	    <?php include("wedget/user-header.php") ?> 
		<div class="container">
    <div class="row">

        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <h2 class="full-lines sm-font"><span class="blue-font"><?php echo $offer->item_brand_name  . ' , ' .$offer->item_type_name.' , '.$offer->item_names_name ?></span></h2>
                <div class="row">
					 
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                                <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12">
                                    <img src="<?php echo $offer->profilepic ?> " class="">
                                    <div class="text-center">
                                        <a   style="display: inline-block;float: none;margin-bottom: 10px;line-height: 35px;    font-size: 14px;width: 190px;" href="<?php  if (isset($getuserid)){ echo '?page=newmessage&uid='.$offer->userid;} else {echo '?page=login';}  ?>" class=" round-corner grey-border btn blue-button text-center">أرسل رسالة لصاحب الفرصه</a>
                                        <a href="javascript:void(0)" style="display: inline-block;line-height: 35px;    font-size: 14px;width: 190px;"  data-record="<?php echo $offer->id ?>" data-user="<?php echo $offer->userid ?>" data-type="offers" class=" round-corner grey-border btn blue-button text-center <?php  if (isset($getuserid)){ echo 'offer-show-phone';} else {  echo 'go-to-login' ;}  ?> ">إظهار بيانات التواصل</a>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-7 col-xs-12 col-sm-12 def-padding zero-top-padding">
                                    <p class="sm-font black-font">
                                       <?php echo $offer->username ?> 
                                    </p>
                                    <p class="md-font orange-font"><?php echo  $offer->job_title ?> </p>
                                    <p class="md-font grey-font">البلد :<?php echo $offer->user_country ?>  </p>
                                    <p class="md-font grey-font">حالة البضاعة :  <?php echo $offer->offer_type_filed ?> </p>
                                    <p class="md-font grey-font">أضيف  :  <?php echo $helper->timeAgo($offer->createdtime) ?> </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <p class="text-right grey-font md-font">مقدمة :</p>
                                <p class="text-right grey-font md-font">
                                    <?php echo $offer->description ?>
                                </p>

                                <p>

                                    <?php  if(isset($getuserid)&&$getuserid==$offer->user_id){
                                        echo($offer->done==0)?'<div class="text-center"><button title="في حال تواصل أحد أعضاء موقع موجة معك و تمت الصفقة اضغط هنا " data-id="'.$offer->id.'" class="btn btn-success successDealOffer">   تمت الصفقة</button></div>':'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';
                                    }else{
                                        if($offer->done==1){echo'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';}
                                    }?>
                                </p>
                            </div>
                            <!---->
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 def-padding-sm">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm">
								<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right"> الماركة:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $offer->item_brand_name ?></p>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right">النوع:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $offer->item_type_name ?></p>
                                    </div>
                                    
									<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right"> الصنف:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $offer->item_brand_name  . ' , ' .$offer->item_type_name.' , '.$offer->item_names_name ?></p>
                                    </div>
									<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right">العنوان:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $offer->offer_country .  ' , ' . $offer->offer_states . ' , ' .  $offer->offer_cities ?></p>
                                    </div>
                                    
									<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right"> اقل كمية للبيع:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $offer->min_qty ?></p>
                                    </div>
									<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right"> السعر:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $offer->price ?></p>
                                    </div>
									
									
									<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right"> المشاهدات:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $offer->views ?></p>
                                    </div>
									
                                </div>
								 
                            </div>
						
						</div>
                        <!--<div class="row">
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6  def-padding-sm">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm">
                                    <p class="black-font md-font text-right">
                                        يحتاج منتجات:
                                    </p>
                                    <ul class="grey-font md-font">
									<?php //$helper->getlist( $offer->project_product_list) ?>
                                       
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6  def-padding-sm">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm">
                                    <p class="black-font md-font text-right">
                                        يحتاج لخدمات:
                                    </p>
                                    <ul class="grey-font md-font">
										<?php //$helper->getlist( $offer->project_service_list) ?>
                                    </ul>
                                </div>
                            </div>


                        </div>-->
                        <p class="grey-font md-font text-justify def-padding-sm">
                           
                        </p>
                        <img  class="round-corner def-padding-sm" src="<?php echo $offer->picpath ?>">
                        <p class="grey-font md-font text-justify def-padding-sm">
                           <?php echo $offer->description ?>
                        </p>
                       
                    </div>

                </div>
				
       
	   </div>
       
            </div>
        </div>
		
		
    </div>
</div>


