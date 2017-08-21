
	
 <?php include("wedget/user-header.php") ?>
	
<div class="container">
    <div class="row">
       <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <h2 class="full-lines sm-font"><span class="blue-font">تصنيفات المقالات</span></h2>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding btm-mrg-sm">
                        <div class="row">
						<?php foreach($allarticles_cat as $articles_cat) {
						$articles_cat = (object) $articles_cat
						?>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 def-padding-sm single-category ">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm ">
                                    <h2 class="line-right sm-font zero-bottom-margin"><span class="blue-font"><?php echo $articles_cat->name;?></span></h2>
                                    <div class="col-sm-4 col-xs-12 col-md-3 col-lg-3">
                                        <img class="articals" src="<?php echo $articles_cat->picpath;?>">
                                    </div>
                                    <div class="col-sm-8 col-xs-12 col-md-9 col-lg-9">
                                        <ul class="diamond-list">
										<?php

											$result =$this->registry->articles->getarticles_bycategoryid($this->registry->encryption->decode($articles_cat->id));
											$i=0;
											foreach($result as $article){
											$i++;
											if($i >4)
											{
												break;
											}
											$article = (object) $article
											
											
											
										?>
                                            <li><a href="?page=singlearticle&id=<?php echo $this->registry->encryption->encode($article->id);?>"><?php echo $article->name;?></a></li>
                                            
											<?php } ?>
                                        </ul>
                                    </div>
                                    <div class="left-btns-cont-bottom"><a href="?page=singlecategory&id=<?php echo $articles_cat->id ?>" class="btn white-btn md-font text-center border-btn">المزيد ...</a></div>
                                </div>
                            </div><!--End single block-->
							<?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>

    </div>

