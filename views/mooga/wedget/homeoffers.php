

				<?php foreach($homeoffers as $offer) {
										$offer = (object) $offer
										?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="feature-item-container-box listing-item">
                            <div class="feature-title-item">

                                <div class="feature-box-text">
                                    <div class="feature-title-item">
                                        <h1><a href=href="?page=singleoffer&pid=<?php echo $offer->id  ?>">
                                                <?php echo $helper->__html( $offer->item_type_name.','.$offer->item_names_name,30,array('html' => true)); ?></a>
                                            </a></h1>
                                    </div>


                                    <h5>   البلد:<a><?php echo $offer->offer_country; ?> </a></h5>
                                    <h5>   مشاهدات:<a><?php echo $offer->views;?> </a></h5>
                                    <p>  <?php echo $helper->__html($offer->description,150,array('html' => true));  ?></p>
                                </div>
                                <div class="feature-item-location">
                                    <button class="btn " type="submit"> <a href="?page=singleoffer&pid=<?php echo $offer->id  ?>">المزيد</a></button>

                                </div>
                            </div>
                        </div>
                    </div>

				<?php } ?>					
					
					

										