<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set('Asia/Kolkata');
        }
        $this->load->library('image_lib');
        $this->load->model("Home_model");
        $this->load->model("College_model");
        $this->load->model("University_model");
        $this->load->model("Student_model");
        $this->load->model("Institute_model");
		
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr'));
    }

    //index pages start
    public function index() {
        if (!empty(get_cookie('country_code')) && !isset($_SESSION["countryId"])) {
            $country_code = get_cookie('country_code');
            $this->Home_model->mSetCountry($country_code);
        }
        if (!isset($_SESSION["countryId"])) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $this->getIptolocation($ip);
        }
        $this->Home_model->setEmail();
        $getCollegesRes = $this->Home_model->mgetOrganizationDetails('College', "");
        ($getCollegesRes ? $data['collegesRes'] = $getCollegesRes : $data["error"] = "");
        $universityRes = $this->Home_model->mgetOrganizationDetails('University', "");

        ($universityRes ? $data['universityRes'] = $universityRes : $data["error"] = "");
        $SchoolRes = $this->Home_model->mgetOrganizationDetails('School', "");
        ($SchoolRes ? $data['schoolRes'] = $SchoolRes : $data["error"] = "");
        $instituteRes = $this->Home_model->mgetOrganizationDetails("Institute", "");
        ($instituteRes ? $data['instituteRes'] = $instituteRes : $data["error"] = "");
        $countries_list = $this->Home_model->mGetallCountries('array');
        ($countries_list ? $data['countries_list'] = $countries_list : $data["error"] = "");
        $this->load->view("home/home_page", $data);
    }

    public function verifyEmail() {
        $this->viewMessage($this->Home_model->mVerifyEmail());
    }

    public function verifyStudentEmail() {
        $this->viewMessage($this->Home_model->mVerifyStudentEmail());
    }

    public function allCoursesDetails() {
        $this->viewMessage($this->Home_model->mGetAllCourses());
    }

    public function allInstCourses() {
        $this->viewMessage($this->Home_model->mGetAllInstCourses());
    }

    public function getIptolocation($ip) {
        $getCountryCode = 'countrynotfound';
        if (!empty(get_cookie('country_code'))) {
            $country_code = get_cookie('country_code');
            $getCountryCode = $this->Home_model->mSetCountry($country_code);
        } else {
            $getCountryCode = $this->iptoLoca($ip);
        }
        if ($getCountryCode == 'countrynotfound') {
            return 'notfound';
        }
    }

    private function iptoLoca($ip) {

        $url = 'https://api.ipdata.co/' . $ip . '?api-key=e8ca8352b5150a5deb63e883a8b84b4deea8694be6a4714578396be5';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        $data = json_decode($result, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            if (array_key_exists("country_code", $data)) {
                $country_code = $data['country_code'];
                set_cookie('country_code', $country_code, '3600000');
                return $getCountryCode = $this->Home_model->mSetCountry($country_code);
            } else {
                return $getCountryCode = 'countrynotfound';
            }
        }
    }

    //index pages end
    //country functions start
    public function countryValue() {
        $id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_NUMBER_INT);
        if (!empty($id)) {
            $_SESSION['countryId'] = $id;
            $country_code = $this->Home_model->mSetCountryCookie($id);
            if ($country_code) {
                set_cookie('country_code', $country_code, '3600000');
            }
            $this->viewMessage($id);
        } else {
            $this->viewMessage("");
        }
    }

    public function getCountriesJson() {
        $this->viewMessage($this->Home_model->mGetallCountries('json'));
    }

    public function getStatesByCountry() {
        $this->viewMessage($this->Home_model->mGetstatesofCountry());
    }

    public function getCityByStates() {
        $this->viewMessage($this->Home_model->mGetCitybyState());
    }

    //countryvalue functions end
    //organization details start
    public function orgDetails() {
        $orgIda = explode("_", $this->uri->segment(2));
        if (count($orgIda) >= "2") {
            $orgId = $orgIda[0];
            $orgName = $orgIda[1];
            if(isset($orgIda[2])){
            	$OrgCourseId = $orgIda[2];
			}else{
				$OrgCourseId = "";
			}
			$data = [];
			$getOrgDetails = $this->Home_model->mGetorgDetails($orgId, $orgName);
			($getOrgDetails ? $data['orgDetails'] = $getOrgDetails : redirect('Home/index'));

			$getPreferredCourse = $this->Home_model->mGetPrefferedCourse($orgId);
			($getPreferredCourse ? $data['orgPreferredCourse'] = $getPreferredCourse : "");
			$getOrgSlides = $this->Home_model->mGetorgSliderImages($orgId);
			($getOrgSlides ? $data['orgSlides'] = $getOrgSlides : "");

			$schoolCourseDetails = $this->Home_model->mGetEventsData($orgId);
			($schoolCourseDetails ? $data['schoolCourses'] = $schoolCourseDetails : "");

			$approvalDocuments = $this->Home_model->mGetApprovalDocs($orgId);
			($approvalDocuments ? $data['approvalDocs'] = $approvalDocuments : "");

			$orgPages = $this->Home_model->mGetPageNames($orgId);
			($orgPages ? $data['pageNames'] = $orgPages : "");
			$this->load->view("home/organization_details_view", array_merge($this->getTabsData($orgId,$OrgCourseId), $data, $this->getGoogleMap($getOrgDetails)));
        } else {
            redirect('Home/index');
        }

    }

    private function getGoogleMap($getOrgDetails) {

        if ($getOrgDetails->orgGoogle == "" && $getOrgDetails->orgAddress !== "") {
            $this->load->library('googlemaps');
            $config = ["geocodeCaching" => TRUE, "https" => TRUE, 'places' => TRUE, 'placesLocation' => $getOrgDetails->orgAddress,
                'zoom' => 'auto', 'center' => $getOrgDetails->orgAddress, 'placesRadius' => 0];

            $this->googlemaps->initialize($config);
            $marker = array();
            $marker['position'] = $getOrgDetails->orgAddress;
            $marker['title'] = $getOrgDetails->orgAddress;

            $this->googlemaps->add_marker($marker);
            $data['location'] = $this->googlemaps->create_map();
        }

        $highlinghtedData = $this->Home_model->mGetHighligtedCourse($getOrgDetails);
        ($highlinghtedData->num_rows() > 0 ? $data["highlightedData"] = $highlinghtedData->row() : $data["error"] = "");
        return $data;
    }

    private function getTabsData($loginId,$OrgCourseId) {
        $reqFacilities = $this->Home_model->mGetReqFacility($loginId);
        ($reqFacilities ? $data['reqFacility'] = $reqFacilities : "");

        $getSeats = $this->Home_model->mGetOrgSeatsDetails($loginId);
        ($getSeats ? $data['orgSeats'] = $getSeats : "");

        $getCoursed = $this->Home_model->mGetOrgCourseDetails($loginId);
        ($getCoursed ? $data['orgCourseDetails'] = $getCoursed : "");

        $getCourseType = $this->Home_model->mGetOrgCourseType();
        ($getCourseType ? $data['orgCourseType'] = $getCourseType : "");

        $getGallery = $this->Home_model->mGetOrgGallery($loginId);
        ($getGallery ? $data['orgGallery'] = $getGallery : "");

        $getOrgCourses = $this->Home_model->mGetOrgCourses($loginId, "");

        ($getOrgCourses ? $data['orgCourses'] = $getOrgCourses : "");
		if($OrgCourseId){
			$getCourseDetails = $this->Home_model->mGetOrgCourses($loginId,"",$OrgCourseId);
			 
			($getCourseDetails ? $data['orgSelectedCourseDetails'] = $getCourseDetails : "");
		}
        $getPlacementdata = $this->Home_model->mGetPlacementData($loginId);
        ($getPlacementdata ? $data['orgPlacement'] = $getPlacementdata : "");

        $facultydetails = $this->Home_model->mGetFacultyData($loginId);
        ($facultydetails ? $data['orgfaculty'] = $facultydetails : "");

        $achievments = $this->Home_model->mGetAchievementData($loginId);
        ($achievments ? $data['achievements'] = $achievments : "");
        $rtabs = $this->remainingTabs($loginId);
        return array_merge($data, $rtabs);
    }

    private function remainingTabs($orgId) {
        $data["error"] = "";
        $news = $this->Home_model->mGetNewsData($orgId);
        ($news ? $data['news'] = $news : "");

        $events = $this->Home_model->mGetEventsData($orgId);
        ($events ? $data['events'] = $events : "");

        $orgCount = $this->Home_model->mGetOrgCount();
        ($orgCount ? $data['orgCount'] = $orgCount : "");
        $myratings = $this->Home_model->mGetMyRatings($orgId);
        ($myratings ? $data['myRatings'] = $myratings : "");
        $allratings = $this->Home_model->mGetAllRatings($orgId);
        ($allratings ? $data['allRatings'] = $allratings : "");
        return $data;
    }

    public function getEnrollData() {
        $reqType = FILTER_VAR(trim($this->input->post('reqType')));
        if ($reqType === "Enqiry") {
            $this->getEnqiryDetails();
            $this->viewMessage($this->getEnqiryDetails());
        } else if (isset($_SESSION['studentId']) && $reqType == "") {
            $id = FILTER_VAR(trim(base64_decode($this->input->post('id'))));
            $type = FILTER_VAR(trim($this->input->post('type')));
            $courseId = FILTER_VAR(trim($this->input->post('courseId')));
            $orgCourseId = FILTER_VAR(trim($this->input->post('orgCourseId')));
            if (empty($id) || empty($type) || !isset($_SESSION['studentId'])) {
                $this->viewMessage($this->Home_model->notLoggedIn("nodata"));
            } else {
                $this->viewMessage($this->Home_model->mGetEnrollData($id, $type, $_SESSION['studentId'], $courseId, $orgCourseId));
            }
        } else {
            $this->viewMessage($this->Home_model->notLoggedIn("login"));
        }
    }
	
	public function setenroll(){
$this->load->view("home/enrollset");
	}
	
    private function getEnqiryDetails() {
        $id = FILTER_VAR(trim(base64_decode($this->input->post('id'))));
        $type = FILTER_VAR(trim($this->input->post('type')));
        $courseId = FILTER_VAR(trim($this->input->post('courseId')));
        $orgCourseId = FILTER_VAR(trim($this->input->post('orgCourseId')));
        return $this->Home_model->mGetEnquiryDetails($id, $type, $courseId, $orgCourseId);
    }

    //organization details end
    //get all organisations start
    public function allOrganizations() {
        $type = FILTER_VAR(trim($this->input->get("Type")));
        if ($type === 'College' || $type === 'University' || $type === 'Institute' || $type === 'School') {

            $orgDetails = $this->Home_model->mGetOrganisationDetails($type, '0', '9');
            ($orgDetails ? $data["orgDetails"] = $orgDetails : $data["error"] = "");

            $totalOrgs = $this->Home_model->mGetTotalOrganization($type);
            ($totalOrgs ? $data["totalOrgs"] = $totalOrgs : "");
            $data["type"] = $type;

            $stateWise = $this->Home_model->getOrganisationStateCityWise($type, 'State');
            ($stateWise ? $data["StateWiseData"] = $stateWise : "");

            $cityWise = $this->Home_model->getOrganisationStateCityWise($type, 'City');
            ($cityWise ? $data["CityWiseData"] = $cityWise : "");

            $coursesType = $this->Home_model->getOrgCoursewise($type);
            ($coursesType ? $data["courseWise"] = $coursesType : "");

            $orgType = $this->Home_model->getOrgTypeWise($type);
            ($orgType ? $data["orgTypeWise"] = $orgType : "");

            $orgStatus = $this->Home_model->getOrgStatusWise($type);
            ($orgStatus ? $data["orgStatusWise"] = $orgStatus : "");

            $this->load->view("home/allOrganizations", $data);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function loadMoreOrg() {
        $type = FILTER_VAR(trim($this->input->post("type")));
        $start = FILTER_VAR(trim($this->input->post("start")));
        if ($type === 'College' || $type === 'University' || $type === 'Institute' || $type === 'School') {

            $orgDetails = $this->Home_model->mGetOrganisationDetails($type, $start, $records = 9);
            if ($orgDetails) {
                $data["orgDetails"] = $orgDetails;
            } else {
                $data["error"] = "";
            }
            $totalOrgs = $this->Home_model->mGetTotalOrganization($type);
            if ($totalOrgs) {
                $data["totalOrgs"] = $totalOrgs;
                $data["type"] = $type;
            }
            $this->load->view("home/loadMoreFilter_view", $data);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function comapreOrganizations() {
        $loginIdsIds = filter_var_array($this->input->post("checkedData"));
        $type = FILTER_VAR(trim($this->input->post("type")));
        if (!empty($loginIdsIds) && count($loginIdsIds) == 2) {
            $start = 0;
            $orgDetails = $this->Home_model->mGetOrganisationDetails($type, $start, $records = 9);
            if ($orgDetails) {
                $data["orgDetails"] = $orgDetails;
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
            $getOrgCourses = $this->Home_model->mGetOrgCourses("0", $type);
            if ($getOrgCourses) {
                $data['orgCourses'] = $getOrgCourses;
            }
            $this->load->view("home/compare_Org_view", $data);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    //get all organisations end
    //filter by cat start
    public function filterByCat() {
        $type = FILTER_VAR(trim($this->input->get("Type")));
        if ($type !== 'College' && $type !== 'University' && $type !== 'Institute' && $type !== 'School') {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $getLatestOrgDetails = $this->Home_model->mGetLatestOrFeaturedOrgDetails($type, 'AND od.orgLatestStatus=1', "");
        if ($getLatestOrgDetails) {
            $data['LatestOrgDetails'] = $getLatestOrgDetails;
        }
        $getTopRatedOrgDetails = $this->Home_model->mGetLatestOrFeaturedOrgDetails($type, 'AND od.orgTopRated=1', "");
        if ($getTopRatedOrgDetails) {
            $data['TopRatedOrgDetails'] = $getTopRatedOrgDetails;
        }
        $getFeatureOrgDetails = $this->Home_model->mGetLatestOrFeaturedOrgDetails($type, 'AND od.orgFeatureStatus=1', "");
        if ($getFeatureOrgDetails) {
            $data['FeatureOrgDetails'] = $getFeatureOrgDetails;
        }
        $data["type"] = $type;
        $this->load->view("home/filter_by_category_view", $data);
    }

    public function getOrgName() {
        $this->viewMessage($this->Home_model->mGetOrgName());
    }

    public function getOrgStatesCityNames() {
        $this->viewMessage($this->Home_model->mGetOrgStatesCityNames());
    }

    public function filterOrganisations() {
        $type = FILTER_VAR(trim($this->input->post("Type")));
        $orgid = $this->input->post('orgid');
        if (!empty($orgid)) {
            $loginid = array_unique(filter_var_array($orgid));
            $loginids = implode(',', $loginid);
            $filterCondition = 'AND od.loginId IN (' . $loginids . ')';
        } else {
            $filterCondition = "";
        }
        $getLatestOrgDetails = $this->Home_model->mGetLatestOrFeaturedOrgDetails($type, 'AND od.orgLatestStatus=1', $filterCondition);
        ($getLatestOrgDetails ? $data['LatestOrgDetails'] = $getLatestOrgDetails : "");

        $getTopRatedOrgDetails = $this->Home_model->mGetLatestOrFeaturedOrgDetails($type, 'AND od.orgTopRated=1', "");
        ($getTopRatedOrgDetails ? $data['TopRatedOrgDetails'] = $getTopRatedOrgDetails : "");

        $getFeatureOrgDetails = $this->Home_model->mGetLatestOrFeaturedOrgDetails($type, 'AND od.orgFeatureStatus=1', $filterCondition);
        ($getFeatureOrgDetails ? $data['FeatureOrgDetails'] = $getFeatureOrgDetails : "");
        $data["type"] = $type;
        $this->load->view("home/filter_org_view", $data);
    }

    public function siteVisitor() {
        $countryId = (isset($_SESSION['countryId']) ? $_SESSION['countryId'] : $this->getIptolocation($_SERVER['REMOTE_ADDR']));
        $this->Home_model->mAddsiteVisitor($countryId);
    }

    public function getVisitors() {
        $this->viewMessage($this->Home_model->mGetVisitors());
    }

    public function orgViewCounter() {
        $this->Home_model->mOrgViewCounter();
    }

    //filter by cat end
    //main header search
    public function mainheaderFilter() {
        $this->viewMessage($this->Home_model->mMainheaderFilter());
    }

    public function locationSearch() {
        $this->viewMessage($this->Home_model->mlocationSearch());
    }

    //main header search
    //Advertise with Us Start
    public function Advertise() {
        $this->load->view("home/advertiseWithus_view");
    }

    public function orgNames() {
        $this->viewMessage($this->Home_model->mOrgNames());
    }

    public function advertisementForm() {
        $this->viewMessage($this->Home_model->mAdvertisementForm());
    }

    //Forgot Student Password Start
    public function forgotpassword() {
        $this->load->view("home/studentpasswordForgot_view");
    }

    public function codegenrations() {
        $this->viewMessage($this->Home_model->mCodegenrations());
    }

    public function forgotPasswordCode() {
        $this->viewMessage($this->Home_model->mForgotPasswordCode());
    }

    //Forgot Student Password End
    //Our Team Start
    public function ourTeam() {
        $getTeam = $this->Home_model->mGetOurTeam();
        ($getTeam ? $data['teamdata'] = $getTeam : $data["error"] = "");
        $this->load->view("home/teamPage_view", $data);
    }

//    public function urlhit() {
//        $url = 'https://cyrusrecharge.in/API/CyrusOperatorFatchAPI.aspx?APIID=AP863433&PASSWORD=Starling123&MOBILENUMBER=9992089947&FORMAT=JSON';
//
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        $result = curl_exec($curl);
//        if (!$result) {
//            die("Connection Failure");
//        }
//        curl_close($curl);
//        echo $result;
//    }
    //Our Team End
    //Carrer Page
    public function carrer() {
        $getTeam = $this->Home_model->mGetOeningData();
        ($getTeam ? $data['openingDetails'] = $getTeam : $data["error"] = "");
        $this->load->view("home/carrerPage_view", $data);
    }

    public function applyForJob() {
        $this->viewMessage($this->Home_model->mApplyForJob());
    }

    //Carrer Page
    //religion start
    public function religion() {
        $this->viewMessage($this->Home_model->mReligion());
    }

    //religion end
    //#enrollNow start
    public function enrollNow() 
	{	
		if($this->input->post("singlebutton")) 
		{
			$singlebutton = FILTER_VAR(trim($this->input->post('singlebutton')));
			if($singlebutton == "Enroll Now")
			{	
				if(isset($_SESSION['studentId'])) 
				{
					$data['ordId'] = FILTER_VAR(trim(base64_decode($this->input->post('lgId'))));
					$data['orgType'] = FILTER_VAR(trim($this->input->post('orgType')));
				$data['courseId'] = FILTER_VAR(trim($this->input->post('courseId')));
				$data['orgCourseId']= FILTER_VAR(trim($this->input->post('orgCourseId')));
					
					if (empty($data['ordId']) || empty($data['orgType'] ) || !isset($_SESSION['studentId'])) 
					{
						$this->viewMessage($this->Home_model->notLoggedIn("nodata"));
					}
					else 
					{
						$data['CourseInfo'] = $this->Home_model->getCourseInfo($data['orgCourseId'], $data['courseId'], $data['orgType'],$data['ordId'], false);
						
						$data['OrgInfo'] = $this->Home_model->mgetEnrollOrgData($data['ordId'], $data['orgType'],true);	
						// $data['enrollId'] = $this->Home_model->mEnrollNow();		
						
						$this->load->view("home/shared/header");
						$this->load->view("checkout",$data);
						$this->load->view("home/shared/footer");
					}					
					// $this->viewMessage($this->Home_model->mEnrollNow());
				}
				else 
				{
					$this->viewMessage($this->Home_model->notLoggedIn("login"));
				}				
			} 
		}
		else
		{
			redirect(base_url());
		}	
    }

    //#enrollNow End
    //FAQ Start
    public function faq() {
        $faq = $this->Home_model->mGetfaq();
        ($faq ? $data["faq"] = $faq : $data['error'] = '');
        $faqCat = $this->Home_model->mGetfaqCategories();
        ($faqCat ? $data["faqCat"] = $faqCat : $data['error'] = '');
        $this->load->view("home/faq_view", $data);
    }

    //FAQ End
    public function orgTypes() {
        $this->viewMessage($this->Home_model->mgetOrgTypes());
    }

    public function getClassNames() {
        $this->viewMessage($this->Home_model->mGetClassNames());
    }

    public function getCourseFeeType() {
        $this->viewMessage($this->Home_model->mGetCourseFeeType());
    }

    public function getSchoolClassType() {
        $this->authenticate();
        $this->viewMessage($this->Home_model->mGetSchoolClassType());
    }

    public function testimonial() {
        $testimonial = $this->Home_model->mGettestimonial();
        ($testimonial ? $data["testimonial"] = $testimonial : $data['error'] = '');

        $this->load->view("home/testimonial", $data);
        //$this->load->view("home/testimonial");
    }

    public function blog() {
        $blogs = $this->Home_model->mGetblogs();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');

        $blogCat = $this->Home_model->mGetblogsCategories();
        ($blogCat ? $data["blogCat"] = $blogCat : $data['error'] = '');

        $this->load->view("home/blog_view", $data);
    }

    public function getCourseName() {
        $this->viewMessage($this->Home_model->mGetCourseName());
    }

    public function setCountry() {
        $countryId = FILTER_VAR(trim($this->input->post('countryId')));
        $set = $this->Home_model->mSetCountrys($countryId);
        if ($set == "done") {
            $this->viewMessage('{"status":"success", "msg":"Country set successful."}');
        } else {
            $this->viewMessage('{"status":"error", "msg":"Country not found!"}');
        }
    }
public function stateValue() {
	unset($_SESSION['stateId']);
        $id = FILTER_VAR(trim($this->input->post('stateId')), FILTER_SANITIZE_NUMBER_INT);
        if (!empty($id)) {
            $_SESSION['stateId'] = $id;
		}
		}
//org Home page filter start
    public function filterOrganisationsHome() {
        $type = FILTER_VAR(trim($this->input->post('orgType')));
        $ratings = FILTER_VAR(trim($this->input->post('ratings')));
        $feeminValue = FILTER_VAR(trim($this->input->post('feeminValue')));
        $feemaxValue = FILTER_VAR(trim($this->input->post('feemaxValue')));
        $courseIds = FILTER_VAR(trim($this->input->post('courseIds')));
        $loginIds = ($this->input->post('loginIds') ? implode(",", $this->input->post('loginIds')) : "");

        $conditions = "";
        $this->filterorghome($type, $ratings, $feeminValue, $feemaxValue, $courseIds, $loginIds, $conditions);
    }

    private function filterorghome($type, $ratings, $feeminValue, $feemaxValue, $courseIds, $loginIds, $conditions) {
        if (!empty($type)) {
            $conditions = $conditions . ($ratings ? " AND ratings>=$ratings " : "");
            $data["type"] = $type;
            if ($type == "University" || $type == "College") {
                $conditions = $conditions . ($feeminValue ? " AND os.courseFee BETWEEN  $feeminValue AND $feemaxValue" : "");
                $conditions = $conditions . ($loginIds ? " AND od.loginId IN($loginIds)  " : "") . ($courseIds ? " AND stds.streamId=$courseIds " : "");
            }
            if ($type == "Institute") {
                $conditions = $conditions . ($feeminValue ? " AND icd.courseFee BETWEEN  $feeminValue AND $feemaxValue" : "");
                $conditions = $conditions . ($loginIds ? " AND od.loginId IN($loginIds)  " : "") . ($courseIds ? " AND icd.insCourseId=$courseIds " : "");
            }
            if ($type == "School") {
                $conditions = $conditions . ($feeminValue ? " AND scd.courseFee BETWEEN  $feeminValue AND $feemaxValue" : "");
                $conditions = $conditions . ($loginIds ? " AND od.loginId IN($loginIds)  " : "") . ($courseIds ? " AND scd.sClassId=$courseIds " : "");
            }
            $qry = $this->Home_model->mgetOrganizationDetails($type, $conditions);
            ($qry ? $data["orgRes"] = $qry : $data["err"] = "");
            $this->load->view("home/homeOrgFilterView", $data);
        }
    }

    //org Home page filter start
    //enquiry Now Start
    public function enquiryNow() {
        $this->viewMessage($this->Home_model->menquiryNow());
    }

    //Enquiry Now End
    public function getHelpContent() {
        $categories = FILTER_VAR(trim($this->input->post('categories')));
        $helpId = FILTER_VAR(trim($this->input->post('helpId')));
        $searchTerm = FILTER_VAR(trim($this->input->post('searchTerm')));
        if ($categories === "categories") {
            $qry = $this->db->where(["parentId" => "0", "isactive" => 1])->get("tbl_helpcategory");
            ($qry->num_rows() > 0 ? $data["categories"] = $qry->result() : $data["error"] = "");
            $this->load->view("home/helpText_view", $data);
        }
        if ($categories === "category" && $helpId != "") {
            $qry = $this->db->where(["categoryId" => $helpId, "isactive" => 1])->get("tbl_helptext");
            ($qry->num_rows() > 0 ? $data["categoryText"] = $qry->result() : $data["error"] = "");
            $this->load->view("home/helpText_view", $data);
        }
        if ($searchTerm !== "") {
            $qry = $this->db->like("helpContent", $searchTerm)->or_like('heading', $searchTerm)->where(["isactive" => 1])->limit("1", "0")->get("tbl_helptext");
            ($qry->num_rows() > 0 ? $data["searchText"] = $qry->result() : $data["error"] = "");

            $this->load->view("home/helpText_view", $data);
        }
    }

    //Marking System Start
    public function getMarkingType() {
        $this->viewMessage($this->Home_model->mGetMarkingType());
    }

    public function addMarkingType() {
        $this->viewMessage($this->Home_model->mAddMarkingType());
    }

    private function viewMessage($message) {
        $data["message"] = $message;
        $this->load->view("view_message", $data);
    }

    //Marking System End
    //Add Competitive Exam Details Start
    public function addCompetitiveExamDetails() {
        $this->viewMessage($this->Home_model->mAddCompetitiveExamDetails());
    }

    public function addSubjectDetails() {
        $this->viewMessage($this->Home_model->mAddSubjectDetails());
    }

    //Add Competitive Exam Details End
    //Add Class Name Start
    public function addNewClass() {
        $this->viewMessage($this->Home_model->mAddNewClass());
    }

    public function getminQualSteam() {
        $this->viewMessage($this->Home_model->mGetminQualSteam());
    }

    public function addClassType() {
        $this->viewMessage($this->Home_model->mAddClassType());
    }

    //Add Class Name End
    //Add Course Name Start
    public function addCourseName() {
        $courseType = FILTER_VAR(trim($this->input->post('courseType')));
        $CourseName = FILTER_VAR(trim($this->input->post('CourseName')));
        $StreamName = FILTER_VAR(trim($this->input->post('StreamName')));
        $this->viewMessage($this->Home_model->mAddCourseName($courseType, $CourseName, $StreamName));
    }

    public function addCourseStreamName() {
        $courseType = FILTER_VAR(trim($this->input->post('courseType')));
        $CourseName = FILTER_VAR(trim($this->input->post('courseName')));
        $StreamName = FILTER_VAR(trim($this->input->post('StreamName')));
        $this->viewMessage($this->Home_model->mAddCourseStreamName($courseType, $CourseName, $StreamName));
    }

    //Add Course Name End
    //Add Exam Mode Start
    public function getExamMode() {
        $this->viewMessage($this->Home_model->mGetExamMode());
    }

    public function addExamMode() {
        $this->viewMessage($this->Home_model->mAddExamMode());
    }

    //Add Exam Mode End
    //Fee Cycle Start
    public function addFeeCycles() {
        $this->viewMessage($this->Home_model->mAddFeeCycles());
    }

    public function getFeeCycle() {
        $this->viewMessage($this->Home_model->mGetFeeCycle());
    }

    //Fee Cycle End
    //Course Type start
    public function getOrgCourseType() {
        $this->viewMessage(json_encode($this->Home_model->mGetOrgCourseType()));
    }

    //Course Type End
    //Add Institute Course Name Start
    /**
     * Login with facebook
     */
    public function addInstituteCourseName() {
        $this->viewMessage($this->Home_model->mAddInstituteCourseName());
    }

    public function getcourseTypeBycourse() {
        $this->viewMessage($this->Home_model->mGetcourseTypeBycourse());
    }
	
	public function payment_success(){
		$this->load->view('success');
	}
	public function payment_failure(){
		$this->load->view('failed');
	}


    public function privacyPolicyPage() {
        $qry = $this->db->select('privacypolicy')->get("web_users");
        $data["privacypolicy"] = ($qry->num_rows() > 0 ? $qry->row()->privacypolicy : "");
        $this->load->view("home/privacypolicy_view", $data);
    }
//////////////// footer pages

	 public function genesis() {
       $blogs = $this->Home_model->mGetgenesis();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hgenesis_view", $data);
    }
	    
	 public function pressRelease() {
        $blogs = $this->Home_model->mGetPressRelease();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hpressRelease_view", $data);
    }
	   
 public function cancelAndReturn() {
        $blogs = $this->Home_model->mGetCancelAndReturn();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hcancelAndReturn_view", $data);
    }
	    
	public function ihuntBestCares() {
 $blogs = $this->Home_model->mGetIhuntBestCares();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hihuntBestCares_view", $data);
    }
	
	public function giftSmile() {
       $blogs = $this->Home_model->mGetGiftSmile();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hgiftSmile_view", $data);
    }
	    
	 public function services() {
        $blogs = $this->Home_model->mGetServices();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hservices_view", $data);
    }
	    
	 public function ihuntBestStories() {
        $blogs = $this->Home_model->mGetIhuntBestStories();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hihuntBestStories_view", $data);
    }
	  
	public function support() {
        $blogs = $this->Home_model->mGetSupport();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hsupport_view", $data);
    }
	  
	public function paymentsSaved() {
         $blogs = $this->Home_model->mGetPaymentsSaved();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hpaymentsSaved_view", $data);
    }
	    
	 public function cardsShipping() {
         $blogs = $this->Home_model->mGetCardsShipping();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hcardsShipping_view", $data);
    }
	
	 public function reportInfringement() {
        $blogs = $this->Home_model->mGetReportInfringement();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hreportInfringement_view", $data);
    }
	
	 public function writeToUs() {
        $blogs = $this->Home_model->mGetWriteToUs();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hwriteToUs_view", $data);
    }
	
	public function showBrandEmpowerment() {
        $blogs = $this->Home_model->mGetShowBrandEmpowerment();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hshowBrandEmpowerment_view", $data);
    }
	  public function onlineShopping() {
         $blogs = $this->Home_model->mGetOnlineShopping();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/honlineShopping_view", $data);
    }
	
	 public function affiliateProgram() {
         $blogs = $this->Home_model->mGetAffiliateProgram();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/haffiliateProgram_view", $data);
    }
	 public function giftCardOffer() {
        $blogs = $this->Home_model->mGetGiftCardOffer();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hgiftCardOffer_view", $data);
    }
	 public function firstSubscription() {
         $blogs = $this->Home_model->mGetFirstSubscription();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hfirstSubscription_view", $data);
    }
	  public function siteMap() {
         $blogs = $this->Home_model->mGetSiteMap();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hsiteMap_view", $data);
    }
	 public function returnPolicy() {
        $blogs = $this->Home_model->mGetReturnPolicy();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hreturnPolicy_view", $data);
    }
	  public function termsOfUse() {
         $blogs = $this->Home_model->mGetTermsOfUse();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/htermsOfUse_view", $data);
    }
	  public function securityPolicy() {
         $blogs = $this->Home_model->mGetSecurityPolicy();
        ($blogs ? $data["blogs"] = $blogs : $data['error'] = '');
        $this->load->view("home/hsecurityPolicy_view", $data);
    }
    public function getPosterData(){
    	$posterData = $this->Home_model->mGetValidPosterData();
    	if($posterData->num_rows()>0){
			$response = ['status'=>true,'message'=>'Banner data.','data'=>$posterData->result()];
		}else{
    		$response = ['status'=>false,'message'=>'Banner data not found','data'=>[]];
		}
		$this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($response));
	}

	public function banner_link(){
		$identifier = $this->input->get('identifier');
		$redirect_link = $this->input->get('link');
		if(!empty($identifier)){
			$no_of_hits = $this->db->where(['adsId' => $identifier])->select('no_of_hits')->get('advertisement');
			if($no_of_hits->num_rows()>0){
				$no_of_hits = $no_of_hits->row();
				 $this->db->where(['adsId' => $identifier])->update('advertisement', ["no_of_hits" => $no_of_hits->no_of_hits+1]);
			}
		}
		if(!empty($redirect_link)){
			redirect($redirect_link);
		}else{
			redirect(site_url());
		}
	}
}
