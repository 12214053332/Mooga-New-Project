<?php

Class myopportunitiesController Extends baseController {

public function index() 
{      
          $this->checkuser();
		  
		  $user_id=$this->getuserid();
		  $opportunities =$this->registry->users->getallopportunities( 'and user_id='.$user_id . ' order by opportunities.id desc limit 10');
		    $this->registry->template->form='my';
		  $this->registry->template->opportunities= $opportunities;
		  
           $this->registry->template->page_body = getviewslink().'/mooga/opportunities';

           $this->registry->template->show('index_home');
}


}
?>
