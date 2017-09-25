<?php

Class projectsController Extends baseController {

public function index() 
{      

        //$this->checkuser();
        $search=post('name');
         $this->registry->template->search=$search;
		$this->registry->template->countries=$this->registry->helper->getcountries(); 
		 $this->registry->template->project_field=json_encode ($this->registry->helper->getproject_field());
         $this->registry->template->project_type=json_encode ($this->registry->helper->getproject_type());
		  
		  $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
		   
		   $this->registry->template->products=json_encode ($this->registry->helper->getproducts_field());
		   
		    $this->registry->template->services=json_encode ($this->registry->helper->getservices());
		 $this->registry->template->helper=$this->registry->objects;
		  $this->registry->template->form='all';
		  $facebook=new StdClass();
		   $facebook->image='assets/uploads/projects/projects.png';
		    $facebook->description='أضف مشروعك الاّن لتسمح لأكبر عدد من أصحاب رؤوس الأموال و المستثمرين بمشاهدته و التواصل معك في الحال';
		  $this->registry->template->facebook=$facebook;
		  
		   $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());
        $this->registry->template->page_body = getviewslink().'/mooga/projects';
    if ($search!=""){$condition="and IFNULL(projects.pending,0)=0 and  (projects.name  like N'%$search%'  or projects.description  like N'%$search%')
         order by projects.id desc limit 10" ;
        $projects=  $this->registry->users->getallprojects_search( $condition);
    }
    else{
        $projects =$this->registry->users->getallprojects_search(" and IFNULL(projects.pending,0)=0 order by projects.id desc limit 10");
    }

		  $this->registry->template->projects= $projects;
        $this->registry->template->show('index_home');
}
public function field(){
    $this->registry->template->countries=$this->registry->helper->getcountries();
    $this->registry->template->project_field=json_encode ($this->registry->helper->getproject_field());
    $this->registry->template->project_type=json_encode ($this->registry->helper->getproject_type());

    $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());

    $this->registry->template->products=json_encode ($this->registry->helper->getproducts_field());

    $this->registry->template->services=json_encode ($this->registry->helper->getservices());
    $this->registry->template->helper=$this->registry->objects;
    $this->registry->template->form='all';
    $facebook=new StdClass();
    $facebook->image='assets/uploads/projects/projects.png';
    $facebook->description='أضف مشروعك الاّن لتسمح لأكبر عدد من أصحاب رؤوس الأموال و المستثمرين بمشاهدته و التواصل معك في الحال';
    $this->registry->template->facebook=$facebook;

    $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());







	$field_id=get('fieldid');
    $project_fields=$this->registry->users->getproject_field_type($field_id);

    $this->registry->template->page_body = getviewslink().'/mooga/projects';
    $projects =$this->registry->users->getallprojects_search(" and IFNULL(projects.pending,0)=0  ".' and Replace( projects.project_field_list,\'"\',\'\' )  in ("'.$project_fields.'")'."order by projects.id desc limit 10");
    $this->registry->template->projects= $projects;
    $this->registry->template->show('index_home');
    //if ($project_field!=""){$condition=$condition.' and Replace( projects.project_field_list,\'"\',\'\' )  in ('."'$project_field'".')' ;}
}

    public function search()
    {
        $search=$_SESSION['search'];

        $condition=" and IFNULL(projects.pending,0)=0 ";
        //$condition=$condition." and user_id=$user_id";

        if ($search!=""){$condition=$condition." and  (projects.name  like N'%$search%'  or projects.description  like N'%$search%'
         or".' Replace( projects.project_field_list,\'"\',\'\' )  in ("'.$search.'")'." or "
            .' Replace( projects.project_type_list,\'"\',\'\' )  in ("'.$search.'")'." or projects.country like N'%$search%')order by projects.id desc" ;}
        $projects=  $this->registry->users->getallprojects_search( $condition);

        $this->registry->template->countries=$this->registry->helper->getcountries();
        $this->registry->template->project_field=json_encode ($this->registry->helper->getproject_field());
        $this->registry->template->project_type=json_encode ($this->registry->helper->getproject_type());

        $this->registry->template->project_stage=json_encode ($this->registry->helper->getproject_stage());

        $this->registry->template->products=json_encode ($this->registry->helper->getproducts_field());

        $this->registry->template->services=json_encode ($this->registry->helper->getservices());
        $this->registry->template->helper=$this->registry->objects;
        $facebook=new StdClass();
        $facebook->image='assets/uploads/projects/projects.png';
        $facebook->description='أضف مشروعك الاّن لتسمح لأكبر عدد من أصحاب رؤوس الأموال و المستثمرين بمشاهدته و التواصل معك في الحال';
        $this->registry->template->facebook=$facebook;


        $this->registry->template->page_body = getviewslink().'/mooga/projects';
        $this->registry->template->projects= $projects;
        $this->registry->template->show('index_home');
    }
}
?>
