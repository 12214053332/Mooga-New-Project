<?php

Class signupController Extends baseController {

    public function index() {
		
		$this->registry->template->countries=$this->registry->helper->getcountries();
	    $this->registry->template->page_body = getviewslink().'/mooga/register';
        $this->registry->template->show('index_home');
	}

      
    

}

?>
