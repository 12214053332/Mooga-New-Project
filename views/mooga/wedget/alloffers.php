                	<?php
                    $offerid="";
					foreach($offers as $offer){
							$offer = (object) $offer;
							$offerid=$offer->id;
					?>		
					<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
                       
					   <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 left-border def-padding-sm" >
                            <p class="black-font sm-font text-right bold">
                                <?php echo $offer->item_brand_name  . ' , ' .$offer->item_type_name.' , '.$offer->item_names_name ?>
                            </p>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <img src="<?php echo $offer->picpath;?>" class="justified-img">
								
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">حالة البضاعة:  </p>
                                    <p class="md-font grey-font zero-bottom-margin"><?php echo $offer->offer_type_filed;?></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">الدولة: </p>
                                    <p class="md-font  grey-font zero-bottom-margin "><?php echo $offer->offer_country;?></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">المشاهدات:</p>
                                    <p class="md-font  grey-font zero-bottom-margin "><?php echo $offer->views;?></p>
                                </div>
                            </div>
							
							
							<?php if  (isset($getuserid)) if ($getuserid==$offer->userid) { ?>
							<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 def-padding-sm">
								<a href="?page=addoffer&action=edit&record=<?php echo $offer->id;?>" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left"><i class="message-box edit-ico"></i></a>
								<a href="javascript:void(0)"  data-record="<?php echo $offer->id;?>" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left deleteoffer"><i class="message-box delete-ico"></i></a>
								<?php  if ($offer->pending==1) { ?>
								<a href="?page=verifie_offer&offer_id=<?php  echo $offer->id; ?>" class="btn orange-btn"><span>تأكيد العرض</span></a>
								<?php } ?>
							</div>
							<?php } ?>
							
                        </div>
						
                        <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12 left-border def-padding-sm">
                            <p class="md-font text-right grey-font zero-bottom-margin sm-top-padding">
                                <?php echo $offer->description;?>
                            </p>
                            <p>
                                <?php
                                if(isset($getuserid)&&$getuserid==$offer->userid){
                                    echo($offer->done==0)?'<div class="text-center">في حال تواصل أحد أعضاء موقع موجة معك و تمت الصفقة اضغط <a href="#" data-id="'.$offer->id.'" class=" successDealOffer">هنا</a></div>':'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';
                                }else{
                                    if($offer->done==1){echo'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';}
                                }?>
                            </p>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12  def-padding-sm" >
						
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
							
                                <p class="black-font sm-font text-center bold">
                                    مالك عرض الجملة
                                </p>
                                <img src="<?php echo $offer->profilepic; ?>" class="justified-img">
                                <p class="black-font sm-font text-center bold zero-bottom-margin">
                                   <?php echo $offer->username;?>
                                </p>
								
                                								
                                <div class=" col-md-12 col-lg-12 col-xs-12 col-sm-12 text-center">
                                    <a  style="display: inline-block;float: none;margin: 7px;line-height: 35px;    font-size: 14px;width: 190px;" href="<?php  if (isset($getuserid)){ echo '?page=newmessage&uid='.$offer->userid;} else {echo '?page=login';}  ?>" class=" round-corner grey-border btn blue-button"> أرسل رسالة لصاحب الفرصه</a>
                                    <a href="javascript:void(0)" style="display: inline-block;line-height: 35px;    font-size: 14px;margin: 7px;width: 190px;" data-record="<?php echo $offer->id ?>" data-user="<?php echo $offer->userid ?>" data-type="offers"  class=" round-corner grey-border btn blue-button <?php  if (isset($getuserid)){ echo 'offer-show-phone';} else {  echo 'go-to-login' ;}  ?> ">إظهار بيانات التواصل</a>
                                </div>

                                <!--<div class="abs-btn cst col-md-5 col-lg-5 col-xs-12 col-sm-12">
                                    <a  href="<?php /* if (isset($getuserid)){ echo '?page=newmessage&uid='.$offer->userid;} else {echo '?page=login';}  */?>" class="sm-border-btn round-corner grey-border"><i class="message-box"></i></a>
                                    <a href="javascript:void(0)"  title="إظهار بيانات الاتصال" data-record="<?php /*echo $offer->id */?>" data-user="<?php /*echo $offer->userid */?>" class="sm-border-btn round-corner grey-border <?php /* if (isset($getuserid)){ echo 'offer-show-phone';} else {  echo 'go-to-login' ;}  */?> "><i class="call-icon"></i> </a>
                                </div>-->
                            </div>
							
                        </div>
                        <div class="left-btns-cont-bottom center-button">
						   <a href="?page=singleoffer&pid=<?php  echo $offer->id;?> " class="btn white-btn md-font text-center border-btn">المزيد ...</a>
						</div>

                    </div><!--end single item-->
                
					<?php } if ($offerid!="" || $offerid!=null){
						echo "<div id='offerid' data-offerid='$offerid'></div>";
					}					?>