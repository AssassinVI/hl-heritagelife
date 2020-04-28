<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {

	if (empty($_POST['Tb_index'])) {//新增
		$Tb_index='df'.date('YmdHis').rand(0,99);
     
	$OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
	$param=  ['Tb_index'=>$Tb_index,
			     'mt_id'=>$_POST['mt_id'],
		   	   'df_free'=>$_POST['df_free'],
			  'df_money'=>$_POST['df_money'],
		   'OnLineOrNot'=>$OnLineOrNot
		  ];
	pdo_insert('appDeliveryFee', $param);
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }
   else{  //修改

   	$Tb_index =$_POST['Tb_index'];
    
    $param=[  
		     'df_free'=>$_POST['df_free'],
			 'df_money'=>$_POST['df_money']
		   ];
    $where= ['Tb_index'=>$Tb_index] ;
	pdo_update('appDeliveryFee', $param, $where);
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}
if ($_GET) {
 	// $where=['Tb_index'=>$_GET['Tb_index']];
	// $row=pdo_select('SELECT * FROM appDeliveryFee WHERE Tb_index=:Tb_index', $where);
 	$row=pdo_select('SELECT * FROM appDeliveryFee LIMIT 0,1', $where);
}
?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<header>網頁資料編輯
					</header>
				</div><!-- /.panel-heading -->
				<div class="panel-body">
					<form id="put_form" action="admin.php" method="POST" enctype='multipart/form-data' class="form-horizontal">
						<div class="form-group">
							<label class="col-md-2 control-label" for="df_free">滿額免運金額</label>
							<div class="col-md-9">
							  $	<input type="text"  id="df_free" name="df_free" value="<?php echo $row['df_free'];?>"> 元
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="df_money">運費</label>
							<div class="col-md-10">
								$ <input type="text" id="df_money" name="df_money" value="<?php echo $row['df_money'];?>"> 元
							</div>
						</div>

					
						<div class="form-group">
							<label class="col-md-2 control-label" for="OnLineOrNot">是否上線</label>
							<div class="col-md-10">
								<input style="width: 20px; height: 20px;" id="OnLineOrNot" name="OnLineOrNot" type="checkbox" value="1" <?php echo $check=!isset($row['OnLineOrNot']) || $row['OnLineOrNot']==1 ? 'checked' : ''; ?>  />
							</div>
						</div>

						<input type="hidden" id="Tb_index" name="Tb_index" value="<?php echo $row['Tb_index'];?>">
						<input type="hidden" id="mt_id" name="mt_id" value="<?php echo $_GET['MT_id'];?>">
					</form>
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->




		</div>

		<div class="col-lg-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<header>儲存您的資料</header>
				</div><!-- /.panel-heading -->
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<button type="button" class="btn btn-danger btn-block btn-flat" data-toggle="modal" data-target="#settingsModal1" onclick="clean_all()">重設表單</button>
						</div>
						<div class="col-lg-6">
						<?php if(empty($_GET['Tb_index'])){?>
							<button type="button" id="submit_btn" class="btn btn-info btn-block btn-raised">儲存</button>
						<?php }else{?>
						    <button type="button" id="submit_btn" class="btn btn-info btn-block btn-raised">更新</button>
						<?php }?>
						</div>
					</div>
					
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->
		</div>
	</div>

</div><!-- /#page-content -->

<?php  include("../../core/page/footer01.php");//載入頁面footer02.php?>
<script type="text/javascript">
	$(document).ready(function() {
          $("#submit_btn").click(function(event) {

			var err_txt='';
			err_txt+=check_input('[name="df_free"]','免運金額\n');
			err_txt+=check_input('[name="df_money"]','運費');

			if(err_txt!=''){
              alert('請輸入\n');
			}
			else{
               $('#put_form').submit();
			}
          });

    //------------------------------ 刪圖 ---------------------------------
          $("#one_del_img").click(function(event) { 
			if (confirm('是否要刪除圖檔?')) {
			 var data={
			 	        Tb_index: $("#Tb_index").val(),
                            aPic: '<?php echo $row["aPic"]?>',
                            type: 'delete'
			          };	
               ajax_in('manager.php', data, '成功刪除', 'no');
               $("#img_div").html('');
			}
		});
      //------------------------------ 刪檔 ---------------------------------
          $(".one_del_file").click(function(event) { 
			if (confirm('是否要刪除檔案?')) {
			 var data={
			 	        Tb_index: $("#Tb_index").val(),
                       OtherFile: $(this).next().next().val(),
                            type: 'delete'
			          };	
               ajax_in('manager.php', data, '成功刪除', 'no');
               $(this).parent().html('');
			}
		});


      });


</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>

