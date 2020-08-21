<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_gateway extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

		if (!$this->session->userdata('isLogIn') 
			&& !$this->session->userdata('isAdmin')
		) 
		redirect('admin'); 
		
		$this->load->model(array(
			'backend/dashboard/setting_model',
			'common_model'
		));
		
	}

	public function index()
	{
		$data['title'] = "SMS Gateway";
		$data['sms'] = $this->db->select('*')->from('email_sms_gateway')->where('es_id', 1)->get()->row();


		$data['content'] = $this->load->view('backend/dashboard/sms_gateway',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function update_sms_gateway()
	{
		$sms = $this->input->post('es_id');
		
		$pass = '';
		$password = $this->db->select('password')->from('email_sms_gateway')->where('es_id', 2)->get()->row();
		
		if($password->password == base64_decode($this->input->post('password'))){
		   $pass = $password->password;
		   
		}else{
		    $pass = $this->input->post('password');
		    
		}

		$data = array(
			'gatewayname' 	=>$this->input->post('gatewayname'),
			'title' 		=>$this->input->post('title'),
			'host' 			=>$this->input->post('host'),
			'user' 			=>$this->input->post('user'),
			'userid' 		=>$this->input->post('userid'),
			'password' 		=>$pass,
			'api' 			=>$this->input->post('api')
		);

		$this->db->where('es_id',$sms)->update('email_sms_gateway',$data);

		
		$this->session->set_flashdata('message',display('update_successfully'));
		
		
		redirect('backend/setting/sms_gateway');
	}

	public function test_sms()
	{
		$this->form_validation->set_rules('mobile_num','Mobile Number','required|trim');
		$this->form_validation->set_rules('test_message','Test SMS','required');

		if($this->form_validation->run()){

			#----------------------------
            #      SMS Test
            #----------------------------
            $this->load->library('sms_lib');

            $mobile_num 	= $this->input->post('mobile_num');
            $test_message 	= $this->input->post('test_message');

            if ($mobile_num) {
                $smssend = $this->sms_lib->send(array(
                    'to'                => $mobile_num, 
                    'template'          => $test_message,
                    'template_config'	=> ''
                ));

                if (is_string($smssend) && is_array(json_decode($smssend, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {

                	$smsdata = json_decode($smssend,true);

                	if($smsdata['status']){

                		$this->session->set_flashdata('message',$smsdata['message']);
                	}else{

                		$this->session->set_flashdata('exception',$smsdata['message']);
                	}

                }else{

                	$this->session->set_flashdata('message',$smssend);
                }

            }else{

                $this->session->set_flashdata('exception', "There is no Phone number!!!");

            }

		}else{
			$this->session->set_flashdata('exception',validation_errors());
		}

		redirect('backend/setting/sms_gateway');
	}


}