
var requiredfiled="برجاء أدخل البيانات";


/*Login Form*/


$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#login-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
             $( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
				errorElement: "span",
		rules : {
                password : {
                    minlength : 5
                },
				 name : {
                    minlength : 5
                },
				 phone : {
                    minlength : 6
                },
                confirmpassword : {
                    minlength : 5,
                    equalTo : "#password"
                }
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
				login();
				//alert("Submitted, thanks!");
			//adddata();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*Login Form*/

/*Register Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#signup-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
		rules : {
                password : {
                    minlength : 5
                },
				 name : {
                    minlength : 5
                },
				 phone : {
                    minlength : 6
                },
                confirmpassword : {
                    minlength : 5,
                    equalTo : "#password"
                },
				account_type : {
                    required : true,
                    
                }
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
				register();
				//alert("Submitted, thanks!");
			//adddata();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*Register Form*/
/*edit profile Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#edit_profile-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                name : {
					required:true,
                    minlength : 4
                }, 
				country : {
					required:true,
                   
					
                },
			  account_type : {
				  required:true,
                   
                },
				phone : {
				  required:true,
                   
                },
				account_type : {
				  required:true,
                   
                },
				
            },
		messages: {
			
			
		},
			submitHandler: function() {
				//alert("Submitted, thanks!");
				edit_profile();
				
			//adddata();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*edit profile Form*/

/*add project Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#addproject-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                name : {
					required:true,
                    minlength : 6
                }, 
				description : {
					required:true,
                    minlength : 50,
					maxlength :6666,
					
                },
			  project_type : {
				  required:true,
					chosen: true,
                   
                },
				
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
				add_project();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*add project Form */




/*add opportunity Form*/

$().ready(function() {
	
			jQuery.validator.addMethod("dateFormat",
				function(value, element) {
					
						var date_regex = /^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/;///^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/ ;
						var today = new Date();
						var today_check = new Date(today.getFullYear(), today.getMonth(), today.getDate());
						//alert(today_check);
						if(!(date_regex.test(value)))
						{
							return false;
						
						}else
						{
						
						var dateval=new Date(value);
						var datelast=new Date(dateval.getFullYear(), dateval.getMonth(), dateval.getDate());
						
							if(today_check > datelast )
							{
								return false;
							}else
							{
								return true;
							}
						
						}
				},
				"من فضلك اختر تاريخ اكبر من تاريخ اليوم");
	// validate the form when it is submitted
	var validator = $("#opportunity-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                name : {
					required:true,
                    minlength : 6
                }, 
				 expiredate : {
					 required: true,

                }, 
				description : {
					required:true,
                    minlength : 50,
					maxlength :6666,
					
                },
			expiredate : {
			   dateFormat: true,
			  },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
				addopportunity();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*add opportunity Form*/


/*allprojects search Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#allprojects-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                
				description : {
					
                    minlength : 4,
					maxlength :6666,
					
                },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
					$('#SearchSpinner').addClass('spinner');
				allprojectssearch();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*allprojects search Form*/

/*myprojects search Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#myprojects-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                
				description : {
					
                    minlength : 4,
					maxlength :6666,
					
                },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
				myprojectssearch();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*myprojects search Form*/

/*allopportunities search Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#allopportunities-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                
				description : {
					
                   
					maxlength :6666,
					
                },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
				  $('#SearchSpinner').addClass('spinner');
				allopportunitiessearch();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*allopportunities search Form*/



/*myopportunities search Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#myopportunities-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                
				description : {
					
                 
					maxlength :6666,
					
                },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
			    $('#SearchSpinner').addClass('spinner');
				myopportunitiessearch();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*myopportunities search Form*/

/*myopportunities search Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#users-search-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                
			
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
		  $('#SearchSpinner').addClass('spinner');
			users_search();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*myopportunities search Form*/

/*addproduct  Form*/
$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#addproduct-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
					rules : {
				
                
				description : {
					required:true,
                    minlength : 4,
					maxlength :6666,
					
                },
				name : {
					required:true,
                    minlength : 4,
			
					
                },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
				add_product();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*addproduct  Form*/


/*$(document).ready(function (e) {
$("#addproduct-form").on('submit',(function(e) {

e.preventDefault();


var xx= new FormData(document.getElementById("addproduct-form"));

//alert(xx);
$.ajax({
url:window.currentdomain +'?page=_productaction&action=addproduct', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: xx, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
	alert(data);

}
});
}));});*/
/*replaymessage  Form*/
$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#replaymessage-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
					rules : {
				
                
				message : {
					required:true,
                    minlength : 4,
					maxlength :6666,
					
                },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
			
				replaymessage();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*replaymessage Form*/

/*newmessage  Form*/
$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#newmessage-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
					rules : {
				
                
				message : {
					required:true,
                    minlength : 4,
					maxlength :6666,
					
                },
				title : {
					required:true,
                    minlength : 4,
					maxlength :50,
					
                },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
			
				newmessage();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*newmessage Form*/


/*forgetpassword  Form*/
$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#forgetpassword-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
					rules : {
				
			email : {
					required:true,
                  
					
                },
			
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
			
				//alert('doneeeeeeeeeeeeeeeee');
				forgetpassword();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});



/*allprojects search Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#contactus-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
			rules : {
				
                
				name : {
					required:true,
                    minlength : 3,
				
					
                },
				email : {
					required:true,
                },
				message : {
					required:true,
					minlength : 5,
					maxlength : 255,
                },
				
				type : {
					required:true,
					
                },
			  
            },
		messages: {
			
			
		},
			submitHandler: function() {
			 $('#SearchSpinner').addClass('spinner');
				contactus();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*allprojects search Form*/
/*forgetpassword Form*/

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#resetpassword-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
		},
		errorElement: "span",
		rules : {
                password : {
                    minlength : 5
                },
				confirmpassword : {
                    minlength : 5,
                    equalTo : "#password"
                },
				
            },
		messages: {
			
			
		},
			submitHandler: function() {
				
			 
				//alert("Submitted, thanks!");
				 resetpassword();
			//adddata();
			}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});