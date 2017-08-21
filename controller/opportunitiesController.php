<?php

Class opportunitiesController Extends baseController {

public function index() 
{      
          //$this->checkuser();
		  
		  $user_id=$this->getuserid();
		  $opportunities =$this->registry->users->getallopportunities(" order by opportunities.id desc limit 10");
		  $this->registry->template->opportunities= $opportunities;
		   $this->registry->template->form='all';
		   
		    $facebook=new StdClass();
		   $facebook->image='assets/uploads/opportunity/opportunities.png';
		    $facebook->description='تصفح أحدث فرص البيزنس المضافة علي موقع موجة و تواصل مع أصحابها الاّن ';
		  $this->registry->template->facebook=$facebook;
		  
        $this->registry->template->page_body = getviewslink().'/mooga/opportunities';

        $this->registry->template->show('index_home');
}


}
?>
