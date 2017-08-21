<?php

Class _projectactionController Extends baseController {

    public function index() {
		

	}
	
    public function addproject() {
		
		 $this->checkuser();
	$id=$this->registry->sessionhandler->get( $this->registry->useridstr);
	$decoded_id=$this->registry->encryption->decode($id);
	 $picpath= $this->getpicpath("assets/uploads/projects/");
         $parameters_db=array();
		  $parameters=$this->registry->objects->addproject();
		  foreach ($parameters as $parameter) {
          //  echo $parameter;
            //return;
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =post($key);
			//echo $json->type . "  " . $key . " = " . $$key . ';<br>';
            if ($$key == "") {
                if (isset($json->requier)) {
                  //  echo "filed  $key  requier";
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
		
		if ($picpath!=""){
				 $data['name'] = 'picpath';
                $data['value'] = $picpath ;
                $data['type'] = 'string';
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
		}
		
		$record=$this->registry->encryption->decode(post('record'));
		
		if ($record>0){
			$this->registry->users->updateproject($record,$decoded_id,$parameters_db);
		}else{
	      $id=	$this->registry->users->addproject($decoded_id,$parameters_db);
		}
	
	}
	
	
	public function showphone()
	{
		 //$this->checkuser();
	   $project_id=$this->registry->encryption->decode(post('project_id'));
	   $user_id=$this->registry->encryption->decode(post('user_id')) ;
	   $phone=	$this->registry->users->getprojectownerphone($project_id,$user_id);
	   if ($phone!=""){
	    echo "<p class='black-font sm-font text-center bold zero-bottom-margin'><a class='show-phone' href='tel:$phone'>$phone</a></p>" ;}
		else{
		   echo "";
	   }
	}	
	
	
	
	public function deleteproject()
	{
		
      $this->checkuser();
	   $project_id=$this->registry->encryption->decode(post('project_id'));
	   
	   $this->registry->users->deleteproject($project_id);
	   
	}
	
	
	public function check_showphone()
	{
    //	 $this->checkuser();
	   $project_id=$this->registry->encryption->decode(post('project_id'));
	   
	  $user_id=$this->registry->encryption->decode(post('user_id')) ;
	   $phone=	$this->registry->users->check_projectownerphone($project_id,$user_id);
	   if ($phone!=""){
	   echo "<p class='black-font sm-font text-center bold zero-bottom-margin'><a class='show-phone' href='tel:$phone'>$phone</a></p>" ;}
	   else{
		   echo "";
	   }
	}

}

?>
