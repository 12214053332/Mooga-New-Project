<?php

Class addprojectController Extends baseController {

public function index() 
{      
    
 $this->checkuser();
	     $this->registry->template->countries=$this->registry->helper->getcountries(); 
		
		 $this->registry->template->project_field=json_encode ($this->registry->helper->getproject_field());
         $this->registry->template->project_type=json_encode ($this->registry->helper->getproject_type());
		  
		  $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
		   
		   $this->registry->template->products=json_encode ($this->registry->helper->getproducts_field());
		   
		    $this->registry->template->services=json_encode ($this->registry->helper->getservices());

		  
		 $this->registry->template->helper=$this->registry->objects;
		
        $this->registry->template->page_body = getviewslink().'/mooga/addproject';

        $this->registry->template->show('index_home');
}

public function edit() 
{      
     $this->checkuser();
	     $this->registry->template->countries=$this->registry->helper->getcountries(); 
		
		 $this->registry->template->project_field=json_encode ($this->registry->helper->getproject_field());
         $this->registry->template->project_type=json_encode ($this->registry->helper->getproject_type());
		  $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
		  
		   $products=json_encode ($this->registry->helper->getproducts_field());
		   $this->registry->template->products =$products;
		    $services=json_encode ($this->registry->helper->getservices());
			$this->registry->template->services= $services;
		 



		$record=$this->registry->encryption->decode(get('record'));
		if ($record<=0) {self::index();exit();}
		
		   $project=$this->registry->users->getsingleproject($record,false);
		   $this->registry->template->project =$project ;
			$allservices=$this->merge_json_array($services,$project->project_service_list);
			$allproducts=$this->merge_json_array($products,$project->project_product_list);
			
           $this->registry->template->services= $allservices;
		    $this->registry->template->products =$allproducts;
		 
		 $this->registry->template->helper=$this->registry->objects;
		
        $this->registry->template->page_body = getviewslink().'/mooga/addproject';

        $this->registry->template->show('index_home');
}


}
?>
