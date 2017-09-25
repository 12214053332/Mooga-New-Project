
				<?php foreach($homeprojects as $projects) {
										$projects = (object) $projects
										?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="feature-item-container-box listing-item">
                            <div class="feature-title-item">
                                <h1><?php echo $projects->project_type_list ?></h1>
                                <img src="<?php echo $projects->picpath ?>" alt="img1"> </div>
                            <div class="hover-overlay">
                                <div class="hover-overlay-inner">
                                    <ul class="listing-links">
                                        <li><a href="#"><i class="fa fa-heart green-1 "></i></a></li>
                                        <li><a href="#"><i class="fa fa-map-marker blue-1"></i></a></li>
                                        <li><a href="#"><i class="fa fa-share yallow-1"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="feature-box-text">
                                <h3><a href="?page=singleproject&pid=<?php echo $projects->id  ?>">
                                        <?php echo $helper->__html($projects->name,30,array('html' => true)); ?>
                                    </a></h3>
                                <p> <?php echo $helper->__html($projects->description,100,array('html' => true));  ?>
                                    <a href="?page=singleproject&pid=<?php  echo $projects->id;?>">المزيد</a></p>
                            </div>
                            <div class="feature-item-location">
                                <h2><i class="fa fa-map-marker"></i><?php echo $projects->project_country; ?></h2>
<!--                                <h2><i class="fa fa-eye"></i><span></span>--><?php //echo $projects->views;?><!--</h2>-->
                                <h2 class="views"> <i class="fa fa-eye"></i><?php echo $projects->views;?> </h2> </div>
                        </div>
                    </div>
                                        <!--                    <div class="col-md-4 col-sm-6 col-xs-12">-->
<!--                        <div class="feature-item-container-box listing-item">-->
<!--                            <div class="feature-title-item">-->
<!---->
<!--                                <div class="feature-box-text">-->
<!--                                    <div class="feature-title-item">-->
<!--                                        <h1><a href=href="?page=singleproject&pid=--><?php //echo $projects->id  ?><!--">-->
<!--                                                --><?php //echo $helper->__html($projects->name,30,array('html' => true)); ?>
<!--                                            </a></h1>-->
<!--                                    </div>-->
<!---->
<!---->
<!--                                    <h5>   البلد:<a>--><?php //echo $projects->project_country; ?><!-- </a></h5>-->
<!--                                    <h5>   مشاهدات:<a>--><?php //echo $projects->views; ?><!-- </a></h5>-->
<!--                                    <p> --><?php //echo $helper->__html($projects->description,150,array('html' => true));  ?><!--</p>-->
<!--                                </div>-->
<!--                                <div class="feature-item-location">-->
<!--                                    <button class="btn " type="submit"> <a href="?page=singleproject&pid=--><?php //echo $projects->id  ?><!--">المزيد</a></button>-->
<!---->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
				<?php } ?>

            