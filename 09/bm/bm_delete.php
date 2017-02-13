<?php
/**
 * bm_delete.php
 *
 * データを削除した後、bm_list_view.php へ転送する
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

// データの削除
$sql = 'DELETE FROM gs_bm_table WHERE id = :id';
$query = $pdo->prepare($sql);
$query->bindValue(':id', $id, PDO::PARAM_INT);
$result = $query->execute();

/**
 * 比較は == ではなくて、=== を使うこと。
 */
if ($result === false) {
	ErrorPage(implode(', ', $query->errorInfo()));
}

/**
 * 削除が成功した
 */
header('Location: bm_list_view.php?success=delete');

/**
 * 下にHTMLがない場合は、閉じPHP (?>) はいらない。
 */
