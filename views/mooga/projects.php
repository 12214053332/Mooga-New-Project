

	
      <?php include("wedget/user-header.php") ?>
		<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs no-border">
            
            <div class="tab-content">
		<?php if(in_array($currentpage,['projects'])) { ?>
            <div class="col-lg-6" style="padding-left:5px;">
                <a href="javascript:void(0);" id="advanced-search-btn" class="btn orange-btn pull-left"><span>بحث متقدم فى  المشروعات </span></a>
            </div>

		<?php } ?>
                <div class="<?php if(in_array($currentpage,['projects'])) { ?>col-lg-6<?php }else{?>col-lg-12<?php }?>" style="padding-right:5px;">
                    <a href="?page=addproject" class="btn orange-btn <?php if(in_array($currentpage,['projects'])) { ?>pull-right<?php }else{?>text-center<?php }?>"><span>أضف مشروع جديد</span></a>
                </div>

                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm grey btm-mrg-sm" <?php if ($currentpage!='investment'){echo 'style="display:none" id="advanced-search"';}?>>
                        <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 def-padding  ">
                            <h2 class="line-right sm-font zero-bottom-margin"><span class="black-font">تصنيفات البحث</span></h2>
							
                            <form class="cust-form col-md-11 col-lg-11 col-xs-12 col-sm-12 col-lg-offset-2  col-lg-offset-2 " id="<?php echo $form;?>projects-form" method="post"  action="#">
								<input type="hidden" name="record" value="<?php printvalue('id') ?>">
								<div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <label class=" control-label md-font bold black-font">اسم المشروع او وصف المشروع  </label>
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <input type="text" class="form-control" id="name" name="name" placeholder=""   value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                        <label class="control-label md-font bold black-font">نوع المشروع </label>
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <select class="form-control chosen-select" data-placeholder="اختر نوع عمل المشروع"  id="project_type" name="project_type" >
											<option value=""></option>
                                                   <?php $helper->getoptions( $project_type,""); ?>
                                                
                                            </select>
											
                                        </div>
                                    </div>
									 <div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                        <label for="project_field" class=" control-label md-font bold black-font">مجال عمل المشروع  </label>
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <select class="form-control chosen-select" data-placeholder="اختر مجال عمل المشروع"   id="project_field" name="project_field"  <?php  echo $object->project_field_list; ?>>
												<option value=""></option>                                                 
												 <?php $helper->getoptions( $project_field,""); ?>
                                               
                                            </select>
                                        </div>
                                    </div>
									<div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                        <label for="stage" class="control-label md-font bold black-font">حالة المشروع</label>
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <select class="form-control chosen-select" data-placeholder="اختر مرحلة المشروع الحالية"  id="stage" name="stage">
											<option value=""></option>
                                                   <?php $helper->getoptions( $project_stage,""); ?>
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
												 <label for="country"></label>
                                                </div>
                                            </div>
                                        
                                            <div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                                <label  class=" control-label text-center">
												
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
												
												المدينة</label>
                                                <div class=" col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                  
												<select class="form-control chosen-select" id="cities" name="cities" >
												
													<option value="">اختر</option>
													 
                                                 </select>
												 <label for="cities"></label>
                                                </div>
                                            </div>
                                        </div>
										 <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <!--<h2 class="full-lines sm-font"><span class="blue-font">احتياجات المشروع</span></h2>-->
									   </div>
										<!--<div class="form-group  col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <label for="needpartner" class="col-md-3 col-lg-3 col-xs-4 col-sm-4 control-label md-font bold black-font">المشروعات التى تحتاج الى :  </label>
                                        <div class="col-lg-9 col-md-9 col-xs-8 col-sm-8">
                                            <label class="radio-inline">
                                                <input type="checkbox" id="needpartner" name="needpartner" value="1" placeholder="" > شريك
                                            </label>
                                            <label class="radio-inline" >
                                                <input type="checkbox" id="needfunder" name="needfunder" value="1" placeholder="" >   مستثمر
                                            </label>
	
											<label class="radio-inline">
                                                <input type="checkbox" id="needbuyer" value="1" name="needbuyer" placeholder=""> شارى للمشروع
                                            </label>
											  
                                        </div>
                                     </div>-->
									 
									 <div class="form-group  col-md-12 col-lg-12 col-xs-12 col-sm-12">
									     <label class="  col-md-3 col-lg-3 col-xs-6 col-sm-6 control-label md-font bold black-font"> المبلغ المراد استثمارة :</label>
                                        <div class="col-md-3 col-lg-3 col-xs-3 col-sm-3">
                                            <input type="text" class="form-control" id="frombudget" name="frombudget" placeholder=""   value="">
											
                                        </div>
										 <label style="text-align: left !important;" class="  col-md-1 col-lg-1 col-xs-6 col-sm-6 control-label md-font bold black-font">  الى  :</label>
										 
										 <div class="col-md-3 col-lg-3 col-xs-6 col-sm-6 "  >
                                            <input  type="text" class="form-control" id="tobudget" name="tobudget" placeholder=""   value="">
											
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
            <h2 class="full-lines sm-font"><span class="blue-font">استعراض المشروعات</span></h2>
            

			
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
<script>

$(document).ready(function(){
	

    $("#country").chosen().change(function(){
		var country_code1= $('#country').chosen().val();
		var code =$("#country").find(':selected').data('code')
		 $("#code").html(code);
		 $("input[name=phone]").attr('style', 'text-align: left;direction:ltr;');
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=country',
                    data:{country_code:country_code1}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#states').html(data);
						 $("#states").trigger("chosen:updated");	
						 
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#states").trigger("chosen:updated");			
    });
	
	    $("#states").chosen().change(function(){
		var country_code1= $('#states').chosen().val();
		//var code =$("#country").find(':selected').data('code')
//		 $("#code").html(code);
	//	 $("input[name=phone]").attr('style', 'text-align: left;direction:ltr;');
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=states',
                    data:{country_code:country_code1}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#cities').html(data);
						 $("#cities").trigger("chosen:updated");	
						 
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#cities").trigger("chosen:updated");			
    });
	
});






</script>
