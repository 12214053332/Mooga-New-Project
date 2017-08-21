<!DOCTYPE html>

<?php
 if  (isset ($page_head)===FALSE) {$page_head='head' ;}
  if  (isset ($page_body)===FALSE) {$page_body='home';}
  if  (isset ($page_footer)===FALSE) {$page_footer='footer';}   
 ?>
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/html">

    <head>

     <?php include ($page_head.'.php');
include 'views/traking/googleanalytic.php';
 ?>
        <script src="https://www.gstatic.com/firebasejs/3.6.9/firebase.js"></script>
        <script src="assets/js/app.js"></script>
	   	
     
    </head>

 <body >
  <header>
 <?php

 include ('menuheader.php'); ?>
 
 </header>  
     <?php include ($page_body.'.php'); ?>
      <?php include ('sign.php'); ?>
    <?php include ($page_footer.'.php'); ?>
  </body>

</html>