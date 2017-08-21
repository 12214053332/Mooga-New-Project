
<div class="container" id="footer">
    <div class="row footer-dark round-corner">
        <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6 def-padding">
            <p class="md-font white-font">
                2016 -  كامل الحقوق محفوظة  لشركةموجة
                <br>
                <a href="?page=privacy" class="md-font white-link">سياسة الخصوصية</a>
              <!--  -
                <a href="?page=terms" class="md-font white-link"> بنود الإستخدام</a>-->
            </p>
            <ul class="social-media">
            <li><a target="_blank" href="https://www.facebook.com/moogabusiness/?fref=ts"><i class="fa fa-facebook"></i></a></li>
            <li><a target="_blank" href="https://twitter.com/moogabusiness"><i class="fa fa-twitter"></i></a></li>
               <!-- <li><a href="#"><i class="fa fa-linkedin round-corner"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube round-corner"></i></a></li>
                <li><a href="#"><i class="fa fa-rss round-corner"></i></a></li>-->
            </ul>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6 def-padding">
            <ul class="footer-nav">
              
			  <?php foreach($footer_blog_category as $category) {
										$category = (object) $category
										?>
    	       <li><a class="md-font white-link" href="?page=singlecategory&id=<?php echo $category->id; ?> "><?php echo $category->name; ?> </a></li>
			  <?php } ?>
<!--			 <li><a class="md-font white-link" href=""> تســويق     </a></li>
                <li><a class="md-font white-link" href=""> مبيــعات       </a></li>
                <li><a class="md-font white-link" href=""> إدارة أعــمال  </a></li>
                <li><a class="md-font white-link" href=""> قـصص النجـاح</a></li>-->
            </ul>
            <ul class="footer-nav">
                <li><a class="md-font white-link" href="?page=index"> الصفحة الرئيسة</a></li>
               <li><a class="md-font white-link" href="?page=aboutus">من نحن</a></li>
                <li><a class="md-font white-link" href="?page=contactus">إتصل بنا</a></li>
            </ul>
        </div>
    </div>
</div>
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

