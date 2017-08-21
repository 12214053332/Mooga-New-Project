				<?php foreach($allproducts as $product){
							$product = (object) $product
				?>
									
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 def-padding-sm">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm">
                        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 left-border def-padding-sm" >
                            <img src="<?php echo $product->picpath;?>" class="justified-img">
                        </div>
                        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 def-padding-sm">
                            <div class="left-btns-cont-top">
                                <a class="sm-border-btn round-corner grey-border zero-top-margin" href="?page=addproduct&action=edit&record=<?php echo $product->id ?>"><i class="message-box edit-ico"></i></a>
                                <a href="#"   data-record="<?php echo $product->id;?>" class="sm-border-btn round-corner grey-border zero-top-margin deleteproduct"><i class="message-box delete-ico"></i></a>
								
                            </div>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <p class="md-font blue-font zero-bottom-margin cst-right-alignment"> اسم المنتـج:</p>
                                <p class="md-font grey-font zero-bottom-margin"><?php echo $product->name;?></p>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <p class="md-font blue-font zero-bottom-margin cst-right-alignment"> وصف المنتج:</p>
                                <p class="md-font grey-font zero-bottom-margin"><?php echo $product->description;?> </p>
                            </div>
                        </div>
                    </div>
                </div>
				
				<?php } ?>
                