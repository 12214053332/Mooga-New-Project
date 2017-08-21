
<div class="container">
    <div class="row">
	
 <?php include("wedget/user-header.php") ?>
	
        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding grey-border">
            <h2 class="full-lines sm-font"><span class="blue-font">استعراض الفرص</span></h2>
            <a href="#" class="md-font blue-font alg-left cust-border-btn negative-top"><i class="add-round"></i><span>أضف منتج</span></a>
				<?php foreach($opportunities as $opportunity){
							$opportunity = (object) $opportunity
				?>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 def-padding-sm" >
                    <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12">
                        <img src="assets/images/project-owner.jpg" class="justified-img">
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-12 col-sm-12">
                        <p class="md-lg-font black-font zero-bottom-margin "><?php echo $opportunity->name ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 def-padding-sm">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <p class="md-lg-font orange-font zero-bottom-margin cst-right-alignment">انتهاء العرض :</p>
                        <p class="md-lg-font grey-font zero-bottom-margin"><?php echo $opportunity->expiredate ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 def-padding-sm">
                    <a href="#" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left"><i class="message-box edit-ico"></i></a>
                    <a href="#" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left"><i class="message-box delete-ico"></i></a>
                </div>
            </div><!--end single item-->
           <?php } ?>
	
        </div>

    </div>
</div>
