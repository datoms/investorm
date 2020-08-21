<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class External_api_setup extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
 		if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

		if (!$this->session->userdata('isLogin') 
			&& !$this->session->userdata('isAdmin'))
			redirect('admin');

 		
 		
 	}
 
	public function api_list()
	{
		$data['title']  = display('payment_gateway');
 		#-------------------------------#
        #
        #pagination starts
        #
        $config["base_url"] = base_url('backend/external_api_setup/external_api_setup/api_list');
        $config["total_rows"] = $this->db->count_all('external_api_setup');
        $config["per_page"] = 25;
        $config["uri_segment"] = 5;
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
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data['apis'] = $this->db->select("*")
			->from('external_api_setup')
			->order_by('id', 'asc')
			->limit($config["per_page"], $page)
			->get()
			->result();
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #    
		$data['content'] = $this->load->view("backend/external_api/list", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}
 
	public function form($id = null)
	{ 
		$data['title']  = display('add_payment_gateway');

		#------------------------#		
		$this->form_validation->set_rules('name', display('name'),'required|max_length[50]');
		$this->form_validation->set_rules('api_key', 'API Key','required|max_length[100]');
		
		/*-----------------------------------*/ 
		$data['apis']   = (object)$userdata = array(
			'id'      		=> $this->input->post('id'),
			'name'   		=> $this->input->post('name'),
			'data' 			=> json_encode(array( 'api_key'=> $this->input->post('api_key'))),
			'status' 		=> $this->input->post('status')
		);

		/*-----------------------------------*/
		if ($this->form_validation->run()) 
		{
			$dataupdate = $this->db->where('id', $id)->update("external_api_setup", $userdata);

			if ($dataupdate) {
				$this->session->set_flashdata('message', display('update_successfully'));
			} else {
				$this->session->set_flashdata('exception', display('please_try_again'));
			}
			redirect("backend/external_api/external_api_setup/form/$id");
		} 
		else
		{
			if(!empty($id)) {
				$data['title'] = 'Edit API';
				$data['apis']   = $this->db->select('*')->from('external_api_setup')->where('id', $id)->get()->row();
			}			
		}

		$data['content'] = $this->load->view("backend/external_api/form", $data, true);
		$this->load->view("backend/layout/main_wrapper", $data);
	}


}
