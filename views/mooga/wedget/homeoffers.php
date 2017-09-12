

				<?php foreach($homeoffers as $offer) {
										$offer = (object) $offer
										?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="recent-listing-box-container-item">
                            <div class="col-md-6 col-sm-12 nopadding">
                                <div class="recent-listing-box-image">
                                    <h1><?php echo $offer->item_brand_name ?></h1>
                                    <img src="<?php echo $offer->picpath ?>" alt="img1"> </div>
                                <div class="hover-overlay">
                                    <div class="hover-overlay-inner">
                                        <ul class="listing-links">
                                            <li><a href="#"><i class="fa fa-heart green-1"></i></a></li>
                                            <li><a href="#"><i class="fa fa-map-marker blue-1"></i></a></li>
                                            <li><a href="#"><i class="fa fa-share yallow-1"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 nopadding">
                                <div class="recent-listing-box-item">
                                    <div class="listing-boxes-text">
                                           <a href="?page=singleoffer&pid=<?php echo $offer->id  ?>">
                                               <h3> <?php echo $helper->__html( $offer->item_type_name.','.$offer->item_names_name,30,array('html' => true)); ?>
                                       </h3></a>

                                        <p> <?php echo $helper->__html($offer->description,150,array('html' => true));  ?></p>
                                    </div>
                                    <div class="recent-feature-item-rating">
                                        <h2><i class="fa fa-map-marker"></i><?php echo  $offer->offer_country; ?></h2>
                                        <h2 class="offers_views"> <i class="fa fa-eye"></i><?php echo $offer->views;?> </h2>
                                        </div>
                            </div>
                        </div>
                        </div>
                    </div>

				<?php } ?>					
					
					

										