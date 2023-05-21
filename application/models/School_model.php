<?php

//developed by Manish Verma Starling softwares
defined('BASEPATH') OR exit('No direct script access allowed');

class School_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
    }

    //Dashboard Details Start
    public function mgetDashboardDetails() {
        $qry = $this->db->query("SELECT (SELECT COUNT(*)  FROM faculty_details WHERE loginId=" . $_SESSION['loginId'] . " and isactive=1) AS totalemployees,
                                    (SELECT COUNT(*) FROM pages WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totalpages,(SELECT COUNT(*) FROM school_class_details WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as classes,
                                    (SELECT COUNT(*) FROM brouchers WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totalbrochures,(SELECT COUNT(*) FROM gallery WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totalimages,
                                    (SELECT COUNT(*) FROM event_details WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totalevents,(SELECT COUNT(*) FROM news WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totalnews,
                                    (SELECT COUNT(*) FROM achievement WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totalachievements,(SELECT COUNT(*) FROM running_status WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totalrunning_status,
                                    (SELECT COUNT(*) FROM advertisement WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totaladvertisement,
                                    (SELECT COUNT(*) FROM tbl_orgapproval_doc WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as totaldocs,
                                    (SELECT ld.visitorCount  FROM login_details ld WHERE ld.id=" . $_SESSION['loginId'] . ") visitorCount,
                                    (SELECT COUNT(*) FROM tbl_news_ltr_plan_buy WHERE loginId=" . $_SESSION['loginId'] . " AND isactive=1) as nlpbuy,
                                    (SELECT COUNT(*) FROM tbl_enroll te INNER JOIN school_class_details scd ON scd.sClassId=te.sClassId
                                    WHERE scd.loginId=" . $_SESSION['loginId'] . " AND scd.isactive=1 AND te.isactive=1) totalenrollments,
                                    (SELECT COUNT(*) FROM tbl_promocodedetails pcd INNER JOIN school_class_details scd ON scd.sClassId=pcd.sClassId
                                    WHERE scd.loginId=" . $_SESSION['loginId'] . " AND scd.isactive=1 AND pcd.isactive=1) promoCodes,
                                    (SELECT COUNT(*) FROM tbl_testimonial WHERE userId=" . $_SESSION['loginId'] . " AND isActive=1) as testimonials,
                                    (SELECT COUNT(*) FROM tbl_blog WHERE userId=" . $_SESSION['loginId'] . " AND isactive=1) as blogs  ");
        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return false;
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

    //Dashboard Details End
    //School profile Start
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
                $this->addActivityLog($_SESSION['loginId'], "Profile Image Updated by " . $_SESSION['orgName'] . "", "organization_details", "0");
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
                $this->addActivityLog($_SESSION['loginId'], "Header Image Updated by " . $_SESSION['orgName'] . "", "organization_details", "0");
                $this->removeImage($prevImg, 'projectimages/images/profile/headerImage/');
                return "updated";
            } else {
                return "notupdated";
            }
        }
    }

    public function getOrgFacilities($status) {
        $id = $_SESSION['loginId'];
        $qry = $this->db->query("SELECT fac.* ,omf.mappingId FROM facilities fac
            LEFT JOIN org_mapping_facilities omf ON omf.facilityId=fac.facilityId AND omf.loginId=$id AND fac.isactive=1
            WHERE fac.facility_status=$status AND fac.isactive=1 order by fac.facilityId");
        if ($qry->num_rows() > 0) {
            return $qry->result();
        } else {
            return false;
        }
    }

    public function msaveProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType, $orgGoogle, $orgWebsite) {
        $approvedBy = FILTER_VAR(trim($this->input->post('approvedBy')), FILTER_SANITIZE_STRING);
        $orgaddress = FILTER_VAR(trim($this->input->post('address1')), FILTER_SANITIZE_STRING);
        $orgDesp = $this->input->post('orgDesp');
        $orgMission = $this->input->post('orgMission');
        $orgVission = $this->input->post('orgVission');
        $org_landline = FILTER_VAR(trim($this->input->post('org_landline')), FILTER_SANITIZE_NUMBER_INT);
        $orgEstablished = FILTER_VAR(trim($this->input->post('orgEstablished')), FILTER_SANITIZE_STRING);
        $this->mSaveFinancialDetails("notshowmessage");
        if (empty($directorName) || empty($directorMobile) || empty($directorEmail) || empty($orgName) || empty($orgMobile) || empty($countryId) ||
                empty($stateId) || empty($cityId) || empty($orgType) || empty($orgWebsite) || empty($approvedBy) || empty($orgaddress) ||
                !isset($_SESSION['loginId'])) {
            return '{"status":"error","msg":"Required field is empty!"}';
        } else {
            $data = ["loginId" => $_SESSION['loginId'], "directorName" => $directorName, "orgName" => $orgName, "directorMobile" => $directorMobile, "directorEmail" => $directorEmail, "orgMobile" => $orgMobile, "org_landline" => $org_landline,
                "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "orgType" => $orgType, "orgGoogle" => $orgGoogle, "orgWebsite" => $orgWebsite, "orgEstablished" => $orgEstablished,
                "approvedBy" => $approvedBy, "orgAddress" => $orgaddress, "orgDesp" => $orgDesp, "orgMission" => $orgMission, "orgVission" => $orgVission, "orgUpdated" => $this->datetimenow()];

            $response = $this->db->where("loginId", $_SESSION['loginId'])->update("organization_details", $data);
            ($response ? $this->addActivityLog($_SESSION['loginId'], "Organization Profile Updated by " . $_SESSION['orgName'] . "", "organization_details", "0") : "");
            return ($response ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mupdateProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType, $orgGoogle, $orgWebsite, $approvedBy, $orgaddress, $facility) {
        $orgDesp = $this->input->post('orgDesp');
        $orgMission = $this->input->post('orgMission');
        $orgVission = $this->input->post('orgVission');
        $org_landline = FILTER_VAR(trim($this->input->post('org_landline')), FILTER_SANITIZE_NUMBER_INT);
        $orgEstablished = FILTER_VAR(trim($this->input->post('orgEstablished')), FILTER_SANITIZE_STRING);
        if (empty($directorName) || empty($directorMobile) || empty($directorEmail) || empty($orgName) || empty($orgMobile) || empty($countryId) ||
                empty($stateId) || empty($cityId) || empty($orgType) || empty($orgWebsite) || empty($approvedBy) || empty($orgaddress) || empty($orgDesp) || empty($orgMission) || empty($orgVission) || !isset($_SESSION['loginId'])) {
            return '{"status":"error","msg":"Required field is empty!"}';
        } else {
            $data = ["orgName" => $orgName, "directorName" => $directorName, "directorMobile" => $directorMobile, "directorEmail" => $directorEmail, "orgMobile" => $orgMobile, "org_landline" => $org_landline,
                "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "orgType" => $orgType, "orgGoogle" => $orgGoogle, "orgWebsite" => $orgWebsite, "orgEstablished" => $orgEstablished,
                "approvedBy" => $approvedBy, "orgAddress" => $orgaddress, "orgDesp" => $orgDesp, "orgMission" => $orgMission, "orgVission" => $orgVission, "orgUpdated" => $this->datetimenow()];

            $response = $this->db->where("loginId", $_SESSION['loginId'])->update("organization_details", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Organization Profile Updated by " . $_SESSION['orgName'] . "", "organization_details", "0");

                $response = $this->db->where("loginId", $_SESSION['loginId'])->update("org_mapping_facilities", ["isactive" => 0]);
            }

            ($response ? $this->updatefacilities($facility, $_SESSION['loginId']) : "");
            return ($response ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
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
        if (empty($bank_name) || empty($accountType) || empty($account_holder_name) || empty($baddress) || empty($accno) || empty($ifscc) || empty($defaultCur) || empty($micrc)) {
            return '{"status":"error","msg":"Required field is empty"}';
        } else {
            $_SESSION['dCurrency'] = $defaultCur;
        }
        return ($id == "no_data" ? $this->insertFinancialDetails($ccardno, $dcardno, $bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $accountType) :
                $this->upDateFinancialDetails($id, $ccardno, $dcardno, $bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $accountType));
    }

    public function mGetcurrencies() {
        return $this->db->query("SELECT * FROM currencies");
    }

    public function insertFinancialDetails($ccardno, $dcardno, $bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $accountType) {

        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "School"])->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            $data = $details->row();
            $id = $data->financial_detail_id;
            return $this->upDateFinancialDetails($id, $ccardno, $dcardno, $bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $accountType);
        } else {
            $ccardno = ($ccardno === "" ? NULL : $this->encryption->encrypt($ccardno));
//            $cccvvno = ($cccvvno === "" ? NULL : $this->encryption->encrypt($cccvvno));
            $dcardno = ($dcardno === "" ? NULL : $this->encryption->encrypt($dcardno));
//            $dcardcvv = ($dcardcvv === "" ? NULL : $this->encryption->encrypt($dcardcvv));
            $accno = ($accno === "" ? NULL : $this->encryption->encrypt($accno));
            $idata = ["credit_card_no" => $ccardno, "accountType" => $accountType, "debit_card_no" => $dcardno,
                "bank_name" => $bank_name, "bankaddress" => $baddress, "bank_account_no" => $accno, "account_holder_name" => $account_holder_name, "ifscCode" => $ifscc, "micr_code" => $micrc,
                "login_id" => $_SESSION['loginId'], "user_type" => "School", "defaultCurrency" => $defaultCur, "ip_address" => $this->getRealIpAddr(), "created_on" => $this->datetimenow(), "isactive" => 1];
            $resp = $this->db->insert("tbl_financial_details", $idata);
        }
        ($resp ? $this->addActivityLog($_SESSION['loginId'], "Finance Detail Inserted for School by " . $_SESSION['orgName'], "tbl_financial_details", "0") : '');
        return ($respond == "showmessage" ? ($resp != "" ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}') : "");
    }

    public function upDateFinancialDetails($id, $ccardno, $dcardno, $bank_name, $baddress, $accno, $ifscc, $micrc, $defaultCur, $respond, $account_holder_name, $accountType) {
        $details = $this->db->where(["financial_detail_id!=" => $id, "login_id" => $_SESSION['loginId'], "user_type" => "School"])->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate details"}';
        } else {
            $ccardno = ($ccardno === "" ? NULL : $this->encryption->encrypt($ccardno));
            //$cccvvno = ($cccvvno === "" ? NULL : $this->encryption->encrypt($cccvvno));
            $dcardno = ($dcardno === "" ? NULL : $this->encryption->encrypt($dcardno));
            //$dcardcvv = ($dcardcvv === "" ? NULL : $this->encryption->encrypt($dcardcvv));
            $accno = ($accno === "" ? NULL : $this->encryption->encrypt($accno));
            $idata = ["credit_card_no" => $ccardno, "debit_card_no" => $dcardno, "accountType" => $accountType,
                "bank_name" => $bank_name, "bankaddress" => $baddress, "bank_account_no" => $accno, "account_holder_name" => $account_holder_name, "ifscCode" => $ifscc, "micr_code" => $micrc,
                "login_id" => $_SESSION['loginId'], "defaultCurrency" => $defaultCur, "ip_address" => $this->getRealIpAddr(), "updated_on" => $this->datetimenow()];

            $resp = $this->db->where("financial_detail_id", $id)->update("tbl_financial_details", $idata);
        }
        ($resp ? $this->addActivityLog($_SESSION['loginId'], "Finance Detail Updated for School by " . $_SESSION['orgName'], "tbl_financial_details", "0") : "");
        return ($respond == "showmessage" ? ($resp != "" ? '{"status":"success","msg":"Saved Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}') : "");
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

    public function insertConcernedPersonDetails($loginId, $cp_name, $gender, $cp_email, $cp_contact, $cp_alt_contact, $cp_position, $cp_address) {
        $cData = ["loginId" => $loginId, "isactive" => 1];
        $this->db->where($cData);
        $chk = $this->db->get("org_concerned_person");
        if ($chk->num_rows() > 2) {
            return '{"status":"error", "msg":"Only three can be there."}';
        } else {
            $iData = ["loginId" => $loginId, "cp_name" => $cp_name, "gender" => $gender, "cp_email" => $cp_email, "cp_contact" => $cp_contact, "cp_alt_contact" => $cp_alt_contact
                , "cp_position" => $cp_position, "cp_address" => $cp_address, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("org_concerned_person", $iData);
        }
        if ($res) {
            return '{"status":"success", "msg":"Saved Successfully"}';
        } else {
            return '{"status":"error", "msg":"Error in server, please contact admin!"}';
        }
    }

    public function updateConcernedPersonDetails($loginId, $cp_Id, $cp_name, $gender, $cp_email, $cp_contact, $cp_alt_contact, $cp_position, $cp_address) {
        $cData = ["loginId" => $loginId, "cp_Id" => $cp_Id, "isactive" => 1];
        $chk = $this->db->where($cData)->get("org_concerned_person");
        if ($chk->num_rows() > 0) {
            $iData = ["cp_name" => $cp_name, "gender" => $gender, "cp_email" => $cp_email, "cp_contact" => $cp_contact, "cp_alt_contact" => $cp_alt_contact
                , "cp_position" => $cp_position, "cp_address" => $cp_address, "updatedAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->where($cData)->update("org_concerned_person", $iData);
        } else {
            $this->insertConcernedPersonDetails($loginId, $cp_name, $gender, $cp_email, $cp_contact, $cp_alt_contact, $cp_position, $cp_address);
        }
        if ($res) {
            return '{"status":"success", "msg":"Saved Successfully"}';
        } else {
            return '{"status":"error", "msg":"Error in server, please contact admin!"}';
        }
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
        }if ($type == "video") {
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

    //profile End
    //addPages start
    public function mshowPages() {
        $orgId = $_SESSION['loginId'];
        $pageId = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        $condition = ($pageId != "" ? " AND pageId =" . base64_decode($pageId) . " AND isactive=1" : " AND isactive=1");

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
        return ($chkduplicate->num_rows() > 0 ? '{"status":"error","msg":"Duplicate Entry!"}' : $this->mAddUpdateNewPages($pageId, $orgId, $pageName, $description, $timenow));
    }

    private function mAddUpdateNewPages($pageId, $orgId, $pageName, $description, $timenow) {
        if ($pageId == 'no_one') {
            $iData = ["loginId" => $orgId, "pageName" => $pageName, "description" => $description, "createdAt" => $timenow, "isactive" => 1];
            $response = $this->db->insert("pages", $iData);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Page Inserted by " . $_SESSION['orgName'] . "", "pages", "0");
                return '{"status":"success","msg":"Added Successfully"}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        } else {
            $uData = ["pageName" => $pageName, "description" => $description, "updatedAt" => $timenow];
            $this->db->where("pageId", $pageId);
            $response = $this->db->update("pages", $uData);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "Page Updated", "pages", "0");
                return '{"status":"success","msg":"Saved Successfully"}';
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
    public function mgetcourseTypeBycourse() {
        $ctId = FILTER_VAR(trim($this->input->post('ctId')), FILTER_SANITIZE_STRING);
        if ($ctId) {
            $condition = " AND ctId=$ctId";
        } else {
            $condition = "";
        }
        return $this->db->query("SELECT * FROM  course_details WHERE isactive=1 $condition order by title desc");
    }

    public function mGetMinQualification() {
        if (!isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Unauthorised access!"}';
        }
        $qry = $this->db->query("SELECT tcn.classnamesId courseId,tcn.classTitle courseName,'tbl_classnames' as tablename,'Class Name'  courseCategory  FROM tbl_classnames tcn WHERE tcn.isactive=1
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

    public function mGetClassNames() {
        if (!isset($_SESSION['loginId'])) {
            return '{"status":"error", "msg":"Unauthorised access!"}';
        }
        $qry = $this->db->where('isactive', 1)->get('tbl_classnames');
        $result = ($qry->num_rows() > 0 ? $qry->result() : "");
        return json_encode($result);
    }

    public function maddSaveClasses($class, $classType, $courseDurationType, $courseFee, $feeCycle, $totalSheet, $availableSheet, $registrationFee, $fromDate, $toDate, $openingDate, $closingDate, $applicationFee, $minage, $maxage, $validupto) {
        $examMode = FILTER_VAR(trim($this->input->post('examMode')), FILTER_SANITIZE_STRING);
        $examDetails = FILTER_VAR(trim($this->input->post('examDetails')), FILTER_SANITIZE_STRING);
        $examDate = FILTER_VAR(trim($this->input->post('examDate')), FILTER_SANITIZE_STRING);
        $resultDate = FILTER_VAR(trim($this->input->post('examDate')), FILTER_SANITIZE_STRING);
        $sClassId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $datetimenow = $this->datetimenow();
        $checkStatus = $this->checkValidations($maxage, $minage, $totalSheet, $availableSheet, $fromDate, $toDate, $openingDate, $closingDate, $examDate, $resultDate);
        if ($checkStatus !== "ok") {
            return $checkStatus;
        }
        if (!isset($_SESSION['loginId']) || empty($class) || empty($feeCycle) || empty($courseFee) || empty($totalSheet) || empty($availableSheet) || empty($sClassId) || empty($applicationFee)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        } else {
            return ($sClassId == 'no_one' ? $this->addNewClass($_SESSION['loginId'], $class, $courseFee, $totalSheet, $availableSheet, $datetimenow, $classType, $courseDurationType, $registrationFee, $fromDate, $toDate, $openingDate, $closingDate, $feeCycle, $applicationFee, $minage, $maxage, $validupto, $examMode, $examDetails, $examDate, $resultDate) :
                    $this->upDateClass($_SESSION['loginId'], base64_decode($sClassId), $class, $courseFee, $totalSheet, $availableSheet, $datetimenow, $classType, $courseDurationType, $registrationFee, $fromDate, $toDate, $openingDate, $closingDate, $feeCycle, $applicationFee, $minage, $maxage, $validupto, $examMode, $examDetails, $examDate, $resultDate));
        }
    }

    private function checkValidations($maxage, $minage, $totalSheet, $availableSheet, $fromDate, $toDate, $openingDate, $closingDate, $examDate, $resultDate) {
        if ($maxage < $minage) {
            return '{"status":"error","msg":"Min age is less than max age.!"}';
        } else if ($totalSheet < $availableSheet) {
            return '{"status":"error","msg":"Total seats is less than available seats.!"}';
        } else if (strtotime($fromDate) > strtotime($toDate)) {
            return '{"status":"error","msg":"Fee Submit Start Date is less than Fee Submit End Date.!"}';
        } else if (strtotime($openingDate) > strtotime($closingDate)) {
            return '{"status":"error","msg":"Application Start Date is less than Application  End Date.!"}';
        } else if (strtotime($resultDate) > strtotime($examDate)) {
            return '{"status":"error","msg":"Exam Date is less than Result Date.!"}';
        } else {
            return 'ok';
        }
    }

    private function addNewClass($loginId, $class, $courseFee, $totalSheet, $availableSheet, $datetimenow, $classType, $courseDurationType, $registrationFee, $fromDate, $toDate, $openingDate, $closingDate, $feeCycle, $applicationFee, $minage, $maxage, $validupto, $examMode, $examDetails, $examDate, $resultDate) {
        $chkData = ["loginId" => $loginId, "class" => $class, "courseFee" => $courseFee, "totalSheet" => $totalSheet,
            "availableSheet" => $availableSheet, "isactive" => 1];

        $duplicate = $this->db->where($chkData)->get("school_class_details");
        if ($duplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            $iData = ["loginId" => $loginId, "class" => $class, "courseFee" => $courseFee, "totalSheet" => $totalSheet, "classTypeId" => $classType, "availableSheet" => $availableSheet, "registrationFee" => $registrationFee,
                "feecycleId" => $feeCycle, "applicationFee" => $applicationFee, "minAge" => $minage, "maxAge" => $maxage, "ageValidDate" => $validupto, "examMode" => $examMode, "examDetails" => $examDetails, "resultDate" => $resultDate,
                "courseDurationType" => $courseDurationType, "feepaySdate" => $fromDate, "feepayEdate" => $toDate, "applyFrom" => $openingDate, "applyTo" => $closingDate, 'examDate' => $examDate, "createdAt" => $datetimenow, "isactive" => 1];
            $res = $this->db->insert("school_class_details", $iData);
            $sClassId = $this->db->insert_id();
            ($res ? $this->addActivityLog($_SESSION['loginId'], "School Class Details Inserted by " . $_SESSION['orgName'] . "", "school_class_details", "0") : '');
            ($res ? $this->insertUpdateMinQualification($sClassId) : '');
            return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    private function insertUpdateMinQualification($sClassId) {
        $min_qualification = $this->input->post("min_qualification");
        $min_percentage = $this->input->post("min_percentage");
        $min_qualificationStream = $this->input->post("min_qualificationStream");
        $markingType = $this->input->post("markingType");
        $condition = $this->input->post("condition");
        if ($min_qualification[0] == "") {
            return false;
        }
        $chk = $this->db->where("sClassId", $sClassId)->get("orgcourse_mapping_prerequisites");
        if ($chk->num_rows() > 0) {
            $this->db->where("sClassId", $sClassId)->update("orgcourse_mapping_prerequisites", ["isactive" => 0]);
        }
        for ($mq = 0; $mq < count($min_qualification); $mq++) {
            $this->minsertUpdatePrerequisites($mq, $min_qualification, $min_qualificationStream, $condition, $sClassId, $min_percentage, $markingType);
        }
        return true;
    }

    private function minsertUpdatePrerequisites($mq, $min_qualification, $min_qualificationStream, $condition, $sClassId, $min_percentage, $markingType) {
        $coursetablename = explode(",", $min_qualification[$mq]);
        $courseId = (count($coursetablename) > 1 ? $coursetablename[0] : "");
        $tablename = (count($coursetablename) > 1 ? $coursetablename[1] : "");
        $Streamtablename = explode(",", $min_qualificationStream[$mq]);
        $SteamId = (count($Streamtablename) > 1 ? $Streamtablename[0] : "");
        $Stablename = (count($Streamtablename) > 1 ? $Streamtablename[1] : "");

        $realtion = ($condition != "" ? (array_key_exists($mq, $condition) ? $condition[$mq] : "") : "");
        $chkomp = $this->db->where(["sClassId" => $sClassId, "isactive" => 0])->get("orgcourse_mapping_prerequisites");
        if ($chkomp->num_rows() > 0) {
            $udata = ["sClassId" => $sClassId, "courseMinQualId" => $courseId, "tableName" => $tablename, "percentage" => $min_percentage[$mq], "minqualstreamId" => $SteamId, "streamTableName" => $Stablename,
                "markingType" => $markingType[$mq], "relationType" => $realtion, "updatedAt" => $this->datetimenow(), "isactive" => 1];
            $rowData = $chkomp->row();
            $this->db->where("prerequisitesId", $rowData->prerequisitesId)->update("orgcourse_mapping_prerequisites", $udata);
        } else {
            $mpData = ["sClassId" => $sClassId, "courseMinQualId" => $courseId, "tableName" => $tablename, "percentage" => $min_percentage[$mq], "minqualstreamId" => $SteamId, "streamTableName" => $Stablename,
                "markingType" => $markingType[$mq], "relationType" => $realtion, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $this->db->insert("orgcourse_mapping_prerequisites", $mpData);
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
            return ($response ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    private function upDateClass($loginId, $sClassId, $class, $courseFee, $totalSheet, $availableSheet, $datetimenow, $classType, $courseDurationType, $registrationFee, $fromDate, $toDate, $openingDate, $closingDate, $feeCycle, $applicationFee, $minage, $maxage, $validupto, $examMode, $examDetails, $examDate, $resultDate) {
        $chkData = ["sClassId!=" => $sClassId, "loginId" => $loginId, "class" => $class, "courseFee" => $courseFee, "totalSheet" => $totalSheet, "availableSheet" => $availableSheet, "isactive" => 1];
        $duplicate = $this->db->where($chkData)->get("school_class_details");
        if ($duplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            $uData = ["class" => $class, "courseFee" => $courseFee, "totalSheet" => $totalSheet, "availableSheet" => $availableSheet, "classTypeId" => $classType, "registrationFee" => $registrationFee,
                "feecycleId" => $feeCycle, "applicationFee" => $applicationFee, "minAge" => $minage, "maxAge" => $maxage, "ageValidDate" => $validupto, "examMode" => $examMode, "examDetails" => $examDetails, "resultDate" => $resultDate,
                "courseDurationType" => $courseDurationType, "feepaySdate" => $fromDate, "feepayEdate" => $toDate, "applyFrom" => $openingDate, "applyTo" => $closingDate, 'examDate' => $examDate, "updatedAt" => $datetimenow];
            $uWhere = ["sClassId" => $sClassId, "loginId" => $loginId, "isactive" => 1];

            $res = $this->db->where($uWhere)->update("school_class_details", $uData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "School Class Details Updated by " . $_SESSION['orgName'] . "", "school_class_details", "0") : '');
            ($res ? $this->insertUpdateMinQualification($sClassId) : '');
            return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mGetClasses() {
        $sClassId = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        $loginId = $_SESSION['loginId'];
        $condition = ($sClassId ? "AND scd.sClassId ='" . base64_decode($sClassId) . "'" : "");
        $qry = $this->db->query("SELECT scd.*, sct.*,DATE_FORMAT(scd.applyFrom ,'%d-%b-%Y') applysdate,'' streamNames,GROUP_CONCAT(CONCAT(omp.minqualstreamId,',',omp.streamTableName) SEPARATOR '^') streamTable,omp.relationType,
                                    DATE_FORMAT(scd.applyTo ,'%d-%b-%Y') applyedate, DATE_FORMAT(scd.feepaySdate ,'%d-%b-%Y') feesdate,scd.courseDurationType,GROUP_CONCAT(omp.markingType) markingTypes,
                                    DATE_FORMAT(scd.feepayEdate ,'%d-%b-%Y') feeEdate,DATE_FORMAT(scd.examDate ,'%d-%b-%Y') exmdate,GROUP_CONCAT(omp.minqualstreamId) minqualstreamIds,
                                    GROUP_CONCAT(CONCAT(omp.courseMinQualId,',',omp.tableName) SEPARATOR '^') minQualification,GROUP_CONCAT(omp.percentage) percentages
                                    FROM school_class_details scd
                                    INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId AND sct.isactive=1
                                    LEFT JOIN orgcourse_mapping_prerequisites omp ON omp.sClassId=scd.sClassId AND omp.isactive=1
                                    WHERE scd.loginId=$loginId $condition AND scd.isactive=1 GROUP BY scd.sClassId ORDER by scd.sClassId DESC");

        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $rs) {
                $rs->sClassId = base64_encode($rs->sClassId);
                $rs->streamNames = ($rs->minQualification != "" ? $this->streamName($rs->minQualification, $rs->minqualstreamIds) : "");
            }
        }
        return json_encode($qry->result());
    }

    private function streamName($minQualification, $streamIds) {

        $sIdtablearr = explode("^", $minQualification);
        $streamIdsarr = explode(",", $streamIds);
        $result = "";
        $i = 0;
        for ($i = 0; $i < count($sIdtablearr); $i++) {
            $arrsId = explode(",", $sIdtablearr[$i]);
            if (count($arrsId) == 2) {
                $courseId = $arrsId[0];
                $tableName = $arrsId[1];
            }
            if ($tableName === "tbl_classnames") {
                $qry = $this->db->query("SELECT title streamTitle FROM school_class_type WHERE classTypeId=" . $streamIdsarr[$i] . " AND classnamesId=" . $courseId . " AND isactive=1");
                $result = $result . ($qry->num_rows() > 0 ? $qry->row()->streamTitle : "") . ",";
            } else if ($tableName === "tbl_competitive_exam_master" || $tableName === "tbl_subjectmaster") {
                $result = $result . "Not Available" . ",";
            } else {
                $result = $result . "" . ",";
            }
        }

        return $result;
    }

    public function mdeleteClasses() {
        $loginId = $_SESSION['loginId'];
        $sClassIds = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $sClassId = base64_decode($sClassIds);
        $chk = $this->db->query("SELECT * from school_class_details where sClassId=$sClassId AND loginId=$loginId and isactive=1");
        if ($chk->num_rows() > 0) {
            $data = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $this->db->where("sClassId", $sClassId);
            $response = $this->db->update("school_class_details", $data);
            if ($response) {
                $this->addActivityLog($_SESSION['loginId'], "School Class Details Deleted by " . $_SESSION['orgName'] . "", "school_class_details", "0");
                return '{"status":"success", "msg":"Deletion Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Invalid Id!"}';
        }
    }

    //addCourse end
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
        $timenow = $this->datetimenow();
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
                $resp = $this->addNewBrouchers($response, $_SESSION['loginId'], $timenow, $broucherIds, $title);
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
        $loginId = $_SESSION['loginId'];
        $broucherId = base64_decode($broucherIds);
        $timenow = $this->datetimenow();
        if (empty($broucherId) || empty($loginId)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $chData = ["loginId" => $loginId, "broucherId" => $broucherId, "isactive" => 1];

            $gData = $this->db->where($chData)->get("brouchers");
            if ($gData) {
                $delData = ["updatedAt" => $timenow, "isactive" => 0];

                $res = $this->db->where($chData)->update("brouchers", $delData);
                $this->addActivityLog($_SESSION['loginId'], "Brochure Deleted by " . $_SESSION['orgName'] . "", "brouchers", "0");
                return ($res !== "" ? '{"status":"success", "msg":"Deletion Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
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
            $this->db->where($gData);
            $ffile = $this->db->get("gallery");
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
        $loginId = $_SESSION['loginId'];
        if (empty($loginId) || empty($image)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            $path = './projectimages/images/gallery/image';
            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
            $todaydate = $date->format('YmdHisA');
            $imgName = $_SESSION['orgName'] . $todaydate . $image;
            $response = $this->uploadImage($path, $imgName, 'galaryUrl');
            if ($response != "error") {
                $imgPath = 'projectimages/images/gallery/image/' . $response;
                $iData = ["loginId" => $loginId, "galaryUrl" => $imgPath, "imgPath" => $imgPath, "createdAt" => $this->datetimenow(), "isactive" => 1];
                $res = $this->db->insert("gallery", $iData);
                $this->addActivityLog($_SESSION['loginId'], "Gallery Image Inserted by " . $_SESSION['orgName'] . "", "gallery", "0");
                return ($res != "" ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
            } else {
                return '{"status":"error", "msg":"Error in image uploading!"}';
            }
        }
    }

    //Gallery End
    //Event Start
    public function maddEvent() {
        $loginId = $_SESSION['loginId'];
        if (isset($_FILES['eventImage']['name'])) {
            $image = preg_replace("/\s+/", "_", $_FILES['eventImage']['name']);
        } else {
            $image = "";
        }
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
        $this->db->where($dData);
        $chkDuplicate = $this->db->get("event_details");
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
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Event Details Inserted by " . $_SESSION['orgName'] . "", "event_details", "0") : "");
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
            $iData = ["loginId" => $loginId, "eventImage" => $response, "eventTitle" => $eventTitle, "description" => $description,
                "location" => $address, "updatedAt" => $this->datetimenow(), "isactive" => 1];

            $res = $this->db->where(["eventId=" => $eventId, "loginId" => $loginId])->update("event_details", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Event Details Updated by " . $_SESSION['orgName'] . "", "event_details", "0") : "");
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mgetEvents() {
        $loginId = $_SESSION['loginId'];
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($ed) && !empty($loginId)) {
            $getData = ["loginId" => $loginId, "eventId" => base64_decode($ed), "isactive" => 1];
            $this->db->where($getData);
            $response = $this->db->get("event_details");
        } else {
            $getData = ["loginId" => $loginId, "isactive" => 1];
            $this->db->where($getData);
            $response = $this->db->get("event_details");
        }
        foreach ($response->result() as $res) {
            $res->eventId = base64_encode($res->eventId);
        }
        return json_encode($response->result());
    }

    public function mdelEvent() {
        $loginId = $_SESSION['loginId'];
        $eventId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (empty($loginId) || empty($eventId)) {
            return '{"status":"error", "msg":"Invalid Details"}';
        }
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
        }
    }

    //Event End
    //Faculty Start
    public function maddFaculty() {
        $loginId = $_SESSION['loginId'];
        $image = (isset($_FILES['facultyImage']['name']) ? preg_replace("/\s+/", "_", $_FILES['facultyImage']['name']) : "");
        $facultyId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $name = FILTER_VAR(trim($this->input->post('name')), FILTER_SANITIZE_STRING);
        $gender = FILTER_VAR(trim($this->input->post('gender')), FILTER_SANITIZE_STRING);
        $mobile = FILTER_VAR(trim($this->input->post('mobile')), FILTER_SANITIZE_STRING);
        $email = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_EMAIL);
        $qualification = FILTER_VAR(trim($this->input->post('qualification')), FILTER_SANITIZE_STRING);
        $post = FILTER_VAR(trim($this->input->post('post')), FILTER_SANITIZE_STRING);
        $address = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);
        if (empty($loginId) || empty($name) || empty($gender) || empty($email) || empty($qualification) || empty($post)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            if ($facultyId === "no_one") {
                return $this->addFaculty($loginId, $name, $gender, $mobile, $email, $post, $address, $qualification, $image, 'facultyImage');
            } else {
                return $this->upDateFaculty(base64_decode($facultyId), $loginId, $name, $gender, $mobile, $email, $post, $address, $qualification, $image, 'facultyImage');
            }
        }
    }

    private function addFaculty($loginId, $name, $gender, $mobile, $email, $post, $address, $qualification, $image, $imgname) {
        $dData = ["loginId" => $loginId, "name" => $name, "gender" => $gender, "mobile" => $mobile, "email" => $email, "isactive" => 1];
        $chkDuplicate = $this->db->where($dData)->get("faculty_details");

        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/facultyImage/image';
                $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
                $todaydate = $date->format('YmdHisA');
                $imgName = $_SESSION['orgName'] . $todaydate . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "name" => $name, "gender" => $gender, "mobile" => $mobile, "email" => $email, "address" => $address,
                "facultyImage" => $response, "qualification" => $qualification, "post" => $post, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("faculty_details", $iData);
            $this->addActivityLog($_SESSION['loginId'], "Faculty Details Inserted by " . $_SESSION['orgName'] . "", "faculty_details", "0");
            return ($res !== "" ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    private function upDateFaculty($facultyId, $loginId, $name, $gender, $mobile, $email, $post, $address, $qualification, $image, $imgname) {
        $dData = ["facultyId!=" => $facultyId, "loginId" => $loginId, "name" => $name, "gender" => $gender, "mobile" => $mobile, "email" => $email, "isactive" => 1];

        $chkDuplicate = $this->db->where($dData)->get("faculty_details");
        $previmg = $this->input->post('previmage');
        if ($chkDuplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } else {
            if ($image != "") {
                $path = './projectimages/images/facultyImage/image';
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $responsed = $this->uploadImage($path, $imgName, $imgname);
                $response = ($responsed == "error" ? $previmg : $responsed);
                ($responsed == "error" ? "" : $this->removeImage('projectimages/images/facultyImage/image/' . $previmg, 'projectimages/images/facultyImage/image/'));
            } else {
                $response = $previmg;
            }
            $iData = ["name" => $name, "gender" => $gender, "mobile" => $mobile, "email" => $email, "address" => $address, "facultyImage" => $response, "qualification" => $qualification, "post" => $post, "updatedAt" => $this->datetimenow()];
            $res = $this->db->where(["facultyId=" => $facultyId, "isactive" => 1, "loginId" => $loginId])->update("faculty_details", $iData);
            $this->addActivityLog($_SESSION['loginId'], "Faculty Details Updated by " . $_SESSION['orgName'] . "", "faculty_details", "0");
            return ($res !== "" ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mgetFaculty() {
        $loginId = $_SESSION['loginId'];
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($ed)) {
            $getData = ["faculty_details.loginId" => $loginId, "faculty_details.facultyId" => base64_decode($ed), "faculty_details.isactive" => 1];
            $this->db->select('*');
            $this->db->from('faculty_details');
            $this->db->where($getData);
            $response = $this->db->get();
        } else {
            $getData = ["faculty_details.loginId" => $loginId, "faculty_details.isactive" => 1];
            $this->db->select('*');
            $this->db->from('faculty_details');
            $this->db->where($getData);
            $response = $this->db->get();
        }
        foreach ($response->result() as $res) {
            $res->facultyId = base64_encode($res->facultyId);
            $res->departmentId = base64_encode($res->departmentId);
        }
        return json_encode($response->result());
    }

    public function mdelFaculty() {
        $loginId = $_SESSION['loginId'];
        $facultyId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (empty($loginId) || empty($facultyId)) {
            return '{"status":"error", "msg":"Invalid details"}';
        }
        $response = $this->db->where(["loginId" => $loginId, "facultyId" => base64_decode($facultyId), "isactive" => 1])->get("faculty_details");
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
    //News Start
    public function mgetNews() {
        $loginId = $_SESSION['loginId'];
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($ed)) {
            $newsId = base64_decode($ed);
            $condition = "AND loginId=$loginId AND newsId=$newsId AND isactive=1";
        } else {
            $condition = "AND loginId=$loginId  AND isactive=1";
        }
        $response = $this->db->query("SELECT newsId,loginId,title,description,newsImage,publishDate publishDateo,DATE_FORMAT(publishDate,'%d-%b-%y') AS publishDate
                                                FROM news WHERE isactive=1 $condition");
        foreach ($response->result() as $res) {
            $res->newsId = base64_encode($res->newsId);
        }
        return json_encode($response->result());
    }

    public function maddNews() {
        $loginId = $_SESSION['loginId'];
        if (isset($_FILES['newsImage']['name'])) {
            $image = preg_replace("/\s+/", "_", $_FILES['newsImage']['name']);
        } else {
            $image = "";
        }
        $publishDate = FILTER_VAR(trim($this->input->post('publishDate')), FILTER_SANITIZE_STRING);
        $newsId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $description = $this->input->post('description');
        if (empty($title) || empty($description)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        } else {
            if ($newsId === "no_one") {
                return $this->addNewsItem($loginId, $title, $description, $image, $publishDate, 'newsImage');
            } else {
                return $this->upDateNews(base64_decode($newsId), $loginId, $title, $description, $image, $publishDate, 'newsImage');
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
                $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
                $todaydate = $date->format('YmdHisA');
                $imgName = $_SESSION['orgName'] . $todaydate . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "newsImage" => $response, "title" => $title, "description" => $description,
                "publishDate" => $publishDate, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("news", $iData);
            $this->addActivityLog($_SESSION['loginId'], "News Inserted by " . $_SESSION['orgName'] . "", "news", "0");
            return ($res != "" ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
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
                $imgName = $_SESSION['orgName'] . strtotime($this->datetimenow()) . $image;
                $respons = $this->uploadImage($path, $imgName, $imgname);
                $response = ($respons == 'error' ? $previmg : $respons);
                ($respons == 'error' ? "" : $this->removeImage('projectimages/images/news/image/' . $previmg, 'projectimages/images/news/image/'));
            } else {
                $response = $previmg;
            }
            $iData = ["loginId" => $loginId, "newsImage" => $response, "title" => $title, "description" => $description, "publishDate" => $publishDate, "updatedAt" => $this->datetimenow()];

            $res = $this->db->where(["newsId=" => $newsId, "loginId" => $loginId])->update("news", $iData);
            $this->addActivityLog($_SESSION['loginId'], "News Updated by " . $_SESSION['orgName'] . "", "news", "0");
            return ($res != "" ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
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
                $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
                $todaydate = $date->format('YmdHisA');
                $imgName = $_SESSION['orgName'] . $todaydate . $image;
                $response = $this->uploadImage($path, $imgName, $imgname);
            } else {
                $response = "";
            }
            $iData = ["loginId" => $loginId, "awards" => $awards, "description" => $description,
                "image" => $response, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("achievement", $iData);
            $this->addActivityLog($_SESSION['loginId'], "Achievement Details Inserted by " . $_SESSION['orgName'] . "", "achievement", "0");
            return ($res != "" ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
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
                ($previmg != "no_image" && $previmg != "" ? $this->removeImage('projectimages/images/achievement/image/' . $previmg, 'projectimages/images/achievement/image/') : "");
            } else {
                $response = $previmg;
            }
            $iData = ["awards" => $awards, "image" => $response, "description" => $description, "updatedAt" => $this->datetimenow()];

            $res = $this->db->where(["achiveId=" => $achiveId, "isactive" => 1, "loginId" => $loginId])->update("achievement", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Achievement Details Updated by " . $_SESSION['orgName'] . "", "achievement", "0") : "");
            return ($res ? '{"status":"success", "msg":"Save Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        }
    }

    public function mgetAchievement() {
        $loginId = $_SESSION['loginId'];
        $ed = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($ed)) {
            $getData = ["loginId" => $loginId, "achiveId" => base64_decode($ed), "isactive" => 1];
            $this->db->where($getData);
            $response = $this->db->get("achievement");
        } else {
            $getData = ["loginId" => $loginId, "isactive" => 1];
            $this->db->where($getData);
            $response = $this->db->get("achievement");
        }
        foreach ($response->result() as $res) {
            $res->achiveId = base64_encode($res->achiveId);
        }
        return json_encode($response->result());
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
                $this->addActivityLog($_SESSION['loginId'], "Achievement Details Deleted by " . $_SESSION['orgName'] . "", "achievement", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        }
    }

    //Achievment End
    //Running Status Start
    public function mRunningStatus() {
        $loginId = $_SESSION['loginId'];
        $res = "";
        $runningStatusIds = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        if (empty($title) || empty($loginId)) {
            return '{"status":"error", "msg":"Empty Details!"}';
        }
        $condition = ($runningStatusIds !== "no_one" ? ["runningStatusId!=" => base64_decode($runningStatusIds), "loginId" => $loginId, "title" => $title, "isactive" => 1] : ["loginId" => $loginId, "title" => $title, "isactive" => 1]);

        $chkduplicate = $this->db->where($condition)->get("running_status");
        if ($chkduplicate->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate entry!"}';
        } if ($runningStatusIds === "no_one") {
            $res = $this->db->insert("running_status", ["loginId" => $loginId, "title" => $title, "createdAt" => $this->datetimenow(), "isactive" => 1]);
            $this->addActivityLog($_SESSION['loginId'], "Running Status Inserted by " . $_SESSION['orgName'] . "", "running_status", "0");
        } else {
            $res = $this->db->where(["runningStatusId" => base64_decode($runningStatusIds), "loginId" => $loginId])->update("running_status", ["title" => $title, "updatedAt" => $this->datetimenow()]);
            $this->addActivityLog($_SESSION['loginId'], "Running Status Updated by " . $_SESSION['orgName'] . "", "running_status", "0");
        }
        return ($res != "" ? '{"status":"success", "msg":"Saved Successful"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
    }

    public function mgetRunningStatus() {
        $loginId = $_SESSION['loginId'];
        $runningStatusIds = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($runningStatusIds)) {
            $runningStatusId = base64_decode($runningStatusIds);
            $condition = "AND runningStatusId=$runningStatusId";
        } else {
            $condition = "";
        }
        $data = $this->db->query("SELECT * FROM running_status WHERE loginId=$loginId AND isactive=1 $condition");
        foreach ($data->result() as $rs) {
            $rs->runningStatusId = base64_encode($rs->runningStatusId);
        }
        return json_encode($data->result());
    }

    public function mdelRunningStatus() {
        $loginId = $_SESSION['loginId'];
        $runningStatusIds = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        $this->db->where(["loginId" => $loginId, "runningStatusId" => base64_decode($runningStatusIds), "isactive" => 1]);
        $response = $this->db->get("running_status");
        if ($response->num_rows() > 0) {
            $this->db->where(["loginId" => $loginId, "runningStatusId" => base64_decode($runningStatusIds), "isactive" => 1]);
            $resp = $this->db->update("running_status", ["updatedAt" => $this->datetimenow(), "isactive" => 0]);
            if ($resp) {
                $this->addActivityLog($_SESSION['loginId'], "Running Status Deleted by " . $_SESSION['orgName'] . "", "running_status", "0");
                return '{"status":"success", "msg":"Deleted Successful"}';
            } else {
                return '{"status":"error", "msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error", "msg":"Record not found"}';
        }
    }

    //Running Status End
    //Advertisement  starts created by shweta
    /*     * ** for Plan details *** */
    public function mGetdetailsofPlan() {
        $id = FILTER_VAR(trim($this->input->post('planId')), FILTER_SANITIZE_STRING);
        $location = FILTER_VAR(trim($this->input->post('location')), FILTER_SANITIZE_STRING);
        $img_loc = FILTER_VAR(trim($this->input->post('img_loc')), FILTER_SANITIZE_STRING);
        if (!empty($id)) {
            $qry = $this->db->query("SELECT * FROM advertisement_plan WHERE isactive=1 AND planId='" . $id . "'");
        } elseif (!empty($location)) {
            $qry = $this->db->query("SELECT DISTINCT img_loc FROM advertisement_plan WHERE isactive=1");
        } elseif (!empty($img_loc)) {
            $qry = $this->db->query("SELECT ap.*,CONCAT(ap.plan_name,'(',sts.name,' (',ctr.name,')',')') planName FROM advertisement_plan ap
                                    INNER JOIN countries ctr on ctr.countryId=ap.countryId
                                    INNER JOIN states sts ON sts.stateId=ap.stateId WHERE ap.isactive=1 AND ap.img_loc='" . $img_loc . "'");
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
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Advertisement Inserted by " . $_SESSION['orgName'] . "", "advertisement", "0") : "");
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
                ($previmg != "no_image" && $previmg != "" ? $this->removeImage('projectimages/images/adsBanner/image/' . $previmg, 'projectimages/images/adsBanner/image/') : "");
            } else {
                $response = $previmg;
            }
            $iData = ["adsTitle" => $adsTitle, "url" => $url, "planId" => $planId, "adsBanner" => $response, "isactive" => 1, "apprv_by_admin" => 1, "adsDate" => date('Y-m-d'), "updatedAt" => $this->datetimenow()];

            $res = $this->db->where(["adsId=" => $adsId, "loginId" => $loginId])->update("advertisement", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Advertisement Updated by " . $_SESSION['orgName'] . "", "advertisement", "0") : "");
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
        $response = $this->db->query("SELECT ta.* ,DATE_FORMAT(ta.ad_start_date,'%d-%b-%Y') as startDate,ta.apprv_by_admin,DATE_FORMAT(ta.adsDate, '%d-%b-%Y') addeddate, tc.name countryname ,ts.name statename,tap.planId,tap.plan_name,tap.img_loc,tap.days,
                                                tap.countryId,CONCAT(tap.price,' (',tap.currencyCode,')') price,tap.stateId,DATE_FORMAT(DATE_ADD(ta.ad_start_date, INTERVAL tap.days DAY),'%d-%b-%Y') expiryDate,
                                                (SELECT COUNT(*) FROM advertisement adv
                                                INNER JOIN advertisement_plan advp ON advp.planId=adv.planId AND adv.isactive=1 WHERE
                                                adv.adsId=ta.adsId AND DATE_ADD(adv.adsDate, INTERVAL advp.days DAY)>CURRENT_DATE()) as statusadd  FROM advertisement ta
                                                INNER JOIN advertisement_plan tap ON tap.planId=ta.planId AND tap.isactive=1
                                                INNER JOIN countries tc ON tc.countryId=tap.countryId
                                                INNER JOIN states ts ON ts.stateId=tap.stateId
                                                WHERE ta.loginId=" . $_SESSION['loginId'] . "  AND ta.isactive=1  $condition");
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
        $adsId = FILTER_VAR(trim($this->input->post('adsId')), FILTER_SANITIZE_STRING);
        $startDateC = FILTER_VAR(trim($this->input->post('startDateC')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['loginId']) || empty($adsId) || empty($startDateC)) {
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

    public function getProfileJson() {
        $profileinfo = $this->getProfileInfo();
        return json_encode($profileinfo);
    }

    //Advertisement  end created by shweta
    //News letter plan buy  starts created by shweta
    public function mGetdetailsofNewsLetterPlan() {
        $id = FILTER_VAR(trim($this->input->post('nlp_Id')), FILTER_SANITIZE_STRING);
        if (!empty($id) || !empty($loginId)) {
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
            $iData1 = ["loginId" => $_SESSION['loginId'], "nlp_Id" => $nlp_Id, "no_of_news_ltr" => $no_of_news_ltr, "pay_status" => 1, "isactive" => 1, "buy_date" => date('Y-m-d'), "createdAt" => $this->datetimenow()];
            $iData = ($chk1->num_rows() > 0 ? array_merge($iData1, ['iscurrent' => 0]) : array_merge($iData1, ['iscurrent' => 1]));

            $res = $this->db->insert("tbl_news_ltr_plan_buy", $iData);
            ($res ? $this->addActivityLog($_SESSION['loginId'], "Buy Plan Inserted by " . $_SESSION['orgName'] . "", "tbl_news_ltr_plan_buy", "1") : "");
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
                    if (isset($_SESSION['loginId'])) {
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
    //Change Password Start
    public function mChangePasswordSave() {
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

    public function mGetSchoolClassType() {
        $classType = FILTER_VAR(trim($this->input->post('classTypeId')), FILTER_SANITIZE_STRING);
        if (!empty($classType)) {
            $this->db->where(["class" => $classType, "isactive" => 1]);
            $qry = $this->db->get("school_class_type");
            if ($qry->num_rows() > 0) {
                return json_encode($qry->result());
            } else {
                return $response = "noData";
            }
        } else {
            return $response = "noData";
        }
    }

    //Analytics Start
    public function mGetViewCounts() {
        $loginId = $_SESSION['loginId'];
        if ($loginId) {
            $qry = $this->db->query("SELECT (SELECT ld.visitorCount  FROM login_details ld WHERE ld.id=$loginId) visitorCount,
                        ( SELECT COUNT(*) FROM tbl_enroll te
            INNER JOIN school_class_details scd ON scd.sClassId=te.sClassId  WHERE scd.loginId=$loginId AND te.status='Accepted') admissiontook,
            ( SELECT COUNT(*) FROM tbl_enroll te
            INNER JOIN school_class_details scd ON scd.sClassId=te.sClassId  WHERE scd.loginId=$loginId AND te.status='Enrolled') admissioninprocess,
                ( SELECT COUNT(*) FROM tbl_enroll te
            INNER JOIN school_class_details scd ON scd.sClassId=te.sClassId  WHERE scd.loginId=$loginId AND te.status='Rejected') admissionrejected");
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
                $data[] = ["enrollmentId" => $i++, "CourseDetails" => $dt->courseName, "CourseDuration" => $dt->timeDuration . ' ' . $dt->courseDurationType,
                    "FeeDetails" => 'Reg Fee : ' . $dt->registrationFee . '<br> Course Fee : ' . $dt->courseFee, "ImportantDates" => 'Application Opening : ' . ($dt->openingDate ? $dt->openingDate : "NA") . '
                    <br>Application Closing : ' . ($dt->closingDate ? $dt->closingDate : "NA") . '<br>Exam Date: ' . ($dt->examDate ? $dt->examDate : "NA"),
                    "ApplicationDate" => $dt->applicationDate, "ApplicationStatus" => $dt->status, "Action" => '<select class="statuschange" erId="' . $dt->enrollmentId . '">
                    <option value="">Select</option><option value="Accepted">Accept</option><option value="Rejected">Reject</option></select>'];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }

    public function mgetAllEnrollments($condition) {
        $columns = array(0 => 'te.enrollmentId', 1 => 'ic.title', 2 => 'td.title', 3 => 'icd.courseFee', 4 => 'icd.applyFrom', 5 => 'te.status');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $likearr = " AND (te.enrollmentId like %$search% OR scd.courseDurationType LIKE %$search% OR od.orgName LIKE %$search% OR scd.courseFee LIKE %$search%
                                    OR scd.applyFrom LIKE %$search% OR te.status LIKE %$search% OR scd.applyTo LIKE %$search% OR te.createdAt LIKE %$search% )";
        $conditions = ($condition == "nosearch" ? "Order by $order $dir  LIMIT  $start,$limit" : ($condition == "total" ? "" :
                ($condition == "search" ? " $likearr Order by $order $dir  LIMIT $start,$limit" : ($condition == "searchtotal" ? " $likearr Order by $order $dir " : ""))));

        return $this->db->query("SELECT te.enrollmentId,te.status,scd.courseDurationType,DATE_FORMAT(scd.applyFrom ,'%d-%b-%Y') openingDate,
                                        DATE_FORMAT(scd.applyTo ,'%d-%b-%Y') closingDate, DATE_FORMAT(scd.examDate ,'%d-%b-%Y') examDate,scd.courseFee,scd.registrationFee,'' departmentName,sct.title  courseType,sct.class courseName,'1 Year' timeDuration,
                                        DATE_FORMAT(te.createdAt ,'%d-%b-%Y') applicationDate,ld.roleName,od.orgName FROM tbl_enroll te
                                        INNER JOIN school_class_details scd ON scd.sClassId=te.sClassId AND scd.isactive=1
                                        INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId
                                        INNER JOIN login_details ld ON ld.id=scd.loginId
                                        INNER JOIN organization_details od ON ld.id=od.loginId
                                        WHERE te.isactive=1 AND scd.loginId=" . $_SESSION['loginId'] . " $conditions");
    }

    public function mChangeStatus() {
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
        $chk = $this->db->query("SELECT * FROM tbl_enroll te INNER JOIN organization_courses oc ON oc.orgCourseId=te.orgCourseId  AND oc.isactive=1
            WHERE oc.loginId=" . $_SESSION['loginId'] . " AND te.enrollmentId=$enrollmentId AND te.isactive=1");
        if ($chk->num_rows() > 0) {
            $uData = ["updatedAt" => $this->datetimenow(), "status" => $status];
            $resp = $this->db->where("enrollmentId", $enrollmentId)->update("tbl_enroll", $uData);
            ($resp ? $this->addActivityLog($_SESSION['loginId'], "Enrollment Status Changed by " . $_SESSION['orgName'] . "", "tbl_enroll", "0") : "");
            $response = ($resp ? $this->sendEnrollEmail($enrollmentId, $status, $message, $chk) : "");
            return ($resp ? '{"status":"success", "msg":"Status changed successfully! ' . $response . '"}' : '{"status":"error", "msg":"Some error occured."}');
        }
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
        $getEnrollment = $this->db->query("SELECT te.enrollmentId,te.status,scd.courseDurationType,DATE_FORMAT(scd.applyFrom ,'%d-%b-%Y') openingDate,
                                        DATE_FORMAT(scd.applyTo ,'%d-%b-%Y') closingDate, DATE_FORMAT(scd.examDate ,'%d-%b-%Y') examDate,scd.courseFee,
                                        scd.registrationFee,'' departmentName,sct.title  courseType,sct.class courseName,'1 Year' timeDuration,
                                        DATE_FORMAT(te.createdAt ,'%d-%b-%Y') applicationDate,ld.roleName,od.orgName FROM tbl_enroll te
                                        INNER JOIN school_class_details scd ON scd.sClassId=te.sClassId AND scd.isactive=1
                                        INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId
                                        INNER JOIN login_details ld ON ld.id=scd.loginId
                                        INNER JOIN organization_details od ON ld.id=od.loginId
                                        WHERE te.isactive=1 AND scd.loginId=" . $_SESSION['loginId'] . " AND te.enrollmentId=$enrollmentId");
        if ($getEnrollment->num_rows() > 0) {
            $rowData = $getEnrollment->row();
            $result = 'Course Name ' . $rowData->courseName . ' Duration ' . $rowData->timeDuration . ' Application Date ' . $rowData->applicationDate;
        } else {
            $result = '';
        }
        return $result;
    }

    //Enrollments End
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
        $columns = array(0 => 'tce.tcEnquiyId', 1 => 'scd.class', 2 => 'tce.senderName', 3 => 'tce.message', 4 => 'tce.date');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $likearr = " AND (tce.tcEnquiyId like %$search% OR scd.class LIKE %$search% OR scd.courseDurationType LIKE %$search% OR sct.title LIKE %$search%
                    OR tce.senderName LIKE %$search% OR tce.email LIKE %$search% OR tce.contact LIKE %$search% OR tce.message LIKE %$search% )";
        $condions = ($condition == "nosearch" ? "Order by $order $dir  LIMIT  $start,$limit" : ($condition == "total" ? "" :
                ($condition == "search" ? " $likearr Order by $order $dir  LIMIT $start,$limit" : ($condition == "searchtotal" ? " $likearr Order by $order $dir " : ""))));

        return $this->db->query("SELECT tce.tcEnquiyId,CONCAT(scd.class,' (',sct.title,') ',' ',scd.courseDurationType ) courseDetails,CONCAT(tce.senderName,'<br>',tce.email,'<br>',tce.contact) senderDetails,
                    tce.message,DATE_FORMAT(tce.date ,'%d-%b-%Y') enqdate,tce.status FROM tbl_course_enquiry tce
                    INNER JOIN school_class_details scd ON scd.sClassId=tce.sClassId AND scd.isactive=1
                    INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId
                    INNER JOIN login_details ld ON ld.id=scd.loginId
                    INNER JOIN organization_details od ON ld.id=od.loginId
                    WHERE  tce.isactive=1 AND scd.loginId=" . $_SESSION['loginId'] . " $condions");
    }

    //Enquiry End
    //promocode Start
    public function mGetCourseNames() {
        $qry = $this->db->query("SELECT scd.sClassId,CONCAT(sct.class,' (',sct.title,')') courseName FROM school_class_details scd
                                        INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId AND sct.isactive=1
                                        WHERE scd.loginId=" . $_SESSION['loginId'] . " AND scd.isactive=1");
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
        $qry = $this->db->query("SELECT scd.sClassId,CONCAT(sct.class,' (',sct.title,')') courseName,scd.sClassId,pc.*,
                                                    CONCAT('From : ',DATE_FORMAT(pc.validFrom,'%d-%b-%Y'),' To : ',DATE_FORMAT(pc.validTo,'%d-%b-%Y')) validdates,
                                                    pcm.price FROM tbl_promocodedetails pc
                                                    INNER JOIN school_class_details scd ON scd.sClassId=pc.sClassId AND scd.isactive=1
                                                    INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId AND sct.isactive=1
                                                    INNER JOIN tbl_promocodemaster pcm ON pcm.promocodeId=pc.promocodeId
                                                    WHERE scd.loginId=" . $_SESSION['loginId'] . " AND pc.isactive=1 $condition");
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
                        INNER JOIN tbl_blog_cat tbc ON tbc.catId=tb.blogcatId INNER JOIN login_details ld ON ld.id=tb.userId AND tb.userType=ld.roleName
                        INNER JOIN organization_details od ON od.loginId=ld.id  WHERE tb.isactive=1 $condition ");

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
            // $error = array('error' => $this->upload->display_errors());
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
                ($res ? $this->addActivityLog($_SESSION['loginId'], "Notification Message sent to " . $chk->row()->orgName . " ", "web_users", "") : "");
                ($res ? ($emailSend == 1 ? $this->sendEmail($chk->row()->email, $message, $reference, "iHuntBest") : "") : "");
                return ($res ? '{"status":"success","msg":" Notification sent successfully!"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
            }
        }
    }

    //Notifications End
    //Activity Log Start
    private function addActivityLog($user_id, $activity, $act_table, $isadmin) {
        $idata = ["user_id" => $user_id, "activity" => $activity, "act_table" => $act_table, "date" => date('Y-m-d'), "isadmin" => 0,
            "role_name" => "School", "created_at" => $this->datetimenow(), "ip_address" => $this->getRealIpAddr(), "isactive" => 1];
        $this->db->insert("activity_log", $idata);
    }

    //Activity Log End
    //Change Password End
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
