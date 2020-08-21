<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment
{

    public function payment_process($sdata, $method = NULL)
    {

        $CI = &get_instance();
        $gateway = $CI->db->select('*')->from('payment_gateway')->where('identity', $method)->where('status', 1)->get()->row();

        if ($method == 'bitcoin') {

            /********************************
             * GoUrl Cryptocurrency Payment API
             *********************************/
            if ($gateway) {

                $coin = 'bitcoin';

                // Change path to your files
                // --------------------------------------
                DEFINE("CRYPTOBOX_PHP_FILES_PATH", base_url('/gourl/lib/'));         // path to directory with files: cryptobox.class.php / cryptobox.callback.php / cryptobox.newpayment.php; 
                // cryptobox.newpayment.php will be automatically call through ajax/php two times - payment received/confirmed
                DEFINE("CRYPTOBOX_IMG_FILES_PATH", base_url('gourl/images/'));      // path to directory with coin image files (directory 'images' by default)
                DEFINE("CRYPTOBOX_JS_FILES_PATH", base_url('gourl/js/'));           // path to directory with files: ajax.min.js/support.min.js


                // Change values below
                // --------------------------------------
                DEFINE("CRYPTOBOX_LANGUAGE_HTMLID", "alang");   // any value; customize - language selection list html id; change it to any other - for example 'aa';   default 'alang'
                DEFINE("CRYPTOBOX_COINS_HTMLID", "acoin");      // any value;  customize - coins selection list html id; change it to any other - for example 'bb'; default 'acoin'
                DEFINE("CRYPTOBOX_PREFIX_HTMLID", "acrypto_");  // any value; prefix for all html elements; change it to any other - for example 'cc';  default 'acrypto_'




                // Open Source Bitcoin Payment Library
                // ---------------------------------------------------------------
                require_once(FCPATH . "gourl/lib/cryptobox.class.php");

                /*********************************************************/
                /****  PAYMENT BOX CONFIGURATION VARIABLES  ****/
                /********************************************************/
                // IMPORTANT: Please read description of options here - https://gourl.io/api-php.html#options
                $paytype = $CI->session->userdata('payment_type');


                $userID                 = $sdata->user_id;
                $userFormat             = "COOKIE";
                $orderID                = @$paytype . '_' . @$sdata->user_id . '_' . time();
                $amountUSD              = (float)@$sdata->deposit_amount + (float)@$sdata->fees;
                $period                 = "NOEXPIRY";
                $def_language           = "en";
                $data['def_language']   = "en";
                $def_coin               = $coin;
                $data['def_coin']       = $coin;


                $coins = array($coin);
                $data['coins'] = array($coin);

                // $pub_key = unserialize($gateway->public_key);
                // $pri_key = unserialize($gateway->private_key);
                $pub_val = $gateway->public_key;
                $piv_val = $gateway->private_key;
                // foreach ($pub_key as $key => $value) { 
                //     if ($coin == $key && $value!='') $pub_val = $value;

                // }
                // foreach ($pri_key as $key => $value) { 
                //     if ($coin == $key && $value!='') $piv_val = $value;

                // }

                $all_keys = array($coin => array(
                    "public_key" => $pub_val,
                    "private_key" => $piv_val
                ));

                // Re-test - all gourl public/private keys
                $def_coin = strtolower($def_coin);
                if (!in_array($def_coin, $coins)) $coins[] = $def_coin;
                foreach ($coins as $v) {
                    if (!isset($all_keys[$v]["public_key"]) || !isset($all_keys[$v]["private_key"])) die("Please add your public/private keys for '$v' in \$all_keys variable");
                    elseif (!strpos($all_keys[$v]["public_key"], "PUB"))  die("Invalid public key for '$v' in \$all_keys variable");
                    elseif (!strpos($all_keys[$v]["private_key"], "PRV")) die("Invalid private key for '$v' in \$all_keys variable");
                    elseif (strpos(CRYPTOBOX_PRIVATE_KEYS, $all_keys[$v]["private_key"]) === false)
                        die("Please add your private key for '$v' in variable \$cryptobox_private_keys, file /lib/cryptobox.config.php.");
                }

                // Current selected coin by user
                // $coinName = cryptobox_selcoin($coins, $def_coin);
                $coinName = cryptobox_selcoin($coins, $def_coin);

                // Current Coin public/private keys
                // $public_key  = $all_keys[$coinName]["public_key"];
                // $private_key = $all_keys[$coinName]["private_key"];
                $public_key  = $gateway->public_key;
                $private_key = $gateway->private_key;

                /** PAYMENT BOX **/
                $options = array(
                    "public_key"    => $public_key,
                    "private_key"   => $private_key,
                    "webdev_key"    => 'DEV1124G19CFB313A993D68G453342148',
                    "orderID"       => $orderID,
                    "userID"        => $userID,
                    "userFormat"    => $userFormat,
                    "amount"        => 0,
                    "amountUSD"     => $amountUSD,
                    "period"        => $period,
                    "language"      => $def_language
                );

                // Initialise Payment Class
                $box = new Cryptobox($options);
                $data['box'] = $box;
                $data['options'] = $options;

                // coin name
                $coinName   = $box->coin_name();
                $order      = $box->get_json_values();
                $data['order'] = $order;


                // $data['def_coin'] = "", 
                // $data['def_language'] = "en", 
                // $data['custom_text'] = "", 
                $data['coinImageSize']  = 70;
                $data['qrcodeSize']     = 200;
                $data['show_languages'] = false;
                $data['logoimg_path']   = "default";
                $data['resultimg_path'] = "default";
                $data['resultimgSize']  = 250;
                $data['redirect']       = base_url("payment_callback/bitcoin_confirm/" . @$order['order']);
                $data['method']         = "ajax";
                $data['debug']          = false;

                // Text above payment box
                $data['custom_text']  = "";


                return $data;
            } else {
                return false;
            }
        } else if ($method == 'payeer') {

            /******************************
             * Payeer Payment Gateway API
             ******************************/
            if ($gateway) {

                $paytype = $CI->session->userdata('payment_type');

                $date       = new DateTime();
                $invoice    = $date->getTimestamp();
                $comment    = $invoice;

                $data['m_shop']     = @$gateway->public_key;
                $data['m_orderid']  = @$paytype . '_' . @$sdata->deposit_id . '_' . @$sdata->user_id . '_' . time();
                $data['m_amount']   = number_format((float)@$sdata->deposit_amount + (float)@$sdata->fees, 2, '.', '');
                $data['m_curr']     = 'USD';
                $data['m_desc']     = base64_encode($comment);
                $data['m_key']      = @$gateway->private_key;

                $arHash = array(
                    $data['m_shop'],
                    $data['m_orderid'],
                    $data['m_amount'],
                    $data['m_curr'],
                    $data['m_desc']
                );

                $arHash[] = $data['m_key'];

                $data['sign'] = strtoupper(hash('sha256', implode(':', $arHash)));

                // $CI->session->unset_userdata('m_sign');
                // $CI->session->set_userdata('m_sign', @$data['sign']);

                return $data;
            } else {
                return false;
            }
        } else if ($method == 'paypal') {

            /******************************
             * Paypal Payment Gateway API
             ******************************/
            if ($gateway) {

                require APPPATH . 'libraries/paypal/vendor/autoload.php';

                // After Step 1
                $apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                        @$gateway->public_key,     // ClientID
                        @$gateway->private_key     // ClientSecret
                    )
                );

                // Step 2.1 : Between Step 1 and Step 2
                $apiContext->setConfig(
                    array(
                        'mode' => @$gateway->secret_key,
                        'log.LogEnabled' => true,
                        'log.FileName' => 'PayPal.log',
                        'log.LogLevel' => 'FINE'
                    )
                );

                // After Step 2
                $payer = new \PayPal\Api\Payer();
                $payer->setPaymentMethod('paypal');

                $item1 = new \PayPal\Api\Item();
                $item1->setName('setName');
                $item1->setCurrency('USD');
                $item1->setQuantity(1);
                $item1->setPrice((float)@$sdata->deposit_amount + (float)@$sdata->fees);

                $itemList = new \PayPal\Api\ItemList();
                $itemList->setItems(array($item1));

                $amount = new \PayPal\Api\Amount();
                $amount->setCurrency("USD");
                $amount->setTotal((float)@$sdata->deposit_amount + (float)@$sdata->fees);

                $transaction = new \PayPal\Api\Transaction();
                $transaction->setAmount($amount);
                $transaction->setItemList($itemList);
                $transaction->setDescription('Description');

                $redirectUrls = new \PayPal\Api\RedirectUrls();
                $redirectUrls->setReturnUrl(base_url('payment_callback/paypal_confirm'))->setCancelUrl(base_url('payment_callback/paypal_cancel'));

                $payment = new \PayPal\Api\Payment();
                $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls);


                // After Step 3
                try {
                    $payment->create($apiContext);

                    $data['payment']     =  $payment;
                    $data['approval_url'] =  $payment->getApprovalLink();
                } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                    // This will print the detailed information on the exception.
                    //REALLY HELPFUL FOR DEBUGGING
                    echo $ex->getData();
                    echo $ex->getData();
                }

                return $data;
            } else {
                return false;
            }
        } else if ($method == 'paystack') {

            $url = "https://free.currconv.com/api/v7/convert?q=USD_NGN&compact=ultra&apiKey=$gateway->shop_id";
            if ($gateway->secret_key == 'premium') {
                $url = "https://api.currconv.com/api/v7/convert?q=USD_NGN&compact=ultra&apiKey=$gateway->shop_id";
            }


            $json           = file_get_contents($url);
            $obj            = json_decode($json, true);
            $val            = floatval($obj['USD_NGN']);
            $total          = $val * (float)@$sdata->deposit_amount + (float)@$sdata->fees;
            $deposit_amount = number_format($total, 2, '.', '');
            $deposit_amount = $deposit_amount * 100;

            $user_mail = $CI->db->select('email')->from('user_registration')->where('user_id', $sdata->user_id)->where('status', 1)->get()->row();

            $paystack = array(
                "secret_key"      => @$gateway->private_key,
                "publishable_key" => @$gateway->public_key
            );

            $curl       = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL            => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST  => "POST",
                CURLOPT_POSTFIELDS     => json_encode([
                    'amount' => $deposit_amount,
                    'email' => $user_mail->email,
                ]),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . $paystack['secret_key'],
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                die('Curl returned error: ' . $err);
            }

            $tranx = json_decode($response, true);

            if (!$tranx['status']) {
                print_r('API returned error: ' . $tranx['message']);
            }
            //$this->session->set_userdata("paystack_payment_type","deposit");//use for call back url
            // header('Location: ' . $tranx['data']['authorization_url']);

            return $tranx['data']['authorization_url'];
        } else if ($method == 'coinpayment') {

            /******************************
             * CoinPayments Gateway API
             ******************************/
            if ($gateway) {

                $user_id = $CI->session->userdata('user_id');
                $userinfo = $CI->db->select('*')->from('dbt_user')->where('user_id', $user_id)->get()->row();

                $check = array(
                    'amount1'   => $sdata->deposit_amount + (float)@$sdata->fees,
                    'amount2'   => $sdata->deposit_amount + (float)@$sdata->fees,
                    'ipn_type'  => 'deposit',
                    'currency1' => $sdata->currency_symbol,
                    'currency2' => $sdata->currency_symbol,
                    'user_id'   => $user_id
                );

                $query          = $CI->db->select('*')->from('coinpayments_payments')->where($check)->get();
                $countrow       = $query->num_rows();
                $coinpaydata    = $query->row();

                if ($countrow > 0) {

                    $querytnxid = $CI->db->select('*')->from('coinpayments_payments')->where('txn_id', $coinpaydata->txn_id)->get();

                    $counttnxidrow  = $querytnxid->num_rows();
                    $lastrow        = $querytnxid->last_row();

                    if ($counttnxidrow > 1) {

                        if ($lastrow->status == 0) {

                            return json_decode($coinpaydata->status_text, true);
                        } else {

                            $coinpayment = array(
                                "private_key"   => @$gateway->private_key,
                                "public_key"    => @$gateway->public_key
                            );

                            $public_key     = $coinpayment['public_key'];
                            $private_key    = $coinpayment['private_key'];

                            $req = array(
                                "version"       => 1,
                                "cmd"           => "create_transaction",
                                "amount"        => number_format((float)($sdata->deposit_amount) + (float)(@$sdata->fees), 8, '.', ''),
                                "currency1"     => $sdata->currency_symbol,
                                "currency2"     => $sdata->currency_symbol,
                                "buyer_email"   => @$userinfo->email,
                                "custom"        => $sdata->fees,
                                "ipn_url"       => base_url("payment_callback/conipayment_confirm"),
                                "key"           => $public_key,
                                "format"        => 'json',
                            );

                            $post_data = http_build_query($req, '', '&');

                            $hmac = hash_hmac('sha512', $post_data, $private_key);

                            static $ch = NULL;
                            if ($ch === NULL) {
                                $ch = curl_init('https://www.coinpayments.net/api.php');
                                curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                            }
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: ' . $hmac));
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

                            $data = curl_exec($ch);

                            if ($data !== FALSE) {
                                if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {

                                    $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
                                } else {

                                    $dec = json_decode($data, TRUE);
                                }
                                if ($dec !== NULL && count($dec)) {

                                    if ($dec['error'] == "ok") {

                                        $reg = array(

                                            'currency1'         => $sdata->currency_symbol,
                                            'currency2'         => $sdata->currency_symbol,
                                            'amount1'           => @$dec['result']['amount'],
                                            'amount2'           => @$dec['result']['amount'],
                                            'ipn_type'          => 'deposit',
                                            'status_text'       => json_encode(@$dec),
                                            'txn_id'            => @$dec['result']['txn_id'],
                                            'user_id'           => $user_id

                                        );

                                        $CI->db->insert("coinpayments_payments", $reg);

                                        return $dec;
                                    } else {

                                        $CI->session->set_flashdata("exception", @$dec['error']);
                                        redirect("deposit");
                                    }
                                } else {

                                    return array('error' => 'Unable to parse JSON result (' . json_last_error() . ')');
                                }
                            } else {

                                return array('error' => 'cURL error: ' . curl_error($ch));
                            }
                        }
                    } else {

                        return json_decode($coinpaydata->status_text, true);
                    }
                } else {

                    $coinpayment = array(
                        "private_key"   => @$gateway->private_key,
                        "public_key"    => @$gateway->public_key
                    );

                    $public_key     = $coinpayment['public_key'];
                    $private_key    = $coinpayment['private_key'];

                    $req = array(
                        "version"   => 1,
                        "cmd"       => "create_transaction",
                        "amount"    => number_format((float)($sdata->deposit_amount) + (float)(@$sdata->fees), 8, '.', ''),
                        "currency1" => $sdata->currency_symbol,
                        "currency2" => $sdata->currency_symbol,
                        "buyer_email" => @$userinfo->email,
                        "custom"    => $sdata->fees,
                        "ipn_url"   => base_url("payment_callback/conipayment_confirm"),
                        "key"       => $public_key,
                        "format"    => 'json',
                    );

                    $post_data = http_build_query($req, '', '&');

                    $hmac = hash_hmac('sha512', $post_data, $private_key);

                    static $ch = NULL;
                    if ($ch === NULL) {
                        $ch = curl_init('https://www.coinpayments.net/api.php');
                        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    }
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: ' . $hmac));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

                    $data = curl_exec($ch);

                    if ($data !== FALSE) {
                        if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {

                            $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
                        } else {

                            $dec = json_decode($data, TRUE);
                        }
                        if ($dec !== NULL && count($dec)) {

                            if ($dec['error'] == "ok") {

                                $reg = array(

                                    'currency1'         => $sdata->currency_symbol,
                                    'currency2'         => $sdata->currency_symbol,
                                    'amount1'           => @$dec['result']['amount'],
                                    'amount2'           => @$dec['result']['amount'],
                                    'ipn_type'          => 'deposit',
                                    'status_text'       => json_encode(@$dec),
                                    'txn_id'            => @$dec['result']['txn_id'],
                                    'user_id'           => $user_id

                                );

                                $CI->db->insert("coinpayments_payments", $reg);

                                return $dec;
                            } else {

                                $CI->session->set_flashdata("exception", @$dec['error']);
                                redirect("deposit");
                            }
                        } else {

                            return array('error' => 'Unable to parse JSON result (' . json_last_error() . ')');
                        }
                    } else {

                        return array('error' => 'cURL error: ' . curl_error($ch));
                    }
                }
            } else {

                return false;
            }
        } else if ($method == 'token') {

            /******************************
             * Token Gateway API
             ******************************/
            if ($gateway) {

                $data['approval_url'] = base_url('payment_callback/token_confirm');
                $data['cancel_url'] = base_url('payment_callback/token_cancel');

                return $data;
            } else {

                return false;
            }
        } else if ($method == 'stripe') {

            /******************************
             * Stripe Payment Gateway API
             ******************************/
            if ($gateway) {

                require_once APPPATH . 'libraries/stripe/vendor/autoload.php';
                // Use below for direct download installation

                $stripe = array(
                    "secret_key"      => @$gateway->private_key,
                    "publishable_key" => @$gateway->public_key
                );

                \Stripe\Stripe::setApiKey($stripe['secret_key']);

                $data['description'] = @$gateway->agent;
                $data['stripe']     = $stripe;


                return $data;
            } else {
                return false;
            }
        } else if ($method == 'phone') {

            /******************************
             * Mobile Payment (Manual)
             ******************************/
            if ($gateway) {

                $data['approval_url'] = base_url('payment_callback/phone_confirm');

                return $data;
            } else {

                return false;
            }
        } else if ($method == 'Pin') {
            // RUN PIN CODE 
            $pin = $CI->db->select('*')
                ->from('pin')
                ->where('pin_code', $sdata->pin_code)
                ->get()
                ->row();
            if ($pin and !$pin->is_used) {

                $data['deposit_amount'] = $pin->pin_amount;
                return $data;
            }
            return false;
        } else if ($method == 'bank') {

            /******************************
             * Bank Payment (Manual)
             ******************************/
            if ($gateway) {

                return false;
            }
        }
    }

    public function payment_withdraw($wdata, $method = NULL)
    {
        $CI = &get_instance();
        $gateway = $CI->db->select('*')->from('payment_gateway')->where('identity', $method)->where('status', 1)->get()->row();

        $user_id = $CI->session->userdata('user_id');

        if ($method == "coinpayment") {

            $coinpayment = array(
                "private_key"   => @$gateway->private_key,
                "public_key"    => @$gateway->public_key
            );

            $public_key     = $coinpayment['public_key'];
            $private_key    = $coinpayment['private_key'];

            $req = array(
                "version"       => 1,
                "cmd"           => "create_withdrawal",
                "amount"        => number_format((float)($wdata['amount']), 8, '.', ''),
                "currency"      => $wdata['currency_symbol'],
                "address"       => $wdata['wallet_id'],
                "auto_confirm"  => 1,
                "ipn_url"       => base_url("payment_callback/conipayment_withdraw"),
                "key"           => $public_key
            );

            $post_data = http_build_query($req, '', '&');

            $hmac = hash_hmac('sha512', $post_data, $private_key);

            static $ch = NULL;
            if ($ch === NULL) {
                $ch = curl_init('https://www.coinpayments.net/api.php');
                curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: ' . $hmac));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

            $data = curl_exec($ch);

            if ($data !== FALSE) {
                if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {

                    $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
                } else {

                    $dec = json_decode($data, TRUE);
                }
                if ($dec !== NULL && count($dec)) {

                    if ($dec['error'] == 'ok') {
                        $reg = array(

                            'currency1'         => $wdata['currency_symbol'],
                            'currency2'         => $wdata['currency_symbol'],
                            'amount1'           => @$dec['result']['amount'],
                            'amount2'           => @$dec['result']['amount'],
                            'status_text'       => json_encode(@$dec),
                            'txn_id'            => @$dec['result']['id'],
                            'user_id'           => $user_id
                        );
                        $CI->db->insert("coinpayments_payments", $reg);

                        return $dec;
                    } else {
                        return $dec['error'];
                    }
                } else {

                    return array('error' => 'Unable to parse JSON result (' . json_last_error() . ')');
                }
            } else {

                return array('error' => 'cURL error: ' . curl_error($ch));
            }
        }
    }

    public function payment_confirm()
    {
    }

}
