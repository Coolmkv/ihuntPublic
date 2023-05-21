<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonModel extends CI_Model{
	public function __construct() {
		parent:: __construct();
		$this->load->database();
	}


	public function getOrganisationsCourses($for_organization,$id=""){
		$where = ["status"=>1,"for_organization"=>$for_organization];
		if($id){
			$where["id"] = $id;
		}
		return $this->db->get_where('organization_course_master', $where);
	}

	public function saveOrganisationsCourses($for_organization){
		$course_ids = $this->input->post('course_id');
		$insert=[];
		if(is_array($course_ids) && count($course_ids)>0){
			foreach ($course_ids as $cIds){
				$confirm =  $this->db->get_where('organization_course_master', ["status"=>1,"for_organization"=>$for_organization,
					"id"=>$cIds]);
				if($confirm->num_rows()>0){
					$insert[] = ["organization_course_master_id"=>$cIds,"org_login_id"=>$_SESSION["loginId"],
						"created_by"=>$_SESSION["loginId"]];
				}
			}
			if(count($insert)>0){
				$this->db->insert_batch("all_organization_courses",$insert);
			}
			return ["status"=>true,"message"=>"Organisation courses inserted.","data"=>[]];
		}else{
			return ["status"=>false,"message"=>"Course Id is missing.","data"=>[]];
		}


	}
}
