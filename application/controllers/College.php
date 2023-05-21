<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class College extends CI_Controller {



    public function __construct() {

        parent::__construct();

        $this->load->library('encryption');

        if (function_exists('date_default_timezone_set')) {

            date_default_timezone_set('Asia/Kolkata');

        }

        $this->load->library('image_lib');

        $this->load->model("College_model");

        $this->encryption->initialize(

                array(

                    'cipher' => 'aes-256',

                    'mode' => 'ctr'));

    }



    //dashboard start

    public function dashboard() {

        $this->authenticate();

        $qry1 = $this->College_model->getProfileInfo();

        if ($qry1) {

            $director = $qry1->directorName;

        } else {

            $director = '';

        }





        $qry = $this->College_model->mgetDashoboardDetails();

        if ($qry) {

            $data['details'] = $qry;

        } else {

            $data = "";

        }

        $profilecompleted = $this->College_model->mgetProfileCompletion();

        ($profilecompleted ? $data['profilec'] = $profilecompleted : '');

        ($profilecompleted != "" ? ($profilecompleted < 60 ? redirect('college/register') : "") : "");

        $this->load->view("college/college_dashboard_view", $data);

    }



    //dashboard end

    //Change Password Start

    public function changePassword() {

        $this->authenticate();

        $this->load->view("college/change_password_view");

    }



    public function changePasswordSave() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mchangePasswordSave());

    }



    //Change Password End

    //college profile start

    public function profile() {

        $this->authenticate();

        $qry = $this->College_model->getProfileInfo();



        if ($qry) {

            $data["profileData"] = $qry;

        } else {

            $data = "";

        }

        $this->load->view("college/college_profile_view", $data);

    }



    public function getProfileData() {

        $this->authenticate();

        $this->viewMessage($this->College_model->getProfileJson());

    }



    public function uploadProfileImage() {

        $this->authenticate();

        $qry = $this->College_model->mUploadProfileImage();

        if ($qry == "updated") {

            redirect("College/profile");

        }

    }



    public function uploadHeaderImage() {

        $this->authenticate();

        $qry = $this->College_model->mUploadHeaderImage();

        if ($qry == "updated") {

            redirect("College/profile");

        }

    }



    public function editprofile() {

        $this->authenticate();

        $qry = $this->College_model->getProfileInfo();

        if ($qry) {

            $data["profileData"] = $qry;

        } else {

            $data = "";

        }

        $this->load->view("college/college_profile_edit_view", $data);

    }



    public function orgFacilities() {

        $data = [];

        $orgf = $this->College_model->getOrgFacilities('0');

        if ($orgf) {

            $data["orgFacilities"] = $orgf;

        }

        $orgfp = $this->College_model->getOrgFacilities('1');

        if ($orgfp) {

            $data["orgFacilitiesp"] = $orgfp;

        }

        $orgfa = $this->College_model->getOrgFacilities('2');

        if ($orgfa) {

            $data["orgFacilitiesa"] = $orgfa;

        }

        $this->load->view("college/orgFacilitiesView", $data);

    }



    public function financialDetails() {

        $this->authenticate();

        $this->load->library('googlemaps');

        $config['places'] = TRUE;

        $config['placesAutocompleteInputID'] = 'bank_address';

        $config['placesAutocompleteBoundsMap'] = TRUE;

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "College"])->get("tbl_financial_details");

        if ($details->num_rows() > 0) {

            $res = $details->row();

            $res->credit_card_no = ($res->credit_card_no === "" ? NULL : $this->encryption->decrypt($res->credit_card_no));

            $res->creditcard_cvv = ($res->creditcard_cvv === "" ? NULL : $this->encryption->decrypt($res->creditcard_cvv));

            $res->debit_card_no = ($res->debit_card_no === "" ? NULL : $this->encryption->decrypt($res->debit_card_no));

            $res->debitcard_cvv = ($res->debitcard_cvv === "" ? NULL : $this->encryption->decrypt($res->debitcard_cvv));

            $res->bank_account_no = ($res->bank_account_no === "" ? NULL : $this->encryption->decrypt($res->bank_account_no));

            $data["details"] = $res;

        }

        $currencies = $this->College_model->mGetcurrencies();

        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : '');

        $this->load->view("college/financial_details_view", $data);

    }



    public function saveFinancialDetails() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mSaveFinancialDetails("showmessage"));

    }



    public function requestFacility() {

        $this->authenticate();

        $title = FILTER_VAR(trim($this->input->post('title')), FILTER_SANITIZE_STRING);

        $fac_icon = FILTER_VAR(trim($this->input->post('fac_icon')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->College_model->mRequestFacility($title, $fac_icon));

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

        $edate = FILTER_VAR(trim($this->input->post('establishdate')), FILTER_SANITIZE_STRING);



        $this->viewMessage($this->College_model->mupdateProfile($directorName, $directorMobile, $directorEmail

                        , $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType, $orgGoogle, $orgWebsite, $approvedBy, $orgaddress, $edate));

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



        $this->viewMessage($this->College_model->msaveProfile($directorName, $directorMobile, $directorEmail, $orgName, $orgMobile, $countryId, $stateId, $cityId, $orgType));

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

        $this->load->view("college/college_concerned_person_view", $data);

    }



    public function addConcernedPersonDetails() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mAddConcernedPersonDetails());

    }



    public function getConcernedPersonDetails() {

        $this->authenticate();

        $this->viewMessage($this->College_model->getOrgConcernedPerson());

    }



    public function delConcernedPerson() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelConcernedPerson());

    }



    public function approvalDocuments() {

        $this->authenticate();

        $qry = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_orgapproval_doc");

        ($qry->num_rows() > 0 ? $data["adocs"] = $qry->result() : $data["error"] = "");

        $this->load->view("college/orgApprovalDocument_view", $data);

    }



    public function uploadApprovalDocs() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mUploadApprovalDocs());

    }



    public function uploadedDocument() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mUploadedDocument());

    }



    public function deletedocument() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDeletedocument());

    }



    public function sliderImages() {

        $this->authenticate();

        $gitems = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_org_sliders");

        if ($gitems->num_rows() > 0) {

            $data['gimages'] = $gitems->result();

        } else {

            $data = "";

        }

        $this->load->view("college/addSliderImages", $data);

    }



    public function addSliderImage() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mAddSliderImage());

    }



    public function updateSliderImage() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mUpdateSliderImage());

    }



    public function deleteSliderImage() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDeleteSliderImage());

    }



    public function setDefaultImage() {

        $this->authenticate();

        $headerId = FILTER_VAR(trim($this->input->post('headerId')), FILTER_SANITIZE_STRING);

        $type = FILTER_VAR(trim($this->input->post('type')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->College_model->mSetDefaultImage($type, $headerId));

    }



    public function profileHeaders() {

        $this->authenticate();

        $data1 = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->get("tbl_headerimagevideo");

        ($data1->num_rows() > 0 ? $data["headerImage"] = $data1->result() : $data["error"] = "");

        $qry = $this->db->where(["loginId" => $_SESSION['loginId'], "isactive" => 1])->select("orgImgHeader,orgVideo")->get("organization_details");

        ($qry->num_rows() > 0 ? $data["defaultImage"] = $qry->row() : $data["error"] = "");

        $this->load->view("college/addProfileheaders_view", $data);

    }



    public function uploadheaderImageVideo() {

        $this->authenticate();

        $this->viewMessage($this->College_model->uploadheaderImageVideo());

    }



    public function deleteHeaderImage() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDeleteHeaderImage());

    }



    //college profile end

    //addPages start

    public function addPages() {

        $this->authenticate();

        $this->load->view("college/addPages_view");

    }



    public function showPages() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mshowPages());

    }



    public function addNewPages() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddNewPages());

    }



    public function delPages() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelPages());

    }



    public function submitForApproval() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mSubmitForApproval());

    }



    //addPages End

    //addCourse start

    public function addCourse() {

        $this->authenticate();

        $this->load->view("college/addCourse_view");

    }



    public function getTimeDuration() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetTimeDuration());

    }



    public function getMinQualification() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetMinQualification());

    }



    public function getCourseType() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetCourseType());

    }



    public function getcourseTypeBycourse() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetcourseTypeBycourse());

    }



    public function addSaveCourse() {

        $this->authenticate();

        $orgCourseId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->College_model->maddCourse($orgCourseId));

    }



    public function getCourses() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetCourses());

    }



    public function deleteCourse() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdeleteCourse());

    }



    public function editCourses() {

        $this->authenticate();

        $coursetype = $this->College_model->mGetCourseTypeArr();

        ($coursetype ? $data["coursetype"] = $coursetype : $data["error"] = "");

        $durationarr = $this->College_model->mGetTimeDurationArr();

        ($durationarr ? $data["durationType"] = $durationarr : $data["error"] = "");



        $qry = $this->College_model->mEditCourses();

        if ($qry) {

            $message = json_encode($qry);

            // $data["OrgCourse"] = $qry;

            //$this->load->view("college/editCourseView", $data);

        } else {

            $message = 'Nodata';

        }

        $this->viewMessage($message);

    }



    public function getCourseDurationType() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetCourseDurationType());

    }



    public function addCourseType() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddCourseType());

    }



    public function addCourseTypeCourse() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddCourseTypeCourse());

    }



    public function addNewDuration() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddNewDuration());

    }



    public function addType() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mAddType());

    }



    public function addCourseFeeType() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mAddCourseFeeType());

    }



    //addCourse end

    //Stream Details start

    public function addStreams() {

        $this->authenticate();

        $this->load->view("college/addStreams_view");

    }



    public function addNewStreams() {

        $this->authenticate();

        $orgStreamId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);

        $orgCourseIds = FILTER_VAR(trim($this->input->post('orgCourseId')), FILTER_SANITIZE_STRING);

        $streamId = FILTER_VAR(trim($this->input->post('streamId')), FILTER_SANITIZE_STRING);

        $description = $this->input->post('description');

        $this->viewMessage($this->College_model->maddNewStreams($orgStreamId, $orgCourseIds, $streamId, $description));

    }



    public function getStreams() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetStreams());

    }



    public function showStreams() {

        $this->authenticate();

        $this->load->view("college/showStreams_view");

    }



    public function viewStreams() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mViewStreams());

    }



    public function delStreams() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelStreams());

    }



    //Stream Details end

    //Eligibility Start not in use

    public function eligibility() {

        $this->authenticate();

        $this->load->view("college/addShowEligibility_view");

    }



    public function getClassType() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetClassType());

    }



    public function addEligibility() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddEligibility());

    }



    public function showEligibility() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mShowEligibility());

    }



    public function delEligibility() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelEligibility());

    }



    //Eligibility End

    //Brochure starts

    public function showBrochure() {

        $this->authenticate();

        $this->load->view("college/showBrochures_view");

    }



    public function brochuresTable() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mbrochuresTable());

    }



    public function addBrochures() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddBrochures());

    }



    public function delBrochures() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdelBrochures());

    }



    //Brochure ends

    //Gallery Start

    public function addGallery() {

        $this->authenticate();

        $gitems = $this->College_model->mGetGalleryData();

        if ($gitems->num_rows() > 0) {

            $data['gimages'] = $gitems->result();

        } else {

            $data = "";

        }

        $this->load->view("college/addGallery_view", $data);

    }



    public function deleteGalleryImage() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdeleteGalleryImage());

    }



    public function addNewGalleryImage() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddNewGalleryImage());

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

        $this->load->view("college/addShowEvent_view", $data);

    }



    public function addEvent() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddEvent());

    }



    public function getEvents() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetEvents());

    }



    public function delEvent() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdelEvent());

    }



    //Event End

    //News Start

    public function news() {

        $this->authenticate();

        $this->load->view("college/addShowNews_view");

    }



    public function getNews() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetNews());

    }



    public function addNews() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddNews());

    }



    public function delNews() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdelNews());

    }



    //News End

    //placement start

    public function placement() {

        $this->authenticate();

        $currencies = $this->College_model->mGetcurrencies();

        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : $data['err'] = '');

        $this->load->view("college/addShowPlacement_view", $data);

    }



    public function getPlacement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetPlacement());

    }



    public function addPlacement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddPlacement());

    }



    public function delPlacement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdelPlacement());

    }



    public function placedStudents() {

        $this->authenticate();

        $currencies = $this->College_model->mGetcurrencies();

        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : $data['err'] = '');

        $this->load->view("college/addShowPlacedStudent_view", $data);

    }



    public function addPlacedStudent() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mAddPlacedStudent());

    }



    public function placedStudentRecords() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mPlacedStudentRecords());

    }



    public function delPlacedStudent() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelPlacedStudent());

    }



    //placement End

    //Achievment Start

    public function achievement() {

        $this->authenticate();

        $this->load->view("college/addShowAchievement_view");

    }



    public function addAchievement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddAchievement());

    }



    public function getAchievement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetAchievement());

    }



    public function delAchievement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdelAchievement());

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

        $this->load->view("college/addShowFaculty_view", $data);

    }



    public function addFaculty() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddFaculty());

    }



    public function getFaculty() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetFaculty());

    }



    public function delFaculty() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdelFaculty());

    }



    //Faculty End

    //Running Status Start

    public function runningStatus() {

        $this->authenticate();

        $this->load->view("college/addShowRunningStatus_view");

    }



    public function addRunningStatus() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mRunningStatus());

    }



    public function getRunningStatus() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetRunningStatus());

    }



    public function delRunningStatus() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdelRunningStatus());

    }



    //Running Status End

    //Advertisement  starts created by shweta



    /*     * ** for Plan details *** */



    public function getPlandetailsJson() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetdetailsofPlan());

    }



    public function advertisement() {

        $this->authenticate();

        $this->load->view("college/addShowAdvertisement_view");

    }



    public function addAdvertisement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->maddAdvertisement());

    }



    public function getAdvertisement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetAdvertisement());

    }



    public function delAdvertisement() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mdelAdvertisement());

    }



    public function updateTime() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mUpdateStartDate());

    }



    //Advertisement End

    //News letter plan buy start by shweta

    public function getNewsLetterPlandetailsJson() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetdetailsofNewsLetterPlan());

    }



    public function newsletterplanbuy() {

        $this->authenticate();

        $this->load->view("college/news_letter_plan_buy_view");

    }



    public function addnewsletterplanbuy() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mAddnewsletterplanbuy());

    }



    public function getnewsletterplanbuy() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetnewsletterplanbuy());

    }



    public function changeStatusNlpb() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mchangeNlpbStatus());

    }



    //News letter plan buy end by shweta

    //Satrt send_news_letter by shweta

    public function getnewsletteremailJson() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetnewsletteremail());

    }



    public function uploadnewsltremailexcel() {

        $this->authenticate();

        $this->viewMessage($this->College_model->muploadnewsltremailexcel());

    }



    public function sendnewsletter() {

        $this->authenticate();

        $this->load->view("college/send_news_letter_view");

    }



    public function emailnewsletter() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mEmailnewsletter());

    }



    //End send_news_letter by shweta

    //register start  by shweta

    public function register() {

        $this->authenticate();

        $bYb = $this->db->where("isactive", 1)->get("tbl_beforyoubegin");

        ($bYb->num_rows() > 0 ? $data["beforeYouBegin"] = $bYb->row() : $data["error"] = "");

        $this->load->view("home/college_register_view", $data);

    }



    public function registerform() {

        $this->authenticate();

        $this->load->library('googlemaps');

        $config = ["places" => TRUE, "placesAutocompleteInputID" => "orgaddress", "placesAutocompleteBoundsMap" => TRUE];

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $qry = $this->College_model->getProfileInfo();

        ($qry ? $data['profileData'] = $qry : $data['error'] = '');

        $details = $this->db->where(["login_id" => $_SESSION['loginId'], "user_type" => "College"])->get("tbl_financial_details");

        if ($details->num_rows() > 0) {

            $res = $details->row();

            $res->credit_card_no = ($res->credit_card_no === "" ? NULL : $this->encryption->decrypt($res->credit_card_no));

            $res->creditcard_cvv = ($res->creditcard_cvv === "" ? NULL : $this->encryption->decrypt($res->creditcard_cvv));

            $res->debit_card_no = ($res->debit_card_no === "" ? NULL : $this->encryption->decrypt($res->debit_card_no));

            $res->debitcard_cvv = ($res->debitcard_cvv === "" ? NULL : $this->encryption->decrypt($res->debitcard_cvv));

            $res->bank_account_no = ($res->bank_account_no === "" ? NULL : $this->encryption->decrypt($res->bank_account_no));

            $data["details"] = $res;

        }

        $currencies = $this->College_model->mGetcurrencies();

        ($currencies->num_rows() > 0 ? $data['currency'] = $currencies->result() : '');

        $this->load->view("home/college_register_form_view", $data);

    }



    //register end by shweta

    //Analytics Start

    public function analytics() {

        $this->authenticate();

        $qry = $this->College_model->mGetViewCounts();

        ($qry ? $data["visits"] = $qry : $data["error"] = "");



        $this->load->view("college/analytics_view", $data);

    }



    //Analytics End

    //Enrollments start

    public function enrollments() {

        $this->authenticate();

        $this->load->view("college/enrollments_view");

    }



    public function getEnrollApplications() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetEnrollApplications());

    }



    public function changeStatus() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mChangeStatus());

    }



    //Enrollments end

    //PromoCode Start

    public function promoCodes() {

        $this->authenticate();

        $qry = $this->College_model->mGetPomoCodePrice();

        ($qry ? $data['price'] = $qry : $data["error"] = "");

        $this->load->view("college/promoCodes_view", $data);

    }



    public function getPromocode() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetPromocode());

    }



    public function getCourseNames() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetCourseNames());

    }



    public function addPromocode() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mAddPromocode());

    }



    public function delPromocode() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelPromocode());

    }



    //PromoCode End

    //testimonial start

    public function addTestimonials() {

        $this->authenticate();

        $this->load->view("college/add_Testimonials_view");

    }



    public function getTestimonials() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetTestimonials());

    }



    public function editTestimonials() {

        $this->authenticate();

        $this->viewMessage($this->College_model->meditTestimonials());

    }



    public function delTestimonial() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelTestimonial());

    }



    public function getBlogCategories() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mgetBlogCategories());

    }



    public function delBlogCategory() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelBlogCategory());

    }



    //testimonial End

    //blog start





    public function addBlog() {

        $this->authenticate();

        $this->load->view("college/createBlog_view");

    }



    public function insertBlogs() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mInsertBlogs());

    }



    public function getBlogsDetails() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetBlogsDetails());

    }



    public function delBlog() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mDelBlog());

    }



    //blog end

    //Add new organisation type start

    public function addNewOrganisationType() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mAddNewOrganisationType());

    }



    //Add new organisation type end

    //enquiries start

    public function enquiries() {

        $this->authenticate();

        $this->load->view("college/enquiries_view");

    }



    public function getenquiriesApplications() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetEnquiryApplications());

    }



    //enquiries end

    //notifications Start

    public function notifications() {

        $this->authenticate();

        $this->load->view("college/notifications_view");

    }



    public function getNotifications() {

        $this->authenticate();

        $this->viewMessage($this->College_model->mGetNotification());

    }



    public function sendNotifications() {

        $this->authenticate();

        $reference = FILTER_VAR(trim($this->input->post('reference')), FILTER_SANITIZE_STRING);

        $message = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);

        $emailSend = FILTER_VAR(trim($this->input->post('emailSend')), FILTER_SANITIZE_STRING);

        $orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->College_model->mSendNotifications($reference, $message, $emailSend, $orgId));

    }



    //notifications end

    private function authenticate() {

        if (!isset($_SESSION['userType']) || !isset($_SESSION['loginId'])) {

            redirect('Register/logout');

            return false;

        } else {

            if ($_SESSION['userType'] != 'College') {

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

    public function addUpdateCourse(){
        if($this->authenticate()){
    		$this->load->model("CourseMasterModel");
			$organisation_courses =  $this->CourseMasterModel->getAllCourses();
			$data = [];
			if($organisation_courses->num_rows()>0){
				$data = ["organisation_courses"=>$organisation_courses->result()];
			} 
			$this->load->view("college/addNewCourseCollege_view",$data);
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

