<?php
require_once '../../core/inc/config.php';
require_once '../../core/inc/function.php';
require_once '../../core/inc/security.php';

$i = 1;
$data_array = array();
$pdo = pdo_conn();
$sql = $pdo->prepare("SELECT * FROM shop_List ORDER BY StartDate DESC");
$sql->execute();
while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

     	  /*$array_name=explode(',', $row['pro_name_array']);
          $array_num=explode(',', $row['pro_num_array']);
          $pro_txt='<ul>';
          for ($i=0; $i <count($array_name)-1 ; $i++) { 
             $pro_txt.='<li>'.$array_name[$i].' X '.$array_num[$i].'</li>';
          }
          $pro_txt.='</ul>';*/

          $sql_detial=$pdo->prepare("SELECT * FROM shopDetial WHERE SL_id=:SL_id ORDER BY Tb_index DESC");
          $sql_detial->execute(['SL_id'=>$row['Tb_index']]);

          $pro_txt='<ul>';
          while ($row_detial=$sql_detial->fetch(PDO::FETCH_ASSOC)) {
           
            $row_item=pdo_select("SELECT * FROM appProduct WHERE Tb_index=:Tb_index", ['Tb_index'=>$row_detial['pro_id']]);
            $pro_txt.='<li>'.$row_item['aTitle'].' X '.$row_detial['pro_num'].'</li>';
            
          }

           $pro_txt.='</ul>';


           //-- 付款狀態 --
           if ($row['is_credit']==1) {
             $is_credit='<span class="label label-primary">付款成功</span>';
           }
           elseif ($row['is_credit']==0){
             
             if ($row['payAdds']=='') {
               $is_credit='<span class="label label-danger">付款失敗</span>';
             }
             else{
               $is_credit='<span class="label">匯款</span>';
             }
           }
          

          //----- 詳細資料 -----
          $detail_btn='<a class="btn btn-w-m btn-success fancybox" data-fancybox-type="iframe" href="detail.php?Tb_index='.$row['Tb_index'].'">詳細資料</a>';

          //------ 核取方塊 --------
          $checkbox='<input type="checkbox" id="check[]" name="check[]" value="'.$row['Tb_index'].'">';
   
  $list_arr=[
             'checkbox'=>$checkbox, 
             'Tb_index'=>$row['Tb_index'], 
            'StartDate'=>$row['StartDate'], 
          'member_name'=>$row['name'], 
          'product_txt'=>$pro_txt, 
          'payment_mod'=>$row['payment_mod'],
            'is_credit'=>$is_credit,
                'total'=>'$'.$row['total'], 
               'status'=>$row['status'], 
               'detail'=>$detail_btn
            ];
	array_push($data_array, $list_arr);
	$i++;
}
$pdo=NULL;
echo json_encode(array('data' => $data_array));
?>