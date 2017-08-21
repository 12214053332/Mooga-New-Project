<?php

Class _messageactionController Extends baseController {

    public function index() {


    }




    public function replaymessage() {


        $this->checkuser();
        $parameters_db=array();
        $parameters=$this->registry->objects->message();
        foreach ($parameters as $parameter) {
            //  echo $parameter;
            //return;
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =post($key);
            //echo $json->type . "  " . $key . " = " . $$key . ';<br>';
            if ($$key == "") {
                if (isset($json->requier)) {
                    echo "filed  $key  requier";
                    $isuccess = FALSE;
                    // return ;
                }
            } else {
                if ($key=='user1_id'||$key=='user2_id'||$key=='msg_id_reply'){$$key=$this->registry->encryption->decode($$key);}
                $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
            }
        }
        $id=$this->registry->message->addmessage($parameters_db);
        if ($id>0){
            $this->registry->template->messagelist = $this->registry->message->get_inbox_msg_byid($msg_id_reply,$this->getuserid()) ;
            $this->registry->template->show('mooga/wedget/readmessage');
        }

    }


    public function newmessage() {
        $this->checkuser();
        $user_id=$this->getuserid();
        $parameters_db=array();
        $parameters=$this->registry->objects->message();
        foreach ($parameters as $parameter) {
            //  echo $parameter;
            //return;
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =post($key);
            //echo $json->type . "  " . $key . " = " . $$key . ';<br>';
            if ($$key == "") {
                if (isset($json->requier)) {
                    echo "filed  $key  requier";
                    $isuccess = FALSE;
                    // return ;
                }
            } else {
                if ($key=='user2_id'){$$key=$this->registry->encryption->decode($$key);}
                $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
            }
        }
        $data['name'] = "user1_id";
        $data['value'] = $user_id;
        $data['type'] = "integer";
        $jsondb = json_encode($data);
        array_push($parameters_db, $jsondb);

        $id=	$this->registry->message->addmessage($parameters_db);
    }

}

?>
