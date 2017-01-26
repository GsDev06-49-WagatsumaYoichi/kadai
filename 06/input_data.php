<?php
	// メッセージ
	$message = '';

	try {

		// POSTでこなかったら
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			throw new Exception();
		}

		// 送信されてきたデータ
		$name = trim(filter_input(INPUT_POST, 'name'));
		$email = date('Y/m/d H:i:s'); 
		$q1 = trim(filter_input(INPUT_POST, 'q1'));
		$q2 = trim(filter_input(INPUT_POST, 'q2'));

		// 入力内容のチェック
		if (!is_string($name) || $name === '') {
			throw new Exception('お名前が未入力です');
		}
//		if (!is_string($email) || $email === '') {
//			throw new Exception('メールアドレスが未入力です');
//		}

		// ファイルを開く
		$fp = fopen('./data/data.csv', 'a');
		if (!$fp) {
			throw new Exception('ファイルが開けません');
		}

		// 排他ロックできない場合
		if (!flock($fp, LOCK_EX)) {
			throw new Exception('ファイルが開けません');
		}

		// カンマ区切りで1行を作る
		$data = [
			$name,
			$email,
			$q1,
			$q2,
		];
		$line = sprintf("%s\n", implode(',', $data));

		// データの保存
		fwrite($fp, $line);
		flock($fp, LOCK_UN);
		fclose($fp);

		$message = '保存しました';

	} catch (Exception $e) {
		$message = $e->getMessage();
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>アンケート収集</title>
		<style>
            /*    リセットcss*/
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: sans-serif;
            }
            .ans{
                width: 300px;
            }
            body{
                text-align: center;
                border-top: solid 2px;
                margin-top: 40px;
            }
            .stamp {
                font-size: 32px;
                font-family: serif;
                font-weight: bold;
                border: solid 3px;
                width: 150px;
                margin: 0px auto;
                border-radius: 14px;
                margin-top: 50px;
                
            }
            h1 {
                font-size: 42px;
                
                margin-top: 20px;
            }
            .topline{
                border-top: solid 2px;
                margin-top: 3px;
            }
            .toplineB{
                border-top: solid 4px;
                margin-top: 3px;
            }
            h3, h4{
                padding: 10px;
            }
          
            .message{
                text-align: right;
                border-bottom: solid 4px;
                margin-top: 100px;
                font-weight: bold;
                font-size: 14px;
                margin-right: 10px;
            }
            h4{
                font-size: 26px;
                font-weight: bold;
            }
            form{
                padding-top: 50px;
                display: flex;
                justify-content: center;
            }
            .icon{
                width: 70px;
            }
            
            .form-left{
                width: 30%;
            }
            .form-right{
                width: 30%;
            }
            button {
                width: 100px;
                height: 50px;
                border-radius: 7px;
                border-style: none;
                background-color: #fff;
                border: solid 2px;
                cursor: pointer;
                margin-top: 20px;
                font-size: 24px;
                font-weight: bold;
            }
            .move {
                    border: solid 2px;
                    /* margin-top: 50px; */
                    border-radius: 15px;
                    width: 300px;
                    margin: 0 auto;
                    margin-top: 50px;
            }
            .link{
                text-decoration: none;
                font-size: 24px;
                font-weight: bold;
                color: #000;
            }
            
		</style>
        
	</head>
	<body>
	    <div class="toplineB"></div>
		<div class="stamp">決定版</div>
		<h1>この後どうする？</h1>
		<div class="messageBox">
		    <p class="message">「お、もう９時じゃん。どうする？」って時にもう悩まなくて済む。<br>そんな便利なアプリをつくりました。</p>
		</div>
		<div class="form-wrapper">
		
		<form method="post" action="" class="topline">
            <div class="form-left">
		    <div>
		        <img src="./img/gohan.png" alt="" class="icon">
		    </div>
			<h4>おなかすいてますか？</h4>
			<p>
				<label><input type="radio" name="q1" value="yes">はい</label>
				<label><input type="radio" name="q1" value="no" checked>いいえ</label>
			</p>
			<div>
		        <img src="./img/oyasumi.png" alt="" class="icon">
		    </div>
			<h4>ねむいですか？</h4>
			<p>
				<label><input type="radio" name="q2" value="yes">はい</label>
				<label><input type="radio" name="q2" value="no" checked>いいえ</label>
			</p>
			</div>
			<div class="form-right">
			<h3>お名前</h3>
			<p>
			    
				<input type="text" name="name">
			</p>
			<h3>今の時間</h3>
			<p>
			    <i ><?php $now = date('Y/m/d H:i:s'); print $now;?></i>
<!--				<input type="email" name="email" >-->
			</p>
			<button>記録</button>
		</form>
            <i><?php print htmlspecialchars($message); ?></i>
		    <div  class="move">
		    <a href="./output_data.php" class="link">こたえを見る</a></li>
		    </div>
		
		</div>
		
		
		</div>
		
        
	</body>
</html>
