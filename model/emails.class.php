<?php

 /*** auto load model classes ***/
  
  
class emails extends db {
    /*     * * Declare instance ** */
 /*** auto load model classes ***/
  
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



public function sendemail($to,$parameters)
{
       
require_once("phpmail/class.phpmailer.php");
$message=self::createtemplate($parameters);
$from="support@mooga.com";
$subject=self::getsubject($parameters);
$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Host = "mail.smtp.com"; // specify main and backup server
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "mohomar99@yahoo.com"; // SMTP username -- CHANGE --
$mail->Password = "8cadf037"; // SMTP password -- CHANGE --
$mail->Port = "25"; // SMTP Port
$mail->From = $from; //From Address -- CHANGE --
$mail->FromName = "موجة"; //From Name -- CHANGE --
$mail->AddAddress($to, $to); //To Address -- CHANGE --
$mail->AddReplyTo("support@mooga.com", "support@mooga.com"); //Reply-To Address -- CHANGE --
$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(true); // set email format to HTML
$mail->Subject = $subject;
$mail->Body = $message;
//$mail->MsgHTML($message);
$mail->charSet = "UTF-16";
$mail->CharSet = mb_detect_encoding($message);
//$mail->Encoding = "base64";
$mail->ContentType = 'text/html;';
//$Mail->ContentType = 'text/plain'; 
$result=$mail->Send();
//var_dump($result);
$mail->ClearAddresses();
$mail->ClearAttachments();
$mail->SmtpClose();
//echo ("done");

}


public function sendemail_bak($to,$parameters)
{
       
        $transport = Swift_SmtpTransport::newInstance('mail.winwinbiz.com', 587, "")
          ->setUsername('omar.bakry@almoasher.net')
          ->setPassword('ASD@123');
      
//die($messaget);
       $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance('Test Subject')
          ->setFrom(array('support@almoasher.net' => 'Win Win biz'))
          ->setTo(array($to))
          ->setSubject(self::getsubject($parameters))
          ->setBody(self::createtemplate($parameters), 'text/html');
          //->setBody($text);

        $result = $mailer->send($message);

}

public function sendemail2($to,$parameters)
{
       
require_once("phpmail/class.phpmailer.php");
$message="ASJas";//self::createtemplate($parameters);

$from="omar.bakry@almoasher.net";
$subject="dhsadjhasjdh";//self::getsubject($parameters);
$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Host = "smtp.gmail.com"; // specify main and backup server
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "jobscvtech@gmail.com"; // SMTP username -- CHANGE --
$mail->Password = "fff"; // SMTP password -- CHANGE --
//$mail->Port = "80"; // SMTP Port
$mail->Port = "587"; // SMTP Port
$mail->From = $from; //From Address -- CHANGE --
$mail->FromName = "Mooga"; //From Name -- CHANGE --
$mail->AddAddress($to, $to); //To Address -- CHANGE --
$mail->AddReplyTo("omar.bakry@almoasher.net", "omar.bakry@almoasher.net"); //Reply-To Address -- CHANGE --
$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(true); // set email format to HTML
$mail->Subject = $subject;
$mail->Body = $message;
//$mail->MsgHTML($message);
$mail->SMTPSecure = 'tls';
$mail->charSet = "UTF-16";
$mail->CharSet = mb_detect_encoding($message);
//$mail->Encoding = "base64";
$mail->ContentType = 'text/html;';
//$Mail->ContentType = 'text/plain'; 
$mail->Send();
$mail->ClearAddresses();
$mail->ClearAttachments();
$mail->SmtpClose();
//echo ("done");
echo "adkalsdkalsklaskdas";

}


public function sendemail__bak2($to,$parameters)
{
       
require_once("phpmail/class.phpmailer.php");
$message=self::createtemplate($parameters);
$from="support@mooga.com";
$subject=self::getsubject($parameters);
$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Host ='smtp.gmail.com';// "mail.smtp.com"; // specify main and backup server
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "jobscvtech@gmail.com";//"mohomar99@yahoo.com"; // SMTP username -- CHANGE --
$mail->Password ="OS123456";// "8cadf037"; // SMTP password -- CHANGE --
$mail->Port = 587;//$mail->Port = "80"; // SMTP Port
$mail->From = $from; //From Address -- CHANGE --
$mail->FromName = "موجة"; //From Name -- CHANGE --
$mail->AddAddress($to, $to); //To Address -- CHANGE --
$mail->AddReplyTo("support@mooga.com", "support@mooga.com"); //Reply-To Address -- CHANGE --
$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(true); // set email format to HTML
$mail->Subject = $subject;
$mail->Body = $message;
$mail->SMTPSecure = 'tls';
//$mail->MsgHTML($message);
$mail->charSet = "UTF-16";
$mail->CharSet = mb_detect_encoding($message);
//$mail->Encoding = "base64";
$mail->ContentType = 'text/html;';
//$Mail->ContentType = 'text/plain'; 
$vv=$mail->Send();
$mail->ClearAddresses();
$mail->ClearAttachments();
$mail->SmtpClose();
//echo ("DONEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE".$vv);

}
public function createtemplate($parameters)
{
  $templat=  $parameters['template'];
   
    $content=file_get_contents('views/template/'.$templat.'.php');
   
 while ($parameter=current($parameters))
    {
        $parkey=  key($parameters);
       //echo  $parkey ;
            $content=str_replace('{'. $parkey . '}',$parameter,$content);
         next($parameters);
    }
    
    
   // die('ffff');
    return $content;
}


public function getsubject($parameters)
{
   
      $templat=  $parameters['template'];
    if ($templat=='active')
        $subject="mooga : Active your Account";
    elseif ($templat=='verify')
        $subject="mooga: Verify your Account";
   elseif ($templat=='welcome')
        $subject="موجة : مرحبا بك";
   elseif ($templat=='resetpassword')
        $subject="موجة : أعادة تعيين كلمة المرور";
	elseif ($templat=='verifyoffer')
        $subject="موجة : كود تفعيل العرض";
   elseif ($templat=='verifyproject')
        $subject="موجة : كود تفعيل المشروع";
    else
        $subject="";
    
    return $subject;
}

    private function __clone() {
        
    }

}

/* * * end of class ** */
?>
