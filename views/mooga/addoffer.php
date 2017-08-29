<?php include("wedget/user-header.php");
	  global $object;
      $object=isset($offer) ? $offer : (object)['item_brand'=>''];
	 ?>
<div id="breadcrum-inner-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="breadcrum-inner-header">
                    <h1>اضف عرض جديد</h1>
                    <a href="">الرئيسية</a> <i class="fa fa-circle"></i> <a href="?page=addproject"><span>اضف عرض جديد</span></a> </div>
            </div>
        </div>
    </div>
</div>
<div id="vfx-product-inner-item">
    <div class="container">
        <div class="row">
        <div class="col-md-12 contact-heading-title text-center bt_heading_3">
            <h1><?php if (getvalue('id')!="") {
                    echo "تعديل <span>عرض</span>";
                } else {
                    echo"اضف<span> عرض</span> جديد";
                }?></h1>
            <div class="blind line_1"></div>
            <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
            <div class="blind line_2"></div>
        </div>
        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 ">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 ">
				<?php if ($user->phone!=""){ ?>
                    <div class="from-list-lt">
                        <div class="col-xs-12 col-lg-12 col-sm-12">
                            <form class="form-float form-alt addoffer-form" id="addoffer-form">
                            <div id="addoffer-response"> </div>
                                <div class="row">

                                    <div class="form-group col-xs-12 col-sm-12">
                                        <button class="btn pull-right" type="submit" name="submit"><?php if (  getvalue('id')!="")echo "تعديل";else echo"حفظ"?></button>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12">
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-12">
                                        <label for="offer_type_filed" > حالة البضاعة <span class="asterisc">*</span> </label>
                                        <select class="form-control chosen-select" data-placeholder=" اختر حالة البضاعة"   id="offer_type_filed" name="offer_type_filed"  <?php  echo $object->offer_type_filed; ?>>
                                            <option value=""></option>
                                            <?php $helper->getoptions( $offer_type_filed,'["'.$object->offer_type_filed.'"]'); ?>
                                        </select>
                                    </div>


                                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                                        <hr class="lt-co-green-hr">
                                        <div class="media media-iconic">
                                            <div class="media-body">
                                                <div class="lt-co-blok-text" style="padding-right:0px !important; ">
                                                    <div class="lt-co-title"><h3>بيانات الصنف</h3></div>
                                                    <hr class="lt-co-green-hr">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12">
                                    </div>

                                        <div class="form-group col-xs-12 col-sm-12">
                                            <label for="item_brand"> الصنف <span class="asterisc">*</span> </label>

                                        <select class="form-control chosen-select" data-placeholder=" اختر الصنف"   id="item_brand" name="item_brand"  >
                                            <option value=""></option>
                                            <?php $helper->getoptions_single( $item_brand,$object->item_brand); ?>

                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label   for="description" >الوصف<span class="asterisc">*</span> </label>
                                        <textarea type="text" class="form-control" id="description" name="description" placeholder="الوصف"><?php printvalue('description'); ?></textarea>

                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="min_qty" >اقل كمية <span class="asterisc">*</span> </label>
                                        <input type="number" class="form-control" id="min_qty" name="min_qty" placeholder="اقل كمية"  value="<?php printvalue('min_qty'); ?>">

                                    </div>
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label for="price" >السعر <span class="asterisc">*</span> </label>
                                        <input type="number" class="form-control" id="price" name="price" placeholder="السعر"   value="<?php printvalue('price'); ?>">

                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4"> <label for="country"> الدولة <span class="asterisc">*</span> </label>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4"> <label for="states"> المحافظة <span class="asterisc">*</span> </label>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4"> <label for="cities"> المدينة <span class="asterisc">*</span> </label>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4">

                                        <select class="form-control chosen-select" id="country" name="country" required>

                                            <option value="">اختر</option>
                                            <?php
                                            $selected="";
                                            $ids=getvalue('country');
                                            foreach ($countries as $country) {
                                                $id=$country['id'];
                                                $name=$country['name'];
                                                $code=$country['code'];
                                                if ($ids==$id){$selected='selected';}else{$selected='';}
                                                echo " <option value='$id'  data-code='$code' $selected>$name</option> ";
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="form-group col-xs-12 col-sm-4">


                                        <select class="form-control chosen-select" id="states" name="states" >

                                            <option value="">اختر</option>

                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4">

                                        <select class="form-control chosen-select" id="cities" name="cities" >

                                            <option value="">اختر</option>

                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                                        <hr class="lt-co-green-hr">
                                        <div class="media media-iconic">
                                            <div class="media-body">
                                                <div class="lt-co-blok-text" style="padding-right:0px !important; ">
                                                    <div class="lt-co-title"><h3>بيانات الاتصال</h3></div>
                                                    <hr class="lt-co-green-hr">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-12">
                                        <label for="contact_type"> طريقة التواصل عبر  <span class="asterisc">*</span> </label>
                                        <select class="form-control chosen-select" id="contact_type" name="contact_type" >
                                            <option value="1"  <?php if (getvalue('contact_type') !=2) {echo 'selected';} ?>>عبر الهاتف</option>
                                            <option value="2" <?php if (getvalue('contact_type') ==2) {echo 'selected';} ?>>عبر البريد الإلكترونى</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12">
                                    <div class="form-group col-xs-12 col-sm-4"> <label for="contact_name" > اسم صاحب الهاتف <span class="asterisc">*</span> </label>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4"> <label for="contact_phone"> هاتف الاتصال <span class="asterisc">*</span> </label>
                                    </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4">

                                        <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="اسم صاحب الهاتف"   value="<?php printvalue('contact_name'); ?>">

                                    </div>


                                    <div class="form-group col-xs-12 col-sm-4">
                                        <input type="number" class="form-control" id="contact_phone" maxlength="11"  minlength="9" name="contact_phone" placeholder="هاتف الاتصال"   value="<?php printvalue('contact_phone'); ?>">

                                    </div>

                                    <div class="form-group col-xs-12 col-sm-4">

                                        <select class="form-control chosen-select" id="country_1" name="country_1" required>

                                            <option value="">اختر كود الدولة</option>
                                            <?php
                                            $ids=getvalue('country');
                                            $select="";
                                            foreach ($countries as $country) {
                                                $id=$country['id'];
                                                $name=$country['name'];
                                                $code=$country['code'];
                                                if ($ids==$id){ $select="selected";}else{$select="";}
                                                echo " <option value='$id'  data-code='$code' $select>$code - $name</option> ";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class=" col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <label for="closedescription" class="col-md-3 col-lg-3 col-xs-4 col-sm-4 control-label md-font bold black-font">صورة عرض الجملة </label>
                                        <div class="col-lg-9 col-md-9 col-xs-8 col-sm-8">
                                            <input type="file" name="fileToUpload" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*" id="fileToUpload"  >
                                        </div>
                                        <div class="clearfix" style="height: 50px;"></div>
                                        <img src=" <?php printvalue('picpath'); ?>" />
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <button class="btn pull-right" type="submit"><?php if (  getvalue('id')!="")echo "تعديل";else echo"حفظ"?></button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>

            <?php }else{?>
			   <div class="alert alert-info fade in alert-dismissable">
					
					<strong>تعليمات هامة </strong><p> عزيزى العميل لكى تستطيع اضافة مشروع جديد من فضلك اضف رقم التليفون الى بياناتك 
					للذهاب الى صفحة تعديل الحساب من هنا</p>
					<a class="btn blue-button small-font" title="تعديل الحساب" href="?page=profile_edit">تعديل الحساب</a>
				</div>
			   <?php }?>
			</div>
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
			 
			  window.states111='<?php  printvalue( 'states'); ?>';
			
			  window.cities111='<?php  printvalue( 'cities'); ?>';
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
