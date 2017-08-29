


	 <?php include("wedget/user-header.php");
      global $object;
       $object=isset($project) ? $project : '';
     ?>
		 <div id="breadcrum-inner-block">
		   <div class="container">
		     <div class="row">
		       <div class="col-sm-12 text-center">
		         <div class="breadcrum-inner-header">
		           <h1>اضف مشروع جديد</h1>
		           <a href="">الرئيسية</a> <i class="fa fa-circle"></i> <a href="?page=addproject"><span>اضف مشروع جديد</span></a> </div>
		       </div>
		     </div>
		   </div>
		 </div>
		 <div id="vfx-product-inner-item">
      <div class="container">
    <div class="row">
        <div class="col-md-12 contact-heading-title text-center bt_heading_3">
            <h1><?php if (getvalue('id')!="") {
                    echo "تعديل <span>مشروع</span>";
                } else {
                    echo"اضف<span> مشروع</span> جديد";
                }?></h1>
            <div class="blind line_1"></div>
            <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
            <div class="blind line_2"></div>
        </div>

        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
				<?php if ($user->phone!="") {

         ?>
                <div class="from-list-lt">
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border def-padding">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">
                            <div class="col-md-12 col-lg-12 col-xs-10 col-sm-10 center-table">
                                <div class="from-list-lt">
                                    <form class="addproject-form"   id="addproject-form">
                                        <div id="addproject-response"> </div>
                                        <input type="hidden" name="record" value="<?php printvalue('id') ?>">
                                        <div class="form-group">
                                            <label class=" control-label md-font bold black-font">اسم المشروع <span class="asterisc">*</span> </label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder=""   value="  <?php printvalue('name'); ?>">
                                            <label for="name"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label md-font bold black-font">نوع المشروع</label>
                                            <label for="project_type"></label>
                                            <select class="form-control chosen-select" data-placeholder="اختر نوع عمل المشروع"  id="project_type" name="project_type" required>
                                                <option value=""></option>
                                                <?php $helper->getoptions( $project_type,"[$object->project_type_list]"); ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_field" class=" control-label md-font bold black-font">مجال عمل المشروع</label>
                                            <select class="form-control chosen-select" data-placeholder="اختر مجال عمل المشروع"   id="project_field" name="project_field"  <?php  echo $object->project_field_list; ?>>
                                                <option value=""></option>
                                                <?php $helper->getoptions( $project_field,"[$object->project_field_list]"); ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label  class=" control-label md-font bold black-font">وصف المشروع  <span class="asterisc">*</span> </label>
                                            <textarea type="text" class="form-control" id="description" name="description" placeholder="">  <?php printvalue('description'); ?></textarea>
                                            <label for="description"></label>
                                        </div>

                                        <div class="form-group">
                                            <label for="country" class="control-label md-font bold black-font">دولة المشروع</label>
                                            <select class="form-control chosen-select" data-placeholder="اختر  دولة المشروع"  id="country" name="country">
                                                <option value=""></option>
                                                <?php $helper->getoptions_single( $countries,$project->country); ?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="stage" class="control-label md-font bold black-font">المرحلة الحالية</label>
                                            <select class="form-control chosen-select" data-placeholder="اختر مرحلة المشروع الحالية"  id="stage" name="stage">
                                                <option value=""></option>
                                                <?php $helper->getoptions( $project_stage,"[$object->stage_list]"); ?>
                                            </select>
                                        </div>

                                        <h2 class="full-lines sm-font"><span class="blue-font">احتياجات المشروع</span></h2>

                                        <!--<div class="form-group">
                                            <label for="project_product" class="control-label md-font bold black-font">قائمة المنتجات التي يحتاجها المشروع</label>
                                            <select class="form-control chosen-select" multiple data-placeholder="اختر قائمة المنتجات التي يحتاجها المشروع"  name="project_product"id="project_product">
                                                <?php /*$helper->getoptions( $products,$object->project_product_list); */?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="project_service" class="control-label md-font bold black-font">قائمة الخدمات التي يحتاجها المشروع</label>
                                            <select class="form-control chosen-select" multiple  data-placeholder="اختر قائمة الخدمات التي يحتاجها المشروع  " name="project_service"id="project_service">
                                                <?php /*$helper->getoptions( $services,$object->project_service_list); */?>
                                            </select>
                                        </div>-->

                                        <div class="form-group">
                                            <label for="needpartner" class="control-label md-font bold black-font">احتياج المشروع لـ: </label>
                                            <label class="radio-inline">
                                                <input type="checkbox" id="needpartner" name="needpartner" value="1" placeholder="" <?php $helper->check_value(getvalue('needpartner')); ?>> شريك
                                            </label>
                                            <label class="radio-inline" >
                                                <input type="checkbox" id="needfunder" name="needfunder" value="1" placeholder="" <?php $helper->check_value(getvalue('needfunder')); ?>>   ممول
                                            </label>
                                            <label class="radio-inline">
                                                <input type="checkbox" id="needdealer" name="needdealer" value="1" placeholder="" <?php $helper->check_value(getvalue('needdealer')); ?>>  موزع
                                            </label>
                                            <label class="radio-inline">
                                                <input type="checkbox" id="needagent" value="1" name="needagent" placeholder="" <?php $helper->check_value(getvalue('needagent')); ?>>  وكيل
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="needclose" class="control-label md-font bold black-font"> المشروع في مرحلة :  </label>
                                            <label class="radio-inline">
                                                <input type="checkbox"  id="needclose" name="needclose" value="1" placeholder="" <?php $helper->check_value(getvalue('needclose')); ?>>  تصفية
                                            </label>
                                        </div>

                                        <div class="form-group" id="closedescriptionsection">
                                            <label for="closedescription" class="control-label md-font bold black-font">تفاصيل التصفية </label>

                                                <textarea type="text" class="form-control" id="closedescription"  name="closedescription" placeholder=""  > <?php printvalue('closedescription'); ?></textarea>

                                        </div>

                                        <div class="form-group">
                                            <label for="closedescription" class="control-label md-font bold black-font">صورة المشروع</label>
                                            <input type="file" name="fileToUpload" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" id="fileToUpload"  >
                                            <img src=" <?php printvalue('picpath'); ?>" />
                                        </div>


                                        <div class="form-group">
                                            <button class="btn orange-btn" name="submit"><?php if (  getvalue('id')!="")echo "تعديل";else echo"اضف"?></button>
                                        </div>

                                    </form>
                                </div>
						 </div>
                        </div>
                    </div>
                </div>
            <?php

     } else {
         ?>
			   <div class="alert alert-info fade in alert-dismissable">

					<strong>تعليمات هامة </strong><p> عزيزى العميل لكى تستطيع اضافة مشروع جديد من فضلك اضف رقم التليفون الى بياناتك
					للذهاب الى صفحة تعديل الحساب من هنا</p>
                   <a class="btn blue-button small-font" title="تعديل الحساب" href="?page=profile_edit">تعديل الحساب</a>
				</div>
			   <?php

     }?>
			</div>
        </div>

    </div>
	</div>
</div>
</div>

<script>


$().ready(function() {

 window.states111='<?php printvalue('states'); ?>';

			  window.cities111='<?php printvalue('cities'); ?>';

   if( $('#needclose').is(':checked')) {
        $("#closedescriptionsection").show();
    } else {
        $("#closedescriptionsection").hide();
    }
$('#needclose').click(function() {
    if( $(this).is(':checked')) {
        $("#closedescriptionsection").show();
    } else {
        $("#closedescriptionsection").hide();
    }
});


    		 $( "#contact_type" ).change(function() {
           // $('#key').val( $('#country').find(':selected').data('code') );
		   change_countact_type();
		   //alert($( "#contact_type" ).val());
          });

		  function change_countact_type(){
			  var typevalue=$( "#contact_type" ).val();
		   if (typevalue==1){
			  $( "#contact_section" ).html('<?php include("wedget/contact_phone.php"); ?>');
		   }else if (typevalue==2)
		   {
			     $( "#contact_section" ).html('<!--label for="contact_email" class="control-label md-font bold black-font">الإيميل <span class="asterisc">*</span> </label--> <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"> <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="الاميل"   value="<?php printvalue('contact_email'); ?>"></div>');
		   }
		  }

		     change_countact_type();
});
</script>
