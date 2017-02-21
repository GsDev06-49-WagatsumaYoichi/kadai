
<?php
session_start();
require_once '../../functions.php';
//loginCheck();
ssidCheck();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規ユーザー登録</title>
  <script src="../../ckeditor/ckeditor.js"></script>
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<?php include("../menu.php"); ?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div> <?php echo $_SESSION["name"] ?> さんログイン中</div>
</div>
<h3>新規ユーザー登録</h3>
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
       <label>名前：<input type="text" name="name"></label><br>
       <label>ID:<input type="text" name="lid" /></label><br>
       <label>パスワード<input type="password" name="lpw"></label><br>
       <label>権限
         <input type="radio" name="kanri_flg" value="1" checked>一般
         <input type="radio" name="kanri_flg" value="0">管理者
       </label><br>
       <label>利用状況
         <input type="radio" name="life_flg" value="1" checked>利用中
         <input type="radio" name="life_flg" value="0">退会済み
       </label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<a href="../../index.php">index.phpへ</a>
<!-- Main[End] -->


</body>
</html>