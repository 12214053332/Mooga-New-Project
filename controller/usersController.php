<?php

Class usersController Extends baseController {

public function index() 
{         

        		    $this->checkuser();
		   /******************************************************************/
          include ('partial/user_lists_partial.php') ;	
			   /******************************************************************/
         $users =$this->registry->users->getallusers(" order by users.id desc limit 10");
		  $this->registry->template->users= $users;
		  
		   $this->registry->template->helper=$this->registry->objects;
        $this->registry->template->page_body = getviewslink().'/mooga/users';
        $this->registry->template->show('index_home');
}



}

?>
