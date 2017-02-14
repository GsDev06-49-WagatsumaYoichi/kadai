<?php
session_start();
session_destroy();
setcookie(session_name(), '', time() - 86400);
header('Location: index.php');
