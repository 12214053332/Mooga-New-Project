   


	 
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
                                        <a     style="display: inline-block;float: none;margin-bottom: 10px;line-height: 35px;    font-size: 14px;width: 190px;" href="<?php  if (isset($getuserid)){ echo '?page=newmessage&uid='.$project->userid;} else {echo '?page=login';}  ?>"  class=" round-corner grey-border btn blue-button text-center">أرسل رسالة لصاحب المشروع</a>
                                        <a  href="javascript:void(0)" style="display: inline-block;line-height: 35px;width: 190px;    font-size: 14px;" data-record="<?php echo $project->id ?>" data-type="projects" data-user="<?php echo $project->userid ?>" class=" round-corner grey-border btn blue-button text-center <?php  if (isset($getuserid)){ echo 'project-show-phone';} else {  echo 'go-to-login' ;}  ?> ">إظهار بيانات التواصل</a>
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
                                        echo($project->done==0)?'<div class="text-center"><button title="في حال تواصل أحد أعضاء موقع موجة معك و تمت الصفقة اضغط هنا " data-id="'.$project->id.'" class="btn btn-success successDeal">   تمت الصفقة</button></div>':'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';
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


      
            </div>
        </div>
    </div>
</div>

