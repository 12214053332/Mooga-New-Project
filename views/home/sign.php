<?php 
$cookie_name = 'WinWinBiz2016Cooook';
$cookiesUser="";
$cookiesPass="";
$rememberme='';

if(isset($_COOKIE[$cookie_name]))
  {

   parse_str($_COOKIE[$cookie_name]);
    $cookiesUser=$user;
    $cookiesPass=$pass;
    
    if ($remember>=1)
       $rememberme ='checked';   
  }
  
?>

<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
                    <i class="fa fa-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-snd-msg">
                    <span class="lnr lnr-users lg-span"></span>
                </div>
                <p class="modal-title-main">welcome dear client</p>
                <p class="modal-title-sub">sign up to wwb</p>
                <div class="row">
                    <div class="registerresult"></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a href="fblogin/fbconfig.php" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-green btn-facebook"><i class="fa fa-facebook"></i>sign up with facebook</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a href="linkedinuser/process.php" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-green btn-linkedin"><i class="fa fa-linkedin"></i>sign up with linkedin</a>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p class="p-lines"><span class="text-lines">or</span></p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form class="form-horizontal"  id="RegisterForm" action="#" method="post">
                            
                            
                            <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-pdg-lft">
                                <input required="" type="text" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-control cst-form-input " id="firstname"  name="firstname" placeholder="First Name">
                            </div>
                           
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-pdg-rt">
                                <input required="" type="text" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-control cst-form-input" id="lastname" name="lastname" placeholder="Last Name">
                            </div>
                          </div>
                            
                            <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-pdg-lft">
                                <input required="" type="email" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-control cst-form-input " id="email"  name="email" placeholder="Username / Email">
                            </div>
                           
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-pdg-rt">
                                <input required="" type="password" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-control cst-form-input" id="password" name="password" placeholder="Password">
                            </div>
                          </div>
                            <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-pdg-rt">
                                <input required="" type="password" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-control cst-form-input" id="password_confirm" name="password_confirm" placeholder="Confirm Password">
                            </div>
                           </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-green btn-black" value="Register">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="checkbox pull-left">
                                        <label class="italic-privacy">
                                            <input  type="checkbox">i agree to the <a href="" class="">terms of service</a> & <a href="#">privacy policy</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="signin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
                    <i class="fa fa-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-snd-msg">
                    <span class="lnr lnr-users lg-span"></span>
                </div>
                <p class="modal-title-main">welcome dear client</p>
                <p class="modal-title-sub">sign in to your account</p>
                <div class="row">
                     <div class="result"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      
                        <form class="form-horizontal" id="login-form" method="post" action="#">
                           
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pdg-zero top-mrg btm-mrg">
                                <input required type="email" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-control cst-form-input" value="<?php echo $cookiesUser ?>" name="username"  id="username" placeholder="Username / Email">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pdg-zero top-mrg btm-mrg">
                                <input required type="password" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-control cst-form-input" value="<?php echo $cookiesPass ?>" name="password"  id="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 col-lg-4 col-md-4 col-xs-12">
                                    <div class="checkbox pull-left">
                                        <label class="italic-privacy">
                                            <input type="checkbox" name="rememberme" <?php echo $rememberme ?> >remember
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-8 col-md-8 col-xs-12 pdg-zero cst-mgr-tp">
                                    <p class="italic-privacy pull-right">
                                        <a href="" class="normal-link">Register</a>
                                        <a href="?page=forgetpassword">forget password</a>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-green btn-black" value="sign in">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <p class="sm-title-gen-droid left">sign in using</p>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <a href="fblogin/fbconfig.php" class="facebook_bg"><i class="fa fa-facebook"></i></a>
                        <a href="linkedinuser/process.php" class="linkedin_bg"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

