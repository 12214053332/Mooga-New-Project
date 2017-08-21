
<div class="container">
    <div class="row">
	
      <?php include("wedget/user-header.php") ?>
		
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 triangle-tabs no-border">
            
            <div class="tab-content">
       
		
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm grey btm-mrg-sm">
                        <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12 def-padding left-border ">
                            <h2 class="line-right sm-font zero-bottom-margin"><span class="black-font">تصنيفات البحث</span></h2>
                            <form class="cust-form col-md-10 col-lg-offset-2 col-md-10 col-lg-offset-2 ">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">ابحث عن </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">في دولة</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">المرحلة</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9">
                                        <label for="" class="col-sm-3 control-label">المشروع يحتاج </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="inlineCheckbox1" value="option1">موزع
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="inlineCheckbox2" value="option2">شريك
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="inlineCheckbox3" value="option3">ممول
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="" class="btn white-btn alg-left mrg-thirty">المزيد</a>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn orange-btn">إبحث</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 def-padding">
                            <p class="black-font sm-font text-center">
                                إقترح لي
                            </p>
                            <p class="grey-font md-font text-justify">
                                الاسم (وجنبه عدد المشروعات اللي تحت المستخدم ده)، والصورة ، البلد   ويتكتب استشاري في مجالات كذا
                            </p>
                            <button type="submit" class="btn orange-btn">   إبدأ</button>
                        </div>
                    </div>
                
                	<?php foreach($projects as $project){
							$project = (object) $project
					?>		
					<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm lg-btm-mrg">
                       
					   <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 left-border def-padding-sm" >
                            <p class="black-font sm-font text-right bold">
                               <?php echo $project->name;?>
                            </p>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <img src="assets/images/project-owner.jpg" class="justified-img">
                            </div>
                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">المشروع:  </p>
                                    <p class="md-font grey-font zero-bottom-margin"><?php echo $project->stage_name;?></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">الدولة: </p>
                                    <p class="md-font  grey-font zero-bottom-margin "><?php echo $project->project_country;?></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">المشاهدات:</p>
                                    <p class="md-font  grey-font zero-bottom-margin "><?php echo $project->views;?></p>
                                </div>
                            </div>
                        </div>
						
                        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12  def-padding-sm">
                            <p class="md-font text-right grey-font zero-bottom-margin sm-top-padding">
                                <?php echo $project->description;?>
                            </p>
                        </div>
                        
                        <div class="left-btns-cont-bottom center-button"><a href="?page=singleproject" class="btn white-btn md-font text-center border-btn">المزيد ...</a></div>

                    </div><!--end single item-->
                
					<?php } ?>
				</div>
               
		
        </div>
    </div>
</div>

