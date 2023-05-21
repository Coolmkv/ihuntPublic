<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class University extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set('Asia/Kolkata');
        }
        $this->load->library('image_lib');
        $this->load->model("University_model");
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr'));
    }

    //dashboard start
    public function dashboard() {
        $this->authenticate();
        $dashboardData = $this->University_model->mGetDasboardDetails();
        if ($dashboardData) {
            $data['details'] = $dashboardData;
        } else {
            $data['nodata'] = "no data";
        }
        $profilecompleted = $this->University_model->mgetProfileCompletion();
        if ($profilecompleted) {
            $data['profilec'] = $profilecompleted;
        }
        ($profilecompleted != "" ? ($profilecompleted < 60 ? redirect('university/register') : "") : "");
        $this->load->view("university/univ_dashboard_view", $data);
    }

    //dashboard end
    //university profile start
    public function orgUser() {
        $this->authenticate();
        $data[] = "";
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'cp_address';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->load->view("university/univ_concerned_person_view", $data);
    }

    public function addConcernedPersonDetails() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mAddConcernedPersonDetails());
    }

    public function getConcernedPersonDetails() {
        $this->authenticate();
        $this->viewMessage($this->University_model->getOrgConcernedPerson());
    }

    public function delConcernedPerson() {
        $this->authenticate();
        $message = $this->University_model->mDelConcernedPerson();
        $this->viewMessage($message);
    }

    public function profile() {
        $this->authenticate();
        $qry = $this->University_model->getProfileInfo();
        if ($qry) {
            $data["profileData"] = $qry;
        } else {
            $data = "";
        }
        $this->load->view("university/univ_profile_view", $data);
    }

    public function getProfileData() {
        $this->authenticate();
        $message = $this->University_model->getProfileJson();
        $this->viewMessage($message);
    }

    public function uploadProfileImage() {
        $this->authenticate();
        $qry = $this->University_model->mUploadProfileImage();
        if ($qry == "updated") {
            redirect("University/profile");
        }
    }

    public function uploadHeaderImage() {
        $this->authenticate();
        $qry = $this->University_model->mUploadHeaderImage();
        if ($qry == "updated") {
            redirect("University/profile");
        }
    }

    public function editprofile() {
        $this->authenticate();
        $qry = $this->University_model->getProfileInfo();

        if ($qry) {
            $data["profileData"] = $qry;
        } else {
            $data = "";
        }
        $this->load->view("university/profile_edit_view", $data);
    }

    public function orgFacilities() {
        $data = [];
        $orgf = $this->University_model->getOrgFacilities('0');
        if ($orgf->num_rows() > 0) {
            $data["orgFacilities"] = $orgf->result();
        }
        $orgfp = $this->University_model->getOrgFacilities('1');
        if ($orgf->num_rows() > 0) {
            $data["orgFacilitiesp"] = $orgfp->result();
        }
        $orgfa = $this->University_model->getOrgFacilities('2');
        if ($orgf->num_rows() > 0) {
            $data["orgFacilitiesa"] = $orgfa->result();
        }
        $this->load->view("university/orgFacilitiesView", $data);
    }

    public function requestFacility() {
        $this->authenticate();
        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);
        $fac_icon = FILTER_VAR(trim($this->input->post('fac_icon')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->University_model->mRequestFacility($title, $fac_icon));
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
        $this->viewMessage($this->University_model->mupdateProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType, $orgGoogle));
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
        $this->viewMessage($this->University_model->msaveProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType));
    }

    public function financialDetails() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'bank_address';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();

        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "University"])->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            $res = $details->row();
            $res->credit_card_no = ($res->credit_card_no === "" ? NULL : $this->encryption->decrypt($res->credit_card_no));
            $res->creditcard_cvv = ($res->creditcard_cvv === "" ? NULL : $this->encryption->decrypt($res->creditcard_cvv));
            $res->debit_card_no = ($res->debit_card_no === "" ? NULL : $this->encryption->decrypt($res->debit_card_no));
            $res->debitcard_cvv = ($res->debitcard_cvv === "" ? NULL : $this->encryption->decrypt($res->debitcard_cvv));
            $res->bank_account_no = ($res->bank_account_no === "" ? NULL : $this->encryption->decrypt($res->bank_account_no));
            $data["details"] = $res;
        }
        $currencies = $this->University_model->mGetcurrencies();
        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : '');
        $this->load->view("university/financial_details_view", $data);
    }

    public function saveFinancialDetails() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mSaveFinancialDetails("showmessage"));
    }

    public function approvalDocuments() {
        $this->authenticate();
        $qry = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_orgapproval_doc");
        ($qry->num_rows() > 0 ? $data["adocs"] = $qry->result() : $data["error"] = "");
        $this->load->view("university/orgApprovalDocument_view", $data);
    }

    public function uploadApprovalDocs() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mUploadApprovalDocs());
    }

    public function deletedocument() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDeletedocument());
    }

    public function uploadedDocument() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mUploadedDocument());
    }

    public function sliderImages() {
        $this->authenticate();
        $gitems = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_org_sliders");
        if ($gitems->num_rows() > 0) {
            $data['gimages'] = $gitems->result();
        } else {
            $data = "";
        }
        $this->load->view("university/addSliderImages", $data);
    }

    public function addSliderImage() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mAddSliderImage());
    }

    public function updateSliderImage() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mUpdateSliderImage());
    }

    public function deleteSliderImage() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDeleteSliderImage());
    }

    public function setDefaultImage() {
        $this->authenticate();
        $headerId = FILTER_VAR(trim($this->input->post('headerId')), FILTER_SANITIZE_STRING);
        $type = FILTER_VAR(trim($this->input->post('type')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->University_model->mSetDefaultImage($type, $headerId));
    }

    public function profileHeaders() {
        $this->authenticate();
        $data1 = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_headerimagevideo");
        ($data1->num_rows() > 0 ? $data["headerImage"] = $data1->result() : $data["error"] = "");
        $qry = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->select("orgImgHeader,orgVideo")->get("organization_details");
        ($qry->num_rows() > 0 ? $data["defaultImage"] = $qry->row() : $data["error"] = "");
        $this->load->view("university/addProfileheaders_view", $data);
    }

    public function uploadheaderImageVideo() {
        $this->authenticate();
        $this->viewMessage($this->University_model->uploadheaderImageVideo());
    }

    public function deleteHeaderImage() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDeleteHeaderImage());
    }

    //university profile end
    //Department Start
    public function addDepartment() {
        $this->authenticate();
        $this->load->view("university/addDepartment_view");
    }

    public function showDepartments() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mshowDepartments());
    }

    public function addNewDepartment() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddNewDepartment());
    }

    public function delDepartment() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdelDepartment());
    }

    //Deppartment End
    //addPages start
    public function addPages() {
        $this->authenticate();
        $this->load->view("university/addPages_view");
    }

    public function showPages() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mshowPages());
    }

    public function addNewPages() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddNewPages());
    }

    public function delPages() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDelPages());
    }

    public function submitForApproval() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mSubmitForApproval());
    }

    //addPages End
    //addCourse start
    public function addCourseFeeType() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mAddCourseFeeType());
    }

    public function addCourse() {
        $this->authenticate();
        $this->load->view("university/addCourse_view");
    }

    public function getTimeDuration() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetTimeDuration());
    }

    public function getMinQualification() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetMinQualification());
    }

    public function getCourseType() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetCourseType());
    }

    public function getcourseTypeBycourse() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mgetcourseTypeBycourse());
    }

    public function addCourseType() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddCourseType());
    }

    public function addSaveCourse() {
        $this->authenticate();
        $departmentId1 = FILTER_VAR(trim($this->input->post('department')), FILTER_SANITIZE_STRING);
        $courseTypeId = FILTER_VAR(trim($this->input->post('courseTypeId')), FILTER_SANITIZE_STRING);
        $courseId = FILTER_VAR(trim($this->input->post('courseId')), FILTER_SANITIZE_STRING);
        $courseDurationId = FILTER_VAR(trim($this->input->post('courseDurationId')), FILTER_SANITIZE_STRING);
        $courseDurationType = FILTER_VAR(trim($this->input->post('courseDurationType')), FILTER_SANITIZE_STRING);
        $openingDate = FILTER_VAR(trim($this->input->post('openingDate')), FILTER_SANITIZE_STRING);
        $closingDate = FILTER_VAR(trim($this->input->post('closingDate')), FILTER_SANITIZE_STRING);
        $examDate = FILTER_VAR(trim($this->input->post('examDate')), FILTER_SANITIZE_STRING);
        $minage = FILTER_VAR(trim($this->input->post('minage')), FILTER_SANITIZE_STRING);
        $maxage = FILTER_VAR(trim($this->input->post('maxage')), FILTER_SANITIZE_STRING);
        $orgCourseId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $min_qualification = $this->input->post("min_qualification");
        $min_percentage = $this->input->post("min_percentage");
        $duration_type = $this->input->post("duration_type");
        $experience_duration = $this->input->post("experience_duration");
        $applicationFee = FILTER_VAR(trim($this->input->post('applicationFee')), FILTER_SANITIZE_STRING);
        $examMode = FILTER_VAR(trim($this->input->post('examMode')), FILTER_SANITIZE_STRING);
        $resultDate = FILTER_VAR(trim($this->input->post('resultDate')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->University_model->maddCourse($departmentId1, $courseTypeId, $courseId, $courseDurationId, $courseDurationType, $openingDate, $closingDate, $examDate, $minage, $maxage, $orgCourseId, $min_qualification, $min_percentage, $duration_type, $experience_duration, $applicationFee, $examMode, $resultDate));
    }

    public function showCourses() {
        $this->authenticate();
        $this->load->view("university/showCourses_view");
    }

    public function getCourses() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetCourses());
    }

    public function deleteCourse() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdeleteCourse());
    }

    public function editCourse() {
        $this->authenticate();
        $orgCourseId = FILTER_VAR(trim($this->input->post('ed')), FILTER_SANITIZE_STRING);
        if (!empty($orgCourseId)) {
            $orgCoursedata = $this->University_model->mgetCourseDetails($orgCourseId);
            $minQualifitn = $this->University_model->mgetMinqualificationData();

            $timeduration = $this->University_model->mgetTimeDurationData();
            if ($orgCoursedata->num_rows() > 0) {
                $data['orgData'] = $orgCoursedata->row();
            } else {
                $data = "";
            }
            ($minQualifitn ? $data['minQualifitns'] = $minQualifitn : "");
            ($timeduration ? $data['timeduration'] = $timeduration : "");

            $this->load->view("university/editCourse_view", $data);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function preRequisites() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetpreRequisites());
    }

    public function requestCourse() {
        $this->authenticate();
        $this->load->view("university/requestCourse_view");
    }

    public function addreqCourse() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddreqCourse());
    }

    public function getstreamBycourse() {
        $this->authenticate();
        $courseId = FILTER_VAR(trim($this->input->post('courseId')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->University_model->mgetStreams($courseId));
    }

    public function addreqStream() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddreqStream());
    }

    public function addreqQuali() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddreqQuali());
    }

    public function addCourseTypeCourse() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddCourseTypeCourse());
    }

    public function addNewDuration() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddNewDuration());
    }

    public function addType() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mAddType());
    }

    public function getCourseDurationType() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetCourseDurationType());
    }

    //addCourse end
    //Stream Details start
    public function addStreams() {
        $this->authenticate();
        $this->load->view("university/addStreams_view");
    }

    public function addNewStreams() {
        $this->authenticate();
        $orgStreamId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $orgCourseIds = FILTER_VAR(trim($this->input->post('orgCourseId')), FILTER_SANITIZE_STRING);
        $streamId = FILTER_VAR(trim($this->input->post('streamId')), FILTER_SANITIZE_STRING);
        $description = $this->input->post('description');
        $this->viewMessage($this->University_model->maddNewStreams($orgStreamId, $orgCourseIds, $streamId, $description));
    }

    public function showStreams() {
        $this->authenticate();
        $this->load->view("university/showStreams_view");
    }

    public function viewStreams() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mViewStreams());
    }

    public function delStreams() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDelStreams());
    }

    //Stream Details end
    //Brochure starts
    public function showBrochure() {
        $this->authenticate();
        $this->load->view("university/showBrochures_view");
    }

    public function brochuresTable() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mbrochuresTable());
    }

    public function addBrochures() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddBrochures());
    }

    public function delBrochures() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdelBrochures());
    }

    //Brochure ends
    //Gallery Start
    public function addGallery() {
        $this->authenticate();
        $gitems = $this->University_model->mGetGalleryData();
        if ($gitems->num_rows() > 0) {
            $data['gimages'] = $gitems->result();
        } else {
            $data = "";
        }
        $this->load->view("university/addGallery_view", $data);
    }

    public function deleteGalleryImage() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdeleteGalleryImage());
    }

    public function addNewGalleryImage() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddNewGalleryImage());
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
        $this->load->view("university/addShowEvent_view", $data);
    }

    public function addEvent() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddEvent());
    }

    public function getEvents() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mgetEvents());
    }

    public function delEvent() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdelEvent());
    }

    //Event End
    //News Start
    public function news() {
        $this->authenticate();
        $this->load->view("university/addShowNews_view");
    }

    public function getNews() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mgetNews());
    }

    public function addNews() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddNews());
    }

    public function delNews() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdelNews());
    }

    //News End
    //placement start
    public function placement() {
        $this->authenticate();
        $currencies = $this->University_model->mGetcurrencies();
        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : $data['err'] = '');
        $this->load->view("university/addShowPlacement_view", $data);
    }

    public function getPlacement() {
        $this->authenticate();
        $this->University_model->mgetPlacement();
    }

    public function addPlacement() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddPlacement());
    }

    public function delPlacement() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdelPlacement());
    }

    public function placedStudents() {
        $this->authenticate();
        $currencies = $this->University_model->mGetcurrencies();
        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : $data['err'] = '');
        $this->load->view("university/addShowPlacedStudent_view", $data);
    }

    public function addPlacedStudent() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mAddPlacedStudent());
    }

    public function placedStudentRecords() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mPlacedStudentRecords());
    }

    public function delPlacedStudent() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDelPlacedStudent());
    }

    //placement End
    //Achievment Start
    public function achievement() {
        $this->authenticate();
        $this->load->view("university/addShowAchievement_view");
    }

    public function addAchievement() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddAchievement());
    }

    public function getAchievement() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mgetAchievement());
    }

    public function delAchievement() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdelAchievement());
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
        $this->load->view("university/addShowFaculty_view", $data);
    }

    public function addFaculty() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddFaculty());
    }

    public function getFaculty() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mgetFaculty());
    }

    public function delFaculty() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdelFaculty());
    }

    //Faculty End
    /**
     *
     */
    public function getPlandetailsJson() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetdetailsofPlan());
    }

    public function advertisement() {
        $this->authenticate();
        $this->load->view("university/addShowAdvertisement_view");
    }

    public function addAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->University_model->maddAdvertisement());
    }

    public function getAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mgetAdvertisement());
    }

    public function delAdvertisement() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mdelAdvertisement());
    }

    public function updateTime() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mUpdateStartDate());
    }

    //Advertisement End by shweta
    //News letter plan buy start by shweta
    public function getNewsLetterPlandetailsJson() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetdetailsofNewsLetterPlan());
    }

    public function newsletterplanbuy() {
        $this->authenticate();
        $this->load->view("university/news_letter_plan_buy_view");
    }

    public function addnewsletterplanbuy() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mAddnewsletterplanbuy());
    }

    public function getnewsletterplanbuy() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetnewsletterplanbuy());
    }

    public function changeStatusNlpb() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mchangeNlpbStatus());
    }

    //News letter plan buy end by shweta
    //Satrt send_news_letter by shweta
    public function getnewsletteremailJson() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetnewsletteremail());
    }

    public function uploadnewsltremailexcel() {
        $this->authenticate();
        $this->viewMessage($this->University_model->muploadnewsltremailexcel());
    }

    public function sendnewsletter() {
        $this->authenticate();
        $this->load->view("university/send_news_letter_view");
    }

    public function emailnewsletter() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mEmailnewsletter());
    }

    //End send_news_letter by shweta
    //register start  by shweta
    public function register() {
        $this->authenticate();
        $bYb = $this->db->where("isactive", 1)->get("tbl_beforyoubegin");
        ($bYb->num_rows() > 0 ? $data["beforeYouBegin"] = $bYb->row() : $data["error"] = "");
        $this->load->view("home/university_register_view", $data);
    }

    public function registerform() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config = ["places" => TRUE, "placesAutocompleteInputID" => "orgaddress", "placesAutocompleteBoundsMap" => TRUE];
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $qry = $this->University_model->getProfileInfo();
        ($qry ? $data['profileData'] = $qry : $data['error'] = '');
        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "University"])->get("tbl_financial_details");
        if ($details->num_rows() > 0) {
            $res = $details->row();
            $res->credit_card_no = ($res->credit_card_no === "" ? NULL : $this->encryption->decrypt($res->credit_card_no));
            $res->creditcard_cvv = ($res->creditcard_cvv === "" ? NULL : $this->encryption->decrypt($res->creditcard_cvv));
            $res->debit_card_no = ($res->debit_card_no === "" ? NULL : $this->encryption->decrypt($res->debit_card_no));
            $res->debitcard_cvv = ($res->debitcard_cvv === "" ? NULL : $this->encryption->decrypt($res->debitcard_cvv));
            $res->bank_account_no = ($res->bank_account_no === "" ? NULL : $this->encryption->decrypt($res->bank_account_no));
            $data["details"] = $res;
        }
        $currencies = $this->University_model->mGetcurrencies();
        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : '');
        $this->load->view("home/university_register_form_view", $data);
    }

    //register end by shweta
    //Change Password Start
    public function changePassword() {
        $this->authenticate();
        $this->load->view("university/change_password_view");
    }

    public function changePasswordSave() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mchangePasswordSave());
    }

    //Change Password End
    //Analytics Start
    public function analytics() {
        $this->authenticate();
        $qry = $this->University_model->mGetViewCounts();
        ($qry ? $data["visits"] = $qry : $data["error"] = "");

        $this->load->view("university/analytics_view", $data);
    }

    //Analytics End
    //Enrollments start
    public function enrollments() {
        $this->authenticate();
        $this->load->view("university/enrollments_view");
    }
	
	public function transactions() {
        $this->authenticate();
        $this->load->view("university/transactions_view");
    }
	
	
 public function showMsg() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mshowMsg());
    }
	
    public function getEnrollApplications() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetEnrollApplications());
    }
	
	 public function getorgtransactions() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetTransactions());
    }
	
	
	
	
	// public function getStudentData() {
			// $studentId = FILTER_VAR(trim($this->input->post('studentId')), FILTER_SANITIZE_STRING);
            // if (empty($studentId)) {
                // $this->viewMessage($this->University_model->notLoggedIn("nodata"));
            // } else {
                // $this->viewMessage($this->University_model->mGetStudentData($studentId));
            // }
    // }
	
	public function getEnrollData() {

            $id = $_SESSION['loginId'];
			
			 
            $type = FILTER_VAR(trim($this->input->post('type')), FILTER_SANITIZE_STRING);
            $courseId = FILTER_VAR(trim($this->input->post('courseId')), FILTER_SANITIZE_STRING);
            $orgCourseId = FILTER_VAR(trim($this->input->post('orgCourseId')), FILTER_SANITIZE_STRING);
			$studentId = FILTER_VAR(trim($this->input->post('studentId')), FILTER_SANITIZE_STRING);
			$_SESSION['studentId']=$studentId;
			// echo $id. $type.$courseId.$orgCourseId;
			
			
            if (empty($id) || empty($type) || !isset($studentId)) {
                $this->viewMessage($this->University_model->notLoggedIn("nodata"));
            } else {
                $this->viewMessage($this->University_model->mGetEnrollData($id, $type,$studentId, $courseId, $orgCourseId));
            }
      
    }

    public function changeStatus() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mChangeEnrollMentStatus());
    }
	  public function notifyMsg() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mnotifyMsg());
    }

    //Enrollments end
    //PromoCode Start
    public function promoCodes() {
        $this->authenticate();
        $qry = $this->University_model->mGetPomoCodePrice();
        ($qry ? $data['price'] = $qry : $data["error"] = "");
        $this->load->view("university/promoCodes_view", $data);
    }

    public function getPromocode() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetPromocode());
    }

    public function getCourseNames() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetCourseNames());
    }

    public function addPromocode() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mAddPromocode());
    }

    public function delPromocode() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDelPromocode());
    }

    //PromoCode End
    //Add new organisation type start
    public function addNewOrganisationType() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mAddNewOrganisationType());
    }

    //Add new organisation type end
    //testimonial start
    public function addTestimonials() {
        $this->authenticate();
        $this->load->view("university/add_Testimonials_view");
    }

    public function getTestimonials() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mgetTestimonials());
    }

    public function editTestimonials() {
        $this->authenticate();
        $this->viewMessage($this->University_model->meditTestimonials());
    }

    public function delTestimonial() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDelTestimonial());
    }

    public function getBlogCategories() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mgetBlogCategories());
    }

    public function delBlogCategory() {
        $this->authenticate();
        $this->University_model->mDelBlogCategory();
    }

    //testimonial End
    //blog start
    public function addBlog() {
        $this->authenticate();
        $this->load->view("university/createBlog_view");
    }

    public function insertBlogs() {
        $this->authenticate();
        $blogId = FILTER_VAR(trim($this->input->post('blogId')), FILTER_SANITIZE_STRING);
        $blogcatId = FILTER_VAR(trim($this->input->post('blogcatId')), FILTER_SANITIZE_STRING);
        $blogTitle = FILTER_VAR(trim($this->input->post('blogTitle')), FILTER_SANITIZE_STRING);
        $blogDesp = $this->input->post('blogDesp');
        $prevImage = FILTER_VAR(trim($this->input->post('prevImage')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->University_model->mInsertBlogs($blogId, $blogcatId, $blogTitle, $blogDesp, $prevImage));
    }

    public function getBlogsDetails() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetBlogsDetails());
    }

    public function delBlog() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mDelBlog());
    }

    //blog end
    //enquiries start
    public function enquiries() {
        $this->authenticate();
        $this->load->view("university/enquiries_view");
    }

    public function getenquiriesApplications() {
        $this->authenticate();
        $this->viewMessage($this->University_model->mGetEnquiryApplications());
    }

    //enquiries end
    //notifications Start
    public function notifications() {
        $this->authenticate();
        $this->load->view("university/notifications_view");
    }

    public function getNotifications() {
        $this->authenticate();
        $message = $this->University_model->mGetNotification();
        $this->viewMessage($message);
    }

    public function sendNotifications() {
        $this->authenticate();
        $reference = FILTER_VAR(trim($this->input->post('reference')), FILTER_SANITIZE_STRING);
        $message = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);
        $emailSend = FILTER_VAR(trim($this->input->post('emailSend')), FILTER_SANITIZE_STRING);
        $orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);
        $this->viewMessage($this->University_model->mSendNotifications($reference, $message, $emailSend, $orgId));
    }

    //notifications end
    private function authenticate() {
        if (!isset($_SESSION['userType']) || !isset($_SESSION['loginId'])) {
            redirect('Register/logout');
            return false;
        } else {
            if ($_SESSION['userType'] != 'University') {
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

	public function addNewCourses() {
    	if($this->authenticate()){
    		$this->load->model("CourseMasterModel");
			$organisation_courses =  $this->CourseMasterModel->getAllCourses();
			$data = [];
			if($organisation_courses->num_rows()>0){
				$data = ["organisation_courses"=>$organisation_courses->result()];
			} 
			$this->load->view("university/addNewCourse_view",$data);
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
