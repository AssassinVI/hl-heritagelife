<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {

    if (!empty($_POST['type']) && $_POST['type']=='delete') { //刪除
    	if (!empty($_POST['aPic'])) {
    		$param=array('aPic'=>'');
            $where=array('Tb_index'=>$_POST['Tb_index']);
            pdo_update('appBrand_url', $param, $where);

            unlink('../../img/'.$_POST['aPic']);
    	}
    	else{
        //----------------------- 多檔刪除 -------------------------------
            $sel_where=array('Tb_index'=>$_POST['Tb_index']);
    		$otr_file=pdo_select('SELECT OtherFile FROM appBrand_url WHERE Tb_index=:Tb_index', $sel_where);
    
               $otr_file_one=explode(',', $otr_file['OtherFile']);

    			for ($j=0; $j <count($otr_file_one)-1 ; $j++) { 

    				if ($otr_file_one[$j]!=$_POST['OtherFile']) {
    			 	  $new_file_one.=$otr_file_one[$j].',';
    			    }else{
    			 	  unlink('../../img/'.$_POST['OtherFile']);
    			    }
    			}
    			
    		$param=array('OtherFile'=>$new_file_one);
            $where=array('Tb_index'=>$_POST['Tb_index']);
            pdo_update('appBrand_url', $param, $where);
    		
    	}

       exit();
  	}


	if (empty($_POST['Tb_index'])) {//新增

		$Tb_index='brandu'.date('YmdHis').rand(0,99);
        $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0: 1 ;

   //----------------------- 檔案判斷 -------------------------
      if (!empty($_FILES['aPic']['name'])) {

      	if (test_img($_FILES['aPic']['name'])){
      		 $type=explode('.', $_FILES['aPic']['name']);
      		 $aPic=$Tb_index.'.'.$type[count($type)-1];
      		 //fire_upload('aPic', $aPic);
      		 ecstart_convert_jpeg($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 'N','N','N','N',1280);
      	}else{
      		location_up('admin.php?MT_id='.$_POST['mt_id'],'圖檔錯誤!請上傳圖片檔');
      		exit();
      	}
      	 
      }else{ $aPic=''; }


      //------------------- 多檔上傳(批次) -------------------
      $OtherFile_more_arr=[];

      	if(!empty($_FILES['OtherFile_more'.$i]['name'][0])){

      	         for ($j=0; $j <count($_FILES['OtherFile_more'.$i]['name']) ; $j++) { 
      	           $type=explode('.', $_FILES['OtherFile_more'.$i]['name'][$j]);
      	           $OtherFile.=$Tb_index.'_others_'.$j.'.'.$type[count($type)-1].',';

      	          // more_fire_upload('OtherFile_more'.$i, $j, $Tb_index.'_others_'.$i.$j.'.'.$type[count($type)-1]);
      	           ecstart_convert_jpeg($_FILES['OtherFile_more']['tmp_name'][$j], '../../img/'.$Tb_index.'_others_'.$j.'.'.$type[count($type)-1], 'N','N','N','N',1700);
      	        }
      	 }
         else{
           $OtherFile='';
         }

      

	$param=array(  'Tb_index'=>$Tb_index,
		              'mt_id'=>$_POST['mt_id'],
					 'aTitle'=>$_POST['aTitle'],
			      'aAbstract'=>$_POST['aAbstract'],
		               'aPic'=>$aPic,
		               'aUrl'=>$_POST['aUrl'],
		          'StartDate'=>date('Y-m-d H:i:s'),
		        'OnLineOrNot'=>$OnLineOrNot
		          );
	pdo_insert('appBrand_url', $param);
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }
   else{  //修改

   	$Tb_index =$_POST['Tb_index'];


     //----------------------- 檔案判斷 -------------------------
      if (!empty($_FILES['aPic']['name'])) {

      	if (test_img($_FILES['aPic']['name'])){
      			$type=explode('.', $_FILES['aPic']['name']);
      			$aPic=$Tb_index.'-'.date("His").'.'.$type[count($type)-1];
      		   //fire_upload('aPic', $aPic);
      		   ecstart_convert_jpeg($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 'N','N','N','N',1280);

      		  $aPic_param=array('aPic'=>$aPic);
      		  $aPic_where=array('Tb_index'=>$Tb_index);
      		  pdo_update('appBrand_url', $aPic_param, $aPic_where);
      	}else{
      		location_up('admin.php?MT_id='.$_POST['mt_id'],'圖檔錯誤!請上傳圖片檔');
      		exit();
      	}
      	 
      }


      //-------------------- 多檔上傳(批次) -----------------------

      $sel_where=array('Tb_index'=>$Tb_index);
      $now_file =pdo_select("SELECT OtherFile FROM appBrand_url WHERE Tb_index=:Tb_index", $sel_where);

      	if (!empty($now_file['OtherFile'])) {
      	       $sel_file=explode(',', $$now_file['OtherFile']);
      	       $file_num=explode('_', $sel_file[count($sel_file)-2]);
      	       $file_num=explode('.', $file_num[2]);
      	       $file_num=(int)$file_num[0]+1;
      	       
      	    }else{
      	       $file_num=0;
      	    }

                $OtherFile='';
      	        for ($k=0; $k <count($_POST['old_file']) ; $k++) { 

      	        	  if(empty($_POST['old_file'][$k])){
                      $OtherFile.=',';
                    }
      	          	else{
      	          		$OtherFile.=$_POST['old_file'][$k].',';
      	          	}
      	        } 

                if (!empty($_FILES['OtherFile_more']['name'][0])) {

                  for ($i=0; $i <count($_FILES['OtherFile_more']['name']) ; $i++) { 

                    $type=explode('.', $_FILES['OtherFile_more']['name'][$i]);
                        $OtherFile.=$Tb_index.date('His').'_other_'.($file_num+$i).'.'.$type[count($type)-1].',';
                        //more_fire_upload('OtherFile_more', $j, $Tb_index.date('His').'_other_'.($num_arr[$i]+$j).'.'.$type[count($type)-1]);
                        ecstart_convert_jpeg($_FILES['OtherFile_more']['tmp_name'][$i], '../../img/'.$Tb_index.date('His').'_other_'.($file_num+$i).'.'.$type[count($type)-1], 'N','N','N','N',1700);
                  }
                }
                $OtherFile_param=array('OtherFile'=>$OtherFile);
                $OtherFile_where=array('Tb_index'=>$Tb_index);
                pdo_update('appBrand_url', $OtherFile_param, $OtherFile_where);

      	//--------------------------- 多檔上傳END -----------------------------------

      $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0: 1 ;
    
    $param=array(  
					 'aTitle'=>$_POST['aTitle'],
				  'aAbstract'=>$_POST['aAbstract'],
		               'aUrl'=>$_POST['aUrl'],
		        'OnLineOrNot'=>$OnLineOrNot
		          );
    $where=array( 'Tb_index'=>$Tb_index );
	pdo_update('appBrand_url', $param, $where);
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}

if ($_GET) {
 	$where=array('Tb_index'=>$_GET['Tb_index']);
 	$row=pdo_select('SELECT * FROM appBrand_url WHERE Tb_index=:Tb_index', $where);
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
							<label class="col-md-2 control-label" for="aTitle">品牌名稱</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="aTitle" name="aTitle" value="<?php echo $row['aTitle'];?>">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label" for="aAbstract">摘要</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="aAbstract" name="aAbstract" value="<?php echo $row['aAbstract'];?>">
							</div>
						</div>

						
						<div class="form-group">
							<label class="col-md-2 control-label" for="aPic">品牌圖檔</label>
							<div class="col-md-10">
								<input type="file" name="aPic" class="form-control" id="aPic" accept=".jpg" onchange="file_viewer_load_new(this, '#img_box')">
								<span class="text-danger">圖片尺寸:1280*1280</span>
							</div>
						</div>

						<div class="form-group">
						   <label class="col-md-2 control-label" ></label>
						   <div id="img_box" class="col-md-4">
								
							</div>
						<?php if(!empty($row['aPic'])){?>
							<div  class="col-md-4">
							   <div id="img_div" >
							    <p>目前圖檔</p>
								 <button type="button" id="one_del_img"> X </button>
								  <span class="img_check"><i class="fa fa-check"></i></span>
								  <img id="one_img" src="../../img/<?php echo $row['aPic'];?>" alt="請上傳代表圖檔">
								</div>
							</div>
						<?php }?>		
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="aUrl">連結</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="aUrl" name="aUrl" value="<?php echo $row['aUrl'];?>">
							</div>
							
						</div>


						<!-- <div class="form-group">
							<label class="col-md-2 control-label" for="OtherFile_more">輪播圖檔</label>
							<div class="col-md-10">
								<input type="file" multiple name="OtherFile_more[]" class="form-control" id="OtherFile_more" accept=".jpg" onchange="file_viewer_load_new(this, '#img_box_other')">
								<span class="help-block m-b-none">可批次上傳多個檔，存檔後可拖曳變更排序</span>
								<span class="text-danger">圖片尺寸:1280*850</span>
							</div>
						</div> -->


                        <div class="form-group">
                           <label class="col-md-2 control-label" ></label>
                           <div id="img_box_other" class="col-md-4">
                          </div>
                        </div>
						

						<div class="form-group">
						  <label class="col-md-2 control-label" ></label>
						    <div class="col-md-10">
						      <ul class="sortable-list connectList agile-list ui-sortable OtherFile_div" >


						                 <?php if(!empty($row['OtherFile'])){
						                      $otherFile=explode(',', $row['OtherFile']);
						                       for ($j=0; $j <count($otherFile)-1 ; $j++) { 
						                         $other_txt='<li class="oneFile_div">
						                                       <div class="">
						                                         <button type="button" class="btn btn-danger one_del_div">x</button>
						                                       </div>
						                                       <div class="old_file" style="background: url(../../img/'.$otherFile[$j].') center; background-size: cover;"><p>目前圖檔</p> </div>
						                                       <input type="hidden" name="old_file[]" value="'.$otherFile[$j].'">
						                                     </li>';
						                                     echo $other_txt;
						                                  }
						                              
						                               }
						                 ?>
						        
						      </ul>
						    </div>
						</div>

						
						<!-- <div class="form-group">
							<label class="col-md-2 control-label" for="ckeditor">品牌介紹</label>
							<div class="col-md-10">
								<textarea id="ckeditor" name="aTXT" ><?php //echo $row['aTXT'];?></textarea>
							</div>
						</div> -->

						<!--<div class="form-group">
							<label class="col-md-2 control-label" for="aUrl">相關連結</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="aUrl" name="aUrl" value="<?php //echo $row['aUrl'];?>">
							</div>
						</div>-->

					

						<!-- <div class="form-group">
							<label class="col-md-2 control-label" for="StartDate">上線日期</label>
							<div class="col-md-10">
								<input type="date" class="form-control" id="StartDate" name="StartDate" value="<?php //echo $row['StartDate'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="EndDate">下線日期</label>
							<div class="col-md-10">
								<input type="date" class="form-control" id="EndDate" name="EndDate" value="<?php //echo $row['EndDate'];?>">
							</div>
						</div> -->

						
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


     //------------------------ 多檔刪除 ----------------------------
      $('.OtherFile_div').on('click', '.one_del_div', function(event) {
        event.preventDefault();

        if (confirm('是否要刪除檔案?')){
        
          if ($(this).parent().next().next().length>0) {
             $.ajax({
             url: 'manager.php',
             type: 'POST',
             data: {
               Tb_index: $("#Tb_index").val(),
               OtherFile: $(this).parent().next().next().val(),
               type: 'delete'
             }

            });
          }
        $(this).parent().parent().remove();
      }
      });


     // --------------------- 拖曳多圖檔 -------------------------
          $(".OtherFile_div").sortable({
            connectWith: ".connectList",
            update: function( event, ui ) {

                 var OtherFile_arr = $( ".OtherFile_div" ).sortable( "toArray" );
            }
         }).disableSelection();
      });
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>

