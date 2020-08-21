<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'backend/pin/pin_model'
        ));

        if (!$this->session->userdata('isAdmin'))
            redirect('logout');

        if (
            !$this->session->userdata('isLogin')
            && !$this->session->userdata('isAdmin')
        )
            redirect('admin');
    }

    public function index()
    {
        $data['title']  = "Pin List";
        #-------------------------------#
        #
        #pagination starts
        #
        $config["base_url"] = base_url('backend/pin/pin/index');
        $config["total_rows"] = $this->db->count_all('pin');
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
        $data['pin'] = $this->pin_model->read($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #    
        $data['content'] = $this->load->view("backend/pin/list", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);
    }

    public function form()
    {
        $data['title']  = "Generate Pin";
        /*-----------------------------------*/

        $this->form_validation->set_rules('pin_code', display('pin_code'), 'required|is_unique[pin.pin_code]|max_length[250]');

        #------------------------#
        $this->form_validation->set_rules('pin_code', "Pin Code", 'reqired');
        $this->form_validation->set_rules('pin_amount', "Pin Amount", 'required|max_length[11]');
       
        /*-----------------------------------*/
        $data['pin'] = (object)$userdata = array(
            'pin_prefix'    => $this->input->post('pin_prefix'),
            'pin_amount'            => $this->input->post('pin_amount'),
        );

        /*-----------------------------------*/
        if ($this->form_validation->run()) {
            $userdata['pin_code'] = $this->generatePinCode($userdata['pin_prefix']);
            unset ($userdata['pin_prefix']);
            if ($this->pin_model->create($userdata)) {
                $this->session->set_flashdata('message', display('save_successfully')." Pin is $userdata[pin_code]");
            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
            redirect("backend/pin/pin/form/");
        } else {
            $data['content'] = $this->load->view("backend/pin/form", $data, true);
            $this->load->view("backend/layout/main_wrapper", $data);
        }

    }

    private function generatePinCode($prefix)
    {
        $pin = '';
        for($i=1; $i <= 4; $i++){
            $pin .='-'. random_int(1000,9999);
        }

        return strtoupper($prefix.$pin);
    }
}
