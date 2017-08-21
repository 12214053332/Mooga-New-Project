<?php
Class _searchactionController Extends baseController {

    public function index() {
		
	
	}
	
	
	  public function allprojects() 
		  {
			  // $this->checkuser();
			/*  $stage_list=$this->registry->objects->replacestr( post('stage_list'));
			  
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
          
          $this->registry->template->show( '/mooga/wedget/allprojects');*/
		 	   
			   	//		   $this->checkuser();
			  $stage_list=$this->registry->objects->replacestr( post('stage_list'));
			  
			  $description=post('name');
			   $project_type=post('project_type');
			    $project_field=post('project_field');
				 $country=post('country');
				 $states=post('states');
				 $cities=post('cities');
				 
			  $countries_list= $this->registry->objects->replacestr( post('countries_list'));
			  
			   $needagent=post('needagent');
			   
			   $needpartner=post('needpartner');
			    $needfunder=post('needfunder');
				   $needbuyer=post('needbuyer');
				$frombudget=post('frombudget');
			   $tobudget=post('tobudget');
			   
			
			   $user_id=$this->getuserid();
				 
			   $lastprojectid=post('lastprojectid');
			   if ($lastprojectid!=""){$lastprojectid=$this->registry->encryption->decode($lastprojectid);}

			   

			  $condition=" and IFNULL(projects.pending,0)=0 ";
			  //$condition=$condition." and user_id=$user_id";
			 
			  if ($stage_list !="" && str_replace( $stage_list,'"','' )!="" ){$condition=$condition. ' and Replace( projects.stage_list,\'"\',\'\' ) in (' . $stage_list .')' ;}
			  if ($description!=""){$condition=$condition." and (projects.name  like N'%$description%'  or projects.description  like N'%$description%' )" ;}
			 // if ($countries_list!=""){$condition=$condition." and projects.country in (" . $countries_list .")" ;}
			  if ($project_type!=""){$condition=$condition.' and Replace( projects.project_type_list,\'"\',\'\' )  in ('."'$project_type'".')' ;}
			  if ($project_field!=""){$condition=$condition.' and Replace( projects.project_field_list,\'"\',\'\' )  in ('."'$project_field'".')' ;}
			  
			  if ($country!=""){$condition=$condition." and projects.country in (" . $country .")" ;}
			  if ($states!=""){$condition=$condition." and projects.states in (" . $states .")" ;}
			  if ($cities!=""){$condition=$condition." and projects.cities in (" . $cities .")" ;}
			      if ($frombudget!="" && $tobudget!=""){$condition=$condition." and (projects.budget between $frombudget and $tobudget) " ;}
			  if ($needagent!=""){$condition=$condition." and needagent=1 "; }//else{$condition=$condition." and needagent=0";}
			  //if ($needpartner!=""){$condition=$condition." and needpartner=1 "; }//else{$condition=$condition." and needpartner=0";}
			  if ($needfunder!=""){$condition=$condition." and needfunder=1 "; }
			  if ($needbuyer!=""){$condition=$condition." and needbuyer=1 "; }
			  
			  if ($lastprojectid!=""){$condition=$condition." and projects.id< $lastprojectid "; }//else{$condition=$condition." and needpartner=0";}
			  $condition=$condition." order by projects.id desc limit 10 ";
			//echo  $condition;
			 $projects=  $this->registry->users->getallprojects_search( $condition);
			   
			
			   
          //$this->registry->template->page_body = getviewslink().'/mooga/wedget/allprojects';
		 
		  $this->registry->template->projects= $projects;
          
          $this->registry->template->show('/mooga/wedget/allprojects');
		  }
	public function allarticles()
	{
		$lastarticleid=post('lastarticleid');
		$catid=post('catid');
		if ($lastarticleid!=""){$lastarticleid=$this->registry->encryption->decode($lastarticleid);}
		if ($catid!=""){$catid=$this->registry->encryption->decode($catid);}
		$category_data=  $this->registry->articles->getarticlesLimit_bycategoryid($catid, "and articles.id< $lastarticleid order by articles.id desc limit 10 ");
		$this->registry->template->category_data= $category_data;
		$this->registry->template->catid= $this->registry->encryption->encode($catid);
		//print_r($category_data);
		$this->registry->template->show('/mooga/wedget/allarticles');
	}

	  public function myprojects() 
		  {
			   $this->checkuser();
			  $stage_list=$this->registry->objects->replacestr( post('stage_list'));
			  
			  $description=post('name');
			   $project_type=post('project_type');
			    $project_field=post('project_field');
				 $country=post('country');
				 $states=post('states');
				 $cities=post('cities');
				 
			  $countries_list= $this->registry->objects->replacestr( post('countries_list'));
			  
			   $needagent=post('needagent');
			   
			   $needpartner=post('needpartner');
			    $needfunder=post('needfunder');
				   $needbuyer=post('needbuyer');
				
			   $user_id=$this->getuserid();
				 
			   $lastprojectid=post('lastprojectid');
			   if ($lastprojectid!=""){$lastprojectid=$this->registry->encryption->decode($lastprojectid);}

			   

			  $condition="";
			  $condition=$condition." and user_id=$user_id";
			  if ($stage_list!=""){$condition=$condition. ' and Replace( projects.stage_list,\'"\',\'\' ) in (' . $stage_list .')' ;}
			  if ($description!=""){$condition=$condition." and (projects.name  like N'%$description%'  or projects.description  like N'%$description%' )" ;}
			 // if ($countries_list!=""){$condition=$condition." and projects.country in (" . $countries_list .")" ;}
			  if ($country!=""){$condition=$condition." and projects.country in (" . $country .")" ;}
			  if ($needagent!=""){$condition=$condition." and needagent=1 "; }//else{$condition=$condition." and needagent=0";}
			  //if ($needpartner!=""){$condition=$condition." and needpartner=1 "; }//else{$condition=$condition." and needpartner=0";}
			  if ($needfunder!=""){$condition=$condition." and needfunder=1 "; }
			  if ($needbuyer!=""){$condition=$condition." and needbuyer=1 "; }
			  
			  if ($lastprojectid!=""){$condition=$condition." and projects.id< $lastprojectid "; }//else{$condition=$condition." and needpartner=0";}
			  $condition=$condition." order by projects.id desc limit 10 ";
			//  echo  $condition;
			 $projects=  $this->registry->users->getallprojects_search( $condition);
			   
			
			   
          //$this->registry->template->page_body = getviewslink().'/mooga/wedget/allprojects';
		 
		  $this->registry->template->projects= $projects;
          
          $this->registry->template->show('/mooga/wedget/allprojects');
		 	   
		  }
	
	
	
			
	  public function alloffers() 
		  {
			
		 // $this->checkuser();
			  //$stage_list=$this->registry->objects->replacestr( post('stage_list'));
			   $offer_type_filed=post('offer_type_filed');
			  $item_brand=post('item_brand');
			   $item_type=post('item_type');
			    $name=post('name');
			    $description=post('description');
				 $country=post('country');
				 $states=post('states');
				 $cities=post('cities');
			   $user_id=$this->getuserid();
				 
			   $lastofferid=post('lastofferid');
			   if ($lastofferid!=""){$lastofferid=$this->registry->encryption->decode($lastofferid);}

			   

			  $condition=" and IFNULL(offers.pending,0)=0 ";
			  //$condition=$condition." and user_id=$user_id";
			  //if ($stage_list!=""){$condition=$condition. ' and Replace( projects.stage_list,\'"\',\'\' ) in (' . $stage_list .')' ;}

			  if ($offer_type_filed!=""){$condition=$condition." and (offers.offer_type_filed  like N'%$offer_type_filed%'  )" ;}
			  if ($name!=""){$condition=$condition." and (offers.name  like N'%$name%'  )" ;}
			  if ($description!=""){$condition=$condition." and (offers.description  like N'%$description%'  )" ;}

			  if ($item_brand!=""){$condition=$condition." and (offers.item_brand  like N'%$item_brand%'  )" ;}
			  if ($item_type!=""){$condition=$condition." and (offers.item_type  like N'%$item_type%'  )" ;}
			
			  if ($country!=""){$condition=$condition." and offers.country in (" . $country .")" ;}
			    if ($states!=""){$condition=$condition." and offers.states in (" . $states .")" ;}
				  if ($cities!=""){$condition=$condition." and offers.cities in (" . $cities .")" ;}
			 
			  if ($lastofferid!=""){$condition=$condition." and offers.id< $lastofferid "; }//else{$condition=$condition." and needpartner=0";}
			  $condition=$condition." order by offers.id desc limit 10 ";
			  //echo  $condition;

			 $offers=  $this->registry->users->getalloffers_search( $condition);
			   
			
			   
          //$this->registry->template->page_body = getviewslink().'/mooga/wedget/allprojects';
		 
		  $this->registry->template->offers= $offers;
          
          $this->registry->template->show('/mooga/wedget/alloffers');
		  }
	
	
	
	  public function myoffers() 
		  {
			   $this->checkuser();
			  $stage_list=$this->registry->objects->replacestr( post('stage_list'));
			  
			  $offer_type_filed=post('offer_type_filed');
			  $item_brand=post('item_brand');
			   $item_type=post('item_type');
			    $name=post('name');
				
				 $country=post('country');
				 $states=post('states');
				 $cities=post('cities');
				 $user_id=$this->getuserid();
				 
				 
			   $lastofferid=post('lastofferid');
			   if ($lastofferid!=""){$lastofferid=$this->registry->encryption->decode($lastofferid);}

			  $condition="";
			  $condition=$condition." and user_id=$user_id";
			   if ($offer_type_filed!=""){$condition=$condition." and (offers.offer_type_filed  like N'%$offer_type_filed%'  )" ;}
			  if ($name!=""){$condition=$condition." and (offers.name  like N'%$name%'  )" ;}
			  if ($item_brand!=""){$condition=$condition." and (offers.item_brand  like N'%$item_brand%'  )" ;}
			  if ($item_type!=""){$condition=$condition." and (offers.item_type  like N'%$item_type%'  )" ;}
			  if ($country!=""){$condition=$condition." and offers.country in (" . $country .")" ;}
			    if ($states!=""){$condition=$condition." and offers.states in (" . $states .")" ;}
				  if ($cities!=""){$condition=$condition." and offers.cities in (" . $cities .")" ;}
			 
			  if ($lastofferid!=""){$condition=$condition." and offers.id< $lastofferid "; }//else{$condition=$condition." and needpartner=0";}
			  $condition=$condition." order by offers.id desc limit 10 ";
			 // echo  $condition;
			 $offers=  $this->registry->users->getalloffers_search( $condition);
			   
			
			   
          //$this->registry->template->page_body = getviewslink().'/mooga/wedget/allprojects';
		 
		  $this->registry->template->offers= $offers;
          
          $this->registry->template->show('/mooga/wedget/alloffers');
		 	   
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
				
				$provide_cosultation_list=post('provide_cosultation_list');
				$need_cosultation_list=post('need_cosultation_list');
				$provide_agent_list=post('provide_agent_list');
				$need_agent_list=post('need_agent_list');
				$need_product_list=post('need_product_list');
				$provide_product_list=post('provide_product_list');
				$worked_country_list=post('worked_country_list');
				$country_list=post('country_list');
				

			
			
			  
			   	$provide_cosultation_list=$this->fix_search($provide_cosultation_list);
				$need_cosultation_list=$this->fix_search($need_cosultation_list);
				$provide_agent_list=$this->fix_search($provide_agent_list);
				$need_agent_list=$this->fix_search($need_agent_list);
				$need_product_list=$this->fix_search($need_product_list);
				$provide_product_list=$this->fix_search($provide_product_list);
				$worked_country_list=$this->fix_search($worked_country_list);
				$country_list=$this->fix_search($country_list);
			   
			   			   $lastuserid=post('lastuserid');
			   if ($lastuserid!=""){$lastuserid=$this->registry->encryption->decode($lastuserid);}
			 
				
			  $condition="";

			 
			//  if(!empty($provide_cosultation_list) ){ $condition=$condition."  and provide_cosultation_list like  $provide_cosultation_list " ;}
			  //  if(!empty($need_cosultation_list) ){ $condition=$condition."  and need_cosultation_list like  $need_cosultation_list " ;}
				  if(!empty($provide_agent_list) ){ $condition=$condition."  and provide_agent_list like  $provide_agent_list " ;}
				    if(!empty($need_agent_list) ){ $condition=$condition."  and need_agent_list like  $need_agent_list " ;}
					  if(!empty($need_product_list) ){ $condition=$condition."  and need_product_list like  $need_product_list " ;}
					    if(!empty($provide_product_list) ){ $condition=$condition."  and provide_product_list like  $provide_product_list " ;}
						  if(!empty($worked_country_list) ){ $condition=$condition."  and worked_country_list like  $worked_country_list " ;}
						   if(!empty($country_list) ){ $condition=$condition."  and country like  $country_list " ;}
						   
						      if(!empty($lastuserid) ){ $condition=$condition."  and users.id < $lastuserid " ;}
						      $condition=$condition." order by users.id desc limit 10 ";
						   
			 
			  //echo $condition;
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
