<?php

Class vediosController Extends baseController {

public function index() 
{      
            
             $this->registry->template->page_body = getviewslink().'/mooga/underconstraction';
			  
			  // echo $message;
             $this->registry->template->show('index_home');
}


}
?>
