<?php include_once 'student_header.php'; 
if(isset($details)){
    
    $totalNotifications     =       $details->totalNotifications;

}else{
    
    
    $totalNotifications     =       "0";
}
if(isset($profileStatus)){
    $profileStatus      =   $profileStatus;
}else{
    $profileStatus      =   0;
}
if(isset($secSchool)){
    $secSchool      =   $secSchool;
}else{
    $secSchool      =       0;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Student Dashboard
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Here</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentProfile');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">View Profile</span>
                            <span class="info-box-number"><?php echo $profileStatus.' %'; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentPersonalDetails');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-maroon-gradient"><i class="fa fa-user-secret"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Edit Personal Info.</span>
                            <span class="info-box-number"><?php echo $profileStatus.' %'; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentSecondarySchoolDetails');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-navy"><i class="fa fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Student Sec. School Details Edit</span>
                            <span class="info-box-number"><?php echo $secSchool.' %'; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentSenSecondarySchoolDetails');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-orange-active"><i class="fa fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Student Sr. Sec. School Details Edit</span>
                            <span class="info-box-number"><?php echo $secSchool.' %'; ?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentHigherEducationDetails');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-orange-active"><i class="fa fa-university"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Student Higher Details Edit</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentCompetitiveExamDetails');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-book"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Competitive Exam Details</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentUploadRelatedDocuments');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-active"><i class="fa fa-upload"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Upload Related Documents</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentExperienceDetails');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-olive"><i class="fa fa-certificate"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Experience</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box studentJobProfileDetails-->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentJobPreferenceDetails');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal-active"><i class="fa fa-file-text-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Job Preference</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentDashboard');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-active"><i class="	fa fa-bar-chart-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Test Result</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('myNotifications');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-active"><i class="fa fa-bell-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Notifications</span>
                            <span class="info-box-number"><?php echo $totalNotifications;?></span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('studentReferenceDetails');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-purple"><i class="fa fa-plus-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Refers</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('earnandsharevalue');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-green-gradient"><i class="fa fa-dollar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Earn and Share</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo site_url('myApplications');?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua-gradient"><i class="fa fa-file-text-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">My Applications</span>
                            <span class="info-box-number">&nbsp;</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->
</div>
<?php include_once 'student_footer.php';?>
<script>
 
$(".dashboard_item").addClass("active");
</script>
