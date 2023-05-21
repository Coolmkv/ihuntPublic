<?php

/**
 * @package Razorpay :  CodeIgniter Razorpay Gateway
 *
 * @author ihunt  Team
 *   
 * Description of Razorpay Controller
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Razorpay extends CI_Controller 
{
    // construct
	public function __construct() 
	{
        parent::__construct();
        $this->load->library('encryption');
		
		require_once APPPATH."/third_party/razorpay/Razorpay.php";
		
        if (function_exists('date_default_timezone_set')) 
		{
            date_default_timezone_set('Asia/Kolkata');
        }
        $this->load->library('image_lib');
        $this->encryption->initialize(array('cipher' => 'aes-256','mode' => 'ctr'));
    }
       
    // checkout page
    public function checkout() 
	{
		// use Razorpay\Api\Api;

		$api_key = "rzp_test_5EwmQhazRAufOe";
		$api_secret = "HN6AQ2epON44lxT5GUgaDYrV";
		
		// $api = new Api($api_key, $api_secret);
		
        $data['title'] = 'Checkout payment | IHUNT';  
        // $this->site->setProductID($id);
        // $data['itemInfo'] = //get info of the course  ;    
        $data['return_url'] = site_url().'razorpay/callback';
        $data['surl'] = site_url().'razorpay/success';;
        $data['furl'] = site_url().'razorpay/failed';;
        $data['currency_code'] = 'INR';
		
		/* $order = $api->order->create(array(
			  'receipt' => '123',
			  'amount' => 100,
			  'payment_capture' => 1,
			  'currency' => 'INR'
			)
		); */
		
    }
 

        
    // callback method
    public function callback() 
	{        
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) 
		{
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try 
			{                
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) 
				{
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } 
				else 
				{
                    $response_array = json_decode($result, true);
                   // echo "<pre>";print_r($response_array);exit;
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) 
						{
                            $success = true;
                        } 
						else 
						{
                            $success = false;
                            if (!empty($response_array['error']['code'])) 
							{
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } 
							else 
							{
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close connection
                curl_close($ch);
            } 
			catch (Exception $e) 
			{
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            if ($success === true) 
			{
                if(!empty($this->session->userdata('ci_subscription_keys'))) 
				{
                    $this->session->unset_userdata('ci_subscription_keys');
                }
                if (!$order_info['order_status_id']) 
				{
                    redirect($this->input->post('merchant_surl_id'));
                } 
				else 
				{
                    redirect($this->input->post('merchant_surl_id'));
                }
 
            } 
			else 
			{
                redirect($this->input->post('merchant_furl_id'));
            }
        } 
		else 
		{
            echo 'An error occured. Contact site administrator, please!';
        }
    } 
	
    public function success() 
	{
        $data['title'] = 'Razorpay Success | IHUNT';  
        $this->load->view('razorpay/success', $data);
    }  
	
    public function failed() 
	{
        $data['title'] = 'Razorpay Failed | IHUNT';            
        $this->load->view('razorpay/failed', $data);
    } 
}
?>