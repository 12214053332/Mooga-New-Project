  <?php 
  $title="Mooga | ";
  if ($currentpage=="users")
	  $title=$title."مجتمع موجة";
    elseif ($currentpage=="projects")
	  $title=$title."المشاريع";
	elseif ($currentpage=="closeprojects")
	  $title=$title."تصفيات المشاريع";
	      elseif ($currentpage=="opportunities")
	  $title=$title."عروض وفرص";
	      elseif ($currentpage=="articles")
	  $title=$title."المقالات";
	      elseif ($currentpage=="balance")
	  $title=$title."الرصيد";
	      elseif ($currentpage=="myopportunities")
	  $title=$title."فرصى";
	      elseif ($currentpage=="myprojects")
	  $title=$title."مشروعاتى";
	  	      elseif ($currentpage=="addproject")
	  $title=$title."أضافة مشروع";
	  	  	      elseif ($currentpage=="addopportunity")
	  $title=$title."أضافة فرصة";
	  	  	  	      elseif ($currentpage=="addproduct")
	  $title=$title."أضافة منتج";
	      elseif ($currentpage=="inbox"||$currentpage=="sent"||$currentpage=="newmessage")
	  $title=$title."الرسائل";
	      elseif ($currentpage=="profile_edit")
	  $title=$title."تعديل الروفايل";
	      elseif ($currentpage=="profile")
	  $title=$title."البروفايل";
	  	      elseif ($currentpage=="singleproject")
	  $title=$title.$project->name;
	  	      elseif ($currentpage=="singleopportunity")
	  $title=$title.$opportunity->name;
	  	      elseif ($currentpage=="singlearticle")
	  $title=$title.$article_data->name;
	  	      elseif ($currentpage=="contactus")
	  $title=$title."أتصل بنا";
	  	      elseif ($currentpage=="aboutus")
	  $title=$title."من نحن";
	  	      elseif ($currentpage=="privacy")
	  $title=$title."سياسة الخصوصية";
	  	      elseif ($currentpage=="login")
	  $title=$title."تسجيل الدخول";
	  	  	      elseif ($currentpage=="signup")
	  $title=$title."مستخدم جديد";
	  	  	      elseif ($currentpage=="index"||$currentpage=="")
	  $title=$title."الرئيسية";

	  	  	  	      elseif ($currentpage=="changepassword")
	  $title=$title."تغيير كلمة المرور";
	  
	  
	  
	  
  ?>  
  
    <title><?php echo $title; ?></title>
    <meta charset="utf-8" dir="rtl">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php if (isset($facebook)) {?>
	<!-- facebook metadata-->
	<meta property="og:image" content="<?php echo $facebook->image ?>"/>
	<!-- facebook metadata-->
	<?php  } ?>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/js/chosen.css">
	<link rel="stylesheet" href="assets/css/box.css">
	 <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
	
    </style>
 
	   <link rel="stylesheet" href="assets/css/custom.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="assets/js/jquery.js"></script>
		<script src="assets/js/action/actions.js"></script>
	<script src="assets/js/action/refer.js"></script>
	
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/validate/jquery.js"></script>
    <script src="assets/js/validate/jquery.validate.min.js"></script>
	<script src="assets/js/validate.js"></script>
	<script src="assets/js/function.js"></script>
	

	
	  <script src="assets/js/chosen.jquery.js" type="text/javascript"></script>
	  
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
          	<?php 
 function printvalue($key)
 {
	 global $object;
	 if (isset($object->$key))
	 {
		 
		 echo  $object->$key;
	 }
	 else{
		 
		 echo  "";
	 }
 }
 
  function getvalue($key)
 {
	 global $object;
	 if (isset($object->$key))
	 {
		 
		 return  $object->$key;
	 }
	 else{
		 
		 return  "";
	 }
 }

 ?>