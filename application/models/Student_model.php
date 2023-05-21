<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
        $this->load->database();
    }

    //student profile start
    public function mgetStudentProfileInfo() {
        $studentId = $_SESSION['studentId'];
        $qry = $this->db->query("SELECT sd.*, ctr.name ctryname,sta.name statename,tr.religionName,cty.name ctyname
                                                    ,DATE_FORMAT(dob,'%d-%b-%Y') as date_of_birth FROM student_details sd
                                                    LEFT JOIN countries ctr ON ctr.countryId=sd.countryId
                                                    LEFT JOIN states sta ON sta.stateId=sd.stateId
                                                    LEFT JOIN cities cty ON cty.cityId=sd.cityId
                                                    LEFT JOIN tbl_religions tr ON tr.religionId=sd.religion
                                                    WHERE sd.isactive=1 AND sd.studentId=$studentId");
        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return false;
        }
    }

    public function mgetProfileCompletion($conditon, $tablename) {
        $this->db->where($conditon);
        $qry = $this->db->get($tablename);
        if ($qry->num_rows() > 0) {
            $arr = $qry->row();

            $total = sizeof((array) $arr);
            $filtera = array_filter((array) $arr);
            $filled = sizeof((array) $filtera);
            return round(($filled / $total) * 100);
        } else {
            return false;
        }
    }

    public function mGetStudentDetails() {
        $qry = $this->db->query("SELECT count(*) totalNotifications FROM tbl_notifications tn
                WHERE tn.notificationFor=" . $_SESSION['studentId'] . " AND tn.isactive=1 AND tn.tableName='student_login' AND tn.isRead=0");

        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return false;
        }
    }

    public function mProfilePersonalDetails() {
        $studentName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('studentName')))), FILTER_SANITIZE_STRING);
        $studentMobile = FILTER_VAR(trim($this->input->post('studentMobile')), FILTER_SANITIZE_NUMBER_INT);
        $gender = FILTER_VAR(trim($this->input->post('gender')), FILTER_SANITIZE_STRING);
        $dob = FILTER_VAR(trim($this->input->post('dob')), FILTER_SANITIZE_STRING);
        $country = FILTER_VAR(trim($this->input->post('country')), FILTER_SANITIZE_STRING);
        $state = FILTER_VAR(trim($this->input->post('state')), FILTER_SANITIZE_STRING);
        $ctyname = FILTER_VAR(trim($this->input->post('ctyname')), FILTER_SANITIZE_STRING);
        $location = FILTER_VAR(trim($this->input->post('location')), FILTER_SANITIZE_STRING);
        $studentdetaild = FILTER_VAR(trim($this->input->post('studentdetaild')), FILTER_SANITIZE_STRING);
        $placeofBirth = FILTER_VAR(trim($this->input->post('placeofBirth')), FILTER_SANITIZE_STRING);
        $fatherName = FILTER_VAR(trim($this->input->post('fatherName')), FILTER_SANITIZE_STRING);
        $religion = FILTER_VAR(trim($this->input->post('religion')), FILTER_SANITIZE_STRING);

        if (!isset($_SESSION['studentId']) || empty($studentName) || empty($studentMobile) || empty($gender) || empty($dob) || empty($country) || empty($state) || empty($ctyname) || empty($location)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        if ($studentdetaild == 'no_id') {
            return $this->insertStudentProfilePersonalDetails($_SESSION['studentId'], $studentName, $studentMobile, $gender, $dob, $country, $state, $ctyname, $location, $placeofBirth, $fatherName, $religion);
        } else {
            return $this->updateStudentProfilePersonalDetails($_SESSION['studentId'], base64_decode($studentdetaild), $studentName, $studentMobile, $gender, $dob, $country, $state, $ctyname, $location, $placeofBirth, $fatherName, $religion);
        }
    }

    private function insertStudentProfilePersonalDetails($studentId, $studentName, $studentMobile, $gender, $dob, $country, $state, $ctyname, $location, $placeofBirth, $fatherName, $religion) {
        $chData = ['studentId' => $studentId, 'isactive' => 1];
        $chkData = $this->db->where($chData)->get("student_details");

        if ($chkData->num_rows() > 0) {
            $rdata = $chkData->row();
            $studentdetaild = $rdata->studentdetaild;
            $this->updateStudentProfilePersonalDetails($studentId, $studentdetaild, $studentName, $studentMobile, $gender, $dob, $country, $state, $ctyname, $location, $placeofBirth, $fatherName, $religion);
        } else {
            $idata = ["studentId" => $studentId, "studentName" => $studentName, "studentMobile" => $studentMobile, "gender" => $gender, "dob" => $dob, "countryId" => $country, 'placeofBirth' => $placeofBirth,
                'fatherName' => $fatherName, 'religion' => $religion, "stateId" => $state, "cityId" => $ctyname, "location" => $location, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("student_details", $idata);
        }
        if ($res) {
            if (isset($_FILES['studentImage']['name'])) {
                $this->uploadProfilePic($studentId, $studentName);
            }
            $this->addActivityLog($_SESSION['studentId'], "Student Details Inserted", "student_details", "0");
            return '{"status":"success","msg":"Saved Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function uploadProfilePic($studentId, $studentName) {
        $path = './projectimages/images/studentProfileImages/' . date('Y') . '/' . date('m') . '/';
        $imgName = $studentName . strtotime($this->datetimenow());
        $this->createDirectory($path);
        $imgresp = $this->uploadImage($path, $imgName, 'studentImage', 100, 400);
        if ($imgresp != 'error') {
            $imgpath = 'projectimages/images/studentProfileImages/' . date('Y') . '/' . date('m') . '/' . $imgresp;
            $udata = ["studentImage" => $imgpath];
            $respo = $this->db->where("studentId", $studentId)->update('student_details', $udata);

            ($respo && (file_exists($this->input->post("previmage"))) ? unlink($this->input->post("previmage")) : "");
            return true;
        } else {
            return FALSE;
        }
    }

    private function uploadImage($path, $imgName, $uploadfname, $quality, $size) {
        $config = ['upload_path' => $path, 'allowed_types' => "gif|jpg|png|jpeg|JPG|JPEG|PNG|GIF", "file_name" => $imgName];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($uploadfname) == false) {
            return 'error';
        } else {
            $data = $this->upload->data();
            $newImage = $data['file_name'];
            $config = ['image_library' => "gd2", 'source_image' => $path . $newImage, 'new_image' => $path . $newImage, "create_thumb" => FALSE, "maintain_ratio" => TRUE, "quality" => $quality, "width" => $size];
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

    private function updateStudentProfilePersonalDetails($studentId, $studentdetaild, $studentName, $studentMobile, $gender, $dob, $country, $state, $ctyname, $location, $placeofBirth, $fatherName, $religion) {
        $chkdata = ["studentdetaild!=" => $studentdetaild, "studentId" => $studentId, "studentName" => $studentName, "studentMobile" => $studentMobile, "gender" => $gender,
            "dob" => $dob, "countryId" => $country, "stateId" => $state, "cityId" => $ctyname, "location" => $location, "isactive" => 1];

        $chkData = $this->db->where($chkdata)->get("student_details");
        if ($chkData->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate Value"}';
        } else {
            $udata = ["studentName" => $studentName, "studentMobile" => $studentMobile, "gender" => $gender, "dob" => $dob, "countryId" => $country, 'placeofBirth' => $placeofBirth,
                'fatherName' => $fatherName, 'religion' => $religion, "stateId" => $state, "cityId" => $ctyname, "location" => $location, "updatedAt" => $this->datetimenow()];

            $res = $this->db->where("studentdetaild", $studentdetaild)->update("student_details", $udata);
        }
        if ($res) {
            if (isset($_FILES['studentImage']['name'])) {
                $this->uploadProfilePic($studentId, $studentName);
            }
            $this->addActivityLog($_SESSION['studentId'], "Student Details Updated", "student_details", "0");
            return '{"status":"success","msg":"Saved Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
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
	 
    public function mUploadRelatedDocs() {
        $studentId = $_SESSION['studentId'];
        $AboutDoc = FILTER_VAR(trim($this->input->post('AboutDoc')), FILTER_SANITIZE_STRING);
        $fileUploadId = FILTER_VAR(trim($this->input->post('fileUploadId')), FILTER_SANITIZE_STRING);
        if (isset($_FILES['documentUpload']['name'])) {
            $fileName = preg_replace("/\s+/", "_", $_FILES['documentUpload']['name']);
            $uploaddoc = $this->uploadStudentDoc($_SESSION['studentName'], $fileUploadId);
        } else {
            $uploaddoc = "";
            $fileName = FILTER_VAR(trim($this->input->post('OrgFileName')), FILTER_SANITIZE_STRING);
        }
        if ($fileUploadId == "no_id") {
            $chk = $this->db->where(["OrgFileName" => $fileName, "studentId" => $studentId, "isactive" => 1])->get("tbl_student_file_upload");
        } else {
            $fileNamec = ($fileName == "" ? "Random" : $fileName);
            $chk = $this->db->where(["fileUploadId!=" => $fileUploadId, "studentId" => $studentId, "OrgFileName" => $fileNamec, "isactive" => 1])->get("tbl_student_file_upload");
        }
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate File!"}';
        }
        return $this->updateInsertRelatedFileInfo($uploaddoc, $studentId, $fileName, $AboutDoc, $fileUploadId);
    }

    private function updateInsertRelatedFileInfo($uploaddoc, $studentId, $fileName, $AboutDoc, $fileUploadId) {
        $ufileName = ($uploaddoc != "" ? $uploaddoc["status"] == "success" ? $uploaddoc["response"] : "" : "");
        $uploadStatus = ($uploaddoc != "" ? $uploaddoc["status"] == "success" ? " And Uploaded Success" : " And Upload Failure" : "");
        if ($fileUploadId == "no_id") {
            if ($ufileName == "") {
                return '{"status":"error","msg":"Required field is empty!"}';
            }

            $res = $this->db->insert("tbl_student_file_upload", ["studentId" => $studentId, "fileName" => $ufileName, "OrgFileName" => $fileName, "AboutDoc" => $AboutDoc, "createdAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr(), "isactive" => 1]);
            $this->addActivityLog($_SESSION['studentId'], "Document Uploaded Inserted", "tbl_student_file_upload", "0");
            return ($res ? '{"status":"success","msg":"Saved Successfully ' . $uploadStatus . '"}' : '{"status":"error","msg":"Error in server, please contact admin!  ' . $uploadStatus . '"}');
        } else {
            $chk = $this->db->where(["studentId" => $studentId, "fileUploadId" => $fileUploadId, "isactive" => 1])->get("tbl_student_file_upload");
            if ($chk->num_rows() > 0) {
                $ifileName = $chk->row()->fileName;
                $nfileName = ($ufileName == "" ? $ifileName : $ufileName);
                $udata = ["fileName" => $nfileName, "OrgFileName" => $fileName, "AboutDoc" => $AboutDoc, "updatedAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr()];
                $res = $this->db->where(["fileUploadId" => $fileUploadId])->update("tbl_student_file_upload", $udata);
                $this->addActivityLog($_SESSION['studentId'], "Document Uploaded Updated", "tbl_student_file_upload", "0");
            }
            return ($res ? '{"status":"success","msg":"Saved Successfully ' . $uploadStatus . '"}' : '{"status":"error","msg":"Error in server, please contact admin!  ' . $uploadStatus . '"}');
        }
    }

    private function uploadStudentDoc($studentName) {

        $this->createDirectory('./uploadedDocuments/' . date('Y') . '/' . date('m'));
        $config['upload_path'] = './uploadedDocuments/' . date('Y') . '/' . date('m');
        $config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX';
        $config['file_name'] = preg_replace("/\s+/", "_", $studentName) . strtotime(date('Y-m-d h:i:s'));
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('documentUpload')) {
            $error = array('error' => $this->upload->display_errors());
            $response = ["response" => $error, "status" => "error"];
            return $response;
        } else {
            $data = $this->upload->data('file_name');
            $fileName = 'uploadedDocuments/' . date('Y') . '/' . date('m') . '/' . $data;
            $response = ["response" => $fileName, "status" => "success"];
            return $response;
        }
    }

    public function muploadStudentOrgDoc() {

        $this->createDirectory('./organizationDocuments/' . date('Y') . '/' . date('m'));
        $config['upload_path'] = './organizationDocuments/' . date('Y') . '/' . date('m');
        $config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX';
        $config['file_name'] = preg_replace("/\s+/", "_", $_SESSION['studentId'].'student') . strtotime(date('Y-m-d h:i:s'));
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('documentUpload')) {
            $error = array('error' => $this->upload->display_errors());
            //$response = ["response" => $error, "status" => "error"];
            $enrollmentId = FILTER_VAR(trim($this->input->post('enrollmentId')), FILTER_SANITIZE_STRING);
			$orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);
			$studentId = FILTER_VAR(trim($this->input->post('studentId')), FILTER_SANITIZE_STRING);
			$msg = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);
			$msgFrom = FILTER_VAR(trim($this->input->post('msgFrom')), FILTER_SANITIZE_STRING);
			$msgTo = FILTER_VAR(trim($this->input->post('msgTo')), FILTER_SANITIZE_STRING);
		
			if (empty($enrollmentId) || empty($orgId) || empty($studentId) || empty($msg)|| empty($msgFrom)|| empty($msgTo)) {
				return '{"status":"error", "msg":"Required details are empty!"}';
			}
			$iData = ["orgId" => $orgId, "enrollmentId" => $enrollmentId, "studentId" => $studentId, "msg" => $msg,"msgFrom" => $msgFrom,"msgTo" => $msgTo];
				$res = $this->db->insert("tbl_notifications_msg", $iData);
				
				return($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
        } else {
            $data = $this->upload->data('file_name');
            $fileName = 'organizationDocuments/' . date('Y') . '/' . date('m') . '/' . $data;
            //$response = ["response" => $fileName, "status" => "success"];
			$enrollmentId = FILTER_VAR(trim($this->input->post('enrollmentId')), FILTER_SANITIZE_STRING);
			$orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_STRING);
			$studentId = FILTER_VAR(trim($this->input->post('studentId')), FILTER_SANITIZE_STRING);
			$msg = FILTER_VAR(trim($this->input->post('message')), FILTER_SANITIZE_STRING);
			$msgFrom = FILTER_VAR(trim($this->input->post('msgFrom')), FILTER_SANITIZE_STRING);
			$msgTo = FILTER_VAR(trim($this->input->post('msgTo')), FILTER_SANITIZE_STRING);
		
			if (empty($enrollmentId) || empty($orgId) || empty($studentId) || empty($msg)|| empty($msgFrom)|| empty($msgTo)) {
				return '{"status":"error", "msg":"Required details are empty!"}';
			}
			$iData = ["orgId" => $orgId, "enrollmentId" => $enrollmentId, "studentId" => $studentId, "msg" => $msg,"msgFrom" => $msgFrom,"msgTo" => $msgTo,"docAttachment"=>$fileName];
				$res = $this->db->insert("tbl_notifications_msg", $iData);
				
				return($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
				  //return $response;
		   }
			
           
        }
    

    private function createDirectory($path) {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
            return 'created';
        } else {
            return 'present';
        }
    }

    public function mUploadedDocument() {
        $studentId = $_SESSION['studentId'];
        $fileUploadId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);

        $getDetails = $this->db->where(["studentId" => $studentId, "fileUploadId" => $fileUploadId, "isactive" => 1])->get("tbl_student_file_upload");
        if ($getDetails->num_rows() > 0) {
            $response = $getDetails->row();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mGetStudentDocuments() {
        $studentId = $_SESSION['studentId'];
        $qry = $this->db->query("SELECT * from tbl_student_file_upload where isactive=1 AND studentId=$studentId order by createdAt desc");
        if ($qry->num_rows() > 0) {
            return $qry->result();
        } else {
            return false;
        }
    }

    public function mDeletedocument() {
        $studentId = $_SESSION['studentId'];
        $fileUploadId = FILTER_VAR(trim($this->input->post('del')), FILTER_SANITIZE_STRING);
        if (empty($studentId) || empty($fileUploadId)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        $chk = $this->db->where(["studentId" => $studentId, 'fileUploadId' => $fileUploadId, 'isactive' => 1])->get('tbl_student_file_upload');
        if ($chk->num_rows() > 0) {
            $uData = ["updatedAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr(), "isactive" => 0];
            $this->db->where(['fileUploadId' => $fileUploadId])->update("tbl_student_file_upload", $uData);
            $rowData = $chk->row();
            (file_exists($rowData->fileName) ? unlink($rowData->fileName) : '');
            return '{"status":"success","msg":"Deleted Successfully"}';
        } else {
            return '{"status":"error","msg":"Record not found!"}';
        }
    }

    public function mGetSchoolNames() {
        $keyword = FILTER_VAR(trim($this->input->post('keyword')), FILTER_SANITIZE_STRING);
        $schoolData = $this->db->query("SELECT od.orgId,od.orgName,od.loginId FROM login_details ld
                                        INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                                        WHERE ld.isactive=1 AND ld.verifyStatus=1 AND ld.roleName='School' AND od.orgName LIKE '%" . $keyword . "%'");

        if ($schoolData->num_rows() > 0) {
            return json_encode($schoolData->result());
        } else {
            return 'NotFound';
        }
    }

    public function mGetUniversityNames() {
        $keyword = FILTER_VAR(trim($this->input->post('keyword')), FILTER_SANITIZE_STRING);
        $schoolData = $this->db->query("SELECT od.orgId,od.orgName,od.loginId FROM login_details ld
                                        INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                                        WHERE ld.isactive=1 AND ld.verifyStatus=1 AND ld.roleName='University' AND od.orgName LIKE '%" . $keyword . "%'");
        if ($schoolData->num_rows() > 0) {

            return json_encode($schoolData->result());
        } else {
            return 'NotFound';
        }
    }

    public function mGetCollegeNames() {
        $keyword = FILTER_VAR(trim($this->input->post('keyword')), FILTER_SANITIZE_STRING);
        $schoolData = $this->db->query("SELECT od.orgId,od.orgName,od.loginId FROM login_details ld
                                        INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                                        WHERE ld.isactive=1 AND ld.verifyStatus=1 AND ld.roleName='College' AND od.orgName LIKE '%" . $keyword . "%'");
        if ($schoolData->num_rows() > 0) {
            return json_encode($schoolData->result());
        } else {
            return 'NotFound';
        }
    }

    public function mgetStudentSecondarySchoolInfo() {
        $studentId = $_SESSION['studentId'];
        $qry = $this->db->query("SELECT * FROM student_secondary_school_details WHERE studentId=" . $studentId . " AND isactive=1");
        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return false;
        }
    }

    public function mSecodarySchoolDetails() {
        $sssd_id = FILTER_VAR(trim($this->input->post('sssd_id')), FILTER_SANITIZE_STRING);
        $schoolOrg_id = FILTER_VAR(trim($this->input->post('schoolOrg_id')), FILTER_SANITIZE_STRING);
        $classTypeId = FILTER_VAR(trim($this->input->post('classTypeId')), FILTER_SANITIZE_STRING);
        $studentClass = FILTER_VAR(trim($this->input->post('studentClass')), FILTER_SANITIZE_STRING);
        $SchoolName = FILTER_VAR(trim($this->input->post('SchoolName')), FILTER_SANITIZE_STRING);
        $boardName = FILTER_VAR(trim($this->input->post('boardName')), FILTER_SANITIZE_STRING);
        $markingType = FILTER_VAR(trim($this->input->post('markingType')), FILTER_SANITIZE_STRING);
        $markingValue = FILTER_VAR(trim($this->input->post('markingValue')), FILTER_SANITIZE_STRING);
        $passingyear = FILTER_VAR(trim($this->input->post('passingyear')), FILTER_SANITIZE_STRING);
        $country = FILTER_VAR(trim($this->input->post('country')), FILTER_SANITIZE_STRING);
        $state = FILTER_VAR(trim($this->input->post('state')), FILTER_SANITIZE_STRING);
        $ctyname = FILTER_VAR(trim($this->input->post('ctyname')), FILTER_SANITIZE_STRING);
        $location = FILTER_VAR(trim($this->input->post('location')), FILTER_SANITIZE_STRING);

        if (empty($studentClass) || empty($classTypeId) || empty($SchoolName) || empty($boardName) || empty($markingType) || empty($markingValue) || empty($passingyear) || empty($country) || empty($state) || empty($ctyname) || empty($location)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        return ($sssd_id == "no_id" ? $this->insertSecSchoolDetails($schoolOrg_id, $studentClass, $classTypeId, $SchoolName, $boardName, $markingType, $markingValue, $passingyear, $country, $state, $ctyname, $location) :
                $this->updateSecSchoolDetails($sssd_id, $schoolOrg_id, $classTypeId, $studentClass, $SchoolName, $boardName, $markingType, $markingValue, $passingyear, $country, $state, $ctyname, $location));
    }

    private function insertSecSchoolDetails($schoolOrg_id, $studentClass, $classTypeId, $SchoolName, $boardName, $markingType, $markingValue, $passingyear, $country, $state, $ctyname, $location) {

        $chData = ['studentId' => $_SESSION['studentId'], 'isactive' => 1];
        $chkData = $this->db->where($chData)->get("student_secondary_school_details");
        if ($chkData->num_rows() > 0) {
            $rdata = $chkData->row();
            $sssd_id = $rdata->sssd_id;
            return $this->updateSecSchoolDetails($sssd_id, $schoolOrg_id, $classTypeId, $studentClass, $SchoolName, $boardName, $markingType, $markingValue, $passingyear, $country, $state, $ctyname, $location);
        } else {
            $markingTypeidr = $this->db->where(["markingTitle" => $markingType, "isactive" => 1])->get("tbl_markingsystem");
            $markingTypeid = ($markingTypeidr->num_rows() > 0 ? $markingTypeidr->row()->markingsystemId : "");
            $organisationId = $this->getOrganisationId($schoolOrg_id, $SchoolName, 'School');
            $idata = ["studentId" => $_SESSION['studentId'], "class_name" => $studentClass, "classTypeId" => $classTypeId, "school_name" => $SchoolName, "orgId" => $organisationId, "markingTypeid" => $markingTypeid, "markingType" => $markingType,
                "markingValue" => $markingValue, "passing_year" => $passingyear, "board" => $boardName, "countryId" => $country, "stateId" => $state, "cityId" => $ctyname, "school_address" => $location, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("student_secondary_school_details", $idata);
        }
        ($res ? $this->addActivityLog($_SESSION['studentId'], "Student Secondary School Details Inserted", "student_secondary_school_details", "0") : "");

        return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    private function updateSecSchoolDetails($sssd_id, $schoolOrg_id, $classTypeId, $studentClass, $SchoolName, $boardName, $markingType, $markingValue, $passingyear, $country, $state, $ctyname, $location) {
        $markingTypeidr = $this->db->where(["markingTitle" => $markingType, "isactive" => 1])->get("tbl_markingsystem");
        $markingTypeid = ($markingTypeidr->num_rows() > 0 ? $markingTypeidr->row()->markingsystemId : "");
        $chkdata = ["sssd_id!=" => $sssd_id, "studentId" => $_SESSION['studentId'], "class_name" => $studentClass, "school_name" => $SchoolName, "orgId" => $schoolOrg_id, "markingTypeid" => $markingTypeid, "markingType" => $markingType, "markingValue" => $markingValue,
            "passing_year" => $passingyear, "board" => $boardName, "countryId" => $country, "stateId" => $state, "cityId" => $ctyname, "school_address" => $location, "isactive" => 1];

        $chkData = $this->db->where($chkdata)->get("student_secondary_school_details");
        if ($chkData->num_rows() > 0) {
            return '{"status":"error", "msg":"Duplicate Value"}';
        } else {
            $organisationId = $this->getOrganisationId($schoolOrg_id, $SchoolName, 'School');
            $udata = ["class_name" => $studentClass, "classTypeId" => $classTypeId, "school_name" => $SchoolName, "orgId" => $organisationId, "markingTypeid" => $markingTypeid, "markingType" => $markingType, "markingValue" => $markingValue,
                "passing_year" => $passingyear, "board" => $boardName, "countryId" => $country, "stateId" => $state, "cityId" => $ctyname, "school_address" => $location, "updatedAt" => $this->datetimenow()];

            $res = $this->db->where("sssd_id", $sssd_id)->update("student_secondary_school_details", $udata);
        }
        ($res ? $this->addActivityLog($_SESSION['studentId'], "Student Secondary School Details Updated", "student_secondary_school_details", "0") : "");

        return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    public function mGetSenSecSchoolInfo() {
        $studentId = $_SESSION['studentId'];
        $qry = $this->db->query("SELECT sssd.*,GROUP_CONCAT(sm.subjectId) subjectIds,GROUP_CONCAT(sm.maxmarks) maxmarks,
                GROUP_CONCAT(sm.obtMarks) obtMarks FROM student_senior_secondary_school_details sssd
                                LEFT JOIN tbl_subjectmarks sm ON sm.ssssd_id=sssd.ssssd_id AND sm.isactive=1
                                WHERE sssd.studentId=" . $studentId . " AND sssd.isactive=1 GROUP BY sssd.ssssd_id");
        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return false;
        }
    }

    public function mGetClassTypeName() {
        $classname = FILTER_VAR(trim($this->input->post('classname')), FILTER_SANITIZE_STRING);
        if ($classname) {
            $condtion = 'AND class="' . $classname . '"';
        } else {
            $condtion = '';
        }
        $qry = $this->db->query('SELECT * FROM school_class_type where isactive=1 ' . $condtion . '');
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mGetCourseType() {
        $this->db->where("isactive", "1");
        $courses = $this->db->get("course_type");
        if ($courses->num_rows() > 0) {
            return $courses->result();
        } else {
            return FALSE;
        }
    }

    public function mInsertSenSecodarySchoolDetails() {
        $sssd_id = FILTER_VAR(trim($this->input->post('ssssd_id')), FILTER_SANITIZE_STRING);
        $orgId = FILTER_VAR(trim($this->input->post('schoolOrg_id')), FILTER_SANITIZE_STRING);
        $class_name = FILTER_VAR(trim($this->input->post('class_name')), FILTER_SANITIZE_STRING);
        $classTypeId = FILTER_VAR(trim($this->input->post('classTypeId')), FILTER_SANITIZE_STRING);
        $school_name = FILTER_VAR(trim($this->input->post('school_name')), FILTER_SANITIZE_STRING);
        $board = FILTER_VAR(trim($this->input->post('boardName')), FILTER_SANITIZE_STRING);
        $markingType = FILTER_VAR(trim($this->input->post('markingType')), FILTER_SANITIZE_STRING);
        $markingValue = FILTER_VAR(trim($this->input->post('markingValue')), FILTER_SANITIZE_STRING);
        $passingyear = FILTER_VAR(trim($this->input->post('passing_year')), FILTER_SANITIZE_STRING);
        $countryId = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_STRING);
        $stateId = FILTER_VAR(trim($this->input->post('stateId')), FILTER_SANITIZE_STRING);
        $cityId = FILTER_VAR(trim($this->input->post('ctyname')), FILTER_SANITIZE_STRING);
        $location = FILTER_VAR(trim($this->input->post('school_address')), FILTER_SANITIZE_STRING);
        if (empty($class_name) || empty($classTypeId) || empty($school_name) || empty($markingType) || empty($markingValue) || empty($board) || empty($passingyear) || empty($countryId) || empty($stateId) || empty($cityId) || empty($location)) {
            return '{"status":"error","msg":"Requireds field is empty!"}';
        }
        return ($sssd_id == "no_id" ? $this->insertSrSecSchoolDetails($orgId, $class_name, $classTypeId, $school_name, $board, $markingType, $markingValue, $passingyear, $countryId, $stateId, $cityId, $location) :
                $this->updateSrSecSchoolDetails($sssd_id, $orgId, $class_name, $classTypeId, $school_name, $board, $markingType, $markingValue, $passingyear, $countryId, $stateId, $cityId, $location));
    }

    private function insertSrSecSchoolDetails($orgId, $class_name, $classTypeId, $school_name, $board, $markingType, $markingValue, $passingyear, $countryId, $stateId, $cityId, $location) {
        $markingTypeidr = $this->db->where(["markingTitle" => $markingType, "isactive" => 1])->get("tbl_markingsystem");
        $markingTypeid = ($markingTypeidr->num_rows() > 0 ? $markingTypeidr->row()->markingsystemId : "");

        $chk = $this->db->where(["studentId" => $_SESSION['studentId'], "isactive" => 1])->get("student_senior_secondary_school_details");
        $this->db->close();
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details!"}';
        } else {
            $organisationId = $this->getOrganisationId($orgId, $school_name, 'School');
            $idata = ["studentId" => $_SESSION['studentId'], "classTypeId" => $classTypeId, "class_name" => $class_name, "school_name" => $school_name, "orgId" => $organisationId, "markingTypeid" => $markingTypeid, "markingType" => $markingType, "markingValue" => $markingValue,
                "passing_year" => $passingyear, "board" => $board, "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "school_address" => $location, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("student_senior_secondary_school_details", $idata);
            $id = $this->db->insert_id();
        }
        if ($res) {
            ($id ? $this->addSubjectMarks($id) : '');

            $this->addActivityLog($_SESSION['studentId'], "Student Senior Secondary School Details Inserted", "student_senior_secondary_school_details", "0");
            return '{"status":"success","msg":"Saved Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    private function getOrganisationId($orgId, $school_name, $type) {
        $qry = $this->db->query("SELECT * FROM organization_details od
                                        INNER JOIN login_details ld on ld.id=od.loginId AND ld.isactive=1
                                        WHERE ld.roleName='$type' AND od.orgName like '%" . $school_name . "%' and od.isactive");
        if ($qry->num_rows() > 0 && $qry->num_rows() < 2) {
            $qryData = $qry->row();
            $orgId = $qryData->orgId;
            return $orgId;
        } else if ($qry->num_rows() > 1) {
            $qryData = $qry->result();
            foreach ($qryData as $qd) {
                if ($orgId == $qd->orgId) {
                    $orgId = $qd->orgId;
                }
            }
            return $orgId;
        } else {
            return false;
        }
    }

    private function updateSrSecSchoolDetails($sssd_id, $orgId, $class_name, $classTypeId, $school_name, $board, $markingType, $markingValue, $passingyear, $countryId, $stateId, $cityId, $location) {
        $markingTypeidr = $this->db->where(["markingTitle" => $markingType, "isactive" => 1])->get("tbl_markingsystem");
        $markingTypeid = ($markingTypeidr->num_rows() > 0 ? $markingTypeidr->row()->markingsystemId : "");
        $chk = $this->db->where(["ssssd_id" => $sssd_id, "studentId" => $_SESSION['studentId'], "isactive" => 1])->get("student_senior_secondary_school_details");
        $this->db->close();
        if ($chk->num_rows() > 0) {
            $organisationId = $this->getOrganisationId($orgId, $school_name, 'School');
            $uData = ["studentId" => $_SESSION['studentId'], "classTypeId" => $classTypeId, "class_name" => $class_name, "school_name" => $school_name, "orgId" => $organisationId,
                "markingTypeid" => $markingTypeid, "markingType" => $markingType, "markingValue" => $markingValue, "passing_year" => $passingyear, "board" => $board,
                "countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "school_address" => $location, "updatedAt" => $this->datetimenow()];

            $res = $this->db->where("ssssd_id", $sssd_id)->update("student_senior_secondary_school_details", $uData);
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
        if ($res) {
            $this->addSubjectMarks($sssd_id);
            $this->addActivityLog($_SESSION['studentId'], "Student Senior Secondary School Details Updated", "student_senior_secondary_school_details", "0");
            return '{"status":"success","msg":"Saved Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    private function addSubjectMarks($sssd_id, $insdata = [], $udata = []) {
        $subjectIds = $this->input->post("subjectId");
        $maxMarks = $this->input->post("maxMarks");
        $obtMarks = $this->input->post("obtMarks");
        if (!empty($subjectIds) && !empty($maxMarks) && !empty($obtMarks)) {
            $this->db->reconnect();
            $this->db->where("ssssd_id", $sssd_id)->update("tbl_subjectmarks", ["isactive" => 0]);

            for ($i = 0; $i < count($subjectIds); $i++) {
                $subjectId = FILTER_VAR(trim(base64_decode($subjectIds[$i])), FILTER_SANITIZE_STRING);
                $maxMark = FILTER_VAR(trim($maxMarks[$i]), FILTER_SANITIZE_STRING);
                $obtMark = FILTER_VAR(trim($obtMarks[$i]), FILTER_SANITIZE_STRING);
                if ($maxMark >= $obtMark) {
                    $chk = $this->db->where(["subjectId" => $subjectId, "ssssd_id" => $sssd_id, "isactive" => '0'])->get("tbl_subjectmarks");
                    $idata = ($chk->num_rows() > 0 ? ["subjectMarksId" => $chk->row()->subjectMarksId, "maxmarks" => $maxMark, "obtMarks" => $obtMark, "isactive" => 1] : ["subjectId" => $subjectId, "ssssd_id" => $sssd_id, "maxmarks" => $maxMark, "obtMarks" => $obtMark, "isactive" => 1]);
                    ($chk->num_rows() > 0 ? $udata[] = $idata : $insdata[] = $idata);
                }
            }
            (count($insdata) > 0 ? $this->db->insert_batch("tbl_subjectmarks", $insdata) : '');
            (count($udata) > 0 ? $this->db->update_batch("tbl_subjectmarks", $udata, 'subjectMarksId') : '');
        }
    }

    public function mGetCourseNames() {
        $ctId = FILTER_VAR(trim($this->input->post('CourseType')), FILTER_SANITIZE_STRING);
        if ($ctId) {
            $condition = 'AND ctId=' . $ctId . '';
        } else {
            $condition = '';
        }
        $qry = $this->db->query("Select * from course_details where isactive=1 $condition");
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mGetStreamNames() {
        $cId = FILTER_VAR(trim($this->input->post('course_name')), FILTER_SANITIZE_STRING);
        if ($cId) {
            $condition = 'AND cId=' . $cId . '';
        } else {
            $condition = '';
        }
        $qry = $this->db->query("Select * from stream_details where isactive=1 $condition");
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mInsertHigherEducationDetails($student_hed_id, $courseType) {
        $course_name = FILTER_VAR(trim($this->input->post('course_name')), FILTER_SANITIZE_STRING);
        $streamId = FILTER_VAR(trim($this->input->post('streamId')), FILTER_SANITIZE_STRING);
        $collegeName = FILTER_VAR(trim($this->input->post('collegeName')), FILTER_SANITIZE_STRING);
        $collegeOrg_id = FILTER_VAR(trim($this->input->post('collegeOrg_id')), FILTER_SANITIZE_NUMBER_INT);
        $college_address = FILTER_VAR(trim($this->input->post('college_address')), FILTER_SANITIZE_STRING);
        $universityName = FILTER_VAR(trim($this->input->post('universityName')), FILTER_SANITIZE_STRING);
        $universityOrg_id = FILTER_VAR(trim($this->input->post('universityOrg_id')), FILTER_SANITIZE_NUMBER_INT);
        $university_address = FILTER_VAR(trim($this->input->post('university_address')), FILTER_SANITIZE_STRING);
        $markingType = FILTER_VAR(trim($this->input->post('markingType')), FILTER_SANITIZE_STRING);
        $markingValue = FILTER_VAR(trim($this->input->post('markingValue')), FILTER_SANITIZE_STRING);
        $passingyear = FILTER_VAR(trim($this->input->post('passingyear')), FILTER_SANITIZE_STRING);
        $country = FILTER_VAR(trim($this->input->post('country')), FILTER_SANITIZE_NUMBER_INT);
        $state = FILTER_VAR(trim($this->input->post('state')), FILTER_SANITIZE_NUMBER_INT);
        $cityid = FILTER_VAR(trim($this->input->post('cityid')), FILTER_SANITIZE_NUMBER_INT);

        if (!isset($_SESSION['studentId']) || empty($courseType) || empty($course_name) || empty($streamId) || empty($collegeName) || empty($college_address) || empty($universityName) || empty($university_address) || empty($markingType) || empty($markingValue) || empty($passingyear) || empty($country) || empty($state) || empty($cityid)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        return ($student_hed_id == "no_id" ? $this->insertHigherEduDetails($courseType, $course_name, $streamId, $collegeName, $college_address, $collegeOrg_id, $universityName, $university_address, $universityOrg_id, $markingType, $markingValue, $passingyear, $country, $state, $cityid) :
                $this->updateHigherEduDetails($student_hed_id, $courseType, $course_name, $streamId, $collegeName, $college_address, $collegeOrg_id, $universityName, $university_address, $universityOrg_id, $markingType, $markingValue, $passingyear, $country, $state, $cityid));
    }

    private function insertHigherEduDetails($courseType, $course_name, $streamId, $collegeName, $college_address, $collegeOrg_id, $universityName, $university_address, $universityOrg_id, $markingType, $markingValue, $passingyear, $country, $state, $cityid) {

        $this->db->where(['studentId' => $_SESSION['studentId'], 'courseType' => $courseType, 'course_name' => $course_name, 'streamId' => $streamId, 'yearPassout' => $passingyear]);
        $chk = $this->db->get("student_higher_education_details");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details!"}';
        } else {
            $collegeID = $this->getOrganisationId($collegeOrg_id, $collegeName, 'College');
            $universityID = $this->getOrganisationId($universityOrg_id, $universityName, 'University');
            $markingTypeidr = $this->db->where(["markingTitle" => $markingType, "isactive" => 1])->get("tbl_markingsystem");
            $markingTypeid = ($markingTypeidr->num_rows() > 0 ? $markingTypeidr->row()->markingsystemId : "");
            $iData = ["studentId" => $_SESSION['studentId'], 'courseType' => $courseType, 'course_name' => $course_name, 'streamId' => $streamId, 'collegeName' => $collegeName, "markingValue" => $markingValue,
                'college_address' => $college_address, 'college_orgId' => $collegeID, 'universityName' => $universityName, 'university_address' => $university_address, "markingTypeid" => $markingTypeid, "markingType" => $markingType,
                'univ_orgId' => $universityID, 'yearPassout' => $passingyear, 'countryId' => $country, 'stateId' => $state, 'cityId' => $cityid, 'createdAt' => $this->datetimenow(), 'isactive' => 1];
            $res = $this->db->insert('student_higher_education_details', $iData);
            ($res ? $this->addActivityLog($_SESSION['studentId'], "Student Higher Education Details Inserted", "student_higher_education_details", "0") : "");
            return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    private function updateHigherEduDetails($student_hed_id, $courseType, $course_name, $streamId, $collegeName, $college_address, $collegeOrg_id, $universityName, $university_address, $universityOrg_id, $markingType, $markingValue, $passingyear, $country, $state, $cityid) {

        $chk = $this->db->where(['student_hed_id' => $student_hed_id, "studentId" => $_SESSION['studentId'], 'isactive' => 1])->get("student_higher_education_details");
        if ($chk->num_rows() > 0) {
            $collegeID = $this->getOrganisationId($collegeOrg_id, $collegeName, 'College');
            $universityID = $this->getOrganisationId($universityOrg_id, $universityName, 'University');
            $markingTypeidr = $this->db->where(["markingTitle" => $markingType, "isactive" => 1])->get("tbl_markingsystem");
            $markingTypeid = ($markingTypeidr->num_rows() > 0 ? $markingTypeidr->row()->markingsystemId : "");
            $uData = ["studentId" => $_SESSION['studentId'], 'courseType' => $courseType, 'course_name' => $course_name, 'streamId' => $streamId, 'collegeName' => $collegeName, "markingTypeid" => $markingTypeid,
                'college_address' => $college_address, 'college_orgId' => $collegeID, 'universityName' => $universityName, 'university_address' => $university_address, "markingValue" => $markingValue, "markingType" => $markingType,
                'univ_orgId' => $universityID, 'yearPassout' => $passingyear, 'countryId' => $country, 'stateId' => $state, 'cityId' => $cityid, 'updatedAt' => $this->datetimenow()];

            $res = $this->db->where(['student_hed_id' => $student_hed_id, "studentId" => $_SESSION['studentId'], 'isactive' => 1])->update('student_higher_education_details', $uData);
            ($res ? $this->addActivityLog($_SESSION['studentId'], "Student Higher Education Details Updated", "student_higher_education_details", "0") : "");
            return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"Details not found!"}';
        }
    }

    public function mGetHigherEduDetail() {
        $student_hed_id = FILTER_VAR(trim($this->input->post('student_hed_id')), FILTER_SANITIZE_STRING);
        if ($student_hed_id) {
            $condition = "AND shed.studentId=" . $_SESSION['studentId'] . " AND shed.student_hed_id=$student_hed_id";
        } else {
            $condition = " AND shed.studentId=" . $_SESSION['studentId'];
        }
        $qry = $this->db->query("SELECT shed.*,ctry.name ctryname,sts.name stsname,cty.name ctyname,ctype.courseType courseTypeName,
                                                cdtl.title ctitle,sdtl.title streamtitle,DATE_FORMAT(shed.yearPassout , '%d-%b-%y') AS passingyear
                                                FROM student_higher_education_details shed
                                            LEFT JOIN countries ctry ON ctry.countryId=shed.countryId
                                            LEFT JOIN states sts ON sts.stateId=shed.stateId
                                            LEFT JOIN cities cty ON cty.cityId=shed.cityId
                                            LEFT JOIN course_type ctype ON ctype.ctId=shed.courseType
                                            LEFT JOIN course_details cdtl on cdtl.cId=shed.course_name
                                            LEFT JOIN stream_details sdtl ON sdtl.streamId=shed.streamId
                                            WHERE shed.isactive=1 $condition");
        $response = ($qry->num_rows() > 0 ? $qry->result() : "");

        return json_encode($response);
    }

    public function mDelHigherEduDetail() {
        $student_hed_id = FILTER_VAR(trim($this->input->post('student_hed_id')), FILTER_SANITIZE_STRING);
        $this->db->where("student_hed_id", $student_hed_id);
        $chk = $this->db->get("student_higher_education_details");
        if ($chk->num_rows() > 0) {
            $uData = ['updatedAt' => $this->datetimenow(), 'isactive' => 0];
            $this->db->where("student_hed_id", $student_hed_id);
            $res = $this->db->update("student_higher_education_details", $uData);
        }
        if ($res) {
            $this->addActivityLog($_SESSION['studentId'], "Student Higher Education Details Deleted", "student_higher_education_details", "0");
            return '{"status":"success","msg":"Deleted Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mGetExamNames() {
        $qry = $this->db->where("isactive", '1')->get('tbl_competitive_exam_master');
        if ($qry->num_rows() > 0) {
            return $qry->result();
        } else {
            return FALSE;
        }
    }

    public function mAddreqExam() {
        $cexam_id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
        $countryId = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_STRING);
        $exam_name = FILTER_VAR(trim($this->input->post('exam_name')), FILTER_SANITIZE_STRING);
        $marking_system = FILTER_VAR(trim($this->input->post('marking_system')), FILTER_SANITIZE_STRING);
        $validity_time = FILTER_VAR(trim($this->input->post('validity_time')), FILTER_SANITIZE_STRING);
        $typeOfexam = FILTER_VAR(trim($this->input->post('typeOfexam')), FILTER_SANITIZE_STRING);
        if (empty($_SESSION['studentId']) || empty($cexam_id) || empty($countryId) || empty($exam_name) || empty($marking_system) || empty($validity_time) || empty($typeOfexam)) {
            return '{"status":"error","msg":"Required field is empty"}';
        }
        if ($cexam_id == "no_one") {
            $this->insertCompetitiveExamDetails($countryId, $exam_name, $marking_system, $validity_time, $typeOfexam);
        } else {

        }
    }

    private function insertCompetitiveExamDetails($countryId, $exam_name, $marking_system, $validity_time, $typeOfexam) {
        $this->db->where(['country_id' => $countryId, 'exam_name' => $exam_name, 'isactive' => 1]);
        $chk = $this->db->get("tbl_competitive_exam_master");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        }
        $iData = ['country_id' => $countryId, 'exam_name' => $exam_name, 'marking_system' => $marking_system, 'exam_valid_for' => $validity_time,
            'exam_type' => $typeOfexam, 'createdAt' => $this->datetimenow(), 'requestStatus' => 1, 'req_StudentId' => $_SESSION['studentId'], 'isactive' => 1];
        $res = $this->db->insert("tbl_competitive_exam_master", $iData);
        if ($res) {
            $this->addActivityLog($_SESSION['studentId'], "Competitive Exam Mater Details Inserted", "tbl_competitive_exam_master", "0");
            return '{"status":"success","msg":"Saved Successfully."}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mInsertCompetitveExamDetails() {
        $sceId = FILTER_VAR(trim($this->input->post('studentCompExamId')), FILTER_SANITIZE_STRING);
        $c_exam_id = FILTER_VAR(trim($this->input->post('c_exam_id')), FILTER_SANITIZE_STRING);
        $examClearingDate = FILTER_VAR(trim($this->input->post('examClearingDate')), FILTER_SANITIZE_STRING);
        $examValidDate = FILTER_VAR(trim($this->input->post('examValidDate')), FILTER_SANITIZE_STRING);
        $examResult = FILTER_VAR(trim($this->input->post('examResult')), FILTER_SANITIZE_STRING);

        if (empty($_SESSION['studentId']) || empty($sceId) || empty($c_exam_id) || empty($examClearingDate) || empty($examValidDate) || empty($examResult)) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        if ($sceId == "no_id") {
            return $this->insertCompExam($c_exam_id, $examClearingDate, $examValidDate, $examResult);
        } else {
            return $this->updateCompExam($sceId, $c_exam_id, $examClearingDate, $examValidDate, $examResult);
        }
    }

    private function insertCompExam($c_exam_id, $examClearingDate, $examValidDate, $examResult) {
        $chk = $this->db->where(["studentId" => $_SESSION['studentId'], "c_exam_id" => $c_exam_id, "isactive" => 1])->get('tbl_student_competitive');

        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        } else {
            $iData = ["studentId" => $_SESSION['studentId'], "c_exam_id" => $c_exam_id, "examClearingDate" => $examClearingDate
                , "examValidDate" => $examValidDate, "examResult" => $examResult, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("tbl_student_competitive", $iData);
            if ($res) {
                $this->addActivityLog($_SESSION['studentId'], "Student Competitive Exam Details Inserted", "tbl_student_competitive", "0");
                return '{"status":"success","msg":"Saved Successfully."}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    private function updateCompExam($sceId, $c_exam_id, $examClearingDate, $examValidDate, $examResult) {
        $chk = $this->db->where(["studentCompExamId!=" => $sceId, "studentId" => $_SESSION['studentId'], "c_exam_id" => $c_exam_id, "isactive" => 1])->get('tbl_student_competitive');
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details"}';
        } else {
            $iData = ["c_exam_id" => $c_exam_id, "examClearingDate" => $examClearingDate, "examValidDate" => $examValidDate, "examResult" => $examResult, "updatedAt" => $this->datetimenow()];

            $res = $this->db->where("studentCompExamId", $sceId)->update("tbl_student_competitive", $iData);
            if ($res) {
                $this->addActivityLog($_SESSION['studentId'], "Student Competitive Exam Details Updated", "tbl_student_competitive", "0");
                return '{"status":"success","msg":"Saved Successfully."}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        }
    }

    public function deleteCompExam() {
        $sceId = FILTER_VAR(trim($this->input->post('studentCompExamId')), FILTER_SANITIZE_STRING);
        if (empty($sceId)) {
            return '{"status":"error","msg":"Empty Details"}';
        }
        $chk = $this->db->where(["studentId" => $_SESSION['studentId'], "studentCompExamId" => $sceId, "isactive" => 1])->get("tbl_student_competitive");
        if ($chk->num_rows() > 0) {
            $udata = ["updatedAt" => $this->datetimenow(), "isactive" => 0];
            $res = $this->db->where("studentCompExamId", $sceId)->update("tbl_student_competitive", $udata);
            if ($res) {
                $this->addActivityLog($_SESSION['studentId'], "Student Competitive Exam Details Deleted", "tbl_student_competitive", "0");
                return '{"status":"success","msg":"Deleted Successfully."}';
            } else {
                return '{"status":"error","msg":"Error in server, please contact admin!"}';
            }
        } else {
            return '{"status":"error","msg":"Not found"}';
        }
    }

    public function mGetCompetitiveExamDetails() {
        $sceId = FILTER_VAR(trim($this->input->post('studentCompExamId')), FILTER_SANITIZE_STRING);
        if (!empty($sceId)) {
            $condition = "AND tsc.studentId=" . $_SESSION['studentId'] . " AND tsc.studentCompExamId=$sceId";
        } else {
            $condition = "AND tsc.studentId=" . $_SESSION['studentId'] . " ";
        }
        $query = $this->db->query("SELECT tsc.*,tcem.exam_name,DATE_FORMAT(tsc.examClearingDate,'%d-%b-%Y') cldate,
                            DATE_FORMAT(tsc.examValidDate,'%d-%b-%Y') cvdate,tcem.marking_system FROM tbl_student_competitive tsc
                            LEFT JOIN tbl_competitive_exam_master tcem ON tcem.c_exam_id=tsc.c_exam_id AND tcem.isactive=1
                            WHERE tsc.isactive=1 " . $condition . " ORDER by tsc.studentCompExamId DESC");
        if ($query->num_rows() > 0) {
            $response = $query->result();
        } else {
            $response = "";
        }
        return json_encode($response);
    }

    public function mGetSubjectNames() {
        $qry = $this->db->where('isactive', 1)->get('tbl_subjectmaster');
        if ($qry->num_rows() > 0) {
            foreach ($qry->result() as $qr) {
                $qr->subjectId = base64_encode($qr->subjectId);
            }
            return $qry->result();
        } else {
            return '';
        }
    }

    public function mAddNewSubject() {
        $subjectTitle = FILTER_VAR(trim(ucfirst(strtolower($this->input->post('subjectName')))), FILTER_SANITIZE_STRING);
        if (empty($subjectTitle) || !isset($_SESSION['studentId'])) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        $chk = $this->db->where(["subjectTitle" => $subjectTitle, "isactive" => 1])->get("tbl_subjectmaster");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Entry!"}';
        }
        $idata = ["subjectTitle" => $subjectTitle, "createdAt" => $this->datetimenow(), "createdByIp" => $this->getRealIpAddr(),
            "studentId" => $_SESSION['studentId'], "isactive" => 1];
        $resp = $this->db->insert("tbl_subjectmaster", $idata);
        ($resp ? $this->addActivityLog($_SESSION['studentId'], "Subject details inserted", "tbl_subjectmaster", "0") : '');
        return ($resp ? '{"status":"success","msg":"Added Successfully."}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    //student profile end
    //student experience Details Start
    public function mInsertExperienceDetails() {
        $student_exp_id = FILTER_VAR(trim($this->input->post('student_exp_id')), FILTER_SANITIZE_STRING);
        $experienceType = FILTER_VAR(trim($this->input->post('experienceType')), FILTER_SANITIZE_STRING);
        $orgName = FILTER_VAR(trim($this->input->post('orgName')), FILTER_SANITIZE_STRING);
        $designation = FILTER_VAR(trim($this->input->post('designation')), FILTER_SANITIZE_STRING);
        $startDate = FILTER_VAR(trim($this->input->post('startDate')), FILTER_SANITIZE_STRING);
        $endDate = FILTER_VAR(trim($this->input->post('endDate')), FILTER_SANITIZE_STRING);
        $workingStatus = FILTER_VAR(trim($this->input->post('workingStatus')), FILTER_SANITIZE_STRING);

        if (empty($experienceType) || empty($orgName) || empty($designation) || empty($startDate) || empty($student_exp_id) || (empty($endDate) && empty($workingStatus))) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        if ($student_exp_id == "no_id") {
            return $this->insertExperienceDetails($experienceType, $orgName, $designation, $startDate, $endDate, $workingStatus);
        } else {
            return $this->updateExperienceDetails($student_exp_id, $experienceType, $orgName, $designation, $startDate, $endDate, $workingStatus);
        }
    }

    private function insertExperienceDetails($experienceType, $orgName, $designation, $startDate, $endDate, $workingStatus) {
        $res = '';
        $studentId = $_SESSION['studentId'];
        $this->db->where(["studentId" => $studentId, "startDate>=" => $startDate, "endDate<=" => $endDate, "isactive" => 1]);
        $chk = $this->db->get("tbl_student_experience");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Invalid Details!"}';
        } else {
            $idata = ["studentId" => $studentId, "experienceType" => $experienceType, "orgName" => $orgName, "designation" => $designation,
                "workingStatus" => $workingStatus, "startDate" => $startDate, "endDate" => $endDate, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $res = $this->db->insert("tbl_student_experience", $idata);
        }
        if ($res) {
            $this->addActivityLog($_SESSION['studentId'], "Student Experience Details Inserted", "tbl_student_experience", "0");
            return '{"status":"success","msg":"Saved Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    private function updateExperienceDetails($student_exp_id, $experienceType, $orgName, $designation, $startDate, $endDate, $workingStatus) {
        $res = '';
        $studentId = $_SESSION['studentId'];
        $this->db->where(["student_exp_id!=" => $student_exp_id, "studentId" => $studentId, "startDate<=" => $startDate, "startDate>=" => $endDate,
            "endDate<=" => $startDate, "endDate>=" => $endDate, "isactive" => 1]);
        $chk = $this->db->get("tbl_student_experience");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Invalid Details!"}';
        } else {
            $idata = ["studentId" => $studentId, "experienceType" => $experienceType, "orgName" => $orgName, "designation" => $designation,
                "workingStatus" => $workingStatus, "startDate" => $startDate, "endDate" => $endDate, "updatedAt" => $this->datetimenow()];
            $this->db->where("student_exp_id", $student_exp_id);
            $res = $this->db->update("tbl_student_experience", $idata);
        }
        if ($res) {
            $this->addActivityLog($_SESSION['studentId'], "Student Experience Details Updated", "tbl_student_experience", "0");
            return '{"status":"success","msg":"Saved Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mGetExpericeDetails() {
        $student_exp_id = FILTER_VAR(trim($this->input->post('student_exp_id')), FILTER_SANITIZE_NUMBER_INT);
        if ($student_exp_id) {
            $condition = "AND student_exp_id=$student_exp_id";
        } else {
            $condition = "";
        }
        $qry = $this->db->query("Select *,DATE_FORMAT(startDate ,'%d-%b-%y') fromDate,DATE_FORMAT(endDate ,'%d-%b-%y') toDate
                                        from tbl_student_experience where isactive=1 $condition");
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    public function mDelExperienceDetail() {
        $student_exp_id = FILTER_VAR(trim($this->input->post('student_exp_id')), FILTER_SANITIZE_STRING);
        $this->db->where("student_exp_id", $student_exp_id);
        $chk = $this->db->get("tbl_student_experience");
        if ($chk->num_rows() > 0) {
            $uData = ['updatedAt' => $this->datetimenow(), 'isactive' => 0];
            $this->db->where("student_exp_id", $student_exp_id);
            $res = $this->db->update("tbl_student_experience", $uData);
        }
        if ($res) {
            $this->addActivityLog($_SESSION['studentId'], "Student Experience Details Deleted", "tbl_student_experience", "0");
            return '{"status":"success","msg":"Deleted Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    public function mgetStudentJobProfileDetails() {
        $qry = $this->db->query('SELECT jpd.*,GROUP_CONCAT(sks.skill_name) skills FROM tbl_job_profile_details jpd
                                            LEFT JOIN student_key_skills sks ON sks.job_profile_Id=jpd.job_profile_Id AND sks.isactive=1
                                            WHERE jpd.studentId=' . $_SESSION["studentId"] . ' AND jpd.isactive=1 GROUP BY jpd.job_profile_Id');
        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return false;
        }
    }

    public function mInsertJobProfileDetails() {
        $job_profile_Id = FILTER_VAR(trim($this->input->post('job_profile_Id')), FILTER_SANITIZE_STRING);
        $post_to_apply = FILTER_VAR(trim($this->input->post('post_to_apply')), FILTER_SANITIZE_STRING);
        $preffered_location = FILTER_VAR(trim($this->input->post('preffered_location')), FILTER_SANITIZE_STRING);
        $present_location = FILTER_VAR(trim($this->input->post('present_location')), FILTER_SANITIZE_STRING);
        $expected_salary = FILTER_VAR(trim($this->input->post('expected_salary')), FILTER_SANITIZE_STRING);
        $present_salary = FILTER_VAR(trim($this->input->post('present_salary')), FILTER_SANITIZE_STRING);
        $notice_period = FILTER_VAR(trim($this->input->post('notice_period')), FILTER_SANITIZE_STRING);
        $keySkills = FILTER_VAR(trim($this->input->post('keySkills')), FILTER_SANITIZE_STRING);
        $about_you = FILTER_VAR(trim($this->input->post('about_you')), FILTER_SANITIZE_STRING);
        if (empty($job_profile_Id) || empty($post_to_apply) || empty($preffered_location) || empty($present_location) || empty($expected_salary) || empty($present_salary) || $notice_period == "" || empty($keySkills)) {
            return '{"status":"error","msg":"Required field is empty!"}';
        }
        if ($job_profile_Id == "no_id") {
            return $this->insertJobDetails($post_to_apply, $preffered_location, $present_location, $expected_salary, $present_salary, $notice_period, $keySkills, $about_you);
        } else {
            return $this->updateJobDetails($job_profile_Id, $post_to_apply, $preffered_location, $present_location, $expected_salary, $present_salary, $notice_period, $keySkills, $about_you);
        }
    }

    private function insertJobDetails($post_to_apply, $preffered_location, $present_location, $expected_salary, $present_salary, $notice_period, $keySkills, $about_you) {
        $res = '';
        $studentId = $_SESSION['studentId'];
        $this->db->where(["studentId" => $studentId, "isactive" => 1]);
        $chk = $this->db->get("tbl_job_profile_details");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate Details!"}';
        } else {
            $idata = ["studentId" => $studentId, "post_to_apply" => $post_to_apply, "preffered_location" => $preffered_location, "present_location" => $present_location, "expected_salary" => $expected_salary,
                "present_salary" => $present_salary, "about_you" => $about_you, "notice_period" => $notice_period, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $this->db->insert("tbl_job_profile_details", $idata);
            $res = $this->db->insert_id();
        }
        if ($res) {
            $this->keySkills($res, $keySkills);
            $this->addActivityLog($_SESSION['studentId'], "Student Job Profile Details Inserted", "tbl_job_profile_details", "0");
            return '{"status":"success","msg":"Saved Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    private function updateJobDetails($job_profile_Id, $post_to_apply, $preffered_location, $present_location, $expected_salary, $present_salary, $notice_period, $keySkills, $about_you) {
        $res = '';
        $studentId = $_SESSION['studentId'];
        $this->db->where(["studentId" => $studentId, "job_profile_Id" => $job_profile_Id, "isactive" => 1]);
        $chk = $this->db->get("tbl_job_profile_details");
        if ($chk->num_rows() > 0) {
            $idata = ["studentId" => $studentId, "post_to_apply" => $post_to_apply, "preffered_location" => $preffered_location, "present_location" => $present_location, "expected_salary" => $expected_salary,
                "present_salary" => $present_salary, "about_you" => $about_you, "notice_period" => $notice_period, "createdAt" => $this->datetimenow(), "isactive" => 1];
            $this->db->where(["studentId" => $studentId, "job_profile_Id" => $job_profile_Id, "isactive" => 1]);
            $res = $this->db->update("tbl_job_profile_details", $idata);
        } else {
            return '{"status":"error","msg":"Details Not Found!"}';
        }
        if ($res) {
            $this->keySkills($job_profile_Id, $keySkills);
            $this->addActivityLog($_SESSION['studentId'], "Student Job Profile Details Updated", "tbl_job_profile_details", "0");
            return '{"status":"success","msg":"Saved Successfully"}';
        } else {
            return '{"status":"error","msg":"Error in server, please contact admin!"}';
        }
    }

    private function keySkills($res, $keySkills) {
        $this->db->where("job_profile_Id", $res);
        $this->db->update("student_key_skills", ["isactive" => 0]);
        $keySkillarr = explode(",", $keySkills);
        for ($i = 0; $i < count($keySkillarr); $i++) {
            $this->db->where(['skill_name' => $keySkillarr[$i], "job_profile_Id" => $res]);
            $chk = $this->db->get('student_key_skills');
            if ($chk->num_rows() > 0) {
                $this->db->where(['skill_name' => $keySkillarr[$i], "job_profile_Id" => $res]);
                $this->db->update("student_key_skills", ["isactive" => 1]);
            } else {
                $idata = ["job_profile_Id" => $res, 'skill_name' => $keySkillarr[$i], "isactive" => 1];
                $this->db->insert("student_key_skills", $idata);
            }
        }
    }

    //Student Experience Details End
    //Student Refer Start
    public function mgetProfileDetails() {
        $qry = $this->db->query("SELECT (SELECT my_refer_code FROM student_login WHERE studentId=" . $_SESSION['studentId'] . " AND isactive=1) refercode,
                            (SELECT COUNT(studentId) FROM student_login where student_login.my_referer=(SELECT my_refer_code FROM student_login WHERE studentId=" . $_SESSION['studentId'] . " AND isactive=1)) myrefrences,"
                . "     (SELECT my_referer FROM student_login WHERE studentId=" . $_SESSION['studentId'] . " AND isactive=1) my_referer");

        if ($qry->num_rows() > 0) {
            return $qry->row();
        } else {
            return FALSE;
        }
    }

    public function mAddMyReference() {
        $your_refrence_code = FILTER_VAR(trim($this->input->post('your_refrence_code')), FILTER_SANITIZE_STRING);
        $this->db->where(["studentId" => $_SESSION['studentId'], "my_refer_code" => $your_refrence_code]);
        $chk = $this->db->get("student_login");
        $res = '';
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"You Can not enter your code!"}';
        }
        $this->db->where(["my_refer_code" => $your_refrence_code, "isactive" => 1]);
        $chkvalid = $this->db->get("student_login");
        if ($chkvalid->num_rows() > 0) {
            $udata = ["my_referer" => $your_refrence_code, "updatedAt" => $this->datetimenow()];
            $this->db->where(["studentId" => $_SESSION['studentId'], "isactive" => 1]);
            $res = $this->db->update("student_login", $udata);
        } else {
            return '{"status":"error","msg":"Refer code not Valid!"}';
        }
        ($res ? $this->addActivityLog($_SESSION['studentId'], "Student Reference Code Updated", "student_login", "0") : "");
        return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    //Student Refer End
    //Add Ratings Start
    public function mAddRating() {
        $studentId = $_SESSION['studentId'];
        $ratings = FILTER_VAR(trim($this->input->post('ratings')), FILTER_SANITIZE_NUMBER_INT);
        $loginId = FILTER_VAR(trim($this->input->post('loginid')), FILTER_SANITIZE_STRING);
        $courseMode = FILTER_VAR(trim($this->input->post('courseMode')), FILTER_SANITIZE_STRING);
        $Comment = FILTER_VAR(trim($this->input->post('Comment')), FILTER_SANITIZE_STRING);
        if (empty($studentId) || empty($ratings) || empty($courseMode) || empty(base64_decode($loginId)) || empty($Comment)) {
            return '{"status":"error","msg":"Required detail is empty!"}';
        }
        $chkOrgs = $this->db->where(["loginId" => base64_decode($loginId), "isactive" => 1])->get("organization_details");
        if ($chkOrgs->num_rows() > 0) {
            $this->mInsertUpdateatings($studentId, base64_decode($loginId), $courseMode, $Comment, $ratings);
        } else {
            return '{"status":"error","msg":"Invalid details!"}';
        }
    }

    private function mInsertUpdateatings($studentId, $loginId, $courseMode, $Comment, $ratings) {

        $chk = $this->db->where(["studentId" => $studentId, "loginId" => $loginId])->get("tbl_ratings");
        if ($chk->num_rows() > 0) {
            $uData = ["courseMode" => $courseMode, "Comment" => $Comment, "ratings" => $ratings, "updatedAt" => $this->datetimenow(), "isReviewed" => 0, "ipAddress" => $this->getRealIpAddr()];
            $res = $this->db->where(["studentId" => $studentId, "loginId" => $loginId])->update("tbl_ratings", $uData);
            ($res ? $this->addActivityLog($_SESSION['studentId'], "Review details updated", "tbl_ratings", "0") : "");
        } else {
            $iData = ["studentId" => $studentId, "loginId" => $loginId, "courseMode" => $courseMode, "Comment" => $Comment, "ratings" => $ratings, "createdAt" => $this->datetimenow(), "isReviewed" => 0,
                "ipAddress" => $this->getRealIpAddr(), "isactive" => 1];
            $res = $this->db->insert("tbl_ratings", $iData);
            ($res ? $this->addActivityLog($_SESSION['studentId'], "Review details Inserted", "tbl_ratings", "0") : "");
        }
        return ($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
    }

    //Add Ratings End
    //Earnandshare value created by shweta
    public function mGetearnandsharevalue() {
        $qry = $this->db->query("SELECT *,(
                SELECT SUM(ens.amount) FROM student_login tsl1
                INNER JOIN tbl_earn_n_share_value ens on ens.ens_value_id=tsl1.ens_value_id
                WHERE tsl1.my_referer=tsl.my_refer_code AND tsl1.isactive=1
                )ensamount FROM student_login tsl
                WHERE tsl.studentId=" . $_SESSION['studentId'] . " AND tsl.isactive=1 ORDER BY ensamount DESC");
        if ($qry->num_rows() > 0) {
            $result = $qry->result();
        } else {
            $result = "";
        }
        return json_encode($result);
    }

    //Earnandshare value end by shweta
    //My Applications start
    public function mMyApplications() {
        $qry = $this->db->query("SELECT te.enrollmentId,te.status,oc.courseDurationType,DATE_FORMAT(oc.openingDate ,'%d-%b-%Y') openingDate,DATE_FORMAT(oc.closingDate ,'%d-%b-%Y') closingDate, DATE_FORMAT(oc.examDate ,'%d-%b-%Y') examDate,ld.id,
            os.courseFee,os.registrationFee,tdep.title departmentName,ct.courseType courseType, cd.title courseName,td.title timeDuration,DATE_FORMAT(te.createdAt ,'%d-%b-%Y') applicationDate,ld.roleName,od.orgName,od.org_account_id,od.org_percentage,od.orgId,od.org_splitpayment_status,ld.email FROM tbl_enroll te
            INNER JOIN organization_streams os ON os.orgStreamId=te.orgStreamId INNER JOIN organization_courses oc ON oc.orgCourseId=os.orgCourseId AND oc.isactive=1
            INNER JOIN department tdep ON tdep.departmentId=oc.departmentId INNER JOIN course_type ct ON ct.ctId = oc.courseTypeId
            INNER JOIN course_details cd ON cd.cId=oc.courseId INNER JOIN time_duration td ON td.tdId=oc.courseDurationId
            INNER JOIN login_details ld ON ld.id=oc.loginId INNER JOIN organization_details od ON ld.id=od.loginId
            WHERE te.studentId=" . $_SESSION['studentId'] . " AND te.isactive=1
UNION       SELECT te.enrollmentId,te.status,icd.courseDurationType,DATE_FORMAT(icd.applyFrom ,'%d-%b-%Y') openingDate,DATE_FORMAT(icd.applyTo ,'%d-%b-%Y') closingDate, DATE_FORMAT(icd.examDate ,'%d-%b-%Y') examDate,ld.id,
            icd.courseFee,icd.registrationFee,'' departmentName,'' courseType,ic.title courseName,td.title timeDuration,DATE_FORMAT(te.createdAt ,'%d-%b-%Y') applicationDate,ld.roleName,od.orgName,od.org_account_id,od.org_percentage,od.orgId,od.org_splitpayment_status,ld.email FROM tbl_enroll te
            INNER JOIN institute_course_details icd ON icd.insCourseDetailsId=te.insCourseDetailsId AND icd.isactive=1 INNER JOIN institute_course ic ON ic.insCourseId=icd.insCourseId
            INNER JOIN time_duration td ON td.tdId=icd.timeDurationId INNER JOIN login_details ld ON ld.id=icd.loginId INNER JOIN organization_details od ON ld.id=od.loginId
            WHERE te.studentId=" . $_SESSION['studentId'] . " AND te.isactive=1
UNION       SELECT te.enrollmentId,te.status,scd.courseDurationType,DATE_FORMAT(scd.applyFrom ,'%d-%b-%Y') openingDate,DATE_FORMAT(scd.applyTo ,'%d-%b-%Y') closingDate, DATE_FORMAT(scd.examDate ,'%d-%b-%Y') examDate,ld.id,
            scd.courseFee,scd.registrationFee,'' departmentName,sct.title courseType,sct.class courseName,'1 Year' timeDuration,DATE_FORMAT(te.createdAt ,'%d-%b-%Y') applicationDate,ld.roleName,od.orgName,od.org_account_id,od.org_percentage,od.orgId,od.org_splitpayment_status,ld.email  FROM tbl_enroll te
            INNER JOIN school_class_details scd ON scd.sClassId=te.sClassId INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId
            INNER JOIN login_details ld ON ld.id=scd.loginId INNER JOIN organization_details od ON ld.id=od.loginId WHERE te.studentId=" . $_SESSION['studentId'] . " AND te.isactive=1");
        $result = ($qry->num_rows() > 0 ? $qry->result() : "");
        return json_encode($result);
    }
	
	
	
	
public function mshowMsg(){
	    $eId=$this->input->post('eId');
		$chData = ['enrollmentId' => $eId];
        $chkData = $this->db->where($chData)->order_by('createdDate','DESC')->get("tbl_notifications_msg");	
		$msg = ($chkData->num_rows() > 0 ? $chkData->result() : null);
		return json_encode($msg);
		
}
   

   //My Applications end
    //My Notifications Start
    public function mGetNotifications() {
        $totalDataqry = $this->mgetAllNotifications('total');
        $totalData = ($totalDataqry->num_rows() > 0 ? $totalDataqry->num_rows() : 0);
        $query = (empty($this->input->post('search')['value']) ? $this->mgetAllNotifications('nosearch') : $this->mgetAllNotifications('search'));
        $posts = ($query->num_rows() > 0 ? $query->result() : null);
        $totalFiltered = (empty($this->input->post('search')['value']) ? $totalData : $this->mgetAllEnrollments('searchtotal')->num_rows());

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $dt) { //.' ('.$dt->courseType.') '.$dt->departmentName
                $data[] = ["MessageId" => $i++, "Message" => $dt->message, "SentBy" => $dt->SentBy, "InRefence" => $dt->reference, "NotificationStatus" => ($dt->isRead ? "Read On " . $dt->readdate : "Not Read")];
            }
        }
        $json_data = array("draw" => intval($this->input->post('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

        return json_encode($json_data);
    }

    private function mgetAllNotifications($condition) {
        $columns = array(0 => 'tn.notificationId', 1 => 'tn.message', 2 => 'od.orgName', 3 => 'te.enrollmentId');
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];
        $likearr = " AND (tn.message like %$search% OR od.orgName LIKE %$search% OR tn.isRead LIKE %$search% OR tn.createdAt LIKE %$search%)";
        $condions = ($condition == "nosearch" ? "Order by $order $dir  LIMIT  $start,$limit" : ($condition == "total" ? "" :
                ($condition == "search" ? " $likearr Order by $order $dir  LIMIT $start,$limit" : ($condition == "searchtotal" ? " $likearr Order by $order $dir " : ""))));

        return $this->db->query("SELECT tn.notificationId,tn.message,tn.isRead,DATE_FORMAT(tn.readDate,'%W %M %e %Y') readdate,
                                    CONCAT(od.orgName,' On ',DATE_FORMAT(tn.createdAt,'%W %M %e %Y')) SentBy,'Enrollment Status Change' reference
                                    FROM tbl_notifications tn
                                    INNER JOIN tbl_enroll te ON te.enrollmentId=tn.referenceId AND tn.referenceTable='tbl_enroll'
                                    INNER JOIN login_details ld ON ld.id=tn.sentBy AND tn.senderTableName='login_details'
                                    INNER JOIN organization_details od ON od.loginId=ld.id
                                    WHERE tn.notificationFor=" . $_SESSION['studentId'] . " AND tn.tableName='student_login' $condions");
    }

    public function mMarkAsReadNotifications() {
        $udata = ["readDate" => $this->datetimenow(), "isRead" => 1];
        $res = $this->db->where(["notificationFor" => $_SESSION['studentId'], "tableName" => "student_login", "isRead" => 0])->update("tbl_notifications", $udata);
        ($res ? $this->addActivityLog($_SESSION['studentId'], "Notification read by " . $_SESSION['studentName'], "tbl_notifications", "0") : "");
    }

    public function mGetinstitutenames() {
        $insName = FILTER_VAR(trim($this->input->post('insName')), FILTER_SANITIZE_STRING);
        if (!empty($insName)) {
            $qry = $this->db->query("SELECT od.loginId,od.orgName FROM organization_details od
                        INNER JOIN login_details ld ON ld.id=od.loginId AND ld.isactive=1 AND ld.roleName='Institute'
                        WHERE od.isactive=1 AND od.orgName LIKE '%$insName%'");
        } else {
            $qry = "";
        }
        return json_encode($qry->result());
    }

    public function mInsertInstituteEducationDetails($studentInsId, $insCourseId, $markingType, $markingValue, $coursestartDate, $courseEndDate, $instituteName) {
        $loginid = FILTER_VAR(trim($this->input->post('loginid')), FILTER_SANITIZE_STRING);
        if (!isset($_SESSION['studentId']) || empty($insCourseId) || empty($markingType) || empty($markingValue) || empty($coursestartDate) || empty($courseEndDate) || empty($instituteName)) {
            return '{"status":"error","msg":"Required detail is empty!"}';
        }
        $condition = ["insCourseId" => $insCourseId, "markingType" => $markingType, "markingValue" => $markingValue, "coursestartDate" => $coursestartDate, "courseEndDate" => $courseEndDate,
            "instituteName" => $instituteName, "loginid" => $loginid, "studentId" => $_SESSION['studentId'], "isactive" => 1];
        $chkarr = ($studentInsId == "no_id" ? $condition : array_merge($condition, ["studentInsId!=" => $studentInsId]));
        $chk = $this->db->where($chkarr)->get("tbl_student_institute_details");
        if ($chk->num_rows() > 0) {
            return '{"status":"error","msg":"Duplicate details!"}';
        }
        if ($studentInsId == "no_id") {
            $res = $this->db->insert("tbl_student_institute_details", array_merge($condition, ["createdAt" => $this->datetimenow()]));
            ($res ? $this->addActivityLog($_SESSION['studentId'], "Student Institute details Inserted", "tbl_student_institute_details", "0") : "");
            return($res ? '{"status":"success","msg":"Saved Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            $res = $this->db->update("tbl_student_institute_details", array_merge($condition, ["updatedAt" => $this->datetimenow()]));
            ($res ? $this->addActivityLog($_SESSION['studentId'], "Student Institute details Updated", "tbl_student_institute_details", "0") : "");
            return($res ? '{"status":"success","msg":"Updated Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        }
    }

    public function mGetInstituteEducationDetail() {
        $studentInsId = FILTER_VAR(trim($this->input->post('studentInsId')), FILTER_SANITIZE_STRING);
        $condition = ($studentInsId ? "AND studentInsId=$studentInsId" : "");

        $query = $this->db->query("SELECT *,DATE_FORMAT(tsid.coursestartDate,'%d-%b-%Y') csdate,DATE_FORMAT(tsid.courseEndDate,'%d-%b-%Y') cedate FROM tbl_student_institute_details tsid
                INNER JOIN institute_course ic ON ic.insCourseId=tsid.insCourseId
                WHERE tsid.isactive=1 AND tsid.studentId=" . $_SESSION['studentId'] . " $condition ");
        return json_encode($studentInsId == "" ? ($query->num_rows() > 0 ? $query->result() : "") : ($query->num_rows() > 0 ? $query->row() : ""));
    }

    public function mDelInstEduDetail() {
        $studentInsId = FILTER_VAR(trim($this->input->post('studentInsId')), FILTER_SANITIZE_STRING);
        if (empty($studentInsId) || !isset($_SESSION['studentId'])) {
            return '{"status":"error","msg":"Important details are empty!"}';
        }
        $chk = $this->db->where(["studentInsId" => $studentInsId, 'studentId' => $_SESSION['studentId'], "isactive" => 1])->get("tbl_student_institute_details");
        if ($chk->num_rows() > 0) {
            $udata = ["isactive" => 0, "updatedAt" => $this->datetimenow()];
            $res = $this->db->where(["studentInsId" => $studentInsId, 'studentId' => $_SESSION['studentId'], "isactive" => 1])->update("tbl_student_institute_details", $udata);
            ($res ? $this->addActivityLog($_SESSION['studentId'], "Student Institute details deleted", "tbl_student_institute_details", "0") : "");
            return($res ? '{"status":"success","msg":"Deleted Successfully"}' : '{"status":"error","msg":"Error in server, please contact admin!"}');
        } else {
            return '{"status":"error","msg":"Details not found!"}';
        }
    }

    //My Notifications End
    //Activity Log Start
    private function addActivityLog($user_id, $activity, $act_table, $isadmin) {
        $idata = ["user_id" => $user_id, "activity" => $activity, "act_table" => $act_table, "date" => date('Y-m-d'), "isadmin" => 0,
            "role_name" => "Student", "created_at" => $this->datetimenow(), "ip_address" => $this->getRealIpAddr(), "isactive" => 1];
        $this->db->insert("activity_log", $idata);
    }

    //Activity Log End

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

}

?>