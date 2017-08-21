<?php
if (!isset($sessionhandler)){
    include_once('../application/SecureSessionHandler.class.php');
    $sessionhandler=new SecureSessionHandler();
    session_set_save_handler($sessionhandler, true);
    ini_set('session.save_handler', 'files');
    session_save_path('../includes/sessions');
}
session_start();
require_once __DIR__ . '/autoload.php';
require_once __DIR__.'/config.php';
$fb = new Facebook\Facebook(['app_id'=>FB_APP_ID,'app_secret'=>FB_APP_SECRET,'default_access_token'=>FB_DEFAULT_ACCESS_TOKEN]);
$helper = $fb->getRedirectLoginHelper();
$permissions = []; // optional
$loginUrl = $helper->getLoginUrl(FB_REDIRECT_URL, $permissions);
//echo $loginUrl;

header('Location:'.$loginUrl);