<?php

Class addproductController Extends baseController {

public function index() 
{         
 $this->checkuser();
         $this->checkuser();
        $this->registry->template->page_body = getviewslink().'/mooga/addproduct';
        $this->registry->template->show('index_home');
}

public function edit() 
{         

 $this->checkuser();
        $record=$this->registry->encryption->decode(get('record'));
		if ($record<=0) {self::index();exit();}
		$user_id=$this->getuserid();
		
		
		$this->registry->template->product=$this->registry->users->getsingleproduct($record,$user_id);
        
        $this->registry->template->page_body = getviewslink().'/mooga/addproduct';
        $this->registry->template->show('index_home');
}


}

?>
