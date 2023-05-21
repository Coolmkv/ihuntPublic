<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
        $this->load->database();
    }

    public function mRegisterAdmin($roletype, $orgname, $orgMobile, $email, $password, $countryId, $stateId, $cityId, $address) {

        if (empty($roletype) || empty($orgname) || empty($orgMobile) || empty($email) || empty($password) || empty($countryId) || empty($stateId) || empty($cityId) || empty($address)) {
            return '{"status":"error", "msg":"Required field is empty."}';
        }
        $chkqry = $this->db->query("SELECT * FROM login_details WHERE email='" . $email . "' AND isactive=1");
        if ($chkqry->num_rows() > 0) {
            return '{"status":"error", "msg":"Already registered."}';
        } else {
            $pwd_encrpyt = $this->encryption->encrypt($password);
            $data = ["email" => $email, "password" => $password, "password1" => $pwd_encrpyt, "roleName" => $roletype, "ipAddress" => $this->getRealIpAddr(), "createdAt" => $this->datetimenow(), "isactive" => 1];
            $this->db->insert("login_details", $data);
            $insertid = $this->db->insert_id();
            if ($insertid) {
                $orgdata = ["loginId" => $insertid, "orgName" => $orgname, "orgMobile" => $orgMobile, "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "orgAddress" => $address, "orgCreated" => $this->datetimenow(), "isactive" => 1];
                $resp = $this->db->insert("organization_details", $orgdata);
                ($resp ? $this->sendVerificationEmail($email, $orgname, $insertid, $roletype) : "");
                return ($resp ? '{"status":"success", "msg":"Registered successfully. Please check your email to verify."}' : '{"status":"error", "msg":"Some error occured."}');
            } else {
                return '{"status":"error", "msg":"Some error occured."}';
            }
        }
    }

    private function sendVerificationEmail($email, $orgname, $id, $roletype) {
        $verificationcode = $this->encryption->encrypt($email);
        $loginid = $this->encryption->encrypt($id);
        $body = "Hello $orgname,<br>&nbsp;&nbsp;&nbsp;&nbsp;Welcome to ihuntbest please
                <a href='" . site_url('home/index?verificationCode=' . $verificationcode . '&id=' . $loginid) . "'>Click Here</a> to Verify email.";
        $subject = "Verify your account at IhuntBest";
        $this->sendEmails($email, $body, $subject);
        $admin = $this->db->get("web_users");
        if ($admin->num_rows() > 0) {
            $rowData = $admin->row();
            $userEmail = $rowData->userEmail;
            $subject = 'A new registration in Ihuntbest.';
            $body = 'A new user is registered with Email = ' . $email . ', Name = ' . $orgname . ',and  Account type=' . $roletype . ' at ' . $this->datetimenow();
            $this->sendEmails($userEmail, $body, $subject);
        }
    }

    public function sendEmails($email, $body, $subject) {
        $emailS = (isset($_SESSION['websiteEmail']) ? $_SESSION['websiteEmail'] : 'donotreply@ihuntbest.com');
        $senderName = "iHuntBest";
        $message = $body;
        $config = array('mailtype' => 'html', 'charset' => 'iso-8859-1', 'wordwrap' => TRUE);
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($emailS, $senderName);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $reps = $this->email->send();
        return $reps;
    }

    public function mOrgLogin($email, $password, $roletype) {
        if (empty($email) || empty($password) || empty($roletype)) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        //$this->sendEmail('donotreply@ihuntbest.com','vermamanish4u@gmail.com','Testing the email class. '.$email.' ','verma.manish@starlingrosy.com');
        $chkquery = $this->db->query("SELECT * FROM login_details WHERE email='" . $email . "' AND roleName='" . $roletype . "' AND isactive=1");
        if ($chkquery->num_rows() > 0) {
            $tpassword = $chkquery->row()->password;
            $encppass = $this->encryption->decrypt($chkquery->row()->password1);
            $loginStatus = $chkquery->row()->loginStatus;
            $verifyStatus = $chkquery->row()->verifyStatus;
            if ($verifyStatus == "0") {
                return '{"status":"error","msg":"Unverified Account"}';
            }
            if ($loginStatus == 0) {
                return $this->setOrgSession($password, $tpassword, $encppass, $email);
            } else {
                return '{"status":"error","msg":"Disabled"}';
            }
        } else {
            return '{"status":"error","msg":"Not registered"}';
        }
    }

    public function setOrgSession($password, $tpassword, $encppass, $email) {
        if ($password == $tpassword || $password == $encppass) {
            $sData = $this->db->query("SELECT od.orgId,od.orgName,ld.email,ld.id,ld.roleName FROM login_details as ld
                                            INNER JOIN organization_details as od ON ld.id=od.loginId WHERE ld.email='" . $email . "'");
            if ($sData->num_rows() > 0) {
                $rData = $sData->row();
                $_SESSION['loginId'] = $rData->id;
                $_SESSION['orgId'] = $rData->orgId;
                $_SESSION['email'] = $rData->email;
                $_SESSION['userType'] = $rData->roleName;
                $_SESSION['orgName'] = $rData->orgName;
                $getCurrency = $this->db->where(["user_type" => $rData->roleName, "login_id" => $rData->id, "isactive" => 1])->select("defaultCurrency")->get("tbl_financial_details");
                $rowData = ($getCurrency->num_rows() > 0 ? $getCurrency->row() : '');
                $_SESSION['dCurrency'] = ($rowData ? $rowData->defaultCurrency : "");
                return '{"status":"success","msg":"Login Successfully"}';
            } else {
                return '{"status":"error","msg":"Incorrect Password"}';
            }
        } else {
            return '{"status":"error","msg":"Incorrect Password"}';
        }
    }

    private function sendEmail($from, $sendto, $message, $ccemail) {
        $this->load->library('email');
        $config = ['mailtype' => 'html', 'charset' => 'iso-8859-1', 'wordwrap' => TRUE, 'protocol' => 'sendmail'];
        $this->email->initialize($config);
        $this->email->from($from, 'Ihunt');
        $this->email->to($sendto);
        $this->email->cc($ccemail);
        //$this->email->bcc('them@their-example.com');

        $this->email->subject('Email Test');
        $this->email->message($message);

        $this->email->send();
    }

    private function datetimenow() {
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $todaydate = $date->format('Y-m-d H:i:sA');
        return $todaydate;
    }

    private function getRealIpAddr() {
        if (!empty($_SERVER['REMOTE_ADDR'])) {   //check ip from share internet
            $ip = $_SERVER['REMOTE_ADDR'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'];
        }
        return $ip;
    }

}
