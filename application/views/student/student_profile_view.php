<?php
include_once 'student_header.php';

if (isset($profileinfo)) {
    $studentName = $profileinfo->studentName;
    $studentMobile = $profileinfo->studentMobile;
    $gender = $profileinfo->gender;
    $date_of_birth = $profileinfo->date_of_birth;
    $country = $profileinfo->ctryname;
    $state = $profileinfo->statename;
    $ctyname = $profileinfo->ctyname;
    $location = $profileinfo->location;
    $relegion = $profileinfo->religionName;
    $fatherName = $profileinfo->fatherName;
    $placeofBirth = $profileinfo->placeofBirth;
    $studentImage = $profileinfo->studentImage;
} else {
    $studentName = '';
    $studentMobile = '';
    $gender = '';
    $date_of_birth = '';
    $country = '';
    $state = '';
    $ctyname = '';
    $location = '';
    $relegion = '';
    $fatherName = '';
    $placeofBirth = '';
    $studentImage = '';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Student Profile View
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student'); ?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">View Profile</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Personal Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Name:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $studentName; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Father:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $fatherName; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Mobile:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $studentMobile; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Gender:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $gender; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Birth date:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $date_of_birth; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Birth Place:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $placeofBirth; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Religion:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $relegion; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Country:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $country; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>State:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $state; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>City:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $ctyname; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Location:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo $location; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Profile Pic:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <img class="img-responsive" onerror="this.src='<?php echo base_url('homepage_images/default.png'); ?>'" src="<?php echo base_url($studentImage); ?>">
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <br>
                                    <a href="<?php echo site_url('studentPersonalDetails'); ?>"><button style="margin-top:3px;width: 145px" class="form-control btn btn-primary" type="submit" name="header_submit" id="header_submit">Edit Personal Details</button></a>&nbsp;&nbsp;&nbsp;


                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                </section>
                <!-- /.content -->
            </div>
            <?php include_once 'student_footer.php'; ?>
            <script>
                $(".profile_link").addClass("active");
                $(".view_profile_link").addClass("active");
                document.title = "iHuntBest | Student Profile";

            </script>
