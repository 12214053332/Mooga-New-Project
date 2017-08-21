<?php               $opportunityid="";
            foreach($opportunities as $opportunity){
							$opportunity = (object) $opportunity;
							$opportunityid=$opportunity->id;
				?>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 def-padding-sm" >
                    <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12">
                        <img src="<?php echo $opportunity->picpath ?>" class="justified-img">
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-12 col-sm-12">
                        <p class="md-lg-font black-font zero-bottom-margin "><?php echo $opportunity->name ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 def-padding-sm">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <p class="md-lg-font orange-font zero-bottom-margin cst-right-alignment">انتهاء الفرصة :</p>
                        <p class="md-lg-font grey-font zero-bottom-margin"><?php echo $opportunity->expiredate ?></p>
                    </div>
                </div>
				
				<?php if  (isset($getuserid)) if ($getuserid==$opportunity->userid) { ?>
                <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 def-padding-sm">
                    <a href="?page=addopportunity&action=edit&record=<?php echo $opportunity->id ?>" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left"><i class="message-box edit-ico"></i></a>
                    <a href="javascript:void()"   data-record="<?php echo $opportunity->id;?>" class="sm-border-btn round-corner grey-border zero-top-margin zoomed-btn alg-left deleteopportunity"><i class="message-box delete-ico"></i></a>
                
			
				</div>
				<?php } ?>
				<div class="left-btns-cont-bottom center-button">
						   <a href="?page=singleopportunity&record=<?php echo $opportunity->id;?> " class="btn white-btn md-font text-center border-btn">المزيد من التفاصيل ...</a>
			</div>
            </div><!--end single item-->
			<?php } if ($opportunityid!="" || $opportunityid!=null){
						echo "<div id='opportunityid' data-opportunityid='$opportunityid'></div>";
					}					?>