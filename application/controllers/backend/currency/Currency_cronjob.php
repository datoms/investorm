<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_cronjob extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();

 		$this->load->model(array(
 			'backend/currency/currency_model'  
 		));
 	}

	public function updateCurency(){


		$apidata = $this->db->select('*')->from('external_api_setup')->where('id', 1)->get()->row();
		$api_data = array();
        if (is_string($apidata->data) && is_array(json_decode($apidata->data, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {
            $api_data = json_decode($apidata->data, true);
            if ($api_data['api_key']=='') {
            	$this->session->set_flashdata('exception', "Setup coinmarketcap API");
        		redirect("backend/currency/currency");
            }
        }else{
        	$this->session->set_flashdata('exception', "Setup coinmarketcap API");
        	redirect("backend/currency/currency");
        }

		// https://pro.coinmarketcap.com/migrate/
		$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
		$parameters = [
		  'start' 	=> '1',
		  'limit' 	=> '500',
		  'convert' => 'USD'
		];

		$headers = [
		  'Accepts: application/json',
		  'X-CMC_PRO_API_KEY: '.@$api_data['api_key']
		];
		$qs = http_build_query($parameters); // query string encode the parameters
		$request = "{$url}?{$qs}"; // create the request URL


		$curl = curl_init(); // Get cURL resource
		// Set cURL options
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $request,            // set the request URL
		  CURLOPT_HTTPHEADER => $headers,     // set the headers 
		  CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
		));

		$response = curl_exec($curl); // Send the request, save the response

		$jcurrency=json_decode($response);
		
		foreach ($jcurrency->data as $jkey => $jvalue) {

			$data['symbol']				= $jvalue->symbol;
			$data['rank']				= $jvalue->cmc_rank;
			$data['price_usd']			= $jvalue->quote->USD->price;
			$data['market_cap_usd']		= $jvalue->quote->USD->market_cap;
			$data['total_supply']		= $jvalue->total_supply;
			$data['max_supply']			= $jvalue->max_supply;
			$data['percent_change_1h']	= $jvalue->quote->USD->percent_change_1h;
			$data['percent_change_24h']	= $jvalue->quote->USD->percent_change_24h;
			$data['percent_change_7d']	= $jvalue->quote->USD->percent_change_7d;
			$data['last_updated']		= $jvalue->quote->USD->last_updated;

			$this->currency_model->updateCurency($data);
		}

		curl_close($curl);

		if ($jcurrency->status->error_message!='') {
			$this->session->set_flashdata('exception', "error_message: ".@$jcurrency->status->error_message.' notice: '.@$jcurrency->status->notice);
		}else{
			$this->session->set_flashdata('message', display('update_successfully'));
		}
		
		redirect("backend/currency/currency/");

		

	}

	
}
