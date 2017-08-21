<?php

Class _offeractionController Extends baseController {

    public function index() {
		

	}

    public function addoffer() {
		
		 $this->checkuser();
		if(!$this->registry->users->checkOfferDuplicated()){
			$id=$this->registry->sessionhandler->get( $this->registry->useridstr);
			$decoded_id=$this->registry->encryption->decode($id);
			$picpath= $this->getpicpath("assets/uploads/projects/");
			$parameters_db=array();
			$parameters=$this->registry->objects->addoffer();
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
				$this->registry->users->updateoffer($record,$parameters_db);
				echo'<script>setTimeout(function(){window.location="?page=myoffers";},500);</script>';
			}else{
				$id=	$this->registry->users->addoffer($parameters_db);
				if ($id>0){
					//  header("Location:?page=verifie_offer&offer_id=".$this->registry->encryption->encode($id));
					$ids=$this->registry->encryption->encode($id);
					self::redirecttopage($ids);

				}
			}
		}

	
	}
	
	
	public function showphone()
	{
		 //$this->checkuser();
		if(self::getuserid()){
			$offer_id=$this->registry->encryption->decode(post('offer_id'));
			$user_id=$this->registry->encryption->decode(post('user_id')) ;
			$phone=	$this->registry->users->getofferownerphone($offer_id,$user_id);
			if ($phone!=""){
				echo $phone;}
			else{
				echo "";
			}
		}else{
			$offer_id=$this->registry->encryption->decode(post('offer_id'));
			$user_id=$this->registry->encryption->decode(post('user_id')) ;
			$this->registry->users->getOfferOwnerPhoneCOOKIE($offer_id,$user_id);
		}

	}	
	
	
	public function deleteoffer()
	{
		
      $this->checkuser();
	   $offer_id=$this->registry->encryption->decode(post('offer_id'));
	   
	   $this->registry->users->deleteoffer($offer_id);
	   
	}
	
	
	public function check_showphone()
	{
    //	 $this->checkuser();
		$offer_id=$this->registry->encryption->decode(post('offer_id'));
		$user_id=$this->registry->encryption->decode(post('user_id')) ;
		$phone=	$this->registry->users->check_offerownerphone($offer_id,$user_id);
		if ($phone!=""){
			echo $phone ;}
		else{
			echo "";
		}


	}

	
		
	public function verifie_offer()
	{

      $this->checkuser();
	   $offer_id=$this->registry->encryption->decode(post('offer_id'));
	   $verifie_code=post('verifie_code');
	   $this->registry->users->verifie_offer($offer_id,$verifie_code);


	}
	
	public function change_offer()
	{
		
      $this->checkuser();
	   $offer_id=$this->registry->encryption->decode(post('offer_id'));
	   $contact_name=post('contact_name');
	   $contact_type=post('contact_type');
	   $contact_phone=post('contact_phone');
	   $contact_email=post('contact_email');
	   $country_code=post('country_1');
	   $this->registry->users->change_offer($offer_id,$country_code,$contact_name,$contact_type,$contact_email,$contact_phone);
	   
	   
	}

 function redirecttopage($id)
 {	
		ob_end_clean();
		$data=array("id" => $id ,);
		echo json_encode( $data);
  }	
}

?>
