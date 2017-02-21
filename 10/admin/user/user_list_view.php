<?php
session_start();
require_once '../../functions.php';
ssidCheck();

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
      
    //三項演算子の書き方 下のif文と同じ
      $view .=$result["kanri_flg"] >= 1 ? "管理者<br>" : "一般<br>";
    
      $view .=$result["life_flg"] >= 1 ? "利用中<br>" : "退会済み<br>";
    
//      if($result["kanri_flg"] >= 1)
//      {
//          $view.="管理者<br>";
//      }
//      else
//      {
//          $view.="一般<br>";
//      }
//    
//      if($result["life_flg"] >= 1)
//      {
//          $view.="利用中";
//      }
//      else
//      {
//          $view.="退会済み";
//      }
      

     
      
      
      
      
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
        <link rel="../../stylesheet" href="css/range.css">
        <link href="../../css/bootstrap.min.css" rel="stylesheet">
        <style>div{padding: 10px;font-size:16px;}</style>
        </style>
    </head>

    <body id="main">
        <!-- Head[Start] -->
        <?php
        include("../menu.php");
        ?>
        <div>
          <div> <?php echo $_SESSION["name"] ?> さんログイン中</div>
        </div>
        <!-- Head[End] -->
        <h3>ユーザー一覧・編集</h3>
        <!-- Main[Start] -->
        <div>
            <div class="container jumbotron">
                <?=$view?>
            </div>
        </div>
        </div>
        <!-- Main[End] -->
<a href="../../index.php">index.phpへ</a>
    </body>

    </html>