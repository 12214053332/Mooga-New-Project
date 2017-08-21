    <div class="top-header">
        <ul class="social-media header-social">
            <li><a target="_blank" href="https://www.facebook.com/moogabusiness/?fref=ts"><i class="fa fa-facebook"></i></a></li>
            <li><a target="_blank" href="https://twitter.com/moogabusiness"><i class="fa fa-twitter"></i></a></li>
            <!--<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
            <li><a href="#"><i class="fa fa-rss"></i></a></li>-->
			  
        </ul>
        <p class="text-left white-font md-font half-padding table-left">
            <a href="?page=contactus" class="md-font white-link">اتصل بنا</a>
            <a href="?page=aboutus" class="md-font white-link"> من نحن</a>
        </p>
		
	 <?php 	if (isset($user)){ if(isset($user->name)){?>
        <p class="text-right white-font md-font half-padding table-right">
            مرحبا  <a href="?page=profile" class="md-font orange-font"><i class="user-cust"></i><?php echo $user->name ?></a>
			 
        </p>
		 <p class="text-right white-font md-font half-padding table-right">
            
			 <a href="?page=logout" class="md-font white-link text-left left"><i class="logout-cust"></i>تسجيل خروج</a>
        </p>
	 <?php }} else {?>
	 
	         <p class="text-right white-font md-font half-padding table-right">
            <a href="?page=login" class="md-font white-link text-right right"><i class="lock-cust"></i>تسجيل الدخول</a>
			 
        </p>
		 <p class="text-right white-font md-font half-padding table-right">
            
			 <a href="?page=signup" class="md-font white-link text-left left"><i class="user-cust"></i>مستخدم جديد</a>
        </p>
	 <?php }?>
    </div>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand main-logo" href="?page=index"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav alg-left">
                    <li class="active"><a href="?page=index">الرئيسية <span class="sr-only">(current)</span></a></li>
					<li><a href="?page=users">مجتمع موجة</a></li>
                    <li><a href="?page=projects">مشروعات  </a></li>
                   
                    <li><a href="?page=opportunities">عروض و فرص</a></li>
                    <li><a href="?page=articles">المقالات</a></li>
                </ul>
            </div>
        </div>
    </nav>