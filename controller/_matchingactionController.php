<?php
Class _matchingactionController Extends baseController {

    public function index() {
		
	
	}
	
	
	  public function allprojects() 
		  {
			  // $this->checkuser();
			  $stage_list=$this->registry->objects->replacestr( post('stage_list'));
			  
			  $description=post('description');
			  $countries_list= $this->registry->objects->replacestr( post('countries_list'));
			  
			   $needagent=post('needagent');
			   $needpartner=post('needpartner');

			   $lastprojectid=post('lastprojectid');
			   if ($lastprojectid!=""){$lastprojectid=$this->registry->encryption->decode($lastprojectid);}
			   
			
			$condition="";
			  if ($stage_list!=""){$condition=$condition. ' and Replace( projects.stage_list,\'"\',\'\' ) in (' . $stage_list .')' ;}
			  if ($description!=""){$condition=$condition." and (projects.name  like N'%$description%'  or projects.description  like N'%$description%' )" ;}
			  if ($countries_list!=""){$condition=$condition." and projects.country in (" . $countries_list .")" ;}
			  if ($needagent!=""){$condition=$condition." and needagent=1 "; }//else{$condition=$condition." and needagent=0";}
			  if ($needpartner!=""){$condition=$condition." and needpartner=1 "; }//else{$condition=$condition." and needpartner=0";}
			  if ($lastprojectid!=""){$condition=$condition." and projects.id< $lastprojectid "; }//else{$condition=$condition." and needpartner=0";}
			  $condition=$condition." order by projects.id desc limit 10 ";
			 $projects=  $this->registry->users->getallprojects_search( $condition);
			   
			   
          //$this->registry->template->page_body = getviewslink().'/mooga/wedget/allprojects';
		 
		  $this->registry->template->projects= $projects;
          
          $this->registry->template->show( '/mooga/wedget/allprojects');
		 	   
		  }
	
	
	
	  public function myprojects() 
		  {
			   $this->checkuser();
			  $stage_list=$this->registry->objects->replacestr( post('stage_list'));
			  
			  $description=post('description');
			  $countries_list= $this->registry->objects->replacestr( post('countries_list'));
			  
			   $needagent=post('needagent');
			   $needpartner=post('needpartner');
			   $user_id=$this->getuserid();
				 
			   $lastprojectid=post('lastprojectid');
			   if ($lastprojectid!=""){$lastprojectid=$this->registry->encryption->decode($lastprojectid);}

			   

			  $condition="";
			  $condition=$condition." and user_id=$user_id";
			  if ($stage_list!=""){$condition=$condition. ' and Replace( projects.stage_list,\'"\',\'\' ) in (' . $stage_list .')' ;}
			  if ($description!=""){$condition=$condition." and (projects.name  like N'%$description%'  or projects.description  like N'%$description%' )" ;}
			  if ($countries_list!=""){$condition=$condition." and projects.country in (" . $countries_list .")" ;}
			  if ($needagent!=""){$condition=$condition." and needagent=1 "; }//else{$condition=$condition." and needagent=0";}
			  if ($needpartner!=""){$condition=$condition." and needpartner=1 "; }//else{$condition=$condition." and needpartner=0";}
			  if ($lastprojectid!=""){$condition=$condition." and projects.id< $lastprojectid "; }//else{$condition=$condition." and needpartner=0";}
			  $condition=$condition." order by projects.id desc limit 10 ";
			  
			 $projects=  $this->registry->users->getallprojects_search( $condition);
			   
			
			   
          //$this->registry->template->page_body = getviewslink().'/mooga/wedget/allprojects';
		 
		  $this->registry->template->projects= $projects;
          
          $this->registry->template->show('/mooga/wedget/allprojects');
		 	   
		  }
	
	

	
	  public function allopportunities() 
		  {
			 //  $this->checkuser();
			  $stage_list=$this->registry->objects->replacestr( post('stage_list'));
			  
			  $description=post('description');
			  $expiredate= post('expiredate');
			    $lastopportunityid=post('lastopportunityid');
			   if ($lastopportunityid!=""){$lastopportunityid=$this->registry->encryption->decode($lastopportunityid);}
			   
			   
			  $condition="";
			  
			  if ($description!=""){$condition=$condition." and (opportunities.name  like N'%$description%'  or opportunities.description  like N'%$description%' )" ;}
			  if ($expiredate!=""){$condition=$condition." and DATE_FORMAT( opportunities.expiredate,'%d/%m/%Y') ='".$expiredate."'" ;}
			  if ($lastopportunityid!=""){$condition=$condition." and opportunities.id< $lastopportunityid "; }//else{$condition=$condition." and needpartner=0";}
			   $condition=$condition." order by opportunities.id desc limit 10 ";
			  
			 $opportunities=  $this->registry->users->getallopportunities( $condition);
			   
			   
          //$this->registry->template->page_body = getviewslink().'/mooga/wedget/allprojects';
		 
		  $this->registry->template->opportunities= $opportunities;
          
          $this->registry->template->show('/mooga/wedget/allopportunities');
		 	   
		  }
	
		  public function myopportunities() 
		  {
			   $this->checkuser();
			  $stage_list=$this->registry->objects->replacestr( post('stage_list'));
			  
			  $description=post('description');
			  $expiredate= post('expiredate');
			  $user_id=$this->getuserid();
			   $lastopportunityid=post('lastopportunityid');
			   if ($lastopportunityid!=""){$lastopportunityid=$this->registry->encryption->decode($lastopportunityid);}
			   
			  $condition="";
			  $condition=$condition." and user_id=".$user_id;
			  if ($description!=""){$condition=$condition." and (opportunities.name  like N'%$description%'  or opportunities.description  like N'%$description%' )" ;}
			  if ($expiredate!=""){$condition=$condition." and DATE_FORMAT( opportunities.expiredate,'%d/%m/%Y') ='".$expiredate."'" ;}
			  if ($lastopportunityid!=""){$condition=$condition." and opportunities.id< $lastopportunityid "; }//else{$condition=$condition." and needpartner=0";}
			   $condition=$condition." order by opportunities.id desc limit 10 ";
			   
			 $opportunities=  $this->registry->users->getallopportunities( $condition);
			   
			   
          //$this->registry->template->page_body = getviewslink().'/mooga/wedget/allprojects';
		 
		  $this->registry->template->opportunities= $opportunities;
          
          $this->registry->template->show('/mooga/wedget/allopportunities');
		 	   
		  }
		  
		  
	 public function userssearch() 
		  {
			  
			  $this->checkuser();
			   $id=$this->registry->sessionhandler->get( $this->registry->useridstr);
	             $user_id=$this->registry->encryption->decode($id);
			  
			  
				$userprofile=$this->registry->users->getuserdetails($user_id);
				
				
				$provide_agent_list=$userprofile->provide_agent_list;
				$need_agent_list=$userprofile->need_agent_list;
				$need_product_list=$userprofile->need_product_list;
				$provide_product_list=$userprofile->provide_product_list;
				$worked_country_list=$userprofile->worked_country_list;
				//$country_list=$userprofile->country_list;
				

			
			
			  
			   //	$provide_cosultation_list=$this->fix_search($provide_cosultation_list);
				//$need_cosultation_list=$this->fix_search($need_cosultation_list);
				$provide_agent_list=$this->fix_search($provide_agent_list);
				$need_agent_list=$this->fix_search($need_agent_list);
				$need_product_list=$this->fix_search($need_product_list);
				$provide_product_list=$this->fix_search($provide_product_list);
				$worked_country_list=$this->fix_search($worked_country_list);
				//$country_list=$this->fix_search($country_list);
			   
			   			   $lastuserid=post('lastuserid');
			   if ($lastuserid!=""){$lastuserid=$this->registry->encryption->decode($lastuserid);}
			 
				
			  $condition="";

			 
			//  if(!empty($provide_cosultation_list) ){ $condition=$condition."  and provide_cosultation_list like  $provide_cosultation_list " ;}
			  //  if(!empty($need_cosultation_list) ){ $condition=$condition."  and need_cosultation_list like  $need_cosultation_list " ;}
			      $condition=$condition." and ( users.id=0 ";
				  if(!empty($provide_agent_list) ){ $condition=$condition."  or  need_agent_list  like  $provide_agent_list " ;}
				    if(!empty($need_agent_list) ){ $condition=$condition."  or provide_agent_list like  $need_agent_list " ;}
					  if(!empty($need_product_list) ){ $condition=$condition."  or provide_product_list like  $need_product_list " ;}
					    if(!empty($provide_product_list) ){ $condition=$condition."  or need_product_list  like  $provide_product_list " ;}
						//  if(!empty($worked_country_list) ){ $condition=$condition."  and worked_country_list like  $worked_country_list " ;}
						  // if(!empty($country_list) ){ $condition=$condition."  and country like  $country_list " ;}
						   
						      if(!empty($lastuserid) ){ $condition=$condition."  and users.id < $lastuserid " ;}
						        if (empty($provide_agent_list) && empty($need_agent_list) && empty($need_product_list)&& empty($provide_product_list) ){
									
								}
							  $condition=$condition." ) and ( users.id <> $user_id ) order by users.id desc limit 10 ";
						   
			 
			 // echo $condition;
			 $users=  $this->registry->users->getallusers( $condition);
			   
			   
      
		  $this->registry->template->helper=$this->registry->objects;
		  $this->registry->template->users= $users;
          
          $this->registry->template->show('/mooga/wedget/allusers');
		 	   
		  }
	
	
    public function addopportunity() {
		
		 $this->checkuser();
		$id=$this->registry->sessionhandler->get( $this->registry->useridstr);
		$decoded_id=$this->registry->encryption->decode($id);
	
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
		
	$id=	$this->registry->users->addopportunity($decoded_id,$parameters_db);
	}

}

?>
