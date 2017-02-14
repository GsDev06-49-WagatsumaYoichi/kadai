<?php
session_start();
require_once 'functions.php';
$user = loginCheck();

$id = '';
if (array_key_exists('id', $_GET) && is_string($_GET['id'])) {
  $id = trim($_GET['id']);
}
if ($id === '') {
  header('Location: index.php');
  exit;
}

$pdo = ConnectDatabase();

$sql = 'DELETE FROM tr_bookmarks WHERE id = :id AND user = :user';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':user', $user['id'], PDO::PARAM_INT);
$stmt->execute();

header('Location: index.php?message=deleted');
