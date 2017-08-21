<?php

         $id=$this->registry->sessionhandler->get( $this->registry->useridstr);
	     $profileid=$this->registry->encryption->decode($id);
	     //echo 'profile_id' . $profileid;
	    $user_id=$profileid;
       $result =$this->registry->users->getuserdetails($user_id);
	   $this->registry->template->user= $result;
	      $selectedstate=$result->cities; $selectedcity=$result->states;
		   /******************************************************************/
        /*get worked_country */	  
		
 	   $countries_json=json_encode($this->registry->helper->getcountries_names());
	    $worked_country_list=$result->worked_country_list;
	    $worked_country_list =$this->merge_json_array($countries_json,$worked_country_list);
		
	    $this->registry->template->worked_country_list= $worked_country_list ;

		  /*get cosultation  */	  
		  
		    $cosultation_json=json_encode($this->registry->helper->getconsultation_field());
			
		    $provide_cosultation_list=$result->provide_cosultation_list;
	        $provide_cosultation_list =$this->merge_json_array($cosultation_json,$provide_cosultation_list);
		     $this->registry->template->provide_cosultation_list= $provide_cosultation_list ;
			 
			  $need_cosultation_list=$result->need_cosultation_list;
		       $need_cosultation_list =$this->merge_json_array($cosultation_json,$need_cosultation_list);
			   $this->registry->template->need_cosultation_list= $need_cosultation_list ;
			     /*get agent  */	  
			   
			     $agent_json=json_encode($this->registry->helper->getagent_field());
				 
				 $provide_agent_list=$result->provide_agent_list;
	             $provide_agent_list =$this->merge_json_array($agent_json,$provide_agent_list);
		        $this->registry->template->provide_agent_list= $provide_agent_list ; 

                 $need_agent_list=$result->need_agent_list;
	             $need_agent_list =$this->merge_json_array($agent_json,$need_agent_list);
		        $this->registry->template->need_agent_list= $need_agent_list ; 	

            /*get product  */	
			     $products_json=json_encode($this->registry->helper->getproducts_field());
				 
				 $provide_product_list=$result->provide_product_list;
	             $provide_product_list =$this->merge_json_array($products_json,$provide_product_list);
		        $this->registry->template->provide_product_list= $provide_product_list ; 

                 $need_product_list=$result->need_product_list;
	             $need_product_list =$this->merge_json_array($products_json,$need_product_list);
		        $this->registry->template->need_product_list= $need_product_list ; 					
			   /******************************************************************/
			      $this->registry->template->countries=$this->registry->helper->getcountries();
?>
