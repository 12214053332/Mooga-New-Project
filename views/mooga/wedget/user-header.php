
<?php if (isset($user->id)) {?>
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="head">
                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="container">
                                <ul class="nav">
                                    <li>
                                        <a title="بيانات الحساب" class="edit_profile" href="?page=profile_edit">
                                           تعديل الحساب

                                        </a>
                                    </li>

                                    <li>
                                        <a href="?page=myprojects">
                                            مشروعاتى
                                            <span class="label label-info"><?=$user->projects;?></span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="?page=myoffers">
                                            عروض جملة
                                            <span class="label label-info"><?=$user->offers;?></span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="?page=inbox">
                                            الرسائل
                                            <span class="label label-info"><?=$messagecount;?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=forgetpassword&action=changepassword">
                                            تغير كلمة المرور
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>