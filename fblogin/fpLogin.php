<?php
if (!isset($sessionhandler)){
    include_once('../application/SecureSessionHandler.class.php');
    $sessionhandler=new SecureSessionHandler();
    session_set_save_handler($sessionhandler, true);
    ini_set('session.save_handler', 'files');
    session_save_path('../includes/sessions');
}
session_start();
require_once 'autoload.php';
require_once __DIR__.'/config.php';
$fb = new \Facebook\Facebook(['app_id'=>FB_APP_ID,'app_secret'=>FB_APP_SECRET]);
$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
if (isset($accessToken)) {
    // Logged in!
    $sessionhandler->put('facebook_access_token', (string) $accessToken);
    $_SESSION['facebook_access_token']=$accessToken;
    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
    $session=$sessionhandler->get('facebook_access_token');

}
//print_r($session);
if(isset($session)&&$session){
    try {
        $response=$fb->get('/me?fields=first_name,last_name,email,name,link,location,gender,birthday,hometown&access_token='.$session,[],$session);
        $data=$response->getDecodedBody();
       // print_r($data);
        //return'';
        $fbid=$data['id'];
        $fbfullname=$data['name'];
        $femail=$data['email'];
        $felink=$data['link'];
        $fegender=$data['gender'];
        $fefname=$data['first_name'];
        $felname=$data['last_name'];
        /* ---- Session Variables -----*/
        $sessionhandler->put('FBID', $fbid);
        $sessionhandler->put('name',$fbfullname);
        $sessionhandler->put('email',$femail);
        $sessionhandler->put('facebook',$felink) ;
        $sessionhandler->put('gender',$fegender) ;
        $sessionhandler->put('firstname', $fefname);
        $sessionhandler->put('lastname',$felname) ;
        $sessionhandler->put('accountstatus','Active') ;
        $sessionhandler->put('login_type','facebook') ;
        $sessionhandler->put('agree','on') ;
        /* ---- header location after session ----*/
        
        header("Location: ../?page=_usersaction&action=signup");
        die();
    } catch(\Facebook\FacebookRequestException $e) {

        echo "Exception occured, code: " . $e->getCode();
        echo " with message: " . $e->getMessage();

    }
}



