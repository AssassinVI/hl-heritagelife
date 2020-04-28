<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
  .other_list{ background: #efefef; padding: 5px; }
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {
  // ======================== 刪除 ===========================
    if (!empty($_POST['type']) && $_POST['type']=='delete') { 
    	if (!empty($_POST['aPic'])) {
    		$param=array('aPic'=>'');
            $where=array('Tb_index'=>$_POST['Tb_index']);
            pdo_update('appProduct', $param, $where);

            unlink('../../img/'.$_POST['aPic']);
    	}
        //----------------------- 多檔刪除 -------------------------------
    	elseif(!empty($_POST['OtherFile'])){

            $sel_where=array('Tb_index'=>$_POST['Tb_index']);
    		$otr_file=pdo_select('SELECT OtherFile FROM appProduct WHERE Tb_index=:Tb_index', $sel_where);
    
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
            pdo_update('appProduct', $param, $where);
    	}

       exit();
  	}

  // ============================ 新增 =========================
	if (empty($_POST['Tb_index'])) {

		    $Tb_index='product'.date('YmdHis').rand(0,99);
        $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0: 1 ;
        $HotPro=empty($_POST['HotPro']) ? 0: 1 ;

        // 最上排序
        $row_OrderBy=pdo_select("SELECT OrderBy FROM appProduct ORDER BY OrderBy DESC LIMIT 0,1");
        $row_OrderBy=(int)$row_OrderBy['OrderBy']+1;


      if (!empty($_FILES['aPic']['name'])) {
      	 $type=explode('.', $_FILES['aPic']['name']);
      	 $aPic=$Tb_index.'.'.$type[count($type)-1];
         //fire_upload('aPic', $aPic);
          ecstart_convert_jpeg_NEW($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 1280); 

      }
      else{
      	$aPic='';
      }
     
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

    $aBrand=empty($_POST['aBrand']) ? '':$_POST['aBrand'];
    //-- 品牌類型+品牌編碼 --
      $row_brand=pdo_select("SELECT serial_type,serial_brand FROM appBrand WHERE Tb_index=:Tb_index", ['Tb_index'=>$aBrand]);
      //-- 最新產品流水號 --
        $row_pro=pdo_select("SELECT serial_num FROM appProduct WHERE aBrand=:aBrand ORDER BY serial_num DESC LIMIT 0,1", ['aBrand'=>$aBrand]);

        if (empty($row_pro['serial_num'])) {

          $serial_num=$row_brand['serial_type'].$row_brand['serial_brand'].date('Y').'001';
        }
        else{
           $num=substr($row_pro['serial_num'], -3);
           $num=(int)$num+1;

           if ($num>=100) {
            $num=(string)$num;
           }
           elseif($num>=10){
            $num='0'.(string)$num;
           }
           else{
            $num='00'.(string)$num;
           }

           $serial_num=$row_brand['serial_type'].$row_brand['serial_brand'].date('Y').$num;
        } 


    //----------------------- 上下線判斷 -------------------------
      $StartDate=empty($_POST['StartDate']) ? date('Y-m-d') : $_POST['StartDate'];
      $EndDate=empty($_POST['EndDate']) ? '0000-00-00' : $_POST['EndDate'];

      

      $label_art=empty($_POST['label_art'])? '': implode(',', $_POST['label_art']);
      $recommend_art=empty($_POST['recommend_art']) ? '': implode(',', $_POST['recommend_art']);
      $search_art=empty($_POST['search_art']) ? '': implode(',', $_POST['search_art']);

      $label_pro=empty($_POST['label_pro'])? '': implode(',', $_POST['label_pro']);
      $recommend_pro=empty($_POST['recommend_pro']) ? '': implode(',', $_POST['recommend_pro']);
      $search_pro=empty($_POST['search_pro']) ? '': implode(',', $_POST['search_pro']);
      
      $other_type=empty($_POST['other_type']) ? 'checkbox':$_POST['other_type'];
      $other_list_name=empty($_POST['other_list_name']) ? '':implode('||', $_POST['other_list_name']);
      $other_list_price=empty($_POST['other_list_price']) ? '':implode(',', $_POST['other_list_price']);

	$param=array(  'Tb_index'=>$Tb_index,
		              'mt_id'=>$_POST['mt_id'],
		             'aTitle'=>$_POST['aTitle'],
		       'Introduction'=>$_POST['Introduction'],
		         'serial_num'=>$serial_num,
		             'aBrand'=>$aBrand,
		          'label_art'=>$label_art,
		      'recommend_art'=>$recommend_art,
		         'search_art'=>$search_art,
		          'label_pro'=>$label_pro,
		      'recommend_pro'=>$recommend_pro,
		         'search_pro'=>$search_pro,
		               'aPic'=>$aPic,
		             'HotPro'=>$HotPro,
		              'price'=>$_POST['price'],
             'other_type'=>$other_type,
        'other_list_name'=>$other_list_name,
       'other_list_price'=>$other_list_price,
		          'OtherFile'=>$OtherFile,
		               'aTXT'=>$_POST['aTXT'],
		               'aUrl'=>$_POST['aUrl'],
		         'YoutubeUrl'=>$_POST['YoutubeUrl'],
		          'StartDate'=>$StartDate,
		            'EndDate'=>$EndDate,
		        'OnLineOrNot'=>$OnLineOrNot,
		            'pro_num'=>$_POST['pro_num'],
                'OrderBy'=>$row_OrderBy,
		            'webLang'=>$weblang
		          );
	pdo_insert('appProduct', $param);
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }

  //============================ 修改 ===========================
   else{  

   	$Tb_index =$_POST['Tb_index'];


      if (!empty($_FILES['aPic']['name'])) {
      	 $type=explode('.', $_FILES['aPic']['name']);
      	 $aPic=$Tb_index.'_'.date('His').'.'.$type[count($type)-1];
         //fire_upload('aPic', $aPic);
          ecstart_convert_jpeg_NEW($_FILES['aPic']['tmp_name'], '../../img/'.$aPic, 1280); 

        $aPic_param=array('aPic'=>$aPic);
        $aPic_where=array('Tb_index'=>$Tb_index);
        pdo_update('appProduct', $aPic_param, $aPic_where);
      }

     //-------------------- 多檔上傳 -----------------------
      $sel_where=array('Tb_index'=>$Tb_index);
      $now_file =pdo_select("SELECT OtherFile FROM appProduct WHERE Tb_index=:Tb_index", $sel_where);

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

                        if (empty($_FILES['aPic']['name'])) {
                          $exif_Orientation=$_POST['exif_Orientation'];
                        }
                        else{
                          $exif_Orientation=$_POST['exif_Orientation'];
                          array_splice($exif_Orientation,0,1) ;
                        }
                        ecstart_convert_jpeg_NEW($_FILES['OtherFile_more']['tmp_name'][$i], '../../img/'.$Tb_index.date('His').'_other_'.($file_num+$i).'.'.$type[count($type)-1], 1700);
                  }
                }
                $OtherFile_param=array('OtherFile'=>$OtherFile);
                $OtherFile_where=array('Tb_index'=>$Tb_index);
                pdo_update('appProduct', $OtherFile_param, $OtherFile_where);
      //------------------------ END --------------------------
   

   $aBrand=empty($_POST['aBrand']) ? '':$_POST['aBrand'];
    //-- 品牌類型+品牌編碼 --
      $row_brand=pdo_select("SELECT serial_type,serial_brand FROM appBrand WHERE Tb_index=:Tb_index", ['Tb_index'=>$aBrand]);
      //-- 最新產品流水號 --
        $row_pro=pdo_select("SELECT serial_num FROM appProduct WHERE aBrand=:aBrand ORDER BY serial_num DESC LIMIT 0,1", ['aBrand'=>$aBrand]);

        if (empty($row_pro['serial_num'])) {

          $serial_num=$row_brand['serial_type'].$row_brand['serial_brand'].date('Y').'001';
        }
        else{
           $num=substr($row_pro['serial_num'], -3);
           $num=(int)$num+1;

           if ($num>=100) {
            $num=(string)$num;
           }
           elseif($num>=10){
            $num='0'.(string)$num;
           }
           else{
            $num='00'.(string)$num;
           }

           $serial_num=$row_brand['serial_type'].$row_brand['serial_brand'].date('Y').$num;
    } 


    $HotPro=empty($_POST['HotPro']) ? 0: 1 ;
    $OnLineOrNot=empty($_POST['OnLineOrNot']) ? 0: 1 ;


    $label_art=empty($_POST['label_art'])? '': implode(',', $_POST['label_art']);
    $recommend_art=empty($_POST['recommend_art']) ? '': implode(',', $_POST['recommend_art']);
    $search_art=empty($_POST['search_art']) ? '': implode(',', $_POST['search_art']);

    $label_pro=empty($_POST['label_pro'])? 'space': implode(',', $_POST['label_pro']);
    $recommend_pro=empty($_POST['recommend_pro']) ? '': implode(',', $_POST['recommend_pro']);
    $search_pro=empty($_POST['search_pro']) ? '': implode(',', $_POST['search_pro']);

    $other_type=empty($_POST['other_type']) ? 'checkbox':$_POST['other_type'];
    $other_list_name=empty($_POST['other_list_name']) ? '':implode('||', $_POST['other_list_name']);
    $other_list_price=empty($_POST['other_list_price']) ? '':implode(',', $_POST['other_list_price']);

    $param=array(  
    	             'aTitle'=>$_POST['aTitle'],
    	       'Introduction'=>$_POST['Introduction'],
    	         'serial_num'=>$serial_num,
		             'aBrand'=>$aBrand, 
		          'label_art'=>$label_art,
		      'recommend_art'=>$recommend_art,
		         'search_art'=>$search_art,
		          'label_pro'=>$label_pro,
		      'recommend_pro'=>$recommend_pro,
		         'search_pro'=>$search_pro,
		             'HotPro'=>$HotPro,
		              'price'=>$_POST['price'],
             'other_type'=>$other_type,
        'other_list_name'=>$other_list_name,
       'other_list_price'=>$other_list_price,
		               'aTXT'=>$_POST['aTXT'],
		               'aUrl'=>$_POST['aUrl'],
		         'YoutubeUrl'=>$_POST['YoutubeUrl'],
		          'StartDate'=>$_POST['StartDate'],
		            'EndDate'=>$_POST['EndDate'],
		            'pro_num'=>$_POST['pro_num'],
		        'OnLineOrNot'=>$OnLineOrNot
		          );
    $where=array( 'Tb_index'=>$Tb_index );
	pdo_update('appProduct', $param, $where);
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}

if ($_GET) {
 	$where=array('Tb_index'=>$_GET['Tb_index']);
 	$row=pdo_select('SELECT * FROM appProduct WHERE Tb_index=:Tb_index', $where);

 	$label_art=explode(',', $row['label_art']);
 	$recommend_art=explode(',', $row['recommend_art']);
 	$search_art=empty($row['search_art']) ? '': explode(',', $row['search_art']);

 	$label_pro=explode(',', $row['label_pro']);
 	$recommend_pro=explode(',', $row['recommend_pro']);
 	$search_pro=empty($row['search_pro']) ? '': explode(',', $row['search_pro']);
  
  $other_list_name=explode('||', $row['other_list_name']);
  $other_list_price=explode(',', $row['other_list_price']);
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
							<label class="col-md-2 control-label" for="serial_num">產品流水號</label>
							<div class="col-md-10">
								<input type="text" class="form-control"  id="serial_num" name="serial_num" readonly value="<?php echo $row['serial_num'];?>">
								
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="aTitle">標題</label>
							<div class="col-md-10">
								<textarea class="form-control" id="aTitle" name="aTitle" maxlength="15"><?php echo $row['aTitle'];?></textarea>
								<span class="text-danger">字數限制:15字內</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="Introduction">簡介</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="Introduction" name="Introduction" maxlength="50" value="<?php echo $row['Introduction'];?>">
								<span class="text-danger">字數限制:50字內</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="aBrand">品牌</label>
							<div class="col-md-10">
								<select class="form-control" id="aBrand" name="aBrand">
									<option value="">-- 請選擇 --</option>
									<?php 
                                     $pdo=pdo_conn();
                                     $sql=$pdo->prepare("SELECT aTitle, Tb_index FROM appBrand WHERE OnLineOrNot='1' ORDER BY OrderBy DESC");
                                     $sql->execute();
                                     while ($row_brand=$sql->fetch(PDO::FETCH_ASSOC)) {

                                     	if ($row['aBrand']==$row_brand['Tb_index']) {
                                     		echo '<option value="'.$row_brand['Tb_index'].'" selected>'.$row_brand['aTitle'].'</option>';
                                     	}
                                     	else{
                                     		echo '<option value="'.$row_brand['Tb_index'].'">'.$row_brand['aTitle'].'</option>';
                                     	}
                                     	
                                     }
									?>
								</select>
							</div>
						</div>
						

						<div class="form-group">
							<label class="col-md-2 control-label" for="ckeditor">商品描述</label>
							<div class="col-md-10">
								<textarea id="ckeditor" name="aTXT" ><?php echo $row['aTXT'];?></textarea>
							</div>
						</div>

						<div  class="form-group">
							<label class="col-md-2 control-label" for="YoutubeUrl">Youtube連結</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="YoutubeUrl" name="YoutubeUrl" value="<?php echo $row['YoutubeUrl'];?>">
							</div>
						</div>
                        
            <!-- 關閉欄位 -->
						<!-- 關閉欄位 -->
						<!-- 關閉欄位 -->
						<div style="display: none;" class="form-group">
							<label class="col-md-2 control-label" for="aUrl">相關連結</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="aUrl" name="aUrl" value="<?php echo $row['aUrl'];?>">
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
                                                            if (!empty($label_art) && in_array($row_label['Tb_index'], $label_art)) {
                                                             echo '<label><input type="checkbox" name="label_art[]" checked value="'.$row_label['Tb_index'].'">'.$row_label['label_name'].'</label>｜';
                                                            }
                                                            else{
                                                          	 echo '<label><input type="checkbox" name="label_art[]" value="'.$row_label['Tb_index'].'">'.$row_label['label_name'].'</label>｜';
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
							<label class="col-md-2 control-label" for="aPic">產品圖檔</label>
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
							<label class="col-md-2 control-label" for="OtherFile_more">輪播圖檔</label>
							<div class="col-md-10">
								<input type="file" multiple name="OtherFile_more[]" class="form-control" id="OtherFile_more" accept=".jpg" onchange="file_viewer_load_new(this, '#img_box_other')">
								<span class="help-block m-b-none">可批次上傳多個檔，存檔後可拖曳變更排序</span><span class="text-danger">圖片尺寸:1280*1280</span>
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

						

           <div class="form-group">
							<label class="col-md-2 control-label" for="price">價格</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="price" name="price" value="<?php echo $row['price'];?>" placeholder="請輸入金額">
							</div>
							
							<label class="col-md-2 control-label" for="pro_num">商品數量</label>
							<div class="col-md-4">
								<input type="number" class="form-control" id="pro_num" name="pro_num" value="<?php echo $row['pro_num'];?>" placeholder="請輸入數量">
							</div>
							
						</div>

            <div class="form-group">
              <label class="col-md-2 control-label" >額外選項</label>
              <div class="col-md-2">
                <button type="button" id="add_other" class="btn btn-info btn-block">新增選項</button>
              </div>
              <!-- <div class="col-md-2">
                <select name="other_type" class="form-control">
                  <option value="">-- 選項類型 --</option>
                  <option value="radio" <?php //echo $check_type=$row['other_type']=='radio' ? 'selected':''; ?> >單選</option>
                  <option value="checkbox"  <?php //echo $check_type=$row['other_type']=='checkbox' ? 'selected':''; ?> >複選</option>
                </select>
              </div> -->
            </div>
            
            <div class="other_list_div">

              <?php
                for ($i=0; $i <count($other_list_name) ; $i++) { 
                  
                  echo '
              <div class="form-group other_list">
                <label class="col-md-2 control-label" >選項名稱</label>
                <div class="col-md-4">
                  <input type="text" class="form-control"  name="other_list_name[]"  placeholder="請輸入內容" value="'.$other_list_name[$i].'">
                </div>
                <label class="col-md-2 control-label" >選項金額</label>
                <div class="col-md-3">
                  <input type="text" class="form-control"  name="other_list_price[]"  placeholder="請輸入金額" value="'.$other_list_price[$i].'">
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-danger del_other">X</button>
                </div>
              </div>';
                }
              ?>

              

            </div>
            


						<!-- <div class="form-group">
							<label class="col-md-2 control-label" for="aAbstract"> 商品說明</label>
							<div class="col-md-10">
								<textarea id="ckeditor1" name="aAbstract" ><?php //echo $row['aAbstract'];?></textarea>
							</div>
						</div> -->

						<!-- <div class="form-group">
							<label class="col-md-2 control-label" for="precautions"> 注意事項</label>
							<div class="col-md-10">
								<textarea style="height: 200px;" class="form-control" name="precautions" ><?php //echo $row['precautions'];?></textarea>
							</div>
						</div> -->

					 
                         <!-- 關閉欄位 -->
						<!-- 關閉欄位 -->
						<!-- 關閉欄位 -->
						<div style="display: none;" class="form-group">
							<label class="col-md-2 control-label" for="StartDate">上線日期</label>
							<div class="col-md-10">
								<input type="date" class="form-control" id="StartDate" name="StartDate" value="<?php echo $row['StartDate'];?>">
							</div>
						</div>
                        
                        <!-- 關閉欄位 -->
						<!-- 關閉欄位 -->
						<!-- 關閉欄位 -->
						<div style="display: none;" class="form-group">
							<label class="col-md-2 control-label" for="EndDate">下線日期</label>
							<div class="col-md-10">
								<input type="date" class="form-control" id="EndDate" name="EndDate" value="<?php echo $row['EndDate'];?>">
							</div>
						</div>
                        
                        <div class="form-group">
							<label class="col-md-2 control-label" for="HotPro">推薦商品</label>
							<div class="col-md-10">
								<input style="width: 20px; height: 20px;" id="HotPro" name="HotPro" type="checkbox" value="1" <?php echo $check_hot=$row['HotPro']==1 ? 'checked' : ''; ?>  />
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

						<input type="hidden" id="art_label" name="art_label" value="<?php echo $row['label_art'];?>"><!-- 依照舊名稱命名，勿改 -->
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


    //---------------------------- 選品牌，產生流水號 -----------------------------
    $('#aBrand').change(function(event) {

    	$.ajax({
    		url: 'manager_ajax.php',
    		type: 'POST',
    		data: {
    			type:'serial_num',
    			Tb_index: $(this).val()
    		},
    		success:function (data) {

    			$('#serial_num').val(data);
    		}
    	});
    });

     

      //=============================================-- 推薦文章 --======================================================
      recommend_art();

    
     //-- 改變文章標籤 --
      $('[name="label_art[]"]').change(function(event) {
      	var labels='';
      	$.each($('[name="label_art[]"]:checked'), function(index, val) {
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
      	$(this).parent().remove();
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



       //-- 新增選項 --
       $('#add_other').click(function(event) {

        var other_txt=
               '<div class="form-group other_list">'+
                '<label class="col-md-2 control-label" >選項名稱</label>'+
               ' <div class="col-md-4">'+
                  '<input type="text" class="form-control"  name="other_list_name[]"  placeholder="請輸入內容">'+
                '</div>'+
                '<label class="col-md-2 control-label" >選項金額</label>'+
                '<div class="col-md-3">'+
                  '<input type="text" class="form-control"  name="other_list_price[]"  placeholder="請輸入金額">'+
                '</div>'+
                '<div class="col-md-1">'+
                  '<button type="button"  class="btn btn-danger del_other">X</button>'+
                '</div>'+
              '</div>';

         $('.other_list_div').append(other_txt);
       });

       //-- 刪除選項 --
       $('.other_list_div').on('click', '.del_other', function(event) {
         event.preventDefault();
          if (confirm('是否要刪除 "'+$(this).parent().parent().find('[name="other_list_name[]"]').val()+'" ?')) {
            $(this).parent().parent().remove();
         }
       });
       

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

