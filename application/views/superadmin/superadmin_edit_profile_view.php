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
    $privacypolicy = $profileDetail->privacypolicy;
} else {
    $id = 'no_data';
    $userName = 'N/A';
    $userMobile = 'N/A';
    $userEmail = 'N/A';
    $website_email_id = 'N/A';
    $userType = 'N/A';
    $userPassword1 = 'N/A';
    $privacypolicy = "";
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('superadmin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active">Edit Profile</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Details</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open('superadmin/saveprofile', ['id' => 'form_details', 'name' => 'form_details']); ?>
                        <div class="row">
                            <input type="hidden" value="<?php echo $id; ?>" name="id" id="user_id">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="userName" id="userName" value="<?php echo $userName; ?>" placeholder="Name" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="number" maxlength="10" name="userMobile" id="userMobile" value="<?php echo $userMobile; ?>" placeholder="Mobile" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="userEmail" id="userEmail" value="<?php echo $userEmail; ?>" placeholder="Email" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Website Email</label>
                                    <input type="email" name="website_email_id" id="website_email_id" value="<?php echo $website_email_id; ?>" placeholder="Website Email" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" minlength="8" name="userPassword1" id="userPassword1" value="<?php echo $userPassword1; ?>" placeholder="Password" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Privacy Policy</label>
                                    <textarea class="form-control summernote" id="privacypolicyId" name="privacypolicy" placeholder="Privacy Policy"><?php echo $privacypolicy; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">
                            </div>

                        </div>
                        <?php echo form_close(); ?>
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
    $(".edit_profile_link").addClass("active");
    document.title = "iHuntBest | View Profile Details";
    $(document).ready(function () {
        $('.summernote').summernote();
        $('#save_details').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({
                            title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        $.alert({
                            title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true
                        });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#form_details').ajaxForm(options);
        });
    });
</script>