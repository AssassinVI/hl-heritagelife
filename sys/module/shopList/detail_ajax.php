<?php
require_once '../../core/inc/config.php';
require_once '../../core/inc/function.php';
require_once '../../core/inc/pdo_fun_calss.php';
require_once '../../core/inc/security.php';

if($_POST){
  $pdo=new PDO_fun;
  $param=[
    'ship_code'=>$_POST['ship_code'],
    'ship_remark'=>$_POST['ship_remark'],
    'status'=>'出貨中'
  ];
  $where=['Tb_index'=>$_POST['Tb_index']];
  $pdo->update('shop_List', $param, $where);
  
  $set_name='襲園生活系統';
  $set_mail='server@hl-heritagelife.com';
  $Subject='襲園生活-出貨通知';

  $file_url='ship_html.html';
  $file_one=fopen($file_url,'r');
  $contents = fread($file_one, filesize($file_url));
  $contents= str_replace("{mem_name}",$_POST['mem_name'],$contents);
  $contents= str_replace("{order_id}",$_POST['order_id'],$contents);
  $body_data=$contents;
  $name_data=[$_POST['mem_name']];
  $adds_data=[$_POST['mem_email']];
  send_Mail($set_name, $set_mail, $Subject, $body_data, $name_data, $adds_data);
  fclose($file_one);
}


?>