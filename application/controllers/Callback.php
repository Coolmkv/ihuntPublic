<?php
//require_once "constants.php";
// initialized cURL Request
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set('Asia/Kolkata');
        }
        $this->load->library('image_lib');
        $this->load->model("Home_model");
		$this->load->library('session');
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr'));
    }

	
public function get_curl_handle($payment_id, $data) {
    $url = 'https://api.razorpay.com/v1/payments/' . $payment_id . '/capture';
    $key_id = RAZOR_KEY_ID;
    $key_secret = RAZOR_KEY_SECRET;
    $params = http_build_query($data);
    //cURL Request
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    return $ch;
}

	public function razorpaycallback(){

			if (!empty($_POST['razorpay_payment_id']) && !empty($_POST['merchant_order_id'])) {
			$json = array();
			$razorpay_payment_id = $_POST['razorpay_payment_id'];
			$merchant_order_id = $_POST['merchant_order_id'];
			$currency_code = $_POST['currency_code_id'];
			// store temprary data
			$dataFlesh = array(
				'amount' => ($_POST['merchant_total'])/100,
				'org_id' => $_POST['org_id'],
				'course_id' => $_POST['course_id'],
				'surl' => $_POST['merchant_surl_id'],
				'furl' => $_POST['merchant_furl_id'],
				'currency_code' => $currency_code,
				'order_id' => $_POST['merchant_order_id'],
				'razorpay_payment_id' => $_POST['razorpay_payment_id'],
				'orgType' => $_POST['orgType'],
				'course_s_id' => $_POST['course_s_id']
			);
			$paymentInfo = $dataFlesh;
			$order_info = array('order_status_id' => $_POST['merchant_order_id']);
			$amount = $_POST['merchant_total'];
			$currency_code = $_POST['currency_code_id'];
			// bind amount and currecy code
			$data = array(
				'amount' => $amount,
				'currency' => $currency_code,
			);
			$success = false;
			$error = '';
			try {
				$ch = $this->get_curl_handle($razorpay_payment_id, $data);
				//execute post
				$result = curl_exec($ch);
				$data = json_decode($result);
			   
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				if ($result === false) {
					$success = false;
					$error = 'Curl error: ' . curl_error($ch);
				} else {
					$response_array = json_decode($result, true);
					//Check success response
					if ($http_status === 200 and isset($response_array['error']) === false) {
						$success = true;
						$this->session->set_userdata($paymentInfo);
					} else {
						$success = false;
						$this->session->set_userdata($paymentInfo);
						if (!empty($response_array['error']['code'])) {
							$error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
						} else {
							$error = 'Invalid Response <br/>' . $result;
						}
					}
				}
				//close connection
				curl_close($ch);
			} catch (Exception $e) {
				$success = false;
				$error = 'Request to Razorpay Failed';
			}
			if ($success === true) {
				if (!$order_info['order_status_id']) {
					$json['redirectURL'] = $_POST['merchant_surl_id'];
				} else {
					$json['redirectURL'] = $_POST['merchant_surl_id'];
				}
			} else {
				// print_r( $error);
				// die();
				$json['redirectURL'] = $_POST['merchant_furl_id'];
			}
			$json['msg'] = '';
			} else {
			$json['msg'] = 'An error occured. Contact site administrator, please!';
			}
			header('Content-Type: application/json');
			echo json_encode($json);

	}
}
?>