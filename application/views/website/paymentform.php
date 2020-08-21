<?php
$cat_title1  = isset($lang) && $lang =="french"?$cat_info->cat_title1_fr:$cat_info->cat_title1_en;
$cat_title2  = isset($lang) && $lang =="french"?$cat_info->cat_title2_fr:$cat_info->cat_title2_en;
?>
<style type="text/css">
    
.table > tbody > tr {
    height: 40px;
}
</style>
        <div class="page_header" data-parallax-bg-image="<?php echo base_url($cat_info->cat_image); ?>" data-parallax-direction="">
            <div class="header-content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="haeder-text">
                                <h1><?php echo $cat_title1; ?></h1>
                                <p><?php echo $cat_title2; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of page header -->

        <div class="buySell_content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-sm-12 col-md-6 col-lg-6 col-xs-offset-3 col-md-offset-3 col-lg-offset-3">           
                        <div class="payment-process">                           
                                <?php if ($deposit->deposit_method=='bitcoin') { ?>
                                <!-- JS -->
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script> 
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
                                <script src="<?php echo base_url("gourl/js/support.min.js"); ?>" crossorigin="anonymous"></script> 
                                <!-- CSS for Payment Box -->
                                <style>
                                    @media (min-width: 768px) { html { font-size: 16px; } .tooltip-inner { max-width: 350px; } }
                                    .mncrpt .container { max-width: 980px; }
                                    .mncrpt .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
                                    img.radioimage-select { padding: 7px; border: solid 2px #ffffff; margin: 7px 1px; cursor: pointer; box-shadow: none; }
                                    img.radioimage-select:hover { border: solid 2px #a5c1e5; }
                                    img.radioimage-select.radioimage-checked { border: solid 2px #7db8d9; background-color: #f4f8fb; }
                                </style>


<?php   echo $deposit_data['box']->display_cryptobox_bootstrap($deposit_data['coins'], $deposit_data['def_coin'], $deposit_data['def_language'], $deposit_data['custom_text'], $deposit_data['coinImageSize'], $deposit_data['qrcodeSize'], $deposit_data['show_languages'], $deposit_data['logoimg_path'], $deposit_data['resultimg_path'], $deposit_data['resultimgSize'], $deposit_data['redirect'], $deposit_data['method'], $deposit_data['debug']); ?>


                                        <?php } elseif ($deposit->deposit_method=='payeer') { ?>
                                        <div class="col-lg-8 offset-lg-2">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo display("user_id") ?></th>
                                                    <td class="text-right"><?php echo $deposit->user_id ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("payment_gateway") ?></th>
                                                    <td class="text-right"><?php echo $deposit->deposit_method ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("amount") ?></th>
                                                    <td class="text-right">$<?php echo $deposit->deposit_amount ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("fees") ?></th>
                                                    <td class="text-right">$<?php echo (float)@$deposit->fees ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td class="text-right">$<?php echo $deposit->deposit_amount+(float)@$deposit->fees ?></td>
                                                </tr>
                                            </table>
                                            <form method="post" action="https://payeer.com/merchant/">
                                                <input type="hidden" name="m_shop" value="<?php echo $deposit_data['m_shop'] ?>">
                                                <input type="hidden" name="m_orderid" value="<?php echo $deposit_data['m_orderid'] ?>">
                                                <input type="hidden" name="m_amount" value="<?php echo $deposit_data['m_amount'] ?>">
                                                <input type="hidden" name="m_curr" value="<?php echo $deposit_data['m_curr'] ?>">
                                                <input type="hidden" name="m_desc" value="<?php echo $deposit_data['m_desc'] ?>">
                                                <input type="hidden" name="m_sign" value="<?php echo $deposit_data['sign'] ?>">                               
                                                <input type="submit" name="m_process" value="Payment Process" class="btn btn-success w-md m-b-5" />
                                                <a href="<?php echo base_url('deposit'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                                
                                                <br>
                                                <br>
                                                <br>
                                            </form>
                                        </div>
                                        <?php } elseif ($deposit->deposit_method=='paypal')  { ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th><?php echo display("user_id") ?></th>
                                                <td class="text-right"><?php echo $deposit->user_id ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo display("payment_gateway") ?></th>
                                                <td class="text-right"><?php echo $deposit->deposit_method ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo display("amount") ?></th>
                                                <td class="text-right">$<?php echo $deposit->deposit_amount ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo display("fees") ?></th>
                                                <td class="text-right">$<?php echo $deposit->fees ?></td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="text-right">$<?php echo $deposit->deposit_amount+$deposit->fees ?></td>
                                            </tr>
                                        </table>
                                        <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>">Payment Process</a>

                                        <?php } elseif ($deposit->deposit_method=='paystack')  { ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th><?php echo display("user_id") ?></th>
                                                <td class="text-right"><?php echo $deposit->user_id ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo display("payment_gateway") ?></th>
                                                <td class="text-right"><?php echo $deposit->deposit_method ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo display("amount") ?></th>
                                                <td class="text-right">$<?php echo $deposit->deposit_amount ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo display("fees") ?></th>
                                                <td class="text-right">$<?php echo $deposit->fees ?></td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="text-right">$<?php echo $deposit->deposit_amount+$deposit->fees ?></td>
                                            </tr>
                                        </table>
                                        <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data ?>">Payment Process</a>

                                        <?php } elseif ($deposit->deposit_method=='coinpayment')  { ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>
                                                    <strong>Important</strong></br>
                                                    <ul>
                                                        <li>
                                                        Send Only <strong><?=$deposit->currency_symbol;?></strong>
                                                        deposit address. Sending any other coin or token to this address may result in the loss of your deposit.</li>
                                                    </ul>
                                                    <br>
                                                    <center>
                                                    <div class="diposit-address" style="margin-top: 25px">
                                                        <div class="label">
                                                            <?php echo $deposit->currency_symbol; ?> Diposit Address.
                                                        </div>
                                                        <div class="dip_address">
                                                            <strong><input type="text" id="copyed" value="<?=$deposit_data['result']['address']?>" readonly="readonly"/></strong>
                                                        </div>
                                                        <div class="copy_address" style="margin-top: 10px">
                                                            <button  class="btn btn-primary" onclick="copyFunction()">Copy Address</button>
                                                        </div>
                                                        <div class="diposit-qrcode" style="margin-top: 25px">
                                                            <div class="qrcode">
                                                                <img src="<?=$deposit_data['result']['qrcode_url']?>" />
                                                            </div>
                                                        </div>
                                                        <div class="deposit-balance" style="margin-top: 5px">
                                                            <h2 style="font-family: inherit;">$<?php echo number_format($deposit->deposit_amount+(float)@$deposit->fees,8)." <span style='font-weight:normal'>"; ?></span></h2>
                                                        </div>
                                                    </div>
                                                    </center>

                                                    <div class="please-note" style="margin-top: 10px">
                                                        <div class="label_note">
                                                            Please Note
                                                        </div>
                                                        <div class="textnote">
                                                            <ul>
                                                                <li>Coins will be deposited immediately after <font color="#03a9f4"><?=$deposit_data['result']['confirms_needed'];?></font> network confirmations</li>
                                                                <li>You can track its progress on the <a target="_blank" href="<?=$deposit_data['result']['status_url'];?>">history</a>  page</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="please-note" style="margin-top: 10px">
                                                        <div class="label_note">
                                                            <a href="<?=base_url()?>"><button type="button" class="btn btn-success">Back</button></a>
                                                        </div>
                                                    </div>
                                                    <style type="text/css">
                                                        .dip_address{
                                                            border: 1px solid #ddd;
                                                            background: #ddd;
                                                            width: 300px;
                                                            padding: 5px;
                                                        }
                                                        .dip_address input{
                                                            width: 100%;
                                                            border: transparent;
                                                            background: transparent;
                                                            font-weight: bold;
                                                            font-size: 14px;
                                                            text-align: center;
                                                        }
                                                        #copydaddress{
                                                            width: 100%;
                                                            background: no-repeat;
                                                            border: 0;
                                                            text-align: center;
                                                            font-weight: bold;
                                                        }
                                                    </style>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php } elseif ($deposit->deposit_method=='token') { ?>
                                        <?php  $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'token')->where('status',1)->get()->row(); ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>
                                                    <strong>Important</strong></br>
                                                    <ul>
                                                        <li>
                                                        Send Only <strong><?php echo $deposit->currency_symbol;?></strong>
                                                        deposit address. Sending any other coin or token to this address may result in the loss of your deposit.</li>
                                                    </ul>
                                                    <br>
                                                    <center>
                                                        <div class="diposit-address" style="margin-top: 25px">
                                                            <div class="label">
                                                                <?php echo $deposit->currency_symbol;?> Deposit Address.
                                                            </div>
                                                            <div class="dip_address">
                                                                <strong><input type="text" id="copyed" value="<?php echo @$gateway->public_key ?>" readonly="readonly"/></strong>
                                                            </div>
                                                            <div class="copy_address" style="margin-top: 10px">
                                                                <button  class="btn btn-primary" onclick="copyFunction()">Copy Address</button>
                                                            </div>
                                                            <?php if ($gateway->secret_key=='show') { ?>
                                                            <div class="diposit-qrcode" style="margin-top: 25px">
                                                                <div class="qrcode">
                                                                    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo @$gateway->public_key ?>&choe=UTF-8" />
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <p style="font-size:22px">$<?php echo $deposit->deposit_amount+(float)@$deposit->fees ?></p>
                                                    </center>

                                                    <div class="please-note" style="margin-top: 10px">
                                                        <div class="textnote">
                                                            <?php echo @$gateway->private_key ?>
                                                        </div>
                                                    </div>
                                                    <div class="please-note" style="margin-top: 10px">
                                                        <div class="label_note">
                                                            <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>">Payment complete</a>
                                                            <a class="btn btn-danger w-md m-b-5 text-right" href="<?php echo $deposit_data['cancel_url'] ?>">Cancel</a>
                                                        </div>
                                                    </div>
                                                    <style type="text/css">
                                                        .dip_address{
                                                            border: 1px solid #ddd;
                                                            background: #ddd;
                                                            width: 300px;
                                                            padding: 5px;
                                                        }
                                                        .dip_address input{
                                                            width: 100%;
                                                            border: transparent;
                                                            background: transparent;
                                                            font-weight: bold;
                                                            font-size: 14px;
                                                            text-align: center;
                                                        }
                                                        #copydaddress{
                                                            width: 100%;
                                                            background: no-repeat;
                                                            border: 0;
                                                            text-align: center;
                                                            font-weight: bold;
                                                        }
                                                    </style>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php } elseif ($deposit->deposit_method=='stripe')  { ?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo display("user_id") ?></th>
                                                    <td class="text-right"><?php echo $deposit->user_id ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("payment_gateway") ?></th>
                                                    <td class="text-right"><?php echo $deposit->deposit_method ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("amount") ?></th>
                                                    <td class="text-right">$<?php echo $deposit->deposit_amount ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("fees") ?></th>
                                                    <td class="text-right">$<?php echo $deposit->fees ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td class="text-right">$<?php echo $deposit->deposit_amount+(float)@$deposit->fees ?></td>
                                                </tr>
                                            </table>
                                            <?php echo form_open('payment_callback/stripe_confirm', 'method="post" '); ?>
                                            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?php echo $deposit_data['stripe']['publishable_key']; ?>" data-description="<?php echo $deposit_data['description'] ?>" data-amount="<?php $total = $deposit->deposit_amount+$deposit->fees; echo round($total*100) ?>" data-locale="auto">
                                            </script>
                                        <?php echo form_close();?>

                                        <?php } elseif ($deposit->deposit_method=='phone')  { ?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo display("user_id") ?></th>
                                                    <td class="text-right"><?php echo $deposit->user_id ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("payment_gateway") ?></th>
                                                    <td class="text-right"><?php echo $deposit->deposit_method ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("amount") ?></th>
                                                    <td class="text-right">$<?php echo @$deposit->deposit_amount ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("fees") ?></th>
                                                    <td class="text-right">$<?php echo @$deposit->fees ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td class="text-right">$<?php echo @$deposit->deposit_amount+@$deposit->fees ?></td>
                                                </tr>
                                            </table>
                                            <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>">Payment Process</a>

                                        <?php } elseif ($deposit->deposit_method=='bank')  { ?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo display("user_id") ?></th>
                                                    <td class="text-right"><?php echo $deposit->user_id ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("payment_gateway") ?></th>
                                                    <td class="text-right"><?php echo $deposit->deposit_method ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("amount") ?></th>
                                                    <td class="text-right">$<?php echo @$deposit->deposit_amount ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo display("fees") ?></th>
                                                    <td class="text-right">$<?php echo @$deposit->fees ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td class="text-right">$<?php echo @$deposit->deposit_amount+@$deposit->fees ?></td>
                                                </tr>
                                            </table>
                                            <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>">Payment Process</a>

                                        <?php } elseif ($deposit->deposit_method=='ppay')  { ?>
                                        <?php echo form_open($deposit_data['approval_url'], array('name'=>'ppay_form','class'=>'f1', 'id'=>'ppay_form'));?>
                                            
                                            <fieldset>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="first_name" class="col-md-5 col-form-label">First name<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="first_name" type="text" class="form-control" id="first_name" value="<?php echo @$deposit_data['first_name']; ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="last_name" class="col-md-5 col-form-label">Last name<i class="text-danger">*</i></label>
                                                            <div class="col-md-7">
                                                                <input name="last_name" type="text" class="form-control" id="last_name" value="<?php echo @$deposit_data['last_name']; ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="user_email" class="col-md-5 col-form-label">User email<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="user_email" type="text" class="form-control" id="user_email" value="<?php echo @$deposit_data['email']; ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="user_phone" class="col-md-5 col-form-label">User phone<i class="text-danger">*</i></label>
                                                            <div class="col-md-7">
                                                                <input name="user_phone" type="text" class="form-control" id="user_phone" value="<?php echo @$deposit_data['phone']; ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="address1" class="col-md-5 col-form-label">Address1<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="address1" type="text" class="form-control" id="address1" value="<?php echo @$address1; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="address2" class="col-md-5 col-form-label">Address2</label>
                                                            <div class="col-md-7">
                                                                <input name="address2" type="text" class="form-control" id="address2" value="<?php echo @$address2; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="city" class="col-md-5 col-form-label">City<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="city" type="text" class="form-control" id="city" value="<?php echo @$city; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="zip" class="col-md-5 col-form-label">Zip<i class="text-danger">*</i></label>
                                                            <div class="col-md-7">
                                                                <input name="zip" type="text" class="form-control" id="zip" value="<?php echo @$zip; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="country" class="col-md-5 col-form-label">Country<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="country" type="text" class="form-control" id="country" value="<?php echo @$country; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="state" class="col-md-5 col-form-label">State<i class="text-danger">*</i></label>
                                                            <div class="col-md-7">
                                                                <input name="state" type="text" class="form-control" id="state" value="<?php echo @$state; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="f1-buttons">
                                                    <button type="button" class="btn btn-success btn-next">Next</button>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="nameoncard" class="col-md-5 col-form-label">Name on card<i class="text-danger">*</i></label>
                                                            <div class="col-md-7">
                                                                <input name="nameoncard" type="text" class="form-control" id="nameoncard" value="<?php echo @$deposit->nameoncard ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="card_type" class="col-md-5 col-form-label">Card type<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="card_type" type="text" class="form-control" id="card_type" value="<?php echo @$card_type; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="card_number" class="col-md-5 col-form-label">Card number<i class="text-danger">*</i></label>
                                                            <div class="col-md-7">
                                                                <input name="card_number" type="text" class="form-control" id="card_number" value="<?php echo @$card_number; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="card_exp_month" class="col-md-5 col-form-label">Card exp month<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="card_exp_month" type="text" class="form-control" id="card_exp_month" value="<?php echo @$card_exp_month; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="cvv" class="col-md-5 col-form-label">CVV<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="cvv" type="text" class="form-control" id="cvv" value="<?php echo @$cvv; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="card_exp_year" class="col-md-5 col-form-label">Card exp year<i class="text-danger">*</i></label>
                                                            <div class="col-md-7">
                                                                <input name="card_exp_year" type="text" class="form-control" id="card_exp_year" value="<?php echo @$card_exp_year; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>                                    
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="fees" class="col-md-5 col-form-label">Fees<i class="text-danger">*</i></label>                                        
                                                            <div class="col-md-7">
                                                                <input name="fees" type="text" class="form-control" id="fees" value="<?php echo @$deposit->fees?@$deposit->fees:'0.00' ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <label for="total" class="col-md-5 col-form-label">Total Amount<i class="text-danger">*</i></label>
                                                            <div class="col-md-7">
                                                                <input name="total" type="text" class="form-control" id="total" value="<?php echo @$deposit->deposit_method+@$deposit->fees ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="f1-buttons">
                                                    <button type="button" class="btn btn-previous">Previous</button>
                                                    <button type="submit" class="btn btn-success w-md m-b-5 text-right">Payment Process</button>
                                                </div>
                                            </fieldset>
                                            <?php echo form_close();?>
                                        <?php } ?>


                           

                        </div>
                    </div>
                </div>
            </div>
        </div>
 