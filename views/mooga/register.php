
<div id="breadcrum-inner-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="breadcrum-inner-header">
                    <h1>تسجيل</h1>
                    <a href="/">الرئيسية</a> <i class="fa fa-circle"></i> <a href="?page=login"><span>تسجيل</span></a> </div>
            </div>
        </div>
    </div>
</div>



<div id="vfx-product-inner-item">
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 listing-modal-1">
            <div class="text-center">
                <h4 class="title-login-form">
تسجيل
                </h4>

            </div>
            <p>إبدأ رحلتك مع منصة موجة بتسجيل الدخول أو تفعيل إشتراكك الذي كونته</p>
            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <div class="clearfix" style="height: 20px"></div>
            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                <a class="btn facebook-btn" href="fblogin/fbconfig.php">من خلال حسابك في</a>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                <a class="btn linkedin-btn" href="linkedinuser/process.php">من خلال حسابك في</a>
            </div>
            <div class="clearfix"></div>
            <div class="clearfix" style="height: 20px"></div>
            <div class="col-md-12 contact-heading-title text-center bt_heading_3">
                <h1>او من خلال</h1>
                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>
            <div class="listing-login-form">
                <div class="from-list-lt">
                <form class="login-form listing-register-form" action="?page=_usersaction&action=signup" method="post"  id="signup-form" name="sinup-form">
                    <div class="form-group">
                        <div id="signup-response">

                        </div>
                    </div>
                    <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <label for="" class="control-label"><span class="asterisc">*</span> الاسم </label>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">

                            <input type="text" class="form-control" id="name" name="name" placeholder="أدخل الاسم " required>

                            <label for="name"></label>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <label for="" class="control-label"><span class="asterisc">*</span>البريد الإلكتروني</label>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">

                            <input type="email" class="form-control" id="email" name="email" placeholder="أدخل البريد الإلكتروني" required>
                            <label for="email"></label>
                        </div>
                    </div>


                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="form-group col-md-6 col-lg-6 col-xs-12 col-sm-12">
                            <label  class="control-label text-center"><span class="asterisc">*</span>الدولة</label>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">

                                <select class="form-control chosen-select" id="country" name="country" required>

                                    <option value="">اختر</option>
                                    <?php

                                    foreach ($countries as $country) {
                                        $id=$country['id'];
                                        $name=$country['name'];
                                        $code=$country['code'];
                                        echo " <option value='$id'  data-code='$code' >$name</option> ";
                                    }
                                    ?>
                                </select>
                                <label for="country"></label>
                            </div>
                        </div>

                        <div class="form-group  col-md-6 col-lg-6 col-xs-12 col-sm-12">
                            <label  class=" control-label text-center">

                                <span class="asterisc">*</span>المحافظة</label>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">

                                <select class="form-control chosen-select" id="states" name="states" >

                                    <option value="">اختر</option>

                                </select>
                                <label for="states"></label>
                            </div>
                        </div>

                        <div class="form-group  col-md-6 col-lg-6 col-xs-12 col-sm-12">
                            <label  class="control-label text-center">

                                <span class="asterisc">*</span>المدينة</label>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">

                                <select class="form-control chosen-select" id="cities" name="cities" >

                                    <option value="">اختر</option>

                                </select>
                                <label for="cities"></label>
                            </div>
                        </div>

                        <div class="form-group  col-md-6 col-lg-6 col-xs-12 col-sm-12">

                            <label  class=" control-label text-center"><span class="asterisc">*</span>الهاتف</label>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div name="code" id="code" class="phone-code" ></div>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="أدخل الهاتف"  required>
                                <label for="phone"></label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group col-md-6 col-lg-6 col-xs-12 col-sm-12">
                        <label for="" class="control-label"><span class="asterisc">*</span>كلمة المرور</label>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">

                            <input type="password" class="form-control" id="password" name="password" placeholder="أدخل كلمة المرور"  required>
                            <label for="password"></label>
                        </div>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-xs-12 col-sm-12">
                        <label for="" class=" control-label"><span class="asterisc">*</span>تأكيد كلمة المرور</label>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">

                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="تأكيد كلمة المرور"  required>
                            <label for="confirmpassword"></label>
                        </div>
                    </div>


                    <!--<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label"><span class="asterisc">*</span>نوع الحساب </label>
                            <div class="col-sm-6">

                              <select class="form-control" id="account_type" name="account_type">
                                   <option value="">اختر</option>
                                   <option value="فردى">فردى</option>
                                   <option value="شركة">شركة</option>
                             </select>
                            <label for="account_type"></label>
                            </div>
                        </div>
                    </div>-->


                    <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="col-md-10 col-lg-10 col-xs-11 col-sm-11 center-table">
                            <div class="listing-form-field clearfix margin-top-20 margin-bottom-20">
                                <input type="checkbox" id="checkbox-1-1" class="regular-checkbox">
                                <label for="checkbox-1-1"></label>
                                <label class="checkbox-lable">
                                    <span class="asterisc">*</span>أوافق على كافة <a target="_blank" href="?page=terms">الشروط والأحكام</a> اللازمة للتسجيل في الموقع
                                </label>
                            </div>
                            <label for="agree"></label>
                        </div>
                    </div>
                    <div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                        <div class="">
                            <button class="btn orange-btn">تسجيل </button>
                        </div>
                    </div>



                </form>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
