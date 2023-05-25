<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model
{

	public function __construct()
	{
		parent:: __construct();
		$this->load->database();
		$this->load->model("Student_model");
		$this->load->library('session');
	}

	//index pages start
	public function mGetAllCourses()
	{
		$qry = $this->db->query("SELECT * FROM course_type where isactive=1");
		if ($qry->num_rows() > 0) {
			$result = $qry->result();
		} else {
			$result = false;
		}
		return json_encode($result);
	}

	public function mGetAllInstCourses()
	{
		$qry = $this->db->query("SELECT * FROM institute_course where isactive=1");
		if ($qry->num_rows() > 0) {
			$result = $qry->result();
		} else {
			$result = false;
		}
		return json_encode($result);
	}

	public function mgetOrganizationDetails($type, $filterCondition)
	{
		if ($type == "University") {
			return $this->getCourseDetailsList($type,"", $filterCondition);
			//return $this->getUniversityDetailsByCourse("", $filterCondition);
		} elseif ($type == "College") {
			//return $this->getCollegeDetailsByCourse("", $filterCondition);
			return $this->getCourseDetailsList($type,"", $filterCondition);
		} elseif ($type == "Institute") {
			//return $this->getInstituteDetailsByCourse("", $filterCondition);
			return $this->getCourseDetailsList($type,"", $filterCondition);
		} elseif ($type == "School") {
			//return $this->getSchoolDetailsByCourse("", $filterCondition);
			return $this->getCourseDetailsList($type,"", $filterCondition);
		} else {
			return false;
		}
	}

	public function mVerifyEmail()
	{
		$verificationCode = $this->input->post('verificationCode');
		$id = $this->input->post('id');
		if ($verificationCode != "" && $id != "") {
			$email = $this->encryption->decrypt($verificationCode);
			$loginid = $this->encryption->decrypt($id);
			$qry = $this->db->where([
				'email' => $email,
				'id' => $loginid,
				"verifyStatus" => 1
			])->get('login_details');
			if ($qry->num_rows() > 0) {
				return '{"status":"success", "msg":"Already verified."}';
			} else {
				$resp = $this->db->where(['email' => $email])->update('login_details', ["verifyStatus" => 1]);
				return ($resp ? '{"status":"success", "msg":"Verified successfully."}' : '{"status":"error", "msg":"No record found."}');
			}
		}
	}

	public function mVerifyStudentEmail()
	{
		$verificationCode = $this->input->post('studentVerification');
		$id = $this->input->post('studentid');
		if ($verificationCode != "" && $id != "") {
			$email = $this->encryption->decrypt($verificationCode);
			$loginid = $this->encryption->decrypt($id);
			$qry = $this->db->where(['email' => $email, 'studentId' => $loginid, "email_verified" => 1])->get('student_login');
			if ($qry->num_rows() > 0) {
				return '{"status":"success", "msg":"Already verified."}';
			} else {
				$resp = $this->db->where(['email' => $email])->update('student_login', ["email_verified" => 1, "updatedAt" => $this->datetimenow()]);
				return ($resp ? '{"status":"success", "msg":"Verified successfully."}' : '{"status":"error", "msg":"No record found."}');
			}
		}
	}

	public function setEmail()
	{
		if (!isset($_SESSION['websiteEmail'])) {
			$getDetails = $this->db->where("id", "1")->get("web_users");
			if ($getDetails->num_rows() > 0) {
				$rowData = $getDetails->row();
				$_SESSION['websiteEmail'] = $rowData->website_email_id;
			} else {
				$_SESSION['websiteEmail'] = "donotreply@ihuntbest.com";
			}
		} else {
			if ($_SESSION['websiteEmail'] == "") {
				$_SESSION['websiteEmail'] = "donotreply@ihuntbest.com";
			}
		}
	}
	
	
	public function payment_info($amt,$ord_id,$r_p_id,$c_code,$stndt_id,$status,$org_id,$crs_id,$crs_s_id,$org_typ)
	{
	
		
		 $orgCourseId = FILTER_VAR(trim($crs_id), FILTER_SANITIZE_STRING);
		 $courseId = FILTER_VAR(trim($crs_s_id), FILTER_SANITIZE_STRING);
		 $orgType = FILTER_VAR(trim($org_typ), FILTER_SANITIZE_STRING);
		
		
		if (empty($orgCourseId) || empty($orgType)) {
			return '{"status":"error", "msg":"Required field is empty!"}';
		}
		$condition = (($orgType == 'University' || $orgType == 'College') ? ["orgStreamId" => $courseId] : ($orgType == 'Institute' ? ["insCourseDetailsId" => $orgCourseId] : ($orgType == 'School' ? ["sClassId" => $orgCourseId] : [])));
		$cmn = ["studentId" => $_SESSION['studentId'], "isactive" => 1];
		$chk = $this->db->where(array_merge($cmn, $condition))->get("tbl_enroll");
		
		/*
		if ($chk->num_rows() > 0)
		{
			return '{"status":"error", "msg":"You have already enrolled for this course!"}';
		}*/
		
			$idata = ["studentId" => $_SESSION['studentId'], "status" => "Enrolled", "createdAt" => $this->datetimenow(), 'isactive' => 1,'payment_id' => $r_p_id ];
			$fidata = array_merge($condition, $idata);
			
			 $this->db->insert("tbl_enroll", $fidata);
		
	
		
	}

	public function mSetCountry($country_code)
	{
		#$this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		
		$countryData = $this->db->query('SELECT * FROM countries WHERE sortname="' . $country_code . '"');
		if ($countryData->num_rows() > 0) {
			$contryCodes = $countryData->row();
			$_SESSION['countryId'] = $contryCodes->countryId;

			return true;
		} else {
			return "countrynotfound";
		}
	}

	//index pages end
	//country functions start
	public function mSetCountryCookie($id)
	{
		$countryData = $this->db->query('SELECT * FROM countries WHERE countryId="' . $id . '"');
		if ($countryData->num_rows() > 0) {
			$contryCodes = $countryData->row();
			$sortname = $contryCodes->sortname;

			return $sortname;
		} else {
			return false;
		}
	}

	public function mGetallCountries($type)
	{
		$getCountries = $this->db->query("SELECT * FROM countries where isactive=1");
		$this->db->close();
		if ($getCountries->num_rows() > 0) {
			$response = $getCountries->result();
		} else {
			$response = "";
		}
		if ($type == 'json') {
			return json_encode($response);
		} else {
			return $response;
		}
	}

	public function mGetstatesofCountry()
	{
		$id = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_NUMBER_INT);
		$sid = FILTER_VAR(trim($this->input->post('stateid')), FILTER_SANITIZE_NUMBER_INT);
		$cd = ($sid === "" ? "" : "AND stateId=$sid");
		if ($id != "") {
			$getStates = $this->db->query("SELECT * FROM states WHERE countryId=$id $cd AND isactive=1");
			if ($getStates->num_rows() > 0) {
				$response = $getStates->result();
			} else {
				$response = "";
			}
		} else {
			$response = "";
		}
		return json_encode($response);
	}

	public function mGetCitybyState()
	{
		$id = FILTER_VAR(trim($this->input->post('stateId')), FILTER_SANITIZE_NUMBER_INT);
		$sid = FILTER_VAR(trim($this->input->post('cityId')), FILTER_SANITIZE_NUMBER_INT);
		$sc = ($sid == "" ? "" : "AND cityId=$sid");
		$condition = ($id == "" ? "" : "AND stateId=$id");
		$getCity = $this->db->query("SELECT * FROM cities WHERE isactive=1 $condition $sc");
		if ($getCity->num_rows() > 0) {
			$response = $getCity->result();
		} else {
			$response = "";
		}
		return json_encode($response);
	}

	//country functions end
	//organisation view start
	//  Enrolled Data Start
	public function mGetEnrollData($loginid, $type, $studentid, $courseId, $orgCourseId)
	{
		$getStudentData = $this->mgetEnrollStudentData($studentid);
		$sData = ($getStudentData->num_rows() > 0 ? $getStudentData->row() : "");
		$getOrgData = $this->mgetEnrollOrgData($loginid, $type,$courseId);
		$orgData = ($getOrgData->num_rows() > 0 ? $getOrgData->result() : "");
		$chkEli = "";//$this->OrgMinQualification($orgCourseId);
		$courseDetails = $this->getCourseInfo($orgCourseId, $courseId, $type, $loginid);
		// $enrolled=$this->check_enroll($studentid,$orgCourseId, $loginid);
		
		// if(isset($enrolled)){
		// if($enrolled->status==1)
				// {
				// $this->session->set_userdata('chk_enroll', $enrolled->status);
				// }
				// else
				// {
				// $this->session->set_userdata('chk_enroll', '0');	
				// }
		// }
		// $this->session->set_userdata('chk_enroll', 0);	
		$response = ["studentDetails" => $sData, "orgDetails" => $orgData, "reqEligibility" => $chkEli];
		

		return json_encode(array_merge($response, $courseDetails));
	}
	
	public function check_enroll($studentid, $courseId, $orgCourseId)
	{
		$qry = $this->db->query("SELECT * from tbl_enroll_payments where student_id=$studentid AND course_id=$courseId AND org_id= $orgCourseId");
		if ($qry->num_rows() > 0) {	
			$rowData = $qry->row();
			
		$this->db->close();
		return $rowData;
		}
	}
	

	public function mgetEnrollStudentData($studentid)
	{
		$qry = $this->db->query("SELECT std.studentId,std.fatherName,std.studentImage,std.placeofBirth,std.religion,std.studentMobile,std.gender,
                                    DATE_FORMAT(std.dob,'%d-%m-%Y') as dobc,std.dob,std.studentName,ctry.name,ctry.countryId,sl.email
                                    FROM student_details std
                                    LEFT JOIN student_login sl ON sl.studentId=std.studentId
                                    LEFT JOIN countries ctry ON ctry.countryId=std.countryId
                                    WHERE std.studentId=" . $studentid . "");
		
		$this->db->close();
		return $qry;
	}

	public function mgetEnrollOrgData($orgid, $type,$courseId, $details = false)
	{
		$qry = $this->db->query("SELECT ld.id as loginId,ld.roleName,ld.email,od.orgName,od.orgAddress,od.orgLogo,od.approvedBy,
        od.orgImgHeader,od.orgMobile,od.orgWebsite,(SELECT SUM(distinct id) FROM
            student_course_registration  WHERE
            organisation_courses_id=$courseId and status=1 and registration_status='Registered')  as availabesheets
        FROM login_details as ld
        INNER JOIN organization_details as od ON od.loginId=ld.id WHERE ld.roleName='" . $type . "' " . $this->getLocationCondtion() . " AND ld.id=" . $orgid . "");
		$this->db->close();
		return $details ? $qry->row() : $qry;
	}

	public function getCourseInfo($orgCourseId, $courseId, $type, $loginid,$html = true)
	{
		if ($type == "University") {
			return $this->universityCourseInfo($orgCourseId, $courseId, $loginid, $html);
		} else if ($type == "College") {
			return $this->collegeCourseInfo($orgCourseId, $courseId, $loginid, $html);
		} else if ($type == "Institute") {
			return $this->instituteCourseInfo($orgCourseId, $courseId, $loginid, $html);
		} else if ($type == "School") {
			return $this->schoolCourseInfo($orgCourseId, $courseId, $loginid, $html);
		} else {
			return false;
		}
	}

	private function universityCourseInfo($orgCourseId, $courseId, $loginid, $html = true)
	{
		$qry = $this->db->query("SELECT 
									oc.id as orgCourseId,
									oc.login_id as loginId,
									fd.defaultCurrency,
									oc.registration_fee,
									oc.course_fee,
									CONCAT('Registration Fee: ',
											oc.registration_fee,
											' Course Fee :',
											oc.course_fee) courseFee,
									cm.course_name as courseTitle,
									cm.course_duration,
								if(oc.course_details is null,cm.course_details,oc.course_details) as course_details,
								if(oc.course_qualifications is null,cm.course_qualifications,oc.course_qualifications) as course_qualifications,
								oc.total_seats
									
								FROM
									organisation_courses AS oc
										INNER JOIN
									course_masters cm ON cm.id = oc.course_masters_id
										LEFT JOIN
									tbl_financial_details fd ON fd.login_id = oc.login_id
										AND fd.user_type = 'University'
								WHERE
									oc.is_active = 1 and oc.id=$orgCourseId
								ORDER BY oc.login_id");
		// $qry = $this->db->query("SELECT cd.title courseTitle,td.title department,cty.courseType as course_details,
		// 		PERIOD_DIFF(DATE_FORMAT(oc.ageValidDate,'%Y%m'),DATE_FORMAT(sdls.dob,'%Y%m'))/12 age,
        //     tdu.title course_duration,sd.title Stream,os.registrationFee as registration_fee,os.courseFee as course_fee,oc.applicationFee ApplicationFee,fd.defaultCurrency,CONCAT('Min Required ',oc.minAge,' To ',oc.maxAge,' Years' ) agePrereq,oc.minAge,oc.maxAge,DATE_FORMAT(oc.ageValidDate,'%d-%b-%Y') ageasOn  FROM organization_courses_delete oc
        // INNER JOIN department td ON td.departmentId=oc.departmentId  INNER JOIN course_type cty ON cty.ctId=oc.courseTypeId  INNER JOIN course_details cd ON cd.cId=oc.courseId INNER JOIN time_duration tdu ON tdu.tdId=oc.courseDurationId
        // INNER JOIN organization_streams os ON os.orgCourseId=oc.orgCourseId AND os.isactive=1 INNER JOIN stream_details sd ON sd.streamId=os.streamId LEFT JOIN tbl_financial_details fd ON fd.login_id=oc.loginId AND fd.user_type='University'
        // LEFT JOIN student_details sdls ON sdls.studentId=" . $_SESSION['studentId'] . " AND sdls.isactive=1 WHERE oc.orgCourseId=$orgCourseId AND oc.loginId=$loginid AND oc.isactive=1 AND os.orgStreamId=$courseId");
		if ($qry->num_rows() > 0) {
			
			$rowData = $qry->row();
			$result = !$html ? $rowData : '<div class="col-md-12 nopadding">'.
											'<div class="col-md-3">Course Name</div>'.
											'<div class="col-md-3">' . $rowData->courseTitle . '</div>'.
											'<div class="col-md-3">Course Details</div>'.
											'<div class="col-md-3">' . $rowData->course_details . '</div>'.
											'<div class="col-md-3">Course Duration</div>'.
											'<div class="col-md-3">' . $rowData->course_duration . '</div>'.
											'<div class="col-md-3">Registration Fee</div>'.
											'<div class="col-md-3">' . $rowData->registration_fee . ' ' . $rowData->defaultCurrency . '</div>'.
											'<div class="col-md-3">Course Fee</div>'.
											'<div class="col-md-3">' . $rowData->course_fee . ' ' . $rowData->defaultCurrency . '</div>'.
										'</div>';

			$isAgeEligible = "Yes"; //($rowData->age > $rowData->minAge && $rowData->maxAge > $rowData->age ? "Yes" : "No");
			$agePreReqTable = !$html ? "" : '<table class="table table-condensed table-bordered table-hover table-responsive table-striped table-sm"><thead><tr style="background:#0073b7;color:white;"><th><small>Required Age</small></th><th><small>Your Age</small></th>
            <th><small>Match</small></th><th><small>Profile Edit</small></th></tr></thead><tbody><tr class="' . ($isAgeEligible == "Yes" ? "success" : "danger") . '"><td>' . !empty($rowData->agePrereq)??"" . '</td><td>' . ($rowData->age != "" ? round($rowData->age??0, '2') . ' Years on ' . ($rowData->ageasOn??"0") : '') . '</td>
            <td>' . ($isAgeEligible == "Yes" ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') . '</td><td><a target="_blank" href="' . site_url('studentPersonalDetails') . '" class="btn btn-xs btn-primary">Edit</a></td></tr></tbody></table>';
		} else {
			$result = "";
			$isAgeEligible = "Yes";
			$agePreReqTable = "";
		}
		$this->db->close();
		return ["CourseDetails" => $result, "isAgeEligible" => $isAgeEligible, "agePreReqTable" => $agePreReqTable];
	}

	private function collegeCourseInfo($orgCourseId, $courseId, $loginid, $html = true)
	{
		$qry = $this->db->query("SELECT cd.title courseTitle ,cty.courseType CourseType,IF(oc.ageValidDate='0000-00-00','', PERIOD_DIFF(DATE_FORMAT(oc.ageValidDate,'%Y%m'),DATE_FORMAT(sdls.dob,'%Y%m'))/12 age, CONCAT('Min Required ',oc.minAge,' To ',oc.maxAge,' Years' ) agePrereq,oc.minAge,oc.maxAge,
            DATE_FORMAT(oc.ageValidDate,'%d-%b-%Y') ageasOn,tdu.title CourseDuration,sd.title Stream,os.registrationFee,os.courseFee,fd.defaultCurrency  FROM organization_courses oc
            INNER JOIN course_type cty ON cty.ctId=oc.courseTypeId  INNER JOIN course_details cd ON cd.cId=oc.courseId INNER JOIN time_duration tdu ON tdu.tdId=oc.courseDurationId INNER JOIN organization_streams os ON os.orgCourseId=oc.orgCourseId AND os.isactive=1
            INNER JOIN stream_details sd ON sd.streamId=os.streamId LEFT JOIN tbl_financial_details fd ON fd.login_id=oc.loginId AND fd.user_type='College'  LEFT JOIN student_details sdls ON sdls.studentId=" . $_SESSION['studentId'] . " AND sdls.isactive=1
            WHERE oc.orgCourseId=$orgCourseId AND oc.loginId=$loginid AND oc.isactive=1 AND os.orgStreamId=$courseId");
		if ($qry->num_rows() > 0) {
			$rowData = $qry->row();
			$result = !$html ? $rowData : '<div class="col-md-12 nopadding"><div class="col-md-3">Course Type</div><div class="col-md-3">' . $rowData->courseTitle . '(' . $rowData->CourseType . ')</div><div class="col-md-3">Course Duration</div><div class="col-md-3">' . $rowData->CourseDuration . '</div><div class="col-md-3">Course Stream</div><div class="col-md-3">' . $rowData->Stream . '</div>
                        <div class="col-md-3">Registration Fee</div><div class="col-md-3">' . $rowData->registrationFee . ' ' . $rowData->defaultCurrency . '</div><div class="col-md-3">Course Fee</div><div class="col-md-3">' . $rowData->courseFee . ' ' . $rowData->defaultCurrency . '</div></div>';
			$isAgeEligible = ($rowData->age > $rowData->minAge && $rowData->maxAge > $rowData->age ? "Yes" : "No");
			$agePreReqTable = !$html ? "" : '<table class="table table-condensed table-bordered table-hover table-responsive table-striped table-sm"><thead><tr style="background:#0073b7;color:white;"><th><small>Required Age</small></th><th><small>Your Age</small></th>
            <th><small>Match</small></th><th><small>Profile Edit</small></th></tr></thead><tbody><tr class="' . ($isAgeEligible == "Yes" ? "success" : "danger") . '"><td>' . $rowData->agePrereq . '</td><td>' . ($rowData->age != "" ? round($rowData->age, '2') . ' Years on ' . ($rowData->ageasOn) : '') . '</td>
            <td>' . ($isAgeEligible == "Yes" ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') . '</td><td><a target="_blank" href="' . site_url('studentPersonalDetails') . '" class="btn btn-xs btn-primary">Edit</a></td></tr></tbody></table>';
		} else {
			$result = "";
			$isAgeEligible = "Yes";
			$agePreReqTable = "";
		}
		$this->db->close();
		return ["CourseDetails" => $result, "isAgeEligible" => $isAgeEligible, "agePreReqTable" => $agePreReqTable];
	}

	private function instituteCourseInfo($orgCourseId, $courseId, $loginid, $html = true)
	{
		$qry = $this->db->query("SELECT oc.insCourseDetailsId orgCourseId,oc.loginId,oc.insCourseId courseId,oc.courseDurationType CourseType,oc.registrationFee,oc.courseFee, ic.title courseTitle,td.title CourseDuration,'' department,'' Stream,fd.defaultCurrency
                ,IF(oc.ageValidDate='0000-00-00','', PERIOD_DIFF(DATE_FORMAT(oc.ageValidDate,'%Y%m'),DATE_FORMAT(sdls.dob,'%Y%m')))/12 age, CONCAT('Min Required ',oc.minAge,' To ',oc.maxAge,' Years' ) agePrereq,oc.minAge,oc.maxAge,DATE_FORMAT(oc.ageValidDate,'%d-%b-%Y') ageasOn  FROM institute_course_details oc
                INNER JOIN institute_course ic ON ic.insCourseId=oc.insCourseId  INNER JOIN time_duration td ON td.tdId=oc.timeDurationId LEFT JOIN tbl_financial_details fd ON fd.login_id=oc.loginId AND fd.user_type='Institute'
                LEFT JOIN student_details sdls ON sdls.studentId=" . $_SESSION['studentId'] . " AND sdls.isactive=1 WHERE oc.insCourseDetailsId=$orgCourseId AND oc.loginId=$loginid AND oc.isactive=1 AND oc.insCourseId=$courseId");
		if ($qry->num_rows() > 0) {
			$rowData = $qry->row();
			$result = !$html ? $rowData : '<div class="col-md-12 nopadding"><div class="col-md-3">Course Name</div><div class="col-md-3">' . $rowData->courseTitle . '</div> <div class="col-md-3">Course Type</div><div class="col-md-3">' . $rowData->CourseType . '</div><div class="col-md-3">Course Duration</div>
                    <div class="col-md-3">' . $rowData->CourseDuration . '</div><div class="col-md-3">Registration Fee</div><div class="col-md-3">' . $rowData->registrationFee . ' ' . $rowData->defaultCurrency . '</div>
                            <div class="col-md-3">Course Fee</div><div class="col-md-3">' . $rowData->courseFee . ' ' . $rowData->defaultCurrency . '</div></div>';
			$isAgeEligible = ($rowData->age > $rowData->minAge && $rowData->maxAge > $rowData->age ? "Yes" : "No");
			$agePreReqTable = !$html ? "" : '<table class="table table-condensed table-bordered table-hover table-responsive table-striped table-sm"><thead><tr style="background:#0073b7;color:white;"><th><small>Required Age</small></th><th><small>Your Age</small></th>
            <th><small>Match</small></th><th><small>Profile Edit</small></th></tr></thead><tbody><tr class="' . ($isAgeEligible == "Yes" ? "success" : "danger") . '"><td>' . $rowData->agePrereq . '</td><td>' . ($rowData->age != "" ? round($rowData->age, '2') . ' Years on ' . ($rowData->ageasOn) : '') . '</td>
            <td>' . ($isAgeEligible == "Yes" ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') . '</td><td><a target="_blank" href="' . site_url('studentPersonalDetails') . '" class="btn btn-xs btn-primary">Edit</a></td></tr></tbody></table>';
		} else {
			$result = "";
			$isAgeEligible = "Yes";
			$agePreReqTable = "";
		}
		$this->db->close();
		return ["CourseDetails" => $result, "isAgeEligible" => $isAgeEligible, "agePreReqTable" => $agePreReqTable];
	}

	private function schoolCourseInfo($orgCourseId, $courseId, $loginid, $html = true)
	{
		$qry = $this->db->query("SELECT  oc.sClassId orgCourseId,oc.loginId,oc.classTypeId courseId,'Full Time' courseDurationType,oc.courseFee,CONCAT(sct.class,' (',sct.title,')') course,'1 year' courseduration,'' departmentName
            ,'' Stream,fd.defaultCurrency,oc.registrationFee,oc.courseFee,fd.defaultCurrency,IF(oc.ageValidDate='0000-00-00','', PERIOD_DIFF(DATE_FORMAT(oc.ageValidDate,'%Y%m'),DATE_FORMAT(sdls.dob,'%Y%m')))/12 age,
            CONCAT('Min Required ',oc.minAge,' To ',oc.maxAge,' Years' ) agePrereq,oc.minAge,oc.maxAge,DATE_FORMAT(oc.ageValidDate,'%d-%b-%Y') ageasOn   FROM school_class_details oc INNER JOIN school_class_type sct ON sct.classTypeId=oc.classTypeId  LEFT JOIN tbl_financial_details fd ON fd.login_id=oc.loginId AND fd.user_type='School'
            LEFT JOIN student_details sdls ON sdls.studentId=" . $_SESSION['studentId'] . " AND sdls.isactive=1 WHERE oc.sClassId=$orgCourseId AND oc.loginId=$loginid AND oc.isactive=1 AND oc.classTypeId=$courseId");
		if ($qry->num_rows() > 0) {
			$rowData = $qry->row();
			$result = !$html ? $rowData : '<div class="col-md-12 nopadding"><div class="col-md-3">Class</div><div class="col-md-3">' . $rowData->course . '</div><div class="col-md-3">Course Type</div><div class="col-md-3">' . $rowData->courseDurationType . '</div><div class="col-md-3">Course Duration</div>
                    <div class="col-md-3">' . $rowData->courseduration . '</div><div class="col-md-3">Registration Fee</div><div class="col-md-3">' . $rowData->registrationFee . ' ' . $rowData->defaultCurrency . '</div>
                    <div class="col-md-3">Course Fee</div><div class="col-md-3">' . $rowData->courseFee . ' ' . $rowData->defaultCurrency . '</div></div>';
			$isAgeEligible = ($rowData->age > $rowData->minAge && $rowData->maxAge > $rowData->age ? "Yes" : "No");
			$agePreReqTable = !$html ? "" : '<table class="table table-condensed table-bordered table-hover table-responsive table-striped table-sm"><thead><tr style="background:#0073b7;color:white;"><th><small>Required Age</small></th><th><small>Your Age</small></th>
            <th><small>Match</small></th><th><small>Profile Edit</small></th></tr></thead><tbody><tr class="' . ($isAgeEligible == "Yes" ? "success" : "danger") . '"><td>' . $rowData->agePrereq . '</td><td>' . ($rowData->age != "" ? round($rowData->age, '2') . ' Years on ' . ($rowData->ageasOn) : '') . '</td>
            <td>' . ($isAgeEligible == "Yes" ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') . '</td><td><a target="_blank" href="' . site_url('studentPersonalDetails') . '" class="btn btn-xs btn-primary">Edit</a></td></tr></tbody></table>';
		} else {
			$result = "";
			$isAgeEligible = "Yes";
			$agePreReqTable = "";
		}
		$this->db->close();
		return ["CourseDetails" => $result, "isAgeEligible" => $isAgeEligible, "agePreReqTable" => $agePreReqTable];
	}

	//  univ minQuali start
	public function OrgMinQualification($orgCourseId)
	{
		$minQual = $this->minqualificationOrg($orgCourseId);
		$minQuals = ($minQual->num_rows() > 0 ? $minQual->result() : "");
		//$sExp = $this->studentexp($studentid);
		$minQualText = '<table class="table table-condensed table-bordered table-hover table-responsive table-striped table-sm">
							<thead>
								<tr style="background:#0073b7;color:white;">
									<th><small>Required Qualification</small></th>
									<th><small>Your Qualification</small></th>
									<th><small>Required Grades</small></th>
									<th><small>Your Grades</small></th>
									<th><small>Match</small></th>
									<th><small>Profile Edit</small></th>
									</tr></thead><tbody>';
		$qualString = "";
		if ($minQuals) {
			foreach ($minQuals as $mc) {
				$sDetailsArr = (!empty($mc->studentDetails) ? explode(',', $mc->studentDetails) : "");
				$eligibilityLink = $this->checkMarking($mc->studentDetails, $mc->percentage, $mc->markingType);

				$yourQual = $this->studentQualification($mc->org_type);
				$yourgrades = ($sDetailsArr != "" ? ($sDetailsArr[0] == "Univ" ?
					($sDetailsArr[4] ? $sDetailsArr[5] . ' ' . $sDetailsArr[4] : '') :
					($sDetailsArr[0] == "School" ? ($sDetailsArr[3] ? $sDetailsArr[4] . ' ' . $sDetailsArr[3] : '') :
						($sDetailsArr[0] == "Competitive" ? ($sDetailsArr[2] ? $sDetailsArr[2] : '') : ''))) : '');
				$profileLink = ($sDetailsArr != "" ? ($sDetailsArr[0] == "Univ" ? site_url('studentHigherEducationDetails') :
					($sDetailsArr[0] == "School" ? site_url('studentSecondarySchoolDetails') :
						($sDetailsArr[0] == "Competitive" ? site_url('studentCompetitiveExamDetails') : ''))) : site_url('student'));
				$minQualText .= '<tr class="' . ($mc->eligibility === "Eligible" ? "success" : "danger") . '">
									<td>' . $mc->courseName . ' (' . $mc->streamName . ')</td>
									<td>' . (isset($yourQual['qualification']) ? $yourQual['qualification'] : '') . '</td>
									<td>' . $mc->percentage . ' ' . $mc->markingType . '</td>
									<td>' . ($yourgrades ? $yourgrades : (isset($yourQual['qualification']) ? $yourQual['grades'] : '')) . '</td>
									<td>' . ($eligibilityLink ? '<i class="fa fa-check-circle text-success"></i>' :
						'<i class="fa fa-times-circle text-danger"></i>') .
					'</td>
									<td>
										<a target="_blank" href="' . $profileLink . '" class="btn btn-xs btn-primary">Edit</a>
										 <h6><small>' . $mc->relationType . '</small></h6>
									</td>
								</tr>';
				$qualString .= ($eligibilityLink ? '1' : '0') .
					($mc->relationType !== "" ? '' . ($mc->relationType == "OR" ? '^||^' : '^&&^') . '' : '');
			}
			$minQualText .= '</tbody></table>';
		}
		$result = ["Minqualification" => $minQualText, "minqual" => $minQuals, "Qualified" => $this->qualStringResult($qualString)];

		return array_merge($result, $this->requiredExperience($orgCourseId));
	}

	public function studentQualification($orgType)
	{
		$qualification_text = '';
		$student_grades = '';
		if (empty($orgType)) {
			return "";
		} else if ($orgType == "Univ") {
			$qualification = $this->Student_model->mGetHigherEduDetail();
			if (!empty($qualification)) {
				$qualification_array = json_decode($qualification);
				if(is_array($qualification_array) && count($qualification_array)>0){
					foreach ($qualification_array as $qr) {
						if (!empty($qr->ctitle)) {
							$qualification_text .= $qr->ctitle . "(" . $qr->streamtitle . ')<br>';
							$student_grades .= $qr->markingValue . " " . $qr->markingType . '<br>';
						}
					}
				}

			}
		} else if ($orgType == "School") {
			$qualification = $this->db->query('SELECT sct.class as class_name,sct.title as stream_name,sssd.markingValue as marking_value,
								sssd.markingType as marking_type FROM student_login as sl 
								LEFT join student_secondary_school_details as sssd on sssd.studentId=sl.studentId
								LEFT join school_class_type as sct on sct.classTypeId=sssd.classTypeId
								WHERE sl.studentId='.$_SESSION['studentId'].' and sssd.isactive=1
								union 
								SELECT sct.class as class_name,sct.title as stream_name,sensecd.markingValue as marking_value,
								sensecd.markingType as marking_type FROM student_login as sl 
								LEFT join student_senior_secondary_school_details as sensecd on sensecd.studentId=sl.studentId								
								LEFT JOIN school_class_type as sct on sct.classTypeId=sensecd.classTypeId								
								where sl.studentId='.$_SESSION['studentId'].' and sl.isactive=1 and sensecd.isactive=1');
			if ($qualification->num_rows()>0) {
				$qualification_array	= $qualification->result();
				foreach ($qualification_array as $qr) {
					if (!empty($qr->class_name)) {
						$qualification_text .= $qr->class_name . "(" . $qr->stream_name . ')<br>';
						$student_grades .= $qr->marking_value . " " . $qr->marking_type . '<br>';
					}
				}
			}
		} else if($orgType == "Inst"){
			$qualification = $this->Student_model->mGetInstituteEducationDetail();
			if (!empty($qualification)) {
				$qualification_array = json_decode($qualification);
				if(is_array($qualification_array) && count($qualification_array)>0){
					foreach ($qualification_array as $qr) {
						if (!empty($qr->title)) {
							$qualification_text .= $qr->title .'<br>';
							$student_grades .= $qr->markingValue . " " . $qr->markingType . '<br>';
						}
					}
				}
			}
		} else if($orgType == "Competitive"){
			$qualification = $this->Student_model->mGetCompetitiveExamDetails();
			
			if (!empty($qualification)) {
				$qualification_array = json_decode($qualification);
				foreach ($qualification_array as $qr) {
					if (!empty($qr->exam_name)) {
						$qualification_text .= $qr->exam_name .'from '.$qr->cldate.' to '.$qr->cvdate.'<br>';
						$student_grades .= $qr->examResult . " " . $qr->marking_system . '<br>';
					}
				}
			}
		}else if($orgType=='Subject'){
		/*	$qualification = $this->Student_model->mGetInstituteEducationDetail();
			if (!empty($qualification)) {
				$qualification_array = json_decode($qualification);
				foreach ($qualification_array as $qr) {
					if (!empty($qr->title)) {
						$qualification_text .= $qr->title .'<br>';
						$student_grades .= $qr->markingValue . " " . $qr->markingType . '<br>';
					}
				}
			}*/
		} else {

		}
		return ["qualification" => $qualification_text, "grades" => $student_grades];
	}

	public function checkMarking($studentdetails, $percentage, $markingtype)
	{
		if ($studentdetails == "") {
			return false;
		}
		$sdetailsarr = explode(",", $studentdetails);
		if ($sdetailsarr[0] == "Univ") {
			if (is_numeric($markingtype)) {
				return ($percentage < $sdetailsarr[5] ? true : false);
			} else {
				return $this->matchGrades(strtoupper($percentage), strtoupper($sdetailsarr[5]));
			}
		} else if ($sdetailsarr[0] == "School" || $sdetailsarr[0] == "Inst") {
			if (is_numeric($percentage) == false) {
				return $this->matchGrades(strtoupper($percentage), strtoupper($sdetailsarr[4]));
			} else {
				return ($percentage < $sdetailsarr[4] ? true : false);
			}
		} else {
			return true;
		}
	}

	private function matchGrades($reqG, $recG)
	{
		if ($reqG == $recG) {
			return true;
		}
		$reqGv = ($reqG == "AA" || $reqG == "A+" || $reqG == "A" ? 10 :
			($reqG == "AB" || $reqG == "A-" || $reqG == "A" ? 9 :
				($reqG == "BB" || $reqG == "B" ? 8 :
					($reqG == "BC" || $reqG == "B-" ? 7 :
						($reqG == "CC" || $reqG == "C" ? 6 :
							($reqG == "FF" || $reqG == "F" ? 5 : 0))))));
		$recGv = ($recG == "AA" || $recG == "A+" || $recG == "A" ? 10 :
			($recG == "AB" || $recG == "A-" || $recG == "A" ? 9 :
				($recG == "BB" || $recG == "B" ? 8 :
					($recG == "BC" || $recG == "B-" ? 7 :
						($recG == "CC" || $recG == "C" ? 6 :
							($recG == "FF" || $recG == "F" ? 5 : 0))))));
		if ($recGv > $reqGv) {
			return true;
		} else {
			return false;
		}
	}

	public function qualStringResult($qualString)
	{
		if ($qualString == "") {
			return "No";
		}
		$returnval = 1;
		$qryarray = explode("^", $qualString);
		if (count($qryarray) > 1) {
			for ($i = 0; $i < count($qryarray); $i++) {
				if ($qryarray[$i] == "&&") {
					$returnval = $returnval * $qryarray[$i - 1] * $qryarray[$i + 1];
				}
				if ($qryarray[$i] == "||") {
					$returnval = ($qryarray[$i - 1] + $qryarray[$i + 1] == 0 ? 0 : 1);
				}
			}
			return ($returnval == 1 ? "Yes" : "No");
		} else {
			return (count($qryarray) == 1 ? ($qryarray[0] === "0" ? "No" : "Yes") : "");
		}
	}

	private function minqualificationOrg($orgCourseId)
	{
		$query = $this->db->query("SELECT omp.prerequisitesId,cd.title courseName,sd.title streamName, omp.markingType, omp.percentage, omp.relationType,
					omp.orgCourseId, CONCAT('Univ',',',shed.student_hed_id,',', shed.collegeName, ',',
                    shed.universityName,',',shed.markingType,',',shed.markingValue) studentDetails, IF(shed.student_hed_id!='','Eligible','NotEligible') eligibility,
                    'Univ' as org_type
                     FROM orgcourse_mapping_prerequisites omp 
                     INNER JOIN course_details cd
                    ON cd.cId=omp.courseMinQualId AND omp.tableName='course_details' 
                    INNER JOIN stream_details sd ON sd.streamId=omp.minqualstreamId AND omp.streamTableName='stream_details' 
                    LEFT JOIN student_higher_education_details shed
                    ON shed.course_name=omp.courseMinQualId AND shed.streamId=omp.minqualstreamId AND omp.tableName='course_details' 
                    AND omp.streamTableName='stream_details' AND shed.markingType=omp.markingType AND shed.studentId=" . $_SESSION['studentId'] . " 
                    WHERE omp.orgCourseId=$orgCourseId AND omp.isactive=1
            UNION   SELECT omp.prerequisitesId,tc.classTitle courseName,sct.title streamName,omp.markingType, omp.percentage,omp.relationType,omp.orgCourseId,
            		IF(sssd.sssd_id!='',CONCAT('School',',',sssd.sssd_id,',',sssd.school_name,',',sssd.markingType,',',sssd.markingValue),
                    CONCAT('School',',',ssssd.ssssd_id,',', ssssd.school_name,',',ssssd.markingType,',',ssssd.markingValue)) studentDetails, 
                    IF(sssd.sssd_id!='' OR ssssd.ssssd_id!='','Eligible','NotEligible') eligibility, 'School' as org_type FROM orgcourse_mapping_prerequisites omp 
                    INNER JOIN tbl_classnames tc ON tc.classnamesId=omp.courseMinQualId AND omp.tableName='tbl_classnames' 
                    INNER JOIN school_class_type sct ON sct.classTypeId=omp.minqualstreamId AND omp.streamTableName='school_class_type' 
                    LEFT JOIN student_secondary_school_details sssd ON sssd.class_name=omp.courseMinQualId AND sssd.studentId=" . $_SESSION['studentId'] . " AND
                    omp.tableName='tbl_classnames' AND sssd.markingType=omp.markingType 
                    LEFT JOIN student_senior_secondary_school_details ssssd ON ssssd.classTypeId=omp.minqualstreamId AND omp.streamTableName='school_class_type' 
                    AND ssssd.studentId=" . $_SESSION['studentId'] . " AND ssssd.class_name=tc.classTitle AND omp.markingType=ssssd.markingType 
                    WHERE omp.orgCourseId=$orgCourseId AND omp.isactive=1
            UNION   SELECT omp.prerequisitesId,ic.title courseName,'Not Available' streamName,omp.markingType,omp.percentage, omp.relationType,omp.orgCourseId, 
            		CONCAT('Inst',',',tsid.studentInsId,',', tsid.instituteName, ',',tsid.markingType,',',
                    tsid.markingValue) studentDetails, IF(tsid.studentInsId!='','Eligible','NotEligible') eligibility, 'Inst' as org_type 
                    FROM orgcourse_mapping_prerequisites omp 
                    INNER JOIN institute_course ic ON ic.insCourseId=omp.courseMinQualId AND omp.tableName='institute_course' 
                    LEFT JOIN tbl_student_institute_details tsid
                    ON tsid.insCourseId=omp.courseMinQualId AND omp.tableName='institute_course' AND tsid.markingType=omp.markingType 
                    AND tsid.studentId=" . $_SESSION['studentId'] . "  AND tsid.isactive=1 WHERE omp.orgCourseId=$orgCourseId AND omp.isactive=1
            UNION   SELECT omp.prerequisitesId,tcem.exam_name courseName, 'Not Available' streamName,omp.markingType,omp.percentage,omp.relationType,
            		omp.orgCourseId,CONCAT('Competitive',',',tsc.studentCompExamId,',', tsc.examResult,',',
                    tsc.examValidDate,',',tsc.examClearingDate) studentDetails, IF(tsc.c_exam_id!='','Eligible','NotEligible') eligibility
                    , 'Competitive' as org_type  
                    FROM orgcourse_mapping_prerequisites omp 
                    INNER JOIN tbl_competitive_exam_master tcem ON tcem.c_exam_id=omp.courseMinQualId AND omp.tableName='tbl_competitive_exam_master'
                    LEFT JOIN tbl_student_competitive tsc ON tsc.studentId=" . $_SESSION['studentId'] . " AND tsc.c_exam_id=tcem.c_exam_id AND tsc.isactive=1 
                    AND tsc.examValidDate >CURRENT_DATE() AND tsc.examResult>=omp.percentage WHERE omp.orgCourseId=$orgCourseId AND omp.isactive=1
            UNION   SELECT omp.prerequisitesId,tsm.subjectId courseName,'Not Available' streamName,omp.markingType,omp.percentage,omp.relationType,
            		omp.orgCourseId,'' studentDetails,IF(ts.subjectMarksId!='','Eligible','NotEligible') as eligibility, 'Subject' as org_type 
            		 FROM orgcourse_mapping_prerequisites omp 
            		 INNER JOIN tbl_subjectmaster tsm ON tsm.subjectId=omp.courseMinQualId AND omp.tableName='tbl_subjectmaster' 
            		 LEFT JOIN student_senior_secondary_school_details ssssd ON ssssd.studentId=" . $_SESSION['studentId'] . " AND ssssd.isactive=1
                    LEFT JOIN tbl_subjectmarks ts ON ts.subjectId=omp.courseMinQualId AND ts.ssssd_id=ssssd.ssssd_id AND omp.tableName='tbl_subjectmaster' 
                    AND ts.obtMarks>omp.percentage AND omp.markingType='Marks' AND ts.isactive=1 WHERE omp.orgCourseId=1 AND omp.isactive=1 ORDER BY prerequisitesId ASC");

		$this->db->close();
		return $query;
	}

	//  univ minQuali end
	//  Experience Required Start
	public function requiredExperience($orgCourseId)
	{
		$qry = $this->db->query("SELECT omp.experienceId,omp.orgCourseId,omp.expDurationType,td.title timeduration,omp.description
        FROM orgcourse_mapping_experience omp INNER JOIN time_duration td on td.tdId=omp.expDurationId AND td.isactive=1 WHERE omp.orgCourseId=$orgCourseId AND omp.isactive=1");
		$this->db->close();
		$days = 0;
		$studentexpdetails = $this->studentexp($_SESSION['studentId']);
		$reqExp = "";
		if ($qry->num_rows() > 0) {
			foreach ($qry->result() as $exp) {
				$timeduration = explode(" ", $exp->timeduration);
				if (count($timeduration) >= 2) {
					$days = $days + (!empty(strpos($timeduration[1], 'ear')) ? (int)$timeduration[0] * 365 : (strpos($timeduration[1], 'onth') ? (int)$timeduration[0] * 30 : 0));
				}
				$reqExp .= $exp->timeduration . ' (' . $exp->expDurationType . ') ' . $exp->description . '<br>';
			}
		}
		$isElligible = ($studentexpdetails["Exp"] > $days ? "Yes" : "No");
		$experincePrereqTable = '<table class="table table-condensed table-bordered table-hover table-responsive table-striped table-sm"><thead><tr style="background:#0073b7;color:white;"><th><small>Required Experience</small></th><th><small>Your Experience</small></th><th><small>Total Required Experience</small></th>
            <th><small>Your Total Experience</small></th><th><small>Match</small></th><th><small>Profile Edit</small></th></tr></thead><tbody><tr class="' . ($isElligible == "Yes" ? "success" : "danger") . '"><td>' . ($reqExp == "" ? "Not Available" : $reqExp) . '</td><td>' . $studentexpdetails["studentexpdetails"] . '</td>
            <td>' . $days . ' Days</td><td>' . $studentexpdetails["Exp"] . ' Days</td><td>' . ($isElligible == "Yes" ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') . '</td><td><a target="_blank" href="' . site_url('studentExperienceDetails') . '" class="btn btn-xs btn-primary">Edit</a></td></tr></tbody></table>';

		return ["isElligible" => $isElligible, "experiencetable" => $experincePrereqTable];
	}

	public function studentexp($studentid)
	{
		$studentExp = $this->db->query("SELECT tse.*,CONCAT(PERIOD_DIFF(DATE_FORMAT(CURRENT_DATE(),'%Y%m'),DATE_FORMAT(tse.startDate,'%Y%m')),' Months ', tse.orgName,' ',
            tse.designation,'<br>From',DATE_FORMAT(tse.startDate,'%d-%b-%Y'),' To ',DATE_FORMAT(tse.endDate,'%d-%b-%Y'),'<br>') studentexpdetails,DATE_FORMAT(tse.startDate,'%d-%b-%Y') sDate,
            DATE_FORMAT(tse.endDate,'%d-%b-%Y') eDate, DATEDIFF(tse.endDate,tse.startDate) expDays FROM tbl_student_experience tse  WHERE tse.studentId=$studentid AND tse.isactive=1");
		$studentexpdetails = "";
		if ($studentExp->num_rows() > 0) {
			$expTotalDays = 0;
			foreach ($studentExp->result() as $se) {
				$expTotalDays = $expTotalDays + $se->expDays;
				$studentexpdetails .= $se->studentexpdetails;
			}
			$expMonths = ($expTotalDays ? floor($expTotalDays / 30) : "");
			$expdays = $expTotalDays - $expMonths * 30;
		} else {
			$expMonths = 0;
			$expdays = 0;
			$expTotalDays = 0;
		}
		$result = ["Exp" => $expTotalDays, "studentexpdetails" => ($studentexpdetails == "" ? "Not Available" : $studentexpdetails)];

		return $result;
	}

	//  Experience Required End
	//  Enrolled Data End

	public function mGetEnquiryDetails($id, $type, $courseId, $orgCourseId)
	{
		$getOrgData = $this->mgetEnrollOrgData($id, $type,$courseId);
		$orgData = ($getOrgData->num_rows() > 0 ? $getOrgData->result() : "");
		$courseDetails = $this->getCourseInfo($orgCourseId, $courseId, $type, $id);
		$response = ["orgDetails" => $orgData, "CourseDetails" => $courseDetails];
		return json_encode($response);
	}

	public function notLoggedIn($response)
	{
		$response;
		return json_encode($response);
	}

	public function mGetorgDetails($loginId, $orgName)
	{
		$orgname = str_replace("-", " ", $orgName);

		$qry = $this->db->query("SELECT ld.id as loginId,ld.email,od.orgName,od.orgVideo,od.orgAddress,od.orgLogo,od.orgMission,
			od.orgVission,od.defaultHeader,od.directorMobile,od.directorEmail,od.directorName,od.orgDesp,cs.name as country,
			ss.name as state,cts.name as city,od.approvedBy,od.orgImgHeader,od.orgMobile,od.orgWebsite,ld.roleName,od.orgGoogle,
			timestampdiff(YEAR,od.orgEstablished,CURRENT_DATE()) yearsofest,od.orgEstablished,od.orgButtonType,
			od.webLinkStartus FROM login_details as ld
			INNER JOIN organization_details as od ON od.loginId=ld.id " . $this->getLocationCondtion() . "
			INNER JOIN countries as cs ON cs.countryId=od.countryId
			INNER JOIN states as ss ON ss.stateId=od.stateId AND ss.isactive=1
			INNER JOIN cities as cts ON cts.cityId=od.cityId WHERE ld.id=$loginId AND od.orgName LIKE '%" . $orgname . "%' 
			AND ld.isactive=1 AND ld.verifyStatus=1");

		if ($qry->num_rows() > 0) {
			return $qry->row();
		} else {
			return false;
		}
	}

	/**
	 *
	 * @param type $getOrgDetails
	 */
	public function mGetHighligtedCourse($getOrgDetails)
	{
		$loginId = $getOrgDetails->loginId;
		$orgType = $getOrgDetails->roleName;
		$studentId = (isset($_SESSION['studentId']) ? $_SESSION['studentId'] : 0);
		$prevsearch = $this->db->where(["studentId" => $studentId, "loginId" => $loginId, "orgType" => $orgType])->or_like('searchterm', 'match', 'both')->order_by("searchID", "desc")->limit("1")->get("tbl_usersearch");
		if ($prevsearch->num_rows() > 0) {
			$courseId = $prevsearch->row()->courseId;
			return $this->getHighlightedCourseDetails($loginId, $orgType, $courseId);
		} else {
			return $this->getHighlightedCourseDetails($loginId, $orgType, "");
		}
	}

	private function getHighlightedCourseDetails($loginId, $orgType, $courseId)
	{
		if (empty($loginId) && empty($orgType) && empty($courseId)) {
			return "";
		}
		$filterCondition = ($courseId ? ($orgType == "University" || $orgType == "College" ? " AND os.orgStreamId=$courseId" :
			($orgType == "Institute" ? " AND ic.insCourseId=$courseId" : ($orgType == "School" ? " AND oc.sClassId=$courseId" : ""))) : "");
		$filterCondition .= 'AND oc.login_id ="' . $loginId . '"';
		return $qry = (($orgType == "University" || $orgType == "College") ? $this->univCollegeCourses($filterCondition, $orgType) :
			($orgType == "Institute" ? $this->instituteCourses($filterCondition, $orgType) : ($orgType == "School" ? $this->schoolCourses($filterCondition, $orgType) : "")));
	}

	public function mGetPrefferedCourse($loginId)
	{
		$studentId = (isset($_SESSION['studentId']) ? $_SESSION['studentId'] : 0);
		$usersearch = $this->db->where(["loginId" => $loginId, "studentId" => $studentId])
			->order_by("searchID", "desc")->limit("1")->get("tbl_usersearch");

		if ($usersearch->num_rows() > 0) {

		}
	}

	public function mGetorgSliderImages($loginId)
	{
		$qry = $this->db->where(["loginId" => $loginId, "isactive" => 1])->get("tbl_org_sliders");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetReqFacility($loginId)
	{
		$qry = $this->db->query("SELECT fs.title as facilities,fs.facility_icon
                FROM org_mapping_facilities as omf
                INNER JOIN facilities as fs ON fs.facilityId=omf.facilityId AND fs.isactive=1
                WHERE omf.loginId=$loginId AND omf.isactive=1");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetOrgSeatsDetails($loginId)
	{
		$qry = $this->db->query("SELECT SUM(availableSheet) as availableSheet ,
                SUM(totalSheet) as totalSheet FROM organization_streams as os
                INNER JOIN organization_details as od ON od.loginId=os.loginId
                WHERE os.loginId=$loginId AND os.isactive=1 " . $this->getLocationCondtion() . "");
		if ($qry->num_rows() > 0) {
			return $qry->row();
		} else {
			return false;
		}
	}

	public function mGetOrgCourseDetails($loginId)
	{
		$qry = $this->db->query("SELECT SUM(availableSheet) as availableSheet ,
                SUM(totalSheet) as totalSheet FROM organization_streams as os
                INNER JOIN organization_details as od ON od.loginId=os.loginId
                WHERE os.loginId=$loginId AND os.isactive=1 " . $this->getLocationCondtion() . "");
		if ($qry->num_rows() > 0) {
			return $qry->row();
		} else {
			return false;
		}
	}

	public function mGetOrgCourseType()
	{
		$qry = $this->db->query("SELECT * FROM course_type WHERE isactive=1");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetOrgGallery($loginId)
	{
		$qry = $this->db->query("SELECT * FROM gallery  WHERE loginId=$loginId AND isactive=1");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetPlacementData($orgId)
	{
		$qry = $this->db->query("SELECT * FROM placement  WHERE loginId=$orgId AND isactive=1");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetOrgCourses($loginId, $type,$OrgCourseId="")
	{
		$loginIdsIds = $this->input->post("checkedData");
		if (!empty($loginIdsIds)) {
			$loginid = array_unique(filter_var_array($loginIdsIds));
			$loginids = implode(',', $loginid);
			$filterCondition = 'AND oc.login_id IN (' . $loginids . ')';
		} else {
			$filterCondition = 'AND oc.login_id ="' . $loginId . '"';
		}
		if ($type == "") {
			$orgType = $this->db->where('id', $loginId)->get('login_details');
			if ($orgType->num_rows() > 0) {
				$type = $orgType->row()->roleName;
			} else {
				return false;
			}
		}
		 switch ($type) {
			 case "College":
			 case "University":
			 	if($OrgCourseId){
					$filterCondition .= " AND oc.id=$OrgCourseId";
				}
			 	$qry = $this->univCollegeCourses($filterCondition, $type);
			 	break;
			 case "Institute":
				 if($OrgCourseId){
					 $filterCondition .= " AND oc.insCourseDetailsId=$OrgCourseId";
				 }
				 $qry = $this->instituteCourses($filterCondition, $type);
				 break;
			 case "School":
				 if($OrgCourseId){
					 $filterCondition .= " AND oc.sClassId=$OrgCourseId";
				 }
				 $qry = $this->schoolCourses($filterCondition, $type);
				 break;
			 default:
				 $qry = "";
				 break;
		 }
		return ($qry->num_rows() > 0 ? $qry->result() : false);

	}

	private function univCollegeCourses($filterCondition, $type)
	{
		return $this->db->query("SELECT 
		oc.id as orgCourseId,
		oc.login_id as loginId,
		fd.defaultCurrency,
		CONCAT('Registration Fee: ',
				oc.registration_fee,
				' Course Fee :',
				oc.course_fee) courseFee,
		cm.course_name,
		cm.course_duration,
    if(oc.course_details is null,cm.course_details,oc.course_details) as course_details,
    if(oc.course_qualifications is null,cm.course_qualifications,oc.course_qualifications) as course_qualifications,
    oc.total_seats
		 
	FROM
		organisation_courses AS oc
			INNER JOIN
		course_masters cm ON cm.id = oc.course_masters_id
			LEFT JOIN
		tbl_financial_details fd ON fd.login_id = oc.login_id
			AND fd.user_type = 'University'
	WHERE
		oc.is_active = 1 $filterCondition
	ORDER BY oc.login_id");
		// return $this->db->query("SELECT oc.orgCourseId,oc.departmentId,oc.loginId,os.orgStreamId courseId,
		// 					oc.courseDurationType,oc.courseFeeType,fd.defaultCurrency,
        //                      CONCAT('Registration Fee: ',os.registrationFee,' Course Fee :',os.courseFee) courseFee,
        //                      ct.courseType,sd.title Stream,cd.title as course,td.title as courseduration,dt.title departmentName,
        //                      DATE_FORMAT(oc.openingDate,'%d-%b-%Y') appOpening,
        //                      DATE_FORMAT(oc.closingDate,'%d-%b-%Y') appClosing,
        //                      DATE_FORMAT(oc.examDate,'%d-%b-%Y') examDate,
        //                      oc.examMode,
        //                      DATE_FORMAT(oc.resultDate,'%d-%b-%Y') resultDate
        //                     FROM organization_courses as oc
        //                     LEFT JOIN department dt ON dt.departmentId=oc.departmentId
        //                     INNER JOIN course_type ct ON ct.ctId=oc.courseTypeId
        //                     INNER JOIN course_details cd ON cd.cId=oc.courseId
        //                     INNER JOIN time_duration td ON td.tdId=oc.courseDurationId
        //                     INNER JOIN organization_streams os ON os.orgCourseId=oc.orgCourseId AND os.isactive=1
        //                     INNER JOIN stream_details sd ON sd.streamId=os.streamId
        //                     LEFT JOIN tbl_financial_details fd ON fd.login_id=oc.loginId AND fd.user_type='$type'
        //                     WHERE  oc.isactive=1 $filterCondition  order by oc.loginId");
	}

	private function instituteCourses($filterCondition, $type)
	{
		return $this->db->query("SELECT oc.insCourseDetailsId orgCourseId,oc.loginId,oc.insCourseId courseId,oc.courseDurationType,
                CONCAT('Registration Fee: ',oc.registrationFee,' Course Fee :',oc.courseFee) courseFee, ic.title course,
                td.title courseduration,'' departmentName,'' Stream,fd.defaultCurrency,
                DATE_FORMAT(oc.applyFrom,'%d-%b-%Y') appOpening,
			    DATE_FORMAT(oc.applyTo,'%d-%b-%Y') appClosing,
			    DATE_FORMAT(oc.examDate,'%d-%b-%Y') examDate,
				oc.examMode,
				DATE_FORMAT(oc.resultDate,'%d-%b-%Y') resultDate FROM institute_course_details oc
                INNER JOIN institute_course ic ON ic.insCourseId=oc.insCourseId
                INNER JOIN time_duration td ON td.tdId=oc.timeDurationId
                LEFT JOIN tbl_financial_details fd ON fd.login_id=oc.loginId AND fd.user_type='$type'
                WHERE   oc.isactive=1 $filterCondition  order by oc.loginId");
	}

	private function schoolCourses($filterCondition, $type)
	{
		return $this->db->query("SELECT oc.sClassId orgCourseId,oc.loginId,oc.classTypeId courseId,
		'Full Time' courseDurationType,CONCAT('Registration Fee: ',oc.registrationFee,' Course Fee :',oc.courseFee) courseFee,
		CONCAT(sct.class,' (',sct.title,')') course,'1 year' courseduration,'' departmentName,'' Stream,fd.defaultCurrency,
	    DATE_FORMAT(oc.applyFrom,'%d-%b-%Y') appOpening,DATE_FORMAT(oc.applyTo,'%d-%b-%Y') appClosing FROM school_class_details oc
            INNER JOIN school_class_type sct ON sct.classTypeId=oc.classTypeId
            LEFT JOIN tbl_financial_details fd ON fd.login_id=oc.loginId AND fd.user_type='$type'
            WHERE   oc.isactive=1 $filterCondition  order by oc.loginId");
	}

	public function mGetFacultyData($orgId)
	{
		$qry = $this->db->query("SELECT * FROM faculty_details WHERE isactive=1 AND loginId=$orgId");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetAchievementData($orgId)
	{
		$qry = $this->db->query("SELECT * FROM achievement WHERE isactive=1 AND loginId=$orgId");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetNewsData($orgId)
	{
		$qry = $this->db->query("SELECT newsId,loginId,title,description,newsImage,DATE_FORMAT(publishDate,'%d-%b-%Y') AS pDate FROM news WHERE isactive=1 AND loginId=$orgId");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
	
	public function sendEmailToOrg($email, $body, $subject) {

        $emailS = (isset($_SESSION['websiteEmail']) ? $_SESSION['websiteEmail'] : 'donotreply@ihuntbest.com');

        $senderName = "iHuntBest";

        $message = $body;

        $config = array('mailtype' => 'html', 'charset' => 'iso-8859-1', 'wordwrap' => TRUE);

        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");

        $this->email->set_mailtype("html");

        $this->email->from($emailS, $senderName);
		$emailmg = "mehul.scorpsoft@gmail.com";

        $this->email->to($email);
		//$this->email->cc($emailmg);

        $this->email->subject($subject);

        $this->email->message($message);

        $reps = $this->email->send();

        return $reps;

    }
	
	
	

	public function mGetEventsData($orgId)
	{
		$qry = $this->db->query("SELECT *, DATE_FORMAT(createdAt,'%d-%b-%Y') AS publishdate  FROM event_details WHERE isactive=1 AND loginId=$orgId");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetOrgCount()
	{
		$qry = $this->db->query("SELECT (SELECT COUNT(ld.id)  FROM login_details ld WHERE ld.roleName='University' AND ld.isactive=1) totalUniversities,
                                            (SELECT COUNT(ld.id)  FROM login_details ld WHERE ld.roleName='College' AND ld.isactive=1) totalColleges,
                                            (SELECT COUNT(ld.id)  FROM login_details ld WHERE ld.roleName='Institute' AND ld.isactive=1) totalInstitutes,
                                            (SELECT COUNT(ld.id)  FROM login_details ld WHERE ld.roleName='School' AND ld.isactive=1) totalSchools");
		if ($qry->num_rows() > 0) {
			return $qry->row();
		} else {
			return false;
		}
	}

	public function mGetMyRatings($orgId)
	{
		if (isset($_SESSION['studentId'])) {
			$studentId = $_SESSION['studentId'];
			$qry = $this->db->where(["studentId" => $studentId, "loginId" => $orgId])->get("tbl_ratings");
			if ($qry->num_rows() > 0) {
				$result = $qry->row();

				return $result;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function mGetAllRatings($orgId)
	{
		$qry = $this->db->query("Select tr.*,sd.studentName,sd.studentImage,DATE_FORMAT(tr.createdAt,'%M %d,%Y') commentDate,DATEDIFF(CURRENT_DATE(),tr.createdAt) daysago from tbl_ratings tr
                                            INNER JOIN student_details sd on sd.studentId=tr.studentId AND sd.isactive=1
                                            where tr.loginId=$orgId and tr.isReviewed=1 and tr.isactive=1 order by tr.ratings_Id DESC");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	//organisation view end
	//Allorganization Details Start

	public function mGetOrganisationDetails($type, $start, $records)
	{

		$checkedData = $this->input->post("checkedData");
		if (!empty($checkedData)) {
			$loginid = array_unique($checkedData);
			$loginids = implode(',', $loginid);
			$filterCondition = 'AND od.loginId IN (' . $loginids . ')';
		} else {
			$filterCondition = '';
		}
		if ($start != "" && $records != "") {
			$limit = ' LIMIT ' . $start . ',' . $records . '';
		} else {
			$limit = "";
		}
		$qry = $this->db->query("SELECT *,ctr.name as countryName FROM organization_details od
                            INNER JOIN login_details ld ON ld.id=od.loginId and ld.isactive=1 LEFT JOIN countries ctr ON ctr.countryId=od.countryId
                            WHERE od.isactive=1 AND ld.roleName='" . $type . "' AND ld.verifyStatus=1 " . $this->getLocationCondtion() . " and ld.loginStatus=0 $filterCondition order by od.loginId $limit"); //and ld.admin_approved=1
		return ($qry->num_rows() > 0 ? $qry->result() : "");
	}

	private function saveSearchData($type)
	{
		$searchterm = FILTER_VAR(trim($this->input->get("searchterm")), FILTER_SANITIZE_STRING);
		$id = FILTER_VAR(trim($this->input->get("id")), FILTER_SANITIZE_STRING);
		$courseId = FILTER_VAR(trim($this->input->get("courseId")), FILTER_SANITIZE_STRING);
		$studentId = (isset($_SESSION['studentId']) ? $_SESSION['studentId'] : "");
		$condition = ["searchterm" => $searchterm, "loginId" => $id, "studentId" => $studentId, "ipAddress" => $this->getRealIpAddr(), "orgType" => $type, "courseId" => $courseId];
		$chk = $this->db->where($condition)->get("tbl_usersearch");
		if ($chk->num_rows() == 0) {
			$this->db->insert("tbl_usersearch", array_merge($condition, ["datetime" => $this->datetimenow()]));
		} else {

		}
	}

	public function mGetTotalOrganization($type)
	{
		$qry = $this->db->query("SELECT COUNT(DISTINCT ld.id) as totalorgs FROM organization_details od
                            INNER JOIN login_details ld ON ld.id=od.loginId and ld.isactive=1
                            WHERE od.isactive=1 AND ld.roleName='" . $type . "' AND ld.verifyStatus=1 " . $this->getLocationCondtion() . " and ld.loginStatus=0"); //and ld.admin_approved=1
		if ($qry->num_rows() > 0) {
			return $qry->row();
		} else {
			return false;
		}
	}

	public function getOrganisationStateCityWise($type, $cityOrState)
	{

		if ($cityOrState == 'State') {
			$selData = 'sts.name as statename,sts.stateId as stateId';
			$groupby = 'od.stateId';
		}
		if ($cityOrState == 'City') {
			$selData = 'cts.name as cityname,cts.cityId';
			$groupby = 'od.cityId';
		}
		$qry = $this->db->query("SELECT $selData,COUNT(DISTINCT ld.id) as totalorgs,GROUP_CONCAT(DISTINCT ld.id) as lids  FROM organization_details od
                                    INNER JOIN login_details ld ON ld.id=od.loginId and ld.isactive=1
                                    INNER JOIN states sts ON sts.stateId=od.stateId
                                    INNER JOIN cities cts ON cts.cityId=od.cityId
                                    WHERE od.isactive=1 AND ld.roleName='" . $type . "' AND ld.verifyStatus=1 and ld.loginStatus=0 GROUP by $groupby");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function getOrgCoursewise($type)
	{
		if ($type == "University" || $type == "College") {
			$qry = $this->db->query("SELECT ct.ctId,ct.courseType,COUNT(DISTINCT ld.id) as totalorgs,GROUP_CONCAT(DISTINCT ld.id) as lids,ld.roleName FROM organization_courses oc
                        INNER JOIN login_details ld ON ld.id = oc.loginId AND ld.isactive=1  INNER JOIN course_type ct ON ct.ctId=oc.courseTypeId
                        WHERE ld.isactive=1 and ld.roleName='" . $type . "' AND ld.verifyStatus=1 and ld.loginStatus=0 GROUP by ct.ctId");
		} else if ($type == "Institute") {
			$qry = $this->db->query("SELECT ic.insCourseId ctId,ic.title courseType,COUNT(DISTINCT icd.loginId) totalorgs,ld.roleName,GROUP_CONCAT(DISTINCT ld.id) lids FROM institute_course_details icd
                        INNER JOIN institute_course ic ON ic.insCourseId=icd.insCourseId AND ic.isactive=1
                        INNER JOIN login_details ld ON ld.id=icd.loginId AND ld.isactive=1
                        WHERE icd.isactive=1 AND ld.roleName='" . $type . "' AND ld.verifyStatus=1 and ld.loginStatus=0 GROUP BY ic.insCourseId ");
		} else {
			$qry = $this->db->query("SELECT sct.classTypeId as ctId,GROUP_CONCAT(sct.class) classes,sct.title courseType,COUNT(DISTINCT scd.loginId) totalorgs,ld.roleName,GROUP_CONCAT(DISTINCT ld.id) lids FROM school_class_details scd
                        INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId INNER JOIN login_details ld ON ld.id=scd.loginId AND ld.isactive=1
                        WHERE scd.isactive=1 AND ld.roleName='" . $type . "' AND ld.verifyStatus=1 and ld.loginStatus=0 GROUP BY sct.title");
		}
		$this->saveSearchData($type);
		return ($qry->num_rows() > 0 ? $qry->result() : "");
	}

	public function getOrgTypeWise($type)
	{
		$qry = $this->db->query("SELECT od.orgType,COUNT(DISTINCT od.orgId) as totalorgs,GROUP_CONCAT(DISTINCT od.orgId) lids
                        FROM organization_details od
                        INNER JOIN login_details ld ON ld.id=od.loginId AND ld.isactive=1
                        WHERE od.isactive=1  AND ld.roleName='" . $type . "' AND ld.verifyStatus=1 and ld.loginStatus=0 " . $this->getLocationCondtion() . " GROUP BY od.orgType");

		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function getOrgStatusWise($type)
	{
	    $qry = $this->db->query("SELECT (SELECT GROUP_CONCAT(DISTINCT od.orgId) lids
                        FROM organization_details od
                        INNER JOIN login_details ld ON ld.id=od.loginId AND ld.isactive=1
                        WHERE od.isactive=1  AND ld.roleName='" . $type . "' AND od.orgTopRated=1 AND ld.verifyStatus=1 and ld.loginStatus=0) topratedorgs,
                        (SELECT GROUP_CONCAT(DISTINCT od.orgId) lids
                        FROM organization_details od
                        INNER JOIN login_details ld ON ld.id=od.loginId AND ld.isactive=1
                        WHERE od.isactive=1  AND ld.roleName='" . $type . "' AND od.orgLatestStatus=1 AND ld.verifyStatus=1 and ld.loginStatus=0) latestorgs,
                        (SELECT GROUP_CONCAT(DISTINCT od.orgId) lids
                        FROM organization_details od
                        INNER JOIN login_details ld ON ld.id=od.loginId AND ld.isactive=1
                        WHERE od.isactive=1  AND ld.roleName='" . $type . "' AND od.orgFeatureStatus AND ld.verifyStatus=1 and ld.loginStatus=0) featuredorgs");
		if ($qry->num_rows() > 0) {
			return $qry->row();
		} else {
			return false;
		}
	}

	public function random_password($length = 8)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr(str_shuffle($chars), 0, $length);

		return $password;
	}

	public function mGetPageNames($orgId)
	{
		$qry = $this->db->where(["loginId" => $orgId, "isactive" => 1])->select("pageName,pageId,description")->get("pages");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetApprovalDocs($orgId)
	{
		$qry = $this->db->where(["loginId" => $orgId, "isactive" => 1])->get("tbl_orgapproval_doc");
		return ($qry->num_rows() > 0 ? $qry->result() : "");
	}

	//Allorganization Details End
	//filter by cat start
	public function mGetLatestOrFeaturedOrgDetails($type, $condition, $filterCondition)
	{
		if ($type == "University") {
			return $this->getUniversityDetailsByCourse($condition, $filterCondition);
		} elseif ($type == "College") {
			return $this->getCollegeDetailsByCourse($condition, $filterCondition);
		} elseif ($type == "Institute") {
			return $this->getInstituteDetailsByCourse($condition, $filterCondition);
		} elseif ($type == "School") {
			return $this->getSchoolDetailsByCourse($condition, $filterCondition);
		} else {
			return false;
		}
//                $qry    =   $this->db->query("SELECT ld.id as loginId,ld.email,od.orgName,od.orgAddress,od.orgLogo,od.orgMission,od.orgVission,od.directorMobile,od.directorEmail,
//			od.directorName,od.orgDesp,cs.name as country,ss.name as state,cts.name as city,od.approvedBy,od.orgImgHeader,od.orgMobile,od.orgWebsite,
//                        ld.roleName,(SELECT SUM(availableSheet)  FROM organization_streams  WHERE loginId=od.loginId) as availabesheets
//                        FROM login_details as ld
//			INNER JOIN organization_details as od ON od.loginId=ld.id
//			INNER JOIN countries as cs ON cs.countryId=od.countryId
//			INNER JOIN states as ss ON ss.stateId=od.stateId AND ss.isactive=1
//			INNER JOIN cities as cts ON cts.cityId=od.cityId WHERE  ld.isactive=1 ".$condition." $filterCondition AND ld.verifyStatus=1 and ld.loginStatus=0 AND ld.roleName='".$type."'");
//
//            if($qry->num_rows()>0){
//                return $qry->result();
//            }else{
//                return false;
//            }
	}

	public function getCourseDetailsList($roleName,$condition = "", $filterCondition = ""){
		$qry = $this->db->query("SELECT od.loginId, od.orgName, od.orgLogo, od.orgImgHeader, od.orgAddress, cm.course_name as courseName, 
					oc.id as OrgcourseId, oc.course_masters_id as  courseid, CONCAT('Reg. Fee: ', oc.registration_fee, ' ', tfd.defaultCurrency,
					 ' Course Fee: ', oc.course_fee, ' ', tfd.defaultCurrency) courseFee, oc.available_seats AS availableSeats, 
					 oc.total_seats AS totalSeats, (SELECT  AVG(ratings) FROM tbl_ratings WHERE isactive = 1 AND loginId = od.loginId) ratings,
					  od.orgButtonType,oc.course_qualifications FROM login_details ld 
		INNER JOIN organization_details od ON od.loginId = ld.id AND od.isactive = 1 
		INNER JOIN organisation_courses oc ON oc.login_id = od.loginId  AND oc.is_active = 1 
		INNER JOIN course_masters as cm on cm.id=oc.course_masters_id	
		LEFT JOIN tbl_financial_details tfd ON tfd.login_id = od.loginId AND tfd.isactive = 1 AND tfd.user_type = '$roleName' 
		WHERE ld.isactive = 1 AND ld.verifyStatus = 1 AND ld.loginStatus = 0 AND ld.roleName = '$roleName' 
		$condition $filterCondition " . $this->getLocationCondtion() . " ORDER BY od.loginId DESC");
		$this->db->close();
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	public function getUniversityDetailsByCourse($condition, $filterCondition)
	{
		
		$qry = $this->db->query("SELECT od.loginId,od.orgName,od.orgLogo,od.orgImgHeader,od.orgAddress,CONCAT(cdt.title,' ',stds.title) courseName,oc.orgCourseId OrgcourseId,os.orgStreamId courseid,
                        CONCAT('Reg. Fee: ',os.registrationFee,' ',tfd.defaultCurrency,' Course Fee: ',os.courseFee,' ',tfd.defaultCurrency) courseFee,os.availableSheet as availableSeats,
                        os.totalSheet as totalSeats,(SELECT AVG(ratings) FROM tbl_ratings WHERE isactive=1 AND loginId=od.loginId) ratings,
                        od.orgButtonType  FROM login_details ld
                        INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                        INNER JOIN organization_courses oc ON oc.loginId=od.loginId AND oc.isactive=1
                        INNER JOIN department dep ON dep.departmentId=oc.departmentId AND dep.isactive=1
                        INNER JOIN course_type ct ON ct.ctId=oc.courseTypeId AND ct.isactive=1
                        INNER JOIN course_details as cdt ON cdt.cId=oc.courseId AND cdt.isactive=1
                        INNER JOIN time_duration ttd ON ttd.tdId=oc.courseDurationId AND ttd.isactive=1
                        INNER JOIN organization_streams os ON os.orgCourseId=oc.orgCourseId AND os.isactive=1
                        INNER JOIN stream_details stds ON stds.streamId=os.streamId AND stds.isactive=1
                        LEFT JOIN tbl_financial_details tfd ON tfd.login_id=od.loginId AND tfd.isactive=1 AND tfd.user_type='University'
                        WHERE ld.isactive=1 $condition $filterCondition AND ld.verifyStatus=1
                        and ld.loginStatus=0 AND ld.roleName='University' " . $this->getLocationCondtion() . " 
                        GROUP BY os.orgStreamId ORDER BY od.loginId DESC");
		 

		$this->db->close();
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	private function getCollegeDetailsByCourse($condition, $filterCondition)
	{
		$qry = $this->db->query("SELECT od.loginId,od.orgName,od.orgLogo,od.orgImgHeader,od.orgAddress,CONCAT(cdt.title,' ',stds.title,' (',ct.courseType,')') courseName,oc.orgCourseId OrgcourseId,os.orgStreamId courseid,
			CONCAT('Reg. Fee: ',os.registrationFee,' ',tfd.defaultCurrency,' Course Fee: ',os.courseFee,' ',tfd.defaultCurrency) courseFee,os.availableSheet as availableSeats,
                        os.totalSheet as totalSeats,(SELECT AVG(ratings) FROM tbl_ratings WHERE isactive=1 AND loginId=od.loginId) ratings,od.orgButtonType  FROM login_details ld
                        INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                        INNER JOIN organization_courses oc ON oc.loginId=od.loginId AND oc.isactive=1
                        INNER JOIN course_type ct ON ct.ctId=oc.courseTypeId AND ct.isactive=1
                        INNER JOIN course_details as cdt ON cdt.cId=oc.courseId AND cdt.isactive=1
                        INNER JOIN time_duration ttd ON ttd.tdId=oc.courseDurationId AND ttd.isactive=1
                        INNER JOIN organization_streams os ON os.orgCourseId=oc.orgCourseId AND os.isactive=1
                        INNER JOIN stream_details stds ON stds.streamId=os.streamId AND stds.isactive=1
                        LEFT JOIN tbl_financial_details tfd ON tfd.login_id=od.loginId AND tfd.isactive=1 AND tfd.user_type='College'
                        WHERE ld.isactive=1 $condition $filterCondition AND ld.verifyStatus=1 and ld.loginStatus=0 AND ld.roleName='College' " . $this->getLocationCondtion() . " GROUP BY os.orgStreamId ORDER BY od.loginId DESC");
		$this->db->close();
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	private function getInstituteDetailsByCourse($condition, $filterCondition)
	{
		
		$qry = $this->db->query("SELECT od.loginId,od.orgName,od.orgLogo,od.orgImgHeader,od.orgAddress,CONCAT(ic.title,' ',td.title,' (',icd.courseDurationType,')') courseName,
                    icd.insCourseDetailsId OrgcourseId,icd.insCourseId courseid,CONCAT('Reg. Fee: ',icd.registrationFee,' ',fd.defaultCurrency,' Course Fee: ',icd.courseFee,' ',fd.defaultCurrency) courseFee,
                    icd.availableSheet as availableSeats,icd.totalSheet as totalSeats,(SELECT AVG(ratings) FROM tbl_ratings WHERE isactive=1 AND loginId=od.loginId) ratings,od.orgButtonType
                    FROM login_details ld
                    INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                    INNER JOIN institute_course_details icd ON icd.loginId=od.loginId AND icd.isactive=1
                    INNER JOIN institute_course ic ON ic.insCourseId=icd.insCourseId AND ic.isactive=1
                    INNER JOIN time_duration td ON td.tdId=icd.timeDurationId
                    LEFT JOIN tbl_financial_details fd ON fd.login_id=icd.loginId AND fd.user_type='Institute'
                    WHERE ld.roleName='Institute' AND ld.isactive=1 $condition $filterCondition AND ld.verifyStatus=1 " . $this->getLocationCondtion() . " AND ld.loginStatus=0 ORDER BY od.loginId DESC");
		$this->db->close();
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	private function getSchoolDetailsByCourse($condition, $filterCondition)
	{
		$qry = $this->db->query("SELECT od.loginId,od.orgName,od.orgLogo,od.orgImgHeader,od.orgAddress,CONCAT(scd.class,' ',sct.title,' (',scd.courseDurationType,')') courseName,
                    scd.sClassId OrgcourseId,scd.classTypeId courseid,CONCAT('Reg. Fee: ',scd.registrationFee,' ',fd.defaultCurrency,' Course Fee: ',scd.courseFee,' ',fd.defaultCurrency) courseFee,
                    scd.availableSheet as availableSeats,scd.totalSheet as totalSeats,(SELECT AVG(ratings) FROM tbl_ratings WHERE isactive=1 AND loginId=od.loginId) ratings,od.orgButtonType FROM login_details ld
                    INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1 AND ld.roleName='School'
                    INNER JOIN school_class_details scd ON scd.loginId=ld.id AND scd.isactive=1
                    INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId
                    LEFT JOIN tbl_financial_details fd ON fd.login_id=od.loginId AND fd.user_type='School'
                    WHERE ld.roleName='School'  $condition $filterCondition " . $this->getLocationCondtion() . " AND  ld.isactive=1 AND ld.verifyStatus=1 AND ld.loginStatus=0 ORDER BY od.loginId DESC");
		$this->db->close();
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetOrgName()
	{
		$orgName = FILTER_VAR(trim($this->input->post('orgName')), FILTER_SANITIZE_STRING);
		$type = FILTER_VAR(trim($this->input->post('type')), FILTER_SANITIZE_STRING);
		$qry = $this->db->query("SELECT od.orgId,od.orgName FROM login_details ld
                                    INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
                                    WHERE ld.isactive=1 AND ld.roleName='" . $type . "' AND ld.verifyStatus=1 and ld.loginStatus=0 and od.orgName LIKE '%" . $orgName . "%'  "); //AND ld.admin_approved

		if ($qry->num_rows() > 0) {
			$result = $qry->result();
		} else {
			$result = "";
		}
		return json_encode($result);
	}

	public function mGetOrgStatesCityNames()
	{
		$type = FILTER_VAR(trim($this->input->post('type')), FILTER_SANITIZE_STRING);
		$roleName = FILTER_VAR(trim($this->input->post('roleName')), FILTER_SANITIZE_STRING);
		$condition = ($type == 'states' ? 'GROUP BY tsts.stateId' : 'GROUP BY cty.cityId');
		$qry = $this->db->query("SELECT GROUP_CONCAT(od.orgId) orgids,cty.name AS cityName,cty.cityId,tsts.stateId,tsts.name stateName FROM organization_details od
                                    INNER JOIN login_details ld ON ld.id=od.loginId AND ld.isactive=1
                                    INNER JOIN states tsts ON tsts.stateId=od.stateId
                                    INNER JOIN cities cty ON cty.cityId=od.cityId
                                    WHERE od.isactive=1 AND ld.roleName='" . $roleName . "' AND ld.verifyStatus=1 and ld.loginStatus=0 $condition");
		if ($qry->num_rows() > 0) {
			$result = $qry->result();
		} else {
			$result = "";
		}
		return json_encode($result);
	}

	//filter by cat end
	//website visitor
	public function mAddsiteVisitor($countryId)
	{
		$ipaddress = $this->getRealIpAddr();
		$cName = "";
		$countryName = $this->db->where('countryId', $countryId)->get('countries');
		if ($countryName->num_rows() > 0) {
			$rowData = $countryName->row();
			$cName = $rowData->name;
		}
		$chkvisitor = $this->db->where(["ipaddress" => $ipaddress, "countryName" => $cName])->get('tbl_website_visitor');
		if ($chkvisitor->num_rows() > 0) {
			$rowData = $chkvisitor->row();
			$tvisits = $rowData->totalVisits;
			$uData = ["totalVisits" => $tvisits + 1, "updatedAt" => $this->datetimenow()];
			$this->db->where("visitorId", $rowData->visitorId)->update("tbl_website_visitor", $uData);
		} else {
			$idata = ["ipaddress" => $ipaddress, "countryName" => $cName,
				"totalVisits" => 1, "createdAt" => $this->datetimenow(),
				"isactive" => 1];
			$this->db->insert("tbl_website_visitor", $idata);
		}
		$this->insertUpdateVisitor();
	}

	private function insertUpdateVisitor()
	{
		$chktotalvisitor = $this->db->where([
			"isactive" => 1,
			"DATE(datenow)" => date('Y-m-d')
		])->get('tbl_totalvisitor');
		if ($chktotalvisitor->num_rows() > 0) {
			$rowData = $chktotalvisitor->row();
			$visitorCount = $rowData->visitorCount;
			$udate = ["visitorCount" => $visitorCount + 1];
			$this->db->where("totalVisitorId", $rowData->totalVisitorId)->update("tbl_totalvisitor", $udate);
		} else {
			$idata = ["visitorCount" => 1, "datenow" => $this->datetimenow(), "isactive" => 1];
			$this->db->insert("tbl_totalvisitor", $idata);
		}
	}

	public function mGetVisitors()
	{
		$webVisitor = $this->db->where("isactive", 1)->get('tbl_website_visitor');
		$totalvisitor = $this->db->where(["isactive" => 1])->get('tbl_totalvisitor');
		if ($webVisitor->num_rows() > 0) {
			$webVisitors = $webVisitor->result();
		}
		if ($totalvisitor->num_rows() > 0) {
			$totalvisitors = $totalvisitor->result();
		}
		$visitors = ["WebVisitor" => $webVisitors, "totalvisitor" => $totalvisitors];
		$totalview = FILTER_VAR(trim($this->input->post('totalview')), FILTER_SANITIZE_STRING);
		if ($totalview) {
			$qry = $this->db->query("SELECT SUM(totalVisits) visitors FROM tbl_website_visitor WHERE isactive=1");
			$result = ($qry->num_rows() > 0 ? $qry->row() : "");
			return json_encode($result);
		} else {
			return json_encode($visitors);
		}
	}

	//website visitor
	//org Visiotr start
	public function mOrgViewCounter()
	{
		$id = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
		if ($id) {
			$loginid = base64_decode($id);
			$chk = $this->db->where(["id" => $loginid, "isactive" => 1])->get("login_details");
			if ($chk->num_rows() > 0) {
				$rowData = $chk->row();
				$visitorCount = $rowData->visitorCount + 1;
				$this->db->where(["id" => $loginid, "isactive" => 1])->update("login_details", ["visitorCount" => $visitorCount]);
			}
		}
	}

	//org Visitor end
	//main header search bar start
	public function mMainheaderFilter()
	{
		$keySearch = FILTER_VAR(trim($this->input->post('keySearch')), FILTER_SANITIZE_STRING);
		$filterWords = explode(" ", $keySearch);
		$searchfor1 = "";
		$searchfor2 = "";
		$searchfor3 = "";
		$searchfor4 = "";
		$searchfor5 = "";
		for ($i = 0; $i < count($filterWords); $i++) {
			$searchfor1 = $searchfor1 . ($i >= 1 ? " OR od.orgName LIKE '%" . $filterWords[$i] . "%'" : " od.orgName LIKE '%" . $filterWords[$i] . "%'");
			$searchfor2 = $searchfor2 . ($i >= 1 ? " OR od.orgAddress LIKE '%" . $filterWords[$i] . "%'" : " od.orgAddress LIKE '%" . $filterWords[$i] . "%'");
			$searchfor3 = $searchfor3 . " " . ($i > 0 ? 'OR' : '') . "   ct.courseType LIKE '%" . $filterWords[$i] . "%' OR cft.FeeType_Name LIKE '%" . $filterWords[$i] . "%'
            OR sd.title LIKE '%" . $filterWords[$i] . "%'  OR cd.title LIKE '%" . $filterWords[$i] . "%' OR td.title LIKE '%" . $filterWords[$i] . "%' OR dt.title LIKE '%" . $filterWords[$i] . "%'";
			$searchfor4 = $searchfor4 . ($i >= 1 ? " OR ic.title LIKE '%" . $filterWords[$i] . "%'" : " ic.title LIKE '%" . $filterWords[$i] . "%'");
			$searchfor5 = $searchfor5 . ($i >= 1 ? " OR sct.title LIKE '%" . $filterWords[$i] . "%'" : " sct.title LIKE '%" . $filterWords[$i] . "%'");
		}
		return $this->searchQuery($searchfor1, $searchfor2, $searchfor3, $searchfor4, $searchfor5, $keySearch);
	}

	public function searchQuery($searchfor1, $searchfor2, $searchfor3, $searchfor4, $searchfor5, $keySearch)
	{
		$qry = $this->db->query("SELECT od.loginId loginids,od.orgName searchterm,ld.roleName,'' courseId FROM login_details ld INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1
            WHERE ld.isactive=1 AND ld.verifyStatus=1 and ld.loginStatus=0 AND (" . $searchfor1 . ") GROUP BY ld.id
    UNION   SELECT od.loginId loginids,od.orgAddress searchterm,ld.roleName,'' courseId FROM login_details ld INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1 WHERE ld.isactive=1
            AND ld.verifyStatus=1 and ld.loginStatus=0 AND (" . $searchfor2 . ") GROUP BY ld.id
    UNION   SELECT GROUP_CONCAT(DISTINCT od.loginId) loginids,IF(ct.courseType LIKE '%$keySearch%',ct.courseType,IF(cft.FeeType_Name LIKE '%$keySearch%',cft.FeeType_Name,IF(sd.title LIKE '%$keySearch%',sd.title,
            IF(cd.title LIKE '%$keySearch%',cd.title,IF(td.title LIKE '%$keySearch%',td.title,IF(dt.title LIKE '%$keySearch%',dt.title,'$keySearch'))))))  searchterm,ld.roleName,os.orgStreamId courseId FROM login_details ld
            INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1 INNER JOIN organization_courses oc ON oc.loginId=ld.id AND oc.isactive=1
            INNER JOIN course_type ct ON ct.ctId=oc.courseTypeId AND oc.isactive=1 INNER JOIN organization_streams os ON os.orgCourseId=oc.orgCourseId AND os.isactive=1
            INNER JOIN course_fee_type cft ON cft.courseFeeType_Id=os.courseFeeType AND cft.isactive=1 INNER JOIN stream_details sd ON sd.streamId=os.streamId AND sd.isactive=1
            INNER JOIN course_details as cd ON cd.cId=oc.courseId INNER JOIN time_duration as td ON td.tdId=oc.courseDurationId INNER JOIN department as dt ON dt.departmentId=oc.departmentId
            WHERE ld.isactive=1 AND ld.verifyStatus=1 and ld.loginStatus=0 AND (" . $searchfor3 . ")
    UNION   SELECT GROUP_CONCAT(DISTINCT od.loginId) loginids,ic.title searchterm,ld.roleName,ic.insCourseId courseId FROM login_details ld
            INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1  INNER JOIN institute_course_details icd ON icd.loginId=ld.id AND icd.isactive=1
            INNER JOIN institute_course ic ON ic.insCourseId=icd.insCourseId AND ic.isactive=1 WHERE ld.isactive=1 AND ld.verifyStatus=1 and ld.loginStatus=0 AND (" . $searchfor4 . ") GROUP BY ic.insCourseId
    UNION   SELECT GROUP_CONCAT(DISTINCT od.loginId) loginids,sct.title searchterm,ld.roleName,scd.sClassId courseId FROM login_details ld
            INNER JOIN organization_details od ON od.loginId=ld.id AND od.isactive=1 INNER JOIN school_class_details scd ON scd.loginId=ld.id AND scd.isactive=1
            INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId AND sct.isactive=1 WHERE ld.isactive=1 AND ld.verifyStatus=1 and ld.loginStatus=0 AND (" . $searchfor5 . ") GROUP BY sct.classTypeId LIMIT 10");

		$response = ($qry->num_rows() > 0 ? $qry->result() : "");

		return json_encode($response);
	}

	//main header search bar end
	//Advertise with Us Start
	public function mOrgNames()
	{
		$keySearch = FILTER_VAR(trim($this->input->post('keySearch')), FILTER_SANITIZE_STRING);
		$qry = $this->db->query("SELECT od.orgId,od.orgName,od.loginId FROM organization_details od
                                INNER JOIN login_details ld on ld.id=od.loginId AND ld.isactive=1
                                WHERE od.isactive=1 AND ld.admin_approved=1 AND ld.verifyStatus=1 AND od.orgName LIKE '%$keySearch%'");
		if ($qry->num_rows() > 0) {
			$result = $qry->result();
		} else {
			$result = "";
		}
		return json_encode($result);
	}

	public function mAdvertisementForm()
	{
		$orgId = FILTER_VAR(trim($this->input->post('orgId')), FILTER_SANITIZE_NUMBER_INT);
		$orgName = FILTER_VAR(trim($this->input->post('orgName')), FILTER_SANITIZE_STRING);
		$firstname = FILTER_VAR(trim($this->input->post('firstname')), FILTER_SANITIZE_STRING);
		$lastName = FILTER_VAR(trim($this->input->post('lastName')), FILTER_SANITIZE_STRING);
		$email = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_EMAIL);
		$phoneNo = FILTER_VAR(trim($this->input->post('phoneNo')), FILTER_SANITIZE_STRING);
		$mobile = FILTER_VAR(trim($this->input->post('mobile')), FILTER_SANITIZE_STRING);
		$comment = FILTER_VAR(trim($this->input->post('comment')), FILTER_SANITIZE_STRING);
		if (empty($firstname) || empty($lastName) || empty($email) || empty($mobile) || empty($comment)) {
			return '{"status" :  "error", "msg":"Required field is empty"}';
		}
		$chk = $this->db->where(["ip_address" => $this->getRealIpAddr(), "email" => $email, "isactive" => 1])->get("tbl_advertiseswithus");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Your Message is already there."}';
		}
		$iData = ["organisation_name" => $orgName, "organisationId" => $orgId, "firstName" => $firstname, "lastName" => $lastName, "email" => $email, "phoneNo" => $phoneNo, "mobile" => $mobile, "comment" => $comment, "createdAt" => $this->datetimenow(), "ip_address" => $this->getRealIpAddr(), "isactive" => 1];
		$res = $this->db->insert("tbl_advertiseswithus", $iData);
		($res ? $this->addActivityLog(0, "AdvertiseWithUs", "tbl_advertiseswithus", "0") : "");
		$emailres = ($res ? $this->sendEmailAdvertisement($email, $comment, $firstname, $lastName) : "");
		return ($res ? '{"status":"success", "msg":"Saved Successful ' . $emailres . ' "}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
	}

	private function sendEmailAdvertisement($email, $comment, $firstname, $lastName)
	{
		$subject = "Hello " . $firstname . " " . $lastName . " your message is successfully submitted.";
		$content = "Hello " . $firstname . " " . $lastName . " Your message " . $comment . " is sent to admin and you will be contacted shortly.";
		$emailS = (isset($_SESSION['websiteEmail']) ? $_SESSION['websiteEmail'] : 'donotreply@ihuntbest.com');
		$senderName = "iHuntBest";
		$resp = $this->sendEmail($emailS, $email, $content, $subject, $senderName);

		return $resp;
	}

	//Advertise with Us End
	//Forgot Student Password Start
	public function mCodegenrations()
	{
		$emailId = FILTER_VAR(trim($this->input->post('emailid')), FILTER_SANITIZE_EMAIL);
		if($this->input->get('type')=="org"){
			$chk = $this->db->where(["email" => $emailId, "isactive" => 1])->get("login_details");
			$type = "Organisation";
		}else{
			$chk = $this->db->where(["email" => $emailId, "isactive" => 1])->get("student_login");
			$type= "Student";
		}

		if ($chk->num_rows() > 0) {
			$rowData = $chk->row();
			$_SESSION['type'] = $type;
			$_SESSION['tmp_primary_id'] = ($type=="Student"?$rowData->studentId:$rowData->id);
			$random_number = mt_rand();
			$senderName = "iHuntBest";
			$subject = "Forgot password code.";
			$body = " Your one time code is: " . $random_number;
			$_SESSION["code"] = $random_number;
			$emailS = (isset($_SESSION['websiteEmail']) ? $_SESSION['websiteEmail'] : 'donotreply@ihuntbest.com');
			$res = $this->sendEmail($emailS, $emailId, $body, $subject, $senderName);
			return ($res == "Sent Successfully" ? '{"status":"success", "msg":"Please check your email."}' : '{"status":"error", "msg":"Sorry Email not Sent try gain."}');
		} else {

			return '{"status":"error", "msg":"Sorry email id is not found."}';
		}
	}

	public function mForgotPasswordCode()
	{
		$newPassword = FILTER_VAR(trim($this->input->post('newPassword')), FILTER_SANITIZE_STRING);
		if (empty($newPassword)) {
			return '{"status":"error", "msg":"Password should not be empty."}';
		}
		$pwd = $this->encryption->encrypt($newPassword);
		if($_SESSION['type']=="Student"){
			$data = ["password" => $newPassword, "password1" => $pwd, "createdAt" => $this->datetimenow(), "isactive" => 1];
			$resp = $this->db->where("studentId", $_SESSION['tmp_primary_id'])->update("student_login", $data);
			($resp ? $this->addActivityLog($_SESSION['tmp_primary_id'], "Password Changed By Student", "student_login", "0") : "");
			unset($_SESSION['code'], $_SESSION['tmp_primary_id']);

		}else{
			$data = ["password" => $newPassword, "password1" => $pwd, "createdAt" => $this->datetimenow(), "isactive" => 1];
			$resp = $this->db->where("id", $_SESSION['tmp_primary_id'])->update("login_details", $data);
			($resp ? $this->addActivityLog($_SESSION['tmp_primary_id'], "Password Changed By Organisation",
				"login_details", "0") : "");
			unset($_SESSION['code'], $_SESSION['tmp_primary_id'],$_SESSION['type']);

		}
		return ($resp ? '{"status":"success", "msg":"Password changed successfully."}' : '{"status":"error", "msg":"Sorry Email not Sent try again."}');
	}

	//Forgot Student Password End
	//OurTeam Start
	public function mGetOurTeam()
	{
		$qry = $this->db->where("isactive", 1)->get("tbl_teammembers");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	//OurTeam End
	//Carrer Start
	public function mGetOeningData()
	{
		$qry = $this->db->where(["isClosed" => 0, "isactive" => 1])->get("tbl_careersopening");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mApplyForJob()
	{
		$firstName = FILTER_VAR(trim($this->input->post('firstName')), FILTER_SANITIZE_STRING);
		$lastName = FILTER_VAR(trim($this->input->post('lastName')), FILTER_SANITIZE_STRING);
		$email = FILTER_VAR(trim($this->input->post('email')), FILTER_SANITIZE_STRING);
		$phone = FILTER_VAR(trim($this->input->post('phone')), FILTER_SANITIZE_STRING);
		$openingId = FILTER_VAR(trim($this->input->post('openingId')), FILTER_SANITIZE_STRING);
		if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($openingId) || !isset($_FILES['resumeFile']['name'])) {
			return '{"status":"error", "msg":"Required field is empty!"}';
		}
		$fileResume = (isset($_FILES['resumeFile']['name']) ? $this->uploadFile($firstName, 'resumeFile') : ["response" => ""]);
		$resumeFile = $fileResume["response"];
		$chk = $this->db->where(["email" => $email, "ipaddress" => $this->getRealIpAddr(), "openingId" => $openingId, "isactive" => 1])->get("tbl_ihuntjobapplication");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate Details!"}';
		} else {
			$idata = ["firstName" => $firstName, "lastName" => $lastName, "email" => $email, "phone" => $phone, "openingId" => $openingId, "resumeFile" => $resumeFile,
				"createdAt" => $this->datetimenow(), "ipaddress" => $this->getRealIpAddr(), "isactive" => 1];
			$resp = $this->db->insert("tbl_ihuntjobapplication", $idata);
			($resp ? $this->addActivityLog(0, "Job Application Submitted By " . $firstName . " ", "tbl_ihuntjobapplication", "0") : "");
			return ($resp ? '{"status":"success", "msg":"Application Submitted successfully."}' : '{"status":"error", "msg":"Sorry there is some error."}');
		}
	}

	public function mEnrollNow()
	{
		if (!isset($_SESSION['studentId'])) {
			return '{"status":"error", "msg":"Session Ended login again!"}';
		}
		/* echo "<pre>";
		print_r($_POST);
		echo "</pre>"; 		
		die; */
		$orgCourseId = FILTER_VAR(trim($_SESSION['course_id']), FILTER_SANITIZE_STRING);
		$courseId = FILTER_VAR(trim($_SESSION['course_s_id']), FILTER_SANITIZE_STRING);
		$orgType = FILTER_VAR(trim($_SESSION['orgType']), FILTER_SANITIZE_STRING);
		//$payment_id = FILTER_VAR(trim($_SESSION['razorpay_payment_id']), FILTER_SANITIZE_STRING);
		if (empty($orgCourseId) || empty($orgType)) {
			return '{"status":"error", "msg":"Required field is empty!"}';
		}
		$condition = (($orgType == 'University' || $orgType == 'College') ? ["orgStreamId" => $courseId] : ($orgType == 'Institute' ? ["insCourseDetailsId" => $orgCourseId] : ($orgType == 'School' ? ["sClassId" => $orgCourseId] : [])));
		$cmn = ["studentId" => $_SESSION['studentId'], "isactive" => 1];
		
		if($orgType == 'University' || $orgType == 'College'){
			$organization_info_query = "SELECT * FROM organization_streams WHERE orgStreamId=$courseId"; 
			$org_result = $this->db->query($organization_info_query)->result();
			$loginid = $org_result[0]->loginId;
			if(isset($loginid)){
				$organization_detail_query = "SELECT * FROM organization_details WHERE loginId =$loginid"; 
				$org_details = $this->db->query($organization_detail_query)->result();
				$orgname = $org_details[0]->orgName ;
			}
		}else {
			if($orgType == 'Institute'){
			$organization_info_query = "SELECT * FROM institute_course_details WHERE insCourseDetailsId=$orgCourseId";
			$org_result = $this->db->query($organization_info_query)->result();
			$loginid = $org_result[0]->loginId;
			if(isset($loginid)){
				$organization_detail_query = "SELECT * FROM organization_details WHERE loginId =$loginid"; 
				$org_details = $this->db->query($organization_detail_query)->result();
				$orgname = $org_details[0]->orgName ;
			  }
		    }else if($orgType == 'School'){
				$organization_info_query = "SELECT * FROM school_class_details WHERE sClassId=$orgCourseId";
				$org_result = $this->db->query($organization_info_query)->result();
				$loginid = $org_result[0]->loginId;
				if(isset($loginid)){
					$organization_detail_query = "SELECT * FROM organization_details WHERE loginId =$loginid"; 
					$org_details = $this->db->query($organization_detail_query)->result();
					$orgname = $org_details[0]->orgName ;
				  }else{
					  $orgname="";
				  }
			}
	     }

		$chk = $this->db->where(array_merge($cmn, $condition))->get("tbl_enroll");
		// if ($chk->num_rows() > 0)
		// {
			// return '{"status":"error", "msg":"You have already enrolled for this course!"}';
		// }
		
		$idata = ["studentId" => $_SESSION['studentId'], "status" => "Enrolled", "createdAt" => $this->datetimenow(), 'isactive' => 1,'payment_id' => $_SESSION['razorpay_payment_id'] ];
		$fidata = array_merge($condition, $idata);
		
		
		$enroll = $this->db->insert("tbl_enroll", $fidata);
		$enrollmentId = $this->db->insert_id();
		if(isset($_SESSION['studentId'])){
				$student_info_query = "SELECT * FROM student_details WHERE studentId=".$_SESSION['studentId']; 
				$result = $this->db->query($student_info_query)->result();
				$studentname = $result[0]->studentName ;
		}
		$tdata = ["enrollmentId" => $enrollmentId, "org_amt" => 0, "ihunt_amt" =>$_SESSION['amount'] ,"payment_id" => $_SESSION['razorpay_payment_id'],"student_name"=>$studentname,"org_name"=>$orgname,"fees_category"=>"Application Fee","createdAt"=> $this->datetimenow()];
		$transaction = $this->db->insert("tbl_transactions", $tdata);
	
		($enroll ? $this->addActivityLog(0, "Enrollment to " . $orgType . " done", "tbl_enroll", "0") : "");
				
		return $enroll;
				
		// return ($enroll ? '{"status":"success", "msg":"You have enrolled successfully!"}' : '{"status":"error", "msg":"Sorry there is some error try again!"}');
	}

	private function uploadFile($firstName, $fileName)
	{
		$this->createDirectory('./uploadedDocuments/jobApplications/' . date('Y') . '/' . date('m'));
		$config['upload_path'] = './uploadedDocuments/jobApplications/' . date('Y') . '/' . date('m');
		$config['allowed_types'] = 'pdf|PDF|doc|DOC|docx|DOCX';
		$config['file_name'] = preg_replace("/\s+/", "_", $firstName) . strtotime(date('Y-m-d h:i:s'));
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($fileName)) {
			$error = array('error' => $this->upload->display_errors());
			$response = ["response" => $error, "status" => "error"];

			return $response;
		} else {
			$data = $this->upload->data('file_name');
			$fileName = 'uploadedDocuments/jobApplications/' . date('Y') . '/' . date('m') . '/' . $data;
			$response = ["response" => $fileName, "status" => "success"];

			return $response;
		}
	}

	private function createDirectory($path)
	{
		if (!file_exists($path)) {
			mkdir($path, 0755, true);

			return 'created';
		} else {
			return 'present';
		}
	}

	//Carrer End
	//FAQ Start
	public function mGetfaq()
	{
		$qry = $this->db->query("SELECT * FROM tbl_faq WHERE isactive=1 order by faqCategoryId desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetfaqCategories()
	{
		$qry = $this->db->query("SELECT * FROM tbl_faq_category WHERE isactive=1 order by faqCategoryId desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	//FAQ End
	//Org Types start
	public function mgetOrgTypes()
	{
		$qry = $this->db->where("isactive", 1)->select("orgTypeId,typeName")->get("orgtype");
		if ($qry->num_rows() > 0) {
			foreach ($qry->result() as $qr) {
				$qr->orgTypeId = base64_encode($qr->orgTypeId);
			}
			$result = $qry->result();
		} else {
			$result = "";
		}
		return json_encode($result);
	}

	//Org Types end

	private function sendEmail($emailSender, $emailReceiver, $body, $subject, $senderName)
	{
		try{
			/*$config     =   ['protocol'=>'sendmail', 'charset'=>'iso-8859-1','wordwrap'=>TRUE,'validate'=>TRUE];
			$this->email->initialize($config);*/
			$this->email->from($emailSender, $senderName);
			$this->email->to($emailReceiver);
			//$this->email->cc('another@another-example.com');
			$this->email->bcc('vermamanish4u@gmail.com');
			$this->email->subject($subject);
			$this->email->message($body);
			$res = $this->email->send();

			return ($res ? "Sent Successfully" : "Sending Failed");
		}catch (\Exception $ex){
			return $ex->getMessage();
		}

	}

	public function mReligion()
	{
		$qry = $this->db->where("isactive", 1)->order_by("religionName", "asc")->get("tbl_religions");
		$result = ($qry->num_rows() > 0 ? $qry->result() : "");
		return json_encode($result);
	}

	public function mGetClassNames()
	{
		$classnamesId = FILTER_VAR(trim($this->input->post('id')), FILTER_SANITIZE_STRING);
		$condtion = ($classnamesId ? ["classnamesId" => $classnamesId, 'isactive' => 1] : ['isactive' => 1]);
		$qry = $this->db->where($condtion)->get('tbl_classnames');
		$result = ($qry->num_rows() > 1 ? $qry->result() : $qry->row());
		return json_encode($result);
	}

	public function mGetCourseFeeType()
	{
		$qry = $this->db->where("isactive", 1)->select("courseFeeType_Id,FeeType_Name")->get("course_fee_type");

		$result = ($qry->num_rows() > 0 ? $qry->result() : "");
		return json_encode($result);
	}

	public function mGetSchoolClassType()
	{
		if (!isset($_SESSION['loginId'])) {
			return '{"status":"error", "msg":"Un authorised login!"}';
		} else {
			$qry = $this->db->where("isactive", 1)->get("school_class_type");
			if ($qry->num_rows() > 0) {
				$result = $qry->result();
			} else {
				$result = '';
			}
			return json_encode($result);
		}
	}

	public function datetimenow()
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
		$todaydate = $date->format('Y-m-d H:i:s');

		return $todaydate;
	}

	public function getRealIpAddr()
	{
		if (!empty($_SERVER['REMOTE_ADDR'])) {   //check ip from share internet
			$ip = $_SERVER['REMOTE_ADDR'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['SERVER_ADDR'];
		}

		return $ip;
	}

	public function mGettestimonial()
	{
		$qry = $this->db->query("SELECT * FROM tbl_testimonial WHERE isactive=1 order by testimonialId desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetblogsCategories()
	{
		$qry = $this->db->query("SELECT * FROM tbl_blog_cat WHERE isActive=1 order by catId desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}

	public function mGetblogs()
	{
		$qry = $this->db->query("SELECT * FROM tbl_blog WHERE blogStatus=1 order by updatedAt desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	/////////////////////////////////////////////////////////////////////////////
		public function mGetgenesis()
	{
		$qry = $this->db->query("SELECT * FROM tbl_genesis WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetPressRelease()
	{
		$qry = $this->db->query("SELECT * FROM tbl_pressRelease  WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetIhuntBestCares()
	{
		$qry = $this->db->query("SELECT * FROM tbl_ihuntBestCares WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetGiftSmile()
	{
		$qry = $this->db->query("SELECT * FROM tbl_giftSmile WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetServices()
	{
		$qry = $this->db->query("SELECT * FROM tbl_services WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetIhuntBestStories()
	{
		$qry = $this->db->query("SELECT * FROM tbl_ihuntBestStories WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetSupport()
	{
		$qry = $this->db->query("SELECT * FROM tbl_support WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetPaymentsSaved()
	{
		$qry = $this->db->query("SELECT * FROM tbl_paymentsSaved WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetCardsShipping()
	{
		$qry = $this->db->query("SELECT * FROM tbl_cardsShipping WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}
	
		public function mGetCancelAndReturn()
	{
		$qry = $this->db->query("SELECT * FROM tbl_cancelReturn WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
	}////////////////////////////////////////////////////
			public function mGetReportInfringement()
			{
		$qry = $this->db->query("SELECT * FROM tbl_reportInfringement WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetWriteToUs()
			{
		$qry = $this->db->query("SELECT * FROM tbl_writeToUs WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetOnlineShopping()
			{
		$qry = $this->db->query("SELECT * FROM tbl_onlnShpng WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetAffiliateProgram()
			{
		$qry = $this->db->query("SELECT * FROM tbl_affiliateProgram WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetGiftCardOffer()
			{
		$qry = $this->db->query("SELECT * FROM tbl_giftCardOffer WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetFirstSubscription()
			{
		$qry = $this->db->query("SELECT * FROM tbl_firstSubscription WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetSiteMap()
			{
		$qry = $this->db->query("SELECT * FROM tbl_siteMap WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetReturnPolicy()
			{
		$qry = $this->db->query("SELECT * FROM tbl_returnPolicy WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetTermsOfUse()
			{
		$qry = $this->db->query("SELECT * FROM tbl_termsOfUse WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetSecurityPolicy()
			{
		$qry = $this->db->query("SELECT * FROM tbl_securityPolicy WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
			
			public function mGetShowBrandEmpowerment()
			{
		$qry = $this->db->query("SELECT * FROM tbl_brandEmpowerment WHERE isactive=1 order by updatedOn desc");
		if ($qry->num_rows() > 0) {
			return $qry->result();
		} else {
			return false;
		}
			}
	
	/////////////////////////////////////////////////////////////////////////

	public function mGetCourseName()
	{
		$type = FILTER_VAR(trim($this->input->post('orgType')), FILTER_SANITIZE_STRING);
		$result = '';
		$this->load->model("CourseMasterModel");
		if ($type == "University") {
			$result  = $this->CourseMasterModel->getOrgCourses($type);
			//$result = $this->universityCollegeCourseNames($type);
		} else if ($type == "College") {
			$result  = $this->CourseMasterModel->getOrgCourses($type);
			//$result = $this->universityCollegeCourseNames($type);
		} else if ($type == "Institute") {
			$result  = $this->CourseMasterModel->getOrgCourses($type);
			//$result = $this->InstituteCourseNames();
		} else if ($type == "School") {
			$result  = $this->CourseMasterModel->getOrgCourses($type);
			//$result = $this->schoolCourseNames();
		} else {
			return 'Unautorised access';
		}
		if ($result->num_rows() > 0) {
			return json_encode($result->result());
		}
	}

	private function universityCollegeCourseNames($type)
	{
		return $this->db->query("SELECT sd.streamId loginIds,CONCAT(cd.title,' ',sd.title,'(',td.title,') ',ct.courseType ) courseName  FROM organization_streams as os
                                INNER JOIN organization_courses as oc ON oc.orgCourseId=os.orgCourseId
                                INNER JOIN course_type as ct ON ct.ctId=oc.courseTypeId
                                INNER JOIN course_details as cd ON cd.cId=oc.courseId
                                INNER JOIN time_duration as td ON td.tdId=oc.courseDurationId
                                INNER JOIN stream_details as sd ON sd.streamId=os.streamId
                                INNER JOIN login_details ld ON ld.id=oc.loginId
                                WHERE os.isactive=1 AND ld.roleName='" . $type . "' GROUP by courseName");
	}

	private function InstituteCourseNames()
	{
		return $this->db->query("SELECT (ic.insCourseId) loginIds,CONCAT(ic.title,' ','(',td.title,') ',icd.courseDurationType ) courseName   FROM institute_course_details icd
                        INNER JOIN institute_course ic ON ic.insCourseId=icd.insCourseId AND ic.isactive=1
                        INNER JOIN time_duration td ON td.tdId=icd.timeDurationId AND td.isactive=1
                        WHERE icd.isactive=1 GROUP by courseName");
	}

	private function schoolCourseNames()
	{
		return $this->db->query("SELECT (scd.sClassId) loginIds,CONCAT(scd.class,' ','(',sct.title,') ',scd.courseDurationType ) courseName   FROM school_class_details scd
                        INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId AND sct.isactive=1
                        WHERE scd.isactive=1 GROUP by courseName");
	}

	public function mSetCountrys($country_code)
	{
		$countryData = $this->db->query('SELECT * FROM countries WHERE countryId = ' . $country_code . '');

		if ($countryData->num_rows() > 0) {
			$contryCodes = $countryData->row();
			$_SESSION['countryId'] = $contryCodes->countryId;

			return "done";
		} else {
			return "countrynotfound";
		}
	}

	public function mlocationSearch()
	{
		$location = FILTER_VAR(trim($this->input->post('keySearch')), FILTER_SANITIZE_STRING);
		$orgType = FILTER_VAR(trim($this->input->post('orgType')), FILTER_SANITIZE_STRING);
		if (!empty($orgType) && !empty($location)) {
			if ($orgType == "University" || $orgType == "College") {
				$result = $this->getLocationsUnivCollege($orgType, $location);
			} else if ($orgType == "Institute") {
				$result = $this->getLocationsInstitute($location);
			} else if ($orgType == "School") {
				$result = $this->getLocationsSchool($location);
			} else {
				$result = "";
			}
		} else {
			$result = "";
		}
		if ($result) {
			if ($result->num_rows() > 0) {
				return json_encode($result->result());
			}
		}
	}

	private function getLocationsUnivCollege($orgType, $location)
	{
		return $this->db->query("SELECT GROUP_CONCAT(oc.loginId) loginIds,od.orgAddress  FROM organization_streams as os
                                INNER JOIN organization_courses as oc ON oc.orgCourseId=os.orgCourseId
                                INNER JOIN course_type as ct ON ct.ctId=oc.courseTypeId
                                INNER JOIN course_details as cd ON cd.cId=oc.courseId
                                INNER JOIN time_duration as td ON td.tdId=oc.courseDurationId
                                INNER JOIN stream_details as sd ON sd.streamId=os.streamId
                                INNER JOIN login_details ld ON ld.id=oc.loginId
                                INNER JOIN organization_details od ON ld.id=od.loginId AND od.isactive=1
                                WHERE os.isactive=1 AND ld.roleName='$orgType' AND od.orgAddress LIKE '%$location%' GROUP by orgAddress LIMIT 10");
	}

	private function getLocationsInstitute($location)
	{
		return $this->db->query("SELECT (icd.loginId) loginIds,od.orgAddress   FROM institute_course_details icd
                        INNER JOIN institute_course ic ON ic.insCourseId=icd.insCourseId AND ic.isactive=1
                        INNER JOIN time_duration td ON td.tdId=icd.timeDurationId AND td.isactive=1
                        INNER JOIN organization_details od ON od.loginId=icd.loginId AND od.isactive=1
                        WHERE icd.isactive=1  AND od.orgAddress LIKE '%$location%' GROUP by orgAddress LIMIT 10");
	}

	private function getLocationsSchool($location)
	{
		return $this->db->query("SELECT (scd.loginId) loginIds,od.orgAddress FROM school_class_details scd
                        INNER JOIN school_class_type sct ON sct.classTypeId=scd.classTypeId AND sct.isactive=1
                        INNER JOIN organization_details od ON od.loginId=scd.loginId AND od.isactive=1
                        WHERE scd.isactive=1  AND  od.orgAddress LIKE '%$location%' GROUP by orgAddress LIMIT 10");
	}

	//enquiry now start
	public function menquiryNow()
	{
		$type = FILTER_VAR(trim($this->input->post('orgType')), FILTER_SANITIZE_STRING);
		$orgCourseId = FILTER_VAR(trim($this->input->post('orgCourseId')), FILTER_SANITIZE_STRING);
		$courseId = FILTER_VAR(trim($this->input->post('courseId')), FILTER_SANITIZE_STRING);
		$senderName = FILTER_VAR(trim($this->input->post('senderName')), FILTER_SANITIZE_STRING);
		$emailSender = FILTER_VAR(trim($this->input->post('emailSender')), FILTER_SANITIZE_STRING);
		$contactSender = FILTER_VAR(trim($this->input->post('contactSender')), FILTER_SANITIZE_STRING);
		$enqmessage = FILTER_VAR(trim($this->input->post('enqmessage')), FILTER_SANITIZE_STRING);
		if (empty($senderName) || empty($type) || empty($emailSender) || empty($contactSender) || empty($enqmessage) || empty($courseId)) {
			return '{"status":"error", "msg":"Required field is empty"}';
		}
		$course = ($type == "University" || $type == "College" ? ["orgStreamId" => $courseId] : ($type == "Institute" ? ["insCourseDetailsId" => $orgCourseId] : ($type == "School" ? ["sClassId" => $orgCourseId] : "")));
		$condition = ["status" => "Sent", "senderName" => $senderName, "email" => $emailSender, "contact" => $contactSender, "message" => $enqmessage, "date" => date('Y-m-d'), "createdAt" => $this->datetimenow(), "ipAddress" => $this->getRealIpAddr(), 'isactive' => 1];
		$chkarr = array_merge($condition, $course);
		$chk = $this->db->where($chkarr)->get("tbl_course_enquiry");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate Details"}';
		} else {
			return $this->insertEnquiry($chkarr, $type, $senderName, $emailSender);
		}
	}

	private function insertEnquiry($chkarr, $type, $senderName, $emailReceiver)
	{

		if (isset($_SESSION['studentId'])) {
			$idata = array_merge($chkarr, ["studentId" => $_SESSION['studentId']]);
		} else {
			$idata = $chkarr;
		}
		$resp = $this->db->insert("tbl_course_enquiry", $idata);
		$emailSender = (isset($_SESSION['websiteEmail']) ? $_SESSION['websiteEmail'] : 'donotreply@ihuntbest.com');
		$emailsName = "iHuntBest";
		$subject = "Enquiry Confirmation";
		$body = "Thank you for enquiry,<br> Your message has been sent successfully.";
		($resp ? $this->sendEmail($emailSender, $emailReceiver, $body, $subject, $emailsName) : "");
		($resp ? $this->addActivityLog($_SESSION['loginId'], "New enquiry for " . $type . "  by " . $senderName . "", "tbl_course_enquiry", "0") : "");
		return ($resp ? '{"status":"success", "msg":"Saved Successfully."}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
	}

//enquiry now end
	//Marking System Start
	public function mGetMarkingType()
	{
		$qry = $this->db->where(["isactive" => 1])->order_by("markingTitle", "asc")->get("tbl_markingsystem");

		if ($qry->num_rows() > 0) {
			$result = $qry->result();
		} else {
			$result = "";
		}
		return json_encode($result);
	}

	public function mAddMarkingType()
	{
		$markingTitle = FILTER_VAR(trim($this->input->post('newMarkingType')), FILTER_SANITIZE_STRING);
		if (empty($markingTitle) && !isset($_SESSION["loginId"])) {
			return '{"status":"error", "msg":"Empty details."}';
		}
		$qry = $this->db->where(["markingTitle" => $markingTitle, "isactive" => 1])->get("tbl_markingsystem");
		if ($qry->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate details."}';
		} else {
			$idata = ["markingTitle" => ucwords(strtolower($markingTitle)), "addedOn" => $this->datetimenow(), "isactive" => 1];
			$resp = $this->db->insert("tbl_markingsystem", $idata);
			($resp ? $this->addActivityLog($_SESSION['loginId'], "Marking Type " . ucwords(strtolower($markingTitle)) . " added by " . $_SESSION['orgName'] . "", "tbl_markingsystem", "0") : "");
			return ($resp ? '{"status":"success", "msg":"Saved Successfully."}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
		}
	}

	//Marking System End
	//Add Competitive Exam Details Start
	public function mAddCompetitiveExamDetails()
	{
		$countryId = FILTER_VAR(trim($this->input->post('countryId')), FILTER_SANITIZE_STRING);
		$exam_name = FILTER_VAR(trim($this->input->post('exam_name')), FILTER_SANITIZE_STRING);
		$marking_system = FILTER_VAR(trim($this->input->post('marking_system')), FILTER_SANITIZE_STRING);
		$validity_time = FILTER_VAR(trim($this->input->post('validity_time')), FILTER_SANITIZE_STRING);
		$typeOfexam = FILTER_VAR(trim($this->input->post('typeOfexam')), FILTER_SANITIZE_STRING);
		if (empty($countryId) || empty($exam_name) || empty($marking_system) || empty($validity_time) || empty($typeOfexam) || !isset($_SESSION['loginId'])) {
			return '{"status":"error", "msg":"Required details are empty."}';
		}

		$chk = $this->db->where(['country_id' => $countryId, 'exam_name' => $exam_name, 'isactive' => 1])->get("tbl_competitive_exam_master");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate details."}';
		} else {
			$iData = ['country_id' => $countryId, 'exam_name' => $exam_name, 'marking_system' => $marking_system,
				'exam_valid_for' => $validity_time, 'exam_type' => $typeOfexam, 'createdAt' => $this->datetimenow(), 'isactive' => 1];
			$res = $this->db->insert("tbl_competitive_exam_master", $iData);
			($res ? $this->addActivityLog($_SESSION['loginId'], "Competitive Exam Details Inserted By " . $_SESSION['orgName'] . "", "tbl_competitive_exam_master", "0") : "");
			return ($res ? '{"status":"success", "msg":"Saved Successfully."}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
		}
	}

	//Add Competitive Exam Details End
	//Add Subject Details Start
	public function mAddSubjectDetails()
	{
		$subjectTitle = FILTER_VAR(trim($this->input->post('SubjectName')), FILTER_SANITIZE_STRING);
		if (empty($subjectTitle) || !isset($_SESSION['loginId'])) {
			return '{"status":"error", "msg":"Required details are empty."}';
		}
		$chk = $this->db->where(["subjectTitle" => $subjectTitle, "isactive" => 1])->get("tbl_subjectmaster");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate details."}';
		} else {
			$idata = ["subjectTitle" => $subjectTitle, "createdAt" => $this->datetimenow(), "createdByIp" => $this->getRealIpAddr(), "isactive" => 1];
			$resp = $this->db->insert("tbl_subjectmaster", $idata);
			($resp ? $this->addActivityLog($_SESSION['loginId'], "Subject details inserted by " . $_SESSION['orgName'] . "", "tbl_subjectmaster", "0") : '');
			return ($resp ? '{"status":"success", "msg":"Added Successfully."}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
		}
	}

	//Add Subject Details End
	//Add Class Name Start
	public function mAddNewClass()
	{
		$newClassName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('newClassName')))), FILTER_SANITIZE_STRING);
		if (!isset($_SESSION['loginId']) || empty($newClassName)) {
			return '{"status":"error", "msg":"Empty Details!"}';
		}
		$chk = $this->db->query("select * from tbl_classnames where isactive=1 and (classTitle='" . $newClassName . "' OR classTitle='" . strtolower($newClassName) . "' OR classTitle='" . strtoupper($newClassName) . "')");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate Details!"}';
		} else {
			$idata = ["classTitle" => $newClassName, "isactive" => 1];
			$resp = $this->db->insert("tbl_classnames", $idata);
			($resp ? $this->addActivityLog($_SESSION['loginId'], "New Class prerequiste Inserted by " . $_SESSION['orgName'], "tbl_classnames", "0") : "");
			return ($resp ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
		}
	}

	//Add Class Name End
	//Add Class Stream Start
	public function mAddClassType()
	{
		$class = FILTER_VAR(trim($this->input->post('class')), FILTER_SANITIZE_STRING);
		$ClassTypeName = FILTER_VAR(trim(ucwords(strtolower($this->input->post('ClassTypeName')))), FILTER_SANITIZE_STRING);
		if (!isset($_SESSION['loginId']) || empty($class) || empty($ClassTypeName)) {
			return '{"status":"error", "msg":"Empty Details!"}';
		}
		$chk = $this->db->where(["classTitle" => $class, "isactive" => 1])->get("tbl_classnames");
		if ($chk->num_rows() > 0) {
			$classnamesId = $chk->row()->classnamesId;
		} else {
			return '{"status":"error", "msg":"Class Details not found."}';
		}
		$chksct = $this->db->where(["classnamesId" => $classnamesId, "title" => $ClassTypeName, "isactive" => 1])->get("school_class_type");
		if ($chksct->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate Class Type Details."}';
		} else {
			$idata = ["class" => $class, "classnamesId" => $classnamesId, "title" => $ClassTypeName, "createdAt" => $this->datetimenow(), "isactive" => 1];
			$resp = $this->db->insert("school_class_type", $idata);
			($resp ? $this->addActivityLog($_SESSION['loginId'], "New Class Type $ClassTypeName Inserted by " . $_SESSION['orgName'], "school_class_type", "0") : "");
			return ($resp ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
		}
	}

	//Add Class Stream End
	//Add Course Name Start
	public function mAddCourseName($courseType, $CourseName, $StreamName)
	{
	    if (!isset($_SESSION['loginId']) || empty($courseType) || empty($CourseName) || empty($StreamName)) {
			return '{"status":"error", "msg":"Empty Details!"}';
		}
		$chkCType = $this->db->where(["ctId" => $courseType, "isactive" => 1])->get("course_type");
		if ($chkCType->num_rows() == 0) {
			return '{"status":"error", "msg":"Course type not found!"}';
		}
		$chkCourseName = $this->db->where(["ctId" => $courseType, "title" => $CourseName, "isactive" => 1])->get("course_details");
		if ($chkCourseName->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate course name!"}';
		}
		$idata = ["ctId" => $courseType, "title" => $CourseName, "requestStatus" => 1, "loginid" => $_SESSION['loginId'], "createdAt" => $this->datetimenow(), "isactive" => 1];
		$this->db->insert("course_details", $idata);
		$cId = $this->db->insert_id();
		if ($cId != "") {
			return $this->mAddCourseStream($cId, $CourseName, $StreamName);
		}
	}

	private function mAddCourseStream($cId, $CourseName, $StreamName)
	{

		($cId ? $this->addActivityLog($_SESSION['loginId'], "New Course Name $CourseName Inserted by " . $_SESSION['orgName'], "course_details", "0") : "");
		$chkStream = $this->db->where(["cId" => $cId, "title" => $StreamName, "isactive" => 1])->get("stream_details");

		if ($chkStream->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate stream name!"}';
		} else {
			$isdata = ["cId" => $cId, "title" => $StreamName, "requestStatus" => 1, "loginid" => $_SESSION['loginId'], "createdAt" => $this->datetimenow(), "isactive" => 1];
			$res = $this->db->insert("stream_details", $isdata);
			($res ? $this->addActivityLog($_SESSION['loginId'], "New Stream Type $StreamName Inserted by " . $_SESSION['orgName'], "stream_details", "0") : "");
			return ($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
		}
	}

	//Add Course Name End
	//Add Exam Mode Start
	public function mGetExamMode()
	{
		$qry = $this->db->where(["isactive" => 1])->get("tbl_exam_mode");
		$result = ($qry->num_rows() > 0 ? $qry->result() : "");
		return json_encode($result);
	}

	public function mAddExamMode()
	{
		$title = FILTER_VAR(trim($this->input->post('examMode')), FILTER_SANITIZE_STRING);
		if (!isset($_SESSION['loginId']) || empty($title)) {
			return '{"status":"error", "msg":"Empty Details!"}';
		}
		$chk = $this->db->where(["title" => $title, "isactive" => 1])->get("tbl_exam_mode");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate Details!"}';
		}
		$iData = ["title" => $title, "approved" => 0, "loginId" => $_SESSION['loginId'], "type" => $_SESSION['userType'], "createdOn" => $this->datetimenow(), "isactive" => 1];

		$res = $this->db->insert("tbl_exam_mode", $iData);
		($res ? $this->addActivityLog($_SESSION['loginId'], "New Exam Mode $title Inserted by " . $_SESSION['orgName'], "tbl_exam_mode", "0") : "");
		return ($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
	}

	//Add Exam Mode End
	//Fee Cycle Start
	public function mAddFeeCycles()
	{
		$title = FILTER_VAR(trim($this->input->post('feeCycleTitle')), FILTER_SANITIZE_STRING);
		if (!isset($_SESSION['loginId']) || empty($title)) {
			return '{"status":"error", "msg":"Empty Details!"}';
		}
		$chk = $this->db->where(["title" => $title, "isactive" => 1])->get("tbl_feecycle");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate Details!"}';
		}
		$iData = ["title" => $title, "approved" => 0, "loginId" => $_SESSION['loginId'], "type" => $_SESSION['userType'], "ip" => $this->getRealIpAddr(), "createdAt" => $this->datetimenow(), "isactive" => 1];

		$res = $this->db->insert("tbl_feecycle", $iData);
		($res ? $this->addActivityLog($_SESSION['loginId'], "New Fee Cycle $title Inserted by " . $_SESSION['orgName'], "tbl_feecycle", "0") : "");
		return ($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
	}

	public function mGetFeeCycle()
	{
		$qry = $this->db->where(["isactive" => 1])->get("tbl_feecycle");
		$result = ($qry->num_rows() > 0 ? $qry->result() : "");
		return json_encode($result);
	}

	//Fee Cycle End
	//MinQual Stream Start
	public function mGetminQualSteam()
	{
		$courseId = FILTER_VAR(trim($this->input->post('courseId')), FILTER_SANITIZE_STRING);
		$tableName = FILTER_VAR(trim($this->input->post('tableName')), FILTER_SANITIZE_STRING);
		if (!isset($_SESSION['loginId']) || empty($courseId) || empty($tableName)) {
			return '{"status":"error", "msg":"Empty Details!"}';
		}
		if ($tableName === "tbl_classnames") {
			$qry = $this->db->query("SELECT classTypeId minqualstreamId,title streamTitle,'school_class_type' tableName FROM school_class_type WHERE classnamesId=$courseId AND isactive=1");
			$result = ($qry->num_rows() > 0 ? $qry->result() : "");
		} else if ($tableName === "tbl_competitive_exam_master" || $tableName === "tbl_subjectmaster") {
			$result = "";
		} else if ($tableName === "course_details") {
			$qry = $this->db->query("SELECT streamId minqualstreamId,title streamTitle,'stream_details' tableName FROM stream_details WHERE cId=$courseId AND isactive=1");
			$result = ($qry->num_rows() > 0 ? $qry->result() : "");
		} else {
			$result = "";
		}
		return json_encode($result);
	}

	//Minqual stream end
	//Add Institute Course Name Start
	public function mAddInstituteCourseName()
	{
		$newCourseType = FILTER_VAR(trim($this->input->post('CourseName')), FILTER_SANITIZE_STRING);
		if (empty($newCourseType) || !isset($_SESSION['loginId'])) {
			return '{"status":"error", "msg":"Required field is empty!"}';
		}
		$CourseType = ucwords(strtolower($newCourseType));
		$chk = $this->db->where(["title" => $CourseType, "isactive" => 1])->get("institute_course");
		if ($chk->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate records!"}';
		}
		$idata = ["title" => $CourseType, "createdBy" => $_SESSION['orgName'] . '^' . $_SESSION['loginId'], "isactive" => 1];
		$res = $this->db->insert("institute_course", $idata);
		($res ? $this->addActivityLog($_SESSION['loginId'], "Institute Course type Inserted by " . $_SESSION['orgName'], "institute_course", "0") : "");
		return ($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
	}

	//Add Institute Course Name End
	//
	public function mGetcourseTypeBycourse()
	{
		$ctId = FILTER_VAR(trim($this->input->post('ctId')), FILTER_SANITIZE_STRING);
		if ($ctId) {
			$condition = " AND ctId=$ctId";
		} else {
			$condition = "";
		}
		if (!isset($_SESSION['loginId'])) {
			return '{"status":"error", "msg":"Unauthorised access!"}';
		}
		$qry = $this->db->query("SELECT * FROM  course_details WHERE isactive=1 $condition order by title desc");
		if ($qry->num_rows() > 0) {
			$response = $qry->result();
		} else {
			$response = "";
		}
		return json_encode($response);
	}

	//Add Course Stream Name Start
	public function mAddCourseStreamName($courseType, $CourseName, $StreamName)
	{

		if (!isset($_SESSION['loginId']) || empty($courseType) || empty($CourseName) || empty($StreamName)) {
			return '{"status":"error", "msg":"Empty Details!"}';
		}
		$chkCType = $this->db->where(["ctId" => $courseType, "isactive" => 1])->get("course_type");
		if ($chkCType->num_rows() == 0) {
			return '{"status":"error", "msg":"Course type not found!"}';
		}
		$chkCourseName = $this->db->where(["ctId" => $courseType, "cId" => $CourseName, "isactive" => 1])->get("course_details");
		if ($chkCourseName->num_rows() == 0) {
			return '{"status":"error", "msg":"Course name not found!"}';
		}
		$chkStream = $this->db->where(["cId" => $CourseName, "title" => $StreamName, "isactive" => 1])->get("stream_details");
		if ($chkStream->num_rows() > 0) {
			return '{"status":"error", "msg":"Duplicate stream name!"}';
		} else {
			$isdata = ["cId" => $CourseName, "title" => $StreamName, "requestStatus" => 1, "loginid" => $_SESSION['loginId'], "createdAt" => $this->datetimenow(), "isactive" => 1];
			$res = $this->db->insert("stream_details", $isdata);
			($res ? $this->addActivityLog($_SESSION['loginId'], "New Stream Type $StreamName Inserted by " . $_SESSION['orgName'], "stream_details", "0") : "");
			return ($res ? '{"status":"success", "msg":"Saved Successfully"}' : '{"status":"error", "msg":"Error in server, please contact admin!"}');
		}
	}

	//Add Course Stream Name End
	//Activity Log Start
	private function addActivityLog($user_id, $activity, $act_table, $isadmin)
	{
		$idata = ["user_id" => $user_id, "activity" => $activity, "act_table" => $act_table, "date" => date('Y-m-d'),
			"isadmin" => 0, "role_name" => "HomePage", "created_at" => $this->datetimenow(), "ip_address" => $this->getRealIpAddr(), "isactive" => 1];
		$this->db->insert("activity_log", $idata);
	}

	/**
	 *
	 * @return String
	 */
	private function getLocationCondtion()
	{
		$condition = (isset($_SESSION["countryId"]) ? " AND od.countryId=" . $_SESSION["countryId"] . "" : "");
		$condition .= (isset($_SESSION["stateId"]) ? " AND od.stateId=" . $_SESSION["stateId"] . "" : "");
		$condition .= (isset($_SESSION["cityId"]) ? " AND od.cityId=" . $_SESSION["cityId"] . "" : "");
		return $condition;
	}

	private function getApprovals()
	{
		return "AND ld.verifyStatus=1 AND ld.admin_approved=1";
	}
	public function mGetValidPosterData(){
		return $this->db->query('SELECT concat(\''.base_url('projectimages/images/adsBanner/image/').'\',adv.adsBanner) as banner,adv.adsTitle as title,adv.url as target_url, 
						advp.img_loc page_location,adv.adsId as identifier
						FROM advertisement as adv
						join advertisement_plan as advp on advp.planId=adv.planId
						WHERE adv.isactive=1');

	}
}
