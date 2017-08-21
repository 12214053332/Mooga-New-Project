<?php

 /*** include the controller class ***/
 include __SITE_PATH . '/application/' . 'controller_base.class.php';

 /*** include the registry class ***/
 include __SITE_PATH . '/application/' . 'registry.class.php';

 /*** include the router class ***/
 include __SITE_PATH . '/application/' . 'router.class.php';

 /*** include the template class ***/
 include __SITE_PATH . '/application/' . 'template.class.php';
 /*** include the session class ***/
 include_once __SITE_PATH . '/application/' . 'SecureSessionHandler.class.php';
  /*** include the Encryption  class ***/
  include __SITE_PATH . '/application/' . 'Encryption.class.php';
  include __SITE_PATH . '/application/' . 'APIEncryption.class.php';

 /*** auto load model classes ***/

    function __autoload($class_name) {
    $filename = strtolower($class_name) . '.class.php';
    $file = __SITE_PATH . '/model/' . $filename;

    if (file_exists($file) == false)
    {
        return false;
    }
  include ($file);
}

 /*** a new registry object ***/
 $registry = new registry;
 $useridstr ="mooga.userid";
 $registry->useridstr= $useridstr;
 
 /*** create the database registry object ***/
  $registry->db = db::getInstance(); 
  $registry->helper=new helper();
  $registry->message=new message();
  $registry->leads=new leads();
  $registry->encryption=new Encryption();
  $registry->emails=new emails();
  $registry->objects=new objects();
  $registry->users=new users();
   $registry->product=new product();
      $registry->articles=new articles();
  $registry->sessionhandler=new SecureSessionHandler();
  
        ini_set('session.save_handler', 'files');
        session_set_save_handler($registry->sessionhandler, true);
        session_save_path(__DIR__ . '/sessions');

        $registry->sessionhandler->start();
/*if ( !$registry->sessionhandler->isValid(5)) {
    $registry->sessionhandler->destroy('winwinbiz18111980123!@#4');
}*/
        require_once 'maillib/swift_required.php';
//$registry->session->put('hello.world', 'bonjour');

?>
