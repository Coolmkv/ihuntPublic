<?php
if (!isset($_SESSION['studentId'])) {
    redirect('Register/logout');
} else {

}
//error_reporting(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>iHuntBest | My Dashboard</title>
        <link rel="icon" href="<?php echo base_url(); ?>images/fav.png" type="image/jpg" sizes="30x30">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="<?php echo base_url('css/404style.css?v=1.7'); ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/skins/skin-blue.min.css">
        <script src="<?php echo base_url('js/html5shiv.min.js');?>"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/checkbox.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/fontawesome-iconpicker.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>


        <![endif]-->
	<style>
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
   margin: 10px 0;
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
        <div class="loader">
            <div class="loder-box">
                <img src="<?php echo base_url('images/load1.png'); ?>" class="load1">
                <img src="<?php echo base_url('images/load3.png'); ?>" class="load3">
                <img src="<?php echo base_url('images/load2.png'); ?>" class="load2">
            </div>
        </div>
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo site_url('home/index'); ?>" class="logo">
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
                                    <i class="fa fa-clock-o"></i><span class="hidden-xs" id="date_time"
                                                                       title="Current Calender"></span>
                                </a>
                            </li>
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">Welcome <?php echo $_SESSION['studentemail']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- Menu Footer-->
                                    <?php if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'admin')) { ?>
                                        <li class="user-footer">
                                            <a href="activity-log" class="btn btn-default btn-flat">Activity</a>
                                        </li>
                                    <?php } ?>
                                    <li class="user-footer chngpassword">
                                        <a href="<?php echo site_url('student/changePassword'); ?>" class="btn btn-default btn-flat">Change Password</a>
                                    </li>
                                    <li class="user-footer">
                                        <a href="<?php echo site_url('register/logout'); ?>" onclick="signOut();" class="btn btn-default btn-flat">Sign out</a>
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
                            <a href="student">
                                <i class="fa fa-dashboard"></i> <span>My Dashboard</span>
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
                                <li class="view_profile_link"><a href="<?php echo site_url('studentProfile'); ?>"><i class="fa fa-users"></i>View Profile</a></li>
                                <li class="edit_personal_link"><a href="<?php echo site_url('studentPersonalDetails'); ?>"><i class="fa fa-pencil"></i>Edit | Insert Personal Info</a></li>
                                <li class="edit_secondary_link"><a href="<?php echo site_url('studentSecondarySchoolDetails'); ?>"><i class="fa fa-pencil"></i>Edit | Insert Secondary Info</a></li>
                                <li class="edit_srsec_link"><a href="<?php echo site_url('studentSenSecondarySchoolDetails'); ?>"><i class="fa fa-pencil"></i>Edit | Insert Sr. Secondary Info</a></li>
                                <li class="edit_pg_link"><a href="<?php echo site_url('studentHigherEducationDetails'); ?>"><i class="fa fa-pencil"></i>Edit | Insert Higher Studies Info</a></li>
                                <li class="edit_ce_link"><a href="<?php echo site_url('studentCompetitiveExamDetails'); ?>"><i class="fa fa-book"></i>Edit | Insert Competitive Exams</a></li>
                                <li class="edit_ins_link"><a href="<?php echo site_url('studentInstituteExamDetails'); ?>"><i class="fa fa-book"></i>Edit | Insert Institute Exams</a></li>
                                <li class="edit_upload_link"><a href="<?php echo site_url('studentUploadRelatedDocuments'); ?>"><i class="fa fa-upload"></i>Upload Related Documents</a></li>

                            </ul>
                        </li>
                        <li class="experience_link treeview">
                            <a href="">
                                <i class="fa fa-certificate"></i> <span>Experience</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="experience_link"><a href="<?php echo site_url('studentExperienceDetails'); ?>"><i class="fa fa-certificate"></i>Edit | Insert Experience</a></li>
                            </ul>
                        </li>
                        <li class="add_jobcategory_link treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Job Preference</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add_jobcategory_link"><a href="<?php echo site_url('studentJobPreferenceDetails'); ?>"><i class=" fa fa-file-text-o"></i>Edit | Insert Job Preference</a></li>

                            </ul>
                        </li>
                        <li class="test_link treeview">
                            <a href="">
                                <i class="fa fa-bar-chart"></i> <span>Test Result</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">

                                <li class="test_link"><a href="#"><i class="fa fa-bar-chart"></i>View Test Result Details</a></li>
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
                                <li class="notfication_link"><a href="<?php echo site_url('myNotifications'); ?>"><i class="fa fa-bell-o"></i>View Notifications</a></li>
                            </ul>
                        </li>
                        <li class="refers_link treeview">
                            <a href="">
                                <i class="fa fa-plus-circle"></i> <span>Refers</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="refers_link"><a href="<?php echo site_url('studentReferenceDetails'); ?>"><i class="fa fa-plus-circle"></i>Add | Show Refers</a></li>
                            </ul>
                        </li>
                        <li class="ensLink treeview">
                            <a href="">
                                <i class="fa fa-dollar"></i> <span>Earn & Share</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="ensvalLinkShow"><a href="<?php echo site_url('student/earnandsharevalue'); ?>"><i class="fa fa-dollar"></i>Show Earn and Share Value</a></li>
                            </ul>
                        </li>
                        <li class="myApplLink treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>My Applications</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="myApplLink"><a href="<?php echo site_url('student/myApplications'); ?>"><i class="fa fa-file-text-o"></i>View Applications Status</a></li>
                            </ul>
                        </li>

                    </ul>
                </section>
            </aside>
