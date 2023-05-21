<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set('Asia/Kolkata');
        }
        $this->load->library('image_lib');
        $this->load->model("Superadmin_model");
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr'));
    }

    //SuperAdmin Login Start
    public function login() {
        $this->load->view("superadmin/super_admin_login_view");
    }

    public function saLogin() {
        $this->viewMessage($this->Superadmin_model->mSuperAdminLogin());
    }

    //SuperAdmin Login End
    //Activity Log Start
    public function activityLog() {
        $this->authenticate();
        $this->load->view("superadmin/activityLog_view");
    }

    public function getActivitylog() {
        $this->authenticate();
        $startDate = FILTER_VAR(trim($this->input->post('datestart')), FILTER_SANITIZE_STRING);
        $endDate = FILTER_VAR(trim($this->input->post('dateend')), FILTER_SANITIZE_STRING);
        $user_type = FILTER_VAR(trim($this->input->post('user_type')), FILTER_SANITIZE_STRING);
        $columns = array(0 => 'al.id', 1 => 'al.activity');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $length = $this->input->post('length');
        $start = $this->input->post('start');
        $message = $this->Superadmin_model->mGetActivitylog($startDate, $endDate, $user_type, "Order By " . $order, $dir, $search, $length, $start);
        $this->viewMessage($message);
    }

    //Activity Log End
    //Change Password Start
    public function changePassword() {
        $this->authenticate();
        $this->load->view("superadmin/changePassword_view");
    }

    public function changePasswordSave() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mchangePasswordSave());
    }

    //Change Password End
    //Profile Start
    public function profile() {
        $this->authenticate();
        $profiledetails = $this->Superadmin_model->mgetProfileDetails();
        if ($profiledetails) {
            $data['profileDetail'] = $profiledetails;
        } else {
            $data['error'] = "";
        }
        $this->load->view("superadmin/superadmin_profile_view", $data);
    }

    public function editprofile() {
        $this->authenticate();
        $profiledetails = $this->Superadmin_model->mgetProfileDetails();
        if ($profiledetails) {
            $data['profileDetail'] = $profiledetails;
        } else {
            $data['error'] = "";
        }
        $this->load->view("superadmin/superadmin_edit_profile_view", $data);
    }

    public function saveprofile() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mSaveProfile());
    }

    public function financialDetails() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config['places'] = true;
        $config['placesAutocompleteInputID'] = 'bank_address';
        $config['placesAutocompleteBoundsMap'] = true;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->db->where(["login_id" => $_SESSION['id'], "user_type" => "Superadmin"]);
        $details = $this->db->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            $res = $details->row();
            $res->credit_card_no = ( $res->credit_card_no === "" ? null : $this->encryption->decrypt($res->credit_card_no) );
            $res->creditcard_cvv = ( $res->creditcard_cvv === "" ? null : $this->encryption->decrypt($res->creditcard_cvv) );
            $res->debit_card_no = ( $res->debit_card_no === "" ? null : $this->encryption->decrypt($res->debit_card_no) );
            $res->debitcard_cvv = ( $res->debitcard_cvv === "" ? null : $this->encryption->decrypt($res->debitcard_cvv) );
            $res->bank_account_no = ( $res->bank_account_no === "" ? null : $this->encryption->decrypt($res->bank_account_no) );
            $data["details"] = $res;
        }
        $this->load->view("superadmin/financial_details_view", $data);
    }

    public function saveFinancialDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mSaveFinancialDetails());
    }

    //Profile End
    //SuperAdmin Dashboard Start
    public function dashboard() {
        $this->authenticate();
        $qry = $this->Superadmin_model->mGetTotals();
        if ($qry->num_rows() > 0) {
            $data['totals'] = $qry->row();
        } else {
            $data = "";
        }
        $this->load->view("superadmin/dashboard_view", $data);
    }

    //SuperAdmin Dashboard End
    //University CourseMaster Start
    public function univCoursesMaster() {
        $this->authenticate();
        $this->load->view("superadmin/univ_course_master_view");
    }

    public function getCourseType() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetUnivCourseType());
    }

    public function addCourseType() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddCourseType());
    }

    public function delCourseType() {
        $this->authenticate();
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (!empty($this->input->post('del'))) {
            $message = $this->Superadmin_model->mDelCourseType(base64_decode($id));
        } else {
            $message = '{"status":"error", "msg":"Required details are empty!"}';
        }
        $this->viewMessage($message);
    }

    public function getcourse_details() {
        $this->authenticate();
        $ctId = FILTER_VAR(trim($this->input->post('ctId')), FILTER_SANITIZE_STRING);
        $cname = FILTER_VAR(trim($this->input->post('cname')), FILTER_SANITIZE_STRING);
        if (!empty($ctId)) {
            $data["ctId"] = $ctId;
            $data["cname"] = $cname;
        } else {
            $data = "";
        }
        $this->load->view("superadmin/course_details_view", $data);
    }

    public function getCoursedetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetcourse_details());
    }

    public function showRejectedCourse() {
        $this->authenticate();
        $this->load->view("superadmin/rejected_courses_view");
    }

    public function getRejectedCoursedetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mgetRejectedCoursedetails());
    }

    public function delCoursedetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelCoursedetails());
    }

    public function addCourse() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddCourse());
    }

    public function loadStream_details() {
        $this->authenticate();
        $ctId = FILTER_VAR(trim($this->input->post('ctId')), FILTER_SANITIZE_STRING);
        $cId = FILTER_VAR(trim($this->input->post('cId')), FILTER_SANITIZE_STRING);
        $courseType = FILTER_VAR(trim($this->input->post('courseType')), FILTER_SANITIZE_STRING);
        $courseName = FILTER_VAR(trim($this->input->post('courseName')), FILTER_SANITIZE_STRING);
        if (!empty($ctId)) {
            $data["ctId"] = $ctId;
            $data["cname"] = $courseType . "-" . $courseName;
            $data["ocname"] = $courseType;
            $data["cId"] = $cId;
        } else {
            $data = "";
        }
        $this->load->view("superadmin/stream_details_view", $data);
    }

    public function getStreamDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetStream_details());
    }

    public function deleteStream() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDeleteStream());
    }

    public function addStream() {
        $this->authenticate();
        $cId = FILTER_VAR(trim($this->input->post('cId')), FILTER_SANITIZE_STRING);
        $streamId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->maddStream($cId, $streamId, $title));
    }

    //University CourseMaster Start
    //Institute Course Master
    public function InstCoursesMaster() {
        $this->load->view("superadmin/inst_course_master_view");
    }

    public function getInstCourseType() {
        $this->authenticate();
        $query = $this->Superadmin_model->mGetInstCourseType();
        if ($query->num_rows() > 0) {
            $rowData = "[";
            foreach ($query->result() as $rd) {
                $rowData = $rowData . '{"insCourseId":"' . $rd->insCourseId . '","insCourseId1":"' . $rd->insCourseId . '","title":"' . $rd->title . '"},';
            }
            $rowDatas = rtrim($rowData, ",");
            $rowData = $rowDatas . ']';
            echo $rowData;
        }
    }

    public function addInstCourseType() {
        if (!empty($this->input->post('save_course'))) {
            $this->viewMessage($this->Superadmin_model->mAddInstCourseType());
        }
    }

    public function delInstCourseType() {
        $this->authenticate();
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (!empty($this->input->post('del'))) {
            $this->viewMessage($this->Superadmin_model->mDelInstCourseType($id));
        }
    }

    //end Institute Course
    //time duration
    public function TimedurationMaster() {
        $this->authenticate();
        $this->load->view("superadmin/time_duration_master_view");
    }

    public function getTimeDuration() {
        $this->authenticate();
        $query = $this->Superadmin_model->mGetTimeDuration();
        if ($query->num_rows() > 0) {
            $rowData = "[";
            foreach ($query->result() as $rd) {
                $rowData = $rowData . '{"tdId":"' . $rd->tdId . '","tdId":"' . $rd->tdId . '","title":"' . $rd->title . '"},';
            }
            $rowDatas = rtrim($rowData, ",");
            $rowData = $rowDatas . ']';
            echo $rowData;
        }
    }

    public function addTimeDuration() {
        $this->authenticate();
        if (!empty($this->input->post('save_time'))) {
            $this->viewMessage($this->Superadmin_model->mAddTimeDuration());
        }
    }

    public function delTimeDuration() {
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (!empty($this->input->post('del'))) {
            $this->viewMessage($this->Superadmin_model->mDelTimeDuration($id));
        }
    }

    //School Class Type Master

    public function schoolClassTypeMaster() {
        $this->authenticate();
        $qry = $this->db->where("isactive", 1)->order_by("classnamesId", 'asc')->get("tbl_classnames");
        ($qry->num_rows() > 0 ? $data["sclass"] = $qry->result() : $data[""] = "");
        $this->load->view("superadmin/school_course_type_master_view", $data);
    }

    public function addSchoolClassType() {
        $this->authenticate();
        if (!empty($this->input->post('save_class'))) {
            $this->viewMessage($this->Superadmin_model->mAddSchoolClassType());
        }
    }

    public function getSchoolClassType() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetSchoolClassType());
    }

    public function delSchoolClassType() {
        $this->authenticate();
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (!empty($this->input->post('del'))) {
            $this->viewMessage($this->Superadmin_model->mdelSchoolClassType($id));
        }
    }

    //School Class Master
    public function schoolClassMaster() {
        $this->authenticate();
        $this->load->view("superadmin/school_class_master_view");
    }

    public function addSchoolClassName() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddSchoolClassName());
    }

    public function delSchoolClass() {
        $this->authenticate();
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (!empty($this->input->post('del'))) {
            $this->viewMessage($this->Superadmin_model->mDelSchoolClass($id));
        }
    }

    //minQualification Master

    public function minQualificationMaster() {
        $this->authenticate();
        $this->load->view("superadmin/minQualification_master_view");
    }

    public function addMinQalification() {
        $this->authenticate();
        if (!empty($this->input->post('save_qualification'))) {
            $this->viewMessage($this->Superadmin_model->mAddMinQualification());
        }
    }

    public function getMinQalification() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetMinQalification());
    }

    public function delMinQalification() {
        $this->authenticate();
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (!empty($this->input->post('del'))) {
            $this->viewMessage($this->Superadmin_model->mdelMinQalification($id));
        }
    }

    //Organization Details Start
    //University Details Start
    public function showUniversity() {
        $this->authenticate();
        $this->load->view("superadmin/allUniversity_view");
    }

    public function getUniversityDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetUniversityDetails());
    }

    public function upOrgApprovalStatus() {
        $this->authenticate();
        $btntype = FILTER_VAR(trim($this->input->post('btntype')), FILTER_SANITIZE_STRING);
        if ($btntype !== "") {
            $this->viewMessage($this->Superadmin_model->mUpdateOrgBtnType($btntype));
        } else {
            $this->viewMessage($this->Superadmin_model->mUpOrgApprovalStatus());
        }
    }

    public function upDateOrgDetailsLoginStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mUpDateOrgDetailsLoginStatus());
    }

    public function orgStatusChange() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mOrgStatusChange());
    }

    public function sendNotifications() {
        $this->authenticate();
        $reference = FILTER_VAR(trim($this->input->post('reference')), FILTER_SANITIZE_STRING);
        $message = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);
        $emailSend = FILTER_VAR(trim($this->input->post('emailSend')), FILTER_SANITIZE_STRING);
        $orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->mSendNotifications($reference, $message, $emailSend, $orgId));
    }

    //University Details End
    //College Details Start
    public function showCollege() {
        $this->authenticate();
        $this->load->view("superadmin/allCollege_view");
    }

    public function getCollegeDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetCollegetDetails());
    }

    //College Details End
    //Institute Details Star
    public function showInstitute() {
        $this->authenticate();
        $this->load->view("superadmin/all_Institute_view");
    }

    public function getInstituteDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetInstituteDetails());
    }

    public function upDateLatestInstituteStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mupDateLatestInstituteStatus());
    }

    //Institute Details End
    //School Details Start
    public function showSchool() {
        $this->authenticate();
        $this->load->view("superadmin/all_School_view");
    }

    public function getSchoolDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetSchoolDetails());
    }

    //School Details End
    //Qrganization Details End
    //Facilities Start
    //Add/Show Facilities Start
    public function addFacility() {
        $this->authenticate();
        $this->load->view("superadmin/facility_view");
    }

    public function getFacilities() {
        $this->authenticate();
        $query = $this->Superadmin_model->mGetFacilities();
        if ($query->num_rows() > 0) {
            $data = [];
            foreach ($query->result() as $rs) {
                $data[] = [
                    "facilityId" => $rs->facilityId,
                    "facilityId1" => base64_encode($rs->facilityId),
                    "facility_icon" => $rs->facility_icon,
                    "title" => $rs->title
                ];
            }
            echo json_encode($data);
        }
    }

    public function addNewfacility() {
        $this->authenticate();
        if ($this->input->post('save_facility')) {
            $this->viewMessage($this->Superadmin_model->maddNewfacility());
        }
    }

    public function deleteFacilities() {
        $this->authenticate();
        $id = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (!empty($this->input->post('del'))) {
            $this->viewMessage($this->Superadmin_model->mDelFacility($id));
        }
    }

    //Add/Show Facilities End
    //Requested Facility Start
    public function showRequestFacility() {
        $this->authenticate();
        $this->load->view("superadmin/requested_Facilities_view");
    }

    public function getRequestedFacilites() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetRequestedFacilites());
    }

    public function changeRequestedFacilitesStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mchangeRequestedFacilitesStatus());
    }

    //Requested Facility End
    //Approved Facility Start
    public function showApprovedFacility() {
        $this->authenticate();
        $this->load->view("superadmin/approved_Facilities_view");
    }

    public function getApprovedFacilities() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetApprovedFacilities());
    }

    ////Approved Facility End
    //Rejected Facicity Start
    public function showRejectedFacility() {
        $this->authenticate();
        $this->load->view("superadmin/rejected_Facilities_view");
    }

    public function getRejectedFacilities() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetRejectedFacilities());
    }

    //Rejected Facility End
    //Facilities End
    //Student Details Start
    //Show Student Details Start
    public function showStudentDetails() {
        $this->authenticate();
        $this->load->view("superadmin/show_StudentDetails_view");
    }

    public function getStudentDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetStudentDetails());
    }

    public function delStudentDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelStudentDetails());
    }

    //show Student Details End
    //Student Details End
    //AddShow Country Start
    public function addShowCountry() {
        $this->authenticate();
        $this->load->view("superadmin/add_Show_Country_view");
    }

    public function getCountry() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->getCountries());
    }

    public function addCountry() {
        $this->authenticate();
        $sortname = FILTER_VAR(trim(strtoupper($this->input->post('sortname'))), FILTER_SANITIZE_STRING);
        $name = FILTER_VAR(trim(ucwords(strtolower($this->input->post('name')))), FILTER_SANITIZE_STRING);
        $countryId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->mAddCountry($sortname, $name, $countryId));
    }

    public function delCountry() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mdelCountry());
    }

    public function addState() {
        $this->authenticate();
        $countryid = FILTER_VAR(trim(base64_decode($this->input->get("ed"))), FILTER_SANITIZE_NUMBER_INT);
        if ($countryid) {
            $countryname = $this->Superadmin_model->getCountryName($countryid);
            $data["countryid"] = $countryid;
            $data["cname"] = $countryname;
            $this->load->view("superadmin/add_Show_State_view", $data);
        } else {
            redirect("superadmin/addShowCountry");
        }
    }

    public function insertState() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddState());
    }

    public function updateStatusCountry() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mUpDateStatusCountry());
    }

    public function delState() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mdelState());
    }

    public function updateStatusState() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mUpDateStatusState());
    }

    public function addCity() {
        $this->authenticate();
        $stateid = FILTER_VAR(trim(base64_decode($this->input->get("ed"))), FILTER_SANITIZE_NUMBER_INT);
        if ($stateid) {
            $name = $this->Superadmin_model->getStateName($stateid);
            $data["stateid"] = $stateid;
            $data["sname"] = $name;
            $data["countryid"] = $this->Superadmin_model->getContryId($stateid);
            $this->load->view("superadmin/add_Show_City_view", $data);
        } else {
            redirect("superadmin/addShowCountry");
        }
    }

    public function insertCity() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mInsertCity());
    }

    public function delCity() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mdelCity());
    }

    public function updateStatusCity() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mUpDateStatusCity());
    }

    //AddShow Country End
    //Registered Organisations Start
    public function registeredOrganisation() {
        $this->authenticate();
        $this->load->view("superadmin/registered_organisations_view");
    }

    public function getRegisteredOrg() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mgetRegisteredOrg());
    }

    public function setOrgRegistrationContent() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->msetOrgRegistrationContent());
    }

    public function delOrgRegistraion() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mdelOrgRegistraion());
    }

    //Registered Organisations End
    //Organization Registration Start
    public function orgRegister() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config['places'] = true;
        $config['placesAutocompleteInputID'] = 'address';
        $config['placesAutocompleteBoundsMap'] = true;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->load->view("superadmin/org_registration_view", $data);
    }

    public function addOrganizationDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddOrganizationDetails());
    }

    public function getOrganisationDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetOrganisationDetails());
    }

    public function delOrganisationDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelOrganisationDetails());
    }

    //Organization Registration End
    public function studentRegister() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config['places'] = true;
        $config['placesAutocompleteInputID'] = 'address';
        $config['placesAutocompleteBoundsMap'] = true;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->load->view("superadmin/org_studentRegisteration_view", $data);
    }

    public function registerStudent() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mRegisterStudent());
    }

    public function orgFileupload() {
        $this->authenticate();
        $this->load->view("superadmin/org_fileUpload_view");
    }

    public function uploadexcel() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->muploadexcel());
    }

    //Organisation Details start
    public function orgDetails() {
        $this->authenticate();
        $id = FILTER_VAR(trim(base64_decode($this->input->get('id'))), FILTER_SANITIZE_STRING);
        if ($id) {
            $orgf = $this->Superadmin_model->getOrgFacilities('0', $id);
            ($orgf->num_rows() > 0 ? $data["orgFacilities"] = $orgf->result() : "");

            $orgfp = $this->Superadmin_model->getOrgFacilities('1', $id);
            ($orgfp->num_rows() > 0 ? $data["orgFacilitiesp"] = $orgfp->result() : "");

            $orgfa = $this->Superadmin_model->getOrgFacilities('2', $id);
            ($orgfa->num_rows() > 0 ? $data["orgFacilitiesa"] = $orgfa->result() : "");

            $qry = $this->Superadmin_model->mGetorganisaionDetails($id);
            ($qry ? $data["profileData"] = $qry : redirect($_SERVER['HTTP_REFERER']));

            $this->load->view("superadmin/org_details_view", $data);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    //Organisation Details end
    //Requested course starts created by shweta
    public function univRequestedcourse() {
        $this->authenticate();
        $this->load->view("superadmin/requested_Courses_view");
    }

    public function GetRequestedCourse() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetRequestedCourse());
    }

    public function showApprovedCourse() {
        $this->authenticate();
        $this->load->view("superadmin/approved_Courses_view");
    }

    public function GetApprovedCourse() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetApprovedCourse());
    }

    public function changeRequestedCourseStatus() {
        $this->authenticate();
        $ctId = FILTER_VAR(trim($this->input->post('ctId')), FILTER_SANITIZE_STRING);
        $cId = FILTER_VAR(trim($this->input->post('cId')), FILTER_SANITIZE_STRING);
        $streamId = FILTER_VAR(trim($this->input->post('streamId')), FILTER_SANITIZE_STRING);
        $requestStatus = FILTER_VAR(trim($this->input->post('requestStatus')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->mchangeRequestedCourseStatus($ctId, $cId, $streamId, $requestStatus));
    }

    //Requested course  end
    //Advertisement plan starts created by shweta
    public function advertisementplan() {
        $this->authenticate();
        $qry = $this->Superadmin_model->mGetcurrencies();
        if ($qry->num_rows() > 0) {
            $data['currency'] = $qry->result();
        } else {
            $data['nodata'] = '';
        }
        $this->load->view("superadmin/add_advertisement_plan_view", $data);
    }

    public function AdvplanDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->maddAdvplanDetails());
    }

    public function getAdvplanDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mgetAdvplanDetails());
    }

    public function delAdvplanDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mdelAdvplanDetails());
    }

    public function showRequestAdvertisement() {
        $this->authenticate();
        $this->load->view("superadmin/requested_advertisement_view");
    }

    public function showApprovedAdvertisement() {
        $this->authenticate();
        $this->load->view("superadmin/approved_advertisement_view");
    }

    public function showRejectedAdvertisement() {
        $this->authenticate();
        $this->load->view("superadmin/rejected_advertisement_view");
    }

    public function getAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mgetAdvertisement());
    }

    public function changeRequestedAdvStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mchangeRequestedAdvStatus());
    }

    public function getApprovAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mgetApprovAdvertisement());
    }

    public function getRejectedAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mgetRejectedAdvertisement());
    }

    //Advertisement plan end
    //Competitive Master start
    public function competitiveMaster() {
        $this->authenticate();
        $this->load->view("superadmin/competitive_exam_master_view");
    }

    public function addCompetitveExamDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddCompetitveExamDetails());
    }

    public function getCompetitiveExamDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetCompetitiveExamDetails());
    }

    public function delCompetitiveExam() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelCompetitiveExam());
    }

    public function test() {
        $qry = $this->db->where("blogId", "8369")->get("blogs");
        if ($qry->num_rows() > 0) {
            echo '<p>';
            print_r($qry->row()->blogDesp) . '</p>';
        }
    }

    //Competitive Master end
    //Rating and Review start
    public function showRatingReviews() {
        $this->authenticate();
        $this->load->view("superadmin/ratingReviews_view");
    }

    public function getRatingDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetRatingDetails());
    }

    public function approveDisapprove() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mApproveDisapprove());
    }

    public function delRating() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelRating());
    }

    //Rating and Review end
    //Advertise with us start
    public function advertiseWithUs() {
        $this->authenticate();
        $this->load->view("superadmin/advertiseWithUs_view");
    }

    public function getadvertiseWithUsDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetadvertiseWithUsDetails());
    }

    //Advertise with us end
    //Team Members Start
    public function addTeam() {
        $this->authenticate();
        $this->load->view("superadmin/addTeamMemebers_view");
    }

    public function getTeamMembers() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetTeamMembers());
    }

    public function addRemoveMember() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddRemoveMember());
    }

    public function delTeamMember() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelTeamMember());
    }

    //Team Members End
    //careers start
    public function careers() {
        $this->authenticate();
        $this->load->view("superadmin/carerrDetails_view");
    }

    public function addRemoveCarrerDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddRemoveCarrerDetails());
    }

    public function getOpeningDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetOpeningDetails());
    }

    public function delOpeningDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelOpeningDetails());
    }

    public function closeOpenOpeningDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mCloseOpenOpeningDetails());
    }

    public function jobApplications() {
        $this->authenticate();
        $this->load->view("superadmin/jobApplications");
    }

    public function getJobApplication() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetJobApplication());
    }

    public function markasImportant() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mMarkasImportant());
    }

    public function delJobApplication() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelJobApplication());
    }

    //careers end
    //Earn and Share created by shweta
    public function earnandshare() {
        $this->authenticate();
        $this->load->view("superadmin/earn_n_share_view");
    }

    public function addearnandshare() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddearnandshare());
    }

    public function getearnandshare() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetearnandshare());
    }

    public function changeStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mchangeStatus());
    }

    //Earn and Share end  by shweta
    //Earn and Share value by student created by shweta
    public function earnandsharevalue() {
        $this->authenticate();
        $this->load->view("superadmin/earn_n_share_value_view");
    }

    public function getearnandsharevalue() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetearnandsharevalue());
    }

    //Earn and Share value by student end  by shweta
    // Total visitor created by shweta
    public function totalvisitor() {
        $this->authenticate();
        $this->load->view("superadmin/total_visitor_view");
    }

    public function getTotalvistor() {
        $this->authenticate();
        $columns = array(0 => 'totalVisitorId', 1 => 'visitorCount', 2 => 'datenow');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $this->viewMessage($this->Superadmin_model->mGetTotalvistor($order, $dir, $search));
    }

    //total visitor end by shweta
    // Website visitor created by shweta
    public function webvisitor() {
        $this->authenticate();
        $this->load->view("superadmin/web_visitor_view");
    }

    public function getWebvistor() {
        $this->authenticate();
        $columns = array(0 => 'visitorId', 1 => 'countryName', 2 => 'totalVisits', 3 => 'ipaddress');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $this->viewMessage($this->Superadmin_model->mGetWebvistor($limit, $start, $order, $dir, $search));
    }

    //website visitor  end by shweta
    //News letter plan start by shweta
    public function getCurrenciesJson() {
        $getCurrencies = $this->Superadmin_model->mGetcurrencies();
        if ($getCurrencies->num_rows() > 0) {
            $response = $getCurrencies->result();
        } else {
            $response = "";
        }
        $this->viewMessage(json_encode($response));
    }

    public function newsletterplan() {
        $this->authenticate();
        $this->load->view("superadmin/news_letter_plan_view");
    }

    public function addNewsletterplan() {
        $this->authenticate();
        $this->Superadmin_model->mAddNewsletterplan();
    }

    public function getNewsletterplan() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetNewsletterplan());
    }

    public function delNewsletterplan() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelNewsletterplan());
    }

    public function changeNewsplanStatus() {
        $this->authenticate();
        $this->Superadmin_model->mchangeNewsplanStatus();
    }

    //News letter plan end by shweta
    //News letter plan Start by shweta
    public function newsletterplanbuy() {
        $this->authenticate();
        $this->load->view("superadmin/news_letter_plan_buy_view");
    }

    public function getnewsletterplanbuy() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetnewsletterplanbuy());
    }

    //News letter plan buy end by shweta
    //Faq Start
    public function faqCategories() {
        $this->authenticate();
        $this->load->view("superadmin/faqCtegoies_view");
    }

    public function addFaqCategories() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddFaqCategories());
    }

    public function getCategories() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetCategories());
    }

    public function delCategories() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelCategories());
    }

    public function faqQuestionAnswers() {
        $this->authenticate();
        $this->load->view("superadmin/faqQA_view");
    }

    public function addFaqQA() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->maddFaqQA());
    }

    public function getFaqQA() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetFaqQA());
    }

    public function delFAQ() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelFAQ());
    }

    // faq end
    //promocode start
    public function promoCode() {
        $this->authenticate();
        $this->load->view("superadmin/promoCodeMaster_view");
    }

    public function addPromocodeMasterDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddPromocodeMasterDetails());
    }

    public function getPromocodeMasterDetails() {
        $this->authenticate();
        $this->Superadmin_model->mGetPromocodeMasterDetails();
    }

    public function delPromoCode() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelPromoCode());
    }

    public function activeDeactive() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mActiveDeactive());
    }

    //promocode end
    //testimonial start
    public function addTestimonials() {
        $this->authenticate();
        $this->load->view("superadmin/add_Testimonials_view");
    }

    public function getTestimonials() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mgetTestimonials());
    }

    public function editTestimonials() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->meditTestimonials());
    }

    public function delTestimonial() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelTestimonial());
    }

    public function getBlogCategories() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mgetBlogCategories());
    }

    public function delBlogCategory() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelBlogCategory());
    }

    //testimonial End
    //blog start
    public function addBlogCategories() {
        $this->authenticate();
        $this->load->view("superadmin/blogCategories_view");
    }

    public function insertBlogCategory() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mInsertBlogCategory());
    }

    public function addBlog() {
        $this->authenticate();
        $this->load->view("superadmin/createBlog_view");
    }

    public function insertBlogs() {
        $this->authenticate();
        $blogId = FILTER_VAR(trim($this->input->post('blogId')), FILTER_SANITIZE_STRING);
        $blogcatId = FILTER_VAR(trim($this->input->post('blogcatId')), FILTER_SANITIZE_STRING);
        $blogTitle = FILTER_VAR(trim($this->input->post('blogTitle')), FILTER_SANITIZE_STRING);
        $blogDesp = $this->input->post('blogDesp');
        $prevImage = FILTER_VAR(trim($this->input->post('prevImage')), FILTER_SANITIZE_STRING);
        if (empty($blogId) || empty($blogcatId) || empty($blogTitle) || empty($blogDesp) || !isset($_SESSION['id']) || !isset($_FILES['blogImage']['name'])) {
            $messgage = '{"status":"error","msg":"Required Fields are empty!"}';
        } else {
            $messgage = $this->Superadmin_model->mInsertBlogs($blogId, $blogcatId, $blogTitle, $blogDesp, $prevImage);
        }
        $this->viewMessage($messgage);
    }

    public function getBlogsDetails() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetBlogsDetails());
    }

    public function changeBlogStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mChangeBlogStatus());
    }

    public function delBlog() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelBlog());
    }

    //blog end
    //Before You Begin Start
    public function beforeYouBegin() {
        $this->authenticate();
        $this->load->view("superadmin/beforeYouBegin_view");
    }

    public function editInsetBeforeYouBegin() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mEditInsetBeforeYouBegin());
    }

    public function getBeforeYouBegin() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetBeforeYouBegin());
    }

    //Before You Begin End
    //Page Request Start
    public function pageRequests() {
        $this->authenticate();
        $this->load->view("superadmin/pageRequests_view");
    }

    public function getPageRequests() {
        $this->authenticate();
        $pageStatusType = FILTER_VAR(trim($this->input->post("pageStatusType")), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->mGetPageRequests($pageStatusType));
    }

    public function changeApprovalStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mChangeApprovalStatus());
    }

    public function acceptedPages() {
        $this->authenticate();
        $this->load->view("superadmin/acceptedPageRequests_view");
    }

    public function rejectedPages() {
        $this->authenticate();
        $this->load->view("superadmin/rejectedPageRequests_view");
    }

    public function paymentPages() {
        $this->authenticate();
        $this->load->view("superadmin/paymentPageRequests_view");
    }

    //Page Request End
    //Help Menu Start
    public function helpMenu() {
        $this->authenticate();
        $this->load->view("superadmin/helpMenuView_view");
    }

    public function addhelpcategory() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddhelpcategory());
    }

    public function getHelpCategories() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetHelpCategories());
    }

    public function addhelpsubcategory() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddhelpsubcategory());
    }

    public function addHelpMenu() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddHelpMenu());
    }

    public function getHelpMenu() {
        $this->authenticate();
        $helptextId = FILTER_VAR(trim($this->input->post('helptextId')), FILTER_SANITIZE_STRING);
        $delete = FILTER_VAR(trim($this->input->post('delete')), FILTER_SANITIZE_STRING);
        $start = $this->input->post('start');
        $columns = array(0 => 'tht.helptextId', 1 => "thc.categoryName", 2 => 'tht.heading', 3 => 'tht.helpContent');
        $order = $columns[$this->input->post('order')[0]['column']];
        if ($helptextId != "" && $delete == "") {
            $this->viewMessage($this->Superadmin_model->mGetHelpMenuById($helptextId));
        } else if ($delete == "delete") {
            $this->viewMessage($this->Superadmin_model->mDeleteHelpMenu($helptextId));
        } else {
            $this->viewMessage($this->Superadmin_model->mGetHelpMenu($start, $order));
        }
    }

    //Help Menu End
    //University Controls Start
    public function univControls() {
        $this->authenticate();
        $this->load->view("superadmin/univControls_view");
    }

    public function webLinkStatusUpdate() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mWebLinkStatusUpdate());
    }

    public function collegeControls() {
        $this->authenticate();
        $this->load->view("superadmin/collegeControls_view");
    }

    public function instituteControls() {
        $this->authenticate();
        $this->load->view("superadmin/instituteControls_view");
    }

    public function schoolControls() {
        $this->authenticate();
        $this->load->view("superadmin/schoolControls_view");
    }

    //University Controls End
    //Notifications Start
    public function adminnotifications() {
        $this->authenticate();
        $this->load->view("superadmin/adminNotifications_view");
    }

    public function getAdminNotifications() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetAdminNotifications());
    }

    //Notifications End
    //Marking Type Master Start
    public function markingTypeMaster() {
        $this->authenticate();
        $this->load->view("superadmin/markingTypeMaster_view");
    }

    public function getMarkingTypes() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetMarkingTypes());
    }

    public function addMarkingType() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddMarkingType());
    }

    public function delmarkingType() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelmarkingType());
    }

    //Marking Type Master End
    //Course Fee Type Master Start
    public function courseFeeTypeMaster() {
        $this->authenticate();
        $this->load->view("superadmin/courseFeeTypeMaster_view");
    }

    public function addCourseFeeType() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddCourseFeeType());
    }

    public function getCourseFeeTypes() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetCourseFeeTypes());
    }

    public function delcourseFeeType() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelcourseFeeType());
    }

    //Course Fee Type Master End
    //Currency Master Start
    public function currencyMaster() {
        $this->authenticate();
        $this->load->view("superadmin/CurrencyMaster_view");
    }

    public function addCurrency() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddCurrency());
    }

    public function getCurrency() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetCurrency());
    }

    public function delCurrency() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelCurrency());
    }

    //Currency Master End
    //Department Master Start
    public function departmentMaster() {
        $this->authenticate();
        $this->load->helper('array');
        $orgNames = $this->db->where(["isactive" => 1])->select('orgName,loginId')->get('organization_details');
        ($orgNames->num_rows() > 0 ? $data["orgNames"] = $orgNames->result() : "");
        $this->load->view("superadmin/departmentMaster_view", $data);
    }

    public function addDepartment() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddDepartment());
    }

    public function getDepartment() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetDepartment());
    }

    public function delDepartment() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelDepartment());
    }

    //Department Master End
    //Student Key Skill Master Start
    public function studentKeySkills() {
        $this->authenticate();
        $this->load->view("superadmin/studentKeySkillsMaster_view");
    }

    public function addStudentKeySkills() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddStudentKeySkills());
    }

    public function getStudentKeySkills() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetStudentKeySkills());
    }

    public function delStudentKeySkills() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelStudentKeySkills());
    }

    //Student Key Skill Master End
    //Course Mode Master Start
    public function courseModeMaster() {
        $this->authenticate();
        $this->load->view("superadmin/courseModeMaster_view");
    }

    public function addCourseModeMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddCourseModeMaster());
    }

    public function getCourseModeMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetCourseModeMaster());
    }

    public function delCourseModeMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelCourseModeMaster());
    }

    //Course Mode Master End
    //Exam Mode Master Start
    public function examModeMaster() {
        $this->authenticate();
        $this->load->view("superadmin/examModeMaster_view");
    }

    public function addExamModeMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddExamModeMaster());
    }

    public function getExamModeMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetExamModeMaster());
    }

    public function delExamModeMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelExamModeMaster());
    }

    public function changeExamModeStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mChangeExamModeStatus());
    }

    //Exam Mode Master End
    //Fee Cyce Master Start
    public function feeCycleMaster() {
        $this->authenticate();
        $this->load->view("superadmin/feeCycleMaster_view");
    }

    public function addFeeCycleMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddFeeCycleMaster());
    }

    public function getFeeCycleMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetFeeCycleMaster());
    }

    public function delFeeCycleMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelFeeCycleMaster());
    }

    public function changeFeeCycleStatus() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mChangeFeeCycleStatus());
    }

    //Fee Cyce Master End
    //Subject Master Start
    public function subjectMaster() {
        $this->authenticate();
        $this->load->view("superadmin/subjectMaster_view");
    }

    public function addSubjectMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mAddSubjectMaster());
    }

    public function getSubjectMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mGetSubjectMaster());
    }

    public function delSubjectMaster() {
        $this->authenticate();
        $this->viewMessage($this->Superadmin_model->mDelSubjectMaster());
    }

    //Subject Master End
    /**
     *
     */
    public function paymentGatewayDetails() {
        $this->authenticate();
        $this->load->view("superadmin/payment_Gateway_view");
    }

    public function insertPaymentGatewayDetails() {
        $gateway_name = FILTER_VAR(trim(ucwords($this->input->post('gateway_name'))), FILTER_SANITIZE_STRING);
        $salt = FILTER_VAR(trim($this->input->post('salt')), FILTER_SANITIZE_STRING);
        $apikey = FILTER_VAR(trim($this->input->post('apikey')), FILTER_SANITIZE_STRING);
        $payment_gatewayID = FILTER_VAR(trim($this->input->post('payment_gatewayID')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->mInsertPaymentGatewayDetails($gateway_name, $salt, $apikey, $payment_gatewayID));
    }

    /**
     *
     */
    public function getPaymentGatewaydetails() {
        $payment_gatewayID = FILTER_VAR(trim($this->input->post('payment_gatewayID')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->mGetPaymentGatwaydetails($payment_gatewayID));
    }

    /**
     *
     */
    public function delPaymentGatewayDetails() {
        $payment_gatewayID = FILTER_VAR(trim($this->input->post('payment_gatewayID')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->mDelPaymentGatewayDetails($payment_gatewayID));
    }

    public function setDefault() {
        $payment_gatewayID = FILTER_VAR(trim($this->input->post('payment_gatewayID')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->Superadmin_model->setNewDefault($payment_gatewayID));
    }

    private function authenticate() {
        if (!isset($_SESSION['user_type']) || !isset($_SESSION['id'])) {
            redirect('Register/logout');

            return false;
        } else {
            if ($_SESSION['user_type'] != 'Admin') {
                redirect('Register/logout');

                return false;
            } else {
                return true;
            }
        }
    }

    private function viewMessage($message) {
        $data["message"] = $message;
        $this->load->view("view_message", $data);
    }

}
