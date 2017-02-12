<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf8">
		<title></title>
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
                <div class="navbar-header"><a class="navbar-brand" href="../user/user_index.php">ユーザー登録</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="../user/user_list_view.php">ユーザー一覧</a></div>
                <div class="navbar-header">書籍登録</div>
                <div class="navbar-header"><a class="navbar-brand" href="bm_list_view.php">書籍一覧</a></div>
        </nav>
        </header>

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
