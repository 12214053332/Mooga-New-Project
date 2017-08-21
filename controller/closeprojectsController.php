<?php

Class closeprojectsController Extends baseController {

public function index() 
{      

		       // $this->checkuser();
				
		$user_id=$this->getuserid();
		$this->registry->template->countries=$this->registry->helper->getcountries(); 
		 $this->registry->template->helper=$this->registry->objects;
		  $this->registry->template->form='close';
		   $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
        $this->registry->template->page_body = getviewslink().'/mooga/projects';
		 $projects =$this->registry->users->getallprojects_search("  and needclose=1");
		  $this->registry->template->projects= $projects;
        $this->registry->template->show('index_home');
}


}
?>
