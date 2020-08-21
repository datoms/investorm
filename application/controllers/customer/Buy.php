<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();

 		if (!$this->session->userdata('isLogIn')) 
        redirect('login');

        if (!$this->session->userdata('user_id')) 
        redirect('login'); 
    
 		$this->load->model(array(

 			'customer/buy_model',
 			'customer/diposit_model',
 			'customer/profile_model',
            'common_model',  
 		));

 		$this->load->library('payment');
 		
 	}
 
	public function index()
	{
		$data['currency'] = $this->buy_model->findExcCurrency();
		
		$data['title']  = display('buy_list');
 		#-------------------------------#
        #
        #pagination starts
        #
        $config["base_url"] = base_url('customer/buy/index');
        $config["total_rows"] = $this->db->count_all('ext_exchange');
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
        $data['buy'] = $this->buy_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #    
		$data['content'] = $this->load->view("customer/buy/list", $data, true);
		$this->load->view("customer/layout/main_wrapper", $data);
	}
 
	public function form()
	{ 
		$data['title']  = display('buy');

		if ($this->session->userdata('buy')) {
			$this->session->unset_userdata('buy');
		}

		$data['payment_gateway'] 		= $this->common_model->payment_gateway();
		$data['currency'] 				= $this->buy_model->findExcCurrency();
		$data['selectedlocalcurrency'] 	= $this->buy_model->findlocalCurrency();
		#------------------------#

		$this->form_validation->set_rules('cid', display('coin_name'), 'required');
		$this->form_validation->set_rules('buy_amount', display('buy_amount'), 'required');
		$this->form_validation->set_rules('wallet_id', display('wallet_data'), 'required');
		$this->form_validation->set_rules('payment_method', display('payment_method'), 'required');
		$this->form_validation->set_rules('usd_amount', display('usd_amount'), 'required');
		$this->form_validation->set_rules('rate_coin', display('rate_coin'), 'required');
		$this->form_validation->set_rules('local_amount', display('local_amount'), 'required');

        if ($this->input->post('payment_method')=='bitcoin' || $this->input->post('payment_method')=='payeer') {
            $this->form_validation->set_rules('comments', display('comments'), 'required');
        }
        if ($this->input->post('payment_method')=='phone') {
			$this->form_validation->set_rules('om_name', display('om_name'), 'required');
			$this->form_validation->set_rules('om_mobile', display('om_mobile'), 'required');
			$this->form_validation->set_rules('transaction_no', display('transaction_no'), 'required');
			$this->form_validation->set_rules('idcard_no', display('idcard_no'), 'required');
		}

		if (!$this->input->valid_ip($this->input->ip_address())){
            return false;
        }

		if ($this->form_validation->run()){


			$sdata['buy']   = (object)$userdata = array(
				'coin_id'      			=> $this->input->post('cid', TRUE),
				'user_id'      			=> $this->session->userdata('user_id'),
				'coin_wallet_id'      	=> $this->input->post('wallet_id', TRUE),
				'transection_type'      => "buy",
				'coin_amount'      		=> $this->input->post('buy_amount', TRUE),
				'usd_amount'      		=> $this->input->post('usd_amount', TRUE),
				'local_amount'      	=> $this->input->post('local_amount', TRUE),
				'payment_method'      	=> $this->input->post('payment_method', TRUE),
				'request_ip'      		=> $this->input->ip_address(),
				'verification_code'     => "",
				'payment_details'      	=> $this->input->post('comments', TRUE),
				'rate_coin'      		=> $this->input->post('rate_coin', TRUE),
				'document_status'      	=> 0,
				'om_name'				=> $this->input->post('om_name', TRUE),
				'om_mobile'				=> $this->input->post('om_mobile', TRUE),
				'transaction_no'		=> $this->input->post('transaction_no', TRUE),
				'idcard_no'				=> $this->input->post('idcard_no', TRUE),
				'status'      			=> 1
			);

			//$ext_exchange_id = $this->buy_model->create($userdata);

			$sdata['deposit']   = (object)$userdata = array(
	            'deposit_id'   		=> '',
	            'user_id'           => $this->session->userdata('user_id'),
	            'deposit_amount'    => $this->input->post('usd_amount', TRUE),
	            'deposit_method'    => $this->input->post('payment_method', TRUE),
	            'fees'              => 0
	        );


			$this->session->set_userdata($sdata);
			redirect("customer/buy/paymentform");

		}

		$data['content'] = $this->load->view("customer/buy/form", $data, true);
		$this->load->view("customer/layout/main_wrapper", $data);

	}


	public function paymentform(){

		$data['title']  = display('buy');


		$data['sbuypayment']=$this->session->userdata('buy');

		if (!$this->session->userdata('buy')) {
			redirect("customer/buy/form");
		}


		if ($this->session->userdata('buy')) {
            $data['deposit'] = $this->session->userdata('deposit');

            //Payment Type specify for callback (deposit/buy/sell etc )
            $this->session->set_userdata('payment_type', 'buy');

            $method  = $data['deposit']->deposit_method;
            $data['deposit_data']   = $this->payment->payment_process($data['deposit'], $method);
            if (!$data['deposit_data']) {
                $this->session->set_flashdata('exception', display('this_gateway_deactivated'));
                redirect('customer/buy/form');

            }

        }else{
            $this->session->set_flashdata('exception', "Something went wrong!!!");
            redirect('customer/buy/form');

        }


		$data['content'] = $this->load->view("customer/pages/payment_process", $data, true);
		$this->load->view("customer/layout/main_wrapper", $data);

	}

	public function buyPayable()
	{  
		$cid 	= $this->input->post('cid');
		$amount = $this->input->post('amount');

		$data['selectedcryptocurrency'] = $this->buy_model->findCurrency($cid);
		$data['selectedexccurrency'] 	= $this->buy_model->findExchangeCurrency($cid);
		$data['selectedlocalcurrency'] 	= $this->buy_model->findlocalCurrency();
		if (!empty($amount)) {
			$data['price_usd'] 		= $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->buy_adjustment)+$data['selectedcryptocurrency']->price_usd;
			$payableusd 			= $data['price_usd']*$amount;
			$data['payableusd'] 	= $payableusd;
			$data['payablelocal'] 	= $payableusd*$data['selectedlocalcurrency']->usd_exchange_rate;
		}
		else{
			$data['payableusd']     = 0;
            $data['payablelocal']   = 0;
            if (empty($cid)) {
                $data['price_usd']  = 0;
            }else{
                $data['price_usd']      = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->buy_adjustment)+$data['selectedcryptocurrency']->price_usd;

            }

		}

		$this->load->view("customer/buy/ajaxpayable", $data);

	}

	public function getPercentOfNumber($number, $percent){
    	return ($percent / 100) * $number;

	} 

}