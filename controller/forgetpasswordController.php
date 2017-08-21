<?php

Class forgetpasswordController Extends baseController {

public function index() 
{
               
             $this->registry->template->page_body = getviewslink().'/mooga/forgetpassword';
              $this->registry->template->show('index_home');     
}
public function resetpassword() 
{
              $this->registry->template->token =get('token')  ;
              $this->registry->template->page_body = getviewslink().'/mooga/resetpassword';
              $this->registry->template->show('index_home');     
}


public function changepassword() 
{
                $this->checkuser();
              $this->registry->template->page_body = getviewslink().'/mooga/changepassword';
              $this->registry->template->show('index_home');     
}



public function resetpasswordaction() 
{
	
   $id=$this->registry->sessionhandler->get( $this->registry->useridstr);
   $user_id=$this->registry->encryption->decode($id);	
   if ($user_id>0){
	     $newpassword=post('confirmpassword');
             $result_resetusertb=  $this->registry->users->updateusernewpasswordbyid($user_id,$newpassword);
            
			$errorMessage= 'تم تحديث كلمة المرور';
               include_once getviewslink().'/message/success_message.php';
             
	   
   }
   else
   {
 if(isset($_POST['submit']))
{
     
     
      $token=post('token');
      
      $token_result=$this->registry->users->get_password_tokens($token);

      if(count($token_result)<=0 )
      {
          $errorMessage='هذا الرابط غير صحيح';
            include_once getviewslink().'/message/error_message.php';
          return ;
          
      }else
      {
          $emailtoken=$token_result[0]['email'];
          if($token_result[0]['used']==0)
          {
              $today=date("Y-m-d H:i:s");
              if($token_result[0]['extime']<$today)
              {
                  $errorMessage= 'هذا الرابط منتهى';
                    include_once getviewslink().'/message/error_message.php';
		  return;
              }  else {
                  
              // UPDATE NEW PASSWORD & UPDATE PASSWORD TOKENS TABLE
                  
             $newpassword=post('confirmpassword');
             $result_resetusertb=  $this->registry->users->updateusernewpassword($emailtoken,$newpassword);
             $result_tokentb=  $this->registry->users->updateusertokens($token);
             
             $this->registry->users->updateusertokens($token);
              
             $errorMessage= 'تم تحديث كلمة المرور';
               include_once getviewslink().'/message/success_message.php';
             
              }
          }else
          {
              $errorMessage= 'تم استخدام هذا الرابط من قبل';
               include_once getviewslink().'/message/error_message.php';
              return;
          }
      }
      

            
            

}


   }
}



}
?>
