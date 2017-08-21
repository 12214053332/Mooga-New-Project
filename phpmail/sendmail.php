<?php

/*   $headers .= "Reply-To: The Sender <admin@almoasher.com>\r\n";
  $headers .= "Return-Path: The Sender <admin@almoasher.com>\r\n";
  $headers .= "From: The Sender <admin@almoasher.com>\r\n";
  $headers .= "Organization: Sender Organization\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
  mail("omarabakry@gmail.com", "Message", "A simple message.", $headers);  */
  sendemail ("omar.bakry@almoasher.net","omarabakry@gmail.com","osama.madah@amloasher.net","test","test");
  
  function sendemail($from,$to,$cc,$subject,$message,$bcc="")
{
require_once("class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Host = "mail.winwinbiz.com"; // specify main and backup server
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "support@winwinbiz.com"; // SMTP username -- CHANGE --
$mail->Password = "ASD@123"; // SMTP password -- CHANGE --
$mail->Port = "587"; // SMTP Port
$mail->From = $from; //From Address -- CHANGE --
$mail->FromName = "kheprat.com"; //From Name -- CHANGE --
$mail->AddAddress($to, $to); //To Address -- CHANGE --
$mail->AddReplyTo("info@almoasher.net", "info@almoasher.net"); //Reply-To Address -- CHANGE --
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
$mail->Send();
$mail->ClearAddresses();
$mail->ClearAttachments();
$mail->SmtpClose();
echo ("done");
}
 ?>