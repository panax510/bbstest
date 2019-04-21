<?php
  session_start();  // セッション開始
  if (isset($_SESSION['id'])){
    header('Location: index.php');
  } else if (isset($_POST['name']) && isset($_POST['password'])){
    //ログインしていない状態でIDとパスが投げられたらDBへユーザー照合
    $dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
    $user = 'bbsuser';
    $password = 'password';
    try {
      $db = new PDO($dsn, $user, $password);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      // プリペアドステートメントを作成
      $stmt = $db->prepare(
        "SELECT * FROM user WHERE name=:name AND pass=:pass"
      );
      // パラメータを割り当て
      $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
      //パスはsha1で暗号化
      $stmt->bindParam(':pass', sha1($_POST['password']), PDO::PARAM_STR);
      $stmt->execute();

      if ($row = $stmt->fetch()){
        // ユーザが存在していたので、セッションにユーザIDをセット
        $_SESSION['id'] = $row['id'];
        // セッションID再作成
        session_regenerate_id(true);
        header('Location: index.php');
        exit();
      } else {
        header('Location: login.php');
        exit();
      }
    } catch(PDOException $e){
      die('エラー：' . $e->getMessage());
    }
  } else {
//ログインページの表示
?>
<!-- ログインページ
ログイン状態じゃない場合は自動でこのページに推移する -->
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>交流サイト</title>
  </head>
  <body>
    <h1>交流サイト</h1>
    <h2>ログイン</h2>
    <form action="login.php" method="post">
      <p>ユーザ名：<input type="text" name="name"></p>
      <p>パスワード：<input type="password" name="password"></p>
      <p><input type="submit" value="ログイン"></p>
    </form>
  </body>
</html>
<?php } ?>
