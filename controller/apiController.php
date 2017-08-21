<?php

Class apiController Extends baseController {

public function index() 
{         


 }



public function sendemail() 
{  
       
$verifiecode=post('verifiecode');
$templatename=post('templatename');
               $parameters=array(
                   'template' => $templatename,
                   'verifiecode' => $verifiecode,
               );
			   $email=post('email');
                  //echo  $email;
                $this->registry->emails->sendemail($email,$parameters);
}


public function sendsms() 
{         
		
}



}

?>
