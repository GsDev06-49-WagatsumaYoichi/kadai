<?php
session_start();
require_once 'functions.php';

$error = '';
if (array_key_exists('error', $_GET) && is_string($_GET['error'])) {
  $error = trim($_GET['error']);
}

$name = '';
$name_error = '';
$email = '';
$email_error = '';
$password = '';
$password_error = '';
$password_confirm = '';
$password_confirm_error = '';
$university = '';
$university_error = '';
$major = '';
$major_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // フォームからデータを取得する
  if (array_key_exists('name', $_POST) && is_string($_POST['name'])) {
    $name = trim($_POST['name']);
  }
  if (array_key_exists('email', $_POST) && is_string($_POST['email'])) {
    $email = trim($_POST['email']);
  }
  if (array_key_exists('password', $_POST) && is_string($_POST['password'])) {
    $password = trim($_POST['password']);
  }
  if (array_key_exists('password_confirm', $_POST) && is_string($_POST['password_confirm'])) {
    $password_confirm = trim($_POST['password_confirm']);
  }
  if (array_key_exists('university', $_POST) && is_string($_POST['university'])) {
    $university = trim($_POST['university']);
  }
  if (array_key_exists('major', $_POST) && is_string($_POST['major'])) {
    $major = trim($_POST['major']);
  }

  // 入力されているか確認する
  $check = true;
  if ($email === '') {
    $email_error = 'メールアドレスが未入力です。';
    $check = false;
  }
  if ($password === '') {
    $password_error = 'パスワードが未入力です。';
    $check = false;
  } else if ($password_confirm === '') {
    $password_confirm_error = 'パスワードが未入力です。';
    $check = false;
  } else if ($password !== $password_confirm) {
    $password_confirm_error = 'パスワードが一致しません。';
    $check = false;
  }
  if ($university === '') {
    $university_error = '大学が未入力です。';
    $check = false;
  }
  if ($major === '') {
    $major_error = '専攻が未入力です。';
    $check = false;
  }

  // 入力されていた場合
  if ($check) {
    $pdo = ConnectDatabase();

    // 入力されたメールアドレスに一致するユーザーを取得する
    $sql = 'SELECT 1 FROM tr_users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch();

    // 入力されたメールアドレスのユーザーがいない場合
    if ($user !== false) {
      $email_error = 'そのメールアドレスは既に登録されています。';

    // 登録して大丈夫
    } else {

      // 大学情報の確認
      $sql = 'SELECT id FROM tr_universities WHERE name = :name AND major = :major';
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':name', $university, PDO::PARAM_STR);
      $stmt->bindValue(':major', $major, PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch();
      if ($row === false) {
        // 未登録の大学&専攻
        $sql = 'INSERT INTO tr_universities (name, major, created) VALUES (:name, :major, NOW())';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $university, PDO::PARAM_STR);
        $stmt->bindValue(':major', $major, PDO::PARAM_STR);
        $stmt->execute();
        $university_id = $pdo->lastInsertId();
      } else {
        // 登録済の大学&専攻
        $university_id = intval($row['id']);
      }

      $sql = 'INSERT INTO tr_users (name, email, password, university, created, updated) VALUES (:name, :email, :password, :university, NOW(), NOW())';
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
      $stmt->bindValue(':university', $university_id, PDO::PARAM_STR);
      $stmt->execute();

      $_SESSION['id'] = $pdo->lastInsertId();
      $_SESSION['sid'] = session_id();

      header('Location: index.php');
      exit;
    }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>

  <form method="post" action="register.php">
    <div>名前：<input type="name" name="name" value="<?= h($name); ?>"></div>
<?php if ($name_error !== ''): ?>
    <div class="message notice"><?= h($name_error); ?></div>
<?php endif; ?>

    <div>アカウント：<input type="email" name="email" value="<?= h($email); ?>" placeholder="メールアドレス"></div>
<?php if ($email_error !== ''): ?>
    <div class="message notice"><?= h($email_error); ?></div>
<?php endif; ?>

    <div>パスワード：<input type="password" name="password" value=""></div>
<?php if ($password_error !== ''): ?>
    <div class="message notice"><?= h($password_error); ?></div>
<?php endif; ?>

    <div>パスワード(確認)：<input type="password" name="password_confirm" value=""></div>
<?php if ($password_confirm_error !== ''): ?>
    <div class="message notice"><?= h($password_confirm_error); ?></div>
<?php endif; ?>

    <div>大学：<input type="text" name="university" value="<?= h($university); ?>"></div>
<?php if ($university_error !== ''): ?>
    <div class="message notice"><?= h($university_error); ?></div>
<?php endif; ?>

    <div>
      専攻：
      <select name="major">
        <option value="">--</option>
        <option value="経済系"<?= $major === '経済系' ? ' selected' : ''; ?>>経済系</option>
        <option value="経営系"<?= $major === '経済系' ? ' selected' : ''; ?>>経営系</option>
        <option value="理工系"<?= $major === '理工系' ? ' selected' : ''; ?>>理工系</option>
        <option value="情報系"<?= $major === '情報系' ? ' selected' : ''; ?>>情報系</option>
        <option value="法学系"<?= $major === '法学系' ? ' selected' : ''; ?>>法学系</option>
        <option value="文学系"<?= $major === '文学系' ? ' selected' : ''; ?>>文学系</option>
      </select>
    </div>
<?php if ($major_error !== ''): ?>
    <div class="message notice"><?= h($major_error); ?></div>
<?php endif; ?>

    <button>作成</button>
  </form>

</body>
</html>
