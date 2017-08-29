			<?php foreach($home_articles as $articles) {
						$articles = (object) $articles
						?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="recent-listing-box-container-item">
                        <div class="col-md-6 col-sm-12 nopadding">
                            <div class="recent-listing-box-image">
                                <h1><?php echo $articles->name; ?></h1>
                                <img src="<?php echo $articles->picpath; ?>" alt="img1"> </div>
                        </div>
                        <div class="col-md-6 col-sm-12 nopadding">
                            <div class="recent-listing-box-item">
                                <div class="listing-boxes-text">


                                    <p><?php  echo $helper->__html($articles->description,200,
                                            array('html' => true, 'ending' => '')); ?></p></p>
                                    <h5>   مشاهدات:<a><?php echo $articles->views  ?> </a></h5>
                                </div>

                        </div>

                                <div class="recent-feature-item-rating ">
                                    <button class="btn " type="submit"> <a href="?page=singlearticle&id=<?php echo $articles->id ?>">المزيد</a></button>

                                </div>

                    </div>
                </div>

                </div>

			<?php } ?>

         
		 
	