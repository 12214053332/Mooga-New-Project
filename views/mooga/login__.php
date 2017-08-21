
<div class="container">
    <div class="row">
        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 center-table">
            <h2 class="full-lines sm-font"><span class="black-font">تسجيل الدخول</span></h2>
            <p class="grey-font md-font text-center">إبدأ رحلتك مع منصة موجة  بتسجيل الدخول او تفعيل إشتراكك الذي كونته</p>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs">
                <ul class="nav nav-tabs nav-justified zero-right-padding " role="tablist">
                    <li role="presentation" class="<?php if ($currentpage=="login"){echo "active";} ?>"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">الدخول إلى حسابك</a></li>
                    <li role="presentation" class="<?php if ($currentpage=="signup"){echo "active";} ?>"><a href="#signup" aria-controls="signup" role="tab" data-toggle="tab">إنشاء حساب جديد</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="col-md-12 col-lg-12 col-xs-12 col-sm-12 tab-pane <?php if ($currentpage=="login"){echo "active";} ?> dark-grey" id="login">
                        <div class="row">
                         
							
							 <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <a class="btn facebook-btn" href="fblogin/fbconfig.php">من خلال حسابك في</a>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <a class="btn linkedin-btn" href="linkedinuser/process.php">من خلال حسابك في</a>
                            </div>
							
							
                            <div class="col-md-10 col-lg-10 col-xs-11 col-sm-11 center-table">
                                <h2 class="full-lines sm-font"><span class="black-font">او من خلال حسابك</span></h2>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class="col-md-10 col-lg-10 col-xs-10 col-sm-10 center-table">
                                    <form class="login-form col-md-8 col-lg-8 col-xs-12 col-sm-12 center-table" action="?page=_usersaction&action=login" method="post" id="login-form" name="login-form">
									
                                        <div class="form-group">
										    
                                            <input type="email" id="uemail" name="email" class="form-control" value="<?php echo $rememberme->username; ?>" placeholder="البريد الإلكترونى" required >
											<label for="uemail"></label>
                                        </div>
                                        <div class="form-group">
										
                                            <input type="password" id="upassword" name="password"  value="<?php echo $rememberme->password; ?>" class="form-control" placeholder="كلمة المرور" required >
											<label for="upassword"></label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <a href="?page=forgetpassword" class="md-font blue-link text-right">نسيت كلمة السر</a>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="checkbox">
                                                    <label class="black-font md-font">
                                                        <input name="remember_me" type="checkbox" value="1" <?php echo $rememberme->rememberme; ?>> تذكرني
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <button class="btn orange-btn">تسجيل الدخول</button>
                                            </div>
											
                                        </div>
										<div class="form-group">
											<div id="login-response">
                                                
                                            </div>
											 </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="col-md-12 col-lg-12 col-xs-12 col-sm-12 tab-pane <?php if ($currentpage=="signup"){echo "active";} ?> dark-grey" id="signup">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <a class="btn facebook-btn" href="fblogin/fbconfig.php">من خلال حسابك في</a>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <a class="btn linkedin-btn" href="linkedinuser/process.php">من خلال حسابك في</a>
                            </div>
                            <div class="col-md-10 col-lg-10 col-xs-11 col-sm-11 center-table">
                                <h2 class="full-lines sm-font"><span class="black-font">او من خلال حسابك</span></h2>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class="col-md-10 col-lg-10 col-xs-10 col-sm-10 center-table">
                                    <form class="login-form col-md-12 col-lg-12 col-xs-12 col-sm-12" action="?page=_usersaction&action=signup" method="post"  id="signup-form" name="sinup-form">
                                        <div class="form-group">
                                            <div id="signup-response">
                                                
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="" class="col-sm-3 control-label"><span class="asterisc">*</span> الإسم الثلاثي</label>
                                            <div class="col-sm-9">
											
											  <input type="text" class="form-control" id="name" name="name" placeholder="أدخل الأسم الثلاثى" required>
											  
                                            	<label for="name"></label>                                              
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-3 control-label"><span class="asterisc">*</span>البريد الإلكتروني</label>
                                            <div class="col-sm-9">
											
                                                <input type="email" class="form-control" id="email" name="email" placeholder="أدخل البريد الإلكتروني" required>
                                            <label for="email"></label>
											</div>
                                        </div>
                                         
										 	
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label  class="col-sm-6 control-label text-center"><span class="asterisc">*</span>الدولة</label>
                                                <div class="col-sm-6">
                                                  
												<select class="form-control" id="country" name="country" required>
												
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
                                        </div>
										
										     <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                             <div class="form-group">
                                          
											 <label  class="col-sm-6 control-label text-center"><span class="asterisc">*</span>الهاتف</label>
                                            <div class="col-sm-6">
											 
                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="أدخل الهاتف"  required>
												<label for="phone"></label>
                                            </div>
                                        </div>
                                        </div>
										
					                
										
										<div class="form-group">
                                            <label for="" class="col-sm-3 control-label"><span class="asterisc">*</span>كلمة المرور</label>
                                            <div class="col-sm-9">
											
                                                <input type="password" class="form-control" id="password" name="password" placeholder="أدخل كلمة المرور"  required>
                                            <label for="password"></label>
											</div>
                                        </div>
										
										<div class="form-group">
                                            <label for="" class="col-sm-3 control-label"><span class="asterisc">*</span>تأكيد كلمة المرور</label>
                                            <div class="col-sm-9">
												
											  <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="تأكيد كلمة المرور"  required>
											  <label for="confirmpassword"></label>                                              
                                            </div>
                                        </div>
										
										
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
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
                                        </div>
									
                                        
                                        <div class="form-group">
                                            <div class="col-md-10 col-lg-10 col-xs-11 col-sm-11 center-table">
											
                                                <div class="checkbox center-form-text">
												
                                                    <label >
                                                        <input type="checkbox"  id="agree" name="agree" required><span class="asterisc">*</span>أوافق على كافة الشروط والأحكام اللازمة للتسجيل في الموقع
                                                    </label>
                                                </div>
												<label for="agree"></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <button class="btn orange-btn">تسجيل الدخول</button>
                                            </div>
                                        </div>

										
										
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
