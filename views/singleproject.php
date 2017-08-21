   


	 
	    <?php include("wedget/user-header.php") ?> 
		<div class="container">
    <div class="row">

        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <h2 class="full-lines sm-font"><span class="blue-font"><?php echo $project->name ?></span></h2>
                <div class="row">
					 
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                                <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12">
                                    <img src="<?php echo $project->profilepic ?> " class="">
                                    <div class="text-center">
                                        <a  href="javascript:void(0)" style="display: inline-block;float: none;margin-bottom: 10px;line-height: 25px;width: 170px;" href="<?php  if (isset($getuserid)){ echo '?page=newmessage&uid='.$project->userid;} else {echo '?page=login';}  ?>"  class=" round-corner grey-border orange-btn text-center">تواصل مع صاحب المشروع</a>
                                        <a  href="javascript:void(0)" style="display: inline-block;line-height: 25px;width: 170px;" title="إظهار بيانات الاتصال" data-record="<?php echo $project->id ?>" data-type="projects" data-user="<?php echo $project->userid ?>" class=" round-corner grey-border orange-btn text-center <?php  if (isset($getuserid)){ echo 'project-show-phone';} else {  echo 'go-to-login' ;}  ?> ">إظهار بيانات الاتصال</a>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-7 col-xs-12 col-sm-12 def-padding zero-top-padding">
                                    <p class="sm-font black-font">
                                       <?php echo $project->username ?> 
                                    </p>
                                    <p class="md-font orange-font"><?php echo $project->job_title ?></p>
                                    <p class="md-font grey-font">البلد :<?php echo $project->user_country ?>  </p>
                                    <p class="md-font grey-font">نوع المشروع :  <?php echo $project->project_type_list ?> </p>
                                    <p class="md-font grey-font">أضيف  :  <?php echo $helper->timeAgo($project->createdtime) ?> </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <p class="text-right grey-font md-font">مقدمة :</p>
                                <p class="text-right grey-font md-font">
                                    <?php echo $project->description ?>
                                </p>
                                <p>

                                    <?php if(isset($getuserid)&&$getuserid==$project->userid){
                                        echo($project->done==0)?'<div class="text-center"><button title="في حال تواصل أحد أعضاء موقع موجة معك و تمت الصفقة اضغط هنا " data-id="'.$project->id.'" class="btn btn-success successDeal">تمت الصفقة</button></div>':'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';
                                    }else{
                                        if($project->done==1){echo'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';}
                                    }?>
                                </p>
                            </div>
                            <!---->
                        </div>
                        <div class="row">


                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-6 def-padding-sm">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border def-padding-sm round-corner" >
                                    <div class="col-md-3 col-lg-3 col-xs-4 col-sm-4">
                                        <p class="black-font bold">يحتاج إلى:</p>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-xs-9 col-sm-9">
                                       
                                        
										<div class="col-md-4 col-lg-4 col-xs-12 col-sm-4">
                                           <?php if( $project->needpartner==1) echo '<i class="green-tick"></i>'?>
                                            <p class="blue-font sm-font"> شريك </p>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-4">
                                             <?php if( $project->needfunder==1) echo '<i class="green-tick"></i>'?>
                                            <p class="blue-font sm-font">   مستثمر </p>
                                        </div>
                                        
										<div class="col-md-4 col-lg-4 col-xs-12 col-sm-4">
                                              <?php if( $project->needbuyer==1) echo '<i class="green-tick"></i>'?>
                                            <p class="blue-font sm-font"> مشترى للمشروع  </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 def-padding-sm">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm">
								<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                            <p class="orange-font sm-font text-right float-right"> نوع المشروع:</p>
											<p class="grey-font sm-font text-right float-right"><?php echo $helper->replace_qute($project->project_type_list) ?></p>
                                   </div>
								 <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                            <p class="orange-font sm-font text-right float-right"> مجال عمل المشروع:</p>
											<p class="grey-font sm-font text-right float-right"><?php echo $helper->replace_qute($project->project_field_list) ?></p>
                                   </div>
								   <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                            <p class="orange-font sm-font text-right float-right"> مرحلة المشروع:</p>
											<p class="grey-font sm-font text-right float-right"><?php echo $helper->replace_qute($project->stage_list) ?></p>
                                   </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
									
                                        <p class="orange-font sm-font text-right float-right">مكان المشروع:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $project->project_country.' , ' .$project->project_states .' , '.$project->project_cities ?></p>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                        <p class="orange-font sm-font text-right float-right"> المشاهدات:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $project->views ?></p>
                                    </div>
									 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <p class="orange-font sm-font text-right float-right"> اسباب الأحتياج:</p>
                                        <p class="grey-font sm-font text-right float-right"><?php echo $project->needdescription ?></p>
                                    </div>
									
								  
                                </div>
                            </div>
                            

                        </div>
                     
                        <p class="grey-font md-font text-justify def-padding-sm">
                           
                        </p>
                        <img  class="round-corner def-padding-sm" src="<?php echo $project->picpath ?>">
                        <p class="grey-font md-font text-justify def-padding-sm">
                           <?php echo $project->description ?>
                        </p>
                       
                    </div>


                    <style>
                        /* carousel */
                        .media-carousel
                        {
                            margin-bottom: 0;
                            padding: 0 40px 30px 40px;
                            margin-top: 30px;
                        }
                        /* Previous button  */
                        .media-carousel .carousel-control.left
                        {
                            left: -12px;
                            background-image: none;
                            background: none repeat scroll 0 0 #222222;
                            border: 4px solid #FFFFFF;
                            border-radius: 23px 23px 23px 23px;
                            height: 40px;
                            width : 40px;
                            margin-top: 15%;
                        }
                        /* Next button  */
                        .media-carousel .carousel-control.right
                        {
                            right: -12px !important;
                            background-image: none;
                            background: none repeat scroll 0 0 #222222;
                            border: 4px solid #FFFFFF;
                            border-radius: 23px 23px 23px 23px;
                            height: 40px;
                            width : 40px;
                            margin-top: 15%;
                        }
                        /* Changes the position of the indicators */
                        .media-carousel .carousel-indicators
                        {
                            right: 50%;
                            top: auto;
                            bottom: 0px;
                            margin-right: -19px;
                        }
                        /* Changes the colour of the indicators */
                        .media-carousel .carousel-indicators li
                        {
                            background: #c0c0c0;
                        }
                        .media-carousel .carousel-indicators .active
                        {
                            background: #333333;
                        }
                        .media-carousel img
                        {
                            width: 350px;
                            height: 200px
                        }
                        /* End carousel */
                    </style>




                </div>
                <?php if(isset($getuserid)){;?>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class="carousel slide media-carousel" id="media">
                                <div class="carousel-inner" style="min-height: 420px;">


                                    <?php
                                    $activeClass=false;
                                    $x=1;
                                    $y=1;
                                    foreach($projects as $project){?>
                                    <?php if($x==1){?>
                                    <div class="item  <?php if(!$activeClass){echo'active';$activeClass=true;}?>">
                                        <div class="row">
                                            <?php }?>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 10px">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 round-corner grey-border">
                                                    <p class="md-font black-font text-center"><?=$project->name?></p>
                                                    <img class="home-artical" src="<?=$project->picpath?>">
                                                    <div class="grey-font md-font ">
                                                        <p style="min-height: 100px;"><?=$helper->__html($project->description,150, array('html' => true, 'ending' => '...'));?></p>
                                                    </div>
                                                    <a href="?page=singleproject&amp;pid=<?=$project->id?>" class="btn white-btn md-font text-center border-btn">المزيد</a>
                                                </div>
                                            </div>
                                            <?php if(count((array)$projects)==$y&&$x!=3){?>
                                        </div>
                                    </div>
                                <?php }echo count((array)$projects).'==Y:'.$y;?>
                                    <?php if($x==3){$x=0;?>
                                </div>
                            </div>
                            <?php }?>
                            <?php $x++;$y++;?>
                            <?php }?>
                                </div>
                                <a data-slide="prev" href="#media" style="text-align: center;" class="left carousel-control">›</a>
                                <a data-slide="next" href="#media" style="text-align: center;" class="right carousel-control">‹</a>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center" style="min-height: 80px;">
                        <a href="?page=relatedProjects">عرض الكل </a>
                    </div>
                <?php }?>


            </div>
        </div>
    </div>
</div>

