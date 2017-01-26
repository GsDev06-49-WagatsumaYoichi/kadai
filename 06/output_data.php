<?php
	// ファイルを開く
	$buff = file_get_contents('./data/data.csv');

	// 結果データの配列
	$data = [];

	// 1行ずつ処理をする
	foreach (explode("\n", $buff) as $i) {

		// データがない場合、処理しない
		if ($i === '') {
			continue;
		}

		// カンマで分割する
		$line = explode(',', trim($i));

		// 配列に足す
		$data[] = [
			'name' => $line[0], // 分割したデータの1番目
			'email' => $line[1], // 分割したデータの2番目
			'q1' => $line[2], // 分割したデータの3番目
			'q2' => $line[3], // 分割したデータの4番目
		];
	}
?>
<!DOCTYPE html>
<html>
    
    <html lang="ja">
   




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
                
                border:none;
                outline:none;
                 background:white;
                 position:absolute;
                 top: 200px;
                 right: 20px;
        }
            .ans2{
                
                border:none;
                outline:none;
                 background:white;
                 position:absolute;
                 top: 270px;
                 right: 300px;
        }
            .shop{
                width: 200px;
                margin-left: 5px;
/*                margin-left: -450px;*/
                
/*
                position:absolute;
                 top: 100px;
                 right: 500px;
*/
            }
            table{
                border: solid 1px #000;
                margin: 10px auto;
            }
            td{
                padding: 5px;
            }
            .contain{
                display: flex;
                justify-content: center;
            }
            .left{
                width: 50%;
                text-align: center;
            }
            .right{
                width: 50%;
/*                text-align: center;*/
                margin: 5px;
                border: solid 3px #000;
                height: 400px;
                margin-top: 100px;
            }
            .selif{
                font-size: 28px;
                font-weight: bold;
                margin-top: 5px;
                margin-left: 10px;
               
            }

            
            
		</style>
		
	</head>
	<body>
	    
	    <div class="contain">
            <div class="left">
           <div>過去の記録</div>
            <table rules="all">
            <thead>
                <th>なまえ</th>
                <th>迷ったとき</th>
                <th><img src="./img/onigiri.png" alt="" style="width:30px;padding:2px;"></th>
                <th><img src="./img/oyasumi.png" alt="" style="width:30px;padding:2px;"></th>
            </thead>
            <?php foreach ($data as $i): ?>
                        <tr>
                            <td><?php print htmlspecialchars($i['name']); ?></td>
                            <td><?php print htmlspecialchars($i['email']); ?></td>
                            <td><?php print htmlspecialchars($i['q1']); ?></td>
                            <td><?php print htmlspecialchars($i['q2']); ?></td>
                        </tr>
            <?php endforeach; ?>
            </table>
            </div>
            <div class="right">
                
                <?php
//                   print ($i['q1']); 
                if(($i['q1'])=== 'yes' && ($i['q2'])=== 'yes'){
                    print '<div class="selif">セブンに寄って帰りましょう</div>';
                    print '<img src="./img/seven.jpg" alt="" class="shop">';
                    print '<img src="./img/panda.png" alt="" class="ans">'; 
                }elseif(($i['q1'])=== 'yes' && ($i['q2'])=== 'no'){
                    print '<div class="selif">温野菜に行きましょう</div>';
                    print '<img src="./img/onyasai.jpg" alt="" class="shop">';
                    print '<img src="./img/run.png" alt="" class="ans">'; 
                }elseif(($i['q1'])=== 'no' && ($i['q2'])=== 'no'){
                    print '<div class="selif">もうちょっと頑張りましょう</div>';
                    print '<img src="./img/good.png" alt="" class="ans">'; 
                }else{
                    print '<div class="selif">もう帰りましょう</div>';
                    print '<img src="./img/bye.png" alt="" class="ans2">';
                }
                
                ?>

            </div>
		</div>
		
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	
	<script>
        $(function(){
            $('.ans').animate({ "right": "+=200px" },3000, function(){
        });  
            $('.ans2').animate({ "top": "-=200px" },3000, function(){
        });  
            
        });     
    </script>	
		
	</body>
</html>
