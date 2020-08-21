<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?$title:null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                <div class="border_preview">
                <?php echo form_open_multipart("backend/pin/pin/form/") ?>
      

                    <div class="form-group row">
                        <label for="pin_name" class="col-sm-4 col-form-label"><?php  echo "Pin Prefix" ?> *</label>
                        <div class="col-sm-8">
                            <input name="pin_prefix" maxlength="3" value="<?php echo $pin->pin_prefix ?>" class="form-control text-uppercase" placeholder="<?php echo display('pin_name') ?>" type="text" id="pin_prefix" data-toggle="tooltip" title="<?php echo display('tooltip_pin_name') ?> ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pin_name" class="col-sm-4 col-form-label"><?php  echo "Pin Amount" ?> *</label>
                        <div class="col-sm-8">
                            <input name="pin_amount" value="<?php echo $pin->pin_amount ?>" class="form-control" placeholder="<?php echo display('pin_name') ?>" type="number" id="pin_code" data-toggle="tooltip" title="<?php echo display('tooltip_pin_name') ?> ">
                        </div>
                    </div>


                    
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo "Generate" ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
