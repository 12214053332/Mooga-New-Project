<?php

Abstract Class baseController {

/*
 * @registry object
 */
protected $registry;

function __construct($registry) {
    error_reporting(0);
	$this->registry = $registry;
         $this->registry->template->currentpage=get('page');
       $userlink=  get('user');
       if ($userlink>0){$this->registry->sessionhandler->put( $this->registry->useridstr,$userlink);}
         if (self::getuserid()>0){
        self::initialdata();}
      
}
public function getuserid()
        {
             $id=$this->registry->sessionhandler->get( $this->registry->useridstr);
             return $id;
        }

        
 public function initialdata()
 {
     
      
        
       $profileid=$this->registry->encryption->decode(get('sid'));
             $id=$this->registry->sessionhandler->get( $this->registry->useridstr);
       $parameters=array();
       $allmyleads = $this->registry->leads->getleads($id,$parameters);
       $found=FALSE;
      
       

           foreach($allmyleads as $lead){
               if ($lead["lead_id"]==$profileid)
               {
                    $found=TRUE;
               }
           }
              
       if ( $found===FALSE)
       {
             $profileid=$id;
       }     
       
      
       // echo $profileid. '.' . $id;
         $parameters1=array();
          $this->registry->template->sidebarleads = $this->registry->leads->getleads($id,$parameters1);
      
        
        if ($profileid==$id || $profileid=="" ||$profileid==0 ){$Ismyprofile=TRUE;}  else {$Ismyprofile=FALSE;}
        $messagecount=$this->registry->message->get_count_message($id);
        $sidebarmessage=$this->registry->message->get_inbox_message($id);
        $acountname=$this->registry->companies->get_acount_type($id);
        
        $result=$this->registry->companies->getcompany($id);
        
        $company=$result['company'];
        $services=$result['services'];
        $gives=$result['gives'];
    if ($profileid>0){
        $profileresult=$this->registry->companies->getcompany($profileid);
        $profilecompany=$profileresult['company'];
        $profileservices=$profileresult['services'];
        $profilegives=$profileresult['gives'];
    }
 else {
           
       $profilecompany=$company;
        $profileservices=$services;
        $profilegives=$gives;
    }
    
        //$this->registry->template->blog_heading = 'This is the blog Index';
        $this->registry->template->page_body = '/../user/myprofile';
       // $this->registry->template->allservices =$this->registry->companies->getallservices();  
        // $this->registry->template->allcountry =$this->registry->companies->getallcountry();  
        $this->registry->template->company=$company;
        $this->registry->template->services=$services;
        $this->registry->template->gives=$gives;
        
        $this->registry->template->company_profile=$profilecompany;
        $this->registry->template->services_profile=$profileservices;
        $this->registry->template->gives_profile=$profilegives;
        
        $this->registry->template->messagecount=$messagecount;
         $this->registry->template->sidebarmessage=$sidebarmessage;
         
        $this->registry->template->account_type=$acountname;
         $this->registry->template->Ismyprofile=$Ismyprofile;
         
 }

 
 public  function checkuser()
 {
     if (self::getuserid()>0){
        self::initialdata();}
        else {
            $currentpage=$this->registry->template->currentpage=get('page');
            if ($currentpage!='index'&&$currentpage!=''&&$currentpage!='contact'
                &&$currentpage!='faqs'&&$currentpage!='about' &&$currentpage!='fb'    ) 
            header('Location:?page=index');
                        
        }
 }
 /**
 * @all controllers must contain an index method
 */
abstract function index();
}

function getviewslink()
{
    return 'views';
}
{
    
}
		function check_input($value)
		{
			// Stripslashes
			if (get_magic_quotes_gpc())
			  {
			  $value = stripslashes($value);
			  }
			// Quote if not a number
	
			return $value;
		}
		
	  function get($key)
		{
			$value="";
			// Stripslashes
			if (isset($_GET[$key]))
			  {
			    $value = stripslashes($_GET[$key]);
			  }
			// Quote if not a number
	
			return $value;
		}
		
		 function post($key)
		{
			$value="";
			// Stripslashes
			if (isset($_POST[$key]))
			  {
			    $value = stripslashes($_POST[$key]);
			  }
			// Quote if not a number
	
			return $value;
		}


