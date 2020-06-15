<?php
//-- 共用連線 --
require 'share_area/conn.php';

$mt_id=$_GET['mt_id'];

//$row_mt=$pdo->select("SELECT * FROM maintable WHERE Tb_index=:Tb_index", ['Tb_index'=>$mt_id], 'one');

$row=$pdo->select("SELECT * FROM appArticle WHERE Tb_index=:Tb_index", ['Tb_index'=>$_GET['Tb_index']], 'one');

$OtherFile=explode(',', substr($row['OtherFile'], 0,-1)   );

$FB_URL='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="zh-tw">
  <head>
    <!-- Site Title-->
    <title><?php echo $row['aTitle'];?>｜襲園生活</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $row['SmallTitle'];?>">

    <meta property="og:site_name" content="<?php echo $row['aTitle'];?>｜襲園生活" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="zh_TW" />
    <meta property="og:image" content="<?php echo 'sys/img/'.$OtherFile[0];?>" />
    <meta property="og:title" content="<?php echo $row['aTitle'];?>｜襲園生活" />
    <meta property="og:description" content="<?php echo $row['SmallTitle'];?>" />
    <meta property="og:url" content="<?php echo $FB_URL;?>" />
    
    <?php 
     //-- 公用CSS --
     require 'share_area/css.php'
    
    ?>
    <style>
      .desktop .swiper-slider_fullheight{    min-height: 55vh;}
    </style>

  </head>
  <body>
    <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <div id="page-loader">
      <div class="cssload-container">
        <div class="cssload-speeding-wheel"></div>
      </div>
    </div>
    <!-- Page-->
    <div class="page">
      
      <?php
       //-- 公用header_d --
       require 'share_area/header_d.php';
      
      ?>


    
      <section class="bg-default section-lg">
        <div class="container">
          <div class="row row-60 justify-content-sm-center">
            <div class="col-lg-8 section-divided__main">
              <section class="section-md post-single-body">
                <div class="row">
                  <div class="col-sm-12"><h1 class="d_title"><?php echo $row['aTitle'];?></h1></div>
                  
                </div>
                

                <!-- Swiper-->
                
                <section class="rd-parallax mt-5">
                  <div class="rd-parallax-layer" data-type="html" data-speed="1">
                    <div class="swiper-container swiper-slider swiper-slider_fullheight" data-simulate-touch="false" data-loop="true" data-autoplay="5500">
                      <div class="swiper-wrapper">
                      <?php
                       foreach ($OtherFile as $one) {
          
                         $url=empty($sl['aUrl']) ? '':'<div class="group-lg group-middle"><a class="button button-primary" data-caption-animate="fadeInUpSmall" data-caption-delay="350" href="'.$sl['aUrl'].'" target="_blank">LINK</a></div>';
                         echo '
                         <div class="swiper-slide bg-black" data-slide-bg="sys/img/'.$one.'">
                          <div class="swiper-slide-caption text-center" data-speed="0.5" data-fade="true">
                            
                          </div>
                        </div>';
                       }
                      ?>
                       
                      </div>
                      <!-- Swiper Pagination-->
                      <div class="swiper-pagination"></div>
                      <!-- Swiper Navigation-->
                      <div class="swiper-button-prev linear-icon-chevron-left"></div>
                      <div class="swiper-button-next linear-icon-chevron-right"></div>
                    </div>
                  </div>
                </section>




                <div class="article_div my-5">
                  <h5>
                   <?php echo $row['SmallTitle']?>
                  </h5>


                  <?php echo $row['aTXT'];?>
                </div>


                <div>
                    <ul class="list-inline-sm line_share">
                      <h6>Share</h6>
                      <li><button type="button" class="icon-sm fa-facebook icon" style="color: #3F51B5; cursor: pointer;"  onclick="window.open('https://www.facebook.com/dialog/feed?app_id=1752476714860775&display=popup&link=<?php echo urlencode($FB_URL);?>&redirect_uri=https://www.facebook.com/', 'FB分享', config='height=600,width=800');"></button></li>
                    </ul>
                  </div>
                 
              </section>

              <?php
                $row_prev=$pdo->select("SELECT aTitle, Tb_index 
                                        FROM appArticle 
                                        WHERE StartDate>(SELECT StartDate FROM appArticle WHERE Tb_index=:Tb_index) AND mt_id=:mt_id
                                        ORDER BY StartDate ASC 
                                        LIMIT 0,1", ['Tb_index'=>$_GET['Tb_index'], 'mt_id'=>$_GET['mt_id']], 'one');

                $row_next=$pdo->select("SELECT aTitle, Tb_index 
                                        FROM appArticle 
                                        WHERE StartDate<(SELECT StartDate FROM appArticle WHERE Tb_index=:Tb_index) AND mt_id=:mt_id
                                        ORDER BY StartDate DESC 
                                        LIMIT 0,1", ['Tb_index'=>$_GET['Tb_index'], 'mt_id'=>$_GET['mt_id']], 'one');
              ?>
              <section class="section-md">
                <div class="row row-60 justify-content-md-between">

                
                  <div class="col-md-5 text-md-left">
                  <?php
                   if(!empty($row_prev['Tb_index'])){
                  ?>
                    <a class="unit flex-row unit-spacing-md align-items-center" href="article_detail.php?mt_id=<?php echo $_GET['mt_id'];?>&Tb_index=<?php echo $row_prev['Tb_index'];?>">
                      <div class="unit-left"><span class="icon icon-md linear-icon-arrow-left"></span></div>
                      <div class="unit-body">
                        <p class="small"><?php echo $row_prev['aTitle'];?></p>
                      </div>
                    </a>
                  <?php }?>
                  </div>
                
                
                  <div class="col-md-5 text-md-right">
                  <?php
                   if(!empty($row_next['Tb_index'])){
                  ?>
                    <a class="unit flex-row unit-spacing-md align-items-center right" href="article_detail.php?mt_id=<?php echo $_GET['mt_id'];?>&Tb_index=<?php echo $row_next['Tb_index'];?>">
                      <div class="unit-body">
                        <p class="small"><?php echo $row_next['aTitle'];?></p><span class="icon icon-md linear-icon-arrow-right"></span>
                      </div>
                    </a>
                  <?php }?>
                  </div>
                 

                </div>
              </section>
            </div>






            <div class="col-lg-4 section-divided__aside section-divided__aside-left">
              <!-- Categories-->
              <section class="section-md">
                <h5>分類目錄</h5>
                <ul class="list-linked">
                  <li><a href="article_list.php?mt_id=site2018110610481744">食事日常</a></li>
                  <li><a href="article_list.php?mt_id=site2020042914035766">職人嚴選</a></li>
                  <li><a href="article_list.php?mt_id=site2020042914164188">空間美學</a></li>
                  <li><a href="article_list.php?mt_id=site2020042914190418">襲園行旅</a></li>
                </ul>
              </section>

              

              <!-- Tags-->
              
              <section class="section-md">
                <h5>標籤</h5>
                <ul class="list-tags">
                  <?php
                    $label=explode(',',$row['label']);
                    foreach ($label as $label_one) {
                      $row_label=$pdo->select("SELECT label_name FROM appLabel WHERE Tb_index=:Tb_index", ['Tb_index'=>$label_one], 'one');
                      echo '<li><a href="#">'.$row_label['label_name'].'</a></li>';
                    }
                  ?>
                </ul>
              </section>

              
            </div>







          </div>
        </div>
      </section>

      <?php
        //-- 公用footer --       
        require 'share_area/footer.php';
       
       ?>



    </div>


    <?php
        //-- 公用彈跳視窗 --       
        require 'share_area/pop_window.php';
       
    ?>


   <?php
       //-- 公用JS--
       require 'share_area/js.php';
      
    ?>

  </body>
</html>