		 <?php 
	  global $object;
       $object=isset($project) ? $project : '';
	 ?>	
	 
<div class="container">
    <div class="row">
        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 center-table">
            <h2 class="full-lines sm-font"><span class="black-font">تفعيل مشروع</span></h2>
            <p class="grey-font md-font text-center">من فضلك أدخل كود تفعيل المشروع </p>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs">
                
                <div class="tab-content">
				
                    <div role="tabpanel" class="col-md-12 col-lg-12 col-xs-12 col-sm-12 tab-pane active dark-grey" id="verifie_project">
                        <div class="row">
                         
                                        <div class="form-group">
                                            
                                        </div>
										<div class="form-group">
										
                                        </div>
                                        <div class="form-group">
                                            
                                        </div>
                          
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class="col-md-10 col-lg-10 col-xs-10 col-sm-10 center-table">
                                    <form class="login-form col-md-8 col-lg-8 col-xs-12 col-sm-12 center-table" action="#" method="post" id="verifie_project-form" name="verifie_project-form">
									  <input type="hidden" class="form-control" id="project_id" name="project_id"value="<?php echo $project_id; ?>">
										<input type="hidden" name="_token" value="<?=$_SESSION['tokenNumber']?>">
										<div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <label for="" class="col-md-4 col-lg-4 col-xs-4 col-sm-4 control-label"><span class="asterisc">*</span>كود التفعيل</label>
                                            <div class="col-md-8 col-lg-8 col-xs-8 col-sm-8">
												
											  <input type="text" class="form-control" id="verifie_code" name="verifie_code" placeholder="من فضلك أدخل كود تفعيل المشروع"  required>
											  <label for="verifie_code"></label>                                              
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-3 col-lg-3 col-xs-12 col-sm-12">
                                            <div class="">
                                                <button name="submit" class="btn orange-btn">ارســـــال</button>
                                            </div>
											
                                        </div>
										<div  class="form-group">
											<div id="verifie_project-response">
                                                
                                            </div>
											 </div>
                                    </form>
									
									<!-- contact information -->		
                                    
									<form class="login-form col-md-8 col-lg-8 col-xs-12 col-sm-12 center-table" action="#" method="post" id="change_project-form" name="change_project-form">
									 <input type="hidden" class="form-control" id="project_id" name="project_id"value="<?php echo $project_id; ?>">
									<?php include("wedget/contact_information.php") ?>
									
									<div class="form-group col-md-3 col-lg-3 col-xs-12 col-sm-12">
                                            <div class="">
                                                <button type="submit" name="submit" class="btn orange-btn">تغيير بيانات الاتصال</button>
                                            </div>
											
                                        </div>
										<div  class="form-group">
											<div id="change_project-response">
                                                
                                            </div>
											 </div>
									</form>
                                 	<!-- contact information -->
									
									
                                </div>
                            </div>
                        </div>
                    </div>

			   </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">


		 $( document ).ready(function() {
	
		
    		$( "#contact_type" ).change(function() {
           // $('#key').val( $('#country').find(':selected').data('code') );
		   change_countact_type1();
		   //alert($( "#contact_type" ).val());
          }); 
		  
		  function change_countact_type1(){
			  var typevalue=$( "#contact_type" ).val();
		   if (typevalue==1){
			  $( "#contact_section" ).html('<?php include("wedget/contact_phone.php"); ?>'); 
		   }else if (typevalue==2)
		   {
			     $( "#contact_section" ).html('<label for="contact_email" class="control-label md-font bold black-font">الإيميل <span class="asterisc">*</span> </label> <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"> <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder=""   value="<?php printvalue('contact_email'); ?>"></div>'); 
		   }
		  }
		  
		     change_countact_type1();
			 
         });

			</script>