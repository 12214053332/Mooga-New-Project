
var requiredfiled="برجاء أدخل البيانات";


/*Login Form*/
$.validator.setDefaults({
	submitHandler: function() {
		alert("submitted!");
	}
});

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
		messages: {
			uemail: {
				required: window.requiredfiled,
				minlength: " (must be at least 3 characters)"
			},
			upassword: {
				required: " (required)",
				minlength: " (must be between 5 and 12 characters)",
				maxlength: " (must be between 5 and 12 characters)"
			}
		}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*Login Form*/
/*Register Form*/
$.validator.setDefaults({
	submitHandler: function() {
		alert("submitted!");
	}
});

$().ready(function() {
	// validate the form when it is submitted
	var validator = $("#signup-form").validate({
		errorPlacement: function(error, element) {
			// Append error within linked label
			$('.validate_error.'+ element.attr( "id" ) ).remove();
			$( element )
				.closest( "form" )
					.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( "<i class='validate_error "+ element.attr( "id" ) +"'></i>" );
		},
		errorElement: "span",
		messages: {
			email: {
				required: window.requiredfiled,
				minlength: " (must be at least 3 characters)"
			},
			password: {
				required: " (required)",
				minlength: " (must be between 5 and 12 characters)",
				maxlength: " (must be between 5 and 12 characters)"
			}
		}
	});

	$(".cancel").click(function() {
		validator.resetForm();
	});
});
/*Register Form*/