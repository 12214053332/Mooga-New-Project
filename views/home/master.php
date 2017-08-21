<!DOCTYPE html>

<?php
 if  (isset ($page_head)===FALSE) {$page_head='head' ;}
  if  (isset ($page_body)===FALSE) {$page_body='home';}
  if  (isset ($page_footer)===FALSE) {$page_footer='footer';}   
 ?>
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/html">

    <head>

     <?php include ($page_head.'.php'); ?>
	   	
     
    </head>

 <body >
<header></header>  
     <?php 
     include 'views/traking/googleanalytic.php';
     include ($page_body.'.php'); ?>
    <?php include ($page_footer.'.php'); ?>
  </body>

</html>