<?php

function loginCheck($redirect = true) {
  $user = null;
  $success = true;

  // セッションハイジャック対策
  if (
    $success &&
    array_key_exists('sid', $_SESSION) &&
    $_SESSION['sid'] === session_id()
  ) {
    session_regenerate_id(true);
    $_SESSION['sid'] = session_id();
  } else {
    $success = false;
  }

  if (
    $success &&
    array_key_exists('id', $_SESSION)
  ) {
    $pdo = ConnectDatabase();
    $sql = 'SELECT * FROM tr_users WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();
    if ($user === false) {
      $success = false;
    }
  }

  if ($redirect && !$success) {
    session_destroy();
    setcookie(session_name(), '', time() - 86400);
    header('Location: login.php?error=unauthorized');
    exit;
  } else {
    return $user;
  }
}

function h($var) {
  print htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
}

function ConnectDatabase() {
  static $connect;
  if (is_null($connect)) {
    $dbname = 'gs_db';
    $dsn = sprintf('mysql:host=localhost;dbname=%s;charset=utf8;', $dbname);
    $user = 'root';
    $pass = '';
    $attr = [
      // 接続にこれを設定しておくと、毎回 $stmt->fetch(PDO::FETCH_ASSOC) しなくてもいい
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    try {
      $connect = new PDO($dsn, $user, $pass, $attr);
    } catch (Exception $e) {
      // TODO: エラー表示
    }
  }
  return $connect;
}

