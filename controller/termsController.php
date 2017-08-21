<?php

Class termsController Extends baseController {

public function index() 
{      

      $this->registry->template->page_body = getviewslink().'/mooga/terms';
        $this->registry->template->show('index_home');
}


}
?>
