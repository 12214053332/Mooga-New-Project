	   

 <?php include("wedget/user-header.php") ?>
 <div id="breadcrum-inner-block">
     <div class="container">
         <div class="row">
             <div class="col-sm-12 text-center">
                 <div class="breadcrum-inner-header">
                     <h1>تعديل الحساب</h1>
                     <a href="">الرئيسية</a> <i class="fa fa-circle"></i> <a href="?page=profile_edit"><span>تعديل الحساب</span></a> </div>
             </div>
         </div>
     </div>
 </div>
 <div id="vfx-product-inner-item">
     <div class="container">
         <div class="row">
             <div class="col-md-12 contact-heading-title text-center bt_heading_3">
                 <h1>
                 بروفايل
                 <span><?php echo $user->name; ?></span>
                 </h1>
                 <div class="blind line_1"></div>
                 <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                 <div class="blind line_2"></div>
             </div>



             <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner">
                 <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                     <div class="from-list-lt">
                         <div class="row">
                             <form method="post" action="#" id="edit_profile-form">
                                 <div id="edit_profile-response"> </div>
                                 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding btm-mrg-sm">
                                     <div class="row">
                                         <div class="col-md-5 col-lg-5 col-xs-12 col-sm-12">
                                             <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                                                 <div class="cst-file-upload" onclick=Javascript:$("#fileToUpload").click()><a href="Javascript:void(0);"><img  id="userpic" src="<?php echo $user->profilepic; ?> "  id=""></a></div>
                                                 <input type="file" id="fileToUpload"  name="fileToUpload" style="display: none" >
                                             </div>
                                             <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 def-padding-sm zero-top-padding zero-child-margin">
                                                 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                     <input type="text" id="name" name="name" class="form-control cust-input-width cust-input-width-lg" placeholder="الاسم " value="<?php echo $user->name; ?>">
                                                     <label for="name"></label>
                                                 </div>
                                                 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                     <input type="text" name="job_title" id="job_title" class="form-control cust-input-width cust-input-width-lg" placeholder="المسمى الوظيفى" value="<?php echo $user->job_title; ?>">
                                                 </div>
                                             </div>
                                             <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                 <a class="sm-border-btn round-corner grey-border"><i class="message-box"></i></a>
                                                 <label  class="form-control cust-input-width"   ><?php echo $user->email; ?></label>
                                             </div>
                                             <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                 <a class="sm-border-btn round-corner grey-border"><i class="call-icon"></i></a>
                                                 <input type="text" class="form-control cust-input-width" id="phone" placeholder="الهاتف" name="phone"  value="<?php echo $user->phone; ?>">
                                                 <label for="phone"></label>
                                             </div>
                                         </div>
                                         <div class="col-md-7 col-lg-7 col-xs-12 col-sm-12">
                                             <div class="form-group md-font grey-font country col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                 <label for="" class="control-label">الدولة: </label>
                                                 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                     <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25" name="country" id="country" required>
                                                         <option value="" >اختر الدولة</option>
                                                         <?php

                                                         foreach ($countries as $country) {
                                                             $selected="";
                                                             $id=$country['id'];
                                                             $name=$country['name'];
                                                             if ($name==$user->countryname)
                                                             {
                                                                 $selected="selected";
                                                             }
                                                             echo " <option value='$id' $selected>$name</option> ";
                                                         }
                                                         ?>
                                                     </select>
                                                     <label for="country"></label>
                                                 </div>
                                             </div>
                                             <div class="form-group md-font grey-font country col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                 <label for="" class="control-label">المحافظة: </label>
                                                 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                     <select class="form-control chosen-select" id="states" name="states" >
                                                         <option value="">اختر</option>
                                                     </select>
                                                     <label for="states"></label>
                                                 </div>
                                             </div>
                                             <div class="form-group md-font grey-font country col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                 <label for="" class=" control-label">المدينة: </label>
                                                 <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                     <select class="form-control chosen-select" id="cities" name="cities" >
                                                         <option value="">اختر</option>
                                                     </select>
                                                     <label for="cities"></label>
                                                 </div>

                                             </div>

                                         </div>
                                         <!---->
                                     </div>
                                     <div class="form-group">
                                         <div class="">
                                             <button class="btn orange-btn" name="submit">حفـظ</button>
                                         </div>
                                     </div>
                                 </div>

                             </form>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </div>
 </div>





<script>

$(document).ready(function (e) {
	 window.states111='<?php echo $user->states; ?>';	
	window.cities111='<?php echo $user->cities;  ?>';
// Function to preview image after validation
$(function() {
$("#fileToUpload").change(function() {

var file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{
$('#userpic').attr('src','noimage.png');
//$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});


function imageIsLoaded(e) {
$("#fileToUpload").css("color","green");
$('#image_preview').css("display", "block");
$('#userpic').attr('src', e.target.result);
//$('#userpic').attr('width', '250px');
//$('#userpic').attr('height', '230px');
}
 //$("#country").chosen().change();	
 //changecountry();
 
});

</script>
