<?php 
include("../../core/page/header01.php");//載入頁面heaer01
include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {
   // -- 更新排序 --
  for ($i=0; $i <count($_POST['OrderBy']) ; $i++) { 
    $data=array("OrderBy"=>$_POST['OrderBy'][$i]);
    $where=array("Tb_index"=>$_POST['Tb_index'][$i]);
    pdo_update('appProduct', $data, $where);
  }
}

if ($_GET) {

   if (!empty($_GET['Tb_index'])) {//刪除

    $where=array('Tb_index'=>$_GET['Tb_index']);

   	$del_row=pdo_select('SELECT aPic, OtherFile FROM appProduct WHERE Tb_index=:Tb_index', $where);
   	if (isset($del_row['aPic'])) { unlink('../../img/'.$del_row['aPic']); }
    if (isset($del_row['OtherFile'])) { 

      $OtherFile=explode(',', $del_row['OtherFile']);
      for ($i=0; $i <count($OtherFile)-1 ; $i++) { 
      	 unlink('../../img/'.$OtherFile[$i]); 
      }
     }

   	 pdo_delete('appProduct', $where);
   }




//-- 分頁判斷數 --
 $num=10;
 //--- 頁數 ---
 $page=empty($_GET['page'])? 0:((int)$_GET['page']-1)*$num;


$pdo=pdo_conn();

 //-- 上下線顯示 --
if (isset($_GET['OnLineOrNot'])) {
  
  $pdo_sql="SELECT Tb_index, aTitle, aBrand, price, pro_num, HotPro, OrderBy, OnLineOrNot, aPic 
            FROM appProduct WHERE mt_id=:mt_id AND webLang=:webLang AND OnLineOrNot=:OnLineOrNot ORDER BY OrderBy DESC, StartDate DESC, Tb_index DESC LIMIT ".$page.",".$num;
   $sql=$pdo->prepare($pdo_sql);
   $sql->execute(array( "mt_id"=>$_GET['MT_id'], "webLang"=>$weblang, "OnLineOrNot"=>$_GET['OnLineOrNot']));
}
else{
  $pdo_sql="SELECT Tb_index, aTitle, aBrand, price, pro_num, HotPro, OrderBy, OnLineOrNot, aPic 
            FROM appProduct WHERE mt_id=:mt_id AND webLang=:webLang  ORDER BY OrderBy DESC, StartDate DESC, Tb_index DESC LIMIT ".$page.",".$num;

     $sql=$pdo->prepare($pdo_sql);
   $sql->execute(array( "mt_id"=>$_GET['MT_id'], "webLang"=>$weblang));
}
   





}

?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<h2 class="text-primary"><?php echo $page_name['MT_Name']?> 列表</h2>
		<p>本頁面條列出所有的文章清單，如需檢看或進行管理，請由每篇文章右側 管理區進行，感恩</p>
	   <div class="new_div">

        <button id="sort_btn" type="button" class="btn btn-default">
        <i class="fa fa-sort-amount-desc"></i> 更新排序</button>

	    <a href="manager.php?MT_id=<?php echo $_GET['MT_id'];?>">
        <button type="button" class="btn btn-default">
        <i class="fa fa-plus" aria-hidden="true"></i> 新增</button>
        </a>
	  </div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table no-margin">
						<thead>
							<tr>
								<th>#</th>
								<th>產品圖示</th>
								<th>產品名稱</th>
								<th>品牌</th>
								<th>排序</th>
								<th>價格</th>
								<th>數量</th>
								<th>推薦商品(勾選即更新)</th>
								<th>
									目前狀態 
									<select class="OnLineOrNot">
									 <?php 
                                      $OnLineOrNot_all=!isset($_GET['OnLineOrNot']) ? 'selected':'';
                                      $OnLineOrNot_1=$_GET['OnLineOrNot']==1 ? 'selected':'';
                                      $OnLineOrNot_0=isset($_GET['OnLineOrNot']) && $_GET['OnLineOrNot']==0 ? 'selected':'';
									  ?>
										<option <?php echo $OnLineOrNot_all; ?> value="">全部</option>
										<option <?php echo $OnLineOrNot_1; ?> value="1">上線中</option>
										<option <?php echo $OnLineOrNot_0; ?> value="0">已下線</option>
									</select> 
								</th>
								<th class="text-right">管理</th>

							</tr>
						</thead>
						<tbody>

						<?php 
						  $i=1; 
						  while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {
                           $aBrand=pdo_select("SELECT aTitle FROM appBrand WHERE Tb_index=:Tb_index", ['Tb_index'=>$row['aBrand']]);
                           $HotPro=$row['HotPro']==0 ? '':'checked';
					    ?>
							<tr>
								<td><?php echo $i?></td>
								<td><img src="../../img/<?php echo $row['aPic'];?>" style="width: 100px;"></td>
								<td><?php echo $row['aTitle'] ?></td>
								<td><?php echo $aBrand['aTitle']; ?></td>
								<td><input type="number" class="sort_in" name="OrderBy" Tb_index="<?php echo $row['Tb_index'];?>" value="<?php echo $row['OrderBy'] ?>"></td>
								<td>$<?php echo $row['price']?></td>
								<td><?php echo $row['pro_num']?></td>
								<td>
									<input type="checkbox" class="HotPro" value="1" <?php echo $HotPro;?>>
									<input type="hidden"  value="<?php echo $row['Tb_index'];?>">
								</td>
								<td><?php echo $online= $row['OnLineOrNot']==1 ? '上線中' : '已下線';?></td>
								

								<td class="text-right">

								<a href="manager.php?MT_id=<?php echo $_GET['MT_id']?>&Tb_index=<?php echo $row['Tb_index'];?>" >
								<button type="button" class="btn btn-rounded btn-info btn-sm">
								<i class="fa fa-pencil-square" aria-hidden="true"></i>
								編輯</button>
								</a>

								<a href="admin.php?MT_id=<?php echo $_GET['MT_id']?>&Tb_index=<?php echo $row['Tb_index'];?>" 
								   onclick="if (!confirm('確定要刪除 [<?php echo $row['aTitle']?>] ?')) {return false;}">
								<button type="button" class="btn btn-rounded btn-warning btn-sm">
								<i class="fa fa-trash" aria-hidden="true"></i>
								刪除</button>
								</a>

					
								</td>
							</tr>
						<?php $i++; }?>
						</tbody>
					</table>
				</div>
			</div>

			<?php 
			 if (!isset($_GET['OnLineOrNot'])) {
			 	$url='admin.php?MT_id='.$_GET['MT_id'];
			 }
			 else{
			 	$url='admin.php?MT_id='.$_GET['MT_id'].'&OnLineOrNot='.$_GET['OnLineOrNot'];
			 }
               
               $tb_name='appProduct';

               require '../../core/page/page.php';
			?>
		</div>
	</div>
</div>
</div><!-- /#page-content -->
<?php  include("../../core/page/footer01.php");//載入頁面footer01.php?>
<script type="text/javascript">
	$(document).ready(function() {


        /*-- 顯示上下線切換 --*/
        $('.OnLineOrNot').change(function(event) {
           if ($(this).val()=='') {
           	location.replace('admin.php?MT_id=site2018100210151469');
           }
           else{
           	location.replace('admin.php?MT_id=site2018100210151469&OnLineOrNot='+$(this).val());
           }
        	
        });


		$("#sort_btn").click(function(event) {

        var arr_OrderBy=new Array();
        var arr_Tb_index=new Array();

          $(".sort_in").each(function(index, el) {
             arr_OrderBy.push($(this).val());
             arr_Tb_index.push($(this).attr('Tb_index'));
          });
          
          var data={ 
                        OrderBy: arr_OrderBy,
                       Tb_index: arr_Tb_index 
                      };
             ajax_in('admin.php', data, 'no', 'no');

          alert('更新排序');	
         location.replace('admin.php?MT_id=<?php echo $_GET['MT_id'];?>');
		});

		$('.HotPro').change(function(event) {
			var checked=$(this).prop('checked')==true ? 1:0;
			console.log(checked);
			console.log($(this).next().val());
			$.ajax({
				url: 'manager_ajax.php',
				type: 'POST',
				data: {
					type: 'is_HotPro',
					HotPro: checked,
					Tb_index: $(this).next().val()
				}
			});
			
		});
	});
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>
