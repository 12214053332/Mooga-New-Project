<?php

Class singleopportunityController Extends baseController {

public function index() 
{         
		
		 //$this->checkuser();
		 $opportunity_id=get('record');
        $opportunity_id=$this->registry->encryption->decode($opportunity_id);
		
		$result =$this->registry->users->getsingleopportunity($opportunity_id);
	    $this->registry->template->opportunity= $result;
		$this->registry->template->facebook= $result->facebook;

		
        $this->registry->template->page_body = getviewslink().'/mooga/singleopportunity';
        $this->registry->template->show('index_home');
}


}

?>
