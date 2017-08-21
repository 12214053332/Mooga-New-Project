
				<?php foreach($homeprojects as $projects) {
										$projects = (object) $projects
										?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 round-corner grey-border col">
                        <a class="btn blue-button" href="?page=singleproject&pid=<?php echo $projects->id  ?>" title="<?php echo $projects->name ?>">
						<?php echo $helper->__html($projects->name,30,array('html' => true)); ?></a>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <p class="md-font grey-font text-right float-right">البلد :</p>
                                <p class="md-font orange-font text-right float-right"><?php echo $projects->project_country; ?>    </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <p class="md-font grey-font text-right float-right">مشاهدات :</p>
                                <p class="md-font orange-font text-right float-right"><?php echo $projects->views; ?></p>
                            </div>
                        </div>
                        <div class="grey-font md-font  home text-right">
                            <?php echo $helper->__html($projects->description,150,array('html' => true));  ?>
                        </div>
                        <a href="?page=singleproject&pid=<?php echo $projects->id  ?>" class="blue-link md-font text-left">المزيد</a>
                    </div>
                </div>
				<?php } ?>

            