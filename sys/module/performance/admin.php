<?php 
include("../../core/page/header01.php");//載入頁面heaer01
include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
// if ($_POST) {
//    // -- 更新排序 --
//   for ($i=0; $i <count($_POST['OrderBy']) ; $i++) { 
//     $data=["OrderBy"=>$_POST['OrderBy'][$i]];
//     $where=["Tb_index"=>$_POST['Tb_index'][$i]];
//     pdo_update('appDiscount', $data, $where);
//   }
// }

if ($_GET) {

//    if (!empty($_GET['Tb_index'])) {//刪除

//     $where=['Tb_index'=>$_GET['Tb_index']];
//    	 pdo_delete('appDiscount', $where);
//    }
   
   $pdo=pdo_conn();
   $sql=$pdo->prepare("SELECT sl.Tb_index, sl.slm_name, SUM(shl.total) as all_total, sl.slm_id, sl.OnLineOrNot
                       FROM appSalesman as sl
					   INNER JOIN appSal_dis as sd ON sd.slm_id=sl.slm_id
					   LEFT JOIN shop_List as shl ON sd.dis_id=shl.dis_id
					   WHERE sl.mt_id='site2020021809205119' 
					   GROUP BY sl.Tb_index
					   ORDER BY sl.OrderBy DESC, all_total DESC");
   $sql->execute();

}

?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<h2 class="text-primary"><?php echo $page_name['MT_Name']?> 列表</h2>
		<p>本頁面條列出所有的文章清單，如需檢看或進行管理，請由每篇文章右側 管理區進行，感恩</p>
	   <div class="new_div">

        <!-- <button id="sort_btn" type="button" class="btn btn-default">
        <i class="fa fa-sort-amount-desc"></i> 更新排序</button>
   
	    <a href="manager.php?MT_id=<?php echo $_GET['MT_id'];?>">
        <button type="button" class="btn btn-default">
        <i class="fa fa-plus" aria-hidden="true"></i> 新增</button>
        </a> -->
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
								<th>業務員</th>
								<th>折扣碼</th>
								<th>總營業額</th>
								<th>狀態</th>
								<th class="text-right">管理</th>

							</tr>
						</thead>
						<tbody>

						<?php 
						 $i=1; while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {
							 $row_sal_dis=$pdo_new->select("SELECT d.di_name, d.di_num 
							                                FROM appSal_dis as sd
															INNER JOIN appDiscount as d ON d.Tb_index=sd.dis_id
															WHERE sd.slm_id=:slm_id", ['slm_id'=>$row['slm_id']]);
							 $dis_txt='';
				             foreach ($row_sal_dis as $sal_dis) {
								 $dis_txt.=$sal_dis['di_name'].'｜';
							 }
					    ?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $row['slm_name']; ?></td>
								<td><?php echo $dis_txt; ?></td>
								<td>$<?php echo $row['all_total']; ?></td>
								<td><?php echo $online= $row['OnLineOrNot']==1 ? '上線' : '已下線';?></td>
								
								<td class="text-right">

								<a href="manager.php?MT_id=<?php echo $_GET['MT_id']?>&Tb_index=<?php echo $row['Tb_index'];?>" >
								<button type="button" class="btn btn-rounded btn-info btn-sm">
								<i class="fa fa-pencil-square" aria-hidden="true"></i>
								查看</button>
								</a>

								

					
								</td>
							</tr>
						<?php $i++; }?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div><!-- /#page-content -->
<?php  include("../../core/page/footer01.php");//載入頁面footer01.php?>
<script type="text/javascript">
	$(document).ready(function() {
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
	});
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>
