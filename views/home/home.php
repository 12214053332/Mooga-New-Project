
<div id="location-map-block">
    <div id="location-homemap-block"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div id="location-link-item">
                    <button id="map_list"><i class="fa fa-angle-double-up"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="slider-banner-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div id="home-slider-item"> <span class="helpyou_item">We <span>Help</span> You to</span>
                    <h1>AMAZING <span>CLASSIFIED</span> HTML <span>TEMPLATE</span></h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                </div>
                <div id="search-categorie-item-block">
                    <form id="categorie-search-form">
                        <h1>search any business listing</h1>
                        <div class="col-sm-9 col-md-10 nopadding">
                            <div id="search-input">
                                <div class="col-sm-3 nopadding">
                                    <select id="location-search-list" class="form-control">
                                        <option>All Categories</option>
                                        <option>Business</option>
                                        <option>Free Lancing</option>
                                        <option>Web Development</option>
                                        <option>Web Designing</option>
                                    </select>
                                </div>
                                <div class="col-sm-9 nopadding">
                                    <div class="form-group">
                                        <input id="location-search-data-store" class="form-control" name="search" placeholder="Enter Keyword" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-2 text-right nopadding-right">
                            <div id="location-search-btn">
                                <button type="submit" id="search-btn"><i class="fa fa-search"></i>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="location_slider_item_block">
                    <button id="map_mark"><i class="fa fa-map-marker"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="search-categorie-item">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="row">
                    <div class="col-md-12 categories-heading bt_heading_3">
                        <h1>Directory <span>Categorie</span></h1>
                        <div class="blind line_1"></div>
                        <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                        <div class="blind line_2"></div>
                    </div>
                    <?php include('views/mooga/wedget/homeprojectfields.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="feature-item_listing_block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="col-md-12 feature-item-listing-heading bt_heading_3">
                    <h1>Featured <span>Listing</span></h1>
                    <div class="blind line_1"></div>
                    <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                    <div class="blind line_2"></div>
                </div>
                <div class="row">
                    <?php include('views/mooga/wedget/homeproject.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="vfx-counter-block">
    <div class="vfx-item-container-slope vfx-item-bottom-slope vfx-item-left-slope"></div>
    <div class="container">
        <div class="row">
            <div class="vfx-item-counter-up">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="vfx-item-countup" >
                            <div class="vfx-item-black-top-arrow"><i class="fa fa-file"></i></div>
                            <div id="count-1" class="vfx-coutter-item count_number vfx-item-count-up"><?php echo $userscounter->projects ?></div>
                            <div class="counter_text">المشروعات</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p class="green-font md-font text-center  slider-padding">
                                    استعرض المشروعات المضافة على الموقع وتصفح الأنسب منها سواء كنت شريك أو صاحب عمل
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="vfx-item-countup">
                            <div class="vfx-item-black-top-arrow"><i class="fa fa-users"></i></div>
                            <div id="count-2" class="vfx-coutter-item count_number vfx-item-count-up"><?php echo $userscounter->projects ?></div>
                            <div class="counter_text">إستثمار</div>
                        </div>
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p class="green-font md-font text-center  slider-padding">
                                    إبحث عن أفضل الفرص الإستثمارية على موقع موجة وإختر الأنسب لك
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="vfx-item-countup">
                            <div class="vfx-item-black-top-arrow"><i class="fa fa-th"></i></div>
                            <div id="count-3" class="vfx-coutter-item count_number vfx-item-count-up"><?php echo $userscounter->offers ?></div>
                            <div class="counter_text">عروض الجملة</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p class="green-font md-font text-center  slider-padding">
                                    تصفح عروض الجملة المضافة على موقع موجة واختر الأنسب لك وابدأ فى عقد الصفقات الآن
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="vfx-item-countup last-countup">
                            <div class="vfx-item-black-top-arrow"><i class="fa fa-th-list"></i></div>
                            <div id="count-4" class="vfx-coutter-item count_number vfx-item-count-up"><?php echo $userscounter->articles ?></div>
                            <div class="counter_text">المقالات</div>
                        </div>
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p class="green-font md-font text-center  slider-padding">
                                    طالع المقالات المتخصصة فى البيزنس كالتسويق والبيع والادارة وتحليل للوضع الراهن فى السوق المحلى والعربى

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div id="recent-product-item-listing">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="col-md-12 recent-item-listing-heading bt_heading_3">
                    <h1>Recent <span>Listing</span></h1>
                    <div class="blind line_1"></div>
                    <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                    <div class="blind line_2"></div>
                </div>
                <div class="row">
                    <?php include('views/mooga/wedget/homeoffers.php'); ?>


                </div>
            </div>
        </div>
    </div>
</div>
