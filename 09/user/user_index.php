<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ登録</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/range.css">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">ユーザー登録</div>
    <div class="navbar-header"><a class="navbar-brand" href="user_list_view.php">ユーザー一覧</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="../bm/bm_index.php">書籍登録</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="../bm/bm_list_view.php">書籍一覧</a></div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>新規ユーザー登録</legend>
       <label>名前：<input type="text" name="name"></label><br>
       <label>ID:<input type="text" name="lid" /></label><br>
       <label>パスワード<input type="password" name="lpw"></label><br>
       <label>権限
       <input type="radio" name="kanri_flg" value="0">一般
       <input type="radio" name="kanri_flg" value="1">管理者
       </label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>