<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set('Asia/Kolkata');
        }
        $this->load->library('image_lib');
        $this->load->model("Register_model");
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr'));
    }

    public function studentRegistration() {
        if ($this->input->post("save_user")) {
            $registerStudent = $this->Register_model->mRegisterStudent();
            if ($registerStudent == "inserted") {
                $message = '{"status":"success","msg":"Registered successfully. Please check verification mail."}';
            }
            if ($registerStudent == "duplicate") {
                $message = '{"status":"error","msg":"Already registered."}';
            }if ($registerStudent == "empty") {
                $message = '{"status":"error","msg":"Validation failed"}';
            }
        } else {
            $message = '{"status":"error","msg":"Registration attempt failed"}';
        }
        $this->viewMessage($message);
    }

    public function studentLogin() {
        $recapchavalidate = $this->recaptcha($this->input->post("g-recaptcha-response"));
        $response = json_decode($recapchavalidate, true);
        if ($response['success'] == "1") {
            $studentEmail = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_EMAIL);
            $password = FILTER_VAR(trim($this->input->post('password')), FILTER_SANITIZE_STRING);
            $this->viewMessage($this->Register_model->mStudentLogin($studentEmail, $password));
        } else {
            $this->viewMessage('{"status":"error","msg":"Captcha not filled"}');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('Home');
    }

    function recaptcha($response) {
        $postvars = array("secret" => "6LfYFV0UAAAAAPRELXIe_yFm48pLeH61g38JTS3S", "response" => "$response");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
        $content = trim(curl_exec($ch));
        curl_close($ch);
        return $content;
    }

    function loginWithGoogle() {
        $this->viewMessage($this->Register_model->registerOrLoginGoogle());
    }
	
	function loginWithFaceBook() {
        $this->viewMessage($this->Register_model->registerOrLoginFacebook());
    }

    private function viewMessage($message) {
        $data["message"] = $message;
        $this->load->view("view_message", $data);
    }

}
