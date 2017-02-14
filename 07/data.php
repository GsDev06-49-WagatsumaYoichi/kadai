<?php
/**
 * 設定値
 */
$SETTINGS = array(
	'DATABASE' => array(
		'USER' => 'root',
		'PASSWORD' => '',
		'DSN' => 'mysql:host=localhost;dbname=gs_db;charset=utf8',
	),
);


/**
 * ユニークなIDを作るための関数
 */
function uuid() {
	if (function_exists('uuid_create')) {
		$var = uuid_create(UUID_TYPE_DEFAULT);
		$var = strtolower($var);
		$var = preg_replace('/[^0-9a-z]/', '', $var);
	} else {
		// ※重複する可能性がある
		$seed = [
			uniqid('', true),
			'edd1369847724a5fbb29db3e80f164fa',
			microtime(true),
		];
		$var = md5(implode('', $seed));
	}
	return $var;
}

/**
 * POSTされてきたデータを取得する
 */
function postdata() {
	$var = file_get_contents('php://input');
	if (!is_string($var) || $var === '') {
		return array();
	}
	$var = json_decode($var, true);
	return is_array($var) ? $var : array();
}

/**
 * ハッシュからデータを取得する
 */
function gethash($hash, $key, $type, $null = false) {
	if (!is_array($hash)) {
		$hash = array();
	}
	if (!is_string($key)) {
		$key = '';
	}
	if (array_key_exists($key, $hash)) {
		$var = $hash[$key];
	} else {
		$var = null;
	}
	switch ($type) {
		case 'string':
			if (is_string($var)) {
				return $var;
			} else {
				return $null ? null : '';
			}
        case 'int':
            if (is_numeric($var)) {
                return intval($var);
            } else {
                return $null ? null : 0;
            }
		case 'array':
			if (is_array($var)) {
				return $var;
			} else {
				return $null ? null : array();
			}
		default:
			return null;
	}
}

/**
 * SQLを1行にする (ログのため)
 */
function trimsql($sql) {
	return implode(' ', array_map('trim', explode("\n", $sql)));
}


$result = array();
try {

	// データベースに接続
	$pdo = new PDO(
		$SETTINGS['DATABASE']['DSN'],
		$SETTINGS['DATABASE']['USER'],
		$SETTINGS['DATABASE']['PASSWORD'],
		array(
			PDO::ATTR_TIMEOUT => 2,
			PDO::ATTR_AUTOCOMMIT => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		)
	);
	$pdo->beginTransaction();

	// GET, POST, PUT or DELETE
	$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
	if (!is_string($method)) {
		$method = 'THRU';
	}

	$pathinfo = filter_input(INPUT_SERVER, 'PATH_INFO');
	if (!is_string($pathinfo)) {
		$pathinfo = '/';
	}

	$request = sprintf('%s %s', strtoupper($method), strtolower($pathinfo));
	switch ($request) {

		// 書籍の登録
		case 'POST /books':
			$post = postdata();
			$errors = array();

			/*
				$post = array(
					'university' => array(
						'name' => '大学名',
						'major' => '専攻',
					),
					'book' => array(
						'name' => '書籍名',
						'thumbnail' => '画像',
					),
					'contributor' => '投稿者',
					'comment' => 'コメント',
				);
			*/

			// 上の構造になっているか確認する
			$var = gethash($post, 'university', 'array');
			$university = array(
				'name' => gethash($var, 'name', 'string'),
				'major' => gethash($var, 'major', 'string'),
			);
			if (is_null($university['name'])) {
				$errors[] = 'Missing university.name';
			}
			if (is_null($university['major'])) {
				$errors[] = 'Missing university.major';
			}

			$var = gethash($post, 'book', 'array');
			$book = array(
                'google_id' => gethash($var, 'google', 'string'),
				'name' => gethash($var, 'name', 'string'),
				'thumbnail' => gethash($var, 'thumbnail', 'string'),
			);
			if (is_null($book['name']) || $book['name'] === '') {
				$errors[] = 'Missing book.name';
			}
			if (is_null($book['thumbnail']) || $book['thumbnail'] === '') {
				$errors[] = 'Missing book.thumbnail';
			}

			$account = array(
				'contributor' => gethash($post, 'contributor', 'string'),
				'comment' => gethash($post, 'comment', 'string'),
                'star' => gethash($post, 'star', 'int'),
			);
			if (is_null($account['contributor']) || $account['contributor'] === '') {
				$errors[] = 'Missing contributor';
			}
			if (is_null($account['comment']) || $account['comment'] === '') {
				$errors[] = 'Missing comment';
			}

			// 構造に間違いがあった場合、エラーを返す
			if (count($errors) > 0) {
				$result['errors'] = $errors;
				throw new Exception('Bad Request', 400);
			}

			// 大学情報の確認
			$sql = 'SELECT id FROM gs_universities WHERE name = ? AND major = ?';
			$var = array($university['name'], $university['major']);
			$sth = $pdo->prepare(trimsql($sql));
			$sth->execute($var);
			$row = $sth->fetch();
			if ($row === false) {
				// 未登録の大学&専攻
				$university_id = uuid();
				$sql = 'INSERT INTO gs_universities (id, name, major, created) VALUES (?, ?, ?, NOW())';
				$var = array($university_id, $university['name'], $university['major']);
				$sth = $pdo->prepare(trimsql($sql));
				$sth->execute($var);
			} else {
				// 登録済の大学&専攻
				$university_id = $row['id'];
			}
            
			// 書籍データの登録
			$book_id = uuid();
            // <<< はヒアドキュメント
			$sql = <<<SQL
INSERT INTO gs_books
	(id, google_id, university, contributor, comment, book, thumbnail, star, ipaddress, created, updated)
VALUES
	(?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
SQL;
			$var = array(
				$book_id,
                $book['google_id'],
				$university_id,
				$account['contributor'],
				$account['comment'],
				$book['name'],
				$book['thumbnail'],
                $account['star'],
				filter_input(INPUT_SERVER, 'REMOTE_ADDR'),
			);
			$sth = $pdo->prepare(trimsql($sql));
			$sth->execute($var);

			$result += array(
				'success' => true,
				'id' => $book_id,
			);
			break;

		// 書籍一覧の取得
		case 'GET /books':
			$books = array();

			$sql = <<<SQL
SELECT
	a.id,
    a.google_id,
	a.contributor,
	a.comment,
	a.book,
	a.thumbnail,
	a.star,
	a.created,
	b.name AS u_name,
	b.major AS u_major
FROM gs_books a
	JOIN gs_universities b ON (a.university = b.id)
SQL;
			$sth = $pdo->prepare(trimsql($sql));
			$sth->execute();

			foreach ($sth as $row) {
				$books[] = array(
					'id' => $row['id'],
					'university' => array(
						'name' => $row['u_name'],
						'major' => $row['u_major'],
					),
					'book' => array(
                        'google' => $row['google_id'],
						'name' => $row['book'],
						'thumbnail' => $row['thumbnail'],
					),
					'contributor' => $row['contributor'],
					'comment' => $row['comment'],
					'star' => intval($row['star']),
					'created' => $row['created'],
				);
			}

			$result += array(
				'success' => true,
				'books' => $books,
			);
			break;

		// 星情報の更新
		case 'PUT /books/star':
			$post = postdata();
			$errors = array();

			$id = gethash($post, 'id', 'string');
			if (is_null($id) || $id === '') {
				$errors[] = 'Missing id';
			}
			if (count($errors) > 0) {
				$result['errors'] = $errors;
				throw new Exception('Bad Request', 400);
			}

			$sql = 'SELECT id, star FROM gs_books WHERE id = ? FOR UPDATE';
			$var = array($id);
			$sth = $pdo->prepare(trimsql($sql));
			$sth->execute($var);
			$row = $sth->fetch();
			if ($row === false) {
				throw new Exception('Not Found', 400);
			}
			$star = intval($row['star']) + 1;

			$sql = 'UPDATE gs_books SET star = ?, updated = NOW() WHERE id = ?';
			$var = array($star, $id);
			$sth = $pdo->prepare(trimsql($sql));
			$sth->execute($var);

			$result += array(
				'success' => true,
				'star' => $star,
			);
			break;

		// 存在しない処理
		default:
			throw new Exception('Not Found', 404);
			break;
	}

	$pdo->commit();

// エラーの処理
} catch (Exception $e) {
	$result += array(
		'success' => false,
		'code' => $e->getCode(),
		'message' => $e->getMessage(),
	);
}

$output = json_encode($result, JSON_UNESCAPED_UNICODE|JSON_HEX_APOS|JSON_HEX_QUOT);
$length = strlen($output);

ob_start('ob_gzhandler');
header('Content-Type: application/json');
header("Content-Length: {$length}");
print $output;
