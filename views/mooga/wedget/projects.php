	<?php foreach($allprojects as $project){
							$project = (object) $project
							?>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
								
                                    <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12 left-border def-padding-sm" >
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <p class="black-font sm-font text-right bold"><?php echo $project->name;?></p>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                            <img src="<?php echo $project->picpath;?>" class="justified-img">
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">المشروع:  </p>
                                                <p class="md-font grey-font zero-bottom-margin"><?php echo $project->name;?></p>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">الدولة: </p>
                                                <p class="md-font  grey-font zero-bottom-margin "><?php echo $project->usercountry; ?></p>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">المشاهدات:</p>
                                                <p class="md-font  grey-font zero-bottom-margin "><?php echo $project->views; ?></p>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                <p class="md-font orange-font zero-bottom-margin cst-right-alignment">المرحلة:</p>
                                                <p class="md-font grey-font zero-bottom-margin"><?php echo $project->stage_list;?></p>
                                            </div>
                                        </div>
			               <?php if ($getuserid==$project->userid) { ?>
							<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 def-padding-sm">
								<a href="?page=addproject&action=edit&record= <?php echo $project->id;?>" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left"><i class="message-box edit-ico"></i></a>
								<a href="#" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left"><i class="message-box delete-ico"></i></a>
							</div>
							<?php } ?>
                                    </div>
                                    <div class="col-md-7 col-lg-7 col-xs-12 col-sm-12 def-padding-sm">
                                        <p class="md-font text-right grey-font zero-bottom-margin lg-top-mrg">
                                           <?php echo $project->description;?>
                                        </p>
                                    </div>
                                    <div class="left-btns-cont-bottom"><a href="?page=singleproject&pid=<?php  echo $project->id;?> " class="btn white-btn md-font text-center border-btn">المزيد ...</a></div>
                                </div><!--end single item-->
								<?php } ?>
								