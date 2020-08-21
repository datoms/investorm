<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd ">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?$title:null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php echo form_open_multipart("backend/dashboard/setting/update_sms_gateway") ?>
                    <?php echo form_hidden('es_id', $sms->es_id) ?>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="gatewayname" class="col-xs-3 col-form-label">Gateway <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <select class="form-control basic-single" name="gatewayname" id="gatewayname" required>
                                    <option>Select Option</option>
                                    <option value="smsrank" <?php echo ($sms->gatewayname=="smsrank")?'Selected':'' ?>>SMSRank</option>
                                    <option value="budgetsms" <?php echo ($sms->gatewayname=="budgetsms")?'Selected':'' ?> >BudgetSMS</option>
                                    <option value="infobip" <?php echo ($sms->gatewayname=="infobip")?'Selected':'' ?>>Infobip</option>
                                    <option value="nexmo" <?php echo ($sms->gatewayname=="nexmo")?'Selected':'' ?>>Nexmo</option>
                                </select>
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <label for="title" class="col-xs-3 col-form-label"><?php echo display('title') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="title" type="text" class="form-control" id="title" placeholder="<?php echo display('title') ?>" value="<?php echo $sms->title ?>" required>
                            </div>
                        </div>
                        <span id="sms_field"> </span>                    
                        <div>
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                        <?php echo form_close(); ?>

                        <div class="form-group row">
                            <div class="col-xs-12">
                            <br>
                            <br>
                                <p>For SMS Gateway Use <a href="http://www.smsrank.com/" target="_blank"><b>SMSRank</b></a>/<a href="https://www.budgetsms.net" target="_blank"><b>budgetsms</b></a>/<a href="https://www.infobip.com" target="_blank"><b>infobip</b></a>/<a href="https://www.nexmo.com" target="_blank"><b>nexmo</b></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-xs-12">
                                <h3 class="text-center">SMS TEST</h3>
                            </div>
                        </div>                        
                        <?php echo form_open_multipart("backend/dashboard/setting/test_sms") ?>
                        <div class="form-group row">
                            <label for="mobile_num" class="col-xs-3 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="mobile_num" id="mobile_num" placeholder="e. 88xxxxxxxx">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="test_message" class="col-xs-3 col-form-label">Message <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <textarea rows="5" class="form-control" name="test_message" id="test_message" placeholder="Test Message"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success"><?php echo display("send") ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $("#gatewayname").on("change", function(event) {
            event.preventDefault();
            var gatewayname = $("#gatewayname").val();
            if (gatewayname==='budgetsms') {
                $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'><?php echo display('host') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='<?php echo display('host') ?>' value='<?php echo ($sms->gatewayname=='budgetsms')?$sms->host:'' ?>' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'><?php echo display('username') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='<?php echo display('username') ?>' value='<?php echo ($sms->gatewayname=='budgetsms')?$sms->user:'' ?>' required></div></div><div class='form-group row'><label for='userid' class='col-xs-3 col-form-label'><?php echo display('user_id') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='userid' type='text' class='form-control' id='userid' placeholder='<?php echo display('user_id') ?>' value='<?php echo ($sms->gatewayname=='budgetsms')?$sms->userid:'' ?>' required></div></div><div class='form-group row'><label for='api' class='col-xs-3 col-form-label'><?php echo display('apikey') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='api' type='text' class='form-control' id='api' placeholder='<?php echo display('apikey') ?>' value='<?php echo ($sms->gatewayname=='budgetsms')?$sms->api:'' ?>' required></div></div>");

            }else if(gatewayname==='infobip'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'><?php echo display('host') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='<?php echo display('host') ?>' value='<?php echo ($sms->gatewayname=='infobip')?$sms->host:'' ?>' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'><?php echo display('username') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='<?php echo display('username') ?>' value='<?php echo ($sms->gatewayname=='infobip')?$sms->user:'' ?>' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'><?php echo display('password') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='<?php echo display('password') ?>' value='<?php echo base64_encode(($sms->gatewayname=='infobip')?$sms->password:'') ?>' required></div></div>");

            }else if(gatewayname==='smsrank'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'><?php echo display('host') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='<?php echo display('host') ?>' value='<?php echo ($sms->gatewayname=='smsrank')?$sms->host:'' ?>' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'><?php echo display('username') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='<?php echo display('username') ?>' value='<?php echo ($sms->gatewayname=='smsrank')?$sms->user:'' ?>' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'><?php echo display('password') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='<?php echo display('password') ?>' value='<?php echo base64_encode(($sms->gatewayname=='smsrank')?$sms->password:'') ?>' required></div></div>");

            }else if(gatewayname==='nexmo'){
               $( "#sms_field").html("<div class='form-group row'><label for='api' class='col-xs-3 col-form-label'><?php echo display('apikey') ?><i class='text-danger'>*</i></label><div class='col-xs-9'><input name='api' type='text' class='form-control' id='api' placeholder='<?php echo display('apikey') ?>' value='<?php echo ($sms->gatewayname=='nexmo')?$sms->api:'' ?>' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'><?php echo display('app_secret') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='<?php echo display('password') ?>' value='<?php echo ($sms->gatewayname=='nexmo')?base64_encode($sms->password):'' ?>' required></div></div>");

            }else if(gatewayname==='twilio'){
                $( "#sms_field").html("<h3><a href='https://www.twilio.com'>Twilio</a> Is On Development</h3>"); 

            }
            else{
                $( "#sms_field").html("<h3>Nothing Found</h3>");

            }

        });


        var gatewayname = $("#gatewayname").val();

        if (gatewayname==='budgetsms') {
                $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'><?php echo display('host') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='<?php echo display('host') ?>' value='<?php echo ($sms->gatewayname=='budgetsms')?$sms->host:'' ?>' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'><?php echo display('username') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='<?php echo display('username') ?>' value='<?php echo ($sms->gatewayname=='budgetsms')?$sms->user:'' ?>' required></div></div><div class='form-group row'><label for='userid' class='col-xs-3 col-form-label'><?php echo display('user_id') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='userid' type='text' class='form-control' id='userid' placeholder='<?php echo display('user_id') ?>' value='<?php echo ($sms->gatewayname=='budgetsms')?$sms->userid:'' ?>' required></div></div><div class='form-group row'><label for='api' class='col-xs-3 col-form-label'><?php echo display('apikey') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='api' type='text' class='form-control' id='api' placeholder='<?php echo display('apikey') ?>' value='<?php echo ($sms->gatewayname=='budgetsms')?$sms->api:'' ?>' required></div></div>");

            }else if(gatewayname==='infobip'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'><?php echo display('host') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='<?php echo display('host') ?>' value='<?php echo ($sms->gatewayname=='infobip')?$sms->host:'' ?>' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'><?php echo display('username') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='<?php echo display('username') ?>' value='<?php echo ($sms->gatewayname=='infobip')?$sms->user:'' ?>' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'><?php echo display('password') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='<?php echo display('password') ?>' value='<?php echo base64_encode(($sms->gatewayname=='infobip')?$sms->password:'') ?>' required></div></div>");

            }else if(gatewayname==='smsrank'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'><?php echo display('host') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='<?php echo display('host') ?>' value='<?php echo ($sms->gatewayname=='smsrank')?$sms->host:'' ?>' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'><?php echo display('username') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='<?php echo display('username') ?>' value='<?php echo ($sms->gatewayname=='smsrank')?$sms->user:'' ?>' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'><?php echo display('password') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='<?php echo display('password') ?>' value='<?php echo base64_encode(($sms->gatewayname=='smsrank')?$sms->password:'') ?>' required></div></div>");

            }else if(gatewayname==='nexmo'){
               $( "#sms_field").html("<div class='form-group row'><label for='api' class='col-xs-3 col-form-label'><?php echo display('apikey') ?><i class='text-danger'>*</i></label><div class='col-xs-9'><input name='api' type='text' class='form-control' id='api' placeholder='<?php echo display('apikey') ?>' value='<?php echo ($sms->gatewayname=='nexmo')?$sms->api:'' ?>' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'><?php echo display('app_secret') ?> <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='<?php echo display('password') ?>' value='<?php echo ($sms->gatewayname=='nexmo'?base64_encode($sms->password):'') ?>' required></div></div>");

            }else if(gatewayname==='twilio'){
                $( "#sms_field").html("<h3><a href='https://www.twilio.com'>Twilio</a> Is On Development</h3>"); 

            }
            else{
                $( "#sms_field").html("<h3>Nothing Found</h3>");

            }

    }); 
</script>