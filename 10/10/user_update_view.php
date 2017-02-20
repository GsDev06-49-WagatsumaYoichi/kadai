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
<body>
<!-- Main[Start] -->
<form method="post" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
   <a href="user_list_view.php">ユーザー一覧に戻る</a>
    <h1>ユーザー編集</h1>
     <label>名前：<input type="text" name="name" value="<?= $res["name"]?>"></label><br>
     <label>ID：<input type="text" name="lid" value="<?= $res["lid"]?>"></label><br>
     <label>パスワード<input type="password" name="lpw" value="<?= $res["lpw"]?>"></label><br>
   <label>
<?php
$kanri = $res["kanri_flg"];
              
$checked0 = ($kanri) ? "" : "checked";
$checked1 = ($kanri) ? "checked" : "";
              
echo <<< EOT
<input type="hidden" name="id" value="$id">
<input class="radio" type="radio" name="kanri_flg" value=0 $checked0 />一般　
<input class="radio" type="radio" name="kanri_flg" value=1 $checked1 />管理者　
EOT;
?>
</label><br>
    <input type="hidden" name="id" value="<?= $id ?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->
</body>
</html>