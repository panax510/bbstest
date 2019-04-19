<?php
  include 'includes/inclogin.php';
  $fp=fopen("info.txt","r");
  $line=array();
  if($fp){
    while(!feof($fp)){
      $line[]=fgets($fp);
    }
    fclose($fp);
  }
 ?>
 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>お知らせ</title>
   </head>
   <body>
     <h1>お知らせ</h1>
     <?php
      if(count($line)){
          for($i=0 ; $i<count($line) ; $i++){
            //先頭行はタイトルとして扱う
            if($i==0){
              echo '<h2>'.$line[$i].'</h2>';
            }else{
              echo $line[$i].'<br />';
            }
          }
      }else{
        echo 'ファイルの中が空です。';
      }
      ?>
  </body>
 </html>
