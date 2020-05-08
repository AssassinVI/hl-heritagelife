<?php
//-- 共用連線 --
require 'share_area/conn.php';

$mt_id=$_GET['mt_id'];

//$row_mt=$pdo->select("SELECT * FROM maintable WHERE Tb_index=:Tb_index", ['Tb_index'=>$mt_id], 'one');

$row=$pdo->select("SELECT * FROM appArticle WHERE Tb_index=:Tb_index", ['Tb_index'=>$_GET['Tb_index']], 'one');
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
    
    <?php 
     //-- 公用CSS --
     require 'share_area/css.php'
    
    ?>

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
            <div class="col-lg-12 section-divided__main">
              <section class="section-md post-single-body">
                <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6"><h1 class="font-weight-bold d_title"><?php echo $row['aTitle'];?></h1></div>
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <ul class="list-inline-sm line_share">
                      <h6>Share</h6>
                      <li><a class="icon-sm fa-facebook icon" href="#"></a></li>
                      <li><a class="icon-sm fa-twitter icon" href="#"></a></li>
                      <li><a class="icon-sm fa-pinterest-p icon" href="#"></a></li>
                    </ul>
                  </div>
                </div>
                

                <!-- Swiper-->
                <?php
                 $OtherFile=explode(',', substr($row['OtherFile'], 0,-1)   );
                ?>
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


                <p class="first-letter">
                  <?php echo $row['aTXT'];?>
                </p>
                 
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