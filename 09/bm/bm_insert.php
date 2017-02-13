<?php
/**
 * bm_insert.php
 *
 * データを登録した後、bm_index.php へ転送する
 * ※画面は表示しない
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
 * POSTでアクセスしなかった場合はエラーにしてよい。
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: bm_index.php?error=method_not_allowed');
	exit;
}

/**
 * 変数が宣言されているかの確認以外では isset は基本的に使わない。
 * 連想配列のキーに設定されているかの確認では array_key_exists を使うこと。
 *
 * 文字列であることを確認してから、文字列の比較を行うこと。
 * is_string(変数)
 * 比較は == ではなくて、=== を使うこと。
 */
if (
	!array_key_exists('name', $_POST) ||
	!is_string($_POST['name']) ||
	$_POST['name'] === '' ||
	!array_key_exists('url', $_POST) ||
	!is_string($_POST['url']) ||
	$_POST['url'] === '' ||
	!array_key_exists('comment', $_POST) ||
	!is_string($_POST['comment']) ||
	$_POST['comment'] === ''
) {
	header('Location: bm_index.php?error=bad_request');
	exit;
}

$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'];

/**
 * 関数名はわかりやすくすること。
 * con ではよくわからない。
 */
$pdo = ConnectDatabase();

// データの登録
$sql = 'INSERT INTO gs_bm_table (name, url, comment, indate) VALUES (:a1, :a2, :a3, NOW())';
$query = $pdo->prepare($sql);
$query->bindValue(':a1', $name, PDO::PARAM_STR);
$query->bindValue(':a2', $url, PDO::PARAM_STR);
$query->bindValue(':a3', $comment, PDO::PARAM_STR);
$result = $query->execute();

/**
 * 比較は == ではなくて、=== を使うこと。
 */
if ($result === false) {
	ErrorPage(implode(', ', $query->errorInfo()));
}

/**
 * 登録が成功した
 */
header('Location: bm_index.php?success=insert');

/**
 * 下にHTMLがない場合は、閉じPHP (?>) はいらない。
 */
