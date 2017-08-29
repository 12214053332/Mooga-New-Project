<?php

Class _usersactionController Extends baseController {

    public function index() {
		
		/*no post found*/
		//if (!isset($_POST['email'])) {echo 0 ;return;}
		/*no post found*/
        //check for login type		
		/*$login_type=$this->registry->sessionhandler->get('login_type');
		  if ($login_type=='facebook'){
			  self::facebook_register();
		  }else if ($login_type=='linkedin')
		  {
			  self::linkedin_register();
		  }else
		  {
			  self::normal_register();
		  }*/
	}
	public function successDeal(){
		$projectid=post('projectid');
		if($projectid!=''){$projectid=$this->registry->encryption->decode($projectid);}
		$this->registry->users->successProjectDeal($projectid,self::getuserid());
	}
    public function signup() {
		
		/*no post found*/
		//if (!isset($_POST['email'])) {echo 0 ;return;}
		/*no post found*/
        //check for login type	
		
		$login_type=$this->registry->sessionhandler->get('login_type');
		  if ($login_type=='facebook'){
			  self::facebook_register();
		  }else if ($login_type=='linkedin')
		  {
			  self::linkedin_register();
		  }else
		  {
			
			  self::normal_register();
		  }
		  
		  
	}
	
	public  function login()
	{
		  $login_type=$this->registry->sessionhandler->get('login_type');
		  if ($login_type=='facebook'){
			  self::facebook_register();
		  }else if ($login_type=='linkedin')
		  {
			  self::linkedin_register();
		  }else
		  {
			  self::normal_login();
		  }
	}



/*other function*/	
		function facebook_register()
	{
	    	$parameters_db=array();
			$login_type=$this->registry->sessionhandler->get('login_type');
			$fbid=$this->registry->sessionhandler->get('FBID');
			$facebookemail=$this->registry->sessionhandler->get("email");
			
		  $fbid=$fbid.'@facebook.com';
	if ($facebookemail==""){$facebookemail=$fbid;}
           $currentuserid=	$this->registry->users->_isexesituser($facebookemail);
          if ($currentuserid>0){
			  $currentuserid=$this->registry->encryption->encode($currentuserid);
	         $this->registry->sessionhandler->put( $this->registry->useridstr,$currentuserid);
	
			  header("Location:?page=profile&");
			  exit;
		  }
		  $parameters=$this->registry->objects->register();

		  foreach ($parameters as $parameter) {
          //  echo $parameter;
            //return;
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =$this->registry->sessionhandler->get($key);//post($key);
			if ($key=="email")
			{
				if ($$key=="")
				{
					$$key= $fbid;
				}
			}
			//echo $json->type . "  " . $key . " = " . $$key . ';<br>';
            if ($$key == "") {
               
            } else {
              //echo $key . "=". $$key;
                $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
            }
        }
		
	$id=	$this->registry->users->adduser($parameters_db);
	$decoded_id=$this->registry->encryption->encode($id);
	$this->registry->sessionhandler->put( $this->registry->useridstr,$decoded_id);
	
	if ($id>0)
	{
		self::sendwelcomemail($email);
	}
	     self::redirecttopage_social();
		  header("Location:?page=profile&");
			  exit;
	}
	
	
	function linkedin_register()
	{
    	$parameters_db=array();
			$login_type=$this->registry->sessionhandler->get('login_type');
			$fbid=$this->registry->sessionhandler->get('FBID');
		  $fbid=$fbid.'@linkedin.com';
		  $linkeinemail=$this->registry->sessionhandler->get("email");
          if ($linkeinemail==""){$linkeinemail=$fbid;}
           $currentuserid=	$this->registry->users->_isexesituser($linkeinemail);
          if ($currentuserid>0){
			  $currentuserid=$this->registry->encryption->encode($currentuserid);
	         $this->registry->sessionhandler->put( $this->registry->useridstr,$currentuserid);
	
			  header("Location:?page=profile&");
			  exit;
		  }
		  $parameters=$this->registry->objects->register();
		  foreach ($parameters as $parameter) {
          //  echo $parameter;
            //return;
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =$this->registry->sessionhandler->get($key);//post($key);
			if ($key=="email")
			{
				if ($$key=="")
				{
					$$key= $fbid;
				}
			}
			//echo $json->type . "  " . $key . " = " . $$key . ';<br>';
            if ($$key == "") {
               
            } else {
              //echo $key . "=". $$key;
                $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
            }
        }
	
	$id=	$this->registry->users->adduser($parameters_db);
		
	$decoded_id=$this->registry->encryption->encode($id);
	$this->registry->sessionhandler->put( $this->registry->useridstr,$decoded_id);
	
	if ($id>0)
	{
		self::sendwelcomemail($email);
	}
	  
	//  echo $message;
	//  $this->registry->sessionhandler->put('message',$message);//post($key);
	 // header("Location:?page=thanks");
	  self::redirecttopage_social();
	 	  header("Location:?page=profile&");
			  exit;
	}
      
    
	function normal_register()
	{
		$parameters_db=array();
		  $parameters=$this->registry->objects->register();
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
		
	$id=	$this->registry->users->adduser($parameters_db);
	
	$decoded_id=$this->registry->encryption->encode($id);
	$this->registry->sessionhandler->put( $this->registry->useridstr,$decoded_id);
	
	if ($id>0)
	{
		self::sendwelcomemail($email);
		
	    self:: redirecttopage();
		
	}
		//echo $id;
	}

 
 function redirecttopage()
 {	
        $httpref=$this->registry->sessionhandler->get('HTTP_REFERER');
	 	if ((isset($facebookpref)&&$facebookpref!="") && strpos($httpref, $_SERVER['HTTP_HOST']) !== false){
		ob_end_clean();
		$data=array("httpref" => $httpref );
		echo json_encode( $data);
		}else{
	 		echo  json_encode( ["httpref" => '?page=index']);
		}
 }
 function redirecttopage_social()
 {	
        $httpref=$this->registry->sessionhandler->get('HTTP_REFERER');
	 	if ($httpref!="" && strpos($httpref, $_SERVER['HTTP_HOST']) !== false){
		//ob_end_clean();
		//$data=array("httpref" => $httpref ,);
		//echo json_encode( $data);
				  header("Location:?page=$httpref"."&");
			  exit;
		}
 }
  function normal_login()
	{
		 
		  $parameters_db=array();
		  $parameters=$this->registry->objects->login();
		
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
		
		
	$id=	$this->registry->users->loginuser($email,$password);
	$decoded_id=$this->registry->encryption->encode($id);
	
	
	if ($id>0){
		$rememberme=post('remember_me');
		
		$this->registry->sessionhandler->put( $this->registry->useridstr,$decoded_id);
		$this->registry->users->rememberme($email,$password,$rememberme);
		
		/*$HTTP_REFERER=$this->registry->sessionhandler->get( "HTTP_REFERER");
		$domain=$_SERVER['SERVER_NAME'];
		
		
		if (strpos($HTTP_REFERER, $domain) !== false) {
          echo $HTTP_REFERER;
		 //header("Location:$HTTP_REFERER");
         }else
		 {
			 echo $id;
		 }*/		
		  //echo $id;
		 self::redirecttopage();
	}
	
	
	
//	echo $this->registry->sessionhandler->get( $this->registry->useridstr);
			//echo 'normal_register';
	}


	
		
	public function showphone()
	{
		 $this->checkuser();
	   $src_user_id=$this->registry->encryption->decode(post('src_user_id'));
	   $user_id=$this->registry->encryption->decode(post('user_id')) ;
	   $phone=	$this->registry->users->getuserownerphone($src_user_id,$user_id);
	   if ($phone!=""){
	    echo "<p class='black-font sm-font text-right bold zero-bottom-margin' style='margin-top:40px' ><a class='show-phone' href='tel:$phone'>$phone</a></p>" ;}
		else{
		   echo "";
	   }
	}	
	
	public function check_showphone()
	{
    	 $this->checkuser();
	   $src_user_id=$this->registry->encryption->decode(post('src_user_id'));
	   $user_id=$this->registry->encryption->decode(post('user_id')) ;
	   $phone=	$this->registry->users->check_userownerphone($src_user_id,$user_id);
	   if ($phone!=""){
	   echo "<p class='black-font sm-font text-right bold zero-bottom-margin' style='margin-top:40px'><a class='show-phone' href='tel:$phone'>$phone</a></p>" ;}
	   else{
		   echo "";
	   }
	}

public function country()
	{
    	 //$this->checkuser();
	   $country_code=post("country_code");
	   $selectedvalue=post("selectedvalue");
		$this->registry->template->selectedvalue =  $selectedvalue;
	   //echo   'country_code'.$country_code;
	   $states=	$this->registry->helper->getstates($country_code);
	   
	   	$this->registry->template->states =  $states;
		
        $this->registry->template->show('mooga/wedget/states');
	}	
	
		public function item_type()
	{
    	 //$this->checkuser();
	   
	    $item_brand=post("item_brand");
	    $selectedvalue=post("selectedvalue");
		//$item_type=post("item_type");
		
	   //echo   'country_code'.$country_code;
	   $states=	$this->registry->helper->getitem_type($item_brand) ;
	   
	   	$this->registry->template->states =  $states;
		$this->registry->template->selectedvalue =  $selectedvalue;
        $this->registry->template->show('mooga/wedget/states');
	}	
	
	public function item_names()
	{
    	 //$this->checkuser();
	   
	   $item_brand=post("item_brand");
		$item_type=post("item_type");
		$selectedvalue=post("selectedvalue");
		$this->registry->template->selectedvalue =  $selectedvalue;
	   //echo   'country_code'.$country_code;
	   $states=	$this->registry->helper->getitem_names($item_brand,$item_type) ;
	   
	   	$this->registry->template->states =  $states;
		
        $this->registry->template->show('mooga/wedget/states');
	}		
public function states()
	{
    	 //$this->checkuser();
	   $country_code=post('country_code');
	   	   $selectedvalue=post("selectedvalue");
		$this->registry->template->selectedvalue =  $selectedvalue;
	  // echo   'country_code'.$country_code;
	   $states=	$this->registry->helper->getcities($country_code);
	   
	   	$this->registry->template->states =  $states;
		
        $this->registry->template->show('mooga/wedget/states');
	}	
	

public function country_array()
	{
    	 //$this->checkuser();
	   $country_code=post("country_code");
	   //echo   'country_code'.$country_code;
	   $states=	$this->registry->helper->getstates($country_code);
	   
	   	$this->registry->template->states =  $states;
		
        $this->registry->template->show('mooga/wedget/states');
	}		
	
public function states_array()
	{
    	 //$this->checkuser();
	   $country_code=post('country_code');
	  // echo   'country_code'.$country_code;
	   $states=	$this->registry->helper->getcities($country_code);
	   
	   	$this->registry->template->states =  $states;
		
        $this->registry->template->show('mooga/wedget/states');
	}	
	

	public function ajaxbalance()
	{
    	 $this->checkuser();
	
	   
	   $result=	$this->registry->users->ajaxbalance();
	   $json = json_encode($result);
	   echo $json;
	  
	}
	
	
	
		public function forgetpassword() 
{      

             $email=post('email');
          
            if($email=="")
                                return;
             $result_email=  $this->registry->users->isexesituser($email);
       
             
             if($result_email)
             {
                 $resultins=  $this->registry->users->insertresetpassword($email);
                //$link= $_SERVER['SERVER_NAME'].'?page=forgetpassword&action=resetpassword&token='.$resultins;
				 $link=   "http://" . $_SERVER['SERVER_NAME'] . strtok($_SERVER["REQUEST_URI"],'?').'?page=forgetpassword&action=resetpassword&token='.$resultins;
               $text="<a href='$link'> $link</a>";
                
               $parameters=array(
                   'template' => 'resetpassword',
                   'link' => $link,
                   'username' => $email,
				   
               );
                  
                $this->registry->emails->sendemail($email,$parameters);
                 //$this->mailresetlink($email,$resultins);
                 $errorMessage= 'يمكنك فحص بريدك الإلكترونى';
                 include_once getviewslink().'/message/success_message.php';
             }
             else
             {
                  $errorMessage= 'من فضلك تأكد من البريد الإلكترونى';
                  include_once getviewslink().'/message/error_message.php';
             }
        
        
        
}


	
		public function sendwelcomemail($email) 
{      
            
            // $email=post('email');
             
            if($email=="")
                                return;
             $result_email=  $this->registry->users->isexesituser($email);
             
             
             if($result_email)
             {
                // $resultins=  $this->registry->users->insertresetpassword($email);
              //  $link= $_SERVER['SERVER_NAME'].'?page=forgetpassword&action=resetpassword&token='.$resultins;
              // $text="<a href='$link'> $link</a>";
                
               $parameters=array(
                   'template' => 'welcome',
                //   'link' => $link,
                   'username' => $email,
				   
               );
                  
                $this->registry->emails->sendemail($email,$parameters);
                
             }
             else
             {
                 
             }
        
        
        
}



}

?>
