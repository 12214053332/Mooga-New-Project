                	<?php
                    $offerid="";
					foreach($offers as $offer){
							$offer = (object) $offer;
							$offerid=$offer->id;
					?>
                        <div class="recent-listing-box-container-item list-view-item">
                            <div class="col-md-4 col-sm-12 nopadding feature-item-listing-item listing-item">
                                <div class="recent-listing-box-image">
                                    <h1><?php echo $offer->offer_type_filed;?></h1>
                                    <img src="<?php echo $offer->picpath;?>" alt="<?php echo $offer->item_brand_name  . ' , ' .$offer->item_type_name.' , '.$offer->item_names_name ?>"> </div>
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
                            <div class="col-md-8 col-sm-12 nopadding">
                                <div class="recent-listing-box-item">
                                    <div class="listing-boxes-text"> <a href="?page=singleoffer&pid=<?php  echo $offer->id;?>">
                                            <h3><?php echo $offer->item_brand_name  . ' , ' .$offer->item_type_name.' , '.$offer->item_names_name ?></h3>
                                        </a> <a href="#"><i class="fa fa-phone"></i> +91 087 654 3210</a>
                                        <p><?php echo $offer->description;?></p>
                                    </div>
                                    <div class="recent-feature-item-rating">
                                        <h2><i class="fa fa-map-marker"></i> <?php echo $offer->offer_country;?></h2>
                                        <span>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                
					<?php } if ($offerid!="" || $offerid!=null){
						echo "<div id='offerid' data-offerid='$offerid'></div>";
					}					?>