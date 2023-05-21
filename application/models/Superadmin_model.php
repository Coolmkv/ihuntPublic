<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
    }

    public function mSuperAdminLogin() {
        $email = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_EMAIL);
        $password = FILTER_VAR(trim($this->input->post('password')), FILTER_SANITIZE_STRING);
        $chkQry = $this->db->query("SELECT * FROM web_users WHERE userEmail='" . $email . "'");
        if ($chkQry->num_rows() > 0) {
            $sdata = $chkQry->row();
            $pwd2 = $this->encryption->decrypt($sdata->userPassword);
            
              
            $pwd1 = $sdata->userPassword1;
            if ($password == $pwd2 && $pwd1 == $password) {
                $_SESSION = ["id" => $sdata->id, "name" => $sdata->userName, "email" => $sdata->userEmail, "user_type" => $sdata->userType];

                $this->addActivityLog($sdata->id, "Logged in successfully", "web_users");
                return '{"status":"success","msg":"Login Successfully"}';
            } else {
                $this->addActivityLog($sdata->id, "Incorrect Password login failed", "web_users");
                return json_encode([
                    "status"=>"error",
                    "msg"=>"Incorrect Password"]);
                    
            }
        } else {
            return '{"status":"error","msg":"Incorrect Email Id"}';
        }
    }

    public function mGetTotals() {
        return $this->db->query("SELECT (SELECT COUNT(DISTINCT od.loginId) FROM login_details as ld INNER JOIN organization_details as od ON od.loginId=ld.id WHERE ld.roleName='College' and ld.isactive=1) totalcolleges,
                (SELECT COUNT(DISTINCT ld.id) FROM login_details as ld INNER JOIN organization_details as od ON od.loginId=ld.id WHERE ld.roleName='University' and ld.isactive=1) totaluniversities,
                (SELECT COUNT(DISTINCT ld.id) FROM login_details as ld INNER JOIN organization_details as od ON od.loginId=ld.id WHERE ld.roleName='Institute' and ld.isactive=1) totalInstitutes,
                (SELECT COUNT(DISTINCT ld.id) FROM login_details as ld INNER JOIN organization_details as od ON od.loginId=ld.id WHERE ld.roleName='School' and ld.isactive=1) totalSchools,
                (SELECT COUNT(sd.studentId) FROM student_login as sd INNER JOIN student_details as std ON std.studentId=sd.studentId) AS totalstudents,
                (SELECT COUNT(*) FROM facilities WHERE facility_status='1') AS pendingfacilities,(SELECT COUNT(*) FROM facilities WHERE facility_status='2') AS approvedfacilities,
                (SELECT COUNT(*) FROM course_type WHERE isactive=1) totalcourseTypes,(SELECT COUNT(*) FROM institute_course WHERE isactive=1) totalinstitute,
                (SELECT COUNT(*) FROM time_duration WHERE isactive=1) totaltimedrtn,(SELECT COUNT(*) FROM school_class_type WHERE isactive=1) totalsctype,
                (SELECT COUNT(*) FROM course_min_qualification WHERE isactive=1) totalminqual,(SELECT COUNT(*) FROM facilities  WHERE isactive=1) totalfacilies,
                (SELECT COUNT(*) FROM facilities as fs INNER JOIN facility_request as fr ON fr.facilityId=fs.facilityId INNER JOIN organization_details as od ON od.loginId=fr.orgId WHERE facility_status!='0') totalreqfacilies,
                (SELECT COUNT(*) FROM facilities as fs INNER JOIN facility_request as fr ON fr.facilityId=fs.facilityId INNER JOIN organization_details as od ON od.loginId=fr.orgId WHERE facility_status='2' ) totalaprfacilies,
                (SELECT COUNT(*) FROM  facilities as fs INNER JOIN facility_request as fr ON fr.facilityId=fs.facilityId INNER JOIN organization_details as od ON od.loginId=fr.orgId WHERE facility_status='1') totalrejfacilies,
                (SELECT COUNT(*) FROM student_login WHERE isactive=1) totalshowdetails,(SELECT COUNT(*) FROM countries WHERE isactive=1) totalCountries,(SELECT COUNT(*) FROM states WHERE isactive=1) totalstates,
                (SELECT COUNT(*) FROM cities WHERE isactive=1) totalcities,(SELECT COUNT(*) FROM login_details WHERE isactive=1) totalregistration,(SELECT COUNT(*) FROM advertisement_plan WHERE isactive=1) advertisement_plan,
                (SELECT COUNT(*) FROM tbl_competitive_exam_master WHERE isactive=1) competitiveExam,(SELECT COUNT(*) FROM tbl_teammembers WHERE isactive=1) teamMembers,(SELECT COUNT(*) FROM tbl_careersopening WHERE isactive=1) Careers,
                (SELECT COUNT(*) FROM tbl_ihuntjobapplication WHERE isactive=1) jobApplications,(SELECT COUNT(*) FROM tbl_earn_n_share_value where isactive=1) ensvalue,(SELECT COUNT(*) FROM student_login tsl1 INNER JOIN tbl_earn_n_share_value ens on ens.ens_value_id=tsl1.ens_value_id  WHERE tsl1.isactive=1) ensUservalue,
                (SELECT COUNT(*) FROM tbl_totalvisitor where isactive=1) totalVisitor,(SELECT COUNT(*) FROM tbl_website_visitor where isactive=1) webVisitor,(SELECT COUNT(*) FROM tbl_news_ltr_plan where isactive=1) nlPlan,
                (SELECT COUNT(*) FROM tbl_news_ltr_plan_buy where isactive=1) nlPlanBuy,(SELECT COUNT(*) FROM tbl_faq where isactive=1) FaqTotal, (SELECT COUNT(*) FROM tbl_faq_category where isactive=1) FAQCategory");
    }

    public function mchangePasswordSave() {
        $oldpass = FILTER_VAR(trim($this->input->post('current_password')), FILTER_SANITIZE_STRING);
        $newpass = FILTER_VAR(trim($this->input->post('new_password')), FILTER_SANITIZE_STRING);
        $cnewpas = FILTER_VAR(trim($this->input->post('confirm_password')), FILTER_SANITIZE_STRING);

        $details = $this->db->where(["id" => $_SESSION['id']])->get("web_users");
        if ($newpass !== $cnewpas) {
            return '{"status":"error", "msg":"Confirm Password and New Password not same."}';
        }
        if ($details->num_rows() > 0) {
            $data = $details->row();
            $currpass = $this->encryption->decrypt($data->userPassword);
            if ($currpass !== $oldpass && $oldpass !== $data->userPassword1) {
                return '{"status":"error", "msg":"Old password is wrong."}';
            } else {
                $uData = ["userPassword1" => $cnewpas, "userPassword" => $this->encryption->encrypt($newpass), "modifiedAt" => $this->datetimenow()];
                $res = $this->db->where(["id" => $_SESSION['id']])->update("web_users", $uData);
                ($res ? $this->addActivityLog($_SESSION['id'], "Password Changed", "web_users") : "");
                return($res ? '{"status":"success", "msg":"Change Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            }
        }
    }

//Activity Log Start
    public function mGetActivitylog($startDate, $endDate, $user_type, $order, $dir, $search, $length, $start) {

        $limit = "LIMIT $start,$length";
        $sdate = ($startDate != "" ? " AND al.date>='" . $startDate . "'" : "");
        $edate = ($startDate != "" ? " AND al.date<='" . $endDate . "'" : "");
        $totalDataqry = $this->getCountactivityLog("AllUsers", "", "", "");
        $totalData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->num_rows() : 0);
        $query = $this->activityLogQuery("alldata", $user_type, $edate, $sdate, $order, $dir, $search, $limit);
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $queryfd = (!empty($search) || !empty($sdate) || !empty($edate) ? $this->getCountactivityLog($user_type, $edate, $sdate, $search) : "");
        $totalFiltered = ($queryfd != "" ? $queryfd->num_rows() : $totalData);
        $data = array();
        if (!empty($posts)) {
            $i = ($start == 0 ? 1 : $start);
            foreach ($posts as $post) {

                $data[] = ["serialNumber" => $i++, "avtivityDetails" => '<div class="alert alert-dismissable coloractivitylog" >
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' . $post->orgName . '</strong><br/>Activity ' . $post->activity . '<br/> <i class="fa fa-clock-o"></i> ' . $post->createddate . '</div>'];
            }
        }

        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }

    private function getCountactivityLog($user_type, $edate, $sdate, $search) {
        $condition = ($search != "" ? "AND  (al.id LIKE '%$search%' OR al.user_id LIKE '%$search%' OR al.activity LIKE '%$search%' OR al.created_at LIKE '%$search%')" : "");
        if ($user_type === "AllUsers") {
            return $this->db->query("SELECT al.id  FROM activity_log al
                INNER JOIN login_details ld ON ld.id=al.user_id AND ld.isactive=1
                INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                WHERE al.isactive=1 $edate $sdate $condition");
        } elseif ($user_type === "Superadmin") {
            return $this->db->query("SELECT al.id  FROM activity_log al
                INNER JOIN web_users wu ON wu.id=al.user_id
                WHERE al.isadmin=1 $edate $sdate $condition");
        } else {
            return $this->db->query("SELECT al.id  FROM activity_log al
            INNER JOIN login_details ld ON ld.id=al.user_id AND ld.isactive=1
            INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
            WHERE al.isadmin=0 AND ld.roleName='" . $user_type . "' $edate $sdate $condition");
        }
    }

    private function activityLogQuery($type, $user_type, $edate, $sdate, $order, $dir, $search, $limit) {
        $condition = ($search != "" ? "AND  (al.id LIKE '%$search%' OR al.user_id LIKE '%$search%' OR al.activity LIKE '%$search%' OR al.created_at LIKE '%$search%')" : "");
        if ($type == "totalCount") {
            return $this->db->query("SELECT  al.id FROM activity_log al
                INNER JOIN login_details ld ON ld.id=al.user_id AND ld.isactive=1                INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                WHERE al.isadmin=0 AND ld.roleName='" . $user_type . "' $edate $sdate $condition ");
        }
        if ($user_type === "AllUsers") {
            return $this->db->query("SELECT al.id,al.user_id,al.activity,al.ip_address,DATE_FORMAT(al.created_at,'%d-%b-%y %r') AS createddate,
                                                    od.orgName,od.orgMobile,od.orgAddress,od.orgType FROM activity_log al    INNER JOIN login_details ld ON ld.id=al.user_id AND ld.isactive=1
                                                    INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1  WHERE al.isactive=1 $edate $sdate $condition $order $dir $limit");
        } elseif ($user_type === "Superadmin") {
            return $this->db->query("SELECT al.id,al.user_id,al.activity,al.ip_address,DATE_FORMAT(al.created_at,'%d-%b-%y %r') AS createddate,
                                                wu.userName as orgName,wu.userMobile FROM activity_log al
                                                INNER JOIN web_users wu ON wu.id=al.user_id   WHERE al.isadmin=1 $edate $sdate $condition $order $dir $limit");
        } else {
            return $this->db->query("SELECT al.id,al.user_id,al.activity,al.ip_address,DATE_FORMAT(al.created_at,'%d-%b-%y %r') AS createddate,
                                                    od.orgName,od.orgMobile,od.orgAddress,od.orgType FROM activity_log al
                                                    INNER JOIN login_details ld ON ld.id=al.user_id AND ld.isactive=1   INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                                                    WHERE al.isadmin=0 AND ld.roleName='" . $user_type . "' $edate $sdate $condition  $order $dir $limit");
        }
    }

//Activity Log End
//profile start
    public function mgetProfileDetails() {
        $this->db->where("id", $_SESSION['id']);
        $details = $this->db->get("web_users");
        if ($details->num_rows() > 0) {
            return $details->row();
        } else {
            return false;
        }
    }

    public function mSaveProfile() {
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $userName = FILTER_VAR(trim($this->input->post('userName')), FILTER_SANITIZE_STRING);
        $userMobile = FILTER_VAR(trim($this->input->post('userMobile')), FILTER_SANITIZE_NUMBER_INT);
        $userEmail = FILTER_VAR(trim($this->input->post('userEmail')), FILTER_SANITIZE_EMAIL);
        $website_email_id = FILTER_VAR(trim($this->input->post('website_email_id')), FILTER_SANITIZE_EMAIL);
        $userPassword1 = FILTER_VAR(trim($this->input->post('userPassword1')), FILTER_SANITIZE_STRING);
        $privacypolicy = $this->input->post('privacypolicy');
        if (empty($id) || empty($userName) || empty($userMobile) || empty($userEmail) || empty($website_email_id) || empty($userPassword1)) {
            return '{"status":"error","msg":"Required field is empty"}';
        }
        if ($id !== "no_data") {
            return $this->updateSuperadminprofile($id, $userName, $userMobile, $userEmail, $website_email_id, $userPassword1, $privacypolicy);
        } else {
            return '{"status":"error","msg":"Id not available"}';
        }
    }

    private function updateSuperadminprofile($id, $userName, $userMobile, $userEmail, $website_email_id, $userPassword1, $privacypolicy) {
        $encpass = $this->encryption->encrypt($userPassword1);
        $uData = ["userName" => $userName, "userMobile" => $userMobile, "userEmail" => $userEmail, "website_email_id" => $website_email_id,
            "userPassword" => $encpass, "userPassword1" => $userPassword1, "privacypolicy" => $privacypolicy, "modifiedAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr()];

        $res = $this->db->where("id", $id)->update("web_users", $uData);
        if ($res) {
            $this->addActivityLog($_SESSION['id'], "Superadmin Details updated", "web_users");
            return '{"status":"success","msg":"Saved Successfully."}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mSaveFinancialDetails() {
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $ccardno = FILTER_VAR(trim($this->input->post('credit_card_no')), FILTER_SANITIZE_STRING);
        $cccvvno = FILTER_VAR(trim($this->input->post('creditcard_cvv')), FILTER_SANITIZE_STRING);
        $ccvalidity = FILTER_VAR(trim($this->input->post('creditcard_validity')), FILTER_SANITIZE_STRING);
        $dcardno = FILTER_VAR(trim($this->input->post('debit_card_no')), FILTER_SANITIZE_STRING);
        $dcardcvv = FILTER_VAR(trim($this->input->post('debitcard_cvv')), FILTER_SANITIZE_STRING);
        $dcvalidity = FILTER_VAR(trim($this->input->post('debitcard_valid')), FILTER_SANITIZE_STRING);
        $bank_name = FILTER_VAR(trim($this->input->post('bank_name')), FILTER_SANITIZE_STRING);
        $baddress = FILTER_VAR(trim($this->input->post('bankaddress')), FILTER_SANITIZE_STRING);
        $accno = FILTER_VAR(trim($this->input->post('bank_account_no')), FILTER_SANITIZE_STRING);
        $ifscc = FILTER_VAR(trim($this->input->post('ifscCode')), FILTER_SANITIZE_STRING);
        $micrc = FILTER_VAR(trim($this->input->post('micr_code')), FILTER_SANITIZE_STRING);
        $account_holder_name = FILTER_VAR(trim($this->input->post('account_holder_name')), FILTER_SANITIZE_STRING);
        if (empty($bank_name) || empty($account_holder_name) || empty($baddress) || empty($accno) || empty($ifscc)) {
            return '{"status":"error","msg":"Required field is empty"}';
        }
        return ($id == "no_data" ? $this->insertFinancialDetails($ccardno, $cccvvno, $ccvalidity, $dcardno, $dcardcvv, $dcvalidity, $bank_name, $baddress, $accno, $ifscc, $micrc, $account_holder_name) :
                $this->upDateFinancialDetails($id, $ccardno, $cccvvno, $ccvalidity, $dcardno, $dcardcvv, $dcvalidity, $bank_name, $baddress, $accno, $ifscc, $micrc, $account_holder_name));
    }

    public function insertFinancialDetails($ccardno, $cccvvno, $ccvalidity, $dcardno, $dcardcvv, $dcvalidity, $bank_name, $baddress, $accno, $ifscc, $micrc, $account_holder_name) {
        $this->db->where(["login_id" => $_SESSION['id'], "user_type" => "Superadmin"]);
        $details = $this->db->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            $data = $details->row();
            $id = $data->financial_detail_id;
            $this->upDateFinancialDetails($id, $ccardno, $cccvvno, $ccvalidity, $dcardno, $dcardcvv, $dcvalidity, $bank_name, $baddress, $accno, $ifscc, $micrc, $account_holder_name);
        } else {
            $ccardno = ( $ccardno === "" ? null : $this->encryption->encrypt($ccardno) );
            $cccvvno = ( $cccvvno === "" ? null : $this->encryption->encrypt(cccvvno) );
            $dcardno = ($dcardno === "" ? null : $this->encryption->encrypt($dcardno) );
            $dcardcvv = ($dcardcvv === "" ? null : $this->encryption->encrypt($dcardcvv));
            $accno = ($accno === "" ? null : $this->encryption->encrypt($accno));
            $idata = ["credit_card_no" => $ccardno, "creditcard_cvv" => $cccvvno, "creditcard_validity" => $ccvalidity, "debit_card_no" => $dcardno,
                "debitcard_cvv" => $dcardcvv, "debitcard_validity" => $dcvalidity, "bank_name" => $bank_name, "bankaddress" => $baddress,
                "bank_account_no" => $accno, "account_holder_name" => $account_holder_name, "ifscCode" => $ifscc, "micr_code" => $micrc, "login_id" => $_SESSION['id'],
                "user_type" => "Superadmin", "ip_address" => $this->getRealIpAddr(), "created_on" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->insert("tbl_financial_details", $idata);
        }
        ($resp ? $this->addActivityLog($_SESSION['id'], "Finance Detail Inserted for admin", "tbl_financial_details") : "");
        return ($resp ? '{"status":"success","msg":"Inserted Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function upDateFinancialDetails($id, $ccardno, $cccvvno, $ccvalidity, $dcardno, $dcardcvv, $dcvalidity, $bank_name, $baddress, $accno, $ifscc, $micrc, $account_holder_name) {

        $details = $this->db->where(["financial_detail_id!=" => $id, "login_id" => $_SESSION['id'], "user_type" => "Superadmin"])->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate details"}';
        } else {
            $ccardno = ( $ccardno === "" ? null : $this->encryption->encrypt($ccardno) );
            $cccvvno = ( $cccvvno === "" ? null : $this->encryption->encrypt($cccvvno) );
            $dcardno = ( $dcardno === "" ? null : $this->encryption->encrypt($dcardno) );
            $dcardcvv = ( $dcardcvv === "" ? null : $this->encryption->encrypt($dcardcvv) );
            $accno = ( $accno === "" ? null : $this->encryption->encrypt($accno));
            $idata = ["credit_card_no" => $ccardno, "creditcard_cvv" => $cccvvno, "creditcard_validity" => $ccvalidity, "debit_card_no" => $dcardno,
                "debitcard_cvv" => $dcardcvv, "debitcard_validity" => $dcvalidity, "bank_name" => $bank_name, "bankaddress" => $baddress,
                "bank_account_no" => $accno, "account_holder_name" => $account_holder_name, "ifscCode" => $ifscc, "micr_code" => $micrc,
                "login_id" => $_SESSION['id'], "user_type" => "Superadmin", "ip_address" => $this->getRealIpAddr(), "updated_on" => $this->datetimenow()];

            $resp = $this->db->where("financial_detail_id", $id)->update("tbl_financial_details", $idata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Finance Detail Updated for admin", "tbl_financial_details") : "");
            return ($resp ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//profile end
    public function mGetUnivCourseType() {
        $condition = "isactive=1";
        $id = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if ($id) {
            $ctId = base64_decode($id);
            $condition = "ctId=$ctId AND isactive=1";
        }
        $query = $this->db->query("Select * from course_type where " . $condition . " ");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rd) {
                $rd->ctId = base64_encode($rd->ctId);
            }
            return json_encode($query->result());
        }
    }

    public function mGetcourse_details() {
        $ctId = FILTER_VAR(trim($this->input->post('ctId')), FILTER_SANITIZE_STRING);
        $cId = FILTER_VAR(trim($this->input->post('cId')), FILTER_SANITIZE_STRING);
        if (!empty($ctId)) {

            $condition = "AND ctId=" . base64_decode($ctId) . "";
        } else {
            $condition = "";
        }
        if (!empty($cId)) {
            $condition1 = "AND cId=" . base64_decode($cId) . "";
        } else {
            $condition1 = "";
        }
        $data = $this->db->query("SELECT * FROM course_details where  isactive=1 $condition $condition1  ORDER BY cId ASC");
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $cd) {
                $cd->ctId = base64_encode($cd->ctId);
                $cd->cId = base64_encode($cd->cId);
            }
        }
        return json_encode($data->result());
    }

    public function mDelCoursedetails() {
        $cId = FILTER_VAR(trim($this->input->post('cId')), FILTER_SANITIZE_STRING);
        if (empty($cId)) {
            return '{"status":"error","msg":"Empty Id"}';
        } else {
            $this->db->where(["cId" => base64_decode($cId), "isactive" => 1]);
            $chk = $this->db->get("course_details");
            if ($chk->num_rows() > 0) {
                $uData = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
                $this->db->where("cId", base64_decode($cId));
                $res = $this->db->update("course_details", $uData);
            } else {
                $res = "";
            }
            if ($res) {
                $this->addActivityLog($_SESSION['id'], "Course Detail deleted", "course_details");
                return '{"status":"success","msg":"Deleted Successfully."}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mAddCourseType() {
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $timenow = $this->datetimenow();
        $chk = $this->chkCourseType($title, $id);
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($id == 'no_one') {
                $data = ["courseType" => $title, "createdAt" => $timenow, "isactive" => 1];
                $response = $this->db->insert("course_type", $data);
                $this->addActivityLog($_SESSION['id'], "Course Type Inserted", "course_type");
            } else {
                $ctId = base64_decode($id);
                $data = ["courseType" => $title, "updatedAt" => $timenow];
                $response = $this->db->where("ctId", $ctId)->update("course_type", $data);
                $this->addActivityLog($_SESSION['id'], "Course Type updated", "course_type");
            }
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}' );
        }
    }

    public function chkCourseType($title, $id) {
        if ($id == 'no_one') {
            $chk = $this->db->query("Select * from course_type where isactive=1 and courseType='" . $title . "'");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        } else {
            $ctId = base64_decode($id);
            $chk = $this->db->query("Select * from course_type where isactive=1 and courseType='" . $title . "' AND ctId!=" . $ctId . "");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        }
    }

    public function mDelCourseType($id) {
        $chkQry = $this->db->query("Select * from course_type where isactive=1 and ctId=$id");
        if ($chkQry->num_rows() > 0) {
            $data = ["isactive" => 0];
            $response = $this->db->where("ctId", $id)->update("course_type", $data);
            if ($response) {
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mAddCourse() {
        $ctId = FILTER_VAR(trim($this->input->post('ctId')), FILTER_SANITIZE_STRING);
        $cId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        if (empty($title)) {
            return '{"status":"error","msg":"Empty Details!"}';
        }
        $condition = ($cId === "no_one" ? ["title" => $title, "isactive" => 1] : ["title" => $title, "cId!=" => base64_decode($cId), "isactive" => 1]);
        $chk = $this->db->where($condition)->get("course_details");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details!"}';
        } else {
            $this->insertUpdateCourse($cId, $ctId, $title);
        }
    }

    private function insertUpdateCourse($cId, $ctId, $title) {

        if ($cId === "no_one") {
            $iData = ["ctId" => base64_decode($ctId), "title" => $title, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("course_details", $iData);
            ($res ? $this->addActivityLog($_SESSION['id'], "Course Detail Inserteds", "course_details") : "");
        } else {
            $uData = ["title" => $title, "updatedAt" => $this->datetimenow()];
            $res = $this->db->where("cId", base64_decode($cId))->update("course_details", $uData);
            ($res ? $this->addActivityLog($_SESSION['id'], "Course Detail updated", "course_details") : "");
        }
        return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetStream_details() {
        $cId = FILTER_VAR(trim($this->input->post('cId')), FILTER_SANITIZE_STRING);
        $streamId = FILTER_VAR(trim($this->input->post('streamId')), FILTER_SANITIZE_STRING);
        if (!empty($cId)) {
            $cID = base64_decode($cId);
            $condition = " AND cId=$cID";
        } elseif (!empty($streamId)) {
            $condition = " AND streamId=" . base64_decode($streamId) . "";
        } else {
            $condition = "";
        }
        $data = $this->db->query("SELECT * FROM stream_details WHERE isactive=1 $condition");
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $dt) {
                $dt->streamId = base64_encode($dt->streamId);
                $dt->cId = base64_encode($dt->cId);
            }
        }
        return json_encode($data->result());
    }

    public function mDeleteStream() {
        $streamId = FILTER_VAR(trim($this->input->post('streamId')), FILTER_SANITIZE_STRING);
        if (empty($streamId)) {
            return '{"status":"error","msg":"Empty Detail !"}';
        }
        $this->db->where(["streamId" => base64_decode($streamId), "isactive" => 1]);
        $chk = $this->db->get("stream_details");
        if ($chk->num_rows() > 0) {
            $dData = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $this->db->where("streamId", base64_decode($streamId));
            $res = $this->db->update("stream_details", $dData);
            if ($res) {
                $this->addActivityLog($_SESSION['id'], "Stream Detail Deleted", "stream_details");
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function maddStream($cId, $streamId, $title) {
        if (empty($title)) {
            return '{"status":"error","msg":"Empty Details!"}';
        }
        $condition = ($streamId === "no_one" ? ["title" => $title, "cId" => $cId, "isactive" => 1] : ["title" => $title, "streamId!=" => base64_decode($streamId), "cId" => $cId, "isactive" => 1]);
        $chk = $this->db->where($condition)->get("stream_details");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details!"}';
        } else {
            if ($streamId === "no_one") {
                $iData = ["cId" => base64_decode($cId), "title" => $title, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->insert("stream_details", $iData);
            } else {
                $uData = ["title" => $title, "updatedAt" => $this->datetimenow()];
                $res = $this->db->where("streamId", base64_decode($streamId))->update("stream_details", $uData);
            }
            ($streamId === "no_one" ? $this->addActivityLog($_SESSION['id'], "Stream Detail Inserted", "stream_details") : $this->addActivityLog($_SESSION['id'], "Stream Detail updated", "stream_details"));
            return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mGetInstCourseType() {
        $condition = "isactive=1";
        $id = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if ($id) {
            $condition = "insCourseId=$id AND isactive=1";
        }

        return $this->db->query("Select * from institute_course where " . $condition . " ");
    }

    public function mAddInstCourseType() {
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $timenow = $this->datetimenow();
        $chk = $this->chkInstCourseType($title, $id);
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($id == 'no_one') {
                $data = ["title" => $title, "createdAt" => $timenow, "isactive" => 1];
                $response = $this->db->insert("institute_course", $data);
            } else {
                $data = ["title" => $title, "updatedAt" => $timenow];
                $this->db->where("insCourseId", $id);
                $response = $this->db->update("institute_course", $data);
            }
            ($id == 'no_one' ? ($response ? $this->addActivityLog($_SESSION['id'], "Institute Course Inserted", "institute_course") : "") :
                            ($response ? $this->addActivityLog($_SESSION['id'], "Institute Course Updated", "institute_course") : ""));
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function chkInstCourseType($title, $id) {
        if ($id == 'no_one') {
            $chk = $this->db->query("Select * from institute_course where isactive=1 and title='" . $title . "'");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        } else {
            $chk = $this->db->query("Select * from institute_course where isactive=1 and title='" . $title . "' AND insCourseId!=" . $id . "");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        }
    }

    public function mDelInstCourseType($id) {
        $chkQry = $this->db->query("Select * from institute_course where isactive=1 and insCourseId=$id");
        if ($chkQry->num_rows() > 0) {
            $data = ["isactive" => 0];
            $this->db->where("insCourseId", $id);
            $response = $this->db->update("institute_course", $data);
            $this->addActivityLog($_SESSION['id'], "Institute Course Deleted", "institute_course");
            if ($response) {
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

//time Duration Master
    public function mGetTimeDuration() {
        $condition = "isactive=1";
        $id = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if ($id) {
            $condition = "tdId =$id AND isactive=1";
        }

        return $this->db->query("SELECT * FROM time_duration WHERE  " . $condition . " ");
    }

    public function mAddTimeDuration() {
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $timenow = $this->datetimenow();
        $chk = $this->chkTimeDuration($title, $id);
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($id == 'no_one') {
                $data = ["title" => $title, "createdAt" => $timenow, "isactive" => 1];
                $response = $this->db->insert("time_duration", $data);
                $this->addActivityLog($_SESSION['id'], "Time Duration Inserted", "time_duration");
            } else {
                $data = ["title" => $title, "updatedAt" => $timenow];
                $response = $this->db->where("tdId", $id)->update("time_duration", $data);
                $this->addActivityLog($_SESSION['id'], "Time Duration Updated", "time_duration");
            }
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function chkTimeDuration($title, $id) {
        if ($id == 'no_one') {
            $chk = $this->db->query("Select * from time_duration where isactive=1 and title='" . $title . "'");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        } else {
            $chk = $this->db->query("Select * from time_duration where isactive=1 and title='" . $title . "' AND tdId!=" . $id . "");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        }
    }

    public function mDelTimeDuration($id) {
        $timenow = $this->datetimenow();
        $chkQry = $this->db->query("Select * from time_duration where isactive=1 and tdId=$id");
        if ($chkQry->num_rows() > 0) {
            $data = ["updatedAt" => $timenow, "isactive" => 0];
            $this->db->where("tdId", $id);
            $response = $this->db->update("time_d uration", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "Time Duration Deleted", "time_duration");
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

//School Class Type
    public function mAddSchoolClassType() {
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $classdetails = FILTER_VAR(trim($this->input->post('class')), FILTER_SANITIZE_STRING);
        $classdetailsarr = explode("^", $classdetails);
        $classnamesId = $classdetailsarr[0];
        $class = $classdetailsarr[1];
        $chk = $this->chkSchoolClassType($title, $id, $class, $classnamesId);
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($id == 'no_one') {
                $data = ["class" => $class, "classnamesId" => $classnamesId, "title" => $title, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $response = $this->db->insert("school_class_type", $data);
            } else {
                $data = ["class" => $class, "classnamesId" => $classnamesId, "title" => $title, "updatedAt" => $this->datetimenow()];
                $response = $this->db->where("classTypeId", $id)->update("school_class_type", $data);
            }
            ($response ? $this->addActivityLog($_SESSION['id'], "School Class Type " . ($id == 'no_one' ? "Inserted" : "Updated") . "", "school_class_type") : "");
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function chkSchoolClassType($title, $id, $class, $classnamesId) {
        if ($id == 'no_one') {
            $chk = $this->db->query("Select * from school_class_type where isactive=1 and classnamesId=" . $classnamesId . " AND class='" . $class . "' and title='" . $title . "'");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        } else {
            $chk = $this->db->query("Select * from school_class_type where isactive=1 and classnamesId=" . $classnamesId . " AND class='" . $class . "' and title='" . $title . "' AND classTypeId!=" . $id . "");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        }
    }

    public function mGetSchoolClassType() {
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);

        $condition = ($id ? "classTypeId =$id AND isactive=1" : "isactive=1");

        $qry = $this->db->query("SELECT * FROM school_class_type WHERE  " . $condition . " ");
        return ($qry->num_rows() > 0 ? json_encode($qry->result()) : json_encode(""));
    }

    public function mdelSchoolClassType($id) {
        $timenow = $this->datetimenow();
        $chkQry = $this->db->query("Select * from school_class_type where isactive=1 and classTypeId=$id");
        if ($chkQry->num_rows() > 0) {
            $data = ["updatedAt" => $timenow, "isactive" => 0];
            $this->db->where("classTypeId", $id);
            $response = $this->db->update("school_class_type", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "School Class Type Deleted", "school_class_type");
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

//minQualification
    public function mAddMinQualification() {
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $timenow = $this->datetimenow();
        $chk = $this->chkMinQualificationType($title, $id);
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($id == 'no_one') {
                $data = ["title" => $title, "createdAt" => $timenow, "isactive" => 1];
                $response = $this->db->insert("course_min_qualification", $data);
                $this->addActivityLog($_SESSION['id'], "Course Min Qualification Inserted", "course_min_qualification");
            } else {
                $data = ["title" => $title, "updatedAt" => $timenow];
                $this->db->where("courseMinQualId", $id);
                $response = $this->db->update("course_min_qualification", $data);
                $this->addActivityLog($_SESSION['id'], "Course Min Qualification Updated", "course_min_qualification");
            }
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function chkMinQualificationType($title, $id) {
        if ($id == 'no_one') {
            $chk = $this->db->query("Select * from course_min_qualification where isactive=1 and title='" . $title . "'");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        } else {
            $chk = $this->db->query("Select * from course_min_qualification where isactive=1 and title='" . $title . "' AND courseMinQualId!=" . $id . "");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        }
    }

    public function mGetMinQalification() {
        $condition = "isactive=1";
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        if ($id) {
            $condition = "courseMinQualId =$id AND isactive=1";
        }
        $query = $this->db->query("SELECT * FROM course_min_qualification WHERE  " . $condition . " ");
        if ($query->num_rows() > 0) {
            $return = $query->result();
        } else {
            $return = "";
        }
        return json_encode($return);
    }

    public function mdelMinQalification($id) {
        $timenow = $this->datetimenow();
        $chkQry = $this->db->query("Select * from course_min_qualification where isactive=1 and courseMinQualId=$id");
        if ($chkQry->num_rows() > 0) {
            $data = ["updatedAt" => $timenow, "isactive" => 0];
            $this->db->where("courseMinQualId", $id);
            $response = $this->db->update("course_min_qualification", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "Course Min Qualification Deleted", "course_min_qualification");
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mGetUniversityDetails() {
        $query = $this->db->query("SELECT ld.password,ld.id,'' profileStatus,od.webLinkStartus,od.orgId,od.orgId orgIdc,od.orgLatestStatus,od.orgFeatureStatus,ld.verifyStatus,ld.admin_approved,
                                    ld.email,od.orgName,od.orgMobile,od.orgAddress,ld.loginStatus,ld.org_status,od.orgTopRated,od.orgButtonType
                                    FROM login_details as ld
                                    INNER JOIN organization_details as od ON od.loginId=ld.id AND od.isactive=1
                                    WHERE ld.isactive=1 AND ld.roleName='University' order by od.loginId desc");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $ud) {
                $ud->orgIdc = base64_encode($ud->orgIdc);
                $ud->profileStatus = $this->profileCompletion($ud->id);
            }
            return json_encode($query->result());
        } else {
            return json_encode("");
        }
    }

    private function profileCompletion($id) {
        $this->db->where(['loginId' => $id, "isactive" => 1]);
        $qry = $this->db->get('organization_details');
        if ($qry->num_rows() > 0) {
            $arr = $qry->row();
            $total = sizeof((array) $arr);
            $filtera = array_filter((array) $arr);
            $filled = sizeof((array) $filtera);
            return round(($filled / $total) * 100);
        } else {
            return "";
        }
    }

    public function mUpdateOrgBtnType($btntype) {
        $id = FILTER_VAR(trim($this->input->post('loginId')), FILTER_SANITIZE_NUMBER_INT);
        $chk = $this->db->where(["loginId" => $id, "isactive" => 1])->get("organization_details");
        $roleType = FILTER_VAR(trim($this->input->post('roleType')), FILTER_SANITIZE_STRING);
        if ($chk->num_rows() > 0) {
            $rdata = $chk->row();
            $orgName = $rdata->orgName;
            $resp = $this->db->where(["loginId" => $id, "isactive" => 1])->update("organization_details", ["orgButtonType" => $btntype]);
            ($resp ? $this->addActivityLog($_SESSION['id'], "" . $orgName . " ($roleType)  button has been updated for " . $btntype . "", "organization_details") : "" );
            return ($resp ? '{"status":"success","msg":"Button Updated Successfully to ' . $btntype . '!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            return '{"status":"error","msg":"Details not found!"}';
        }
    }

    public function mUpOrgApprovalStatus() {
        $id = FILTER_VAR(trim($this->input->post('loginId')), FILTER_SANITIZE_NUMBER_INT);
        $admin_approved = FILTER_VAR(trim($this->input->post('admin_approved')), FILTER_SANITIZE_NUMBER_INT);
        $roleType = FILTER_VAR(trim($this->input->post('roleType')), FILTER_SANITIZE_STRING);
        if ($admin_approved == 1) {
            $admin_approved = 0;
        } else {
            $admin_approved = 1;
        }
        $chk = $this->db->query("SELECT * FROM login_details ld
                        LEFT JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                        WHERE ld.id=$id AND ld.roleName='$roleType' AND ld.isactive=1");
        if ($chk->num_rows() > 0) {
            $udata = ["admin_approved" => $admin_approved, "approval_date" => $this->datetimenow()];
            $this->db->where(["id" => $id, "roleName" => $roleType]);
            $resp = $this->db->update("login_details", $udata);
            $rdata = $chk->row();
            $orgName = $rdata->orgName;
        }
        ($resp ? $this->addActivityLog($_SESSION['id'], "Login Details Approval Status Updated For " . $orgName . "", "login_details") : "" );
        return ($resp ? '{"status":"success","msg":"Approval Status Updated Successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mUpDateOrgDetailsLoginStatus() {
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_NUMBER_INT);
        $login_status = FILTER_VAR(trim($this->input->post('login_status')), FILTER_SANITIZE_STRING);
        $roletype = FILTER_VAR(trim($this->input->post('roletype')), FILTER_SANITIZE_STRING);
        if ($login_status == "0" || $login_status == "1") {
            return $this->updateLoginStatus($id, $login_status, $roletype);
        } else {
            return $this->updateOrg_status($id, $login_status, $roletype);
        }
    }

    private function updateOrg_status($id, $login_status, $roletype) {
        $this->db->where(["roleName" => $roletype, "isactive" => "1", "id" => $id]);
        $chkData = $this->db->get("login_details");


        if ($chkData->num_rows() > 0) {
            $data = ["org_status" => $login_status, "updatedAt" => $this->datetimenow()];
            $result = $this->db->where("id", $id)->update("login_details", $data);
            if ($result) {
                $data1 = ["loginStatus" => "1", "updatedAt" => $this->datetimenow()];
                $this->db->where(["id" => $id, "roleName" => $roletype])->update("login_details", $data1);
                $this->addActivityLog($_SESSION['id'], "Login Details Login Status Updated", "login_details");
                return '{"status":"success","msg":"Login Status Updated Successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    private function updateLoginStatus($id, $login_status, $roletype) {
        $chkQuery = $this->db->query("SELECT * FROM login_details where id='$id' AND roleName='$roletype' AND isactive=1");
        if ($chkQuery->num_rows() > 0) {
            $data = ["loginStatus" => $login_status, "updatedAt" => $this->datetimenow()];
            $this->db->where(["id" => $id, "roleName" => $roletype])->update("login_details", $data);
            $data1 = ["org_status" => "", "updatedAt" => $this->datetimenow()];
            $result1 = $this->db->where("id", $id)->update("login_details", $data1);
            if ($result1) {
                $this->addActivityLog($_SESSION['id'], "Login Details Login Status Updated", "login_details");
                return '{"status":"success","msg":"Login Status Updated Successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mOrgStatusChange() {
        $orgId1 = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);
        $orgStatus = FILTER_VAR(trim($this->input->post('orgStatus')), FILTER_SANITIZE_STRING);
        $Statustype = FILTER_VAR(trim($this->input->post('Statustype')), FILTER_SANITIZE_STRING);
        $orgType = FILTER_VAR(trim($this->input->post('orgType')), FILTER_SANITIZE_STRING);
        $statusName = FILTER_VAR(trim($this->input->post('statusName')), FILTER_SANITIZE_STRING);
        if ($orgStatus == 0) {
            $orgStatus = 1;
        } else {
            $orgStatus = 0;
        }
        $data = [$Statustype => $orgStatus, "orgUpdated" => $this->datetimenow()];
        $result = $this->db->where("orgId", $orgId1)->update("organization_details", $data);
        if ($result) {
            $this->addActivityLog($_SESSION['id'], " " . $orgType . " Details " . $statusName . " Updated", "organization_details");
            return '{"status":"success","msg":" ' . $statusName . ' ' . $orgType . ' Status Updated Successfully!"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mSendNotifications($reference, $message, $emailSend, $orgIds) {

        if (!isset($_SESSION['id']) || empty($reference) || empty($message) || empty($orgIds)) {
            return '{"status":"error","msg":"Required details are empty."}';
        }
        $orgId = base64_decode($orgIds);
        $chk = $this->db->query("SELECT od.orgName,ld.email FROM organization_details od INNER JOIN login_details ld ON ld.id=od.loginId AND ld.isactive=1 WHERE od.orgId=$orgId AND od.isactive=1");
        if ($chk->num_rows() > 0) {
            $idata = ["message" => $message, "notificationFor" => $orgId, "tableName" => "organization_details", "sentBy" => $_SESSION['id'], "senderTableName" => "web_users", "isRead" => 0, "reference" => $reference];
            $chkDuplicate = $this->db->where($idata)->get("tbl_notifications");
            if ($chkDuplicate->num_rows() > 0) {
                return '{"status":"error","msg":"Duplicate details."}';
            } else {

                $insdata = ["createdAt" => $this->datetimenow(), "ipAddressSender" => $this->getRealIpAddr(), "isactive" => 1];
                $res = $this->db->insert("tbl_notifications", array_merge($idata, $insdata));
                ($res ? $this->addActivityLog($_SESSION['id'], "Notification Message sent to " . $chk->row()->orgName . " ", "organization_details") : "");
                ($res ? ($emailSend == 1 ? $this->sendEmail($chk->row()->email, $message, $reference, "iHuntBest") : "") : "");
                return ($res ? '{"status":"success","msg":" Notification sent successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            }
        }
    }

    public function mGetCollegetDetails() {
        $query = $this->db->query("SELECT ld.id,'' profileStatus,od.orgId,od.orgId orgIdc,od.orgLatestStatus,od.orgFeatureStatus,ld.admin_approved,ld.verifyStatus,
                                    ld.email,od.orgName,od.webLinkStartus,od.orgMobile,od.orgAddress,ld.loginStatus,ld.org_status,od.orgTopRated,od.orgButtonType
                                    FROM login_details as ld
                                    INNER JOIN organization_details as od ON od.loginId=ld.id AND od.isactive=1
                                    WHERE ld.isactive=1 AND ld.roleName='College'");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $q) {
                $q->orgIdc = base64_encode($q->orgIdc);
                $q->profileStatus = $this->profileCompletion($q->id);
            }
            return json_encode($query->result());
        } else {
            return '';
        }
    }

    public function mGetInstituteDetails() {
        $query = $this->db->query("SELECT ld.id,'' profileStatus,od.webLinkStartus,od.orgId,od.orgId orgIdc,od.orgLatestStatus,od.orgFeatureStatus,ld.admin_approved,
                                    ld.email,od.orgName,od.orgMobile,od.orgAddress,ld.loginStatus,ld.org_status,od.orgTopRated,od.orgButtonType
                                    FROM login_details as ld
                                    INNER JOIN organization_details as od ON od.loginId=ld.id AND od.isactive=1
                                    WHERE ld.isactive=1 AND ld.roleName='Institute'");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rs) {
                $rs->orgIdc = base64_encode($rs->orgIdc);
                $rs->profileStatus = $this->profileCompletion($rs->id);
            }
            return json_encode($query->result());
        } else {
            return "";
        }
    }

    public function mupDateLatestInstituteStatus() {
        $orgId1 = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);
        $orgLatestStatus = FILTER_VAR(trim($this->input->post('orgLatestStatus')), FILTER_SANITIZE_STRING);
        $data_exploded = explode('_', $orgId1);
        $orgId = $data_exploded[1];
        if ($orgLatestStatus == 0) {
            $orgLatestStatus = 1;
        } else {
            $orgLatestStatus = 0;
        }
        $data = ["orgLatestStatus" => $orgLatestStatus, "orgUpdated" => $this->datetimenow()];
        $this->db->where("orgId", $orgId);
        $result = $this->db->update("organization_details", $data);
        if ($result) {
            $this->addActivityLog($_SESSION['id'], "Institute Latest Status Updated", "organization_details");
            return '{"status":"success","msg":"Latest Institute Status Updated Successfully!"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mGetSchoolDetails() {
        $query = $this->db->query("SELECT ld.id,'' profileStatus,od.webLinkStartus,od.orgId,od.orgId orgIdc,od.orgLatestStatus,od.orgFeatureStatus,ld.admin_approved,
                                    ld.email,od.orgName,od.orgMobile,od.orgAddress,ld.loginStatus,ld.org_status,od.orgTopRated,od.orgButtonType
                                    FROM login_details as ld
                                    INNER JOIN organization_details as od ON od.loginId=ld.id AND od.isactive=1
                                    WHERE ld.isactive=1 AND ld.roleName='School'");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rs) {
                $rs->orgIdc = base64_encode($rs->orgIdc);
                $rs->profileStatus = $this->profileCompletion($rs->id);
            }

            return json_encode($query->result());
        } else {
            return "";
        }
    }

    public function mGetFacilities() {
        $condition = "isactive=1";
        $id = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if ($id) {
            $id = base64_decode($id);
            $condition = "facilityId=$id AND isactive=1";
        }

        return $this->db->query("Select * from facilities where " . $condition . " ");
    }

    public function maddNewfacility() {
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $fac_icon = FILTER_VAR(trim($this->input->post('fac_icon')), FILTER_SANITIZE_STRING);
        $facilityId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $chkDuplicate = $this->chkFacility($title, $facilityId);
        $timenow = $this->datetimenow();
        if ($chkDuplicate == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($facilityId == "no_one") {
                $data = ["title" => $title, "facility_icon" => $fac_icon, "createdAt" => $timenow, "isactive" => 1];
                $response = $this->db->insert("facilities", $data);
                $this->addActivityLog($_SESSION['id'], "Facility added", "facilities");
            } else {
                $data = ["title" => $title, "facility_icon" => $fac_icon, "updatedAt" => $timenow];
                $response = $this->db->where("facilityId", base64_decode($facilityId))->update("facilities", $data);
                $this->addActivityLog($_SESSION['id'], "Facility updated", "facilities");
            }
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function chkFacility($title, $facilityId) {
        if ($facilityId == 'no_one') {
            $chk = $this->db->query("Select * from facilities where isactive=1 and title='" . $title . "'");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        } else {

            $chk = $this->db->query("Select * from facilities where isactive=1 and title='" . $title . "' AND facilityId!=" . base64_decode($facilityId) . "");
            if ($chk->num_rows() > 0) {
                return "duplicate";
            } else {
                return "fine";
            }
        }
    }

    public function mDelFacility($id) {
        $chkQry = $this->db->query("Select * from facilities where isactive=1 and facilityId=" . base64_decode($id) . "");
        if ($chkQry->num_rows() > 0) {
            $data = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $this->db->where("facilityId", base64_decode($id));
            $response = $this->db->update("facilities", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "Facility Deleted", "facilities");
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mGetRequestedFacilites() {
        $reqfacilities = $this->db->query("SELECT fs.facilityId,od.orgName,od.orgMobile,fs.title as facility,fs.facility_icon,fs.facility_status
                                                FROM  facilities as fs INNER JOIN facility_request as fr ON fr.facilityId=fs.facilityId
                                                INNER JOIN organization_details as od ON od.loginId=fr.orgId WHERE facility_status!='0' ");
        if ($reqfacilities->num_rows() > 0) {
            return json_encode($reqfacilities->result());
        } else {
            return "";
        }
    }

    public function mGetApprovedFacilities() {
        $reqfacilities = $this->db->query("SELECT fs.facilityId,od.orgName,od.orgMobile,fs.title as facility,fs.facility_icon,fs.facility_status
                                                    , DATE_FORMAT(fs.updatedAt , '%d-%b-%y') as approvalDate FROM  facilities as fs
                                                    INNER JOIN facility_request as fr ON fr.facilityId=fs.facilityId
                                                    INNER JOIN organization_details as od ON od.loginId=fr.orgId WHERE facility_status='2' ");
        if ($reqfacilities->num_rows() > 0) {
            return json_encode($reqfacilities->result());
        } else {
            return "";
        }
    }

    public function mGetRejectedFacilities() {
        $reqfacilities = $this->db->query("SELECT fs.facilityId,od.orgName,od.orgMobile,fs.title as facility,fs.facility_icon,fs.facility_status
                    , DATE_FORMAT(fs.updatedAt , '%d-%b-%y') as approvalDate FROM  facilities as fs
                    INNER JOIN facility_request as fr ON fr.facilityId=fs.facilityId
                    INNER JOIN organization_details as od ON od.loginId=fr.orgId WHERE facility_status='1'");
        if ($reqfacilities->num_rows() > 0) {
            return json_encode($reqfacilities->result());
        } else {
            return "";
        }
    }

    public function mchangeRequestedFacilitesStatus() {
        $facilityId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $facilityStatus = FILTER_VAR(trim($this->input->post('facility_status')), FILTER_SANITIZE_STRING);
        $data = ["facility_status" => $facilityStatus, "updatedAt" => $this->datetimenow()];
        $this->db->where("facilityId", $facilityId);
        $response = $this->db->update("facilities", $data);
        if ($response) {
            $this->addActivityLog($_SESSION['id'], "Requested Facility status updated", "facilities");
            return '{"status":"success","msg":"Facility Status Changed Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function getCountries() {
        $cid = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($cid)) {
            $id = base64_decode($cid);
            $condition = " countryId=$id AND isactive=1";
        } else {
            $condition = " isactive=1";
        }
        $countries = $this->db->query("SELECT * FROM countries WHERE $condition");
        if ($countries->num_rows() > 0) {
            foreach ($countries->result() as $ci) {
                $ci->countryId = base64_encode($ci->countryId);
            }
            return json_encode($countries->result());
        } else {
            return "";
        }
    }

    private function uploadImage($path, $imgName, $uploadfname) {
        $config = ['upload_path' => $path, 'allowed_types' => "gif|jpg|png|jpeg|JPG|JPEG|PNG|GIF", "file_name" => $imgName];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($uploadfname) == false) {
//            /$error = array('error' => $this->upload->display_errors());
//$error['error'];
// $error->error;

            return 'error';
        } else {
            $data = $this->upload->data();
            $newImage = $data['file_name'];
            $config = ['image_library' => "gd2", 'source_image' => $path . $newImage, 'new_image' => $path . $newImage,
                "create_thumb" => false, "maintain_ratio" => true, "quality" => 100, "width" => 550];
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                $this->image_lib->display_errors();

                return "error";
            } else {
                return $newImage;
            }
        }
    }

    public function mAddCountry($sortname, $name, $countryId) {
        $mchekdup = $this->mCheckCountry($name, $sortname, $countryId);
        if (isset($_FILES['countryImage']['name'])) {
            $flagname = $this->uploadImage('./projectimages/images/countryflags/', $name . strtotime($this->datetimenow()), 'countryImage');
        } else {
            $flagname = FILTER_VAR(trim(strtoupper($this->input->post('flagname'))), FILTER_SANITIZE_STRING);
        }
        if ($mchekdup == "fine") {
            if ($countryId == "no_one") {
                $data = ["sortname" => $sortname, "name" => $name, "flag_image" => $flagname, "isactive" => 1];
                $response = $this->db->insert("countries", $data);
            } else {
                $data = ["sortname" => $sortname, "name" => $name, "flag_image" => $flagname, "modifiedAt" => $this->datetimenow()];
                $response = $this->db->where("countryId", base64_decode($countryId))->update("countries", $data);
            }
            ($countryId == "no_one" ? ($response ? $this->addActivityLog($_SESSION['id'], "Country Details Inserted for $name", "countries") : "") :
                            ($response ? $this->addActivityLog($_SESSION['id'], "Country Details Updated for $name", "countries") : ""));
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        }
    }

    public function mAddState() {
        $name = FILTER_VAR(trim(ucwords(strtolower($this->input->post('name')))), FILTER_SANITIZE_STRING);
        $Id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $countryname = FILTER_VAR(trim($this->input->post('countryname')), FILTER_SANITIZE_STRING);
        $countryId = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_STRING);
        $mchekdup = $this->mCheckState($name, $Id, $countryId);
        if (isset($_FILES['stateFlag']['name'])) {
//                $image      =       preg_replace("/\s+/", "_", $_FILES['stateFlag']['name']);
            $path = './projectimages/images/stateflags/';
//$gext       =       explode(".", $image);
            $imgName = $name . '-' . $countryname . strtotime($this->datetimenow());
            $flagname = $this->uploadImage($path, $imgName, 'stateFlag');
        } else {
            $flagname = FILTER_VAR(trim(strtoupper($this->input->post('flagname'))), FILTER_SANITIZE_STRING);
        }
        if ($mchekdup == "fine") {
            return $this->insertUpdateState($Id, $countryId, $name, $flagname);
        } else {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        }
    }

    private function insertUpdateState($Id, $countryId, $name, $flagname) {

        if ($Id == "no_one") {
            $data = ["countryId" => $countryId, "name" => $name, "state_flag" => $flagname, "modifiedAt" => $this->datetimenow(), "isactive" => 1];
            $response = $this->db->insert("states", $data);
            $this->addActivityLog($_SESSION['id'], "State Details Inserted for $name", "states");
        } else {
            $data = ["countryId" => $countryId, "name" => $name, "state_flag" => $flagname, "modifiedAt" => $this->datetimenow()];

            $response = $this->db->where("stateId", $Id)->update("states", $data);
            $this->addActivityLog($_SESSION['id'], "State Details Updated for $name", "states");
        }
        return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
    }

    private function mCheckState($name, $Id, $countryId) {
        if ($Id === "no_one") {
            $cData = ["name" => $name, "countryId" => $countryId, "isactive" => 1];
        } else {
            $cData = ["stateId!=" => $Id, "name" => $name, "countryId" => $countryId, "isactive" => 1];
        }
        $this->db->where($cData);
        $data = $this->db->get("states");
        if ($data->num_rows() > 0) {
            return "duplicate";
        } else {
            return "fine";
        }
    }

    public function mCheckCountry($name, $sortname, $countryId) {
        if ($countryId == "no_one") {
            $condition = "AND isactive=1";
        } else {
            $id = base64_decode($countryId);
            $condition = "AND countryId!=$id AND isactive=1";
        }
        $qry = $this->db->query("SELECT * from countries where (name='$name' OR sortname='$sortname') $condition ");
        if ($qry->num_rows() > 0) {
            return "duplicate";
        } else {
            return "fine";
        }
    }

    public function mUpDateStatusCountry() {
        $countryId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $country_status = FILTER_VAR(trim($this->input->post('country_status')), FILTER_SANITIZE_NUMBER_INT);
        $id = base64_decode($countryId);
        if ($country_status == "" || $countryId == "") {
            return '{"status":"error","msg":"Sorry Empty Variables!"}';
        } else {
            $data = ["countryFlag" => $country_status, "modifiedAt" => $this->datetimenow()];

            $response = $this->db->where("countryId", $id)->update("countries", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "Country Status Updated", "countries");
                return '{"status":"success","msg":"Country Flag Update Successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function getCountryName($countryid) {
        $this->db->where("countryId", $countryid);
        $countryData = $this->db->get("countries");
        if ($countryData->num_rows() > 0) {
            $data = $countryData->row();

            return $data->name;
        } else {
            return "notFound";
        }
    }

    public function mdelState() {
        $stateId = FILTER_VAR(trim($this->input->post('stateid')), FILTER_SANITIZE_STRING);
        $states = $this->db->where("stateId", $stateId)->get("states");
        if ($states->num_rows() > 0) {
            $udata = ["modifiedAt" => $this->datetimenow(), "isactive" => 0];
            $res = $this->db->where("stateId", $stateId)->update("states", $udata);
            $sdata = $states->row();
            if ($res) {
                $this->addActivityLog($_SESSION['id'], "State Details of " . $sdata->name . " is deleted ", "states");
                return '{"status":"success","msg":"State details deleted successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mUpDateStatusState() {
        $Id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $status = FILTER_VAR(trim($this->input->post('state_status')), FILTER_SANITIZE_NUMBER_INT);

        if ($status == "" || $Id == "") {
            return '{"status":"error","msg":"Sorry Empty Variables!"}';
        } else {
            $data = ["stateFlag" => $status, "modifiedAt" => $this->datetimenow()];
            $response = $this->db->where("stateId", $Id)->update("states", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "State Status Updated", "states");
                return '{"status":"success","msg":"State Status Flag Update Successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mdelCountry() {
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if ($id == "") {
            return '{"status":"error","msg":"Country Id is empty!"}';
        } else {
            $id1 = base64_decode($id);
            $chkQry = $this->db->query("Select * from countries where isactive=1 and countryId=$id1");
            if ($chkQry->num_rows() > 0) {
                $data = ["isactive" => 0];
                $response = $this->db->where("countryId", $id1)->update("countries", $data);
            } else {
                $response = "";
            }
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "Country Deleted", "countries");
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function getStateName($stateid) {
        $statesData = $this->db->where("stateId", $stateid)->get("states");
        if ($statesData->num_rows() > 0) {
            $data = $statesData->row();

            return $data->name;
        } else {
            return "notFound";
        }
    }

    public function getContryId($stateid) {
        $this->db->where("stateId", $stateid);
        $statesData = $this->db->get("states");
        if ($statesData->num_rows() > 0) {
            $data = $statesData->row();

            return base64_encode($data->countryId);
        } else {
            return "notFound";
        }
    }

    public function mInsertCity() {
        $name = FILTER_VAR(trim(ucwords(strtolower($this->input->post('name')))), FILTER_SANITIZE_STRING);
        $Id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $statename = FILTER_VAR(trim($this->input->post('statename')), FILTER_SANITIZE_STRING);
        $stateId = FILTER_VAR(trim($this->input->post('state')), FILTER_SANITIZE_STRING);
        $mchekdup = $this->mCheckCity($name, $Id, $stateId);
        if (isset($_FILES['cityFlag']['name'])) {
            $path = './projectimages/images/cityflags/';
            $imgName = $name . '-' . $statename . strtotime($this->datetimenow());
            $flagname = $this->uploadImage($path, $imgName, 'cityFlag');
        } else {
            $flagname = FILTER_VAR(trim(strtoupper($this->input->post('flagname'))), FILTER_SANITIZE_STRING);
        }
        if ($mchekdup == "fine") {
            return $this->insertUpdateCity($Id, $stateId, $name, $flagname);
        } else {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        }
    }

    private function insertUpdateCity($Id, $stateId, $name, $flagname) {

        if ($Id == "no_one") {
            $data = ["stateId" => $stateId, "name" => $name, "city_flag" => $flagname, "modifiedAt" => $this->datetimenow(), "isactive" => 1];
            $response = $this->db->insert("cities", $data);
            $this->addActivityLog($_SESSION['id'], "City Details Inserted for $name", "states");
        } else {
            $data = ["stateId" => $stateId, "name" => $name, "city_flag" => $flagname, "modifiedAt" => $this->datetimenow()];

            $response = $this->db->where("cityId", $Id)->update("cities", $data);
            $this->addActivityLog($_SESSION['id'], "City Details Updated for $name", "states");
        }
        return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
    }

    private function mCheckCity($name, $Id, $stateId) {
        if ($Id === "no_one") {
            $cData = ["name" => $name, "stateId" => $stateId, "isactive" => 1];
        } else {
            $cData = ["cityId!=" => $Id, "name" => $name, "stateId" => $stateId, "isactive" => 1];
        }
        $this->db->where($cData);
        $data = $this->db->get("cities");
        if ($data->num_rows() > 0) {
            return "duplicate";
        } else {
            return "fine";
        }
    }

    public function mdelCity() {
        $cityId = FILTER_VAR(trim($this->input->post('cityId')), FILTER_SANITIZE_STRING);
        $cities = $this->db->where("cityId", $cityId)->get("cities");
        if ($cities->num_rows() > 0) {
            $udata = ["modifiedAt" => $this->datetimenow(), "isactive" => 0];
            $res = $this->db->where("cityId", $cityId)->update("cities", $udata);
            $sdata = $cities->row();
            if ($res) {
                $this->addActivityLog($_SESSION['id'], "City Details of " . $sdata->name . " is deleted ", "cities");
                return '{"status":"success","msg":"City details deleted successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mgetRegisteredOrg() {
        $cid = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($cid)) {
            $id = base64_decode($cid);
            $condition = " orgRegCId=$id AND isactive=1";
        } else {
            $condition = " isactive=1";
        }
        $data = $this->db->query("SELECT orgRegCId,title,beforeBegin,proceedContent,DATE_FORMAT(createdAt ,'%d-%b-%y %r') as createdAt
                FROM org_register_contents WHERE  $condition");

        foreach ($data->result() as $ci) {
            $ci->orgRegCId = base64_encode($ci->orgRegCId);
        }
        return json_encode($data->result());
    }

    public function mUpDateStatusCity() {
        $Id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $status = FILTER_VAR(trim($this->input->post('city_status')), FILTER_SANITIZE_NUMBER_INT);

        if ($status == "" || $Id == "") {
            return '{"status":"error","msg":"Sorry Empty Variables!"}';
        } else {
            $data = ["cityFlag" => $status, "modifiedAt" => $this->datetimenow()];
            $response = $this->db->where("cityId", $Id)->update("cities", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "City Status Updated", "states");
                return '{"status":"success","msg":"City Status Flag Update Successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function msetOrgRegistrationContent() {
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $beforeBegin = $this->input->post('beforeBegin');
        $proceedContent = $this->input->post('proceedContent');
        $orgRegCId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $mchekdup = $this->mCheckoRegOrg($beforeBegin, $proceedContent, $orgRegCId, $title);
        if ($mchekdup == "fine") {
            if ($orgRegCId == "no_one") {
                $data = ["title" => $title, "beforeBegin" => $beforeBegin, "proceedContent" => $proceedContent, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $response = $this->db->insert("org_register_contents", $data);
                $this->addActivityLog($_SESSION['id'], "Organisation Registered Content Inserted", "org_register_contents");
            } else {
                $id = base64_decode($orgRegCId);
                $data = ["title" => $title, "beforeBegin" => $beforeBegin, "proceedContent" => $proceedContent, "updatedAt" => $this->datetimenow()];
                $response = $this->db->where("orgRegCId", $id)->update("org_register_contents", $data);
                $this->addActivityLog($_SESSION['id'], "Organisation Registered Content Updated", "org_register_contents");
            }
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        }
    }

    public function mCheckoRegOrg($beforeBegin, $proceedContent, $orgRegCId, $title) {
        if ($orgRegCId == "no_one") {
            $condition = "AND isactive=1";
        } else {
            $id = base64_decode($orgRegCId);
            $condition = "AND orgRegCId!=$id AND isactive=1";
        }
        $qry = $this->db->query("SELECT * from org_register_contents where (beforeBegin='$beforeBegin' OR title='$title' OR proceedContent='$proceedContent')
                    $condition ");
        if ($qry->num_rows() > 0) {
            return "duplicate";
        } else {
            return "fine";
        }
    }

    public function mdelOrgRegistraion() {
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (empty($id)) {
            return '{"status":"error","msg":"Organization Id is empty!"}';
        } else {
            $id1 = base64_decode($id);
            $chkQry = $this->db->query("Select * from org_register_contents where isactive=1 and orgRegCId=$id1");
            if ($chkQry->num_rows() > 0) {
                $data = ["isactive" => 0];
                $response = $this->db->where("orgRegCId", $id1)->update("org_register_contents", $data);
            }
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "Organisation Registered Content Deleted", "org_register_contents");
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

//organization Registration start
    public function mAddOrganizationDetails() {
        $loginId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $roletype = FILTER_VAR(trim($this->input->post('roleName')), FILTER_SANITIZE_STRING);
        $orgname = FILTER_VAR(trim(ucwords(strtolower($this->input->post('orgname')))), FILTER_SANITIZE_STRING);
        $orgMobile = FILTER_VAR(trim($this->input->post('orgContact')), FILTER_SANITIZE_STRING);
        $orgAContact = FILTER_VAR(trim($this->input->post('orgAContact')), FILTER_SANITIZE_STRING);
        $email = FILTER_VAR(trim($this->input->post('orgemail')), FILTER_SANITIZE_EMAIL);
        $password = FILTER_VAR(trim($this->input->post('orgpassword')), FILTER_SANITIZE_STRING);
        $countryId = FILTER_VAR(trim($this->input->post('country')), FILTER_SANITIZE_STRING);
        $stateId = FILTER_VAR(trim($this->input->post('state')), FILTER_SANITIZE_STRING);
        $cityId = FILTER_VAR(trim($this->input->post('city')), FILTER_SANITIZE_STRING);
        $address = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);
        $ipAddress = $this->getRealIpAddr();
        if (empty($loginId) || empty($roletype) || empty($orgname) || empty($orgAContact) || empty($email) || empty($password) || empty($countryId) || empty($stateId) || empty($cityId) || empty($address)) {
            return '{"status":"error", "msg":"Required field is empty."}';
        }
        if ($loginId === "no_one") {
            return $this->insertOrganisationDetails($roletype, $orgname, $orgMobile, $orgAContact, $email, $password, $countryId, $stateId, $cityId, $address, $ipAddress);
        } else {
            return $this->updateOrganisationDetails($loginId, $roletype, $orgname, $orgMobile, $orgAContact, $email, $password, $countryId, $stateId, $cityId, $address, $ipAddress);
        }
    }

    private function insertOrganisationDetails($roletype, $orgname, $orgMobile, $orgAContact, $email, $password, $countryId, $stateId, $cityId, $address, $ipAddress) {
        $chkqry = $this->db->query("SELECT * FROM login_details WHERE email='" . $email . "' AND isactive=1");
        if ($chkqry->num_rows() > 0) {
            return '{"status":"error", "msg":"Already registered."}';
        } else {
            $pwd_encrpyt = $this->encryption->encrypt($password);
            $data = ["email" => $email, "password" => $password, "password1" => $pwd_encrpyt, "roleName" => $roletype, "ipAddress" => $ipAddress, "createdAt" => $this->datetimenow(), "createdBy" => "Admin", "isactive" => 1];
            $this->db->insert("login_details", $data);
            $this->addActivityLog($_SESSION['id'], "New Organisation " . $orgname . "(" . $roletype . ") Registered", "login_details");
            $insertid = $this->db->insert_id();
            if ($insertid) {
                $orgdata = ["loginId" => $insertid, "orgName" => $orgname, "orgMobile" => $orgMobile, "org_landline" => $orgAContact, "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId,
                    "orgAddress" => $address, "orgCreated" => $this->datetimenow(), "isactive" => 1];
                $this->db->insert("organization_details", $orgdata);
                $this->addActivityLog($_SESSION['id'], "New Organisation " . $orgname . "(" . $roletype . ") details inserted", "organization_details");
                return '{"status":"success", "msg":"Registered successfully."}';
            } else {
                return '{"status":"error", "msg":"Some error occured."}';
            }
        }
    }

    private function updateOrganisationDetails($loginId, $roletype, $orgname, $orgMobile, $orgAContact, $email, $password, $countryId, $stateId, $cityId, $address, $ipAddress) {
        $chkqry = $this->db->query("SELECT * FROM login_details WHERE id='" . $loginId . "' AND isactive=1");
        if ($chkqry->num_rows() > 0) {
            $pwd_encrpyt = $this->encryption->encrypt($password);
            $data = ["email" => $email, "password" => $password, "password1" => $pwd_encrpyt, "roleName" => $roletype, "ipAddress" => $ipAddress, "updatedAt" => $this->datetimenow(), "updatedBy" => "Admin", "isactive" => 1];
            $this->db->where("id", $loginId)->update("login_details", $data);
            $this->addActivityLog($_SESSION['id'], "New Organisation " . $orgname . "(" . $roletype . ") Updated", "login_details");

            $chkqrydata = $this->db->where("loginId", $loginId)->get("organization_details");
            if ($chkqrydata->num_rows() > 0) {
                $orgdata = ["orgName" => $orgname, "orgMobile" => $orgMobile, "org_landline" => $orgAContact, "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "orgAddress" => $address, "orgUpdated" => $this->datetimenow(), "isactive" => 1];

                $res = $this->db->where("loginId", $loginId)->update("organization_details", $orgdata);
                $this->addActivityLog($_SESSION['id'], "Organisation " . $orgname . "(" . $roletype . ") details updated", "organization_details");
            } else {
                $orgdata = ["loginId" => $loginId, "orgName" => $orgname, "orgMobile" => $orgMobile, "org_landline" => $orgAContact, "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "orgAddress" => $address, "orgCreated" => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->insert("organization_details", $orgdata);
                $this->addActivityLog($_SESSION['id'], "New Organisation " . $orgname . "(" . $roletype . ") details inserted", "organization_details");
            }
            return ($res ? '{"status":"success", "msg":"Registered successfully."}' : '{"status":"error", "msg":"Some error occured."}');
        } else {
            return '{"status":"error", "msg":"NO such entry."}';
        }
    }

    public function mGetOrganisationDetails() {
        $loginId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $condition = ($loginId ? "AND ld.id=$loginId" : "");

        $data = $this->db->query("SELECT ld.id,ld.email,ld.password,ld.roleName,od.orgName,od.orgMobile,od.org_landline,od.orgAddress,od.countryId,
                                od.stateId,od.cityId,ctr.name AS country,st.name AS statename,c.name AS ctyname FROM login_details ld
                                LEFT JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                                LEFT JOIN countries ctr on ctr.countryId=od.countryId
                                LEFT JOIN states st on st.stateId=od.stateId
                                LEFT JOIN cities c on c.cityId=od.cityId
                                WHERE ld.isactive=1 $condition");
        if ($data->num_rows() > 0) {
            $result = $data->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mDelOrganisationDetails() {
        $loginId = FILTER_VAR(trim($this->input->post('Id')), FILTER_SANITIZE_STRING);
        if (empty($loginId)) {
            return '{"status":"error","msg":"Empty Id"}';
        } else {
            $chk = $this->db->where(["id" => $loginId, "isactive" => 1])->get("login_details");
            if ($chk->num_rows() > 0) {
                $uData = ["updatedAt" => $this->datetimenow(), "updatedBy" => "Admin", "isactive" => 0];

                $res = $this->db->where("id", $loginId)->update("login_details", $uData);

                $oData = ["orgUpdated" => $this->datetimenow(), "isactive" => 0];
                $this->db->where("loginId", $loginId)->update("organization_details", $oData);
            } else {
                $res = "";
            }
            ($res !== "" ? $this->addActivityLog($_SESSION['id'], "Organization account deleted", "login_details") : "");
            return ($res != "" ? '{"status":"success","msg":"Deleted Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//organization Registration end
//student Registration Start
    public function mRegisterStudent() {
        $studentName = FILTER_VAR(trim(ucfirst(strtolower($this->input->post('student_name')))), FILTER_SANITIZE_STRING);
        $studentMobile = FILTER_VAR(trim($this->input->post('studentMobile')), FILTER_SANITIZE_NUMBER_INT);
        $studentEmail = FILTER_VAR(trim($this->input->post('student_email')), FILTER_SANITIZE_EMAIL);
        $password = FILTER_VAR(trim($this->input->post('student_password')), FILTER_SANITIZE_STRING);
        $countryId1 = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_NUMBER_INT);
        $stateId1 = FILTER_VAR(trim($this->input->post('stateId1')), FILTER_SANITIZE_NUMBER_INT);
        $cityId1 = FILTER_VAR(trim($this->input->post('cityId1')), FILTER_SANITIZE_NUMBER_INT);
        $address = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);
        $dob = FILTER_VAR(trim($this->input->post('student_dob')), FILTER_SANITIZE_STRING);
        $studentId = FILTER_VAR(trim($this->input->post('studentId')), FILTER_SANITIZE_STRING);
        $gender = FILTER_VAR(trim($this->input->post('gender')), FILTER_SANITIZE_STRING);
        $ipAddress = $this->getRealIpAddr();
        if (empty($studentName) || empty($studentMobile) || empty($studentEmail) || empty($password) || empty($countryId1) || empty($stateId1) || empty($cityId1) || empty($address) || empty($dob) || empty($studentId) || empty($gender)) {
            return '{"status":"error", "msg":"Required field is empty."}';
        }
        if ($studentId == "no_one") {
            return $this->insertStudentDetails($studentName, $studentMobile, $studentEmail, $password, $countryId1, $stateId1, $cityId1, $address, $dob, $ipAddress, $gender);
        } else {
            return $this->upDateStudentDetails($studentId, $studentName, $studentMobile, $studentEmail, $password, $countryId1, $stateId1, $cityId1, $address, $dob, $ipAddress, $gender);
        }
    }

    private function insertStudentDetails($studentName, $studentMobile, $studentEmail, $password, $countryId1, $stateId1, $cityId1, $address, $dob, $ipAddress, $gender) {
        $chk = $this->db->where(["email" => $studentEmail])->get("student_login");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Already registered."}';
        } else {
            $encpass = $this->encryption->encrypt($password);
            $data = ["email" => $studentEmail, "password" => $password, "password1" => $encpass, "studentName" => $studentName, "ipAddress" => $ipAddress, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $this->db->insert("student_login", $data);
            $id = $this->db->insert_id();
            if ($id) {
                $this->addActivityLog($_SESSION['id'], "Student Registered $studentName($studentEmail))", "student_login");
                $sdetails = ["studentId" => $id, "studentName" => $studentName, "studentMobile" => $studentMobile, "countryId" => $countryId1, "stateId" => $stateId1, "cityId" => $cityId1, "location" => $address,
                    "gender" => $gender, "dob" => $dob, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->insert("student_details", $sdetails);
                ($res ? $this->addActivityLog($_SESSION['id'], "Student Details  $studentName($studentEmail)) inserted.", "student_details") : "" );
                return ($res ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Not inserted."}';
            }
        }
    }

    private function upDateStudentDetails($studentId, $studentName, $studentMobile, $studentEmail, $password, $countryId1, $stateId1, $cityId1, $address, $dob, $ipAddress, $gender) {
        $chk = $this->db->where(["email" => $studentEmail, "studentId" => $studentId])->get("student_login");
        if ($chk->num_rows() > 0) {
            $encpass = $this->encryption->encrypt($password);
            $data = ["email" => $studentEmail, "password" => $password, "password1" => $encpass, "studentName" => $studentName, "ipAddress" => $ipAddress];
            $res = $this->db->where('studentId', $studentId)->update("student_login", $data);

            if ($res) {
                $this->addActivityLog($_SESSION['id'], "Student Login Detail for $studentName($studentEmail)) updated", "student_login");
                $details = $this->db->where("studentId", $studentId)->get("student_details");
                $sdetails = ["studentId" => $studentId, "studentName" => $studentName, "studentMobile" => $studentMobile, "countryId" => $countryId1,
                    "stateId" => $stateId1, "cityId" => $cityId1, "location" => $address, "gender" => $gender, "dob" => $dob, "isactive" => 1];
                $res = ($details->num_rows() > 0 ? $this->db->where("studentId", $studentId)->update("student_details", array_merge($sdetails, ["updatedAt" => $this->datetimenow()])) :
                        $this->db->insert("student_details", array_merge($sdetails, ["createdAt" => $this->datetimenow()])));
                ($res ? $this->addActivityLog($_SESSION['id'], "Student Details  $studentName($studentEmail)) " . ($details->num_rows() > 0 ? "updated" : "inserted") . ".", "student_details") : "");
                return ($res ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Not registered."}';
            }
        } else {
            return '{"status":"error", "msg":"Already registered."}';
        }
    }

    public function mGetStudentDetails() {
        $studentId = FILTER_VAR(trim($this->input->post('studentId')), FILTER_SANITIZE_NUMBER_INT);
        if (!empty($studentId)) {
            $condition = "AND sl.studentId=$studentId";
        } else {
            $condition = "";
        }
        $reqfacilities = $this->db->query("SELECT sl.studentId,sl.email,sl.studentName,sd.studentMobile,sd.dob dobo,sd.countryId,sd.stateId,sd.cityId,
                                    sd.location,sd.gender,DATE_FORMAT(sd.dob, '%d-%b-%y') dob,sl.password,concat_ws(',' ,cts.name,sts.name,ctr.name) as countrydetails
                                    FROM student_login sl
                                    INNER JOIN student_details sd ON sd.studentId=sl.studentId AND sd.isactive=1
                                    LEFT JOIN countries ctr ON ctr.countryId=sd.countryId AND ctr.isactive=1
                                    LEFT JOIN cities cts ON cts.cityId=sd.cityId AND cts.isactive=1
                                    LEFT JOIN states sts on sts.stateId=sd.stateId AND sts.isactive=1
                                    where sl.isactive=1 $condition");
        if ($reqfacilities->num_rows() > 0) {
            $result = $reqfacilities->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mDelStudentDetails() {
        $studentId = FILTER_VAR(trim($this->input->post('studentId')), FILTER_SANITIZE_NUMBER_INT);
        if (empty($studentId)) {
            return '{"status":"error", "msg":"Important detail missing."}';
        }
        $this->db->where("studentId", $studentId);
        $login = $this->db->get("student_login");
        if ($login->num_rows() > 0) {
            $uData = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $res = $this->db->where("studentId", $studentId)->update('student_login', $uData);
            $this->addActivityLog($_SESSION['id'], "Student Login Details of " . $login->row()->studentName . " deleted", "student_login");
        }
        $sdetails = $this->db->where("studentId", $studentId)->get("student_details");
        if ($sdetails->num_rows() > 0) {
            $uData = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $res = $this->db->where("studentId", $studentId)->update('student_details', $uData);
            $this->addActivityLog($_SESSION['id'], "Student Details of " . $sdetails->row()->studentName . " deleted", "student_details");
        }
        return ($res ? '{"status":"success","msg":"Deleted Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function muploadexcel() {
        if (isset($_FILES['orgexcel']['name'])) {
            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
            $todaydate = $date->format('YmdHisA');
// $filename = preg_replace("/\s+/", "_", $_FILES['orgexcel']['name']);
            $config['upload_path'] = './excelfiles/';
            $config['allowed_types'] = 'xlsx|xltx|xlsm|xltm|xls';

            $config['file_name'] = $todaydate;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('orgexcel')) {
                $error = array('error' => $this->upload->display_errors());
                return '{"status":"error","msg":"File Upload Error is ' . $error . '!"}';
            } else {
                $data = $this->upload->data();
                $file = './excelfiles/' . $data['file_name'];
                return $this->getExcelFileData($file);
            }
        }
    }

    private function getExcelFileData($file) {
//load the excel library
        $this->load->library('excel');
//read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);
//get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
//extract to a PHP readable array format

        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
//header will/should be in row 1 only.
            if ($row == 1) {
                $arr_data[$row][$column] = $data_value;
            } else {
                $arr_data[$row][$column] = $data_value;
            }
        }
        return $this->insertOrgDetails($arr_data);
    }

    private function insertOrgDetails($arr_data) {
        $created = 0;
        $total = 0;
        foreach ($arr_data as $ar) {
            $roleName = FILTER_VAR(trim($ar['A']), FILTER_SANITIZE_STRING);
            $orgName = FILTER_VAR(trim(ucfirst(strtolower($ar['B']))), FILTER_SANITIZE_STRING);
            $orgMobile = FILTER_VAR(trim($ar['C']), FILTER_SANITIZE_NUMBER_INT);
            $org_landline = FILTER_VAR(trim($ar['D']), FILTER_SANITIZE_NUMBER_INT);
            $email = FILTER_VAR(trim($ar['E']), FILTER_SANITIZE_EMAIL);
            $password = FILTER_VAR(trim($ar['F']), FILTER_SANITIZE_STRING);
            $orgAddress = FILTER_VAR(trim($ar['G']), FILTER_SANITIZE_STRING);
            if (!empty($roleName) && !empty($orgName) && !empty($orgMobile) && !empty($email) && !empty($password) && !empty($orgAddress)) {
                $password1 = $this->encryption->encrypt($password);
                $chkdetails = $this->db->where("email", $email)->get("login_details");
                $created = ($chkdetails->num_rows() > 0 ? $created : $this->insertRowData($roleName, $email, $password, $password1, $orgName, $orgMobile, $org_landline, $orgAddress, $created));
            }
            $total ++;
        }
        return '{"status":"success","msg":"File Upload and ' . $created . ' created out of ' . $total . '!"}';
    }

    public function insertRowData($roleName, $email, $password, $password1, $orgName, $orgMobile, $org_landline, $orgAddress, $created) {

        $idata = ["roleName" => $roleName, "email" => $email, "password" => $password, "password1" => $password1, "ipAddress" => $this->getRealIpAddr(), "createdAt" => $this->datetimenow(), "createdBy" => "Admin", "isactive" => 1];
        $this->db->insert("login_details", $idata);
        $loginid = $this->db->insert_id();
        if ($loginid) {
            $ioData = ["loginId" => $loginid, "orgName" => $orgName, "orgMobile" => $orgMobile, "org_landline" => $org_landline, "orgAddress" => $orgAddress, "orgCreated" => $this->datetimenow(), "isactive" => 1];
            $this->db->insert("organization_details", $ioData);
            return $created ++;
        } else {
            return $created;
        }
    }

//Student Registration End
//organisation details start
    public function mGetorganisaionDetails($id) {

        $data = $this->db->query("SELECT ld.*,od.*, ctr.name AS country,st.name AS statename,c.name AS ctyname
                                FROM login_details ld
                                LEFT JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                                LEFT JOIN countries ctr on ctr.countryId=od.countryId
                                LEFT JOIN states st on st.stateId=od.stateId
                                LEFT JOIN cities c on c.cityId=od.cityId
                                WHERE ld.isactive=1 AND orgId=$id");
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }

    public function getOrgFacilities($status, $id) {

        return $this->db->query("SELECT fac.* ,omf.mappingId FROM facilities fac
            LEFT JOIN org_mapping_facilities omf ON omf.facilityId=fac.facilityId AND fac.isactive=1
            INNER JOIN organization_details od ON od.loginId=omf.loginId AND
            od.orgId=$id
            WHERE fac.facility_status=$status AND fac.isactive=1 order by fac.facilityId");
    }

//organization details end
//Requested Course starts created by shweta
    public function mGetRequestedCourse() {
        $reqCourse = $this->db->query("SELECT ct.ctId,ct.courseType,ct.requestStatus,ct.loginid,ct.isactive,c.cId,c.ctId,c.title as course,c.requestStatus,c.loginid,c.isactive,
                                st.cId,st.title as stream,st.requestStatus,st.loginid,st.isactive,st.streamId
                                FROM  course_type as ct
                                INNER JOIN course_details as c ON c.ctId=ct.ctId
                                INNER JOIN stream_details as st ON st.cId=c.cId WHERE ct.requestStatus=1 AND c.requestStatus=1 AND st.requestStatus=1");
        if ($reqCourse->num_rows() > 0) {
            $res = $reqCourse->result();
        } else {
            $res = "";
        }
        return json_encode($res);
    }

    public function mGetApprovedCourse() {
        $reqCourse = $this->db->query("SELECT ct.ctId,ct.courseType,ct.requestStatus,ct.loginid,ct.isactive,ct.updatedAt,c.cId,c.ctId,c.title as course,c.requestStatus,c.loginid,c.isactive,
                                c.updatedAt,st.cId,st.title as stream,st.requestStatus,st.loginid,st.isactive,st.streamId,st.updatedAt
                                FROM  course_type as ct
                                INNER JOIN course_details as c ON c.ctId=ct.ctId
                                INNER JOIN stream_details as st ON st.cId=c.cId WHERE ct.requestStatus=2 AND c.requestStatus=2 AND st.requestStatus=2");
        if ($reqCourse->num_rows() > 0) {
            $res = $reqCourse->result();
        } else {
            $res = "";
        }
        return json_encode($res);
    }

    public function mgetRejectedCoursedetails() {
        $reqrejCourse = $this->db->query("SELECT ct.ctId,ct.courseType,ct.requestStatus,ct.loginid,ct.isactive,ct.updatedAt,c.cId,c.ctId,c.title as course,c.requestStatus,c.loginid,c.isactive,
                                c.updatedAt,st.cId,st.title as stream,st.requestStatus,st.loginid,st.isactive,st.streamId,st.updatedAt
                                FROM  course_type as ct
                                INNER JOIN course_details as c ON c.ctId=ct.ctId
                                INNER JOIN stream_details as st ON st.cId=c.cId WHERE ct.requestStatus=3 AND c.requestStatus=3 AND st.requestStatus=3");
        if ($reqrejCourse->num_rows() > 0) {
            $res = $reqrejCourse->result();
        } else {
            $res = "";
        }
        return json_encode($res);
    }

    public function mchangeRequestedCourseStatus($ctId, $cId, $streamId, $requestStatus) {

        if (empty($requestStatus) || empty($ctId) || empty($cId) || empty($streamId)) {
            return '{"status":"error", "msg":"Important detail missing."}';
        } else {
            $course_type = $this->db->where("ctId", $ctId)->get("course_type");
            if ($course_type->num_rows() > 0) {
                $res = $this->db->where("ctId", $ctId)->update("course_type", ["requestStatus" => $requestStatus, "updatedAt" => $this->datetimenow()]);
                ($res ? $this->addActivityLog($_SESSION['id'], "Requested Course status updated", "course_type") : "");
            }
            if ($this->db->where("cId", $cId)->get("course_details")->num_rows() > 0) {
                $res = $this->db->where("cId", $cId)->update("course_details", ["requestStatus" => $requestStatus, "updatedAt" => $this->datetimenow()]);

                ($res ? $this->addActivityLog($_SESSION['id'], "Requested Course status updated", "course_details") : "");
            }
            if ($this->db->where("streamId", $streamId)->get("stream_details")->num_rows() > 0) {
                $res = $this->db->where("streamId", $streamId)->update("stream_details", ["requestStatus" => $requestStatus, "updatedAt" => $this->datetimenow()]);
                ($res ? $this->addActivityLog($_SESSION['id'], "Requested Course status updated", "course_details") : "");
            }
            return ($res ? '{"status":"success","msg":"Course Status Changed Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Requested Course end
//Advertisement plan starts created by shweta
    public function maddAdvplanDetails() {
        $planId = FILTER_VAR(trim($this->input->post('planid')), FILTER_SANITIZE_STRING);
        $img_loc = FILTER_VAR(trim($this->input->post('img_loc')), FILTER_SANITIZE_STRING);
        $plan_name = FILTER_VAR(trim(ucwords(strtolower($this->input->post('plan_name')))), FILTER_SANITIZE_STRING);
        $days = FILTER_VAR(trim($this->input->post('days')), FILTER_SANITIZE_STRING);
        $price = FILTER_VAR(trim($this->input->post('price')), FILTER_SANITIZE_STRING);
        $currency = FILTER_VAR(trim($this->input->post('currency')), FILTER_SANITIZE_STRING);
        $start_time = FILTER_VAR(trim($this->input->post('start_time')), FILTER_SANITIZE_STRING);
        $end_time = FILTER_VAR(trim($this->input->post('end_time')), FILTER_SANITIZE_STRING);
        $countryId = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_NUMBER_INT);
        $stateId = FILTER_VAR(trim($this->input->post('stateId')), FILTER_SANITIZE_NUMBER_INT);
        if (empty($img_loc) || empty($days) || empty($price) || empty($currency) || empty($plan_name) || empty($countryId) || empty($stateId)) {
            return '{"status":"error", "msg":"Required field is empty."}';
        } else {
            if ($planId === "no_one") {
                return $this->insertAdvplanDetails($img_loc, $days, $price, $plan_name, $start_time, $end_time, $countryId, $stateId, $currency);
            } else {
                return $this->updateAdvplanDetails($planId, $img_loc, $days, $price, $plan_name, $start_time, $end_time, $countryId, $stateId, $currency);
            }
        }
    }

    private function insertAdvplanDetails($img_loc, $days, $price, $plan_name, $start_time, $end_time, $countryId, $stateId, $currency) {
        $this->db->where(["img_loc" => $img_loc, "days" => $days, "price" => $price, "isactive" => 1]);
        $chkqry = $this->db->get("advertisement_plan");
        if ($chkqry->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate"}';
        } else {
            $data = ["img_loc" => $img_loc, "days" => $days, "price" => $price, "currencyCode" => $currency, "plan_name" => $plan_name, "start_time" => $start_time, "end_time" => $end_time, "countryId" => $countryId, "stateId" => $stateId, "isactive" => 1];
            $this->db->insert("advertisement_plan", $data);
            $this->addActivityLog($_SESSION['id'], "New Plan" . $plan_name . "(" . $img_loc . ") Saved", "advertisement_plan");
            return '{"status":"success", "msg":"Saved successfully."}';
        }
    }

    private function updateAdvplanDetails($planId, $img_loc, $days, $price, $plan_name, $start_time, $end_time, $countryId, $stateId, $currency) {
        $this->db->where(["planId!=" => $planId, "img_loc" => $img_loc, "days" => $days, "price" => $price, "isactive" => 1]);
        $chkqry = $this->db->get("advertisement_plan");
        $res = "";
        if ($chkqry->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate"}';
        } else {
            $data = ["img_loc" => $img_loc, "days" => $days, "price" => $price, "currencyCode" => $currency, "plan_name" => $plan_name,
                "start_time" => $start_time, "end_time" => $end_time, "countryI d" => $countryId, "stateId" => $stateId, "isactive" => 1];
            $res = $this->db->where("planId", $planId)->update("advertisement_plan", $data);
        }
        if ($res) {
            $this->addActivityLog($_SESSION['id'], "New Plan" . $plan_name . "(" . $img_loc . ") Update", "advertisement_plan");
            return '{"status":"success", "msg":"Update successfully."}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mgetAdvplanDetails() {
        $planId = FILTER_VAR(trim($this->input->post('planid')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Un authorised login!"}';
        }
        $condtion = ( $planId ? "AND ta.planId='$planId'" :
                '');
        $query = $this->db->query("SELECT ta.planId,ta.currencyCode,ta.img_loc,ta.days,ta.price,ta.plan_name,ta.start_time,ta.end_time,ta.countryId,
            ta.stateId,ta.isactive,tc.name as countryname,ts.name as statename FROM advertisement_plan ta
                        INNER JOIN countries tc ON tc.countryId=ta.countryId
                        INNER JOIN states ts ON ts.stateId=ta.stateId
                        WHERE ta.isactive=1 $condtion ");
        if ($query->num_rows() > 0) {
            return json_encode($query->result());
        } else {
            return '{"status":"error","msg":"Error"}';
        }
    }

    public function mdelAdvplanDetails() {
        $planId = FILTER_VAR(trim($this->input->post('planId')), FILTER_SANITIZE_STRING);
        if (empty($planId)) {
            return '{"status":"error","msg":"Empty planId"}';
        } else {

            $chk = $this->db->where(["planId" => $planId, "isactive" => 1])->get("advertisement_plan");
            if ($chk->num_rows() > 0) {
                $res = $this->db->where("planId", $planId)->update("advertisement_plan", ["isactive" => 0]);
            } else {
                $res = "";
            }
            if ($res) {
                $this->addActivityLog($_SESSION['id'], "Advertisement plan deleted", "advertisement_plan");
                return '{"status":"success","msg":"Deleted Successfully."}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mgetAdvertisement() {

        $response = $this->db->query("SELECT ta.* ,ta.apprv_by_admin,DATE_FORMAT(ta.adsDate, '%d-%b-%Y') startdate, tc.name countryname ,ts.name statename,tap.planId,tap.plan_name,tap.img_loc,tap.price,tap.days,
                                                tap.countryId,tap.stateId,DATE_FORMAT(DATE_ADD(ta.adsDate, INTERVAL tap.days DAY),'%d-%b-%Y') expiryDate,
                                                (SELECT COUNT(*) FROM advertisement adv
                                                INNER JOIN advertisement_plan advp ON advp.planId=adv.planId AND adv.isactive=1 WHERE
                                                adv.adsId=ta.adsId AND DATE_ADD(adv.adsDate, INTERVAL advp.days DAY)>CURRENT_DATE()) as statusadd  FROM advertisement ta
                                                INNER JOIN advertisement_plan tap ON tap.planId=ta.planId AND tap.isactive=1
                                                INNER JOIN countries tc ON tc.countryId=tap.countryId
                                                INNER JOIN states ts ON ts.stateId=tap.stateId
                                                WHERE ta.apprv_by_admin=1  AND ta.isactive=1");
        if ($response->num_rows() > 0) {
            $res = $response->result();
        } else {
            $res = "";
        }
        return json_encode($res);
    }

    public function mchangeRequestedAdvStatus() {
        $adsId = FILTER_VAR(trim($this->input->post('adsId')), FILTER_SANITIZE_STRING);
        $apprv_by_admin = FILTER_VAR(trim($this->input->post('apprv_by_admin')), FILTER_SANITIZE_STRING);
        $data = ["apprv_by_admin" => $apprv_by_admin, "updatedAt" => $this->datetimenow()];
        $response = $this->db->where("adsId", $adsId)->update("advertisement", $data);
        if ($response) {
            $this->addActivityLog($_SESSION['id'], "Requested Advertisement status updated", "advertisement");
            return '{"status":"success","msg":"Advertisement Status Changed Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mgetApprovAdvertisement() {
        $response = $this->db->query("SELECT ta.* ,ta.apprv_by_admin,DATE_FORMAT(ta.adsDate, '%d-%b-%Y') startdate, tc.name countryname ,ts.name statename,tap.planId,tap.plan_name,tap.img_loc,tap.price,tap.days,
    tap.countryId,tap.stateId,DATE_FORMAT(DATE_ADD(ta.adsDate, INTERVAL tap.days DAY),'%d-%b-%Y') expiryDate,
    (SELECT COUNT(*) FROM advertisement adv
    INNER JOIN advertisement_plan advp ON advp.planId=adv.planId AND adv.isactive=1 WHERE
    adv.adsId=ta.adsId AND DATE_ADD(adv.adsDate, INTERVAL advp.days DAY)>CURRENT_DATE()) as statusadd  FROM advertisement ta
    INNER JOIN advertisement_plan tap ON tap.planId=ta.planId AND tap.isactive=1
    INNER JOIN countries tc ON tc.countryId=tap.countryId
    INNER JOIN states ts ON ts.stateId=tap.stateId    WHERE ta.apprv_by_admin=2  AND ta.isactive=1");
        if ($response->num_rows() > 0) {
            $res = $response->result();
        } else {
            $res = "";
        }
        return json_encode($res);
    }

    public function mgetRejectedAdvertisement() {

        $response = $this->db->query("SELECT ta.* ,ta.apprv_by_admin,DATE_FORMAT(ta.adsDate, '%d-%b-%Y') startdate, tc.name countryname ,ts.name statename,tap.planId,tap.plan_name,tap.img_loc,tap.price,tap.days,
                                                tap.countryId,tap.stateId,DATE_FORMAT(DATE_ADD(ta.adsDate, INTERVAL tap.days DAY),'%d-%b-%Y') expiryDate,
                                                (SELECT COUNT(*) FROM advertisement adv
                                                INNER JOIN advertisement_plan advp ON advp.planId=adv.planId AND adv.isactive=1 WHERE
                                                adv.adsId=ta.adsId AND DATE_ADD(adv.adsDate, INTERVAL advp.days DAY)>CURRENT_DATE()) as statusadd  FROM advertisement ta
                                                INNER JOIN advertisement_plan tap ON tap.planId=ta.planId AND tap.isactive=1
                                                INNER JOIN countries tc ON tc.countryId=tap.countryId
                                                INNER JOIN states ts ON ts.stateId=tap.stateId
                                                WHERE ta.apprv_by_admin=3  AND ta.isactive=1");
        if ($response->num_rows() > 0) {
            $res = $response->result();
        } else {
            $res = "";
        }
        return json_encode($res);
    }

//Advertisement plan end
//Competitive Exam Start
    public function mAddCompetitveExamDetails() {
        $cexam_id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $countryId = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_STRING);
        $exam_name = FILTER_VAR(trim($this->input->post('exam_name')), FILTER_SANITIZE_STRING);
        $marking_system = FILTER_VAR(trim($this->input->post('marking_system')), FILTER_SANITIZE_STRING);
        $validity_time = FILTER_VAR(trim($this->input->post('validity_time')), FILTER_SANITIZE_STRING);
        $typeOfexam = FILTER_VAR(trim($this->input->post('typeOfexam')), FILTER_SANITIZE_STRING);
        if (empty($cexam_id) || empty($countryId) || empty($exam_name) || empty($marking_system) || empty($validity_time) || empty($typeOfexam)) {
            return '{"status":"error","msg":"Required field is empty"}';
        }
        if ($cexam_id == "no_one") {
            return $this->insertCompetitiveExamDetails($countryId, $exam_name, $marking_system, $validity_time, $typeOfexam);
        } else {
            return $this->updateCompetitiveExamDetails(base64_decode($cexam_id), $countryId, $exam_name, $marking_system, $validity_time, $typeOfexam);
        }
    }

    private function insertCompetitiveExamDetails($countryId, $exam_name, $marking_system, $validity_time, $typeOfexam) {
        $chk = $this->db->where(['country_id' => $countryId, 'exam_name' => $exam_name, 'isactive' => 1])->get("tbl_competitive_exam_master");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $iData = ['country_id' => $countryId, 'exam_name' => $exam_name, 'marking_system' => $marking_system,
            'exam_valid_for' => $validity_time, 'exam_type' => $typeOfexam, 'createdAt' => $this->datetimenow(), 'isactive' => 1];
        $res = $this->db->insert("tbl_competitive_exam_master", $iData);
        if ($res) {
            $this->addActivityLog($_SESSION['id'], "Competitive Exam Details Inserted", "tbl_competitive_exam_master");
            return '{"status":"success","msg":"Saved Successfully."}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    private function updateCompetitiveExamDetails($cexam_id, $countryId, $exam_name, $marking_system, $validity_time, $typeOfexam) {

        $chk = $this->db->where(['c_exam_id' => $cexam_id, 'isactive' => 1])->get("tbl_competitive_exam_master");
        if ($chk->num_rows() == 0) {
            return '{"status":"error","msg":"Details not found"}';
        }
        $uData = ['country_id' => $countryId, 'exam_name' => $exam_name, 'marking_system' => $marking_system,
            'exam_valid_for' => $validity_time, 'exam_type' => $typeOfexam, 'updatedAt' => $this->datetimenow()];

        $res = $this->db->where(['c_exam_id' => $cexam_id, 'isactive' => 1])->update("tbl_competitive_exam_master", $uData);
        if ($res) {
            $this->addActivityLog($_SESSION['id'], "Competitive Exam Details Updated", "tbl_competitive_exam_master");
            return '{"status":"success","msg":"Saved Successfully."}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mGetCompetitiveExamDetails() {
        $cexam_id = FILTER_VAR(trim($this->input->post('Id')), FILTER_SANITIZE_STRING);
        if ($cexam_id) {
            $condition = " AND c_exam_id=" . base64_decode($cexam_id) . "";
        } else {
            $condition = "";
        }
        $qry = $this->db->query("SELECT tcem.*,ctr.name FROM tbl_competitive_exam_master tcem
                                INNER JOIN countries ctr ON ctr.countryId=tcem.country_id
                                WHERE tcem.isactive=1 $condition");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $rs) {
                $rs->c_exam_id = base64_encode($rs->c_exam_id);
            }
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mDelCompetitiveExam() {
        $cexam_id = FILTER_VAR(trim($this->input->post('Id')), FILTER_SANITIZE_STRING);
        $qry = $this->db->where("c_exam_id", base64_decode($cexam_id))->get("tbl_competitive_exam_master");
        if ($qry->num_rows() > 0) {
            $comexamName = $qry->row();
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $res = $this->db->where("c_exam_id", base64_decode($cexam_id))->update("tbl_competitive_exam_master", $udata);
            if ($res) {
                $this->addActivityLog($_SESSION['id'], "Competitive Exam Details of "
                        . $comexamName->exam_name . " is deleted ", "tbl_competitive_exam_master");
                return '{"status":"success","msg":"Deleted successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

//Competitive Exam end
//Ratings Start
    public function mGetRatingDetails() {
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['id'])) {
            return false;
        } else {
            $qry = $this->db->query("Select tr.*,sd.studentName,sd.studentImage,DATE_FORMAT(tr.createdAt,'%d-%b-%y') commentDate,CONCAT(od.orgName,' (',ld.roleName,')') orgdetails from tbl_ratings tr
        INNER JOIN student_details sd on sd.studentId=tr.studentId AND sd.isactive=1
        INNER JOIN organization_details od ON od.loginId=tr.loginId AND od.isactive=1
        INNER JOIN login_details ld ON ld.id=tr.loginId AND ld.isactive=1
        where  tr.isactive=1 order by tr.ratings_Id DESC");
            if ($qry->num_rows() > 0) {
                $result = $qry->result();
            } else {
                $result = "";
            }
            return json_encode($result);
        }
    }

    public function mApproveDisapprove() {
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['id'])) {
            return false;
        } else {
            $ratings_Id = FILTER_VAR(trim($this->input->post('ratings_Id')), FILTER_SANITIZE_STRING);
            $chk = $this->db->where(["ratings_Id" => $ratings_Id, "isactive" => 1])->get("tbl_ratings");
            if ($chk->num_rows() > 0) {
                $isReviewed = $chk->row()->isReviewed;
                $review = ($isReviewed == "0" ? 1 : 0);
                $uData = ["isReviewed" => $review, "updatedAt" => $this->datetimenow()];
                $res = $this->db->where(["ratings_Id" => $ratings_Id])->update("tbl_ratings", $uData);
                ($res ? $this->addActivityLog($_SESSION['id'], "Rating Comment Reviewd", "tbl_ratings") : "");
                return($res ? '{"status":"success","msg":"Updated successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            }
        }
    }

    public function mDelRating() {
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['id'])) {
            return false;
        } else {
            $ratings_Id = FILTER_VAR(trim($this->input->post('ratings_Id')), FILTER_SANITIZE_STRING);
            $chk = $this->db->where(["ratings_Id" => $ratings_Id, "isactive" => 1])->get("tbl_ratings");
            if ($chk->num_rows() > 0) {
                $uData = ["isactive" => 0, "updatedAt" => $this->datetimenow()];
                $res = $this->db->where(["ratings_Id" => $ratings_Id])->update("tbl_ratings", $uData);
                ($res ? $this->addActivityLog($_SESSION['id'], "Rating Comment Deleted", "tbl_ratings") : "");
                return($res ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            }
        }
    }

//Rating End
//Advertise with us Start
    public function mGetadvertiseWithUsDetails() {
        $qry = $this->db->query("SELECT *,DATE_FORMAT(createdAt , '%d-%b-%Y') messagedate
                FROM tbl_advertiseswithus WHERE isactive=1 ORDER BY advtisewu DESC");
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

//Advertise with us end
//TeamMembers Start
    public function mGetTeamMembers() {
        $memberId = FILTER_VAR(trim($this->input->post('memberId')), FILTER_SANITIZE_STRING);
        $condition = ($memberId ? ["isactive" => 1, "memberId" => base64_decode($memberId)] : ["isactive" => 1] );
        $qry = $this->db->where($condition)->get("tbl_teammembers");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $rs) {
                $rs->memberId = base64_encode($rs->memberId);
            }
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mAddRemoveMember() {
        $memberId = FILTER_VAR(trim($this->input->post('memberId')), FILTER_SANITIZE_STRING);
        $memberName = FILTER_VAR(trim($this->input->post('memberName')), FILTER_SANITIZE_STRING);
        $position = FILTER_VAR(trim($this->input->post('position')), FILTER_SANITIZE_STRING);
        $memberEmail = FILTER_VAR(trim($this->input->post('memberEmail')), FILTER_SANITIZE_EMAIL);
        $phoneNo = FILTER_VAR(trim($this->input->post('phoneNo')), FILTER_SANITIZE_NUMBER_INT);
        $memberFbLink = FILTER_VAR(trim($this->input->post('memberFbLink')), FILTER_SANITIZE_URL);
        $memberTtLink = FILTER_VAR(trim($this->input->post('memberTtLink')), FILTER_SANITIZE_URL);
        $memberGpLink = FILTER_VAR(trim($this->input->post('memberGpLink')), FILTER_SANITIZE_URL);
        $aboutMember = FILTER_VAR(trim($this->input->post('aboutMember')), FILTER_SANITIZE_STRING);
        if (empty($memberName) || empty($position) || empty($memberEmail)) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $memberImage = ( isset($_FILES['memberImage']['name']) ? $this->memberImage($this->input->post('memberImageName')) : FILTER_VAR(trim($this->input->post('memberImageName')), FILTER_SANITIZE_STRING) );

        $condition = ( $memberId == "no_one" ? ["memberName" => $memberName, "memberEmail" => $memberEmail, "phoneNo" => $phoneNo] :
                ["memberId!=" => base64_decode($memberId), "memberName" => $memberName, "memberEmail" => $memberEmail, "phoneNo" => $phoneNo, "isactive" => 1]);
        $chk = $this->db->where($condition)->get("tbl_teammembers");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        return $this->insertUpdateTeamMembers($memberId, $memberName, $position, $memberEmail, $phoneNo, $memberImage, $memberFbLink, $memberTtLink, $memberGpLink, $aboutMember);
    }

    private function insertUpdateTeamMembers($memberId, $memberName, $position, $memberEmail, $phoneNo, $memberImage, $memberFbLink, $memberTtLink, $memberGpLink, $aboutMember) {
        if ($memberId == "no_one") {
            $iData = ["memberName" => $memberName, "position" => $position, "memberEmail" => $memberEmail, "phoneNo" => $phoneNo, "memberImage" => $memberImage, "memberFbLink" =>
                $memberFbLink, "memberTtLink" => $memberTtLink, "memberGpLink" => $memberGpLink, "aboutMember" => $aboutMember, "createdAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr(), "isactive" => 1];
            $res = $this->db->insert("tbl_teammembers", $iData);
            ($res ? $this->addActivityLog($_SESSION['id'], "Team Member Details Inserted", "tbl_teammembers") : "" );
            return( $res ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            $chk = $this->db->where(["memberId" => base64_decode($memberId), "isactive" => 1])->get("tbl_teammembers");
            if ($chk->num_rows() > 0) {
                $uData = ["memberName" => $memberName, "position" => $position, "memberEmail" => $memberEmail, "phoneNo" => $phoneNo, "memberImage" => $memberImage, "memberFbLink" => $memberFbLink, "memberTtLink" => $memberTtLink, "memberGpLink" => $memberGpLink, "aboutMember" => $aboutMember, "updateAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr()];
                $res = $this->db->where(["memberId" => base64_decode($memberId), "isactive" => 1])->update("tbl_teammembers", $uData);
                ( $res ? $this->addActivityLog($_SESSION['id'], "Team Member Details Inserted", "tbl_teammembers") :
                                "");
                return($res ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error","msg":"No Details Found."}';
            }
        }
    }

    private function memberImage($prevImg) {
        $this->createDirectory('./projectimages/images/TeamMembers/' . date('Y'));
        $this->createDirectory('./projectimages/images/TeamMembers/' . date('Y') . '/' . date('m'));
        $path = './projectimages/images/TeamMembers/' . date('Y') . '/' . date('m') . '/';
        $imgName = 'Team_' . strtotime(date("Y-m-d H:i:s"));
        $imageName = $this->uploadImage($path, $imgName, 'memberImage');

        if ($imageName != "error" && file_exists(ltrim($prevImg, './'))) {
            unlink(ltrim($prevImg, './'));
        }
        return '/projectimages/images/TeamMembers/' . date('Y') . '/' . date('m') . '/' . $imageName;
    }

    public function mDelTeamMember() {
        $memberId = FILTER_VAR(trim($this->input->post('memberId')), FILTER_SANITIZE_STRING);
        if (empty($memberId)) {
            return '{"status":"error","msg":"Empty details."}';
        }
        $chk = $this->db->where(["memberId" => base64_decode($memberId), "isactive" => 1])->get("tbl_teammembers");
        if ($chk->num_rows() > 0) {
            $uData = ["isactive" => 0, "updateAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr()];
            $resp = $this->db->where(["memberId" => base64_decode($memberId), "isactive" => 1])->update("tbl_teammembers", $uData);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Team Member Details Deleted", "tbl_teammembers") : "");
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"No Details Found."}';
        }
    }

//TeamMembers End
    private function createDirectory($path) {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);

            return 'created';
        } else {
            return 'present';
        }
    }

//Career Details Start
    public function mAddRemoveCarrerDetails() {
        $openingId = FILTER_VAR(trim($this->input->post('openingId')), FILTER_SANITIZE_STRING);
        $openingTitle = FILTER_VAR(trim($this->input->post('openingTitle')), FILTER_SANITIZE_STRING);
        $openingDetails = $this->input->post('openingDetails');
        if (empty($openingTitle) || empty($openingDetails) || empty($openingId) || !isset($_SESSION['id'])
        ) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($openingId == "no_one" ? ["openingTitle" => $openingTitle, "isClosed" => 0, 'isactive' => 1] :
                ["openingId!=" => base64_decode($openingId), "openingTitle" => $openingTitle, "isClosed" => 0, 'isactive' => 1]);
        $chk = $this->db->where($condition)->get("tbl_careersopening");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        return $this->insertUpdateCarrerDetails($openingId, $openingTitle, $openingDetails);
    }

    private function insertUpdateCarrerDetails($openingId, $openingTitle, $openingDetails) {
        if ($openingId == "no_one") {
            $iData = ["openingTitle" => $openingTitle, "openingDetails" => $openingDetails, "createdAt" => $this->datetimenow(), "isClosed" => 0, 'isactive' => 1];
            $resp = $this->db->insert('tbl_careersopening', $iData);
            ($resp ? $this->addActivityLog($_SESSION ['id'], "Career Opening Details Inserted", "tbl_careersopening") : "");
            return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            $chk = $this->db->where(["openingId" => base64_decode($openingId), "isClosed" => 0, 'isactive' => 1])->get("tbl_careersopening");

            if ($chk->num_rows() > 0) {
                $uData = ["openingTitle" => $openingTitle, "openingDetails" => $openingDetails, "updatedAt" => $this->datetimenow()];
                $resp = $this->db->where("openingId", base64_decode($openingId))->update('tbl_careersopening', $uData);
                ($resp ? $this->addActivityLog($_SESSION['id'], "Career Opening Details Updated", "tbl_careersopening") : "");
                return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error","msg":"No Details Found."}';
            }
        }
    }

    public function mGetOpeningDetails() {
        $openingId = FILTER_VAR(trim($this->input->post('openingId')), FILTER_SANITIZE_STRING);
        $condition = ($openingId ? ["isactive" => 1, "openingId" => $openingId] : ["isactive" => 1]);
        $qry = $this->db->select("*,DATE_FORMAT(createdAt,'%d-%b-%Y') createdDate")->where($condition)->get("tbl_careersopening");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $rs) {
                $rs->openingId = base64_encode($rs->openingId);
            }
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mDelOpeningDetails() {
        $openingId = FILTER_VAR(trim($this->input->post('openingId')), FILTER_SANITIZE_STRING);
        if (empty($openingId)) {
            return '{"status":"error","msg":"Empty details."}';
        }
        $chk = $this->db->where(["openingId" => base64_decode($openingId), "isactive" => 1])->get("tbl_careersopening");
        if ($chk->num_rows() > 0) {
            $uData = ["isactive" => 0, "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where(["openingId" => base64_decode($openingId), "isactive" => 1])->update("tbl_careersopening", $uData);

            ($resp ? $this->addActivityLog($_SESSION['id'], "Career Opening Details Deleted", "tbl_careersopening") : "");
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"No Details Found."}';
        }
    }

    public function mCloseOpenOpeningDetails() {
        $openingId = FILTER_VAR(trim($this->input->post('openingId')), FILTER_SANITIZE_STRING);
        $actn = FILTER_VAR(trim($this->input->post('actn')), FILTER_SANITIZE_STRING);
        if (empty($openingId)) {
            return '{"status":"error","msg":"Empty details."}';
        }
        $chk = $this->db->where(["openingId" => base64_decode($openingId), "isactive" => 1])->get("tbl_careersopening");
        if ($chk->num_rows() > 0) {
            $isClosed = ($actn == 'close' ? 1 : 0);
            $openclose = ($actn == 'close' ? "Closed" : "Opened");
            $uData = ["isClosed" => $isClosed, "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where(["openingId" => base64_decode($openingId), "isactive" => 1])->update("tbl_careersopening", $uData);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Career Opening Details " . $openclose . "", "tbl_careersopening") : "");
            return($resp ? '{"status":"success","msg":"' . $openclose . ' successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"No Details Found."}';
        }
    }

    public function mGetJobApplication() {
        $qry = $this->db->query("SELECT tij.*,tco.openingTitle,DATE_FORMAT(tij.createdAt,'%d-%b-%Y') applydate FROM tbl_ihuntjobapplication tij
                                INNER JOIN tbl_careersopening tco ON tco.openingId=tij.openingId AND tco.isactive=1
                                WHERE tij.isactive=1");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $rs) {
                $rs->jobapplicationId = base64_encode($rs->jobapplicationId);
            }
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mMarkasImportant() {
        $jobapplicationId = FILTER_VAR(trim($this->input->post('jobapplicationId')), FILTER_SANITIZE_STRING);
        $important = FILTER_VAR(trim($this->input->post('important')), FILTER_SANITIZE_STRING);
        if (empty($jobapplicationId) || empty($important) || !isset($_SESSION['id'])
        ) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $chk = $this->db->where("jobapplicationId", base64_decode($jobapplicationId))->get("tbl_ihuntjobapplication");
        if ($chk->num_rows() > 0) {
            $imp1 = ($important === "important" ? 1 : 0);
            $uData = ["isImportant" => $imp1, "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where("jobapplicationId", base64_decode($jobapplicationId))->update("tbl_ihuntjobapplication", $uData);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Important mark updated", "tbl_ihuntjobapplication") : "");
            return($resp ? '{"status":"success","msg":"Update successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"No Details Found."}';
        }
    }

    public function mDelJobApplication() {
        $jobapplicationId = FILTER_VAR(trim($this->input->post('jobapplicationId')), FILTER_SANITIZE_STRING);

        if (empty($jobapplicationId) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty details."}';
        }
        $chk = $this->db->where(["jobapplicationId" => base64_decode($jobapplicationId), "isactive" => 1])->get("tbl_ihuntjobapplication");
        if ($chk->num_rows() > 0) {
            $uData = ["isactive" => 0, "updatedAt" => $this->datetimenow()];


            $resp = $this->db->where(["jobapplicationId" => base64_decode($jobapplicationId), "isactive" => 1])->update("tbl_ihuntjobapplication", $uData);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Job application Details Deleted", "tbl_ihuntjobapplication") : "");
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"No Details Found."}';
        }
    }

//Carrer Details End
//Earnandshare created by shweta
    public function mAddearnandshare() {
        $ens_id = FILTER_VAR(trim($this->input->post('ensid')), FILTER_SANITIZE_STRING);
        $amt = FILTER_VAR(trim($this->input->post('amt')), FILTER_SANITIZE_STRING);
// $isactive      =       FILTER_VAR(trim($this->input->post('isactive')),FILTER_SANITIZE_STRING);
        if (empty($ens_id) || empty($amt)) {
            return '{"status":"error","msg":"Required field is empty"}';
        }
        if ($ens_id == "no_one") {

            $chk = $this->db->where(['amount' => $amt, 'isactive' => 1])->get("tbl_earn_n_share_value");
            if ($chk->num_rows() > 0) {
                return '{"status":"error","msg":"Duplicate Details"}';
            }
            $iData = ['amount' => $amt, 'createdAt' => $this->datetimenow(), 'isactive' => 1];
            $res = $this->db->insert("tbl_earn_n_share_value", $iData);
            if ($res) {
                $this->addActivityLog($_SESSION ['id'], "Earn And Share Amount Inserted", "tbl_earn_n_share_value");
                return '{"status":"success","msg":"Saved Successfully."}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mGetearnandshare() {
        $qry = $this->db->query("SELECT * FROM tbl_earn_n_share_value where isactive=1");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $rs) {
                $rs->ensid = base64_encode($rs->ens_value_id);
            }
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mchangeStatus() {
        $ens_value_id = FILTER_VAR(trim($this->input->post('ensid')), FILTER_SANITIZE_STRING);
        $iscurrent = FILTER_VAR(trim($this->input->post('iscurrent')), FILTER_SANITIZE_STRING);
        if (empty($ens_value_id) || $iscurrent == "") {
            return '{"status":"error","msg":"Empty Details."}';
        }
        return ($iscurrent == '1' ? $this->deacticateall($ens_value_id) : $this->checkAvailable($ens_value_id));
    }

    private function deacticateall($ens_value_id) {

        $this->db->where("ens_value_id", $ens_value_id)->update("tbl_earn_n_share_value", ["iscurrent" => 1, "updatedAt" => $this->datetimenow()]);
        $response = $this->db->where("ens_value_id!=", $ens_value_id)->update("tbl_earn_n_share_value", ["iscurrent" => 0, "updatedAt" => $this->datetimenow()]);
        if ($response) {
            $this->addActivityLog($_SESSION['id'], "Earn And Share Status updated", "tbl_earn_n_share_value");
            return '{"status":"success","msg":"Earn And Share Status Changed Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    private function checkAvailable($ens_value_id) {
        $chk = $this->db->where(["ens_value_id!=" => $ens_value_id, "iscurrent" => 1])->get("tbl_earn_n_share_value");
        if ($chk->num_rows() > 0) {
            $response = $this->db->where("ens_value_id", $ens_value_id)->update("tbl_earn_n_share_value", ["iscurrent" => 0, "updatedAt" => $this->datetimenow()]);
            ($response ? $this->addActivityLog($_SESSION['id'], "Earn And Share Status updated", "tbl_earn_n_share_value") : "");
            return($response ? '{"status":"success","msg":"Earn And Share Status Changed Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"Sorry one is required to be active."}';
        }
    }

//end by shweta
//Earnandshare value created by shweta
    public function mGetearnandsharevalue() {
        $qry = $this->db->query("SELECT *,(
                SELECT SUM(ens.amount) FROM student_login tsl1
                INNER JOIN tbl_earn_n_share_value ens on ens.ens_value_id=tsl1.ens_value_id
                WHERE tsl1.my_referer=tsl.my_refer_code AND tsl1.isactive=1
                )ensamount FROM student_login tsl
                WHERE tsl.isactive=1 ORDER BY ensamount DESC");
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

//Earnandshare value end by shweta
//Total Visitor Start
    public function mGetTotalvistor($order, $dir, $search) {
        $totalDataqry = $this->db->query("SELECT count(*) totalcount FROM tbl_totalvisitor WHERE isactive=1");
        $rowData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->row() : "");
        $totalData = ($rowData != "" ? $rowData->totalcount : 0);

        $query = (empty($search) ? $this->db->limit($this->input->post('length'), $this->input->post('start'))->order_by($order, $dir)->get('tbl_totalvisitor') : $this->db->like('totalVisitorId', $search)
                        ->or_like('datenow', $search)->or_like('visitorCount', $search)->limit($this->input->post('length'), $this->input->post('start'))->order_by($order, $dir)->get('tbl_totalvisitor'));
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $queryfd = (!empty($search) ? $this->db->like('totalVisitorId', $search)->or_like('datenow', $search)->or_like('visitorCount', $search)->get('tbl_totalvisitor') : "");

        $totalFiltered = ($queryfd != "" ? $queryfd->num_rows() : $totalData);
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $data[] = ['totalVisitorId' => $post->totalVisitorId, "visitorCount" => $post->visitorCount, "datenow" => date('j M Y h:i a', strtotime($post->datenow))];
            }
        }
        return json_encode(["draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data]);
    }

//Total Visitor End
//Website visitor created by shweta
    public function mGetWebvistor($limit, $start, $order, $dir, $search) {
        $totalDataqry = $this->db->query("SELECT count(*) totalcount FROM tbl_website_visitor WHERE isactive=1");
        $rowData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->row() : "");
        $totalData = ($rowData != "" ? $rowData->totalcount : 0);

        $query = (empty($search) ? $this->db->limit($limit, $start)->order_by($order, $dir)->get('tbl_website_visitor') : $this->db->like('visitorId', $search)
                        ->or_like('countryName', $search)->or_like('totalVisits', $search)->or_like('ipaddress', $search)->limit($limit, $start)->order_by($order, $dir)->get('tbl_website_visitor'));
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $queryfd = (!empty($search) ? $this->db->like('visitorId', $search)->or_like('countryName', $search)->or_like('totalVisits', $search)->or_like('ipaddress', $search)->get('tbl_website_visitor') : "");
        $totalFiltered = ($queryfd != "" ? $queryfd->num_rows() : $totalData);
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $data[] = ["visitorId" => $post->visitorId, "countryName" => $post->countryName, "totalVisits" => $post->totalVisits, "ipaddress" => $post->ipaddress];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }

//Website visitor end by shweta
//News letter plan start by shweta
    public function mGetcurrencies() {
        return $this->db->query("SELECT * FROM currencies");
    }

    public function mAddNewsletterplan() {
        $nlp_Id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $plan_name = FILTER_VAR(trim(ucwords(strtolower($this->input->post('plan_name')))), FILTER_SANITIZE_STRING);
        $no_of_news_ltr = FILTER_VAR(trim($this->input->post('no_of_news_ltr')), FILTER_SANITIZE_NUMBER_INT);
        $price = FILTER_VAR(trim($this->input->post('price')), FILTER_SANITIZE_NUMBER_FLOAT);
        $currencies = FILTER_VAR(trim($this->input->post('currencies')), FILTER_SANITIZE_STRING);
        if (empty($plan_name) || empty($no_of_news_ltr) || empty($price) || empty($currencies)) {
            return '{"status":"error", "msg":"Required field is empty."}';
        } else {
            if ($nlp_Id === "no_one") {
                return $this->insertAddNewsletterplan($plan_name, $no_of_news_ltr, $price, $currencies);
            } else {
                return $this->updateAddNewsletterplan($nlp_Id, $plan_name, $no_of_news_ltr, $price, $currencies);
            }
        }
    }

    private function insertAddNewsletterplan($plan_name, $no_of_news_ltr, $price, $currencies) {
        $chkqry = $this->db->where(["plan_name" => $plan_name, "no_of_news_ltr" => $no_of_news_ltr, "price" => $price, "currencies" => $currencies])->get("tbl_news_ltr_plan");
        $chkqry1 = $this->db->where(["plan_name" => $plan_name])->get("tbl_news_ltr_plan");
        $chkqry2 = $this->db->where(["no_of_news_ltr" => $no_of_news_ltr, "currencies" => $currencies])->get("tbl_news_ltr_plan");
        if ($chkqry->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate"}';
        } elseif ($chkqry1->num_rows() > 0) {
            return '{"status":"error", "msg":"Plan Name Duplicate "}';
        } elseif ($chkqry2->num_rows() > 0) {
            return '{"status":"error", "msg":"No.of News letter And Currency must be different "}';
        } else {
            $data = ["plan_name" => $plan_name, "no_of_news_ltr" => $no_of_news_ltr, "price" => $price, "currencies" => $currencies, "isactive" => 1, "createdAt" => $this->datetimenow()];
            $this->db->insert("tbl_news_ltr_plan", $data);
            $this->addActivityLog($_SESSION['id'], "New Plan" . $plan_name . "(" . $no_of_news_ltr . ") Saved", "tbl_news_ltr_plan");
            return '{"status":"success", "msg":"Saved successfully."}';
        }
    }

    private function updateAddNewsletterplan($nlp_Id, $plan_name, $no_of_news_ltr, $price, $currencies) {
        $this->db->where(["nlp_Id!=" => $nlp_Id, "plan_name" => $plan_name, "no_of_news_ltr" => $no_of_news_ltr, "price" => $price, "currencies" => $currencies, "isactive" => 1]);
        $chkqry = $this->db->get("tbl_news_ltr_plan");
        $res = "";
        if ($chkqry->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate"}';
        } else {
            $data = ["plan_name" => $plan_name, "no_of_news_ltr" => $no_of_news_ltr, "price" => $price, "currencies" => $currencies, "isactive" => 1, "updatedAt" => $this->datetimenow()];
            $res = $this->db->where("nlp_Id", $nlp_Id)->update("tbl_news_ltr_plan", $data);
            ($res ? $this->addActivityLog($_SESSION['id'], "New Plan" . $plan_name . "(" . $no_of_news_ltr . ") Update", "tbl_news_ltr_plan") : "");
            return ($res ? '{"status":"success", "msg":"Update successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mGetNewsletterplan() {
        $nlp_Id = FILTER_VAR(trim($this->input->post('nlp_Id')), FILTER_SANITIZE_STRING);
        if ($nlp_Id) {
            $qry = $this->db->query("SELECT * FROM tbl_news_ltr_plan WHERE nlp_Id='$nlp_Id'");
        } else {
            $qry = $this->db->query("SELECT * FROM tbl_news_ltr_plan");
        }
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mDelNewsletterplan() {
        $nlp_Id = FILTER_VAR(trim($this->input->post('nlp_Id')), FILTER_SANITIZE_STRING);
        $qry = $this->db->where("nlp_Id", $nlp_Id)->get("tbl_news_ltr_plan");
        if ($qry->num_rows() > 0) {
            $newsletterplan = $qry->row();
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];

            $res = $this->db->where("nlp_Id", $nlp_Id)->update("tbl_news_ltr_plan", $udata);
            if ($res) {
                $this->addActivityLog($_SESSION['id'], "News Letter Plan Details of " . $newsletterplan->plan_name . " is deleted ", "tbl_news_ltr_plan");
                return '{"status":"success","msg":"Deleted successfully!"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

//News letter plan end by shweta
//News letter plan buy start by shweta
    public function mGetnewsletterplanbuy() {
        $response = $this->db->query("SELECT nlpb.* ,DATE_FORMAT(nlpb.buy_date,'%d-%b-%Y') as buyDate,nlp.nlp_Id,nlp.plan_name,nlp.no_of_news_ltr,nlp.price,nlp.currencies,ld.id,ld.email,ld.roleName
        FROM tbl_news_ltr_plan_buy nlpb
        INNER JOIN tbl_news_ltr_plan nlp ON nlp.nlp_Id=nlpb.nlp_Id AND nlp.isactive=1
        INNER JOIN login_details ld ON ld.id=nlpb.loginId AND ld.isactive=1");
        if ($response->num_rows() > 0) {
            $result = $response->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

//News letter plan buy end by shweta
//FAQ start
    public function mAddFaqCategories() {
        $faqCategoryId = FILTER_VAR(trim($this->input->post('faqCategoryId')), FILTER_SANITIZE_STRING);
        $categoryName = FILTER_VAR(trim(ucfirst(strtolower($this->input->post('categoryName')))), FILTER_SANITIZE_STRING);
        if (empty($faqCategoryId) || !isset($_SESSION['id']) || empty($categoryName)) {
            return '{"status":"error", "msg":"Required Fields are empty."}';
        }
        $condition = ($faqCategoryId == 'no_one' ? ["categoryName" => $categoryName] : ["faqCategoryId!=" => base64_decode($faqCategoryId), "categoryName" => $categoryName]);
        $chk = $this->db->where($condition)->get("tbl_faq_category");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate"}';
        }
        if ($faqCategoryId == 'no_one') {
            $idata = ["categoryName" => $categoryName, "isactive" => 1];
            $resp = $this->db->insert("tbl_faq_category", $idata);
        } else {
            $idata = ["categoryName" => $categoryName, "isactive" => 1];
            $resp = $this->db->where('faqCategoryId', base64_decode($faqCategoryId))->update("tbl_faq_category", $idata);
        }
        ($resp ? $this->addActivityLog($_SESSION['id'], "Faq category added", "tbl_faq_category") : "");
        return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetCategories() {
        $faqCategoryId = FILTER_VAR(trim(base64_decode($this->input->post('faqCategoryId'))), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id'])) {
            return false;
        }
        $condition = ($faqCategoryId ? ["faqCategoryId" => $faqCategoryId, "isactive" => 1] : ["isactive" => 1]);
        $qry = $this->db->where($condition)->get("tbl_faq_category");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $qr) {
                $qr->faqCategoryId = base64_encode($qr->faqCategoryId);
            }
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mDelCategories() {
        $faqCategoryId = FILTER_VAR(trim(base64_decode($this->input->post('faqCategoryId'))), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($faqCategoryId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $qry = $this->db->where(["faqCategoryId" => $faqCategoryId, "isactive" => 1])->get("tbl_faq_category");
        if ($qry->num_rows() > 0) {
            $uData = ["isactive" => 0];
            $resp = $this->db->where('faqCategoryId', $faqCategoryId)->update("tbl_faq_category", $uData);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Faq category deleted", "tbl_faq_category") : "");
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Details not found"}';
        }
    }

    public function maddFaqQA() {
        $faqCategoryId = FILTER_VAR(trim(base64_decode($this->input->post('faqCategoryId'))), FILTER_SANITIZE_STRING);
        $faqQuestion = FILTER_VAR(trim($this->input->post('faqQuestion')), FILTER_SANITIZE_STRING);
        $faqAnswer = FILTER_VAR($this->input->post('faqAnswer'), FILTER_SANITIZE_STRING);
        $faqId = FILTER_VAR(trim($this->input->post('faqId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($faqCategoryId) || empty($faqQuestion) || empty($faqAnswer) || empty($faqId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $condition = ($faqId == "no_one" ? ["faqCategoryId" => $faqCategoryId, "faqQuestion" => $faqQuestion, "isactive" => 1] :
                ["faqId!=" => base64_decode($faqId), "faqCategoryId" => $faqCategoryId, "faqQuestion" => $faqQuestion, "isactive" => 1]);
        $chk = $this->db->where($condition)->get("tbl_faq");
        if (
                $chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate"}';
        } else {
            return $this->insertUpdateFaq($faqCategoryId, $faqQuestion, $faqAnswer, $faqId);
        }
    }

    private function insertUpdateFaq($faqCategoryId, $faqQuestion, $faqAnswer, $faqId) {
        if ($faqId == "no_one") {
            $idata = ["faqCategoryId" => $faqCategoryId, "faqQuestion" => $faqQuestion, "faqAnswer" => $faqAnswer, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->insert("tbl_faq", $idata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Faq Question added", "tbl_faq") : "");
        } else {
            $udata = ["faqCategoryId" => $faqCategoryId, "faqQuestion" => $faqQuestion, "faqAnswer" => $faqAnswer, "updatedAt" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->where("faqId", base64_decode($faqId))->update("tbl_faq", $udata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Faq Question updated", "tbl_faq") : "");
        }
        return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetFaqQA() {
        $faqId = FILTER_VAR(trim($this->input->post('faqId')), FILTER_SANITIZE_STRING);
        $condition = ($faqId ? " AND faqId=" . base64_decode($faqId) . "" : "");
        $qry = $this->db->query("SELECT * FROM tbl_faq tf INNER JOIN tbl_faq_category tfc on tfc.faqCategoryId=tf.faqCategoryId WHERE tf.isactive=1 $condition");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $qr) {
                $qr->faqId = base64_encode($qr->faqId);
                $qr->faqCategoryId = base64_encode($qr->faqCategoryId);
            }
            $result = $qry->result();
        } else {
            $result = '';
        }
        return json_encode($result);
    }

    public function mDelFAQ() {
        $faqId = FILTER_VAR(trim(base64_decode($this->input->post('faqId'))), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($faqId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $qry = $this->db->where(["faqId" => $faqId, "isactive" => 1])->get("tbl_faq");
        if ($qry->num_rows() > 0) {
            $uData = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where('faqId', $faqId)->update("tbl_faq", $uData);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Faq Question deleted", "tbl_faq") : "");
            return( $resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            return '{"status":"error", "msg":"Details not found"}';
        }
    }

//FAQ end
//promocode start
    public function mAddPromocodeMasterDetails() {
        $promocodeId = FILTER_VAR(trim($this->input->post('promocodeId')), FILTER_SANITIZE_STRING);
        $price = FILTER_VAR(trim($this->input->post('price')), FILTER_SANITIZE_NUMBER_INT);
        $isApplicable = FILTER_VAR(trim($this->input->post('isApplicable')), FILTER_SANITIZE_NUMBER_INT);
        if (!isset($_SESSION['id']) || empty($promocodeId) || empty($price)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $condition = ($promocodeId == "no_one" ? ["price" => $price, "isactive" => 1] : ["promocodeId!=" => base64_decode($promocodeId),
            "price" => $price, "isactive" => 1]);
        $chk = $this->db->where($condition)->get("tbl_promocodemaster");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate"}';
        }
        return $this->addUpdatePromocodeDetails($promocodeId, $price, $isApplicable);
    }

    private function addUpdatePromocodeDetails($promocodeId, $price, $isApplicable) {
        if ($promocodeId == "no_one") {
            $idata = ["price" => $price, "createdAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr(), "isactive" => 1];
            $resp = $this->db->insert("tbl_promocodemaster", $idata);
            $id = $this->db->insert_id();
            ($isApplicable ? $this->changeIsapplicable($id) : "");
            ($resp ? $this->addActivityLog($_SESSION['id'], "Promocode master details added", "tbl_promocodemaster") : "");
        } else {
            $result = $this->checkPromoCode(base64_decode($promocodeId));
            if ($result) {
                $udata = ["price" => $price, "updatedAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr()];
                $resp = $this->db->where("promocodeId", base64_decode($promocodeId))->update("tbl_promocodemaster", $udata);
                ($isApplicable ? $this->changeIsapplicable(base64_decode($promocodeId)) : "");
                ($resp ? $this->addActivityLog($_SESSION['id'], "Promocode master details updated", "tbl_promocodemaster") : "");
            } else {
                return '{"status":"error","msg":"One promocode is must required"}';
            }
        }
        return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    private function checkPromoCode($promocodeId) {
        $chk = $this->db->where(["promocodeId!=" => $promocodeId, "isApplicable" => 1, "isactive" => 1])->get("tbl_promocodemaster");
        if ($chk->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function changeIsapplicable($id) {
        $check = $this->db->where(["promocodeId" => $id, "isactive" => 1])->get("tbl_promocodemaster");
        if ($check->num_rows() > 0) {
            $this->db->where("isactive", 1)->update("tbl_promocodemaster", ["isApplicable" => 0]);
            $this->db->where(["promocodeId" => $id, "isactive" => 1])->update("tbl_promocodemaster", ["isApplicable" => 1]);

            return true;
        } else {
            return false;
        }
    }

    public function mGetPromocodeMasterDetails() {
        $promocodeId = FILTER_VAR(trim($this->input->post('promocodeId')), FILTER_SANITIZE_STRING);
        $condition = ( $promocodeId == "" ? ["isactive" => 1] : ["promocodeId" => base64_decode($promocodeId), "isactive" => 1]);
        $qry = $this->db->where($condition)->select("*,DATE_FORMAT(createdAt,'%d-%b-%Y') aDate,DATE_FORMAT(updatedAt,'%d-%b-%Y') uDate")->get("tbl_promocodemaster");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $qr) {
                $qr->promocodeId = base64_encode($qr->promocodeId);
            }
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mDelPromoCode() {
        $promocodeId = FILTER_VAR(trim(base64_decode($this->input->post('promocodeId'))), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($promocodeId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $chk = $this->db->where(["promocodeId" => $promocodeId, "isactive" => 1])->get("tbl_promocodemaster");
        if ($chk->num_rows() > 0) {
            $result = $this->checkPromoCode($promocodeId);
            if ($result) {
                $udata = ["updatedAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr(), "isactive" => 0];
                $resp = $this->db->where(["promocodeId" => $promocodeId])->update("tbl_promocodemaster", $udata);
                ( $resp ? $this->addActivityLog($_SESSION['id'], "Promocode master details Deleted", "tbl_promocodemaster") : "" );
                return( $resp ? '{"status":"success","msg":"Deleted successfully!"}' :
                        '{"status":"error","msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error","msg":"One promocode is must required.Please activate one before delete."}';
            }
        }
    }

    public function mActiveDeactive() {
        $promocodeId = FILTER_VAR(trim(base64_decode($this->input->post('promocodeId'))), FILTER_SANITIZE_STRING);
        $value = FILTER_VAR(trim($this->input->post('value')), FILTER_SANITIZE_STRING);
        if ($value == "0") {
            $chk = $this->checkPromoCode($promocodeId);
            if ($chk) {
                $resp = $this->db->where(["promocodeId" => $promocodeId, "isactive" => 1])->update("tbl_promocodemaster", ["isApplicable" => 0]);
                ($resp ? $this->addActivityLog($_SESSION['id'], "Promocode deactivated", "tbl_promocodemaster") : "" );
                return($resp ? '{"status":"success","msg":"Promocode deactivated successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error","msg":"One promocode is must required.Please activate one before deactivate."}';
            }
        } else {
            $resp = $this->changeIsapplicable($promocodeId);
            ( $resp ? $this->addActivityLog($_SESSION['id'], "Promocode activated", "tbl_promocodemaster") : "");
            return( $resp ? '{"status":"success","msg":"Promocode activated successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        }
    }

//promocode end
//testimonial start
    public function mgetTestimonials() {
        $testimonialId = FILTER_VAR(trim($this->input->post('testimonialId')), FILTER_SANITIZE_STRING);
        if ($testimonialId == 'all') {
            $qry = $this->db->where(["isactive" => 1])->get("tbl_testimonial");
        } else {
            $qry = $this->db->where(["testimonialId" => $testimonialId, "isactive" => 1])->get("tbl_testimonial");
        }
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = '';
        }
        return json_encode($result);
    }

    public function meditTestimonials() {
        $testimonialId = FILTER_VAR(trim($this->input->post('testimonialId')), FILTER_SANITIZE_STRING);
        $userName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('userName')))), FILTER_SANITIZE_STRING);
        $userHeadline = FILTER_VAR(trim(ucwords(strtolower($this->input->post('userHeadline')))), FILTER_SANITIZE_STRING);
        $userText = $this->input->post('userText');

        if (empty($testimonialId) || empty($userName) || empty($userName) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $condition = ( $testimonialId == "no_one" ? ["userName" => $userName, "userHeadline" => $userHeadline, "isactive" => 1] :
                ["testimonialId!=" => $testimonialId, "userName" => $userName, "userHeadline" => $userHeadline, "isactive" => 1]);
        $chk = $this->db->where($condition)->get("tbl_testimonial");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details!"}';
        }
        return $this->editInsertTestimonials($testimonialId, $userName, $userHeadline, $userText);
    }

    private function editInsertTestimonials($testimonialId, $userName, $userHeadline, $userText) {
        $prevImage = FILTER_VAR(trim($this->input->post('prevImage')), FILTER_SANITIZE_STRING);
        if (isset($_FILES['userImage']['name'])) {
            $path = './projectimages/images/Testimonial/' . date('Y') . '/' . date('m') . '/';
            $this->createDirectory($path);

            $testimonialImage = $this->uploadImage($path, "Testimonial_" . strtotime($this->datetimenow()), 'userImage');
            if ($testimonialImage == "error") {
                return '{"status":"error","msg":"Image Upload error!"}';
            } else {
                (file_exists(ltrim($prevImage, './')) ? unlink(rtrim($prevImage, './')) : "" );
                $testimonialImage = $path . $testimonialImage;
            }
        } else {
            $testimonialImage = $prevImage;
        }
        $idata = ["userName" => $userName, "userImage" => $testimonialImage, "userHeadline" => $userHeadline,
            "userText" => $userText, "userId" => $_SESSION['id'], "userRole" => "Admin", "isactive" => 1];
        $resp = ($testimonialId == "no_one" ? $this->db->insert("tbl_testimonial", array_merge($idata, ["createdAt" => $this->datetimenow()])) :
                $this->db->where(["testimonialId" => $testimonialId, "isactive" => 1])->update("tbl_testimonial", array_merge($idata, ["updatedAt" => $this->datetimenow()])) );

        ( $resp ? $this->addActivityLog($_SESSION['id'], "Testimonial details Inserted", "tbl_testimonial") : "");
        return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mDelTestimonial() {
        $testimonialId = FILTER_VAR(trim($this->input->post('testimonialId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($testimonialId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $chk = $this->db->where(["testimonialId" => $testimonialId, "isactive" => 1
                ])->get("tbl_testimonial");
        if ($chk->num_rows() > 0) {
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where(["testimonialId" => $testimonialId, "isactive" => 1])->update("tbl_testimonial", $udata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Testimonial details Deleted", "tbl_testimonial") : "" );
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            return($resp ? '{"status":"success","msg":"No records found!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//testimonial end
//Blog Start
    public function mInsertBlogCategory() {
        $catId = FILTER_VAR(trim($this->input->post('catId')), FILTER_SANITIZE_STRING);
        $catName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('catName')))), FILTER_SANITIZE_STRING);
        if (empty($catId) || empty($catName) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $condition = ($catId == "no_one" ? ["catName" => $catName, "isactive" => 1] : ["catId" => $catId, "catName" => $catName, "isactive" => 1]);
        $chk = $this->db->where($condition)->get("tbl_blog_cat");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details!"}';
        }
        if ($catId == "no_one") {
            $res = $this->db->insert("tbl_blog_cat", ["catName" => $catName, "createdAt" => $this->datetimenow(), "isactive" => 1]);
        } else {
            $res = $this->db->where(["catId" => $catId])->update("tbl_blog_cat", ["catName" => $catName, "updatedAt" => $this->datetimenow()]);
        }
        ($res ? $this->addActivityLog($_SESSION['id'], "Blog category details inserted", "tbl_blog_cat") : "" );
        return($res ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
    }

    public function mgetBlogCategories() {
        $catId = FILTER_VAR(trim($this->input->post('catId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Un authorised Access!"}';
        } else {
            $condition = ($catId ? ["catId" => $catId, "isactive" => 1] : ["isactive" => 1]);
            $result = $this->db->where($condition)->order_by("catName asc")->get("tbl_blog_cat");
            if ($result->num_rows() > 0) {
                $response = $result->result();
            } else {
                $response = '';
            }
            return json_encode($response);
        }
    }

    public function mDelBlogCategory() {
        $catId = FILTER_VAR(trim($this->input->post('catId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($catId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $chk = $this->db->where(["catId" => $catId, "isactive" => 1])->get("tbl_blog_cat");
        if ($chk->num_rows() > 0) {
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where(["catId" => $catId, "isactive" => 1])->update("tbl_blog_cat", $udata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Blog category details Deleted", "tbl_blog_cat") : "" );
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            return($resp ? '{"status":"success","msg":"No records found!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mInsertBlogs($blogId, $blogcatId, $blogTitle, $blogDesp, $prevImage) {
        if (isset($_FILES['blogImage']['name'])) {
            $path = './projectimages/images/BlogImages/' . date('Y') . '/' . date('m') . '/';
            $this->createDirectory($path);
            $blogImage = $this->uploadBlogImage($path, "Blog_" . strtotime($this->datetimenow()), 'blogImage', 800);
            if ($blogImage == "error") {
                return '{"status":"error","msg":"Image Upload error!"}';
            } else {
                (file_exists(ltrim($prevImage, './')) ? unlink(rtrim($prevImage, './')) : "");
                $blogImage = $path . $blogImage;
            }
        } else {
            $blogImage = $prevImage;
        }

        $chk = $this->db->where(array_merge(["blogcatId" => $blogcatId, "blogTitle" => $blogTitle, "isactive" => 1], ($blogId == "no_one" ? [] : ["blogId!=" => $blogId])))->get("tbl_blog");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details!"}';
        }
        return $this->editInsertBlogs($blogId, $blogcatId, $blogTitle, $blogDesp, $blogImage);
    }

    private function editInsertBlogs($blogId, $blogcatId, $blogTitle, $blogDesp, $blogImage) {
        if ($blogId == "no_one") {
            $idata = ["blogcatId" => $blogcatId, "blogTitle" => $blogTitle, "blogImage" => $blogImage, "blogDesp" => $blogDesp, "userId" => $_SESSION['id'],
                "userType" => "Admin", "createdAt" => $this->datetimenow(), "blogStatus" => 1, "isactive" => 1];
            $resp = $this->db->insert("tbl_blog", $idata);
        } else {
            $idata = ["blogcatId" => $blogcatId, "blogTitle" => $blogTitle, "blogImage" => $blogImage, "blogDesp" => $blogDesp,
                "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where(["blogId" => $blogId, "isactive" => 1])->update("tbl_blog", $idata);
        }
        ($resp ? $this->addActivityLog($_SESSION['id'], "Blog posted by Super Admin", "tbl_blog") : "" );
        return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
    }

    public function mGetBlogsDetails() {
        $blogId = FILTER_VAR(trim($this->input->post('blogId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Un authorised Access!"}';
        }
        $condition = ($blogId ? " AND tb.blogId=$blogId" : "");
        $result = $this->db->query("SELECT tb.blogId,tb.blogcatId,tb.blogTitle,tb.blogImage,tb.blogDesp,tb.userType,CONCAT(od.orgName,' (',DATE_FORMAT(tb.createdAt,'%d-%b-%y'),')') addedBy,tbc.catName,tb.blogStatus FROM tbl_blog tb
            INNER JOIN tbl_blog_cat tbc ON tbc.catId=tb.blogcatId INNER JOIN login_details ld ON ld.id=tb.userId AND tb.userType=ld.roleName
            INNER JOIN organization_details od ON od.loginId=ld.id WHERE tb.isactive=1 $condition
    UNION   SELECT tb.blogId,tb.blogcatId,tb.blogTitle,tb.blogImage,tb.blogDesp,tb.userType,CONCAT(wu.userName,' (',DATE_FORMAT(tb.createdAt,'%d-%b-%y'),')') addedBy,tbc.catName,tb.blogStatus FROM tbl_blog tb
            INNER JOIN tbl_blog_cat tbc ON tbc.catId=tb.blogcatId INNER JOIN web_users wu ON wu.id=tb.userId AND tb.userType='Admin' WHERE tb.isactive=1 $condition");
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $rs) {
                $rs->blogDesp = ($blogId == "" ? substr(strip_tags($rs->blogDesp), 0, 50) : $rs->blogDesp);
            }
            return json_encode($result->result());
        } else {
            return json_encode("");
        }
    }

    public function mChangeBlogStatus() {
        $blogId = FILTER_VAR(trim($this->input->post('blogId')), FILTER_SANITIZE_STRING);
        $status = FILTER_VAR(trim($this->input->post('status')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || $blogId == "" || $status == "") {
            return '{"status":"error","msg":"Required details are empty"}';
        }
        $chk = $this->db->where(["blogId" => $blogId, "isactive" => 1])->get("tbl_blog");
        if ($chk->num_rows() > 0) {
            $udata = ["blogStatus" => $status, "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where(["blogId" => $blogId, "isactive" => 1])->update("tbl_blog", $udata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Blog Status updated to " . ($status == 0 ? 'UnApprove' :
                                            ($status == 1 ? 'Approve' : ($status == 2 ? 'Reject' : ''))) . "", "tbl_blog") : "");
            return($resp ? '{"status":"success","msg":"Staus changed successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"Blog not found."}';
        }
    }

    public function mDelBlog() {
        $blogId = FILTER_VAR(trim($this->input->post('blogId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($blogId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $chk = $this->db->where(["blogId" => $blogId, "isactive" => 1])->get("tbl_blog");
        if ($chk->num_rows() > 0) {
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where(["blogId" => $blogId, "isactive" => 1])->update("tbl_blog", $udata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Blog details Deleted", "tbl_blog") : "");
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return($resp ? '{"status":"success","msg":"No records found!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Blog End
//Image Upload start
    private function uploadBlogImage($path, $imgName, $uploadfname, $size) {
        $config = ['upload_path' => $path, 'allowed_types' => "gif|jpg|png|jpeg|JPG|JPEG|PNG|GIF", "file_name" => $imgName];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($uploadfname) == false) {
//$error = array('error' => $this->upload->display_errors());
//$error['error'];
// $error->error;
//print_r($error); exit();
            return 'error';
        } else {
            $data = $this->upload->data();
            $newImage = $data['file_name'];
            $config = ['image_library' => "gd2", 'source_image' => $path . $newImage, 'new_image' => $path . $newImage, "create_thumb" => false, "maintain_ratio" => true, "quality" => 100, "width" => $size];
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                $this->image_lib->display_errors();
                return "error";
            } else {
                return $newImage;
            }
        }
    }

//Image Upload end
//Before You Begin Start
    public function mEditInsetBeforeYouBegin() {
        $bybId = FILTER_VAR(trim($this->input->post('bybId')), FILTER_SANITIZE_STRING);
        $beforeYouBegin = $this->input->post('beforeYouBegin');
        if (!isset($_SESSION['id']) || $beforeYouBegin == "") {
            return '{"status":"error","msg":"Required details are empty"}';
        }

        $chk = $this->db->where(["isactive" => 1])->get("tbl_beforyoubegin");
        if ($chk->num_rows() > 0) {
            $bybId = $chk->row()->bybId;
            $udata = ["bybText" => $beforeYouBegin, "updatedOn" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->where("bybId", $bybId)->update("tbl_beforyoubegin", $udata);
        } else {
            $udata = ["bybText" => $beforeYouBegin, "createdOn" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->insert("tbl_beforyoubegin", $udata);
        }
        ($resp ? $this->addActivityLog($_SESSION['id'], "Before You Begin Inserted", "tbl_beforyoubegin") : "" );
        return($resp ? '{"status":"success","msg":"Saved successfully!"}' :
                '{"status":"error","msg":"Error in server, please contact admin!"}' );
    }

    public function mGetBeforeYouBegin() {
        $qry = $this->db->where("isactive", 1)->get("tbl_beforyoubegin");
        if ($qry->num_rows() > 0) {
            $result = $qry->row();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

//Before you Begin end
//pageRequest start
    public function mGetPageRequests($reqType) {
        $pageId = FILTER_VAR(trim($this->input->post('pageId')), FILTER_SANITIZE_STRING);
        if (!empty($pageId)) {
            $qry = $this->db->where(["pageId" => $pageId, "isactive" => 1])->get("pages");
            $result = ($qry->num_rows() > 0 ? $qry->row() : "" );
            return json_encode($result);
        } else {

            $qry = $this->db->query("SELECT tp.pageId,tp.paymentAmount,tp.paymentStatus,tp.pageName,tp.approvalStatus,DATE_FORMAT(tp.date,'%d-%b-%Y') addedOn,
            DATE_FORMAT(tp.createdAt,'%d-%b-%Y') createdOn,od.orgType,od.orgName FROM pages tp
            INNER JOIN organization_details od ON od.loginId=tp.loginId AND od.isactive=1
            INNER JOIN login_details ld ON ld.id=tp.loginId AND od.isactive=1
            WHERE tp.isactive=1 AND tp.approvalStatus='$reqType' ORDER BY tp.createdAt ASC");
            $result = ($qry->num_rows() > 0 ? $qry->result() : "");
            return json_encode($result);
        }
    }

    public function mChangeApprovalStatus() {
        $pageId = FILTER_VAR(trim($this->input->post('pageId')), FILTER_SANITIZE_STRING);
        $approvalStatus = FILTER_VAR(trim($this->input->post('approvalStatus')), FILTER_SANITIZE_STRING);
        $paymentLink = FILTER_VAR(trim($this->input->post('paymentLink')), FILTER_SANITIZE_STRING);
        $paymentAmount = FILTER_VAR(trim($this->input->post('paymentAmount')), FILTER_SANITIZE_STRING);
        $chk = $this->db->where(["pageId" => $pageId, "isactive" => 1])->get("pages");
        if ($chk->num_rows() > 0) {
            $udata = ["approvalStatus" => $approvalStatus, "paymentLink" => $paymentLink, "paymentAmount" => $paymentAmount,
                "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where(["pageId" => $pageId, "isactive" => 1])->update("pages", $udata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Page approval status changed to " . $approvalStatus, "pages") : "" );
            return($resp ? '{"status":"success","msg":"Changed successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            return '{"status":"error","msg":"Sorry details not found."}';
        }
    }

//pageRequest end
//Help Menu Start
    public function mAddhelpcategory() {
        $categoryName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('categoryName')))), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($categoryName)) {
            return '{"status":"error","msg":"Required details are empty."}';
        }
        $chk = $this->db->where(["categoryName" => $categoryName, "parentId" => "0", "isactive" => 1])->get("tbl_helpcategory");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate entry."}';
        } else {
            $idata = ["categoryName" => $categoryName, "parentId" => "0", "isactive" => 1];
            $resp = $this->db->insert("tbl_helpcategory", $idata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "New Category added named " . $categoryName . "", "tbl_helpcategory") : "");
            return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mGetHelpCategories() {
        $helpId = FILTER_VAR(trim(ucwords(strtolower($this->input->post('helpId')))), FILTER_SANITIZE_STRING);
        $parentId = FILTER_VAR(trim(ucwords(strtolower($this->input->post('parentId')))), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || $parentId == "") {
            return '{"status":"error","msg":"Required details are empty."}';
        }
        $condition = ($helpId == "" ? "isactive=1 AND parentId=$parentId" : "isactive=1 AND helpId=$helpId");
        $qry = $this->db->where($condition)->get("tbl_helpcategory");
        $result = ($qry->num_rows() > 0 ? $qry->result() : "");
        return json_encode($result);
    }

    public function mAddhelpsubcategory() {
        $categoryId = FILTER_VAR(trim(ucwords(strtolower($this->input->post('categoryId')))), FILTER_SANITIZE_STRING);
        $subcategoryName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('subcategoryName')))), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($categoryId) || empty($subcategoryName)) {
            return '{"status":"error","msg":"Required details are empty."}';
        }
        $chk = $this->db->where(["categoryName" => $subcategoryName, "parentId" => $categoryId, "isactive" => 1])->get("tbl_helpcategory");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate entry."}';
        } else {
            $idata = ["categoryName" => $subcategoryName, "parentId" => $categoryId, "isactive" => 1];
            $resp = $this->db->insert("tbl_helpcategory", $idata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "New Sub Category added named " . $subcategoryName . "", "tbl_helpcategory") : "" );
            return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        }
    }

    public function mAddHelpMenu() {
        $helptextId = FILTER_VAR(trim($this->input->post('helptextId')), FILTER_SANITIZE_STRING);
        $categoryId = FILTER_VAR(trim($this->input->post('categoryId')), FILTER_SANITIZE_STRING);
        $subcategoryId = FILTER_VAR(trim($this->input->post('subcategoryId')), FILTER_SANITIZE_STRING);
        $heading = FILTER_VAR(trim($this->input->post('heading')), FILTER_SANITIZE_STRING);
        $helpContent = $this->input->post('helpContent');
        if (!isset($_SESSION['id']) || empty($helptextId) || empty($categoryId) || empty($subcategoryId) || empty($heading) || empty($helpContent)) {
            return '{"status":"error","msg":"Required details are empty."}';
        }
        $condition = ($helptextId == "no_one" ? ["categoryId" => $categoryId, "subcategoryId" => $subcategoryId, "heading" => $heading, "isactive" => 1] :
                ["helptextId!=" => $helptextId, "categoryId" => $categoryId, "subcategoryId" => $subcategoryId, "heading" => $heading, "isactive" => 1]);
        $chk = $this->db->where($condition)->select("helptextId")->get("tbl_helptext");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate details."}';
        } else {
            return $this->insertUpdateHelpMenu($helptextId, $categoryId, $subcategoryId, $heading, $helpContent);
        }
    }

    private function insertUpdateHelpMenu($helptextId, $categoryId, $subcategoryId, $heading, $helpContent) {
        if ($helptextId == "no_one") {
            $idata = ["categoryId" => $categoryId, "subcategoryId" => $subcategoryId, "heading" => $heading, "helpContent" => $helpContent,
                "createdAt" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->insert("tbl_helptext", $idata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Help Content added for " . $heading . "", "tbl_helptext") :
                            "");
            return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            $udata = ["categoryId" => $categoryId, "subcategoryId" => $subcategoryId, "heading" => $heading, "helpContent" => $helpContent,
                "createdAt" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->where(["helptextId" => $helptextId, "isactive" => 1])->update("tbl_helptext", $udata);
            ($resp ? $this->addActivityLog($_SESSION['id'], "Help Content updated for " . $heading . "", "tbl_helptext") : "");
            return($resp ? '{"status":"success","msg":"updated successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mGetHelpMenu($start, $order) {
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->helpMenuQuery("count", "", "", "", "", "");
        $totalFiltered = $totalData;
        if (empty($this->input->post('search')['value'])) {
            $posts = $this->helpMenuQuery("all", $this->input->post('length'), $start, $order, $dir, "");
        } else {
            $posts = $this->helpMenuQuery("all", $this->input->post('length'), $start, $order, $dir, $this->input->post('search')['value']);
            $totalFiltered = $this->helpMenuQuery("count", "", "", "", "", $this->input->post('search')['value']);
        }
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $btn = '<a href="javascript:" onclick="editfunction(' . $post->helptextId . ')"><i class="fa fa-edit btn-primary btn-sm"></i></a> &nbsp;';
                $btn = $btn . '<a href="javascript:" onclick="deletefunction(' . $post->helptextId . ')"><i class="fa fa-trash-o btn-danger btn-sm"></i></a>';
                $data[] = ["serialNumber" => ++$start, "CategoryName" => $post->CategoryName . "-" . $post->SubCategoryName, "SubCategoryName" => $post->SubCategoryName,
                    "heading" => $post->heading, "helpContent" => $post->helpContent, "categoryId" => $post->categoryId, "subcategoryId" => $post->subcategoryId, "numberofhits" => $post->numberofhits, "actionbtns" => $btn];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }

    private function helpMenuQuery($type, $limit, $start, $order, $dir, $search) {
        if ($type == "count") {
            $condition = ($search !== "" ? " AND (tht.helptextId LIKE '%$search%' OR tht.heading LIKE '%$search%' OR tht.helpContent LIKE '%$search%'
                 OR thc.categoryName LIKE '%$search%'  OR th.categoryName LIKE '%$search%')" : "");
            $qry = $this->db->query("SELECT count(*) totalCount FROM tbl_helptext tht
                        INNER JOIN tbl_helpcategory th ON th.helpId=tht.categoryId AND th.parentId=0 AND th.isactive=1
                        INNER JOIN tbl_helpcategory thc ON thc.helpId=tht.subcategoryId AND thc.parentId=tht.categoryId AND th.isactive=1
                        WHERE tht.isactive=1 $condition");
            $rowData = ($qry->num_rows() > 0 ? $qry->row() :
                    "");
            return($rowData == "" ? 0 : $rowData->totalCount );
        } else {
            $condition = " AND (tht.helptextId LIKE '%$search%' OR tht.heading LIKE '%$search%' OR tht.helpContent LIKE '%$search%' OR thc.categoryName LIKE '%$search%'  OR th.categoryName LIKE '%$search%')";
            $condition = $condition . ($dir !== "" && $order !== "" ? " ORDER by $order $dir " : "");
            $condition = $condition . ($limit !== "" && $start !== "" ? " LIMIT $start,$limit" : "");
            $qry = $this->db->query("SELECT tht.*,th.categoryName CategoryName,thc.categoryName SubCategoryName FROM tbl_helptext tht
                            INNER JOIN tbl_helpcategory th ON th.helpId=tht.categoryId AND th.parentId=0 AND th.isactive=1
                             INNER JOIN tbl_helpcategory thc ON thc.helpId=tht.subcategoryId AND thc.parentId=tht.categoryId AND th.isactive=1
                            WHERE tht.isactive=1 $condition");
            return ($qry->num_rows() > 0 ? $qry->result() : "" );
        }
    }

    public function mGetHelpMenuById($helptextId) {
        if (!isset($_SESSION['id']) || empty($helptextId)) {
            return '{"status":"error","msg":"Required fields are empty!"}';
        } else {

            $qry = $this->db->where(["helptextId" => $helptextId, "isactive" => 1])->get("tbl_helptext");
            $result = ($qry->num_rows() > 0 ? $qry->row() : "");
            return json_encode($result);
        }
    }

    public function mDeleteHelpMenu($helptextId) {
        if (!isset($_SESSION['id']) || empty($helptextId)) {
            return '{"status":"error","msg":"Required fields are empty!"}';
        } else {
            $chk = $this->db->where(["helptextId" => $helptextId, "isactive" => 1])->get("tbl_helptext");
            if ($chk->num_rows() > 0) {
                $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
                $resp = $this->db->where(["helptextId" => $helptextId, "isactive" => 1])->update("tbl_helptext", $udata);
                ($resp ? $this->addActivityLog($_SESSION['id'], "Help menu details Deleted", "tbl_helptext") : "" );
                return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
            } else {
                return '{"status":"error","msg":"No records found!"}';
            }
        }
    }

//Help Menu End
//University Controls Start
    public function mWebLinkStatusUpdate() {
        $weblink = FILTER_VAR(trim($this->input->post('weblink')), FILTER_SANITIZE_STRING);
        $loginId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || $weblink == "" || $loginId == "") {
            return '{"status":"error","msg":"Empty details"}';
        } else {
            $chk = $this->db->where(["loginId" => $loginId, "isactive" => 1])->get("organization_details");
            if ($chk->num_rows() > 0) {
                $rowData = $chk->row();
                $orgName = $rowData->orgName;
                $resp = $this->db->where(["loginId" => $loginId, "isactive" => 1])->update("organization_details", ["webLinkStartus" => $weblink]);
                ($resp ? $this->addActivityLog($_SESSION['id'], "Weblink status updated successfully.", "organization_details") : "" );
                return($resp ? '{"status":"success","msg":"Weblink successfully changed to ' . ($weblink == 1 ? "active" : "disable") . ' for ' . $orgName . '!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
            } else {
                return '{"status":"error","msg":"No records found!"}';
            }
        }
    }

//University Controls End
//Notifications Start
    public function mGetAdminNotifications() {
        $totalDataqry = $this->mgetAllNotifications('total');
        $totalData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->num_rows() : 0);

        $query = (empty($this->input->post('search')['value']) ? $this->mgetAllNotifications('nosearch') : $this->mgetAllNotifications('search'));
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $totalFiltered = (empty($this->input->post('search')['value']) ? $totalData : $this->mgetAllEnrollments('searchtotal')->num_rows());

        $data = array();
        if (!empty($posts)) {
            $i = ($this->input->post('start') == 0 ? 1 : $this->input->post('start'));

            foreach ($posts as $dt) { //.' ('.$dt->courseType.') '.$dt->departmentName
                $action = '<button type="button" onclick="sendNotificationMessage(\'' . base64_encode($dt->orgId) . '\');" class="btn btn-primary btn-xs">Send Messsage</button>';
                $data[] = ["MessageId" => $i++, "Message" => $dt->message, "SentBy" => $dt->SentBy, "InRefence" => $dt->reference,
                    "NotificationStatus" => ($dt->isRead ? "Read On " . $dt->readdate : "Not Read"), "Sentto" => $dt->orgName, "Action" => $action];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }

    private function mgetAllNotifications($condition) {
        $columns = array(0 => 'tn.notificationId', 1 => 'tn.message', 2 => 'od.orgName', 3 => 'tn.reference');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $likearr = " AND (tn.message like %$search% OR od.orgName LIKE %$search% OR tn.isRead LIKE %$search% OR tn.createdAt LIKE %$search%)";
        $conditions = ($condition == "nosearch" ? "Order by $order $dir  LIMIT  $start,$limit" : ($condition == "total" ? "" :
                ($condition == "search" ? " $likearr Order by $order $dir  LIMIT $start,$limit" : ($condition == "searchtotal" ? " $likearr Order by $order $dir " : ""))));

        return $this->db->query("SELECT tn.notificationId,tn.message,tn.isRead,DATE_FORMAT(tn.readDate,'%W %M %e %Y') readdate,od.orgName,od.orgId,
                                    CONCAT(ld.userName,' On ',DATE_FORMAT(tn.createdAt,'%W %M %e %Y')) SentBy,tn.reference
                                    FROM tbl_notifications tn
                                    INNER JOIN web_users ld ON ld.id=tn.sentBy AND tn.senderTableName='web_users'
                                    INNER JOIN organization_details od ON od.loginId=tn.notificationFor AND tableName='organization_details'
                                    WHERE tn.sentBy=" . $_SESSION['id'] . "   $conditions");
    }

//Notifications End
//Add Class Name Master Start
    public function mAddSchoolClassName() {
        $newClassName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('cname')))), FILTER_SANITIZE_STRING);
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['id']) || empty($newClassName) || empty($id)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $condition = ($id == "no_one" ? "" : "AND classnamesId!=$id");
        $chk = $this->db->query("select * from tbl_classnames where isactive=1 and classTitle='$newClassName' $condition");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate Details!"}';
        } else {
            $idata = ["classTitle" => $newClassName, "isactive" => 1];
            if ($id == "no_one") {
                $resp = $this->db->insert("tbl_classnames", $idata);
            } else {
                $resp = $this->db->where(["classnamesId" => $id, "isactive" => "1"])->update("tbl_classnames", $idata);
            }
            ($resp ? $this->addActivityLog($_SESSION['id'], "New Class Name added " . ($id == "no_one" ? "inserted" : "updated") . " by Superadmin", "tbl_classnames") : "");
            return($resp ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mDelSchoolClass($id) {
        $chkQry = $this->db->query("Select * from tbl_classnames where isactive=1 and classnamesId=$id");
        if ($chkQry->num_rows() > 0) {
            $data = ["isactive" => 0];
            $response = $this->db->where(["classnamesId" => $id, "isactive" => "1"])->update("tbl_classnames", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['id'], "Class Name Deleted by Superadmin", "tbl_classnames");
                return '{"status":"success","msg":"Removed Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

//Add Class Name Master End
//Marking Type Start
    public function mGetMarkingTypes() {
        $markingsystemId = FILTER_VAR(trim($this->input->post('markingsystemId')), FILTER_SANITIZE_STRING);
        $condition = ($markingsystemId ? ["markingsystemId" => $markingsystemId, "isactive" => 1] : ["isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->where($condition)->select("markingTitle,markingsystemId")->get("tbl_markingsystem");
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mAddMarkingType() {
        $markingsystemId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $markingTitle = FILTER_VAR(trim(ucwords(strtolower($this->input->post('markingTitle')))), FILTER_SANITIZE_STRING);
        if (empty($markingTitle) || empty($markingsystemId) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($markingsystemId == "no_one" ? ["markingTitle" => $markingTitle, "isactive" => 1] : ["markingsystemId!=" => $markingsystemId, "markingTitle" => $markingTitle, "isactive" => 1]);
        $result = $this->db->where($condition)->select("markingTitle,markingsystemId")->get("tbl_markingsystem");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = ($markingsystemId == "no_one" ? ["markingTitle" => $markingTitle, "addedOn" => $this->datetimenow()] : ["markingTitle" => $markingTitle, "isactive" => 1]);
        $res = ($markingsystemId == "no_one" ? $this->db->insert("tbl_markingsystem", $dataarr) : $this->db->where(["markingsystemId" => $markingsystemId, "isactive" => 1])->update("tbl_markingsystem", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "Marking Type $markingTitle " . ($markingsystemId == "no_one" ? "added" : "updated") . "  by Superadmin", "tbl_markingsystem") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mDelmarkingType() {
        $markingsystemId = FILTER_VAR(trim($this->input->post('markingsystemId')), FILTER_SANITIZE_STRING);
        if (empty($markingsystemId) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["markingsystemId" => $markingsystemId, "isactive" => 1])->select("markingTitle,markingsystemId")->get("tbl_markingsystem");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["markingsystemId" => $markingsystemId, "isactive" => 1])->update("tbl_markingsystem", ["isactive" => 0]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Marking Type " . $result->row()->markingTitle . " deleted by Superadmin", "tbl_markingsystem") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Marking Type End
//Course Fee Type Start
    public function mAddCourseFeeType() {
        $courseFeeType_Id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $FeeType_Name = FILTER_VAR(trim(ucwords(strtolower($this->input->post('FeeType_Name')))), FILTER_SANITIZE_STRING);
        if (empty($FeeType_Name) || empty($courseFeeType_Id) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($courseFeeType_Id == "no_one" ? ["FeeType_Name" => $FeeType_Name, "isactive" => 1] : ["courseFeeType_Id!=" => $courseFeeType_Id, "FeeType_Name" => $FeeType_Name, "isactive" => 1]);
        $result = $this->db->where($condition)->select("FeeType_Name,courseFeeType_Id")->get("course_fee_type");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = ($courseFeeType_Id == "no_one" ? ["FeeType_Name" => $FeeType_Name, "createdAt" => $this->datetimenow(), "createdBy" => $_SESSION['id']] : ["FeeType_Name" => $FeeType_Name, "updatedAt" => $this->datetimenow(), "updatedBy" => $_SESSION['id'], "isactive" => 1]);
        $res = ($courseFeeType_Id == "no_one" ? $this->db->insert("course_fee_type", $dataarr) : $this->db->where(["courseFeeType_Id" => $courseFeeType_Id, "isactive" => 1])->update("course_fee_type", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "Marking Type $FeeType_Name " . ($courseFeeType_Id == "no_one" ? "added" : "updated") . "  by Superadmin", "course_fee_type") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetCourseFeeTypes() {
        $courseFeeType_Id = FILTER_VAR(trim($this->input->post('courseFeeType_Id')), FILTER_SANITIZE_STRING);
        $condition = ($courseFeeType_Id ? ["courseFeeType_Id" => $courseFeeType_Id, "isactive" => 1] : ["isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->where($condition)->select("FeeType_Name,courseFeeType_Id")->get("course_fee_type");
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mDelcourseFeeType() {
        $courseFeeType_Id = FILTER_VAR(trim($this->input->post('courseFeeType_Id')), FILTER_SANITIZE_STRING);
        if (empty($courseFeeType_Id) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["courseFeeType_Id" => $courseFeeType_Id, "isactive" => 1])->select("FeeType_Name,courseFeeType_Id")->get("course_fee_type");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["courseFeeType_Id" => $courseFeeType_Id, "isactive" => 1])->update("course_fee_type", ["isactive" => 0]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Course Fee Type " . $result->row()->FeeType_Name . " deleted by Superadmin", "course_fee_type") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Course Fee Type End
//Currency Master Start
    public function mAddCurrency() {
        $code_Id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $code = FILTER_VAR(trim(strtoupper($this->input->post('code'))), FILTER_SANITIZE_STRING);
        $name = FILTER_VAR(trim(ucwords(strtolower($this->input->post('name')))), FILTER_SANITIZE_STRING);
        if (empty($code) || empty($name) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ["code" => $code, "name" => $name, "isactive" => 1];
        $result = $this->db->where($condition)->select("name,code")->get("currencies");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = ["code" => $code, "name" => $name, "isactive" => 1];
        $res = ($code_Id == "no_one" ? $this->db->insert("currencies", $dataarr) : $this->db->where(["code" => $code_Id, "isactive" => 1])->update("currencies", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "Currency Type $name " . ($code_Id == "no_one" ? "added" : "updated") . "  by Superadmin", "currencies") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetCurrency() {
        $code = FILTER_VAR(trim($this->input->post('code')), FILTER_SANITIZE_STRING);
        $condition = ($code ? ["code" => $code, "isactive" => 1] : ["isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->where($condition)->select("code,name")->get("currencies");
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mDelCurrency() {
        $code_Id = FILTER_VAR(trim($this->input->post('code')), FILTER_SANITIZE_STRING);
        if (empty($code_Id) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["code" => $code_Id, "isactive" => 1])->select("code,name")->get("currencies");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["code" => $code_Id, "isactive" => 1])->update("currencies", ["isactive" => 0]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Currency Type " . $result->row()->name . " deleted by Superadmin", "currencies") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Currency Master End
//Department Start
    public function mAddDepartment() {
        $departmentId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $loginId = FILTER_VAR(trim(strtoupper($this->input->post('loginId'))), FILTER_SANITIZE_STRING);
        $departmentCode = FILTER_VAR(trim(strtoupper($this->input->post('departmentCode'))), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim(ucwords(strtolower($this->input->post('title')))), FILTER_SANITIZE_STRING);
        if (empty($departmentId) || empty($loginId) || empty($departmentCode) || empty($title) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($departmentId == "no_one" ? ["loginId" => $loginId, "departmentCode" => $departmentCode, "title" => $title, "isactive" => 1] : ["departmentId!=" => $departmentId, "loginId" => $loginId, "departmentCode" => $departmentCode, "title" => $title, "isactive" => 1]);
        $result = $this->db->where($condition)->select("departmentId,title")->get("department");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = ($departmentId == "no_one" ? ["loginId" => $loginId, "departmentCode" => $departmentCode, "title" => $title, "createdAt" => $this->datetimenow(), "isactive" => 1] : ["loginId" => $loginId, "departmentCode" => $departmentCode, "title" => $title, "updatedAt" => $this->datetimenow(), "isactive" => 1]);
        $res = ($departmentId == "no_one" ? $this->db->insert("department", $dataarr) : $this->db->where(["departmentId" => $departmentId, "isactive" => 1])->update("department", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "Department Name $title " . ($departmentId == "no_one" ? "added" : "updated") . "  by Superadmin", "department") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetDepartment() {
        $departmentId = FILTER_VAR(trim($this->input->post('departmentId')), FILTER_SANITIZE_STRING);
        $condition = ($departmentId ? ["department.departmentId" => $departmentId, "department.isactive" => 1] : ["department.isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->select("departmentCode,title,orgName,departmentId,department.loginId")->from('department')->join("organization_details", "organization_details.loginId=department.loginId AND organization_details.isactive=1", "left")->where($condition)->get();
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mDelDepartment() {
        $departmentId = FILTER_VAR(trim($this->input->post('departmentId')), FILTER_SANITIZE_STRING);
        if (empty($departmentId) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["departmentId" => $departmentId, "isactive" => 1])->select("departmentId,title")->get("department");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["departmentId" => $departmentId, "isactive" => 1])->update("department", ["updatedAt" => $this->datetimenow(), "isactive" => 0]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Department Type " . $result->row()->title . " deleted by Superadmin", "department") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Department Master End
//Student Key Skill Master Start
    public function mAddStudentKeySkills() {
        $key_skill_id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $skill_name = FILTER_VAR(trim(ucwords(strtolower($this->input->post('skill_name')))), FILTER_SANITIZE_STRING);
        if (empty($key_skill_id) || empty($skill_name) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($key_skill_id == "no_one" ? ["skill_name" => $skill_name, "isactive" => 1] : ["key_skill_id!=" => $key_skill_id, "skill_name" => $skill_name, "isactive" => 1]);
        $result = $this->db->where($condition)->select("key_skill_id,skill_name")->get("student_key_skills");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = ["skill_name" => $skill_name, "isactive" => 1];
        $res = ($key_skill_id == "no_one" ? $this->db->insert("student_key_skills", $dataarr) : $this->db->where(["key_skill_id" => $key_skill_id, "isactive" => 1])->update("student_key_skills", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "KeySkill Name $skill_name " . ($key_skill_id == "no_one" ? "added" : "updated") . "  by Superadmin", "student_key_skills") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetStudentKeySkills() {
        $key_skill_id = FILTER_VAR(trim($this->input->post('key_skill_id')), FILTER_SANITIZE_STRING);
        $condition = ($key_skill_id ? ["key_skill_id" => $key_skill_id, "isactive" => 1] :
                ["isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->select("key_skill_id,skill_name")->from('student_key_skills')->where($condition)->get();
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mDelStudentKeySkills() {
        $key_skill_id = FILTER_VAR(trim($this->input->post('key_skill_id')), FILTER_SANITIZE_STRING);
        if (empty($key_skill_id) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["key_skill_id" => $key_skill_id, "isactive" => 1])->select("key_skill_id,skill_name")->get("student_key_skills");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["key_skill_id" => $key_skill_id, "isactive" => 1])->update("student_key_skills", ["isactive" => 0]);
            ($res ? $this->addActivityLog($_SESSION['id'], "KeySkill Name  " . $result->row()->skill_name . " deleted by Superadmin", "student_key_skills") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Student Key Skill Master End
//Course Mode Master Start
    public function mAddCourseModeMaster() {
        $type_id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $typeTile = FILTER_VAR(trim(ucwords(strtolower($this->input->post('typeTile')))), FILTER_SANITIZE_STRING);
        if (empty($type_id) || empty($typeTile) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($type_id == "no_one" ? ["typeTile" => $typeTile, "isactive" => 1] : ["type_id!=" => $type_id, "typeTile" => $typeTile, "isactive" => 1]);
        $result = $this->db->where($condition)->select("type_id,typeTile")->get("tbl_coursetype");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = array_merge(["typeTile" => $typeTile, "isactive" => 1], ($type_id == "no_one" ? ["createdAt" => $this->datetimenow(), "createdBy" => $this->session->name] : ["updatedAt" => $this->datetimenow()]));
        $res = ($type_id == "no_one" ? $this->db->insert("tbl_coursetype", $dataarr) : $this->db->where(["type_id" => $type_id, "isactive" => 1])->update("tbl_coursetype", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "Course Mode Name $typeTile " . ($type_id == "no_one" ? "added" : "updated") . "  by Superadmin", "tbl_coursetype") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetCourseModeMaster() {
        $type_id = FILTER_VAR(trim($this->input->post('type_id')), FILTER_SANITIZE_STRING);
        $condition = ($type_id ? ["type_id" => $type_id, "isactive" => 1] :
                ["isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->select("type_id,typeTile")->from('tbl_coursetype')->where($condition)->get();
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mDelCourseModeMaster() {
        $type_id = FILTER_VAR(trim($this->input->post('type_id')), FILTER_SANITIZE_STRING);
        if (empty($type_id) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["type_id" => $type_id, "isactive" => 1])->select("type_id,typeTile")->get("tbl_coursetype");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["type_id" => $type_id, "isactive" => 1])->update("tbl_coursetype", ["isactive" => 0, "updatedAt" => $this->datetimenow()]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Course Mode Name  " . $result->row()->typeTile . " deleted by Superadmin", "student_key_skills") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Course Mode Master End
//Exam Mode Master Start
    public function mAddExamModeMaster() {
        $exam_mode_id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim(ucwords(strtolower($this->input->post('title')))), FILTER_SANITIZE_STRING);
        if (empty($exam_mode_id) || empty($title) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($exam_mode_id == "no_one" ? ["title" => $title, "isactive" => 1] : ["exam_mode_id!=" => $exam_mode_id, "title" => $title, "isactive" => 1]);
        $result = $this->db->where($condition)->select("exam_mode_id,title")->get("tbl_exam_mode");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = array_merge(["title" => $title, "isactive" => 1], ($exam_mode_id == "no_one" ? ["createdOn" => $this->datetimenow(), "approved" => 1] : ["updatedOn" => $this->datetimenow()]));
        $res = ($exam_mode_id == "no_one" ? $this->db->insert("tbl_exam_mode", $dataarr) : $this->db->where(["exam_mode_id" => $exam_mode_id, "isactive" => 1])->update("tbl_exam_mode", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "Exam Mode Name $title " . ($exam_mode_id == "no_one" ? "added" : "updated") . "  by Superadmin", "tbl_exam_mode") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetExamModeMaster() {
        $exam_mode_id = FILTER_VAR(trim($this->input->post('exam_mode_id')), FILTER_SANITIZE_STRING);
        $condition = ($exam_mode_id ? ["tem.exam_mode_id" => $exam_mode_id, "tem.isactive" => 1] :
                ["tem.isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->select("tem.exam_mode_id,tem.title,od.orgName,tem.approved")->from('tbl_exam_mode tem')->join("organization_details od", "od.loginId=tem.loginId", "left")->where($condition)->get();
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mDelExamModeMaster() {
        $exam_mode_id = FILTER_VAR(trim($this->input->post('exam_mode_id')), FILTER_SANITIZE_STRING);
        if (empty($exam_mode_id) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["exam_mode_id" => $exam_mode_id, "isactive" => 1])->select("exam_mode_id,title")->get("tbl_exam_mode");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["exam_mode_id" => $exam_mode_id, "isactive" => 1])->update("tbl_exam_mode", ["isactive" => 0, "updatedOn" => $this->datetimenow()]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Exam Mode Name  " . $result->row()->title . " deleted by Superadmin", "tbl_exam_mode") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mChangeExamModeStatus() {
        $exam_mode_id = FILTER_VAR(trim($this->input->post('emid')), FILTER_SANITIZE_STRING);
        $status = FILTER_VAR(trim($this->input->post('status')), FILTER_SANITIZE_STRING);
        if ($exam_mode_id == "" || $status == "" || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $chk = $this->db->where(["exam_mode_id" => $exam_mode_id, "isactive" => 1])->select("exam_mode_id,title")->get("tbl_exam_mode");
        if ($chk->num_rows() > 0) {
            $approved = ($status == "Approve" ? 1 : 2);
            $idata = ["approved" => $approved, "isactive" => 1, "updatedOn" => $this->datetimenow()];
            $res = $this->db->where(["exam_mode_id" => $exam_mode_id, "isactive" => 1])->update("tbl_exam_mode", $idata);
            ($res ? $this->addActivityLog($_SESSION['id'], "Exam Mode Name  " . $chk->row()->title . " status changed to  $status by Superadmin", "tbl_exam_mode") : "");
            return($res ? '{"status":"success","msg":"Status changed successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Exam Mode Master End
//Fee Cyce Master Start
    public function mAddFeeCycleMaster() {
        $feecycleId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim(ucwords(strtolower($this->input->post('title')))), FILTER_SANITIZE_STRING);
        if (empty($feecycleId) || empty($title) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($feecycleId == "no_one" ? ["title" => $title, "isactive" => 1] : ["feecycleId!=" => $feecycleId, "title" => $title, "isactive" => 1]);
        $result = $this->db->where($condition)->select("feecycleId,title")->get("tbl_feecycle");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = array_merge(["title" => $title, "isactive" => 1], ($feecycleId == "no_one" ? ["createdAt" => $this->datetimenow(), "approved" => 1] : ["updatedAt" => $this->datetimenow()]));
        $res = ($feecycleId == "no_one" ? $this->db->insert("tbl_feecycle", $dataarr) : $this->db->where(["feecycleId" => $feecycleId, "isactive" => 1])->update("tbl_feecycle", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "Fee Cycle Name $title " . ($feecycleId == "no_one" ? "added" : "updated") . "  by Superadmin", "tbl_feecycle") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetFeeCycleMaster() {
        $feecycleId = FILTER_VAR(trim($this->input->post('feecycleId')), FILTER_SANITIZE_STRING);
        $condition = ($feecycleId ? ["tfc.feecycleId" => $feecycleId, "tfc.isactive" => 1] : ["tfc.isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->select("tfc.feecycleId,tfc.title,od.orgName,tfc.approved")->from('tbl_feecycle tfc')->join("organization_details od", "od.loginId=tfc.loginId", "left")->where($condition)->get();
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mDelFeeCycleMaster() {
        $feecycleId = FILTER_VAR(trim($this->input->post('feecycleId')), FILTER_SANITIZE_STRING);
        if (empty($feecycleId) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["feecycleId" => $feecycleId, "isactive" => 1])->select("feecycleId,title")->get("tbl_feecycle");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["feecycleId" => $feecycleId, "isactive" => 1])->update("tbl_feecycle", ["isactive" => 0, "updatedAt" => $this->datetimenow()]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Fee Cycle Name  " . $result->row()->title . " deleted by Superadmin", "tbl_feecycle") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mChangeFeeCycleStatus() {
        $feecycleId = FILTER_VAR(trim($this->input->post('emid')), FILTER_SANITIZE_STRING);
        $status = FILTER_VAR(trim($this->input->post('status')), FILTER_SANITIZE_STRING);
        if ($feecycleId == "" || $status == "" || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $chk = $this->db->where(["feecycleId" => $feecycleId, "isactive" => 1])->select("feecycleId,title")->get("tbl_feecycle");
        if ($chk->num_rows() > 0) {
            $approved = ($status == "Approve" ? 1 : 2);
            $idata = ["approved" => $approved, "isactive" => 1, "updatedAt" => $this->datetimenow()];
            $res = $this->db->where(["feecycleId" => $feecycleId, "isactive" => 1])->update("tbl_feecycle", $idata);
            ($res ? $this->addActivityLog($_SESSION['id'], "Exam Mode Name  " . $chk->row()->title . " status changed to  $status by Superadmin", "tbl_feecycle") : "");
            return($res ? '{"status":"success","msg":"Status changed successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

//Fee Cyce Master End
//Course Mode Master Start
    public function mAddSubjectMaster() {
        $subjectId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $subjectTitle = FILTER_VAR(trim(ucwords(strtolower($this->input->post('subjectTitle')))), FILTER_SANITIZE_STRING);
        if (empty($subjectId) || empty($subjectTitle) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = ($subjectId == "no_one" ? ["subjectTitle" => $subjectTitle, "isactive" => 1] : ["subjectId!=" => $subjectId, "subjectTitle" => $subjectTitle, "isactive" => 1]);
        $result = $this->db->where($condition)->select("subjectId,subjectTitle")->get("tbl_subjectmaster");
        if ($result->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $dataarr = array_merge(["subjectTitle" => $subjectTitle, "isactive" => 1], ($subjectId == "no_one" ? ["createdAt" => $this->datetimenow(), "createdByIp" => $this->getRealIpAddr()] : ["updatedAt" => $this->datetimenow(), 'updateByIp' => $this->getRealIpAddr()]));
        $res = ($subjectId == "no_one" ? $this->db->insert("tbl_subjectmaster", $dataarr) : $this->db->where(["subjectId" => $subjectId, "isactive" => 1])->update("tbl_subjectmaster", $dataarr));
        ($res ? $this->addActivityLog($_SESSION['id'], "Subject Name $subjectTitle " . ($subjectId == "no_one" ? "added" : "updated") . "  by Superadmin", "tbl_subjectmaster") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetSubjectMaster() {
        $subjectId = FILTER_VAR(trim($this->input->post('subjectId')), FILTER_SANITIZE_STRING);
        $condition = ($subjectId ? ["subjectId" => $subjectId, "isactive" => 1] :
                ["isactive" => 1]);
        if (!isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Session ended please login"}';
        }
        $result = $this->db->select("subjectId,subjectTitle")->from('tbl_subjectmaster')->where($condition)->get();
        return json_encode(($result->num_rows() > 0 ? $result->result() : ""));
    }

    public function mDelSubjectMaster() {
        $subjectId = FILTER_VAR(trim($this->input->post('subjectId')), FILTER_SANITIZE_STRING);
        if (empty($subjectId) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["subjectId" => $subjectId, "isactive" => 1])->select("subjectId,subjectTitle")->get("tbl_subjectmaster");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["subjectId" => $subjectId, "isactive" => 1])->update("tbl_subjectmaster", ["isactive" => 0, "updatedAt" => $this->datetimenow()]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Subject Name  " . $result->row()->subjectTitle . " deleted by Superadmin", "tbl_subjectmaster") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    /**
     * Course Mode Master End
     */

    /**
     *
     * @param type $gateway_name
     * @param type $salt
     * @param type $apikey
     */
    public function mInsertPaymentGatewayDetails($gateway_name, $salt, $apikey, $payment_gatewayID) {
        if (empty($gateway_name) || empty($salt) || empty($apikey) || empty($payment_gatewayID)) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $condition = array_merge(["gateway_name" => $gateway_name, "isactive" => 1], ($payment_gatewayID == "no_one" ? [] : ["payment_gatewayID!=" => $payment_gatewayID]));
        $chk = $this->db->where($condition)->get("tbl_payment_gateway");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $cdata = ["gateway_name" => $gateway_name, "salt" => $salt, "apikey" => $apikey, "ipAccessed" => $this->getRealIpAddr(), "isactive" => 1];
        $idata = array_merge($cdata, ($payment_gatewayID == "no_one" ? ["createdAt" => $this->datetimenow()] : ["updatedAt" => $this->datetimenow()]));
        $res = ($payment_gatewayID == "no_one" ? $this->db->insert("tbl_payment_gateway", $idata) : $this->db->where([$payment_gatewayID => "payment_gatewayID"])->update("tbl_payment_gateway", $idata));
        ($res ? $this->addActivityLog($_SESSION['id'], "Payment gateway  " . $gateway_name . " " . ($payment_gatewayID == "no_one" ? "Inserted" : "Updated") . " successfully by Superadmin", "tbl_payment_gateway") : "");
        return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    /**
     *
     * @param type $payment_gatewayID
     * @return type
     */
    public function mGetPaymentGatwaydetails($payment_gatewayID) {
        $condition = array_merge(($payment_gatewayID ? ["payment_gatewayID" => $payment_gatewayID] : []), ["isactive" => 1]);

        $qry = $this->db->where($condition)->select("payment_gatewayID,gateway_name,salt,apikey,isdefault")->get("tbl_payment_gateway");

        if ($qry->num_rows() > 0) {
            $return = ($payment_gatewayID ? $qry->row() : $qry->result());
        } else {
            $return = "";
        }
        return json_encode($return);
    }

    public function mDelPaymentGatewayDetails($payment_gatewayID) {

        if (empty($payment_gatewayID) || !isset($_SESSION['id'])) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $result = $this->db->where(["payment_gatewayID" => $payment_gatewayID, "isactive" => 1])->select("payment_gatewayID,gateway_name,isdefault")->get("tbl_payment_gateway");
        if ($result->num_rows() > 0) {
            $res = $this->db->where(["payment_gatewayID" => $payment_gatewayID, "isactive" => 1])->update("tbl_payment_gateway", ["isactive" => 0, "updatedAt" => $this->datetimenow(), "ipAccessed" => $this->getRealIpAddr()]);
            ($res ? $this->addActivityLog($_SESSION['id'], "Payment gateway Name " . $result->row()->gateway_name . " deleted by Superadmin", "tbl_payment_gateway") : "");
            ($result->row()->isdefault ? $this->setNewDefault() : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function setNewDefault($payment_gatewayID = "") {
        $this->db->update("tbl_payment_gateway", ["isdefault" => 0]);
        if (!isset($_SESSION['id'])) {
            return false;
        }
        if (empty($payment_gatewayID)) {
            $qry = $this->db->where(["isactive" => 1])->get("tbl_payment_gateway");
            if ($qry->num_rows() > 0) {
                return $this->db->where(["payment_gatewayID" => $qry->row()->payment_gatewayID])->update("tbl_payment_gateway", ["isdefault" => 1, "updatedAt" => $this->datetimenow(), "ipAccessed" => $this->getRealIpAddr()]);
            }
        } else {
            $res = $this->db->where(["payment_gatewayID" => $payment_gatewayID])->update("tbl_payment_gateway", ["isdefault" => 1, "updatedAt" => $this->datetimenow(), "ipAccessed" => $this->getRealIpAddr()]);
            $qry = $this->db->where(["payment_gatewayID" => $payment_gatewayID])->get("tbl_payment_gateway");
            ($res ? $this->addActivityLog($_SESSION['id'], "Payment gateway  " . $qry->row()->gateway_name . "set default successfully by Superadmin", "tbl_payment_gateway") : "");
            return($res ? '{"status":"success","msg":"Set default Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    /**
     * Activity Log Start
     */
    private function addActivityLog($user_id, $activity, $act_table) {
        $idata = ["user_id" => $user_id, "activity" => $activity, "act_table" => $act_table, "date" => date('Y-m-d'), "isadmin" => 1,
            "role_name" => "Superadmin", "created_at" => $this->datetimenow(), "ip_address" => $this->getRealIpAddr(), "isactive" => 1];
        $this->db->insert("activity_log", $idata);
    }

    /**
     * Activity Log End
     */
    public function datetimenow() {
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $todaydate = $date->format('Y-m-d H:i:s ');

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

    private function sendEmail($emailReceiver, $body, $subject, $senderName) {
        $emailSender = ( isset($_SESSION['websiteEmail']) ? $_SESSION['websiteEmail'] : 'donotreply@ihuntbest.com' );
        $this->email->from($emailSender, $senderName);
        $this->email->to($emailReceiver);
//$this->email->cc('another@another-example.com');
        $this->email->bcc('vermamanish4u@gmail.com');
        $this->email->subject($subject);
        $this->email->message($body);
        $res = $this->email->send();

        return ( $res ? "Sent Successfully" : "Sending Failed" );
    }

}
