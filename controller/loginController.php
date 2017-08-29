<?php

Class loginController Extends baseController {

    public function index() {
			$this->registry->template->countries=$this->registry->helper->getcountries();
			$this->registry->template->rememberme=$this->registry->users->getrememberme();
			$this->registry->sessionhandler->put( "HTTP_REFERER",$HTTP_REFERER=(isset($_SERVER['HTTP_REFERER']))?$_SERVER['
			']:'?page=index');
			
	    $this->registry->template->page_body = getviewslink().'/mooga/login';
        $this->registry->template->show('index_home');
	}

      
    

}

?>
