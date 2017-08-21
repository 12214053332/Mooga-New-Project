<?php

class objects  {
    /*     * * Declare instance ** */

	   private $firstName_json = '"name":"firstname"';
	   private $Name_json = '"name":"name"';
	   private $password_json = '"name":"password"';
	   private $confirmpassword_json = '"name":"confirmpassword"';
       private $lastname_json = '"name":"lastname"';
	   private $phone_json = '"name":"phone"'; 
	   private $country_json = '"name":"country"';
	   private $states_json = '"name":"states"';
	    private $country_1_json = '"name":"country_1"';
       private  $email_json = '"name":"email"';
	    private  $price_json = '"name":"price"';
		private  $budget_json = '"name":"budget"';
       private  $identification_json = '"name":"identification"';
	   private  $gender_json = '"name":"gender"';
	   private  $agree_json = '"name":"agree"';
	   private  $marital_status_json = '"name":"marital_status"';
       // private $contry_json = '"name":"contry"';
      private  $facebook_json='"name":"facebook"';
      private   $linkedin_json='"name":"linkedin"';
      private    $accountstatus_json='"name":"accountstatus"';
      private  $login_type_json='"name":"login_type"'; 
	  private  $type_json='"name":"type"'; 
	  private  $provide_cosultation_list_json='"name":"provide_cosultation_list"'; 
	  private  $need_cosultation_list_json='"name":"need_cosultation_list"'; 
	  private  $provide_agent_list_json='"name":"provide_agent_list"'; 
	  private  $need_agent_list_json='"name":"need_agent_list"';   
	  private  $provide_product_list_json='"name":"provide_product_list"'; 
	  private  $need_product_list_json='"name":"need_product_list"'; 
	  private  $worked_country_list_json='"name":"worked_country_list"';
	  private  $project_type_list_json='"name":"project_type_list"';
	  private  $project_field_list_json='"name":"project_field_list"';
	  private  $description_json='"name":"description"';
	  private  $project_product_list_json='"name":"project_product_list"';
	  private  $project_service_list_json='"name":"project_service_list"';
	  private  $needagent_json='"name":"needagent"';
	  private  $needpartner_json='"name":"needpartner"';
	  private  $needfunder_json='"name":"needfunder"';
	  private  $needdealer_json='"name":"needdealer"';
	  private  $needbuyer_json='"name":"needbuyer"';
	  private  $needclose_json='"name":"needclose"';
	  private  $closedescription_json='"name":"closedescription"';
	   private  $needdescription_json='"name":"needdescription"';
	   private  $account_type_json='"name":"account_type"';
	  private  $stage_list_json='"name":"stage_list"';
	  private  $job_title_json='"name":"job_title"';
	  private  $FBID_json='"name":"FBID"';
	   private  $expiredate_json='"name":"expiredate"';
	   
	   
	    private  $user1_id_json='"name":"user1_id"';
		 private  $user2_id_json='"name":"user2_id"';
		  private  $title_json='"name":"title"';
		   private  $message_json='"name":"message"';
		    private  $msg_id_reply_json='"name":"msg_id_reply"';
			 private  $msgtime_json='"name":"msgtime_reply"';
			 
			 private  $isconsaltant_json='"name":"isconsaltant"';
			 private  $isagent_json='"name":"isagent"';
			 private  $isinvestor_json='"name":"isinvestor"';
			 private  $isbusinessman_json='"name":"isbusinessman"';
			 private  $isprovider_json='"name":"isprovider"';
			 private  $isproductowner_json='"name":"isproductowner"';
			 
			 private  $offer_type_filed_json='"name":"offer_type_filed"';
   			 private  $item_type_json='"name":"item_type"';
			  private  $item_brand_json='"name":"item_brand"';
			   private  $min_qty_json='"name":"min_qty"';
			 private  $state_json='"name":"state"';
			 private  $cities_json='"name":"cities"';
			 private  $contact_name_json='"name":"contact_name"';
			 private  $contact_phone_json='"name":"contact_phone"';
            private  $contact_email_json='"name":"contact_email"';
		    private  $contact_type_json='"name":"contact_type"';
		/*data type*/
		
		private  $dbstring = '"type":"string"';
       private  $dbinteger = '"type":"integer"';
	   
	   private  $required = '"requier":"required"';

    /**
     *
     * the constructor is set to private so
     * so nobody can create a new instance using new
     *
     */

    
	  
    public function __construct() {
  /*** maybe set the db name here later ***/
	 
	}

	public function contactus()
	{
			$parameters = array('{' . "$this->Name_json,$this->dbstring"  .'}',
            '{' . "$this->email_json,$this->dbstring" .'}',
			 '{' . "$this->type_json,$this->dbstring" . '}',
			  '{' . "$this->phone_json,$this->dbstring" . '}',
            '{' . "$this->message_json,$this->dbstring" . '}');
			return $parameters;
	}
	public function register()
	{
		//echo '{' . "$this->firstName_json,$this->dbstring" . '}';
		$parameters = array('{' . "$this->Name_json,$this->dbstring" . ",$this->required" . '}',
            '{' . "$this->phone_json,$this->dbstring"  . ",$this->required" . '}',
            '{' . "$this->email_json,$this->dbstring" .",$this->required" . '}',
            '{' . "$this->identification_json,$this->dbstring" . '}',
            '{' . "$this->agree_json,$this->dbstring" . ",$this->required" . '}',
            '{' . "$this->country_json,$this->dbstring" . ",$this->required" . '}',
			'{' . "$this->states_json,$this->dbstring" . ",$this->required" . '}',
			'{' . "$this->cities_json,$this->dbstring" . ",$this->required" . '}',
			
             '{' . "$this->password_json,$this->dbstring" . ",$this->required" . '}',
			   '{' . "$this->accountstatus_json,$this->dbstring" . '}',
			      '{' . "$this->facebook_json,$this->dbstring" . '}',
			     '{' . "$this->linkedin_json,$this->dbstring" . '}', 
				 '{' . "$this->account_type_json,$this->dbstring" . '}',
				  '{' . "$this->job_title_json,$this->dbstring" . '}',
				  
				    '{' . "$this->isconsaltant_json,$this->dbinteger" . '}',
					 '{' . "$this->isagent_json,$this->dbinteger" . '}',
					  '{' . "$this->isbusinessman_json,$this->dbinteger" . '}',
					   '{' . "$this->isinvestor_json,$this->dbinteger" . '}',
					    '{' . "$this->isprovider_json,$this->dbinteger" . '}',
					    '{' . "$this->isproductowner_json,$this->dbinteger" . '}',
			
        );
		
		return $parameters ;
	}
	
	public function message()
	{
		//echo '{' . "$this->firstName_json,$this->dbstring" . '}';
		$parameters = array('{' . "$this->user1_id_json,$this->dbstring"  . '}',
            '{' . "$this->user2_id_json,$this->dbstring"  . '}',
            '{' . "$this->title_json,$this->dbstring"  . '}',
            '{' . "$this->message_json,$this->dbstring" . '}',
            '{' . "$this->msg_id_reply_json,$this->dbstring" . '}',
            '{' . "$this->msgtime_json,$this->dbstring" . '}',
             
        );
		return $parameters ;
	}
	public function login()
	{
		//echo '{' . "$this->firstName_json,$this->dbstring" . '}';
		$parameters = array('{' . "$this->email_json,$this->dbstring" . ",$this->required" . '}',
            '{' . "$this->password_json,$this->dbstring"  . ",$this->required" . '}',
           
           
        );
		
		return $parameters ;
	}
	
		public function userdetails()
	{
		//echo '{' . "$this->firstName_json,$this->dbstring" . '}';
		$parameters = array('{' . "$this->provide_cosultation_list_json,$this->dbstring"  . '}',
		'{' . "$this->need_cosultation_list_json,$this->dbstring"  . '}',
		'{' . "$this->provide_agent_list_json,$this->dbstring"  . '}',
		'{' . "$this->need_agent_list_json,$this->dbstring"  . '}',
            '{' . "$this->provide_product_list_json,$this->dbstring"  . '}',
		'{' . "$this->need_product_list_json,$this->dbstring"  . '}',
           '{' . "$this->worked_country_list_json,$this->dbstring"  . '}',
        );
		
		return $parameters ;
	}
    
		public function addoffer()
	{
		//echo '{' . "$this->firstName_json,$this->dbstring" . '}';
		$parameters = array('{' . "$this->Name_json,$this->dbstring"  . '}',
		'{' . "$this->offer_type_filed_json,$this->dbstring"  . '}',
		'{' . "$this->item_type_json,$this->dbstring"  . '}',
		'{' . "$this->item_brand_json,$this->dbstring"  . '}',
		'{' . "$this->price_json,$this->dbstring"  . '}',
		'{' . "$this->min_qty_json,$this->dbstring"  . '}',
		'{' . "$this->description_json,$this->dbstring"  . '}',
        '{' . "$this->country_json,$this->dbstring"  . '}',
		'{' . "$this->states_json,$this->dbstring"  . '}',
		'{' . "$this->cities_json,$this->dbstring"  . '}',	 
        '{' . "$this->contact_name_json,$this->dbstring"  . '}',
		'{' . "$this->contact_phone_json,$this->dbstring"  . '}',
		'{' . "$this->contact_email_json,$this->dbstring"  . '}',
         '{' . "$this->contact_type_json,$this->dbstring"  . '}',
		  '{' . "$this->country_1_json,$this->dbstring"  . '}',
        );
		
		return $parameters ;
	}
  
		public function addproject()
	{
		//echo '{' . "$this->firstName_json,$this->dbstring" . '}';
		$parameters = array('{' . "$this->Name_json,$this->dbstring"  . '}',
		'{' . "$this->project_type_list_json,$this->dbstring"  . '}',
		'{' . "$this->project_field_list_json,$this->dbstring"  . '}',
		'{' . "$this->description_json,$this->dbstring"  . '}',
        '{' . "$this->country_json,$this->dbstring"  . '}',
		'{' . "$this->states_json,$this->dbstring"  . '}',
		'{' . "$this->cities_json,$this->dbstring"  . '}',
		'{' . "$this->stage_list_json,$this->dbstring"  . '}',
        //'{' . "$this->project_product_list_json,$this->dbstring"  . '}',
	    //'{' . "$this->project_service_list_json,$this->dbstring"  . '}',
		'{' . "$this->needagent_json,$this->dbstring"  . '}',	 
        '{' . "$this->needpartner_json,$this->dbstring"  . '}',
		'{' . "$this->needfunder_json,$this->dbstring"  . '}',
		'{' . "$this->needbuyer_json,$this->dbstring"  . '}',
		'{' . "$this->needdealer_json,$this->dbstring"  . '}',
	    '{' . "$this->needclose_json,$this->dbstring"  . '}',	
		'{' . "$this->closedescription_json,$this->dbstring"  . '}',	
		'{' . "$this->contact_name_json,$this->dbstring"  . '}',
		'{' . "$this->contact_phone_json,$this->dbstring"  . '}',
		'{' . "$this->contact_type_json,$this->dbstring"  . '}',
		'{' . "$this->contact_email_json,$this->dbstring"  . '}',
		'{' . "$this->needdescription_json,$this->dbstring"  . '}',
         '{' . "$this->budget_json,$this->dbstring"  . '}',	
		 '{' . "$this->country_1_json,$this->dbstring"  . '}',	
        );

		
		return $parameters ;
	}
    
  public function addopportunity()
	{
		//echo '{' . "$this->firstName_json,$this->dbstring" . '}';
		$parameters = array('{' . "$this->Name_json,$this->dbstring"  . '}',
		'{' . "$this->description_json,$this->dbstring"  . '}',
		
        '{' . "$this->expiredate_json,$this->dbstring"  . '}',
        );
		
		return $parameters ;
	}
    
	
	public function addproduct()
	{
		//echo '{' . "$this->firstName_json,$this->dbstring" . '}';
		$parameters = array('{' . "$this->Name_json,$this->dbstring"  . '}',
		'{' . "$this->description_json,$this->dbstring"  . '}',
		
		);
		
		return $parameters ;
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
	 
	 public function getoptions_single($source,$values)
	 {
         try{		
		//$source = json_decode($source);
		 // $values = json_decode($values);
		 $exist=FALSE;
		 if ($source!=""){
		 foreach ($source as $obj)
           {
				
			    $selectedstr="";
				
					 if ($values==$obj['id'])
					 {
						  $selectedstr="selected";
					 }
				
				 $id=$obj['id'];
				 $name=$obj['name'];
				 echo "<option value='$id' $selectedstr> $name</option> ";
		   }
		 }
         }
      catch(Exception $e) {
              //echo 'Message: ' .$e->getMessage();
          }

	 }
	 
	 public function getoptions($source,$values)
	 {
		// echo $values;
         try{		
		$source = json_decode($source);
		  $values = json_decode($values);
		 $exist=FALSE;
		 if ($source!=""){
		 foreach ($source as $obj)
           {
				
			    $selectedstr="";
				if ($values!=""){
				 foreach ($values as $selected)
				 {
					
					 if ($selected==$obj)
					 {
						  $selectedstr="selected";
					 }
				}
				}
				 
				 echo "<option value='$obj' $selectedstr>$obj</option> ";
		   }
		 }
         }
      catch(Exception $e) {
              //echo 'Message: ' .$e->getMessage();
          }

	 }
	 
	 	 public function getlist($source)
	 {
         try{		
		$source = json_decode($source);
		 
		 $exist=FALSE;
		 if ($source!=""){
		 foreach ($source as $obj)
           {
			  
				 
				 echo "<li>$obj</li> ";
		   }
		 }
         }
      catch(Exception $e) {
              //echo 'Message: ' .$e->getMessage();
          }

	 }
	 
	 public function getoptions_p($source,$values="")
	 {
		   try{	
		 $source = json_decode($source);
		 // $values = json_decode($values);
		 //$exist=FALSE;
		if ($source!=""){
		 foreach ($source as $obj)
           {
			 //   $selectedstr="";
			//	if ($values!=""){
			//	 foreach ($values as $selected)
				// {
					// if ($selected==$obj)
					// {
					///	  $selectedstr="selected";
					 //}
				 //}
				//}
				 echo "  <p class='text-center grey-font md-font float-right'>$obj</p> ";
		   }
		}
		   }
      catch(Exception $e) {
             //echo 'Message: ' .$e->getMessage();
         }
	 }
	 
	 public function getspan($source,$values="")
	 {
		   try{	
		 $source = json_decode($source);
		 // $values = json_decode($values);
		 //$exist=FALSE;
		if ($source!=""){
		 foreach ($source as $obj)
           {
			 //   $selectedstr="";
			//	if ($values!=""){
			//	 foreach ($values as $selected)
				// {
					// if ($selected==$obj)
					// {
					///	  $selectedstr="selected";
					 //}
				 //}
				//}
				 echo " <span class='label label-default'>$obj</span>";
		   }
		}
		   }
      catch(Exception $e) {
             //echo 'Message: ' .$e->getMessage();
         }
	 }
	 
	 	 public function check_value($value)
	 {
		   try{	
		            if ($value==1)echo 'checked' ;
						
		   }
      catch(Exception $e) {
             //echo 'Message: ' .$e->getMessage();
         }
	 }
	 
	  public function replacestr($source)
	  {
		  if ($source=="null") return "";
		  return str_replace("]","", str_replace("[","",$source));
	  }
	  
	  public function replace_qute($source)
	  {
		  if ($source=="null") return "";
		  return str_replace('"',"",$source);
	  }
	  
	  
	  		 public function timeAgo($datetime, $full = false) {
				 $now = new DateTime;
				 $ago = new DateTime($datetime);
				 $diff = $now->diff($ago);

				 $diff->w = floor($diff->d / 7);
				 $diff->d -= $diff->w * 7;

				 $string = array(
						 'y' => 'سنه',
						 'm' => 'شهر',
						 'w' => 'اسبوع',
						 'd' => 'يوم',
						 'h' => 'ساعة',
						 'i' => 'دقيقه',
						 's' => 'ثانيه',
				 );
				 foreach ($string as $k => &$v) {
					 if ($diff->$k) {
						 $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
					 } else {
						 unset($string[$k]);
					 }
				 }

				 if (!$full) $string = array_slice($string, 0, 1);
				 return $string ?   '  منذ '.implode(', ', $string): 'الأن';
			 }
	public function generateCSF(){
		$token = md5(uniqid(rand(), TRUE));
		$_SESSION['tokenNumber'] = $token;
		$_SESSION['tokenNumberTime'] = time();
		return$token;
	}
		public function __html($text, $length = 100, $options = array()) {
			$default = array(
				'ending' => '...', 'exact' => true, 'html' => false
			);
			$options = array_merge($default, $options);
			extract($options);

			if ($html) {
				if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
					return $text;
				}
				$totalLength = mb_strlen(strip_tags($ending));
				$openTags = array();
				$truncate = '';

				preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
				foreach ($tags as $tag) {
					if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
						if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
							array_unshift($openTags, $tag[2]);
						} else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
							$pos = array_search($closeTag[1], $openTags);
							if ($pos !== false) {
								array_splice($openTags, $pos, 1);
							}
						}
					}
					$truncate .= $tag[1];

					$contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
					if ($contentLength + $totalLength > $length) {
						$left = $length - $totalLength;
						$entitiesLength = 0;
						if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
							foreach ($entities[0] as $entity) {
								if ($entity[1] + 1 - $entitiesLength <= $left) {
									$left--;
									$entitiesLength += mb_strlen($entity[0]);
								} else {
									break;
								}
							}
						}

						$truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
						break;
					} else {
						$truncate .= $tag[3];
						$totalLength += $contentLength;
					}
					if ($totalLength >= $length) {
						break;
					}
				}
			} else {
				if (mb_strlen($text) <= $length) {
					return $text;
				} else {
					$truncate = mb_substr($text, 0, $length - mb_strlen($ending));
				}
			}
			if (!$exact) {
				$spacepos = mb_strrpos($truncate, ' ');
				if (isset($spacepos)) {
					if ($html) {
						$bits = mb_substr($truncate, $spacepos);
						preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
						if (!empty($droppedTags)) {
							foreach ($droppedTags as $closingTag) {
								if (!in_array($closingTag[1], $openTags)) {
									array_unshift($openTags, $closingTag[1]);
								}
							}
						}
					}
					$truncate = mb_substr($truncate, 0, $spacepos);
				}
			}
			$truncate .= $ending;

			if ($html) {
				foreach ($openTags as $tag) {
					$truncate .= '</'.$tag.'>';
				}
			}

			return $truncate;
		}


    private function __clone() {
        
    }

    
    
}

/* * * end of class ** */
?>