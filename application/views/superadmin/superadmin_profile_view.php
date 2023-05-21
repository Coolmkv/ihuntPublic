<?php
include_once 'superadmin_header.php';
if (isset($profileDetail)) {
    $id = $profileDetail->id;
    $userName = $profileDetail->userName;
    $userMobile = $profileDetail->userMobile;
    $userEmail = $profileDetail->userEmail;
    $website_email_id = $profileDetail->website_email_id;
    $userType = $profileDetail->userType;
    $userPassword1 = $profileDetail->userPassword1;
} else {
    $id = 'N/A';
    $userName = 'N/A';
    $userMobile = 'N/A';
    $userEmail = 'N/A';
    $website_email_id = 'N/A';
    $userType = 'N/A';
    $userPassword1 = 'N/A';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('superadmin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active">View Profile</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profile Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                    <u>Name:</u>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $userName; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                    <u>Mobile:</u>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $userMobile; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                    <u>Email:</u>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $userEmail; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                    <u>Website Email:</u>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $website_email_id; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                    <u>User Type:</u>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $userType; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                    <u>Password:</u>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $userPassword1; ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br><br><br><br>
                                <a href="<?php echo site_url('superadmin/editprofile'); ?>"><button style="margin-top:3px;width: 135px" class="form-control btn btn-primary" type="submit" name="header_submit" id="header_submit">Edit Profile</button></a>&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <!--/.col -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    $(".profile_link").addClass("active");
    $(".view_profile_link").addClass("active");
    document.title = "iHuntBest | View Profile Details";
</script>