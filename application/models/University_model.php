<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class University_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
    }

    //dashboard start
    public function mGetDasboardDetails() {
        $id = $_SESSION['loginId'];
        $details = $this->db->query("SELECT(SELECT COUNT(*) FROM department WHERE loginId=$id AND isactive=1) totaldepartments,
                                                (SELECT COUNT(*) FROM pages WHERE loginId=$id AND isactive=1) totalpages,
                                                (SELECT COUNT(*) FROM organisation_courses WHERE login_id=$id AND is_active=1) as  totalcourses,
                                                (SELECT COUNT(*)  FROM organization_streams as os     INNER JOIN organization_courses as oc ON oc.orgCourseId=os.orgCourseId    INNER JOIN course_type as ct ON ct.ctId=oc.courseTypeId
                                                INNER JOIN course_details as cd ON cd.cId=oc.courseId    INNER JOIN time_duration as td ON td.tdId=oc.courseDurationId
                                                INNER JOIN stream_details as sd ON sd.streamId=os.streamId  WHERE os.isactive=1 and os.loginId=$id) totalstreams,
                                                (SELECT COUNT(*) FROM brouchers WHERE loginId=$id AND isactive=1) totalbrouchers,
                                                (SELECT COUNT(*) FROM gallery WHERE loginId=$id AND isactive=1) totalgallery,
                                                (SELECT COUNT(*) FROM event_details WHERE loginId=$id AND isactive=1) totalevent_details,
                                                (SELECT COUNT(*) FROM news WHERE loginId=$id AND isactive=1) totalnews,
                                                (SELECT COUNT(*) FROM placement WHERE loginId=$id AND isactive=1) totalplacement,
                                                (SELECT COUNT(*) FROM achievement WHERE loginId=$id AND isactive=1) totalachievement,
                                                (SELECT COUNT(*) FROM faculty_details WHERE loginId=$id AND isactive=1) totalfaculty,
                                                (SELECT COUNT(*) FROM advertisement WHERE loginId=$id AND isactive=1) totaladvertisement");
        if ($details->num_rows() > 0) {
            return $details->row();
        }
    }

    public function mgetProfileCompletion() {
        $this->db->where(['loginId' => $_SESSION['loginId'], "isactive" => 1]);
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

    //dashboard end
    //university profile start
    public function getOrgConcernedPerson() {
        $cp_Id = FILTER_VAR(trim($this->input->post('cp_Id')), FILTER_SANITIZE_STRING);

        if (!isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Invalid login."}';
        }
        $condition = ($cp_Id ? " AND cp_Id=" . base64_decode($cp_Id) . "" : "");
        $qry = $this->db->query("select * from org_concerned_person where loginId=" . $_SESSION['loginId'] . " $condition AND isactive=1");
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
            foreach ($result as $rs) {
                $rs->cp_Id = base64_encode($rs->cp_Id);
            }
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mAddConcernedPersonDetails() {
        $cp_Id = FILTER_VAR(trim($this->input->post('cp_Id')), FILTER_SANITIZE_STRING);
        $cp_name = FILTER_VAR(trim($this->input->post('cp_name')), FILTER_SANITIZE_STRING);
        $gender = FILTER_VAR(trim($this->input->post('gender')), FILTER_SANITIZE_STRING);
        $cp_email = FILTER_VAR(trim($this->input->post('cp_email')), FILTER_SANITIZE_EMAIL);
        $cp_contact = FILTER_VAR(trim($this->input->post('cp_contact')), FILTER_SANITIZE_NUMBER_INT);
        $cp_alt_contact = FILTER_VAR(trim($this->input->post('cp_alt_contact')), FILTER_SANITIZE_NUMBER_INT);
        $cp_position = FILTER_VAR(trim($this->input->post('cp_position')), FILTER_SANITIZE_STRING);
        $cp_address = FILTER_VAR(trim($this->input->post('cp_address')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId']) || empty($cp_Id) || empty($cp_name) || empty($gender) || empty($cp_email) || empty($cp_contact) || empty($cp_position) || empty($cp_address)) {
            return '{"status":"error", "msg":"Required field is empty."}';
        }
        if ($cp_Id === "no_one") {
            return $this->insertConcernedPersonDetails($_SESSION['loginId'], $cp_name, $gender, $cp_email, $cp_contact, $cp_alt_contact, $cp_position, $cp_address);
        } else {
            return $this->updateConcernedPersonDetails($_SESSION['loginId'], base64_decode($cp_Id), $cp_name, $gender, $cp_email, $cp_contact, $cp_alt_contact, $cp_position, $cp_address);
        }
    }

    public function insertConcernedPersonDetails($loginId, $cp_name, $gender, $cp_email, $cp_contact, $cp_alt_contact, $cp_position, $cp_address) {
        $cData = ["loginId" => $loginId, "isactive" => 1];

        $chk = $this->db->where($cData)->get("org_concerned_person");
        if ($chk->num_rows() > 2) {
            return '{"status":"error", "msg":"Only three can be there."}';
        } else {
            $iData = ["loginId" => $loginId, "cp_name" => $cp_name, "gender" => $gender, "cp_email" => $cp_email, "cp_contact" =>
                $cp_contact, "cp_alt_contact" => $cp_alt_contact
                , "cp_position" => $cp_position, "cp_address" => $cp_address, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("org_concerned_person", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Concerned person details inserted", "org_concerned_person", "0") : "" );
            return($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mDelConcernedPerson() {
        $cp_Id = FILTER_VAR(trim($this->input->post('cp_Id')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId']) || empty($cp_Id)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        $chk = $this->db->where(["loginId" => $_SESSION['loginId'], 'cp_Id' => base64_decode($cp_Id), 'isactive' => 1])->get('org_concerned_person');
        if ($chk->num_rows() > 0) {
            $uData = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where(['cp_Id' => base64_decode($cp_Id)])->update("org_concerned_person", $uData);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Concerned person details deleted", "org_concerned_person", "0") : "" );

            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            return '{"status":"error","msg":"Record not found!"}';
        }
    }

    public function updateConcernedPersonDetails($loginId, $cp_Id, $cp_name, $gender, $cp_email, $cp_contact, $cp_alt_contact, $cp_position, $cp_address) {
        $cData = ["loginId" => $loginId, "cp_Id" => $cp_Id, "isactive" => 1];

        $chk = $this->db->where($cData)->get("org_concerned_person");
        if ($chk->num_rows() > 0) {
            $iData = ["cp_name" => $cp_name, "gender" => $gender, "cp_email" => $cp_email,
                "cp_contact" => $cp_contact, "cp_alt_contact" => $cp_alt_contact
                , "cp_position" => $cp_position, "cp_address" => $cp_address, "updatedAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->where($cData)->update("org_concerned_person", $iData);
            return($res ? '{"status":"success", "msg":"Updated Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            return $this->insertConcernedPersonDetails($loginId, $cp_name, $gender, $cp_email, $cp_contact, $cp_alt_contact, $cp_position, $cp_address);
        }
    }

    public function getProfileInfo() {
        $id = $_SESSION['loginId'];
        $qry = $this->db->query("SELECT ld.email,ld.id,od.orgName,od.orgType,od.orgMobile,od.orgAddress,od.orgLogo,od.orgImgHeader,
                                od.directorName,od.directorEmail,od.directorMobile,od.orgGoogle,od.orgWebsite,od.approvedBy,od.orgDesp,
                                od.orgMission,od.orgVission,st.name as state,cs.name as country,ct.name as city,od.countryId,od.stateId,
                                od.cityId,od.org_landline,od.orgEstablished FROM login_details as ld
                                INNER JOIN organization_details as od ON od.loginId=ld.id
                                INNER JOIN countries as cs ON cs.countryId=od.countryId
                                INNER JOIN states as st ON st.stateId=od.stateId
                                INNER JOIN cities as ct ON ct.cityId=od.cityId WHERE od.loginId=$id");
        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return false;
        }
    }

    public function getProfileJson() {
        $profileinfo = $this->getProfileInfo();
        return json_encode($profileinfo);
    }

    public function mUploadProfileImage() {
        $id = $_SESSION['loginId'];
        $orgName = $_SESSION['orgName'];
        $image = preg_replace("/\s+/", "_", $_FILES['orgLogo']['name']);
        $path = './projectimages/images/profile/logo/';
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $todaydate = $date->format('YmdHisA');
        $imgName = $orgName . $todaydate . $image;
        $response = $this->uploadImage($path, $imgName, 'orgLogo');
        $prevImg = $this->input->post("logoimgname");
        if ($response != "error") {
            $data = ["orgLogo" => 'projectimages/images/profile/logo/' . $response];
            $res = $this->db->where("loginId", $id)->update("organization_details", $data);
            if ($res) {
                $this->addActivityLog($_SESSION['loginId'], "Profile Image Updated by " . $_SESSION['orgName'], "organization_details", "0");
                $this->removeImage($prevImg, 'projectimages/images/profile/logo/');
                return "updated";
            } else {
                return "notupdated";
            }
        }
    }

    public function mUploadHeaderImage() {
        $id = $_SESSION['loginId'];
        $orgName = $_SESSION['orgName'];
        $image = preg_replace("/\s+/", "_", $_FILES['orgImgHeader']['name']);
        $path = './projectimages/images/profile/headerImage/';
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $todaydate = $date->format('YmdHisA');
        $imgName = $orgName . $todaydate . $image;
        $response = $this->uploadImage($path, $imgName, 'orgImgHeader');
        $prevImg = $this->input->post("Headerimgname");
        if ($response != "error") {
            $data = ["orgImgHeader" => 'projectimages/images/profile/headerImage/' . $response];

            $res = $this->db->where("loginId", $id)->update("organization_details", $data);
            if ($res) {
                $this->addActivityLog($_SESSION['loginId'], "Header Image Updated by " . $_SESSION['orgName'], "organization_details", "0");
                $this->removeImage($prevImg, 'projectimages/images/profile/headerImage/');
                return "updated";
            } else {
                return "notupdated";
            }
        }
    }

    public function getOrgFacilities($status) {
        $id = $_SESSION['loginId'];
        return $this->db->query("SELECT fac.* ,omf.mappingId FROM facilities fac
            LEFT JOIN org_mapping_facilities omf ON omf.facilityId=fac.facilityId AND omf.loginId=$id AND fac.isactive=1
            WHERE fac.facility_status=$status AND fac.isactive=1 order by fac.facilityId");
    }

    public function mRequestFacility($title, $fac_icon) {

        if (!isset($_SESSION['loginId']) || empty($title) || empty($fac_icon)) {
            return '{"status":"error", "msg":"Blank values submitted"}';
        } else {
            $chk = $this->db->query("Select * from facilities where title='" . $title . "' AND facility_icon='" . $fac_icon . "' AND isactive=1");
            if ($chk->num_rows() > 0) {
                return '{"status":"error", "msg":"Duplicate Value"}';
            } else {

                $data = ["title" => $title, "facility_icon" => $fac_icon, "facility_status" => 1, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $this->db->insert("facilities", $data);
                $facilityId = $this->db->insert_id();
            }
            if ($facilityId) {
                $this->addActivityLog($_SESSION['loginId'], "Facility Inserted by " . $_SESSION['orgName'], "facilities", "0");
                $datai = ["orgId" => $_SESSION['loginId'], "facilityId" => $facilityId, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->insert("facility_request", $datai);
                $this->addActivityLog($_SESSION['loginId'], "Facility Request added by " . $_SESSION['orgName'], "facility_request", "0");
                return ($res ? '{"status":"success", "msg":"Request Facility Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            }
        }
    }

    public function msaveProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType) {

        $orgGoogle = $this->input->post('orgGoogle');
        $orgWebsite = FILTER_VAR(trim($this->input->post('orgWebsite')), FILTER_SANITIZE_STRING);
        $approvedBy = FILTER_VAR(trim($this->input->post('approvedBy')), FILTER_SANITIZE_STRING);
        $orgaddress = FILTER_VAR(trim($this->input->post('address1')), FILTER_SANITIZE_STRING);
        //$facility           =       $this->input->post('facility');
        $orgDesp = $this->input->post('orgDesp');
        $orgMission = $this->input->post('orgMission');
        $orgVission = $this->input->post('orgVission');
        $org_landline = FILTER_VAR(trim($this->input->post('org_landline')), FILTER_SANITIZE_NUMBER_INT);
        $orgEstablished = FILTER_VAR(trim($this->input->post('orgEstablished')), FILTER_SANITIZE_STRING);

        if (empty($directorName) || empty($directorMobile) || empty($directorEmail) || empty($orgName) || empty($orgMobile) || empty($countryId) ||
                empty($stateId) || empty($cityId) || empty($orgType) || empty($orgWebsite) || empty($approvedBy) || empty($orgaddress) || !isset($_SESSION['loginId'])) {
            return '{"status":"error","msg":"Requiredss field is empty!"}';
        } else {
            $this->mSaveFinancialDetails("notshowmessage");
            $data = ["loginId" => $_SESSION['loginId'], "directorName" => $directorName, "orgName" => $orgName, "directorMobile" => $directorMobile, "directorEmail" => $directorEmail, "orgMobile" => $orgMobile, "org_landline" => $org_landline,
                "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "orgType" => $orgType, "orgGoogle" => $orgGoogle, "orgWebsite" => $orgWebsite, "orgEstablished" => $orgEstablished,
                "approvedBy" => $approvedBy, "orgAddress" => $orgaddress, "orgDesp" => $orgDesp, "orgMission" => $orgMission, "orgVission" => $orgVission, "orgUpdated" => $this->datetimenow()];

            $response = $this->db->where("loginId", $_SESSION['loginId'])->update("organization_details", $data);
            return($response ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mupdateProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType, $orgGoogle) {
        $orgWebsite = FILTER_VAR(trim($this->input->post('orgWebsite')), FILTER_SANITIZE_STRING);
        $approvedBy = FILTER_VAR(trim($this->input->post('approvedBy')), FILTER_SANITIZE_STRING);
        $orgaddress = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);
        $edate = FILTER_VAR(trim($this->input->post('establishdate')), FILTER_SANITIZE_STRING);
        $facility = $this->input->post('facility');
        $orgDesp = $this->input->post('orgDesp');
        $orgMission = $this->input->post('orgMission');
        $orgVission = $this->input->post('orgVission');
        $org_landline = FILTER_VAR(trim($this->input->post('org_landline')), FILTER_SANITIZE_STRING);
        if (empty($directorName) || empty($directorMobile) || empty($directorEmail) || empty($orgName) || empty($orgMobile) || empty($countryId) || empty($stateId) || empty($cityId) || empty($orgType) || empty($orgWebsite) || empty($approvedBy) || empty($orgaddress) || empty($orgDesp) || empty($orgMission) || empty($orgVission) || !isset($_SESSION['loginId'])) {
            return '{"status":"error","msg":"Required field is empty!"}';
        } else {
            $data = ["orgName" => $orgName, "directorName" => $directorName, "directorMobile" => $directorMobile, "directorEmail" => $directorEmail, "orgMobile" => $orgMobile, "org_landline" => $org_landline, "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "orgType" => $orgType,
                "orgGoogle" => $orgGoogle, "orgWebsite" => $orgWebsite, "orgEstablished" => $edate, "approvedBy" => $approvedBy, "orgAddress" => $orgaddress, "orgDesp" => $orgDesp, "orgMission" => $orgMission, "orgVission" => $orgVission, "orgUpdated" => $this->datetimenow()];

            $response = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->update("organization_details", $data);
            ($response ? $this->addActivityLog($_SESSION['loginId'], "Organization Profile Updated by " . $_SESSION['orgName'], "organization_details", "0") : "");
            $res = ($response ? $this->db->where("loginId", $_SESSION['loginId'])->update("org_mapping_facilities", ["isactive" => 0]) : "");
            $rep = ($res ? $this->updatefacilities($facility, $_SESSION['loginId']) : "");
            return ($rep ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    private function updatefacilities($facility, $orgId) {
        $timenow = $this->datetimenow();
        for ($fi = 0; $fi < count($facility); $fi++) {
            $chk = $this->db->query("SELECT * FROM org_mapping_facilities WHERE facilityId=" . $facility[$fi] . " AND loginId=" . $orgId . "");
            if ($chk->num_rows() > 0) {
                $udata = ["updatedAt" => $timenow, "isactive" => 1];
                $this->db->where("facilityId", $facility[$fi]);
                $this->db->where("loginId", $orgId);
                $this->db->update("org_mapping_facilities", $udata);
            } else {
                $iData = ["facilityId" => $facility[$fi], "loginId" => $orgId, "createdAt" => $timenow, "isactive" => 1];
                $this->db->insert("org_mapping_facilities", $iData);
            }
        }
        return true;
    }

    public function mGetcurrencies() {
        return $this->db->query("SELECT * FROM currencies");
    }

    public function mSaveFinancialDetails($respond) {
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $bank_name = FILTER_VAR(trim($this->input->post('bank_name')), FILTER_SANITIZE_STRING);
        $baddress = FILTER_VAR(trim($this->input->post('bankaddress')), FILTER_SANITIZE_STRING);
        $accno = FILTER_VAR(trim($this->input->post('bank_account_no')), FILTER_SANITIZE_STRING);
        $account_holder_name = FILTER_VAR(trim($this->input->post('account_holder_name')), FILTER_SANITIZE_STRING);
        $accountType = FILTER_VAR(trim($this->input->post('accountType')), FILTER_SANITIZE_STRING);
        $ifscc = FILTER_VAR(trim($this->input->post('ifscCode')), FILTER_SANITIZE_STRING);
        $micrc = FILTER_VAR(trim($this->input->post('micr_code')), FILTER_SANITIZE_STRING);
        $ccardno = FILTER_VAR(trim($this->input->post('credit_card_no')), FILTER_SANITIZE_STRING);
        $dcardno = FILTER_VAR(trim($this->input->post('debit_card_no')), FILTER_SANITIZE_STRING);
        $defaultCur = FILTER_VAR(trim($this->input->post('defaultCurrency')), FILTER_SANITIZE_STRING);

//        $cccvvno = FILTER_VAR(trim($this->input->post('creditcard_cvv')), FILTER_SANITIZE_STRING);
//        $ccvalidity = FILTER_VAR(trim($this->input->post('creditcard_validity')), FILTER_SANITIZE_STRING);
//        $dcardcvv = FILTER_VAR(trim($this->input->post('debitcard_cvv')), FILTER_SANITIZE_STRING);
//        $dcvalidity = FILTER_VAR(trim($this->input->post('debitcard_valid')), FILTER_SANITIZE_STRING);
        if (empty($bank_name) || empty($account_holder_name) || empty($baddress) || empty($accno) || empty($ifscc) || empty($accountType) || empty($micrc) || empty($defaultCur)) {
            return '{"status":"error","msg":"Required field is empty"}';
        } else {
            $_SESSION['dCurrency'] = $defaultCur;
        }
        return ($id == "no_data" ? $this->insertFinancialDetails($bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $ccardno, $dcardno, $accountType) :
                $this->upDateFinancialDetails($id, $bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $ccardno, $dcardno, $accountType));
    }

    public function insertFinancialDetails($bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $ccardno, $dcardno, $accountType) {
        $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "University"]);
        $details = $this->db->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            $data = $details->row();
            $id = $data->financial_detail_id;
            return $this->upDateFinancialDetails($id, $bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $ccardno, $dcardno, $accountType);
        } else {
            $ccardno = ($ccardno === "" ? NULL : $this->encryption->encrypt($ccardno));
//            $cccvvno = ($cccvvno === "" ? NULL : $this->encryption->encrypt($cccvvno));
            $dcardno = ($dcardno === "" ? NULL : $this->encryption->encrypt($dcardno));
//            $dcardcvv = ($dcardcvv === "" ? NULL : $this->encryption->encrypt($dcardcvv));
            $accno = ($accno === "" ? NULL : $this->encryption->encrypt($accno));
            $idata = ["credit_card_no" => $ccardno, "debit_card_no" => $dcardno, "bank_name" => $bank_name, "bankaddress" => $baddress, "bank_account_no" => $accno, "account_holder_name" => $account_holder_name, "ifscCode" => $ifscc, "micr_code" => $micrc,
                "login_id" => $_SESSION['loginId'], "user_type" => "University", "defaultCurrency" => $defaultCur, "ip_address" => $this->getRealIpAddr(), "created_on" => $this->datetimenow(), "accountType" => $accountType, "isactive" => 1];
            $resp = $this->db->insert("tbl_financial_details", $idata);
            $this->addActivityLog($_SESSION['loginId'], "Finance Detail Inserted for University by " . $_SESSION['orgName'], "tbl_financial_details", "0");
        }
        return ($respond == "showmessage" ? ($resp != "" ? '{"status":"success","msg":"Inserted Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}') : "");
    }

    public function upDateFinancialDetails($id, $bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $ccardno, $dcardno, $accountType) {
        $this->db->where(["financial_detail_id!=" => $id, "login_id" => $_SESSION['loginId'], "user_type" => "University"]);
        $details = $this->db->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate details"}';
        } else {
            $ccardno = ($ccardno === "" ? NULL : $this->encryption->encrypt($ccardno));
//            $cccvvno = ($cccvvno === "" ? NULL : $this->encryption->encrypt($cccvvno));
            $dcardno = ($dcardno === "" ? NULL : $this->encryption->encrypt($dcardno));
//            $dcardcvv = ($dcardcvv === "" ? NULL : $this->encryption->encrypt($dcardcvv));
            $accno = ($accno === "" ? NULL : $this->encryption->encrypt($accno));
            $idata = ["credit_card_no" => $ccardno, "debit_card_no" => $dcardno, "bank_name" => $bank_name, "bankaddress" => $baddress, "bank_account_no" => $accno, "account_holder_name" => $account_holder_name, "ifscCode" => $ifscc, "micr_code" => $micrc,
                "login_id" => $_SESSION['loginId'], "user_type" => "University", "defaultCurrency" => $defaultCur, "ip_address" => $this->getRealIpAddr(), "updated_on" => $this->datetimenow(), "accountType" => $accountType];

            $resp = $this->db->where("financial_detail_id", $id)->update("tbl_financial_details", $idata);
            $this->addActivityLog($_SESSION['loginId'], "Finance Detail Updated for University by " . $_SESSION['orgName'], "tbl_financial_details", "0");
        }
        return ($respond == "showmessage" ? ($resp != "" ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}') : "");
    }

    public function mUploadApprovalDocs() {
        $AboutDoc = FILTER_VAR(trim($this->input->post('AboutDoc')), FILTER_SANITIZE_STRING);
        $approvalDocId = FILTER_VAR(trim($this->input->post('approvalDocId')), FILTER_SANITIZE_STRING);
        $docName = FILTER_VAR(trim($this->input->post('docName')), FILTER_SANITIZE_STRING);
        if ((!isset($_FILES['documentUpload']['name']) && empty($docName)) || !isset($_SESSION['loginId']) || empty($AboutDoc)) {
            return '{"status":"error","msg":"Required field is empty"}';
        }
        if (isset($_FILES['documentUpload']['name'])) {
            $response = $this->uploadDoc($_SESSION['orgName']);
            if ($response["status"] == "success") {
                $fileName = $response["response"];
            } else {
                return $response;
            }
        } else {

            $fileName = $docName;
        }
        return $this->addUpdateApprovalDoc($AboutDoc, $fileName, $docName, $approvalDocId);
    }

    private function addUpdateApprovalDoc($AboutDoc, $fileName, $docName, $approvalDocId) {
        $condtion = ($approvalDocId == "no_id" ? ["docName" => $fileName, "loginId" => $_SESSION['loginId'], "aboutDocument" => $AboutDoc, "isactive" => 1] :
                ["approvalDocId!=" => $approvalDocId, "docName" => $fileName, "loginId" => $_SESSION['loginId'], "aboutDocument" => $AboutDoc, "isactive" => 1]);
        $chk = $this->db->where($condtion)->get("tbl_orgapproval_doc");
        if ($chk->num_rows() > 0) {
            (file_exists($fileName) ? unlink($fileName) : "");
            return '{"status":"error","msg":"Duplicate details."}';
        }
        $OrgFileName = (isset($_FILES['documentUpload']['name']) ? $_FILES['documentUpload']['name'] : FILTER_VAR(trim($this->input->post('OrgFileName')), FILTER_SANITIZE_STRING));
        if ($approvalDocId == "no_id") {
            $idata = ["docName" => $fileName, "loginId" => $_SESSION['loginId'], "OrgFileName" => $OrgFileName, "aboutDocument" => $AboutDoc, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->insert("tbl_orgapproval_doc", $idata);
        } else {
            ($fileName != $docName ? (file_exists($fileName) ? unlink($docName) : "") : "");
            $udata = ["docName" => $fileName, "OrgFileName" => $OrgFileName, "aboutDocument" => $AboutDoc, "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where(["approvalDocId" => $approvalDocId, "loginId" => $_SESSION['loginId'], "isactive" => 1])->update("tbl_orgapproval_doc", $udata);
        }
        ($resp ? $this->addActivityLog($_SESSION['loginId'], "Approval Doc Uploaded by " . $_SESSION['orgName'], "tbl_orgapproval_doc", "0") : '');
        return ($resp != "" ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    private function uploadDoc($docName) {

        $this->createDirectory('./uploadedApprovalDocuments/' . date('Y') . '/' . date('m'));
        $config['upload_path'] = './uploadedApprovalDocuments/' . date('Y') . '/' . date('m');
        $config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX';
        $config['file_name'] = preg_replace("/\s+/", "_", $docName) . strtotime(date('Y-m-d h:i:s'));
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('documentUpload')) {
            $error = array('error' => $this->upload->display_errors());
            $response = ["response" => $error, "status" => "error"];
            return $response;
        } else {
            $data = $this->upload->data('file_name');
            $fileName = 'uploadedApprovalDocuments/' . date('Y') . '/' . date('m') . '/' . $data;
            $response = ["response" => $fileName, "status" => "success"];
            return $response;
        }
    }

    public function mDeletedocument() {
        $approvalDocId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId']) || empty($approvalDocId)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        $chk = $this->db->where(["loginId" => $_SESSION['loginId'], 'approvalDocId' => $approvalDocId, 'isactive' => 1])->get('tbl_orgapproval_doc');
        if ($chk->num_rows() > 0) {
            $uData = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where(['approvalDocId' => $approvalDocId])->update("tbl_orgapproval_doc", $uData);
            $rowData = $chk->row();
            (file_exists($rowData->docName) ? unlink($rowData->docName) : "");
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Approval Doc Deleted by " . $_SESSION['orgName'], "tbl_orgapproval_doc", "0") : '');

            return '{"status":"success","msg":"Deleted Successfully"}';
        } else {
            return '{"status":"error","msg":"Record not found!"}';
        }
    }

    public function mUploadedDocument() {
        $loginId = $_SESSION['loginId'];
        $approvalDocId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);

        $getDetails = $this->db->where(["loginId" => $loginId, "approvalDocId" => $approvalDocId, "isactive" => 1])->get("tbl_orgapproval_doc");
        if ($getDetails->num_rows() > 0) {
            $response = $getDetails->row();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mAddSliderImage() {
        if (isset($_FILES['sliderImage']['name'])) {
            $image = preg_replace("/\s+/", "_", $_FILES['sliderImage']['name']);
        } else {
            $image = "";
        }
        if (!isset($_SESSION['loginId']) || empty($image)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $chk = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_org_sliders");
            if ($chk->num_rows() >= 3) {
                return '{"status":"error", "msg":"You can upload only three images."}';
            } else {
                return $this->mInsertSliderImage();
            }
        }
    }

    private function mInsertSliderImage() {
        $path = 'projectimages/images/OrgSlider/' . date('Y') . '/' . date('m');
        $this->createDirectory($path);
        $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow());
        $response = $this->uploadImageCustom($path, $imgName, 'sliderImage', "1650");
        if ($response != "error") {
            $imgPath = $path . '/' . $response;
            $iData = ["imageUrl" => $imgPath, "loginId" => $_SESSION['loginId'], "useIt" => 1, "isactive" => 1];
            $res = $this->db->insert("tbl_org_sliders", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Slider Image Inserted by " . $_SESSION['orgName'] . "", "tbl_org_sliders", "0") : "");
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Error in image uploading!"}';
        }
    }

    public function mUpdateSliderImage() {
        $slideId = FILTER_VAR(trim($this->input->post('prevImageId')), FILTER_SANITIZE_STRING);
        $prevImage = FILTER_VAR(trim($this->input->post('prevImage')), FILTER_SANITIZE_STRING);
        if (isset($_FILES['sliderImage']['name'])) {
            $image = preg_replace("/\s+/", "_", $_FILES['sliderImage']['name']);
        } else {
            $image = "";
        }
        if (!isset($_SESSION['loginId']) || empty($slideId) || empty($prevImage) || empty($image)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $chk = $this->db->where(["slideId" => $slideId, "loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_org_sliders");
            if ($chk->num_rows() > 0) {
                return $this->mUpdaterSliderImage($slideId, $prevImage);
            } else {
                return '{"status":"error", "msg":"No image found."}';
            }
        }
    }

    private function mUpdaterSliderImage($slideId, $prevImage) {
        $path = 'projectimages/images/OrgSlider/' . date('Y') . '/' . date('m');
        $this->createDirectory($path);
        $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow());
        $response = $this->uploadImageCustom($path, $imgName, 'sliderImage', "1650");
        if ($response != "error") {
            $imgPath = $path . '/' . $response;
            $iData = ["imageUrl" => $imgPath, "loginId" => $_SESSION['loginId'], "useIt" => 1, "isactive" => 1];
            $res = $this->db->where(["slideId" => $slideId])->update("tbl_org_sliders", $iData);
            if (file_exists($prevImage)) {
                unlink($prevImage);
            }
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Slider Image Changed by " . $_SESSION['orgName'] . "", "tbl_org_sliders", "0") : "");
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Error in image uploading!"}';
        }
    }

    public function mDeleteSliderImage() {

        $slideId = FILTER_VAR(trim($this->input->post('slideId')), FILTER_SANITIZE_STRING);
        if (empty($slideId) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $chk = $this->db->where(["slideId" => $slideId, "loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_org_sliders");

            if ($chk->num_rows() > 0) {
                $data = ["isactive" => 0];
                $res = $this->db->where("slideId", $slideId)->update("tbl_org_sliders", $data);
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Slider Image deleted by " . $_SESSION['orgName'] . "", "tbl_org_sliders", "0") : "");
                return ($res ? '{"status":"success", "msg":"Deleted Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Error image not found!"}';
            }
        }
    }

    public function uploadheaderImageVideo() {
        $type = FILTER_VAR(trim($this->input->post('type')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION["loginId"])) {
            return '{"status":"error", "msg":"Invalid login!"}';
        }
        if ($type == "image") {
            $prevImageId = FILTER_VAR(trim($this->input->post('prevImageId')), FILTER_SANITIZE_STRING);
            $prevImage = FILTER_VAR(trim($this->input->post('prevImage')), FILTER_SANITIZE_STRING);
            $chk = $this->db->where(["loginId" => $_SESSION["loginId"], "isactive" => 1, "type" => $type])->get("tbl_headerimagevideo");
            if ($chk->num_rows() > 2) {
                return '{"status":"error", "msg":"Only three images allowed!"}';
            } else {
                return $this->uploadHeaderImage($type, $prevImageId, $prevImage);
            }
        }
        if ($type == "video") {
            $orgVideoUrl = FILTER_VAR(trim($this->input->post('orgVideoUrl')), FILTER_SANITIZE_STRING);
            return $this->uploadHeaderVideo($orgVideoUrl);
        }
    }

    private function uploadHeaderVideo($orgVideoUrl) {
        if (!isset($_FILES['orgvideoHeader']['name']) && empty($orgVideoUrl)) {
            return '{"status":"error", "msg":"Required details are empty!"}';
        }
        if ($orgVideoUrl != "") {
            $udata = ["orgVideo" => $orgVideoUrl, "orgUpdated" => $this->datetimenow()];
            $resp = $this->db->where(["loginId" => $_SESSION["loginId"], "isactive" => 1])->update("organization_details", $udata);
        } else {
            $path = 'projectvideos/headerVideos/' . date('Y') . '/' . date('m');
            $this->createDirectory($path);
            $vidName = $_SESSION['orgName'] . strtotime($this->datetimenow());
            $url = $this->uploadVideo($path, $vidName, 'orgvideoHeader');
            if ($url !== "error") {
                $udata = ["orgVideo" => $url, "orgUpdated" => $this->datetimenow()];
                $resp = $this->db->where(["loginId" => $_SESSION["loginId"], "isactive" => 1])->update("organization_details", $udata);
            } else {
                return '{"status":"error", "msg":"Video upload Error"}';
            }
        }
        ($resp ? $this->addActivityLog($_SESSION['loginId'], "Header Video Inserted by " . $_SESSION['orgName'] . "", "organization_details", "0") : "");
        return ($resp ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
    }

    private function uploadVideo($path, $vidName, $uploadfname) {

        $config = ['upload_path' => $path, 'allowed_types' => "mp4|mkv|m4v|avi|flv|mov", "file_name" => $vidName];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($uploadfname) == false) {

            return 'error';
        } else {
            $data = $this->upload->data();
            return $path . '/' . $data['file_name'];
        }
    }

    private function uploadHeaderImage($type, $prevImageId, $prevImage) {
        $path = 'projectimages/images/headerImages/' . date('Y') . '/' . date('m');
        $this->createDirectory($path);
        $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow());
        $response = $this->uploadImageCustom($path, $imgName, 'headerImage', "1024");
        if ($response != "error") {
            $imgPath = $path . '/' . $response;
            if ($prevImageId !== "") {
                return $this->removePrevImage($prevImageId, $prevImage, $imgPath);
            } else {
                $iData = ["type" => $type, "loginId" => $_SESSION['loginId'], "url" => $imgPath, 'createdAt' => $this->datetimenow(),
                    "isactive" => 1];
                $res = $this->db->insert("tbl_headerimagevideo", $iData);
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Header Image Inserted by " . $_SESSION['orgName'] . "", "tbl_headerimagevideo", "0") : "");
                return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            }
        } else {
            return '{"status":"error", "msg":"Error in image uploading!"}';
        }
    }

    private function removePrevImage($prevImageId, $prevImage, $imgPath) {
        $chk = $this->db->where(["headerId" => $prevImageId, "loginId" => $_SESSION['loginId']])->get("tbl_headerimagevideo");
        if ($chk->num_rows() > 0) {
            $udata = ["type" => "image", "loginId" => $_SESSION['loginId'], "url" => $imgPath, 'updatedAt' => $this->datetimenow()];
            $resp = $this->db->where(["headerId" => $prevImageId, "loginId" => $_SESSION['loginId']])->update("tbl_headerimagevideo", $udata);
            if ($resp) {
                (file_exists($prevImage) ? unlink($prevImage) : "");
            }
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Header Image Changed by " . $_SESSION['orgName'] . "", "tbl_headerimagevideo", "0") : "");
            return ($resp ? '{"status":"success", "msg":"Updated Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Error in not found in database!"}';
        }
    }

    public function mDeleteHeaderImage() {
        $headerId = FILTER_VAR(trim($this->input->post('headerId')), FILTER_SANITIZE_STRING);
        if (empty($headerId) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $chk = $this->db->where(["headerId" => $headerId, "loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_headerimagevideo");

            if ($chk->num_rows() > 0) {
                $data = ['updatedAt' => $this->datetimenow(), "isactive" => 0];
                $res = $this->db->where("headerId", $headerId)->update("tbl_headerimagevideo", $data);
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Header Image deleted by " . $_SESSION['orgName'] . "", "tbl_headerimagevideo", "0") : "");
                $rowData = $chk->row();
                ($res ? (file_exists($rowData->url) ? unlink($rowData->url) : "") : "");
                return ($res ? '{"status":"success", "msg":"Deleted Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Error image not found!"}';
            }
        }
    }

    public function mSetDefaultImage($type, $headerId) {
        if ($type == "video") {
            $res = $this->db->where("loginId", $_SESSION['loginId'])->update("organization_details", ["defaultHeader" => $type]);
            return ($res ? '{"status":"success", "msg":"Set Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            if (empty($headerId) || !isset($_SESSION['loginId'])) {
                return '{"status":"error", "msg":"Empty Details!"}';
            }
            $chk = $this->db->where(["headerId" => $headerId, "loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_headerimagevideo");
            if ($chk->num_rows() > 0) {
                $rowData = $chk->row();
                $data = ['orgImgHeader' => $rowData->url, "defaultHeader" => $type, 'orgUpdated' => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->where("loginId", $_SESSION['loginId'])->update("organization_details", $data);
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Header Image set default by " . $_SESSION['orgName'] . "", "organization_details", "0") : "");
                return ($res ? '{"status":"success", "msg":"Set Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Error image not found!"}';
            }
        }
    }

    //university profile end
    //Department Start
    public function mshowDepartments() {
        $orgId = $_SESSION['loginId'];
        $departmentId = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);

        if ($departmentId) {
            $departmentId = base64_decode($departmentId);
            $condition = " AND departmentId =$departmentId AND isactive=1";
        } else {
            $condition = " AND isactive=1";
        }
        $qry = $this->db->query("SELECT * FROM department WHERE loginId=$orgId $condition");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $qr) {
                $qr->departmentId = base64_encode($qr->departmentId);
            }
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function maddNewDepartment() {
        $orgId = $_SESSION['loginId'];
        $departmentId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $departmentCode = FILTER_VAR(trim($this->input->post('departmentCode')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $timenow = $this->datetimenow();
        if ($departmentId == 'no_one') {
            $condition = "AND isactive=1";
        } else {
            $departmentId = base64_decode($departmentId);
            $condition = "AND departmentId !=$departmentId  AND isactive=1";
        }
        $chkduplicate = $this->db->query("SELECT * from department where (departmentCode='" . $departmentCode . "' OR title='" . $title . "')
                                           AND loginId=$orgId $condition");
        if ($chkduplicate->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Entry!"}';
        } else {
            return $this->editInsertDepartmentDetails($departmentId, $orgId, $departmentCode, $title, $timenow);
        }
    }

    private function editInsertDepartmentDetails($departmentId, $orgId, $departmentCode, $title, $timenow) {
        if ($departmentId == 'no_one') {
            $iData = ["loginId" => $orgId, "departmentCode" => $departmentCode, "title" => $title, "createdAt" => $timenow, "isactive" => 1];
            $response = $this->db->insert("department", $iData);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Department Added by " . $_SESSION['orgName'], "department", "0");
                return '{"status":"success","msg":"Added Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        } else {
            $uData = ["departmentCode" => $departmentCode, "title" => $title, "updatedAt" => $timenow];
            $response = $this->db->where("departmentId", $departmentId)->update("department", $uData);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Department Updated by " . $_SESSION['orgName'], "department", "0");
                return '{"status":"success","msg":"Updated Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mdelDepartment() {
        $orgId = $_SESSION['loginId'];
        $departmentId1 = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $departmentId = base64_decode($departmentId1);
        $chk = $this->db->query("SELECT * from department where departmentId=$departmentId AND loginId=$orgId and isactive=1");
        if ($chk->num_rows() > 0) {
            $data = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $this->db->where("departmentId", $departmentId);
            $response = $this->db->update("department", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Department Deleted by " . $_SESSION['orgName'], "department", "0");
                return '{"status":"success", "msg":"Deletion Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Invalid department Id!"}';
        }
    }

    //Deppartment End
    //addPages start
    public function mshowPages() {
        $orgId = $_SESSION['loginId'];
        $pageId = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if ($pageId) {
            $pageId = base64_decode($pageId);
            $condition = " AND pageId =$pageId AND isactive=1";
        } else {
            $condition = " AND isactive=1";
        }
        $qry = $this->db->query("SELECT pageId,pageName,approvalStatus,DATE_FORMAT(createdAt,'%d-%b-%y %r') as date,description,
            paymentLink,paymentAmount,paymentStatus FROM pages WHERE loginId=$orgId $condition");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $qr) {
                $qr->pageId = base64_encode($qr->pageId);
            }
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function maddNewPages() {
        $orgId = $_SESSION['loginId'];
        $pageId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $pageName = FILTER_VAR(trim($this->input->post('pageName')), FILTER_SANITIZE_STRING);
        $description = $this->input->post('description');
        $timenow = $this->datetimenow();
        if ($pageId == 'no_one') {
            $condition = "AND isactive=1";
        } else {
            $pageId = base64_decode($pageId);
            $condition = "AND pageId !=$pageId  AND isactive=1";
        }
        $chkduplicate = $this->db->query("SELECT * FROM pages WHERE (pageName='$pageName' OR description='" . $description . "') AND loginId=$orgId $condition");
        if ($chkduplicate->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Entry!"}';
        } else {
            return $this->insertUpdatePages($pageId, $orgId, $pageName, $description, $timenow);
        }
    }

    private function insertUpdatePages($pageId, $orgId, $pageName, $description, $timenow) {
        if ($pageId == 'no_one') {
            $iData = ["loginId" => $orgId, "pageName" => $pageName, "description" => $description, "createdAt" => $timenow, "isactive" => 1];
            $response = $this->db->insert("pages", $iData);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Page Inserted by " . $_SESSION['orgName'], "pages", "0");
                return '{"status":"success","msg":"Added Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        } else {
            $uData = ["pageName" => $pageName, "description" => $description, "updatedAt" => $timenow];
            $this->db->where("pageId", $pageId);
            $response = $this->db->update("pages", $uData);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Page Updated by " . $_SESSION['orgName'], "pages", "0");
                return '{"status":"success","msg":"Updated Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mDelPages() {
        $pageId1 = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $pageId = base64_decode($pageId1);
        if (isset($_SESSION['loginId']) || empty($pageId)) {
            return '{"status":"error", "msg":"Invalid Session!"}';
        }
        $chk = $this->db->query("SELECT * from pages where pageId=$pageId AND loginId=" . $_SESSION['loginId'] . " and isactive=1");
        if ($chk->num_rows() > 0) {
            $data = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $response = $this->db->where("pageId", $pageId)->update("pages", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Page Deleted by " . $_SESSION['orgName'] . "", "pages", "0");
                return '{"status":"success", "msg":"Deletion Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Invalid department Id!"}';
        }
    }

    public function mSubmitForApproval() {
        $pageId = FILTER_VAR(trim($this->input->post('pageId')), FILTER_SANITIZE_STRING);
        $reqType = FILTER_VAR(trim($this->input->post('reqType')), FILTER_SANITIZE_STRING);
        if (empty($pageId) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Required field id empty!"}';
        }
        if ($reqType == "sendforapproval") {
            $pageId = base64_decode($pageId);
            $chk = $this->db->where(["pageId" => $pageId, "loginId" => $_SESSION['loginId'], "approvalStatus" => "", "isactive" => 1])->get("pages");
            if ($chk->num_rows() > 0) {
                $udata = ["approvalStatus" => "approval_request", "updatedAt" => $this->datetimenow()];
                $resp = $this->db->where(["pageId" => $pageId, "loginId" => $_SESSION['loginId'], "approvalStatus" => "", "isactive" => 1])->update("pages", $udata);
                ($resp ? $this->addActivityLog($_SESSION['loginId'], "Page submitted for approval", "pages", "0") : "" );
                return ($resp ? '{"status":"success", "msg":"Page Sent for approval successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Requested page not found."}';
            }
        }
        if ($reqType == "cancelapproval") {
            return $this->cancelapproval($pageId);
        }
    }

    private function cancelapproval($pageId1) {
        $pageId = base64_decode($pageId1);
        $chk = $this->db->where(["pageId" => $pageId, "loginId" => $_SESSION['loginId'], "approvalStatus" => "approval_request", "isactive" => 1])->get("pages");
        if ($chk->num_rows() > 0) {
            $udata = ["approvalStatus" => "", "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where(["pageId" => $pageId, "loginId" => $_SESSION['loginId'], "approvalStatus" => "approval_request", "isactive" => 1])->update("pages", $udata);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Page approval cancelled", "pages", "0") : "" );
            return ($resp ? '{"status":"success", "msg":"Page approval request cancelled"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Requested page not found."}';
        }
    }

    //addPages End
    //addCourse start
    public function mGetTimeDuration() {
        if (!isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Unauthorised access!"}';
        }
        $qry = $this->db->query("SELECT * FROM time_duration where isactive=1 order by title ASC");
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mGetMinQualification() {
        $qry = $this->db->query("SELECT cd.cId  courseId,cd.title courseName,'course_details' as tablename,'Course Name' courseCategory FROM course_details cd
        INNER JOIN course_type ct ON ct.ctId=cd.ctId AND ct.isactive=1
        INNER JOIN stream_details sd ON sd.cId=cd.cId AND sd.isactive=1
        WHERE cd.isactive=1
        UNION
        SELECT sct.classnamesId  courseId,sct.classTitle courseName,'tbl_classnames' as tablename,'Class Name' courseCategory FROM tbl_classnames sct WHERE sct.isactive=1
        UNION
        SELECT inc.insCourseId  courseId,inc.title courseName,'institute_course' as tablename,'Institute Course' courseCategory FROM institute_course inc WHERE inc.isactive=1
        UNION
        SELECT tcem.c_exam_id courseId,tcem.exam_name courseName,'tbl_competitive_exam_master' as tablename,'Competitive Exam' courseCategory  FROM tbl_competitive_exam_master tcem WHERE tcem.isactive=1
        UNION
        SELECT tsm.subjectId courseId,tsm.subjectTitle courseName,'tbl_subjectmaster' as tablename,'Subject Name' courseCategory  FROM tbl_subjectmaster tsm WHERE tsm.isactive=1");
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mgetMinqualificationData() {
        $qry = $this->db->query("SELECT cd.cId  courseId,cd.title courseName,'course_details' as tablename,'Course Name' courseCategory FROM course_details cd
                INNER JOIN course_type ct ON ct.ctId=cd.ctId AND ct.isactive=1
                INNER JOIN stream_details sd ON sd.cId=cd.cId AND sd.isactive=1
                WHERE cd.isactive=1
                UNION
                SELECT sct.classnamesId  courseId,sct.classTitle courseName,'tbl_classnames' as tablename,'Class Name' courseCategory FROM tbl_classnames sct WHERE sct.isactive=1
                UNION
                SELECT inc.insCourseId  courseId,inc.title courseName,'institute_course' as tablename,'Institute Course' courseCategory FROM institute_course inc WHERE inc.isactive=1
                UNION
                SELECT tcem.c_exam_id courseId,tcem.exam_name courseName,'tbl_competitive_exam_master' as tablename,'Competitive Exam' courseCategory  FROM tbl_competitive_exam_master tcem WHERE tcem.isactive=1
                UNION
                SELECT tsm.subjectId courseId,tsm.subjectTitle courseName,'tbl_subjectmaster' as tablename,'Subject Name' courseCategory  FROM tbl_subjectmaster tsm WHERE tsm.isactive=1");
        if ($qry->num_rows() > 0) {
            return $qry->result();
        } else {
            return false;
        }
    }

    public function mgetTimeDurationData() {
        $qry = $this->db->query("SELECT * FROM time_duration where isactive=1 order by title ASC");
        if ($qry->num_rows() > 0) {
            return $qry->result();
        } else {
            return false;
        }
    }

    public function mGetCourseType() {
        if (!isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Unauthorised access!"}';
        }
        $qry = $this->db->query("SELECT * FROM course_type where isactive=1 order by courseType ASC");
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mgetcourseTypeBycourse() {
        $ctId = FILTER_VAR(trim($this->input->post('ctId')), FILTER_SANITIZE_STRING);
        if ($ctId) {
            $condition = " AND ctId=$ctId";
        } else {
            $condition = "";
        }
        $qry = $this->db->query("SELECT * FROM  course_details WHERE isactive=1 $condition order by title desc");
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function maddCourseType() {
        $loginid = $_SESSION['loginId'];
        $courseType = FILTER_VAR(trim($this->input->post('courseType')), FILTER_SANITIZE_STRING);
        $chk = $this->checkCourseType($courseType);
        $timenow = $this->datetimenow();
        $response = "";
        if (empty($loginid) || empty($courseType)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            $data = ["loginid" => $loginid, "courseType" => $courseType, "requestStatus" => 1, "createdAt" => $timenow, "isactive" => 1];
            $response = $this->db->insert("course_type", $data);
        }if ($response) {
            $this->addActivityLog($_SESSION['loginId'], "Course Type Inserted by " . $_SESSION['orgName'], "course_type", "0");
            return '{"status":"success", "msg":"Saved Successfully"}';
        } else {
            return '{"status":"error", "msg":"Error in server, please contact admin!"}';
        }
    }

    public function maddCourseTypeCourse() {
        $courseType = FILTER_VAR(trim($this->input->post('courseTypeIdnew')), FILTER_SANITIZE_STRING);
        $course = FILTER_VAR(trim(ucwords(strtolower($this->input->post('courseNew')))), FILTER_SANITIZE_STRING);
        if (empty($courseType) || empty($course) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $chk = $this->db->where(["ctId" => $courseType, "title" => $course, "isactive" => 1])->get("course_details");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            $idata = ["ctId" => $courseType, "title" => $course, "requestStatus" => 1, "loginid" => $_SESSION['loginId'],
                "createdAt" => $this->datetimenow(), "isactive" => 1];
            $response = $this->db->insert("course_details", $idata);
            ($response ? $this->addActivityLog($_SESSION['loginId'], "Course Details Inserted by " . $_SESSION['orgName'], "course_details", "0") : "");
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function maddNewDuration() {
        $newDuration = FILTER_VAR(trim(ucwords(strtolower($this->input->post('newDuration')))), FILTER_SANITIZE_STRING);
        if (empty($newDuration) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $chk = $this->db->where(["title" => $newDuration, "isactive" => 1])->get("time_duration");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            $idata = ["title" => $newDuration, "createdBy" => $_SESSION['orgName'] . '_' . $_SESSION['loginId'],
                "createdAt" => $this->datetimenow(), "isactive" => 1];
            $response = $this->db->insert("time_duration", $idata);
            ($response ? $this->addActivityLog($_SESSION['loginId'], "Course Time Duration Inserted by " . $_SESSION['orgName'], "time_duration", "0") : "");
            return($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mAddType() {
        $newType = FILTER_VAR(trim(ucwords(strtolower($this->input->post('newType')))), FILTER_SANITIZE_STRING);
        if (empty($newType) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $chk = $this->db->where(["typeTile" => $newType, "isactive" => 1])->get("tbl_coursetype");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            $idata = ["typeTile" => $newType, "createdBy" => $_SESSION['orgName'] . '_' . $_SESSION['loginId'],
                "createdAt" => $this->datetimenow(), "isactive" => 1];
            $response = $this->db->insert("tbl_coursetype", $idata);
            ($response ? $this->addActivityLog($_SESSION['loginId'], "Course Mode Type Inserted by " . $_SESSION['orgName'], "time_duration", "0") : "");
            return($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mGetCourseDurationType() {
        $qry = $this->db->where(["isactive" => 1])->select("typeTile")->get("tbl_coursetype");
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function maddCourse($departmentId1, $courseTypeId, $courseId, $courseDurationId, $courseDurationType, $openingDate, $closingDate, $examDate, $minage, $maxage, $orgCourseId, $min_qualification, $min_percentage, $duration_type, $experience_duration, $applicationFee, $examMode, $resultDate) {
//            $courseFeeType      =       FILTER_VAR(trim($this->input->post('courseFeeType')),FILTER_SANITIZE_STRING);
//            $courseFee          =       FILTER_VAR(trim($this->input->post('courseFee')),FILTER_SANITIZE_STRING);
//            $registrationFee    =       FILTER_VAR(trim($this->input->post('registrationFee')),FILTER_SANITIZE_STRING);
//            $fromDate           =       FILTER_VAR(trim($this->input->post('fromDate')),FILTER_SANITIZE_STRING);
//            $toDate             =       FILTER_VAR(trim($this->input->post('toDate')),FILTER_SANITIZE_STRING);

        $description = $this->input->post("description");
        $examDetails = FILTER_VAR(trim($this->input->post('examDetails')), FILTER_SANITIZE_STRING);
        $departmentId = base64_decode($departmentId1);
        if (!isset($_SESSION['loginId']) || empty($departmentId) || empty($courseTypeId) || empty($courseId) || empty($courseDurationId) || empty($courseDurationType) || empty($openingDate) || empty($closingDate)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        } else {
            $data1 = ["loginId" => $_SESSION['loginId'], "departmentId" => $departmentId, "courseTypeId" => $courseTypeId, "courseId" => $courseId, "courseDurationId" => $courseDurationId,
                "courseDurationType" => $courseDurationType, "openingDate" => $openingDate, "closingDate" => $closingDate, "examDate" => $examDate, "isactive" => 1];
            if ($orgCourseId == 'no_one') {
                $data = $data1;
            } else {
                $data = array_merge($data1, ["orgCourseId!=" => $orgCourseId]);
            }
            $duplicates = $this->db->where($data)->get("organization_courses");
            if ($duplicates->num_rows() > 0) {
                return '{"status":"error", "msg":"Duplicate entry!"}';
            } else {
                return $this->insertUpdateCourse($orgCourseId, $_SESSION['loginId'], $departmentId, $courseTypeId, $courseId, $courseDurationId, $courseDurationType, $openingDate, $closingDate, $examDate, $this->datetimenow(), $min_qualification, $min_percentage, $duration_type, $experience_duration, $description, $minage, $maxage, $examDetails, $applicationFee, $examMode, $resultDate);
            }
        }
    }

    private function insertUpdateCourse($orgCourseId, $orgId, $departmentId, $courseTypeId, $courseId, $courseDurationId, $courseDurationType, $openingDate, $closingDate, $examDate, $datetimenow, $min_qualification, $min_percentage, $duration_type, $experience_duration, $description, $minage, $maxage, $examDetails, $applicationFee, $examMode, $resultDate) {
        $ageValidDate = FILTER_VAR(trim($this->input->post('validupto')), FILTER_SANITIZE_STRING);
        $idata = ["loginId" => $orgId, "departmentId" => $departmentId, "courseTypeId" => $courseTypeId, "courseId" => $courseId, "courseDurationId" => $courseDurationId, "courseDurationType" => $courseDurationType, "applicationFee" => $applicationFee, "examMode" => $examMode,
            "openingDate" => $openingDate, "closingDate" => $closingDate, "examDate" => $examDate, "minAge" => $minage, "maxAge" => $maxage, "ageValidDate" => $ageValidDate, "examDetails" => $examDetails, "resultDate" => $resultDate, "isactive" => 1];
        if ($orgCourseId == 'no_one') {
            $this->db->insert("organization_courses", array_merge($idata, ["createdAt" => $datetimenow]));
            $norgCourseId = $this->db->insert_id();
            $this->addActivityLog($_SESSION['loginId'], "Organization Course Details Inserted by " . $_SESSION['orgName'], "organization_courses", "0");
        } else {
            $this->db->where("orgCourseId", $orgCourseId)->update("organization_courses", array_merge($idata, ["updatedAt" => $datetimenow]));
            $this->addActivityLog($_SESSION['loginId'], "Organization Course Details Updated by " . $_SESSION['orgName'], "organization_courses", "0");
            $norgCourseId = $orgCourseId;
        }
        if ($norgCourseId) {
            $min_qualificationStream = $this->input->post("min_qualificationStream");
            $markingType = $this->input->post("markingType");
            $this->addMinQualification($min_qualification, $norgCourseId, $min_percentage, $min_qualificationStream, $markingType);
            ($duration_type[0] == "" ? "" : $this->addDuration($duration_type, $norgCourseId, $experience_duration, $description, $datetimenow));
        }
        return ($norgCourseId != "" ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    private function addMinQualification($min_qualification, $norgCourseId, $min_percentage, $min_qualificationStream, $markingType) {
        if ($min_qualification[0] == "") {
            return false;
        }
        $chk = $this->db->where("orgCourseId", $norgCourseId)->get("orgcourse_mapping_prerequisites");
        if ($chk->num_rows() > 0) {
            $this->db->where("orgCourseId", $norgCourseId)->update("orgcourse_mapping_prerequisites", ["isactive" => 0]);
        }
        $condition = $this->input->post("condition");
        for ($mq = 0; $mq < count($min_qualification); $mq++) {
            $this->minsertUpdatePrerequisites($mq, $min_qualification, $min_qualificationStream, $condition, $norgCourseId, $min_percentage, $markingType);
        }
    }

    private function minsertUpdatePrerequisites($mq, $min_qualification, $min_qualificationStream, $condition, $orgCourseId, $min_percentage, $markingType) {
        $coursetablename = explode(",", $min_qualification[$mq]);
        $courseId = (count($coursetablename) > 1 ? $coursetablename[0] : "");
        $tablename = (count($coursetablename) > 1 ? $coursetablename[1] : "");
        $Streamtablename = explode(",", $min_qualificationStream[$mq]);

        $SteamId = (count($Streamtablename) > 1 ? $Streamtablename[0] : "");
        $Stablename = (count($Streamtablename) > 1 ? $Streamtablename[1] : "");

        $realtion = ($condition != "" ? (array_key_exists($mq, $condition) ? $condition[$mq] : "") : "");
        $chkomp = $this->db->where(["orgCourseId" => $orgCourseId, "isactive" => 0])->get("orgcourse_mapping_prerequisites");
        if ($chkomp->num_rows() > 0) {
            $udata = ["orgCourseId" => $orgCourseId, "courseMinQualId" => $courseId, "tableName" => $tablename, "percentage" => $min_percentage[$mq], "minqualstreamId" => $SteamId, "streamTableName" => $Stablename,
                "markingType" => $markingType[$mq], "relationType" => $realtion, "updatedAt" => $this->datetimenow(), "isactive" => 1];
            $rowData = $chkomp->row();
            $this->db->where("prerequisitesId", $rowData->prerequisitesId)->update("orgcourse_mapping_prerequisites", $udata);
        } else {
            $mpData = ["orgCourseId" => $orgCourseId, "courseMinQualId" => $courseId, "tableName" => $tablename, "percentage" => $min_percentage[$mq], "minqualstreamId" => $SteamId, "streamTableName" => $Stablename,
                "markingType" => $markingType[$mq], "relationType" => $realtion, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $this->db->insert("orgcourse_mapping_prerequisites", $mpData);
        }
    }

    private function addDuration($duration_type, $norgCourseId, $experience_duration, $description, $datetimenow) {
        $chk = $this->db->where("orgCourseId", $norgCourseId)->get("orgcourse_mapping_experience");
        if ($chk->num_rows() > 0) {
            $this->db->where("orgCourseId", $norgCourseId)->update("orgcourse_mapping_experience", ["isactive" => 0]);
        }
        for ($edt = 0; $edt < count($duration_type); $edt++) {
            $chkomp = $this->db->where(["orgCourseId" => $norgCourseId, "isactive" => 0])->get("orgcourse_mapping_experience");
            if ($chkomp->num_rows() > 0) {
                $rowData = $chkomp->row();
                $udata = ["orgCourseId" => $norgCourseId, "expDurationType" => $duration_type[$edt], "expDurationId" => $experience_duration[$edt],
                    "description" => $description[$edt], "updatedAt" => $datetimenow, "isactive" => 1];
                $this->db->where("experienceId", $rowData->experienceId)->update("orgcourse_mapping_experience", $udata);
            } else {
                $edtData = ["orgCourseId" => $norgCourseId, "expDurationType" => $duration_type[$edt], "expDurationId" => $experience_duration[$edt],
                    "description" => $description[$edt], "createdAt" => $datetimenow, "isactive" => 1];
                $this->db->insert("orgcourse_mapping_experience", $edtData);
            }
        }
    }

    public function mGetCourses() {
        $orgCourseId = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        $loginId = $_SESSION['loginId'];
        if ($orgCourseId) {
            $qry = $this->db->query('SELECT * FROM organization_courses WHERE loginId ="' . $loginId . '" AND orgCourseId ="' . $orgCourseId . '"');
        } else {
            $qry = $this->db->query('SELECT oc.orgCourseId,dt.title as department,oc.departmentId,oc.courseId,oc.courseFeeType,oc.courseFee,
                    ct.courseType,cd.title as course,td.title as timeduration,DATE_FORMAT(oc.openingDate,"%d-%b-%Y") appOpening,DATE_FORMAT(oc.closingDate,"%d-%b-%Y") appClosing,
                    oc.applicationFee,oc.minAge,oc.maxAge,DATE_FORMAT(oc.ageValidDate ,"%d-%b-%Y") ageValid,DATE_FORMAT(oc.examDate,"%d-%b-%Y") exmDate,oc.examMode,oc.examDetails,oc.examMode,
                    DATE_FORMAT(oc.resultDate,"%d-%b-%Y") rdate,GROUP_CONCAT(CONCAT(sd.title,",",os.courseFee,",",os.totalSheet,",",os.availableSheet,",",cft.FeeType_Name) SEPARATOR "^") streamDetails,
                    GROUP_CONCAT(os.registrationFee) regfee FROM organization_courses as oc  INNER JOIN course_type as ct ON ct.ctId=oc.courseTypeId
                    LEFT JOIN organization_streams os ON os.orgCourseId=oc.orgCourseId AND os.isactive=1
                    LEFT JOIN course_fee_type cft ON cft.courseFeeType_Id=os.courseFeeType AND cft.isactive=1 LEFT JOIN stream_details sd ON sd.streamId=os.streamId AND sd.isactive=1 INNER JOIN course_details as cd ON cd.cId=oc.courseId
                    INNER JOIN time_duration as td ON td.tdId=oc.courseDurationId  INNER JOIN department as dt ON dt.departmentId=oc.departmentId WHERE oc.isactive=1 and oc.loginId ="' . $loginId . '" GROUP BY oc.orgCourseId ORDER BY oc.orgCourseId DESC');
        }
        // $this->db->last_query();
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mdeleteCourse() {
        $orgId = $_SESSION['loginId'];
        $orgCourseId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (empty($orgId) || empty($orgCourseId)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $chk = $this->db->query("SELECT * from organization_courses where orgCourseId=$orgCourseId AND loginId=$orgId and isactive=1");
        if ($chk->num_rows() > 0) {
            $data = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $this->db->where("orgCourseId", $orgCourseId);
            $response = $this->db->update("organization_courses", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Organization Course Deletion by " . $_SESSION['orgName'], "organization_courses", "0");
                return '{"status":"success", "msg":"Deletion Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Invalid Id!"}';
        }
    }

    public function mgetCourseDetails($orgCourseId) {
        $orgId = $_SESSION['loginId'];
        return $this->db->query("SELECT oc.*, (SELECT GROUP_CONCAT(CONCAT(ompre.prerequisitesId,',',ompre.courseMinQualId,',',ompre.tableName,',',
            ompre.minqualstreamId,',',ompre.streamTableName,',',ompre.markingType,',',ompre.percentage,',',ompre.relationType) SEPARATOR '^') FROM organization_courses orgc
                LEFT JOIN orgcourse_mapping_prerequisites ompre ON ompre.orgCourseId=orgc.orgCourseId AND ompre.isactive=1
                          WHERE orgc.orgCourseId=$orgCourseId AND orgc.isactive=1 AND orgc.loginId=$orgId GROUP BY orgc.orgCourseId
                         ) as courseMinQuals, GROUP_CONCAT(ome.expDurationType) as expDurationTypes,GROUP_CONCAT(ome.expDurationId) AS expDurationIds,
                         GROUP_CONCAT(ome.description) AS descriptions
                            FROM organization_courses oc
                            LEFT JOIN orgcourse_mapping_experience ome ON ome.orgCourseId=oc.orgCourseId AND ome.isactive=1

                            WHERE oc.isactive=1 AND oc.orgCourseId=$orgCourseId AND oc.loginId=$orgId GROUP BY oc.orgCourseId");
    }

    public function mGetpreRequisites() {
        $orgId = $_SESSION['loginId'];
        $orgCourseId = FILTER_VAR(trim($this->input->post('orgCourseId')), FILTER_SANITIZE_STRING);
        $qry = $this->db->query("SELECT (SELECT GROUP_CONCAT(CONCAT(ompre.prerequisitesId,',',ompre.courseMinQualId,',',ompre.tableName,',',
            ompre.minqualstreamId,',',ompre.streamTableName,',',ompre.markingType,',',ompre.percentage,',',ompre.relationType) SEPARATOR '^') FROM organization_courses orgc
                LEFT JOIN orgcourse_mapping_prerequisites ompre ON ompre.orgCourseId=orgc.orgCourseId AND ompre.isactive=1
                          WHERE orgc.orgCourseId=$orgCourseId AND orgc.isactive=1 AND orgc.loginId=$orgId GROUP BY orgc.orgCourseId
                         ) as courseMinQuals,(SELECT GROUP_CONCAT(CONCAT(expDurationType,',',expDurationId,',',description) SEPARATOR '^')  FROM orgcourse_mapping_experience WHERE orgCourseId=$orgCourseId AND isactive=1 GROUP BY orgCourseId) experienceDetails");

        if ($qry->num_rows() > 0) {
            return json_encode($qry->result());
        } else {
            return josn_encode("");
        }
    }

    public function maddreqCourse() {
        $loginid = $_SESSION['loginId'];
        $courseType = FILTER_VAR(trim($this->input->post('course_type_id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim($this->input->post('course')), FILTER_SANITIZE_STRING);
        $timenow = $this->datetimenow();
        $chk = $this->checkCourse($title);
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if (empty($title)) {
                return '{"status":"error", "msg":"Blank values submitted"}';
            } else {
                $response = $this->db->where("courseType", $courseType);
            }if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Course Inserted by " . $_SESSION['orgName'], "course_type", "0");
                $datacd = ["loginid" => $loginid, "ctId" => $courseType, "title" => $title, "requestStatus" => 1, "createdAt" => $timenow, "isactive" => 1];
                $res = $this->db->insert("course_details", $datacd);
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Course Inserted by " . $_SESSION['orgName'] . "", "course_details", "0") : "");
                return ($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            }
        }
    }

    public function mgetStreams($courseId) {
        if (!empty($courseId)) {
            $condition = " isactive=1 AND cId=$courseId";
        } else {
            $condition = " isactive=1";
        }
        $sdata = $this->db->query("SELECT streamId,cId,title FROM stream_details WHERE $condition");
        return json_encode($sdata->result());
    }

    public function maddreqStream() {
        $course = FILTER_VAR(trim($this->input->post('course_id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim($this->input->post('stream')), FILTER_SANITIZE_STRING);
        $chk = $this->checkStream($title);
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if (empty($title)) {
                return '{"status":"error", "msg":"Blank values submitted"}';
            } else {
                $response = $this->db->where("course", $course);
            }if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Stream Inserted by " . $_SESSION['orgName'] . "", "course", "0");
                $datacd = ["loginid" => $_SESSION['loginId'], "cId" => $course, "title" => $title, "requestStatus" => 1, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->insert("stream_details", $datacd);

                ($res ? $this->addActivityLog($_SESSION['loginId'], "Stream  Inserted by " . $_SESSION['orgName'] . "", "course_details", "0") : "");
                return ($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            }
        }
    }

    private function checkStream($title) {
        $loginid = $_SESSION['loginId'];
        $chk = $this->db->query("Select * from stream_details where isactive=1 AND loginId=$loginid and title='" . $title . "'");
        if ($chk->num_rows() > 0) {
            return "duplicate";
        } else {
            return "fine";
        }
    }

    public function maddreqQuali() {
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $chk = $this->checkQuali($title);
        if ($chk == "duplicate") {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if (empty($title)) {
                return '{"status":"error", "msg":"Blank values submitted"}';
            } else {
                $this->addActivityLog($_SESSION['loginId'], "Min Qualification Inserted by " . $_SESSION['orgName'] . "", "title", "0");
                $datacd = ["loginid" => $_SESSION['loginId'], "title" => $title, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->insert("course_min_qualification", $datacd);
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Min Qualification  Inserted by " . $_SESSION['orgName'] . "", "course_min_qualification", "0") : "");
                return ($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            }
        }
    }

    public function checkQuali($title) {
        $loginid = $_SESSION['loginId'];
        $chk = $this->db->query("Select * from course_min_qualification where isactive=1 AND loginId=$loginid and title='" . $title . "'");
        if ($chk->num_rows() > 0) {
            return "duplicate";
        } else {
            return "fine";
        }
    }

    public function mAddCourseFeeType() {
        $newType = FILTER_VAR(trim(ucwords(strtolower($this->input->post('newFeeType')))), FILTER_SANITIZE_STRING);
        if (empty($newType) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $chk = $this->db->where(["FeeType_Name" => $newType, "isactive" => 1])->get("course_fee_type");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            $idata = ["FeeType_Name" => $newType, "createdBy" => $_SESSION['orgName'] . '_' . $_SESSION['loginId'],
                "createdAt" => $this->datetimenow(), "isactive" => 1];
            $response = $this->db->insert("course_fee_type", $idata);
            ($response ? $this->addActivityLog($_SESSION['loginId'], "Course Fee Type Inserted by " . $_SESSION['orgName'], "course_fee_type", "0") : "");
            return($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    //addCourse end
    //Stream Details start
    public function maddNewStreams($orgStreamId, $orgCourseIds, $streamId, $description) {
        $totalSheet = FILTER_VAR(trim($this->input->post('totalSheet')), FILTER_SANITIZE_STRING);
        $availableSheet = FILTER_VAR(trim($this->input->post('availableSheet')), FILTER_SANITIZE_STRING);
        $seoKeywords = FILTER_VAR(trim($this->input->post('seoKeywords')), FILTER_SANITIZE_STRING);
        $courseFeeType = FILTER_VAR(trim($this->input->post('courseFeeType')), FILTER_SANITIZE_STRING);
        $courseFee = FILTER_VAR(trim($this->input->post('courseFee')), FILTER_SANITIZE_NUMBER_INT);
        $registrationFee = FILTER_VAR(trim($this->input->post('registrationFee')), FILTER_SANITIZE_NUMBER_INT);
        $fromDate = FILTER_VAR(trim($this->input->post('fromDate')), FILTER_SANITIZE_STRING);
        $toDate = FILTER_VAR(trim($this->input->post('toDate')), FILTER_SANITIZE_STRING);
        $exporgCourseIds = explode("-", $orgCourseIds);
        $orgCourseId = $exporgCourseIds[0];
        if (!isset($_SESSION['loginId']) || empty($orgStreamId) || empty($orgCourseId) || empty($streamId) || empty($description) || empty($totalSheet) || empty($availableSheet) || empty($seoKeywords) || empty($courseFeeType) || empty($courseFee) || empty($registrationFee) || empty($fromDate) || empty($toDate)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $chkData = ($orgStreamId == "no_one" ? ["orgCourseId" => $orgCourseId, "streamId" => $streamId, "loginId" => $_SESSION['loginId'], "isactive" => 1] : ["orgStreamId!=" => $orgStreamId, "orgCourseId" => $orgCourseId, "streamId" => $streamId, "loginId" => $_SESSION['loginId'], "isactive" => 1]);
        $prev = $this->db->where($chkData)->get("organization_streams");
        if ($prev->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        }
        return $this->insertUpdateStreams($orgStreamId, $orgCourseId, $streamId, $_SESSION['loginId'], $description, $totalSheet, $seoKeywords, $availableSheet, $courseFeeType, $courseFee, $registrationFee, $fromDate, $toDate);
    }

    private function insertUpdateStreams($orgStreamId, $orgCourseId, $streamId, $loginId, $description, $totalSheet, $seoKeywords, $availableSheet, $courseFeeType, $courseFee, $registrationFee, $fromDate, $toDate) {
        $timenow = $this->datetimenow();
        $response = "";
        if ($orgStreamId == "no_one") {
            $iData = ["orgCourseId" => $orgCourseId, "streamId" => $streamId, "loginId" => $loginId, "description" => $description, "totalSheet" => $totalSheet, "seoKeywords" => $seoKeywords,
                "availableSheet" => $availableSheet, "courseFeeType" => $courseFeeType, "courseFee" => $courseFee, "registrationFee" => $registrationFee, "fromDate" => $fromDate, "toDate" => $toDate, "createdAt" => $timenow, "isactive" => 1];
            $response = $this->db->insert("organization_streams", $iData);
            $this->addActivityLog($_SESSION['loginId'], "Organization Stream Details Inserted by " . $_SESSION['orgName'] . "", "organization_streams", "0");
        } else {
            $uData = ["orgCourseId" => $orgCourseId, "streamId" => $streamId, "loginId" => $loginId, "description" => $description, "totalSheet" => $totalSheet, "seoKeywords" => $seoKeywords, "availableSheet" => $availableSheet,
                "courseFeeType" => $courseFeeType, "courseFee" => $courseFee, "registrationFee" => $registrationFee, "fromDate" => $fromDate, "toDate" => $toDate, "updatedAt" => $timenow];

            $response = $this->db->where(["orgStreamId" => $orgStreamId, "loginId" => $loginId, "isactive" => 1])->update("organization_streams", $uData);
            $this->addActivityLog($_SESSION['loginId'], "Organization course Stream Details Updated by " . $_SESSION['orgName'] . "", "organization_streams", "0");
        }
        if ($response) {
            return '{"status":"success", "msg":"Save Successful"}';
        } else {
            return '{"status":"error", "msg":"Error in server, please contact admin!"}';
        }
    }

    public function mViewStreams() {
        $loginId = $_SESSION['loginId'];
        $orgStreamId = FILTER_VAR(trim($this->input->post('orgStreamId')), FILTER_SANITIZE_STRING);
        $condition = ($orgStreamId != "" ? " and os.orgStreamId=$orgStreamId" : "");
        $response = $this->db->query("SELECT os.orgStreamId,oc.courseId,os.description,os.seoKeywords,os.totalSheet,os.availableSheet,ct.courseType,
                                        cd.title as course,td.title as timeduration,sd.title as stream,oc.orgCourseId,os.streamId,os.courseFeeType,os.courseFee
                                        ,os.registrationFee,os.fromDate,os.toDate,CONCAT('Course Fee: ',os.courseFee,' Registartion Fee: ',os.registrationFee,
                                        '<br>Fee Submit From: ',DATE_FORMAT(os.fromDate,'%d-%b-%Y'),'Fee Submit To: ',DATE_FORMAT(os.toDate,'%d-%b-%Y')) feeDetails FROM organization_streams as os
                                        INNER JOIN organization_courses as oc ON oc.orgCourseId=os.orgCourseId
                                        INNER JOIN course_type as ct ON ct.ctId=oc.courseTypeId
                                        INNER JOIN course_details as cd ON cd.cId=oc.courseId
                                        INNER JOIN time_duration as td ON td.tdId=oc.courseDurationId
                                        INNER JOIN stream_details as sd ON sd.streamId=os.streamId  WHERE os.isactive=1 and os.loginId=$loginId $condition");
        if ($response->num_rows() > 0) {
            $result = $response->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mDelStreams() {
        $loginId = $_SESSION['loginId'];
        $orgStreamId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (empty($loginId) || empty($orgStreamId)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $data = ["orgStreamId" => $orgStreamId, "loginId" => $loginId, "isactive" => 1];
            $find = $this->db->where($data)->get("organization_streams");
            if ($find->num_rows() > 0) {
                $ddata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
                $resp = $this->db->where($data)->update("organization_streams", $ddata);
                $resp ? $this->addActivityLog($_SESSION['loginId'], "Organization Stream Details Deleted by " . $_SESSION['orgName'] . "", "organization_streams", "0") : '';
                return ($resp ? '{"status":"success", "msg":"Deletion Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Error record not found!"}';
            }
        }
    }

    //Stream Details end
    //Brochure starts
    public function mbrochuresTable() {
        $broucherIds = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        $broucherId = base64_decode($broucherIds);
        if (!isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $condition = (!empty($broucherId) ? "AND isactive=1 AND broucherId=$broucherId" : "AND isactive=1");

        $sdata = $this->db->query("SELECT * FROM brouchers WHERE loginId=" . $_SESSION['loginId'] . " $condition");
        if ($sdata->num_rows() > 0) {
            foreach ($sdata->result() as $bd) {
                $bd->broucherId = base64_encode($bd->broucherId);
            }
            $response = $sdata->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function maddBrochures() {
        $broucherIds = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $broucherId = base64_decode($broucherIds);
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $image = (isset($_FILES['image']['name']) ? preg_replace("/\s+/", "_", $_FILES['image']['name']) : "");
        if (empty($title) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $dData = ($broucherIds === "no_one" ? ["title" => $title, "loginId" => $_SESSION['loginId'], "isactive" => 1] : ["broucherId!=" => $broucherId, "title" => $title, "loginId" => $_SESSION['loginId'], "isactive" => 1]);
            $chkDuplicate = $this->db->where($dData)->get("brouchers");
            if ($chkDuplicate->num_rows() > 0) {
                return '{"status":"error", "msg":"Duplicate entry!"}';
            } else {
                $imgPath = './projectimages/images/brouchers/' . date('Y') . '/' . date('m');
                $this->createDirectory($imgPath);
                $response = (!empty($image) ? $this->uploadImage($imgPath, $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image, 'image') : 'error');
                $resp = $this->addNewBrouchers($response, $_SESSION['loginId'], $this->datetimenow(), $broucherIds, $title);
                return ($resp ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            }
        }
    }

    private function addNewBrouchers($response, $loginId, $timenow, $broucherIds, $title) {
        $broucherId = base64_decode($broucherIds);
        if ($response != "error") {
            $imgPath = 'projectimages/images/brouchers/' . date('Y') . '/' . date('m') . '/' . $response;
            $prevData = $this->db->where(["loginId" => $loginId, "broucherId" => $broucherId, "isactive" => 1])->get("brouchers");
            $imgarr = ["image" => $imgPath];
            if ($prevData->num_rows() > 0) {
                $previmage = $prevData->row()->image;
                ($previmage != "" ? $this->removeImage($previmage, 'projectimages/images/brouchers/image/') : "");
            }
        } else {
            $imgPath = "";
            $imgarr = [];
        }
        $iDatas = ($broucherIds === "no_one" ? ["loginId" => $loginId, "title" => $title, "createdAt" => $timenow, "isactive" => 1] : ["loginId" => $loginId, "title" => $title, "updatedAt" => $timenow, "isactive" => 1]);
        ($broucherIds === "no_one" ? $this->addActivityLog($_SESSION['loginId'], "Brochure Inserted by " . $_SESSION['orgName'], "brouchers", "0") : $this->addActivityLog($_SESSION['loginId'], "Brochure Updated by " . $_SESSION['orgName'], "brouchers", "0"));
        return ($broucherIds === "no_one" ? $this->db->insert("brouchers", array_merge($iDatas, $imgarr)) : $this->db->where(["broucherId" => $broucherId, "loginId" => $loginId])->update("brouchers", array_merge($iDatas, $imgarr)));
    }

    public function mdelBrochures() {
        $broucherIds = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);

        $broucherId = base64_decode($broucherIds);
        if (empty($broucherId) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $chData = ["loginId" => $_SESSION['loginId'], "broucherId" => $broucherId, "isactive" => 1];
            $gData = $this->db->where($chData)->get("brouchers");
            if ($gData) {
                $delData = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
                $res = $this->db->where($chData)->update("brouchers", $delData);
                $this->addActivityLog($_SESSION['loginId'], "Brochure Details Deleted by " . $_SESSION['orgName'] . "", "brouchers", "0");
                return ($res != "" ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"No such entry in databse!"}';
            }
        }
    }

    //Brochure ends
    //Gallery Start
    public function mGetGalleryData() {
        $loginId = $_SESSION['loginId'];
        $this->db->where(["loginId" => $loginId, "isactive" => 1]);
        return $this->db->get('gallery');
    }

    public function mdeleteGalleryImage() {
        $loginId = $_SESSION['loginId'];
        $galleryId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        if (empty($galleryId) || empty($loginId)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $gData = ["galleryId" => $galleryId, "loginId" => $loginId, "isactive" => 1];
            $ffile = $this->db->where($gData)->get("gallery");
            if ($ffile->num_rows() > 0) {
                $data = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
                $res = $this->db->where($gData)->update("gallery", $data);
            }
            if ($res) {
                $this->addActivityLog($_SESSION['loginId'], "Gallery Image updated by " . $_SESSION['orgName'] . "", "gallery", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function maddNewGalleryImage() {
        $image = (isset($_FILES['galaryUrl']['name']) ? preg_replace("/\s+/", "_", $_FILES['galaryUrl']['name']) : "");

        if (!isset($_SESSION['loginId']) || empty($image)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $path = './projectimages/images/gallery/image';
            $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
            $response = $this->uploadImage($path, $imgName, 'galaryUrl');
            if ($response != "error") {
                $imgPath = 'projectimages/images/gallery/image/' . $response;
                $iData = ["loginId" => $_SESSION['loginId'], "galaryUrl" => $imgPath, "imgPath" => $imgPath, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->insert("gallery", $iData);
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Gallery Image Inserted by " . $_SESSION['orgName'] . "", "gallery", "0") : "");
                return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Error in image uploading!"}';
            }
        }
    }

    //Gallery End
    //Event Start
    public function maddEvent() {
        $loginId = $_SESSION['loginId'];
        $image = (isset($_FILES['eventImage']['name']) ? preg_replace("/\s+/", "_", $_FILES['eventImage']['name']) : "");
        $eventId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $eventTitle = FILTER_VAR(trim($this->input->post('eventTitle')), FILTER_SANITIZE_STRING);
        $description = FILTER_VAR(trim($this->input->post('description')), FILTER_SANITIZE_STRING);
        $address = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);
        if (empty($eventTitle) || empty($description)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            if ($eventId === "no_one") {
                return $this->addNewEvent($loginId, $eventTitle, $description, $address, $image, 'eventImage');
            } else {
                return $this->upDateEvent(base64_decode($eventId), $loginId, $eventTitle, $description, $address, $image, 'eventImage');
            }
        }
    }

    private function addNewEvent($loginId, $eventTitle, $description, $address, $image, $imgname) {
        $dData = ["loginId" => $loginId, "eventTitle" => $eventTitle, "description" => $description];

        $chkDuplicate = $this->db->where($dData)->get("event_details");
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/eventImage/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "eventImage" => $response, "eventTitle" => $eventTitle, "description" => $description,
                "location" => $address, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("event_details", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Event Details Inserted by " . $_SESSION['orgName'] . "", "event_details", "0") : '');
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    private function upDateEvent($eventId, $loginId, $eventTitle, $description, $address, $image, $imgname) {
        $dData = ["eventId!=" => $eventId, "loginId" => $loginId, "eventTitle" => $eventTitle, "description" => $description];
        $chkDuplicate = $this->db->where($dData)->get("event_details");
        $previmg = $this->input->post('prevImage');
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/eventImage/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
                ($previmg != "no_image" && $previmg != "" ? $this->removeImage('projectimages/images/eventImage/image/' . $previmg, 'projectimages/images/eventImage/image/') : "");
            } else {
                $response = $previmg;
            }
            $iData = ["loginId" => $loginId, "eventImage" => $response, "eventTitle" => $eventTitle, "description" => $description, "location" => $address, "updatedAt" => $this->datetimenow(), "isactive" => 1];

            $res = $this->db->where(["eventId=" => $eventId, "loginId" => $loginId])->update("event_details", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Event Details Updated by " . $_SESSION['orgName'] . "", "event_details", "0") : "");
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mgetEvents() {
        $loginId = $_SESSION['loginId'];
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($ed) && !empty($loginId)) {
            $eventId = base64_decode($ed);
            $condition = "AND loginId=$loginId AND eventId=$eventId AND isactive=1";
        } else {
            $condition = "AND loginId=$loginId  AND isactive=1";
        }
        $response = $this->db->query("SELECT * FROM event_details WHERE isactive=1 $condition");
        if ($response->num_rows() > 0) {
            foreach ($response->result() as $res) {
                $res->eventId = base64_encode($res->eventId);
            }
            return json_encode($response->result());
        } else {
            return "";
        }
    }

    public function mdelEvent() {
        $loginId = $_SESSION['loginId'];
        $eventId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $this->db->where(["loginId" => $loginId, "eventId" => base64_decode($eventId), "isactive" => 1]);
        $response = $this->db->get("event_details");
        if ($response) {
            $this->db->where(["loginId" => $loginId, "eventId" => base64_decode($eventId), "isactive" => 1]);
            $resp = $this->db->update("event_details", ["updatedAt" => $this->datetimenow(), "isactive" => 0]);
            if ($resp) {
                $this->addActivityLog($_SESSION['loginId'], "Event Details Deleted by " . $_SESSION['orgName'] . "", "event_details", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Record not in database."}';
        }
    }

    //Event End
    //News Start
    public function mgetNews() {
        $loginId = $_SESSION['loginId'];
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        $condition = (empty($ed) ? ["loginId" => $loginId, "isactive" => 1] : ["loginId" => $loginId, "newsId" => base64_decode($ed), "isactive" => 1]);
        $response = $this->db->where($condition)->get("news");
        foreach ($response->result() as $res) {
            $res->newsId = base64_encode($res->newsId);
        }
        return json_encode($response->result());
    }

    public function maddNews() {
        $image = (isset($_FILES['newsImage']['name']) ? preg_replace("/\s+/", "_", $_FILES['newsImage']['name']) : "");
        $publishDate = FILTER_VAR(trim($this->input->post('publishDate')), FILTER_SANITIZE_STRING);
        $newsId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $description = $this->input->post('description');
        if (empty($title) || empty($description)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            if ($newsId === "no_one") {
                return $this->addNewsItem($_SESSION['loginId'], $title, $description, $image, $publishDate, 'newsImage');
            } else {
                return $this->upDateNews(base64_decode($newsId), $_SESSION['loginId'], $title, $description, $image, $publishDate, 'newsImage');
            }
        }
    }

    private function addNewsItem($loginId, $title, $description, $image, $publishDate, $imgname) {
        $dData = ["loginId" => $loginId, "title" => $title, "description" => $description];
        $chkDuplicate = $this->db->where($dData)->get("news");
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/news/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "newsImage" => $response, "title" => $title, "description" => $description,
                "publishDate" => $publishDate, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("news", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "News Inserted by " . $_SESSION['orgName'] . "", "news", "0") : "");
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    private function upDateNews($newsId, $loginId, $title, $description, $image, $publishDate, $imgname) {
        $dData = ["newsId!=" => $newsId, "loginId" => $loginId, "title" => $title, "description" => $description];
        $chkDuplicate = $this->db->where($dData)->get("news");
        $previmg = $this->input->post('previmage');
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/news/image';
                $response = $this->uploadImage($path, $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image, $imgname);
                ($previmg != "no_image" && $previmg != "" ? $this->removeImage('projectimages/images/news/image/' . $previmg, 'projectimages/images/news/image/') : "");
            } else {
                $response = $previmg;
            }
            $iData = ["loginId" => $loginId, "newsImage" => $response, "title" => $title, "description" => $description, "publishDate" => $publishDate, "updatedAt" => $this->datetimenow()];
            $res = $this->db->where(["newsId=" => $newsId, "loginId" => $loginId])->update("news", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "News Updated by " . $_SESSION['orgName'] . "", "news", "0") : "");
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mdelNews() {
        $loginId = $_SESSION['loginId'];
        $newsId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $this->db->where(["loginId" => $loginId, "newsId" => base64_decode($newsId), "isactive" => 1]);
        $response = $this->db->get("news");
        if ($response) {
            $this->db->where(["loginId" => $loginId, "newsId" => base64_decode($newsId), "isactive" => 1]);
            $resp = $this->db->update("news", ["updatedAt" => $this->datetimenow(), "isactive" => 0]);
            if ($resp) {
                $this->addActivityLog($_SESSION['loginId'], "News Deleted by " . $_SESSION['orgName'] . "", "news", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        }
    }

    //News End
    //placement start
    public function mgetPlacement() {
        $loginId = $_SESSION['loginId'];
        $placementId = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($placementId)) {
            $getData = ["loginId" => $loginId, "placementId" => base64_decode($placementId), "isactive" => 1];
            $response = $this->db->where($getData)->get("placement");
        } else {
            $getData = ["loginId" => $loginId, "isactive" => 1];
            $response = $this->db->where($getData)->get("placement");
        }
        foreach ($response->result() as $res) {
            $res->placementId = base64_encode($res->placementId);
        }
        return json_encode($response->result());
    }

    public function maddPlacement() {
        $loginId = $_SESSION['loginId'];
        $image = (isset($_FILES['companyImage']['name']) ? preg_replace("/\s+/", "_", $_FILES['companyImage']['name']) : "");

        $placementId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $highestAmount = FILTER_VAR(trim($this->input->post('highestAmount')), FILTER_SANITIZE_STRING);
        $lowestAmount = FILTER_VAR(trim($this->input->post('lowestAmount')), FILTER_SANITIZE_STRING);
        $averageAmount = FILTER_VAR(trim($this->input->post('averageAmount')), FILTER_SANITIZE_STRING);
        $companyName = FILTER_VAR(trim($this->input->post('companyName')), FILTER_SANITIZE_STRING);
        $currency = FILTER_VAR(trim($this->input->post('Currency')), FILTER_SANITIZE_STRING);
        if (empty($companyName) || empty($highestAmount) || empty($averageAmount) || empty($lowestAmount) || empty($currency)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            if ($placementId === "no_one") {
                return $this->addPlacement($loginId, $highestAmount, $lowestAmount, $averageAmount, $companyName, $image, 'companyImage', $currency);
            } else {
                return $this->upDatePlacement(base64_decode($placementId), $loginId, $highestAmount, $lowestAmount, $averageAmount, $companyName, $image, 'companyImage', $currency);
            }
        }
    }

    private function addPlacement($loginId, $highestAmount, $lowestAmount, $averageAmount, $companyName, $image, $imgname, $currency) {
        $dData = ["loginId" => $loginId, "highestAmount" => $highestAmount, "lowestAmount" => $lowestAmount, "averageAmount" => $averageAmount, "companyName" => $companyName];
        $chkDuplicate = $this->db->where($dData)->get("placement");
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/placementCompany/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "companyImage" => $response, "highestAmount" => $highestAmount, "lowestAmount" => $lowestAmount,
                "averageAmount" => $averageAmount, "companyName" => $companyName, "currency" => $currency, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("placement", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Placement Inserted by " . $_SESSION['orgName'] . "", "placement", "0") : '');
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    private function upDatePlacement($placementId, $loginId, $highestAmount, $lowestAmount, $averageAmount, $companyName, $image, $imgname, $currency) {
        $dData = ["placementId!=" => $placementId, "loginId" => $loginId, "highestAmount" => $highestAmount, "lowestAmount" => $lowestAmount,
            "averageAmount" => $averageAmount, "companyName" => $companyName, "isactive" => 1];

        $chkDuplicate = $this->db->where($dData)->get("placement");
        $previmg = $this->input->post('previmage');
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/placementCompany/image';
                $response = $this->uploadImage($path, $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image, $imgname);
                ($previmg != "no_image" && $previmg != "" ? $this->removeImage('projectimages/images/placementCompany/image/' . $previmg, 'projectimages/images/placementCompany/image/') : "");
            } else {
                $response = $previmg;
            }
            $iData = ["loginId" => $loginId, "companyImage" => $response, "highestAmount" => $highestAmount, "lowestAmount" => $lowestAmount,
                "averageAmount" => $averageAmount, "companyName" => $companyName, "currency" => $currency, "updatedAt" => $this->datetimenow()];

            $res = $this->db->where(["placementId=" => $placementId, "isactive" => 1, "loginId" => $loginId])->update("placement", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Placement Updated by " . $_SESSION['orgName'] . "", "placement", "0") : "");
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mdelPlacement() {
        $loginId = $_SESSION['loginId'];
        $placementId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $this->db->where(["loginId" => $loginId, "placementId" => base64_decode($placementId), "isactive" => 1]);
        $response = $this->db->get("placement");
        if ($response->num_rows() > 0) {
            $this->db->where(["loginId" => $loginId, "placementId" => base64_decode($placementId), "isactive" => 1]);
            $resp = $this->db->update("placement", ["updatedAt" => $this->datetimenow(), "isactive" => 0]);
            if ($resp) {
                $this->addActivityLog($_SESSION['loginId'], "Placement Deleted by " . $_SESSION['orgName'] . "", "placement", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function mAddPlacedStudent() {
        $placedstudentId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $studentName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('studentName')))), FILTER_SANITIZE_STRING);
        $companyName = FILTER_VAR(trim($this->input->post('companyName')), FILTER_SANITIZE_STRING);
        $placementDate = FILTER_VAR(trim($this->input->post('placementDate')), FILTER_SANITIZE_STRING);
        $package = FILTER_VAR(trim($this->input->post('package')), FILTER_SANITIZE_STRING);
        $courseId = FILTER_VAR(trim($this->input->post('courseId')), FILTER_SANITIZE_STRING);
        $currency = FILTER_VAR(trim($this->input->post('currency')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId']) || empty($studentName) || empty($companyName) || empty($placementDate) || empty($package) || empty($courseId) || empty($currency)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $condition = ($placedstudentId == "no_one" ? ["studentName" => $studentName, "companyName" => $companyName, "package" => $package, "courseId" => $courseId, "loginId" => $_SESSION['loginId'], "isactive" => 1] :
                ["placedstudentId!=" => base64_decode($placedstudentId), "studentName" => $studentName, "companyName" => $companyName, "package" => $package, "courseId" => $courseId, "loginId" => $_SESSION['loginId'], "isactive" => 1]);
        $check = $this->db->where($condition)->get("tbl_placedstudents");
        if ($check->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            return $this->insertUpdatePlacedStudents($placedstudentId, $studentName, $companyName, $placementDate, $package, $courseId, $currency);
        }
    }

    private function insertUpdatePlacedStudents($placedstudentId, $studentName, $companyName, $placementDate, $package, $courseId, $currency) {
        $image = $this->uploadPlaceStudentImage($studentName);
        if ($image == 'error') {
            return '{"status":"error", "msg":"Image Upload error!"}';
        }
        if ($placedstudentId == "no_one") {
            $idata = ["studentName" => $studentName, "image" => $image, "companyName" => $companyName, "package" => $package, "placementDate" => $placementDate,
                "currency" => $currency, "courseId" => $courseId, "loginId" => $_SESSION['loginId'], "createdAt" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->insert("tbl_placedstudents", $idata);
        } else {
            $udata = ["studentName" => $studentName, "image" => $image, "companyName" => $companyName, "package" => $package, "placementDate" => $placementDate,
                "currency" => $currency, "courseId" => $courseId, "loginId" => $_SESSION['loginId'], "updatedAt" => $this->datetimenow()];
            $resp = $this->db->where(["loginId" => $_SESSION['loginId'], "placedstudentId" => base64_decode($placedstudentId), "isactive" => 1])->update("tbl_placedstudents", $udata);
        }
        ($resp ? $this->addActivityLog($_SESSION['loginId'], "Placed Student $studentName Details added by " . $_SESSION['orgName'] . "", "tbl_placedstudents", "0") : '');
        return ($resp ? '{"status":"success", "msg":"Saved Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
    }

    private function uploadPlaceStudentImage($studentName) {
        $previmage = FILTER_VAR(trim($this->input->post('previmage')), FILTER_SANITIZE_STRING);
        if (isset($_FILES['image']['name'])) {
            $path = './projectimages/images/placedStudents/' . date('Y') . '/' . date('m');
            $this->createDirectory($path);
            $imgName = $_SESSION['orgName'] . '_' . $studentName . strtotime(date('Y-m-d h:i:s'));
            $response = $this->uploadImage($path, $imgName, 'image');
            if ($response == "error") {
                // return '{"status":"error", "msg":"Image upload error!"}';
                return 'error';
            }
            if ($previmage != "" && file_exists($previmage)) {
                unlink($previmage);
            }
            $response = 'projectimages/images/placedStudents/' . date('Y') . '/' . date('m') . '/' . $response;
        } else {
            $response = $previmage;
        }
        return $response;
    }

    public function mPlacedStudentRecords() {
        if (!isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Session expired!"}';
        }
        $placedstudentId = FILTER_VAR(trim($this->input->post('placedstudentId')), FILTER_SANITIZE_STRING);
        $condition = ($placedstudentId ? " AND placedstudentId=" . base64_decode($placedstudentId) : "");
        $qry = $this->db->query("SELECT tp.*,CONCAT('Placed On:',DATE_FORMAT(tp.placementDate,'%d-%b-%Y'),' Package: ',tp.package,' (',cr.code,'(',cr.name,'))') placementDetails
                FROM tbl_placedstudents tp LEFT JOIN currencies cr ON cr.code=tp.currency
                WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1 $condition ORDER BY tp.placedstudentId DESC");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $qr) {
                $qr->placedstudentId = base64_encode($qr->placedstudentId);
            }
            $result = $qry->result();
        } else {
            $result = '';
        }
        return json_encode($result);
    }

    public function mDelPlacedStudent() {
        $placedstudentId = FILTER_VAR(trim($this->input->post('placedstudentId')), FILTER_SANITIZE_STRING);
        if (empty($placedstudentId) && !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Unauthorised access!"}';
        }
        $chk = $this->db->where(["placedstudentId" => base64_decode($placedstudentId), "loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_placedstudents");
        if ($chk->num_rows() > 0) {
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where(["placedstudentId" => base64_decode($placedstudentId), "loginId" => $_SESSION['loginId'], "isactive" => 1])->update("tbl_placedstudents", $udata);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Placed Student Details deleted by " . $_SESSION['orgName'] . "", "tbl_placedstudents", "0") : '');
            return ($resp ? '{"status":"success", "msg":"Deleted Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Record not found!"}';
        }
    }

    //placement End
    //Achievment Start

    public function maddAchievement() {
        $loginId = $_SESSION['loginId'];
        if (isset($_FILES['image']['name'])) {
            $image = preg_replace("/\s+/", "_", $_FILES['image']['name']);
        } else {
            $image = "";
        }
        $achiveId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $awards = FILTER_VAR(trim($this->input->post('awards')), FILTER_SANITIZE_STRING);
        $description = FILTER_VAR(trim($this->input->post('description')), FILTER_SANITIZE_STRING);
        if (empty($awards)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            if ($achiveId === "no_one") {
                return $this->addAchievement($loginId, $awards, $description, $image, 'image');
            } else {
                return $this->upDateAchievement(base64_decode($achiveId), $loginId, $awards, $description, $image, 'image');
            }
        }
    }

    private function addAchievement($loginId, $awards, $description, $image, $imgname) {
        $dData = ["loginId" => $loginId, "awards" => $awards, "description" => $description];
        $chkDuplicate = $this->db->where($dData)->get("achievement");
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/achievement/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "awards" => $awards, "description" => $description,
                "image" => $response, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("achievement", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Achievement Inserted by " . $_SESSION['orgName'] . "", "achievement", "0") : '');
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    private function upDateAchievement($achiveId, $loginId, $awards, $description, $image, $imgname) {
        $dData = ["achiveId!=" => $achiveId, "loginId" => $loginId, "awards" => $awards, "description" => $description, "isactive" => 1];
        $chkDuplicate = $this->db->where($dData)->get("achievement");
        $previmg = $this->input->post('previmage');
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/achievement/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
                ($previmg != "no_image" && $previmg != "" ? $this->removeImage('projectimages/images/achievement/image/' . $previmg, 'projectimages/images/achievement/image/') : '');
            } else {
                $response = $previmg;
            }
            $iData = ["awards" => $awards, "image" => $response, "description" => $description, "updatedAt" => $this->datetimenow()];
            $this->db->where(["achiveId=" => $achiveId, "isactive" => 1, "loginId" => $loginId]);
            $res = $this->db->update("achievement", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Achievement Updated by " . $_SESSION['orgName'] . "", "achievement", "0") : '');
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mgetAchievement() {
        $loginId = $_SESSION['loginId'];
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        $condition = (empty($ed) ? ["loginId" => $loginId, "isactive" => 1] : ["loginId" => $loginId, "achiveId" => base64_decode($ed), "isactive" => 1]);
        $response = $this->db->where($condition)->get("achievement");
        if ($response->num_rows() > 0) {
            foreach ($response->result() as $res) {
                $res->achiveId = base64_encode($res->achiveId);
            }
            return json_encode($response->result());
        } else {
            return '';
        }
    }

    public function mdelAchievement() {
        $loginId = $_SESSION['loginId'];
        $achiveId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $this->db->where(["loginId" => $loginId, "achiveId" => base64_decode($achiveId), "isactive" => 1]);
        $response = $this->db->get("achievement");
        if ($response->num_rows() > 0) {
            $this->db->where(["loginId" => $loginId, "achiveId" => base64_decode($achiveId), "isactive" => 1]);
            $resp = $this->db->update("achievement", ["updatedAt" => $this->datetimenow(), "isactive" => 0]);
            if ($resp) {
                $this->addActivityLog($_SESSION['loginId'], "Achievement Deleted by " . $_SESSION['orgName'] . "", "achievement", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Details not found!"}';
        }
    }

    //Achievment End
    //Faculty Start
    public function maddFaculty() {
        $image = (isset($_FILES['facultyImage']['name']) ? preg_replace("/\s+/", "_", $_FILES['facultyImage']['name']) : '');
        $facultyId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $departmentId = FILTER_VAR(trim($this->input->post('departmentId')), FILTER_SANITIZE_STRING);
        $name = FILTER_VAR(trim($this->input->post('name')), FILTER_SANITIZE_STRING);
        $mobile = FILTER_VAR(trim($this->input->post('mobile')), FILTER_SANITIZE_STRING);
        $gender = FILTER_VAR(trim($this->input->post('gender')), FILTER_SANITIZE_STRING);
        $email = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_EMAIL);
        $qualification = FILTER_VAR(trim($this->input->post('qualification')), FILTER_SANITIZE_STRING);
        $post = FILTER_VAR(trim($this->input->post('post')), FILTER_SANITIZE_STRING);
        $address = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);
        if (empty($departmentId) || empty($name) || empty($gender) || empty($email) || empty($qualification) || empty($post)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            if ($facultyId === "no_one") {
                return $this->addFaculty($_SESSION['loginId'], base64_decode($departmentId), $name, $gender, $mobile, $email, $post, $address, $qualification, $image, 'facultyImage');
            } else {
                return $this->upDateFaculty(base64_decode($facultyId), $_SESSION['loginId'], base64_decode($departmentId), $name, $gender, $mobile, $email, $post, $address, $qualification, $image, 'facultyImage');
            }
        }
    }

    private function addFaculty($loginId, $departmentId, $name, $gender, $mobile, $email, $post, $address, $qualification, $image, $imgname) {
        $dData = ["loginId" => $loginId, "departmentId" => $departmentId, "name" => $name, "gender" => $gender, "mobile" => $mobile, "email" => $email, "isactive" => 1];
        $chkDuplicate = $this->db->where($dData)->get("faculty_details");
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/facultyImage/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "departmentId" => $departmentId, "name" => $name, "gender" => $gender, "mobile" => $mobile, "email" => $email, "address" => $address,
                "facultyImage" => $response, "qualification" => $qualification, "post" => $post, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("faculty_details", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Faculty Details Inserted by " . $_SESSION['orgName'] . "", "faculty_details", "0") : '');
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    private function upDateFaculty($facultyId, $loginId, $departmentId, $name, $gender, $mobile, $email, $post, $address, $qualification, $image, $imgname) {
        $dData = ["facultyId!=" => $facultyId, "loginId" => $loginId, "departmentId" => $departmentId, "name" => $name, "gender" => $gender, "mobile" => $mobile, "email" => $email, "isactive" => 1];
        $chkDuplicate = $this->db->where($dData)->get("faculty_details");
        $previmg = $this->input->post('previmage');
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/facultyImage/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
                ($previmg != "no_image" && $previmg != "" ? $this->removeImage('projectimages/images/facultyImage/image/' . $previmg, 'projectimages/images/facultyImage/image/') : "");
            } else {
                $response = $previmg;
            }
            $iData = ["departmentId" => $departmentId, "name" => $name, "gender" => $gender, "mobile" => $mobile, "email" => $email, "address" => $address,
                "facultyImage" => $response, "qualification" => $qualification, "post" => $post, "updatedAt" => $this->datetimenow()];
            $res = $this->db->where(["facultyId=" => $facultyId, "isactive" => 1, "loginId" => $loginId])->update("faculty_details", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Faculty Details Updated by " . $_SESSION['orgName'] . "", "faculty_details", "0") : '');
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mgetFaculty() {
        $loginId = $_SESSION['loginId'];
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($ed) && !empty($loginId)) {
            $getData = ["faculty_details.loginId" => $loginId, "faculty_details.facultyId" => base64_decode($ed), "faculty_details.isactive" => 1];

            $response = $this->db->select('*')->from('faculty_details')->join('department', 'department.departmentId=faculty_details.departmentId AND department.isactive=1 AND department.loginId=' . $loginId . '')->where($getData)->get();
        } else {
            $getData = ["faculty_details.loginId" => $loginId, "faculty_details.isactive" => 1];
            $response = $this->db->select('*')->from('faculty_details')->where($getData)->join('department', 'department.departmentId=faculty_details.departmentId AND department.isactive=1 AND department.loginId=' . $loginId . '', 'inner')->get();
        }
        if ($response->num_rows() > 0) {
            foreach ($response->result() as $res) {
                $res->facultyId = base64_encode($res->facultyId);
                $res->departmentId = base64_encode($res->departmentId);
            }
            return json_encode($response->result());
        } else {
            return "";
        }
    }

    public function mdelFaculty() {
        $loginId = $_SESSION['loginId'];
        $facultyId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $this->db->where(["loginId" => $loginId, "facultyId" => base64_decode($facultyId), "isactive" => 1]);
        $response = $this->db->get("faculty_details");
        if ($response->num_rows() > 0) {
            $this->db->where(["loginId" => $loginId, "facultyId" => base64_decode($facultyId), "isactive" => 1]);
            $resp = $this->db->update("faculty_details", ["updatedAt" => $this->datetimenow(), "isactive" => 0]);
            if ($resp) {
                $this->addActivityLog($_SESSION['loginId'], "Faculty Details Deleted by " . $_SESSION['orgName'] . "", "faculty_details", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Record not found"}';
        }
    }

    //Faculty End
    //Advertisement
    public function mGetdetailsofPlan() {
        $id = FILTER_VAR(trim($this->input->post('planId')), FILTER_SANITIZE_STRING);
        $location = FILTER_VAR(trim($this->input->post('location')), FILTER_SANITIZE_STRING);
        $img_loc = FILTER_VAR(trim($this->input->post('img_loc')), FILTER_SANITIZE_STRING);
        if (!empty($id)) {
            $qry = $this->db->query("SELECT * FROM advertisement_plan WHERE isactive=1 AND planId='" . $id . "'");
        } elseif (!empty($location)) {
            $qry = $this->db->query("SELECT DISTINCT img_loc FROM advertisement_plan WHERE isactive=1");
        } elseif (!empty($img_loc)) {
            $qry = $this->db->query("SELECT * FROM advertisement_plan WHERE isactive=1 AND img_loc='" . $img_loc . "'");
        } else {
            $qry = $this->db->query("SELECT * FROM advertisement_plan WHERE isactive=1");
        }
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function maddAdvertisement() {
        $loginId = $_SESSION['loginId'];
        if (isset($_FILES['adsBanner']['name'])) {
            $image = preg_replace("/\s+/", "_", $_FILES['adsBanner']['name']);
        } else {
            $image = "";
        }
        $adsId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $adsTitle = FILTER_VAR(trim($this->input->post('adsTitle')), FILTER_SANITIZE_STRING);
        $url = FILTER_VAR(trim($this->input->post('url')), FILTER_SANITIZE_URL);
        $planId = FILTER_VAR(trim($this->input->post('plan_name')), FILTER_SANITIZE_STRING);
        $startDate = FILTER_VAR(trim($this->input->post('startDate')), FILTER_SANITIZE_STRING);
        if (empty($adsTitle) || empty($planId)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            if ($adsId === "no_one") {
                return $this->addAdvertisement($loginId, $adsTitle, $url, $planId, $image, 'adsBanner', $startDate);
            } else {
                return $this->upDateAdvertisement(base64_decode($adsId), $loginId, $adsTitle, $url, $planId, $image, 'adsBanner');
            }
        }
    }

    private function addAdvertisement($loginId, $adsTitle, $url, $planId, $image, $imgname, $startDates) {
        $startDate = ($startDates != "" ? strtotime($startDates) >= strtotime(date('Y-m-d')) ? $startDates : date('Y-m-d') : "");
        $dData = ["loginId" => $loginId, "adsTitle" => $adsTitle, "url" => $url, "planId " => $planId, "isactive" => 1];

        $chkDuplicate = $this->db->where($dData)->get("advertisement");
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/adsBanner/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "adsTitle" => $adsTitle, "url" => $url, "planId" => $planId, "ad_start_date" => $startDate,
                "adsBanner" => $response, "adsDate" => date('Y-m-d'), "createdAt" => $this->datetimenow(), "isactive" => 1, "apprv_by_admin" => 1];
            $res = $this->db->insert("advertisement", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Advertisement Inserted by " . $_SESSION['orgName'] . "", "advertisement", "0") : '');
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    private function upDateAdvertisement($adsId, $loginId, $adsTitle, $url, $planId, $image, $imgname) {
        $dData = ["adsId!=" => $adsId, "loginId" => $loginId, "adsTitle" => $adsTitle, "url" => $url, "planId " => $planId, "isactive" => 1];

        $chkDuplicate = $this->db->where($dData)->get("advertisement");
        $previmg = $this->input->post('previmage');
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/adsBanner/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
                ($previmg != "no_image" && $previmg != "" ? $this->removeImage('projectimages/images/adsBanner/image/' . $previmg, 'projectimages/images/adsBanner/image/') : '');
            } else {
                $response = $previmg;
            }
            $iData = ["adsTitle" => $adsTitle, "url" => $url, "planId" => $planId,
                "adsBanner" => $response, "isactive" => 1, "apprv_by_admin" => 1, "adsDate" => date('Y-m-d'), "updatedAt" => $this->datetimenow()];

            $res = $this->db->where(["adsId=" => $adsId, "loginId" => $loginId])->update("advertisement", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Advertisement Updated by " . $_SESSION['orgName'] . "", "advertisement", "0") : '');
            return ($res ? '{"status":"success", "msg":"Update Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mgetAdvertisement() {
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($ed)) {
            $adsId = base64_decode($ed);
            $condition = "AND ta.adsId=$adsId";
        } else {
            $condition = "";
        }
        $response = $this->db->query("SELECT ta.* ,DATE_FORMAT(ta.ad_start_date,'%d-%b-%Y') as startDate,ta.apprv_by_admin,DATE_FORMAT(ta.adsDate, '%d-%b-%Y') addeddate, tc.name countryname ,ts.name statename,tap.planId,tap.plan_name,tap.img_loc
                                                ,CONCAT(tap.price,' (',tap.currencyCode,')') price,tap.days,tap.countryId,tap.stateId,DATE_FORMAT(DATE_ADD(ta.ad_start_date, INTERVAL tap.days DAY),'%d-%b-%Y') expiryDate,
                                                (SELECT COUNT(*) FROM advertisement adv
                                                INNER JOIN advertisement_plan advp ON advp.planId=adv.planId AND adv.isactive=1 WHERE
                                                adv.adsId=ta.adsId AND DATE_ADD(adv.adsDate, INTERVAL advp.days DAY)>CURRENT_DATE()) as statusadd  FROM advertisement ta
                                                INNER JOIN advertisement_plan tap ON tap.planId=ta.planId AND tap.isactive=1
                                                INNER JOIN countries tc ON tc.countryId=tap.countryId
                                                INNER JOIN states ts ON ts.stateId=tap.stateId
                                                WHERE ta.loginId=" . $_SESSION['loginId'] . "  AND ta.isactive=1  $condition order by ta.adsId desc");
        foreach ($response->result() as $res) {
            $res->adsId = base64_encode($res->adsId);
        }
        return json_encode($response->result());
    }

    public function mdelAdvertisement() {
        $loginId = $_SESSION['loginId'];
        $adsId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $this->db->where(["loginId" => $loginId, "adsId" => base64_decode($adsId), "isactive" => 1]);
        $response = $this->db->get("advertisement");
        if ($response->num_rows() > 0) {
            $this->db->where(["loginId" => $loginId, "adsId" => base64_decode($adsId), "isactive" => 1]);
            $resp = $this->db->update("advertisement", ["updatedAt" => $this->datetimenow(), "isactive" => 0]);
            if ($resp) {
                $this->addActivityLog($_SESSION['loginId'], "Advertisement Deleted by " . $_SESSION['orgName'] . "", "advertisement", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Record not found"}';
        }
    }

    public function mUpdateStartDate() {
        $loginId = $_SESSION['loginId'];
        $adsId = FILTER_VAR(trim($this->input->post('adsId')), FILTER_SANITIZE_STRING);
        $startDateC = FILTER_VAR(trim($this->input->post('startDateC')), FILTER_SANITIZE_STRING);
        if (empty($loginId) || empty($adsId) || empty($startDateC)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        if (strtotime($startDateC) < strtotime(date('Y-m-d'))) {
            return '{"status":"error", "msg":"Date is not valid."}';
        }
        $chkadv = $this->db->where(['adsId' => base64_decode($adsId), 'ad_start_date' => "", 'isactive' => 1])->get("advertisement");
        if ($chkadv->num_rows() > 0) {
            $uData = ["ad_start_date" => $startDateC];
            $res = $this->db->where('adsId', base64_decode($adsId))->update("advertisement", $uData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Password Updated by " . $_SESSION['orgName'] . "", "login_details", "0") : "");
            return ($res ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error", "msg":"Details not in database."}';
        }
    }

    //Advertisement End
    // start requested course by shweta
    private function checkCourseType($title) {
        $chk = $this->db->query("Select * from course_type where isactive=1 and courseType='" . $title . "'");
        if ($chk->num_rows() > 0) {
            return "duplicate";
        } else {
            return "fine";
        }
    }

    private function checkCourse($title) {
        $loginid = $_SESSION['loginId'];
        $chk = $this->db->query("Select * from course_details where isactive=1 AND loginId=$loginid  and title='" . $title . "'");
        if ($chk->num_rows() > 0) {
            return "duplicate";
        } else {
            return "fine";
        }
    }

    // end  requested course by shweta
    //News letter plan buy  starts created by shweta
    public function mGetdetailsofNewsLetterPlan() {
        $id = FILTER_VAR(trim($this->input->post('nlp_Id')), FILTER_SANITIZE_STRING);
        if (!empty($id) || !isset($_SESSION['loginId'])) {
            $qry = $this->db->query("SELECT * FROM tbl_news_ltr_plan WHERE  nlp_Id='" . $id . "' AND isactive=1");
        } else {
            $qry = $this->db->query("SELECT * FROM tbl_news_ltr_plan WHERE isactive=1");
        }
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mAddnewsletterplanbuy() {
        $nlpb_Id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $nlp_Id = FILTER_VAR(trim($this->input->post('plan_name')), FILTER_SANITIZE_NUMBER_INT);
        $no_of_news_ltr = FILTER_VAR(trim($this->input->post('no_of_news_ltr1')), FILTER_SANITIZE_STRING);

        if (empty($nlp_Id) || empty($no_of_news_ltr) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Required field is empty."}';
        }
        if ($nlpb_Id === "no_one") {
            $chk = $this->db->where(['nlp_Id' => $nlp_Id, 'loginId' => $_SESSION['loginId'], 'isactive' => 1])->get("tbl_news_ltr_plan_buy");
            if ($chk->num_rows() > 0) {
                return '{"status":"error","msg":"Duplicate Details"}';
            }

            $chk1 = $this->db->where(['iscurrent' => 1, 'loginId' => $_SESSION['loginId']])->get("tbl_news_ltr_plan_buy");
            $iData = array_merge(["loginId" => $_SESSION['loginId'], "nlp_Id" => $nlp_Id, "no_of_news_ltr" => $no_of_news_ltr,
                "pay_status" => 1, "isactive" => 1, "buy_date" => date('Y-m-d'), "createdAt" => $this->datetimenow()], ($chk1->num_rows() > 0 ? ['iscurrent' => 0] : ['iscurrent' => 1]));
            $res = $this->db->insert("tbl_news_ltr_plan_buy", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Buy Plan Inserted by " . $_SESSION['orgName'] . "", "tbl_news_ltr_plan_buy", "0") : '');
            return ($res ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mGetnewsletterplanbuy() {
        $response = $this->db->query("SELECT nlpb.nlpb_Id,nlpb.nlp_Id,nlpb.loginId,nlpb.no_of_news_ltr as no_of_news_letter,nlpb.iscurrent ,DATE_FORMAT(nlpb.buy_date,'%d-%b-%Y') as buyDate,nlp.nlp_Id,nlp.plan_name,nlp.no_of_news_ltr,nlp.price,nlp.currencies
                                                FROM tbl_news_ltr_plan_buy nlpb
                                                INNER JOIN tbl_news_ltr_plan nlp ON nlp.nlp_Id=nlpb.nlp_Id AND nlp.isactive=1
                                                WHERE nlpb.loginId=" . $_SESSION['loginId'] . " AND nlpb.isactive=1 ");
        if ($response->num_rows() > 0) {
            $result = $response->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mchangeNlpbStatus() {
        $loginId = $_SESSION['loginId'];
        $nlpb_Id = FILTER_VAR(trim($this->input->post('nlpb_Id')), FILTER_SANITIZE_STRING);
        $iscurrent = FILTER_VAR(trim($this->input->post('iscurrent')), FILTER_SANITIZE_STRING);
        if (empty($nlpb_Id) || $iscurrent == "") {
            return '{"status":"error","msg":"Empty Details."}';
        }
        return ($iscurrent == '1' && $loginId == '".loginId."' ? $this->deacticateall($nlpb_Id) : $this->checkAvailable($nlpb_Id));
    }

    private function deacticateall($nlpb_Id) {
        $loginId = $_SESSION['loginId'];

        $this->db->where("nlpb_Id", $nlpb_Id, "loginId", $loginId)->update("tbl_news_ltr_plan_buy", ["iscurrent" => 1, "updatedAt" => $this->datetimenow()]);
        $response = $this->db->where("nlpb_Id!=", $nlpb_Id, "loginId", $loginId)->update("tbl_news_ltr_plan_buy", ["iscurrent" => 0, "updatedAt" => $this->datetimenow()]);
        if ($response) {
            $this->addActivityLog($_SESSION['loginId'], "Buy Plan Status updated by " . $_SESSION['orgName'] . "", "tbl_news_ltr_plan_buy", "0");
            return '{"status":"success","msg":"Buy Plan Status Changed Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    private function checkAvailable($nlpb_Id) {
        $loginId = $_SESSION['loginId'];

        $chk = $this->db->where(["nlpb_Id!=" => $nlpb_Id, "loginId" => $loginId, "iscurrent" => 1])->get("tbl_news_ltr_plan_buy");
        if ($chk->num_rows() > 0) {
            $response = $this->db->where("nlpb_Id", $nlpb_Id, "loginId", $loginId)->update("tbl_news_ltr_plan_buy", ["iscurrent" => 0, "updatedAt" => $this->datetimenow()]);
            ($response ? $this->addActivityLog($_SESSION['loginId'], "Buy Plan Status updated by " . $_SESSION['orgName'] . "", "tbl_news_ltr_plan_buy", "0") : "");
            return ($response ? '{"status":"success","msg":"Buy Plan Status Changed Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"Sorry one is required to be active."}';
        }
    }

    //News letter plan buy  end created by shweta
    //Start send_news_letter by shweta
    public function mGetnewsletteremail() {
        $loginId = $_SESSION['loginId'];
        $qry = $this->db->query("SELECT * FROM tbl_news_letter_emails WHERE loginId='$loginId' AND isactive=1");
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function muploadnewsltremailexcel() {
        if (isset($_FILES['news_ltr_email_excel']['name'])) {
            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
            $todaydate = $date->format('YmdHisA');
            // $filename = preg_replace("/\s+/", "_", $_FILES['news_ltr_email_excel']['name']);
            $config['upload_path'] = './excelfiles/';
            $config['allowed_types'] = 'xlsx|xltx|xlsm|xltm|xls';

            $config['file_name'] = $todaydate;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('news_ltr_email_excel')) {
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
        $arr_data = [];
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
        return $this->insertnewsltremailDetails($arr_data);
    }

    private function insertnewsltremailDetails($arr_data) {
        $created = 0;
        $total = 0;
        foreach ($arr_data as $ar) {
            $email = FILTER_VAR(trim($ar['A']), FILTER_VALIDATE_EMAIL);
            if (!isset($_SESSION['loginId']) && !empty($email)) {
                $chkdetails = $this->db->where(["email" => $email, "loginId" => $_SESSION['loginId']])->get("tbl_news_letter_emails");
                if ($chkdetails->num_rows() > 0) {
                    return '{"status":"error","msg":"Duplicate Details"}';
                } else {
                    if ($_SESSION['loginId']) {
                        $idata = ["loginId" => $_SESSION['loginId'], "email" => $email, "createdAt" => $this->datetimenow(), "isactive" => 1];
                        $this->db->insert("tbl_news_letter_emails", $idata);
                        $created++;
                    }
                }
            }
            $total++;
        }
        return '{"status":"success","msg":"File Upload and ' . $created . ' created out of ' . $total . '!"}';
    }

    public function mEmailnewsletter() {
        $email = FILTER_VAR(trim($this->input->post('email')), FILTER_VALIDATE_EMAIL);
        $msg = $this->input->post('msg');
        if (empty($email) || empty($msg)) {
            return '{"status":"error","msg":"Empty Data"}';
        } else {
            $subject = 'Gretting From IhuntBest';
            $message = ".$msg.";
            $body = "" . $message . "<p>Best Regards</p>" . "\n\n" . " Team IhuntBest";
            //send email
            //$res = true;
            $res = $this->sendEmail($email, $body, $subject);
            if ($res) {
                $response = $this->db->query("SELECT no_of_news_ltr FROM tbl_news_ltr_plan_buy  WHERE loginId=" . $_SESSION['loginId'] . " AND iscurrent=1 AND isactive=1");
                $result = ($response->num_rows() > 0 ? $response->row()->no_of_news_ltr : "");
                ($result == 0 ? $this->db->where(["loginId" => $_SESSION['loginId'], 'iscurrent' => 1, 'isactive' => 1])->update('tbl_news_ltr_plan_buy', ['iscurrent' => 0, 'isactive' => 0]) :
                                $this->db->where(['loginId' => $_SESSION['loginId'], 'email' => $email, 'isactive' => 1])->update('tbl_news_letter_emails', ['no_of_news_ltr_send' => 'no_of_news_ltr_send+1']));
                ($result == 0 ? '' : $this->db->where(['loginId' => $_SESSION['loginId'], 'iscurrent' => 1, 'isactive' => 1])->update('tbl_news_ltr_plan_buy', ['no_of_news_ltr' => 'no_of_news_ltr-1']));
                return ($result == 0 ? '{"status":"error","msg":"No of news letter 0 please select another plan to continue"}' : '{"status":"success","msg":"Send Successfully"}');
            }
        }
    }

    public function sendEmail($email, $body, $subject) {
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

    //End send_news_letter by shweta
    private function uploadImage($path, $imgName, $uploadfname) {
        $config = ['upload_path' => $path, "allowed_types" => "gif|jpg|png|jpeg|JPG|JPEG|PNG|GIF", 'file_name' => $imgName];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($uploadfname) == false) {
//            $error = array('error' => $this->upload->display_errors());
            return 'error';
        } else {

            $data = $this->upload->data();
            $newImage = $data['file_name'];
            $config = ['image_library' => "gd2", 'source_image' => $path . '/' . $newImage,
                'new_image' => $path . '/' . $newImage, "create_thumb" => false, "maintain_ratio" => true, "quality" => 100, "width" => '1024'];
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                $this->image_lib->display_errors();
                return "error";
            } else {
                $this->waterMarkingImage($newImage, $path);
                return $newImage;
            }
        }
    }

    public function removeImage($prevImg, $imagepath) {
        $imgn = explode("/", $prevImg);
        $iname = $imgn[count($imgn) - 1];
        if (file_exists($imagepath . $iname)) {
            unlink($imagepath . $iname);
        }
    }

    public function mchangePasswordSave() {
        $loginId = $_SESSION['loginId'];
        $oldpass = FILTER_VAR(trim($this->input->post('current_password')), FILTER_SANITIZE_STRING);
        $newpass = FILTER_VAR(trim($this->input->post('new_password')), FILTER_SANITIZE_STRING);
        $cnewpas = FILTER_VAR(trim($this->input->post('confirm_password')), FILTER_SANITIZE_STRING);
        $details = $this->db->where(["id" => $loginId])->get("login_details");
        if ($newpass !== $cnewpas) {
            return '{"status":"error", "msg":"Confirm Password and New Password not same."}';
        } if ($details->num_rows() > 0) {
            $data = $details->row();
            $currpass = $this->encryption->decrypt($data->password1);
            if ($currpass !== $oldpass && $oldpass !== $data->password) {
                return '{"status":"error", "msg":"Old password is wrong."}';
            } else {
                $encpass = $this->encryption->encrypt($newpass);
                $uData = ["password" => $cnewpas, "password1" => $encpass, "updatedAt" => $this->datetimenow()];
                $res = $this->db->where(["id" => $loginId])->update("login_details", $uData);
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Password Updated by " . $_SESSION['orgName'] . "", "login_details", "0") : '');
                return ($res ? '{"status":"success", "msg":"Change Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            }
        }
    }

    //Analytics Start
    public function mGetViewCounts() {
        $loginId = $_SESSION['loginId'];
        if ($loginId) {
            $qry = $this->db->where("id", $loginId)->get("login_details");
            if ($qry->num_rows() > 0) {
                $rowData = $qry->row();

                return $rowData;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //Analytics End
    //Enquiry Start
    public function mGetEnquiryApplications() {
        $totalDataqry = $this->mgetAllEnquiry('total');
        $totalData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->num_rows() : 0);
        $query = (empty($this->input->post('search')['value']) ? $this->mgetAllEnquiry('nosearch') : $this->mgetAllEnquiry('search'));
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $totalFiltered = (empty($this->input->post('search')['value']) ? $totalData : $this->mgetAllEnquiry('searchtotal')->num_rows());

        $data = array();
        if (!empty($posts)) {
            $i = ($this->input->post('start') == 0 ? 1 : $this->input->post('start'));
            foreach ($posts as $dt) { //.' ('.$dt->courseType.') '.$dt->departmentName
                $data[] = ["tcEnquiyId" => $i++, "CourseDetails" => $dt->courseDetails, "senderDetails" => $dt->senderDetails, "message" => $dt->message, "enquiryDate" => $dt->enqdate,
                    "enquiryStatus" => $dt->status, "action" => '<a href="javascript:" class="sendMessage btn btn-primary" enqId="' . $dt->tcEnquiyId . '">Send Message</a>'];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }

    private function mgetAllEnquiry($condition) {
        $columns = array(0 => 'tce.tcEnquiyId', 1 => 'cd.title', 2 => 'tce.senderName', 3 => 'tce.message', 4 => 'tce.date');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $likearr = " AND (tce.tcEnquiyId like %$search% OR cd.title LIKE %$search% OR oc.courseDurationType LIKE %$search% OR td.title LIKE %$search%
                    OR tce.senderName LIKE %$search% OR tce.email LIKE %$search% OR tce.contact LIKE %$search% OR tce.message LIKE %$search% )";
        $condions = ($condition == "nosearch" ? "Order by $order $dir  LIMIT  $start,$limit" : ($condition == "total" ? "" :
                ($condition == "search" ? " $likearr Order by $order $dir  LIMIT $start,$limit" : ($condition == "searchtotal" ? " $likearr Order by $order $dir " : ""))));

        return $this->db->query("SELECT tce.tcEnquiyId,CONCAT(cd.title,' (',sd.title,') ',td.title,' ',oc.courseDurationType ) courseDetails,CONCAT(tce.senderName,'<br>',tce.email,'<br>',tce.contact) senderDetails,
                    tce.message,DATE_FORMAT(tce.date ,'%d-%b-%Y') enqdate,tce.status FROM tbl_course_enquiry tce
                    INNER JOIN organization_streams os ON os.orgStreamId=tce.orgStreamId
                    INNER JOIN organization_courses oc ON oc.orgCourseId=os.orgCourseId
                    LEFT JOIN department dep ON dep.departmentId=oc.departmentId
                    INNER JOIN stream_details sd ON sd.streamId=os.streamId INNER JOIN course_type ct ON ct.ctId = oc.courseTypeId
                    INNER JOIN course_details cd ON cd.cId=oc.courseId
                    INNER JOIN time_duration td ON td.tdId=oc.courseDurationId
                    INNER JOIN login_details ld ON ld.id=oc.loginId
                    WHERE  tce.isactive=1 AND os.loginId=" . $_SESSION['loginId'] . " $condions");
    }
	
		public function notLoggedIn($response)
	    {
		    $response;
		    return json_encode($response);
	    }


    //Enquiry End
    //Enrollments Start
    public function mGetEnrollApplications() {
        $totalDataqry = $this->mgetAllEnrollments('total');
        $totalData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->num_rows() : 0);
        $query = (empty($this->input->post('search')['value']) ? $this->mgetAllEnrollments('nosearch') : $this->mgetAllEnrollments('search'));
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $totalFiltered = (empty($this->input->post('search')['value']) ? $totalData : $this->mgetAllEnrollments('searchtotal')->num_rows());

        $data = array();
        if (!empty($posts)) {
            $i = ($this->input->post('start') == 0 ? 1 : $this->input->post('start'));
            foreach ($posts as $dt) { //.' ('.$dt->courseType.') '.$dt->departmentName
                $data[] = ["enrollmentId" => $i++,"StudentDetails" => ' <button type="button" class="btn btn-info  stu_info" onclick="studentInfo('."'".$dt->roleName."'".','.$dt->courseId.','.$dt->orgCourseId.','.$dt->studentId.','.$dt->enrollmentId.')" value="'.$dt->enrollmentId.'">'.$dt->studentName.'</button><br><br><button type="button" class="btn btn-info  see_msg" onclick="showMsg('.$dt->enrollmentId.','.$dt->studentId.','."'".$dt->studentName."'".')" data-toggle="modal" data-target="#myModal">See Message</button>', "CourseDetails" => $dt->courseName, "CourseDuration" => $dt->timeDuration . ' ' . $dt->courseDurationType,
                    "FeeDetails" => 'Reg Fee : ' . $dt->registrationFee . '<br> Course Fee : ' . $dt->courseFee, "ImportantDates" => 'Application Opening : ' . ($dt->openingDate ? $dt->openingDate : "NA") . '
                    <br>Application Closing : ' . ($dt->closingDate ? $dt->closingDate : "NA") . '<br>Exam Date: ' . ($dt->examDate ? $dt->examDate : "NA"),
                    "ApplicationDate" => $dt->applicationDate, "ApplicationStatus" => $dt->status, "Action" => '<select class="statuschange" erId="' . $dt->enrollmentId . '">
                    <option value="">Select</option><option value="Accepted">Accept</option><option value="Rejected">Reject</option></select>'];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }
	
	public function mshowMsg(){
	    $eId=$this->input->post('eId');
		$chData = ['enrollmentId' => $eId];
        $chkData = $this->db->where($chData)->order_by('createdDate','DESC')->get("tbl_notifications_msg");	
		$msg = ($chkData->num_rows() > 0 ? $chkData->result() : null);
		return json_encode($msg);
		
}
	
		public function mGetStudentData($studentid)
	    {
			$getStudentData = $this->mviewEnrollStudentData($studentid);
			$sData = ($getStudentData->num_rows() > 0 ? $getStudentData->row() : "");
			$response = ["studentDetails" => $sData];
			return json_encode(array_merge($response));
		}
	
		public function mviewEnrollStudentData($studentid)
	    {
			$qry = $this->db->query("SELECT std.studentId,std.fatherName,std.studentImage,std.placeofBirth,std.religion,std.studentMobile,std.gender,
										DATE_FORMAT(std.dob,'%d-%m-%Y') as dobc,std.dob,std.studentName,ctry.name,ctry.countryId,sl.email
										FROM student_details std
										LEFT JOIN student_login sl ON sl.studentId=std.studentId
										LEFT JOIN countries ctry ON ctry.countryId=std.countryId
										WHERE std.studentId=$studentid");
			$this->db->close();
			return $qry;
	    }
	
    public function mgetAllEnrollments($condition) {
        $columns = array(0 => 'te.enrollmentId', 1 => 'sd.studentName', 2 => 'cd.title', 3 => 'td.title', 4 => 'os.courseFee', 5 => 'icd.applyFrom', 6 => 'te.createdAt', 7 => 'te.status');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $likearr = " AND (te.enrollmentId like %$search% OR cd.title LIKE %$search% OR td.title LIKE %$search% OR oc.courseFee LIKE %$search%
                    OR oc.openingDate LIKE %$search% OR te.status LIKE %$search% OR std.studentName LIKE %$search% OR  te.closingDate LIKE %$search% OR oc.courseDurationType LIKE %$search% )";
        $condions = ($condition == "nosearch" ? "Order by $order $dir  LIMIT  $start,$limit" : ($condition == "total" ? "" :
                ($condition == "search" ? " $likearr Order by $order $dir  LIMIT $start,$limit" : ($condition == "searchtotal" ? " $likearr Order by $order $dir " : ""))));
       $loginId=$_SESSION['loginId'];
        return $this->db->query("SELECT te.enrollmentId,te.status,te.studentId,std.studentName,oc.courseDurationType,os.orgCourseId,oc.courseId,ld.roleName,DATE_FORMAT(oc.openingDate ,'%d-%b-%Y') openingDate,
                                        DATE_FORMAT(oc.closingDate ,'%d-%b-%Y') closingDate,  DATE_FORMAT(oc.examDate ,'%d-%b-%Y') examDate,os.courseFee,
                                        os.registrationFee,dep.title departmentName, ct.courseType,CONCAT(cd.title,' (',sd.title,')') courseName,td.title timeDuration,
                                        DATE_FORMAT(te.createdAt ,'%d-%b-%Y') applicationDate,ld.roleName,od.orgName FROM tbl_enroll te
                                        INNER JOIN student_details std ON std.studentId=te.studentId
										INNER JOIN organization_streams os ON os.orgStreamId=te.orgStreamId INNER JOIN organization_courses oc ON oc.orgCourseId=os.orgCourseId
                                        LEFT JOIN department dep ON dep.departmentId=oc.departmentId 
										INNER JOIN course_type ct ON ct.ctId = oc.courseTypeId
										INNER JOIN course_details cd ON cd.cId=oc.courseId  INNER JOIN time_duration td ON td.tdId=oc.courseDurationId 
                                        INNER JOIN stream_details sd ON sd.streamId=os.streamId  INNER JOIN login_details ld ON ld.id=oc.loginId
                                        INNER JOIN organization_details od ON ld.id=od.loginId
                                        WHERE  te.isactive=1 AND os.loginId=" . $_SESSION['loginId'] . " $condions");
    }
	public function mGetEnrollData($loginid, $type, $studentid, $courseId, $orgCourseId)
	{
		$this->load->model('Home_model');
		$getStudentData = $this->Home_model->mgetEnrollStudentData($studentid);
		$sData = ($getStudentData->num_rows() > 0 ? $getStudentData->row() : "");
		$getOrgData = $this->Home_model->mgetEnrollOrgData($loginid, $type);
		$orgData = ($getOrgData->num_rows() > 0 ? $getOrgData->result() : "");
		$chkEli = $this->Home_model->OrgMinQualification($orgCourseId);
		$courseDetails = $this->Home_model->getCourseInfo($orgCourseId, $courseId, $type, $loginid);
		  $cData = ["studentId" => $studentid];
		  //print_r($cData);
        $docData = $this->db->query("SELECT * FROM tbl_student_file_upload WHERE studentId=$studentid AND isactive=1")->result() ;
		 
		$response = ["studentDetails" => $sData, "orgDetails" => $orgData, "reqEligibility" => $chkEli,"docDetails" => $docData];
		

		return json_encode(array_merge($response, $courseDetails));
	}
	
	
	public function mGetTransactions() {
        $totalDataqry = $this->mgetorgtransactions('total');
        $totalData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->num_rows() : 0);
        $query = (empty($this->input->post('search')['value']) ? $this->mgetorgtransactions('nosearch') : $this->mgetorgtransactions('search'));
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $totalFiltered = (empty($this->input->post('search')['value']) ? $totalData : $this->mgetorgtransactions('searchtotal')->num_rows());

        $data = array();
        if (!empty($posts)) {
            $i = ($this->input->post('start') == 0 ? 1 : $this->input->post('start'));
            foreach ($posts as $dt) { //.' ('.$dt->courseType.') '.$dt->departmentName
                $data[] = ["sno" => $i++,"PaymentId" => $dt->payment_id ,"EnrollmentId" => $dt->enrollment_id ,"StudentName" => $dt->student_name,
                    "Amount" => $dt->amount , "Date" => $dt->createdate];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }
	
	
	
	
	
	
	public function mgetorgtransactions($condition)
	{
		$columns = array(0 => 'torg.id', 1 => 'torg.payment_id', 2 => 'torg.enrollment_id', 3 => 'torg.student_name', 4 => 'torg.amount',5 => 'torg.createdate');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $likearr = " AND (torg.id like %$search% OR torg.payment_id LIKE %$search% OR torg.enrollment_id LIKE %$search% OR torg.student_name LIKE %$search%
                    OR torg.amount LIKE %$search% OR torg.createdate)";
        $condions = ($condition == "nosearch" ? "Order by $order $dir  LIMIT  $start,$limit" : ($condition == "total" ? "" :
                ($condition == "search" ? " $likearr Order by $order $dir  LIMIT $start,$limit" : ($condition == "searchtotal" ? " $likearr Order by $order $dir " : ""))));
       //$loginId=$_SESSION['loginId'];
        return $this->db->query("SELECT torg.payment_id,torg.enrollment_id,torg.student_name,torg.amount ,DATE_FORMAT(torg.createdate ,'%d-%b-%Y') createdate FROM tbl_org_transactions torg
                                        WHERE org_id=" . $_SESSION['loginId'] . " $condions");
		/* $transactions = $this->db->where(["org_id" => $_SESSION['loginId']])->get("tbl_org_transactions");
		return $transactions; */
		//$transactions = $this->db->query("SELECT * FROM tbl_org_transactions WHERE org_id=".$_SESSION['loginId'])->result() ;
	}
	
	public function getdocs($studentid){
		$chk = $this->db->where(["studentId" => $studentId, "isactive" => 1])->get("tbl_student_file_upload");
		return $chk;
	}
	

    public function mChangeEnrollMentStatus() {
        $enrollmentId = FILTER_VAR(trim($this->input->post('enrollmentId')), FILTER_SANITIZE_STRING);
        $status = FILTER_VAR(trim($this->input->post('status')), FILTER_SANITIZE_STRING);
        $message = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);
        if (empty($enrollmentId) || empty($status) || empty($message) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Required details are empty!"}';
        }
        $chks = $this->db->where(["enrollmentId" => $enrollmentId, "status" => $status])->get("tbl_enroll");
        if ($chks->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate Status"}';
        }
        /* $chk = $this->db->query("SELECT * FROM tbl_enroll te INNER JOIN organization_courses oc ON oc.orgCourseId=te.orgCourseId  AND oc.isactive=1
            WHERE oc.loginId=" . $_SESSION['loginId'] . " AND te.enrollmentId=$enrollmentId AND te.isactive=1"); */
			$chk = $this->db->query("SELECT * FROM tbl_enroll where enrollmentId=$enrollmentId AND isactive=1");
        if ($chk->num_rows() > 0) {
            $uData = ["updatedAt" => $this->datetimenow(), "status" => $status];
            $resp = $this->db->where("enrollmentId", $enrollmentId)->update("tbl_enroll", $uData);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Enrollment Status Changed by " . $_SESSION['orgName'] . "", "tbl_enroll", "0") : "");
            //$response = ($resp ? $this->sendEnrollEmail($enrollmentId, $status, $message, $chk) : "");
            return ($resp ? '{"status":"success", "msg":"Status changed successfully! "}' : '{"status":"error", "msg":"Some error occured."}');
        }
    }
	 public function mnotifyMsg() {
		 
		$enrollmentId = FILTER_VAR(trim($this->input->post('enrollmentId')), FILTER_SANITIZE_STRING);
        $orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);
        $studentId = FILTER_VAR(trim($this->input->post('studentId')), FILTER_SANITIZE_STRING);
        $msg = FILTER_VAR(trim($this->input->post('msg')), FILTER_SANITIZE_STRING);
		$msgFrom = FILTER_VAR(trim($this->input->post('msgFrom')), FILTER_SANITIZE_STRING);
        $msgTo = FILTER_VAR(trim($this->input->post('msgTo')), FILTER_SANITIZE_STRING);
		
		if (empty($enrollmentId) || empty($orgId) || empty($studentId) || empty($msg)|| empty($msgFrom)|| empty($msgTo)) {
            return '{"status":"error", "msg":"Required details are empty!"}';
        }
		$iData = ["orgId" => $orgId, "enrollmentId" => $enrollmentId, "studentId" => $studentId, "msg" => $msg,"msgFrom" => $msgFrom,"msgTo" => $msgTo];
            $res = $this->db->insert("tbl_notifications_msg", $iData);
            
            return($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
	
		 
	 }

    public function sendEnrollEmail($enrollmentId, $status, $message, $chk) {
        $rowData = ($chk->num_rows() > 0 ? $chk->row() : "");
        $cdetails = $this->courseDetails($enrollmentId);
        $idata = ["message" => $message . ' ' . $cdetails, "notificationFor" => $rowData->studentId, "tableName" => "student_login", "sentBy" => $_SESSION['loginId'],
            "senderTableName" => "login_details", "isRead" => 0, "referenceId" => $enrollmentId, "referenceTable" => "tbl_enroll", "createdAt" => $this->datetimenow(),
            "ipAddressSender" => $this->getRealIpAddr(), "isactive" => 1];
        $resp = $this->db->insert("tbl_notifications", $idata);
        ($resp ? $this->addActivityLog($_SESSION['loginId'], "New notification added by " . $_SESSION['orgName'] . "", "tbl_notifications", "0") : "");
        $sdetails = $this->db->where("studentId", $rowData->studentId)->get("student_login");
        if ($sdetails->num_rows() > 0) {
            $sData = $sdetails->row();
            $email = $sData->email;
            $subject = 'Enrollment Status Updated.';
            $body = "Hello, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Your request for course " . $cdetails . ' has been ' . $status . '. Please login iHuntBest
                            for more information.<br></br>With Regards,<br>iHuntBest.com';
            $resp = $this->sendEmail($email, $body, $subject);
            $response = ($resp ? "Email Sent Successfully" : "Email not sent.");
        } else {
            $response = "Email not sent.";
        }
        return $response;
    }

    private function courseDetails($enrollmentId) {
        $getEnrollment = $this->db->query("SELECT te.enrollmentId,te.status,oc.courseDurationType,DATE_FORMAT(oc.openingDate ,'%d-%b-%Y') openingDate,
        DATE_FORMAT(oc.closingDate ,'%d-%b-%Y') closingDate,  DATE_FORMAT(oc.examDate ,'%d-%b-%Y') examDate,oc.courseFee,
        oc.registrationFee,dep.title departmentName, ct.courseType,cd.title courseName,td.title timeDuration,
        DATE_FORMAT(te.createdAt ,'%d-%b-%Y') applicationDate,ld.roleName,od.orgName FROM tbl_enroll te
        INNER JOIN organization_courses oc ON oc.orgCourseId=te.orgCourseId  AND oc.isactive=1
        LEFT JOIN department dep ON dep.departmentId=oc.departmentId  INNER JOIN course_type ct ON ct.ctId = oc.courseTypeId
        INNER JOIN course_details cd ON cd.cId=oc.courseId  INNER JOIN time_duration td ON td.tdId=oc.courseDurationId
        INNER JOIN login_details ld ON ld.id=oc.loginId
        INNER JOIN organization_details od ON ld.id=od.loginId
        WHERE te.isactive=1 AND oc.loginId=" . $_SESSION['loginId'] . " AND te.enrollmentId=$enrollmentId");
        if ($getEnrollment->num_rows() > 0) {
            $rowData = $getEnrollment->row();
            $result = 'Course Name ' . $rowData->courseName . ' Duration ' . $rowData->timeDuration . ' Application Date ' . $rowData->applicationDate;
        } else {
            $result = '';
        }
        return $result;
    }

    //Enrollments End
    //promocode Start
    public function mGetCourseNames() {
        $qry = $this->db->query("SELECT CONCAT(td.title,'(',cd.title,')') courseName,oc.orgCourseId FROM organization_courses oc
        INNER JOIN department td ON td.departmentId=oc.departmentId AND td.isactive=1
        INNER JOIN course_type ct ON ct.ctId=oc.courseTypeId AND ct.isactive=1
        INNER JOIN course_details cd ON cd.cId=oc.courseId  AND cd.isactive=1
        WHERE oc.loginId=" . $_SESSION['loginId'] . " AND oc.isactive=1");
        if ($qry->num_rows() > 0) {
            $response = $qry->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mGetPomoCodePrice() {
        $qry = $this->db->where(["isApplicable" => 1, "isactive" => 1])->get("tbl_promocodemaster");
        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return false;
        }
    }

    public function mAddPromocode() {
        $promocodeDetailsId = FILTER_VAR(trim($this->input->post('promocodeDetailsId')), FILTER_SANITIZE_STRING);
        $PromoCode = FILTER_VAR(trim($this->input->post('PromoCode')), FILTER_SANITIZE_STRING);
        $offer_amount = FILTER_VAR(trim($this->input->post('offer_amount')), FILTER_SANITIZE_NUMBER_INT);
        $orgCourseId = FILTER_VAR(trim($this->input->post('orgCourseId')), FILTER_SANITIZE_STRING);
        $validFrom = FILTER_VAR(trim($this->input->post('validFrom')), FILTER_SANITIZE_STRING);
        $validTo = FILTER_VAR(trim($this->input->post('validTo')), FILTER_SANITIZE_STRING);
        $price = FILTER_VAR(trim($this->input->post('price')), FILTER_SANITIZE_NUMBER_INT);
        $priceid = FILTER_VAR(trim($this->input->post('priceid')), FILTER_SANITIZE_NUMBER_INT);
        $payableAmount = FILTER_VAR(trim($this->input->post('payableAmount')), FILTER_SANITIZE_NUMBER_INT);
        $isApplicable = FILTER_VAR(trim($this->input->post('isApplicable')), FILTER_SANITIZE_NUMBER_INT);
        $numberOfCodes = FILTER_VAR(trim($this->input->post('numberOfCodes')), FILTER_SANITIZE_NUMBER_INT);
        $promocodeId = FILTER_VAR(trim($this->input->post('promocodeId')), FILTER_SANITIZE_NUMBER_INT);
        if (empty($promocodeDetailsId) || empty($PromoCode) || empty($offer_amount) || empty($orgCourseId) || empty($validFrom) || empty($validTo) || empty($price) || empty($payableAmount) || empty($numberOfCodes) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Required details are empty!"}';
        }
        $condition = ($promocodeDetailsId == "no_one" ? ["PromoCode" => $PromoCode, "orgCourseId" => $orgCourseId, "isactive" => 1] : ["promocodeDetailsId!=" => base64_decode($promocodeDetailsId), "PromoCode" => $PromoCode, "orgCourseId" => $orgCourseId, "isactive" => 1]);
        $chkqry = $this->db->where($condition)->get("tbl_promocodedetails");
        return ($chkqry->num_rows() > 0 ? '{"status":"error", "msg":"Duplicate details."}' : $this->insertUpdatePromoCodes($promocodeDetailsId, $PromoCode, $offer_amount, $orgCourseId, $validFrom, $validTo, $price, $priceid, $payableAmount, $isApplicable, $numberOfCodes, $promocodeId));
    }

    private function insertUpdatePromoCodes($promocodeDetailsId, $PromoCode, $offer_amount, $orgCourseId, $validFrom, $validTo, $price, $priceid, $payableAmount, $isApplicable, $numberOfCodes, $promocodeId) {
        if (($price !== $priceid) || ($payableAmount != $priceid * $numberOfCodes)) {
            return '{"status":"error", "msg":"Inconsistent details."}';
        }
        if ($promocodeDetailsId == "no_one") {
            $idata = ["PromoCode" => $PromoCode, "offer_amount" => $offer_amount, "orgCourseId" => $orgCourseId, "validFrom" => $validFrom, "validTo" => $validTo, "numberOfCodes" => $numberOfCodes,
                "payableAmount" => $payableAmount, "promocodeId" => $promocodeId, "isapplicable" => $isApplicable, "createdAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr(), "isactive" => 1];
            $resp = $this->db->insert("tbl_promocodedetails", $idata);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Promocode details added by " . $_SESSION['orgName'] . "", "tbl_promocodedetails", "0") : "");
        } else {
            $idata = ["PromoCode" => $PromoCode, "offer_amount" => $offer_amount, "orgCourseId" => $orgCourseId, "validFrom" => $validFrom, "validTo" => $validTo, "numberOfCodes" => $numberOfCodes,
                "payableAmount" => $payableAmount, "promocodeId" => $promocodeId, "isapplicable" => $isApplicable, "updateAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr(), "isactive" => 1];
            $resp = $this->db->where(["promocodeDetailsId" => base64_decode($promocodeDetailsId), "isactive" => 1])->update("tbl_promocodedetails", $idata);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Promocode details added by " . $_SESSION['orgName'] . "", "tbl_promocodedetails", "0") : "");
        }
        return ($resp ? '{"status":"success", "msg":"Saved Successfully."}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
    }

    public function mGetPromocode() {
        $promocodeDetailsId = FILTER_VAR(trim($this->input->post('promocodeDetailsId')), FILTER_SANITIZE_STRING);
        $condition = ($promocodeDetailsId ? " AND promocodeDetailsId=" . base64_decode($promocodeDetailsId) : "");
        $qry = $this->db->query("SELECT CONCAT(td.title,'(',cd.title,')') courseName,oc.orgCourseId,pc.*,
                                                    CONCAT('From : ',DATE_FORMAT(pc.validFrom,'%d-%b-%Y'),' To : ',DATE_FORMAT(pc.validTo,'%d-%b-%Y')) validdates,
                                                    pcm.price FROM tbl_promocodedetails pc
                                                    INNER JOIN organization_courses oc ON oc.orgCourseId =pc.orgCourseId AND oc.isactive=1
                                                    INNER JOIN department td ON td.departmentId=oc.departmentId
                                                    INNER JOIN course_type ct ON ct.ctId=oc.courseTypeId
                                                    INNER JOIN course_details cd ON cd.cId=oc.courseId
                                                    INNER JOIN tbl_promocodemaster pcm ON pcm.promocodeId=pc.promocodeId
                                                    WHERE oc.loginId=" . $_SESSION['loginId'] . " AND pc.isactive=1 $condition");
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $qr) {
                $qr->promocodeDetailsId = base64_encode($qr->promocodeDetailsId);
            }
            $response = $qry->result();
        } else {
            $response = '';
        }
        return json_encode($response);
    }

    public function mDelPromocode() {
        $promocodeDetailsId = FILTER_VAR(trim($this->input->post('promocodeDetailsId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId']) || empty($promocodeDetailsId)) {
            return '{"status":"error", "msg":"Required fields are empty."}';
        }
        $chk = $this->db->where(["promocodeDetailsId" => base64_decode($promocodeDetailsId), "isactive" => 1])->get("tbl_promocodedetails");
        if ($chk->num_rows() > 0) {
            $resp = $this->db->where("promocodeDetailsId", base64_decode($promocodeDetailsId))->update("tbl_promocodedetails", ["updateAt" => $this->datetimenow(), "isactive" => 0]);
            if ($resp) {
                $this->addActivityLog($_SESSION['loginId'], "Promocode Deleted by " . $_SESSION['orgName'] . "", "tbl_promocodedetails", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Record not found"}';
        }
    }

    //promocode End
    //Add new organisation type start
    public function mAddNewOrganisationType() {
        $newOrgType1 = FILTER_VAR(trim($this->input->post('newOrgType')), FILTER_SANITIZE_STRING);
        if (empty($newOrgType1) || !isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Required fields are empty."}';
        }
        $newOrgType = ucwords(strtolower($newOrgType1));
        $chk = $this->db->where(["typeName" => $newOrgType, "isactive" => 1])->get("orgtype");
        if ($chk->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate record."}';
        } else {
            $idata = ["typeName" => $newOrgType, "createdAt" => $this->datetimenow(), "createdBy" => $_SESSION['orgName'],
                "isactive" => 1];
            $resp = $this->db->insert("orgtype", $idata);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "New Organization Type " . $newOrgType . " added by " . $_SESSION['orgName'] . "", "orgtype", "0") : "");
            return ($resp ? '{"status":"success", "msg":"Saved Successfully."}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    //Add new organisation type end
    //testimonial start
    public function mgetTestimonials() {
        $testimonialId = FILTER_VAR(trim($this->input->post('testimonialId')), FILTER_SANITIZE_STRING);
        if ($testimonialId == 'all') {
            $qry = $this->db->where(["userRole" => $_SESSION['userType'], "userId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_testimonial");
        } else {
            $qry = $this->db->where(["testimonialId" => $testimonialId, "userRole" => $_SESSION['userType'], "userId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_testimonial");
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

        if (empty($testimonialId) || empty($userName) || empty($userName) || !isset($_SESSION['loginId'])) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $condition = ( $testimonialId == "no_one" ? ["userName" => $userName, "userHeadline" => $userHeadline,
            "userRole" => $_SESSION['userType'], "userId" => $_SESSION['loginId'], "isactive" => 1] : ["testimonialId!=" => $testimonialId, "userName" => $userName,
            "userHeadline" => $userHeadline, "userRole" => $_SESSION['userType'], "userId" => $_SESSION['loginId'], "isactive" => 1]);
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
            $imgName = "Testimonial_" . strtotime($this->datetimenow());
            $testimonialImage = $this->uploadImage($path, $imgName, 'userImage');
            if ($testimonialImage == "error") {
                return '{"status":"error","msg":"Image Upload error!"}';
            } else {
                (file_exists(ltrim($prevImage, './')) ? unlink(rtrim($prevImage, './')) : "");
                $testimonialImage = $path . $testimonialImage;
            }
        } else {
            $testimonialImage = $prevImage;
        }
        $idata = array_merge(["userName" => $userName, "userImage" => $testimonialImage, "userHeadline" => $userHeadline, "userText" => $userText], ($testimonialId == "no_one" ? ["userRole" => $_SESSION['userType'], "userId" => $_SESSION['loginId'], "createdAt" => $this->datetimenow(), "isactive" => 1] : ["updatedAt" => $this->datetimenow()]));
        $resp = ($testimonialId == "no_one" ? $this->db->insert("tbl_testimonial", $idata) : $this->db->where(["testimonialId" => $testimonialId, "userRole" => $_SESSION['userType'], "userId" => $_SESSION['loginId'], "isactive" => 1])->update("tbl_testimonial", $idata));

        ( $resp ? $this->addActivityLog($_SESSION['loginId'], "Testimonial details Inserted", "tbl_testimonial", "0") : "" );
        return( $resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
    }

    public function mDelTestimonial() {
        $testimonialId = FILTER_VAR(trim($this->input->post('testimonialId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId']) || empty($testimonialId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $chk = $this->db->where(["testimonialId" => $testimonialId, "isactive" => 1])->get("tbl_testimonial");
        if ($chk->num_rows() > 0) {
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where(["testimonialId" => $testimonialId, "isactive" => 1])->update("tbl_testimonial", $udata);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Testimonial details Deleted", "tbl_testimonial", "0") : "" );
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            return( $resp ? '{"status":"success","msg":"No records found!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        }
    }

    //testimonial end
    //Blog Start
    public function mgetBlogCategories() {
        $catId = FILTER_VAR(trim($this->input->post('catId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId'])) {
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
        if (empty($blogId) || empty($blogcatId) || empty($blogTitle) || empty($blogDesp) || !isset($_SESSION['loginId']) || empty($blogImage)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $condition = ( $blogId == "no_one" ? ["blogcatId" => $blogcatId, "blogTitle" => $blogTitle, "isactive" => 1] : ["blogId!=" => $blogId, "blogcatId" => $blogcatId, "blogTitle" => $blogTitle, "isactive" => 1] );
        $chk = $this->db->where($condition)->get("tbl_blog");
        return ($chk->num_rows() > 0 ? '{"status":"error","msg":"Duplicate Details!"}' : $this->editInsertBlogs($blogId, $blogcatId, $blogTitle, $blogDesp, $blogImage));
    }

    private function editInsertBlogs($blogId, $blogcatId, $blogTitle, $blogDesp, $blogImage) {
        if ($blogId == "no_one") {
            $idata = ["blogcatId" => $blogcatId, "blogTitle" => $blogTitle, "blogImage" => $blogImage, "blogDesp" => $blogDesp, "userId" => $_SESSION['loginId'],
                "userType" => $_SESSION['userType'], "createdAt" => $this->datetimenow(), "blogStatus" => 0, "isactive" => 1];
            $resp = $this->db->insert("tbl_blog", $idata);
        } else {
            $idata = ["blogcatId" => $blogcatId, "blogTitle" => $blogTitle, "blogImage" => $blogImage, "blogDesp" => $blogDesp,
                "updatedAt" => $this->datetimenow(), "blogStatus" => 0, "updatedAt" => $this->datetimenow(),];
            $resp = $this->db->where(["blogId" => $blogId, "isactive" => 1])->update("tbl_blog", $idata);
        }
        ($resp ? $this->addActivityLog($_SESSION['loginId'], "Blog posted by Super Admin", "tbl_blog", "0") : "" );
        return($resp ? '{"status":"success","msg":"Saved successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
    }

    public function mGetBlogsDetails() {
        $blogId = FILTER_VAR(trim($this->input->post('blogId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId'])) {
            return '{"status":"error","msg":"Un authorised Access!"}';
        }
        $condition = ($blogId ? "AND tb.userId=" . $_SESSION['loginId'] . " AND tb.blogId=$blogId" : " AND tb.userId=" . $_SESSION['loginId'] . "");
        $result = $this->db->query("SELECT tb.blogId,tb.blogcatId,tb.blogTitle,tb.blogImage,tb.blogDesp,tb.userType
                        ,CONCAT(od.orgName,' (',DATE_FORMAT(tb.createdAt,'%d-%b-%y'),')') addedBy,tbc.catName,tb.blogStatus FROM tbl_blog tb
                        INNER JOIN tbl_blog_cat tbc ON tbc.catId=tb.blogcatId  INNER JOIN login_details ld ON ld.id=tb.userId AND tb.userType=ld.roleName
                        INNER JOIN organization_details od ON od.loginId=ld.id   WHERE tb.isactive=1 $condition ");

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $rs) {
                $rs->blogDesp = ($blogId == "" ? substr(strip_tags($rs->blogDesp), 0, 50) : $rs->blogDesp);
            }
            $response = $result->result();
        } else {
            $response = '';
        }
        return json_encode($response);
    }

    public function mDelBlog() {
        $blogId = FILTER_VAR(trim($this->input->post('blogId')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId']) || empty($blogId)) {
            return '{"status":"error","msg":"Required Fields are empty!"}';
        }
        $chk = $this->db->where(["blogId" => $blogId, "isactive" => 1])->get("tbl_blog");
        if ($chk->num_rows() > 0) {
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $resp = $this->db->where(["blogId" => $blogId, "isactive" => 1])->update("tbl_blog", $udata);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Blog details Deleted", "tbl_blog", "0") : "" );
            return($resp ? '{"status":"success","msg":"Deleted successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
        } else {
            return( $resp ? '{"status":"success","msg":"No records found!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}' );
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
            $config = ['image_library' => "gd2", 'source_image' => $path . $newImage,
                'new_image' => $path . $newImage, "create_thumb" => false, "maintain_ratio" => true, "quality" => 100, "width" => $size];
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
    //Notifications Start
    public function mGetNotification() {
        $totalDataqry = $this->mgetAllNotifications('total');
        $totalData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->num_rows() : 0);

        $query = (empty($this->input->post('search')['value']) ? $this->mgetAllNotifications('nosearch') : $this->mgetAllNotifications('search'));
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $totalFiltered = (empty($this->input->post('search')['value']) ? $totalData : $this->mgetAllEnrollments('searchtotal')->num_rows());

        $data = array();
        if (!empty($posts)) {
            $i = ($this->input->post('start') == 0 ? 1 : $this->input->post('start'));
            foreach ($posts as $dt) { //.' ('.$dt->courseType.') '.$dt->departmentName
                ($dt->isRead == 0 ? $this->markRead($dt->notificationId) : "");
                $action = '<button type="button" onclick="sendNotificationMessage(\'' . base64_encode($dt->id) . '\');" class="btn btn-primary btn-xs">Send Messsage</button>';
                $data[] = ["MessageId" => $i++, "Message" => $dt->message, "SentBy" => $dt->SentBy, "InRefence" => $dt->reference,
                    "NotificationStatus" => ($dt->isRead ? "Read On " . $dt->readdate : "Not Read"), "Action" => $action];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }

    private function markRead($notificationId) {
        if ($notificationId) {
            $idata = ["isRead" => 1, "readDate" => $this->datetimenow(), "ipAddressReceiver" => $this->getRealIpAddr()];
            $this->db->where(["notificationId" => $notificationId, "isRead" => 0, "notificationFor" => $_SESSION['loginId']])->update("tbl_notifications", $idata);
        }
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

        return $this->db->query("SELECT tn.notificationId,tn.message,ld.id,tn.isRead,DATE_FORMAT(tn.readDate,'%W %M %e %Y') readdate,
                                    CONCAT(ld.userName,' On ',DATE_FORMAT(tn.createdAt,'%W %M %e %Y')) SentBy,tn.reference
                                    FROM tbl_notifications tn
                                    INNER JOIN web_users ld ON ld.id=tn.sentBy AND tn.senderTableName='web_users'

                                    INNER JOIN organization_details od ON od.loginId=tn.notificationFor AND tableName='organization_details'
                                    WHERE tn.notificationFor=" . $_SESSION['loginId'] . " AND tn.tableName='organization_details' $conditions");
    }

    public function mSendNotifications($reference, $message, $emailSend, $orgIds) {

        if (!isset($_SESSION['loginId']) || empty($reference) || empty($message) || empty($orgIds)) {
            return '{"status":"error","msg":"Required details are empty."}';
        }
        $adminid = base64_decode($orgIds);
        $chk = $this->db->query("SELECT wu.userName orgName,wu.userEmail email FROM web_users wu WHERE wu.id=$adminid");
        if ($chk->num_rows() > 0) {

            $idata = ["message" => $message, "notificationFor" => $adminid, "tableName" => "web_users", "sentBy" => $_SESSION['orgId'], "senderTableName" => "organization_details", "isRead" => 0, "reference" => $reference];
            $chkDuplicate = $this->db->where($idata)->get("tbl_notifications");
            if ($chkDuplicate->num_rows() > 0) {
                return '{"status":"error","msg":"Duplicate details."}';
            } else {
                $insdata = ["createdAt" => $this->datetimenow(), "ipAddressSender" => $this->getRealIpAddr(), "isactive" => 1];
                $res = $this->db->insert("tbl_notifications", array_merge($idata, $insdata));
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Notification Message sent to " . $chk->row()->orgName . " ", "web_users") : "");
                ($res ? ($emailSend == 1 ? $this->sendEmail($chk->row()->email, $message, $reference, "iHuntBest") : "") : "");
                return ($res ? '{"status":"success","msg":" Notification sent successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            }
        }
    }

    //Notifications End
    private function addActivityLog($user_id, $activity, $act_table, $isadmin) {
        $idata = ["user_id" => $user_id, "activity" => $activity, "act_table" => $act_table, "date" => date('Y-m-d'), "isadmin" => 0,
            "role_name" => "University", "created_at" => $this->datetimenow(), "ip_address" => $this->getRealIpAddr(), "isactive" => 1];
        $this->db->insert("activity_log", $idata);
    }

    public function datetimenow() {
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $todaydate = $date->format('Y-m-d H:i:s');
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

    private function createDirectory($path) {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
            return 'created';
        } else {
            return 'present';
        }
    }

    private function waterMarkingImage($imagename, $path) {
        $config['source_image'] = $path . '/' . $imagename;
        $config['wm_text'] = 'Copyright ' . date("Y") . ' - iHuntBest.com';
        $config['wm_type'] = 'text';
        $config['wm_font_path'] = './system/fonts/texb.ttf';
        $config['wm_font_size'] = '16';
        $config['wm_font_color'] = '000000';
        $config['wm_vrt_alignment'] = 'center';
        $config['wm_hor_alignment'] = 'left';
        $config['wm_vrt_offset'] = '30';
        $config['wm_padding'] = '10';
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->load->library('image_lib', $config);
        if (!$this->image_lib->watermark()) {
            $erro = $this->image_lib->display_errors();
        }
    }

    private function uploadImageCustom($path, $imgName, $uploadfname, $width) {
        $config['upload_path'] = $path;
        $config['allowed_types'] = "gif|jpg|png|jpeg|JPG|JPEG|PNG|GIF";
        $config['file_name'] = $imgName;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($uploadfname) == false) {
//            $error = array('error' => $this->upload->display_errors());
            return 'error';
        } else {
            $data = $this->upload->data();
            $newImage = $data['file_name'];
            $filename = $_FILES[$uploadfname]["name"];
            $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
            if ($file_ext == 'GIF' || 'gif') {
                return $newImage;
            } else {
                return $this->ImageResize($path, $newImage, $width);
            }
        }
    }

    private function ImageResize($path, $newImage, $width) {
        $config = ['image_library' => "gd2", 'source_image' => $path . '/' . $newImage,
            'new_image' => $path . '/' . $newImage, "create_thumb" => false, "maintain_ratio" => true, "quality" => 100, "width" => $width];
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->load->library('image_lib', $config);
        if (!$this->image_lib->resize()) {
            //$erro = $this->image_lib->display_errors();

            return "error";
        } else {
            $this->waterMarkingImage($newImage, $path);
            return $newImage;
        }
    }

}
