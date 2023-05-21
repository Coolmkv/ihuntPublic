<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentCourseRegistration extends CI_Model{

    const TABLE_NAME = "student_course_registration";

    const ID = "id";
    const STUDENT_ID = "student_id";
    const ORGANISATION_COURSES_ID = "organisation_courses_id";
    const PURCHASE_ORDERS_ID = "purchase_orders_id";
    const REGISTRATION_DATE = "registration_date";
    const REGISTRATION_STATUS = "registration_status";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";
}
