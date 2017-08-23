                                <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12">
										 <h2 class="full-lines sm-font"><span class="blue-font">بيانات الاتصال</span></h2>
										 </div>
									 <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <!--label for="contact_type" class=" control-label md-font bold black-font">طريقة التواصل عبر :<span class="asterisc">*</span> </label-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                          <select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" id="contact_type" name="contact_type" data-placeholder="">

											<option value="1"  <?php if (getvalue('contact_type') !=2) {
    echo 'selected';
} ?>>عبر الهاتف</option>
											<option value="2" <?php if (getvalue('contact_type') ==2) {
    echo 'selected';
} ?>>عبر البريد الإلكترونى</option>

                                                 </select>
                                        </div>
                                    </div>
									<div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                        <!--label for="contact_name" class=" control-label md-font bold black-font">اسم صاحب الهاتف<span class="asterisc">*</span> </label-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder=" * اسم صاحب الهاتف"   value="<?php printvalue('contact_name'); ?>">

                                        </div>
                                    </div>
									<div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12" id="contact_section">
                                        <!--label for="contact_phone" class="control-label md-font bold black-font col-lg-12 col-md-12 col-xs-12 col-sm-12">هاتف الاتصال <span class="asterisc">*</span></label-->
										<div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
                                            <input type="number" class="form-control" id="contact_phone" maxlength="11"  minlength="9" name="contact_phone" placeholder="* هاتف الاتصال"   value="<?php printvalue('contact_phone'); ?>">

                                        </div>
                                          <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">

												<select class="form-control cust-input-width cust-input-width-three zero-top-margin hi25 valid chosen-select" id="country_1" name="country_1" required data-placeholder=" * اختر الدولة">

													<option value=""></option>
													  <?php
                                                               $ids=getvalue('country');
                                                               $select="";
                                                                foreach ($countries as $country) {
                                                                    $id=$country['id'];
                                                                    $name=$country['name'];
                                                                    $code=$country['code'];
                                                                    if ($ids==$id) {
                                                                        $select="selected";
                                                                    } else {
                                                                        $select="";
                                                                    }
                                                                    echo " <option value='$id'  data-code='$code' $select>$code - $name</option> ";
                                                                }
                                                     ?>
                                                 </select>

                                                </div>

                                    </div>
