<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();      

        $this->load->model(array( 

            'common_model',
            'website/web_model',

        ));

        $this->load->library('payment');

        $gData['category']    = $this->web_model->categoryList();
        $gData['social_link'] = $this->web_model->social_link();
        $gData['web_language'] = $this->web_model->webLanguage();
        @$gData['service']     = $this->web_model->article($this->web_model->catidBySlug('service')->cat_id, 8);

        $this->load->vars($gData);

    }

    public function index()
    {

        @$cat_id = $this->web_model->catidBySlug('home');

        //Language setting
        $data['lang']           = $this->langSet();

        $data['title']          = "Home";
        @$data['news']           = $this->db->select("*")->from('web_news')->order_by('article_id', 'desc')->limit(8)->get()->result();
        @$data['client']           = $this->web_model->article($this->web_model->catidBySlug('client')->cat_id);
        @$data['cryptocoins']    = $this->db->select("Id, Url, ImageUrl, Name, Symbol,CoinName,FullName")->from('cryptolist')->order_by('SortOrder', 'asc')->limit(10,0)->get()->result();
        @$data['testimonial']    = $this->web_model->article($this->web_model->catidBySlug('testimonial')->cat_id);
        @$data['about']          = $this->web_model->article($this->web_model->catidBySlug('about')->cat_id);
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['slider']         = $this->web_model->active_slider();

        $this->load->view('website/header', $data);     
        $this->load->view('website/index', $data);
        $this->load->view('website/footer', $data);

    }

    public function page()
    {

        if (!$this->web_model->catidBySlug($this->uri->segment(1))) {
            redirect(base_url());
        }

        //Language setting
        $data['lang']       = $this->langSet();

        $data['title']      = $this->uri->segment(1);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->segment(1));
        $data['article']    = $this->web_model->article($this->web_model->catidBySlug($this->uri->segment(1))->cat_id);

        $this->load->view('website/header', $data);
        $this->load->view('website/page', $data);
        $this->load->view('website/footer', $data);

    } 


    public function home()
    {

        @$cat_id = $this->web_model->catidBySlug('home');

        //Language setting
        $data['lang']           = $this->langSet();

        $data['title']          = $this->uri->segment(1);
        @$data['news']           = $this->db->select("*")->from('web_news')->order_by('article_id', 'desc')->limit(8)->get()->result();
        @$data['client']           = $this->web_model->article($this->web_model->catidBySlug('client')->cat_id);
        @$data['cryptocoins']    = $this->db->select("Id, Url, ImageUrl, Name, Symbol,CoinName,FullName")->from('cryptolist')->order_by('SortOrder', 'asc')->limit(10,0)->get()->result();
        @$data['testimonial']    = $this->web_model->article($this->web_model->catidBySlug('testimonial')->cat_id);
        @$data['about']          = $this->web_model->article($this->web_model->catidBySlug('about')->cat_id);
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['slider']         = $this->web_model->active_slider();

        $this->load->view('website/header', $data);     
        $this->load->view('website/index', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function lending()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']       = $this->langSet();  

        $data['title']      = $this->uri->segment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->segment(1));
        $data['package']    = $this->web_model->package();
        
        $this->load->view('website/header', $data);     
        $this->load->view('website/lending', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function coinmarket()
    {
       
        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']           = $this->langSet();        

        $data['title']          = $this->uri->segment(1);
        $data['advertisement']  = $this->web_model->advertisement($cat_id->cat_id);
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']       = $this->web_model->cat_info($this->uri->segment(1));

        /******************************
        * Pagination Start
        ******************************/
        $config["base_url"]         = base_url('coinmarket/');
        $config["total_rows"]       = $this->db->count_all('cryptolist');
        $config["per_page"]         = 15;
        $config["uri_segment"]      = 2;
        $config["last_link"]        = "Last"; 
        $config["first_link"]       = "First"; 
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';  
        $config['full_tag_open']    = "<ul class='pagination col-xs pull-right'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = "<li>";
        $config['next_tag_close']   = "</li>";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page   = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['cryptocoins']    = $this->web_model->cryptoCoin($config["per_page"], $page);
        $data["links"]          = $this->pagination->create_links();
        /******************************
        * Pagination ends
        ******************************/

        $this->load->view('website/header', $data);     
        $this->load->view('website/coinmarket', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function exchange()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']           = $this->langSet();
        
        $data['title']          = $this->uri->segment(1);
        $data['advertisement']  = $this->web_model->advertisement($cat_id->cat_id);
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']       = $this->web_model->cat_info($this->uri->segment(1));

        $this->load->view('website/header', $data);     
        $this->load->view('website/exchange', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function contact()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']       = $this->langSet();
        
        $data['title']      = $this->uri->segment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->segment(1));

        $this->load->view('website/header', $data);     
        $this->load->view('website/contact', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function buy()
    {

        if ($this->session->userdata('buy')) {
            $this->session->unset_userdata('buy');
        }
        $this->load->model('customer/buy_model');

        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']                   = $this->langSet();

        $data['title']                  = $this->uri->segment(1);
        $data['article']                = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']               = $this->web_model->cat_info($this->uri->segment(1));
        $data['payment_gateway']        = $this->common_model->payment_gateway();
        $data['currency']               = $this->buy_model->findExcCurrency();
        $data['selectedlocalcurrency']  = $this->buy_model->findlocalCurrency();

        //Set Rules From validation
        $this->form_validation->set_rules('cid', display('coin_name'),'required');
        $this->form_validation->set_rules('buy_amount', display('buy_amount'),'required');
        $this->form_validation->set_rules('wallet_id', display('wallet_data'),'required');
        $this->form_validation->set_rules('payment_method', display('payment_method'),'required');
        $this->form_validation->set_rules('usd_amount', display('usd_amount'),'required');
        $this->form_validation->set_rules('rate_coin', display('rate_coin'),'required');
        $this->form_validation->set_rules('local_amount', display('local_amount'),'required');

        if ($this->input->post('payment_method')=='bitcoin' || $this->input->post('payment_method')=='payeer') {
            $this->form_validation->set_rules('comments', display('comments'),'required');

        }
        if ($this->input->post('payment_method')=='phone') {
            $this->form_validation->set_rules('om_name', display('om_name'),'required');
            $this->form_validation->set_rules('om_mobile', display('om_mobile'),'required');
            $this->form_validation->set_rules('transaction_no', display('transaction_no'),'required');
            $this->form_validation->set_rules('idcard_no', display('idcard_no'),'required');

        }
        

        //Validation Check confirm then Redirect to Payment
        if ($this->form_validation->run()) 
        {
            if (!$this->input->valid_ip($this->input->ip_address())){
                $this->session->set_flashdata('exception', display("ip_address")." Invalid");
                redirect("buy");

            }


            $sdata['buy']   = (object)$userdata = array(
                'coin_id'               => $this->input->post('cid'),
                'user_id'               => $this->session->userdata('user_id'),
                'coin_wallet_id'        => $this->input->post('wallet_id'),
                'transection_type'      => "buy",
                'coin_amount'           => $this->input->post('buy_amount'),
                'usd_amount'            => $this->input->post('usd_amount'),
                'local_amount'          => $this->input->post('local_amount'),
                'payment_method'        => $this->input->post('payment_method'),
                'request_ip'            => $this->input->ip_address(),
                'verification_code'     => "",
                'payment_details'       => $this->input->post('comments'),
                'rate_coin'             => $this->input->post('rate_coin'),
                'document_status'       => 0,
                'om_name'               => $this->input->post('om_name'),
                'om_mobile'             => $this->input->post('om_mobile'),
                'transaction_no'        => $this->input->post('transaction_no'),
                'idcard_no'             => $this->input->post('idcard_no'),
                'status'                => 1
            );

            $sdata['deposit']   = (object)$userdata = array(
                'deposit_id'        => '',
                'user_id'           => $this->session->userdata('user_id'),
                'deposit_amount'    => $this->input->post('usd_amount', TRUE),
                'deposit_method'    => $this->input->post('payment_method', TRUE),
                'fees'              => 0
            );

            $this->session->set_userdata($sdata);
            redirect("paymentform");

        }


        $this->load->view('website/header', $data);     
        $this->load->view('website/buy', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function sells()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        $this->load->model('customer/sell_model');

        //Language setting
        $data['lang']                   = $this->langSet();
        
        $data['title']                  = $this->uri->segment(1);
        $data['article']                = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']               = $this->web_model->cat_info($this->uri->segment(1));
        $data['payment_gateway']        = $this->common_model->payment_gateway();
        $data['currency']               = $this->sell_model->findExcCurrency();
        $data['selectedlocalcurrency']  = $this->sell_model->findlocalCurrency();

        //Set Rules From validation
        $this->form_validation->set_rules('cid', display('coin_name'),'required');
        $this->form_validation->set_rules('sell_amount', display('sell_amount'),'required');
        $this->form_validation->set_rules('wallet_id', display('wallet_data'),'required');
        $this->form_validation->set_rules('payment_method', display('payment_method'),'required');
        $this->form_validation->set_rules('usd_amount', display('usd_amount'),'required');
        $this->form_validation->set_rules('rate_coin', display('rate_coin'),'required');
        $this->form_validation->set_rules('local_amount', display('local_amount'),'required');

        if ($this->input->post('payment_method')=='bitcoin' || $this->input->post('payment_method')=='payeer') {
            $this->form_validation->set_rules('comments', display('comments'),'required');

        }
        if ($this->input->post('payment_method')=='phone') {
            $this->form_validation->set_rules('om_name', display('om_name'),'required');
            $this->form_validation->set_rules('om_mobile', display('om_mobile'),'required');
            $this->form_validation->set_rules('transaction_no', display('transaction_no'),'required');
            $this->form_validation->set_rules('idcard_no', display('idcard_no'),'required');

        }        

        //Set Upload File Config 
        $config = [
            'upload_path'       => 'upload/document/',
            'allowed_types'     => 'gif|jpg|png|jpeg|pdf', 
            'overwrite'         => false,
            'maintain_ratio'    => true,
            'encrypt_name'      => true,
            'remove_spaces'     => true,
            'file_ext_tolower'  => true 
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('document')) {  
            $data   = $this->upload->data();  
            $image  = $config['upload_path'].$data['file_name'];

        }

        $data['sell']   = (object)$userdata = array(
            'coin_id'               => $this->input->post('cid'),
            'user_id'               => $this->session->userdata('user_id'),
            'coin_wallet_id'        => $this->input->post('wallet_id'),
            'transection_type'      => "sell",
            'coin_amount'           => $this->input->post('sell_amount'),
            'usd_amount'            => $this->input->post('usd_amount'),
            'local_amount'          => $this->input->post('local_amount'),
            'payment_method'        => $this->input->post('payment_method'),
            'request_ip'            => $this->input->ip_address(),
            'verification_code'     => "",
            'payment_details'       => $this->input->post('comments'),
            'rate_coin'             => $this->input->post('rate_coin'),
            'document_status'       => (!empty($image)?1:0),
            'om_name'               => $this->input->post('om_name'),
            'om_mobile'             => $this->input->post('om_mobile'),
            'transaction_no'        => $this->input->post('transaction_no'),
            'idcard_no'             => $this->input->post('idcard_no'),
            'status'                => 1
        );

        //From Validation Check
        if ($this->form_validation->run()) 
        {
            if (!$this->input->valid_ip($this->input->ip_address())){
                $this->session->set_flashdata('exception', display("ip_address")." Invalid");
                redirect("sells");
            }
            if (empty($this->session->userdata('user_id'))) {
                redirect("register#tab2");
            }

            if ($this->sell_model->create($userdata)) {
                if (!empty($image)) {
                    $data['document'] = (object)$documentdata = array(
                        'ext_exchange_id'   => $this->db->insert_id(),
                        'doc_url'           => (!empty($image)?$image:'')

                    );
                    $this->sell_model->documentcreate($documentdata);

                }
                $this->session->set_flashdata('message', display('sell_successfully'));

            }else {
                $this->session->set_flashdata('exception', display('please_try_again'));

            }

            redirect("sells");

        }


        $this->load->view('website/header', $data);     
        $this->load->view('website/sell', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function price()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']           = $this->langSet();

        $data['title']          = $this->uri->segment(1);
        $data['advertisement']  = $this->web_model->advertisement($cat_id->cat_id);
        @$data['newscat']        = $this->web_model->newsCatListBySlug('news');
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']       = $this->web_model->cat_info($this->uri->segment(1));
        $data['news']           = $this->db->select("*")->from('web_news')->order_by('article_id', 'desc')->limit(6, 3)->get()->result();
        $data['recentnews']     = $this->db->select("*")->from('web_news')->order_by('article_id', 'desc')->limit(3)->get()->result();


        $data['content']        = $this->load->view("website/sidebar", $data, true);

        $this->load->view('website/header', $data);     
        $this->load->view('website/price', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function about()
    {

        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']           = $this->langSet();

        $data['title']          = $this->uri->segment(1);        
        @$data['client']           = $this->web_model->article($this->web_model->catidBySlug('client')->cat_id);
        @$data['team']           = $this->web_model->article($this->web_model->catidBySlug('team')->cat_id);
        @$data['testimonial']    = $this->web_model->article($this->web_model->catidBySlug('testimonial')->cat_id);
        $data['article']        = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']       = $this->web_model->cat_info($this->uri->segment(1));

        $this->load->view('website/header', $data);     
        $this->load->view('website/about', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function service($slug=NULL)
    {   

        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']                   = $this->langSet();

        $data['title']                  = $this->uri->segment(1);

        if ($slug=="" || $slug==NULL) {
            $data['article']            = $this->web_model->article($cat_id->cat_id);
            $data['cat_info']           = $this->web_model->cat_info($this->uri->segment(1)); 

            $this->load->view('website/header', $data);     
            $this->load->view('website/service', $data);
            $this->load->view('website/footer', $data);

        }else{
            $data['cat_info']           = $this->web_model->cat_info($this->uri->segment(1));
            $data['service_details']    = $this->web_model->contentDetails($this->uri->segment(2));

            $this->load->view('website/header', $data);     
            $this->load->view('website/service-details', $data);
            $this->load->view('website/footer', $data);

        }
        
    }

    public function news()
    {

        $slug1 = $this->uri->segment(1);
        $slug2 = $this->uri->segment(2);
        $slug3 = $this->uri->segment(3);

        //Language setting
        $data['lang']               = $this->langSet();

        $data['title']              = $this->uri->segment(1);

        //For Coin Tricker
        $data['cryptocoins']        = $this->web_model->cryptoCoin(10, 0);
        $data['recentnews']         = $this->db->select("*")->from('web_news')->order_by('article_id', 'desc')->limit(3)->get()->result();

        if ($slug2=="" || $slug2==NULL || is_numeric($slug2)) {

            //All Category News with Pagination
            $cat_id     = $this->web_model->catidBySlug($slug1)->cat_id;
            $where_add  = $this->web_model->catidBySlug('news')->cat_id;

            /******************************
            * Pagination Start
            ******************************/
            $config["base_url"]         = base_url('news');
            $config["total_rows"]       = $this->db->count_all('web_news');
            $config["per_page"]         = 6;
            $config["uri_segment"]      = 2;
            $config["last_link"]        = "Last"; 
            $config["first_link"]       = "First"; 
            $config['next_link']        = '&#8702;';
            $config['prev_link']        = '&#8701;';  
            $config['full_tag_open']    = "<ul class='pagination'>";
            $config['full_tag_close']   = "</ul>";
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';
            $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open']    = "<li>";
            $config['next_tag_close']   = "</li>";
            $config['prev_tag_open']    = "<li>";
            $config['prev_tagl_close']  = "</li>";
            $config['first_tag_open']   = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open']    = "<li>";
            $config['last_tagl_close']  = "</li>";
            /* ends of bootstrap */
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['news']           = $this->db->select("*")
                                        ->from('web_news')
                                        ->order_by('article_id', 'desc')
                                        ->limit($config["per_page"], $page)
                                        ->get()
                                        ->result();
            $data["links"]          = $this->pagination->create_links();
            /******************************
            * Pagination ends
            ******************************/

            $data['advertisement']  = $this->web_model->advertisement($where_add);
            $data['newscat']        = $this->web_model->newsCatListBySlug('news');
            $data['cat_info']       = $this->web_model->cat_info($slug1);
            $data['content']        = $this->load->view("website/sidebar", $data, true);


            $this->load->view('website/header', $data);     
            $this->load->view('website/blog', $data);
            $this->load->view('website/footer', $data); 

        }
        elseif (($slug2!="" || !is_numeric($slug2)) && ($slug3=="" || $slug3==NULL)) {

            @$where_add  = $this->web_model->catidBySlug('news')->cat_id;

            //Slug Category News
            $cat_id     = $this->web_model->catidBySlug($slug2)->cat_id;
            /******************************
            * Pagination Start
            ******************************/
            $config["base_url"]         = base_url('news/'.$slug2);
            $config["total_rows"]       = $this->db->get_where('web_news', array('cat_id'=>$cat_id))->num_rows();
            $config["per_page"]         = 6;
            $config["uri_segment"]      = 3;
            $config["last_link"]        = "Last"; 
            $config["first_link"]       = "First"; 
            $config['next_link']        = '&#8702;';
            $config['prev_link']        = '&#8701;';  
            $config['full_tag_open']    = "<ul class='pagination'>";
            $config['full_tag_close']   = "</ul>";
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';
            $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open']    = "<li>";
            $config['next_tag_close']   = "</li>";
            $config['prev_tag_open']    = "<li>";
            $config['prev_tagl_close']  = "</li>";
            $config['first_tag_open']   = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open']    = "<li>";
            $config['last_tagl_close']  = "</li>";
            /* ends of bootstrap */
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['news']               = $this->db->select("*")
                                            ->from('web_news')
                                            ->where('cat_id', $cat_id)
                                            ->order_by('article_id', 'desc')
                                            ->limit($config["per_page"], $page)
                                            ->get()
                                            ->result();
            $data["links"]              = $this->pagination->create_links();
            /******************************
            * Pagination ends
            ******************************/

            $data['advertisement']      = $this->web_model->advertisement($where_add);
            @$data['newscat']            = $this->web_model->newsCatListBySlug('news');
            $data['cat_info']           = $this->web_model->cat_info($slug1);
            $data['content']            = $this->load->view("website/sidebar", $data, true);


            $this->load->view('website/header', $data);     
            $this->load->view('website/blog', $data);
            $this->load->view('website/footer', $data);

        }
        elseif ($slug3=="" || $slug3==NULL || is_numeric($slug3)) {

            @$where_add  = $this->web_model->catidBySlug('news')->cat_id;

            //Slug Category News with Pagination
            $cat_id     = $this->web_model->catidBySlug($slug2)->cat_id;
            /******************************
            * Pagination Start
            ******************************/
            $config["base_url"]         = base_url('news');
            $config["total_rows"]       = $this->db->get_where('web_news', array('cat_id'=>$cat_id))->num_rows();
            $config["per_page"]         = 6;
            $config["uri_segment"]      = 2;
            $config["last_link"]        = "Last"; 
            $config["first_link"]       = "First"; 
            $config['next_link']        = '&#8702;';
            $config['prev_link']        = '&#8701;';  
            $config['full_tag_open']    = "<ul class='pagination'>";
            $config['full_tag_close']   = "</ul>";
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';
            $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open']    = "<li>";
            $config['next_tag_close']   = "</li>";
            $config['prev_tag_open']    = "<li>";
            $config['prev_tagl_close']  = "</li>";
            $config['first_tag_open']   = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open']    = "<li>";
            $config['last_tagl_close']  = "</li>";
            /* ends of bootstrap */
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['news']           = $this->db->select("*")
                                        ->from('web_news')
                                        ->where('cat_id', $cat_id)
                                        ->order_by('article_id', 'desc')
                                        ->limit($config["per_page"], $page)
                                        ->get()
                                        ->result();
            $data["links"]          = $this->pagination->create_links();
            /******************************
            * Pagination ends
            ******************************/
            
            $data['advertisement']  = $this->web_model->advertisement($where_add);
            @$data['newscat']        = $this->web_model->newsCatListBySlug('news');
            $data['cat_info']       = $this->web_model->cat_info($slug1);
            $data['content']        = $this->load->view("website/sidebar", $data, true);


            $this->load->view('website/header', $data);     
            $this->load->view('website/blog', $data);
            $this->load->view('website/footer', $data);

        }
        elseif ($slug3!="" || !is_numeric($slug3)) {
            //Slug Category News detail

            $where_add = $this->web_model->catidBySlug('news-details')->cat_id;
            $data['advertisement']  = $this->web_model->advertisement($where_add);

            @$data['newscat']        = $this->web_model->newsCatListBySlug('news');
            $data['article']        = $this->web_model->article($slug1);
            $data['cat_info']       = $this->web_model->cat_info($slug1);
            $data['news']           = $this->web_model->newsDetails($slug3);
            $data['content']        = $this->load->view("website/sidebar", $data, true);


            $this->load->view('website/header', $data);     
            $this->load->view('website/blog-details', $data);
            $this->load->view('website/footer', $data);
            
        }
        
    }
    
    public function faq()
    {
        
        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']       = $this->langSet();

        $data['title']      = $this->uri->segment(1);        
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->segment(1));

        $this->load->view('website/header', $data);     
        $this->load->view('website/faq', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function register()
    {

        if ($this->session->userdata('isLogIn'))
            redirect(base_url());


        $cat_id = $this->web_model->catidBySlug($this->uri->segment(1));

        //Language setting
        $data['lang']       = $this->langSet();

        $data['title']      = $this->uri->segment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->segment(1));

        //Load Helper For [user_id] Generate
        $this->load->helper('string');

        //Set Rules From validation
        $this->form_validation->set_rules('f_name', display('firstname'),'required|max_length[50]');
        $this->form_validation->set_rules('l_name', display('lastname'),'required|max_length[50]');
        $this->form_validation->set_rules('username', display('username'),'required|max_length[50]');
        $this->form_validation->set_rules('email', display('email'),"required|valid_email|max_length[100]");
        $this->form_validation->set_rules('pass', display('password'),'required|min_length[8]|max_length[32]|matches[r_pass]');
        $this->form_validation->set_rules('r_pass', display('password'),'trim');
        $this->form_validation->set_rules('phone', display('mobile'),'max_length[100]');
        $this->form_validation->set_rules('accept_terms', display('accept_terms_privacy'),'required');

        //From Validation Check
        if ($this->form_validation->run() === true) {

            $sponsor_user_id = $this->db->select('user_id')->where('user_id', $this->input->cookie('sponsor_id'))->get('user_registration')->row();
         
            if (!$sponsor_user_id){
                $this->session->set_flashdata('exception', "Valid Sponsor ID Required");
                redirect("register");
                return false;
            }
        
            $dlanguage = $this->db->select('language')->get('setting')->row();
            $data = array();
            $data = [
                'username'  => $this->input->post('username'),                
                'email'     => $this->input->post('email')
            ];
            
            $usercheck=$this->web_model->checkUser($data);
            if ($usercheck->num_rows() > 0) {
                if ($usercheck->row()->oauth_provider=='facebook' && $usercheck->row()->status==0 || $usercheck->row()->oauth_provider=='google' && $usercheck->row()->status==0) {

                    $checkDuplictuser = $this->web_model->checkDuplictuser($data);    
                    if ($checkDuplictuser->num_rows() > 0){
                        $this->session->set_flashdata('exception', display('username_used'));
                        redirect("register");
                    }
    
                    $data = [
                        'f_name'        => $this->input->post('f_name'),
                        'l_name'        => $this->input->post('l_name'), 
                        'sponsor_id'    => $this->input->cookie('sponsor_id')!=""?$this->input->cookie('sponsor_id'):'',
                        'language'      => $dlanguage->language,
                        'username'      => $this->input->post('username'),
                        'email'         => $this->input->post('email'),
                        'phone'         => $this->input->post('phone'),
                        'password'      => MD5($this->input->post('pass')),
                        'status'        => 1,
                        'reg_ip'        => $this->input->ip_address()
                    ];
                    $this->web_model->updateUser($data);
                    $this->session->set_flashdata('message', display('account_create_success_social'));
                    redirect('register#tab2');

                }else {
                    $this->session->set_flashdata('exception', display('email_used')." ".display('username_used'));
                    redirect("register");

                }

            }else{
                $userid = strtoupper(random_string('alnum', 6));

                if (!$this->input->valid_ip($this->input->ip_address())){
                    $this->session->set_flashdata('exception',  "Invalid IP address");
                    redirect("register");

                }
                $data = [
                    'f_name'        => $this->input->post('f_name'),
                    'l_name'        => $this->input->post('l_name'), 
                    'sponsor_id'    => $this->input->cookie('sponsor_id')!=""?$this->input->cookie('sponsor_id'):'', 
                    'language'      => $dlanguage->language,
                    'user_id'       => $userid, 
                    'username'      => $this->input->post('username'),
                    'email'         => $this->input->post('email'),
                    'phone'         => $this->input->post('phone'),
                    'oauth_provider'=> 'website',
                    'password'      => MD5($this->input->post('pass')),
                    'status'        => 0,
                    'reg_ip'        => $this->input->ip_address()
                ];
                $duplicatemail = $this->web_model->checkDuplictemail($data);          
                if ($duplicatemail->num_rows() > 0){
                    $this->session->set_flashdata('exception', display('email_used'));
                    redirect("register");

                }           
                $checkDuplictuser = $this->web_model->checkDuplictuser($data);    
                if ($checkDuplictuser->num_rows() > 0){
                    $this->session->set_flashdata('exception', display('username_used'));
                    redirect("register");

                }
                if($this->web_model->registerUser($data)){
                    $appSetting = $this->common_model->get_setting();

                    $data['title']      = $appSetting->title;
                    $data['to']         = $this->input->post('email');
                    $data['subject']    = 'Account Activation';
                    $data['message']    = "<br><b>Your account was created successfully, Please click on the link below to activate your account. </b><br> <a target='_blank' href='".base_url('home/activeAcc/').strtolower($userid).md5($userid)."'>".base_url('home/activeAcc/').strtolower($userid).md5($userid)."</a>";
                    $this->common_model->send_email($data);

                    $this->session->set_flashdata('message', display('account_create_active_link'));
                    redirect("register#tab2");

                }
                else{
                    $this->session->set_flashdata('exception',  display('please_try_again'));
                    redirect("register");
                }

            }

        }

        $this->load->view('website/header', $data);     
        $this->load->view('website/register', $data);
        $this->load->view('website/footer', $data);
        
    }

    public function login()
    {

        if ($this->session->userdata('isLogIn'))
            redirect(base_url());

        @$cat_id = $this->web_model->catidBySlug('register');
        
        $data['title']      = $this->uri->segment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info($this->uri->segment(1));

        //Set Rules From validation
        $this->form_validation->set_rules('email', display('email'), 'required|max_length[100]|trim');
        $this->form_validation->set_rules('password', display('password'), 'required|max_length[32]|md5|trim');

        $data['user'] = (object)$userData = array(
            'email'      => $this->input->post('email'),
            'password'   => $this->input->post('password'),
        );
        
        //From Validation Check
        if ($this->form_validation->run())
        {            
            $user = $this->web_model->checkUser($userData);
            if($user->num_rows() > 0) {

                if($user->row()->password==md5($userData['password']) && $user->row()->status==1) 
                {
                    $sData = array(
                        'isLogIn'     => true,
                        'id'          => $user->row()->uid,
                        'user_id'     => $user->row()->user_id,
                        'fullname'    => $user->row()->f_name.' '.$user->row()->l_name,
                        'email'       => $user->row()->email,
                        'sponsor_id'  => $user->row()->sponsor_id,
                        'phone'       => $user->row()->phone,
                    );
                    //Store date to session & Login
                    $this->session->set_userdata($sData);
                    redirect(base_url());

                }
                else{
                    if($user->row()->status==0){
                        $this->session->set_flashdata('exception', display('account_active_mail'));
                        redirect(base_url('login#tab2'));

                    }
                    else{
                        $this->session->set_flashdata('exception', display('incorrect_email_password'));
                        redirect(base_url('login#tab2'));

                    }

                }

            }
            else{
                $this->session->set_flashdata('exception', display('incorrect_email_password'));
                redirect(base_url('login#tab2'));

            }

        }

        $this->load->view('website/header', $data);     
        $this->load->view('website/register', $data);
        $this->load->view('website/footer', $data);

    }

    //Ajax Subscription Action
    public function subscribe()
    {
        $data = array();
        $data['email'] =  $this->input->post('subscribe_email');

        if($this->web_model->subscribe($data)){
            $this->session->set_flashdata('message', display('save_successfully'));

        }
        else{
            $this->session->set_flashdata('exception',  display('please_try_again'));

        }
    }

    //Ajax Contact Message Action
    public function contactMsg()
    {
        $appSetting = $this->common_model->get_setting();
        
        $data['fromName']       = $this->input->post('f_name')." ".$this->input->post('l_name');
        $data['from']           = $this->input->post('email');
        $data['to']             = $appSetting->email;
        $data['subject']        = 'Leave us a message';
        $data['title']          = $this->input->post('email');
        $data['message']    = "<b>Phone: </b>".$this->input->post('phone')."<br><b>Company: </b>".$this->input->post('company')."<br><b>Message: </b>".$this->input->post('comment');
        
        $this->common_model->send_email($data);

    }

    public function activeAcc($activecode='')
    {
        if($activecode){
            $activecode = strtoupper(substr($activecode, 0, 6));

        }
        $user = $this->web_model->activeAccountSelect($activecode);

        if ($user->num_rows() > 0){
            $this->web_model->activeAccount($activecode);
            $this->session->set_flashdata('message', display('active_account'));
            redirect("register#tab2");

        }       
        else {
            $this->session->set_flashdata('exception', display('wrong_try_activation'));
            redirect("register#tab2");

        }

    }

    public function paymentform(){

        if (empty($this->session->userdata('user_id'))) {
            redirect("register#tab2");

        }

        $this->load->model('customer/buy_model');

        @$cat_id = $this->web_model->catidBySlug('buy');

        //Language setting
        $data['lang']       = $this->langSet();

        //Session Data from Buy FORM
        $data['sbuypayment']= $this->session->userdata('buy'); 

        $data['title']      = $this->uri->segment(1);
        $data['article']    = $this->web_model->article($cat_id->cat_id);
        $data['cat_info']   = $this->web_model->cat_info('buy');


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

        $this->load->view('website/header', $data);     
        $this->load->view('website/paymentform', $data);
        $this->load->view('website/footer', $data);

    }


    //Ajax calculation Buy Form
    public function buyPayable()
    {

        $cid    = $this->input->post('cid');
        $amount = $this->input->post('amount');

        $this->load->model('customer/buy_model');

        $data['selectedcryptocurrency'] = $this->buy_model->findCurrency($cid);
        $data['selectedexccurrency']    = $this->buy_model->findExchangeCurrency($cid);
        $data['selectedlocalcurrency']  = $this->buy_model->findlocalCurrency();
        if (!empty($amount)) {
            $data['price_usd']      = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->buy_adjustment)+$data['selectedcryptocurrency']->price_usd;
            $payableusd             = $data['price_usd']*$amount;
            $data['payableusd']     = $payableusd;
            $data['payablelocal']   = $payableusd*$data['selectedlocalcurrency']->usd_exchange_rate;
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

        $this->load->view("website/ajaxbuy", $data);

    }

    //Ajax calculation Sells Form
    public function sellPayable()
    {

        $cid    = $this->input->post('cid');
        $amount = $this->input->post('amount');

        $this->load->model('customer/sell_model');

        $data['selectedcryptocurrency'] = $this->sell_model->findCurrency($cid);
        $data['selectedexccurrency']    = $this->sell_model->findExchangeCurrency($cid);
        $data['selectedlocalcurrency']  = $this->sell_model->findlocalCurrency();
        if (!empty($amount)) {
            $data['price_usd']          = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->sell_adjustment)+$data['selectedcryptocurrency']->price_usd;
            $payableusd                 = $data['price_usd']*$amount;
            $data['payableusd']         = $payableusd;
            $data['payablelocal']       = $payableusd*$data['selectedlocalcurrency']->usd_exchange_rate;
        }
        else{
            $data['payableusd']         = 0;
            $data['payablelocal']       = 0;
            if (empty($cid)) {
                $data['price_usd']      = 0;
            }else{
                $data['price_usd']      = $this->getPercentOfNumber($data['selectedcryptocurrency']->price_usd, $data['selectedexccurrency']->sell_adjustment)+$data['selectedcryptocurrency']->price_usd;
            }
        }

        $this->load->view("website/ajaxsell", $data);

    }

    public function forgotPassword()
    {

        //Set Rules From validation
        $this->form_validation->set_rules('email', display('email'),'required');

        //From Validation Check
        if ($this->form_validation->run()) {
            $userdata = array(
                'email'       => $this->input->post('email'),
            );

            $varify_code = $this->randomID();

            /******************************
            *  Email Verify
            ******************************/
            $appSetting = $this->common_model->get_setting();

            $post = array(
                'title'             => $appSetting->title,
                'subject'           => 'Password Reset Verification!',
                'to'                => $this->input->post('email'),
                'message'           => 'The Verification Code is <h1>'.$varify_code.'</h1>'
            );

            //Send Mail Password Reset Verification
            $send = $this->common_model->send_email($post);
            
            if(isset($send)){

                $varify_data = array(

                    'ip_address'    => $this->input->ip_address(),
                    'user_id'       => $this->session->userdata('user_id'),
                    'session_id'    => $this->session->userdata('isLogIn'),
                    'verify_code'   => $varify_code,
                    'data'          => json_encode($userdata)
                );

                $this->db->insert('verify_tbl',$varify_data);
                $id = $this->db->insert_id();

                $this->session->set_flashdata('message', "Password reset code sent.Check your email.");
                redirect("resetPassword");

            }
        }else{
            $this->session->set_flashdata('exception',display('email')." Required");
            redirect('register#tab2');

        }

    }

    public function resetPassword()
    {

        @$cat_id = $this->web_model->catidBySlug('forgot-password');     

        $data['title'] = $this->uri->segment(1);   
        $data['article']  = $this->web_model->article($cat_id->cat_id);
        $data['cat_info'] = $this->web_model->cat_info('forgot-password');

        $code = $this->input->post('verificationcode');
        $newpassword = $this->input->post('newpassword');
        
        $chkdata = $this->db->select('*')
        ->from('verify_tbl')
        ->where('verify_code',$code)
        ->where('status', 1)
        ->get()
        ->row();

        //Set Rules From validation
        $this->form_validation->set_rules('verificationcode', display('enter_verify_code'),'required');
        $this->form_validation->set_rules('newpassword', display('password'),'required|trim|min_length[8]|max_length[32]|matches[r_pass]');
        $this->form_validation->set_rules('r_pass', display('password'),'trim');

        //From Validation Check
        if ($this->form_validation->run()) {
            if($chkdata!=NULL) {
                $p_data = ((array) json_decode($chkdata->data));
                $password   = array('password' => md5($newpassword));
                $status     = array('status'   => 0);

                $this->db->where('verify_code',$code)
                ->update('verify_tbl', $status);

                $this->db->where('email',$p_data['email'])
                ->update('user_registration', $password);

                $this->session->set_flashdata('message',display('update_successfully'));
                redirect('register#tab2');

            }else{
                $this->session->set_flashdata('exception',display('wrong_try_activation'));
                redirect('resetPassword');
            }

        }else{
            $this->load->view('website/header', $data);     
            $this->load->view('website/passwordreset', $data);
            $this->load->view('website/footer', $data);
        }

    }

    
    //Ajax Language Change
    public function langChange()
    {
        $newdata = array(
            'lang'  => $this->input->post('lang')
        );        

        $user_id = $this->session->userdata('user_id');
        if ($user_id!="") {
            $data['language'] = $this->input->post('lang');
            $this->db->where('user_id', $user_id);
            $this->db->update('user_registration', $data);

        }
        else {
            $this->session->set_userdata($newdata);

        }
        
    }


    /******************************
    * Language Set For User
    ******************************/
    public function langSet(){

        $lang = "";
        $user_id = $this->session->userdata('user_id');
        if ($user_id!="") {
            $ulang = $this->db->select('language')->where('user_id', $user_id)->get('user_registration')->row();
            if ($ulang->language!='english') {
                $lang ='french';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set_userdata($newdata);

            }
            else{
                $lang ='english';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set_userdata($newdata);
            }

        }
        else{
            $alang = $this->db->select('language')->get('setting')->row();
            if ($alang->language=='french') {
                $lang ='french';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set_userdata($newdata);

            }else{
                if ($this->session->lang=='french') {
                    $lang ='french';

                }
                else{
                    $lang ='english';
                }

            }

        }

        return $lang;
        
    }


    //Ajax Sparkline Graph data JSON Formate
    public function coingraphdata($data1=0)
    {
        $per_page=15;

        $data['cryptocoins']  = $this->db->select("Symbol")->from('cryptolist')->order_by('SortOrder', 'asc')->limit($per_page, $data1)->get()->result();

        foreach ($data['cryptocoins'] as $key => $value) {            

            $test1      = file_get_contents('https://min-api.cryptocompare.com/data/histoday?fsym='.$value->Symbol.'&tsym=USD&limit=12');
            $history1   = json_decode($test1, true);

            $data24h[$value->Symbol]="";
            foreach ($history1['Data'] as $h_key => $h_value) { 

                $data24h[$value->Symbol] .= $h_value['low'].",".$h_value['high'].",";

            }
            $data24h[$value->Symbol] = rtrim($data24h[$value->Symbol], ',');    

        }

        echo json_encode($data24h);
        
    }


    //Ajax Currency Price Tricker data JSON Formate
    public function cointrickerdata()
    {

        $data['cryptocoins']  = $this->db->select("Symbol")->from('cryptolist')->order_by('SortOrder', 'asc')->limit(10, 0)->get()->result();

        foreach ($data['cryptocoins'] as $key => $value) {            

            $test1 = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym='.$value->Symbol.'&tsyms=USD');
            $history1 = json_decode($test1, true);

            $datatricker[$value->Symbol]="";
            foreach ($history1 as $tri_key => $tri_value) { 

                $datatricker[$value->Symbol] .= $tri_value.",";

            }
            $datatricker[$value->Symbol] = rtrim($datatricker[$value->Symbol], ',');    

        }
        echo json_encode($datatricker);
        
    }


    /******************************
    * Converter Percent of Number
    ******************************/
    public function getPercentOfNumber($number, $percent){
        return ($percent / 100) * $number;
    }


    /******************************
    * Rand ID Generator
    ******************************/
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];

        }
        return $result;

    }


}