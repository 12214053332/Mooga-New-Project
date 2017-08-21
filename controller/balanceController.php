<?php

Class balanceController Extends baseController {

public function index() 
{      

      $this->registry->template->page_body = getviewslink().'/mooga/balance';
        $this->registry->template->show('index_home');
}


}
?>
