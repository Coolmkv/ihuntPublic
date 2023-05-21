<?php
if (!isset($_SESSION['userType']) || !isset($_SESSION['loginId'])) {
    redirect('Register/logout');
} else {
    if ($_SESSION['userType'] != 'School') {
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
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <link href="<?php echo base_url('css/404style.css?v=1.7'); ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/skins/skin-blue.min.css">
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/checkbox.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/fontawesome-iconpicker.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <link rel="stylesheet" href="<?php echo base_url('plugins\summernote\summernote.css'); ?>">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>


        <![endif]-->
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
                <a target="_blank" href="<?php echo site_url('home/index'); ?>" class="logo">
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
                                    <li class="user-footer chngpassword">
                                        <a href="<?php echo site_url('school/changePassword'); ?>" class="btn btn-default btn-flat">Change Password</a>
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
                                <i class="fa fa-dashboard"></i> <span>School Dashboard</span>
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
                                <li class="edit_profile_link"><a href="<?php echo site_url('school/editprofile'); ?>"><i class="fa fa-pencil"></i>Edit Profile</a></li>
                                <li class="view_profile_link"><a href="<?php echo site_url('school/profile'); ?>"><i class="fa fa-users"></i>View Profile</a></li>
                                <li class="profile_header_link"><a href="<?php echo site_url('school/profileHeaders'); ?>"><i class="fa fa-photo"></i>Profile Header Manage</a></li>
                                <li class="view_concerned_link"><a href="<?php echo site_url('school/orgUser'); ?>"><i class="fa fa-user"></i>Concerned Person Details</a></li>
                                <li class="view_Finacial_link"><a href="<?php echo site_url('school/financialDetails'); ?>"><i class="fa fa-rupee"></i>Financial Details</a></li>
                                <li class="view_approval_link"><a href="<?php echo site_url('school/approvalDocuments'); ?>"><i class="fa fa-file-pdf-o"></i>Approval Document Upload</a></li>
                                <li class="sliderimage_link"><a href="<?php echo site_url('school/sliderImages'); ?>"><i class="fa fa-image"></i>Add | Remove Slider Images</a></li>
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
                                <li class="add_pages_link"><a href="<?php echo site_url('school/addPages'); ?>"><i class="fa  fa-file-text-o"></i>Add Pages</a></li>
                            </ul>
                        </li>
                        <li class="add_Classes_link treeview">
                            <a href="">
                                <i class="fa fa-cog"></i> <span>Add Classes</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add_Classes"><a href="<?php echo site_url('school/addClasses'); ?>"><i class=" fa fa-cog"></i>Add | Show Classes</a></li>

                            </ul>
                        </li>
                        <li class="brochures_link treeview">
                            <a href="">
                                <i class="fa fa-commenting"></i> <span>Brochures</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">

                                <li class="addshowBrouchers"><a href="<?php echo site_url('school/showBrochure'); ?>"><i class="fa fa-commenting"></i>Add/Show Brochures</a></li>
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
                                <li class="add_gallery_link"><a href="<?php echo site_url('school/addGallery'); ?>"><i class="fa  fa-bookmark-o"></i>Add/Show Gallery</a></li>
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
                                <li class="add_show_events_link"><a href="<?php echo site_url('school/event'); ?>"><i class="fa fa-money"></i>Add/Show Event</a></li>
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
                                <li class="addShowFaculty"><a href="<?php echo site_url('school/faculty'); ?>"><i class="fa fa-plus-circle"></i>Add/Show Faculty</a></li>
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
                                <li class="add_show_news"><a href="<?php echo site_url('school/news'); ?>"><i class="fa fa-newspaper-o"></i>Add/Show News</a></li>
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
                                <li class="notfication_link"><a href="<?php echo site_url('school/notifications'); ?>"><i class="fa fa-bell-o"></i>View Notifications</a></li>
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
                                <li class="addShowAchievement"><a href="<?php echo site_url('school/achievement'); ?>"><i class="fa fa-angellist"></i>Add/Show Achievement</a></li>
                            </ul>
                        </li>

                        <li class="runningstatus_link treeview">
                            <a href="">
                                <i class="fa fa-user"></i> <span>Running Status</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="runningstatus_link"><a href="<?php echo site_url('school/runningStatus'); ?>"><i class="fa fa-users"></i>Add/Show Running Status</a></li>
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
                                <li class="advertisement"><a href="<?php echo site_url('school/advertisement'); ?>"><i class="fa fa-adjust"></i>Add/Show Advertisement</a></li>
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
                                <li class="analytics"><a href="<?php echo site_url('school/analytics'); ?>"><i class="fa fa-chart"></i>View Analytics</a></li>
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
                                <li class="nlpbAddShow"><a href="<?php echo site_url('school/newsletterplanbuy'); ?>"><i class="fa fa-envelope-o"></i>News Letter Plan Buy</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="nlpbSend"><a href="<?php echo site_url('school/sendnewsletter'); ?>"><i class="fa fa-send-o"></i>Send News Letter</a></li>
                            </ul>
                        </li>
                        <li class="myEnrollments treeview">
                            <a href="">
                                <i class="fa fa-file-text-o"></i> <span>Enrollments</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="myEnrollmentsview"><a href="<?php echo site_url('school/enrollments'); ?>"><i class="fa fa-file-text-o"></i>View Enrollments</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="myEnquiriesview"><a href="<?php echo site_url('school/enquiries'); ?>"><i class="fa fa-file-text-o"></i>View Enquiries</a></li>
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
                                <li class="addShowPromocode"><a href="<?php echo site_url('school/promoCodes'); ?>"><i class="fa fa-handshake-o"></i>Add|Remove Promocode</a></li>
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
                                <li class="addTestimonials"><a href="<?php echo site_url('school/addTestimonials'); ?>"><i class="fa fa-quote-left"></i>Add | Show Testimonials</a></li>
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
                                <li class="addBlogs"><a href="<?php echo site_url('school/addBlog'); ?>"><i class="fa fa-rss-square"></i>Add | Show Blogs</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
            </aside>