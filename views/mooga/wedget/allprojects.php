                	<?php
                    $projectid="";
					foreach($projects as $project){
							$project = (object) $project;
							$projectid=$project->id;
					?>		
					<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
                       
					   <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 left-border def-padding-sm" >
                            <p class="black-font sm-font text-right bold">
                               <?php echo $project->name;?>
                            </p>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <img src="<?php echo $project->picpath;?>" class="justified-img">
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
							<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">نوع المشروع :  </p>
                                    <p class="md-font grey-font zero-bottom-margin"><?php echo $project->project_type_list;?></p>
                                </div>
								<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">مجال المشروع :  </p>
                                    <p class="md-font grey-font zero-bottom-margin"><?php echo $project->project_field_list;?></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">حالة المشروع:  </p>
                                    <p class="md-font grey-font zero-bottom-margin"><?php echo $project->stage_list;?></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">الدولة: </p>
                                    <p class="md-font  grey-font zero-bottom-margin "><?php echo $project->project_country;?></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">المشاهدات:</p>
                                    <p class="md-font  grey-font zero-bottom-margin "><?php echo $project->views;?></p>
                                </div>

                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">أضيف:</p>
                                    <p class="md-font  grey-font zero-bottom-margin "><?php echo $helper->timeAgo($project->createdtime);?></p>

                                </div>
                            </div>
							
							
							<?php if  (isset($getuserid)) if ($getuserid==$project->userid) { ?>
							<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 def-padding-sm">
								<a href="?page=addproject&action=edit&record= <?php echo $project->id;?>" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left"><i class="message-box edit-ico"></i></a>
								<a href="javascript:void(0)"  data-record="<?php echo $project->id;?>" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left deleteproject"><i class="message-box delete-ico"></i></a>
							<?php  if ($project->pending==1) { ?>
								<a href="?page=verifie_project&project_id=<?php  echo $project->id; ?>" class="btn orange-btn"><span>تأكيد المشروع</span></a>
								<?php } ?>
							</div>
							<?php } ?>
							
                        </div>
						
                        <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12 left-border def-padding-sm">
                            <p class="md-font text-right grey-font zero-bottom-margin sm-top-padding">
                                <?php //echo $project->description;?>
								<?php  echo $helper->__html($project->description,150, 
                                          array('html' => true, 'ending' => '')).'....'; ?>
                            </p>
                            <p>
                                <?php
                                if(isset($getuserid)&&$getuserid==$project->userid){
                                    echo($project->done==0)?'<div class="text-center">في حال تواصل أحد أعضاء موقع موجة معك و تمت الصفقة اضغط <a data-id="'.$project->id.'" href="#" class=" successDeal">هنا </a></div>':'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';
                                }else{
                                    if($project->done==1){echo'<div class="text-center"><img src="assets/images/150x150_Button.png"></div>';}
                                }?>
                            </p>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12  def-padding-sm" >
						
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
							
                                <p class="black-font sm-font text-center bold">
                                    مالك المشروع
                                </p>
                                <img src="<?php echo $project->profilepic; ?>" class="justified-img">
                                <p class="black-font sm-font text-center bold zero-bottom-margin">
                                   <?php echo $project->username;?>
                                </p>
								<p id=""></p>
								
                                <div class=" col-md-12 col-lg-12 col-xs-12 col-sm-12 text-center">
                                    <a  style="display: inline-block;float: none;margin-bottom: 7px;line-height: 35px;    font-size: 14px;width: 190px;" href="<?php  if (isset($getuserid)){ echo '?page=newmessage&uid='.$project->userid;} else {echo '?page=login';}  ?>"  class=" round-corner grey-border btn blue-button"> أرسل رسالة لصاحب المشروع</a>
                                    <a  href="javascript:void(0)" style="display: inline-block;line-height: 35px;    font-size: 14px;width: 190px;margin-bottom: 7px;"data-record="<?php echo $project->id ?>" data-type="projects" data-user="<?php echo $project->userid ?>" class=" round-corner grey-border btn blue-button <?php  if (isset($getuserid)){ echo 'project-show-phone';} else {  echo 'go-to-login' ;}  ?> ">إظهار بيانات التواصل</a>
                                </div>
                                <!--<div class="abs-btn cst col-md-5 col-lg-5 col-xs-12 col-sm-12">
                                    <a  href="<?php /* if (isset($getuserid)){ echo '?page=newmessage&uid='.$project->userid;} else {echo '?page=login';}  */?>"  class="sm-border-btn round-corner grey-border"><i class="message-box"></i></a>
                                    <a style="width: 120px;display: inline-block;float: none;position: relative;top: -8px;" href="javascript:void(0)"  title="إظهار بيانات الاتصال" data-record="<?php /*echo $project->id */?>" data-toggle="tooltip" data-user="<?php /*echo $project->userid */?>" class="sm-border-btn round-corner grey-border <?php /* if (isset($getuserid)){ echo 'project-show-phone';} else {  echo 'go-to-login' ;}  */?> ">اظهار بيانات التواصل</a>
                                </div>-->
                            </div>
							
                        </div>
                        <div class="left-btns-cont-bottom center-button">
						   <a href="?page=singleproject&pid=<?php  echo $project->id;?> " class="btn white-btn md-font text-center border-btn">المزيد ...</a>
						</div>

                    </div><!--end single item-->
                
					<?php } if ($projectid!="" || $projectid!=null){
						echo "<div id='projectid' data-projectid='$projectid'></div>";
					}
                    ?>



