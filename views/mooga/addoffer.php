


	 <?php include("wedget/user-header.php");
      global $object;
       $object=isset($offer) ? $offer : (object)['item_brand'=>''];
     ?>
      <div class="container">
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <h2 class="full-lines sm-font"><span class="blue-font"><?php if (getvalue('id')!="") {
         echo "تعديل عرض";
     } else {
         echo"اضف عرض جديد";
     }?></span></h2>
				<?php if ($user->phone!="") {
         ?>
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border def-padding">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">
                            <div class="col-md-10 col-lg-10 col-xs-10 col-sm-10 center-table">
                                <form class="addoffer-form"   id="addoffer-form">
								<div id="addoffer-response"> </div>

                                    <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                        <button class="btn orange-btn" name="submit"><?php if (getvalue('id')!="") {
             echo "تعديل";
         } else {
             echo"حفظ";
         } ?></button>
                                    </div>
								<input type="hidden" name="record" value="<?php printvalue('id') ?>">
									 <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <label for="offer_type_filed" class="control-label md-font bold black-font">حالة البضاعة <span class="asterisc">*</span></label>
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <select class="form-control chosen-select" data-placeholder="اختر حالة البضاعة"   id="offer_type_filed" name="offer_type_filed"  <?php  echo $object->offer_type_filed; ?>>
												<option value=""></option>
												 <?php $helper->getoptions($offer_type_filed, '["'.$object->offer_type_filed.'"]'); ?>

                                            </select>
                                        </div>
                                    </div>
									<div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12">
									 <h2 class="full-lines sm-font"><span class="blue-font">بيانات الصنف</span></h2>
									</div>
									<div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                        <label for="item_brand" class=" control-label md-font bold black-font">الصنف <span class="asterisc">*</span> </label>
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
										 <select class="form-control chosen-select" data-placeholder="اختر "   id="item_brand" name="item_brand" style="width: 94%" >
												<option value=""></option>
												 <?php $helper->getoptions_single($item_brand, $object->item_brand); ?>

                                            </select>


                                        </div>
                                    </div>

									<div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12 <?php if (!(isset($_GET['action'])&&$_GET['action']=='edit')) {
             ?>hidden<?php

         } ?>">
                                        <label  for="item_type" class="control-label md-font bold black-font"><span class="asterisc">*</span> </label>
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
										 <select class="form-control chosen-select" data-placeholder="اختر  "   id="item_type" name="item_type" >
												<option value=""></option>
												 <?php //$helper->getoptions_single( $item_type,$object->item_type);?>

                                            </select>


                                        </div>
                                    </div>

								<div class="form-group col-md-4 col-lg-4 col-xs-12 col-sm-12 <?php if (!(isset($_GET['action'])&&$_GET['action']=='edit')) {
             ?>hidden<?php

         } ?>">
                                        <label for="name" class="control-label md-font bold black-font"><span class="asterisc">*</span> </label>
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<select class="form-control chosen-select" data-placeholder="اختر "   id="name" name="name" >
												<option value=""></option>


                                            </select>


                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
									<div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <label   for="description" class=" control-label md-font bold black-font">الوصف<span class="asterisc">*</span> </label>
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <textarea type="text" class="form-control" id="description" name="description" placeholder=""><?php printvalue('description'); ?></textarea>

                                        </div>
                                    </div>
									<div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                        <label for="min_qty" class="control-label md-font bold black-font">اقل كمية <span class="asterisc">*</span> </label>
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <input type="number" class="form-control" id="min_qty" name="min_qty" placeholder=""  value="<?php printvalue('min_qty'); ?>">

                                        </div>
                                    </div>

							        <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                        <label for="price" class=" control-label md-font bold black-font">السعر <span class="asterisc">*</span> </label>
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <input type="number" class="form-control" id="price" name="price" placeholder=""   value="<?php printvalue('price'); ?>">

                                        </div>
                                    </div>


                                            <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                                <label for="country" class=" control-label text-center">الدولة<span class="asterisc">*</span></label>
                                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

												<select class="form-control chosen-select" id="country" name="country" required>

													<option value="">اختر</option>
													  <?php
                                                     $selected="";
         $ids=getvalue('country');
         foreach ($countries as $country) {
             $id=$country['id'];
             $name=$country['name'];
             $code=$country['code'];
             if ($ids==$id) {
                 $selected='selected';
             } else {
                 $selected='';
             }
             echo " <option value='$id'  data-code='$code' $selected>$name</option> ";
         } ?>
                                                 </select>

                                                </div>
                                            </div>



                                            <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                                <label for="states" class="control-label text-center">

												المحافظة<span class="asterisc">*</span></label>
                                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

												<select class="form-control chosen-select" id="states" name="states" >

													<option value="">اختر</option>

                                                 </select>

                                                </div>
                                            </div>



                                            <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                                <label for="cities"  class="control-label text-center">

											المدينة	<span class="asterisc">*</span></label>
                                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

												<select class="form-control chosen-select" id="cities" name="cities" >

													<option value="">اختر</option>

                                                 </select>

                                                </div>
                                            </div>

									<!-- contact information -->

									<?php include("wedget/contact_information.php") ?>
                                 	<!-- contact information -->
								    <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <label for="closedescription" class="col-md-3 col-lg-3 col-xs-4 col-sm-4 control-label md-font bold black-font">صورة عرض الجملة </label>
                                        <div class="col-lg-9 col-md-9 col-xs-8 col-sm-8">
                                           <input type="file" name="fileToUpload" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" id="fileToUpload"  >
                                        </div>
										<div class="clearfix" style="height: 50px;"></div>
										<img src=" <?php printvalue('picpath'); ?>" />
                                    </div>


                                    <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-12">
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

<script>
$().ready(function() {

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
});
</script>

<script type="text/javascript">


		 $( document ).ready(function() {

			 var item_brand='<?php printvalue('item_brand'); ?>';
			 var item_type111;
			 window.item_type111='<?php  printvalue('item_type'); ?>';

			  window.states111='<?php  printvalue('states'); ?>';

			  window.cities111='<?php  printvalue('cities'); ?>';
			 var name111;
			  window.name111='<?php  printvalue('name'); ?>';

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
