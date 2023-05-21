<?php
include_once 'school_header.php';
if (isset($details)) {
    $totalemployees = $details->totalemployees;
    $totalpages = $details->totalpages;
    $classes = $details->classes;
    $totalbrochures = $details->totalbrochures;
    $totalimages = $details->totalimages;
    $totalevents = $details->totalevents;
    $totalnews = $details->totalnews;
    $totalachievements = $details->totalachievements;
    $totalrunning_status = $details->totalrunning_status;
    $totaladvertisement = $details->totaladvertisement;
    $totaldocs = $details->totaldocs;
    $visitorCount = $details->visitorCount;
    $nlpbuy = $details->nlpbuy;
    $totalenrollments = $details->totalenrollments;
    $promoCodes = $details->promoCodes;
    $testimonials = $details->testimonials;
    $blogs = $details->blogs;
} else {

    $totalemployees = "NA";
    $totalpages = "NA";
    $classes = "NA";
    $totalbrochures = "NA";
    $totalimages = "NA";
    $totalevents = "NA";
    $totalnews = "NA";
    $totalachievements = "NA";
    $totalrunning_status = "NA";
    $totaladvertisement = "NA";
    $totaldocs = 0;
    $visitorCount = 0;
    $nlpbuy = 0;
    $totalenrollments = 0;
    $promoCodes = 0;
    $testimonials = 0;
    $blogs = 0;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            School Dashboard
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>School Dashboard</a></li>
            <li class="active">Here</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/editprofile'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-pencil"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Edit Profile</span>
                            <span class="info-box-text"><?php
                                if (isset($profilec)) {
                                    echo $profilec . ' % Completed';
                                }
                                ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/profile'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">View Profile</span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/orgUser'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Concerned Person Details</span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/financialDetails'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-active"><i class="fa fa-rupee"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Financial Details</span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i>&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/approvalDocuments'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-black-gradient"><i class="fa fa-file-pdf-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Approval Document Upload</span>
                            <span class="info-box-number"><?php echo $totaldocs; ?>&nbsp;</span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/sliderImages'); ?>">
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
                <a href="<?php echo site_url('school/addPages'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa  fa-file-text-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Pages</span>
                            <span class="info-box-number"><?php echo $totalpages; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/addClasses'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-navy"><i class="fa fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Classes</span>
                            <span class="info-box-number"><?php echo $classes; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/showBrochure'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-olive"><i class="fa fa-commenting"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Brochures</span>
                            <span class="info-box-number"><?php echo $totalbrochures; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/addGallery'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal-active"><i class="fa fa-image"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Images</span>
                            <span class="info-box-number"><?php echo $totalimages; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/event'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-orange-active"><i class="	fa fa-calendar-check-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Events</span>
                            <span class="info-box-number"><?php echo $totalevents; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/faculty'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-active"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Employees</span>
                            <span class="info-box-number"><?php echo $totalemployees; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/news'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-purple"><i class="fa fa-newspaper-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total News</span>
                            <span class="info-box-number"><?php echo $totalnews; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/achievement'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue"><i class="fa fa-angellist"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Achievements</span>
                            <span class="info-box-number"><?php echo $totalachievements; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/runningStatus'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal"><i class="fa fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Running Status</span>
                            <span class="info-box-number"><?php echo $totalrunning_status; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/advertisement'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-gray-light"><i class="fa fa-adjust"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Advertisement</span>
                            <span class="info-box-number"><?php echo $totaladvertisement; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/analytics'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-active"><i class="fa fa-bar-chart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Analytics</span>
                            <span class="info-box-number"><?php echo $visitorCount; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/newsletterplanbuy'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-envelope"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">News Letter Plan Buy</span>
                            <span class="info-box-number"><?php echo $nlpbuy; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/sendnewsletter'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-paper-plane-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Send News Letter</span>
                            <span class="info-box-number">&nbsp;</span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/enrollments'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-gradient"><i class="fa fa-file-text-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">View Enrollments</span>
                            <span class="info-box-number"><?php echo $totalenrollments; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/promoCodes'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue-gradient"><i class="fa fa-handshake-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Promocodes</span>
                            <span class="info-box-number"><?php echo $promoCodes; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/addTestimonials'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-lime-active"><i class="fa fa-quote-right"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Testimonials</span>
                            <span class="info-box-number"><?php echo $testimonials; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('school/addBlog'); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal-gradient"><i class="fa fa-rss-square"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Blogs</span>
                            <span class="info-box-number"><?php echo $blogs; ?></span>
                            <span class="info-box-number"><i class="fa fa-arrow-circle-o-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
</div>
<?php include_once 'school_footer.php'; ?>
<script>

    $(".dashboard_item").addClass("active");
</script>
