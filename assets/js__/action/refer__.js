	/*function*/

           function register() {


              
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=signup',
                    data: $('#signup-form').serialize(),
                    success: function (data) {
						  $('#signup-response').html(data);
						 // alert(data);
                         if (data.indexOf('شكر')!=-1){
                         $('input').val('')
						
						 $('select option[value=""]').attr('selected','selected');
						  window.location.assign('?page=profile');
                             // window.location.assign("?page=profile")
                        }else{
                       // $('.registerresult').html(data);
                        }
                    }
                });

            }
			
			
           function login() {


              //  alert('start');
               
			  
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=login',
                    data: $('#login-form').serialize(),
                    success: function (data) {
						//    alert(data);
                         if (data>0){
                        
                              window.location.assign("?page=index")
                        }else{
                              $('#login-response').html(data);
                        }
                    }
                });

            }
			
			
			function contactus() {


              //  alert('start');
               
			  
                $.ajax({
                    type: 'post',
                    url: /****/'?page=contactus&action=contactus',
                    data: $('#contactus-form').serialize(),
                    success: function (data) {
						   
                              $('#contactus-response').html(data);
							 
							   
							     
						  $("input[type='text']").val('');
						  $("input[type='email']").val('');
						  $("input[type='phone']").val('');
						  $('textarea').val('');
						$('select').val('');
                       
                        
                    }
                });

            }
			
		  function edit_profile() {

                var myvalue = $('#provide_cosultation').chosen().val();
				var need_cosultation = $('#need_cosultation').chosen().val();
				var provide_agent = $('#provide_agent').chosen().val();
				var need_agent = $('#need_agent').chosen().val();
				var need_product = $('#need_product').chosen().val();
					var provide_product = $('#provide_product').chosen().val();
				var worked_country = $('#worked_country').chosen().val();	
				
				var newval= JSON.stringify(myvalue);
				need_cosultation= JSON.stringify(need_cosultation);
				provide_agent= JSON.stringify(provide_agent);
				need_agent= JSON.stringify(need_agent);
				need_product= JSON.stringify(need_product);
				provide_product= JSON.stringify(provide_product);		
				worked_country= JSON.stringify(worked_country);	
				
				var provide_cosultation_list="provide_cosultation_list="+newval;
				var need_cosultation_list="need_cosultation_list="+need_cosultation;
				var provide_agent_list="provide_agent_list="+provide_agent;
				var need_agent_list="need_agent_list="+need_agent;
				var need_product_list="need_product_list="+need_product;
				var provide_product_list="provide_product_list="+provide_product;
					var worked_country_list="worked_country_list="+worked_country;
              //  alert($('#edit_profile-form').serialize()+"&"+provide_cosultation_list);
			  
			  var formdata= new FormData(document.getElementById("edit_profile-form"));
				formdata.append('provide_cosultation_list', newval);
				formdata.append('need_cosultation_list', need_cosultation);
				formdata.append('provide_agent_list', provide_agent);
				formdata.append('need_agent_list',need_agent );
				formdata.append('need_product_list', need_product);
				formdata.append('provide_product_list', provide_product);
				formdata.append('worked_country_list', worked_country);
				
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_profileaction&action=edit',
                    data: formdata,
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false, 
                    success: function (data) {
						  $('#edit_profile-response').html(data);
						   window.location.assign('?page=profile');
                       
                    }
                });
				
             

            }


						
		  function add_project() {

                var project_type = $('#project_type').chosen().val();
				project_type= JSON.stringify(project_type);
				var project_type_list="project_type_list="+project_type;

                var project_field = $('#project_field').chosen().val();
				project_field= JSON.stringify(project_field);
				var project_field_list="project_field_list="+project_field;
				
			    var project_stage = $('#stage').chosen().val();
				project_stage= JSON.stringify(project_stage);
				var stage_list="stage_list="+project_stage;
				
				 var project_product = $('#project_product').chosen().val();
				project_product= JSON.stringify(project_product);
				var project_product_list="project_product_list="+project_product;
				
				 var project_service = $('#project_service').chosen().val();
				project_service= JSON.stringify(project_service);
				var project_service_list="project_service_list="+project_service;
				
				
				 var formdata= new FormData(document.getElementById("addproject-form"));
				 
				formdata.append('project_type_list', project_type);
				formdata.append('project_field_list', project_field);
				formdata.append('project_product_list', project_product);
				formdata.append('project_service_list',project_service );
				formdata.append('stage_list',project_stage );
				
                $.ajax({
                    type: 'post',
                    url:/****/'?page=_projectaction&action=addproject',
                    data: formdata,
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false, 
                    success: function (data) {
						
						  $('#addproject-response').html(data);
						  $("input[type='text']").val('');
						  $("input[type='file']").val('');
						  $('textarea').val('');
						  $('.chosen-select').val('').trigger('chosen:updated');
                       $("input[type='checkbox']").prop('checked', false); // Unchecks it
					    window.location.assign('?page=projects');

                    }
                });
				
				

            }



		 function addopportunity() {


			 	 var formdata= new FormData(document.getElementById("opportunity-form"));
				
				
				
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_opportunityaction&action=addopportunity',
                    data: formdata,
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false, 
                    success: function (data) {
					 $('#opportunity-response').html(data);
					 window.location.assign('?page=opportunities');
                    }
                });
              
            

            }



						
		  function allprojectssearch() {

              /*  var project_type = $('#project_type').chosen().val();
				project_type= JSON.stringify(project_type);
				var project_type_list="project_type_list="+project_type;

                var project_field = $('#project_field').chosen().val();
				project_field= JSON.stringify(project_field);
				var project_field_list="project_field_list="+project_field;
				
				 var project_product = $('#project_product').chosen().val();
				project_product= JSON.stringify(project_product);
				var project_product_list="project_product_list="+project_product;
				
				 var project_service = $('#project_service').chosen().val();
				project_service= JSON.stringify(project_service);
				var project_service_list="project_service_list="+project_service;*/
				
				
				 var country = $('#country').chosen().val();
				country= JSON.stringify(country);
				var countries_list="countries_list="+country;
				
				 var stage = $('#stage').chosen().val();
				stage= JSON.stringify(stage);
				var stage_list="stage_list="+stage;
				
				
				
				var parameter="&"+countries_list+"&"+stage_list;
				//alert(parameter);
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=allprojects',
                    data: $('#allprojects-form').serialize()+parameter,
                    success: function (data) {
						//alert(data);
	                 $('#SearchSpinner').removeClass('spinner');						
						$('#allprojects-response').html(data);
						
						$(window).scrollTop($('#allprojects-response').offset().top);

                           showprojectnumber_all();
                    }
                });

            }
			
			function lazy_allprojectssearch() {

				
				
				 var country = $('#country').chosen().val();
				country= JSON.stringify(country);
				var countries_list="countries_list="+country;
				
				 var stage = $('#stage').chosen().val();
				stage= JSON.stringify(stage);
				var stage_list="stage_list="+stage;
				
				var lastprojectid=$('#projectid').data('projectid');
				lastprojectid="lastprojectid="+lastprojectid;
				
				$( "#projectid" ).remove();
				
				var parameter="&"+countries_list+"&"+stage_list+"&"+lastprojectid;
				//alert(parameter);
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=allprojects',
                    data: $('#allprojects-form').serialize()+parameter,
                    success: function (data) {
					//	alert($('#projectid').data('projectid'));
						//alert(data);
						$('#mySpinner').removeClass('spinner');
						if (!data.trim()){
				         $('#no-result-found').remove();
						 $('#allprojects-response').append("<h3 class='full-lines sm-font' id='no-result-found'>لا توجد نتائج</h3>");		
						}
						else
						{
					
				         $('#allprojects-response').append(data);
						 after_lazy_projects ();
                         showprojectnumber_all();
						 
						}
						   
                    }
                });

            }


						
			function lazy_myprojectssearch() {

				
				
				 var country = $('#country').chosen().val();
				country= JSON.stringify(country);
				var countries_list="countries_list="+country;
				
				 var stage = $('#stage').chosen().val();
				stage= JSON.stringify(stage);
				var stage_list="stage_list="+stage;
				
				var lastprojectid=$('#projectid').data('projectid');
				lastprojectid="lastprojectid="+lastprojectid;
				
				$( "#projectid" ).remove();
				
				var parameter="&"+countries_list+"&"+stage_list+"&"+lastprojectid;
				//alert(parameter);
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=myprojects',
                    data: $('#myprojects-form').serialize()+parameter,
                    success: function (data) {
					//	alert($('#projectid').data('projectid'));
						//alert(data);
						
						$('#mySpinner').removeClass('spinner');
						
						
						if (!data.trim()){
				         $('#no-result-found').remove();
						 $('#allprojects-response').append("<h3 class='full-lines sm-font' id='no-result-found'>لا توجد نتائج</h3>");		
						}
						else
						{
					      $('#allprojects-response').append(data);
						  after_lazy_projects ();
                          showprojectnumber_all();
				         
						 
						}
						   
                    }
                });

            }


										
		  function myprojectssearch() {
				 var country = $('#country').chosen().val();
				country= JSON.stringify(country);
				var countries_list="countries_list="+country;
				
				 var stage = $('#stage').chosen().val();
				stage= JSON.stringify(stage);
				var stage_list="stage_list="+stage;
				var parameter="&"+countries_list+"&"+stage_list;
				//alert(parameter);
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=myprojects',
                    data: $('#myprojects-form').serialize()+parameter,
                    success: function (data) {
						//alert(data);
						  $('#allprojects-response').html(data);
						  
						  showprojectnumber_all();
                         
                    }
                });

            }


								
		  function allopportunitiessearch() {

                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=allopportunities',
                    data: $('#allopportunities-form').serialize(),//+parameter,
                    success: function (data) {
						
						$('#SearchSpinner').removeClass('spinner');						
						
						  $('#allopportunities-response').html(data);
						  $(window).scrollTop($('#users-search-response').offset().top);
                       
                    }
                });

            }
	

									
		  function lazy_allopportunitiessearch() {

		  		var lastopportunityid=$('#opportunityid').data('opportunityid');
				lastopportunityid="lastopportunityid="+lastopportunityid;
				
				parameter="&" + lastopportunityid;
				
				$( "#opportunityid" ).remove();
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=allopportunities',
                    data: $('#allopportunities-form').serialize() + parameter,
                    success: function (data) {
						
						
						  $('#mySpinner').removeClass('spinner');
						
						if (!data.trim()){
						  

                         $('#no-result-found').remove();
						 $('#allopportunities-response').append("<h3 class='full-lines sm-font' id='no-result-found'>لا توجد نتائج</h3>");		
						}
						else
						{
					
				         $('#allopportunities-response').append(data);
                        // showprojectnumber_all();
                         after_lazy_opportunities();
						 
						}
						
						
                         
				
                       
                    }
                });

            }
			
	      function lazy_myopportunitiessearch() {

		  		var lastopportunityid=$('#opportunityid').data('opportunityid');
				lastopportunityid="lastopportunityid="+lastopportunityid;
				
				parameter="&" + lastopportunityid;
				
				$( "#opportunityid" ).remove();
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=myopportunities',
                    data: $('#allopportunities-form').serialize() + parameter,
                    success: function (data) {
						
						 // alert(data);
						  $('#mySpinner').removeClass('spinner');
						
						if (!data.trim()){
						 
                         $('#no-result-found').remove();
						 $('#allopportunities-response').append("<h3 class='full-lines sm-font' id='no-result-found'>لا توجد نتائج</h3>");		
						}
						else
						{
					
				         $('#allopportunities-response').append(data);
                        // showprojectnumber_all();
						 after_lazy_opportunities();
						}
                         
				
                       
                    }
                });

            }
	

	
		function myopportunitiessearch() {

             
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=myopportunities',
                    data: $('#myopportunities-form').serialize(),//+parameter,
                    success: function (data) {
						
						$('#SearchSpinner').removeClass('spinner');						
						
						  $('#allopportunities-response').html(data);
						  $(window).scrollTop($('#users-search-response').offset().top);
						 
                       
                    }
                });

            }

			
			
													
		  function users_search() {

           
				
                var myvalue = $('#provide_cosultation').chosen().val();
				var need_cosultation = $('#need_cosultation').chosen().val();
				var provide_agent = $('#provide_agent').chosen().val();
				var need_agent = $('#need_agent').chosen().val();
				var need_product = $('#need_product').chosen().val();
					var provide_product = $('#provide_product').chosen().val();
				var worked_country = $('#worked_country_list').chosen().val();	
				var country_list = $('#country').chosen().val();	
				
				var newval= JSON.stringify(myvalue);
				need_cosultation= JSON.stringify(need_cosultation);
				provide_agent= JSON.stringify(provide_agent);
				need_agent= JSON.stringify(need_agent);
				need_product= JSON.stringify(need_product);
				provide_product= JSON.stringify(provide_product);		
				worked_country= JSON.stringify(worked_country);	
				country_list= JSON.stringify(country_list);	
				var provide_cosultation_list="provide_cosultation_list="+newval;
				var need_cosultation_list="need_cosultation_list="+need_cosultation;
				var provide_agent_list="provide_agent_list="+provide_agent;
				var need_agent_list="need_agent_list="+need_agent;
				var need_product_list="need_product_list="+need_product;
				var provide_product_list="provide_product_list="+provide_product;
				var worked_country_list="worked_country_list="+worked_country;
				var _country_list="country_list="+country_list;	
				
				
				
				
				var parameter="&"+provide_cosultation_list+"&"+need_cosultation_list+"&"+provide_agent_list
				+"&"+need_agent_list+"&"+need_product_list+"&"+provide_product_list+"&"+worked_country_list+"&"+_country_list;
				//alert(parameter);
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=userssearch',
                    data: $('#users-search-form').serialize()+parameter,
                    success: function (data) {
						
						  $('#SearchSpinner').removeClass('spinner');						
						$('#users-search-response').html(data);
						
						$(window).scrollTop($('#users-search-response').offset().top);

                          // showprojectnumber_all();
						//alert(data);
						  
                       
                    }
                });

            }
			
		 function lazy_users_search() {

           
				
                var myvalue = $('#provide_cosultation').chosen().val();
				var need_cosultation = $('#need_cosultation').chosen().val();
				var provide_agent = $('#provide_agent').chosen().val();
				var need_agent = $('#need_agent').chosen().val();
				var need_product = $('#need_product').chosen().val();
					var provide_product = $('#provide_product').chosen().val();
				var worked_country = $('#worked_country_list').chosen().val();	
				var country_list = $('#country').chosen().val();	
				
				var newval= JSON.stringify(myvalue);
				need_cosultation= JSON.stringify(need_cosultation);
				provide_agent= JSON.stringify(provide_agent);
				need_agent= JSON.stringify(need_agent);
				need_product= JSON.stringify(need_product);
				provide_product= JSON.stringify(provide_product);		
				worked_country= JSON.stringify(worked_country);	
				country_list= JSON.stringify(country_list);	
				var provide_cosultation_list="provide_cosultation_list="+newval;
				var need_cosultation_list="need_cosultation_list="+need_cosultation;
				var provide_agent_list="provide_agent_list="+provide_agent;
				var need_agent_list="need_agent_list="+need_agent;
				var need_product_list="need_product_list="+need_product;
				var provide_product_list="provide_product_list="+provide_product;
				var worked_country_list="worked_country_list="+worked_country;
				var _country_list="country_list="+country_list;	
				
				var lastuserid=$('#lastuserid').data('lastuserid');
				lastuserid="lastuserid="+lastuserid;
				$( "#lastuserid" ).remove();
				
				
				var parameter="&"+provide_cosultation_list+"&"+need_cosultation_list+"&"+provide_agent_list
				+"&"+need_agent_list+"&"+need_product_list+"&"+provide_product_list+"&"+worked_country_list+"&"+_country_list+"&"+lastuserid;
				//alert(parameter);
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_searchaction&action=userssearch',
                    data: $('#users-search-form').serialize()+parameter,
                    success: function (data) {
					
						  $('#mySpinner').removeClass('spinner');
						
						if (!data.trim()){
						  

                         $('#no-result-found').remove();
						 $('#users-search-response').append("<h3 class='full-lines sm-font' id='no-result-found'>لا توجد نتائج</h3>");		
						}
						else
						{
					
				         $('#users-search-response').append(data);
						 after_lazy_projects ();
                        showusersnumber_all();
						 after_lazy_users();
						}
						
						
                       
                    }
                });

            }


			
			function add_product() {

              // e.preventDefault();
			   var formdata= new FormData(document.getElementById("addproduct-form"));
				
				
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_productaction&action=addproduct',
                    data: formdata,
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false, 
                    success: function (data) {
						  $('#addproduct-response').html(data);
                       $('input').val('');
					   $('textarea').val('');
                    }
                });

            }
			
			

			
			
			function replaymessage() {

                
				
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_messageaction&action=replaymessage',
                    data: $('#replaymessage-form').serialize(),
                    success: function (data) {
						  $('#replaymessage-response').html(data);
						  $('#message').val("");
						  
                       
                    }
                });

            }

						
			function newmessage() {

                
				
                $.ajax({
                    type: 'post',
                    url: /****/'?page=_messageaction&action=newmessage',
                    data: $('#newmessage-form').serialize(),
                    success: function (data) {
						//alert(data);
						  //$('#newmessage-response').html(data);
						  $('#title').val("");
						    $('#message').val("");
							ajaxbalance();
							$('#newmessage-response').html(data);
                       
                    }
                });

            }
			
						
			function showprojectphone(project_id1,user_id1,e) {

                $.ajax({
                    type: 'post',
                    url:/****/'?page=_projectaction&action=showphone',
                    data: {project_id:project_id1,user_id:user_id1},
                    success: function (data) {
						
						if (data!=""){
						$(data).insertBefore($(e).parent());
						
						$(e).unbind( "click" );
						$(e).removeClass( "project-show-phone" );
						}
						ajaxbalance();
						//$(e).append(data);
						//$(e).removeclass(data);
						//return data;
                    },
					error: function(xhr, textStatus, errorThrown){
					   
					}
                });

            }
		
		
		function check_showprojectphone(project_id,user_id,e) {

                $.ajax({
                    type: 'post',
                    url: /****/'?page=_projectaction&action=check_showphone',
                    data: {project_id:project_id,user_id:user_id},
                    success: function (data) {
						//alert(data);
						if (data!=""){
							
						  $(data).insertBefore($(e).parent());
						  $(e).unbind( "click" );
						  $(e).removeClass('project-show-phone');
						}
						//$(e).append(data);
						//$(e).removeclass(data);
						//return data;
                    }
                });

            }
			
	

						
			function showuserphone(src_user_id1,user_id1,e) {

                $.ajax({
                    type: 'post',
                    url:/****/'?page=_usersaction&action=showphone',
                    data: {src_user_id:src_user_id1,user_id:user_id1},
                    success: function (data) {
					//	alert(data);
						if (data!=""){
						$(data).insertBefore($(e).parent());
						
						$(e).unbind( "click" );
					
						$(e).removeClass( "user-show-phone" );
						}
						ajaxbalance();
						//$(e).append(data);
						//$(e).removeclass(data);
						//return data;
                    },
					error: function(xhr, textStatus, errorThrown){
					   
					}
                });

            }
		
		
		function check_showopportunityphone(opportunity_id1,user_id,e) {

                $.ajax({
                    type: 'post',
                    url: /****/'?page=_opportunityaction&action=check_showphone',
                    data: {opportunity_id:opportunity_id1,user_id:user_id},
                    success: function (data) {
						//alert(data);
						if (data!=""){
						$(data).insertAfter($(e).parent());
						
						$(e).unbind( "click" );
						}
						
						ajaxbalance() ;
						//$(e).append(data);
						//$(e).removeclass(data);
						//return data;
                    }
                });

            }



			function showopportunityphone(opportunity_id1,user_id1,e) {

                $.ajax({
                    type: 'post',
                    url:/****/'?page=_opportunityaction&action&action=showphone',
                    data: {opportunity_id:opportunity_id1,user_id:user_id1},
                    success: function (data) {
					//	alert(data);
						if (data!=""){
						$(data).insertAfter($(e).parent());
						
						$(e).unbind( "click" );
					
						$(e).removeClass( "opportunity-show-phone" );
						}
						ajaxbalance();
						//$(e).append(data);
						//$(e).removeclass(data);
						//return data;
                    },
					error: function(xhr, textStatus, errorThrown){
					   
					}
                });

            }
		
		
		function check_showuserphone(src_user_id1,user_id,e) {

                $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=check_showphone',
                    data: {src_user_id:src_user_id1,user_id:user_id},
                    success: function (data) {
						//alert(data);
						if (data!=""){
						$(data).insertBefore($(e).parent());
						
						$(e).unbind( "click" );
						}
						
						ajaxbalance() ;
						//$(e).append(data);
						//$(e).removeclass(data);
						//return data;
                    }
                });

            }

			
		function forgetpassword() {

                $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=forgetpassword',
                    data: $('#forgetpassword-form').serialize(),
                    success: function (data) {
						     if (data.indexOf('نجاح')!=-1){
						  //$('#newmessage-response').html(data);
							 $('#umail').val("");
							 }
							 $('#forgetpassword-response').html(data);
				  }
                });

            }
			
			
		function ajaxbalance() {

                $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=ajaxbalance',
                    data: {},
                    success: function (data) {
						 var obj = jQuery.parseJSON(data);
						 $("#balance").html(obj.balance);
						 $("#opportunities-balance").html(obj.opportunities);
						 $("#projects-balance").html(obj.projects);
						 
						 
				  }
                });

            }
			
		function deleteproject(project_id1,e) {


			   if (confirm('هل أنت متأكد من حذف هذا المشروع ؟')) {
					// Save it!
					
				} else {
					// Do nothing!
					return;
				}

                $.ajax({
                    type: 'post',
                    url:/****/'?page=_projectaction&action=deleteproject',
                    data: {project_id:project_id1},
                    success: function (data) {
						$(e).parent().parent().parent().remove();
						ajaxbalance();
						
                    },
					error: function(xhr, textStatus, errorThrown){
					   
					}
                });

            }
			
					function deleteopportunity(opportunity_id1,e) {


			   if (confirm('هل أنت متأكد من حذف هذه الفرصة ؟')) {
					// Save it!
					
				} else {
					// Do nothing!
					return;
				}

                $.ajax({
                    type: 'post',
                    url:/****/'?page=_opportunityaction&action=deleteopportunity',
                    data: {opportunity_id:opportunity_id1},
                    success: function (data) {
						
						$(e).parent().parent().remove();
						ajaxbalance();
                    },
					error: function(xhr, textStatus, errorThrown){
					   
					}
                });

            }
			
		function deleteproduct(product_id1,e) {


			   if (confirm('هل أنت متأكد من حذف هذا المنتج')) {
					// Save it!
					
				} else {
					// Do nothing!
					return;
				}

                $.ajax({
                    type: 'post',
                    url:/****/'?page=_productaction&action=deleteproduct',
                    data: {product_id:product_id1},
                    success: function (data) {
						
						//alert(data);
                    },
					error: function(xhr, textStatus, errorThrown){
					   
					}
                });

            }
			
		function resetpassword() {

                $.ajax({
                    type: 'post',
                    url: /*****/'?page=forgetpassword&action=resetpasswordaction',
                    data: $('#resetpassword-form').serialize(),
                    success: function (data) {
						//alert(data);
						
                       $('#resetpassword-response').html(data);
					   window.location.assign('?page=profile');
                       
                    }
                });

           }
			
	/*function*/