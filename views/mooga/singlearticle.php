
	
 <?php include("wedget/user-header.php") ?>
	<div class="container">
    <div class="row">
 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table sm-top-padding">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding btm-mrg-sm">
                        <div class="row">
                            <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
                                <h2 class="line-right md-lg-font zero-bottom-margin"><span class="blue-font"><?php echo $article_data->name;?></span></h2>
								<a href="<?php if ($ispublic===TRUE){echo "?page=singlearticle&id=$article_data->id&type=1";}else {echo "?page=singlearticle&id=$article_data->id";} ?>" class="btn orange-btn"><span><?php if ($ispublic===TRUE){echo 'قراءة المقال باللغة الفصحى';}else {echo 'قراءة المقال باللغة العامية';} ?> </span></a>
                                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">الكاتب : </p>
                                        <p class="md-font grey-font zero-bottom-margin"><?php echo $article_data->author_name;?></p>
                                    </div>    

					<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">تاريخ النشر : </p>
                                        <p class="md-font grey-font zero-bottom-margin"><?php echo date('Y-m-d',strtotime($article_data->article_date));?></p>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">مشاهدات : </p>
                                        <p class="md-font grey-font zero-bottom-margin"><?php echo $article_data->views;?></p>
                                    </div>    

                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 def-padding-sm">
                                <h2 class="line-left sm-font zero-bottom-margin"><span class="blue-font">شارك المقال</span>
                                    <ul class="social-media side-bar">
									    
                                        <li data-url=""><a href="#" data-url="http://www.facebook.com/sharer.php?u=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>"><i class="fa fa-facebook round-corner"></i></a></li>
                                        <li><a href="javascript:void(0);" data-url="http://twitter.com/intent/tweet?url=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>"><i class="fa fa-twitter round-corner"></i></a></li>
                                        <li><a href="javascript:void(0);" data-url="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>"><i class="fa fa-linkedin round-corner"></i></a></li>
                                        
                                    </ul>
                                </h2>
                            </div>
                            <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 def-padding-sm ">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 def-padding-sm artical">
                                    <img src=" <?php echo $article_data->picpath;?>" class="img-responsive">
                                    
									 <?php

                                     echo ($ispublic===TRUE)?$article_data->description:$article_data->public;
									 /*if (isset($getuserid)){
									 echo $article_data->description;}
									 else
									 {
										 echo $helper->__html($article_data->description,236, 
                                          array('html' => true, 'ending' => ''));
										  echo "<a href='?page=login'  class='btn orange-btn'><span>استكمل قراءة المقال</span></a>";
									 }*/
									
									?>
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 def-padding-sm md-top-pdg">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
                                    <h2 class="line-right sm-font zero-bottom-margin"><span class="blue-font"><?php echo $allarticles_cat[0]['name'];?></span></h2>
                                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                                        <ul class="diamond-list cst-pdg">
										<?php
											$result =$this->registry->articles->getarticles_bycategoryid($this->registry->encryption->decode($allarticles_cat[0]['id']));
											foreach($result as $article){
											$article = (object) $article
										?>
                                           <li><a href="?page=singlearticle&id=<?php echo $this->registry->encryption->encode($article->id);?>"><?php echo $article->name;?></a></li>
 											<?php } ?>
                                        </ul>
                                        <div class="left-btns-cont-bottom cust-sidebar"><a href="?page=singlecategory&id=<?php echo $allarticles_cat[0]['id'];?>" class="btn white-btn md-font text-center border-btn">المزيد ...</a></div>
                                    </div>
                                </div>
                                <?php if (isset($allarticles_cat[1]['name']) ){ ?>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
                                    <h2 class="line-right sm-font zero-bottom-margin"><span class="blue-font"><?php echo $allarticles_cat[1]['name'];?></span></h2>
                                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                                        <ul class="diamond-list cst-pdg">
										<?php
											$result =$this->registry->articles->getarticles_bycategoryid($this->registry->encryption->decode($allarticles_cat[1]['id']));
											foreach($result as $article){
											$article = (object) $article
										?>
                                            <li><a href="?page=singlearticle&id=<?php echo $this->registry->encryption->encode($article->id);?>"><?php echo $article->name;?></a></li>
 											<?php } ?>
                                        </ul>
                                        <div class="left-btns-cont-bottom cust-sidebar"><a href="?page=singlecategory&id=<?php echo $allarticles_cat[1]['id'];?>" class="btn white-btn md-font text-center border-btn">المزيد ...</a></div>
                                    </div>
                                </div>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>

    </div>
	
	<!--<script> ajaxbalance(); </script>-->

