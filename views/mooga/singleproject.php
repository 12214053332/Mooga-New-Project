<?php include("wedget/user-header.php") ?>
<div id="breadcrum-inner-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="breadcrum-inner-header">
                  <h1><?php echo $project->name ?></h1>
                    </div>
            </div>
        </div>
    </div>
</div>

<div id="featured-service-block">
    <div class="container">

            <div class="col-md-12  pricing-heading-title bt_heading_3">
                <div class="col-md-8 col-sm-12 col-xs-12">

                    <div class="price-table-feature-block">
                            <h1>مرحلة المشروع</h1>
                            <hr class="hr">
                        <div class="  detail-content">
                            <ul class="detail-amenities">
                                <li  <?php if( $helper->replace_qute($project->stage_list) =='في طور التصفية'){ ?> class="yes" <?php  } ?>>في طور التصفية</li>
                                <li <?php if( $helper->replace_qute($project->stage_list) =='تحت الانشاء'){ ?> class="yes" <?php }?>>تحت الانشاء</li>
                                <li  <?php if( $helper->replace_qute($project->stage_list) =='فكرة'){ ?> class="yes" <?php } ?> > فكرة</li>
                                <li <?php if( $helper->replace_qute($project->stage_list) =='قائم'){ ?> class="yes" <?php  } ?>>قائم</li>

                            </ul>
                        </div>
                    </div>
                    <div class="price-table-feature-block desc">
                        <h1>تفاصيل</h1>
                        <hr class="hr">
                        <div class="description" >
                            <a href="<?php echo $project->picpath ?>"> <img src="<?php echo $project->picpath ?>"> </a>
                        </div>
                        <p>
                                    <?php echo $project->description ?>
                        </p>
                        <p >
                            <?php if(isset($getuserid)&&$getuserid==$project->userid){
                                echo($project->done==0)?'<div class="text-center"><button title="في حال تواصل أحد أعضاء موقع موجة معك و تمت الصفقة اضغط هنا " data-id="'.$project->id.'" class="btn btn-success successDeal">   تمت الصفقة</button></div>':'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';
                            }else{
                                if($project->done==1){echo'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';}
                            }?>
                        </p>


                    </div>
                    <div class="price-table-feature-block">
                        <h1>احتياج المشروع</h1>
                        <hr class="hr">
                        <div class="detail-content">
                            <ul class="detail-amenities">
                                <li  <?php if( $project->needpartner==1){ ?> class="yes" <?php } ?> > شريك</li>
                                <li <?php if( $project->needfunder==1){ ?> class="yes" <?php }?>>مستثمر</li>
                                <li <?php if( $project->needbuyer==1){ ?> class="yes" <?php  } ?>>مشترى للمشروع</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="price-table-feature-block">

                            <h1>البيانات</h1>
                            <hr class="hr">
                        <div class="dlt-title-item">
                            <ul >
                                <li> <span> نوع المشروع:</span><?php echo $helper->replace_qute($project->project_type_list) ?></li>
                                <li> <span> مجال عمل المشروع:</span><?php echo $helper->replace_qute($project->project_field_list) ?></li>
                                <li> <span> مكان المشروع:</span><?php echo $project->project_country.' , ' .$project->project_states .' , '.$project->project_cities ?></li>
                                <li> <span> المشاهدات:</span><?php echo $project->views ?></li>
                                <li> <span> اسباب الأحتياج:</span><?php echo $project->needdescription ?></li>

                            </ul>
                        </div>
                        <div class="text-center">
                            <div class="blind line_1"></div>
                            <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                            <div class="blind line_2"></div>
                        </div>

                        <h1> بيانات صاحب المشروع</h1>
                        <hr class="hr">
                        <div class="dlt-title-item">
                            <ul>
                                <li><span>  الاسم :</span> <?php echo $project->username ?></li>
                                <li> <?php if($project->job_title!=''){?><span>  الوظيفة :</span><?php echo $project->job_title ?> <?php }?></li>
                                <li><span>  البلد :</span><?php echo $project->user_country ?> </li>
                                <li><span>  نوع المشروع :  </span><?php echo $project->project_type_list ?></li>
                                <li><span> أضيف  :  </span><?php echo $helper->timeAgo($project->createdtime) ?></li>

                            </ul>

                        </div>
                        </div>
                    <div class="price-table-feature-block">
                        <h1> وصائل التواصل</h1>
                        <hr class="hr">
                            <div class="dlt-com-lt-img">
                                <ul class=" social-icons">
                                    <li><a target="_blank" href="https://www.facebook.com/moogabusiness/?fref=ts"><i class="fa fa-facebook"></i></a></li>
                                    <li><a target="_blank" href="https://twitter.com/moogabusiness"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                    <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                                </ul>
                            </div>
                    </div>

                </div>
            </div>

    </div>
</div>