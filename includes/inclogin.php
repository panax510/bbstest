<!-- 各ページのログインセッション確認用 -->
<?php
  session_start();
  if (!isset($_SESSION['id'])){
    header('Location: login.php');
    exit();
  }
?>
