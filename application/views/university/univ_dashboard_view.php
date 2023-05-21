<?php
include_once 'university_header.php';
if (isset($details)) {
    $totaldepartments = $details->totaldepartments;
    $totalpages = $details->totalpages;
    $totalcourses = $details->totalcourses;
    $totalstreams = $details->totalstreams;
    $totalbrouchers = $details->totalbrouchers;
    $totalgallery = $details->totalgallery;
    $totalevent_details = $details->totalevent_details;
    $totalnews = $details->totalnews;
    $totalplacement = $details->totalplacement;
    $totalachievement = $details->totalachievement;
    $totalfaculty = $details->totalfaculty;
    $totaladvertisement = $details->totaladvertisement;
} else {
    $totaldepartments = 'No Data';
    $totalpages = 'No Data';
    $totalcourses = 'No Data';
    $totalstreams = 'No Data';
    $totalbrouchers = 'No Data';
    $totalgallery = 'No Data';
    $totalevent_details = 'No Data';
    $totalnews = 'No Data';
    $totalplacement = 'No Data';
    $totalachievement = 'No Data';
    $totalfaculty = 'No Data';
    $totaladvertisement = 'No Data';
}
if (isset($profilec)) {
    $profileCompletion = $profilec;
} else {
    $profileCompletion = "";
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            University Dashboard
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i>University Dashboard</a></li>
            <li class="active">Here</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-aqua" style="background-color: #00c0ef !important;">
                    <div class="inner">
                        <h3><?php echo ($profileCompletion ? $profileCompletion . ' %' : "&nbsp;" ) ?></h3>
                        <p>Profile View</p>
                    </div>
                    <div class="icon"><i class="fa  fa-users"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/profile'); ?>">View Profile
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-blue-gradient" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>Profile Edit</p>
                    </div>
                    <div class="icon"><i class="fa  fa-pencil"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/editprofile'); ?>">View Edit
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-teal" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>Concerned Person Details</p>
                    </div>
                    <div class="icon"><i class="fa  fa-pencil"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/orgUser'); ?>">Concerned Person Details Edit
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-green-active" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>Financial Details</p>
                    </div>
                    <div class="icon"><i class="fa  fa-rupee"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/financialDetails'); ?>">Financial Details
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-light-blue-gradient" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>Approval Documents Upload</p>
                    </div>
                    <div class="icon"><i class="fa  fa-file-pdf-o"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/approvalDocuments'); ?>">Approval Documents Upload
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-teal-gradient" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>Add | Remove Slider Images</p>
                    </div>
                    <div class="icon"><i class="fa  fa-picture-o"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/sliderImages'); ?>">Add | Remove Slider Images
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-teal" >
                    <div class="inner">
                        <h3><?php echo $totaldepartments; ?></h3>
                        <p>Department</p>
                    </div>
                    <div class="icon"><i class="fa  fa-file-text-o"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/addDepartment'); ?>">Add Department
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-aqua" >
                    <div class="inner">
                        <h3><?php echo $totalpages; ?></h3>
                        <p>Pages</p>
                    </div>
                    <div class="icon"><i class="fa  fa-paperclip"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/addPages'); ?>">Add Pages
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-olive-active" >
                    <div class="inner">
                        <h3><?php echo $totalcourses; ?></h3>
                        <p>Course</p>
                    </div>
                    <div class="icon"><i class="fa fa-cog"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/addCourse'); ?>">Add Course
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-blue-gradient" >
                    <div class="inner">
                        <h3><?php echo $totalstreams; ?></h3>
                        <p>Streams</p>
                    </div>
                    <div class="icon"><i class="fa fa-tasks"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/addStreams'); ?>">Add Streams
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-aqua-gradient" >
                    <div class="inner">
                        <h3><?php echo $totalstreams; ?></h3>
                        <p>Streams</p>
                    </div>
                    <div class="icon"><i class="fa fa-tasks"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/showStreams'); ?>">View Streams
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-green-active" >
                    <div class="inner">
                        <h3><?php echo $totalbrouchers; ?></h3>
                        <p>Brochures </p>
                    </div>
                    <div class="icon"><i class="fa fa-commenting"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/showBrochure'); ?>">View Brochures
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-purple-gradient" >
                    <div class="inner">
                        <h3><?php echo $totalgallery; ?></h3>
                        <p>Gallery</p>
                    </div>
                    <div class="icon"><i class="fa fa-image"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/addGallery'); ?>">Add Gallery
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-blue-gradient" >
                    <div class="inner">
                        <h3><?php echo $totalevent_details; ?></h3>
                        <p>Event</p>
                    </div>
                    <div class="icon"><i class="fa fa-money"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/event'); ?>">Add Event
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-olive-active" >
                    <div class="inner">
                        <h3><?php echo $totalnews; ?></h3>
                        <p>News</p>
                    </div>
                    <div class="icon"><i class="fa fa-newspaper-o"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/news'); ?>">Add News
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-green-gradient" >
                    <div class="inner">
                        <h3><?php echo $totalplacement; ?></h3>
                        <p>Placement</p>
                    </div>
                    <div class="icon"><i class="fa fa-paper-plane"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/placement'); ?>">Add Placement
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-olive-active" >
                    <div class="inner">
                        <h3><?php echo $totalachievement; ?></h3>
                        <p>Achievement</p>
                    </div>
                    <div class="icon"><i class="fa fa-angellist"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/achievement'); ?>">Add Achievement
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-teal" >
                    <div class="inner">
                        <h3><?php echo $totalfaculty; ?></h3>
                        <p>Faculty</p>
                    </div>
                    <div class="icon"><i class="fa fa-plus-circle"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/faculty'); ?>">Add Faculty
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-yellow-active" >
                    <div class="inner">
                        <h3><?php echo $totaladvertisement; ?></h3>
                        <p>Advertisement</p>
                    </div>
                    <div class="icon"><i class="fa fa-adjust"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/advertisement'); ?>">Add Advertisement
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-green-gradient" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>Analytics</p>
                    </div>
                    <div class="icon"><i class="fa fa-bar-chart"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/analytics'); ?>">Analytics
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-yellow-gradient" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>News Letter</p>
                    </div>
                    <div class="icon"><i class="fa fa-envelope"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/newsletterplanbuy'); ?>">News Letter Plan Buy
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-blue-gradient" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>News Letter</p>
                    </div>
                    <div class="icon"><i class="fa fa-paper-plane"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/sendnewsletter'); ?>">Send News Letter
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-light-blue-gradient" >
                    <div class="inner">
                        <h3>&nbsp;</h3>
                        <p>Enrollments</p>
                    </div>
                    <div class="icon"><i class="fa fa-file-text-o"></i></div>
                    <a class="small-box-footer" href="<?php echo site_url('university/enrollments'); ?>">View Enrollments
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<?php include_once 'university_footer.php'; ?>
<script>
    document.title = "iHuntBest | Dashboard";
    $("document").ready(function () {
        var profileCStatus = <?php echo $profileCompletion; ?>;
        if (profileCStatus < 60) {

            $.alert({title: 'Error!', content: "Please complete your profile first.", type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: function () {
                        window.location.href = '<?php echo site_url("university/editprofile"); ?>';
                    }
                }
            });
        }
    });
    $(".dashboard_item").addClass("active");
</script>
