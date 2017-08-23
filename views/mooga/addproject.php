


	 <?php include("wedget/user-header.php");
      global $object;
       $object=isset($project) ? $project : '';
     ?>
		 <div id="breadcrum-inner-block">

		 </div>
		 <div id="vfx-product-inner-item">
      <div class="container">
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <h2 class="full-lines sm-font"><span class="blue-font"><?php if (getvalue('id')!="") {
         echo "تعديل مشروع";
     } else {
         echo"اضف مشروع جديد";
     }?></span></h2>
				<?php if ($user->phone!="") {
         ?>
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border def-padding">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">
                            <div class="col-md-12 col-lg-12 col-xs-10 col-sm-10 center-table">

                                <form class="addproject-form"   id="addproject-form">
								<div id="addproject-response"> </div>
								   <div class="form-group">
                                        <button class="btn orange-btn" name="submit"><?php if (getvalue('id')!="") {
             echo "تعديل";
         } else {
             echo"حفظ";
         } ?></button>
                                    </div>
								<input type="hidden" name="record" value="<?php printvalue('id') ?>">
								<div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <!--label  for="name" class=" control-label md-font bold black-font"><span class="asterisc">*</span>اسم المشروع  </label-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
																						<input class="form-control" required="" id="name" placeholder="* اسم المشروع" type="text" value="<?php printvalue('name'); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 col-lg-6 col-xs-12 col-sm-12 ">
                                        <!--label  for="project_type" class=" control-label md-font bold black-font"><span class="asterisc">*</span>نوع المشروع </label-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" data-placeholder="* اختر نوع عمل المشروع"  id="project_type" name="project_type" required>
											<option value=""></option>
                                                   <?php $helper->getoptions($project_type, "[$object->project_type_list]"); ?>

                                            </select>

                                        </div>
                                    </div>
									 <div class="form-group col-md-6 col-lg-6 col-xs-12 col-sm-12 ">
                                        <!--label for="project_field" class="control-label md-font bold black-font"><span class="asterisc">*</span>مجال عمل المشروع  </label-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" data-placeholder="* اختر مجال عمل المشروع"   id="project_field" name="project_field"  <?php  echo $object->project_field_list; ?>>
												<option value=""></option>
												 <?php $helper->getoptions($project_field, "[$object->project_field_list]"); ?>

                                            </select>

                                        </div>
                                    </div>


									<div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <!--label  for="description" class=" control-label md-font bold black-font"><span class="asterisc">*</span>وصف المشروع </label-->
	                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 ">
	                        <textarea type="text" class="form-control text-area" id="description" name="description" placeholder="* وصف المشروع "><?php printvalue('description'); ?></textarea>
	                    </div>
	                </div>

									<!--<div class="form-group">
                                        <label for="country" class="col-md-3 col-lg-3 col-xs-4 col-sm-4 control-label md-font bold black-font">دولة المشروع <span class="asterisc">*</span></label>
                                        <div class="col-lg-9 col-md-9 col-xs-8 col-sm-8">
                                            <select class="form-control chosen-select" data-placeholder="اختر  دولة المشروع"  id="country" name="country">
											<option value=""></option>
                                                <?php //$helper->getoptions_single( $countries,$project->country);?>

                                            </select>
                                        </div>
                                    </div>-->




									<div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                        <!--label  for="stage" class="control-label md-font bold black-font"><span class="asterisc">*</span>حالة المشروع</label-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" data-placeholder="* اختر مرحلة المشروع الحالية"  id="stage" name="stage">
											<option value=""></option>
                                                   <?php $helper->getoptions($project_stage, "[$object->stage_list]"); ?>
                                            </select>

                                        </div>

                                    </div>


                                            <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                                <!--label for="country" class=" control-label text-center"><span class="asterisc">*</span>الدولة</label-->
                                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

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
                                            </div>



                                            <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                                <!--label for="states" class="control-label text-center">

												<span   class="asterisc">*</span>المحافظة</label-->
                                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

												<select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" id="states" name="states" data-placeholder=" * المحافظة">

													<option value=""></option>

                                                 </select>

                                                </div>
                                            </div>



                                            <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                                <!--label for="cities" class="control-label text-center">

												<span class="asterisc">*</span>المدينة</label -->
                                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

												<select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" id="cities" name="cities" data-placeholder=" * المدينة">

													<option value=""></option>

                                                 </select>

                                                </div>
                                            </div>

	                        <!-- contact information -->

									<?php include("wedget/contact_information.php") ?>
                                 	<!-- contact information -->
									<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <h2 class="full-lines sm-font"><span class="blue-font">احتياجات المشروع</span></h2>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <label for="needpartner" class="col-md-4 col-lg-4 col-xs-4 col-sm-4 control-label md-font bold black-font">احتياج المشروع لـ: <span class="asterisc">*</span> </label>
                                        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
                                            <label class="radio-inline">
                                                <input type="checkbox" id="needpartner" name="needpartner" value="1" placeholder="" <?php $helper->check_value(getvalue('needpartner')); ?>> شريك
                                            </label>
                                            <label class="radio-inline" >
                                                <input type="checkbox" id="needfunder" name="needfunder" value="1" placeholder="" <?php $helper->check_value(getvalue('needfunder')); ?>>   مستثمر
                                            </label>

											<label class="radio-inline">
                                                <input type="checkbox" id="needbuyer" value="1" name="needbuyer" placeholder="" <?php $helper->check_value(getvalue('needbuyer')); ?>> مشتري للمشروع
                                            </label>

                                        </div>
                                     </div>
									<div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12" >
                                        <!--label for="budget" class="control-label md-font bold black-font">المبلغ المطلوب تقريباً<span class="asterisc">*</span></label-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<input type="number" id="budget"  name="budget" placeholder="* المبلغ المطلوب تقريباً " class="form-control" value="<?php printvalue('budget'); ?>">

                                        </div>
                                    </div>

									<div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12" id="needdescription">
                                        <!--label for="needdescription" class="control-label md-font bold black-font">أسباب الاحتياج <span class="asterisc">*</span></label-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <textarea type="text" class="form-control text-area" id="needdescription"  name="needdescription" placeholder=" * أسباب الاحتياج "  ><?php printvalue('needdescription'); ?></textarea>
                                        </div>
                                    </div>

									<div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12" id="closedescriptionsection">
	                    <!--label for="closedescription" class="col-md-3 col-lg-3 col-xs-4 col-sm-4 control-label md-font bold black-font">تفاصيل التصفية <span class="asterisc">*</span> </label-->
	                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
													<textarea type="text" class="form-control text-area" id="closedescription"  name="closedescription" placeholder="* تفاصيل التصفية"  ><?php printvalue('closedescription'); ?></textarea>
	                    </div>
	                </div>

								    <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <label for="closedescription" class="col-md-4 col-lg-4 col-xs-4 col-sm-4 control-label md-font bold black-font">صورة المشروع </label>
                                        <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
                                           <input type="file" name="fileToUpload" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" id="fileToUpload"  >
                                        </div>
                                        <div class="clearfix" style="height: 50px;"></div>
										<img src=" <?php printvalue('picpath'); ?>" />
                                    </div>


                                    <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-12">
																			<div class="form-group col-xs-12">
                                        <button class="btn orange-btn" name="submit"><?php if (getvalue('id')!="") {
             echo "تعديل";
         } else {
             echo"حفظ";
         } ?></button>
                                    </div>

                                </form>

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
			     $( "#contact_section" ).html('<label for="contact_email" class="control-label md-font bold black-font">الإيميل <span class="asterisc">*</span> </label> <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"> <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder=""   value="<?php printvalue('contact_email'); ?>"></div>');
		   }
		  }

		     change_countact_type();
});
</script>
