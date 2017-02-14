<?php
session_start();
require_once 'functions.php';
$user = loginCheck(false);

$id = '';
if (array_key_exists('id', $_GET) && is_string($_GET['id'])) {
  $id = trim($_GET['id']);
}
if ($id === '') {
  header('Location: index.php');
  exit;
}

$pdo = ConnectDatabase();

$sql = 'SELECT * FROM tr_books WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$book = $stmt->fetch();
if ($book === '') {
  header('Location: index.php');
  exit;
}

$bookmarks = [];
$sql = <<<SQL
SELECT
  a.id,
  a.comment,
  a.star,
  a.created,
  b.id AS user_id,
  b.name AS user_name,
  c.name AS university_name,
  c.major AS university_major
FROM tr_bookmarks a
  JOIN tr_users b ON (a.user = b.id)
  JOIN tr_universities c ON (b.university = c.id)
WHERE a.book = :id
SQL;
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
foreach ($stmt as $i) {
  $bookmarks[] = $i;
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

  <div>
    <img src="<?= h($book['thumbnail']); ?>">
    <?= h($book['name']); ?>
  </div>
  
<?php foreach ($bookmarks as $i): ?>
  <div>
    <p><?= h($i['university_name']); ?> <?= h($i['university_major']); ?></p>
    <p><a href="./?user=<?= h($i['user_id']); ?>"><?= h($i['user_name']); ?></a></p>
    <p><?= h($i['comment']); ?></p>
    <p>
<?php for ($n = 0; $n < 5; $n ++): ?>
      <?= $n < intval($i['star']) ? '★' : '☆'; ?>
<?php endfor; ?>
    </p>
<?php if (!is_null($user) && $user['id'] === $i['user_id']): ?>
    <p>
      <a href="delete.php?id=<?= h($i['id']); ?>">削除</a>
    </p>
<?php endif; ?>
  </div>
<?php endforeach; ?>

</body>
</html>