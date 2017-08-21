<?php
$articleid="";
foreach($category_data as $category){
    $category = (object) $category;
    $articleid=$this->registry->encryption->encode($category->id);
    ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 lg-btm-mrg">


        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border round-corner def-padding-sm ">
            <h2 class="line-right sm-font zero-bottom-margin"><span class="blue-font"><?php echo $category->name;?></span></h2>
            <div class="col-sm-12 col-xs-12 col-md-9 col-lg-9 def-padding zero-top-padding">
                <p class="green-font md-font text-right">
                    <?php //echo substr($category->description,0,1000);?>
                    <?php  echo $helper->__html($category->description,236,
                        array('html' => true, 'ending' => '')); ?>
                </p>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
                <img class="" src="<?php echo $category->picpath;?>">
            </div>
            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">المشاهدات:</p>
                <p class="md-font  grey-font zero-bottom-margin "><?php echo $category->views;?></p>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                <p class="md-font  orange-font zero-bottom-margin cst-right-alignment">تاريخ النشر</p>
                <p class="md-font  grey-font zero-bottom-margin "><?php echo date('d-m-Y',strtotime($category->article_date));?></p>
            </div>
            <div class="left-btns-cont-bottom"><a href="?page=singlearticle&id=<?php echo $this->registry->encryption->encode($category->id);?>" class="btn white-btn md-font text-center border-btn">المزيد ...</a></div>
        </div>
    </div>
<?php }
if ($articleid!="" || $articleid!=null){
    echo "<div id='articleid' data-articleid='$articleid'></div><div id='catid' data-catid='$catid'></div>";
}?>
