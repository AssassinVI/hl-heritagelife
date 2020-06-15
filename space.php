<?php
//-- 共用連線 --
require 'share_area/conn.php';

$mt_id=$_GET['mt_id'];

$row_mt=$pdo->select("SELECT * FROM maintable WHERE Tb_index=:Tb_index", ['Tb_index'=>$mt_id], 'one');

?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="zh-tw">
  <head>
    <!-- Site Title-->
    <title><?php echo $row_mt['MT_Name'];?>｜襲園生活</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $company['description'];?>">
    
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
       //-- 公用header --
       require 'share_area/header.php';
      
      ?>

     
      <section class="text-center">
        <!-- RD Parallax-->
        <div class="parallax-container bg-image parallax-header rd-parallax-light" data-parallax-img="sys/img/<?php echo $row_mt['aPic'];?>">
          <div class="parallax-content">
            <div class="parallax-header__inner">
              <div class="parallax-header__content">
                <div class="container">
                  <div class="row justify-content-sm-center">
                    <div class="col-md-10 col-xl-8">
                      <h2><?php echo $row_mt['MT_Name'];?></h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="bg-default section-md">
        
        <div class="container">
          <div class=" text-center pb-5">
            <div class="title_div">
              <h2><?php echo $row_mt['MT_Name'];?></h2>
            </div>
          </div>



        <section class=" bg-default text-center" id="section-see-features">
        <div class="container">
          <div class="row justify-content-lg-center">
            <div class="col-lg-10 col-xl-8">

              <p>Monstroid² boasts clean and crispy design, bulletproof layout consistency and intuitive navigation. The template was created by top industry leaders in web design and user experience. Improve your audience engagement and loyalty with simple and user friendly tools offered by our template.</p>
            </div>
          </div>
          <div class="row row-50">
            <div class="col-md-6 col-lg-4">
              <!-- Blurb circle-->
              <article class="blurb blurb-circle blurb-circle_centered">
                <div class="blurb-circle__icon"><span class="icon linear-icon-feather"></span></div>
                <p class="blurb__title">Clean and Crispy Design</p>
                <p>Monstroid² is crafted by top industry leaders with love, care and customer needs in mind.</p>
              </article>
            </div>
            <div class="col-md-6 col-lg-4">
              <!-- Blurb circle-->
              <article class="blurb blurb-circle blurb-circle_centered">
                <div class="blurb-circle__icon"><span class="icon linear-icon-menu3"></span></div>
                <p class="blurb__title">Customizable Template</p>
                <p>Use our Template to customize and update your website within seconds.</p>
              </article>
            </div>
            <div class="col-md-6 col-lg-4">
              <!-- Blurb circle-->
              <article class="blurb blurb-circle blurb-circle_centered">
                <div class="blurb-circle__icon"><span class="icon linear-icon-bag2"></span></div>
                <p class="blurb__title">Advanced UI Toolkit</p>
                <p>Monstroid² comes with a powerful and flexible extended toolkit in addition to basic Bootstrap.</p>
              </article>
            </div>
          </div>
        </div>
      </section>
        </div>
      </section>



      <section class="section-xl bg-gray-lighter">
        <div class="container">
          <div class="row justify-content-md-center flex-lg-row-reverse align-items-lg-center justify-content-lg-between row-50">
            <div class="col-md-9 col-lg-6">
              <h3>Impressive Features</h3>
              <!-- Blurb minimal-->
              <article class="blurb blurb-minimal">
                <div class="unit flex-row unit-spacing-md">
                  <div class="unit-left">
                    <div class="blurb-minimal__icon"><span class="icon linear-icon-rocket"></span></div>
                  </div>
                  <div class="unit-body">
                    <p class="blurb__title">Built for Speed</p>
                    <p>Built for speed and performance. Get the best results at GTmetrix and Google PageSpeed.</p>
                  </div>
                </div>
              </article>
              <!-- Blurb minimal-->
              <article class="blurb blurb-minimal">
                <div class="unit flex-row unit-spacing-md">
                  <div class="unit-left">
                    <div class="blurb-minimal__icon"><span class="icon linear-icon-equalizer"></span></div>
                  </div>
                  <div class="unit-body">
                    <p class="blurb__title">Flexible and Multipurpose</p>
                    <p>Monstroid² allows to create various websites for complex and scalable  projects.</p>
                  </div>
                </div>
              </article>
              <!-- Blurb minimal-->
              <article class="blurb blurb-minimal">
                <div class="unit flex-row unit-spacing-md">
                  <div class="unit-left">
                    <div class="blurb-minimal__icon"><span class="icon linear-icon-arrow-down-square"></span></div>
                  </div>
                  <div class="unit-body">
                    <p class="blurb__title">Social Integration</p>
                    <p>You can easily integrate your Twitter and Facebook accounts with the website using the social widgets.</p>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-md-7 col-lg-4">
              <figure class="image-sizing-1"><img src="sys/img/article2020042910570690_others_0.jpg" alt="" width="388" height="608"/>
              </figure>
            </div>
          </div>
        </div>
      </section>




      <section class="section-xl bg-default">
        <div class="container">
          <div class="row justify-content-md-center align-items-lg-center justify-content-lg-between row-50">
            <div class="col-md-9 col-lg-5">
              <h3>Content Driven Design</h3>
              <p>Unlike many other templates Monstroid² is built around user content but not vice versa. Thus you may be sure when you add your own texts and images the template will look same cool and appealing.</p>
            </div>
            <div class="col-md-9 col-lg-6">
              <div class="row gallery-wrap">
                <div class="col-6">
                  <figure><img src="https://uart.qrl.tw/hl-heritagelife/sys/img/article2020042914154588.jpg" alt="" width="301" height="227"/>
                  </figure>
                </div>
                <div class="col-6">
                  <figure><img src="https://uart.qrl.tw/hl-heritagelife/sys/img/article2020042914124728.jpg" alt="" width="301" height="227"/>
                  </figure>
                </div>
                <div class="col-6">
                  <figure><img src="https://uart.qrl.tw/hl-heritagelife/sys/img/article2020042914124728.jpg" alt="" width="301" height="227"/>
                  </figure>
                </div>
                <div class="col-6">
                  <figure><img src="https://uart.qrl.tw/hl-heritagelife/sys/img/article2020042914090715140921.jpg" alt="" width="301" height="227"/>
                  </figure>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


      <section class="bg-gray-dark text-center">
              <!-- RD Parallax-->
              <div class="parallax-container bg-image rd-parallax-light" data-parallax-img="https://uart.qrl.tw/hl-heritagelife/sys/img/article2020042910504425105120.jpg">
                <div class="parallax-content">
                  <div class="container section-xxl">
                    <h2>Like What We Offer?</h2>
                    <p>Start with this demo now or check out the others to choose what you need.</p><a class="button button-primary" href="#">View now!</a>
                  </div>
                </div>
              </div>
      </section>



      <!-- Divider-->
      <div class="container">
        <div class="divider"></div>
      </div>
      
      <!-- 頁數 -->
      <!-- <section class="section-md text-center">
        <div class="container">
          <nav>
            <ul class="pagination-classic">
              <li class="active"><span>1</span></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a class="icon linear-icon-arrow-right" href="#"></a></li>
            </ul>
          </nav>
        </div>
      </section> -->


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
    <script>
      $(document).ready(function () {
        $('.post-minimal').mouseenter(function () { 
           $(this).find('.img_a').addClass('active');
        });
        $('.post-minimal').mouseleave(function () { 
           $(this).find('.img_a').removeClass('active');
        });
      });
    </script>
  </body>
</html>