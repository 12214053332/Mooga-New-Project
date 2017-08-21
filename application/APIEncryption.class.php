<?php
class APIEncryption{
    private $_key='CrfkthqknHrQ4ZEYkT7zkpLNBhxckarHEymT6eYUytbjBas8',//48 characters
    $_algorithm=['76jHhu2czVtqfbEwwE','5DyCAATDk528y8DWjs','9Qhw8F3VgD2TCKFrGT','K3AngB63UpUrkmEqwh','z2JpFLsJ3wSzt9YRvJ','MDCKdPFuTp4jGMCs6t','QAGL8cZMgWkcKn4QPu','4D25GRqtsJXbFWDhmQ'],//8 array of character of 18
    $_encryptionKey,$_password='bYhfWUMS5FQKbrvJ',
    $_authHeaderUsername='GYVZtuegzYLytAkL5F7EnDHqvyYSfTZ2xBpeKPa6S5W',
    $_authHeaderPassword='Cd3DrgUAmwWesykbQ4fGzRLQf5JuYW3Y8cGn3vSd9W5',
    $_sendUrls=[
        'saveToken'=>'http://notification.al-moasher.net/APINotifications/saveTokenNumber',
        'sendNotifications'=>'http://notification.al-moasher.net/APINotifications/sendNotifications',
    ];
    function __construct()
    {
        //make encryption to the key
        $this->_encryptionKey=$this->encryptionKey();
    }
    //encryption the key
    public function encryptionKey(){
        $first = substr($this->_key, 16);
        $second=substr($this->_key, 32);
        return array(hash("sha1", $first.$second), hash("sha1", $first . $this->_key));
    }
    //generate the algorithm of the type
    public function generateAlg($type){
        return base64_encode(md5(base64_encode(base64_encode(md5(strlen($type+225).$this->_algorithm[0].strlen($type).date('Y-m-d').$this->_algorithm[1].strlen($type).$this->_algorithm[2].$type.date('Y-m-d').$this->_algorithm[3].$type.strlen($type).$this->_algorithm[4].date('D').$type.(strlen($type)+5).date('j').strlen($type+12).$this->_algorithm[5].$type.date('l').strlen($type+150).$this->_algorithm[6].date('L').strlen($type+99).$type.date('N').strlen($type+11).date('S').strlen($type+234).date('W').strlen($type).$this->_algorithm[7])))));
    }
    //encrypt data
    public function encrypt($data) {
        return trim( base64_encode( mcrypt_encrypt(MCRYPT_RIJNDAEL_256,substr($this->_encryptionKey[0],0,32),$data,MCRYPT_MODE_CBC,substr($this->_encryptionKey[1],0,32))));
    }
    //generate token using special algorithm type
    public function generateToken($algType=null){
        //generate 44[generateAlg] and after password_has it will be 60[password_hash(generateAlg)] and after 60 characters it will have time and it will encrypt using encrypt function andit will generate 104 character
        $algType=($algType==null)?$algType:$this->_password;
        return password_hash($this->generateAlg($algType),PASSWORD_DEFAULT).$this->encrypt(time()+(30));
    }
    //generate auth header using username and password that used for authentication
    public function generateBaseAuthHeader(){
       // return base64_encode($this->generateToken($this->_authHeaderUsername).':'.$this->generateToken($this->_authHeaderPassword));
	   return base64_encode('GYVZtuegzYLytAkL5F7EnDHqvyYSfTZ2xBpeKPa6S5W:Cd3DrgUAmwWesykbQ4fGzRLQf5JuYW3Y8cGn3vSd9W5');
    }
    public function sendRequest($postData,$type='saveToken'){
        if(isset($this->_sendUrls[$type])){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->_sendUrls[$type],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic ".$this->generateBaseAuthHeader(),
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return "cURL Error #:" . $err;
            } else {
                return$response;
            }
        }
    }
}