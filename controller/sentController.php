<?php

Class sentController Extends baseController {

    public function index() {
    
        $this->checkuser();
        $sendto=get('sid');
        $msid=get('msid');
        
		$user_id=  $this->getuserid();
    
        
        $this->registry->template->messagelist = $this->registry->message->get_sent_message($user_id) ;
       
        
        $this->registry->template->sendto=$sendto;

		$this->registry->template->page_body = getviewslink().'/mooga/sent';
        $this->registry->template->show('index_home');
    }

}

?>
