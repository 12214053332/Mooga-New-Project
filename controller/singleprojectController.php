<?php

Class singleprojectController Extends baseController {

public function index() 

{      
      
      //     $this->checkuser();  
         $project_id=get("pid");
		 $project_id=$this->registry->encryption->decode($project_id);
		 
		 if ($project_id<=0||!isset($project_id)){
		 
		     header("Location: ?page=index");
		    exit;
		 }
		 $project=$this->registry->users->getsingleproject($project_id);
		 $this->registry->template->projects=$this->registry->users->getUserRelatedProjects($this->getuserid());
		 $this->registry->template->project =$project ;
		 $this->registry->template->facebook =$project->facebook ;
		 $this->registry->template->helper=$this->registry->objects;
	     $this->registry->template->page_body = getviewslink().'/mooga/singleproject';
        $this->registry->template->page_body = getviewslink().'/mooga/singleproject';

        $this->registry->template->show('index_home');
}


}
?>
