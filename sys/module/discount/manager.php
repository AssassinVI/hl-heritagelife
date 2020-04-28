<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {

	if (empty($_POST['Tb_index'])) {//新增
		$Tb_index='di'.date('YmdHis').rand(0,99);
     
	$StartDate=empty($_POST['StartDate']) ? date('Y-m-d'): $_POST['StartDate'];
	$OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
	$param=  ['Tb_index'=>$Tb_index,
			     'mt_id'=>$_POST['mt_id'],
			'di_name'=>$_POST['di_name'],
			'di_num'=>$_POST['di_num'],
			'di_code'=>$_POST['di_code'],
			'StartDate'=>$StartDate,
		   'OnLineOrNot'=>$OnLineOrNot
		  ];
	pdo_insert('appDiscount', $param);
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }
   else{  //修改

   	$Tb_index =$_POST['Tb_index'];
    
    $param=[  
		      'di_name'=>$_POST['di_name'],
			'di_num'=>$_POST['di_num'],
			'di_code'=>$_POST['di_code']
		   ];
    $where= ['Tb_index'=>$Tb_index] ;
	pdo_update('appDiscount', $param, $where);
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}
if ($_GET) {
 	$where=['Tb_index'=>$_GET['Tb_index']];
 	$row=pdo_select('SELECT * FROM appDiscount WHERE Tb_index=:Tb_index', $where);
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
					<form id="put_form" action="manager.php" method="POST" enctype='multipart/form-data' class="form-horizontal">
						<div class="form-group">
							<label class="col-md-2 control-label" for="di_name">折扣名稱</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="di_name" name="di_name" value="<?php echo $row['di_name'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="di_num">折扣數</label>
							<div class="col-md-2">
								<input type="text" class="form-control" id="di_num" name="di_num" value="<?php echo $row['di_num'];?>">
							</div>
							<div class="col-md-1">
								<h3>折</h3>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="di_code">折扣碼</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="di_code" name="di_code" value="<?php echo $row['di_code'];?>">
							</div>
							<div class="col-md-5">
								<button id="code_btn" type="button" class="btn btn-success">自動產生</button>
								<span>自動產生12個英文加數字亂碼</span>
							</div>
						</div>


						
						<div class="form-group">
							<label class="col-md-2 control-label" for="OnLineOrNot">是否上線</label>
							<div class="col-md-10">
								<input style="width: 20px; height: 20px;" id="OnLineOrNot" name="OnLineOrNot" type="checkbox" value="1" <?php echo $check=!isset($row['OnLineOrNot']) || $row['OnLineOrNot']==1 ? 'checked' : ''; ?>  />
							</div>
						</div>

						<input type="hidden" id="Tb_index" name="Tb_index" value="<?php echo $_GET['Tb_index'];?>">
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
          	 $('#put_form').submit();
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


		/*------------------ 自動亂碼 -------------------- */
		$('#code_btn').click(function (e) { 
			
			$('[name="di_code"]').val(randomPassword(12));
		});
      });

//-- 亂數 --
function randomPassword(size)
{
var seed = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z',
'a','b','c','d','e','f','g','h','i','j','k','m','n','p','Q','r','s','t','u','v','w','x','y','z',
'2','3','4','5','6','7','8','9'
);//陣列
seedlength = seed.length;//陣列長度
var createPassword = '';
for (i=0;i<size;i++ ) {
j = Math.floor(Math.random()*seedlength);
createPassword  += seed[j];
}
return createPassword;
}
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>

