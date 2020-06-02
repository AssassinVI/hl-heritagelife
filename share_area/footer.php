<!-- Page Footer-->
      <div class="logo_div">

              <!-- <ul class="brands_icon">
                <li><a href="#"><img class="logo_n_hover" src="img/logo_l_d1.png"><img class="logo_hover" src="img/logo_l_1.png"></a></li>
                <li><a href="#"><img class="logo_n_hover" src="img/logo_l_d2.png"><img class="logo_hover" src="img/logo_l_2.png"></a></li>
                <li><a href="#"><img class="logo_n_hover" src="img/logo_l_d3.png"><img class="logo_hover" src="img/logo_l_3.png"></a></li>
                <li><a href="#"><img class="logo_n_hover" src="img/logo_l_d4.png"><img class="logo_hover" src="img/logo_l_4.png"></a></li>
              </ul> -->


             <div class="swiper-container logo_sw">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="#"><img class="logo_n_hover" src="img/logo_l_d1.png"><img class="logo_hover" src="img/logo_l_1.png"></a></div>
                    <div class="swiper-slide"><a href="#"><img class="logo_n_hover" src="img/logo_l_d2.png"><img class="logo_hover" src="img/logo_l_2.png"></a></div>
                    <div class="swiper-slide"><a href="#"><img class="logo_n_hover" src="img/logo_l_d3.png"><img class="logo_hover" src="img/logo_l_3.png"></a></div>
                    <div class="swiper-slide"><a href="#"><img class="logo_n_hover" src="img/logo_l_d4.png"><img class="logo_hover" src="img/logo_l_4.png"></a></div>
                </div>
            </div>


</div>      

<section class="pre-footer-corporate">
        <div class="container">
          <div class="row justify-content-sm-center justify-content-xl-center row-30 row-md-60">
            <div class="col-sm-10 col-md-6 col-lg-10 col-xl-3">
              <h6 class="text-regular">關於</h6>
              <p><?php echo $company['description'];?></p>
            </div>
            <div class="col-sm-10 col-md-6 col-lg-3 col-xl-3">
              <h6 class="text-regular">選單</h6>
              <div class="row">
                <div class="col-md-6 col-6">
                  <ul class="list-xxs">
                    <li><a href="article_list.php?mt_id=site2018110610481744">食事日常</a></li>
                    <li><a href="article_list.php?mt_id=site2020042914035766">職人嚴選</a></li>
                    <li><a href="article_list.php?mt_id=site2020042914164188">空間美學</a></li>
                    <li><a href="article_list.php?mt_id=site2020042914190418">襲園行旅</a></li>
                  </ul>
                </div>
                <div class="col-md-6 col-6">
                  <ul class="list-xxs">
                    <li><a href="brands_list.php">品牌頻道</a></li>
                    <li><a href="#">嚴選好物</a></li>
                    <li><a href="contacts.php">聯絡我們</a></li>
                    <li><a href="login.php">登入</a></li>
                  </ul>
                </div>
              </div>
            </div>

            
            
            <div class="col-sm-10 col-md-6 col-lg-4 col-xl-4">
              <h6 class="text-regular">聯絡我們</h6>
              <ul class="list-xs">
                <li>
                  <dl class="list-terms-minimal">
                    <dt>公司地址</dt>
                    <dd><?php echo $adds= str_replace(',','',$company['adds']);?></dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>公司電話</dt>
                    <dd>
                      <ul class="list-semicolon">
                        <li><a href="tel:<?php echo $company['phone'];?>"><?php echo $company['phone'];?></a></li>
                        
                      </ul>
                    </dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>連絡信箱</dt>
                    <dd><a href="mailto:<?php echo $company['email'];?>"><?php echo $company['email'];?></a></dd>
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
            <p class="text-center"><?php echo $company['name'];?>Ⓒ COPYRIGHT 2020. ALL RIGHT RESERVED.</p>
          </div>
        </div>
      </footer>