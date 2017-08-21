

				<?php foreach($homeoffers as $offer) {
										$offer = (object) $offer
										?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 round-corner grey-border col">
                        <a class="btn blue-button" href="?page=singleoffer&pid=<?php echo $offer->id  ?>" title="<?php echo $offer->item_type_name.','.$offer->item_names_name; ?>">
						<?php echo $helper->__html( $offer->item_type_name.','.$offer->item_names_name,30,array('html' => true)); ?></a>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <p class="md-font grey-font text-right float-right">البلد :</p>
                                <p class="md-font orange-font text-right float-right"><?php echo $offer->offer_country; ?>    </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <p class="md-font grey-font text-right float-right">مشاهدات :</p>
                                <p class="md-font orange-font text-right float-right"><?php echo $offer->views; ?></p>
                            </div>
                        </div>
                        <div class="grey-font md-font  home text-right">
                            <?php echo $helper->__html($offer->description,150,array('html' => true));  ?>
                        </div>
                        <a href="?page=singleproject&pid=<?php echo $offer->id  ?>" class="blue-link md-font text-left">المزيد</a>
                    </div>
                </div>
				<?php } ?>					
					
					

										