

	
 <?php include("wedget/user-header.php") ?>
				 <div class="container">
    <div class="row">
	  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs no-border">
           
            
               

                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm grey btm-mrg-sm">
					
                        <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12 def-padding">
                            <h2 class="line-right sm-font zero-bottom-margin"><span class="black-font">تصنيفات البحث</span></h2>
                            <form class="cust-form col-md-10 col-lg-offset-2 col-md-10 col-lg-offset-2 " id="<?php echo $form; ?>opportunities-form" method="post" action="#">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">أبحث عن </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="description"  name="description" placeholder="">
										<label for="description"></label>
                                    </div>
                                </div>
                               
                               <!-- <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">تاريخ الانتهاء</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="expiredate"  name="expiredate" placeholder="">
                                    </div>
                                </div>-->
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn orange-btn">ابحث</button>
									<div id="SearchSpinner" ></div>
                                </div>
                            </form>
                        </div>
                    </div>
        </div>
		
        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding grey-border">
            <h2 class="full-lines sm-font"><span class="blue-font">استعراض الفرص</span></h2>
            <a href="?page=addopportunity" class="md-font blue-font alg-left cust-border-btn negative-top"><i class="add-round"></i><span>أضف فرصة</span></a>
				
				<div class="row" id="allopportunities-response"> 	
			 		<?php include("wedget/allopportunities.php") ?>
			   </div>
		 <div id="mySpinner" > </div>
        </div>

		
    </div>
</div>

 <script>
 $( document ).ready(function() {
    $( "#expiredate" ).datepicker();
});
  
  </script>
  
  <script>
$(window).scroll(function() {
		     
    if($(window).scrollTop() == $(document).height() - $(window).height()  ) {
          
			$('#mySpinner').addClass('spinner');
	        lazy_<?php echo $form; ?>opportunitiessearch();
    }
});


</script>

