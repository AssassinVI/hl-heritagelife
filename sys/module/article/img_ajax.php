<?php
require '../../core/inc/pdo_fun_calss.php';
require '../../core/inc/function.php';
if ($_FILES) {

  //$pdo=new PDO_fun;
  $date=date('YmdHis');

  if ($_FILES['img']['type']=='image/jpeg') {
     ecstart_convert_jpeg_NEW($_FILES['img']['tmp_name'],'../../img/cropper/'.$date.'.jpg',1000);
  }
  elseif($_FILES['img']['type']=='image/png'){
     ecstart_convert_png_NEW($_FILES['img']['tmp_name'],'../../img/cropper/'.$date.'.jpg',1000);
  }
  
 

  echo $date;
}
?>