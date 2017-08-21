

 

 <?php include("wedget/user-header.php") ;
 global $object;
 $object=isset($opportunity) ? $opportunity : '';
 ?>
 
  
<div class="container">
    <div class="row">

        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <h2 class="full-lines sm-font"><span class="blue-font"><?php if (getvalue('id')!="")echo "تعديل فرصة ";else echo"أضف فرصة جديدة"?> </span></h2>
               <?php if ($user->phone!=""){ ?>               
			   <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border def-padding">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">
                            <div class="col-md-10 col-lg-10 col-xs-10 col-sm-10 center-table">
							
                                <form class="opportunity-form" id="opportunity-form" action="#" method="post">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>اسم الفرصة</label>
										<input type="hidden" name="opportunity_id" value="<?php printvalue('id') ?>">
                                        <div class="col-sm-9">
                                             <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?php printvalue('name'); ?>">
											 
											 <label for="name"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>تفاصيل الفرصة</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" id="description"  name="description" placeholder=""><?php  printvalue(  'description') ?></textarea>
											<label for="description"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>تاريخ انتهاء الفرصة</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="expiredate"  class="form-control" name="expiredate" placeholder="" value="<?php   printvalue('expiredate') ?>">
											<label for="expiredate"></label>
                                        </div>
                                    </div>
									
                                   <div class="form-group">
                                        <label for="closedescription" class="col-sm-3 control-label md-font bold black-font">الصورة</label>
                                        <div class="col-sm-9">
                                           <input type="file" name="fileToUpload" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" id="fileToUpload"  >
                                        </div>
										<img src=" <?php printvalue('picpath'); ?>" />
                                    </div>
									
                                    <div class="form-group">
                                        <button class="btn orange-btn" name="submit"><?php if (  getvalue('id')!="")echo "تعديل";else echo"اضف"?></button>
                                    </div>
									 
										<div class="form-group">
											<div id="opportunity-response">
                                                
                                            </div>
										 </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
			   <?php }else{?>
			   <div class="alert alert-info fade in alert-dismissable">
					
					<strong>تعليمات هامة </strong><p> عزيزى العميل لكى تستطيع اضافة فرصة جديدة من فضلك اضف رقم التليفون الى بياناتك 
					للذهاب الى صفحة تعديل الحساب من هنا</p>
					<a class="btn blue-button small-font" title="تعديل الحساب" href="?page=profile_edit">تعديل الحساب</a>
				</div>
			   <?php }?>
		   </div>
        </div>

    </div>
</div>

 <script>
 $( document ).ready(function() {
    //$( "#expiredate" ).datepicker();
	$( "#expiredate" ).datepicker({ dateFormat: 'yy-mm-dd' });
	
});
  
  </script>

