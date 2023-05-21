<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        if (function_exists('date_default_timezone_set'))
            date_default_timezone_set('Asia/Kolkata');
        $this->load->library('image_lib');
        $this->load->model("Admin_model");
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr'));
    }

    public function register() {
        if ($this->input->post("adminRegister")) {
            $this->newRegistration();
        }
        $this->load->view("admin_register_view");
    }

    public function newRegistration() {
        $roletype = FILTER_VAR(trim($this->input->post('roleName')), FILTER_SANITIZE_STRING);
        $orgname = FILTER_VAR(trim(ucwords(strtolower($this->input->post('name')))), FILTER_SANITIZE_STRING);
        $orgMobile = FILTER_VAR(trim($this->input->post('orgMobile')), FILTER_SANITIZE_NUMBER_INT);
        $email = FILTER_VAR(trim($this->input->post('email')), FILTER_VALIDATE_EMAIL);
        $password = FILTER_VAR(trim($this->input->post('password')), FILTER_SANITIZE_STRING);
        $countryId = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_STRING);
        $stateId = FILTER_VAR(trim($this->input->post('stateId')), FILTER_SANITIZE_STRING);
        $cityId = FILTER_VAR(trim($this->input->post('cityId')), FILTER_SANITIZE_STRING);
        $address = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);

        $query = $this->Admin_model->mRegisterAdmin($roletype, $orgname, $orgMobile, $email, $password, $countryId, $stateId, $cityId, $address);
        ($query == "empty" ? $this->session->set_flashdata("msg_r", "Required field is empty.") :
                        ($query == "duplicate" ? $this->session->set_flashdata("msg_r", "Already registered.") :
                                ($query == "success" ? $this->session->set_flashdata("msg_g", "Registered successfully.") :
                                        ($query == "error" ? $this->session->set_flashdata("msg_r", "Some error occured.") : ""))));

        redirect('Admin/register');
    }

    public function login() {
        $this->load->view("admin_login_view");
    }

    public function adminlogin() {
        $recapchavalidate = $this->recaptcha($this->input->post("g-recaptcha-response"));
        $response = json_decode($recapchavalidate, true);
        if ($response['success'] == "1") {
            $email = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_EMAIL);
            $password = FILTER_VAR(trim($this->input->post('password')), FILTER_SANITIZE_STRING);
            $roletype = FILTER_VAR(trim($this->input->post('role')), FILTER_SANITIZE_STRING);
            if (empty($email) || empty($password) || empty($roletype)) {
                $message = '{"status":"error","msg":"Empty Details"}';
            } else {
                $message = $this->Admin_model->mAdminLogin($email, $password, $roletype);
            }
        } else {
            $message = '{"status":"captcha","msg":"Captcha not filled"}';
        }
        $this->viewMessage($message);
    }

    public function recaptcha($response) {
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

    private function viewMessage($message) {
        $data["message"] = $message;
        $this->load->view("view_message", $data);
    }

}
