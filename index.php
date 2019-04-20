<?php
 include 'includes/inclogin.php';
 //トップに記載するお知らせ
 $fp = fopen("info.txt","r");
 ?>

 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>交流サイト</title>
   </head>
   <body>
     <h1>交流サイト</h1>
     <h2>メニュー</h2>
     <p>
       <a href="picalbum.php">フォトアルバム</a>
       <a href="bbs.php">掲示板</a>
       <a href="logout.php">ログアウト</a>
     </p>
     <h2>お知らせ</h2>
     <?php
       if ($fp){
         $title = fgets($fp);
         if ($title){
           echo '<a href="info.php">' . $title . '</a>';
         } else {
           //中味が空
           echo 'お知らせはありません。';
         }
         fclose($fp);  // ファイルを閉じる
       } else {
         echo 'お知らせはありません。';
       }
     ?>
   </body>
 </html>
