<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
        $this->load->database();
    }

    public function mRegisterAdmin($roletype, $orgname, $orgMobile, $email, $password, $countryId, $stateId, $cityId, $address) {
        $ipAddress = $this->getRealIpAddr();
        if (empty($roletype) || empty($orgname) || empty($orgMobile) || empty($email) || empty($password) || empty($countryId) || empty($stateId) || empty($cityId) || empty($address)) {
            return "empty";
        }
        $chkqry = $this->db->query("SELECT * FROM login_details WHERE email='" . $email . "' AND isactive=1");
        if ($chkqry->num_rows() > 0) {
            return "duplicate";
        } else {
            $pwd_encrpyt = $this->encryption->encrypt($password);
            $data = ["email" => $email, "password" => $password, "password1" => $pwd_encrpyt, "roleName" => $roletype, "ipAddress" => $ipAddress, "isactive" => 1];
            $this->db->insert("login_details", $data);
            $insertid = $this->db->insert_id();
            if ($insertid) {
                $orgdata = ["loginId" => $insertid, "orgName" => $orgname, "orgMobile" => $orgMobile, "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "orgAddress" => $address, "isactive" => 1];
                $this->db->insert("organization_details", $orgdata);
                return "success";
            } else {
                return "error";
            }
        }
    }

    public function mAdminLogin($email, $password, $roletype) {
        $chkquery = $this->db->query("SELECT * FROM login_details WHERE email='" . $email . "' AND roleName='" . $roletype . "' AND isactive=1");
        if ($chkquery->num_rows() > 0) {
            $qryData = $chkquery->row();
            $tpassword = $qryData->password;
            $encppass = $this->encryption->decrypt($qryData->password1);
            $loginStatus = $qryData->loginStatus;
            $verifyStatus = $qryData->verifyStatus;
            if ($verifyStatus == "0") {
                return '{"status":"error","msg":"Unverified Account"}';
            }
            if ($loginStatus == 0) {
                return $this->setAdminSession($password, $tpassword, $encppass, $email);
            } else {
                return '{"status":"error","msg":"Disabled"}';
            }
        } else {
            return '{"status":"error","msg":"Details Not found"}';
        }
    }

    public function setAdminSession($password, $tpassword, $encppass, $email) {
        if ($password == $tpassword || $password == $encppass) {
            $sData = $this->db->query("SELECT od.orgId,od.orgName,ld.email,ld.id,ld.roleName FROM login_details as ld
                    INNER JOIN organization_details as od ON ld.id=od.loginId WHERE ld.email='" . $email . "'");
            if ($sData->num_rows() > 0) {
                $rData = $sData->row();
                $_SESSION['loginId'] = $rData->id;
                $_SESSION['email'] = $rData->email;
                $_SESSION['userType'] = $rData->roleName;
                $_SESSION['orgName'] = $rData->orgName;
                return '{"status":"success","msg":"Login Successfully"}';
            } else {
                return '{"status":"error","msg":"Incorrect Password"}';
            }
        } else {
            return '{"status":"error","msg":"Incorrect Password"}';
        }
    }

    public function getRealIpAddr() {
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
