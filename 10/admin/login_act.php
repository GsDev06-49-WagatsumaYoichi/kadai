<?php
session_start();
include("../functions.php");

$id = $_POST["lid"];
$pw = $_POST["lpw"];

//パラメータチェック
if(
  !isset($_POST["lid"]) || $_POST["lid"]=="" ||
  !isset($_POST["lpw"]) || $_POST["lpw"]==""
  )
{
  header("Location: login.php");
  exit();
}

//1. 接続します
$pdo = db_con();

//３．データ登録SQL作成
$sql="SELECT * FROM gs_user_table WHERE lid=:lid AND life_flg=1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $_POST["lid"]);
$res = $stmt->execute();

//SQL実行時にエラーがある場合
if($res==false){
    queryError($stmt);
}

//５．抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法

//6. 該当レコードがあればSESSIONに値を代入
if( password_verify($pw, $val["lpw"])){ 
  //password_hash("パスワード文字", PASSWORD_DEFAULT);でパスワード登録しておくこと
  $_SESSION["schk"]   = session_id();
  $_SESSION["kanri_flg"]  = $val['kanri_flg'];
  $_SESSION["name"]       = $val['name'];
  //Login処理OKの場合select.phpへ遷移
  header("Location: news/select.php");
}else{
  //Login処理NGの場合login.phpへ遷移
  header("Location: login.php");
}
//処理終了
exit();
?>

<!--

if( $val["id"] != "" ){
  $_SESSION["schk"] = session_id();
  $_SESSION["name"]=$val["name"];
  $_SESSION["kanri_flg"]=$val["kanri_flg"];
  header("Location: select.php");
}else{
  //logout処理を経由して全画面へ
  header("Location: login.php");
}
exit();
-->
