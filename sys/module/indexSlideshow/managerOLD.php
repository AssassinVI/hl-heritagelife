<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
  .main_name{ width: 50px; }
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {


  // ======================== 刪除 ===========================
  	//----------------------- 代表圖刪除 -------------------------------
    if (!empty($_POST['type']) && $_POST['type']=='delete') { 
    	if (!empty($_POST['back_img'])) {
    		$param=array('back_img'=>'');
            $where=array('Tb_index'=>$_POST['Tb_index']);
            pdo_update('indexSlideshow', $param, $where);

            unlink('../../img/'.$_POST['back_img']);
    	}
      else{
        $param=array('main_icon'=>'');
            $where=array('Tb_index'=>$_POST['Tb_index']);
            pdo_update('indexSlideshow', $param, $where);

            unlink('../../img/'.$_POST['main_icon']);
      }
    	/*else{
        //----------------------- 多檔刪除 -------------------------------
    		$sel_where=array('Tb_index'=>$_POST['Tb_index']);
    		$otr_file=pdo_select('SELECT OtherFile FROM appArticle WHERE Tb_index=:Tb_index', $sel_where);
    		$otr_file=explode(',', $otr_file['OtherFile']);

    		for ($i=0; $i <count($otr_file)-1 ; $i++) { //比對 
    			 if ($otr_file[$i]!=$_POST['OtherFile']) {
    			 	$new_file.=$otr_file[$i].',';
    			 }else{
    			 	 unlink('../../other_file/'.$_POST['OtherFile']);
    			 }
    		}
    		$param=array('OtherFile'=>$new_file);
            $where=array('Tb_index'=>$_POST['Tb_index']);
            pdo_update('appArticle', $param, $where);

    	}*/

       exit();
  	}


	if (empty($_POST['Tb_index'])) {//新增

		$Tb_index='inSS'.date('YmdHis').rand(0,99);
     
     //===================== 背景圖 ========================
      if (!empty($_FILES['back_img']['name'])){

      	if (test_img($_FILES['back_img']['name'])){
      		 $type=explode('.', $_FILES['back_img']['name']);
      		 $back_img=$Tb_index.'.'.$type[count($type)-1];
      		// fire_upload('back_img', $back_img);

           ecstart_convert_jpeg($_FILES['back_img']['tmp_name'], '../../img/'.$back_img, 'N','N','N','N',1920);
      	}else{
      		location_up('admin.php?MT_id='.$_POST['mt_id'],'圖檔錯誤!請上傳圖片檔');
      		exit();
      	}
      	 
         
      }else{
      	 $back_img='';
      }


    //===================== ICON圖 ========================
      if (!empty($_FILES['main_icon']['name'])){

        if (test_img($_FILES['main_icon']['name'])){
           $type=explode('.', $_FILES['main_icon']['name']);
           $main_icon=$Tb_index.'.'.$type[count($type)-1];
           fire_upload('main_icon', $main_icon);
        }else{
          location_up('admin.php?MT_id='.$_POST['mt_id'],'圖檔錯誤!請上傳圖片檔');
          exit();
        }
         
         
      }else{
         $main_icon='';
      }


     //===================== 多圖檔 ========================
      /*if (!empty($_FILES['OtherFile']['name'][0])){
        for ($i=0; $i <count($_FILES['OtherFile']['name']) ; $i++) { 
        	
         $type=explode('.', $_FILES['OtherFile']['name'][$i]);
      	 $OtherFile.=$Tb_index.'_other_'.$i.'.'.$type[1].',';
         more_other_upload('OtherFile', $i, $Tb_index.'_other_'.$i.'.'.$type[1]);
        }
      }*/
  
  $StartDate=empty($_POST['StartDate']) ? date('Y-m-d H:i:s'):$_POST['StartDate'];
  $EndDate=empty($_POST['EndDate']) ? date('Y-m-d H:i:s'):$_POST['EndDate'];
  $main_name=implode(',', $_POST['main_name']);
  $is_main=empty($_POST['is_main']) ? 0:1;

	$param=array(  'Tb_index'=>$Tb_index,
                  'mt_id'=>$_POST['mt_id'],
		             'aTitle'=>$_POST['aTitle'],
		           'back_img'=>$back_img,
               'main_icon'=>$main_icon,
		       'html_content'=>$_POST['html_content'],
              'main_name'=>$main_name,
                   'aUrl'=>$_POST['aUrl'],
		          'StartDate'=>$StartDate,
                'EndDate'=>$EndDate,
                'is_main'=>$is_main,
		             'is_use'=>$_POST['is_use'],
		            'webLang'=>$weblang
		          );
	pdo_insert('indexSlideshow', $param);
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }
   else{  //修改

   	$Tb_index =$_POST['Tb_index'];
    

    //------------------------ 背景圖 -------------------------
      if (!empty($_FILES['back_img']['name'])) {

      	if (test_img($_FILES['back_img']['name'])){
      			 $type=explode('.', $_FILES['back_img']['name']);
      			 $back_img=$Tb_index.date('His').'.'.$type[count($type)-1];
      		   //fire_upload('back_img', $back_img);
             ecstart_convert_jpeg($_FILES['back_img']['tmp_name'], '../../img/'.$back_img, 'N','N','N','N',1920);

      		  $back_img_param=array('back_img'=>$back_img);
      		  $back_img_where=array('Tb_index'=>$Tb_index);
      		  pdo_update('indexSlideshow', $back_img_param, $back_img_where);
      	}else{
           location_up('admin.php?MT_id='.$_POST['mt_id'],'圖檔錯誤!請上傳圖片檔');
           exit();
      	}
      }


    //------------------------ ICON圖 -------------------------
      if (!empty($_FILES['main_icon']['name'])) {

        if (test_img($_FILES['main_icon']['name'])){
             $type=explode('.', $_FILES['main_icon']['name']);
             $main_icon=$Tb_index.date('His').'.'.$type[count($type)-1];
             fire_upload('main_icon', $main_icon);

            $main_icon_param=array('main_icon'=>$main_icon);
            $main_icon_where=array('Tb_index'=>$Tb_index);
            pdo_update('indexSlideshow', $main_icon_param, $main_icon_where);
        }else{
           location_up('admin.php?MT_id='.$_POST['mt_id'],'圖檔錯誤!請上傳圖片檔');
           exit();
        }
      }


      //-------------------- 多檔上傳 ------------------------------
     /* if (!empty($_FILES['OtherFile']['name'][0])) {

      	$sel_where=array('Tb_index'=>$Tb_index);
      	$now_file =pdo_select("SELECT OtherFile FROM appArticle WHERE Tb_index=:Tb_index", $sel_where);
      	if (!empty($now_file['OtherFile'])) {
      	   $sel_file=explode(',', $now_file['OtherFile']);
           $file_num=explode('_', $sel_file[count($sel_file)-2]);
           $file_num=explode('.', $file_num[2]);
           $file_num=(int)$file_num[0]+1;
      	}else{
      	   $file_num=0;
      	}

      	for ($i=0; $i <count($_FILES['OtherFile']['name']) ; $i++) { 
      	 $type=explode('.', $_FILES['OtherFile']['name'][$i]);
      	 $OtherFile.=$Tb_index.'_other_'.($file_num+$i).'.'.$type[1].',';
         more_other_upload('OtherFile', $i, $Tb_index.'_other_'.($file_num+$i).'.'.$type[1]);
      	}

      	$OtherFile=$now_file['OtherFile'].$OtherFile;
      	 
        $OtherFile_param=array('OtherFile'=>$OtherFile);
        $OtherFile_where=array('Tb_index'=>$Tb_index);
        pdo_update('appArticle', $OtherFile_param, $OtherFile_where);
      }*/
      	//--------------------------- END -----------------------------------
    $StartDate=empty($_POST['StartDate']) ? date('Y-m-d H:i:s'):$_POST['StartDate'];
    $EndDate=empty($_POST['EndDate']) ? date('Y-m-d H:i:s'):$_POST['EndDate'];
    $main_name=implode(',', $_POST['main_name']);
    $is_main=empty($_POST['is_main']) ? 0:1;
    $param=array(  
    	             'aTitle'=>$_POST['aTitle'],
		       'html_content'=>$_POST['html_content'],
              'main_name'=>$main_name,
                   'aUrl'=>$_POST['aUrl'],
		          'StartDate'=>$StartDate,
                'EndDate'=>$EndDate,
                'is_main'=>$is_main,
		             'is_use'=>$_POST['is_use']
		          );
    $where=array( 'Tb_index'=>$Tb_index );
	pdo_update('indexSlideshow', $param, $where);
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}

if ($_GET) {
 	$where=array('Tb_index'=>$_GET['Tb_index']);
 	$row=pdo_select('SELECT * FROM indexSlideshow WHERE Tb_index=:Tb_index', $where);

  $main_name=explode(',', $row['main_name']);
  $StartDate=empty($row['StartDate']) ? date('Y-m-d\TH:i'): date('Y-m-d\TH:i', strtotime($row['StartDate']));
  $EndDate=empty($row['EndDate']) ? date('Y-m-d\TH:i'): date('Y-m-d\TH:i', strtotime($row['EndDate']));
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
							<label class="col-md-2 control-label" for="aTitle">標題</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="aTitle" name="aTitle" value="<?php echo $row['aTitle'];?>">
							</div>
						</div>

            <div class="form-group">
              <label class="col-md-2 control-label" for="ckeditor">詳細內容</label>
              <div class="col-md-10">
                <textarea name="html_content" class="form-control" placeholder="詳細內容"><?php echo $row['html_content'];?></textarea>
              </div>
            </div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="back_img">背景圖檔</label>
							<div class="col-md-10">
								<input type="file" name="back_img" class="form-control" id="back_img" onchange="file_viewer_load_new(this, '#img_box')">
                <span class="text-danger">圖片規格(1426*900) 圖片比例盡量維持正方形</span>
							</div>
						</div>

						<div class="form-group">
						   <label class="col-md-2 control-label" ></label>
						   <div id="img_box" class="col-md-4">
								
							</div>
						<?php if(!empty($row['back_img'])){?>
							<div  class="col-md-4">
							   <div id="img_div" >
							    <p>目前圖檔</p>
								 <button type="button" id="one_del_img"> X </button>
								  <span class="img_check"><i class="fa fa-check"></i></span>
								  <img id="one_img" src="../../img/<?php echo $row['back_img'];?>" alt="請上傳代表圖檔">
								</div>
							</div>
						<?php }?>		
						</div>

            <div class="form-group">
               <label class="col-md-2 control-label" for="is_main">使用主題</label>
               <div class="col-md-2">
                  <input style="width: 20px; height: 20px;" type="checkbox" id="is_main" name="is_main" value="1" <?php echo $check=!isset($row['is_main']) || $row['is_main']==1 ? 'checked' : ''; ?>  >
               </div>
            </div>

            <div class="form-group">
              <label class="col-md-2 control-label" for="main_name">主題名稱</label>
              <div class="col-md-4">
                <input type="text"  class="main_name" name="main_name[]" maxlength="1" value="<?php echo $main_name[0];?>">
                <input type="text"  class="main_name" name="main_name[]" maxlength="1" value="<?php echo $main_name[1];?>">
                <input type="text"  class="main_name" name="main_name[]" maxlength="1" value="<?php echo $main_name[2];?>">
                <input type="text"  class="main_name" name="main_name[]" maxlength="1" value="<?php echo $main_name[3];?>">
                <br>
                <span class="text-danger">請填齊4個字，會有較佳顯示結果</span>
              </div>
             
            </div>

            <div class="form-group">
              <label class="col-md-2 control-label" for="main_icon">主題Icon</label>
              <div class="col-md-10">
                <input type="file" name="main_icon" class="form-control" id="main_icon" onchange="file_viewer_load_new(this, '#img_box2')">
              </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label" ></label>
               <div id="img_box2" class="col-md-4">
                
              </div>
            <?php if(!empty($row['main_icon'])){?>
              <div  class="col-md-4">
                 <div id="img_div" class="icon_div" >
                  <p>目前圖檔</p>
                 <button type="button" id="one_del_icon" class="one_del_file"> X </button>
                  <span class="img_check"><i class="fa fa-check"></i></span>
                  <img id="one_img" src="../../img/<?php echo $row['main_icon'];?>" alt="請上傳代表圖檔">
                </div>
              </div>
            <?php }?>   
            </div>


            <div class="form-group">
              <label class="col-md-2 control-label" for="aUrl">連結</label>
              <div class="col-md-10">
                <input type="text" class="form-control" id="aUrl" name="aUrl" value="<?php echo $row['aUrl'];?>">
                 <span class="text-danger">也可輸入youtube網址</span>
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-2 control-label" for="StartDate">開始日期</label>
              <div class="col-md-4">
                <input type="datetime-local" class="form-control" id="StartDate" name="StartDate" value="<?php echo $StartDate;?>">
              </div>

              <label class="col-md-2 control-label" for="EndDate">結束日期</label>
              <div class="col-md-4">
                <input type="datetime-local" class="form-control" id="EndDate" name="EndDate" value="<?php echo $EndDate;?>">
              </div>
              
            </div>
						

						<div class="form-group">
							<label class="col-md-2 control-label" for="is_use">是否上線</label>
							<div class="col-md-10">
								<input style="width: 20px; height: 20px;" id="is_use" name="is_use" type="checkbox" value="1" <?php echo $check=!isset($row['is_use']) || $row['is_use']==1 ? 'checked' : ''; ?>  />
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
                        back_img: '<?php echo $row["back_img"]?>',
                            type: 'delete'
			          };	
               ajax_in('manager.php', data, '成功刪除', 'no');
               $("#img_div").html('');
			}
		});


   //------------------------------ 刪ICON ---------------------------------
         $("#one_del_icon").click(function(event) { 
      if (confirm('是否要刪除Icon?')) {
       var data={
                Tb_index: $("#Tb_index").val(),
                main_icon: '<?php echo $row["main_icon"]?>',
                type: 'delete'
                };  
               ajax_in('manager.php', data, '成功刪除', 'no');
               $(".icon_div").html('');
      }
    });


      //------------------------------ 刪檔 ---------------------------------
         /* $(".one_del_file").click(function(event) { 
			if (confirm('是否要刪除檔案?')) {
			 var data={
			 	        Tb_index: $("#Tb_index").val(),
                       OtherFile: $(this).next().next().val(),
                            type: 'delete'
			          };	
               ajax_in('manager.php', data, '成功刪除', 'no');
               $(this).parent().html('');
			}
		});*/

      });
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>

