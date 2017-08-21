
	
   


	 
	    <?php include("wedget/user-header.php") ?> 
		<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <h2 class="full-lines sm-font"><span class="blue-font"><?php echo $opportunity->name ?></span></h2>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding">
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-6 col-sm-6">
                                <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                    <img src="<?php  echo $opportunity->profilepic ; ?> " class="">
                                    <a class="sm-border-btn round-corner grey-border" href="<?php  if (isset($getuserid)){ echo '?page=newmessage&uid='.$opportunity->user_id;} else {echo '?page=login';}  ?>"><i class="message-box"></i></a>
                                     <a href="javascript:void(0)"  title="أظهار رقم التليفون" data-record="<?php echo $opportunity->id ?>" data-user="<?php echo $opportunity->userid ?>" class="sm-border-btn round-corner grey-border  <?php  if (isset($getuserid)){ echo 'opportunity-show-phone';} else {  echo 'go-to-login' ;}  ?> "><i class="call-icon"></i> </a>
								
								</div>
                                <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 def-padding zero-top-padding">
                                    <p class="sm-font black-font">
                                       <?php  echo $opportunity->username ?> 
                                    </p>
                                    <p class="md-font orange-font">رائد أعمال في الصناعة</p>
                                    <p class="md-font grey-font">البلد :<?php echo $opportunity->country ?>  </p>
                                   
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-7 col-xs-12 col-sm-12">
                                <p class="text-right grey-font md-font">مقدمة :</p>
                                <p class="text-right grey-font md-font">
                                    <?php echo $opportunity->description ?>
                                </p>
                            </div>
                            <!---->
                        </div>
                        <div class="row">



                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6 def-padding-sm">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm">

                                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right"> المشاهدات:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $opportunity->views?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6 def-padding-sm">
                                
                            </div>

                        </div>
                       
                        <p class="grey-font md-font text-justify def-padding-sm">
                           
                        </p>
                        <img class="round-corner def-padding-sm" src="<?php echo $opportunity->picpath ?>">

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

