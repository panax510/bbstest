<?php
  include 'includes/inclogin.php';

  $filename=$_POST['filename'];

  $fpath = 'img/';
  $fpath .= $filename;

  if(!file_exists($fpath)){
    die("ファイルが見つかりません");
  }else if(!($fp = fopen($fpath,"r"))){
    die("ファイルが開けません");
  }

  mb_output_handler("pass");
  header("Content-Type: application/octet-stream");
  header("content-disposition: attachment; filename={$filename}");
  header("content-length: ".filesize($fpath));
  header("connection: close");

  if(!readfile($fpath)){
    die("ファイルが読み込めません");
  }

  header('location: picalbum.php');
  exit();
 ?>
