<?php

Class addofferController Extends baseController {

public function index() 
{      
    
 $this->checkuser();
	     $this->registry->template->countries=$this->registry->helper->getcountries(); 
		
		 $this->registry->template->offer_type_filed=json_encode ($this->registry->helper->getoffer_type_filed());
        $this->registry->template->item_brand=$this->registry->helper->getitem_brand();
	///	  $this->registry->template->item_type=$this->registry->helper->getitem_type();
		 $this->registry->template->helper=$this->registry->objects;
		
        $this->registry->template->page_body = getviewslink().'/mooga/addoffer';

        $this->registry->template->show('index_home');
}

public function edit() 
{      
     $this->checkuser();
        $this->registry->template->countries=$this->registry->helper->getcountries(); 
		
		 $this->registry->template->offer_type_filed=json_encode ($this->registry->helper->getoffer_type_filed());
        $this->registry->template->item_brand=$this->registry->helper->getitem_brand();
		  //$this->registry->template->item_type=$this->registry->helper->getitem_type();
		  
		 
		$record=$this->registry->encryption->decode(get('record'));
		if ($record<=0) {self::index();exit();}
		
		   $offer=$this->registry->users->getsingleoffer($record);
		   $this->registry->template->offer =$offer ;
		 
		 $this->registry->template->helper=$this->registry->objects;
		
        $this->registry->template->page_body = getviewslink().'/mooga/addoffer';

        $this->registry->template->show('index_home');
}


}
?>
