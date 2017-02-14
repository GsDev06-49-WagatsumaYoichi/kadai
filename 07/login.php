<?php
session_start();
require_once 'functions.php';

$error = '';
if (array_key_exists('error', $_GET) && is_string($_GET['error'])) {
  $error = trim($_GET['error']);
}

$email = '';
$email_error = '';
$password = '';
$password_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // フォームからデータを取得する
  if (array_key_exists('email', $_POST) || is_string($_POST['email'])) {
    $email = trim($_POST['email']);
  }
  if (array_key_exists('password', $_POST) || is_string($_POST['password'])) {
    $password = trim($_POST['password']);
  }

  // 入力されているか確認する
  if ($email === '') {
    $email_error = 'メールアドレスが未入力です。';
  }
  if ($password === '') {
    $password_error = 'パスワードが未入力です。';
  }

  // 入力されていた場合
  if ($email_error === '' && $password_error === '') {
    $pdo = ConnectDatabase();
    
    // 入力されたメールアドレスに一致するユーザーを取得する
    $sql = 'SELECT * FROM tr_users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch();
    
    // 入力されたメールアドレスのユーザーがいない場合
    if ($user === false) {
      $password_error = 'メールアドレスかパスワードが間違っています。';
      
    // ユーザーは存在するが、パスワードが一致しない場合
    } else if (!password_verify($password, $user['password'])) {
      $password_error = 'メールアドレスかパスワードが間違っています。';
      
    // ログイン成功！
    } else {
      $_SESSION['id'] = $user['id'];
      $_SESSION['sid'] = session_id();
      // TODO: 転送先を変更する
      header('Location: index.php');
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

<?php if ($error === 'unauthorized'): ?>
  <div class="message warn">
    ログインが必要です。
  </div>
<?php endif; ?>

  <form method="post" action="login.php">
    <div>アカウント：<input type="email" name="email" value="<?= h($email); ?>" placeholder="メールアドレス"></div>
<?php if ($email_error !== ''): ?>
    <div class="message notice"><?= h($email_error); ?></div>
<?php endif; ?>

    <div>パスワード：<input type="password" name="password" value=""></div>
<?php if ($password_error !== ''): ?>
    <div class="message notice"><?= h($password_error); ?></div>
<?php endif; ?>

    <button>ログイン</button>
  </form>

  <div>
    <a href="register.php">アカウントを作成する</a>
  </div>

</body>
</html>
