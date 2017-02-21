<?php
include("../../functions.php");
//1.POSTでParamを取得
$id = $_GET["id"];

//2.DB接続など
$pdo = db_con();

//3.UPDATE gs_an_table SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。
$stmt = $pdo->prepare("SELECT * FROM gs_cms_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  $row = $stmt->fetch();
}

if($row["upfile"]!=""){
  unlink('../../'.$row["upfile"]);}
  
$stmt = $pdo->prepare("UPDATE gs_cms_table SET upfile=:upfile  WHERE id=:id");
$stmt->bindValue(':id',      $id,      PDO::PARAM_INT);
$stmt->bindValue(':upfile',   "");
$status = $stmt->execute();

header("Location: detail.php?id=$id");

?>
