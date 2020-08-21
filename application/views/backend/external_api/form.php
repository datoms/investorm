<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?$title:null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="border_preview">
                    <?php echo form_open_multipart("backend/external_api/external_api_setup/form/$apis->id") ?>
                    <?php echo form_hidden('id', $apis->id) ?>
                    <?php
                        $api_data = array();
                        if (is_string($apis->data) && is_array(json_decode($apis->data, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {
                            $api_data = json_decode($apis->data, true);
                        }
                    ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">API Name <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <input name="name" value="<?php echo $apis->name ?>" class="form-control" type="text" id="name" required>
                            </div>
                            <?php   
                                echo "<div class='col-sm-4'>
                                   <a href='https://coinmarketcap.com/api/' target='_blank'>Get Your API Key Now</a>
                                </div>";
                            ?>
                        </div>
                        <div class="form-group row">
                            <label for="api_key" class="col-sm-3 col-form-label">API Key <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <input name="api_key" value="<?php echo @$api_data['api_key'] ?>" class="form-control" type="text" id="api_key" required>
                            </div>
                        </div>                    
                        
                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label"><?php echo display('status') ?></label>
                            <div class="col-sm-5">
                                <label class="radio-inline">
                                    <?php echo form_radio('status', '1', (($apis->status==1 || $apis->status==null)?true:false)); ?><?php echo display('active') ?>
                                 </label>
                                <label class="radio-inline">
                                    <?php echo form_radio('status', '0', (($apis->status=="0")?true:false) ); ?><?php echo display('inactive') ?>
                                 </label> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-3">
                                <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("update") ?></button>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 