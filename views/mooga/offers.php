
	
      <?php include("wedget/user-header.php") ?>
		<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs no-border">
            
            <div class="tab-content">
                <?php if(in_array($currentpage,['offers'])) { ?>
                    <div class="col-lg-6" style="padding-left:5px;">
                        <a href="javascript:void(0);" id="advanced-search-btn" class="btn orange-btn pull-left"><span>بحث متقدم فى عروض الجملة </span></a>
                    </div>
               <?php }?>
                <div class="<?php if(in_array($currentpage,['offers'])) { ?>col-lg-6<?php }else{?>col-lg-12<?php }?>" style="padding-right:5px;">
                    <a href="?page=addoffer" class="btn orange-btn <?php if(in_array($currentpage,['offers'])) { ?>pull-right<?php }else{?>text-center<?php }?>"><span>أضف عرض جملة جديد</span></a>
                </div>
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm grey btm-mrg-sm" style="display:none" id="advanced-search">
                        <div class="col-md-11 col-lg-11 col-xs-12 col-sm-12 def-padding  ">
                            <h2 class="line-right sm-font zero-bottom-margin"><span class="black-font">بحث فى عرض الجملة</span></h2>
                            <form class="cust-form col-md-10 col-lg-10 col-xs-12 col-sm-12 col-lg-offset-2  col-lg-offset-2 " id="<?php echo $form;?>offers-form" method="post"  action="#">


                                <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <label class=" control-label md-font bold black-font">وصف عرض الجملة</label>
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <input type="text" class="form-control" id="description" name="description" placeholder=""   value="">
                                    </div>
                                </div>
									 <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <label for="offer_type_filed" class=" control-label md-font bold black-font">حالة البضاعة </label>
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <select class="form-control chosen-select" data-placeholder="اختر حالة البضاعة"   id="offer_type_filed" name="offer_type_filed"  <?php  echo $object->offer_type_filed; ?>>
												<option value=""></option>                                                 
												 <?php $helper->getoptions( $offer_type_filed,""); ?>
                                               
                                            </select>
                                        </div>
                                    </div>
									 
									<div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                        <label class=" control-label md-font bold black-font">الماركة  </label>
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
										 <select class="form-control chosen-select" data-placeholder="اختر الماركة "   id="item_brand" name="item_brand" >
												<option value=""></option>                                                 
												 <?php $helper->getoptions_single( $item_brand,"[$object->item_brand]"); ?>
                                               
                                            </select>
                                           
											
                                        </div>
                                    </div>
									
									<div class="form-group col-md4 col-lg-4 col-xs-12 col-sm-12 ">
                                        <label class=" control-label md-font bold black-font">النوع </label>
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
										 <select class="form-control chosen-select" data-placeholder="اختر النوع "   id="item_type" name="item_type" >
												<option value=""></option>                     
                                               
                                            </select>
                                           
											
                                        </div>
                                    </div>
									
								<div class="form-group col-md4 col-lg-4 col-xs-12 col-sm-12">
                                        <label class=" control-label md-font bold black-font">الصنف </label>
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
										<select class="form-control chosen-select" data-placeholder="اختر الصنف"   id="name" name="name" >
												<option value=""></option>                                                 
												
                                               
                                            </select>
                                        </div>
                                    </div>
									
							
									 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                                <label  class="control-label text-center">الدولة</label>
                                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                  
												<select class="form-control chosen-select" id="country" name="country" >
												
													<option value="">اختر</option>
													  <?php
													 
																foreach ($countries as $country) {
																	$id=$country['id'];
																	$name=$country['name'];
																	$code=$country['code'];
																	echo " <option value='$id'  data-code='$code' >$name</option> ";
																}
													 ?>
                                                 </select>
												
                                                </div>
                                            </div>
                                       
                                            <div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                                <label  class="control-label text-center">
												
												المحافظة</label>
                                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                  
												<select class="form-control chosen-select" id="states" name="states" >
												
													<option value="">اختر</option>
													 
                                                 </select>
												 <label for="states"></label>
                                                </div>
                                            </div>
                                   
                                            <div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                                <label  class=" control-label text-center">
												
											المدينة	</label>
                                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                  
												<select class="form-control chosen-select" id="cities" name="cities" >
												
													<option value="">اختر</option>
													 
                                                 </select>
												 <label for="cities"></label>
                                                </div>
                                            </div>
                                        </div>
									
									
									
								
                                <div class="col-lg-9 col-md-9 col-xs-8 col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn orange-btn">إبحث</button>
									<div id="SearchSpinner" ></div>
                                </div>
                           

						   </form>
                        </div>
                       
                    </div>
                
			 <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding grey-border">
            <h2 class="full-lines sm-font"><span class="blue-font">استعراض عروض الجملة</span></h2>
            

			 
				<div  class="row" id="alloffers-response"> 
                	
					<?php include('wedget/alloffers.php') ?>
				
				</div>
				<div id="mySpinner" > </div>
			
					</div>
				</div>
               
		
        </div>
    </div>
</div>

<script>
$(window).scroll(function() {
		     
    if($(window).scrollTop() == $(document).height() - $(window).height()  ) {
          
			$('#mySpinner').addClass('spinner');
	     	lazy_<?php echo $form;?>offerssearch();	
    }
});


</script>



