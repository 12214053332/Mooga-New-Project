     <?php include("wedget/user-header.php") ?>

<div class="no-pdg-top">
<div class="container">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pdg-rt inbox-lft">
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bg-gry pdg-mrg lg-pdg mobile-headr">
    <h3 class="panel-title custom-line">
        <span class="ico-custom ico-custom-inbox-title"></span>
        <div class="btn-group pull-right">
            <button type="button" class="trans-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                صندوق الوارد<i class="fa fa-angle-down"></i>
            </button>
          <ul class="dropdown-menu inbx-actions-drop">
                
                <li><a href="?page=sent"><span class="ico-custom-lite ico-custom-inbox-lite-sent span-mrg"></span>المرسل</a></li>
                
            </ul>
			            <!--<ul class="dropdown-menu inbx-actions-drop">
                <li><a href="#"><span class="ico-custom-lite ico-custom-inbox-lite-title span-mrg"></span>صندوق الوارد</a></li>
                <li><a href="#"><span class="ico-custom-lite ico-custom-inbox-lite-sent span-mrg"></span>المرسل</a></li>
                <li><a href="#"><span class="ico-custom-lite ico-custom-inbox-lite-arch span-mrg"></span>الارشيف</a></li>
            </ul>-->
        </div>
    </h3>
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#convs-collapse" aria-expanded="false">
        <span class="sr-only">المحادثات</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
   
</div>
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bg-gry no-pdg">
    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
      <!--  <input type="checkbox">-->
    </div>
    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
        <div class="btn-group pull-left new-msg-btn">
           <!-- <button type="button" class="trans-btn trans-btn-brd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                الإجراءات

            </button>
            <ul class="dropdown-menu inbx-actions-drop lg-inbx-actions-drop">
                <li><a href="#"><span class="ico-custom-lite ico-custom-lite-inbox-arch span-mrg"></span>الارشيف</a></li>
                <li><a href="#"><span class="ico-custom-lite ico-custom-lite-inbox-spam span-mrg"></span>مؤذي</a></li>
                <li><a href="#"><span class="ico-custom-lite ico-custom-lite-inbox-delete span-mrg warning-btn"></span>مسح</a></li>
            </ul>-->
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bg-wht no-brd-top scroll-div-lg" id="convs-collapse">
    <?php include("wedget/inboxmessage.php"); ?>
    <!--<a href="#" class="btn btn-blue col-md-offset-1 col-lg-offset-1 col-xs-offset-0 col-xs-offset-0 col-lg-11 col-md-11 col-sm-12 col-xs-12 ">المزيد</a>-->
</div>
</div>

</div>
</div>
</div>
</div>
