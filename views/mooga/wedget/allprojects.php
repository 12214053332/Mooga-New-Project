                	<?php
                    $projectid="";
					foreach($projects as $project){
							$project = (object) $project;
							$projectid=$project->id;
					?>
                        <div class="recent-listing-box-container-item list-view-item">
                            <div class="col-md-4 col-sm-12 nopadding feature-item-listing-item listing-item">
                                <div class="recent-listing-box-image">
                                    <h1><?php echo $project->project_type_list;?></h1>
                                    <img src="<?php echo $project->picpath;?>" alt="<?php echo $project->name;?>"> </div>
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
                                    <div class="listing-boxes-text " >
                                        <a href="?page=singleproject&pid=<?php  echo $project->id;?>">
                                            <h3><?php echo $project->name;?></h3>
                                        </a>
                                        <!--<div class="phone">
                                            <a href="#"><i class="fa fa-phone"></i></a>
                                        </div>-->


                                        <p><?php  echo $helper->__html($project->description,150,array('html' => true, 'ending' => '')).'....'; ?>
                                            <a href="?page=singleproject&pid=<?php  echo $project->id;?>">المزيد</a></p>

<!--                                       --><?php //if ($project->ads_expireddate!=null){?><!--<a class="btn btn-success btn-block" href="?page=newmessage&pid=--><?php //$project->id ?><!--"> تفاصيل الاعلان</a>--><?php //} ?>

                                    </div>
                                    <div class="recent-feature-item-rating">
                                        <h2><i class="fa fa-map-marker"></i> <?php echo $project->project_country;?></h2>
                                        <span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </span> </div>
                                </div>
                            </div>
                        </div>
                
					<?php } if ($projectid!="" || $projectid!=null){
						echo "<div id='projectid' data-projectid='$projectid'></div>";
					}
                    ?>



