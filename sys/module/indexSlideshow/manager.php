<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
  .main_name{ width: 50px; }

  .modal-dialog{ width: 1024px; }
  .modal-body{ padding: 5rem; }
  .sk-spinner-three-bounce div{ background-color: #999; }
   #loadingIMG{ display: none; position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1000; align-items: center; justify-content: center; background: rgba(255, 255, 255, 0.9); }
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


      //---- 裁切圖片 -----
      if (!empty($_POST['cropper_img'])) {

        $img=$_POST['cropper_img'].'.jpg';
        $back_img=$Tb_index.'.jpg';
        copy('../../img/cropper/'.$img, '../../img/'.$back_img);
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


      //---- 裁切圖片 -----
      if (!empty($_POST['aPic_base64'])) {

        $back_img=$Tb_index.'.png';
        $img=$_POST['aPic_base64'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $success = file_put_contents('../../img/'.$back_img, $data);

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
  $is_use=empty($_POST['is_use']) ? 0:1;

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
		             'is_use'=>$is_use,
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


      //---- 裁切圖片 -----
      if (!empty($_POST['cropper_img'])) {
        
        $img=$_POST['cropper_img'].'.jpg';
        $back_img=$Tb_index.date('His').'.jpg';
        copy('../../img/cropper/'.$img, '../../img/'.$back_img);

        $back_img_param=['back_img'=>$back_img];
        $back_img_where=['Tb_index'=>$Tb_index];
        pdo_update('indexSlideshow', $back_img_param, $back_img_where);
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
    $is_use=empty($_POST['is_use']) ? 0:1;
    $param=array(  
    	             'aTitle'=>$_POST['aTitle'],
		       'html_content'=>$_POST['html_content'],
              'main_name'=>$main_name,
                   'aUrl'=>$_POST['aUrl'],
		          'StartDate'=>$StartDate,
                'EndDate'=>$EndDate,
                'is_main'=>$is_main,
		             'is_use'=>$is_use
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
  $StartDate=empty($row['StartDate']) ? date('Y-m-d'): date('Y-m-d', strtotime($row['StartDate']));
  $EndDate=empty($row['EndDate']) ? date('Y-m-d'): date('Y-m-d', strtotime($row['EndDate']));
}


?>

<div id="loadingIMG">
   <div>
    <h3>
      裁切中，請稍後 ...
     </h3>
     <div class="sk-spinner sk-spinner-three-bounce">
                                   <div class="sk-bounce1"></div>
                                   <div class="sk-bounce2"></div>
                                   <div class="sk-bounce3"></div>
                               </div>
   </div> 
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<header>網頁資料編輯
					</header>
				</div><!-- /.panel-heading -->
				<div class="panel-body">
					<form id="put_form" action="manager-test.php" method="POST" enctype='multipart/form-data' class="form-horizontal">
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

 
            <!-- <div class="form-group">
              <label class="col-md-2 control-label" for="aPic">背景圖檔</label>
              <div class="col-md-10">
                <input type="file"  class="form-control" accept=".jpg" id="cropper_img" >
                <span class="text-danger">圖片規格(1364*900) 圖片比例盡量維持正方形</span>
              </div>
            </div> -->


            <!-- 裁切彈出視窗 -->
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">裁切圖片</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="img-container">
                      <img id="image" src="">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-default rotate-left"><span class="fa fa-rotate-left"></span></button>
                    <button type="button" class="btn btn-default rotate-right"><span class="fa fa-rotate-right"></span></button> -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="crop">裁切</button>
                    <input type="hidden" name="cropper_img">
                  </div>
                </div>
              </div>
            </div>


						<div class="form-group">
							<label class="col-md-2 control-label" for="back_img">背景圖檔</label>
							<div class="col-md-10">
								<input type="file" name="back_img" class="form-control" id="back_img" onchange="file_viewer_load_new(this, '#img_box')">
                <span class="text-danger">圖片規格(1364*900) 圖片比例盡量維持正方形</span>
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
                <input type="date" class="form-control" id="StartDate" name="StartDate" value="<?php echo $StartDate;?>">
              </div>

              <label class="col-md-2 control-label" for="EndDate">結束日期</label>
              <div class="col-md-4">
                <input type="date" class="form-control" id="EndDate" name="EndDate" value="<?php echo $EndDate;?>">
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



   //-- 選擇圖檔 --
     $('#cropper_img').change(function(event) {

               var files = event.target.files;
               var reader;
               var file;
               var url;
               var done = function (url) {
                 $('#cropper_img').val('');
                 $('#image').attr('src', url);
                 $('#modal').modal('show');
               };

               if (files && files.length > 0) {
                 file = files[0];

                 if (URL) {
                   done(URL.createObjectURL(file));
                 } else if (FileReader) {
                   reader = new FileReader();
                   reader.onload = function (e) {
                     done(reader.result);
                   };
                   reader.readAsDataURL(file);
                 }
               }
     });
           
           //-- 開啟裁切視窗 --
     $('#modal').on('shown.bs.modal', function () {
       cropper = new Cropper(image, {
         aspectRatio: 1920/1266,
         viewMode: 2,
         autoCropArea: 1,
       });
     }).on('hidden.bs.modal', function () {
       cropper.destroy();
       cropper = null;
     });

           
      //-- 裁切BTN --
      $('#crop').click(function(event) {
        var initialAvatarURL;
        var canvas;

        $('#modal').modal('hide');
        
        canvas = cropper.getCroppedCanvas({
          imageSmoothingQuality:"high"
        });

        canvas.toBlob(function (blob) {
            var formData = new FormData();

            formData.append('img', blob);
           
            $.ajax('img_ajax.php', {
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,

              // xhr: function () {
              //   var xhr = new XMLHttpRequest();

              //   xhr.upload.onprogress = function (e) {
              //     var percent = '0';
              //     var percentage = '0%';

              //     if (e.lengthComputable) {
              //       percent = Math.round((e.loaded / e.total) * 100);
              //       percentage = percent + '%';
              //       $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
              //     }
              //   };

              //   return xhr;
              // },

              success: function (data) {
                $('[name="cropper_img"]').val(data);
                console.log(data);
                //$alert.show().addClass('alert-success').text('Upload success');
              },
              beforeSend:function(){
                    $('#loadingIMG').css('display', 'flex');
              },
              complete:function(){
                    $('#loadingIMG').hide();
              }
            });
          });

        var img_html='<div id="img_div" ><img id="one_img" src="'+canvas.toDataURL()+'"></div>';
        $('#img_box').html(img_html);
      });


     $('.rotate-left').click(function(event) {
       cropper.rotate(-90);
     });

     $('.rotate-right').click(function(event) {
       cropper.rotate(90);
     });





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

