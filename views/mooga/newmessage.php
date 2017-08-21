     <?php include("wedget/user-header.php") ?>

<div class="no-pdg-top">
    <div class="container">
        <div class="row">
	
	
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-custom no-pdg-lft inbox-rt">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 panel panel-default panel-custom padding-custom mrg-btm-lg bg-gry no-pdg-lft">
            <div class="panel-body no-pad-bor">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bg-gry lg-pdg no-brd-lft mobile-headr">
                                    <h3 class="panel-title custom-line">
                    <span class="ico-custom ico-custom-inbox-title"></span>
                    <div class="btn-group pull-right">
                        <button type="button" class="trans-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           ارسال رسالة جديدة<i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu inbx-actions-drop">
                            <li><a href="?page=inbox"><span class="ico-custom-lite ico-custom-inbox-lite-title span-mrg"></span>صندوق الوارد</a></li>
                        <li><a href="?page=sent"><span class="ico-custom-lite ico-custom-inbox-lite-sent span-mrg"></span>المرسل</a></li>
                              <!--  <li><a href="#"><span class="ico-custom-lite ico-custom-inbox-lite-arch span-mrg"></span>الارشيف</a></li>-->
                        </ul>
                    </div>
                </h3>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#convs-collapse" aria-expanded="false">
                    <span class="sr-only">المحادثات</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
              
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bg-wht no-brd-top no-brd-lft fixed-ht scroll-div-lg rt" id="msgs-collapse">
                    <form class="form-horizontal send-message" method="post" action="#" id="newmessage-form">
                        <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                            <input  type="hidden" name="user2_id" id="user2_id" value="<?php echo $messageuser->id ?>"/>
							<label for="selectuser" class="col-sm-2 control-label">ارسال الى</label>
							
                            <div class="col-sm-10">
                                <input disabled class="form-control"  type="text" name="user" id="user" value="<?php echo $messageuser->name ?>"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12">
                            <label class="col-sm-2 control-label">الموضوع</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title"  name="title" placeholder="الموضوع">
								<label  for="title"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-lg-12 col-xs-12 col-sm-12s">
                            <label for="Message" class="col-sm-2 control-label">الرساله</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="message" name="message"  placeholder="الرساله" style="min-height: 100px"></textarea>
								<label  for="message"></label>
                            </div>
                        </div>
                       <button class="btn orange-btn alg-left">ارسال</button>
                        <div id="newmessage-response"></div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


			</div>
        </div>
    </div>

