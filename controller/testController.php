<?php

Class testController Extends baseController {

public function index() 
{      
            
             $this->registry->users->sendsms("1112");
			  
}


}
?>
