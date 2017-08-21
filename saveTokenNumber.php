<?php
/*include_once'application/APIEncryption.class.php';
$en=new APIEncryption();
*/
$token=post('token');
//$auth=$en->generateBaseAuthHeader('GYVZtuegzYLytAkL5F7EnDHqvyYSfTZ2xBpeKPa6S5W','Cd3DrgUAmwWesykbQ4fGzRLQf5JuYW3Y8cGn3vSd9W5');
$auth= base64_encode('GYVZtuegzYLytAkL5F7EnDHqvyYSfTZ2xBpeKPa6S5W:Cd3DrgUAmwWesykbQ4fGzRLQf5JuYW3Y8cGn3vSd9W5');
//echo$auth;
//exit();
$curl = curl_init();


curl_setopt_array($curl, array(
    CURLOPT_URL => "https://notification.al-moasher.net/APINotifications/saveTokenNumber",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_SSL_VERIFYPEER=>false,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => [
        'token'=>$token
    ],
    CURLOPT_HTTPHEADER => array(
        "Authorization: Basic $auth",
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo$response;
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