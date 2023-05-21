<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class School extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set('Asia/Kolkata');
        }
        $this->load->library('image_lib');
        $this->load->model("School_model");
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr'));
    }

    //dashboard start
    public function dashboard() {
        $this->authenticate();
        $details = $this->School_model->mgetDashboardDetails();
        if ($details) {
            $data['details'] = $details;
        }
        $profilecompleted = $this->School_model->mgetProfileCompletion();
        if ($profilecompleted) {
            $data['profilec'] = $profilecompleted;
        }
        ($profilecompleted != "" ? ($profilecompleted < 60 ? redirect('school/register') : "") : "");
        $this->load->view("school/school_dashboard_view", $data);
    }

    //dashboard end
    //school profile start
    public function profile() {
        $this->authenticate();
        $qry = $this->School_model->getProfileInfo();
        if ($qry) {
            $data["profileData"] = $qry;
        } else {
            $data = "";
        }
        $this->load->view("school/school_profile_view", $data);
    }

    public function getProfileData() {
        $this->authenticate();
        $this->viewMessage($this->School_model->getProfileJson());
    }

    public function uploadProfileImage() {
        $this->authenticate();
        $qry = $this->School_model->mUploadProfileImage();
        if ($qry == "updated") {
            redirect("school/profile");
        }
    }

    public function uploadHeaderImage() {
        $this->authenticate();
        $qry = $this->School_model->mUploadHeaderImage();
        if ($qry == "updated") {
            redirect("school/profile");
        }
    }

    public function editprofile() {
        $this->authenticate();

        $qry = $this->School_model->getProfileInfo();
        if ($qry) {
            $data["profileData"] = $qry;
        } else {
            $data = "";
        }
        $this->load->view("school/school_profile_edit_view", $data);
    }

    public function orgFacilities() {
        $data = [];
        $orgf = $this->School_model->getOrgFacilities('0');
        if ($orgf) {
            $data["orgFacilities"] = $orgf;
        }
        $orgfp = $this->School_model->getOrgFacilities('1');
        if ($orgfp) {
            $data["orgFacilitiesp"] = $orgfp;
        }
        $orgfa = $this->School_model->getOrgFacilities('2');
        if ($orgfa) {
            $data["orgFacilitiesa"] = $orgfa;
        }
        $this->load->view("school/orgFacilitiesView", $data);
    }

    public function requestFacility() {
        $this->authenticate();

        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $fac_icon = FILTER_VAR(trim($this->input->post('fac_icon')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->School_model->mRequestFacility($title, $fac_icon));
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
        $orgWebsite = FILTER_VAR(trim($this->input->post('orgWebsite')), FILTER_SANITIZE_STRING);
        $approvedBy = FILTER_VAR(trim($this->input->post('approvedBy')), FILTER_SANITIZE_STRING);
        $orgaddress = FILTER_VAR(trim($this->input->post('address')), FILTER_SANITIZE_STRING);
        $facility = $this->input->post('facility');
        $message = $this->School_model->mupdateProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType, $orgGoogle, $orgWebsite, $approvedBy, $orgaddress, $facility);
        $this->viewMessage($message);
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
        $orgGoogle = $this->input->post('orgGoogle');
        $orgWebsite = FILTER_VAR(trim($this->input->post('orgWebsite')), FILTER_SANITIZE_STRING);

        $message = $this->School_model->msaveProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType, $orgGoogle, $orgWebsite);
        $this->viewMessage($message);
    }

    public function orgUser() {
        $this->authenticate();
        $data[""] = "";
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'cp_address';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->load->view("school/school_concerned_person_view", $data);
    }

    public function getConcernedPersonDetails() {
        $this->authenticate();
        $this->viewMessage($this->School_model->getOrgConcernedPerson());
    }

    public function delConcernedPerson() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDelConcernedPerson());
    }

    public function addConcernedPersonDetails() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mAddConcernedPersonDetails());
    }

    public function approvalDocuments() {
        $this->authenticate();
        $qry = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_orgapproval_doc");
        ($qry->num_rows() > 0 ? $data["adocs"] = $qry->result() : $data["error"] = "");
        $this->load->view("school/orgApprovalDocument_view", $data);
    }

    public function uploadApprovalDocs() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mUploadApprovalDocs());
    }

    public function uploadedDocument() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mUploadedDocument());
    }

    public function deletedocument() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDeletedocument());
    }

    public function sliderImages() {
        $this->authenticate();
        $gitems = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_org_sliders");
        if ($gitems->num_rows() > 0) {
            $data['gimages'] = $gitems->result();
        } else {
            $data = "";
        }
        $this->load->view("school/addSliderImages", $data);
    }

    public function addSliderImage() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mAddSliderImage());
    }

    public function updateSliderImage() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mUpdateSliderImage());
    }

    public function deleteSliderImage() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDeleteSliderImage());
    }

    public function setDefaultImage() {
        $this->authenticate();
        $headerId = FILTER_VAR(trim($this->input->post('headerId')), FILTER_SANITIZE_STRING);
        $type = FILTER_VAR(trim($this->input->post('type')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->School_model->mSetDefaultImage($type, $headerId));
    }

    public function profileHeaders() {
        $this->authenticate();
        $data1 = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_headerimagevideo");
        ($data1->num_rows() > 0 ? $data["headerImage"] = $data1->result() : $data["error"] = "");
        $qry = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->select("orgImgHeader,orgVideo")->get("organization_details");
        ($qry->num_rows() > 0 ? $data["defaultImage"] = $qry->row() : $data["error"] = "");
        $this->load->view("school/addProfileheaders_view", $data);
    }

    public function uploadheaderImageVideo() {
        $this->authenticate();
        $this->viewMessage($this->School_model->uploadheaderImageVideo());
    }

    public function deleteHeaderImage() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDeleteHeaderImage());
    }

    //school profile end
    //addPages start
    public function addPages() {
        $this->authenticate();
        $this->load->view("school/addPages_view");
    }

    public function showPages() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mshowPages());
    }

    public function financialDetails() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'bank_address';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();

        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "School"])->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            $res = $details->row();
            $res->credit_card_no = ($res->credit_card_no === "" ? NULL : $this->encryption->decrypt($res->credit_card_no));
            $res->creditcard_cvv = ($res->creditcard_cvv === "" ? NULL : $this->encryption->decrypt($res->creditcard_cvv));
            $res->debit_card_no = ($res->debit_card_no === "" ? NULL : $this->encryption->decrypt($res->debit_card_no));
            $res->debitcard_cvv = ($res->debitcard_cvv === "" ? NULL : $this->encryption->decrypt($res->debitcard_cvv));
            $res->bank_account_no = ($res->bank_account_no === "" ? NULL : $this->encryption->decrypt($res->bank_account_no));
            $data["details"] = $res;
        }
        $currencies = $this->School_model->mGetcurrencies();
        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : '');
        $this->load->view("school/financial_details_view", $data);
    }

    public function saveFinancialDetails() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mSaveFinancialDetails("showmessage"));
    }

    public function addNewPages() {
        $this->authenticate();
        $this->viewMessage($this->School_model->maddNewPages());
    }

    public function delPages() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDelPages());
    }

    public function submitForApproval() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mSubmitForApproval());
    }

    public function getMinQualification() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetMinQualification());
    }

    //addPages End
    //addClasses start
    public function addClasses() {
        $this->authenticate();
        $this->load->view("school/addClasses_view");
    }

    public function getSchoolClassType() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetSchoolClassType());
    }

    public function addSaveClasses() {
        $this->authenticate();
        $class = FILTER_VAR(trim($this->input->post('class')), FILTER_SANITIZE_STRING);
        $classType = FILTER_VAR(trim($this->input->post('classType')), FILTER_SANITIZE_STRING);
        $courseDurationType = FILTER_VAR(trim($this->input->post('courseDurationType')), FILTER_SANITIZE_STRING);
        $courseFee = FILTER_VAR(trim($this->input->post('courseFee')), FILTER_SANITIZE_STRING);
        $feeCycle = FILTER_VAR(trim($this->input->post('feeCycle')), FILTER_SANITIZE_STRING);
        $totalSheet = FILTER_VAR(trim($this->input->post('totalSheet')), FILTER_SANITIZE_STRING);
        $availableSheet = FILTER_VAR(trim($this->input->post('availableSheet')), FILTER_SANITIZE_STRING);
        $registrationFee = FILTER_VAR(trim($this->input->post('registrationFee')), FILTER_SANITIZE_STRING);
        $fromDate = FILTER_VAR(trim($this->input->post('fromDate')), FILTER_SANITIZE_STRING);
        $toDate = FILTER_VAR(trim($this->input->post('toDate')), FILTER_SANITIZE_STRING);
        $openingDate = FILTER_VAR(trim($this->input->post('openingDate')), FILTER_SANITIZE_STRING);
        $closingDate = FILTER_VAR(trim($this->input->post('closingDate')), FILTER_SANITIZE_STRING);
        $applicationFee = FILTER_VAR(trim($this->input->post('applicationFee')), FILTER_SANITIZE_STRING);
        $minage = FILTER_VAR(trim($this->input->post('minage')), FILTER_SANITIZE_STRING);
        $maxage = FILTER_VAR(trim($this->input->post('maxage')), FILTER_SANITIZE_STRING);
        $validupto = FILTER_VAR(trim($this->input->post('validupto')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->School_model->maddSaveClasses($class, $classType, $courseDurationType, $courseFee, $feeCycle, $totalSheet, $availableSheet, $registrationFee, $fromDate, $toDate, $openingDate, $closingDate, $applicationFee, $minage, $maxage, $validupto));
    }

    public function getClasses() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetClasses());
    }

    public function deleteClasses() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mdeleteClasses());
    }

    public function getClassNames() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetClassNames());
    }

    public function getCourseDurationType() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetCourseDurationType());
    }

    public function addType() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mAddType());
    }

    //addClasses end
    //Brochure starts
    public function showBrochure() {
        $this->authenticate();
        $this->load->view("school/showBrochures_view");
    }

    public function brochuresTable() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mbrochuresTable());
    }

    public function addBrochures() {
        $this->authenticate();
        $this->viewMessage($this->School_model->maddBrochures());
    }

    public function delBrochures() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mdelBrochures());
    }

    //Brochure ends
    //Gallery Start
    public function addGallery() {
        $this->authenticate();
        $gitems = $this->School_model->mGetGalleryData();
        if ($gitems->num_rows() > 0) {
            $data['gimages'] = $gitems->result();
        } else {
            $data = "";
        }
        $this->load->view("school/addGallery_view", $data);
    }

    public function deleteGalleryImage() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mdeleteGalleryImage());
    }

    public function addNewGalleryImage() {
        $this->authenticate();
        $this->viewMessage($this->School_model->maddNewGalleryImage());
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
        $this->load->view("school/addShowEvent_view", $data);
    }

    public function addEvent() {
        $this->authenticate();
        $this->viewMessage($this->School_model->maddEvent());
    }

    public function getEvents() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mgetEvents());
    }

    public function delEvent() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mdelEvent());
    }

    //Event End
    //Faculty Start
    public function faculty() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'address';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->load->view("school/addShowFaculty_view", $data);
    }

    public function addFaculty() {
        $this->authenticate();
        $this->viewMessage($this->School_model->maddFaculty());
    }

    public function getFaculty() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mgetFaculty());
    }

    public function delFaculty() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mdelFaculty());
    }

    //Faculty End
    //News Start
    public function news() {
        $this->authenticate();
        $this->load->view("school/addShowNews_view");
    }

    public function getNews() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mgetNews());
    }

    public function addNews() {
        $this->authenticate();
        $this->viewMessage($this->School_model->maddNews());
    }

    public function delNews() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mdelNews());
    }

    //News End
    //Achievment Start
    public function achievement() {
        $this->authenticate();
        $this->load->view("school/addShowAchievement_view");
    }

    public function addAchievement() {
        $this->authenticate();
        $this->viewMessage($this->School_model->maddAchievement());
    }

    public function getAchievement() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mgetAchievement());
    }

    public function delAchievement() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mdelAchievement());
    }

    //Achievment End
    //Running Status Start
    public function runningStatus() {
        $this->authenticate();
        $this->load->view("school/addShowRunningStatus_view");
    }

    public function addRunningStatus() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mRunningStatus());
    }

    public function getRunningStatus() {
        if ($this->authenticate()) {
            $this->viewMessage($this->School_model->mgetRunningStatus());
        } else {
            $this->viewMessage('{"status":"logout","msg":"unauthorised"}');
        }
    }

    public function delRunningStatus() {
        if ($this->authenticate()) {
            $this->viewMessage($this->School_model->mdelRunningStatus());
        } else {
            $this->viewMessage('{"status":"logout","msg":"unauthorised"}');
        }
    }

    //Running Status End
    //Advertisement  starts created by shweta

    /*     * ** for Plan details *** */

    public function getPlandetailsJson() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetdetailsofPlan());
    }

    public function advertisement() {
        $this->authenticate();
        $this->load->view("school/addShowAdvertisement_view");
    }

    public function addAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->School_model->maddAdvertisement());
    }

    public function getAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mgetAdvertisement());
    }

    public function delAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mdelAdvertisement());
    }

    public function updateTime() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mUpdateStartDate());
    }

    //Advertisement End
    //News letter plan buy start by shweta
    public function getNewsLetterPlandetailsJson() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetdetailsofNewsLetterPlan());
    }

    public function newsletterplanbuy() {
        $this->authenticate();
        $this->load->view("school/news_letter_plan_buy_view");
    }

    public function addnewsletterplanbuy() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mAddnewsletterplanbuy());
    }

    public function getnewsletterplanbuy() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetnewsletterplanbuy());
    }

    public function changeStatusNlpb() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mchangeNlpbStatus());
    }

    //News letter plan buy end by shweta
    //Satrt send_news_letter by shweta
    public function getnewsletteremailJson() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetnewsletteremail());
    }

    public function uploadnewsltremailexcel() {
        $this->authenticate();
        $this->viewMessage($this->School_model->muploadnewsltremailexcel());
    }

    public function sendnewsletter() {
        $this->authenticate();
        $this->load->view("school/send_news_letter_view");
    }

    public function emailnewsletter() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mEmailnewsletter());
    }

    //End send_news_letter by shweta
    //register start  by shweta
    public function register() {
        $this->authenticate();
        $bYb = $this->db->where("isactive", 1)->get("tbl_beforyoubegin");
        ($bYb->num_rows() > 0 ? $data["beforeYouBegin"] = $bYb->row() : $data["error"] = "");
        $this->load->view("home/school_register_view", $data);
    }

    public function registerform() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config = ["places" => TRUE, "placesAutocompleteInputID" => "orgaddress", "placesAutocompleteBoundsMap" => TRUE];
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $qry = $this->School_model->getProfileInfo();
        ($qry ? $data['profileData'] = $qry : $data['error'] = '');
        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "School"])->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            $res = $details->row();
            $res->credit_card_no = ($res->credit_card_no === "" ? NULL : $this->encryption->decrypt($res->credit_card_no));
            $res->creditcard_cvv = ($res->creditcard_cvv === "" ? NULL : $this->encryption->decrypt($res->creditcard_cvv));
            $res->debit_card_no = ($res->debit_card_no === "" ? NULL : $this->encryption->decrypt($res->debit_card_no));
            $res->debitcard_cvv = ($res->debitcard_cvv === "" ? NULL : $this->encryption->decrypt($res->debitcard_cvv));
            $res->bank_account_no = ($res->bank_account_no === "" ? NULL : $this->encryption->decrypt($res->bank_account_no));
            $data["details"] = $res;
        }
        $currencies = $this->School_model->mGetcurrencies();
        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : '');
        $this->load->view("home/school_register_form_view", $data);
    }

    //register end by shweta
    //Analytics Start
    public function analytics() {
        $this->authenticate();
        $qry = $this->School_model->mGetViewCounts();
        ($qry ? $data["visits"] = $qry : $data["error"] = "");

        $this->load->view("school/analytics_view", $data);
    }

    //Analytics End
    //Change Password Start
    public function changePassword() {
        $this->authenticate();
        $this->load->view("school/changePasswordview");
    }

    public function changePasswordSave() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mChangePasswordSave());
    }

    //Change Password End
    //Enrollments start
    public function enrollments() {
        $this->authenticate();
        $this->load->view("school/enrollments_view");
    }

    public function getEnrollApplications() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetEnrollApplications());
    }

    public function changeStatus() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mChangeStatus());
    }

    //Enrollments end
    //enquiries start
    public function enquiries() {
        $this->authenticate();
        $this->load->view("school/enquiries_view");
    }

    public function getenquiriesApplications() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetEnquiryApplications());
    }

    //enquiries end
    //PromoCode Start
    public function promoCodes() {
        $this->authenticate();
        $qry = $this->School_model->mGetPomoCodePrice();
        ($qry ? $data['price'] = $qry : $data["error"] = "");
        $this->load->view("school/promoCodes_view", $data);
    }

    public function getPromocode() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetPromocode());
    }

    public function getCourseNames() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetCourseNames());
    }

    public function addPromocode() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mAddPromocode());
    }

    public function delPromocode() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDelPromocode());
    }

    //PromoCode End
    //testimonial start
    public function addTestimonials() {
        $this->authenticate();
        $this->load->view("school/add_Testimonials_view");
    }

    public function getTestimonials() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mgetTestimonials());
    }

    public function editTestimonials() {
        $this->authenticate();
        $this->viewMessage($this->School_model->meditTestimonials());
    }

    public function delTestimonial() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDelTestimonial());
    }

    public function getBlogCategories() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mgetBlogCategories());
    }

    public function delBlogCategory() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDelBlogCategory());
    }

    //testimonial End
    //blog start


    public function addBlog() {
        $this->authenticate();
        $this->load->view("school/createBlog_view");
    }

    public function insertBlogs() {
        $this->authenticate();
        $blogId = FILTER_VAR(trim($this->input->post('blogId')), FILTER_SANITIZE_STRING);
        $blogcatId = FILTER_VAR(trim($this->input->post('blogcatId')), FILTER_SANITIZE_STRING);
        $blogTitle = FILTER_VAR(trim($this->input->post('blogTitle')), FILTER_SANITIZE_STRING);
        $blogDesp = $this->input->post('blogDesp');
        $prevImage = FILTER_VAR(trim($this->input->post('prevImage')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->School_model->mInsertBlogs($blogId, $blogcatId, $blogTitle, $blogDesp, $prevImage));
    }

    public function getBlogsDetails() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetBlogsDetails());
    }

    public function delBlog() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mDelBlog());
    }

    //blog end
    //Add new organisation type start
    public function addNewOrganisationType() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mAddNewOrganisationType());
    }

    //Add new organisation type end
    //notifications Start
    public function notifications() {
        $this->authenticate();
        $this->load->view("school/notifications_view");
    }

    public function getNotifications() {
        $this->authenticate();
        $this->viewMessage($this->School_model->mGetNotification());
    }

    public function sendNotifications() {
        $this->authenticate();
        $reference = FILTER_VAR(trim($this->input->post('reference')), FILTER_SANITIZE_STRING);
        $message = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);
        $emailSend = FILTER_VAR(trim($this->input->post('emailSend')), FILTER_SANITIZE_STRING);
        $orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->School_model->mSendNotifications($reference, $message, $emailSend, $orgId));
    }

    //notifications end
    private function viewMessage($message) {
        $data["message"] = $message;
        $this->load->view("view_message", $data);
    }

    private function authenticate() {
        if (!isset($_SESSION['userType']) || !isset($_SESSION['loginId'])) {
            redirect('Register/logout');
            return false;
        } else {
            if ($_SESSION['userType'] != 'School') {
                redirect('Register/logout');
                return false;
            } else {
                return true;
            }
        }
    }

    public function addNewClasses() {
    	if($this->authenticate()){
    		$this->load->model("CourseMasterModel");
			$organisation_courses =  $this->CourseMasterModel->getAllCourses();
			$data = [];
			if($organisation_courses->num_rows()>0){
				$data = ["organisation_courses"=>$organisation_courses->result()];
			} 
			$this->load->view("school/addNewCourseSchool_view",$data);
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

}
