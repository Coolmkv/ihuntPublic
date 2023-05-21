<?php
include_once 'college_header.php';
if (isset($details)) {
    $totalemployees = $details->totalemployees;
    $totalpages = $details->totalpages;
    $courses = $details->courses;
    $totalstreams = $details->totalstreams;
//    $totaleligibility       =       $details->totaleligibility;
    $totalbrochures = $details->totalbrochures;
    $totalimages = $details->totalimages;
    $totalevents = $details->totalevents;
    $totalnews = $details->totalnews;
    $totalplacements = $details->totalplacements;
    $totalachievements = $details->totalachievements;
    $totalrunning_status = $details->totalrunning_status;
    $totaladvertisement = $details->totaladvertisement;
    $totalnewsL = $details->totalnewsL;
    $totalenroll = $details->totalenroll;
} else {
    $totalemployees = "NA";
    $totalpages = "NA";
    $courses = "NA";
    $totalstreams = "NA";
    $totaleligibility = "NA";
    $totalbrochures = "NA";
    $totalimages = "NA";
    $totalevents = "NA";
    $totalnews = "NA";
    $totalplacements = "NA";
    $totalachievements = "NA";
    $totalrunning_status = "NA";
    $totaladvertisement = "NA";
    $totalnewsL = "NA";
    $totalenroll = "NA";
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
            College Dashboard
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>College Dashboard</a></li>
            <li class="active">Here</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/editprofile'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal-active"><i class="fa  fa-pencil"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Edit Profile</span>
                            <span class="info-box-number"><?php echo ($profileCompletion ? $profileCompletion . ' % Completed' : "&nbsp;" ) ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/profile'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-eye"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">View Profile</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/orgUser'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-orange-active"><i class="fa fa-user-secret"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Concerned Person Details</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/financialDetails'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-active"><i class="fa fa-rupee"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Financial Details</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/approvalDocuments'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal-active"><i class="fa fa-file-pdf-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Approval Document Upload</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/sliderImages'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-image"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Slider Images</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/addPages'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa  fa-file-text-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Pages</span>
                            <span class="info-box-number"><?php echo $totalpages; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/addCourse'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-navy"><i class="fa fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Courses</span>
                            <span class="info-box-number"><?php echo $courses; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/addStreams'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-olive"><i class="fa fa-tasks"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Streams</span>
                            <span class="info-box-number"><?php echo $totalstreams; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!--            <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?php // echo site_url('college/eligibility');             ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-eject"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Add Eligibility Criteria</span>
                                        <span class="info-box-number"><?php // echo $totaleligibility;              ?></span>
                                    </div>

                                     /.info-box-content
                                </div>
                            </a>
                             /.info-box
                        </div>-->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/showBrochure'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue"><i class="fa fa-commenting"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Brochures</span>
                            <span class="info-box-number"><?php echo $totalbrochures; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/addGallery'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal-active"><i class="fa fa-image"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Images</span>
                            <span class="info-box-number"><?php echo $totalimages; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/event'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-orange-active"><i class="	fa fa-calendar-check-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Events</span>
                            <span class="info-box-number"><?php echo $totalevents; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/news'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-purple"><i class="fa fa-newspaper-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add News</span>
                            <span class="info-box-number"><?php echo $totalnews; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/placement'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-paper-plane"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Placements</span>
                            <span class="info-box-number"><?php echo $totalplacements; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/faculty'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-active"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Employees</span>
                            <span class="info-box-number"><?php echo $totalemployees; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/achievement'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-angellist"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Achievements</span>
                            <span class="info-box-number"><?php echo $totalachievements; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/runningStatus'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal"><i class="fa fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Running Status</span>
                            <span class="info-box-number"><?php echo $totalrunning_status; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/advertisement'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-gray-light"><i class="fa fa-adjust"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Advertisement</span>
                            <span class="info-box-number"><?php echo $totaladvertisement; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/analytics'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-active"><i class="fa fa-bar-chart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Analytics</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/newsletterplanbuy'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-envelope"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">News Letter Plan Buy</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/sendnewsletter'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-paper-plane-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Send News Letter</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/enrollments'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-gradient"><i class="fa fa-file-text-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">View Enrollments</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('college/promoCodes'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal-gradient"><i class="fa fa-handshake-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Promocode</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                    </div>
                </a>
            </div>
            <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
</div>
<?php include_once 'college_footer.php'; ?>
<script>
    document.title = 'iHuntBest | Dashboard';
    $("document").ready(function () {
        var profileCStatus = <?php echo $profileCompletion; ?>;
        if (profileCStatus < 60) {

            $.alert({title: 'Error!', content: "Please complete your profile first.", type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: function () {
                        window.location.href = '<?php echo site_url("college/editprofile"); ?>';
                    }
                }
            });
        }
    });
    $(".dashboard_item").addClass("active");
</script>
