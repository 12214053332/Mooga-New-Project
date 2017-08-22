  <?php 
  $title="Mooga | ";
  if ($currentpage=="users")
	  $title=$title."مجتمع موجة";
    elseif ($currentpage=="projects")
	  $title=$title."المشروعات";
	elseif ($currentpage=="closeprojects")
	  $title=$title."تصفيات المشروعات";
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
	  $title=$title."تعديل الصفحه الشخصيه";
  elseif ($currentpage=="addoffer")
	  $title=$title."اضافه عرض";
	      elseif ($currentpage=="profile")
	  $title=$title."الصفحه الشخصيه";
	  	      elseif ($currentpage=="singleproject")
	  $title=$title.$project->name;
  elseif ($currentpage=="singleoffer")
	  $title=$title.$offer->item_brand_name;
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
  elseif ($currentpage=="whyus")
	  $title=$title."لماذا موجة";
  elseif ($currentpage=="investment")
	  $title=$title."إستثمار ";
  elseif ($currentpage=="offers")
	  $title=$title."عروض الجملة ";
	  	  	      elseif ($currentpage=="index"||$currentpage=="")
	  $title=$title."الرئيسية";

	   elseif ($currentpage=="changepassword")
	  $title=$title."تغيير كلمة المرور";
    elseif ($currentpage=="forgetpassword")
	  $title=$title."أعدادات تغير كلمة المرور";
	  
	  
	  
  ?>  
  
  

<meta name="author" content="">
<meta name="description" content="">
<meta charset="utf-8" dir="rtl">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="<?=$helper->generateCSF()?>" id="_token">
<title><?php echo $title; ?></title>
	 
	 
	 
	<?php if (isset($facebook)) {
	$facebookimage=$facebook->image;
	
	 echo '<meta property="og:image" content="'.$facebookimage.'"/>';
	 if (isset($facebook->description)){
		 $facebookdescription=$facebook->description;
	     echo '<meta property="og:description" content="'.$facebookdescription.'"/>';
	 }
	
     //	twitter 
	 	echo '<meta name="twitter:card" content="summary_large_image">';
		echo '<meta name="twitter:site" content="@mooga.com">';
	    echo '<meta name="twitter:creator" content="@mooga.com">'; 
		echo '<meta name="twitter:title" content="'. $title.'">';
		if (isset($facebook->description)){
		 $twitterdescription=$facebook->description;
	       echo '<meta name="twitter:description" content="'.$twitterdescription.'">';
		}
		echo '<meta name="twitter:image" content="http://mooga.com/'.$facebookimage.'">';
	 	}?>
	
	
		
		
		
		
<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

<!-- Style Sheets -->
<link rel="stylesheet" href="assets/css/bootstrap-rtl.css" type="text/css">
<link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css">

<link rel="stylesheet" href="assets/css/animate.css" type="text/css">
<link rel="stylesheet" href="assets/css/stylesheet.css" type="text/css">
<link rel="stylesheet" href="assets/css/responsive_style.css" type="text/css">

<!-- Google Fonts-->
<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800%7CMontserrat:400,700' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900" rel="stylesheet">  


    <title><?php echo $title; ?></title>
    <meta charset="utf-8" dir="rtl">
    <meta content="<?//=$helper->generateCSF()?>" id="_token">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	 <meta name="msvalidate.01" content="254DBC05E79A35ACA5EDDF70F092D00D" />
	 
		


   <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css?ver=3.1">-->
	<link rel="stylesheet" href="assets/js/chosen.css?ver=1">
	<!--<link rel="stylesheet" href="assets/css/box.css">
	 <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
	.chosen-single span{width: 160px;}
    </style>
 
	   <link rel="stylesheet" href="assets/css/custom.css?ver=1">

  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

-->

  
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