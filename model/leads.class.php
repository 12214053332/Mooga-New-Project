<?php

class leads extends db {
    /*     * * Declare instance ** */

    private static $success_message = "your transaction are success";
    private static $emailexsist_message = "this email exist before";

    /**
     *
     * the constructor is set to private so
     * so nobody can create a new instance using new
     *
     */
    private  static $encryption;
    public function __construct() {
  /*** maybe set the db name here later ***/
 self::$encryption=new Encryption();
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


    /**
     *
     * Like the constructor, we make __clone private
     * so nobody can clone the instance
     *
     */
    
        public static function UpdateLeadStatus($LeadStatus,$Company_id,$Leadid) {

        $leadstatus=  array() ;
        $query = " Update leads set leadstatus='$LeadStatus' where companies_id=$Company_id and lead_id=$Leadid  " ;
         //die($query);
        $result = self::execquery($query);
        
    }

    
    public static function getLeads($companyid,$parameters) {
       
        $condition="";$limit="";$sortby=";";
        foreach ($parameters as $parameter)
        {
            if ($parameter['operator']=='and' ||$parameter['operator']=='or' ){
              if (  $parameter['value']!="")
            $condition=$condition. " ". $parameter['operator'] ." ". $parameter['name']." = '". $parameter['value']."'"; }
            
           else if ($parameter['operator']=='limit' ){
              if (  $parameter['value']!="")
           $limit= "limit ". $parameter['value']; }
           
           else if ($parameter['operator']=='sort'  ){
              if (  $parameter['value']!="")
           $sortby= " order by ". $parameter['value']; }
           
        }
        
        $company = array();
        $gives = array();
        $services = array();
        $leads =array();
        $query = " select lead_id ,firstname ,lastname ,email  ,companyname , countrycode, leadstatus"
                . ",matchingdate,islocked,ispotential,profilepic from companies "
                . " inner join leads on leads.lead_id=companies.id where  leads.companies_id= $companyid ".$condition. " ".$sortby ." ".$limit  ;
        
       //die($query);
      //  echo $query;
        $result = self::execquery($query);
        if ($result) {
            while ($obj = $result->fetch_object()) {
                $lead_id=$obj->lead_id;
                if (!file_exists($obj->profilepic)){$obj->profilepic="assets/img/none.png";}
                $com = array('id' => self::$encryption->encode($obj->lead_id),
                    'firstname' => $obj->firstname,
                    'lastname' => $obj->lastname,
                    'email' => $obj->email,
                    
                    'companyname' => $obj->companyname,
                    
                    'countrycode' => $obj->countrycode,
                    'leadstatus' => $obj->leadstatus,
                    'matchingdate' => $obj->matchingdate,
                    'islocked' => $obj->islocked,
                    'ispotential' => $obj->ispotential,
                    'profilepic' => $obj->profilepic,
                );

                //get lead services
                $query = "select * from services where company_id = $lead_id";
                $result_s = self::execquery($query);
                if ($result_s) {
                    $obj = $result_s->fetch_object();
                    $services = array('services1' => $obj->services1,
                        'services2' => $obj->services2,
                        'services3' => $obj->services3,
                        'services4' => $obj->services4,
                        'services5' => $obj->services5
                    );
                }
                //get lead gives
                $query = "select * from gives where company_id = $lead_id";
                $result_g = self::execquery($query);
                if ($result_g) {
                    $obj = $result_g->fetch_object();
                    $gives = array('gives1' => $obj->gives1,
                        'gives2' => $obj->gives2,
                        'gives3' => $obj->gives3,
                        'gives4' => $obj->gives4,
                        'gives5' => $obj->gives5
                    );
                }

                $element = array('lead_id' => $lead_id,
                    'company' => $com,
                    'services' => $services,
                    'gives' => $gives
                );
                
                array_push( $leads, $element);
            }
        }






        return $leads;
    }


        public static function getLeadStatus() {
       
    
        
        $leadstatus=  array() ;
       
        $query = " select * from leadstatus " ;
        
     $element="";
        $result = self::execquery($query);
        if ($result) {
            while ($obj = $result->fetch_object()) {
                if ($obj->status!=""||$obj->status!=null){
                $leadstatus[$obj->status] =$obj->status;
                }
                
            
            }
            
              
        }






        return $leadstatus;
    }

    private function __clone() {
        
    }

}

/* * * end of class ** */
?>
