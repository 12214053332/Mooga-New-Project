<?php foreach($projectcolsed as $project) {
										$project = (object) $project
										?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p class="md-font black-font text-center"><?php echo  $helper->__html($project->name,50,array('html' => true))  ?></p>
                        <img class="home-closeproject" src="<?php echo $project->picpath; ?>">
                        <div class="grey-font md-font home">
                            <?php echo $helper->__html($project->description,200,array('html' => true)) ;?>
                        </div>
                        <a href="?page=singleproject&pid=<?php echo $project->id  ?>" class="blue-link md-font text-left">شاهد المشروع</a>
                    </div>
                </div>
	<?php } ?>