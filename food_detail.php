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
              <section class="section-md">
                <div class="row row-60 justify-content-md-between">
                  <div class="col-md-5 text-md-left"><a class="unit flex-row unit-spacing-md align-items-center" href="#">
                      <div class="unit-left"><span class="icon icon-md linear-icon-arrow-left"></span></div>
                      <div class="unit-body">
                        <p class="small">手作甜點</p>
                      </div></a></div>
                  <div class="col-md-5 text-md-right"><a class="unit flex-row unit-spacing-md align-items-center" href="#">
                      <div class="unit-body">
                        <p class="small">手作興趣變一生製菓追求</p>
                      </div>
                      <div class="unit-right"><span class="icon icon-md linear-icon-arrow-right"></span></div></a></div>
                </div>
              </section>
              
              
              
             
            </div>

          </div>
        </div>
      </section>
      <!-- Page Footer-->
      <section class="pre-footer-corporate">
        <div class="container">
          <div class="row justify-content-sm-center justify-content-lg-start row-30 row-md-60">
            <div class="col-sm-10 col-md-6 col-lg-10 col-xl-3">
              <h6 class="text-regular">關於</h6>
              <p>襲園集團自2004年進入住屋設計領域，始終堅持以
                 設計自宅的心來完成每次住案委託，以尊重自然的
                 態度進行建築與環境的整合，透過襲園美術館傳達
                 「生活美學、情感聯結」的生活藝術觀，以此回應
                 我們所關心、珍惜、重視的這塊土地。</p>
            </div>
            <div class="col-sm-10 col-md-6 col-lg-3 col-xl-2">
              <h6 class="text-regular">選單</h6>
              <div class="row">
                <div class="col-md-6 col-6">
                  <ul class="list-xxs">
                    <li><a href="food_list.html">食事日常</a></li>
                    <li><a href="article_list.html">職人嚴選</a></li>
                    <li><a href="style_list.html">空間美學</a></li>
                    <li><a href="travel_list.html">襲園行旅</a></li>
                  </ul>
                </div>
                <div class="col-md-6 col-6">
                  <ul class="list-xxs">
                    <li><a href="brands_list.html">品牌頻道</a></li>
                    <li><a href="#">嚴選好物</a></li>
                    <li><a href="login.html">登入</a></li>
                    <li><a href="contacts.html">聯絡我們</a></li>
                  </ul>
                </div>
              </div>
 
            </div>
            <div class="col-sm-10 col-md-6 col-lg-10 col-xl-3">
              <ul class="brands_icon">
                <li><img src="img/her.jpg"></li>
                <li><img src="img/home.jpg"></li>
                <li><img src="img/top.jpg"></li>
                <li><img src="img/cloth.jpg"></li>
              </ul>
            </div>
            
            <div class="col-sm-10 col-md-6 col-lg-4 col-xl-4">
              <h6 class="text-regular">聯絡我們</h6>
              <ul class="list-xs">
                <li>
                  <dl class="list-terms-minimal">
                    <dt>公司地址</dt>
                    <dd>320桃園市中壢區青埔九街57號</dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>公司電話</dt>
                    <dd>
                      <ul class="list-semicolon">
                        <li><a href="tel:#">03-453-3886</a></li>
                        
                      </ul>
                    </dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>連絡信箱</dt>
                    <dd><a href="mailto:#">heritagelife.cl@gmail.com</a></dd>
                  </dl>
                </li>
                
              </ul>
            </div>
          </div>
        </div>
      </section>

      <footer class="footer-corporate">
        <div class="container">
          <div class="footer-corporate__inner">
            <p class="text-center">Ⓒ COPYRIGHT 2018. ALL RIGHT RESERVED.</p>
          </div>
        </div>
      </footer>
    </div>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>