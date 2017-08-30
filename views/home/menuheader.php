<div id="logo-header">
  <div class="container">
    <div class="row">
      <div class="col-sm-2 col-xs-9 text-right">
        <div id="logo"> <a href="/"><img src="assets/images/logo.png" alt="logo"></a> </div>
      </div>
	  
      <div class="col-sm-10 text-right">
        <nav class="navbar navbar-default">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#thrift-1" aria-expanded="false"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          </div>
          <div class="collapse navbar-collapse" id="thrift-1"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
            <div id="nav_menu_list">
              <ul>
                <li class="<?php if ($currentpage=="" || $currentpage=="index" ){echo 'active';} ?>"><a href="?page=index">الرئيسية</a></li>
                <li class="<?php if ( $currentpage=="whyus"){echo 'active';} ?>"><a href="?page=whyus">لماذا موجة</a></li>
                <li class="<?php if ($currentpage=="addproject" || $currentpage=="singleproject" || $currentpage=="projects"){echo 'active';}?>"><a href="?page=projects">المشروعات</a></li>
                <li class="<?php if ($currentpage=="investment"){echo 'active';}?>"><a href="?page=investment">إستثمار</a></li>
				<li class="<?php if ($currentpage=="addoffer" || $currentpage=="singleoffer" || $currentpage=="offers"){echo 'active';}?>" ><a href="?page=offers">عروض الجملة</a></li>
                <!--<li class="<?php /*if ($currentpage=="singlearticle" || $currentpage=="articles" || $currentpage=="singlecategory"){echo 'active';}*/?>"><a href="?page=articles">المقالات</a></li>-->
                <span class="btn_item">
                  <?php if($IsLogin){?>
                    <li class="<?php if ($currentpage=="profile"){echo 'active';}?>">
                      <a href="?page=profile">
                        مرحبا
                        <?=$user->name?>
                      </a>
                    </li>
                    <li class="<?php if ($currentpage=="logout"){echo 'active';}?>">
                      <a href="?page=logout">
                        تسجيل الخروج
                      </a>
                    </li>
                  <?php }else{?>
                    <li class="<?php if ($currentpage=="login"){echo 'active';}?>">
                      <!--<button class="btn_login" data-toggle="modal" data-target="#login">دخول</button>-->
                      <a href="?page=login">دخول</a>
                    </li>
                    <li class="<?php if ($currentpage=="signup"){echo 'active';}?>">
                      <!--<button class="btn_register" data-toggle="modal" data-target="#register">مستخدم جديد</button>-->
                      <a href="?page=signup">مستخدم جديد</a>
                    </li>
                  <?php }?>
                </span>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    
	</div>
  </div>
</div>

