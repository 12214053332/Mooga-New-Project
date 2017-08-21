

				<?php
				$i=0;
				$header="";$body="";$active="active";
				foreach($homeopportunities as $opportunity) {
				$opportunity = (object) $opportunity;
				$description=  $helper->__html($opportunity->description,200,array('html' => true));
				
				$header=$header . "<li data-target='#carousel-one' data-slide-to='$i' class='active'></li>";
				$body=$body." <div class='item $active'>
                                <div class='row'>
                                    <div class='col-lg-4 col-md-4 col-sm-12 col-xs-12 def-padding'>
                                       <img class='home-opportunities' src='$opportunity->picpath'>
                                    </div>
                                    <div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 def-padding'>
                                        <p class='sm-font blue-font text-right'> $opportunity->name</p>
                                        <p class='md-font grey-font text-right'>
                                          $description
                                        </p>
                                    </div>
                                </div>
                            </div>"	;
				
				   $active="";
				   $i++;
				}
										
?>

                    <div id="carousel-one" class="carousel slide cust slider-fix" data-ride="carousel">
                        <ol class="carousel-indicators">
                           <?php echo $header ;?>
                            <a href="?page=opportunities" class="btn white-btn md-font float-left zero-top-margin">للمزيد من الفرص</a>
                        </ol>
                        <div class="carousel-inner" role="listbox">
				        <?php echo $body ;?>
                     
					 </div>
                    </div>

										