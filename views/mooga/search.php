
<?php include("wedget/user-header.php") ?>

<div id="breadcrum-inner-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="breadcrum-inner-header">
                    <h1>نتائج البحث</h1>
                    <a href="/">الرئيسية</a> <i class="fa fa-circle"></i> <a href="#"><span> نتائج البحث</span></a> </div>
            </div>
        </div>
    </div>
</div>
<div id="vfx-product-inner-item">
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="sorts-by-results">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <span class="result-item-view">
                            المشروعات
                            </span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="disp-f-right">
                                <div class="from-list-lt text-center">
                                    <button class="btn"><a href="?page=projects&action=search">المزيد</a></button>
                                </div>


                            </div>
                        </div>

                        </div>
                    </div>
                    <div id="allprojects-response">
                        <?php include('wedget/searchprojects.php') ?>
                    </div>

                </div>
            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                <div class="sorts-by-results">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span class="result-item-view">
                            العروض

                            </span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="disp-f-right">
                            <div class="from-list-lt text-center">
                                <button class="btn"><a href="?page=offers&action=search">المزيد</a></button>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="row" >

                    <div id="alloffers-response">
                        <?php include('wedget/searchoffers.php') ?>
                    </div>


                </div>
            </div>




            </div>
        </div>
    </div>
</div>

