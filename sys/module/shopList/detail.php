<?php 
require_once '../../core/inc/config.php';
require_once '../../core/inc/function.php';
include_once '../../core/inc/pdo_fun_calss.php';
require_once '../../core/inc/security.php';

$pdo_new=new PDO_fun;

if ($_GET) {
	
	$pdo=pdo_conn();
    $row=$pdo_new->select("SELECT * FROM shop_List WHERE Tb_index=:Tb_index", ['Tb_index'=>$_GET['Tb_index']], 'one');
	$row_d_fee=$pdo_new->select("SELECT * FROM appDeliveryFee LIMIT 0,1", 'no', 'one');
	$df_money=$row['is_deliveryFee']=='1' ? $row_d_fee['df_money']:0;
}

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title></title>
	
	<style type="text/css">
		.mem_td_lab{ text-align: center; background-color: #eafffb;  }
		.Ship_input{ width:100%; padding:5px 3px;}
		.btn-success{padding: 5px 25px; border: none; color: #fff; background-color: #0060bb;     cursor: pointer; }
		.btn-default{padding: 5px 25px; border: none; color: #fff; background-color: #adadad;     cursor: pointer;}
	</style>
</head>
<body>
  <p>訂單編號: <span id="order_id"><?php echo $row['Tb_index']?></span></p>
    <!-- 訂單資訊 -->
	<table width="100%" border="1" cellpadding="15" cellspacing="0" style="border-color: #fff; margin-bottom: 20px;">
		<thead style="background: #eee">
			<th>訂購商品</th>
            <th>客製化</th>
			<th>售價</th>
			<th>數量</th>
			<th>小計</th>
		</thead>
		<tbody>
			<?php 
			  /* $array_id=explode(',', $row['pro_id_array']);
               $array_name=explode(',', $row['pro_name_array']);
               $array_num=explode(',', $row['pro_num_array']);
               for ($i=0; $i <count($array_name)-1 ; $i++) { 

               	 $where=array('Tb_index'=>$array_id[$i]);
               	 $product=pdo_select("SELECT price, mem_price FROM appProduct WHERE Tb_index=:Tb_index", $where);
               	 if (!empty($product['mem_price'])) {
               	 	echo "<tr>
               	         <td>".$array_name[$i]."</td>
               	         <td align='center'>$".$product['mem_price']."</td>
               	         <td align='center'>".$array_num[$i]."</td>
               	         <td align='center'>$".((int)$product['mem_price']*(int)$array_num[$i])."</td>
               	       </tr>";
               	 }
               	 else{
               	 	echo "<tr>
               	         <td>".$array_name[$i]."</td>
               	         <td align='center'>$".$product['price']."</td>
               	         <td align='center'>".$array_num[$i]."</td>
               	         <td align='center'>$".((int)$product['price']*(int)$array_num[$i])."</td>
               	       </tr>";
               	 }
               }*/

              $item_total=0;
              $sql_detial=$pdo->prepare("SELECT * FROM shopDetial WHERE SL_id=:SL_id");
              $sql_detial->execute(array(':SL_id'=>$row['Tb_index']));
              while ($row_detial=$sql_detial->fetch(PDO::FETCH_ASSOC)) {
                
                $other_list_txt='';
                $other_list_total=0;
                $other_list=explode('|,|', $row_detial['other_list']);
                for ($i=0; $i <count($other_list)-1 ; $i++) {
                  $other_list_one=explode('||', $other_list[$i]); 
                  $other_list_txt.=$other_list_one[0].' $'.$other_list_one[1].'<br>';
                  $other_list_total+=(int)$other_list_one[1];
                }


                $row_item=pdo_select("SELECT * FROM appProduct WHERE Tb_index=:Tb_index", ['Tb_index'=>$row_detial['pro_id']]);
                  
				  $item_price=(int)$row_item['price']+$other_list_total;
				  $item_total+=($item_price*(int)$row_detial['pro_num']);
              	 	echo "<tr>
               	         <td>".$row_item['aTitle']."</td>
                         <td>".$other_list_txt."</td>
                         <td align='center'>$".$item_price."</td>
               	         <td align='center'>".$row_detial['pro_num']."</td>
               	         <td align='center'>$".($item_price*(int)$row_detial['pro_num'])."</td>
               	       </tr>";
              	 
              }
			?>

			<tr>
			  <td colspan="4" align="right">總計</td>
			  <td align="center">$<?php echo $item_total;?></td>
			</tr>
			<?php
			//-- 折扣 --
			$row_di=$pdo_new->select("SELECT * FROM appDiscount WHERE Tb_index=:Tb_index", ['Tb_index'=>$row['dis_id']], 'one');
			if(!empty($row_di['Tb_index'])){
			  
              echo '<tr style=" background: #ffe8e8; font-weight: 600;">
			        <td >折扣</td>
			        <td colspan="3" align="right">'.$row_di['di_name'].'</td>
			        <td align="center">'.$row_di['di_num'].'折</td>
			      </tr>';
			}
			?>
			
			<tr>
				<td>
				   總金額(打折後)：$<?php 
				      if(!empty($row_di['Tb_index'])){
						 $di_num=strlen($row_di['di_num'])>1 ? (int)$row_di['di_num']/100 : (int)$row_di['di_num']/10;
                         echo round((int)$item_total*$di_num);
					  }
					  else{
                         echo $item_total;
					  }
				    ?>
				</td>
				<td>運費：$<?php echo $df_money;?></td>
				<td colspan="2" align="right">總金額+運費：</td>
				<td align="center" style="color: red">$<?php echo $row['total']?></td>
			</tr>

		</tbody>
	</table>
	<!-- 客戶資訊 -->
	<table width="100%" border="1" cellpadding="15" cellspacing="0" style="border-color: #fff; margin-bottom: 20px;">
		<tbody>
			<tr style="background: #eee"><td colspan="6">收件者資料</td></tr>
			<tr>
        <td class="mem_td_lab">姓名</td><td id="mem_name"><?php echo $row['name']?></td>
        <td class="mem_td_lab">行動電話</td><td><?php echo $row['phone']?></td>
      </tr>
			<tr><td class="mem_td_lab">聯絡地址</td><td colspan="5"><?php echo $row['adds']?></td></tr>
			<tr><td class="mem_td_lab">電子信箱</td><td id="mem_email" colspan="5"><?php echo $row['email']?></td></tr>
      <?php
        if ($row['payment_mod']=='匯款') {
          echo '<tr><td class="mem_td_lab">匯款後五碼</td><td colspan="5">'.$row['payAdds'].'</td></tr>';
        }
        else{
          $is_credit=$row['is_credit']==1 ? '付款成功':'交易失敗(Error '.$row['is_credit'].')';
          echo '<tr><td class="mem_td_lab">信用卡交易狀態</td><td colspan="5">'.$is_credit.'</td></tr>';
        }
      ?>

			<tr><td class="mem_td_lab">訂單狀態</td><td colspan="5"><?php echo $row['status']?></td></tr>
      <tr><td class="mem_td_lab">備註</td><td colspan="5"><?php echo $row['remark']?></td></tr>
		</tbody>
	</table>
    
	<!-- 出貨收據 -->
	<table width="100%" border="1" cellpadding="15" cellspacing="0" style="border-color: #fff; ">
		<tbody>
			<tr style="background: #eee"><td colspan="6">出貨收據</td></tr>
			<?php
			 if($row['status']=='出貨中' || $row['status']=='結案' || $row['status']=='作廢'){
              echo '<tr><td class="mem_td_lab">出貨收據號碼</td><td colspan="5">'.$row['ship_code'].'</td></tr>
                    <tr><td class="mem_td_lab">備註</td><td colspan="5">'.$row['ship_remark'].'</td></tr>';
			 }
			 else{
               echo '<tr><td class="mem_td_lab">出貨收據號碼</td><td colspan="5"><input class="Ship_input" name="ship_code" type="text" value=""></td></tr>
                    <tr><td class="mem_td_lab">備註</td><td colspan="5"><input class="Ship_input" name="ship_remark" type="text" value=""></td></tr>';
			 }
			?>
			
		</tbody>
	</table>

	<div style=" text-align: center;  margin-top: 15px;">
	 <?php 
	  if($row['status']=='出貨中' || $row['status']=='結案' || $row['status']=='作廢'){
        echo '';
	  }
	  else{
		echo '<button id="sub_btn" class="btn-success">確定</button>
	          <button id="no_btn" class="btn-default">取消</button>';
	  }
	 ?>
	   
	</div>
    
	<script src="../../js/jquery-2.1.1.js"></script>
	<script>
	  $(document).ready(function () {
		  $('#sub_btn').click(function (e) { 

			var err_txt='';

			err_txt+=check_input('[name="ship_code"]','出貨號碼');

			if(err_txt!=''){
              alert('請輸入'+err_txt);
			}
			else{
              
			  if(confirm('是否要確定出貨?\n確定後狀態將改為出貨中')){
              var Tb_index=location.search.split('=');
			      Tb_index=Tb_index[1];
			  $.ajax({
				  type: "POST",
				  url: "detail_ajax.php",
				  data: {
                    Tb_index: Tb_index,
					order_id:$('#order_id').html(),
					mem_name:$('#mem_name').html(),
					mem_email:$('#mem_email').html(),
					ship_code: $('[name="ship_code"]').val(),
					ship_remark: $('[name="ship_remark"]').val(),
				  },
				  success: function (response) {
					  
					//   window.parent.table.page( 0 ).draw( 'page' );
					//   parent.$.fancybox.close();
					window.parent.location.reload();
				  }
			  });
			}
			}
			
			
			  
		  });

		  $('#no_btn').click(function (e) { 
			  parent.$.fancybox.close();
		  });
	  });


	  // =============================== 檢查input ====================================
function check_input(id,txt) {

          if ($(id).attr('type')=='radio' || $(id).attr('type')=='checkbox') {
            
            if($(id+':checked').val()==undefined){
             $(id).css('borderColor', 'red');
              return txt;
           }else{
              $(id).css('borderColor', 'rgba(0,0,0,0.1)');
              return "";
           }
          }else{
            if ($(id).val()=='') {
              $(id).css('borderColor', 'red');
              return txt;
           }else{
              $(id).css('borderColor', 'rgba(0,0,0,0.1)');
              return "";
           }
          }
  }
	</script>
</body>
</html>