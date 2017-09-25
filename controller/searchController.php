<?php

Class searchController Extends baseController {

public function index() 
{

    $search=post('name');
$_SESSION['search']=$search;

    $condition=" and IFNULL(projects.pending,0)=0 ";
    //$condition=$condition." and user_id=$user_id";

    if ($search!=""){$condition=$condition." and  (projects.name  like N'%$search%'  or projects.description  like N'%$search%'
         or".' Replace( projects.project_field_list,\'"\',\'\' )  in ("'.$search.'")'." or "
        .' Replace( projects.project_type_list,\'"\',\'\' )  in ("'.$search.'")'." or projects.country like N'%$search%')order by projects.id desc limit 6" ;}

    $projects=  $this->registry->users->getallprojects_search( $condition);
    $offers=  $this->registry->users->getalloffers_search("and IFNULL(offers.pending,0)=0 and (offers.name  like N'%$search%' or offers.offer_type_filed  like N'%$search%' 
              or offers.description  like N'%$search%' or offers.item_brand  like N'%$search%' or offers.country like N'%$search%' )order by offers.id desc limit 6");


    $this->registry->template->page_body = getviewslink().'/mooga/search';
    $this->registry->template->projects= $projects;
    $this->registry->template->offers= $offers;


    $this->registry->template->show('index_home');
}

}
?>
