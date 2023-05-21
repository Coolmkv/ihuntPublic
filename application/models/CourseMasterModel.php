<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CourseMasterModel extends CI_Model {

    public function __construct() {
        parent:: __construct();
    }

    const ID = "id";
    const COURSE_NAME = "course_name";
    const COURSE_DETAILS = "course_details";
    const COURSE_QUALIFICATIONS = "course_qualifications";
    const COURSE_DURATION = "course_duration";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";
    const CREATED_BY = "created_by";
    const UPDATED_BY = "updated_by";
    const IS_ACTIVE = "is_active";
    const TABLE_NAME = "course_masters";
    
    const COURSE_DETAILS_ALIAS = "course_masters.course_details";
    const COURSE_QUALIFICATIONS_ALIAS = "course_masters.course_qualifications";
    const COURSE_NAME_ALIAS = "course_masters.course_name";
    const ID_ALIAS = "course_masters.id";
    const IS_ACTIVE_ALIAS = "course_masters.is_active";
  
    private static $object;

    public static function getSingleTonObject():self{
        if(!self::$object){
            self::$object = new CourseMasterModel();
        }
        return self::$object;
    }
    /**
     * insertCourseMaster
     *
     * @return array
     */
    public function insertCourseMaster():array{
        
        $id = FILTER_VAR(trim($this->input->post(self::ID)),FILTER_VALIDATE_INT);
    	$course_name = FILTER_VAR(trim($this->input->post(self::COURSE_NAME)));
		$course_details = $this->input->post(self::COURSE_DETAILS);
		$course_qualification = FILTER_VAR(trim($this->input->post(self::COURSE_QUALIFICATIONS)));
    	$course_duration = FILTER_VAR(trim($this->input->post(self::COURSE_DURATION)),FILTER_VALIDATE_INT);
    	if(empty($course_name)){
			$return = ["status"=>"failure","message"=>"Course name is empty.","data"=>[]];
		}else if(empty($course_qualification)){
			$return = ["status"=>"failure","message"=>"Course qualification is required.","data"=>[]];
		}else if(empty($course_duration) && is_numeric($course_duration)){
			$return = ["status"=>"failure","message"=>"Course duration is required and in months.","data"=>[]];
		}else{
            if(empty($id)){
                //
               $return = $this->insertCourseMasterData($course_name,$course_details,$course_qualification,$course_duration);
            }else{
                //check duplicate
                $check = $this->db->where([
                    self::COURSE_NAME=>$course_name,
                    self::ID." !="=>$id
                ])->get(self::TABLE_NAME);
                if($check->num_rows()>0){
                    $return = ["status"=>"failure","message"=>"Duplicate course name.","data"=>[
                        "duplicate"=>$check->row()
                    ]];
                }else{
                    //update details
                    $updateData = [
                        self::COURSE_NAME=>$course_name,
                        self::COURSE_DETAILS=>$course_details,
                        self::COURSE_QUALIFICATIONS=>$course_qualification,
                        self::COURSE_DURATION=>$course_duration,
                        self::IS_ACTIVE=>1,
                        self::UPDATED_BY=>$_SESSION['id'],
                    ];
                    $return = $this->updateCourserEntry($updateData,$id);
                }
            }
            
        }
        return $return;
    }
    
    /**
     * updateCourserEntry
     *
     * @param  mixed $updateRow
     * @param  mixed $id
     * @return array
     */
    public function updateCourserEntry(array $updateRow,$id):array{
        try{
            if(empty($updateRow) || empty($id)){
                $return = ["status"=>"failure","message"=>"Update data and id required to update.","data"=>[]];
            }else{
                $updateRow[self::UPDATED_AT] = (new Superadmin_model())->datetimenow();
                $this->db->where(self::ID,$id)->update(self::TABLE_NAME,$updateRow);
                $return = ["status"=>"success","message"=>"Course data updated.","data"=>[]];
            }
        }catch(Exception $exception){
            $return = ["status"=>"failure","message"=>"Exception in course update.","data"=>[
                "message"=>$exception->getMessage()
            ]];
        }
        return $return;
    }
    
    /**
     * insertCourseEntry
     *
     * @param  mixed $insertRow
     * @return array
     */
    public function insertCourseEntry($insertRow):array{
        try{
            if(empty($insertRow)){
                $return = ["status"=>"failure","message"=>"Insert data required to insert.","data"=>[]];
            }else{
                $insertRow[self::CREATED_AT] = (new Superadmin_model())->datetimenow();
                $this->db->insert(self::TABLE_NAME,$insertRow);
                $return = ["status"=>"success","message"=>"Course data inserted.","data"=>[]];
            }
        }catch(Exception $exception){
            $return = ["status"=>"failure","message"=>"Exception in course data insert.","data"=>[
                "message"=>$exception->getMessage()
            ]];
        }
        return $return;
        
    }

    public function GetCourseMastersData(){
		$where = [self::IS_ACTIVE=>1];
		$id = FILTER_VAR(trim($this->input->post('id')));
		if ($id) {
			$where[self::ID] = $id;
		}
		$query = $this->db->where($where)
			->select(
                self::COURSE_NAME.",".self::COURSE_DETAILS.",".self::ID.",".self::COURSE_DURATION.",".self::COURSE_QUALIFICATIONS)
			->get(self::TABLE_NAME);
		if ($query->num_rows() > 0) {
			return json_encode($query->result());
		}else{
			return json_encode([]);
		}
	}
    
    /**
     * insertCourseMasterData
     *
     * @param  mixed $course_name
     * @param  mixed $course_details
     * @param  mixed $course_qualification
     * @param  mixed $course_duration
     * @return void
     */
    public function insertCourseMasterData($course_name,$course_details,$course_qualification,$course_duration){
            //check course name status should be unique
            $check = $this->db->where([
                self::COURSE_NAME=>$course_name
            ])->get(self::TABLE_NAME);
            if($check->num_rows()>0){
                $rowData = $check->row();
                $status = $rowData->{self::IS_ACTIVE};
                if($status==1){
                    $return = ["status"=>"failure","message"=>"Course Name already taken.","data"=>[]];
                }else{
                    //update details
                    $updateData = [
                        self::COURSE_NAME=>$course_name,
                        self::COURSE_DETAILS=>$course_details,
                        self::COURSE_QUALIFICATIONS=>$course_qualification,
                        self::COURSE_DURATION=>$course_duration,
                        self::IS_ACTIVE=>1,
                        self::UPDATED_BY=>$_SESSION['id'],
                    ];
                    $return = $this->updateCourserEntry($updateData,$rowData->{self::ID});
                }
            }else{
                //insert details
                $return = $this->insertCourseEntry([
                    self::COURSE_NAME=>$course_name,
                    self::COURSE_DETAILS=>$course_details,
                    self::COURSE_QUALIFICATIONS=>$course_qualification,
                    self::COURSE_DURATION=>$course_duration,
                    self::IS_ACTIVE=>1,
                    self::CREATED_BY=>$_SESSION['id']
                ]);

            }
            return $return;
    }

    public function deleteCourseMastersData(){
        $id = FILTER_VAR(trim($this->input->post(self::ID)),FILTER_VALIDATE_INT);
        $check = $this->db->where([
            self::ID=>$id,
            self::IS_ACTIVE=>"1"
        ])->get(self::TABLE_NAME);
        if($check->num_rows()>0){
            $this->db->where(self::ID,$id)->update(self::TABLE_NAME,[
                self::IS_ACTIVE=>0,
                self::UPDATED_BY=>$_SESSION['id'],
                self::UPDATED_AT=>(new Superadmin_model())->datetimenow()
            ]);
            $return = ["status"=>"success","message"=>"Course data deleted.","data"=>[]];
        }else{
            $return = ["status"=>"failure","message"=>"Course data not found.","data"=>[]];
        }
        return $return;
    }
    
    /**
     * getCourseMaster
     *
     * @param  mixed $id
     * @return object
     */
    public function getCourseMaster($id):object{
        $check = $this->db->where([
            self::ID=>$id,
            self::IS_ACTIVE=>"1"
        ])->get(self::TABLE_NAME);
        return $check->row();
    }
    
    /**
     * getAllCourses
     *
     * @return void
     */
    public function getAllCourses(){
        return $this->db->where([
            self::IS_ACTIVE=>"1"
        ])->get(self::TABLE_NAME);
    }

    public function getOrgCourses($roleName){
        return $this->db->query("SELECT distinct cm.course_name,cm.id  FROM ihunt_best.organisation_courses as oc
        join course_masters as cm on cm.id=oc.course_masters_id and cm.is_active=1
        join login_details as ld on oc.login_id=ld.id 
        where oc.is_active=1 and ld.roleName='$roleName'");
    }
}