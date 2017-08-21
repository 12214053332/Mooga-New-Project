<?php

Class _opportunityactionController Extends baseController {

    public function index() {
		
	
	}
	
    public function addopportunity() {
		
		 $this->checkuser();
		$id=$this->registry->sessionhandler->get( $this->registry->useridstr);
		$decoded_id=$this->registry->encryption->decode($id);
	 $picpath= $this->getpicpath("assets/uploads/opportunity/");
         $parameters_db=array();
		  $parameters=$this->registry->objects->addopportunity();
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
                $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
            }
        }
	if($picpath!=""){		
     			$data['name'] = 'picpath';
                $data['value'] = $picpath ;
                $data['type'] = 'string';
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
	}
		
		$opp_id=$this->registry->encryption->decode(post('opportunity_id'));
		
		if ($opp_id>0){
			$this->registry->users->updateopportunity($opp_id,$decoded_id,$parameters_db);
		}else{
	    $id=	$this->registry->users->addopportunity($decoded_id,$parameters_db);
		}
	}

	
	public function deleteopportunity()
	{
		
    	 $this->checkuser();
	   $opportunity_id=$this->registry->encryption->decode(post('opportunity_id'));
	   
	   $this->registry->users->deleteopportunity($opportunity_id);
	   
	}
	
	
		public function showphone()
	{
		 $this->checkuser();
	   $opportunity_id=$this->registry->encryption->decode(post('opportunity_id'));
	   $user_id=$this->registry->encryption->decode(post('user_id')) ;
	   $phone=	$this->registry->users->getopportunityownerphone($opportunity_id,$user_id);
  
	  if ($phone!=""){
	    echo "<p class='black-font sm-font text-right bold zero-bottom-margin' style='margin-top:40px' ><a class='show-phone  opp-margin' href='tel:$phone'>$phone</a></p>" ;}
		else{
		  echo "<p class='col-md-6 col-lg-6 col-xs-12 col-sm-12 black-font sm-font text-right bold zero-bottom-margin show-phone margin-right' style='margin-top:40px'>لا يوجد رقم هاتف</p>" ;
	   }
	}	 
	
	public function check_showphone()
	{
    	// $this->checkuser();
	   $opportunity_id=$this->registry->encryption->decode(post('opportunity_id'));
	   $user_id=$this->registry->encryption->decode(post('user_id')) ;
	   $phone=	$this->registry->users->check_opportunityownerphone($opportunity_id,$user_id);
	 
	   if ($phone!=""){
	   echo "<p class='black-font sm-font text-right bold zero-bottom-margin' style='margin-top:40px'><a class='show-phone  opp-margin' href='tel:$phone'>$phone</a></p>" ;}
	   else{
		  echo "<p class='col-md-6 col-lg-6 col-xs-12 col-sm-12  black-font sm-font text-right bold zero-bottom-margin show-phone margin-right' style='margin-top:40px' >لا يوجد رقم هاتف</p>" ;
	   }
	}
	

}

?>
