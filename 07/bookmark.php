<?php
session_start();
require_once 'functions.php';

$user = loginCheck();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // フォームからデータを取得する
  if (array_key_exists('id', $_POST) && is_string($_POST['id'])) {
    $google_id = trim($_POST['id']);
  }
  if (array_key_exists('name', $_POST) && is_string($_POST['name'])) {
    $name = trim($_POST['name']);
  }
  if (array_key_exists('thumbnail', $_POST) && is_string($_POST['thumbnail'])) {
    $thumbnail = trim($_POST['thumbnail']);
  }
  if (array_key_exists('comment', $_POST) && is_string($_POST['comment'])) {
    $comment = trim($_POST['comment']);
  }
  if (array_key_exists('star', $_POST) && is_string($_POST['star'])) {
    $star = trim($_POST['star']);
  }

  // 入力されているか確認する
  $check = true;
  if ($google_id === '') {
    $check = false;
  }
  if ($name === '') {
    $check = false;
  }
  if ($thumbnail === '') {
    $check = false;
  }

  // 入力されていた場合
  if ($check) {
    $pdo = ConnectDatabase();

    // 本情報の確認
    $sql = 'SELECT id FROM tr_books WHERE google_id = :google_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':google_id', $google_id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row === false) {
      // 未登録の本
      $sql = 'INSERT INTO tr_books (google_id, name, thumbnail, created) VALUES (:google_id, :name, :thumbnail, NOW())';
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':google_id', $google_id, PDO::PARAM_STR);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':thumbnail', $thumbnail, PDO::PARAM_STR);
      $stmt->execute();
      $book_id = $pdo->lastInsertId();
    } else {
      // 登録済の本
      $book_id = intval($row['id']);
    }

    $sql = 'SELECT 1 FROM tr_bookmarks WHERE book = :book AND user = :user';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':book', $book_id, PDO::PARAM_INT);
    $stmt->bindValue(':user', $user['id'], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row !== false) {
      header('Location: index.php?error=bookmarked');
      exit;
    }
    
    $sql = 'INSERT INTO tr_bookmarks (book, user, comment, star, created, updated) VALUES (:book, :user, :comment, :star, NOW(), NOW())';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':book', $book_id, PDO::PARAM_INT);
    $stmt->bindValue(':user', $user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindValue(':star', $star, PDO::PARAM_STR);
    $stmt->execute();
    
    header('Location: index.php?message=bookmarked');
  } else {
    header('Location: book.php');
  }
  exit;
}

header('Location: index.php');
