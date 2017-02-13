<?php
/**
 * update.php
 *
 * データを更新した後、bm_list_view.php へ転送する
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
	header('Location: bm_list_view.php?error=method_not_allowed');
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
	!array_key_exists('id', $_POST) ||
	!is_string($_POST['id']) ||
	$_POST['id'] === '' ||
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
	header('Location: bm_list_view.php?error=bad_request');
	exit;
}

$id = $_POST['id'];
$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'];

/**
 * 関数名はわかりやすくすること。
 * con ではよくわからない。
 */
$pdo = ConnectDatabase();

// データの更新
$sql = 'UPDATE gs_bm_table SET name = :name, url = :url, comment = :comment WHERE id = :id';
$query = $pdo->prepare($sql);
$query->bindValue(':name', $name, PDO::PARAM_STR);
$query->bindValue(':url', $url, PDO::PARAM_STR);
$query->bindValue(':comment', $comment, PDO::PARAM_STR);
$query->bindValue(':id', $id, PDO::PARAM_INT);
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
header('Location: bm_list_view.php?success=update');

/**
 * 下にHTMLがない場合は、閉じPHP (?>) はいらない。
 */
