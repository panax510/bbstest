<?php
  // ログインセッション確認用
  session_start();
  if (!isset($_SESSION['id'])){
    header('Location: login.php');
    exit();
  }
?>
