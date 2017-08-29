
<div id="breadcrum-inner-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="breadcrum-inner-header">
                    <h1>تغيير كلمه المرور</h1>
                    <a href="/">الرئيسية</a> <i class="fa fa-circle"></i> <a href="?page=login"><span>تغيير كلمه المرور</span></a> </div>
            </div>
        </div>
    </div>
</div>



<div id="vfx-product-inner-item">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4 listing-modal-1">
                <div class="text-center">
                    <h4 class="title-login-form">
                        تغيير كلمه المرور
                    </h4>

                </div>
                <p>من فضلك أدخل كلمة المرور الجديدة</p>
                <div class="clearfix"></div>
                <div class="listing-login-form">
                    <form action="#" method="post" id="resetpassword-form" name="resetpassword-form">
                        <input type="hidden" class="form-control" id="token" name="token"value="<?php echo $token; ?>">
                        <div class="listing-form-field">
                            <input class="form-field bgwhite" type="password" name="password"  id="password" placeholder="أدخل كلمة المرور" required  />
                            <label for="password"></label>
                        </div>
                        <div class="listing-form-field">
                            <input class="form-field bgwhite" type="password" name="confirmpassword"  id="confirmpassword" placeholder="تأكيد كلمة المرور" required  />
                            <label for="confirmpassword"></label>
                        </div>
                        <div class="listing-form-field">
                            <input class="form-field submit" name="submit" type="submit" value="تغير كلمة المرور" />
                        </div>
                        <div  class="form-group">
                            <div id="resetpassword-response">

                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
