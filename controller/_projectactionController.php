<?php

Class _projectactionController Extends baseController {

    public function index() {
		

	}
	
    public function addproject() {
		if(!isset($_POST['needpartner'])&&!isset($_POST['needfunder'])&&!isset($_POST['needbuyer'])){
			$errorMessage='من فضلك اختر احتياج المشروع';
			include 'views/message/error_message.php';
			return'';
		}
		 $this->checkuser();
		if(!$this->registry->users->checkProjectsDuplicated()){
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
				if ($id>0){

					$ids=$this->registry->encryption->encode($id);
					self::redirecttopage($ids);

				}
			}
		}

	
	}
	
	
	
		public function change_project()
	{
		
      $this->checkuser();
	   $project_id=$this->registry->encryption->decode(post('project_id'));
	   $contact_name=post('contact_name');
	   $contact_type=post('contact_type');
	   $contact_phone=post('contact_phone');
	   $contact_email=post('contact_email');
	   $country_code=post('country_1');
	   $this->registry->users->change_project($project_id,$country_code,$contact_name,$contact_type,$contact_email,$contact_phone);
	   
	   
	}
	
	public function showphone()
	{
		 //$this->checkuser();
		if(self::getuserid()){
			$project_id=$this->registry->encryption->decode(post('project_id'));
			$user_id=$this->registry->encryption->decode(post('user_id')) ;
			$phone=	$this->registry->users->getprojectownerphone($project_id,$user_id);
			if ($phone!=""){
				echo $phone;}
			else{
				echo "";
			}
		}else{

			$project_id=$this->registry->encryption->decode(post('project_id'));
			$user_id=$this->registry->encryption->decode(post('user_id')) ;
			$this->registry->users->getProjectOwnerPhoneCOOKIE($project_id,$user_id);
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
	   echo $phone ;}
	   else{
		   echo "";
	   }
	}
	
		public function verifie_project()
	{
		if(self::validCSF()){
			$this->checkuser();
			// echo post('project_id');
			$project_id=$this->registry->encryption->decode(post('project_id'));
			$verifie_code=post('verifie_code');
			$this->registry->users->verifie_project($project_id,$verifie_code);
		}
	}
	
	 function redirecttopage($id)
 {	
		ob_end_clean();
		$data=array("id" => $id ,);
		echo json_encode( $data);
  }	

}

?>
