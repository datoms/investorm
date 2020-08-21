<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-body">

            <?php if ($latest_version!=$current_version) { ?>
                <?php echo form_open_multipart("backend/autoupdate/update") ?>
                    <div class="row">
                        <div class="form-group col-lg-8 col-sm-offset-2">
                            <blink class="text-success text-center" style="font-size: 32px;margin-bottom: 36px;display: block;"><?php echo @$message_txt ?></blink>
                            <blink class="text-waring text-center" style="font-size: 32px;margin-bottom: 36px;display: block;"><?php echo @$exception_txt ?></blink>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="alert alert-success text-center" style="font-size:18px;    line-height: 28px;">Latest version <br>V-<?php echo $latest_version ?></div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="alert alert-danger text-center" style="font-size:18px;    line-height: 28px;">Current version <br>V-<?php echo $current_version ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-lg-6 col-sm-offset-3">
                            <p class="alert" style="color:#8a4246;background-color:#ffedb6;border: 2px dotted #ffd479;;border-radius:5px;padding:15px;margin-bottom:20px;">note: strongly recomanded to backup your <b>SOURCE FILE</b> and <b>DATABASE</b> before update.</p>
                            <label>Licence/Purchase key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="purchase_key">
                        </div>
                    </div> 
                    <div>
                        <button type="submit" class="btn btn-success col-sm-offset-5" onclick="return confirm('are you sure want to update?')"><i class="fa fa-wrench" aria-hidden="true"></i> Update</button>
                    </div>
                <?php echo form_close() ?>

                <?php } else{  ?>
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-offset-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-success text-center" style="font-size:18px;    line-height: 28px;">Current version <br>V-<?php echo $current_version ?></div>
                                    <h2 class="text-center">No Update available</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<style type="text/css">
blink {
    -webkit-animation: 2s linear infinite condemned_blink_effect; // for android
    animation: 2s linear infinite condemned_blink_effect;
}
@-webkit-keyframes condemned_blink_effect { // for android
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
}
@keyframes condemned_blink_effect {
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
}
</style>

 