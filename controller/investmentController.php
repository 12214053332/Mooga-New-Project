<?php

Class investmentController Extends baseController {

public function index() 
{      

        //$this->checkuser();
		$this->registry->template->countries=$this->registry->helper->getcountries(); 
		 $this->registry->template->project_field=json_encode ($this->registry->helper->getproject_field());
         $this->registry->template->project_type=json_encode ($this->registry->helper->getproject_type());
		  
		  $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
		   
		   $this->registry->template->products=json_encode ($this->registry->helper->getproducts_field());
		   
		    $this->registry->template->services=json_encode ($this->registry->helper->getservices());
		 $this->registry->template->helper=$this->registry->objects;
		  $this->registry->template->form='all';
		  $facebook=new StdClass();
		   $facebook->image='assets/uploads/projects/projects.png';
		    $facebook->description='أضف مشروعك الاّن لتسمح لأكبر عدد من أصحاب رؤوس الأموال و المستثمرين بمشاهدته و التواصل معك في الحال';
		  $this->registry->template->facebook=$facebook;
		  
		   $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
        $this->registry->template->page_body = getviewslink().'/mooga/projects';
		
		 $projects =$this->registry->users->getallprojects_search(" and IFNULL(projects.pending,0)=0 order by projects.id desc limit 10");
		  $this->registry->template->projects= $projects;
        $this->registry->template->show('index_home');
}


}
?>
