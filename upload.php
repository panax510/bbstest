<?php
  include 'includes/inclogin.php';
  $msg = '';

  if(isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])){
    $old_name = $_FILES['image']['tmp_name'];

    //上書き対策
    $new_name = date("YmdHis");
    //↓mt_randは原則使用しない。PHPのバージョンをあげたら別関数に書き換え
    $new_name .= mt_rand();
    //拡張子
    switch (exif_imagetype($_FILES['image']['tmp_name'])) {
      case IMAGETYPE_JPEG:
        $new_name.='.jpg';
        break;
      case IMAGETYPE_PNG:
        $new_name.='.png';
        break;
      case IMAGETYPE_GIF:
        $new_name.='.gif';
        break;
      default:
        // code...
        header('location: upload.php');
        exit();
      }
    if(move_uploaded_file($old_name,'img/'.$new_name)){
      chmod("img/".$new_name,0666);
      $msg = '画像のアップロードに成功しました。';
    }else{
      $msg = '画像のアップロードに失敗しました。';
    }
  }
 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>画像アップロード</title>
  </head>
  <body>
    <h1>画像のアップロード</h1>
    <p><a href="index.php">トップへ戻る</a></p>
    <?php
      if($msg != ''){
        echo '<p>'.$msg.'</p>';
      }
     ?>
     <form class="" action="upload.php" method="post" enctype="multipart/form-data">
       <input type="file" name="image" value="">
       <input type="submit" name="" value="アップロード">
     </form>
  </body>
</html>
