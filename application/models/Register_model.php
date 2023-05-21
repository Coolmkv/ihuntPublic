<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
    }

    public function mRegisterStudent() {
        $studentName = FILTER_VAR(trim(ucfirst(strtolower($this->input->post('studentName')))), FILTER_SANITIZE_STRING);
        $studentMobile = FILTER_VAR(trim($this->input->post('studentMobile')), FILTER_SANITIZE_NUMBER_INT);
        $studentEmail = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_EMAIL);
        $password = FILTER_VAR(trim($this->input->post('password')), FILTER_SANITIZE_STRING);
        $countryId1 = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_NUMBER_INT);
        $stateId1 = FILTER_VAR(trim($this->input->post('stateId1')), FILTER_SANITIZE_NUMBER_INT);
        $cityId1 = FILTER_VAR(trim($this->input->post('cityId1')), FILTER_SANITIZE_NUMBER_INT);
        $address = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);
        $dob = FILTER_VAR(trim($this->input->post('dob')), FILTER_SANITIZE_STRING);
        $dobc = date('Y-m-d', strtotime($dob));
        $gender = FILTER_VAR(trim($this->input->post('gender')), FILTER_SANITIZE_STRING);
        $encpass = $this->encryption->encrypt($password);
        $ens_value_id = $this->earnvalueCode();
        $refercode = FILTER_VAR(trim($this->input->post('refercode')), FILTER_SANITIZE_STRING);
        if (empty($studentName) || empty($studentMobile) || empty($studentEmail) || empty($password) || empty($countryId1) || empty($stateId1) || empty($cityId1) || empty($address) || empty($gender)) {
            return "empty";
        }
        $chkQuery = $this->db->query("SELECT * FROM student_login WHERE email='" . $studentEmail . "'");
        return ($chkQuery->num_rows() > 0 ? "duplicate" : $this->registerStudent($studentEmail, $password, $encpass, $refercode, $ens_value_id, $studentName, $studentMobile, $countryId1, $stateId1, $cityId1, $address, $gender, $dobc));
    }

    private function registerStudent($studentEmail, $password, $encpass, $refercode, $ens_value_id, $studentName, $studentMobile, $countryId1, $stateId1, $cityId1, $address, $gender, $dobc) {

        $data = ["email" => $studentEmail, "password" => $password, "password1" => $encpass, "my_referer" => $refercode, "ens_value_id" => $ens_value_id,
            "studentName" => $studentName, "ipAddress" => $this->getRealIpAddr(), "createdAt" => $this->datetimenow(), "isactive" => 1];
        $this->db->insert("student_login", $data);

        $id = $this->db->insert_id();
        $this->addActivityLog($id, "Student Login Details  $studentName($studentEmail)) inserted.", "student_login", "0", "Student");
        $sdetails = ["studentId" => $id, "studentName" => $studentName, "studentMobile" => $studentMobile, "countryId" => $countryId1, "stateId" => $stateId1, "cityId" => $cityId1, "location" => $address,
            "gender" => $gender, "dob" => $dobc, "createdAt" => $this->datetimenow(), "isactive" => 1];
        $this->db->insert("student_details", $sdetails);
        $refereCode = "IHB" . $id . '-' . time();

        $resp = $this->db->where("studentId", $id)->update("student_login", ["my_refer_code" => $refereCode]);
        $this->addActivityLog($id, "Student Details  $studentName($studentEmail)) inserted.", "student_details", "0", "Student");
        ($resp ? $this->sendVerificationEmail($studentEmail, $studentName, $id, 'Student') : "");
        return 'inserted';
    }

    private function sendVerificationEmail($email, $orgname, $id, $roletype) {
        $verificationcode = $this->encryption->encrypt($email);
        $loginid = $this->encryption->encrypt($id);
        $body = "Hello $orgname,<br>&nbsp;&nbsp;&nbsp;&nbsp;Welcome to ihuntbest please
                <a href='" . site_url('home/index?studentVerification=' . $verificationcode . '&id=' . $loginid) . "'>Click Here</a> to Verify email.";
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

    private function earnvalueCode() {
        $qry = $this->db->where("iscurrent", 1)->get("tbl_earn_n_share_value");
        $result = ($qry->num_rows() > 0 ? $qry->row() : null);
        $return = ($result ? $result->ens_value_id : false);
        return $return;
    }

    public function mStudentLogin($studentEmail, $password) {
        if (empty($studentEmail) || empty($password)) {
            return '{"status":"error", "msg":"Required field is empty."}';
        }
        $findStudent = $this->db->query("SELECT * FROM student_login WHERE email='" . $studentEmail . "' AND isactive=1");
        if ($findStudent->num_rows() > 0) {
            $sdata = $findStudent->row();
            $password1 = $this->encryption->decrypt($sdata->password1);
            $pwd2 = $sdata->password;
            $email_verified = $sdata->email_verified;
            if ($email_verified === '0') {
                $this->sendVerificationEmail($studentEmail, $sdata->studentName, $sdata->studentId, 'Student');
                return '{"status":"error", "msg":"Email not verfied.Another Email sent."}';
            }
            return ($password == $password1 || $password == $pwd2 ? $this->setStudentSession($studentEmail) : '{"status":"error", "msg":"Password not matched."}');
        } else {
            return '{"status":"error", "msg":"Details not found."}';
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

    public function setStudentSession($studentEmail) {
        $getData = $this->db->query("SELECT sd.studentName,sl.email,sl.studentId FROM student_login as sl
                INNER JOIN  student_details as sd ON sl.studentId=sd.studentId WHERE sl.email='" . $studentEmail . "' AND sl.isactive=1");
        if ($getData->num_rows() > 0) {
            $rowData = $getData->row();
            $_SESSION['studentId'] = $rowData->studentId;
            $_SESSION['studentName'] = $rowData->studentName;
            $_SESSION['studentemail'] = $rowData->email;
            $this->addActivityLog($rowData->studentId, "Student Login  ($studentEmail) success.", "student_login", "0", "Student");
            return '{"status":"success", "msg":"Logged in Successfully"}';
        } else {
            $this->addActivityLog("", "Student Login  ($studentEmail) failed.", "student_login", "0", "Student");
            return '{"status":"error", "msg":"Details not found."}';
        }
    }

    public function registerOrLoginGoogle() {
        $name = FILTER_VAR(trim($this->input->post('name')), FILTER_SANITIZE_STRING);
        $email = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_EMAIL);
        //$image = $this->input->post('image');
        if (empty($name) || empty($email)) {
            return '{"status":"error", "msg":"Details are empty."}';
        }
        $chk = $this->db->where(["email" => $email])->get("student_login");
        if ($chk->num_rows() > 0) {
            $sdata = $chk->row();
            ($sdata->email_verified === '0' ? $this->sendVerificationEmail($email, $sdata->studentName, $sdata->studentId, 'Student') : '');

            return $this->setStudentSession($email);
        } else {
            $password = $name . mt_rand();
            $encpass = $this->encryption->encrypt($password);
            $data = ["email" => $email, "password" => $password, "password1" => $encpass, "studentName" => $name, "ipAddress" => $this->getRealIpAddr(), "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("student_login", $data);
            ($res ? $this->addStudentDetails($email, $name, $this->db->insert_id()) : '');
            ($res ? $this->sendPasswordEmail($email, $password, $name, $this->db->insert_id()) : '');

            return $this->setStudentSession($email);
        }
    }

    private function addStudentDetails($studentEmail, $studentName, $id) {
        $sdetails = ["studentId" => $id, "studentName" => $studentName, "createdAt" => $this->datetimenow(), "isactive" => 1];
        $this->db->insert("student_details", $sdetails);
        $refereCode = "IHB" . $id . '-' . time();

        $resp = $this->db->where("studentId", $id)->update("student_login", ["my_refer_code" => $refereCode]);
        ($resp ? $this->addActivityLog($id, "Student Details  $studentName($studentEmail)) inserted.", "student_details", "0", "Student") : '');
    }

    private function sendPasswordEmail($email, $password, $orgname, $id) {
        $verificationcode = $this->encryption->encrypt($email);
        $loginid = $this->encryption->encrypt($id);
        $body = "Hello $orgname,<br>&nbsp;&nbsp;&nbsp;&nbsp;Welcome to ihuntbest please
                <a href='" . site_url('home/index?studentVerification=' . $verificationcode . '&id=' . $loginid) . "'>Click Here</a> to Verify email. And your password is : " . $password;
        $subject = "Verify your account at IhuntBest & password.";
        $this->sendEmails($email, $body, $subject);
        $admin = $this->db->get("web_users");
        if ($admin->num_rows() > 0) {
            $rowData = $admin->row();
            $userEmail = $rowData->userEmail;
            $subject = 'A new registration in Ihuntbest.';
            $body = 'A new user is registered with Email = ' . $email . ', Name = ' . $orgname . ',and  Account type=Student at ' . $this->datetimenow();
            $this->sendEmails($userEmail, $body, $subject);
        }
    }

    private function addActivityLog($user_id, $activity, $act_table, $isadmin, $role_name) {
        $idata = ["user_id" => $user_id, "activity" => $activity, "act_table" => $act_table, "date" => date('Y-m-d'), "isadmin" => 0,
            "role_name" => $role_name, "created_at" => $this->datetimenow(), "ip_address" => $this->getRealIpAddr(), "isactive" => 1];
        $this->db->insert("activity_log", $idata);
    }

    public function datetimenow() {
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $todaydate = $date->format('Y-m-d H:i:sA');
        return $todaydate;
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
