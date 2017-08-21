<?php

Class thanksController Extends baseController {

public function index() 
{      
            
             $this->registry->template->page_body = getviewslink().'/mooga/thanks';
			  $message= $this->registry->sessionhandler->get('message');//post($key);
			   $this->registry->template->message =  $message;
			  // echo $message;
             $this->registry->template->show('index_home');
}


}
?>
