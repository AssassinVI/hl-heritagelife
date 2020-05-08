<?php
//-- 共用連線 --
require 'share_area/conn.php';

$mt_id='site2020042916243587';

if ($_POST) {
  //-- GOOGLE recaptcha 驗證程式 --
   GOOGLE_recaptcha('6Le-hSUTAAAAAKpUuKnGOoHpKhgq60V1irZPA_4E', $_POST['g-recaptcha-response'], 'back');

   $param=[
     'mt_id'=>$mt_id,
     'UserName'=>$_POST['name'],
     'UserMail'=>$_POST['email'],
     'UserPhone'=>$_POST['phone'],
     'UserMsg'=>$_POST['message'],
     'StartDate'=>date('Y-m-d')
   ];
   $pdo->insert('appContacts', $param);
   
   
   $name_data=['呂'];
   $adds_data=['d974252037@gmail.com'];
   $body_data="
      <table border='1' cellpadding='5' cellspacing='0'>
      <tr>
        <td >姓名:</td>
        <td>".$_POST[ 'name' ]."</td>
      </tr>
      
      <tr>
        <td >Email:</td>
        <td >".$_POST[ 'email' ]."</td>
      </tr>

      <tr>
        <td >手機:</td>
        <td >".$_POST[ 'phone' ]."</td>
      </tr>
      <tr>
        <td colspan='1'>Message:</td>
        <td colspan='3'>".nl2br($_POST[ 'message' ])."</td>
      </tr>
    </table>";

   send_Mail('襲園生活系統', 'heritagelife@uart.qrl.tw', '襲園生活365-聯絡我們', $body_data, $name_data, $adds_data);

   location_up('contacts.php','感謝您的來信');

}



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

     
      <section class="section-lg bg-default">
        <div class="container">
          <div class="row row-50">
            <div class="col-md-5 col-lg-4">
              <h3>聯絡我們</h3>
              <ul class="list-xs contact-info">
                <li>
                  <dl class="list-terms-minimal">
                    <dt>公司地址</dt>
                    <dd><?php echo $adds= str_replace(',','',$company['adds']);?></dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>Phones</dt>
                    <dd>
                      <ul class="list-semicolon">
                        <li><a href="tel:<?php echo $company['phone'];?>"><?php echo $company['phone'];?></a></li>
                      </ul>
                    </dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>E-mail</dt>
                    <dd><a href="mailto:<?php echo $company['email'];?>"><?php echo $company['email'];?></a></dd>
                  </dl>
                </li>
                
                <li>
                  <ul class="list-inline-sm">
                    <li><a class="icon-sm fa-facebook icon" href="#"></a></li>
                    <li><a class="icon-sm fa-twitter icon" href="#"></a></li>
                    <li><a class="icon-sm fa-vimeo icon" href="#"></a></li>
                    <li><a class="icon-sm fa-pinterest-p icon" href="#"></a></li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="col-md-7 col-lg-8">
              <!-- RD Mailform-->
              <form id="contact_form" class=""  method="post" action="">
                <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-man"></span>
                  <input class="form-input" id="contact-name" type="text" name="name" >
                  <label class="form-label" for="contact-name">姓名</label>
                </div>
                <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-envelope"></span>
                  <input class="form-input" id="contact-email" type="email" name="email" >
                  <label class="form-label" for="contact-email">信箱</label>
                </div>
                <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-telephone"></span>
                  <input class="form-input" id="contact-phone" type="text" name="phone" >
                  <label class="form-label" for="contact-phone">手機</label>
                </div>
                <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-feather"></span>
                  <textarea class="form-input" id="contact-message" name="message" ></textarea>
                  <label class="form-label" for="contact-message">內容</label>
                </div>

                <div class="form-wrap form-wrap_icon">
                  <!-- google 驗證碼 -->
                  <div class="g-recaptcha" data-sitekey="6Le-hSUTAAAAABhfvrZeqewWS6hENhApDVtdAJfr"></div>
                </div>

                <button class="button button-primary sub_btn" type="button"">送出</button>
              </form>
            </div>
          </div>
        </div>
      </section>
      <!-- Divider-->
      <div class="container">
        <div class="divider"></div>
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
    <!-- GOOGLE recaptcha 驗證程式 -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
      $(document).ready(function () {
         $('.sub_btn').click(function (e) { 
           var err_txt='';

           err_txt+=check_input('#contact-name','姓名\n');
           err_txt+=check_input('#contact-email','email\n');
           err_txt+=check_input('#contact-phone','手機\n');
           err_txt+=check_input('#contact-message','內容\n');

           if(err_txt!=''){
             alert('請輸入'+err_txt);
           }
           else{
             $('#contact_form').submit();
           }
           
         });
      });
    </script>

  </body>
</html>