<?php

Class myprojectsController Extends baseController {

public function index() 
{
    $search=post('name');
    $this->registry->template->search=$search;
		        $this->checkuser();
				
		$user_id=$this->getuserid();
		$this->registry->template->countries=$this->registry->helper->getcountries(); 
		 $this->registry->template->helper=$this->registry->objects;
		  $this->registry->template->form='my';
		   $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
        $this->registry->template->page_body = getviewslink().'/mooga/projects';
		 $projects =$this->registry->users->getallprojects_search(" and user_id=". $user_id . ' order by projects.id desc limit 10');
		  $this->registry->template->projects= $projects;
        $this->registry->template->show('index_home');
}


}
?>
