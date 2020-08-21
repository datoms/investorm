<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_gateway extends CI_Controller {

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
		$data['title'] = "Email Gateway";
		$data['email'] = $this->db->select('*')->from('email_sms_gateway')->where('es_id', 2)->get()->row();


		$data['content'] = $this->load->view('backend/dashboard/email_gateway',$data,true);
		$this->load->view('backend/layout/main_wrapper',$data);
	}

	public function update_email_gateway()
	{
		$email = $this->input->post('es_id');
		
		$pass = '';
		$password = $this->db->select('password')->from('email_sms_gateway')->where('es_id', 2)->get()->row();
		
		if($password->password == base64_decode($this->input->post('email_password'))){
		   $pass = $password->password;
		   
		}else{
		    $pass = $this->input->post('email_password');
		    
		}
		$data = array(
			'title' 	=>$this->input->post('email_title'),
			'protocol' 	=>$this->input->post('email_protocol'),
			'host' 		=>$this->input->post('email_host'),
			'port' 		=>$this->input->post('email_port'),
			'user' 		=>$this->input->post('email_user'),
			'password' 	=>$pass,
			'mailtype' 	=>$this->input->post('email_mailtype'),
			'charset' 	=>$this->input->post('email_charset')
		);
			
		$this->db->where('es_id', $email)->update('email_sms_gateway',$data);
		
		$this->session->set_flashdata('message',display('update_successfully'));

		redirect('backend/setting/email_gateway');
	}

	public function test_email()
	{
		$this->form_validation->set_rules('email_to','Email','required|valid_email');
		$this->form_validation->set_rules('email_sub','Subject','required');
		$this->form_validation->set_rules('email_message','Message','required');

		if($this->form_validation->run()){

			$post = array(
                'title'             => "Test Email Gateway",
                'subject'           => $this->input->post('email_sub'),
                'to'                => $this->input->post('email_to'),
                'message'           => $this->input->post('email_message'),
            );

            //$code_send = $this->common_model->send_email($post);

            if(@$this->common_model->send_email($post)){
            	$this->session->set_flashdata('message','Email Send Successfully!');
            }
            else{
            	$this->session->set_flashdata('exception',"Email not configured in server.");
            }

		}
		else{
			$this->session->set_flashdata('exception',validation_errors());
		}

		redirect('backend/setting/email_gateway/');
	}


}