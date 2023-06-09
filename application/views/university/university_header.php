<?php
if (!isset($_SESSION['userType']) || !isset($_SESSION['loginId'])) {
    redirect('Register/logout');
} else {
    if ($_SESSION['userType'] != 'University') {
        redirect('Register/logout');
    }
}
//error_reporting(0);
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
        <link href="<?php echo base_url('css/404style.css?v=1.7'); ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <link rel="stylesheet" href="<?php echo base_url('plugins\summernote\summernote.css'); ?>">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>


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
                                    <i class="fa fa-clock-o"></i><span class="hidden-xs" id="date_time"
                                                                       title="Current Calender"></span>
                                </a>
                            </li>
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">Welcome <?php echo $_SESSION['email']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- Menu Footer-->
                                    <?php if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'admin')) { ?>
                                        <li class="user-footer">
                                            <a href="activity-log" class="btn btn-default btn-flat">Activity</a>
                                        </li>
                                    <?php } ?>
                                    <li class="user-footer">
                                        <a href="<?php echo site_url('university/changePassword'); ?>" class="btn btn-default btn-flat">Change Password</a>
                                    </li>
                                    <li class="user-footer">
                                        <a href="<?php echo site_url('register/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown user user-menu" id="helpmenu">
                                <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-question-circle-o"></i>
                                </a>
                                <ul class="dropdown-menu" style="width: auto;">
                                    <div class="col-lg-12" style="padding: 15px; overflow: scroll;max-height: 400px;   border: dashed #3c8dbc 2px;">
                                        <h5>Help Menu</h5>
                                        <input type="text" class="form-control helpSearch" placeholder="Search" name="search">
                                        <div class="loading">
                                            <div class="loder-box">
                                                <img src="<?php echo base_url("images/LoaderIcon.gif"); ?>">
                                            </div>
                                        </div>

                                        <div id="searchContent"></div>
                                        <div id="searchCategories"></div>
                                    </div>
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
                                <i class="fa fa-dashboard"></i> <span>University Dashboard</span>
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
                                <li class="edit_profile_link"><a href="<?php echo site_url('university/editprofile'); ?>"><i class="fa fa-pencil"></i>Edit Profile</a></li>
                                <li class="view_profile_link"><a href="<?php echo site_url('university/profile'); ?>"><i class="fa fa-users"></i>View Profile</a></li>
                                <li class="profile_header_link"><a href="<?php echo site_url('university/profileHeaders'); ?>"><i class="fa fa-photo"></i>Profile Header Manage</a></li>
                                <li class="view_concerned_link"><a href="<?php echo site_url('university/orgUser'); ?>"><i class="fa fa-user"></i>Concerned Person Details</a></li>
                                <li class="view_Finacial_link"><a href="<?php echo site_url('university/financialDetails'); ?>"><i class="fa fa-rupee"></i>Financial Details</a></li>
                                <li class="view_approval_link"><a href="<?php echo site_url('university/approvalDocuments'); ?>"><i class="fa fa-file-pdf-o"></i>Approval Document Upload</a></li>
                                <li class="sliderimage_link"><a href="<?php echo site_url('university/sliderImages'); ?>"><i class="fa fa-image"></i>Add | Remove Slider Images</a></li>
                            </ul>
                        </li>
                        <li class="department_link treeview">
                            <a href="">
                                <i class="fa  fa-file-text-o"></i> <span>Department</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add_department_link"><a href="<?php echo site_url('university/addDepartment'); ?>"><i class="fa  fa-file-text-o"></i>Add Department</a></li>
                            </ul>
                        </li>
                        <li class="pages_link treeview">
                            <a href="">
                                <i class="fa  fa-file-text-o"></i> <span>Pages</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add_pages_link"><a href="<?php echo site_url('university/addPages'); ?>"><i class="fa  fa-file-text-o"></i>Add Pages</a></li>
                            </ul>
                        </li>
                        <li class="add_course_link treeview">
                            <a href="">
                                <i class="fa fa-cog"></i> <span>Add Courses</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
								<li class="add_course"><a href="<?php echo site_url('university/addNewCourses'); ?>"><i class=" fa fa-cog"></i>Add New Courses</a></li>
                                <!-- <li class="add_course"><a href="<?php //echo site_url('university/addCourse'); ?>"><i class=" fa fa-cog"></i>Add Courses</a></li>
                                <li class="show_course"><a href="<?php //echo site_url('university/showCourses'); ?>"><i class=" fa fa-cog"></i>Show Courses</a></li>
                                <li class="req_course"><a href="<?php //echo site_url('university/requestCourse'); ?>"><i class=" fa fa-plus-circle"></i>Request Courses</a></li> -->
                            </ul>
                        </li>
                        <!-- <li class="streamDetails_link treeview">
                            <a href="">
                                <i class="fa fa-tasks"></i> <span>Course Streams Details</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="addstream_link"><a href="<?php //echo site_url('university/addStreams'); ?>"><i class="fa fa-tasks"></i>Add Course Streams</a></li>
                                <li class="showstream_link"><a href="<?php //echo site_url('university/showStreams'); ?>"><i class="fa fa-tasks"></i>Show Course Streams</a></li>
                            </ul>
                        </li> -->
                        <li class="brochures_link treeview">
                            <a href="">
                                <i class="fa fa-commenting"></i> <span>Brochures</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">

                                <li class="addshowBrouchers"><a href="<?php echo site_url('university/showBrochure'); ?>"><i class="fa fa-commenting"></i>Add/Show Brochures</a></li>
                            </ul>
                        </li>
                        <li class="gallery_link treeview">
                            <a href="">
                                <i class="fa fa-bookmark-o"></i> <span>Gallery</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add_gallery_link"><a href="<?php echo site_url('university/addGallery'); ?>"><i class="fa  fa-bookmark-o"></i>Add/Show Gallery</a></li>
                            </ul>
                        </li>
                        <li class="events_link treeview">
                            <a href="">
                                <i class="fa fa-money"></i> <span>Events</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add_show_events_link"><a href="<?php echo site_url('university/event'); ?>"><i class="fa fa-money"></i>Add/Show Event</a></li>
                            </ul>
                        </li>
                        <li class="news_link treeview">
                            <a href="">
                                <i class="fa fa-newspaper-o"></i> <span>News</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add_show_news"><a href="<?php echo site_url('university/news'); ?>"><i class="fa fa-newspaper-o"></i>Add/Show News</a></li>
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
                                <li class="notfication_link"><a href="<?php echo site_url('university/notifications'); ?>"><i class="fa fa-bell-o"></i>View Notifications</a></li>
                            </ul>
                        </li>
                        <li class="placement_link treeview">
                            <a href="">
                                <i class="fa fa-paper-plane"></i> <span>Placement</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add_showPlacement_link"><a href="<?php echo site_url('university/placement'); ?>"><i class="fa fa-paper-plane"></i>Add/Show Placement</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="add_showStudentPlacement_link"><a href="<?php echo site_url('university/placedStudents'); ?>"><i class="fa fa-paper-plane"></i>Add/Show Placed Students</a></li>
                            </ul>
                        </li>
                        <li class="achievement_link treeview">
                            <a href="">
                                <i class="fa fa-angellist"></i> <span>Achievement</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="addShowAchievement"><a href="<?php echo site_url('university/achievement'); ?>"><i class="fa fa-angellist"></i>Add/Show Achievement</a></li>
                            </ul>
                        </li>
                        <li class="faculty_link treeview">
                            <a href="">
                                <i class="fa fa-plus-circle"></i> <span>Faculty</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="addShowFaculty"><a href="<?php echo site_url('university/faculty'); ?>"><i class="fa fa-plus-circle"></i>Add/Show Faculty</a></li>
                            </ul>
                        </li>
                        <li class="advertisetment_link treeview">
                            <a href="">
                                <i class="fa fa-adjust"></i> <span>Advertisement</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="advertisement"><a href="<?php echo site_url('university/advertisement'); ?>"><i class="fa fa-adjust"></i>Add/Show Advertisement</a></li>
                            </ul>
                        </li>
                        <li class="analytics_link treeview">
                            <a href="">
                                <i class="fa fa-bar-chart"></i> <span>Analytics</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="analytics"><a href="<?php echo site_url('university/analytics'); ?>"><i class="fa fa-chart"></i>View Analytics</a></li>
                            </ul>
                        </li>
                        <li class="nlpb_link treeview">
                            <a href="">
                                <i class="fa fa-envelope"></i> <span>News Letter</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nlpbAddShow"><a href="<?php echo site_url('university/newsletterplanbuy'); ?>"><i class="fa fa-envelope-o"></i>News Letter Plan Buy</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="nlpbSend"><a href="<?php echo site_url('university/sendnewsletter'); ?>"><i class="fa fa-send-o"></i>Send News Letter</a></li>
                            </ul>
                        </li>
                        <li class="myEnrollments treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Enrollments/Enquiries</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="myEnrollmentsview"><a href="<?php echo site_url('university/enrollments'); ?>"><i class="fa fa-file-text-o"></i>View Enrollments</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="myEnquiriesview"><a href="<?php echo site_url('university/enquiries'); ?>"><i class="fa fa-file-text-o"></i>View Enquiries</a></li>
                            </ul>
                        </li>
                        <li class="promoCode_link treeview">
                            <a href="">
                                <i class="fa fa-handshake-o"></i> <span>Promocode</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="addShowPromocode"><a href="<?php echo site_url('university/promoCodes'); ?>"><i class="fa fa-handshake-o"></i>Add|Remove Promocode</a></li>
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
                                <li class="addTestimonials"><a href="<?php echo site_url('university/addTestimonials'); ?>"><i class="fa fa-quote-left"></i>Add | Show Testimonials</a></li>
                            </ul>
                        </li>
                        <li class="blogs treeview">
                            <a href="">
                                <i class="fa fa-rss-square"></i> <span>Blogs</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="addBlogs"><a href="<?php echo site_url('university/addBlog'); ?>"><i class="fa fa-rss-square"></i>Add | Show Blogs</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
            </aside>
