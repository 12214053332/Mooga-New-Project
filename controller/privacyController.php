<?php

Class privacyController Extends baseController {

public function index() 
{      

      $this->registry->template->page_body = getviewslink().'/mooga/privacy';
        $this->registry->template->show('index_home');
}


}
?>
