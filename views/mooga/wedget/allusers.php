                	<?php
                    $lastuserid="";
					foreach($users as $loopuser){
							$loopuser = (object) $loopuser;
							$lastuserid=$loopuser->id;
							
					?>	
	
				   <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
				   
                        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 left-border def-padding-sm" >
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <img src="<?php echo $loopuser->profilepic;?>" class="justified-img">
                                <p class="black-font sm-font text-center bold">
                                    <?php echo $loopuser->name;?>
                                </p>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <p class="sm-font text-right orange-font zero-bottom-margin">
                                    <?php echo $loopuser->job_title;?>
                                </p>
                                <p class="md-font text-right grey-font zero-bottom-margin">
                                    البلد : <?php echo $loopuser->countryname;?>
                                </p>
                                <p class="md-font text-right grey-font zero-bottom-margin">
                                    المشروعات :<?php echo $loopuser->projects;?>
                                </p>
                                <a class="sm-border-btn round-corner grey-border"  href="?page=newmessage&uid=<?php echo $loopuser->id; ?>"><i class="message-box"></i></a>
                               <a href="javascript:void(0)"  title="أظهار رقم التليفون" data-record="<?php echo $loopuser->id ?>" data-user="<?php echo $user->id ?>" class="sm-border-btn round-corner grey-border user-show-phone"><i class="call-icon"></i> </a>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 def-padding-sm">
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">

                                <div class="md-font text-right grey-font zero-bottom-margin">
                                  <div class="row">
									  <span class="label grey-font">أقدم منتجات/خدمات:</span>
									  <?php  $helper->getspan($loopuser->provide_product_list) ?>
									
									</div>
                                </div>
                                <div class="md-font text-right grey-font zero-bottom-margin">
                                    <div class="row">
									  <span class="label grey-font">اعمل وكيل او موزع فى :</span>
									  <?php  $helper->getspan($loopuser->provide_agent_list) ?>
									
									</div>
                                </div>
                            </div>
                                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                
								
                                <div class="md-font text-right grey-font zero-bottom-margin">
                                  <div class="row">
									  <span class="label grey-font">احتاج منتجات/خدمات:</span>
									  <?php  $helper->getspan($loopuser->need_product_list) ?>
									
									</div>
                                </div>
                                <div class="md-font text-right grey-font zero-bottom-margin">
                                    <div class="row">
									  <span class="label grey-font">احتاج وكيل او موزع فى :</span>
									  <?php  $helper->getspan($loopuser->need_agent_list) ?>
									
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="left-btns-cont-bottom"><a href="?page=profile&sid=<?php echo $loopuser->id ?>" class="btn white-btn md-font text-center border-btn">المزيد ...</a></div>
                    </div><!--end single item-->
				
					<?php }
                      if ($lastuserid!="" || $lastuserid!=null){
					  echo "<div id='lastuserid' data-lastuserid='$lastuserid'></div>";		}			?>