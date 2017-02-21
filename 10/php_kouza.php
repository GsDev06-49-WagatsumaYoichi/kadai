<?php
//bindevalueについて

//1. POSTデータ取得
$name   = $_POST["name"];
$lid  = $_POST["lid"];
$lpw = $_POST["lpw"];
$kanri_flg = $_POST["kanri_flg"];
$life_flg = $_POST["life_flg"];
//2. DB接続します(エラー処理追加)
//new PDO とはPHPの用意されているクラス new PDO,$pdo->prepare,bindvalue,executeは1セット
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
//catch以降は接続できなかった場合のエラー表示
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}
//３．データ登録SQL作成
//INSERTからがSQL文
//prepare 準備する
$stmt = $pdo->prepare("INSERT INTO gs_user_table(id, name, lid, lpw, kanri_flg,life_flg)VALUES(NULL, :a1, :a2, :a3, :a4,:a5)");
//PDOはPHPのクラス bindevalueはPDOの中の関数（メソッド）
$stmt->bindValue(':a1', $name);
$stmt->bindValue(':a2', $lid);
$stmt->bindValue(':a3', password_hash($lpw, PASSWORD_DEFAULT));
$stmt->bindValue(':a4', $kanri_flg);
$stmt->bindValue(':a5', $life_flg);
$status = $stmt->execute();



//これを書き換えると↓
$stmt = $pdo->prepare('INSERT INTO gs_user_table(id, name, lid, lpw, kanri_flg,life_flg)VALUES(NULL, ?, ?, ?, ?, ?)');
//$valueという配列を作る。それをexecuteの中に入れる
$values = [
  $name,
  $lid,
  password_hash($lpw, PASSWORD_DEFAULT),
  $kanri_flg,
  $life_flg,
];
$stmt->execute($values);













?>