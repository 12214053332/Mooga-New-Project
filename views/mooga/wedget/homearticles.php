			<?php foreach($home_articles as $articles) {
						$articles = (object) $articles
						?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 round-corner grey-border">
                    <p class="md-font black-font text-center"><?php echo $articles->name; ?> </p>
                    <img class="home-artical" src="  <?php echo $articles->picpath; ?>">
                    <div class="grey-font md-font home">
                        <?php  echo $helper->__html($articles->description,236, 
array('html' => true, 'ending' => '')); ?>
                    </div>
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p class="md-font grey-font text-right float-right">مشاهدات :</p>
                                <p class="md-font orange-font text-right float-right"><?php echo $articles->views ?></p>
                            </div>
                    <a href="?page=singlearticle&id=<?php echo $articles->id ?>" class="btn white-btn md-font text-center border-btn">المزيد</a>
                </div>
            </div>
			<?php } ?>

         
		 
	