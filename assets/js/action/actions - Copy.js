	$(document).ready(function() {
	  	
	          currentdomain='http://'+ window.location.host +'/';
		$("#recordClientPhone").mask("(999) 999-9999");
		$("#recordClientPhoneAlt").mask("(999) 999-9999");
		$("#recordClientZip").mask("99999");
		$("#recordPropertyZip").mask("99999");
		$("#recordPurchaseZip").mask("99999");

		// add * to required field labels
		$('label.required').append('&nbsp;<strong>*</strong>&nbsp;');

		// accordion functions
		var accordion = $("#stepForm").accordion();
		var current = 0;

		$.validator.addMethod("pageRequired", function(value, element) {
			var $element = $(element)

				function match(index) {
					return current == index && $(element).parents("#sf" + (index + 1)).length;
				}
			if (match(0) || match(1) || match(2)) {
				return !this.optional(element);
			}
			return "dependency-mismatch";
		}, $.validator.messages.required)

		var v = $("#cmaForm").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
			submitHandler: function() {
				
				
				//alert("Submitted, thanks!");
			adddata();
			}
		});
		var vn = $("#login-form").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
			submitHandler: function() {
				
				
			//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		         	checklogin();
			}
		});
                
              		var vsn = $("#MessageComposeForm").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
			submitHandler: function() {
				
				
				//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		         	addmessage();
			}
		});  
                  var contactus = $("#contactus").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
			submitHandler: function() {
				
				
				//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		         	ContactUs();
			}
		});  
                   var vssn = $("#MessageThreadForm").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
			submitHandler: function() {
				
				
				//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		         	messagereply();
			}
		});  
                
                    var vnnn = $("#EditProfileForm").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
                        errorPlacement: function (error, element) {
                           $('#EditProfileMessage').html('Kindly make sure to fill all the forms');
                        },
			submitHandler: function() {
				
			 $('#EditProfileMessage').html('');
			//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		        	UpdateProfile();
		}
		});  
                
                    var forgetpassword1 = $("#ForgetPasswordForm").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
			submitHandler: function() {
				
				
			//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		        	forgetpassword();
			}
		});
                
                         var resetpass123 = $("#ResetPasswordForm").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
                         rules: {
                        password2: {
					required: true,
					minlength: 5,
					equalTo: "#password1"
				}
                         },
                         messages: {
                             password2: {
					required: "Repeat your password",
					minlength: jQuery.validator.format("Enter at least {0} characters"),
					equalTo: "Enter the same password as above"
				},
                         },
			submitHandler: function() {
				
				resetpassword();
			//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		        	
			}
		}
                     
                    );        
              var register123 = $("#RegisterForm").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
                         rules: {
                        password_confirm: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				}
                         },
                         messages: {
                             password_confirm: {
					required: "Repeat your password",
					minlength: jQuery.validator.format("Enter at least {0} characters"),
					equalTo: "Enter the same password as above"
				},
                         },
			submitHandler: function() {
				
				
			//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		        	Register();
			}
		}
                     
                    );   
                        var message_reply = $("#MessageReplyForm").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,
			submitHandler: function() {
				
				
			//alert("Submitted, thanksssssssssssssssssssssssssssss!");
		        	messagereply();
			}
                        
                        
		});  
                         
            var register555 = $("#newregisterform").validate({
			errorClass: "warning",
			onkeyup: false,
			onfocusout: false,      
                        
		});  
              $( "#newregistersubmit" ).click(function() {
                    $( "#newregisterform" ).submit();
                  });
                //alert('start');

  
                $( "#EditProfileSubmit" ).click(function() {
                    $( "#EditProfileForm" ).submit();
                  });
                  
                  $( "#MessageComposeFormSubmit" ).click(function() {
                    $( "#MessageComposeForm" ).submit();
                  });
                  $( "#SubmitContactUs" ).click(function() {
                      
                    //$( "#contactus" ).submit();
                  });
                   
                  $( "#MessageReplyFormSubmit" ).click(function() {
                      
                    $( "#MessageReplyForm" ).submit();
                  });
                  
                 
                  
                  
                  $( "#RatingForm select" ).change(function() {
                      
                    $( "#RatingForm" ).submit();
                  });  
		// back buttons do not need to run validation
		$("#sf2 .prevbutton").click(function() {
			accordion.accordion("option", "active", 0);
			current = 0;
		});
		$("#sf3 .prevbutton").click(function() {
			accordion.accordion("option", "active", 1);
			current = 1;
		});
		$("#sf4 .prevbutton").click(function() {
			accordion.accordion("option", "active", 2);
			current = 2;
		});
		// these buttons all run the validation, overridden by specific targets above
		$(".open3").click(function() {
		  if (v.form()) {
				accordion.accordion("option", "active", 3);
				current = 3;
			}
		});
		
		$(".open2").click(function() {
			if (v.form()) {
				accordion.accordion("option", "active", 2);
				current = 2;
			}
		});
		
            $(".open1").click(function() {
			if (v.form()) {
				accordion.accordion("option", "active", 1);
				current = 1;
			}
		});
		
            $(".open0").click(function() {
			if (v.form()) {
				accordion.accordion("option", "active", 0);
				current = 0;
			}
		});
                
                
                      $( '.profileuser' ).click(function() {
                          var ss= $(this).data("userid");
                         window.location.assign("?page=profile&sid="+ss);
                       });
                      $( '.messagefolder' ).click(function() {
                          var ss= $(this).data("src");
                         window.location.assign("?page=profile&sid="+ss);
                       });    
                      $( '.readmessage' ).click(function() {
                         
                          var usermessage= $(this).data("message");
                           
                          var data= { message:usermessage };
                           GetMessage(data);
                          setTimeout(reloadjs, 500) ;
                           
                       });
                     //  alert('dfsdfsdf');
       
                    
               
                $(".LeadStatusAction").click(function(){
              // Holds the product ID of the clicked element
              
             //  alert('sdasdasd');
                   var usersrc1= $(this).data("src");
                    var useraction= $(this).data("action");
                    var data= { leadstatus:useraction , usersrc: usersrc1 };
                            //{usersrc:usersrc,useraction:useraction};
                    UpdateLeadStatus(data);
              });
              
	});




           function Register() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=fb',
                    data: $('#RegisterForm').serialize(),
                    success: function (data) {
                         if (data==1){
                         
                              window.location.assign("?page=profile")
                        }else{
                        $('.registerresult').html(data);
                        }
                    }
                });

            }

           function checklogin() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=login',
                    data: $('#login-form').serialize(),
                    success: function (data) {
                      
                        if (data==1){
                         
                              window.location.assign("?page=profile");
                        }else{
                        $('.result').html(data);
                        }
                    }
                });

            }
            function adddata() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=news',
                    data: $('#cmaForm').serialize(),
                    success: function (data) {
                      
                        $('.result').html(data);

                    }
                });

            }

           function addmessage() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=addmessage',
                    data: $('#MessageComposeForm').serialize(),
                    success: function (data) {
                      //  if (data==1){
                         
                       //       window.location.assign("?page=profile")
                        //}else{
                        $('.result').html(data);
                        $('#MessageToUserId').val('');
                        $('#MessageSubject').val('');
                        $('#MessageMessage').val('');
                       // }
                    }
                });

            }
            
                       function addmessage() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=addmessage',
                    data: $('#MessageComposeForm').serialize(),
                    success: function (data) {
                      //  if (data==1){
                         
                       //       window.location.assign("?page=profile")
                        //}else{
                        $('.result').html(data);
                        $('#MessageToUserId').val('');
                        $('#MessageSubject').val('');
                        $('#MessageMessage').val('');
                       // }
                    }
                });

            }
            
           function forgetpassword() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=forgetpasswordaction',
                    data: $('#ForgetPasswordForm').serialize(),
                    success: function (data) {
                      
                        $('#forgetpasswordresult').html(data);
                      
                    }
                });

            }
	
           function messagereply() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=messagereply',
                    data: $('#MessageReplyForm').serialize(),
                    success: function (data) {
                        //alert(data);
                        ///$('.result').html(data);
                        //$('#MessageMessage').val('');
                        $('.inbox-rt').html(data);
                         setTimeout(reloadjs, 500) ;
                    }
                });

            }
            
            function UpdateProfile() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=updateprofile',
                    data: $('#EditProfileForm').serialize(),
                    success: function (data) {
                        $('#EditProfileMessage').html(data);
                       
                    }
                });

            }
            function ContactUs() {




                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=contactus',
                    data: $('#MessageThreadForm').serialize(),
                    success: function (data) {
                      
                       //alert(data);
                    }
                });

            }
        
           
            function UpdateLeadStatus(dataaction) {


                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=UpdateLeadStatus',
                    data:dataaction,
                    success: function (data) {
                      location.reload();
                       
                    }
                });

            }
           function resetpassword() {

                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=resetpasswordAction',
                    data: $('#ResetPasswordForm').serialize(),
                    success: function (data) {
                       $('#resetpasswordresult').html(data);
                       
                    }
                });

           }    
           function GetMessage(message) {

                $.ajax({
                    type: 'post',
                    url: window.currentdomain +'?page=inbox_read',
                    data:message,
                    success: function (data) {
                       $('.inbox-rt').html(data);
                       
                    }
                });

           }   
           
function reloadjs() {
      // alert('dataSource');
       
       //first get the src to put in the new <script> tag
	var dataSource = document.getElementById("mapData").src;

	//create new script
	newScript=document.createElement('script');
	newScript.src=dataSource;
	document.getElementsByTagName('head')[0].appendChild(newScript);

       //reload the map
	init();
}