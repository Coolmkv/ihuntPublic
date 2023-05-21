<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set('Asia/Kolkata');
        }
        $this->load->library('image_lib');
        $this->load->model("Student_model");
        $this->load->helper('cookie');
    }

    //student Profile start
    public function index() {
        $this->authenticate();
        $profilestatus = $this->Student_model->mgetProfileCompletion(['studentId' => $_SESSION['studentId'], "isactive" => 1], 'student_details');
        if ($profilestatus) {
            $data['profileStatus'] = $profilestatus;
        } else {
            $data['error'] = 'error';
        }
        $secSchoolDetails = $this->Student_model->mgetProfileCompletion(['studentId' => $_SESSION['studentId'], "isactive" => 1], 'student_secondary_school_details');
        if ($secSchoolDetails) {
            $data['secSchool'] = $secSchoolDetails;
        }
        $details = $this->Student_model->mGetStudentDetails();
        ($details ? $data['details'] = $details : "");
        $this->load->view('student/student_dashboard_view', $data);
    }

    public function editpersonalprofile() {
        $this->authenticate();
        $profileinfo = $this->Student_model->mgetStudentProfileInfo();
        if ($profileinfo) {
            $data['profileinfo'] = $profileinfo;
        } else {
            $data = '';
        }
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'location';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->load->view('student/student_personalprofileEdit_view', $data);
    }

    public function profilePersonalDetails() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mProfilePersonalDetails());
    }

    public function editsecondarySchoolInfo() {
        $this->authenticate();
        $profileinfo = $this->Student_model->mgetStudentSecondarySchoolInfo();
        if ($profileinfo) {
            $data['profileinfo'] = $profileinfo;
        }
        $markingtype = $this->db->where(["isactive" => 1, "markingTitle!=" => ""])->get("tbl_markingsystem");
        ($markingtype->num_rows() > 0 ? $data["markingType"] = $markingtype->result() : "");
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'location';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->load->view('student/student_SecondarySchoolInfoEdit_view', $data);
    }

    public function secodarySchoolDetails() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mSecodarySchoolDetails());
    }

    public function getSchoolNames() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetSchoolNames());
    }

    public function editsrsecondarySchoolInfo() {
        $this->authenticate();
        $profileinfo = $this->Student_model->mGetSenSecSchoolInfo();
        if ($profileinfo) {
            $data['profileinfo'] = $profileinfo;
        }
        $markingtype = $this->db->where(["isactive" => 1])->get("tbl_markingsystem");
        ($markingtype->num_rows() > 0 ? $data["markingType"] = $markingtype->result() : "");
        $subjectNames = $this->Student_model->mGetSubjectNames();

        ($subjectNames ? $data["subjectNames"] = $subjectNames : "");
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'location';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $this->load->view('student/student_Senior_SecondarySchoolInfoEdit_view', $data);
    }

    public function secodarySecSchoolDetails() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mInsertSenSecodarySchoolDetails());
    }

    public function getClassTypeName() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetClassTypeName());
    }

    public function edithigherInfo() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'location';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $qry = $this->Student_model->mGetCourseType();
        if ($qry) {
            $data["coursetypes"] = $qry;
        }
        $markingtype = $this->db->where(["isactive" => 1])->get("tbl_markingsystem");
        ($markingtype->num_rows() > 0 ? $data["markingType"] = $markingtype->result() : "");
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'university_address';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map2'] = $this->googlemaps->create_map();
        $this->load->view('student/student_HigherEduInfoEdit_view', $data);
    }

    public function getCourseNames() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetCourseNames());
    }

    public function getStreamNames() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetStreamNames());
    }

    public function getCollegeNames() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetCollegeNames());
    }

    public function getUniversityNames() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetUniversityNames());
    }

    public function insertHigherEducationDetails() {
        $this->authenticate();
        $student_hed_id = FILTER_VAR(trim($this->input->post('student_hed_id')), FILTER_SANITIZE_STRING);
        $courseType = FILTER_VAR(trim($this->input->post('courseType')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->Student_model->mInsertHigherEducationDetails($student_hed_id, $courseType));
    }

    public function getHigherEduDetail() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetHigherEduDetail());
    }
	 public function showMsg() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mshowMsg());
    }

    public function delHigherEduDetail() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mDelHigherEduDetail());
    }

    public function profile() {
        $this->authenticate();
        $profileinfo = $this->Student_model->mgetStudentProfileInfo();
        if ($profileinfo) {
            $data['profileinfo'] = $profileinfo;
        } else {
            $data = '';
        }
        $this->load->view('student/student_profile_view', $data);
    }

    public function deletedocument() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mDeletedocument());
    }

    public function uploadDocuments() {
        $this->authenticate();
        $documentsUplaoded = $this->Student_model->mGetStudentDocuments();
        if ($documentsUplaoded) {
            $data['docs'] = $documentsUplaoded;
        } else {
            $data['error'] = '';
        }
        $this->load->view('student/student_Dcument_Upload_view', $data);
    }

	  public function notifyMsg() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mnotifyMsg());
    }
	
    public function uploadRelatedDocs() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mUploadRelatedDocs());
    }
	  public function uploadOrgDocs() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->muploadStudentOrgDoc());
		//redirect($_SERVER['HTTP_REFERER']);
	
    }

    public function uploadedDocument() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mUploadedDocument());
    }

    public function competitiveExamDetails() {
        $this->authenticate();
        $qry = $this->Student_model->mGetExamNames();
        if ($qry) {
            $data['examNames'] = $qry;
        } else {
            $data['error'] = "";
        }
        $this->load->view('student/student_CompetitveExam_view', $data);
    }

    public function addreqExam() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mAddreqExam());
    }

    public function insertCompetitveExamDetails() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mInsertCompetitveExamDetails());
    }

    public function getCompetitiveExamDetails() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetCompetitiveExamDetails());
    }

    public function delCompetitiveExam() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->deleteCompExam());
    }

    public function getSubjectNames() {
        $this->authenticate();
        $this->viewMessage(json_encode($this->Student_model->mGetSubjectNames()));
    }

    public function addNewSubject() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mAddNewSubject());
    }

    //student profile end
    //Student Experience Details Start
    public function experience() {
        $this->authenticate();
        $this->load->view('student/student_experience_view');
    }

    public function insertExperienceDetails() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mInsertExperienceDetails());
    }

    public function getExperienceDetails() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetExpericeDetails());
    }

    public function delExperienceDetail() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mDelExperienceDetail());
    }

    //Student Experience Details End
    //Student Job Application Start
    public function studentJobProfile() {
        $this->authenticate();
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'preffered_location';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $profileinfo = $this->Student_model->mgetStudentSecondarySchoolInfo();
        ($profileinfo ? $data['profileinfo'] = $profileinfo : "");
        $jobprofile = $this->Student_model->mgetStudentJobProfileDetails();
        if ($jobprofile) {
            $data['jobprofile'] = $jobprofile;
        }
        $this->load->library('googlemaps');
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'present_location';
        $config['placesAutocompleteBoundsMap'] = TRUE;
        $this->googlemaps->initialize($config);
        $data['map1'] = $this->googlemaps->create_map();
        $this->load->view('student/student_jobapplication_view', $data);
    }

    public function insertJobProfileDetails() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mInsertJobProfileDetails());
    }

    //Student Job Application End
    //Student Refers Start
    public function referes() {
        $this->authenticate();
        $getProfileDetails = $this->Student_model->mgetProfileDetails();
        if ($getProfileDetails) {
            $data["referDetails"] = $getProfileDetails;
        } else {
            $data["norecord"] = "";
        }
        $this->load->view('student/student_refers_view', $data);
    }

    public function addMyReference() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mAddMyReference());
    }

    //Organisation Ratings Start
    public function addRating() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mAddRating());
    }

    //Organisation Ratings End
    //Student Refers End
    //Earn and Share value by student created by shweta
    public function earnandsharevalue() {
        $this->authenticate();
        $this->load->view("student/earn_n_share_value_view");
    }

    public function getearnandsharevalue() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetearnandsharevalue());
    }

    //Earn and Share value by student end  by shweta
    //my Applications view start
    public function myApplications() {
        $this->authenticate();
        $this->load->view('student/myApplications_view');
    }

    public function mgetMyApplication() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mMyApplications());
    }

    //My Applications view end
    //Notifications Start
    public function myNotifications() {
        $this->authenticate();
        $this->Student_model->mMarkAsReadNotifications();
        $this->load->view('student/myNotifications_view');
    }

    public function getNotifications() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetNotifications());
    }

    //Notifications End
    //Institute Exam Details Start
    public function instituteExamDetails() {
        $this->authenticate();
        $qry = $this->db->where(["isactive" => 1, "title!=" => ""])->get("institute_course");
        ($qry->num_rows() > 0 ? $data["inscourseNames"] = $qry->result() : $data["error"] = "");
        $markingtype = $this->db->where(["isactive" => 1, "markingTitle!=" => ""])->get("tbl_markingsystem");
        ($markingtype->num_rows() > 0 ? $data["markingType"] = $markingtype->result() : "");
        $this->load->view('student/instituteExamDetails_view', $data);
    }

    public function getinstitutenames() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetinstitutenames());
    }

    public function insertInstituteEducationDetails() {
        $this->authenticate();
        $sInsId = FILTER_VAR(trim($this->input->post('studentInsId')), FILTER_SANITIZE_STRING);
        $insCId = FILTER_VAR(trim($this->input->post('insCourseId')), FILTER_SANITIZE_STRING);
        $mType = FILTER_VAR(trim($this->input->post('markingType')), FILTER_SANITIZE_STRING);
        $mValue = FILTER_VAR(trim($this->input->post('markingValue')), FILTER_SANITIZE_STRING);
        $csDate = FILTER_VAR(trim($this->input->post('coursestartDate')), FILTER_SANITIZE_STRING);
        $cEDate = FILTER_VAR(trim($this->input->post('courseEndDate')), FILTER_SANITIZE_STRING);
        $iName = FILTER_VAR(trim($this->input->post('instituteName')), FILTER_SANITIZE_STRING);

        $this->viewMessage($this->Student_model->mInsertInstituteEducationDetails($sInsId, $insCId, $mType, $mValue, $csDate, $cEDate, $iName));
    }

    public function getInstituteEducationDetail() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mGetInstituteEducationDetail());
    }

    public function delInstEduDetail() {
        $this->authenticate();
        $this->viewMessage($this->Student_model->mDelInstEduDetail());
    }

    //Institute Exam Details End
    private function authenticate() {
        if (!isset($_SESSION['studentId'])) {
            redirect('Register/logout');
            return false;
        } else {

        }
    }

    private function viewMessage($message) {
        $data["message"] = $message;
        $this->load->view("view_message", $data);
    }

//        public function emailSend() {
//            $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'ssl://smtp.googlemail.com',
//            'smtp_port' => 465,
//            'smtp_user' => 'manish.starlingsoftwares@gmail.com',
//            'smtp_pass' => 'Manish@1857',
//            'mailtype'  => 'html',
//            'charset'   => 'iso-8859-1'
//        );
//
//        $this->load->library('email', $config);
//        $this->email->set_newline("\r\n");
//        // Set to, from, message, etc.
//         $this->email->initialize($config);
//            $this->email->from('manish.starlingsoftwares@gmail.com', 'Manish');
//            $this->email->to('vermamanish4u@gmail.com');
////            $this->email->cc('another@another-example.com');
////            $this->email->bcc('them@their-example.com');
//
//            $this->email->subject('Email Test');
//            $this->email->message('Testing the email class.');
//            $this->email->subject('Email Test');
//            $this->email->message('Testing the email class.');
//        $result = $this->email->send();
//    echo $this->email->print_debugger();
//
//        echo "Email Result:".$result;
//        }
}
