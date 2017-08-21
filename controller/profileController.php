<?php

Class profileController Extends baseController {

public function index() 
{      
         $this->checkuser();
        $profileid=$this->registry->encryption->decode(get('sid'));
		
       $id=$this->registry->sessionhandler->get( $this->registry->useridstr);
	   $user_id=$this->registry->encryption->decode($id);
	   //echo 'profile_id' . $profileid;
	   if ($profileid>0){
	    $user_id=$profileid;
	   }
	   $result =$this->registry->users->getuserdetails($user_id);
	   $this->registry->template->currentuser= $result;
	 
		 
		 $condition =" and projects.user_id=$user_id order by createdtime desc limit 5 ";
	    $result2 =$this->registry->users->getallprojects_search($condition);
         $this->registry->template->allprojects= $result2;
		 
		 $opportunities =$this->registry->users->getuseropportunities($user_id);
		  $this->registry->template->opportunities= $opportunities;
		  
		  $result_product =$this->registry->product->getallproducts($user_id);
	   $this->registry->template->allproducts= $result_product;
		  
	     $this->registry->template->helper=$this->registry->objects;
        $this->registry->template->page_body = getviewslink().'/mooga/profile';

        $this->registry->template->show('index_home');
}


}
?>


