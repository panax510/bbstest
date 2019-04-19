<?php
  include 'includes/inclogin.php';

  $id=intval($_POST['id']);
  $pass=$_POST['pass'];
  $token=$_POST['token'];

  if($id==''||$pass==''){
    header('location: bbs.php');
    exit();
  }elseif($token != sha1(session_id())){
    header('location: bbs.php');
    exit();
  }

  $dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
  $user = 'bbsuser';
  $password = 'password';

  try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt=$db->prepare(
      "DELETE FROM bbs WHERE id=:id AND pass=:pass"
    );

    $stmt->bindparam(':id', $id, PDO::PARAM_INT);
    $stmt->bindparam(':pass', $pass, pdo::PARAM_INT);
    $stmt->execute();
  }catch(PDOException $e){
    echo "エラー：" . $e->getMessage();
  }
  header('location: bbs.php');
  exit();
 ?>
