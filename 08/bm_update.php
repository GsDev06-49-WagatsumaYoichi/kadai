<?php
//1.POSTでParamを取得
$id     = $_POST["id"];
$name   = $_POST["name"];
$email  = $_POST["email"];
$naiyou = $_POST["naiyou"];
//2.DB接続など
//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}
//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE gs_an_table SET name=:name,email=:email,naiyou=:naiyou WHERE id=:id");
$stmt->bindValue(':name', $name);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':naiyou', $naiyou);
$stmt->bindValue(':id', $id);
$status = $stmt->execute();
//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: bm_list_view.php");
  exit;
}
//3.UPDATE gs_an_table SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。
?>
