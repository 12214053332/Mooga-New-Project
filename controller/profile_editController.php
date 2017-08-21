<?php

Class profile_editController Extends baseController {

public function index() 
{      


  $this->checkuser();
        $profileid=$this->registry->encryption->decode(get('sid'));
		

	   /******************************************************************/
            include ("partial/user_lists_partial.php");
			   /******************************************************************/
			   
	
	   
	  		$condition =" and projects.user_id=$user_id order by createdtime desc limit 5 ";
	    $result2 =$this->registry->users->getallprojects_search($condition);
         $this->registry->template->allprojects= $result2;
		 
	  
	   
	    $opportunities =$this->registry->users->getuseropportunities($user_id);
		  $this->registry->template->opportunities= $opportunities;
		  
		  
		  $result_product =$this->registry->product->getallproducts($user_id);
	   $this->registry->template->allproducts= $result_product;
	   
	   $this->registry->template->helper=$this->registry->objects;
        $this->registry->template->page_body = getviewslink().'/mooga/profile_edit';

        $this->registry->template->show('index_home');
}


}
?>
