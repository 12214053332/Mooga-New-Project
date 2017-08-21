<?php

include_once("config.php");

include_once("LinkedIn/http.php");
include_once("LinkedIn/oauth_client.php");


		if (!isset($sessionhandler)){
         include_once('../application/SecureSessionHandler.class.php');
		$sessionhandler=new SecureSessionHandler();
		
        ini_set('session.save_handler', 'files');
        session_set_save_handler($sessionhandler, true);
        session_save_path('../includes/sessions');
        $sessionhandler->start();

}


//db class instance


if (isset($_GET["oauth_problem"]) && $_GET["oauth_problem"] <> "") {
  // in case if user cancel the login. redirect back to home page.
  $_SESSION["err_msg"] = $_GET["oauth_problem"];
  header("location:index.php");
  exit;
}

$client = new oauth_client_class;

$client->debug = false;
$client->debug_http = true;
$client->redirect_uri = $callbackURL;

$client->client_id = $linkedinApiKey;
$application_line = __LINE__;
$client->client_secret = $linkedinApiSecret;

if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
  die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
			'create an application, and in the line '.$application_line.
			' set the client_id to Consumer key and client_secret with Consumer secret. '.
			'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
			'necessary permissions to execute the API calls your application needs.';

/* API permissions
 */
$client->scope = $linkedinScope;
if (($success = $client->Initialize())) {
  if (($success = $client->Process())) {
    if (strlen($client->authorization_error)) {
      $client->error = $client->authorization_error;
      $success = false;
    } elseif (strlen($client->access_token)) {
      $success = $client->CallAPI(
					'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
					'GET', array(
						'format'=>'json'
					), array('FailOnAccessError'=>true), $user);
    }
  }
  $success = $client->Finalize($success);
}
if ($client->exit) exit;
if ($success) {
  	//$user_id = $db->checkUser($user);
	$user_id =0;
	$_SESSION['loggedin_user_id'] = $user_id;
	$_SESSION['user'] = $user;

$fbid = $user->id;              // To Get Facebook ID
 	    $fbfullname = $user->formattedName; // To Get Facebook full name
	    $femail =  $user->emailAddress;    // To Get Facebook email ID
		$felink = $user->publicProfileUrl;
		$picpath = $user->pictureUrl;
                $felocation = $user->location->name;
		$febday ='';
		$fecountry = '';
		$fegender = $user->gender;
		$fefname =$user->firstName;
		$felname = $user->lastName;
		$fetown ='';
		$fetown2 = $fetown->name;

// To Get Facebook email ID
	/* ---- Session Variables -----*/
	        $sessionhandler->put('FBID', $fbid);           
                $sessionhandler->put('name',$fbfullname);
	        $sessionhandler->put('email',$femail);
		$sessionhandler->put('linkedin',$felink) ;
		$sessionhandler->put('gender',$fegender) ;
		$sessionhandler->put('firstname', $fefname);
		$sessionhandler->put('lastname',$felname) ;	
        $sessionhandler->put('felocation',$felocation) ;	
		$sessionhandler->put('accountstatus','Active') ;
        $sessionhandler->put('login_type','linkedin') ;
        $sessionhandler->put('picpath',$picpath) ;
				
    /* ---- header location after session ----*/
  header("Location: ../?page=_usersaction&action=signup");

} else {
header("Location: ../?page=index");
 	 $_SESSION["err_msg"] = $client->error;
}
//header("location:index.php");
exit;
?>

