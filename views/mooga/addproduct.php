

 

        	
 <?php include("wedget/user-header.php");
global $object;
 $object=isset($product) ? $product : '';
 ?>
 
  
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
              
				<h2 class="full-lines sm-font"><span class="blue-font"><?php if (getvalue('id')!="")echo "تعديل منتج ";else echo"اضف منتج جديد"?> </span></h2>
                <?php if ($user->phone!=""){ ?>  
			   <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border def-padding">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">
                            <div class="col-md-10 col-lg-10 col-xs-10 col-sm-10 center-table">
                                <form class="addproduct-form" id="addproduct-form" >
								<input type="hidden" name="product_id" value="<?php printvalue('id') ?>">
                                    <div class="form-group">
                                        <label  class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>اسم المنتج</label>
                                        <div class="col-sm-9">
                                             <input type="text" class="form-control" id="name" name="name" value="<?php printvalue('name') ?>" placeholder="">
											 <label for="name"></label>
                                        </div>
                                    </div>
									
                                    <div class="form-group">
                                        <label  class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>تفاصيل المنتج</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" id="description"  name="description" placeholder=""> <?php printvalue('description') ?></textarea>
												 <label for="description"></label>
                                        </div>
                                    </div>
									
								   <div class="form-group">
                                        <label  class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>صورة المنتج</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="fileToUpload" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" id="fileToUpload"  >
											 	<img src=" <?php printvalue('picpath'); ?>" />
                                        </div>
                                    </div>
                                   
									 
                                   
                                    <div class="form-group">
                                        <button class="btn orange-btn" name="submit"><?php if (  getvalue('id')!="")echo "تعديل";else echo"اضف"?></button>
                                    </div>
									    <div id="addproduct-response">
                                        
                                       </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
			<?php }else{?>
			   <div class="alert alert-info fade in alert-dismissable">
					
					<strong>تعليمات هامة </strong><p> عزيزى العميل لكى تستطيع اضافة منتج جديد من فضلك اضف رقم التليفون الى بياناتك 
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
    $( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
   
  /* $( function() {
    $( "#end_date" ).datepicker();
  } ); */
  </script>
  
  
  </script>

