<?php
  include 'includes/inclogin.php';

  $name=$_POST['name'];
  $title=$_POST['title'];
  $body=$_POST['body'];
  $pass=$_POST['pass'];
  $token=$_POST['token'];

  // 入力チェック
  if($name==''||$title==''||$body==''){
    header('location: bbs.php');
    exit();
  }else if(!preg_match("/^[0-9]{4}$/",$pass)){
    header('location: bbs.php');
    exit();
  }else if($token != sha1(session_id())){
    header('location: bbs.php');
    exit();
  }
  setcookie('name',$name,time()+60*60*24*30);

  $dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
  $user = 'bbsuser';
  $password = 'password';

  try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt=$db->prepare("
      INSERT INTO bbs(name,title,body,date,pass)
      VALUES(:name, :title, :body, now(), :pass)
    ");
    $stmt->bindparam(':name', $name, PDO::PARAM_STR);
    $stmt->bindparam(':title', $title, PDO::PARAM_STR);
    $stmt->bindparam(':body', $body, PDO::PARAM_STR);
    $stmt->bindparam(':pass', $pass, PDO::PARAM_INT);
    $stmt->execute();

    header('location: bbs.php');
    exit();
  }catch(PDOException $e){
    die('エラー：' . $e->getMessage());
  }
 ?>
