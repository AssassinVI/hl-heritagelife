<!-- Modal login window-->
    <div class="modal fade" id="modalLogin" role="dialog">
      <div class="modal-dialog modal-dialog_custom">
        <!-- Modal content-->
        <div class="modal-dialog__inner">
          <button class="close" type="button" data-dismiss="modal"></button>
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
              <button class="button button-primary" type="submit">登入</button>
            </form>
            <ul class="list-small">
              <li><a href="#">忘記您的帳號?</a></li>
              <li><a href="#">忘記您的密碼?</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal register window-->
    <div class="modal fade" id="modalRegister" role="dialog">
      <div class="modal-dialog modal-dialog_custom">
        <!-- Modal content-->
        <div class="modal-dialog__inner">
          <button class="close" type="button" data-dismiss="modal"></button>
          <div class="modal-dialog__content">
            <h5>註冊會員</h5>
            <!-- RD Mailform-->
            <form class="rd-mailform rd-mailform_responsive" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php">
              <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-envelope"></span>
                <input class="form-input" id="modal-register-email" type="email" name="email" data-constraints="@Email @Required">
                <label class="form-label" for="modal-register-email">E-mail(帳號)</label>
              </div>
              <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-lock"></span>
                <input class="form-input" id="modal-register-password" type="password" name="password" data-constraints="@Required">
                <label class="form-label" for="modal-register-password">密碼</label>
              </div>
              <div class="form-wrap form-wrap_icon"><span class="novi-icon form-icon linear-icon-lock"></span>
                <input class="form-input" id="modal-register-password2" type="password" name="password2" data-constraints="@Required">
                <label class="form-label" for="modal-register-password2">再輸入一次密碼</label>
              </div>
              <div class="form-wrap">
                <label class="checkbox-inline">
                  <input type="checkbox" name="remember">記住我
                </label>
              </div>
              <button class="button button-primary" type="submit">註冊</button>
            </form>
          </div>
        </div>
      </div>
    </div>