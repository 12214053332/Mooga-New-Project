

 

        	
 <?php include("wedget/user-header.php");
global $object;
 $object=isset($product) ? $product : '';
 ?>
 
<div class="container">
    <div class="row">

		
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs no-border">
          
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm grey btm-mrg-sm">
                        <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12 def-padding left-border">
                            <h2 class="line-right sm-font zero-bottom-margin"><span class="black-font">                                ابحث عن من يقدمون </span></h2>
                            <form class="cust-form" id="users-search-form">
                                
                                <div class="form-group">
                                    <div class="col-sm-12">
                                             <select class="form-control  chosen-select" name="provide_agent" id="provide_agent" multiple data-placeholder="موزعون وكلاء فى - يمكنك اختيار اكثر من مجال">
												<?php $helper->getoptions( $provide_agent_list,""); ?>
											</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                      <select class="form-control  chosen-select" name="provide_product" id="provide_product" multiple data-placeholder="منتجات وخدمات - يمكنك اختيار اكثر من منتج / خدمة">
										<?php $helper->getoptions( $provide_product_list,""); ?>
									</select>
                                    </div>
                                </div>
								
								 <div class="form-group">
                                   
                                    <div class="col-sm-12">
                                            <select class="form-control chosen-select" data-placeholder="اختر دولة الاقامة" multiple id="country" name="country">
											<option value=""></option>
                                                <?php $helper->getoptions_single( $countries,""); ?>
                                               
                                            </select>
                                </div>
								</div>

                              
                           
                        </div>
                        <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12 def-padding ">
                            <h2 class="line-right sm-font zero-bottom-margin"><span class="black-font">                                  ابحث عن من يحتاجون</span></h2>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                         <select class="form-control  chosen-select" name="need_agent" id="need_agent" multiple data-placeholder="موزعون وكلاء فى - يمكنك اختيار اكثر من مجال">
											<?php $helper->getoptions( $need_agent_list,""); ?>
										</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    
                                    <div class="col-sm-12">
                                         <select class="form-control  chosen-select" name="need_product" id="need_product" multiple data-placeholder="منتجات وخدمات - يمكنك اختيار اكثر من منتج / خدمة">
											<?php $helper->getoptions( $need_product_list,""); ?>
										</select>
                                    </div>
                                </div>
								
								 <div class="form-group">
                                   
                                    <div class="col-sm-12">
                                            <select class="form-control chosen-select" data-placeholder="دول يمكنه العمل بها" multiple id="worked_country_list" name="worked_country_list">
											<option value=""></option>
                                                <?php $helper->getoptions( $worked_country_list,""); ?>
                                               
                                            </select>
                                </div>
								</div>
                                
                                <button type="submit" class="btn orange-btn">إبحث</button>
								<div id="SearchSpinner" ></div>
                            </form>
                        </div>
                       
                    </div>
                   <div  class="col-md-12 col-lg-12 col-xs-12 col-sm-12" id="users-search-response">
				   <div class="row">
                        <?php include('wedget/allusers.php'); ?> 
						</div></div>
						
						
        </div>
    </div>
</div>
<div id="mySpinner" > </div>

<script>
$(window).scroll(function() {
		     
    if($(window).scrollTop() == $(document).height() - $(window).height()  ) {
          //alert('asdasdasd');
			$('#mySpinner').addClass('spinner');
	     	lazy_users_search();	
    }
});


</script>