<?php

Class db extends baseController{

/*** Declare instance ***/
private static $instance = NULL;


/**
*
* the constructor is set to private so
* so nobody can create a new instance using new
*
*/

protected  $registry;


public function __construct($registry) {
  /*** maybe set the db name here later ***/
    $this->registry = $registry;
}

public function index() 
{   
    
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
public static function getInstance() {

if (!self::$instance)
    {
    //self::$instance = new PDO("mysql:host=localhost;dbname=biz", 'root', '');;
    //self::$instance-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     //self::$instance= new mysqli("localhost", "crmkhepr_mooga", "Almoasher123", "crmkhepr_mooga");
        self::$instance= new mysqli("localhost", "root", "", "mooga_mm");
    /* check connection */
    if (self::$instance->connect_errno) {
        printf("Connect failed: %s\n", self::$instance->connect_error);
        exit();
}
    }
return self::$instance;
}

/**
*
* Like the constructor, we make __clone private
* so nobody can clone the instance
*
*/
  public static function execquery($query)
    {

        self::$instance->query("SET NAMES 'utf8'");
		self::$instance->query('SET CHARACTER SET utf8');
      return  self::$instance->query($query);
 return self::$instance->fetchAll();
        if ( self::$instance->query($query) === TRUE) {
          return self::$instance->result;
            return TRUE; 
          
        } else {
      
            return FALSE; 
        } self::$instance->close();
    }
    
      public static function execquery_id($query)
    {
         
        self::$instance->query("SET NAMES 'utf8'");
		self::$instance->query('SET CHARACTER SET utf8');
        if ( self::$instance->query($query) ) {
            
          return self::$instance->insert_id;
        } else {
            // printf("Errormessage: %s\n", self::$instance->error);
            return -1; 
        } self::$instance->close();
    }
private function __clone(){
}

} /*** end of class ***/

?>
