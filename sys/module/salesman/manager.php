<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {

	if (empty($_POST['Tb_index'])) {//新增
		$Tb_index='slm'.date('YmdHis').rand(0,99);
		
		$slm_id=$pdo_new->select("SELECT slm_id+1 as slm_id_new FROM appSalesman ORDER BY slm_id DESC LIMIT 0,1", 'no', 'one');
		$slm_id=empty($slm_id['slm_id_new']) ? 1:$slm_id['slm_id_new'];
	    $StartDate=empty($_POST['StartDate']) ? date('Y-m-d'): $_POST['StartDate'];
	    $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
	
	$param=  ['Tb_index'=>$Tb_index,
				 'mt_id'=>$_POST['mt_id'],
				'slm_id'=>$slm_id,
			   'slm_name'=>$_POST['slm_name'],
			    'slm_genger'=>$_POST['slm_genger'],
			   'slm_phone'=>$_POST['slm_phone'],
			   'slm_addr'=>$_POST['slm_addr'],
			   'slm_mail'=>$_POST['slm_mail'],
			 'StartDate'=>$StartDate,
		   'OnLineOrNot'=>$OnLineOrNot
		  ];
	pdo_insert('appSalesman', $param);

	//-- 折扣碼 --
	$x=1;
	foreach ($_POST['sel_discount'] as $sel_discount) {
	  if(!empty($sel_discount)){
        $Tb_index='sd'.date('YmdHis').'0'.$x;
	    $param=  ['Tb_index'=>$Tb_index,
				   'slm_id'=>$slm_id,
			     'dis_id'=>$sel_discount,
		 	   'StartDate'=>date('Y-m-d H:i:s')
		  ];
	    pdo_insert('appSal_dis', $param);
	    $x++;
	  }
	}
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }
   else{  //修改

	   $Tb_index =$_POST['Tb_index'];
	   $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
    
    $param=[  
		      'slm_name'=>$_POST['slm_name'],
			'slm_genger'=>$_POST['slm_genger'],
			 'slm_phone'=>$_POST['slm_phone'],
			  'slm_addr'=>$_POST['slm_addr'],
			  'slm_mail'=>$_POST['slm_mail'],
			  'OnLineOrNot'=>$OnLineOrNot
		   ];
    $where= ['Tb_index'=>$Tb_index] ;
	pdo_update('appSalesman', $param, $where);

	//-- 折扣碼 --
	$x=0;
	foreach ($_POST['sel_discount'] as $sel_discount) {
	  if(!empty($sel_discount)){
		//-- 新增 --
		if(empty($_POST['sal_dis_id'][$x])){
           $Tb_index='sd'.date('YmdHis').rand(4,99);
	        $param=  ['Tb_index'=>$Tb_index,
				        'slm_id'=>$_POST['slm_id'],
			            'dis_id'=>$sel_discount,
		 	         'StartDate'=>date('Y-m-d H:i:s')];
	       pdo_insert('appSal_dis', $param);
		}
		//-- 修改 --
		else{
           $where= ['Tb_index'=>$_POST['sal_dis_id'][$x]];
	       $param= ['dis_id'=>$sel_discount];
	       pdo_update('appSal_dis', $param, $where);
		}
	  }
	  //-- 刪除 --
	  else{
		$where= ['Tb_index'=>$_POST['sal_dis_id'][$x]];
	    pdo_delete('appSal_dis', $where);
	  }
	  $x++;
	}
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}
if ($_GET) {
 	$where=['Tb_index'=>$_GET['Tb_index']];
	 $row=pdo_select('SELECT * FROM appSalesman WHERE Tb_index=:Tb_index', $where);
	 $slm_genger1=$row['slm_genger']==1 ? 'checked':'';
	 $slm_genger0=$row['slm_genger']==2 ? 'checked':'';

	 $row_dis=$pdo_new->select("SELECT * FROM appSal_dis WHERE slm_id=:slm_id", ['slm_id'=>$row['slm_id']]);
	 $dis_arr=[];
	 $dis_id_arr=[];
	 foreach ($row_dis as $dis) {
		 array_push($dis_arr,$dis['Tb_index']);
		 array_push($dis_id_arr,$dis['dis_id']);
	 }
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
							<label class="col-md-2 control-label" for="di_name">業務員ID</label>
							<div class="col-md-10">
								<?php
								  if(!empty($row['slm_id'])){
                                    echo number_zero($row['slm_id'], 10000);
								  }
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="slm_name">業務員名稱</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="slm_name" name="slm_name" value="<?php echo $row['slm_name'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="slm_genger">業務員性別</label>
							<div class="col-md-5">
								<label ><input type="radio"  id="slm_genger" name="slm_genger" <?php echo $slm_genger1;?> value="1">男</label>｜
								<label ><input type="radio"  id="slm_genger" name="slm_genger" <?php echo $slm_genger0;?> value="2">女</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="slm_phone">電話</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="slm_phone" name="slm_phone" value="<?php echo $row['slm_phone'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="slm_addr">地址</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="slm_addr" name="slm_addr" value="<?php echo $row['slm_addr'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="slm_mail">電子信箱</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="slm_mail" name="slm_mail" value="<?php echo $row['slm_mail'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="slm_mail">折扣碼1</label>
							<div class="col-md-10">
							  <select name="sel_discount[]" id="sel_discount" class="form-control">
							   <option value="">-- 無 --</option>
							   <?php
								 $row_dis=$pdo_new->select("SELECT dis.Tb_index, dis.di_name, dis.di_num, sld.dis_id FROM appDiscount as dis
								                            LEFT JOIN appSal_dis as sld ON sld.dis_id=dis.Tb_index
								                            WHERE dis.OnLineOrNot=1
															ORDER BY dis.OrderBy DESC, dis.Tb_index DESC");  
								 foreach ($row_dis as $dis) {
									if(!empty($dis_id_arr[0]) && $dis_id_arr[0]==$dis['Tb_index']){
                                       echo '<option selected value="'.$dis['Tb_index'].'">'.$dis['di_name'].' (折扣:'.$dis['di_num'].')</option>';
									}
									elseif(empty($dis['dis_id'])){
									   echo '<option value="'.$dis['Tb_index'].'">'.$dis['di_name'].' (折扣:'.$dis['di_num'].')</option>';
									}
								 }
							   ?>
							  </select>
							  <input type="hidden" name="sal_dis_id[]" value="<?php echo $dis1=empty($dis_arr[0]) ? '' : $dis_arr[0];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="slm_mail">折扣碼2</label>
							<div class="col-md-10">
							  <select name="sel_discount[]" id="sel_discount" class="form-control">
							   <option value="">-- 無 --</option>
							   <?php
								 $row_dis=$pdo_new->select("SELECT dis.Tb_index, dis.di_name, dis.di_num, sld.dis_id FROM appDiscount as dis
								                            LEFT JOIN appSal_dis as sld ON sld.dis_id=dis.Tb_index
								                            WHERE dis.OnLineOrNot=1
															ORDER BY dis.OrderBy DESC, dis.Tb_index DESC");  
								 foreach ($row_dis as $dis) {
									if(!empty($dis_id_arr[1]) && $dis_id_arr[1]==$dis['Tb_index']){
                                       echo '<option selected value="'.$dis['Tb_index'].'">'.$dis['di_name'].' (折扣:'.$dis['di_num'].')</option>';
									}
									elseif(empty($dis['dis_id'])){
									   echo '<option value="'.$dis['Tb_index'].'">'.$dis['di_name'].' (折扣:'.$dis['di_num'].')</option>';
									}
								 }
							   ?>
							  </select>
							  <input type="hidden" name="sal_dis_id[]" value="<?php echo $dis1=empty($dis_arr[1]) ? '' : $dis_arr[1];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="slm_mail">折扣碼3</label>
							<div class="col-md-10">
							  <select name="sel_discount[]" id="sel_discount" class="form-control">
							   <option value="">-- 無 --</option>
							   <?php
								 $row_dis=$pdo_new->select("SELECT dis.Tb_index, dis.di_name, dis.di_num, sld.dis_id FROM appDiscount as dis
								                            LEFT JOIN appSal_dis as sld ON sld.dis_id=dis.Tb_index
								                            WHERE dis.OnLineOrNot=1
															ORDER BY dis.OrderBy DESC, dis.Tb_index DESC");  
								 foreach ($row_dis as $dis) {
									if(!empty($dis_id_arr[2]) && $dis_id_arr[2]==$dis['Tb_index']){
                                       echo '<option selected value="'.$dis['Tb_index'].'">'.$dis['di_name'].' (折扣:'.$dis['di_num'].')</option>';
									}
									elseif(empty($dis['dis_id'])){
									   echo '<option value="'.$dis['Tb_index'].'">'.$dis['di_name'].' (折扣:'.$dis['di_num'].')</option>';
									}
								 }
							   ?>
							  </select>
							  <input type="hidden" name="sal_dis_id[]" value="<?php echo $dis1=empty($dis_arr[2]) ? '' : $dis_arr[2];?>">
							</div>
						</div>


						
						<div class="form-group">
							<label class="col-md-2 control-label" for="OnLineOrNot">是否啟用</label>
							<div class="col-md-10">
								<input style="width: 20px; height: 20px;" id="OnLineOrNot" name="OnLineOrNot" type="checkbox" value="1" <?php echo $check=!isset($row['OnLineOrNot']) || $row['OnLineOrNot']==1 ? 'checked' : ''; ?>  />
							</div>
						</div>

						<input type="hidden" id="Tb_index" name="Tb_index" value="<?php echo $_GET['Tb_index'];?>">
						<input type="hidden" id="mt_id" name="mt_id" value="<?php echo $_GET['MT_id'];?>">
						<input type="hidden" id="slm_id" name="slm_id" value="<?php echo $row['slm_id'];?>">
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

			err_txt+=check_input('[name="slm_name"]','業務員名稱\n');
			err_txt+=check_input('[name="slm_genger"]','業務員性別');

			if(err_txt!=''){
               alert('請輸入\n'+err_txt);
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

