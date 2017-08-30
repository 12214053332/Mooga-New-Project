


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
				<?php if ($user->phone!="") {

         ?>
                <div class="from-list-lt">
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border def-padding">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">
                            <div class="col-md-12 col-lg-12 col-xs-10 col-sm-10 center-table">
                                <div class="from-list-lt">
                                    <form class="addproject-form"   id="addproject-form">
                                        <div class="form-group col-xs-12 col-sm-12">
                                            <button class="btn pull-right" type="submit" name="submit">حفظ</button>
                                        </div>
                                        <div id="addproject-response"> </div>
                                        <input type="hidden" name="record" value="<?php printvalue('id') ?>">
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label class=" control-label md-font bold black-font">اسم المشروع <span class="asterisc">*</span> </label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder=""   value="  <?php printvalue('name'); ?>">
                                            <label for="name"></label>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label class="control-label md-font bold black-font">نوع المشروع<span class="asterisc">*</span></label>
                                            <label for="project_type"></label>
                                            <select class="form-control chosen-select" data-placeholder="اختر نوع عمل المشروع"  id="project_type" name="project_type" required>
                                                <option value=""></option>
                                                <?php $helper->getoptions( $project_type,"[$object->project_type_list]"); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                            <label for="project_field" class=" control-label md-font bold black-font">مجال عمل المشروع<span class="asterisc">*</span></label>
                                            <select class="form-control chosen-select" data-placeholder="اختر مجال عمل المشروع"   id="project_field" name="project_field"  <?php  echo $object->project_field_list; ?>>
                                                <option value=""></option>
                                                <?php $helper->getoptions( $project_field,"[$object->project_field_list]"); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label  class=" control-label md-font bold black-font">وصف المشروع  <span class="asterisc">*</span> </label>
                                            <textarea type="text" class="form-control" id="description" name="description" placeholder="">  <?php printvalue('description'); ?></textarea>
                                            <label for="description"></label>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12 pull-right">
                                            <label  class=" control-label md-font bold black-font">حالة المشروع<span class="asterisc">*</span> </label><label for="stage"></label>
                                            <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" data-placeholder="* اختر مرحلة المشروع الحالية"  id="stage" name="stage">
                                                <option value=""></option>
                                                <?php $helper->getoptions($project_stage, "[$object->stage_list]"); ?>
                                            </select>

                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12 pull-right">
                                            <label  class=" control-label md-font bold black-font">الدولة <span class="asterisc">*</span> </label><label for="country"></label>
                                            <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" id="country" name="country" required data-placeholder=" * الدولة">
                                                <option value=""></option>
                                                <?php
                                                $ids=getvalue('country');
                                                $select="";
                                                foreach ($countries as $country) {
                                                    $id=$country['id'];
                                                    $name=$country['name'];
                                                    $code=$country['code'];
                                                    if ($ids==$id) {
                                                        $select="selected";
                                                    } else {
                                                        $select="";
                                                    }
                                                    echo " <option value='$id'  data-code='$code' $select>$name</option> ";
                                                } ?>
                                            </select>

                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-xs-12 pull-right">
                                            <label  class=" control-label md-font bold black-font">المحافظة<span class="asterisc">*</span> </label><label for="states"></label>
                                            <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" id="states" name="states" data-placeholder=" * المحافظة">
                                                <option value=""></option>
                                            </select>

                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-xs-12 pull-right">
                                            <label  class=" control-label md-font bold black-font">المدينة<span class="asterisc">*</span> </label><label for="cities"></label>
                                            <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" id="cities" name="cities" data-placeholder=" * المدينة">
                                                <option value=""></option>
                                            </select>

                                        </div>


                                        <?php include("wedget/contact_information.php") ?>





                                        <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 block-header text-center">
                                            <div class="col-md-12 contact-heading-title bt_heading_3">
                                                <h1>احتياجات  <span>المشروع</span></h1>
                                                <div class="blind line_1"></div>
                                                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                                                <div class="blind line_2"></div>
                                            </div>
                                        </div>



                                        <div class="clearfix"></div>

                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label for="needpartner" class="control-label md-font bold black-font">احتياج المشروع لـ: </label>
                                            <label class="radio-inline">
                                                <input type="checkbox" id="needpartner" name="needpartner" value="1" placeholder="" <?php $helper->check_value(getvalue('needpartner')); ?>> شريك
                                            </label>
                                            <label class="radio-inline" >
                                                <input type="checkbox" id="needfunder" name="needfunder" value="1" placeholder="" <?php $helper->check_value(getvalue('needfunder')); ?>>   مستثمر
                                            </label>
                                            <label class="radio-inline">
                                                <input type="checkbox" id="needbuyer" name="needbuyer" value="1" placeholder="" <?php $helper->check_value(getvalue('needbuyer')); ?>>   مشتري للمشروع
                                            </label>
                                        </div>


                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label  class=" control-label md-font bold black-font">المبلغ المطلوب تقريباً<span class="asterisc">*</span> </label>
                                            <input type="number" id="budget" name="budget" placeholder="" class="form-control error" value="" aria-required="true">
                                            <label for="budget"></label>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                            <label  class=" control-label md-font bold black-font">أسباب الاحتياج <span class="asterisc">*</span> </label>
                                            <textarea type="text" class="form-control" id="needdescription" name="needdescription" placeholder=""></textarea>
                                            <label for="needdescription"></label>
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
