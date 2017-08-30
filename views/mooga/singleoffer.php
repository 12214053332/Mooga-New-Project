	    <?php include("wedget/user-header.php") ?>
        <div class="details-lt-block">
            <div class="slt_block_bg"><img src="images/detail-view-bg.jpg" alt=""></div>
            <div class="container header_slt_block">
                <div class="slt_item_head">
                    <div class="user_logo_pic"> <img alt="" src="<?php echo $offer->picpath  ?>"> </div>
                    <div class="slt_item_contant">

                        <h1><?php echo $offer->item_brand_name  . ' , ' .$offer->item_type_name.' , '.$offer->item_names_name ?></h1>
                        <ul >
                            <li> <?php echo $offer->username ?>  </p></li>
                            <li> <?php if($offer->job_title!=''){?><p class="location"><?php echo $offer->job_title ?></p> <?php }?></li>
                            <li>  البلد :<?php echo $offer->user_country ?> </li>
                            <li>  حالة البضاعة :  <?php echo $offer->offer_type_filed ?></li>
                            <li> أضيف  :  <?php echo $helper->timeAgo($offer->createdtime) ?></li>
                        </ul>

                        <div class="head-bookmark-bock">
                            <div class="detail-banner-btn"><a href="<?php  if (isset($getuserid)){ echo '?page=newmessage&uid='.$offer->userid;} else {echo '?page=login';}  ?>  ?>"> أرسل رسالة لصاحب المشروع</a></div>
                            <div class="detail-banner-btn "><a href="javascript:void(0) "  data-record="<?php echo $offer->id ?>" data-user="<?php echo $offer->userid ?>" data-type="offers" class="<?php  if (isset($getuserid)){ echo 'offer-show-phone';} else {  echo 'go-to-login' ;}  ?>">إظهار بيانات التواصل</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="vfx-product-inner-item">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <a href="?page=addproject" class="btn btn-success btn-block <?php if(in_array($currentpage,['projects'])) { ?>pull-right<?php }else{?>text-center<?php }?>"><span>أضف مشروع جديد</span></a>
                        <div class="clearfix"></div>
                        <div class="clearfix" style="height: 20px;"></div>
                        <form id="allprojects-form" onsubmit="return false" method="post" action="#" novalidate="novalidate">
                            <div class="news-search-lt">
                                <input class="form-control" id="name" placeholder="اسم المشروع او وصف المشروع" type="text">
                                <span class="input-search">
                              <i class="fa fa-search"></i>
                          </span>
                            </div>
                            <div class="form-group">
                                <select class="form-control chosen-select" data-placeholder="اختر نوع عمل المشروع"  id="project_type" name="project_type" >
                                    <option value=""></option>
                                    <?php $helper->getoptions( $project_type,""); ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control chosen-select" data-placeholder="اختر مجال عمل المشروع"   id="project_field" name="project_field"  <?php  echo $object->project_field_list; ?>>
                                    <option value=""></option>
                                    <?php $helper->getoptions( $project_field,""); ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control chosen-select" data-placeholder="اختر مرحلة المشروع الحالية"  id="stage" name="stage">
                                    <option value=""></option>
                                    <?php $helper->getoptions( $project_stage,""); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control chosen-select" data-placeholder="اختر الدولة"  id="country" name="country" >
                                    <option value=""></option>
                                    <?php
                                    foreach ($countries as $country) {
                                        $id=$country['id'];
                                        $name=$country['name'];
                                        $code=$country['code'];
                                        echo " <option value='$id'  data-code='$code' >$name</option> ";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control chosen-select" data-placeholder="اختر المحافظة" id="states" name="states" >
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control chosen-select"  data-placeholder="اختر المدينة"  id="cities" name="cities" >
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="المبلغ المراد استثمارة" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="الى" type="text">
                            </div>

                            <div class="from-list-lt text-center">
                                <button type="submit" class="btn">إبحث</button>
                            </div>
                        </form>

                        <div class="clearfix"></div>
                        <div class="clearfix" style="height: 20px;"></div>


                        <div class="left-slide-slt-block">
                            <h3>Categories</h3>
                        </div>
                        <div class="list-group"> <a href="#" class="list-group-item active"><i class="fa fa-hand-o-left"></i> Business <span class="list-lt">15</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Health &amp; Fitness <span class="list-lt">09</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Real Estate <span class="list-lt">18</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Entertainment <span class="list-lt">24</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Beauty &amp; Spas <span class="list-lt">06</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Automotive <span class="list-lt">04</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Hotels &amp; Travel <span class="list-lt">14</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Sports &amp; Adventure <span class="list-lt">07</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Technology <span class="list-lt">12</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Arts &amp; Entertainment <span class="list-lt">26</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Education &amp; Learning <span class="list-lt">24</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Cloth Shop <span class="list-lt">16</span></a> </div>
                        <div class="left-slide-slt-block">
                            <h3>Popular Tags</h3>
                        </div>
                        <div class="archive-tag">
                            <ul>
                                <li><a href="#" class="active">Amazing</a></li>
                                <li><a href="#">Envato</a></li>
                                <li><a href="#">Themes</a></li>
                                <li><a href="#">Clean</a></li>
                                <li><a href="#">Responsivenes</a></li>
                                <li><a href="#">SEO</a></li>
                                <li><a href="#">Mobile</a></li>
                                <li><a href="#">IOS</a></li>
                                <li><a href="#">Flat</a></li>
                                <li><a href="#">Design</a></li>
                            </ul>
                        </div>
                        <div class="left-slide-slt-block">
                            <h3>Location List</h3>
                        </div>
                        <div class="left-location-item">
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Manchester</a><span class="list-lt">07</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Lankashire</a><span class="list-lt">04</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> New Mexico</a><span class="list-lt">03</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Nevada</a><span class="list-lt">06</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Kansas</a><span class="list-lt">08</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> West Virginina</a><span class="list-lt">05</span></li>
                            </ul>
                        </div>
                        <div class="left-slide-slt-block">
                            <h3>Archives</h3>
                        </div>
                        <div class="left-archive-categor">
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> January 2016</a><span class="list-lt">09</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> February 2016</a><span class="list-lt">52</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> March 2016</a><span class="list-lt">36</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> April 2016</a><span class="list-lt">78</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> May 2016</a><span class="list-lt">66</span></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> June 2016</a><span class="list-lt">15</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <div class="dlt-title-item">
                            <h2>مقدمة :</h2>
                            <p> <?php echo $offer->description ?></p>
                            <p>

                                <?php  if(isset($getuserid)&&$getuserid==$offer->user_id){
                                    echo($offer->done==0)?'<div class="text-center"><button title="في حال تواصل أحد أعضاء موقع موجة معك و تمت الصفقة اضغط هنا " data-id="'.$offer->id.'" class="btn btn-success successDealOffer">   تمت الصفقة</button></div>':'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';
                                }else{
                                    if($offer->done==1){echo'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';}
                                }?>
                            </p>
                        </div>
                        <div class="dlt-title-item">
                            <ul>
                                <li> <span>الماركة:</span><?php echo $offer->item_brand_name ?> </li>
                                <li> <span>النوع:</span><?php echo $offer->item_type_name ?></li>
                                <li> <span> الصنف:</span><?php echo $offer->item_brand_name  . ' , ' .$offer->item_type_name.' , '.$offer->item_names_name ?></li>
                                <li> <span>العنوان:</span><?php echo $offer->offer_country .  ' , ' . $offer->offer_states . ' , ' .  $offer->offer_cities ?></li>
                                <li> <span> اقل كمية للبيع:</span><?php echo $offer->min_qty ?></li>
                                <li> <span> السعر:</span><?php echo $offer->price ?></li>
                                <li> <span>المشاهدات:</span><?php echo $offer->views ?></li>

                            </ul>
                        </div>




                        <div class="slider">
                            <div class="detail-gallery">
                                <div class="detail-gallery-preview"> <a href="<?php echo $offer->picpath ?>"> <img src="<?php echo $offer->picpath ?>"> </a> </div>

                            </div>
                        </div>
                        <p >
                            <?php echo $offer->description ?>
                        </p>

                    </div>

                </div>

            </div>

        </div>
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


