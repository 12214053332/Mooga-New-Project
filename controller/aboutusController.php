<?php

Class aboutusController Extends baseController {

public function index() 
{      

      $this->registry->template->page_body = getviewslink().'/mooga/aboutus';
        $this->registry->template->show('index_home');
}


}
?>
