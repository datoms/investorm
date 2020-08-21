<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
  
        if (!$this->session->userdata('isLogIn')) 
        redirect('login');

        if (!$this->session->userdata('user_id')) 
        redirect('login');  
 
		$this->load->model(array(
            
            'customer/diposit_model',
            'customer/transections_model',
            'common_model',
        ));
        $this->load->library('payment');
	}


/*
|-----------------------------------
|   Add new Deposit form
|-----------------------------------
*/
    public function index(){  

        $data['title']   = display('diposit');

        if ($this->session->userdata('deposit')) {
            $this->session->unset_userdata('deposit');
        }

        $this->form_validation->set_rules('amount', display('amount'),'required|numeric|trim');
        $this->form_validation->set_rules('method', display('payment_method'),'required|alpha_numeric|trim');
        $this->form_validation->set_rules('fees', display('fees'),'required|numeric|trim');

        if($this->input->post('method') == 'Pin'){
            $this->form_validation->set_rules('pin_code', 'Pin','required');
        }

        $date           = new DateTime();
        $deposit_date   = $date->format('Y-m-d H:i:s');      

        if ($this->form_validation->run()) 
        {
           
            if ($this->input->post('method') == 'phone') {
                $mobiledata =  array(
                    'om_name'         => $this->input->post('om_name', TRUE),
                    'om_mobile'       => $this->input->post('om_mobile', TRUE),
                    'transaction_no'  => $this->input->post('transaction_no', TRUE),
                    'idcard_no'       => $this->input->post('idcard_no', TRUE),
                );

                $comment = json_encode($mobiledata);

            }else if ($this->input->post('method')=='payeer') {

                $comment = $this->input->post('comments', TRUE);
                (object)$depositdata = array(
                    'user_id'           => $this->session->userdata('user_id'),
                    'deposit_amount'    => $this->input->post('amount', TRUE),
                    'deposit_method'    => $this->input->post('method', TRUE),
                    'fees'              => $this->input->post('fees', TRUE),
                    'comments'          => $comment,
                    'deposit_date'      => $deposit_date,
                    'deposit_ip'        => $this->input->ip_address(),
                );

                $deposit = $this->diposit_model->save_deposit($depositdata);
                

            }else if ($this->input->post('method')=='bank') {

                

            }else if($this->input->post('method')=='Pin'){
                $pin_code = $this->input->post('pin_code',true);
                
            }else{
                $comment = $this->input->post('comments', TRUE);
                 (object)$depositdata = array(
                    'user_id'           => $this->session->userdata('user_id'),
                    'deposit_amount'    => $this->input->post('amount', TRUE),
                    'deposit_method'    => $this->input->post('method', TRUE),
                    'fees'              => $this->input->post('fees', TRUE),
                    'comments'          => $comment,
                    'deposit_date'      => $deposit_date,
                    'deposit_ip'        => $this->input->ip_address(),
                );
                $deposit = $this->diposit_model->save_deposit($depositdata);

            }
    
            $sdata['deposit']   = (object)$userdata = array(
                'deposit_id'        => @$deposit['deposit_id'],
                'user_id'           => $this->session->userdata('user_id'),
                'deposit_amount'    => $this->input->post('amount', TRUE),
                'deposit_method'    => $this->input->post('method', TRUE),
                'fees'              => $this->input->post('fees', TRUE),
                'comments'          => $comment,
                'deposit_date'      => $deposit_date,
                'deposit_ip'        => $this->input->ip_address(),
                'pin_code'          => $pin_code
            );

            //Store Deposit Session Data
            $this->session->set_userdata($sdata);

            redirect("customer/deposit/payment_process");
        }

        $data['payment_gateway'] = $this->common_model->payment_gateway();


        $data['content'] = $this->load->view('customer/pages/diposit', $data, true);
        $this->load->view('customer/layout/main_wrapper', $data);  

    }


    public function payment_process()
    {
       
        $data['title']  = display('deposit');
       
        if ($this->session->userdata('deposit')) {
            $data['deposit'] = $this->session->userdata('deposit');

            //Payment Type specify for callback (deposit/buy/sell etc )
            $this->session->set_userdata('payment_type', 'deposit');

            $method  = $data['deposit']->deposit_method;
            $data['deposit_data']   = $this->payment->payment_process($data['deposit'], $method);
            if (!$data['deposit_data']) {
                if($data['deposit']->deposit_method == 'Pin')
                {
                $this->session->set_flashdata('exception', "Invalid Pin or pin has been used");

                }
                $this->session->set_flashdata('exception', display('this_gateway_deactivated'));
                redirect('customer/deposit');

            }

        }else{
            $this->session->set_flashdata('exception', "Something went wrong!!!");
            redirect('customer/deposit');

        }
        
    

        $data['content'] = $this->load->view("customer/pages/payment_process", $data, true);
        $this->load->view("customer/layout/main_wrapper", $data);

    }

/*
|-----------------------------------
|   Save Deposit 
|-----------------------------------
*/

    // public function store($diposit_id=NULL)
    // { 
    
    //     $data = $this->db->select('*')->from('deposit')->where('deposit_id',$diposit_id)->get()->row();

    //     $this->db->set('status',1)->where('deposit_id',$diposit_id)->update('deposit');
        
    //     if($data!=NULL){
            
    //         $transections_data = array(
    //         'user_id'                   => $data->user_id,
    //         'transection_category'      => 'deposit',
    //         'releted_id'                => $data->deposit_id,
    //         'amount'                    => $data->deposit_amount,
    //         'comments'                  => $data->comments,
    //         'transection_date_timestamp'=> date('Y-m-d h:i:s')
    //         );
    //         $this->diposit_model->save_transections($transections_data);
            
    //     }

    //     $set = $this->common_model->email_sms('email');
    //     $appSetting = $this->common_model->get_setting();
    //     #-----------------------------------------------------
    //     $balance = $this->transections_model->get_cata_wais_transections();
       

    //     #-----------------------------------------------------
    //     if($set->deposit!=NULL){

    //         #----------------------------
    //         #      email verify smtp
    //         #----------------------------
    //         $post = array(
    //             'title'             => $appSetting->title,
    //             'subject'           => 'Deposit',
    //             'to'                => $this->session->userdata('email'),
    //             'message'           => 'You successfully deposit the amount $'.$data->deposit_amount.'. Your new balance is $'.$balance['balance'],
    //         );
    //         $send_email = $this->common_model->send_email($post);

    //         if($send_email){
    //                 $n = array(
    //                 'user_id'                => $this->session->userdata('user_id'),
    //                 'subject'                => display('diposit'),
    //                 'notification_type'      => 'deposit',
    //                 'details'                => 'You successfully deposit The amount $'.$data->deposit_amount.'. Your new balance is $'.$balance['balance'],
    //                 'date'                   => date('Y-m-d h:i:s'),
    //                 'status'                 => '0'
    //             );
    //             $this->db->insert('notifications',$n);    
    //         }

    //         $this->load->library('sms_lib');
    //         $template = array( 
    //             'name'       => $this->session->userdata('fullname'),
    //             'amount'     => $data->deposit_amount,
    //             'new_balance'=> $balance['balance'],
    //             'date'       => date('d F Y')
    //         );

    //         #------------------------------
    //         #   SMS Sending
    //         #------------------------------
    //         $send_sms = $this->sms_lib->send(array(
    //             'to'              => $this->session->userdata('phone'), 
    //             'header'         => 'Deposit', 
    //             'template'        => 'You successfully deposit the amount $%amount% . Your new balance is $%new_balance%.', 
    //             'template_config' => $template, 
    //         ));

    //         if($send_sms){

    //             $message_data = array(
    //                 'sender_id' =>1,
    //                 'receiver_id' => $this->session->userdata('user_id'),
    //                 'subject' => 'Deposit',
    //                 'message' => 'You successfully deposit the amount $'.$data->deposit_amount.'. Your new balance is $'.$balance['balance'],
    //                 'datetime' => date('Y-m-d h:i:s'),
    //             );

    //             $this->db->insert('message',$message_data);    

    //         }

    //     }


    //     $this->session->set_flashdata('message', display('deopsit_add_msg'));
    //     redirect('customer/deposit');

    // }

/*
|-----------------------------------
|   View deposit list
|-----------------------------------
*/

    public function show()
    {   
        $data['title']   = display('deposit_list');
        #-------------------------------#
        #
        #pagination starts
        #
        $config["base_url"] = base_url('customer/deposit/show');
        $config["total_rows"] = $this->db->get_where('deposit', array('user_id'=>$this->session->userdata('user_id')))->num_rows();
        $config["per_page"] = 25;
        $config["uri_segment"] = 4;
        $config["last_link"] = "Last"; 
        $config["first_link"] = "First"; 
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';  
        $config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['deposit'] = $this->diposit_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #
        //$data['deposit'] = $this->diposit_model->all_deposit();
        $data['content'] = $this->load->view('customer/pages/diposit_list', $data, true);
        $this->load->view('customer/layout/main_wrapper', $data);  
    }

    

}