<?php
$id = $_GET["id"];
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}
//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id= :id");//バインド変数埋め込み
$stmt->bindValue(":id",$id,PDO::PARAM_INT); //STR or INT PDO::はセキュリティ
$status = $stmt->execute();
//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  $res = $stmt->fetch(); //1レコード取得
 
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>編集画面</title>
        <link rel="stylesheet" href="../css/range.css">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <style>
            div {
                padding: 10px;
                font-size: 16px;
            }
        </style>
    </head>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>編集・更新画面</legend>
     <label>名前：<input type="text" name="name" value="<?= $res["name"]?>"></label><br>
     <label>ID：<input type="text" name="lid" value="<?= $res["lid"]?>"></label><br>
     <label>パスワード<input type="password" name="lpw" value="<?= $res["lpw"]?>"></label><br>
       <label>権限
       <input type="radio" name="kanri_flg" value="<?= $res["kanri_flg"]?>">一般
       <input type="radio" name="kanri_flg" value="<?= $res["kanri_flg"]?>">管理者
       </label><br>

       <input type="hidden" name="id" value="<?= $id ?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>