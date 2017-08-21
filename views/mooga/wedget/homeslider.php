
			<?php 
			 $active='active';
			foreach($slider_articles as $articles) {
						$articles = (object) $articles
						?>
   
			
			<div class="item <?php echo $active ?>">
            <img src="assets/images/slider_3.jpg">
            <div class="carousel-caption cst-cap">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <p class="sm-font white-font text-right">أحدث المقالات</p>
                        <p class="lg-font white-font text-right home-header"><?php echo $articles->name; ?></p>
                        <div class="md-font white-font text-right">
						<?php  echo $helper->__html($articles->description,236, 
                        array('html' => true, 'ending' => '')); ?></div>
						 <a href="?page=singlearticle&id=<?php echo $articles->id ?>" class="btn white-btn md-font text-center border-btn">المزيد</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <img class="home-sider-img" src="<?php echo $articles->picpath; ?>">
                    </div>
                </div>
            </div>
        </div>
        
			<?php $active=''; } ?>

         