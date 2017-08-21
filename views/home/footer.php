<footer class="site-footer footer-map">
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <h2>About Us</h2>
          <hr>
          <p class="about-lt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer justo lectus, consectetur quis nisi vitae, Nunc eget ultrices ligula.</p>
          <a href="about.html" class="btn-primary-link more-detail"><i class="fa fa-hand-o-right"></i> Read More</a>
          <h2>Follow Us</h2>
          <hr>
          <ul class="social-icons">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
            <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
          </ul>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <h2>Recent Listing</h2>
          <hr>
          <ul class="widget-news-simple">
            <li>
              <div class="news-thum"><a href="#"><img src="images/new-thum-1.png" alt="new-thum-1"></a></div>
              <div class="news-text-thum">
                <h6><a href="listing_detail.html">Hello Directory Listing</a></h6>
                <p>Phasellus ut condimentum diam, eget tempus lorem...</p>
                <div>Price: $117</div>
              </div>
            </li>
            <li>
              <div class="news-thum"><a href="#"><img src="images/new-thum-1.png" alt="new-thum-1"></a></div>
              <div class="news-text-thum">
                <h6><a href="listing_detail.html">Hello Directory Listing</a></h6>
                <p>Phasellus ut condimentum diam, eget tempus lorem...</p>
                <div>Price: $117</div>
              </div>
            </li>
          </ul>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <h2>Useful links</h2>
          <hr>
          <ul class="use-slt-link">
            <li><a href="#"><i class="fa fa-hand-o-right"></i>&nbsp;&nbsp;Privacy & Policy</a></li>
            <li><a href="#"><i class="fa fa-hand-o-right"></i>&nbsp;&nbsp;Payment Method</a></li>
            <li><a href="#"><i class="fa fa-hand-o-right"></i>&nbsp;&nbsp;Sitemap</a></li>
            <li><a href="#"><i class="fa fa-hand-o-right"></i>&nbsp;&nbsp;Support</a></li>
            <li><a href="#"><i class="fa fa-hand-o-right"></i>&nbsp;&nbsp;Terms & Condition</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <h2>Have you any Query?</h2>
          <hr>
          <form class="form-alt">
            <div class="form-group">
              <input type="text" placeholder="Name :-" required class="form-control">
            </div>
            <div class="form-group">
              <input type="text" placeholder="Email :-" required class="form-control">
            </div>
            <div class="form-group">
              <textarea placeholder="Message :-" required class="form-control"></textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn-quote">Send Now</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <p class="text-xs-center">Copyright © 2017  All Rights Reserved.</p>
        </div>
        <div><a href="#" class="scrollup">Scroll</a></div>
      </div>
    </div>
  </div>
</footer>
<!--================================ Login and Register Forms ===========================================--> 

<!-- login form -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="listing-modal-1 modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"> Login</h4>
      </div>
      <div class="modal-body">
        <div class="listing-login-form">
          <form action="#">
            <div class="listing-form-field"> <i class="fa fa-user blue-1"></i>
              <input class="form-field bgwhite" type="text" name="user_name" placeholder="username" />
            </div>
            <div class="listing-form-field"> <i class="fa fa-lock blue-1"></i>
              <input class="form-field bgwhite" type="password" name="user_pass" placeholder="password"  />
            </div>
            <div class="listing-form-field clearfix margin-top-20 margin-bottom-20">
              <input type="checkbox" id="checkbox-1-1" class="regular-checkbox" />
              <label for="checkbox-1-1"></label>
              <label class="checkbox-lable">Remember me</label>
              <a href="#">forgot password?</a> </div>
            <div class="listing-form-field">
              <input class="form-field submit" type="submit" value="login" />
            </div>
          </form>
          <div class="bottom-links">
            <p>not a member?<a href="#">create account</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- registration form -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="listing-modal-1 modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel2">Registration</h4>
      </div>
      <div class="modal-body">
        <div class="listing-register-form">
          <form action="#">
            <div class="listing-form-field"> <i class="fa fa-user blue-1"></i>
              <input class="form-field bgwhite" type="text" name="user_name" placeholder="name"  />
            </div>
            <div class="listing-form-field"> <i class="fa fa-envelope blue-1"></i>
              <input class="form-field bgwhite" type="email" name="user_email" placeholder="email" />
            </div>
            <div class="listing-form-field"> <i class="fa fa-lock blue-1"></i>
              <input class="form-field bgwhite" type="password" name="user_password" placeholder="password"  />
            </div>
            <div class="listing-form-field"> <i class="fa fa-lock blue-1"></i>
              <input class="form-field bgwhite" type="password" name="user_confirm_password" placeholder="confirm password" />
            </div>
            <div class="listing-form-field clearfix margin-top-20 margin-bottom-20">
              <input type="checkbox" id="checkbox-1-2" class="regular-checkbox" />
              <label for="checkbox-1-2"></label>
              <label class="checkbox-lable">i agree with</label>
              <a href="#">terms & conditions</a> </div>
            <div class="listing-form-field">
              <input class="form-field submit" type="submit" value="create account" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Scripts --> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script> 
<script type="text/javascript" src="js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/waypoints.js"></script> 
<script type="text/javascript" src="js/jquery_counterup.js"></script> 
<script type="text/javascript" src="js/jquery_custom.js"></script> 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript">
$(document).ready(function(){
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
});
</script> 
<script>	
/*************** show and hide map block ********************/
$(document).ready(function(e) {
   $("#location-map-block").hide();
	$("#location_slider_item_block").click(function(){
		$("#slider-banner-section,#location-map-block").slideToggle("slow");
		initmap();
	});
	$("#location-link-item").click(function(){
		$("#slider-banner-section,#location-map-block").slideToggle("slow");
	}); 
});		
// home page map section
function initmap() {
  var map = new google.maps.Map(document.getElementById("location-homemap-block"), {
	zoom:8,
	scrollwheel: false ,
	center: new google.maps.LatLng(22.2587, 71.1924), // Gujarat
	
	styles: [
	{
		"featureType": "administrative",
		"elementType": "labels.text.fill",
		"stylers": [
			{
				"color": "#646464"
			}
		]
	},
	{
		"featureType": "landscape",
		"elementType": "all",
		"stylers": [
			{
				"color": "#e2e2e2"
			}
		]
	},
	{
		"featureType": "poi",
		"elementType": "all",
		"stylers": [
			{
				"visibility": "off"
			}
		]
	},
	{
		"featureType": "road",
		"elementType": "all",
		"stylers": [
			{
				"saturation": -100
			},
			{
				"lightness": 45
			}
		]
	},
	{
		"featureType": "road.highway",
		"elementType": "all",
		"stylers": [
			{
				"visibility": "simplified"
			}
		]
	},
	{
		"featureType": "road.arterial",
		"elementType": "labels.icon",
		"stylers": [
			{
				"visibility": "off"
			}
		]
	},
	{
		"featureType": "transit",
		"elementType": "all",
		"stylers": [
			{
				"visibility": "off"
			}
		]
	},
	{
		"featureType": "water",
		"elementType": "all",
		"stylers": [
			{
				"color": "#01273a"
			},
			{
				"visibility": "on"
			}
		]
	}
]		
});    
setMarkers(map);
}	

var item_location = [
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0476, Oslo 1', 22.2587,71.1924, 5,'ic_1.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0426, Oslo 2', 21.9619,70.7923, 3,'ic_2.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 22.3039,70.8022, 1,'ic_3.png'],	  
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0476, Oslo 1', 22.7739,71.6673, 5,'ic_1.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0426, Oslo 2', 21.5222,70.4579, 3,'ic_2.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 21.4445,71.2874, 1,'ic_3.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0476, Oslo 1', 21.6417,69.6993, 5,'ic_1.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0426, Oslo 2', 21.7645,72.1519, 3,'ic_2.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 22.8120,70.8236, 1,'ic_3.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0476, Oslo 1', 23.0225,72.5714, 5,'ic_1.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0426, Oslo 2', 23.2420,69.6669, 3,'ic_2.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 22.6916,72.8634, 1,'ic_3.png'],	  
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 22.3072,73.1812, 2,'ic_2.png'],	  
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 21.1702,72.8311, 4,'ic_1.png'],	  
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 23.0753,70.1337, 1,'ic_3.png'],	  
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 21.7051,72.9959, 3,'ic_2.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 21.1257,73.1121, 5,'ic_3.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 22.4195,74.5668, 7,'ic_1.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 23.3473,70.5830, 4,'ic_3.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 23.0145,71.1788, 6,'ic_2.png'],  
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 22.7788,73.6143, 1,'ic_1.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 22.0896,69.2788, 5,'ic_3.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 21.8999,69.3161, 4,'ic_1.png'],
  ['Gujarat', 'Courier & Courier', 'Gujarat, Oslo, 15G, Torshovgata, Sagene, 0438, Oslo 3', 22.4649,69.0702, 1,'ic_1.png'],
];	
function setMarkers(map) {	
	var shape = {
	  coords: [1, 1, 1, 52, 50, 52, 50, 1],
	  type: 'poly'
	};
	for (var i = 0; i < item_location.length; i++) {
		var item = item_location[i];
		var image = {
		  url: 'images/'+item[6],
		  
		  size: new google.maps.Size(61, 72),
		  
		  origin: new google.maps.Point(0, 0),
		  
		  anchor: new google.maps.Point(0, 53)
		};
		var infoWindow = new google.maps.InfoWindow({
			content: item[0],
		});
		var marker = new google.maps.Marker({
		position: {lat: item[3], lng: item[4]},
		animation: google.maps.Animation.DROP,
		map: map,
		icon: image,
		shape: shape,
		title: item[0],
		zIndex: item[5]
	  });
	  (function (marker, item) {
			google.maps.event.addListener(marker, "click", function (e) {
				//Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
				infoWindow.setContent("<div style = 'width:250px;min-height:50px' id='m-info-window'> <h6 class='info-window-hding'>" + item[1] + "</h6> <p class='info-window-desc'>" + item[2] + "</p> </div>");
				infoWindow.open(map, marker);
			});                
		})(marker, item);
	}
  }    
</script>
</body>

	
	<script src="assets/js/validate/jquery.js"></script>
    <script src="assets/js/validate/jquery.validate.min.js"></script>
	<script src="assets/js/validate.js?ver=1"></script>
	<script src="assets/js/function.js?ver=1"></script>
	

	
	  <script  src="assets/js/chosen.jquery.js" type="text/javascript"></script>
	  
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>

