<?php
/**
 * bm_update_view.php
 *
 * データを表示する
 * ※画面は表示する
 */

/**
 * この場合 include ではなく require_once を使うこと。
 * なぜなら、このファイルを複数回読み込ませるとエラーになり、(同一の関数が宣言されてしまうため)
 * 読み込みに失敗した場合、先の処理も失敗することが確定しているため。
 *
 * 参考まで: http://php.net/manual/ja/function.include.php
 */
require_once '../functions.php';

/**
 * IDを取得する
 */
if (
	!array_key_exists('id', $_GET) ||
	!is_string($_GET['id']) ||
	$_GET['id'] === ''
) {
	header('Location: bm_list_view.php?error=bad_request');
	exit;
}

$id = $_GET['id'];

/**
 * 関数名はわかりやすくすること。
 * con ではよくわからない。
 */
$pdo = ConnectDatabase();

// データの取得
$sql = 'SELECT * FROM gs_bm_table WHERE id = :id';
$query = $pdo->prepare($sql);
$query->bindValue(':id', $id, PDO::PARAM_INT);
$result = $query->execute();

/**
 * 比較は == ではなくて、=== を使うこと。
 */
if ($result === false) {
	ErrorPage(implode(', ', $query->errorInfo()));
}

$record = $query->fetch();

// IDが見つからない時
if ($record === false) {
	header('Location: bm_list_view.php?error=not_found');
	exit;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<title>POSTデータ登録</title>
	</head>
	<body>
        
		<nav>
			<a href="bm_list_view.php">本の一覧</a>
		</nav>
        <h1>本の編集</h1>
		<form method="post" action="bm_update.php">
			<dl>
				<dt>書籍名</dt>
				<dd><input type="text" name="name" value="<?= h($record['name']); ?>"></dd>
				<dt>書籍URL</dt>
				<dd><input type="text" name="url" value="<?= h($record['url']); ?>"></dd>
				<dt>コメント</dt>
				<dd><textarea name="comment" rows="4" cols="40"><?= h($record['comment']); ?></textarea></dd>
			</dl>
			<button>送信</button>
			<input type="hidden" name="id" value="<?= h($record['id']); ?>">
		</form>

	</body>
</html>
