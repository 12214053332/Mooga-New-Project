<?php

Class newmessageController Extends baseController {

public function index() 
{       $this->checkuser();
    

        //die('doneeeeeeeeeeeeeeee');
        $this->registry->template->page_body = getviewslink().'/mooga/newmessage';
         $user2_id=get('uid');
        $user2_id=$this->registry->encryption->decode($user2_id);
        //die($user2_id);
		if ($user2_id <= 0){header("Location:?page=inbox");exit;}
         $this->registry->template->messageuser= $this->registry->message->get_user($user2_id);
        $this->registry->template->show('index_home');
}


}
?>
