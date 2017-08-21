<?php

Class verifie_projectController Extends baseController {

	public function index()
	{
					$this->checkuser();
					  $this->registry->template->countries=$this->registry->helper->getcountries();
				   $project_id=get('project_id');
						$record=$this->registry->encryption->decode( $project_id);
					  if ($record<=0) {self::index();exit();}

			   $project=$this->registry->users->getsingleproject($record,false);
			   $this->registry->template->project =$project ;
					 $this->registry->template->countries=$this->registry->helper->getcountries();
				   $this->registry->template->project_id= $project_id;
				 $this->registry->template->page_body = getviewslink().'/mooga/verifie_project';
				  $this->registry->template->show('index_home');
	}
}
?>
