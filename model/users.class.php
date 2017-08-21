<?php

class users extends db {
    /*     * * Declare instance ** */

    private static $success_message = "شكرا لتسجيلك فى موقع موجة";
    private static $emailexsist_message = "هذا البريد الإلكتروني موجود من قبل";
    private static $emailnotexsist_message = "خطأ فى البريد الإلكترونى او كلمة المرور";
    private static $problem_message = "خطأ فى تسجيل البيانات";
	private static $success_add = "تم  الأضافة بنجاح";
	private static $success_edit = "تم  التعديل بنجاح";
	private static $success_validate = "تم التأكيد بنجاح";
	
	private static $success_validate1 = "تم ارسال كود التفعيل";
	private static $error_validate = "الرقم التأكيدى الذى ادخلتة غير صحيح";
	private static $error_validate1 = "بيانات الاتصال موجودة بالفعل";
		private static $contactus = "شكرا لاتصالك سيتم الرد عليك فى اسرع وقت ممكن";
		private static $existData = 'هذه البيانات مضافه من قبل';
	private static $project_credit = 1;
	private static $user_credit = 1;
	private static $opportunity_credit = 1;
	private static $message_credit = 1;

	private static $user_expired_after = 30;
		private static $project_expired_after = 30;
			private static $opportunity_expired_after = 30;
			private static $message_expired_after = 30;
			private static $cookieID = 'MOOGAUSERIDSESSIONDATA';
			private static $cookieExpired = (3600*24*30);

	 private static $picpath = "assets/uploads/projects/none.png"; 
	 private static $picpathoffer = "assets/uploads/offers/none.png";
	 private static $picpathopp = "assets/uploads/opportunity/none.png";
    /**
     *
     * the constructor is set to private so
     * so nobody can create a new instance using new
     *
     */

    private  static $encryption;
	  private  static $sessionhandler2;

    public function __construct() {

  /*** maybe set the db name here later ***/
	 self::$encryption=new Encryption();
	 self::$sessionhandler2=new SecureSessionHandler();

		if(!isset($_COOKIE[self::$cookieID])){
			$query="INSERT INTO session_users (`user_id`) VALUES ('0')";

			$id=self::execquery_id($query);
			setcookie (self::$cookieID,$id, time() + self::$cookieExpired);
		}
	}

    /**
     *
     * Return DB instance or create intitial connection
     *
     * @return object (PDO)
     *
     * @access public
     *
     */
	 
	 /*
	 *
	 *All Function need to users 
	 */
	 
	 
    public static function adduser($parameters) {
        $keys = "";
        $values = "";
        $currentsource=self::$sessionhandler2->get('currentlink');
        //die('my current session is '.$currentsource);
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
			
            $value = $json->value;
            
			$type = $json->type;
			
            $keys = $keys . $key . ',';
            if ($key == 'email') {
               if ( self::isexesituser($value)===TRUE)
               {
                    //echo self::$emailexsist_message;
				    $errorMessage=  self::$emailexsist_message;
                    include 'views/message/error_message.php';
                return 0;
               }
            }

            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
        $query = "insert into users (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
	
			//echo  $query;
        $id = self::execquery_id($query);
		
		  if ($id>0){
		  self::updateuserbalance($id,1000);
		//self::updateprofilelink ($id,$currentsource);
       
	       $errorMessage=  self::$success_message;
                    include 'views/message/success_message.php';
        /*add record to crm*/
         self::transferdatatocrmbyid($id);
		  }
		  else
		  {
			  $errorMessage=  self::$problem_message;
                    include 'views/message/error_message.php';
		  }
        
        return $id;
    }

    public static function isexesituser($email) {
        $query = "select id  from users where email='$email'";
        $result = self::execquery($query);

        if ($result) {
            if ($result->num_rows > 0) {
                return TRUE;
            }
        } else {
            return FALSE;
        }

     }
	 
	 
	    public static function _isexesituser($email) {
        $query = "select id  from users where email='$email' ";
        //  $result = self::execquery($query);
        //echo  $query ;
        $id = 0;
        $result = self::execquery($query);
        if ($result) {
            if ($result->num_rows > 0) {
                $obj = mysqli_fetch_object($result);
                $id = $obj->id;
            }
        }

        return $id;
    }

	 
	
    public static function isexesituserdetails($user_id) {
        $query = "select id  from userdetails where user_id='$user_id'";
        $result = self::execquery($query);

        if ($result) {
            if ($result->num_rows > 0) {
                return TRUE;
            }
        } else {
            return FALSE;
        }

     }
	 

	      public static function updateuserpfile($path, $userid) {
        
        
        
      $query = " update users set profilepic= '$path' where id=$userid";
      //die($query);
        $id = self::execquery_id($query);
        return $id;
    } 
  

      public static function insertresetpassword($email) {
        
        $table_name='password_tokens';
        
        $token = md5(uniqid(rand(), true));
        $datetoday = time();
        $end_date=date('Y-m-d H:i:s', strtotime('+1 day', $datetoday));
        
        $form_data=array('token'=>$token,'email'=>$email,'used'=>0,'extime'=>$end_date);
        $fields = array_keys($form_data);
        
        
        $query = "INSERT INTO ".$table_name."
        (`".implode('`,`', $fields)."`)
        VALUES('".implode("','", $form_data)."')";
    
        //$query = "select id  from companies where email='$email'";
         $id = self::execquery_id($query);
         if($id>0)
         {
             return $token;
         }
    }

    /*
	 *
	 *All Function need to users 
	 */
    public static function loginuser($email, $password) {
        $query = "select id  from users where email='$email' and password='$password'";
        //  $result = self::execquery($query);
        //echo  $query ;
        $id = 0;
        $result = self::execquery($query);
        if ($result) {
            if ($result->num_rows > 0) {
                $obj = mysqli_fetch_object($result);
                $id = $obj->id;
				if(isset($_COOKIE[self::$cookieID])){
					$cookID=$_COOKIE[self::$cookieID];
					$query="UPDATE session_users SET user_id='$id' WHERE id='$cookID'";
					self::execquery($query);
					//echo$query;
				}
            }
        }



        if ($id <= 0) {
               $errorMessage= self::$emailnotexsist_message;
            include 'views/message/error_message.php';
        }


        return $id;
    }


    public static function ajaxbalance() {
							 global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
        $query = "SELECT
					users.opportunities,
					users.projects,
					users.balance,
					users.offers
					from users where id=$myuser_id
					";
					

        //  $result = self::execquery($query);
        //echo  $query ;
       
        $result = self::execquery($query);
        if ($result) {
            if ($result->num_rows > 0) {
                $obj = mysqli_fetch_object($result);
             //   $id = $obj->id;
            }
        }


        return $obj;
    }



    public static function getuserdetails($user_id) {
     
        $company = array();
        $gives = array();
        $services = array();
		
        $query = "select users.*,country.`code` as countrycode,country.`arab_name` as countryname,states.`arab_name` as statename,cities.`arab_name` as cityname,balance,provide_cosultation_list,need_cosultation_list
		             ,provide_agent_list,need_agent_list,provide_product_list,need_product_list,worked_country_list from users 
		          left outer join country on country.id=users.country
				  left outer join states on states.id=users.states
				    left outer join cities on cities.id=users.cities
				  left outer join userdetails on userdetails.user_id=users.id 
				  where users.id=$user_id";
      
	  
        $result = self::execquery($query);
        if ($result) {
           
            $obj = $result->fetch_object();
			$obj->id=self::$encryption->encode($obj->id);
         // echo self::$encryption->encode(33);
            // echo $obj->companyname;
            //if (!file_exists($obj->profilepic)){$obj->profilepic="assets/img/none.png";}
            
         $user = array('id' => self::$encryption->encode($obj->id),
                'name' => $obj->name,
                'phone' => $obj->phone,
                'email' => $obj->email,
                'password' => $obj->password,
                
                'countrycode' => $obj->country,
                'identification' => $obj->identification,
                'website' => $obj->website,
               
                'facebook' => $obj->facebook,
                'twitter' => $obj->twitter,
                'linkedin' => $obj->linkedin,
                'google' => $obj->google,
                'instagram' => $obj->instagram,
                'isactive'=>$obj->isactive,
				'pio'=>$obj->pio,
                'email' => $obj->email,
                'profilepic' => $obj->profilepic,
				
                'mailref' => $obj->mailref,
                 'ispay' => $obj->ispay,
                'login_type' => $obj->login_type,
                'accountstatus' => $obj->accountstatus,
                'sevicetime' => $obj->servicetime,
				//'sevicetime' => $obj->servicetime,
             
            );
			if (!file_exists($obj->profilepic)){
					$obj->profilepic="assets/uploads/profile/none.png";
					self::updateuserpfile($obj->profilepic,$obj->id);
					}
        }

     
        return $obj;
    }



    public static function getallusers($condition="") {
     
        $users = array();
      
        $query = "select users.*,country.`code` as countrycode,country.`arab_name` as countryname,balance,provide_cosultation_list,need_cosultation_list
		             ,provide_agent_list,need_agent_list,provide_product_list,need_product_list,worked_country_list from users 
		          left outer join country on country.id=users.country
				  left outer join userdetails on userdetails.user_id=users.id 
				  where 1 $condition ";
      
	  //echo  $query;
        $result = self::execquery($query);
        if ($result) {
           
           while ($obj = $result->fetch_object()) {
         // echo self::$encryption->encode(33);
            // echo $obj->companyname;
            //if (!file_exists($obj->profilepic)){$obj->profilepic="assets/img/none.png";}
            
         $user = array('id' => self::$encryption->encode($obj->id),
                'name' => $obj->name,
                'phone' => $obj->phone,
                'email' => $obj->email,
                'countrycode' => $obj->country,
                'identification' => $obj->identification,
                'website' => $obj->website,
                'facebook' => $obj->facebook,
                'twitter' => $obj->twitter,
                'linkedin' => $obj->linkedin,
                'google' => $obj->google,
                'instagram' => $obj->instagram,
                'isactive'=>$obj->isactive,
				'pio'=>$obj->pio,
                'profilepic' => $obj->profilepic,
                'mailref' => $obj->mailref,
                 'ispay' => $obj->ispay,
                'login_type' => $obj->login_type,
                'provide_cosultation_list' => $obj->provide_cosultation_list,
				'need_cosultation_list' => $obj->need_cosultation_list,
				'provide_agent_list' => $obj->provide_agent_list,
				'need_agent_list' => $obj->need_agent_list,
				'provide_product_list' => $obj->provide_product_list,
				'need_product_list' => $obj->need_product_list,
				'worked_country_list' => $obj->worked_country_list,
				'job_title' => $obj->job_title,
				'countryname' => $obj->countryname,
				'projects' => $obj->projects,
            );
			if (!file_exists($obj->profilepic)){
					$obj->profilepic="assets/uploads/profile/none.png";
					self::updateuserpfile($obj->profilepic,$obj->id);
					}
					 array_push($users, $user);
		   }
        }

     
        return $users;
    }

	
	 public static function adduserdetails($user_id,$parameters)
	 
	 {
		  $keys = "";
        $values = "";
		$updatevalues="";
		 foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';
			
	        if ($type == 'string') {

                $values = $values . "'$value'" . ',';
				$updatevalues =$updatevalues. $key ."=" . "N'$value'" . ',';
            } else {
                $values = $values . $value . ',';
				$updatevalues = $updatevalues . $key ."=" . $value . ',';
				
            }
			
			
		}
		
		  $keys = $keys . 'user_id' . ',';
		  $values = $values . "$user_id" . ',';
		  
		    if ( self::isexesituserdetails($user_id)===TRUE)
               {
                    //update
					$query = " update userdetails set " . substr($updatevalues, 0, -1)  .
                " where user_id=$user_id";
               }
			   else
			   {
				   //insert 
                 $query = "insert into userdetails (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
				   
			   }
       // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;
       
	 }
	


		
	 public static function updateuser($user_id,$parameters)
	 
	 {
		$keys = "";
        $values = "";
		$updatevalues="";
		 foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';
			
	        if ($type == 'string') {

               
				$updatevalues =$updatevalues. $key ."=" . "N'$value'" . ',';
            } else {
               
				$updatevalues = $updatevalues . $key ."=" . $value . ',';
				
            }
			
			
		}
		

                    //update
					$query = " update users set " . substr($updatevalues, 0, -1)  .
                " where id=$user_id";
              
       // echo $query ;
		$result = self::execquery($query);
	//	echo self::$success_message;
	$errorMessage=  self::$success_edit;
                    include 'views/message/success_message.php';
		
       
	 }


	public static function getuserownerphone($src_user_id,$user_id)
	{
		   global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			
			$query = "select phone from users where id=$src_user_id ";
			 //echo $query;
             $phone="";
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   $phone=$obj->phone;
				   self::addownerphonelog($src_user_id,$user_id,'user');
				   
			 }
			 return $phone;
		
	}
	
		public static function check_userownerphone($src_user_id,$user_id)
	{
		  
		global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			 $query = "select Count(src_id) as count_1  from show_owner_phone where  src_id=$src_user_id and user_id=$myuser_id and expiredate>=NOW() and type='user' ";
			 //echo  $query;

		    $phone="";
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1>0){
					  
					  $query = "select phone from users where id=$src_user_id ";
			 //echo $query;
					 
					 $result=self::execquery($query);
					 if ($result) {
						   $obj = $result->fetch_object();
						   $phone=$obj->phone;
						   
						   
					 }
					 
				   }
				   
			 }
			 
			 
			
			 return $phone;
		
	}
	
	

		
		
	public static function  addownerphonelog($src_user_id,$user_id,$type)
		{ 
		
		global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			 $query = "select Count(src_id) as count_1  from show_owner_phone where  src_id=$src_user_id and user_id=$myuser_id and expiredate>=NOW() and type='$type'";
			 
//echo  $query;
		
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1==0){
					  //echo $myuser_id;
			           if ($src_user_id!=$myuser_id){
						   if ($type=='project'){
						   $user_expired_after= self::$project_expired_after;
						  $user_credit =self::$project_credit;
						   }
					      elseif($type=='user'){
						   $user_expired_after= self::$user_expired_after;
						   $user_credit =self::$user_credit;
						   }
						  elseif($type=='opportunity'){
						    $user_expired_after= self::$opportunity_expired_after;
						    $user_credit =self::$opportunity_credit;
						   }
						   elseif($type=='message'){
						    $user_expired_after= self::$message_expired_after;
						    $user_credit =self::$message_credit;
						   }
						   elseif($type=='offer'){
						    $user_expired_after= self::$message_expired_after;
						    $user_credit =self::$message_credit;
						   }
						  
					      $query = "insert into show_owner_phone set src_id=$src_user_id ,user_id=$myuser_id ,type='$type',amount='$user_credit',expiredate=DATE_ADD(NOW(),INTERVAL $user_expired_after DAY)";
						 
			              $result=self::execquery($query);
						 
						   self::updateuserbalance($myuser_id,-1*$user_credit);
						 }
				   }
				   
			 }
		
		}
		
	 

	 public static function updateuserbalance($user_id,$balance)
	 
	 {
	

                    //update
					$query = " update users set balance=ifnull(balance,0)+$balance  where id=$user_id";
              
       // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;
		
       
	 }
  


	 public static function userscounter()
	 
	 {
	$query = "SELECT  CAST(businessman + (allusers-businessman-investor)* 0.4 AS DECIMAL(0))   as businessman
			,CAST(investor + (allusers - businessman-investor)* 0.6 AS DECIMAL(0)) as investor
			 , consaltant,projects,offers ,articles,opportunities from (
			select 
			(select count('x') from users  ) as allusers
			,(select count('x') from users where isbusinessman =1 ) as  businessman
					,(select count('x') from users where isconsaltant =1 ) as consaltant
					
					,(select count('x') from users where isinvestor =1 ) as investor
					,(select count('x') from projects where IFNULL(deleted,0) =0 and IFNULL(projects.pending,0)=0 ) as projects
					,(select count('x') from offers where IFNULL(deleted,0) =0 and IFNULL(offers.pending,0)=0 )  as offers
					,(select count('x') from articles  ) as articles
					,(select count('x') from opportunities where IFNULL(deleted,0) =0 ) as opportunities) as xx
		";
		
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   
			 }
         return  $obj;
		
       
	 }
	 

	 
  

  public static function updateuserprojects($user_id,$count)
	 
	 {
	

                    //update
					$query = " update users set projects=ifnull(projects,0)+$count  where id=$user_id";
              
      // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;
		

	 } 
	 public static function updateuseroffers($user_id,$count)
	 
	 {
	

                    //update
					$query = " update users set offers=ifnull(offers,0)+$count  where id=$user_id";
              
      // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;
		

	 }
	 	 public static function updateoffer_code($verified_code,$id)
	 
	 {
					$query = " update offers set verified_code=$verified_code  where id=$id";
              
      // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;
		

	 }
	 
	 public static function updateproject_code($verified_code,$id)
	 
	 {
					$query = " update projects set verified_code=$verified_code  where id=$id";
              
      // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;
		

	 }
	public static function verifie_offer($id,$verified_code)
	 
	 {
	  // $id=self::$encryption->decode($id);
		 
		 $query = "select id  from offers where id='$id' and verified_code='$verified_code'";
		// echo  $query;
        $result = self::execquery($query);

        if ($result) {
            if ($result->num_rows > 0) {
			$obj=$result->fetch_object();
			$en=new APIEncryption();
				$ob=new objects();
				$postData=[
						'messageTitle'=>'تم أضافة عرض جملة جديد',
						//'messageImageURL'=>'http://mooga.com/'.$obj->picpath,
						'messageImageURL'=>'https://www.mooga.com/notifiction.png',
						'messageContent'=>$ob->__html($obj->description,30,array('html' => false)),
						'messageLink'=>'https://mooga.com/?page=singleoffer&pid='.self::$encryption->encode($obj->id),
				];
				$en->sendRequest($postData,'sendNotifications');
                  $query = " update offers set pending=0  where id=$id";
					$result = self::execquery($query);
					
					  $errorMessage=  self::$success_validate;;
                    include 'views/message/success_message.php';
            }else
			{
			
				  $errorMessage=  self::$error_validate;;
                    include 'views/message/error_message.php';
				
			}
        }
		

	 }
	 
	 
	 	public static function change_offer($id,$country_code,$contact_name,$contact_type,$contact_email,$contact_phone)
	 
	 {
	  // $id=self::$encryption->decode($id);
		 
		 $query = "select id  from offers where id='$id' and contact_name='$contact_name' and ifnull(contact_email,'')='$contact_email' and ifnull(contact_phone,'')='$contact_phone'";
		// echo  $query;
        $result = self::execquery($query);

        if ($result) {
            if ($result->num_rows > 0) {
                   $errorMessage=  self::$error_validate1;
                    include 'views/message/error_message.php';
            }else
			{
				
				$contact_phone = ltrim($contact_phone, '0');
			   $query = " update offers set country_1='$country_code',contact_name='$contact_name'
              			   ,contact_type='$contact_type' ,contact_phone='$contact_phone' ,contact_email='$contact_email' where id=$id";
					$result = self::execquery($query);
					
					$query = "select verified_code  from offers where id='$id' ";
		         // echo  $query;
                    $result = self::execquery($query);
					$obj = $result->fetch_object();
					$verified_code=$obj->verified_code;
					 if ($contact_type==1){
					   self::sendsms($country_code.$contact_phone,$verified_code);
					   }else
					   {
							self::sendemail($contact_email,$verified_code,'verifyoffer');
					   }
								
					  $errorMessage=  self::$success_validate1;
                    include 'views/message/success_message.php';
				 
				
			}
        }
		

	 }
	 
	 

	 
	 	public static function change_project($id,$country_code,$contact_name,$contact_type,$contact_email,$contact_phone)
	 
	 {
	  // $id=self::$encryption->decode($id);
		 
		 $query = "select id  from projects where id='$id' and contact_name='$contact_name' and ifnull(contact_email,'')='$contact_email' and ifnull(contact_phone,'')='$contact_phone'";
		 //echo  $query;
        $result = self::execquery($query);

        if ($result) {
            if ($result->num_rows > 0) {
                   $errorMessage=  self::$error_validate1;
                    include 'views/message/error_message.php';
            }else
			{
				
				$contact_phone = ltrim($contact_phone, '0');
			   $query = " update projects set country_1='$country_code',contact_name='$contact_name'
              			   ,contact_type='$contact_type' ,contact_phone='$contact_phone' ,contact_email='$contact_email' where id=$id";
					$result = self::execquery($query);
					
					$query = "select verified_code  from projects where id='$id' ";
		         // echo  $query;
                    $result = self::execquery($query);
					$obj = $result->fetch_object();
					$verified_code=$obj->verified_code;
					 if ($contact_type==1){
					   self::sendsms($country_code.$contact_phone,$verified_code);
					   }else
					   {
							self::sendemail($contact_email,$verified_code,'verifyproject');
					   }
								
					  $errorMessage=  self::$success_validate1;
                    include 'views/message/success_message.php';
				 
				
			}
        }
		

	 }
	 
	 
	 
	 
	 	public static function verifie_project($id,$verified_code)
	 
	 {
	  // $id=self::$encryption->decode($id);

		 $query = "select *  from projects where id='$id' and verified_code='$verified_code'";
		//echo  $query;
        $result = self::execquery($query);

        if ($result) {
            if ($result->num_rows > 0) {
				$obj=$result->fetch_object();
				if (!file_exists($obj->picpath)) {
					$obj->picpath = "assets/uploads/projects/none.png";
				}
				$en=new APIEncryption();
				$ob=new objects();
				$postData=[
						'messageTitle'=>' تم أضافة مشروع جديد : '.$obj->name,
						//'messageImageURL'=>'http://mooga.com/'.$obj->picpath,
						'messageImageURL'=>'https://www.mooga.com/notifiction.png',
						'messageContent'=>$ob->__html($obj->description,30,array('html' => false)),
						'messageLink'=>'https://mooga.com/?page=singleproject&pid='.self::$encryption->encode($obj->id),
				];
				$en->sendRequest($postData,'sendNotifications');
                  $query = " update projects set pending=0  where id=$id";
					$result = self::execquery($query);
					  $errorMessage=  self::$success_validate;;
                    include 'views/message/success_message.php';

            }else
			{
			
				  $errorMessage=  self::$error_validate;;
                    include 'views/message/error_message.php';
				
			}
        }

	 }
	    public static function updateuseropportunities($user_id,$balance)
	 
	 {
	

                    //update
					$query = " update users set opportunities=ifnull(opportunities,0)+$balance  where id=$user_id";
              
       // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;
		
       
	 }
	

	
	
	
	
	
	
	/*projects method*/
	
	    public static function addproject($user_id,$parameters) {
        $keys = "";
        $values = "";
          $contact_phone="";
			  $contact_email="";
			  $contact_type="";
			  $country_1="";
        //die('my current session is '.$currentsource);
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
			
			if ($key=='contact_phone'){ $value = ltrim($json->value, '0');}
            $keys = $keys . $key . ',';
                    
		
		  if ($key=='contact_phone'){$contact_phone=$value;}
		  
		  if ($key=='country_1'){$country_1=$value;}
		   if ($key=='contact_type'){$contact_type=$value;}
		   if ($key=='contact_email'){$contact_email=$value;}
            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
		$keys = $keys .  'user_id,';
		$values = $values . $user_id . ',';
		
        $query = "insert into projects (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
	
		//	echo  $query;
        $id = self::execquery_id($query);
			echo$query;
		if ($id>0)
		{
		  self::updateuserprojects($user_id,1);
		  
		  $verified_code=  self::getverified_code();
		   self::updateproject_code($verified_code,$id);
		   if ($contact_type==1){
		   self::sendsms($country_1.$contact_phone,$verified_code);
		   }else
		   {
			    self::sendemail($contact_email,$verified_code,'verifyproject');
		   }
		}
		
	      $errorMessage=  self::$success_add;;
                    include 'views/message/success_message.php';
        /*add record to crm*/
      // self::transferdatatocrmbyid($id);
        
        return $id;
    }

	
	
	
	   public static function updateproject($project_id,$user_id,$parameters) {
        $keys = "";
        $values = "";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
			
            $type = $json->type;
			if ($key=='contact_phone'){ $value = ltrim($json->value, '0');}
            //$keys = $keys . $key . ',';
            

            if ($type == 'string') {

                $values =$values. $key ."=" . "N'$value'" . ',';
            } else {
                 $values = $values . $key ."=" . $value . ',';
            }
           
        }
       
        $query = " update projects set " . substr($values, 0, -1)  .
                " where user_id=$user_id and id=$project_id";
     
        $result = self::execquery($query);
       	 $errorMessage=  self::$success_edit;;
          include 'views/message/success_message.php';
        return $result;
    }

	public function getUserRelatedOffers($userID){
		$offers=[];
		$query="
select offers.*,users.`id` AS userid,users.`name` as username,users.`job_title` as job_title,users.country as usercountry,users.companyname ,users.profilepic ,
				 country.`arab_name` as offer_country,states.`name` as offer_states,cities.`name` as offer_cities
				 ,item_type.`name` as item_type_name  ,item_brand.`name` as item_brand_name  ,item_names.`name` as item_names_name
				 ,country_1.`name`  as user_country ,users.id as user_id
			      from offers

			INNER JOIN users on users.id=offers.user_id
            LEFT JOIN country on country.id=offers.country
			LEFT JOIN states on states.id=offers.states
			LEFT JOIN cities on cities.id=offers.cities
			LEFT JOIN item_type on item_type.id=offers.item_type
			LEFT JOIN item_brand on item_brand.id=offers.item_brand
			LEFT JOIN item_names on item_names.id=offers.name
            LEFT JOIN country as country_1 on country_1.id=users.country
             WHERE `offer_type_filed`IN(SELECT `offer_type_filed`.`name` FROM `offer_views` INNER JOIN `offers` on `offers`.id=`offer_views`.`offer_id` INNER JOIN `offer_type_filed` on `offer_type_filed`.`name`=`offers`.`offer_type_filed` WHERE `offer_views`.`user_id`='$userID' GROUP BY `offer_type_filed`.`id` ) AND pending='0' GROUP BY offers.offer_type_filed limit 0,6
";
		$result = self::execquery($query);
		if ($result) {
			while ($obj = $result->fetch_object()) {
				$file= $obj->picpath ;
				if (!file_exists($file)){$obj->picpath= self::$picpath;}
				$offers []= (object)[
						'id' => self::$encryption->encode($obj->id),
						'picpath' =>$obj->picpath,
						'name' => $obj->name,
						'usercountry' => $obj->usercountry,
						'description' => $obj->description,
						'offer_type_filed' => $obj->offer_type_filed,
						'views' => $obj->views,
						'offer_country' => $obj->offer_country,
						'username' => $obj->username,
						'profilepic' => $obj->profilepic,
						'item_type_name' => $obj->item_type_name,
						'item_brand_name' => $obj->item_brand_name,
						'item_names_name' => $obj->item_names_name,
						'pending' => $obj->pending,
						'userid' => self::$encryption->encode($obj->userid),
				];
			}
		}
		return (object)$offers;
	}
	public function checkOfferDuplicated(){
		$offer_type_filed=post('offer_type_filed');
		$name=post('name');
		$item_type=post('item_type');
		$item_brand=post('item_brand');
		$description=post('description');
		$query="SELECT count(id) AS count FROM offers WHERE offer_type_filed LIKE '%$offer_type_filed%' AND name='$name' AND item_type='$item_type' AND item_brand='$item_brand' AND description LIKE'%$description%'";
		//echo$query.'<br>';
		$result=self::execquery($query);
		$obj=$result->fetch_object();
		//echo$obj->count;
		if($obj->count>0){
			$errorMessage=self::$existData;
			include 'views/message/error_message.php';
			return true;
		}
		return false;
	}
	public function checkProjectsDuplicated(){
		$name=post('name');
		$project_type=post('project_type');
		$project_field=post('project_field');
		$description=post('description');
		$query="SELECT count(id) AS count FROM projects WHERE name LIKE '%$name%' AND project_type_list LIKE '%$project_type%' AND project_field_list LIKE '%$project_field%' AND description LIKE'%$description%'";
		//echo$query.'<br>';
		$result=self::execquery($query);
		$obj=$result->fetch_object();
		//echo$obj->count;
		if($obj->count>0){
			$errorMessage=self::$existData;
			include 'views/message/error_message.php';
			return true;
		}
		return false;
	}
	public function getUserRelatedProjects($userID){
		$projects=[];
		$query="
select projects.*,users.`name` as username,users.`id` as userid,users.country as usercountry,users.companyname,users.job_title ,users.profilepic ,
				  country.`arab_name` as project_country,states.`arab_name` as project_states,cities.`arab_name` as project_cities ,country_1.`name`  as user_country ,users.id as user_id
			       FROM `projects`
INNER JOIN users on users.id=projects.user_id
            LEFT JOIN country on country.id=projects.country
			 LEFT JOIN states on states.id=projects.states
			  LEFT JOIN cities on cities.id=projects.cities
            LEFT JOIN country as country_1 on country_1.id=users.country
             WHERE `project_field_list`IN(SELECT CONCAT('\"',`project_field`.`name`,'\"') FROM `project_views` INNER JOIN `projects` on `projects`.id=`project_views`.`project_id` INNER JOIN `project_field` on `project_field`.`name`=Replace(`projects`.`project_field_list`,'\"','') WHERE `project_views`.`user_id`='$userID' GROUP BY `project_field`.`id` ) AND pending='0' GROUP BY projects.project_field_list limit 0,6
";
		$result = self::execquery($query);
		if ($result) {
			while ($obj = $result->fetch_object()) {
				$file= $obj->picpath ;
				if (!file_exists($file)){$obj->picpath= self::$picpath;}
				$projects []= (object)[
						'id' => self::$encryption->encode($obj->id),
						'picpath' =>$obj->picpath,
						'name' => $obj->name,
						'usercountry' => $obj->usercountry,
						'description' => $obj->description,
						'views' => $obj->views,
						'stage_list' => json_decode($obj->stage_list),
						'project_country' => $obj->project_country,
						'project_type_list' => str_replace('"','',$obj->project_type_list) ,
						'project_field_list' => str_replace('"','',$obj->project_field_list),
						'username' => $obj->username,
						'profilepic' => $obj->profilepic,
						'userid' => self::$encryption->encode($obj->userid),
						'pending' => $obj->pending,
				];
			}
		}
		return (object)$projects;
	}
	
	
	
    public static function getsingleproject($project_id,$addView=true) {
        $company = array();
        $gives = array();
        $services = array();
		
        $query = "select projects.*,users.`name` as username,users.`id` as userid,users.country as usercountry,users.companyname,users.job_title ,users.profilepic ,
				  country.`arab_name` as project_country,states.`arab_name` as project_states,cities.`arab_name` as project_cities ,country_1.`name`  as user_country ,users.id as user_id
			      from projects

			INNER JOIN users on users.id=projects.user_id
            LEFT JOIN country on country.id=projects.country
			 LEFT JOIN states on states.id=projects.states
			  LEFT JOIN cities on cities.id=projects.cities
            LEFT JOIN country as country_1 on country_1.id=users.country
						where projects.id=$project_id";
      
	  //echo         $query;
        $result = self::execquery($query);
        if ($result) {
			if($addView){
				self::addprojectviewlog($project_id);
			}
            $obj = $result->fetch_object();
			 $obj->user_id=self::$encryption->encode($obj->user_id);
			  $obj->id=self::$encryption->encode($obj->id);
			 
         // echo self::$encryption->encode(33);
            // echo $obj->companyname;
			$shareimage='http://mooga.com/'.$obj->picpath;
            if (!file_exists($obj->picpath)){
				$obj->picpath="assets/uploads/projects/none.png";
				$shareimage="http://mooga.com/assets/uploads/projects/projects.png";
				}
			$facebook=new StdClass();
			$facebook->image=$shareimage;
			$facebook->description=$obj->description;
             $obj->facebook=$facebook;
			 
         $project = (object)array('id' => self::$encryption->encode($project_id),
                'name' => $obj->name,
                'userid' => self::$encryption->encode($obj->userid),
                'job_title' => $obj->job_title,
                'done' => $obj->done,
                'user_country' => $obj->user_country,
                'profilepic' => $obj->profilepic,
                'user_id' =>self::$encryption->encode($obj->userid),
                'needbuyer' =>$obj->needbuyer,
                'needfunder' =>$obj->needfunder,
                'project_country' =>$obj->project_country,
                'project_states' =>$obj->project_states,
                'project_cities' =>$obj->project_cities,
                'needdescription' =>$obj->needdescription,
                'picpath' =>$obj->picpath,
                'project_type_list' => $obj->project_type_list,
                'project_field_list' => $obj->project_field_list,
                'description' => $obj->description,
                'createdtime' => $obj->createdtime,

                'country' => $obj->country,
                'stage_list' => $obj->stage_list,
                'project_product_list' => $obj->project_product_list,
               
                'project_service_list' => $obj->project_service_list,
                'needagent' => $obj->needagent,
                'needpartner' => $obj->needpartner,
                'needclose' => $obj->needclose,
                'closedescription' => $obj->closedescription,
                
                'views'=>$obj->views,
                'facebook'=>$obj->facebook,
				'username'=>$obj->username,
                'usercountry' => $obj->usercountry,
                'companyname' => $obj->companyname,
               
             
            );
        }

     
        return $project;
    }

	   public static function getsingleoffer($offer_id,$addView=true) {
     
      
		
        $query = "select offers.*,users.`name` as username,users.`id` as userid,users.`job_title` as job_title,users.country as usercountry,users.companyname ,users.profilepic ,
				 country.`arab_name` as offer_country,states.`name` as offer_states,cities.`name` as offer_cities  
				 ,item_type.`name` as item_type_name  ,item_brand.`name` as item_brand_name  ,item_names.`name` as item_names_name 
				 ,country_1.`name`  as user_country ,users.id as user_id
			      from offers

			INNER JOIN users on users.id=offers.user_id
            LEFT JOIN country on country.id=offers.country
			LEFT JOIN states on states.id=offers.states
			LEFT JOIN cities on cities.id=offers.cities
			LEFT JOIN item_type on item_type.id=offers.item_type
			LEFT JOIN item_brand on item_brand.id=offers.item_brand
			LEFT JOIN item_names on item_names.id=offers.name
            LEFT JOIN country as country_1 on country_1.id=users.country
						where offers.id=$offer_id";
      
	  //echo         $query;
        $result = self::execquery($query);
        if ($result) {
           
			if($addView){
				self::addofferviewlog($offer_id);
			}

            $obj = $result->fetch_object();
			 $obj->user_id=self::$encryption->encode($obj->user_id);
			  $obj->id=self::$encryption->encode($obj->id);
			 
         // echo self::$encryption->encode(33);
            // echo $obj->companyname;
			$shareimage='http://mooga.com/'.$obj->picpath;
            if (!file_exists($obj->picpath)){
				$obj->picpath="assets/uploads/offers/none.png";
				$shareimage="http://mooga.com/assets/uploads/offers/offers.png";
				}
			$facebook=new StdClass();
			$facebook->image=$shareimage;
			$facebook->description=$obj->description;
             $obj->facebook=$facebook;
		
        }

     
        return $obj;
    }


	
	
	
	public static function getuserprojects($user_id) {
	
	 $allprojects = array();
        $query = "select projects.*,users.`name` as username,country.name as usercountry,users.companyname,project_stage.name as stage_name,
					country2.arab_name as project_country
					 from projects 
					INNER JOIN users on users.id=projects.user_id
					 LEFT JOIN  country on country.id=users.country 
					 	LEFT JOIN  country as country2 on country2.id=projects.country 
					LEFT JOIN  project_stage on projects.stage=project_stage.id where projects.user_id=$user_id";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = array('id' => $obj->id,
                    'name' => $obj->name,
					'usercountry' => $obj->usercountry,
					'description' => $obj->description,
					'project_field_list' => $obj->project_field_list,
					'views' => $obj->views,
					'stage_name' => $obj->stage_name,
					'project_country' => $obj->project_country,
					'username' => $obj->username,
					);
                array_push($allprojects, $element);
            }
        }

        return $allprojects;
		
		
     
        
    }
	
	
	public static function getallprojects() {
	
	 $allprojects = array();
        $query = "select projects.*,users.`name` as username,country.arab_name as usercountry,users.companyname,project_stage.name as stage_name,
					country2.arab_name as project_country
								 from projects 
								INNER JOIN users on users.id=projects.user_id
								 LEFT JOIN  country on country.id=users.country 
						LEFT JOIN  country as country2 on country2.id=projects.country 
								LEFT JOIN  project_stage on projects.stage=project_stage.id ";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = array('id' => $obj->id,
                    'name' => $obj->name,
					'usercountry' => $obj->usercountry,
					'description' => $obj->description,
					'project_field_list' => $obj->project_field_list,
					'views' => $obj->views,
					'stage_name' => $obj->stage_name,
					'project_country' => $obj->project_country,
					'username' => $obj->username,
                                        'createdtime' => $obj->createdtime,
					);
                array_push($allprojects, $element);
            }
        }

        return $allprojects;
		
		
     
        
    }
	
	
	
	public static function getalloffers_search($condition="") {
	
	 $alloffers = array();
        $query = "select offers.*,users.`id` as userid,users.`name` as username,country.arab_name as usercountry,users.companyname,
					country2.arab_name as offer_country,users.profilepic ,item_type.`name` as item_type_name  ,item_brand.`name` as item_brand_name  ,item_names.`name` as item_names_name 
								 from offers 
								INNER JOIN users on users.id=offers.user_id
								 LEFT JOIN  country on country.id=users.country 
								 LEFT JOIN item_type on item_type.id=offers.item_type
			LEFT JOIN item_brand on item_brand.id=offers.item_brand
			LEFT JOIN item_names on item_names.id=offers.name
						LEFT JOIN  country as country2 on country2.id=offers.country 
								 where 1 and IFNULL(offers.deleted,0)=0 ".$condition ;
	//echo  ($query) ;
	
	
      
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
				$file= $obj->picpath ;
              if (!file_exists($file)){$obj->picpath= self::$picpathoffer;}
                $element = array('id' => self::$encryption->encode($obj->id), 
				    'picpath' =>$obj->picpath,
                    'name' => $obj->name,
                    'done' => $obj->done,
					'usercountry' => $obj->usercountry,
					'description' => $obj->description,
					'offer_type_filed' => $obj->offer_type_filed,
					'views' => $obj->views,
					'offer_country' => $obj->offer_country,
					'username' => $obj->username,
					'profilepic' => $obj->profilepic,
					'item_type_name' => $obj->item_type_name,
					'item_brand_name' => $obj->item_brand_name,
					'item_names_name' => $obj->item_names_name,
					'pending' => $obj->pending,
					'userid' => self::$encryption->encode($obj->userid),
					
					);
                array_push($alloffers, $element);
            }
        }

        return $alloffers;
		
		
     
        
    }
	public static function getalloffers_searchRelated($userID,$condition="") {

		$alloffers = array();
		$query = "select offers.*,users.`id` AS userid,users.`name` as username,users.`job_title` as job_title,users.country as usercountry,users.companyname ,users.profilepic ,
				 country.`arab_name` as offer_country,states.`name` as offer_states,cities.`name` as offer_cities
				 ,item_type.`name` as item_type_name  ,item_brand.`name` as item_brand_name  ,item_names.`name` as item_names_name
				 ,country_1.`name`  as user_country ,users.id as user_id
			      from offers

			INNER JOIN users on users.id=offers.user_id
            LEFT JOIN country on country.id=offers.country
			LEFT JOIN states on states.id=offers.states
			LEFT JOIN cities on cities.id=offers.cities
			LEFT JOIN item_type on item_type.id=offers.item_type
			LEFT JOIN item_brand on item_brand.id=offers.item_brand
			LEFT JOIN item_names on item_names.id=offers.name
            LEFT JOIN country as country_1 on country_1.id=users.country
             WHERE `offer_type_filed`IN(SELECT `offer_type_filed`.`name` FROM `offer_views` INNER JOIN `offers` on `offers`.id=`offer_views`.`offer_id` INNER JOIN `offer_type_filed` on `offer_type_filed`.`name`=`offers`.`offer_type_filed` WHERE `offer_views`.`user_id`='$userID' GROUP BY `offer_type_filed`.`id` ) AND pending='0' ".$condition ;
		//echo  ($query) ;



		$result = self::execquery($query);
		if ($result) {

			while ($obj = $result->fetch_object()) {
				$file= $obj->picpath ;
				if (!file_exists($file)){$obj->picpath= self::$picpathoffer;}
				$element = array('id' => self::$encryption->encode($obj->id),
						'picpath' =>$obj->picpath,
						'name' => $obj->name,
						'usercountry' => $obj->usercountry,
						'description' => $obj->description,
						'offer_type_filed' => $obj->offer_type_filed,
						'views' => $obj->views,
						'offer_country' => $obj->offer_country,
						'username' => $obj->username,
						'profilepic' => $obj->profilepic,
						'item_type_name' => $obj->item_type_name,
						'item_brand_name' => $obj->item_brand_name,
						'item_names_name' => $obj->item_names_name,
						'pending' => $obj->pending,
						'userid' => self::$encryption->encode($obj->userid),

				);
				array_push($alloffers, $element);
			}
		}

		return $alloffers;




	}
	
	
	public static function successProjectDeal($projectid,$userid){
		$query="UPDATE projects set done='1' WHERE id='$projectid' AND user_id='$userid'";
		self::execquery($query);
	}
	public static function successOfferDeal($offerid,$userid){
		$query="UPDATE offers set done='1' WHERE id='$offerid' AND user_id='$userid'";
		self::execquery($query);
	}
	public static function getallprojects_search($condition="") {
		//$query="ALTER TABLE `projects` ADD `done` INT NOT NULL AFTER `needdescription`;";
		//self::execquery($query);
	 $allprojects = array();
        $query = "select projects.*,users.`id` as userid,users.`name` as username,country.arab_name as usercountry,users.companyname,
					country2.arab_name as project_country,users.profilepic
								 from projects
								INNER JOIN users on users.id=projects.user_id
								 LEFT JOIN  country on country.id=users.country
						LEFT JOIN  country as country2 on country2.id=projects.country
								 where 1 and IFNULL(projects.deleted,0)=0   ".$condition ;
	//echo  ($query) ;
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
				$file= $obj->picpath ;
              if (!file_exists($file)){$obj->picpath= self::$picpath;}
                $element = array('id' => self::$encryption->encode($obj->id), 
				    'picpath' =>$obj->picpath,
                    'name' => $obj->name,
					'usercountry' => $obj->usercountry,
					'description' => $obj->description,
					'views' => $obj->views,
					'stage_list' => json_decode($obj->stage_list),
					'project_country' => $obj->project_country,
					'project_type_list' => str_replace('"','',$obj->project_type_list) ,
					'project_field_list' => str_replace('"','',$obj->project_field_list),
					'username' => $obj->username,
					'profilepic' => $obj->profilepic,
					'userid' => self::$encryption->encode($obj->userid),
					'done' => $obj->done,
					'pending' => $obj->pending,
                                          'createdtime' => $obj->createdtime,
					);
                array_push($allprojects, $element);
            }
        }

        return $allprojects;
		
		
     
        
    }
	public static function getallprojects_searchRelated($userID,$condition="") {

		$allprojects = array();
		$query = "select projects.*,users.`name` as username,users.`id` as userid,users.country as usercountry,users.companyname,users.job_title ,users.profilepic ,
				  country.`arab_name` as project_country,states.`arab_name` as project_states,cities.`arab_name` as project_cities ,country_1.`name`  as user_country ,users.id as user_id
			       FROM `projects`
INNER JOIN users on users.id=projects.user_id
            LEFT JOIN country on country.id=projects.country
			 LEFT JOIN states on states.id=projects.states
			  LEFT JOIN cities on cities.id=projects.cities
            LEFT JOIN country as country_1 on country_1.id=users.country
             WHERE `project_field_list`IN(SELECT CONCAT('\"',`project_field`.`name`,'\"') FROM `project_views` INNER JOIN `projects` on `projects`.id=`project_views`.`project_id` INNER JOIN `project_field` on `project_field`.`name`=Replace(`projects`.`project_field_list`,'\"','') WHERE `project_views`.`user_id`='$userID' GROUP BY `project_field`.`id` ) AND pending='0'".$condition ;
		//echo  ($query) ;
		$result = self::execquery($query);
		if ($result) {

			while ($obj = $result->fetch_object()) {
				$file= $obj->picpath ;
				if (!file_exists($file)){$obj->picpath= self::$picpath;}
				$element = array('id' => self::$encryption->encode($obj->id),
						'picpath' =>$obj->picpath,
						'name' => $obj->name,
						'usercountry' => $obj->usercountry,
						'description' => $obj->description,
						'project_field_list' => $obj->project_field_list,
						'views' => $obj->views,
						'stage_list' => json_decode($obj->stage_list),
						'project_country' => $obj->project_country,
						'project_type_list' => str_replace('"','',$obj->project_type_list) ,
						'project_field_list' => str_replace('"','',$obj->project_field_list),
						'username' => $obj->username,
						'profilepic' => $obj->profilepic,
						'userid' => self::$encryption->encode($obj->userid),
						'pending' => $obj->pending,
				);
				array_push($allprojects, $element);
			}
		}

		return $allprojects;




	}
		
	public static function deleteproject($project_id) {
	
	
        $query = "update projects set deleted=1 where id=$project_id" ;
	   
        $result = self::execquery($query);
		if ( $result )
		{
			global $useridstr;
			$user_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($user_id);
		      self::updateuserprojects($user_id,-1);
		}
		
        
    }
	public static function deleteoffer($offer_id) {
	
	
        $query = "update offers set deleted=1 where id=$offer_id" ;
	   
        $result = self::execquery($query);
		if ( $result )
		{
			global $useridstr;
			$user_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($user_id);
		      self::updateuseroffers($user_id,-1);
		}
		
        
    }
   public static function deleteopportunity($opportunity_id) {
	
	
        $query = "update opportunities set deleted=1 where id=$opportunity_id" ;
	
        $result = self::execquery($query);
        		if ( $result )
		{
			global $useridstr;
			$user_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($user_id);
		      self::updateuseropportunities($user_id,-1);
		}
    }
	
	   public static function deleteproduct($product_id) {
	
	
        $query = "update products set deleted=1 where id=$product_id" ;
	
        $result = self::execquery($query);
        
    }
	
	
	
	
	public static function  updateprojectviews($project_id)
		{
			
			 $query = "update projects set views=views+1 where  id=$project_id";
			 	//echo $query;
              self::execquery($query);
		
		
		}
		
	public static function  updateofferviews($offer_id)
		{
			
			 $query = "update offers set views=views+1 where  id=$offer_id";
			 	//echo $query;
              self::execquery($query);
		
		
		}
	

	public static function  addprojectviewlog($project_id)
		{
		global $useridstr;
			$user_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($user_id);
			 $query = "select Count(project_id) as count_1,id from project_views where  project_id=$project_id and user_id=$user_id ";
			 //echo $query;
			 self::updateprojectviews($project_id);
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1==0){
					    $query = "insert into project_views set project_id=$project_id ,user_id=$user_id,`count`='1'";
			             $result=self::execquery($query);
						  // self::updateprojectviews($project_id);
				   }else{
					   $projectViewID=$obj->id;
					   $query="UPDATE project_views SET `count`=`count`+1 WHERE id='$projectViewID'";
					   self::execquery($query);
				   }
			 }
			if(isset($_COOKIE[self::$cookieID])){
				$coUserID=$_COOKIE[self::$cookieID];
				$query="SELECT id FROM session_project_views WHERE project_id='$project_id' AND user_id='$coUserID'";
				$result=self::execquery($query);
				if ($result) {
					if($result->num_rows==0){
						$query="INSERT INTO session_project_views (`project_id`,`user_id`,`count`) VALUES ('$project_id','$coUserID','1')";
						self::execquery($query);
					}else{
						$sesOfferID=$result->fetch_object()->id;
						$query="UPDATE session_project_views SET `count`=`count`+1 WHERE id='$sesOfferID'";
						self::execquery($query);
					}
				}
			}
		
		}
		
	
public static function  addofferviewlog($offer_id)
		{
		global $useridstr;
			$user_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($user_id);
			 $query = "select Count(offer_id) as count_1,id  from offer_views where  offer_id=$offer_id and user_id=$user_id ";
			self::updateofferviews($offer_id);
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1==0){
					    $query = "insert into offer_views set offer_id=$offer_id ,user_id=$user_id,`count`='1'";
					   //echo$query;
			             $result=self::execquery($query);
						   //self::updateofferviews($project_id);
				   }else{
					   $OfferViewID=$obj->id;
					   $query="UPDATE offer_views SET `count`=`count`+1 WHERE id='$OfferViewID'";
					   self::execquery($query);
				   }
			 }
			if(isset($_COOKIE[self::$cookieID])){
				$coUserID=$_COOKIE[self::$cookieID];
				$query="SELECT id FROM session_offer_views WHERE offer_id='$offer_id' AND user_id='$coUserID'";
				$result=self::execquery($query);
				if ($result) {
					if($result->num_rows==0){
						$query="INSERT INTO session_offer_views (`offer_id`,`user_id`,`count`) VALUES ('$offer_id','$coUserID','1')";
						self::execquery($query);
					}else{
						$sesOfferID=$result->fetch_object()->id;
						$query="UPDATE session_offer_views SET `count`=`count`+1 WHERE id='$sesOfferID'";
						self::execquery($query);
					}
				}
			}
		}
	public static function getProjectOwnerPhoneCOOKIE($project_id,$user_id){

		if(isset($_COOKIE[self::$cookieID])){
			$myuser_id=$_COOKIE[self::$cookieID];
			$query = "select phone,contact_phone,contact_name,contact_type,contact_email from projects inner join users on users.id=projects.user_id where projects.id=$project_id ";
			$result=self::execquery($query);
			if($result){
				$obj = $result->fetch_object();
				$query = "select Count(src_id) as count_1  from session_show_owner_phone where  src_id=$project_id and user_id=$myuser_id and expiredate>=NOW() and type='project'";
				$result=self::execquery($query);
				if ($result) {
					$obj = $result->fetch_object();
					if ( $obj->count_1==0){
						//echo $myuser_id;
						if ($project_id!=$myuser_id){
							$user_expired_after= self::$project_expired_after;
							$user_credit =self::$project_credit;
							$query = "insert into session_show_owner_phone set src_id=$project_id ,user_id=$myuser_id ,type='project',amount='$user_credit',expiredate=DATE_ADD(NOW(),INTERVAL $user_expired_after DAY)";
							$result=self::execquery($query);
						}
					}
				}

			}
		}
	}
	public static function getprojectownerphone($project_id,$user_id)
	{
		   global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			
			//$query = "select phone from users where id=$user_id ";
			//$query = "select contact_name,contact_phone from projects where id=$project_id ";
			  $query = "select phone,contact_phone,contact_name,contact_type,contact_email from projects inner join users on users.id=projects.user_id where projects.id=$project_id ";
			 //echo $query;

		    $phone="";
			$name="";
			$email="";
			$type="";
			$string="";
	        $userphone="";
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   //$phone=$obj->phone;
				  $phone=$obj->contact_phone;
						   $name=$obj->contact_name;
						   $email=$obj->contact_email;
						   $type=$obj->contact_type;
						    $userphone=$obj->phone;
						   if ($type==1){
							   
							   $string=  "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الاسم : </p>
                                    <p class='md-font grey-font zero-bottom-margin'>$name</p>
                                </div>". "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الهاتف : </p>
                                    <p class='black-font sm-font text-center bold zero-bottom-margin show-phone show-phone'>
							           <a class='show-phone' href='tel:$phone'>$phone</a></p>
                                </div>";
								
							 
						   }else if ($type==2)
						   {
							  $string=  "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الاسم : </p>
                                    <p class='md-font grey-font zero-bottom-margin'>$name</p>
                                </div>". "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment show-phone'>الإيميل : </p>
                                    <p class='black-font sm-font text-center bold zero-bottom-margin'>
							           <a class='show-phone' href='mailto:$email'>$email</a></p>
                                </div>"
									   ;
						   }else
						   {
							   $string=  "<p class='black-font sm-font text-center bold zero-bottom-margin show-phone'>
							           <a class='show-phone' href='tel:$userphone'>$userphone</a></p>";
						   }
						   
						   
						   
				   self::addownerphonelog($project_id,$user_id,'project');
				   
			 }
			 return $string;
		
	}

	public static function getOfferOwnerPhoneCOOKIE($offer_id,$user_id){
		if(isset($_COOKIE[self::$cookieID])){
			$myuser_id=$_COOKIE[self::$cookieID];
			$query = "select phone,contact_phone,contact_name,contact_type,contact_email from offers inner join users on users.id=offers.user_id where offers.id=$offer_id ";
			$result=self::execquery($query);
			if($result){
				$obj = $result->fetch_object();
				$query = "select Count(src_id) as count_1  from session_show_owner_phone where  src_id=$offer_id and user_id=$myuser_id and expiredate>=NOW() and type='offer'";
				$result=self::execquery($query);
				if ($result) {
					$obj = $result->fetch_object();
					if ( $obj->count_1==0){
						//echo $myuser_id;
						if ($offer_id!=$myuser_id){
							$user_expired_after= self::$message_expired_after;
							$user_credit =self::$message_credit;
							$query = "insert into session_show_owner_phone set src_id=$offer_id ,user_id=$myuser_id ,type='offer',amount='$user_credit',expiredate=DATE_ADD(NOW(),INTERVAL $user_expired_after DAY)";
							$result=self::execquery($query);
						}
					}
				}
			}
		}
	}
		public static function getofferownerphone($offer_id,$user_id)
	{
		   global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			
			//$query = "select phone from users where id=$user_id ";
			//$query = "select contact_name,contact_phone from projects where id=$project_id ";
			  $query = "select phone,contact_phone,contact_name,contact_type,contact_email from offers inner join users on users.id=offers.user_id where offers.id=$offer_id ";
			 //echo $query;

		    $phone="";
			$name="";
			$email="";
			$type="";
			$string="";
	        $userphone="";
			 $result=self::execquery($query);
			 
			 if ($result) {
			       $obj = $result->fetch_object();
				   //$phone=$obj->phone;
				  $phone=$obj->contact_phone;
						   $name=$obj->contact_name;
						   $email=$obj->contact_email;
						   $type=$obj->contact_type;
						    $userphone=$obj->phone;
						   if ($type==1){
							   
							   $string=  "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الاسم : </p>
                                    <p class='md-font grey-font zero-bottom-margin'>$name</p>
                                </div>". "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الهاتف : </p>
                                    <p class='black-font sm-font text-center bold zero-bottom-margin show-phone'>
							           <a class='show-phone' href='tel:$phone'>$phone</a></p>
                                </div>";
								
							 
						   }else if ($type==2)
						   {
							  $string=  "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الاسم : </p>
                                    <p class='md-font grey-font zero-bottom-margin'>$name</p>
                                </div>". "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment show-phone'>الإيميل : </p>
                                    <p class='black-font sm-font text-center bold zero-bottom-margin'>
							           <a class='show-phone' href='mailto:$email'>$email</a></p>
                                </div>"
									   ;
						   }else
						   {
							   $string=  "<p class='black-font sm-font text-center bold zero-bottom-margin show-phone'>
							           <a class='show-phone' href='tel:$userphone'>$userphone</a></p>";
						   }
						   
						   
						   
				   self::addownerphonelog($offer_id,$user_id,'offer');
				   
			 }
			
			return $string;
		
	}
	
	
		public static function getopportunityownerphone($opportunity_id,$user_id)
	{
		   global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			
			$query = "select phone from users where id=$user_id ";
			 //echo $query;
             $phone="";
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   $phone=$obj->phone;
				   self::addownerphonelog($opportunity_id,$user_id,'opportunity');
				   
			 }
			 return $phone;
		
	}
	
		public static function check_projectownerphone($project_id,$user_id)
	{
		  
		global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			 //$query = "select Count(project_id) as count_1  from project_show_owner_phone where  project_id=$project_id and user_id=$myuser_id and expiredate>=NOW()";
			  $query = "select Count(src_id) as count_1  from show_owner_phone where  src_id=$project_id and user_id=$myuser_id and expiredate>=NOW() and type='project' ";
			 //echo  $query;

		    $phone="";
			$name="";
			$email="";
			$type="";
			$string="";
	        $userphone="";
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1>0){
					  
					
			//$query = "select phone from users where id=$user_id ";
			//$query = "select contact_name,contact_phone from projects where id=$project_id ";
			  $query = "select phone,contact_phone,contact_name,contact_type,contact_email from projects inner join users on users.id=projects.user_id where projects.id=$project_id ";
			 //echo $query;

			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   //$phone=$obj->phone;
				  $phone=$obj->contact_phone;
						   $name=$obj->contact_name;
						   $email=$obj->contact_email;
						   $type=$obj->contact_type;
						    $userphone=$obj->phone;
						   if ($type==1){
							   
							   $string=  "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الاسم : </p>
                                    <p class='md-font grey-font zero-bottom-margin'>$name</p>
                                </div>". "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الهاتف : </p>
                                    <p class='black-font sm-font text-center bold zero-bottom-margin show-phone'>
							           <a class='show-phone' href='tel:$phone'>$phone</a></p>
                                </div>";
								
							 
						   }else if ($type==2)
						   {
							  $string=  "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الاسم : </p>
                                    <p class='md-font grey-font zero-bottom-margin'>$name</p>
                                </div>". "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment show-phone'>الإيميل : </p>
                                    <p class='black-font sm-font text-center bold zero-bottom-margin'>
							           <a class='show-phone' href='mailto:$email'>$email</a></p>
                                </div>"
									   ;
						   }else
						   {
							   $string=  "<p class='black-font sm-font text-center bold zero-bottom-margin show-phone'>
							           <a class='show-phone' href='tel:$userphone'>$userphone</a></p>";
						   }
						   
						   
						   
				
				   
			       }
				  } 
			 }
			 
			
			
			 return $string;
		
	}

	
			public static function check_offerownerphone($offer_id,$user_id)
	{
		  
		global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			 //$query = "select Count(project_id) as count_1  from project_show_owner_phone where  project_id=$project_id and user_id=$myuser_id and expiredate>=NOW()";
			  $query = "select Count(src_id) as count_1  from show_owner_phone where  src_id=$offer_id and user_id=$myuser_id and expiredate>=NOW() and type='offer' ";
			 //echo  $query;

		    $phone="";
			$name="";
			$email="";
			$type="";
			$string="";
	        $userphone="";
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1>0){
					  
					
			//$query = "select phone from users where id=$user_id ";
			//$query = "select contact_name,contact_phone from projects where id=$project_id ";
			  $query = "select phone,contact_phone,contact_name,contact_type,contact_email from offers inner join users on users.id=offers.user_id where offers.id=$offer_id ";
			 //echo $query;

			 $result=self::execquery($query);
			 
			 
			 if ($result) {
			       $obj = $result->fetch_object();
				   //$phone=$obj->phone;
				  $phone=$obj->contact_phone;
						   $name=$obj->contact_name;
						   $email=$obj->contact_email;
						   $type=$obj->contact_type;
						    $userphone=$obj->phone;
						   if ($type==1){
							   
							   $string=  "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الاسم : </p>
                                    <p class='md-font grey-font zero-bottom-margin'>$name</p>
                                </div>". "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الهاتف : </p>
                                    <p class='black-font sm-font text-center bold zero-bottom-margin show-phone'>
							           <a class='show-phone' href='tel:$phone'>$phone</a></p>
                                </div>";
								
							 
						   }else if ($type==2)
						   {
							  $string=  "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment'>الاسم : </p>
                                    <p class='md-font grey-font zero-bottom-margin'>$name</p>
                                </div>". "<div class='col-md-12 col-lg-12 col-xs-12 col-sm-12'>
                                    <p class='md-font  orange-font zero-bottom-margin cst-right-alignment show-phone'>الإيميل : </p>
                                    <p class='black-font sm-font text-center bold zero-bottom-margin'>
							           <a class='show-phone' href='mailto:$email'>$email</a></p>
                                </div>"
									   ;
						   }else
						   {
							   $string=  "<p class='black-font sm-font text-center bold zero-bottom-margin show-phone'>
							           <a class='show-phone' href='tel:$userphone'>$userphone</a></p>";
						   }
						   
						   
						   
				   
				   
			 }
			
				 } 
			 }
			 
			
			
			 return $string;
		
	}
	
	
	public static function check_opportunityownerphone($opportunity_id,$user_id)
	{
		  
		global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			 //$query = "select Count(project_id) as count_1  from project_show_owner_phone where  project_id=$project_id and user_id=$myuser_id and expiredate>=NOW()";
			  $query = "select Count(src_id) as count_1  from show_owner_phone where  src_id=$opportunity_id and user_id=$myuser_id and expiredate>=NOW() and type='opportunity' ";
			 //echo  $query;

		    $phone="";
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1>0){
					  
					  $query = "select phone from users where id=$user_id ";
			 //echo $query;
					 
					 $result=self::execquery($query);
					 if ($result) {
						   $obj = $result->fetch_object();
						   $phone=$obj->phone;
						   
						   
					 }
					 
				   }
				   
			 }
			 
			 
			
			 return $phone;
		
	}

		
		
	public static function  addprojectownerphonelog($project_id,$user_id)
		{ 
		
		global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			 $query = "select Count(project_id) as count_1  from project_show_owner_phone where  project_id=$project_id and user_id=$myuser_id and expiredate>=NOW()";
			 

		
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1==0){
					  //echo $myuser_id;
			           if ($user_id!=$myuser_id){
						  $project_expired_after= self::$project_expired_after;
					      $query = "insert into project_show_owner_phone set project_id=$project_id ,user_id=$myuser_id ,expiredate=DATE_ADD(NOW(),INTERVAL $project_expired_after DAY)";
			              $result=self::execquery($query);
						 
						   self::updateuserbalance($myuser_id,-1*self::$project_credit);
						 }
				   }
				   
			 }
		
		}
		
		
		
	    public static function addopportunity($user_id,$parameters) {
        $keys = "";
        $values = "";
        
        //die('my current session is '.$currentsource);
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';
          
            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
		$keys = $keys .  'user_id,';
		$values = $values . $user_id . ',';
		
        $query = "insert into opportunities (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
	
			//echo  $query;
        $id = self::execquery_id($query);
		
		if ($id>0)
		{
			self::updateuseropportunities($user_id,1);
		}
		//self::updateprofilelink ($id,$currentsource);
      
	   				    $errorMessage=  self::$success_add;;
                    include 'views/message/success_message.php';
        /*add record to crm*/
      // self::transferdatatocrmbyid($id);
        
        return $id;
    }

	   public static function updateopportunity($opp_id,$user_id,$parameters) {
        $keys = "";
        $values = "";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            //$keys = $keys . $key . ',';
            

            if ($type == 'string') {

                $values =$values. $key ."=" . "N'$value'" . ',';
            } else {
                 $values = $values . $key ."=" . $value . ',';
            }
           
        }
       
        $query = " update opportunities set " . substr($values, 0, -1)  .
                " where user_id=$user_id and id=$opp_id";
     
        $result = self::execquery($query);
       	 $errorMessage=  self::$success_edit;;
          include 'views/message/success_message.php';
        return $result;
    }
	
	
		public static function getuseropportunities($user_id) {
	
	 $opportunities = array();
        $query = "select opportunities.*,users.`name` as username,users.companyname
					 from opportunities 
					INNER JOIN users on users.id=opportunities.user_id
					 where opportunities.user_id=$user_id";
	
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
           	$file= $obj->picpath ;
              if (!file_exists($file)){$obj->picpath=self::$picpathopp;}
                $element = array('id' => self::$encryption->encode($obj->id),
                    'name' => $obj->name,
					'description' => $obj->description,
					'expiredate' => $obj->expiredate,
					'views' => $obj->views,
					'picpath' => $obj->picpath,
					
					);
                array_push($opportunities, $element);
            }
        }

        return $opportunities;
		
		
     
        
    }
	
	public static function getsingleopportunity($opportunity_id) {
	
	
        $query = "select opportunities.*,DATE_FORMAT (expiredate,'%d-%m-%Y') as expiredate_1 ,users.`name` as username,users.companyname,users.id as userid,users.profilepic
					 from opportunities 
					INNER JOIN users on users.id=opportunities.user_id where opportunities.id=$opportunity_id";
	//die  ($query) ;
        $result = self::execquery($query);
        if ($result) {
		$obj = $result->fetch_object();
		$obj->id=self::$encryption->encode($obj->id);
		$obj->userid=self::$encryption->encode($obj->userid);
		$obj->user_id=self::$encryption->encode($obj->user_id);
		$shareimage='http://mooga.com/'. $obj->picpath;
		if (!file_exists($obj->picpath)){$obj->picpath="assets/uploads/opportunity/none.png";
		$shareimage="http://mooga.com/assets/uploads/opportunity/opportunities.png";
		}
			$facebook=new StdClass();
			$facebook->image=$shareimage;
			$facebook->description=$obj->description;
             $obj->facebook=$facebook;
		}
		self::addopportunityviewlog($opportunity_id);
		return $obj;
         
        
    }
		
		public static function getallopportunities($condition="") {
	
	 $opportunities = array();
        $query = "select opportunities.*,DATE_FORMAT (expiredate,'%d-%m-%Y') as expiredate_1 ,users.`name` as username,users.companyname,users.id as userid
					 from opportunities 
					INNER JOIN users on users.id=opportunities.user_id where 1 and IFNULL(opportunities.deleted,0)=0 and  expiredate>=NOW()
					 ".$condition;
	//echo   ($query) ;
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
	$file= $obj->picpath ;
              if (!file_exists($file)){$obj->picpath=self::$picpathopp;}
                $element = array('id' => self::$encryption->encode($obj->id),
                    'name' => $obj->name,
					'description' => $obj->description,
					'expiredate' => $obj->expiredate_1,
					'views' => $obj->views,
					'picpath' => $obj->picpath,
					'userid' => self::$encryption->encode($obj->userid),
					
					);
                array_push($opportunities, $element);
            }
        }

        return $opportunities;
		
		
     
        
    }
	
	
	
			
		public static function getsingleopportunities($opp_id,$user_id) {
	
	 $opportunities = array();
        $query = "select opportunities.*,DATE_FORMAT (expiredate,'%Y-%m-%d') as expiredate_1
					 from opportunities 
					 where 1
					 and  id=$opp_id and user_id=$user_id";
 
        $result = self::execquery($query);
		 $obj=null;
        if ($result) {
          $obj = $result->fetch_object();
		  $obj->id=self::$encryption->encode($obj->id);
		   $obj->expiredate=$obj->expiredate_1;
          /*  while ($obj = $result->fetch_object()) {

                $element = array('id' => $obj->id,
                    'name' => $obj->name,
					'description' => $obj->description,
					'expiredate' => $obj->expiredate,
					'views' => $obj->views,
					
					);
                array_push($opportunities, $element);
            }*/
        }

        return  $obj;
		
		
     
        
    }
	
	
	

	
	
	
			
		public static function getsingleproduct($product_id,$user_id) {
	
	 $products = array();
        $query = "select products.*
					 from products 
					 where 1
					 and  id=$product_id and user_id=$user_id";
 
        $result = self::execquery($query);
		 $obj=null;
        if ($result) {
          $obj = $result->fetch_object();
		  $obj->id=self::$encryption->encode($obj->id);
          /*  while ($obj = $result->fetch_object()) {

                $element = array('id' => $obj->id,
                    'name' => $obj->name,
					'description' => $obj->description,
					'expiredate' => $obj->expiredate,
					'views' => $obj->views,
					
					);
                array_push($opportunities, $element);
            }*/
        }

        return  $obj;
		
		
     
        
    }
	
	
	
        public static function 	rememberme($username,$password,$rememberme)
		{
				  $cookie_name = 'mooga2016';
					$cookie_time = (3600 * 24 * 30);
				   if ($rememberme==1||$rememberme=='on')
				  {      
                    		  
					  setcookie ($cookie_name, 'user='.$username.'&pass='.$password.'&remember=1', time() + $cookie_time);
					  	
				  }
				 else {
					   setcookie ($cookie_name, '', time() - $cookie_time);
				  }
		}
		
	   public static function 	getrememberme()
		{
				$cookie_name = 'mooga2016';
				$cookiesUser="";
				$cookiesPass="";
				$rememberme='';

				if(isset($_COOKIE[$cookie_name]))
				  {

				   parse_str($_COOKIE[$cookie_name]);
					$cookiesUser=$user;
					$cookiesPass=$pass;
					
					if ($remember>=1)
					   $rememberme ='checked';   
				  }
				   
				$obj=  (object) array ('username' => $cookiesUser,
											'password' => $cookiesPass,
											'rememberme' => $rememberme,)  ;
											
				return	$obj	;						
		}
		
	
	
	
	public static function CheckActivation($id,$token) {
        $query = "select id,link_expired  from companies where id='$id' and active_code='$token'";
        $result = self::execquery($query);

        if ($result) {
            if ($result->num_rows > 0) {
                $obj = $result->fetch_object();
                  $today=date("Y-m-d H:i:s");
                if ($today>$obj->link_expired)
                 return FALSE;
                else{
                    self::ActivLink($id);
                return TRUE;
                }
            }
        } else {
            return FALSE;
        }
    }

     public static function ActivLink($id) {
        $query = "update companies set isactive=1  where id='$id' ";
        $result = self::execquery($query);
    }
   public static function ActivLinkbyemail($email) {
        $query = "update companies set isactive=1  where email='$email' ";
        $result = self::execquery($query);
    }
    public static function ActivCompany($id) {
        $query = "update companies set accountstatus='Active'  where id='$id' ";
        $result = self::execquery($query);
    }
        public static function ActivCompanybyemail($email) {
        $query = "update companies set accountstatus='Active'  where email='$email' ";
        $result = self::execquery($query);
    }
    
  public static function ResendActiveCodeCompany($id,$token,$link_expired) {
        $query = "update companies set active_code='$token' ,link_expired='$link_expired'  where id='$id' ";
        $result = self::execquery($query);
    }
    
    public static function isexesitcompany($email) {
        $query = "select id  from companies where email='$email'";
        $result = self::execquery($query);

        if ($result) {
            if ($result->num_rows > 0) {
                return TRUE;
            }
        } else {
            return FALSE;
        }

     }

	 
    public static function addcompany($parameters) {
        $keys = "";
        $values = "";
        $currentsource=self::$sessionhandler2->get('currentlink');
        //die('my current session is '.$currentsource);
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';
            if ($key == 'email') {
               if ( self::isexesitcompany($value)===TRUE)
               {
                    echo self::$emailexsist_message;
                exit;
               }
            }

            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
        $query = "insert into companies (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
	
			
        $id = self::execquery_id($query);
		
		self::updateprofilelink ($id,$currentsource);
        //echo self::$success_message;
        /*add record to crm*/
       self::transferdatatocrmbyid($id);
        
        return $id;
    }

	
	
      public static function Editcompany($parameters,$companyid) {
        $keys = "";
        $values = "";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            //$keys = $keys . $key . ',';
            

            if ($type == 'string') {

                $values =$values. $key ."=" . "N'$value'" . ',';
            } else {
                 $values = $values . $key ."=" . $value . ',';
            }
           
        }
       
        $query = " update companies set " . substr($values, 0, -1)  .
                " where id=$companyid";
     
        $result = self::execquery($query);
        /*add record to crm*/
        self::transferdatatocrmbyid($companyid);
               
        return $result;
    }

    public static function addservices($parameters, $companies_id) {
        $keys = "companies_id,";
        $values = "$companies_id,";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';


            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
        $query = "insert into services (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
//echo($query);
        $id = self::execquery_id($query);
        return $id;
    }

    public static function addgives($parameters, $companies_id) {
        $keys = "companies_id,";
        $values = "$companies_id,";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';
            if ($key == 'companies_id') {
                $value = $companies_id;
            }
            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
        $query = "insert into gives (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";

        $id = self::execquery_id($query);
        return $id;
    }


    
    

   
   public static function Editservices($parameters, $companies_id) {
        $keys = ",";
        $values = "";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
           // $keys = $keys . $key . ',';


            if ($type == 'string') {

                 $values =$values. $key ."=" . "N'$value'" . ',';
            } else {
                 $values = $values . $key ."=" . $value . ',';
            }
            
        }
        
        
      $query = " update services set " . substr($values, 0, -1)  .
                " where companies_id=$companies_id";
     // die($query);
        $id = self::execquery_id($query);
        return $id;
    }

    public static function Editgives($parameters, $companies_id) {
        $keys = "";
        $values = "";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            //$keys = $keys . $key . ',';
           
            if ($type == 'string') {

               $values =$values. $key ."=" . "N'$value'" . ',';
            } else {
                 $values = $values . $key ."=" . $value . ',';
            }
        }
    
         $query = " update gives set " . substr($values, 0, -1)  .
                " where companies_id=$companies_id";

        $id = self::execquery_id($query);
        return $id;
    }

    /**
     *
     * Like the constructor, we make __clone private
     * so nobody can clone the instance
     *
     */
    public static function getcompany($companyid) {
     
        $company = array();
        $gives = array();
        $services = array();
        $query = "select companies.*,country.`arab_name` as countryname from companies
                    LEFT OUTER JOIN country 
                    on country.`code`=companies.countrycode where companies.id = $companyid";
      
        $result = self::execquery($query);
        if ($result) {
           
            $obj = $result->fetch_object();
         // echo self::$encryption->encode(33);
            // echo $obj->companyname;
            if (!file_exists($obj->profilepic)){$obj->profilepic="assets/img/none.png";}
            
         $com = array('id' => self::$encryption->encode($obj->id),
                'name' => $obj->name,
               
                'email' => $obj->email,
                'password' => $obj->password,
                'companyname' => $obj->companyname,
                'phone' => $obj->phone,
                'website' => $obj->website,
                'facebook' => $obj->facebook,
                'twitter' => $obj->twitter,
                'linkedin' => $obj->linkedin,
                'google' => $obj->google,
                'instagram' => $obj->instagram,
                
                'countryname' => $obj->countryname,
                'email' => $obj->email,
                'profilepic' => $obj->profilepic,
                'mailref' => $obj->mailref,
                 'ispay' => $obj->ispay,
                'login_type' => $obj->login_type,
                'accountstatus' => $obj->accountstatus,
                'sevicetime' => $obj->servicetime,
             
            );
        }

        $query = "select services.*,services1tb.name as services1name,services2tb.name as services2name
                    ,services3tb.name as services3name ,services4tb.name as services4name 
                    ,services5tb.name as services5name
                    from services
                    LEFT OUTER JOIN allservices as services1tb
                    on services.services1=services1tb.`code`
                    LEFT OUTER JOIN allservices as services2tb
                    on services.services2=services2tb.`code`
                    LEFT OUTER JOIN allservices as services3tb
                    on services.services3=services3tb.`code`
                    LEFT OUTER JOIN allservices as services4tb
                    on services.services4=services4tb.`code`
                    LEFT OUTER JOIN allservices as services5tb
                    on services.services5=services5tb.`code` where companies_id = $companyid";
        //echo $query;
        $result = self::execquery($query);
        if ($result) {
            $obj = $result->fetch_object();
            $services = array('services1' => $obj->services1,
                'services2' => $obj->services2,
                'services3' => $obj->services3,
                'services4' => $obj->services4,
                'services5' => $obj->services5,
                'services1name' => $obj->services1name,
                'services2name' => $obj->services2name,
                'services3name' => $obj->services3name,
                'services4name' => $obj->services4name,
                'services5name' => $obj->services5name
            );
        }

        $query = "select gives.*,gives1tb.name as gives1name,gives2tb.name as gives2name
                ,gives3tb.name as gives3name ,gives4tb.name as gives4name 
                ,gives5tb.name as gives5name
                from gives
                LEFT OUTER JOIN allservices as gives1tb
                on gives.gives1=gives1tb.`code`
                LEFT OUTER JOIN allservices as gives2tb
                on gives.gives2=gives2tb.`code`
                LEFT OUTER JOIN allservices as gives3tb
                on gives.gives3=gives3tb.`code`
                LEFT OUTER JOIN allservices as gives4tb
                on gives.gives4=gives4tb.`code`
                LEFT OUTER JOIN allservices as gives5tb
                on gives.gives5=gives5tb.`code` where companies_id = $companyid";
        $result = self::execquery($query);
        if ($result) {
            $obj = $result->fetch_object();
            $gives = array('gives1' => $obj->gives1,
                'gives2' => $obj->gives2,
                'gives3' => $obj->gives3,
                'gives4' => $obj->gives4,
                'gives5' => $obj->gives5,
                'gives1name' => $obj->gives1name,
                'gives2name' => $obj->gives2name,
                'gives3name' => $obj->gives3name,
                'gives4name' => $obj->gives4name,
                'gives5name' => $obj->gives5name
            );
        }

        $company = array('company' => $com,
            'services' => $services,
            'gives' => $gives
        );
        return $company;
    }

        public static function getcompanybyemail($email) {
        
        $company = array();
        $gives = array();
        $services = array();
        $query = "select companies.*,country.`arab_name` as countryname from companies
                    LEFT OUTER JOIN country 
                    on country.`code`=companies.countrycode where companies.email = '$email'";
      //die($query);
        $result = self::execquery($query);
        if ($result) {
           
            $obj = $result->fetch_object();
         // echo self::$encryption->encode(33);
            // echo $obj->companyname;
            if ($obj==null)return;
         $company = array('id' => self::$encryption->encode($obj->id),
                'firstname' => $obj->firstname,
                'lastname' => $obj->lastname,
                'email' => $obj->email,
                'password' => $obj->password,
                'companyname' => $obj->companyname,
                
                'countrycode' => $obj->countrycode,
                'phone' => $obj->phone,
                'website' => $obj->website,
                'aboutcompany' => $obj->aboutcompany,
                'facebook' => $obj->facebook,
                'twitter' => $obj->twitter,
                'linkedin' => $obj->linkedin,
                'google' => $obj->google,
                'instagram' => $obj->instagram,
                'gender' => $obj->gender,
                'countryname' => $obj->countryname,
                'email' => $obj->email,
                'profilepic' => $obj->profilepic,
                'mailref' => $obj->mailref,
                 'ispay' => $obj->ispay,
                'login_type' => $obj->login_type,
                'accountstatus' => $obj->accountstatus
             
            );
        }


        return $company;
    }

    public static function getallservices() {
        $allservices = array();
        $query = "select id,code,name  from allservices order by id";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = array('code' => $obj->code,
                    'name' => $obj->name);
                array_push($allservices, $element);
            }
        }

        return $allservices;
    }

    public static function getallcountry() {
        $allcountry = array();
        $query = "select id,code,name  from country order by id";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = array('code' => $obj->code,
                    'name' => $obj->name);
                array_push($allcountry, $element);
            }
        }

        return $allcountry;
    }


    public static function insertaccount_transaction($company_id,$start_date,$end_date,$account_id,$flag,$pay_date) {
        
        $table_name='account_plan_trans';
        
        
        
        $form_data=array('user_id'=>$company_id,'account_id'=>$account_id,'start_date'=>$start_date,'end_date'=>$end_date,'year_month'=>$flag,'pay_date'=>$pay_date);
        $fields = array_keys($form_data);
        
        
        
        $query = "INSERT INTO ".$table_name."
        (`".implode('`,`', $fields)."`)
        VALUES('".implode("','", $form_data)."')";
    
        
         $id = self::execquery_id($query);
         return $id;


    }
    public static function get_account_plandate($company_id) {
        $date_list = array();
        $query="select * from companies where id=$company_id";
        
        $result = self::execquery($query);
        if ($result) {

                while ($obj = $result->fetch_object()) {

                $element = array('start_date' => $obj->start_date,
                    'end_date' => $obj->end_date);
                array_push($date_list, $element);
                }
            }
        
       
        return $date_list;
        
    }
    public static function updateusernewpassword($email,$newpassowrd) {
        
        
        
      $query = " update users set password='$newpassowrd' where email='$email'";
      //echo($query);
        $id = self::execquery_id($query);
        //self::ActivLinkbyemail($email);
       // self::ActivCompanybyemail($email);
        return $id;
    } 
	
	    public static function updateusernewpasswordbyid($id,$newpassowrd) {
        
        
        
      $query = " update users set password='$newpassowrd' where id='$id'";
      //echo($query);
        $id = self::execquery_id($query);
        //self::ActivLinkbyemail($email);
       // self::ActivCompanybyemail($email);
        return $id;
    } 
     public static function updateusertokens($token) {
        
        
        
      $query = " update password_tokens set used=1 where token='$token'";
      //echo($query);
        $id = self::execquery_id($query);
        return $id;
    } 
    public static function get_password_tokens($token) {
        $token_list = array();
        $query="select * from password_tokens where token='$token'";
       // echo $query;
        $result = self::execquery($query);
        if ($result) {

                while ($obj = $result->fetch_object()) {

                $element = array('token' => $obj->token,
                    'email' => $obj->email,'used'=>$obj->used,'extime'=>$obj->extime );
                array_push($token_list, $element);
                }
            }
        
       
        return $token_list;
        
    }
	

    public static function updatecompanyplan($type, $companies_id,$account_id) {
        
        $start_date=date('Y-m-d H:i:s');
        $pay_date=date('Y-m-d H:i:s');
        $datetoday = time();
        // CHECK IF THE ACCOUNT IS EXPIRED OR NOT//////////////////////////////////////
        $result_date =  self::get_account_plandate($companies_id);
        if( count($result_date)>0)
        {
            $start_datedb=$result_date[0]['start_date'];
            $end_datedb=$result_date[0]['end_date'];
            $date1=new DateTime($start_datedb);
            $date2=new DateTime($end_datedb);
            $diff=$date1->diff($date2);
            $diff_symbol= $diff->format('%R'); // use for point out relation: smaller/greater
            $diff_days=$diff->days ;
            if($diff_days>0)
            {
                if($diff_symbol=='+')
                {
                    $start_date=$end_datedb;
                    $datetoday=strtotime($end_datedb);
                    
                }
            }
        }
        
        ////CHECK IF THE ACCOUNT IS EXPIRED OR NOT/////////////////////////////////////////
	if($type=='month')
	{
		$end_date=date('Y-m-d H:i:s', strtotime('+1 month', $datetoday));
		$account_year_month='m';
	}
	elseif($type=='year')
	{
		$end_date=date('Y-m-d H:i:s', strtotime('+1 year', $datetoday));
		$account_year_month='y';
	}
        //Insert Into Database Account plan Transaction//////////////////////
        $result_ins= self::insertaccount_transaction(
                 $companies_id,
                 $start_date,
                 $end_date,
                 $account_id,
                 $account_year_month,
                 $pay_date
                 );
       
        //Insert Into Database Account plan Transaction//////////////////////
      $query = " update companies set account_id=$account_id , year_moth='$account_year_month',start_date='$start_date',end_date='$end_date' where id=$companies_id";
      //echo($query);
        $id = self::execquery_id($query);
        return $id;
    } 

	
      public static function deleteuser($feedback, $companies_id) {
        
        
        
      $query = " update companies set deleted=1 , deletefeedback='$feedback' where id=$companies_id";
      //echo($query);
        $id = self::execquery_id($query);
        return $id;
    } 
    public static function updateusermailref($value, $companies_id) {
        
        
        
      $query = " update companies set mailref= '$value' where id=$companies_id";
      //die($query);
        $id = self::execquery_id($query);
        return $id;
    } 

    
        public static function get_acount_type($companyid) {
        $account_typelist = array();
        $query="select companies.account_id,account_def.name from companies inner join account_def
        on companies.account_id=account_def.id where companies.id=$companyid";
        $account_type='';
        $result = self::execquery($query);
        if ($result) {

           //$obj = $result->fetch_object();

            // $account_type= $obj->name ;
                while ($obj = $result->fetch_object()) {

                $element = array('account_id' => $obj->account_id,
                    'name' => $obj->name );
                array_push($account_typelist, $element);
                }
            }
        
       
        return $account_typelist;
        
    }
   

    
    public static function isexesitpassword($oldpassword,$companies_id) {
        $query = "select id  from users where password='$oldpassword' and id=$companies_id";
        $result = self::execquery($query);
          
        if ($result) {
            if ($result->num_rows <= 0) {
                echo self::$passwordnotexsist_message;
                
                exit;
            }
        } else {
            return true;
        }
    }
    
    
    public static function updateuserpassword($parameters, $companies_id) {
        $keys = ",";
        $values = "";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
           // $keys = $keys . $key . ',';


            if ($type == 'string') {

                 $values =$values. $key ."=" . "N'$value'" . ',';
            } else {
                 $values = $values . $key ."=" . $value . ',';
            }
        }
         
        
      $query = " update companies set " . substr($values, 0, -1)  .
                " where id=$companies_id";
     // die($query);
        $id = self::execquery_id($query);
        return $id;
    }
    
    public static function getplan($plan_id)
    {
      $query = "select * from  account_def  where id='$plan_id' ";
        //  $result = self::execquery($query);
      //die($query);
        $result = self::execquery($query);
         $plan= array();
        if ($result) {
            if ($result->num_rows > 0) {
                $obj = mysqli_fetch_object($result);
               $plan=  array( 
                'id' => $obj->id,
                'name' => $obj->name,
                'price' => $obj->price,
                'title' => $obj->title,
                'description' => $obj->description,
                       );
            }
        }
        return $plan;
   }

        public static function AddPaymentTrans($parameters,$id) {
        $keys = "";
        $values = "";
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';
       

            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
        $query = "insert into payment_trans (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";

        $id = self::execquery_id($query);
        //echo self::$success_message;
        return $id;
    }

    

	      public static function updateprofilelink ($id,$currentsource)
		  {
			  $profilelink=self::$encryption->encode($id);
			  
			  $query2 = "update  companies set profilelink='$profilelink' ,source='$currentsource' where  id=$id";
			 // die($query2);
               $result2 = self::execquery($query2);
		  }
	    public static function createprofile() {
        
        $query = "select *  from companies where accountstatus='Active' order by id";
		//die($query);
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
            $companyid=$obj->id;
			$profilelink=self::$encryption->encode($obj->id);
			  
			  $query2 = "update  companies set profilelink='$profilelink' where  id=$companyid";
			//  die($query2);
               $result2 = self::execquery($query2);
            }
        }


    }

	
    
        
    public function  transferdatatocrm()
    {
        
        $query="select * from companies where accountstatus='Active'";
        $result = self::execquery($query);
         if ($result) {
            while ($obj = $result->fetch_object()) {
               
                $com = array(
                        'id'=>$obj->id,	
                        'firstname'=>$obj->firstname,
                        'lastname'=>$obj->lastname,
                        'email'	=>$obj->email,
                        'password'	=>$obj->password,
                        'companyname'	=>$obj->companyname,
                        'country'	=>$obj->countrycode,
                        'phone'	=>$obj->phone,
                        'website'	=>$obj->website,
                        'linkedin'	=>$obj->linkedin,
                        'facebook'=>$obj->facebook,
                        'twitter'	=>$obj->twitter,
                        'aboutcompany'	=>$obj->aboutcompany,
                        'google'	=>$obj->google,
                        'instagram'	=>$obj->instagram,
                        'gender'	=>$obj->gender,
                        'profilepic'	=>$obj->profilepic,
                        'account_id'=>$obj->account_id,
                        'start_date'	=>$obj->start_date,
                        'end_date'	=>$obj->end_date,
                        'registerdate'=>$obj->registerdate,
                        'login_type'	=>$obj->login_type,
                        'ispay'=>$obj->ispay,
                        'accountstatus'=>$obj->accountstatus,
                   
                   
                );
                
                self::transferdatatocrmbyid($obj->id);
           }
         }


         
         

    }
    
    
    
        public function transfer($data)
    {
       
        $url = "http://crm.winwinbiz.com/web_crm_updates/new_lead.php";

           
            $content="";
            foreach($data as $key=>$value) { $content .= $key.'='.$value.'&'; }
            //echo $content;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

            $json_response = curl_exec($curl);

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);
            echo 'Transfer Record '. $data['id'].' Is '. $json_response.'<br>';
            //$response = json_decode($json_response, true);
            //echo $response['name'];
            //var_dump($response);
    }
        
    public static function  transferdatatocrmbyid($id)
    {
        
        $query="select * from users where id=$id   ";
        $result = self::execquery($query);
         if ($result) {
            while ($obj = $result->fetch_object()) {
               
                $com = array(
                        'id'=>$obj->id,	
                        'name'=>$obj->name,
                        
                        'email'	=>$obj->email,
                        'password'	=>$obj->password,
                        'companyname'	=>$obj->companyname,
                        
                        'phone'	=>$obj->phone,
                        'website'	=>$obj->website,
                        'linkedin'	=>$obj->linkedin,
                        'facebook'=>$obj->facebook,
                        'twitter'	=>$obj->twitter,
                       
                        'google'	=>$obj->google,
                        'instagram'	=>$obj->instagram,
						 
                      
                        'profilepic'	=>$obj->profilepic,
                        'account_id'=>$obj->account_id,
                        'start_date'	=>$obj->start_date,
                        'end_date'	=>$obj->end_date,
                        'registerdate'=>$obj->registerdate,
                        'login_type'	=>$obj->login_type,
                        'ispay'=>$obj->ispay,
                        'accountstatus'=>$obj->accountstatus,
						'profilelink'=>$obj->profilelink,
						'source'=>$obj->source,
                   
                );
                
                self::transferbyid($com);
           }
         }


         
         

    }
    
    
    
    
    public static function transferbyid($data)
    {
       
        $url = "http://localhost:8081/mooga/web/crm/mooge_service/new_contact.php";

           
            $content="";
            foreach($data as $key=>$value) { $content .= $key.'='.$value.'&'; }
            //echo $content;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

            $json_response = curl_exec($curl);

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);
          //  echo 'Transfer Record '. $data['id'].' Is '. $json_response.'<br>';
            //$response = json_decode($json_response, true);
            //echo $response['name'];
            //var_dump($response);
    }
	
	    public static function getcodesms($code)
    {
       
        $url = "http://api.cequens.com/cequens/api/v1/signin";

           $data=array("apiKey" => "20e2b5c6-d2cc-4ec8-b653-1cc48d232da4", "userName" =>"almoasher");

		   
            $content="";
            foreach($data as $key=>$value) { $content .= $key.'='.$value.'&'; }
           // echo $content;
            $curl = curl_init($url);
			//curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 2);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "apiKey=20e2b5c6-d2cc-4ec8-b653-1cc48d232da4&userName=almoasher");

            $json_response = curl_exec($curl);
            echo $json_response;
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);
          //  echo 'Transfer Record '. $data['id'].' Is '. $json_response.'<br>';
            //$response = json_decode($json_response, true);
            //echo $response['name'];
            //var_dump($response);
    }
	
	 public static function sendsms ($mobile,$code)
    {
       
	   $data=array('access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbiI6IjA1YjBjZjM4MjNjNWY3MDkwNGM4ZjRmMzZjNDQ5YTI2MmQ4MjAyOGUxMjQwZjIwMjFkOTUwYTYyYjVjMWM3ZTQ0NjNmYzg0YzdiY2Y5NzFlZmViYmYwMmM1OTc3OTViOTkyYjYwYjJmOTFkMmE1YzYyNzU5ZWRmZjg3ZDVhN2Y5ZDU0YWZlNGY2NDY1NGZkNWNhM2IxMDg3NzQ3ZDU2NDAiLCJpYXQiOjE0ODQwMDA2NDF9.xSpu-1UjP05VhRSoSt73ZSaxMEl26eT3u-hYO8jZmRg',
	            'senderName' => 'Mooga.com', 'recipients' => "$mobile",'messageType' => 'text', 'messageText' => "كود التفعيل : $code");
        $url = "http://api.cequens.com/cequens/api/v1/messaging";

           //$data=array("apiKey" => "20e2b5c6-d2cc-4ec8-b653-1cc48d232da4", "userName" =>"almoasher");

		   
            $content="";
            foreach($data as $key=>$value) { $content .= $key.'='.$value.'&'; }
             //echo $content;
            $curl = curl_init($url);
			//curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);


            $json_response = curl_exec($curl);
            //echo $json_response;
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);
          //  echo 'Transfer Record '. $data['id'].' Is '. $json_response.'<br>';
            //$response = json_decode($json_response, true);
            //echo $response['name'];
            //var_dump($response);
    }
	
  public static function sendemail ($email,$code,$templatename)
    {
       
	   $data=array('email' => $email,
	            'verifiecode' => $code,
				'templatename' => $templatename
				);
				
        $url = "http://mooga.com/?page=api&action=sendemail";
         
            $content="";
            foreach($data as $key=>$value) { $content .= $key.'='.$value.'&'; }
             //echo $content;
            $curl = curl_init($url);
			//curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);


            $json_response = curl_exec($curl);
            //echo $json_response;
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);
      
    }
	


    
	
	        
    public static function transfertroubleticketbyid($id)
    {
        
       // $query="select * from contactus where id=$id   ";
	    $query="select * from contactus where id<40   ";
        $result = self::execquery($query);
         if ($result) {
            while ($obj = $result->fetch_object()) {
               
                $com = array(
                        'title'=>$obj->name,	
                        'description'=>$obj->message,
                        
                        'email'	=>$obj->email,
                        //'message'	=>$obj->message,
                        'type'	=>$obj->type,
                         'phone'	=>$obj->phone,
                        'registerdate'	=>$obj->createdtime,

                );
                
                self::transfertroubleticket($com);
           }
         }


         
         

    }
    
    
    
    
	
    public static function transfertroubleticket($data)
    {
       
        $url = "http://localhost:8081/mooga/web/crm/mooge_service/troubleticket.php";

           
            $content="";
            foreach($data as $key=>$value) { $content .= $key.'='.$value.'&'; }
            //echo $content;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

            $json_response = curl_exec($curl);
echo  $json_response;
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);
          //  echo 'Transfer Record '. $data['id'].' Is '. $json_response.'<br>';
            //$response = json_decode($json_response, true);
            //echo $response['name'];
            //var_dump($response);
    }

	
	
		/*projects method*/
	
	    public static function contactus($parameters) {
        $keys = "";
        $values = "";
        foreach ($parameters as $parameter) {
          
            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';
          
            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
		
		
        $query = "insert into contactus (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
	
		//echo  $query;
        $id = self::execquery_id($query);
		if ($id>0)
		{
		  $errorMessage=  self::$contactus;;
                    include 'views/message/success_message.php';
		}
		self::transfertroubleticketbyid($id);
        
        return $id;
    }

	
		public static function  addopportunityviewlog($src_id)
		{ 
		
		global $useridstr;
			$user_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($user_id);
			 $query = "select Count(src_id) as count_1  from opportunity_views where  src_id=$src_id and user_id=$user_id ";
			 //echo $query;

			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1==0){
					  
			 
					    $query = "insert into opportunity_views set src_id=$src_id ,user_id=$user_id";

			             $result=self::execquery($query);
						   self::updateopportunityviews($src_id);
				   }
				   
			 }
		
		}
		
		
			public static function  updateopportunityviews($src_id)
		{
			
			 $query = "update opportunities set views=ifnull(views,0)+1 where  id=$src_id";
			 	//echo $query;
              self::execquery($query);
		
		
		}


/*offers method*/
	
	    public static function addoffer($parameters) {
        $keys = "";
        $values = "";
        	 global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($myuser_id);
			 $contact_phone="";
			  $contact_email=""; $country_1="";
			  $contact_type="";
        //die('my current session is '.$currentsource);
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
			if ($key=='contact_phone'){ $value = ltrim($json->value, '0');}
            $keys = $keys . $key . ',';
          
		   
		  if ($key=='country_1'){$country_1=$value;}
		  if ($key=='contact_phone'){$contact_phone=$value;}
		   if ($key=='contact_type'){$contact_type=$value;}
		   if ($key=='contact_email'){$contact_email=$value;}
            if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
		$keys = $keys .  'user_id,';
		$values = $values . $user_id . ',';
		
        $query = "insert into offers (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
	
		//	echo  $query;
        $id = self::execquery_id($query);
		if ($id>0)
		{
		  self::updateuseroffers($user_id,1);
		  $verified_code=  self::getverified_code();
		   self::updateoffer_code($verified_code,$id);
		   if ($contact_type==1){
		   self::sendsms($country_1.$contact_phone,$verified_code);
		   }else
		   {
			    self::sendemail($contact_email,$verified_code,'verifyoffer');
		   }
		}
	      $errorMessage=  self::$success_add;;
                    include 'views/message/success_message.php';
        /*add record to crm*/
      // self::transferdatatocrmbyid($id);
        
        return $id;
    }

	
		
	   public static function updateoffer($offer_id,$parameters) {
        $keys = "";
        $values = "";
		 global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($myuser_id);
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
			
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
			if ($key=='contact_phone'){ $value = ltrim($json->value, '0');}
            //$keys = $keys . $key . ',';
            

            if ($type == 'string') {

                $values =$values. $key ."=" . "N'$value'" . ',';
            } else {
                 $values = $values . $key ."=" . $value . ',';
            }
           
        }
       
        $query = " update offers set " . substr($values, 0, -1)  .
                " where user_id=$user_id and id=$offer_id";
     
        $result = self::execquery($query);
       	 $errorMessage=  self::$success_edit;;
          include 'views/message/success_message.php';
        return $result;
    }
	
	public static function getverified_code()
	{
		$random_number = intval( rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
		return $random_number;
	}
	
	
	
	
	
/*offers method*/
		private function __clone() {
        
    }

    
    
}

/* * * end of class ** */
?>