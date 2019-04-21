<?php
  include 'includes/inclogin.php';

// 　掲示板
// 　DBから書き込み内容を取得し、表示する。
// 　１ページに表示する書き込みは５件。
// 　トップには掲示板への書き込みフォームを設置。

  $num = 5;
  $dsn = 'mysql:host=localhost;dbname=bbs;charset=utf8';
  $user = 'bbsuser';
  $password = 'password';

  $page = 0;
  //ページ指定があれば
  if(isset($_GET['page']) && $_GET['page']>0){
    $page = intval($_GET['page'])-1;
  }

  try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // プリペアドステートメントを作成
    $stmt = $db->prepare(
      "SELECT * FROM bbs ORDER BY date DESC LIMIT :page, :num"
    );
    // パラメータを割り当て
    $page = $page*$num;
    $stmt->bindParam(':page', $page, PDO::PARAM_INT);
    $stmt->bindParam(':num', $num, PDO::PARAM_INT);
    $stmt->execute();
  }catch(PDOException $e){
    echo "エラー：" . $e->getMessage();
  }
 ?>
 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
   <head>
     <link rel="stylesheet" href="css/style.css">
     <meta charset="utf-8">
     <title>掲示板</title>
   </head>
   <body>
     <h1>掲示板</h1>
     <p><a href="index.php">トップへ戻る</a> </p>
     <!-- 書き込みフォーム -->
     <form class="" action="bbswrite.php" method="post">
       <p>名前：<input type="text" name="name" value="<?php echo $_COOKIE['name'] ?>"></p>
       <p>タイトル：<input type="text" name="title" value=""></p>
       <textarea name="body" rows="10" cols="100"></textarea>
       <p>削除用パスワード（数字4桁）：<input type="text" class="bbspass" name="pass" value=""></p>
       <input type="submit" name="" value="書き込む">
       <input type="hidden" name="token" value="<?php echo sha1(session_id()); ?>">
     </form>
     <hr>
     <!-- 表示エリア -->
     <?php
      while($row=$stmt->fetch()){
      ?>
      <p>名前：<?php echo $row['name'] ?></p>
      <p>タイトル：<?php echo $row['title'] ?></p>
      <p><?php echo nl2br(htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8'), false) ?></p>
      <p><?php echo $row['date'] ?></p>
      <form class="" action="bbsdel.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        削除用パスワード：<input type="password" class="bbspass" name="pass">
        <input type="submit" name="" value="削除">
        <input type="hidden" name="token" value="<?php echo sha1(session_id()); ?>">
      </form>
      <?php
      }

      // ページ数の表記
      try{
        $stmt = $db->prepare("SELECT COUNT(*) FROM bbs");
        $stmt->execute();
      }catch(PDOException $e){
        echo "エラー：" . $e->getMessage();
      }
      $comment = $stmt->fetchcolumn();
      $maxpage = ceil($commnet/$num);
      ?>
      <p>
        <?php
          for($i=1;$i<=$maxpage;$i++){
            echo '<a href="bbs.php?page=' . $i . '">' . $i . '</a>&nbsp;';
          }
         ?>
      </p>
   </body>
 </html>
