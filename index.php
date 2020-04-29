<?php
//-- 共用連線 --
require 'share_area/conn.php';

?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="zh-tw"">
  <head>
    <!-- Site Title-->
    <title><?php echo $company['name'];?></title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    
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
         <div class="page">
      
      <?php
       //-- 公用header --
       require 'share_area/header.php';
      
      ?>
          

      <!-- Swiper-->
      <section class="rd-parallax">
        <div class="rd-parallax-layer" data-type="html" data-speed="1">
          <div class="swiper-container swiper-slider swiper-slider_fullheight" data-simulate-touch="false" data-loop="true" data-autoplay="5500">
            <div class="swiper-wrapper">
            <?php
             $row_sl=$pdo->select("SELECT * FROM indexSlideshow WHERE is_use=1 ORDER BY OrderBy DESC");
             foreach ($row_sl as $sl) {

               $url=empty($sl['aUrl']) ? '':'<div class="group-lg group-middle"><a class="button button-primary" data-caption-animate="fadeInUpSmall" data-caption-delay="350" href="'.$sl['aUrl'].'" >LINK</a></div>';
               echo '
               <div class="swiper-slide bg-black" data-slide-bg="sys/img/'.$sl['back_img'].'">
                <div class="swiper-slide-caption text-center" data-speed="0.5" data-fade="true">
                  <div class="container">
                    <h1 data-caption-animate="fadeInUpSmall" data-wow-duration="5s"><span>'.$sl['aTitle'].'</span></h1>
                    <h3 data-caption-animate="fadeInUpSmall" data-caption-delay="200">'.$sl['html_content'].'</h3>
                    '.$url.'
                  </div>
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


      <!-- Presentation-->
      <section class="section-xl bg-default text-center" id="section-see-features">
        <div class="container">
          <!-- <div class="row justify-content-lg-center">
            <div class="col-lg-10 col-xl-8">
              <h3>(品牌)最新消息</h3>
            </div>
          </div> -->
          <div class="row row-50">

          <?php 
            $row_life=$pdo->select("SELECT * FROM appLife WHERE mt_id='site2020042910161796' AND OnLineOrNot=1 ORDER BY OrderBy DESC, Tb_index DESC");
            foreach ($row_life as $life) {
              echo '
              <div class="col-md-6 col-xl-6">
              <div class="thumbnail-classic"><img src="sys/img/'.$life['aPic'].'" alt="" width="100%" height="315"/>
                <div class="caption">
                  <h5><a class="thumbnail-classic-title" href="'.$life['aUrl'].'">'.$life['aTitle'].'</a></h5>
                  <p>'.$life['aAbstract'].'</p>
                  <div class="group-middle"><a class="s_button button-primary" data-caption-animate="fadeInLeftSmall" data-caption-delay="200" href="'.$life['aUrl'].'" target="_blank">more</a></div>
                </div>
              </div>
            </div>';
            }
          ?>

            

            
           
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