<?php
//-- 共用連線 --
require 'share_area/conn.php';

// $mt_id=$_GET['mt_id'];

// $row_mt=$pdo->select("SELECT * FROM maintable WHERE Tb_index=:Tb_index", ['Tb_index'=>$mt_id], 'one');

?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="zh-tw">
  <head>
    <!-- Site Title-->
    <title>襲園生活</title>
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
        <div class="parallax-container bg-image parallax-header rd-parallax-light" data-parallax-img="img/pump.jpg">
          <div class="parallax-content">
            <div class="parallax-header__inner">
              <div class="parallax-header__content">
                <div class="container">
                  <div class="row justify-content-sm-center">
                    <div class="col-md-10 col-xl-8">
                      <h2>登入會員</h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

        <div class="modal-dialog modal-dialog_custom">
          <!-- Modal content-->
          <div class="modal-dialog__inner">
            <div class="modal-dialog__content">
              <h5>登入會員</h5>
              <!-- RD Mailform-->
              <form class="rd-mailform rd-mailform_responsive">
                <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-envelope"></span>
                  <input class="form-input" id="modal-login-email" type="email" name="email" data-constraints="@Email @Required">
                  <label class="form-label" for="modal-login-email">E-mail(帳號)</label>
                </div>
                <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-lock"></span>
                  <input class="form-input" id="modal-login-password" type="password" name="password" data-constraints="@Required">
                  <label class="form-label" for="modal-login-password">密碼</label>
                </div>
                <button class="button button-primary" type="submit">FB登入</button>
                <button class="button button-primary" type="submit">登入</button>
              </form>
              <ul class="list-small">
                <li><a href="#">忘記您的帳號?</a></li>
                <li><a href="#">忘記您的密碼?</a></li>
              </ul>
            </div>
          </div>
        </div>

      
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