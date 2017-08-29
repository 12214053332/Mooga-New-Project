
				<?php foreach($homeprojects as $projects) {
										$projects = (object) $projects
										?>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="feature-item-container-box listing-item">
                            <div class="feature-title-item">

                                <div class="feature-box-text">
                                    <div class="feature-title-item">
                                        <h1><a href=href="?page=singleproject&pid=<?php echo $projects->id  ?>">
                                                <?php echo $helper->__html($projects->name,30,array('html' => true)); ?>
                                            </a></h1>
                                    </div>


                                    <h5>   البلد:<a><?php echo $projects->project_country; ?> </a></h5>
                                    <h5>   مشاهدات:<a><?php echo $projects->views; ?> </a></h5>
                                    <p> <?php echo $helper->__html($projects->description,150,array('html' => true));  ?></p>
                                </div>
                                <div class="feature-item-location">
                                    <button class="btn " type="submit"> <a href="?page=singleproject&pid=<?php echo $projects->id  ?>">المزيد</a></button>

                                </div>
                            </div>
                        </div>
                    </div>
				<?php } ?>

            