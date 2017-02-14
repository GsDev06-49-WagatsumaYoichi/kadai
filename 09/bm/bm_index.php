<?php
session_start();
require_once '../functions.php';
loginCheck();

$pdo = ConnectDatabase();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<title>新基本の登録</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
    <header>
		<nav class="navbar navbar-default">
                <div class="container-fluid">
                <?= nav($pdo,__FILE__); ?>
                </div>
        </nav>
        </header>
        <h1>新規本の登録</h1>
		<form method="post" action="bm_insert.php">
			<dl>
				<dt>書籍名</dt>
				<dd><input type="text" name="name"></dd>
				<dt>書籍URL</dt>
				<dd><input type="text" name="url"></dd>
				<dt>コメント</dt>
				<dd><textarea name="comment" rows="4" cols="40"></textarea></dd>
			</dl>
			<button>送信</button>
		</form>

	</body>
</html>
