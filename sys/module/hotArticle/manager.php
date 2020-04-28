<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
	.oneFile_div{ float: left; position: relative; margin: 5px; border: 1px solid #ccc; }
	.one_del_div{ position: absolute; top: 0; right: 0; }
	.other_div{ float: left; }
	.old_file{ width: 150px; height: 150px; float: left;}
	.old_file p{ text-align: center; background: #ccc; }

	.recommend_div{  overflow: auto; max-height: 300px; }
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {
  // ======================== 刪除 ===========================
  	//----------------------- 代表圖刪除 -------------------------------
    if (!empty($_POST['type']) && $_POST['type']=='delete') { 
    	if (!empty($_POST['aPic'])) {
    		$param=['aPic'=>''];
            $where=['Tb_index'=>$_POST['Tb_index']];
            pdo_update('appArticle', $param, $where);
            unlink('../../img/'.$_POST['aPic']);
    	}else{
        //----------------------- 多檔刪除 -------------------------------
            $sel_where=array('Tb_index'=>$_POST['Tb_index']);
    		$otr_file=pdo_select('SELECT OtherFile FROM appArticle WHERE Tb_index=:Tb_index', $sel_where);
    
      

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
            pdo_update('appArticle', $param, $where);
    		
    	}
       exit();
  	}

  	//----------------------------------- 新增 ---------------------------------------------------

	if (empty($_POST['Tb_index'])) {
		$Tb_index='article'.date('YmdHis').rand(0,99);
     
     //===================== 代表圖 ========================
      if (!empty($_FILES['aPic']['name'])){

      	 $type=explode('.', $_FILES['aPic']['name']);
      	 $aPic=$Tb_index.'.'.$type[count($type)-1];
        // fire_upload('aPic', $aPic);
         ecstart_convert_jpeg($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 'N','N','N','N',1280);

      }
     //===================== 多圖檔 ========================
      // if (!empty($_FILES['OtherFile']['name'][0])){

      //   for ($i=0; $i <count($_FILES['OtherFile']['name']) ; $i++) { 
        	
      //    $type=explode('.', $_FILES['OtherFile']['name'][$i]);
      // 	 $OtherFile.=$Tb_index.'_other_'.$i.'.'.$type[count($type)-1].',';
      //    more_fire_upload('OtherFile', $i, $Tb_index.'_other_'.$i.'.'.$type[count($type)-1]);
      //   }
      // }

    //------------------- 多檔上傳(批次) -------------------
      $OtherFile_more_arr=[];

      	if(!empty($_FILES['OtherFile_more'.$i]['name'][0])){

      	         for ($j=0; $j <count($_FILES['OtherFile_more'.$i]['name']) ; $j++) { 
      	           $type=explode('.', $_FILES['OtherFile_more'.$i]['name'][$j]);
      	           $OtherFile.=$Tb_index.'_others_'.$j.'.'.$type[count($type)-1].',';

      	          // more_fire_upload('OtherFile_more'.$i, $j, $Tb_index.'_others_'.$i.$j.'.'.$type[count($type)-1]);
      	           ecstart_convert_jpeg($_FILES['OtherFile_more']['tmp_name'][$j], '../../img/'.$Tb_index.'_others_'.$j.'.'.$type[count($type)-1], 'N','N','N','N',1280);
      	        }
      	 }
         else{
           $OtherFile='';
         }
      
    
      
     $HotArt=empty($_POST['HotArt']) ? 0:1;
     $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
     $StartDate=empty($_POST['StartDate']) ? date('Y-m-d H:i:s'):$_POST['StartDate'];

    $label=implode(',', $_POST['label']);
    $recommend_art=implode('||', $_POST['recommend_art']);
    
	$param=  ['Tb_index'=>$Tb_index,
			              'mt_id'=>$_POST['mt_id'],
			             'aTitle'=>$_POST['aTitle'],
			         'SmallTitle'=>$_POST['SmallTitle'],
			             'aPoster'=>$_POST['aPoster'],
			          'aAbstract'=>$_POST['aAbstract'],
			               'aPic'=>$aPic,
			          'OtherFile'=>$OtherFile,
			               'aTXT'=>$_POST['aTXT'],
			         'YoutubeUrl'=>$_POST['YoutubeUrl'],
			              'label'=>$label,
			      'recommend_art'=>$recommend_art,
			          'StartDate'=>$StartDate,
			         'UpdateDate'=>date('Y-m-d'),
			             'HotArt'=>$HotArt,
			        'OnLineOrNot'=>$OnLineOrNot,
			            'webLang'=>$weblang
			         ];
	pdo_insert('appArticle', $param);
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }

   //-------------------------------------------- 修改 -----------------------------------------------------
   else{  
   	$Tb_index =$_POST['Tb_index'];

   	 //===================== 代表圖 ========================
      if (!empty($_FILES['aPic']['name'])) {

      	 $type=explode('.', $_FILES['aPic']['name']);
      	 $aPic=$Tb_index.date('His').'.'.$type[count($type)-1];
         //fire_upload('aPic', $aPic);
         ecstart_convert_jpeg($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 'N','N','N','N',1280);
        $aPic_param=['aPic'=>$aPic];
        $aPic_where=['Tb_index'=>$Tb_index];
        pdo_update('appArticle', $aPic_param, $aPic_where);

      }

      	
       //-------------------- 多檔上傳(批次) -----------------------

    $sel_where=array('Tb_index'=>$Tb_index);
    $now_file =pdo_select("SELECT OtherFile FROM appArticle WHERE Tb_index=:Tb_index", $sel_where);

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
                      ecstart_convert_jpeg($_FILES['OtherFile_more']['tmp_name'][$i], '../../img/'.$Tb_index.date('His').'_other_'.($file_num+$i).'.'.$type[count($type)-1], 'N','N','N','N',1280);
                }
                      
              }

    $OtherFile_param=array('OtherFile'=>$OtherFile);
    $OtherFile_where=array('Tb_index'=>$Tb_index);
    pdo_update('appArticle', $OtherFile_param, $OtherFile_where);
      

      //------------------------------------------------------------------------------------------

    $HotArt=empty($_POST['HotArt']) ? 0:1;
    $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
    $label=implode(',', $_POST['label']);
    $recommend_art=implode('||', $_POST['recommend_art']);
    $StartDate=empty($_POST['StartDate']) ? date('Y-m-d H:i:s'):$_POST['StartDate'];
    $param=[  
		              'mt_id'=>$_POST['mt_id'],
    	             'aTitle'=>$_POST['aTitle'],
    	         'SmallTitle'=>$_POST['SmallTitle'],
    	             'aPoster'=>$_POST['aPoster'],
		          'aAbstract'=>$_POST['aAbstract'],
		               'aTXT'=>$_POST['aTXT'],
		         'YoutubeUrl'=>$_POST['YoutubeUrl'],
		             'label'=>$label,
		     'recommend_art'=>$recommend_art,
		         'StartDate'=>$StartDate,
		            'HotArt'=>$HotArt,
		        'OnLineOrNot'=>$OnLineOrNot
		          ];
    $where= ['Tb_index'=>$Tb_index] ;
	pdo_update('appArticle', $param, $where);
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}
if ($_GET) {
 	$where=['Tb_index'=>$_GET['Tb_index']];
 	$row=pdo_select('SELECT * FROM appArticle WHERE Tb_index=:Tb_index', $where);

 	$label=explode(',', $row['label']);
 	$recommend_art=explode('||', $row['recommend_art']);

 	$aTXT=explode('||', $row['aTXT']);
 	$OtherFile=explode('||', $row['OtherFile']);
    $StartDate=empty($row['StartDate']) ? date('Y-m-d\TH:i'): date('Y-m-d\TH:i', strtotime($row['StartDate']));
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
							<label class="col-md-2 control-label" for="aTitle">標題名稱</label>
							<div class="col-md-10">
								<textarea class="form-control" id="aTitle" name="aTitle"><?php echo $row['aTitle'];?></textarea>
							</div>
						</div>

						
						<div  class="form-group">
							<label class="col-md-2 control-label" for="SmallTitle">前言</label>
							<div class="col-md-10">
								<input type="text" id="SmallTitle" name="SmallTitle" class="form-control" value="<?php echo $row['SmallTitle'];?>">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label" for="aPoster">內容編輯資訊</label>
							<div class="col-md-10">
								<textarea class="form-control" id="aPoster" name="aPoster"><?php echo $row['aPoster'];?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="StartDate">日期</label>
							<div class="col-md-4">
								<input type="datetime-local" class="form-control" id="StartDate" name="StartDate" value="<?php echo $StartDate;?>">
							</div>

							<label class="col-md-2 control-label" for="HotArt">首頁文章</label>
							<div class="col-md-4">
								<input style="width: 20px; height: 20px;" id="HotArt" name="HotArt" type="checkbox" value="1" <?php echo $check=$row['HotArt']==1 ? 'checked' : ''; ?>  /> <br>
								<span class="text-danger">最多12篇</span>
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label" for="aPic">代表圖檔</label>
							<div class="col-md-10">
								<input type="file" name="aPic" class="form-control" accept=".jpg" id="aPic" onchange="file_viewer_load_new(this, '#img_box')">
								<span class="text-danger">尺寸: 1280*850</span>
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



						<!-- <div class="form-group">
							<label class="col-md-2 control-label" for="aAbstract">摘要內容</label>
							<div class="col-md-10">
								<textarea class="form-control" id="aAbstract" name="aAbstract" placeholder="摘要內容"><?php //echo $row['aAbstract'];?></textarea>
							</div>
						</div> -->


						<div class="form-group">
							<label class="col-md-2 control-label" for="YoutubeUrl">影片URL</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="YoutubeUrl" name="YoutubeUrl" value="<?php echo $row['YoutubeUrl'];?>">
                <span class="text-danger">請輸入youtube網址</span>
							</div>
						</div>


                        <div class="form-group">
							<label class="col-md-2 control-label">文章標籤</label>
							<div class="col-md-10">
								<?php
                                  $pdo=pdo_conn();
                                  $sql=$pdo->prepare("SELECT * FROM appLabel WHERE mt_id=:mt_id ORDER BY OrderBy DESC, Tb_index DESC");
                                  $sql->execute(['mt_id'=>'site2018090510193983']);
                                  while ($row_label=$sql->fetch(PDO::FETCH_ASSOC)) {
                                    if (!empty($label) && in_array($row_label['Tb_index'], $label)) {
                                     echo '<label><input type="checkbox" name="label[]" checked value="'.$row_label['Tb_index'].'">'.$row_label['label_name'].'</label>｜';
                                    }
                                    else{
                                  	 echo '<label><input type="checkbox" name="label[]" value="'.$row_label['Tb_index'].'">'.$row_label['label_name'].'</label>｜';
                                    }
                                    
                                  }
								?>
								
							</div>
						</div>


						<div class="form-group ">
							<label class="col-md-2 control-label">推薦文章</label>
							<div class="col-md-10 recommend_div">
								<?php
                                  
                                  $sql=$pdo->prepare("SELECT * FROM appArticle WHERE mt_id=:mt_id AND Tb_index!=:Tb_index ORDER BY OrderBy DESC, StartDate DESC, Tb_index DESC");
                                  $sql->execute(['mt_id'=>$_GET['MT_id'], 'Tb_index'=>$_GET['Tb_index']]);
                                  while ($row_art=$sql->fetch(PDO::FETCH_ASSOC)) {
                                    if (!empty($recommend_art) && in_array($row_art['Tb_index'], $recommend_art)) {
                                     echo '<label><input type="checkbox" name="recommend_art[]" checked value="'.$row_art['Tb_index'].'">'.$row_art['aTitle'].'</label><br>';
                                    }
                                    else{
                                  	 echo '<label><input type="checkbox" name="recommend_art[]" value="'.$row_art['Tb_index'].'">'.$row_art['aTitle'].'</label><br>';
                                    }
                                    
                                  }
								?>
								
							</div>
						</div>



						<div class="form-group">
							<label class="col-md-2 control-label" for="ckeditor">詳細內容</label>
							<div class="col-md-10">
								<textarea id="ckeditor" name="aTXT" placeholder="詳細內容"><?php echo $row['aTXT'];?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="OtherFile_more">輪播圖檔</label>
							<div class="col-md-10">
								<input type="file" multiple name="OtherFile_more[]" class="form-control" id="OtherFile_more" accept=".jpg" onchange="file_viewer_load_new(this, '#img_box_other')">
								<span class="help-block m-b-none">可批次上傳多個檔，存檔後可拖曳變更排序</span>
							</div>
						</div>


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
							<label class="col-md-2 control-label" for="YoutubeUrl">嵌入youtube連結</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="YoutubeUrl" name="YoutubeUrl" value="<?php //echo $row['YoutubeUrl'];?>">
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

