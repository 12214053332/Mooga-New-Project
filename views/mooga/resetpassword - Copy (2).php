								
<div class="container">
    <div class="row">
        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 center-table">
            <h2 class="full-lines sm-font"><span class="black-font">تغيير كلمه المرور</span></h2>
            <p class="grey-font md-font text-center">من فضلك أدخل كلمة المرور الجديدة</p>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs">
                
                <div class="tab-content">
				
                    <div role="tabpanel" class="col-md-12 col-lg-12 col-xs-12 col-sm-12 tab-pane active dark-grey" id="resetpassword">
                        <div class="row">
                         
                                        <div class="form-group">
                                            
                                        </div>
										<div class="form-group">
										
                                        </div>
                                        <div class="form-group">
                                            
                                        </div>
                          
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class="col-md-10 col-lg-10 col-xs-10 col-sm-10 center-table">
                                    <form class="login-form col-md-8 col-lg-8 col-xs-12 col-sm-12 center-table" action="#" method="post" id="resetpassword-form" name="resetpassword-form">
									  <input type="hidden" class="form-control" id="token" name="token"value="<?php echo $token; ?>">
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
                                        
                                        <div class="form-group">
                                            <div class="">
                                                <button name="submit" class="btn orange-btn">تغيير كلمة المرور</button>
                                            </div>
											
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
            </div>
        </div>
    </div>
</div>
