

	
 <?php include("wedget/user-header.php") ?>

<div class="container">
    <div class="row"> 
         <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
             <?php $catid=$this->registry->encryption->encode($category_data[0]['category_id']);?>
            <h2 class="full-lines sm-font"><span class="blue-font"><?php  if(isset($category_data[0]['cat_name']))  {echo $category_data[0]['cat_name'];}?></span></h2>
        </div>
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <div class="row">
                    <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12 def-padding zero-top-padding">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" id="allarticles-response">
							<?php include'wedget/allarticles.php';?>
                            
                            
                          
                        </div>
                        <div id="mySpinner" > </div>
                    </div>
					
					<?php if ($single_cat_data!=null){ ?>
                    <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 left-sidebar">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 round-corner grey-border lg-top-padding">
                            <div class="top-btn-center"><a href="?page=articles" class="btn white-btn md-font text-center border-btn">المزيد ...</a></div>

							<?php

											foreach($single_cat_data as $single_cat){
											$single_cat = (object) $single_cat
							?>

                            <p class="text-center blue-font sm-font"><?php echo $single_cat->name;?></p>

                            <ul class="diamond-list">
                              <?php
                                    $catID=$this->registry->encryption->decode($single_cat->id);
									$result =$this->registry->articles->getarticles_bycategoryid($catID);
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

                           <div class="separator"></div>
							<?php } ?>
                        </div>
                    </div>
					<?php } ?>
					
                </div>
            </div>
        </div>
        </div>

    </div>

 <script>
     $(window).scroll(function() {

         if($(window).scrollTop() == $(document).height() - $(window).height()  ) {

             $('#mySpinner').addClass('spinner');
             lazy_allarticlessearch();
         }
     });


 </script>