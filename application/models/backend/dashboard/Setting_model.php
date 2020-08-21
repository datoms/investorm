<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {
 
	private $table = "setting";

	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->get()
			->row();
	} 
	
  	public function update($data = [])
	{
		return $this->db->where('setting_id',$data['setting_id'])
			->update($this->table,$data); 
	} 

	//new add 
	public function getMenuSingelRoleInfo($id="")
	{
		$role_id = $this->session->userdata('role_id');

		if($role_id!=0){

			return $this->db->select('*')
				->from('dbt_role_permission')
				->where('role_id',$role_id)
				->where('sub_menu_id',$id)
				->get()
				->row();
		}
		else{
			return "";
		}
	}

	//Send email via SMTP server in CodeIgniter
	public function send_email($post=array()){

		$email = $this->db->select('*')->from('email_sms_gateway')->where('es_id', 2)->get()->row();
		
		//print_r($email);
		//die();

		//SMTP & mail configuration
		$config = array(
		    'protocol'  => $email->protocol,
		    'smtp_host' => $email->host,
		    'smtp_port' => $email->port,
		    'smtp_user' => $email->user,
		    'smtp_pass' => $email->password,
		    'mailtype'  => $email->mailtype,
		    'charset'   => 'iso-8859-1',
            'wordwrap'  => TRUE,
		    'newline'   => "\r\n"
		);
		
		//Load email library
		$this->load->library('email',$config);
		$this->email->initialize($config);
		//$this->email->set_mailtype("html");
		//$this->email->set_newline("\r\n");

		//Email content
		$htmlContent = $post['message'];

		$this->email->to($post['to']);
		$this->email->from($email->user, $email->title);
		$this->email->subject($post['subject']);
		$this->email->message($htmlContent);
		
		//Send email
		if($this->email->send()){

			return 1;

		} else{
			
			return 0;

		}
		
	}


	public function email_sms($method)
	{
        
	   return $this->db->select('*')
       ->from('sms_email_send_setup')
       ->where('method',$method)
       ->get()
       ->row();

	}
	
	public function send_bulk_email($config = array())
    {
        if (isset($config['from']) && !empty($config['from']))
        {
            $_from = $config['from'];
        } 

        $_message = $config['template'];
        if (is_array($config['template_config']) && sizeof($config['template_config']) > 0)
        {
            $_message = $this->bulk_template($config['template'], $config['template_config']);
        }

        if (isset($config['attach']) && is_array($config['attach']) && sizeof($config['attach']) > 0)
        {
            $_attach = $config['attach'];
        }

        $data['to']		= $config['to'];
        $data['subject']= $config['subject'];
        $data['title']	= 'Crypto Currency MLM System';
        $data['message']= $_message;
        

        $nowtime = date("Y-m-d H:i:s");
        $delivary = array(
        	'reciver_email'			=>$data['to'],
        	'delivery_date_time'	=>$nowtime,
        	'message'				=>$data['message']
        );

        $this->db->insert("email_delivery",$delivary);

        #send mail
        $this->send_email($data);
    }

	private function bulk_template($template = null, $data = array())
    {

        $newStr = $template;
        foreach ($data as $key => $value) {

            $fkey = array_keys($value);
            $newStr = str_replace("{".$fkey[0]."}", $value[$fkey[0]], $newStr);

        }

        return $newStr; 

    }
}
