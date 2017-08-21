<?php

Class whyusController Extends baseController {

public function index() 
{      
            
             $this->registry->template->page_body = getviewslink().'/mooga/whyus';
			  
			  // echo $message;
             $this->registry->template->show('index_home');
}


}
?>
