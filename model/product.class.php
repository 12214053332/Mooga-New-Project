<?php

class product extends db {
    /*     * * Declare instance ** */

    private static $success_message = "شكرا لتسجيلك فى موقع موجة";
    private static $emailexsist_message = "هذا البريد الإلكتروني موجود من قبل";
    private static $emailnotexsist_message = "خطأفى البريد الإلكترونى او كلمة المرور";
    private static $problem_message = "خطأ فى تسجيل البيانات";
		private static $success_add = "تم  الأضافة بنجاح";
	private static $success_edit = "تم  التعديل بنجاح";
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


       
      
    

	 public static function addproduct($user_id,$parameters) {
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
		
        $query = "insert into products (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
		//die($query);
			//echo  $query;
			//echo '<script"> alert("' . 'welcome' . '")</script>';
        $id = self::execquery_id($query);
			$errorMessage=  self::$success_add;
                    include 'views/message/success_message.php';

        
        return $id;
    }
	
	
	   public static function updateproduct($product_id,$user_id,$parameters) {
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
       
        $query = " update products set " . substr($values, 0, -1)  .
                " where user_id=$user_id and id=$product_id";
     
        $result = self::execquery($query);
       	 $errorMessage=  self::$success_edit;;
          include 'views/message/success_message.php';
        return $result;
    }
	
	
	
	public static function getallproducts($user_id) {
	
	 $allproducts = array();
        $query = "select products.*,users.`name` as username,country.name as usercountry,users.companyname  from products
		INNER JOIN users on users.id=products.user_id inner join country on country.id=users.country
		where products.user_id=$user_id";
		//echo $query;
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = array('id' =>  self::$encryption->encode($obj->id),
                    'name' => $obj->name,
					'description' => $obj->description,
					'picpath' => $obj->picpath,
					);
                array_push($allproducts, $element);
            }
        }

        return $allproducts;
		
		
     
        
    }
    private function __clone() {
        
    }

    
    
}

/* * * end of class ** */
?>