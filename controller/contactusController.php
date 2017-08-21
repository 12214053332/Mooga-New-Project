<?php

Class contactusController Extends baseController {

public function index() 
{         


        $this->registry->template->page_body = getviewslink().'/mooga/contactus';
        $this->registry->template->show('index_home');
}

public function contactus() 
{         
          $parameters_db=array();
		  $parameters=$this->registry->objects->contactus();
		  
	  foreach ($parameters as $parameter) {
          
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =post($key);
			
            if ($$key == "") {
                if (isset($json->requier)) {
                    echo "filed  $key  requier";
                    $isuccess = FALSE;
                    // return ;
                }
            } else {
				
                $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
            
	  }
	  }
		
		 $id=	$this->registry->users->contactus($parameters_db);
		



}
}


?>
