				<?php foreach($messagelist as $message){
							$message = (object) $message
				?>
							
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 msg-thread">
                                    <div class="row">
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                                            <img src="<?php  echo $message->profilepic;  ?> " class="img-responsive">
                                        </div>
                                        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 no-pdg-lft">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <p class="pnl-name sm-title-name"><?php echo $message->name;  ?></p>
                                                    <p class="pnl-left message-date sm-title-name"><?php echo $message->msgtime;  ?></p>
                                                </div>
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <p class="message-body">
                                                        
														<?php echo $message->message;  ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


		
					
					<?php } ?>
                
