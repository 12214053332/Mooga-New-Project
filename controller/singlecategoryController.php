<?php

Class singlecategoryController Extends baseController {

public function index() 
{         
		
		
		 $cat_id=get('id');
        $cat_id=$this->registry->encryption->decode($cat_id);
		
		//$result =$this->registry->articles->getarticles_bycategoryid($cat_id);
		$result =$this->registry->articles->getarticlesLimit_bycategoryid($cat_id,"order by articles.id desc limit 10");
	    $this->registry->template->category_data= $result;
		
		$result_single =$this->registry->articles->getsingle_category_block($cat_id);
	    $this->registry->template->single_cat_data= $result_single;		
		
		
		
        $this->registry->template->page_body = getviewslink().'/mooga/singlecategory';
        $this->registry->template->show('index_home');
}


}

?>
