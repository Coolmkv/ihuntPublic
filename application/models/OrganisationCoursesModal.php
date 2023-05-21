<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrganisationCoursesModal extends CI_Model{

    const TABLE_NAME = "organisation_courses";

    const ID = "id";
    const COURSE_MASTERS_ID = "course_masters_id";
    const ORGANISATION_ID = "organisation_id";
    const LOGIN_ID = "login_id";
    const COURSE_DETAILS = "course_details";
    const COURSE_QUALIFICATIONS = "course_qualifications"; 
    const REGISTRATION_FEE = "registration_fee";
    const COURSE_FEE = "course_fee";
    const TOTAL_SEATS = "total_seats";
    const AVAILABLE_SEATS = "available_seats"; 
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";
    const CREATED_BY = "created_by";
    const UPDATED_BY = "updated_by";
    const IS_ACTIVE = "is_active";

    const ID_ALIAS = "organisation_courses.id";
    const COURSE_MASTERS_ID_ALIAS = "organisation_courses.course_masters_id";
    const COURSE_DETAILS_ALIAS = "organisation_courses.course_details";
    const LOGIN_ID_ALIAS = "organisation_courses.login_id";
    const ORGANISATION_ID_ALIAS = "organisation_courses.organisation_id";

    const COURSE_QUALIFICATIONS_ALIAS = "organisation_courses.course_qualifications";
    const IS_ACTIVE_ALIAS = "organisation_courses.is_active";

    const REGISTRATION_FEE_ALIAS = "organisation_courses.registration_fee";
    const COURSE_FEE_ALIAS = "organisation_courses.course_fee";
    const TOTAL_SEATS_ALIAS = "organisation_courses.total_seats";
    const AVAILABLE_SEATS_ALIAS = "organisation_courses.available_seats";

    public function saveOrganisationsCourses(){
        $course_masters_ids = $this->input->post(self::COURSE_MASTERS_ID);
        $login_id = $_SESSION['loginId'];
        $orgId = $_SESSION["orgId"];
        $inserted = 0;
        $failed = 0;
        foreach($course_masters_ids as $course_masters_id){
            $insertCourse = $this->insertOrganisationCourse($course_masters_id,$orgId,$login_id);
            if($insertCourse["status"]=="success"){
                $inserted++;
            }else{
                $failed++;
            }
        }
        return ["status"=>"success","message"=>"Inserted for  $inserted and failed for $failed.","data"=>null];
    }
    
    /**
     * insertOrganisationCourse
     *
     * @param  mixed $course_masters_id
     * @param  mixed $organisation_id
     * @param  mixed $login_id
     * @param  mixed $course_details
     * @param  mixed $course_qualifications
     * @return array
     */
    public function insertOrganisationCourse($course_masters_id,$organisation_id,$login_id,$course_details = null,$course_qualifications = null):array{
        //check duplicate
        //check duplicate
        $check = $this->db->where([
            self::COURSE_MASTERS_ID=>$course_masters_id,
            self::ORGANISATION_ID=>$organisation_id,
            self::LOGIN_ID=>$login_id
        ])->get(self::TABLE_NAME);
        if($check->num_rows()>0){
            $return = ["status"=>"failure","message"=>"Duplicate course details.","data"=>[
                "duplicate"=>$check->row()
            ]];
        }else{
            $this->load->model("CourseMasterModel");
            $course_masters_details = $this->CourseMasterModel->getCourseMaster($course_masters_id);
            if(!empty($course_masters_details)){
               
                $return = $this->db->insert(self::TABLE_NAME,[
                    self::COURSE_MASTERS_ID=>$course_masters_id,
                    self::ORGANISATION_ID=>$organisation_id,
                    self::LOGIN_ID=>$login_id,
                    self::COURSE_DETAILS=>($course_details??($course_masters_details->{CourseMasterModel::COURSE_DETAILS}??null)),
                    self::COURSE_QUALIFICATIONS=>($course_qualifications??($course_masters_details->{CourseMasterModel::COURSE_QUALIFICATIONS}??null)),
                    self::IS_ACTIVE=>1,
                    self::UPDATED_BY=>$login_id,
                ]);
                $return = ["status"=>"success","message"=>"Inserted.","data"=>null];
            }else{
                $return = ["status"=>"failure","message"=>"course_masters_details not found.","data"=>null];
            }
        }
        return $return;
    }

    public function getOrganisationCourses(){
        
        $this->load->model("CourseMasterModel");
        $this->load->helper('helpers');
        $query = $this->db->select(self::ID_ALIAS.",".self::COURSE_MASTERS_ID_ALIAS.
        ",if(".self::COURSE_DETAILS_ALIAS." is null,".CourseMasterModel::COURSE_DETAILS_ALIAS.",".self::COURSE_DETAILS_ALIAS.") as ".
        self::COURSE_DETAILS.", if(".self::COURSE_QUALIFICATIONS_ALIAS." is null,".CourseMasterModel::COURSE_QUALIFICATIONS_ALIAS.",".
        self::COURSE_QUALIFICATIONS_ALIAS.") as ".self::COURSE_QUALIFICATIONS.",".CourseMasterModel::COURSE_NAME_ALIAS.",".
        self::ID_ALIAS.",".self::COURSE_FEE_ALIAS.",".self::REGISTRATION_FEE_ALIAS.",".self::TOTAL_SEATS_ALIAS.",".self::AVAILABLE_SEATS_ALIAS)
        ->from(self::TABLE_NAME)
        ->join(CourseMasterModel::TABLE_NAME,CourseMasterModel::ID_ALIAS."=".self::COURSE_MASTERS_ID_ALIAS." and ".self::IS_ACTIVE_ALIAS)
        ->where([
            CourseMasterModel::IS_ACTIVE_ALIAS=>1,
            self::LOGIN_ID_ALIAS=>$_SESSION['loginId'],
            self::ORGANISATION_ID_ALIAS=>$_SESSION['orgId']
        ]);
        renderDataTable($query);

    }
    

    public function updateCourse(){
        $id = FILTER_VAR(trim($this->input->post("organisation_courses_id")),FILTER_VALIDATE_INT);
        $course_details = $this->input->post(self::COURSE_DETAILS);
		$course_qualification = FILTER_VAR(trim($this->input->post(self::COURSE_QUALIFICATIONS)));
        $loginId = $_SESSION['loginId'];
        $organisation_id = $_SESSION['orgId'];
        $registration_fee = FILTER_VAR(trim($this->input->post("registration_fee")??0),FILTER_VALIDATE_INT);
        $course_fee = FILTER_VAR(trim($this->input->post("course_fee")??0),FILTER_VALIDATE_INT);
        $total_seats = FILTER_VAR(trim($this->input->post("total_seats")??0),FILTER_VALIDATE_INT);
        $available_seats = FILTER_VAR(trim($this->input->post("available_seats")??0),FILTER_VALIDATE_INT);
        if($registration_fee<0){
            $return = ["status"=>"failure","message"=>"Registration fee can not be less than 0.","data"=>[]];
        }else if($course_fee<0){
            $return = ["status"=>"failure","message"=>"Course fee can not be less than 0.","data"=>[]];
        }elseif($total_seats<0){
            $return = ["status"=>"failure","message"=>"Total seats can not be less than 0.","data"=>[]];
        }else if($available_seats<0){
            $return = ["status"=>"failure","message"=>"Available seats can not be less than 0.","data"=>[]];
        }else if($available_seats>$total_seats){
            $return = ["status"=>"failure","message"=>"Available seats can not be greater than available.","data"=>[]];
        }elseif(empty($id)){
			$return = ["status"=>"failure","message"=>"Id is empty.","data"=>[]];
		}else if(empty($course_qualification)){
			$return = ["status"=>"failure","message"=>"Course qualification is required.","data"=>[]];
		}else if(empty($course_details)){
			$return = ["status"=>"failure","message"=>"Course details is required.","data"=>[]];
		}else{
            $check = $this->db->where([
                self::LOGIN_ID=>$loginId,
                self::ORGANISATION_ID=>$organisation_id,
                self::ID=>$id
            ])->get(self::TABLE_NAME);

            if($check->num_rows()>0){
                $this->db->where(self::ID,$id)->update(self::TABLE_NAME,[
                    self::COURSE_DETAILS=>$course_details,
                    self::COURSE_QUALIFICATIONS=>$course_qualification,
                    self::UPDATED_BY=>$loginId,
                    self::REGISTRATION_FEE=>$registration_fee,
                    self::COURSE_FEE=>$course_fee,
                    self::AVAILABLE_SEATS=>$available_seats,
                    self::TOTAL_SEATS=>$total_seats
                ]);
                $return = ["status"=>"success","message"=>"Course details updated.","data"=>[]];
		    }else{
                $return = ["status"=>"failure","message"=>"Course details not found.","data"=>[]];
            }
        }
    	return $return;
    }

    public function deleteCourse(){
        $loginId = $_SESSION['loginId'];
        $organisation_id = $_SESSION['orgId'];
        
        $id = FILTER_VAR(trim($this->input->post("organisation_courses_id")),FILTER_VALIDATE_INT);
        if(empty($id)){
			$return = ["status"=>"failure","message"=>"Id is empty.","data"=>[]];
		}else{
            $check = $this->db->where([
                self::LOGIN_ID=>$loginId,
                self::ORGANISATION_ID=>$organisation_id,
                self::ID=>$id
            ])->get(self::TABLE_NAME);

            if($check->num_rows()>0){
                $this->db->where(self::ID,$id)->update(self::TABLE_NAME,[
                    self::IS_ACTIVE=>0,
                    self::UPDATED_BY=>$loginId
                ]);
                $return = ["status"=>"success","message"=>"Course details deleted.","data"=>[]];
		    }else{
                $return = ["status"=>"failure","message"=>"Course details not found.","data"=>[]];
            }
        }
        return $return;
    }
    
}