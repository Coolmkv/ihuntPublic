<?php
//require_once "constants.php";
// initialized cURL Request
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	
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

public function get_curl_handle_for_transfer($data) {
    $url = 'https://api.razorpay.com/v1/transfers/';
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

			if (!empty($_POST['razorpay_payment_id'])) {
			$json = array();
			$razorpay_payment_id = $_POST['razorpay_payment_id'];
			//$merchant_order_id = $_POST['merchant_order_id'];
			$currency_code = $_POST['currency_code_id'];
			$enroll_id = $_POST['enrollmentId'];
			$org_id = $_POST['orgId'];
			$org_name = $_POST['org_name'];
			$orgemail = $_POST['orgemail'];
			$orgaccid = $_POST['orgaccount_id'];
			$org_splitpay_status = $_POST['org_splitpay_status'];
			$orgpercent = $_POST['orgpercentage'];
			
			// store temprary data
			$dataFlesh = array(
			    'payment_id'=> $_POST['razorpay_payment_id'],
			    'enrollment_id'=> $enroll_id,
				'amount' => ($_POST['merchant_total'])/100,
				'notes'=>"Payment_success_full"
			);
			//$paymentInfo = $dataFlesh;
			//$order_info = array('order_status_id' => $_POST['merchant_order_id']);
			$amount = $_POST['merchant_total'];
			$currency_code = $_POST['currency_code_id'];
			// bind amount and currecy code
			$data = array(
				'amount' => $amount,
				'currency' => $currency_code,
			);
			
			
			
			
			if(isset($_SESSION['studentId'])){
				$sql = "SELECT * FROM student_details WHERE studentId=".$_SESSION['studentId']; 
				$result = $this->db->query($sql)->result();
				$studentname = $result[0]->studentName ;
				
				
			}
			
			
			$accountId = 'acc_EU5Beq5AdNss3U';
			if(strstr($orgpercent,"%")){
				$orgpercent = str_replace("%","",$orgpercent);
				$transfer_amount = $amount - ($amount*(int)$orgpercent/100);
				$transfer_condition = "true";
			}else{
				$orgpercent = str_replace("Rs","",$orgpercent);
				$orgpercent = (int)$orgpercent*100;
				$transfer_amount = $amount- $orgpercent;
				$transfer_condition = ($amount>=$orgpercent)? "true" : "false";
			}
			$currency = "INR";
			$data_transfer = array(
				'account'=> $orgaccid,
				'amount'=>  $transfer_amount,
				'currency'=> $currency
			);
			
			$dataInsert = array(
			    'enrollment_id'=> $enroll_id,
				'org_id'=> $org_id,
				'student_name'=>$studentname,
				'amount' => ($transfer_amount)/100
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
						$this->db->insert('tbl_enroll_payments', $dataFlesh);
						$tdata = ["enrollmentId" => $enroll_id, "org_amt" => 0, "ihunt_amt" =>($_POST['merchant_total'])/100 ,"payment_id" => $_POST['razorpay_payment_id'],"student_name"=>$studentname,"org_name"=>$org_name,"fees_category"=>"Course Fee","createdAt"=> $this->datetimenow()];
		                $transaction = $this->db->insert("tbl_transactions", $tdata); 
						//$this->session->set_userdata($paymentInfo);
						if($org_splitpay_status=="true" && $transfer_condition=="true") {
								try{
									$ch1 = $this->get_curl_handle_for_transfer($data_transfer);
									//execute post
									$result1 = curl_exec($ch1);
									$data1 = json_decode($result1);
								   
									$http_status1 = curl_getinfo($ch1, CURLINFO_HTTP_CODE);
									if ($result1 === false) {
										$success1 = false;
										$error1 = 'Curl error: ' . curl_error($ch1);
									} else {
										$response_array1 = json_decode($result1, true);
										/* echo "<pre>";
										print_r($response_array1);
										echo "<pre>"; */
										//Check success response
										if ($http_status1 === 200 and isset($response_array1['error']) === false) {
												$success1 = true;
												$dataInsert['payment_id'] = $response_array1['id'];
												$this->db->insert('tbl_org_transactions', $dataInsert);
												$famt = ($_POST['merchant_total'])/100;
												$orgamt = ($transfer_amount)/100;
												$ihuntamt = $famt-$orgamt;
												$tdata = ["enrollmentId" => $enroll_id, "org_amt" =>$orgamt, "ihunt_amt" =>$ihuntamt ,"payment_id" => $_POST['razorpay_payment_id'].','.$response_array1['id'],"student_name"=>$studentname,"org_name"=>$org_name,"fees_category"=>"Course Fee","createdAt"=> $this->datetimenow()];
		                                        $transaction = $this->db->insert("tbl_transactions", $tdata); 
										}
										else {
												$success1 = false;
											
												//$this->session->set_userdata($paymentInfo);
												if (!empty($response_array1['error']['code'])) {
													$error1 = $response_array1['error']['code'] . ':' . $response_array1['error']['description'];
												} else {
													$error1 = 'Invalid Response <br/>' . $result;
												}
										}
									}
									//close connection
									curl_close($ch1);
								}
								
								catch (Exception $c) {
									$success = false;
									$error = 'Request to Razorpay Failed';
								}
								
						}else{
							//$sendermail = $orgemail;
							if($org_splitpay_status=="true"){
								$sendermail = "mehul.scorpsoft@gmail.com";
								$pendingamount = ((int)$orgpercent-$amount)/100;

								$subject = 'Pending Payment to ihuntBest.com';

								$body = 'A new Student is enrolled in course with enrollment Id = '.$enroll_id.'. Please pay the pending amount which is '.$pendingamount.' to ihuntBest.com';


								$this->Home_model->sendEmailToOrg($sendermail,$body,$subject);
							}
						}
							
					} else {
						$success = false;
					
						//$this->session->set_userdata($paymentInfo);
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
				$json['msg'] = 'Payment SuccessFull';
				//if (!$order_info['order_status_id']) {
					//$json['redirectURL'] = $_POST['merchant_surl_id'];
				//} else {
					//$json['redirectURL'] = $_POST['merchant_surl_id'];
				//}
			} else {
				// print_r( $error);
				// die();
				//$json['redirectURL'] = $_POST['merchant_furl_id'];
			}
			} else {
			$json['msg'] = 'An error occured. Contact site administrator, please!';
			}
			header('Content-Type: application/json');
			echo json_encode($json);

	}
	public function datetimenow()
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
		$todaydate = $date->format('Y-m-d H:i:s');

		return $todaydate;
	}
}
?>