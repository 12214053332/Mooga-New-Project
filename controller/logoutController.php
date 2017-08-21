<?php

Class logoutController Extends baseController {

public function index() 
{      
    

    
         $this->registry->sessionhandler->forget();
         $newURL="?page=index";
         header('Location: '.$newURL);
}


}
?>
