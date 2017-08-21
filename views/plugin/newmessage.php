       
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 panel panel-default panel-custom padding-custom mrg-btm-lg bg-gry">
                    <div class="panel-body no-pad-bor">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bg-gry lg-pdg no-brd-lft mobile-headr">
                            <h3 class="panel-title custom-line">Create new message</h3>
                        
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#msgs-collapse" aria-expanded="false">
                                <span class="sr-only"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="result"></div> 
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bg-wht no-brd-top no-brd-lft fixed-ht scroll-div-lg rt" id="msgs-collapse">
                            <form class="form-horizontal" id="MessageComposeForm" method="post" action="#">
                                <div class="form-group">
                                    <label for="selectuser" class="col-sm-2 control-label">Send to</label>
                                    <div class="col-sm-10">
                                        <select  required="" name="user2_id" class="form-control" id="selectuser" >
                                            <option value="">Select User</option>
                                            <?php 
                                          
                                            foreach ($leadslist as $row )
                                            {
                                                $select="";
                                                $code= $row['lead_id'];
                                                $name= $row['firstname'].' ' .$row['lastname']; 
                                                if ($code==$sendto)$select="selected";
                                                
                                                echo "<option value='$code' $select   >$name</option>";
                                            }
                                           ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="col-sm-2 control-label">Subject</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"  name="title" id="subject" placeholder="subject">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Message" class="col-sm-2 control-label">Message</label>
                                    <div class="col-sm-10">
                                        <textarea  required="" name="message" class="form-control" id="Message" placeholder="Message" style="min-height: 100px"></textarea>
                                    </div>
                                </div>
                                <a href="#" id="MessageComposeFormSubmit" class="btn btn-green send-msg-btn-lead pull-right">Send</a>
                                <a href="#" class="btn btn-dark send-msg-btn-lead pull-right">Cancel</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
       
