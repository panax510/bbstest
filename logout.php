<?php
  session_start();
// 　ログアウト処理

  if(isset($_SESSION['id'])){
    unset($_SESSION['id']);
  }
  header('Location:login.php');

 ?>
