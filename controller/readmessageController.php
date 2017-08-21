<?php

Class readmessageController Extends baseController {

public function index() 
{       $this->checkuser();
    

        //die('doneeeeeeeeeeeeeeee');
        $this->registry->template->page_body = getviewslink().'/mooga/readmessage';
        $message_id=get('mid');
        
        $message_id=$this->registry->encryption->decode($message_id);
        //die($message_id);
         $this->registry->template->currentmessage=$this->registry->message->get_message_byid($message_id,$this->getuserid()) ;
        $this->registry->template->messagelist = $this->registry->message->get_inbox_msg_byid($message_id,$this->getuserid()) ;
        $this->registry->template->show('index_home');
}


}
?>
