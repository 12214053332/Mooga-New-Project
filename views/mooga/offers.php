
	
      <?php include("wedget/user-header.php") ?>


      <div id="breadcrum-inner-block">
          <div class="container">
              <div class="row">
                  <div class="col-sm-12 text-center">
                      <div class="breadcrum-inner-header">
                          <h1>عروض الجملة</h1>
                          <a href="">الرئيسية</a> <i class="fa fa-circle"></i> <a href="?page=offers"><span>عروض الجملة</span></a> </div>
                  </div>
              </div>
          </div>
      </div>




      <div id="vfx-product-inner-item">
          <div class="container">
              <div class="row">

                  <div class="col-md-3 col-sm-4 col-xs-12">
                      <a href="?page=addoffer" class="btn btn-success btn-block <?php if(in_array($currentpage,['projects'])) { ?>pull-right<?php }else{?>text-center<?php }?>"><span>أضف عرض جملة جديد</span></a>
                      <div class="clearfix"></div>
                      <div class="clearfix" style="height: 20px;"></div>

                      <form method="post"  action="#" id="<?php echo $form;?>offers-form">
                      <div class="news-search-lt">
                          <input class="form-control" placeholder="وصف عرض الجملة" type="text">
                          <span class="input-search"> <i class="fa fa-search"></i> </span>
                      </div>
                      <div class="form-group">
                          <select class="form-control chosen-select" data-placeholder="اختر حالة البضاعة"   id="offer_type_filed" name="offer_type_filed"  <?php  echo $object->offer_type_filed; ?>>
                              <option value=""></option>
                              <?php $helper->getoptions( $offer_type_filed,""); ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <select class="form-control chosen-select" data-placeholder="اختر الماركة "   id="item_brand" name="item_brand" >
                              <option value=""></option>
                              <?php $helper->getoptions_single( $item_brand,"[$object->item_brand]"); ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <select class="form-control chosen-select" data-placeholder="اختر النوع "   id="item_type" name="item_type" >
                              <option value=""></option>
                          </select>
                      </div>
                      <div class="form-group">
                          <select class="form-control chosen-select" data-placeholder="اختر الصنف"   id="name" name="name" >
                              <option value=""></option>
                          </select>
                      </div>
                      <div class="form-group">
                          <select class="form-control chosen-select" data-placeholder="اختر الدولة"   id="country" name="country" >
                              <option value=""></option>
                              <?php
                              foreach ($countries as $country) {
                                  $id=$country['id'];
                                  $name=$country['name'];
                                  $code=$country['code'];
                                  echo " <option value='$id'  data-code='$code' >$name</option> ";
                              }
                              ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <select class="form-control chosen-select" data-placeholder="اختر المحافظة" id="states" name="states" >
                              <option value=""></option>
                          </select>
                      </div>
                      <div class="form-group">
                          <select class="form-control chosen-select" data-placeholder="اختر المدينة" id="cities" name="cities" >
                              <option value=""></option>
                          </select>
                      </div>
                      <div class="from-list-lt text-center">
                          <button type="submit" class="btn">إبحث</button>
                      </div>
                      </form>
                      <div class="clearfix"></div>
                      <div class="clearfix" style="height: 20px;"></div>
                      <div class="left-slide-slt-block">
                          <h3>Categories</h3>
                      </div>
                      <div class="list-group"> <a href="#" class="list-group-item active"><i class="fa fa-hand-o-left"></i> Business <span class="list-lt">15</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Health &amp; Fitness <span class="list-lt">09</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Real Estate <span class="list-lt">18</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Entertainment <span class="list-lt">24</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Beauty &amp; Spas <span class="list-lt">06</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Automotive <span class="list-lt">04</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Hotels &amp; Travel <span class="list-lt">14</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Sports &amp; Adventure <span class="list-lt">07</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Technology <span class="list-lt">12</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Arts &amp; Entertainment <span class="list-lt">26</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Education &amp; Learning <span class="list-lt">24</span></a> <a href="#" class="list-group-item"><i class="fa fa-hand-o-left"></i> Cloth Shop <span class="list-lt">16</span></a> </div>
                      <div class="left-slide-slt-block">
                          <h3>Popular Tags</h3>
                      </div>
                      <div class="archive-tag">
                          <ul>
                              <li><a href="#" class="active">Amazing</a></li>
                              <li><a href="#">Envato</a></li>
                              <li><a href="#">Themes</a></li>
                              <li><a href="#">Clean</a></li>
                              <li><a href="#">Responsivenes</a></li>
                              <li><a href="#">SEO</a></li>
                              <li><a href="#">Mobile</a></li>
                              <li><a href="#">IOS</a></li>
                              <li><a href="#">Flat</a></li>
                              <li><a href="#">Design</a></li>
                          </ul>
                      </div>
                      <div class="left-slide-slt-block">
                          <h3>Location List</h3>
                      </div>
                      <div class="left-location-item">
                          <ul>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> Manchester</a><span class="list-lt">07</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> Lankashire</a><span class="list-lt">04</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> New Mexico</a><span class="list-lt">03</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> Nevada</a><span class="list-lt">06</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> Kansas</a><span class="list-lt">08</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> West Virginina</a><span class="list-lt">05</span></li>
                          </ul>
                      </div>
                      <div class="left-slide-slt-block">
                          <h3>Archives</h3>
                      </div>
                      <div class="left-archive-categor">
                          <ul>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> January 2016</a><span class="list-lt">09</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> February 2016</a><span class="list-lt">52</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> March 2016</a><span class="list-lt">36</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> April 2016</a><span class="list-lt">78</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> May 2016</a><span class="list-lt">66</span></li>
                              <li><a href="#"><i class="fa fa-angle-double-right"></i> June 2016</a><span class="list-lt">15</span></li>
                          </ul>
                      </div>
                  </div>
                  <div class="col-md-9 col-sm-8 col-xs-12">
                      <div class="sorts-by-results">
                          <div class="col-md-6 col-sm-6 col-xs-6">
                              <!--<span class="result-item-view">
                                  Your Search Returned
                                  <span class="yellow">16</span>
                                  Results
                              </span>-->
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-6">
                              <div class="disp-f-right">
                                  <div class="disp-style active"><a href="listing_grid.html"><i class="fa fa-th"></i></a></div>
                                  <div class="disp-style"><a href="listing_list.html"><i class="fa fa-th-list"></i></a></div>
                              </div>
                          </div>
                      </div>
                      <div class="row" >

                          <div id="alloffers-response">
                              <?php include('wedget/alloffers.php') ?>
                          </div>



                          <!--<div class="vfx-person-block">
                              <ul class="vfx-pagination">
                                  <li><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                                  <li class="active"><a href="#">1</a></li>
                                  <li><a href="#">2</a></li>
                                  <li><a href="#">3</a></li>
                                  <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                              </ul>
                          </div>-->
                      </div>
                  </div>
              </div>
          </div>
      </div>

<script>
$(window).scroll(function() {
		     
    if($(window).scrollTop() >= ($(document).height() - $(window).height())-700  ) {
          
			$('#mySpinner').addClass('spinner');
	     	lazy_<?php echo $form;?>offerssearch();	
    }
});


</script>



