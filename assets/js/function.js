
	function popup(mylink) { 
    if (! window.focus)return true;
    var href;
   
    if (typeof(mylink) == 'string') href=mylink;
    else href=mylink.href; 
    window.open(href, "", 'width=400,height=200,scrollbars=yes'); 
    return false; 
  }
  
  $().ready(function  xxxx() {
	  
 $( ".social-media li a" ).click(function() {
	  var mylink=$(this).data("url");
	    popup(mylink);
  }
  );
	
after_lazy_projects();
  after_lazy_offers();
  
//users 
  after_lazy_users();
  
//opportuities 
after_lazy_opportuities();
  
     $( ".deleteopportunity" ).click(function() {

	 
      //$( this ).addClass( "foo" );
	  var opportunityid=$(this).data("record");
	 // var user_id=$(this).data("user");
	
	  var data= deleteopportunity(opportunityid,$(this));
       
	// $(this).html("asdasdasd");
	  
  }
  );	
  
  
  
       $( ".deleteproduct" ).click(function() {

	 
      //$( this ).addClass( "foo" );
	  var productid=$(this).data("record");
	 // var user_id=$(this).data("user");
	
	  var data= deleteproduct(productid,$(this));
       
	// $(this).html("asdasdasd");
	  
  }
  );	
  
  });

$( document ).ready(function() {
	$( ".project-show-phone" ).each(function() {
      //$( this ).addClass( "foo" );
	  var project_id=$(this).data("record");
	  var user_id=$(this).data("user");
	  var data= check_showprojectphone(project_id,user_id,$(this));
   });
});
$( document ).ready(function() {

	$( ".offer-show-phone" ).each(function() {
      //$( this ).addClass( "foo" );
	  var offer_id=$(this).data("record");
	  var user_id=$(this).data("user");
	  var data= check_showofferphone(offer_id,user_id,$(this));
   });
 

    
});
$( document ).ready(function() {
	$( document ).on('click','.go-to-login',function() {
		type=$(this).data('type');
		if(type=='offers'){
			var offer_id=$(this).data("record");
			var user_id=$(this).data("user");
			var data= showofferphone(offer_id,user_id,$(this));
		}else if(type=='projects'){
			//$( this ).addClass( "foo" );
			var project_id=$(this).data("record");
			var user_id=$(this).data("user");
			var data= showprojectphone(project_id,user_id,$(this));
		}
      window.location.assign('?page=login');
   });
 

    
});


$( document ).ready(function() {

	$( ".opportunity-show-phone" ).each(function() {
      //$( this ).addClass( "foo" );
	  var opportunity_id=$(this).data("record");
	  var user_id=$(this).data("user");
	
	  var data= check_showopportunityphone(opportunity_id,user_id,$(this));
   });
 

    
});



$( document ).ready(function() {

	$( ".user-show-phone" ).each(function() {
      //$( this ).addClass( "foo" );
	  var src_user_id=$(this).data("record");
	  var user_id=$(this).data("user");
	
	  var data= check_showuserphone(src_user_id,user_id,$(this));
   });
 

    
});








   function showoffernumber_all()
   {
	    
	   	$( ".offer-show-phone" ).each(function() {
      //$( this ).addClass( "foo" );
	  var offer_id=$(this).data("record");
	  var user_id=$(this).data("user");
	
	  var data= check_showofferphone(offer_id,user_id,$(this));
	  
     });
   }
   
   function showprojectnumber_all()
   {
	    
	   	$( ".project-show-phone" ).each(function() {
      //$( this ).addClass( "foo" );
	  var project_id=$(this).data("record");
	  var user_id=$(this).data("user");
	
	  var data= check_showprojectphone(project_id,user_id,$(this));
	  
     });
   }
   
      function showusersnumber_all()
   {
	    
	   	$( ".user-show-phone" ).each(function() {
      //$( this ).addClass( "foo" );
	  var src_id=$(this).data("record");
	  var user_id=$(this).data("user");
	
	  var data= check_showuserphone(src_id,user_id,$(this));
	  
     });
   }
   
   
   
   function after_lazy_opportunities()
   {
	   	   $(".deleteopportunity").unbind( "click" );
	    $(".opportunity-show-phone").unbind( "click" );
	   		$( ".deleteopportunity" ).click(function() {
			  var opportunityid=$(this).data("record");
			  var data= deleteopportunity(opportunityid,$(this));
			  
		  }
		  );	
   }


      function after_lazy_projects()
   {
	   $(".deleteproject").unbind( "click" );
	    $(".project-show-phone").unbind( "click" );
		
		   $( ".deleteproject" ).click(function() {
			  var projectid=$(this).data("record");
			  var data= deleteproject(projectid,$(this));
		  }
		  );
	   $(document).on('click','.project-show-phone',function(){
		   $(this).removeClass("project-show-phone");
		   var project_id=$(this).data("record");
		   var user_id=$(this).data("user");
		   var data= showprojectphone(project_id,user_id,$(this));
	   });
   }
   
   function after_lazy_offers()
   {
	   $(".deleteoffer").unbind("click");
	   $(".offer-show-phone").unbind("click");
	   $( ".deleteoffer" ).click(function() {
		   var offerid=$(this).data("record");
		   var data= deleteoffer(offerid,$(this));
	   });
       $(document).on('click','.offer-show-phone',function() {
		   $(this).removeClass('offer-show-phone');
		   var offerid=$(this).data("record");
		   var user_id=$(this).data("user");
		   var data= showofferphone(offerid,user_id,$(this));
	   });
   }   
      function after_lazy_opportuities()
   {

  
         $( ".opportunity-show-phone" ).click(function() {
			 
			  var opportuinty_id=$(this).data("record");
			  var user_id=$(this).data("user");
			 // alert (opportuinty_id);
			  var data= showopportunityphone(opportuinty_id,user_id,$(this));
			  
		  }
		  );	
		  
   }
   
   
   
         function after_lazy_users()
   {
   
   $(".user-show-phone").unbind( "click" );
   
	  $( ".user-show-phone" ).click(function() {

	 
      //$( this ).addClass( "foo" );
	  var src_user_id=$(this).data("record");
	  var user_id=$(this).data("user");
	
	  var data= showuserphone(src_user_id,user_id,$(this));
 
	// $(this).html("asdasdasd");
	  
  }
  );	
		  
   }
   
   
   
  