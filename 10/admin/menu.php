<?php
  if($_SESSION["kanri_flg"]!="1"){
?>
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="../news/input.php">記事登録</a>　
      <a class="navbar-brand" href="../news/select.php">データ一覧</a>　
      <a class="navbar-brand" href="../logout.php">ログアウト</a>
      </div>
    </div>
  </nav>
</header>
<?php
  }else{
?>
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="../news/input.php">記事登録</a>　
      <a class="navbar-brand" href="../news/select.php">記事一覧</a>　
      <a class="navbar-brand" href="../user/user_index.php">ユーザー登録</a>　
      <a class="navbar-brand" href="../user/user_list_view.php">ユーザー一覧</a>　
      <a class="navbar-brand" href="../logout.php">ログアウト</a>
      </div>
    </div>
  </nav>
</header>
<?php
  }
?>
