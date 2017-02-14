<?php
session_start();
require_once '../functions.php';
loginCheck();

/**
 * bm_list_view.php
 *
 * データを一覧表示する
 * ※画面は表示する
 */

/**
 * この場合 include ではなく require_once を使うこと。
 * なぜなら、このファイルを複数回読み込ませるとエラーになり、(同一の関数が宣言されてしまうため)
 * 読み込みに失敗した場合、先の処理も失敗することが確定しているため。
 *
 * 参考まで: http://php.net/manual/ja/function.include.php
 */


/**
 * 関数名はわかりやすくすること。
 * con ではよくわからない。
 */
$pdo = ConnectDatabase();

// データの取得
$sql = 'SELECT * FROM gs_bm_table';
$query = $pdo->prepare($sql);
$result = $query->execute();


/**
 * 比較は == ではなくて、=== を使うこと。
 */
if ($result === false) {
	ErrorPage(implode(', ', $query->errorInfo()));
}

/**
 * まずは配列に溜め込む。
 * ここでHTMLを作るとわかりにくくなるため。
 */
$data = [];
foreach ($query as $record) {
	$data[] = $record;
}



?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>本の一覧編集</title>
        <link rel="stylesheet" href="../css/range.css">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <style>
            div {
                padding: 10px;
                font-size: 16px;
            }
        </style>
    </head>
	<body>
    <header>
		<nav class="navbar navbar-default">
                <div class="container-fluid">
                    <?= nav($pdo,__FILE__); ?>
                </div>
        </nav>
    </header>
    <h1>本の一覧・編集</h1>
		<table>
			<thead>
				<tr>
					<th>登録日</th>
					<th>書籍名</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($data as $i): ?>
				<tr>
					<td><?= h($i['indate']); ?></td>
					<td><?= h($i['name']); ?></td>
					<td>
						<a href="bm_update_view.php?id=<?= h($i['id']); ?>">[詳細]</a>
						/
						<a href="bm_delete.php?id=<?= h($i['id']); ?>">[削除]</a>
					</td>
				</tr>
<?php endforeach; ?>
			</tbody>
		</table>

	</body>
</html>
