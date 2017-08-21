<?php

Class _profileactionController Extends baseController {

public function index() 
{      
 $this->checkuser();
        $profileid=$this->registry->encryption->decode(get('sid'));
		
       $id=$this->registry->sessionhandler->get( $this->registry->useridstr);
	   $profileid=$this->registry->encryption->decode($id);
	   //echo 'profile_id' . $profileid;
	   $user_id=$profileid;
	   $result =$this->registry->users->getuserdetails($user_id);
	   $this->registry->template->user= $result;
        $this->registry->template->page_body = getviewslink().'/mooga/profile';

        $this->registry->template->show('index_home');
}

public function edit() 
{      

 $this->checkuser();
  $profilepic= $this->getpicpath("assets/uploads/profile/");
          $parameters_db=array();
		  $parameters_db2=array();
		  //update master 
		   $parameters=$this->registry->objects->userdetails();
		   
		   $parameters2=$this->registry->objects->register();
		  
		  foreach ($parameters2 as $parameter) {
          //  echo $parameter;
            //return;
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =post($key);
		//	echo $json->type . "  " . $key . " = " . $$key . ';<br>';

            if (($key=="isconsaltant" ||$key=="isagent" ||$key=="isbusinessman" ||$key=="isinvestor" ||$key=="isprovider" ||$key=="isproductowner" )&& $$key==""){$$key=0;}           
		  //echo $json->type . "  " . $key . " = " . $$key . ';<br>';
		  if ($$key === 0){
			   $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db2, $jsondb);
				
		  }
		  elseif ($$key != "" &&  $key!='email') {
			  
                $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db2, $jsondb);
				
            }
        }
		
		      if ($profilepic!=""){
		        $data['name'] = 'profilepic';
                $data['value'] = $profilepic ;
                $data['type'] = 'string';
                $jsondb = json_encode($data);
                array_push($parameters_db2, $jsondb);
			  }
		  //update details
		  $parameters=$this->registry->objects->userdetails();
		  foreach ($parameters as $parameter) {
          //  echo $parameter;
            //return;
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =post($key);
			//echo $json->type . "  " . $key . " = " . $$key . ';<br>';
            if ($$key == "") {
                if (isset($json->requier)) {
                 //   echo "filed  $key  requier";
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
		
		
		$id=$this->registry->sessionhandler->get( $this->registry->useridstr); 
		$user_id=$this->registry->encryption->decode($id);
		
		$this->registry->users->updateuser($user_id,$parameters_db2);
		$this->registry->users->adduserdetails($user_id,$parameters_db);
	  
	  
}




}
?>
