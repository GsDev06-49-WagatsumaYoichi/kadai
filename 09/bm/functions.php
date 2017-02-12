<?php
/* 共通で使うもの */

// エラーが起きた時に使う
function ErrorPage($message) {
	header('Content-Type: text/plain; charset=utf-8');
	print $message;
	exit;
}

// データベースに接続する
function ConnectDatabase() {
	$dbname = 'gs_db';
	$dsn = sprintf('mysql:host=localhost;dbname=%s;charset=utf8;', $dbname);
	$user = 'root';
	$pass = '';
	$attr = [
		// 接続にこれを設定しておくと、毎回 $stmt->fetch(PDO::FETCH_ASSOC) しなくてもいい
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	];
	try {
		return new PDO($dsn, $user, $pass, $attr);
	} catch (Exception $e) {
		ErrorPage($e->getMessage());
	}
}

// データを表示する時に使う
function h($str){
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

/**
 * 下にHTMLがない場合は、閉じPHP (?>) はいらない。
 */
