<?php

Class offersController Extends baseController {

public function index() 
{      

        //$this->checkuser();
				
		 $this->registry->template->offer_type_filed=json_encode ($this->registry->helper->getoffer_type_filed());
        $this->registry->template->item_brand=$this->registry->helper->getitem_brand();
		 // $this->registry->template->item_type=$this->registry->helper->getitem_type();
		$this->registry->template->countries=$this->registry->helper->getcountries(); 
		 $this->registry->template->helper=$this->registry->objects;
		  $this->registry->template->form='all';
		  $facebook=new StdClass();
		    $facebook->image='assets/uploads/offers/offers.png';
		    $facebook->description='أضف عرضك الاّن لتسمح لأكبر عدد من أصحاب رؤوس الأموال و المستثمرين بمشاهدته و التواصل معك في الحال';
		  $this->registry->template->facebook=$facebook;
		  
		   $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
        $this->registry->template->page_body = getviewslink().'/mooga/offers';
		
		 $offers =$this->registry->users->getalloffers_search(" and IFNULL(offers.pending,0)=0  order by offers.id desc limit 10");
		  $this->registry->template->offers= $offers;
        $this->registry->template->show('index_home');
}


}
?>
