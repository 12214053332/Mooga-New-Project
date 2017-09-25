<?php

class helper extends db {
    /*     * * Declare instance ** */

    private static $success_message = "your transaction are success";
    private static $emailexsist_message = "this email exist before";
    private static $emailnotexsist_message = "invalid username or password";

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
	 
	  public static function getitem_brand() {
        $item_brand = array();
        $query = "select id,name from item_brand";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = 
				array(
                    'name' => $obj->name,
					 'id' => $obj->id
					);
                array_push($item_brand, $element);
            }
        }

        return $item_brand;
    }
	
	/*public static function getitem_type() {
        $item_type = array();
        $query = "select id,name from item_type";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = 
				array(
                    'name' => $obj->name,
					 'id' => $obj->id
					);
                array_push($item_type,$element);
            }
        }

        return $item_type;
    }*/
		 public static function getitem_type($brand_id) {
        $item_names = array();
        $query = "select id,name from item_type where (brand_id= $brand_id )";
		//echo  $query;
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = 
				array(
                    'name' => $obj->name,
					 'id' => $obj->id
					);
                array_push($item_names,  $element);
            }
        }

        return $item_names;
    }
	 public static function getitem_names($brand_id,$type_id) {
        $item_names = array();
        $query = "select id,name from item_names where (brand_id= $brand_id and type_id=$type_id) or (brand_id=0 and type_id=0)";
		//echo  $query;
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = 
				array(
                    'name' => $obj->name,
					 'id' => $obj->id
					);
                array_push($item_names,  $element);
            }
        }

        return $item_names;
    }

    public static function getcountries() {
        $countries = array();
        $query = "select id,code,name,arab_name from country order by arab_name";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = 
				array('code' => $obj->code,
                    'name' => $obj->arab_name,
					 'id' => $obj->id
					);
                array_push($countries, $element);
            }
        }

        return $countries;
    }
	
	    public static function getstates($country_code) {
        $states = array();
        $query = "select id,name,arab_name from states where country_id=$country_code";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = 
				array(
                    'name' => $obj->arab_name,
					
					 'id' => $obj->id
					);
                array_push($states, $element);
            }
        }

        return $states;
    }



	    public static function getcities($country_code) {
        $states = array();
        $query = "select id,name,arab_name from cities where state_id=$country_code";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = 
				array(
                    'name' => $obj->arab_name,
					 'id' => $obj->id
					);
                array_push($states, $element);
            }
        }

        return $states;
    }	
	
	    public static function getcountries_names() {
        $countries = array();
        $query = "select name from country";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

           /*     $element = 
				array(
                    'name' => $obj->name,
					
					);*/
                array_push($countries, $obj->name);
            }
        }

        return $countries;
    }
	
	 public static function getconsultation_field() {
        $consultation = array();
        $query = "select name from consultation_field";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

           /*     $element = 
				array(
                    'name' => $obj->name,
					
					);*/
                array_push($consultation, $obj->name);
            }
        }

        return $consultation;
    }
	
   public static function getagent_field() {
        $agent= array();
        $query = "select name from agent_field";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

           /*     $element = 
				array(
                    'name' => $obj->name,
					
					);*/
                array_push($agent, $obj->name);
            }
        }

        return $agent;
    }
	
	   public static function getproducts_field() {
        $products= array();
        $query = "select name from products_field";
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

           /*     $element = 
				array(
                    'name' => $obj->name,
					
					);*/
                array_push($products, $obj->name);
            }
        }

        return $products;
    }
	
	    public static function getproject_type() {
        $project_type = array();
        $query = "select id,name from project_type";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                /*$element = 
				array(
                    'name' => $obj->name,
					 
					);*/
                array_push($project_type,  $obj->name);
            }
        }

        return $project_type;
    }
	
  public static function getproject_field() {
        $project_field = array();
        $query = "select id,name from project_field";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                /*$element = 
				array(
                    'name' => $obj->name,
					 
					);*/
                array_push($project_field,  $obj->name);
            }
        }

        return $project_field;
    }

	

	
  public static function getproject_stage() {
        $project_stage = array();
        $query = "select id,name from project_stage";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                /*$element = 
				array(
                    'name' => $obj->name,
					 
					);*/
                array_push($project_stage,  $obj->name);
            }
        }

        return $project_stage;
    }
	
	  public static function getproducts() {
        $products = array();
        $query = "select id,name from products";
	
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                /*$element = 
				array(
                    'name' => $obj->name,
					 
					);*/
                array_push($products,  $obj->name);
            }
        }

        return $products;
    }
		  public static function getservices() {
        $services = array();
		
        $query = "select id,name from services";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                /*$element = 
				array(
                    'name' => $obj->name,
					 
					);*/
                array_push($services,  $obj->name);
            }
        }

        return $services;
    }
	

	
		
	    public static function getoffer_type_filed() {
        $offer_type_filed = array();
        $query = "select id,name from offer_type_filed";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                /*$element = 
				array(
                    'name' => $obj->name,
					 
					);*/
                array_push($offer_type_filed,  $obj->name);
            }
        }

        return $offer_type_filed;
    }
	
	
	
    private function __clone() {
        
    }

    
    
}

/* * * end of class ** */
?>