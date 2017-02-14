<?php
session_start();
require_once 'functions.php';
$user = loginCheck(false);

$pdo = ConnectDatabase();

$and = [];
if (array_key_exists('major', $_GET) && is_string($_GET['major'])) {
  $and['d.major'] = ['placeholder' => ':major', 'value' => trim($_GET['major'])];
}
if (array_key_exists('user', $_GET) && is_string($_GET['user'])) {
  $and['c.id'] = ['placeholder' => ':user', 'value' => trim($_GET['user'])];
  $sql='SELECT * FROM tr_users WHERE id=:id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':id', $_GET['user'], PDO::PARAM_STR);
  $stmt->execute();
  $selectUser = $stmt->fetch();
  
}
if (count($and) > 0) {
  $data = [];
  foreach ($and as $column => $i) {
    $data[] = "{$column} = {$i['placeholder']}";
  }
  $where = implode(' AND ', $data);
} else {
  $where = '1 = 1';
}

$sql = <<<SQL
SELECT
  a.id,
  a.name,
  a.thumbnail,
  COUNT(a.id) AS n
FROM tr_books a
  JOIN tr_bookmarks b ON (a.id = b.book)
  JOIN tr_users c ON (c.id = b.user)
  JOIN tr_universities d ON (c.university = d.id)
WHERE
  {$where}
GROUP BY
  a.id
SQL;

$stmt = $pdo->prepare($sql);
foreach ($and as $i) {
  $stmt->bindValue($i['placeholder'], $i['value'], PDO::PARAM_STR);
}

$stmt->execute();

$books = [];
foreach ($stmt as $i) {
  $books[] = $i;
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="css/awesome.css">
</head>
<body>

<?php if (!is_null($user)): ?>
  <header>
    <?= h($user['name']); ?>さんでログイン中
    <a href="logout.php">ログアウト</a>
  </header>
<?php endif; ?>

   <div class="top">
        <div>
            <a href="./">
                <img src="img/logo.png" alt="" class="logo">
            </a>
            <a href="http://tokyo-rocket.net/" class="copyright">© TokyoRocket Inc. All Rights Reserved.</a>
                
        </div>
        <div class="tab-box">
          <div class="tab current"><a href="./">全て</a></div>
            <div class="tab"><a href="./?major=経済系">経済系</a></div>
            <div class="tab"><a href="./?major=経営系">経営系</a></div>
            <div class="tab"><a href="./?major=理工系">理工系</a></div>
            <div class="tab"><a href="./?major=情報系">情報系</a></div>
            <div class="tab"><a href="./?major=法学系">法学系</a></div>
            <div class="tab"><a href="./?major=文学系">文学系</a></div>
<?php if (!is_null($user)): ?>
            <div class="tab"><a href="./?user=<?= h($user['id']); ?>">マイブック</a></div>
<?php endif; ?>
        </div>
    </div>
    <div class="guide">
    <p>AwesomBooksは、大学生がAwesomeな本をシェアできるサービスです。<br>専攻ごとに本を検索できます。</p>
    <a href="book.php" class="post-b">投稿する</a>
    </div>

   
    <?php if (isset($selectUser)): ?>
        <div><?php print h($selectUser['name']).'さんのAwesomeBooks'?></div>
    <?php endif; ?>
   
   
    <div class="post-box">
<?php foreach ($books as $book): ?>
      <div class="book">
        <div>
           <a href="detail.php?id=<?= h($book['id']); ?>">
             <img class="book-img" src="<?= h($book['thumbnail']); ?>">
          </a>
        </div>
        <div class="book-txt">
          <p><?= h($book['name']); ?></p>
          <p>投稿件数：<?= h($book['n']); ?></p>
        </div>
      </div>
<?php endforeach; ?>
    </div>

</body>
</html>