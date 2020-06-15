<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
	.oneFile_div{ float: left; position: relative; margin: 5px; border: 1px solid #ccc; }
	.one_del_div{ position: absolute; top: 0; right: 0; }
	.other_div{ float: left; }
	.old_file{ width: 150px; height: 150px; float: left;}
	.old_file p{ text-align: center; background: #ccc; }

	.recommend_div{  overflow: auto; max-height: 300px; }
	#search_div{ display: none; width: 500px;}
	#search_item{ height: 200px; overflow: auto; }
	#search_item ul{ padding: 2rem; margin:0; }
	#search_item ul li{ padding: 5px; }
    #search_item ul li:hover{ background-color: #d4d4d4; }
	#search_item ul li p{ display: inline-block; width: 70%; margin:0;}
	#search_new{ padding: 1rem;}
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
        //ecstart_convert_jpeg($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 'N','N','N','N',1280);
        ecstart_convert_jpeg_NEW($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 1280); 
      }
      else{
      	$aPic='';
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
      	          //ecstart_convert_jpeg($_FILES['OtherFile_more']['tmp_name'][$j], '../../img/'.$Tb_index.'_others_'.$j.'.'.$type[count($type)-1], 'N','N','N','N',1700);
                   ecstart_convert_jpeg_NEW($_FILES['OtherFile_more']['tmp_name'][$j], '../../img/'.$Tb_index.'_others_'.$j.'.'.$type[count($type)-1], 1700);
      	        }
      	 }
         else{
           $OtherFile='';
         }
      
    
      
     $HotArt=empty($_POST['HotArt']) ? 0:1;
     $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
     $StartDate=empty($_POST['StartDate']) ? date('Y-m-d H:i:s'):$_POST['StartDate'];

    $label=empty($_POST['label'])? '': implode(',', $_POST['label']);
    $recommend_art=empty($_POST['recommend_art']) ? '': implode(',', $_POST['recommend_art']);
    $search_art=empty($_POST['search_art']) ? '': implode(',', $_POST['search_art']);

    $label_pro=empty($_POST['label_pro'])? '': implode(',', $_POST['label_pro']);
    $recommend_pro=empty($_POST['recommend_pro']) ? '': implode(',', $_POST['recommend_pro']);
    $search_pro=empty($_POST['search_pro']) ? '': implode(',', $_POST['search_pro']);
    
	$param=  ['Tb_index'=>$Tb_index,
			              'mt_id'=>$_POST['mt_id'],
			             'aTitle'=>$_POST['aTitle'],
                   //'aTitle_s'=>$_POST['aTitle_s'],
			         'SmallTitle'=>$_POST['SmallTitle'],
			             'aPoster'=>$_POST['aPoster'],
			          'aAbstract'=>$_POST['aAbstract'],
			               'aPic'=>$aPic,
			          'OtherFile'=>$OtherFile,
			               'aTXT'=>$_POST['aTXT'],
			         'YoutubeUrl'=>$_POST['YoutubeUrl'],
			              'label'=>$label,
			      'recommend_art'=>$recommend_art,
			         'search_art'=>$search_art,
                'label_pro'=>$label_pro,
            'recommend_pro'=>$recommend_pro,
               'search_pro'=>$search_pro,
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
         //ecstart_convert_jpeg($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 'N','N','N','N',1280);
         ecstart_convert_jpeg_NEW($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 1280);
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
                      //ecstart_convert_jpeg($_FILES['OtherFile_more']['tmp_name'][$i], '../../img/'.$Tb_index.date('His').'_other_'.($file_num+$i).'.'.$type[count($type)-1], 'N','N','N','N',1700);
                      ecstart_convert_jpeg_NEW($_FILES['OtherFile_more']['tmp_name'][$i], '../../img/'.$Tb_index.date('His').'_other_'.($file_num+$i).'.'.$type[count($type)-1], 1700);
                }
                      
              }

    $OtherFile_param=array('OtherFile'=>$OtherFile);
    $OtherFile_where=array('Tb_index'=>$Tb_index);
    pdo_update('appArticle', $OtherFile_param, $OtherFile_where);
      

      //------------------------------------------------------------------------------------------

    $HotArt=empty($_POST['HotArt']) ? 0:1;
    $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0:1;
    $label=empty($_POST['label']) ? '': implode(',', $_POST['label']);
    $recommend_art=empty($_POST['recommend_art']) ? '': implode(',', $_POST['recommend_art']);
    $search_art=empty($_POST['search_art']) ? '': implode(',', $_POST['search_art']);
    $StartDate=empty($_POST['StartDate']) ? date('Y-m-d H:i:s'):$_POST['StartDate'];

    $label_pro=empty($_POST['label_pro'])? '': implode(',', $_POST['label_pro']);
    $recommend_pro=empty($_POST['recommend_pro']) ? '': implode(',', $_POST['recommend_pro']);
    $search_pro=empty($_POST['search_pro']) ? '': implode(',', $_POST['search_pro']);

    $param=[  
		              'mt_id'=>$_POST['mt_id'],
    	           'aTitle'=>$_POST['aTitle'],
                 //'aTitle_s'=>$_POST['aTitle_s'],
    	       'SmallTitle'=>$_POST['SmallTitle'],
    	          'aPoster'=>$_POST['aPoster'],
		          'aAbstract'=>$_POST['aAbstract'],
		               'aTXT'=>$_POST['aTXT'],
		         'YoutubeUrl'=>$_POST['YoutubeUrl'],
		             'label'=>$label,
		     'recommend_art'=>$recommend_art,
		        'search_art'=>$search_art,
             'label_pro'=>$label_pro,
         'recommend_pro'=>$recommend_pro,
            'search_pro'=>$search_pro,
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
 	$recommend_art=explode(',', $row['recommend_art']);
 	$search_art=empty($row['search_art']) ? '': explode(',', $row['search_art']);

  $label_pro=explode(',', $row['label_pro']);
  $recommend_pro=explode(',', $row['recommend_pro']);
  $search_pro=empty($row['search_pro']) ? '': explode(',', $row['search_pro']);

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
                <span class="text-danger">文字請在30字內</span>
							</div>
						</div>

			<!-- <div class="form-group">
              <label class="col-md-2 control-label" for="aTitle_s">次標題名稱</label>
              <div class="col-md-10">
                <textarea class="form-control" id="aTitle_s" name="aTitle_s"><?php //echo $row['aTitle_s'];?></textarea>
              </div>
            </div> -->

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

							<!-- <label class="col-md-2 control-label" for="HotArt">首頁文章</label>
							<div class="col-md-4">
								<input style="width: 20px; height: 20px;" id="HotArt" name="HotArt" type="checkbox" value="1" <?php //echo $check=$row['HotArt']==1 ? 'checked' : ''; ?>  /> <br>
								<span class="text-danger">最多12篇</span>
							</div> -->
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
                                  $sql=$pdo->prepare("SELECT * FROM appLabel WHERE mt_id=:mt_id AND OnLineOrNot=1 ORDER BY OrderBy DESC, Tb_index DESC");
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
                              
							
								
							</div>
							
						</div>

						<div class="form-group ">
							<label class="col-md-2 control-label">手動搜尋文章</label>
							<div class="col-md-10">
								<a href="#search_div" class="btn btn-info btn-raised fancybox">搜尋</a>
							</div>
							<label class="col-md-2 control-label"></label>
							<div id="search_new" class="col-md-10">
                              <?php 
                               if (!empty($search_art)) {
                               	for ($i=0; $i <count($search_art) ; $i++) { 

                                 $row_search=pdo_select("SELECT aTitle FROM appArticle WHERE Tb_index=:Tb_index", ['Tb_index'=>$search_art[$i]]);
                               	 echo '<div><button class="search_del_btn" type="button">刪除</button><label>'.$row_search['aTitle'].'</label><input type="hidden" name="search_art[]" value="'.$search_art[$i].'"></div>';
                                }
                               }
                               
                              ?>
							</div>
						</div>

						<div id="search_div" class="form-group">
							<label class="col-md-2 control-label">搜尋文章</label>
							<div class="col-md-8">
								<input type="text" id="search_art" class="form-control">
							</div>
							<div class="col-md-2">
								<button type="button" id="search_btn" class="btn btn-info btn-block btn-raised">搜尋</button>
							</div>
							<div id="search_item" class="col-md-12">
								<ul>
									
								</ul>
							</div>
						</div>



<hr>


            <div class="form-group">
                                          <label class="col-md-2 control-label">產品標籤</label>
                                          <div class="col-md-10">
                                            <?php
                                                              $pdo=pdo_conn();
                                                              $sql=$pdo->prepare("SELECT * FROM appLabel WHERE mt_id=:mt_id ORDER BY OrderBy DESC, Tb_index DESC");
                                                              $sql->execute(['mt_id'=>'site201809221033134']);
                                                              while ($row_label=$sql->fetch(PDO::FETCH_ASSOC)) {
                                                                if (!empty($label_pro) && in_array($row_label['Tb_index'], $label_pro)) {
                                                                 echo '<label><input type="checkbox" name="label_pro[]" checked value="'.$row_label['Tb_index'].'">'.$row_label['label_name'].'</label>｜';
                                                                }
                                                                else{
                                                                 echo '<label><input type="checkbox" name="label_pro[]" value="'.$row_label['Tb_index'].'">'.$row_label['label_name'].'</label>｜';
                                                                }
                                                                
                                                              }
                                            ?>
                                            
                                          </div>
                                        </div>


                                        <div class="form-group ">
                                          <label class="col-md-2 control-label">推薦產品</label>
                                          <div class="col-md-10 recommend_pro_div">
                                                          
                                          
                                            
                                          </div>
                                          
                                        </div>

                                        <div class="form-group ">
                                          <label class="col-md-2 control-label">手動搜尋產品</label>
                                          <div class="col-md-10">
                                            <a href="#search_pro_div" class="btn btn-info btn-raised fancybox">搜尋</a>
                                          </div>
                                          <label class="col-md-2 control-label"></label>
                                          <div id="search_pro_new" class="col-md-10">
                                                          <?php 
                                                           if (!empty($search_pro)) {
                                                            for ($i=0; $i <count($search_pro) ; $i++) { 

                                                             $row_search=pdo_select("SELECT aTitle FROM appProduct WHERE Tb_index=:Tb_index", ['Tb_index'=>$search_pro[$i]]);
                                                             echo '<div><button class="search_del_btn" type="button">刪除</button><label>'.$row_search['aTitle'].'</label><input type="hidden" name="search_pro[]" value="'.$search_pro[$i].'"></div>';
                                                            }
                                                           }
                                                           
                                                          ?>
                                          </div>
                                        </div>

                                        <div id="search_pro_div" class="form-group">
                                          <label class="col-md-2 control-label">搜尋產品</label>
                                          <div class="col-md-8">
                                            <input type="text" id="search_pro" class="form-control">
                                          </div>
                                          <div class="col-md-2">
                                            <button type="button" id="search_pro_btn" class="btn btn-info btn-block btn-raised">搜尋</button>
                                          </div>
                                          <div id="search_pro_item" class="col-md-12">
                                            <ul>
                                              
                                            </ul>
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

						<input type="hidden" id="art_label" name="art_label" value="<?php echo $row['label'];?>"><!-- 依照舊名稱命名，勿改 -->
						<input type="hidden" id="recommend_art" value="<?php echo $row['recommend_art'];?>">

            <input type="hidden" id="label_pro"  value="<?php echo $row['label_pro'];?>">
            <input type="hidden" id="recommend_pro" value="<?php echo $row['recommend_pro'];?>">
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
    
      //=============================================-- 推薦文章 --======================================================
        recommend_art();

       
       //-- 改變文章標籤 --
        $('[name="label[]"]').change(function(event) {
        	var labels='';
        	$.each($('[name="label[]"]:checked'), function(index, val) {
                 labels+=$(this).val()+',';
        	});

        	$('#art_label').val(labels.slice(0,-1));
        	recommend_art();
        });


        //-- 手動搜尋 --
        $('#search_btn').click(function(event) {
        	var search_html='';
        	$.ajax({
        		url: 'manager_ajax.php',
        		type: 'POST',
        		dataType: 'json',
        		data: {
              type:'recommend_art',
        			search_art: $('#search_art').val(),
        			Tb_index:$('#Tb_index').val()
        		},
        		success:function (data) {
        			 $.each(data, function() {
        			 	search_html+='<li><p>'+this['aTitle']+'</p> <button class="search_new_btn" type="button">新增</button><input type="hidden" name="search_item" value="'+this['aTitle']+','+this['Tb_index']+'"></li>';
        			 });
                    $('#search_item ul').html(search_html);
        		}
        	});
        });

        //-- 手動搜尋-新增 --
        $('#search_item ul').on('click', '.search_new_btn', function(event) {
        	event.preventDefault();
        	var search_item=$(this).next().val().split(',');


        	var search_html='<div><button class="search_del_btn" type="button">刪除</button><label>'+search_item[0]+'</label><input type="hidden" name="search_art[]" value="'+search_item[1]+'"></div>';
        	$('#search_new').append(search_html);
        	toastr.options={
               closeButton: 'checked',
               progressBar: 'checked'
        	};
        	toastr.success('已新增 " '+search_item[0]+' " ','成功訊息');
        });

        //-- 手動搜尋文章-刪除 --
        $('#search_new').on('click', '.search_del_btn', function(event) {
        	event.preventDefault();
        	if (confirm('是否要刪除 " '+$(this).next().html()+' " ?')) {
        		$(this).parent().remove();
        	}
        });





        //=============================================-- 推薦產品 --======================================================
       recommend_pro();

      
      //-- 改變產品標籤 --
       $('[name="label_pro[]"]').change(function(event) {
        var labels_pro='';
        $.each($('[name="label_pro[]"]:checked'), function(index, val) {
                labels_pro+=$(this).val()+',';
        });

        $('#label_pro').val(labels_pro.slice(0,-1));
        recommend_pro();
       });


       //-- 手動搜尋 --
       $('#search_pro_btn').click(function(event) {
        var search_html='';
        $.ajax({
          url: 'manager_ajax.php',
          type: 'POST',
          dataType: 'json',
          data: {
            type:'recommend_pro',
            search_pro: $('#search_pro').val(),
            Tb_index:$('#Tb_index').val()
          },
          success:function (data) {
             $.each(data, function() {
              search_html+='<li><p>'+this['aTitle']+'</p> <button class="search_new_btn" type="button">新增</button><input type="hidden" name="search_pro_item" value="'+this['aTitle']+','+this['Tb_index']+'"></li>';
             });
                   $('#search_pro_item ul').html(search_html);
          }
        });
       });

       //-- 手動搜尋-新增 --
       $('#search_pro_item ul').on('click', '.search_new_btn', function(event) {
        event.preventDefault();
        var search_item=$(this).next().val().split(',');


        var search_html='<div><button class="search_del_btn" type="button">刪除</button><label>'+search_item[0]+'</label><input type="hidden" name="search_pro[]" value="'+search_item[1]+'"></div>';
        $('#search_pro_new').append(search_html);
        toastr.options={
              closeButton: 'checked',
              progressBar: 'checked'
        };
        toastr.success('已新增 " '+search_item[0]+' " ','成功訊息');
        $(this).parent().remove();
       });

       //-- 手動搜尋文章-刪除 --
       $('#search_pro_new').on('click', '.search_del_btn', function(event) {
        event.preventDefault();
        if (confirm('是否要刪除 " '+$(this).next().html()+' " ?')) {
          $(this).parent().remove();
        }
       });







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

    
    //-- 推薦文章 --
	function recommend_art() {
		var recommend_txt='';
		$.ajax({
			url: 'manager_ajax.php',
			type: 'POST',
			dataType: 'json',
			data: {
        type:'recommend_art',
				Tb_index: $('#Tb_index').val(),
				art_label:$('#art_label').val()
			},
			success:function (data) {
				$.each(data, function() {
				
					 var recommend_art_arr=$('#recommend_art').val().split(',');
					if (recommend_art_arr.indexOf(this['Tb_index'])>=0) {
                      recommend_txt+='<label><input type="checkbox" name="recommend_art[]" checked value="'+this['Tb_index']+'">'+this['aTitle']+'</label><br>';
					}
					else{
					  recommend_txt+='<label><input type="checkbox" name="recommend_art[]" value="'+this['Tb_index']+'">'+this['aTitle']+'</label><br>';
					}
				});

				$('.recommend_div').html(recommend_txt);
			}
		});
	}


  //-- 推薦產品 --
    function recommend_pro() {
      var recommend_txt='';
      $.ajax({
        url: 'manager_ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {
          type:'recommend_pro',
          Tb_index: $('#Tb_index').val(),
          label_pro:$('#label_pro').val()
        },
        success:function (data) {
          $.each(data, function() {
          
             var recommend_pro_arr=$('#recommend_pro').val().split(',');
            if (recommend_pro_arr.indexOf(this['Tb_index'])>=0) {
                        recommend_txt+='<label><input type="checkbox" name="recommend_pro[]" checked value="'+this['Tb_index']+'">'+this['aTitle']+'</label><br>';
            }
            else{
              recommend_txt+='<label><input type="checkbox" name="recommend_pro[]" value="'+this['Tb_index']+'">'+this['aTitle']+'</label><br>';
            }
          });

          $('.recommend_pro_div').html(recommend_txt);
        }
      });
    }
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>

