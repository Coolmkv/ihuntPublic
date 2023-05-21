<?php
if (!isset($_SESSION['id']) || !isset($_SESSION['user_type'])) {
    redirect('Register/logout');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>iHuntBest | Dashboard</title>
        <link rel="icon" href="<?php echo base_url(); ?>images/fav.png" type="image/jpg" sizes="30x30">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/AdminLTE.min.css?v=1">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/skins/skin-blue.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/checkbox.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/fontawesome-iconpicker.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <link rel="stylesheet" href="<?php echo base_url('plugins/summernote/summernote.css'); ?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="<?php echo base_url('js/html5shiv.min.js');?>"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

        <![endif]-->
		<style>
				div#studentModal {
    position: fixed;
    
    padding-top: 0px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
 background-color: rgba(0, 0, 0, 0.84); 
}
img#enqLogo {
    max-width: 100%;
}
h4#en_collegename {
    font-weight: bold;
}
.closediv {
    text-align: right;
}

h4.enrollnowlabels {
    background-color: #faa71a;
    padding: 7px 0;
    color: #fff;
}
.h4, h4 {
    margin-top: 0px !important;
	}
.control-label {
    font-weight: 600;
    color: #212121;
    font-size: 16px;
    text-align: right;
    padding-top: 9px;
}
.modal-body {
    padding: 0 15px !important;
}
button#msgId {
    margin-top: 20px;
}
	.incoming_msg_img {
 display: inline-block;
 width: 6%;
}
.input_msg_write {
   margin: 20px 0;
}
.received_msg {
 display: inline-block;
 padding: 0 0 0 10px;
 vertical-align: top;
 width: 92%;
}
.received_withd_msg p {
 background: #ebebeb none repeat scroll 0 0;
 border-radius: 3px;
 color: #646464;
 font-size: 14px;
 margin: 0;
 padding: 5px 10px 5px 12px;
 width: 100%;
  word-wrap: break-word;
}
.time_date {
 color: black;
 display: block;
 font-size: 12px;
 margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
 float: left;
 padding: 30px 15px 0 25px;
 width: 100%;
}
.msg_history {
height: 400px;
overflow-y: auto;
border: 1px solid #ebebeb;
padding: 10px;
border-radius: 5px;
box-shadow: inset 1px -1px 12px 0px #ebebeb;
}

.sent_msg p {
 background: #05728f none repeat scroll 0 0;
 border-radius: 3px;
 font-size: 14px;
 margin: 0; color:#fff;
 padding: 5px 10px 5px 12px;
 width:100%;
 word-wrap: break-word;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
 float: right;
 width: 46%;
}
.input_msg_write input {
 background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
 border: 1px solid grey;
 color: #4c4c4c;
 font-size: 15px;
 min-height: 48px;
 width: 100%;
 padding: 10px 20px;
}
input::placeholder{
 padding:10px 20px;
}
.type_msg {border-top: 1px solid #c4c4c4;position: relative;}

.msg_send_btn {
 background: #05728f none repeat scroll 0 0;
 border: medium none;
 border-radius: 50%;
 color: #fff;
 cursor: pointer; 
 font-size: 17px;
 height: 50px;
 position: absolute;
left: 35%;
   top: 28px;
 width: 50px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
 height: 400px;
 overflow-y: auto;
}
textarea#stu_msgId {
    width: 100%;
}
i.fa.fa-paper-plane-o{
	font-size: 22px;
}

.modal-footer {
   padding: 15px;
   text-align: center;
   border-top: 1px solid #e5e5e5;
}
.btn-default {
   background-color: #f4f4f4;
   color: #444;
   border-color: #ddd;
   margin: 10px 1px;
}
.sent_msg p a {
    color: #f5aa22;
}
.sent_msg p a:hover {
    color: #f5aa22a6;
}
</style>	
		
		
		
    </head>
    <!--
    BODY TAG OPTIONS:
    =================
    Apply one or more of the following classes to get the
    desired effect
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
    -->
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>Hunt</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="<?php echo base_url(); ?>images/logo.png" width="210px"></span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <i class="fa fa-clock-o"></i><span class="hidden-xs" id="date_time" title="Current Calender"></span>
                                </a>
                            </li>
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">Welcome <?php echo $_SESSION['name']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- Menu Footer-->
                                    <li class="user-footer activitylog">
                                        <a href="<?php echo site_url('superadmin/activityLog'); ?>" class="btn btn-default btn-flat">Activity</a>
                                    </li>
                                    <li class="user-footer chngpassword">
                                        <a href="<?php echo site_url('superadmin/changePassword'); ?>" class="btn btn-default btn-flat">Change Password</a>
                                    </li>
                                    <li class="user-footer">
                                        <a href="<?php echo site_url('register/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="dashboard_item treeview">
                            <a href="dashboard">
                                <i class="fa fa-dashboard"></i> <span>Super Admin Dashboard</span>
                            </a>
                        </li>
                        <li class="profile_link treeview">
                            <a href="">
                                <i class="fa fa-user"></i> <span>Profile</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="edit_profile_link"><a href="<?php echo site_url('superadmin/editprofile'); ?>"><i class="fa fa-pencil"></i>Edit Profile</a></li>
                                <li class="view_profile_link"><a href="<?php echo site_url('superadmin/profile'); ?>"><i class="fa fa-users"></i>View Profile</a></li>
                                <li class="view_Finacial_link"><a href="<?php echo site_url('superadmin/financialDetails'); ?>"><i class="fa fa-rupee"></i>Financial Details</a></li>
                            </ul>
                        </li>
                        <li class="admin_item treeview">
                            <a href="">
                                <i class="fa fa-user"></i> <span>Masters</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
								<li class="organizationCourse_link"><a href="<?php echo site_url('superadmin/organisationCoursesMaster'); ?>"><i class="fa fa-university"></i>All Organisations Course Master</a></li>
								<li class="universityCourse_link"><a href="<?php echo site_url('superadmin/univCoursesMaster'); ?>"><i class="fa fa-university"></i>University Course</a></li>
                                <li class="instituteCourse_link"><a href="<?php echo site_url('superadmin/InstCoursesMaster'); ?>"><i class="fa fa-code-fork"></i>Institute Course</a></li>
                                <li class="timeduration_link"><a href="<?php echo site_url('superadmin/TimedurationMaster'); ?>"><i class="fa fa-clock-o"></i>Time Duration</a></li>
                                <li class="schoolClassType_link"><a href="<?php echo site_url('superadmin/schoolClassMaster'); ?>"><i class="fa fa-shield"></i>School Class</a></li>
                                <li class="schoolClassType_link"><a href="<?php echo site_url('superadmin/schoolClassTypeMaster'); ?>"><i class="fa fa-shield"></i>School Class Type</a></li>
                                <li class="competitiveexam_link"><a href="<?php echo site_url('superadmin/competitiveMaster'); ?>"><i class="fa fa-book"></i>Competitive Exam Master</a></li>
                                <li class="markingType_link"><a href="<?php echo site_url('superadmin/markingTypeMaster'); ?>"><i class="fa fa-pencil"></i>Marking Type</a></li>
                                <li class="courseFeeType_link"><a href="<?php echo site_url('superadmin/courseFeeTypeMaster'); ?>"><i class="fa fa-rupee"></i>Course Fee Type</a></li>
                                <li class="currencyMaster_link"><a href="<?php echo site_url('superadmin/currencyMaster'); ?>"><i class="fa fa-dollar"></i>Currencies Master</a></li>
                                <li class="departMent_link"><a href="<?php echo site_url('superadmin/departmentMaster'); ?>"><i class="fa fa-briefcase"></i>Department</a></li>
                                <li class="keySkill_link"><a href="<?php echo site_url('superadmin/studentKeySkills'); ?>"><i class="fa fa-compress"></i>Student Key Skill Master</a></li>
                                <li class="courseModeMaster_link"><a href="<?php echo site_url('superadmin/courseModeMaster'); ?>"><i class="fa fa-cogs"></i>Course Mode</a></li>
                                <li class="examModeMaster_link"><a href="<?php echo site_url('superadmin/examModeMaster'); ?>"><i class="fa fa-cogs"></i>Exam Mode</a></li>
                                <li class="feeCycle_link"><a href="<?php echo site_url('superadmin/feeCycleMaster'); ?>"><i class="fa fa-check-square-o"></i>Fee Cycle</a></li>
                                <li class="subject_link"><a href="<?php echo site_url('superadmin/subjectMaster'); ?>"><i class="fa fa-book"></i>Subject Master</a></li>
                                <li class="courser_masters"><a href="<?php echo site_url('superadmin/courseMasters'); ?>"><i class="fa fa-book"></i>Course Masters</a></li>
                            </ul>
                        </li>
                        <!-- created by shweta-->
                        <li class="treeviewReqCourses_link treeview">
                            <a href="">
                                <i class="fa fa-book"></i> <span>Requested Course</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="RequniversityCourse_link"><a href="<?php echo site_url('superadmin/univRequestedcourse'); ?>"><i class="fa fa-pencil-square-o"></i>University Requested Course</a></li>
                                <li class="treeviewApprovuniversityCourse_link"><a href="<?php echo site_url('superadmin/showApprovedCourse'); ?>"><i class="fa fa-check-square-o"></i>Approved Course</a></li>
                                <li class="rejected_courses_plan_link"><a href="<?php echo site_url('superadmin/showRejectedCourse'); ?>"><i class="fa fa-times-circle-o"></i>Rejected Course</a></li>
                            </ul>
                        </li>
                        <!--end by shweta-->
                        <li class="organicationDetails_link treeview">
                            <a href="">
                                <i class="fa fa-user"></i> <span>Organization Details</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeviewUd_link"><a href="<?php echo site_url('superadmin/showUniversity'); ?>"><i class="fa fa-university"></i>University Details</a></li>
                                <li class="treeviewCd_link"><a href="<?php echo site_url('superadmin/showCollege'); ?>"><i class="fa fa-graduation-cap"></i>College Details</a></li>
                                <li class="treeviewId_link"><a href="<?php echo site_url('superadmin/showInstitute'); ?>"><i class="fa fa-code-fork"></i>Institute Details</a></li>
                                <li class="treeviewSd_link"><a href="<?php echo site_url('superadmin/showSchool'); ?>"><i class="fa fa-shield"></i>School Details</a></li>
                            </ul>
                        </li>
                        <li class="organicationControls_link treeview">
                            <a href="">
                                <i class="fa fa-cogs"></i> <span>Organization Controls</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="univControls_link"><a href="<?php echo site_url('superadmin/univControls'); ?>"><i class="fa fa-university"></i>University Controls</a></li>
                                <li class="collegeControls_link"><a href="<?php echo site_url('superadmin/collegeControls'); ?>"><i class="fa fa-graduation-cap"></i>College Controls</a></li>
                                <li class="instituteControls_link"><a href="<?php echo site_url('superadmin/instituteControls'); ?>"><i class="fa fa-code-fork"></i>Institute Controls</a></li>
                                <li class="schoolControls_link"><a href="<?php echo site_url('superadmin/schoolControls'); ?>"><i class="fa fa-shield"></i>School Controls</a></li>
                            </ul>
                        </li>
                        <li class="notfication_link treeview">
                            <a href="">
                                <i class="fa fa-bell-o"></i> <span>Notifications</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="notfication_link"><a href="<?php echo site_url('superadmin/adminnotifications'); ?>"><i class="fa fa-bell-o"></i>View Notifications</a></li>
                            </ul>
                        </li>
                        <li class="treeviewfacilities_link treeview">
                            <a href="">
                                <i class="fa fa-sheqel"></i> <span>Facilities</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeviewAddShow_link"><a href="<?php echo site_url('superadmin/addFacility'); ?>"><i class="fa fa-plus"></i>Add/Show Facilities</a></li>
                                <li class="treeviewReqfacilities_link"><a href="<?php echo site_url('superadmin/showRequestFacility'); ?>"><i class="fa fa-pencil-square-o"></i>Requested Facilities</a></li>
                                <li class="treeviewApprovfacilities_link"><a href="<?php echo site_url('superadmin/showApprovedFacility'); ?>"><i class="fa fa-check-square-o"></i>Approved Facilities</a></li>
                                <li class="treeviewrejectfacilities_link"><a href="<?php echo site_url('superadmin/showRejectedFacility'); ?>"><i class="fa fa-times-circle-o"></i>Rejected Facilities</a></li>
                            </ul>
                        </li>
                        <li class="treeviewStudentDetails_link treeview">
                            <a href="">
                                <i class="fa fa-deviantart"></i> <span>Student Details</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeviewSSD_link"><a href="<?php echo site_url('superadmin/showStudentDetails'); ?>"><i class="fa fa-deviantart"></i>Show Student Details</a></li>
                            </ul>
                        </li>
                        <li class="treeviewCSC_link treeview">
                            <a href="">
                                <i class="fa fa-cc"></i> <span>Country & State & city</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeviewASC_link"><a href="<?php echo site_url('superadmin/addShowCountry'); ?>"><i class="fa fa-cc">Add/Show Country</i></a></li>


                            </ul>
                        </li>
                        <li class="admin_registration treeview">
                            <a href="">
                                <i class="fa fa-plus-square"></i> <span>Register</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="orgRegister_link"><a href="<?php echo site_url('superadmin/orgRegister'); ?>"><i class="fa fa-university"></i>Organization Registration</a></li>
                                <!--<li class="adminRegister_link"><a href="<?php echo site_url('superadmin/adminRegister'); ?>"><i class="fa fa-user"></i>Administrator Register</a></li>-->
                                <li class="studentRegister_link"><a href="<?php echo site_url('superadmin/studentRegister'); ?>"><i class="fa fa-user"></i>Student Register</a></li>
                                <li class="xcelfile_link"><a href="<?php echo site_url('superadmin/orgFileupload'); ?>"><i class="fa fa-file-excel-o"></i>Upload File of Organizations</a></li>
                            </ul>
                        </li>
                        <li class="treeviewRAO_link treeview">
                            <a href="">
                                <i class="fa fa-openid"></i> <span>Registration of Organization</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeviewASRAO_link"><a href="<?php echo site_url('superadmin/registeredOrganisation') ?>" title="Add/Show Registered Organisation"><i class="fa fa-openid">Add/Show RAO's</i></a></li>
                            </ul>
                        </li>
                        <li class="advertisement_plan treeview">
                            <a href="">
                                <i class="fa fa-paper-plane"></i> <span>Advertisement Plan</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="advertisement_plan_link"><a href="<?php echo site_url('superadmin/advertisementplan') ?>" ><i class="fa fa-paper-plane-o">Add/Show Advertisement Plan</i></a></li>
                                <li class="Req_adv_plan_link"><a href="<?php echo site_url('superadmin/showRequestAdvertisement'); ?>"><i class="fa fa-pencil-square-o"></i>Requested Advertisement</a></li>
                                <li class="Approv_adv_plan_link"><a href="<?php echo site_url('superadmin/showApprovedAdvertisement'); ?>"><i class="fa fa-check-square-o"></i>Approved Advertisement</a></li>
                                <li class="rejected_adv_plan_link"><a href="<?php echo site_url('superadmin/showRejectedAdvertisement'); ?>"><i class="fa fa-times-circle-o"></i>Rejected Advertisement</a></li>
                            </ul>
                        </li>
                        <li class="ratingNreview treeview">
                            <a href="">
                                <i class="fa fa-star"></i> <span>Rating & Review Approval</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="ratingNreview"><a href="<?php echo site_url('superadmin/showRatingReviews'); ?>"><i class="fa fa-star"></i>Rating & Reviews</a></li>
                            </ul>
                        </li>
                        <li class="advertisewithus treeview">
                            <a href="">
                                <i class="fa fa-paper-plane"></i> <span>Advertise With Us</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="advertisewithus"><a href="<?php echo site_url('superadmin/advertiseWithUs'); ?>"><i class="fa fa-paper-plane"></i>Advertise With Us Messages</a></li>
                            </ul>
                        </li>
                        <li class="pageLink treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Page Requests</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="pageReqLink"><a href="<?php echo site_url('superadmin/pageRequests'); ?>"><i class="fa fa-file-text-o"></i>Approve|Reject Page Requests</a></li>
                                <li class="apageReqLink"><a href="<?php echo site_url('superadmin/acceptedPages'); ?>"><i class="fa fa-file-text-o"></i>Accepted Page Requests</a></li>
                                <li class="rpageReqLink"><a href="<?php echo site_url('superadmin/rejectedPages'); ?>"><i class="fa fa-file-text-o"></i>Rejected Page Requests</a></li>
                                <li class="ppageReqLink"><a href="<?php echo site_url('superadmin/paymentPages'); ?>"><i class="fa fa-file-text-o"></i>Payment Asked Page Requests</a></li>
                            </ul>
                        </li>
                        <li class="ourteamLink treeview">
                            <a href="">
                                <i class="fa fa-id-card"></i> <span>Our Team</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="ourteamLink"><a href="<?php echo site_url('superadmin/addTeam'); ?>"><i class="fa fa-id-card"></i>Add | Remove Team Members</a></li>
                            </ul>
                        </li>
                        <li class="CareersLink treeview">
                            <a href="">
                                <i class="fa fa-briefcase"></i> <span>Careers</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="CareersLinkdetails"><a href="<?php echo site_url('superadmin/careers'); ?>"><i class="fa fa-briefcase"></i>Add | Remove Careers Details</a></li>
                                <li class="JobapplicationLink"><a href="<?php echo site_url('superadmin/jobApplications'); ?>"><i class="fa fa-file-pdf-o"></i>Job Applications</a></li>
                            </ul>
                        </li>
                        <!-- created by shweta-->
                        <li class="ensLink treeview">
                            <a href="">
                                <i class="fa fa-dollar"></i> <span>Earn & Share</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="ensLinkAddShow"><a href="<?php echo site_url('superadmin/earnandshare'); ?>"><i class="fa fa-dollar"></i>Add | Show Earn and Share</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="ensvalLinkShow"><a href="<?php echo site_url('superadmin/earnandsharevalue'); ?>"><i class="fa fa-dollar"></i>Show Earn and Share Value</a></li>
                            </ul>
                        </li>
                        <li class="pcmaster treeview">
                            <a href="">
                                <i class="fa fa-handshake-o"></i> <span>PromoCode</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="pcmaster"><a href="<?php echo site_url('superadmin/promoCode'); ?>"><i class="fa fa-handshake-o"></i>Show PromoCode Price Master</a></li>
                            </ul>
                        </li>
                        <li class="totalvisLink treeview">
                            <a href="">
                                <i class="fa fa-users"></i> <span>Visitor</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="totalvisShow"><a href="<?php echo site_url('superadmin/totalvisitor'); ?>"><i class="fa fa-users"></i>Show Total Visitor</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="webvisShow"><a href="<?php echo site_url('superadmin/webvisitor'); ?>"><i class="fa fa-globe"></i>Show Website Visitor</a></li>
                            </ul>
                        </li>
                        <li class="newsltr_plan_Link treeview">
                            <a href="">
                                <i class="fa fa-envelope"></i> <span>News Letter Plan</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="newsltr_plan_AddShow"><a href="<?php echo site_url('superadmin/newsletterplan'); ?>"><i class="fa fa-envelope-o"></i>Add|Show News Letter Plan</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="nlpb_Show"><a href="<?php echo site_url('superadmin/newsletterplanbuy'); ?>"><i class="fa fa-dollar"></i>Show News Letter Plan Buy</a></li>
                            </ul>
                        </li>
						<li class="newsltr_plan_Link treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Enrollments</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="newsltr_plan_AddShow"><a href="<?php echo site_url('superadmin/enrollments'); ?>"><i class="fa fa-arrow-circle-right"></i>View Enrollments</a></li>
                            </ul>
                        </li>
						<li class="newsltr_plan_Link treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Transactions</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="newsltr_plan_AddShow"><a href="<?php echo site_url('superadmin/transactions'); ?>"><i class="fa fa-arrow-circle-right"></i>View Transactions</a></li>
                            </ul>
                        </li>
                        <li class="testmo treeview">
                            <a href="">
                                <i class="fa fa-quote-left"></i> <span>Testimonials</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="addTestimonials"><a href="<?php echo site_url('superadmin/addTestimonials'); ?>"><i class="fa fa-quote-left"></i>Add | Show Testimonials</a></li>
                            </ul>
                            <!--                <ul class="treeview-menu">
                                                <li class="showTestimonials"><a href="<?php // echo site_url('superadmin/showTestimonials');                                                                                          ?>"><i class="fa fa-quote-left"></i>Show Testimonials</a></li>
                                            </ul>-->
                        </li>
                        <li class="blogs treeview">
                            <a href="">
                                <i class="fa fa-rss-square"></i> <span>Blogs</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="addBlogs"><a href="<?php echo site_url('superadmin/addBlog'); ?>"><i class="fa fa-rss-square"></i>Add | Show Blogs</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="addBlogsCategories"><a href="<?php echo site_url('superadmin/addBlogCategories'); ?>"><i class="fa fa-rss-square"></i>Add | Show Blog Categories</a></li>
                            </ul>
                        </li>
                        <li class="orgByB treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Before You Begin</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="bubtext"><a href="<?php echo site_url('superadmin/beforeYouBegin'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Before You Begin</a></li>
                            </ul>

                        </li>
                        <li class="faqlink treeview">
                            <a href="">
                                <i class="fa fa-question-circle-o"></i> <span>FAQ'S</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="faqCategorieslink"><a href="<?php echo site_url('superadmin/faqCategories'); ?>"><i class="fa fa-question-circle-o"></i>Add|Show Categories</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="faqQAlink"><a href="<?php echo site_url('superadmin/faqQuestionAnswers'); ?>"><i class="fa fa-question-circle-o"></i>Add|Show Questions</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-dollar"></i> <span>Payment Gateway</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo site_url('superadmin/paymentGatewayDetails'); ?>"><i class="fa fa-dollar"></i>Add|Show Payment Gateway</a></li>
                            </ul>
                        </li>
                        <li class="helpMenu treeview">
                            <a href="">
                                <i class="fa fa-info-circle"></i> <span>Help Menu</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="helpmenulink"><a href="<?php echo site_url('superadmin/helpMenu'); ?>"><i class="fa fa-info-circle"></i>Add|Show Help Menu</a></li>
                            </ul>
                        </li>
									<li class="newsltr_plan_Link treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Message Status</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="newsltr_plan_AddShow"><a href="<?php echo site_url('superadmin/messageStatus'); ?>"><i class="fa fa-arrow-circle-right"></i>View Message Status</a></li>
                            </ul>
                        </li>
						         <li class="orgByB treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Footer Pages</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                               
								<li class="bubtext"><a href="<?php echo site_url('superadmin/genesis'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Genesis </a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/pressRelease'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Press Release</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/ihuntBestCares'); ?>"><i class="fa fa-file-text-o"></i>Add | Show ihunt Best Cares</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/giftSmile'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Gift Smile</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/services'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Services</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/ihuntBestStories'); ?>"><i class="fa fa-file-text-o"></i>Add | Show ihunt Best Stories</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/support'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Support</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/paymentsSaved'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Payments Saved</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/cardsShipping'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Cards Shipping</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/cancelAndReturn'); ?>"><i class="fa fa-file-text-o"></i>Add | Show cancelation And Return</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/reportInfringement'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Report Infringement</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/writeToUs'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Write To Us</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/showBrandEmpowerment'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Brand Empowerment</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/onlineShopping'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Online Shopping</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/affiliateProgram'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Affiliate Program</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/giftCardOffer'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Gift Card and Offer</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/firstSubscription'); ?>"><i class="fa fa-file-text-o"></i>Add | Show First Subscription</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/siteMap'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Site Map</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/returnPolicy'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Return Policy</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/termsOfUse'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Terms Of Use</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/securityPolicy'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Security Policy</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/refundPolicy'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Refund Policy</a></li>
								<li class="bubtext"><a href="<?php echo site_url('superadmin/footerContent'); ?>"><i class="fa fa-file-text-o"></i>Add | Show Footer Content</a></li>
                            </ul>

                        </li>

                        <!-- end by shweta-->

                    </ul>
                </section>
            </aside>

