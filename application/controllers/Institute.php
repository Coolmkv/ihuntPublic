<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Institute extends CI_Controller {



    public function __construct() {

        parent::__construct();

        $this->load->library('encryption');

        if (function_exists('date_default_timezone_set')) {

            date_default_timezone_set('Asia/Kolkata');

        }

        $this->load->library('image_lib');

        $this->load->model("Institute_model");

        $this->encryption->initialize(

                array(

                    'cipher' => 'aes-256',

                    'mode' => 'ctr'));

    }



    //dashboard start

    public function dashboard() {

        $this->authenticate();

        $details = $this->Institute_model->mgetDashboardDetails();

        if ($details->num_rows() > 0) {

            $data['details'] = $details->row();

        }

        $profilecompleted = $this->Institute_model->mgetProfileCompletion();

        if ($profilecompleted) {

            $data['profilec'] = $profilecompleted;

        }

        ($profilecompleted != "" ? ($profilecompleted < 60 ? redirect('institute/register') : "") : "");



        $this->load->view("institute/institute_dashboard_view", $data);

    }



    //dashboard end

    //Institute profile start

    public function profile() {

        $this->authenticate();

        $qry = $this->Institute_model->getProfileInfo();

        if ($qry) {

            $data["profileData"] = $qry;

        } else {

            $data = "";

        }

        $this->load->view("institute/institute_profile_view", $data);

    }



    public function getProfileData() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->getProfileJson());

    }



    public function uploadProfileImage() {

        $this->authenticate();

        $qry = $this->Institute_model->mUploadProfileImage();

        if ($qry == "updated") {

            redirect("institute/profile");

        }

    }



    public function uploadHeaderImage() {

        $this->authenticate();

        $qry = $this->Institute_model->mUploadHeaderImage();

        if ($qry == "updated") {

            redirect("institute/profile");

        }

    }



    public function editprofile() {

        $this->authenticate();

        $qry = $this->Institute_model->getProfileInfo();



        if ($qry) {

            $data["profileData"] = $qry;

        } else {

            $data = "";

        }

        $this->load->view("institute/institute_profile_edit_view", $data);

    }



    public function orgFacilities() {

        $data = [];

        $orgf = $this->Institute_model->getOrgFacilities('0');

        if ($orgf->num_rows() > 0) {

            $data["orgFacilities"] = $orgf->result();

        }

        $orgfp = $this->Institute_model->getOrgFacilities('1');

        if ($orgf->num_rows() > 0) {

            $data["orgFacilitiesp"] = $orgfp->result();

        }

        $orgfa = $this->Institute_model->getOrgFacilities('2');

        if ($orgf->num_rows() > 0) {

            $data["orgFacilitiesa"] = $orgfa->result();

        }

        $this->load->view("institute/orgFacilitiesView", $data);

    }



    public function financialDetails() {

        $this->authenticate();

        $this->load->library('googlemaps');

        $config['places'] = TRUE;

        $config['placesAutocompleteInputID'] = 'bank_address';

        $config['placesAutocompleteBoundsMap'] = TRUE;

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();



        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "Institute"])->get("tbl_financial_details");

        if ($details->num_rows() > 0) {

            $res = $details->row();

            $res->credit_card_no = ($res->credit_card_no === "" ? NULL : $this->encryption->decrypt($res->credit_card_no));

            $res->creditcard_cvv = ($res->creditcard_cvv === "" ? NULL : $this->encryption->decrypt($res->creditcard_cvv));

            $res->debit_card_no = ($res->debit_card_no === "" ? NULL : $this->encryption->decrypt($res->debit_card_no));

            $res->debitcard_cvv = ($res->debitcard_cvv === "" ? NULL : $this->encryption->decrypt($res->debitcard_cvv));

            $res->bank_account_no = ($res->bank_account_no === "" ? NULL : $this->encryption->decrypt($res->bank_account_no));

            $data["details"] = $res;

        }

        $currencies = $this->Institute_model->mGetcurrencies();

        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : '');

        $this->load->view("institute/financial_details_view", $data);

    }



    public function saveFinancialDetails() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mSaveFinancialDetails("showmessage"));

    }



    public function requestFacility() {

        $this->authenticate();

        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);

        $fac_icon = FILTER_VAR(trim($this->input->post('fac_icon')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->Institute_model->mRequestFacility($title, $fac_icon));

    }



    public function updateProfile() {

        $this->authenticate();

        $directorName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('directorName')))), FILTER_SANITIZE_STRING);

        $directorMobile = FILTER_VAR(trim($this->input->post('directorMobile')), FILTER_SANITIZE_NUMBER_INT);

        $directorEmail = FILTER_VAR(trim($this->input->post('directorEmail')), FILTER_SANITIZE_EMAIL);

        $orgName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('orgName')))), FILTER_SANITIZE_STRING);

        $orgMobile = FILTER_VAR(trim($this->input->post('orgMobile')), FILTER_SANITIZE_NUMBER_INT);

        $countryId = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_NUMBER_INT);

        $stateId = FILTER_VAR(trim($this->input->post('stateId')), FILTER_SANITIZE_NUMBER_INT);

        $cityId = FILTER_VAR(trim($this->input->post('cityId')), FILTER_SANITIZE_NUMBER_INT);

        $orgType = FILTER_VAR(trim($this->input->post('orgType')), FILTER_SANITIZE_STRING);

        $orgGoogle = $this->input->post('orgGoogle');

        $this->viewMessage($this->Institute_model->mupdateProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType, $orgGoogle));

    }



    public function saveProfile() {

        $this->authenticate();

        $directorName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('directorName')))), FILTER_SANITIZE_STRING);

        $directorMobile = FILTER_VAR(trim($this->input->post('directorMobile')), FILTER_SANITIZE_NUMBER_INT);

        $directorEmail = FILTER_VAR(trim($this->input->post('directorEmail')), FILTER_SANITIZE_EMAIL);

        $orgName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('orgName')))), FILTER_SANITIZE_STRING);

        $orgMobile = FILTER_VAR(trim($this->input->post('orgMobile')), FILTER_SANITIZE_NUMBER_INT);

        $countryId = FILTER_VAR(trim($this->input->post('orgcountryId')), FILTER_SANITIZE_NUMBER_INT);

        $stateId = FILTER_VAR(trim($this->input->post('orgstateId')), FILTER_SANITIZE_NUMBER_INT);

        $cityId = FILTER_VAR(trim($this->input->post('orgcityId')), FILTER_SANITIZE_NUMBER_INT);

        $orgType = FILTER_VAR(trim($this->input->post('orgType')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->Institute_model->msaveProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType));

    }



    public function orgUser() {

        $this->authenticate();

        $data[] = "";

        $this->load->library('googlemaps');

        $config['places'] = TRUE;

        $config['placesAutocompleteInputID'] = 'cp_address';

        $config['placesAutocompleteBoundsMap'] = TRUE;

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $this->load->view("institute/institute_concerned_person_view", $data);

    }



    public function getConcernedPersonDetails() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->getOrgConcernedPerson());

    }



    public function delConcernedPerson() {

        $this->authenticate();

        $this->Institute_model->mDelConcernedPerson();

    }



    public function addConcernedPersonDetails() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mAddConcernedPersonDetails());

    }



    public function approvalDocuments() {

        $this->authenticate();

        $qry = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_orgapproval_doc");

        ($qry->num_rows() > 0 ? $data["adocs"] = $qry->result() : $data["error"] = "");

        $this->load->view("institute/orgApprovalDocument_view", $data);

    }



    public function uploadApprovalDocs() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mUploadApprovalDocs());

    }



    public function uploadedDocument() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mUploadedDocument());

    }



    public function deletedocument() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDeletedocument());

    }



    public function sliderImages() {

        $this->authenticate();

        $gitems = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_org_sliders");

        if ($gitems->num_rows() > 0) {

            $data['gimages'] = $gitems->result();

        } else {

            $data = "";

        }

        $this->load->view("institute/addSliderImages", $data);

    }



    public function addSliderImage() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mAddSliderImage());

    }



    public function updateSliderImage() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mUpdateSliderImage());

    }



    public function deleteSliderImage() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDeleteSliderImage());

    }



    public function setDefaultImage() {

        $this->authenticate();

        $headerId = FILTER_VAR(trim($this->input->post('headerId')), FILTER_SANITIZE_STRING);

        $type = FILTER_VAR(trim($this->input->post('type')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->Institute_model->mSetDefaultImage($type, $headerId));

    }



    public function profileHeaders() {

        $this->authenticate();

        $data1 = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_headerimagevideo");

        ($data1->num_rows() > 0 ? $data["headerImage"] = $data1->result() : $data["error"] = "");

        $qry = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->select("orgImgHeader,orgVideo")->get("organization_details");

        ($qry->num_rows() > 0 ? $data["defaultImage"] = $qry->row() : $data["error"] = "");

        $this->load->view("institute/addProfileheaders_view", $data);

    }



    public function uploadheaderImageVideo() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->uploadheaderImageVideo());

    }



    public function deleteHeaderImage() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDeleteHeaderImage());

    }



    //Institute profile end

    //addPages start

    public function addPages() {

        $this->authenticate();

        $this->load->view("institute/addPages_view");

    }



    public function showPages() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mshowPages());

    }



    public function addNewPages() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddNewPages());

    }



    public function delPages() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDelPages());

    }



    public function submitForApproval() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mSubmitForApproval());

    }



    //addPages End

    //addCourse start

    public function addCourse() {

        $this->authenticate();

        $this->load->view("institute/addCourse_view");

    }



    public function getTimeDuration() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetTimeDuration());

    }



    public function getMinQualification() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetMinQualification());

    }



    public function getCourseType() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetCourseType());

    }



    public function getcourseTypeBycourse() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetcourseTypeBycourse());

    }



    public function addSaveCourse() {

        $this->authenticate();

        $minage = FILTER_VAR(trim($this->input->post('minage')), FILTER_SANITIZE_STRING);

        $maxage = FILTER_VAR(trim($this->input->post('maxage')), FILTER_SANITIZE_STRING);

        $validupto = FILTER_VAR(trim($this->input->post('validupto')), FILTER_SANITIZE_STRING);

        $examMode = FILTER_VAR(trim($this->input->post('examMode')), FILTER_SANITIZE_STRING);

        $examDetails = FILTER_VAR(trim($this->input->post('examDetails')), FILTER_SANITIZE_STRING);

        $examDate = FILTER_VAR(trim($this->input->post('examDate')), FILTER_SANITIZE_STRING);

        $resultDate = FILTER_VAR(trim($this->input->post('examDate')), FILTER_SANITIZE_STRING);

        $feeCycle = FILTER_VAR(trim($this->input->post('feeCycle')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->Institute_model->mAddCourse($minage, $maxage, $validupto, $examMode, $examDetails, $examDate, $resultDate, $feeCycle));

    }



    public function getCourses() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetCourses());

    }



    public function editCourses() {

        $this->authenticate();

        $this->viewMessage(json_encode($this->Institute_model->mEditCourses()));

//        if ($qry) {

//            $data["OrgCourse"] = $qry;

//            $this->load->view("institute/editCourseView", $data);

//        } else {

//            echo 'Nodata';

//        }

    }



    public function deleteCourse() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mdeleteCourse());

    }



    public function addCourseType() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mAddCourseType());

    }



    public function getCourseDurationType() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetCourseDurationType());

    }



    public function addType() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mAddType());

    }



    //addCourse end

    //Eligibility Start

    public function eligibility() {

        $this->authenticate();

        $this->load->view("institute/addShowEligibility_view");

    }



    public function getClassType() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetClassType());

    }



    public function addEligibility() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddEligibility());

    }



    public function showEligibility() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mShowEligibility());

    }



    public function delEligibility() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDelEligibility());

    }



    //Eligibility End

    //Brochure starts

    public function showBrochure() {

        $this->authenticate();

        $this->load->view("institute/showBrochures_view");

    }



    public function brochuresTable() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mbrochuresTable());

    }



    public function addBrochures() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddBrochures());

    }



    public function delBrochures() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mdelBrochures());

    }



    //Brochure ends

    //Gallery Start

    public function addGallery() {

        $this->authenticate();

        $gitems = $this->Institute_model->mGetGalleryData();

        if ($gitems->num_rows() > 0) {

            $data['gimages'] = $gitems->result();

        } else {

            $data = "";

        }

        $this->load->view("institute/addGallery_view", $data);

    }



    public function deleteGalleryImage() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mdeleteGalleryImage());

    }



    public function addNewGalleryImage() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddNewGalleryImage());

    }



    //Gallery End

    //Event Start

    public function event() {

        $this->authenticate();

        $this->load->library('googlemaps');

        $config['places'] = TRUE;

        $config['placesAutocompleteInputID'] = 'address';

        $config['placesAutocompleteBoundsMap'] = TRUE;

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $this->load->view("institute/addShowEvent_view", $data);

    }



    public function addEvent() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddEvent());

    }



    public function getEvents() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetEvents());

    }



    public function delEvent() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mdelEvent());

    }



    //Event End

    //News Start

    public function news() {

        $this->authenticate();

        $this->load->view("institute/addShowNews_view");

    }



    public function getNews() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetNews());

    }



    public function addNews() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddNews());

    }



    public function delNews() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mdelNews());

    }



    //News End

    //Placement Start

    public function placement() {

        $this->authenticate();

        $currencies = $this->Institute_model->mGetcurrencies();

        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : $data['err'] = '');

        $this->load->view("institute/addShowPlacement_view", $data);

    }



    public function getPlacement() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetPlacement());

    }



    public function addPlacement() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddPlacement());

    }



    public function delPlacement() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mdelPlacement());

    }



    public function placedStudents() {

        $this->authenticate();

        $currencies = $this->Institute_model->mGetcurrencies();

        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : $data['err'] = '');

        $this->load->view("institute/addShowPlacedStudent_view", $data);

    }



    public function addPlacedStudent() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mAddPlacedStudent());

    }



    public function placedStudentRecords() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mPlacedStudentRecords());

    }



    public function delPlacedStudent() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDelPlacedStudent());

    }



    //placement End

    //Achievment Start

    public function achievement() {

        $this->authenticate();

        $this->load->view("institute/addShowAchievement_view");

    }



    public function addAchievement() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddAchievement());

    }



    public function getAchievement() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetAchievement());

    }



    public function delAchievement() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mdelAchievement());

    }



    //Achievment End

    //Faculty Start

    public function faculty() {

        $this->authenticate();

        $this->load->library('googlemaps');

        $config['places'] = TRUE;

        $config['placesAutocompleteInputID'] = 'address';

        $config['placesAutocompleteBoundsMap'] = TRUE;

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $this->load->view("institute/addShowFaculty_view", $data);

    }



    public function addFaculty() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->maddFaculty());

    }



    public function getFaculty() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetFaculty());

    }



    public function delFaculty() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mdelFaculty());

    }



    //Faculty End

    //Running Status Start

    public function runningStatus() {

        $this->authenticate();

        $this->load->view("institute/addShowRunningStatus_view");

    }



    public function addRunningStatus() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mRunningStatus());

    }



    public function getRunningStatus() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetRunningStatus());

    }



    public function delRunningStatus() {

        $this->authenticate();

        $this->Institute_model->mdelRunningStatus();

    }



    //Running Status End

    //Advertisement  starts created by shweta



    /*     * ** for Plan details *** */



    public function getPlandetailsJson() {

        $this->authenticate();

        $this->Institute_model->mGetdetailsofPlan();

    }



    public function advertisement() {

        $this->authenticate();

        $this->load->view("institute/addShowAdvertisement_view");

    }



    public function addAdvertisement() {

        $this->authenticate();

        $this->Institute_model->maddAdvertisement();

    }



    public function getAdvertisement() {

        $this->authenticate();

        $this->Institute_model->mgetAdvertisement();

    }



    public function delAdvertisement() {

        $this->authenticate();

        $this->Institute_model->mdelAdvertisement();

    }



    public function updateTime() {

        $this->authenticate();

        $this->Institute_model->mUpdateStartDate();

    }



    //Advertisement End

    //News letter plan buy start by shweta

    public function getNewsLetterPlandetailsJson() {

        $this->authenticate();

        $this->Institute_model->mGetdetailsofNewsLetterPlan();

    }



    public function newsletterplanbuy() {

        $this->authenticate();

        $this->load->view("institute/news_letter_plan_buy_view");

    }



    public function addnewsletterplanbuy() {

        $this->authenticate();

        $this->Institute_model->mAddnewsletterplanbuy();

    }



    public function getnewsletterplanbuy() {

        $this->authenticate();

        $this->Institute_model->mGetnewsletterplanbuy();

    }



    public function changeStatusNlpb() {

        $this->authenticate();

        $this->Institute_model->mchangeNlpbStatus();

    }



    //News letter plan buy end by shweta

    //Satrt send_news_letter by shweta

    public function getnewsletteremailJson() {

        $this->authenticate();

        $this->Institute_model->mGetnewsletteremail();

    }



    public function uploadnewsltremailexcel() {

        $this->authenticate();

        $this->Institute_model->muploadnewsltremailexcel();

    }



    public function sendnewsletter() {

        $this->authenticate();

        $this->load->view("institute/send_news_letter_view");

    }



    public function emailnewsletter() {

        $this->authenticate();

        $this->Institute_model->mEmailnewsletter();

    }



    //End send_news_letter by shweta

    //register start  by shweta

    public function register() {

        $this->authenticate();

        $bYb = $this->db->where("isactive", 1)->get("tbl_beforyoubegin");

        ($bYb->num_rows() > 0 ? $data["beforeYouBegin"] = $bYb->row() : $data["error"] = "");

        $this->load->view("home/institute_register_view", $data);

    }



    public function registerform() {

        $this->authenticate();

        $this->load->library('googlemaps');

        $config = ["places" => TRUE, "placesAutocompleteInputID" => "orgaddress", "placesAutocompleteBoundsMap" => TRUE];

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $qry = $this->Institute_model->getProfileInfo();

        ($qry ? $data['profileData'] = $qry : $data['error'] = '');

        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "Institute"])->get("tbl_financial_details");

        if ($details->num_rows() > 0) {

            $res = $details->row();

            $res->credit_card_no = ($res->credit_card_no === "" ? NULL : $this->encryption->decrypt($res->credit_card_no));

            $res->creditcard_cvv = ($res->creditcard_cvv === "" ? NULL : $this->encryption->decrypt($res->creditcard_cvv));

            $res->debit_card_no = ($res->debit_card_no === "" ? NULL : $this->encryption->decrypt($res->debit_card_no));

            $res->debitcard_cvv = ($res->debitcard_cvv === "" ? NULL : $this->encryption->decrypt($res->debitcard_cvv));

            $res->bank_account_no = ($res->bank_account_no === "" ? NULL : $this->encryption->decrypt($res->bank_account_no));

            $data["details"] = $res;

        }

        $currencies = $this->Institute_model->mGetcurrencies();

        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : '');

        $this->load->view("home/institute_register_form_view", $data);

    }



    //register end by shweta

    //Change Password Start

    public function changePassword() {

        $this->authenticate();

        $this->load->view("institute/change_password_view");

    }



    public function changePasswordSave() {

        $this->authenticate();

        $this->Institute_model->mchangePasswordSave();

    }



    //Change Password End

    //Analytics Start

    public function analytics() {

        $this->authenticate();

        $qry = $this->Institute_model->mGetViewCounts();

        ($qry ? $data["visits"] = $qry : $data["error"] = "");



        $this->load->view("institute/analytics_view", $data);

    }



    //Analytics End

    //Enrollments start

    public function enrollments() {

        $this->authenticate();

        $this->load->view("institute/enrollments_view");

    }



    public function getEnrollApplications() {

        $this->authenticate();

        $this->Institute_model->mGetEnrollApplications();

    }



    public function changeStatus() {

        $this->authenticate();

        $enrollmentId = FILTER_VAR(trim($this->input->post('enrollmentId')), FILTER_SANITIZE_STRING);

        $status = FILTER_VAR(trim($this->input->post('status')), FILTER_SANITIZE_STRING);

        $message = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);



        $this->viewMessage($this->Institute_model->mChangeStatus($enrollmentId, $status, $message));

    }



    //Enrollments end

    //enquiries start

    public function enquiries() {

        $this->authenticate();

        $this->load->view("institute/enquiries_view");

    }



    public function getenquiriesApplications() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetEnquiryApplications());

    }



    //enquiries end

    //PromoCode Start

    public function promoCodes() {

        $this->authenticate();

        $qry = $this->Institute_model->mGetPomoCodePrice();

        ($qry ? $data['price'] = $qry : $data["error"] = "");

        $this->load->view("institute/promoCodes_view", $data);

    }



    public function getPromocode() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetPromocode());

    }



    public function getCourseNames() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetCourseNames());

    }



    public function addPromocode() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mAddPromocode());

    }



    public function delPromocode() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDelPromocode());

    }



    //PromoCode End

    //Add new organisation type start

    public function addNewOrganisationType() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mAddNewOrganisationType());

    }



    //Add new organisation type end

    //testimonial start

    public function addTestimonials() {

        $this->authenticate();

        $this->load->view("institute/add_Testimonials_view");

    }



    public function getTestimonials() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetTestimonials());

    }



    public function editTestimonials() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->meditTestimonials());

    }



    public function delTestimonial() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDelTestimonial());

    }



    public function getBlogCategories() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mgetBlogCategories());

    }



    public function delBlogCategory() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDelBlogCategory());

    }



    //testimonial End

    //blog start

    public function addBlog() {

        $this->authenticate();

        $this->load->view("institute/createBlog_view");

    }



    public function insertBlogs() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mInsertBlogs());

    }



    public function getBlogsDetails() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetBlogsDetails());

    }



    public function delBlog() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mDelBlog());

    }



    //blog end

    //notifications Start

    public function notifications() {

        $this->authenticate();

        $this->load->view("institute/notifications_view");

    }



    public function getNotifications() {

        $this->authenticate();

        $this->viewMessage($this->Institute_model->mGetNotification());

    }



    public function sendNotifications() {

        $this->authenticate();

        $reference = FILTER_VAR(trim($this->input->post('reference')), FILTER_SANITIZE_STRING);

        $message = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);

        $emailSend = FILTER_VAR(trim($this->input->post('emailSend')), FILTER_SANITIZE_STRING);

        $orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->Institute_model->mSendNotifications($reference, $message, $emailSend, $orgId));

    }



    //notifications end

    private function viewMessage($message) {

        $data["message"] = $message;

        $this->load->view("view_message", $data);

    }

    public function addUpdateCourse(){
        if($this->authenticate()){
    		$this->load->model("CourseMasterModel");
			$organisation_courses =  $this->CourseMasterModel->getAllCourses();
			$data = [];
			if($organisation_courses->num_rows()>0){
				$data = ["organisation_courses"=>$organisation_courses->result()];
			} 
			$this->load->view("institute/addNewCourseInstitute_view",$data);
		}else{
    		redirect("");
		}
    }
    public function addUpdateNewCourse(){
		if($this->authenticate()){
            $this->load->model("OrganisationCoursesModal");			
			$message = $this->OrganisationCoursesModal->saveOrganisationsCourses();
			$this->viewMessage(json_encode($message));
		}else{
			redirect("");
		}
	}

    public function getAllCourseDetails(){
        if($this->authenticate()){		
            $this->load->model("OrganisationCoursesModal");	
			$this->OrganisationCoursesModal->getOrganisationCourses();
		}else{
			redirect("");
		}
    }

    public function editCourseMaster(){
        if($this->authenticate()){
            $this->load->model("OrganisationCoursesModal");			
			$message = $this->OrganisationCoursesModal->updateCourse();
			$this->viewMessage(json_encode($message));
		}else{
			$this->viewMessage(json_encode(unAuthenticMessage()));
		}
    }

    public function deleteCourseMasterEntry(){
        if($this->authenticate()){
            $this->load->model("OrganisationCoursesModal");			
			$message = $this->OrganisationCoursesModal->deleteCourse();
			$this->viewMessage(json_encode($message));
		}else{
			$this->viewMessage(json_encode(unAuthenticMessage()));
		}
    }
    private function authenticate() {

        if (!isset($_SESSION['userType']) || !isset($_SESSION['loginId'])) {

            redirect('Register/logout');

            return false;

        } else {

            if ($_SESSION['userType'] != 'Institute') {

                redirect('Register/logout');

                return false;

            } else {

                return true;

            }

        }

    }



}

