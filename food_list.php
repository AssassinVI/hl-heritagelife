<?php
//-- 共用連線 --
require 'share_area/conn.php';

$mt_id='site2018110610481744';

$row_mt=$pdo->select("SELECT * FROM maintable WHERE Tb_index=:Tb_index", ['Tb_index'=>$mt_id], 'one');

?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="zh-tw"">
  <head>
    <!-- Site Title-->
    <title><?php echo $row_mt['MT_Name'];?>｜襲園生活</title>
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

      <section class="bg-default section-lg">
        <div class="container">
          <div class="row row-60">
           <?php
             $row_art=$pdo->select("SELECT * FROM appArticle WHERE mt_id=:mt_id AND OnLineOrNot=1 ORDER BY OrderBy DESC, StartDate DESC", ['mt_id'=>$mt_id]);
             foreach ($row_art as $art) {
               $url='food_detail.php?mt_id='.$art['mt_id'].'&Tb_index='.$art['Tb_index'];
               $time=date('Y-m-d', strtotime($art['StartDate']));
               echo '
               <div class="col-md-6 col-xl-4" title="'.$art['aTitle'].'">
                  <article class="post-classic post-minimal"><img src="sys/img/'.$art['aPic'].'" alt="" width="418" height="315"/>
                    <div class="post-classic-title">
                      <h5 class="list_title" ><a href="'.$url.'">'.$art['aTitle'].'</a></h5>
                    </div>
                    <div class="post-meta">
                      <div class="group"><a href="'.$url.'">
                          <time>'.$time.'</time></a><a class="meta-author" >'.$art['aPoster'].'</a></div>
                    </div>
                  </article>
               </div>';
             }
           ?>
           
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
  </body>
</html>