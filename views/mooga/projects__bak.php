

	
      <?php include("wedget/user-header.php") ?>
		<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs no-border">
            
            <div class="tab-content">
       
		
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm grey btm-mrg-sm">
                        <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12 def-padding  ">
                            <h2 class="line-right sm-font zero-bottom-margin"><span class="black-font">تصنيفات البحث</span></h2>
                            <form class="cust-form col-md-10 col-lg-offset-2 col-md-10 col-lg-offset-2 " id="<?php echo $form;?>projects-form" method="post"  action="#"> 
                                
								
								
								<div class="form-group">
                                    <label for="" class="col-sm-3 control-label">ابحث عن </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="description"  name="description" placeholder="">
										<label for="description"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">في دولة</label>
                                    <div class="col-sm-8">
                                            <select class="form-control chosen-select" data-placeholder="اختر  دولة المشروع" multiple id="country" name="country">
											<option value=""></option>
                                                <?php $helper->getoptions_single( $countries,""); ?>
                                               
                                            </select>
                                </div> 
								</div>
								
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">المرحلة</label>
                                    <div class="col-sm-8">
                                        <select class="form-control chosen-select" data-placeholder="اختر مرحلة المشروع الحالية"  multiple  id="stage" name="stage">
											<option value=""></option>
                                                   <?php $helper->getoptions( $project_stage,""); ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9">
                                        <label for="" class="col-sm-3 control-label">المشروع يحتاج </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="needagent" name="needagent" value="1">موزع
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="needpartner" name="needpartner" value="1">شريك
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="inlineCheckbox3" value="1">ممول
                                        </label>
                                    </div>
                                   
                                </div>
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn orange-btn">إبحث</button>
									<div id="SearchSpinner" ></div>
                                </div>
                            </form>
                        </div>
                       
                    </div>
                
			 <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding grey-border">
            <h2 class="full-lines sm-font"><span class="blue-font">استعراض المشاريع</span></h2>
            <a href="?page=addproject" class="md-font blue-font alg-left cust-border-btn negative-top"><i class="add-round"></i><span>أضف مشروع</span></a>
			  <?php  if  ($currentpage!= "closeprojects"){?>
				 <a href="?page=closeprojects" class="btn orange-btn"><span>استعراض مشروعات فى مرحلة تصفية</span></a>
			  <?php }?>
				<div  class="row" id="allprojects-response"> 
                	
					<?php include('wedget/allprojects.php') ?>
				
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
	     	lazy_<?php echo $form;?>projectssearch();	
    }
});


</script>
