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
                    <?php echo form_open_multipart("backend/dashboard/setting//update_email_gateway") ?>
                    <?php echo form_hidden('es_id',$email->es_id) ?>
                    <div class="col-md-6">   
          
                        <div class="form-group row">
                            <label for="email_title" class="col-xs-3 col-form-label"><?php echo display('title') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_title" type="text" class="form-control" id="email_title" placeholder="<?php echo display('title') ?>" value="<?php echo $email->title ?>" required>
                            </div>
                        </div>                                         
                        <div class="form-group row">
                            <label for="email_protocol" class="col-xs-3 col-form-label"><?php echo display('protocol') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_protocol" type="text" class="form-control" id="email_protocol" placeholder="<?php echo display('protocol') ?>" value="<?php echo $email->protocol ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_host" class="col-xs-3 col-form-label"><?php echo display('host') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_host" type="text" class="form-control" id="email_host" placeholder="<?php echo display('host') ?>" value="<?php echo $email->host ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_port" class="col-xs-3 col-form-label"><?php echo display('port') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_port" type="text" class="form-control" id="email_port" placeholder="<?php echo display('port') ?>" value="<?php echo $email->port ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_user" class="col-xs-3 col-form-label"><?php echo display('username') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_user" type="text" class="form-control" id="email_user" placeholder="<?php echo display('username') ?>" value="<?php echo $email->user ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_password" class="col-xs-3 col-form-label"><?php echo display('password') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_password" type="password" class="form-control" id="email_password" placeholder="<?php echo display('password') ?>" value="<?php echo base64_encode($email->password) ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_mailtype" class="col-xs-3 col-form-label"><?php echo display('mail_type') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_mailtype" type="text" class="form-control" id="email_mailtype" placeholder="<?php echo display('mail_type') ?>" value="<?php echo $email->mailtype ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_charset" class="col-xs-3 col-form-label"><?php echo display('charset') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_charset" type="text" class="form-control" id="email_charset" placeholder="<?php echo display('charset') ?>" value="<?php echo $email->charset ?>" required>
                            </div>
                        </div>
                
                        <div>
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                        <div class="row">
                            <div class="col-sm-9 col-sm-offset-2">
                                <div class="notice-board">
                                    <p>Note: If problem with google smtp then please use another third party smtp server
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open_multipart("backend/dashboard/setting//test_email") ?>
                    <div class="col-md-6">
                        <h3 class="text-center">Email Test</h3>

                        <div class="form-group row">
                            <label for="email_to" class="col-xs-3 col-form-label">To<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_to" type="email" class="form-control" id="email_to" placeholder="e. example@mail.com" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_sub" class="col-xs-3 col-form-label">Subject<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="email_sub" type="text" class="form-control" id="email_sub" placeholder="e. Test Mail" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_message" class="col-xs-3 col-form-label">Message<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <textarea rows="5" class="form-control" name="email_message" id="email_message"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-9 col-md-offset-3">
                                <button type="submit" class="btn btn-success"><?php echo display("send") ?></button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div> 
            </div>
        </div>
    </div>
</div>