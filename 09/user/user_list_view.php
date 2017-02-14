<?php
session_start();
require_once '../functions.php';
loginCheck();

//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){

      $view .="<p>";
      $view .='<a href="user_update_view.php? id='.$result["id"].'">';
      $view .= $result["name"]."[".$result["lid"]."]";
      $view .="</a>";
      
      $view .=" ";
      $view .='<a href="user_delete.php? id='.$result["id"].'">';
      $view .="[削除]";
      $view .="</a>";
      $view .="</p>";
      
      if($result["kanri_flg"] >= 1)
      {
          $view.="管理者";
      }
      else
      {
          $view.="一般";
      }
      

     
      
      
      
      
  }
}
?>


    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ユーザー一覧・編集</title>
        <link rel="stylesheet" href="../css/range.css">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <style>
            div {
                padding: 10px;
                font-size: 16px;
            }
        </style>
    </head>

    <body id="main">
        <!-- Head[Start] -->
        <header>
              <nav class="navbar navbar-default">
                <div class="container-fluid">
                <?= nav($pdo,__FILE__); ?>
                </div>
              </nav>
        </header>
        <!-- Head[End] -->
        <h1>ユーザー一覧・編集</h1>
        <!-- Main[Start] -->
        <div>
            <div class="container jumbotron">
                <?=$view?>
            </div>
        </div>
        </div>
        <!-- Main[End] -->

    </body>

    </html>