<?php

Class articlesController Extends baseController {

public function index() 
{         
 //$this->checkuser();
		$result =$this->registry->articles->getarticles_category();
	    $this->registry->template->allarticles_cat= $result;
		
		  $facebook=new StdClass();
		   $facebook->image='assets/uploads/blog/articles.png';
		    $facebook->description='تصفح واقرأ أحدث المقالات المضافة على موقع موجة فى مختلف مجالات البيزنس كالتسويق وفن البيع وعلوم الادارة المختلفة ';
		  $this->registry->template->facebook=$facebook;
		  
		  
        $this->registry->template->page_body = getviewslink().'/mooga/articles';
        $this->registry->template->show('index_home');
}


}

?>
