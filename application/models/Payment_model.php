<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model{
    function __construct() {

    }

    //All payment Log Data
    public function bitcoinPaymentLog($data = array()){
       

    }
    public function payeerPaymentLog($data = array()){

       return $this->db->insert('payeer_payments', $data);

    }
    public function paypalPaymentLog($data = array()){

        // return $this->db->insert('paypal_payments', $data);       

    }
    public function stripePaymentLog($data = array()){

        // return $this->db->insert('stripe_payments', $data);

    }
    public function coinpaymentsPaymentLog($data = array()){

        $this->db->insert("coinpayments_payments",$data);

    }

    //All payment Data
    public function paymentStore($data = array()){
       
        return $this->db->insert('deposit', $data);

    }
    //All payment Data
    public function transections($data = array()){
       
        $this->db->insert('transections', $data);
        return  $this->db->insert_id();

    }
    //All payment Data
    public function save_transections($data = array()){
       
        $this->db->insert('deposit', $data);
        return  $this->db->insert_id();

    }

    //Add User Balance
    public function balanceAdd($data = array()){

        $check_user_balance = $this->db->select('*')->from('bdt_liysummary')->where('user_id', $data->user_id)->get()->row();

        if ($check_user_balance) {

            $updatebalance = array(
                'balance'     => @$data->amount+@$check_user_balance->balance,
            );

            $this->db->where('user_id', $data->user_id)->update("bdt_liysummary", $updatebalance);

            return  $check_user_balance->user_id;

        }else{

            $insertbalance = array(
                'user_id'         => $data->user_id,
                'balance'         => $data->amount,
                'last_update'     => date('Y-m-d h:i:s'),
            );
            $this->db->insert('bdt_liysummary', $insertbalance);

            return  $this->db->insert_id();

        }
        

    }


    public function coinpayments_balanceAdd($data = array()){

        $check_user_balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data['user_id'])->where('currency_symbol', $data['currency_symbol'])->get()->row();
        
        if ($check_user_balance) {

            $updatebalance = array(
                'balance'     => $data['amount']+$check_user_balance->balance,
            );

            $this->db->where('user_id', $data['user_id'])->where('currency_symbol', $data['currency_symbol'])->update("dbt_balance", $updatebalance);

            return  $check_user_balance->id;

        }else{

            $insertbalance = array(
                'user_id'         => $data['user_id'],
                'currency_id'     => '',
                'currency_symbol' => $data['currency_symbol'],
                'balance'         => $data['amount'],
                'last_update'     => date('Y-m-d h:i:s'),
            );
            $this->db->insert('dbt_balance', $insertbalance);

            return  $this->db->insert_id();

        }
        

    }

    //Balance Log
    public function balancelog($data = array()){
       
        return $this->db->insert('transections', $data);

    }

    public function checkBalance($key, $user=null)
    {
        if ($user==null) {
            $user = $this->session->userdata('user_id');
        }

        return $this->db->select('*')
            ->from('dbt_balance')
            ->where('user_id', $user)
            ->where('currency_symbol', $key)
            ->get()
            ->row();

    }

    public function confirm_coinpayment_deposit($data = array()){

        $updatedata = array(
            'deposit_date'  =>$data['depositdate'],
            'approved_date' =>$data['depositdate'],
            'status'        =>1
        );

        $wheredata = array(
            'user_id'           =>$data['user_id'],
            'comment'           =>$data['comment'],
            'currency_symbol'   =>$data['currency_symbol']
        );

        $this->db->where($wheredata);
        $this->db->update('dbt_deposit', $updatedata);

    }


}