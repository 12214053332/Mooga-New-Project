
<?php if (isset($user->id)) {?>				
<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner internal-sub-header btm-mrg-sm grey">
            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 def-padding-sm">
                <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                   <a title="بيانات الحساب" class="edit_profile" href="?page=profile">  <img src="<?php echo $user->profilepic; ?>" class="round-corner justified-img"> </a>
					<a class="btn blue-button small-font" title="تعديل الحساب"  href="?page=profile_edit" >تعديل الحساب</a>
                </div>
                <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 ">
                    <p class="orange-font md-lg-font text-right"><?php echo $user->name; ?></p>
                    
					<p class="grey-font md-font text-right"><?php echo $user->job_title; ?></p>
					
                </div>
			
            </div>
            <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 def-padding-sm justified-div">
              
                
                <a href="?page=myprojects" class="header-btn md-font grey-font"><i class="btn-ico case"><span class="notification green" id="projects-balance"><?php echo $user->projects;?></span></i> مشروعاتى</a>
                <a href="?page=myoffers" class="header-btn md-font grey-font"><i class="btn-ico light"><span class="notification green" id="offers-balance"><?php echo $user->offers;?></span></i> عروض الجملة</a>
				<a href="?page=inbox" class="header-btn md-font grey-font"><i class="btn-ico message"><span class="notification red"><?php echo $messagecount; ?></span></i>  الرسائل</a>
                <a href="?page=forgetpassword&action=changepassword" class="header-btn md-font grey-font"><i class="btn-ico settings"></i> تغيير كلمة المرور</a>
            </div>
        </div>
    </div>
</div>
<?php } ?>