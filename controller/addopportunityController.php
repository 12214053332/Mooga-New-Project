<?php

Class addopportunityController Extends baseController {

public function index() 

{ 

 $this->checkuser();
 $this->registry->template->opportunity="";
        $this->registry->template->page_body = getviewslink().'/mooga/addopportunity';
        $this->registry->template->show('index_home');
}

public function edit() 
{       
 $this->checkuser();  
        $record=$this->registry->encryption->decode(get('record'));
		if ($record<=0) {self::index();exit();}
		$user_id=$this->getuserid();
		
		
		$this->registry->template->opportunity=$this->registry->users->getsingleopportunities($record,$user_id);
        
		$this->registry->template->page_body = getviewslink().'/mooga/addopportunity';
		
        $this->registry->template->show('index_home');
}

}

?>
