<?php

Class verifie_offerController Extends baseController {

public function index() 
{
               
			   $offer_id=get('offer_id');
			     $this->registry->template->countries=$this->registry->helper->getcountries(); 
			$record=$this->registry->encryption->decode( $offer_id);
		    if ($record<=0) {self::index();exit();}
		   $offer=$this->registry->users->getsingleoffer($record,false);
		   $this->registry->template->offer =$offer ;
			   $this->registry->template->offer_id= $offer_id;
             $this->registry->template->page_body = getviewslink().'/mooga/verifie_offer';
              $this->registry->template->show('index_home');     
}
      

            
            

}
?>
