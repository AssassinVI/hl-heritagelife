<!-- Page Footer-->
      <section class="pre-footer-corporate">
        <div class="container">
          <div class="row justify-content-sm-center justify-content-lg-start row-30 row-md-60">
            <div class="col-sm-10 col-md-6 col-lg-10 col-xl-3">
              <h6 class="text-regular">關於</h6>
              <p><?php echo $company['description'];?></p>
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