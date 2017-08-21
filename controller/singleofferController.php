<?php

Class singleofferController Extends baseController {

public function index() 

{      
      
      //     $this->checkuser();  
         $offer_id=get("pid");
		 $offer_id=$this->registry->encryption->decode($offer_id);
		 
		 if ($offer_id<=0||!isset($offer_id)){
		 
		     header("Location: ?page=index");
		    exit;
		 }
	     
		 $offer=$this->registry->users->getsingleoffer($offer_id);
		 
		 
		    
		 $this->registry->template->offer =$offer ;
		 $this->registry->template->facebook =$offer->facebook ;
		 $this->registry->template->helper=$this->registry->objects;
	     $this->registry->template->page_body = getviewslink().'/mooga/singleoffer';
        

        $this->registry->template->show('index_home');
}


}
?>
