<?php

Class indexController Extends baseController {

public function index() {
   // $ss=$this->registry->session->get('userid');
    //echo $ss;
   
     
        
        $mysession=  $this->registry->sessionhandler->get($this->registry->useridstr); // bonjour  

      //  echo $mysession;
        
       /* if (isset($mysession))
        {   
          
        $newURL='?page=profile';
	    header('Location: '.$newURL);
         
        }
       else 
           {*/

			  
			  $result =$this->registry->users->getallprojects_search('and projects.needclose=1 LIMIT 4');
			  $this->registry->template->projectcolsed= $result;
			  
			  $userscounter =$this->registry->users->userscounter();
			  $this->registry->template->userscounter= $userscounter;
			  
			  $result_project =$this->registry->users->getallprojects_search(' and IFNULL(projects.pending,0)=0 order by id desc LIMIT 6');
			  $this->registry->template->homeprojects= $result_project;
			  
			  $homeopportunities =$this->registry->users->getallopportunities('order by id desc LIMIT 6');
			  $this->registry->template->homeopportunities= $homeopportunities;
			  
			  $homeoffers =$this->registry->users->getalloffers_search(' and IFNULL(offers.pending,0)=0 order by id desc LIMIT 6');
			  $this->registry->template->homeoffers= $homeoffers;
			  
			  $result_articles =$this->registry->articles->get_home_articles();
			  $this->registry->template->home_articles= $result_articles;
			  
			  $slider_articles =$this->registry->articles->get_home_articles(5);
			  $this->registry->template->slider_articles= $slider_articles;
			  

			$facebook=new StdClass();
		   $facebook->image='assets/uploads/homepage.png';
		    $facebook->description='موجة دوت كوم هو أول موقع متخصص فى الربط بين الباحثين عن فرص البيزنس المختلفة كالشراكة والاستثمار والتمويل وبين أصحاب المشروعات والفرص الواعدة وتسهيل التواصل بين الأطراف';
		  $this->registry->template->facebook=$facebook;
		  
		  
              $this->registry->template->show('index_home');
			  
           /*}*/
}

}

?>
