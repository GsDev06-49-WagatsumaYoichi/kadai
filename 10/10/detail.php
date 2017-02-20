<?php
session_start();
include("functions.php");
ssidCheck();

//1.GETでidを取得
$id = $_GET["id"];

//2.DB接続など
$pdo = db_con();

//3.SELECT * FROM gs_an_table WHERE id=***; を取得（bindValueを使用！）
$stmt = $pdo->prepare("SELECT * FROM gs_cms_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  $row = $stmt->fetch();
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ登録</title>
  <script src="ckeditor/ckeditor.js">
  </script>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<?php include("menu.php"); ?>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="update.php" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend>記事編集</legend>
     <label>Newsタイトル：<input type="text" name="title" value="<?=$row["title"]?>"></label><br>
     <textarea name="article" id="editor1" rows="10" cols="80">
          <?=$row["article"]?>
      </textarea>
      <script>
     CKEDITOR.replace("editor1");
     </script>
     <input type="hidden" name="id" value="<?=$id?>">
     <input type="file" name="filename">
     <img src="<?=$row["upfile"]?>" alt="">
     <p>現在の画像</p>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>






