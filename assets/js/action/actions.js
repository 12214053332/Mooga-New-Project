	$(document).ready(function() {
	  	
	          //currentdomain='http://'+ window.location.host +'/';
			  currentdomain='http://mooga.com/';
        $('[data-toggle="tooltip"]').tooltip();
			  
	});
	
	
	/*function*/

	/*function*/
	
	

$(document).ready(function(){
    $(document).on('click','.successDeal',function(e){
        e.preventDefault();
        el=$(this);
        projectid=el.data('id');
        $.ajax({
            type: 'post',
            url: /****/'?page=_usersaction&action=successDeal',
            data:{'projectid':projectid}, //$('#signup-form').serialize(),
            success: function (data) {
                el.parent().html('<img src="assets/images/150x150_Button.png">');
            }
        });
    });
    $(document).on('click','.successDealOffer',function(e){
        e.preventDefault();
        el=$(this);
        offerid=el.data('id');
        $.ajax({
            type: 'post',
            url: /****/'?page=_usersaction&action=successDealOffer',
            data:{'offerid':offerid}, //$('#signup-form').serialize(),
            success: function (data) {
                el.parent().html('<img src="assets/images/150x150_Button.png">');
            }
        });
    });
	changecountry1();changestates1();
	getitembrand();getitemnames1();
	function changecountry1(){
		var country_code1= $('#country').chosen().val();
		var code =$("#country").find(':selected').data('code')
		 $("#code").html(code);
		 $("input[name=phone]").attr('style', 'text-align: left;direction:ltr;');
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=country',
                    data:{country_code:country_code1,selectedvalue:window.states111}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#states').html(data);
						 $("#states").trigger("chosen:updated");	
						 
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#states").trigger("chosen:updated");			
    }
	
		function changestates1(){
		var country_code1=window.states111;//$('#states').chosen().val();
		//var code =$("#country").find(':selected').data('code')
//		 $("#code").html(code);
	//	 $("input[name=phone]").attr('style', 'text-align: left;direction:ltr;');
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=states',
                    data:{country_code:country_code1,selectedvalue:window.cities111}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#cities').html(data);
						 $("#cities").trigger("chosen:updated");	
						 
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#cities").trigger("chosen:updated");	
    }
	
	function getitembrand(){
		var item_brand1= $('#item_brand').chosen().val();
		var item_type1= $('#item_type').chosen().val();
	
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=item_type',
                    data:{item_brand:item_brand1,item_type:item_type1,selectedvalue:window.item_type111}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#item_type').html(data);
						 $("#item_type").trigger("chosen:updated");
                         // window.location.assign("?page=profile")
                        }
                    }
                });
            $("#item_type").trigger("chosen:updated");	
			
			
	}
	
		function getitemnames1(){
		var item_brand1= $('#item_brand').chosen().val();
		var item_type1=window.item_type111 ;//$('#item_type').chosen().val();
	  
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=item_names',
                    data:{item_brand:item_brand1,item_type:item_type1,selectedvalue:window.name111}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#name').html(data);

						 $("#name").trigger("chosen:updated");	
						 
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#name").trigger("chosen:updated");	
			
			
	}
	
    $("#country").chosen().change(function changecountry(){
		var country_code1= $('#country').chosen().val();
		var code =$("#country").find(':selected').data('code')
		 $("#code").html(code);
		 $("input[name=phone]").attr('style', 'text-align: left;direction:ltr;');
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=country',
                    data:{country_code:country_code1}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#states').html(data);
						 $("#states").trigger("chosen:updated");	
						 
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#states").trigger("chosen:updated");			
    });
	
	    $("#item_brand").chosen().change(function changebrand(){
		var item_brand1= $('#item_brand').chosen().val();
		var item_type1= $('#item_type').chosen().val();
        $('#item_type').parent().parent().removeClass('hidden');
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=item_type',
                    data:{item_brand:item_brand1,item_type:item_type1}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#item_type').html(data);

						 $("#item_type").trigger("chosen:updated");
                             getitemnames1();
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#item_type").trigger("chosen:updated");			
    });
	
		
	    $("#item_type").chosen().change(function changetype(){
		var item_brand1= $('#item_brand').chosen().val();
		var item_type1= $('#item_type').chosen().val();
            $('#name').parent().parent().removeClass('hidden')
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=item_names',
                    data:{item_brand:item_brand1,item_type:item_type1}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#name').html(data);

						 $("#name").trigger("chosen:updated");	
						 
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#name").trigger("chosen:updated");			
    });
	
	
	
	    $("#states").chosen().change(function(){
		var country_code1= $('#states').chosen().val();
		//var code =$("#country").find(':selected').data('code')
//		 $("#code").html(code);
	//	 $("input[name=phone]").attr('style', 'text-align: left;direction:ltr;');
         $.ajax({
                    type: 'post',
                    url: /****/'?page=_usersaction&action=states',
                    data:{country_code:country_code1}, //$('#signup-form').serialize(),
                    success: function (data) {
						
						 
						 // alert(data);
                         if (data!=""){
                         $('#cities').html(data);
						 $("#cities").trigger("chosen:updated");	
						 
                             // window.location.assign("?page=profile")
                        }
                    }
                });
			
            $("#cities").trigger("chosen:updated");			
    });

		$( "#advanced-search-btn" ).click(function() {
			if ($("#advanced-search").css('display') === 'none') {
			   // ...
			 $( "#advanced-search-btn" ).html('<span>اخفاء البحث المتقدم</span>');
			}
			else
			{
				 $( "#advanced-search-btn" ).html('<span>بحث متقدم فى  المشروعات </span>');
			}
        $( "#advanced-search" ).toggle( "slow", function() {
			
    // Animation complete.
  });
});

	});

	
	






