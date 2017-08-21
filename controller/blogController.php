<?php

Class blogController Extends baseController {

public function index() 
{      
    
       $result=$this->registry->companies->getcompany(30);
        $company=$result['company'];
         $services=$result['services'];
          $gives=$result['gives'];
        $this->registry->template->blog_heading = 'This is the blog Index';
        $this->registry->template->page_body = getviewslink().'/user/reg_1';
                 $this->registry->template->allservices =$this->registry->companies->getallservices();  
         $this->registry->template->allcountry =$this->registry->companies->getallcountry();  
        $this->registry->template->company=$company;
                 $this->registry->template->services=$services;
                 $this->registry->template->gives=$gives;
        $this->registry->template->show('blog_index');
}


public function view(){

	/*** should not have to call this here.... FIX ME ***/

	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

}
?>
