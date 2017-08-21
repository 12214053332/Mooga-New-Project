
 


<div class="container">
    <div class="row">

        <div class="col-lg-12 col-xs-12 col-md-12 col-xs-12 def-padding">
            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12 center-table">
                <h2 class="full-lines sm-font"><span class="blue-font">اتصل بنا</span></h2>
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 grey-border def-padding">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">
                            <div class="col-md-10 col-lg-10 col-xs-10 col-sm-10 center-table">
							
                                <form class="contactus-form" id="contactus-form" action="#" method="post">
								
								   <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <label class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>الغرض</label>
										
                                        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
                                         <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid" name="type" id="type" >
											   <option value="">--اختر الغرض--</option>
											   <option value="أستفسار">أستفسار</option>  
											   <option value="مقترح">مقترح</option>   
										       <option value="شكوى">شكوى</option>  
                                               <option value="طلب تعاون">طلب تعاون</option>  											   
											   
										 </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <label class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>الاسم</label>
										
                                        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
                                             <input type="text" class="form-control" id="name" name="name" placeholder="" value="">
											 
											 <label for="name"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <label  class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>الإيميل</label>
                                        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
										<input type="email" class="form-control" id="email" name="email" placeholder="" value="">
										<label for="email"></label>
                                           
                                        </div>
                                    </div>
									
									<div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <label  class="col-sm-3 control-label md-font bold black-font">التليفون</label>
                                        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
										<input type="phone" class="form-control" id="phone" name="phone" placeholder="" value="">
										<label for="phone"></label>
                                           
                                        </div>
                                    </div>
									
                                    <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <label class="col-sm-3 control-label md-font bold black-font"><span class="asterisc">*</span>الرساله</label>
                                        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
                                            <textarea type="text" class="form-control" id="message"  name="message" placeholder=""></textarea>
											<label for="message"></label>
                                        </div>
                                    </div>
								
                                    <div class="form-group">
                                        <button class="btn orange-btn" name="submit">ارسال</button>
                                    </div>
									 
										<div class="form-group">
											<div id="contactus-response">
                                                
                                            </div>
										 </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

 <script>
 $( document ).ready(function() {
    //$( "#expiredate" ).datepicker();
	$( "#expiredate" ).datepicker({ dateFormat: 'yy-mm-dd' });
	
});
  
  </script>

