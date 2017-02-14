<?php
/* 共通で使うもの */

// エラーが起きた時に使う
function ErrorPage($message) {
	header('Content-Type: text/plain; charset=utf-8');
	print $message;
	exit;
}

// データベースに接続する
function ConnectDatabase() {
	$dbname = 'gs_db';
	$dsn = sprintf('mysql:host=localhost;dbname=%s;charset=utf8;', $dbname);
	$user = 'root';
	$pass = '';
	$attr = [
		// 接続にこれを設定しておくと、毎回 $stmt->fetch(PDO::FETCH_ASSOC) しなくてもいい
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	];
	try {
		return new PDO($dsn, $user, $pass, $attr);
	} catch (Exception $e) {
		ErrorPage($e->getMessage());
	}
}

// データを表示する時に使う
function h($str){
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

/**
 * 下にHTMLがない場合は、閉じPHP (?>) はいらない。
 */

//ログインチェックの関数
function loginCheck(){
    if(!isset($_SESSION["chk_ssid"])|| $_SESSION["chk_ssid"]!=session_id())
    {
        echo"ログインされていません。";
        exit();
    }
    else
    {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"]=session_id();
        print $_SESSION['lid'];
        print 'さんログイン中<br>';
        print '<br>';
    }
}

//NaviBar の切り替え
function nav($pdo,$path){
        $lid=$_SESSION['lid'];

        //データ登録SQL作成
        $stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid= :lid");//バインド変数埋め込み
        $stmt->bindValue(":lid",$lid,PDO::PARAM_INT); //STR or INT PDO::はセキュリティ
        $status = $stmt->execute();
        //データ表示
        if($status==false){
          //execute（SQL実行時にエラーがある場合）
          $error = $stmt->errorInfo();
          exit("ErrorQuery:".$error[2]);
        }else{
          $res = $stmt->fetch(); //1レコード取得
        }

    
        $fileName=basename($path);
        $nav = '';
        if ($res['kanri_flg'] ==1) {
            if($fileName=='user_index.php')
            {
                $nav .= '<div class="navbar-header">新規ユーザー登録</div>';
            }
            else {
                $nav .= '<div class="navbar-header"><a class="navbar-brand" href="../user/user_index.php">新規ユーザー登録</a></div>';
            }
            
            if($fileName=='user_list_view.php')
            {
                $nav .= '<div class="navbar-header">ユーザー一覧・編集</div>';
            }
            else {
                $nav .= '<div class="navbar-header"><a class="navbar-brand" href="../user/user_list_view.php">ユーザー一覧・編集</a></div>';
            }
        }
            if($fileName=='bm_index.php')
            {
                $nav .= '<div class="navbar-header">新規本の登録</div>';
            }
            else {
                $nav .= '<div class="navbar-header"><a class="navbar-brand" href="../bm/bm_index.php">新規本の登録</a></div>';
            }
            if($fileName=='bm_list_view.php')
            {
                $nav .= '<div class="navbar-header">本の一覧・編集</div>';
            }
            else {
                $nav .= '<div class="navbar-header"><a class="navbar-brand" href="../bm/bm_list_view.php">本の一覧・編集</a></div>';
            }
            $nav .= '<div class="navbar-header"><a class="navbar-brand" href="../logout.php">ログアウト</a></div>';
            print $nav;
    
    
    
    
    
    
    
    
    }
