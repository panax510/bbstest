<?php
  include "includes/inclogin.php";
  //画像ファイル名の格納用配列
  $image = array();
  $num=5;
  //画像一覧取得
  if($pic = opendir('./img')){
    while($entry = readdir($pic)){
      if($entry != "." && $entry != ".."){
        $image[] = $entry;
      }
    }
    closedir($pic);
  }
 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ピクチャーアルバム</title>
  </head>
  <body>
    <h1>ピクチャーアルバム</h1>
    <p>
      <a href="index.php">トップへ戻る</a>
      <a href="upload.php">画像のアップロード</a>
    </p>
    <?php
      if(count($image)>0){
        $image = array_chunk($image,$num);
        $page=0;
        if(isset($_GET['page']) && is_numeric($_GET['page'])){
          $page = intval($_GET['page'])-1;
          if(!isset($image[$page])){
            $page=0;
          }
        }
        foreach ($image[$page] as $img) {
          // code...
          echo '<form method="POST" action="download.php">';
          echo '<input type=hidden value="'.$img.'" name="filename">';
          echo '<input type=image src="./img/'.$img.'">';
          echo '</form>';
        }

        echo '<p>';
        for($i=1; $i<=count($image); $i++){
          echo '<a href="picalbum.php?page='.$i.'">'.$i.'</a>&nbsp;';
        }
        echo '</p>';
      }else{
        echo '<p>画像がありません。</p>';
      }
     ?>
  </body>
</html>
