<?php include_once 'college_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<style>
    .active a
    {color:#FFF !important;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Password
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('college/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Password</a></li>
            <li class="active">Change Password</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Password</h3>
                    </div>
                    <?php echo form_open_multipart('college/changePasswordSave', ["id" => "password_form", "name" => "password_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label>Confirm Password <span class="hidden newpass" style="color:red"> Not Matched</span><span class="hidden newpassm" style="color:green"> Matched</span></label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" style="text-align: center">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="change_pass" id="change_pass" value="Change Password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <!--/.col -->
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<?php include_once 'college_footer.php'; ?>
<script>
    $(".chngpassword").addClass("active");
    document.title = "iHuntBest | Change Password";
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $.validate({
            lang: 'en'
        });
        $("#confirm_password").keyup(function () {
            if ($("#new_password").val() !== $(this).val()) {
                $(".newpassm").addClass("hidden");
                $(".newpass").removeClass("hidden");
            } else {
                $(".newpass").addClass("hidden");
                $(".newpassm").removeClass("hidden");
            }
        });
        $('#change_pass').click(function () {
            var options = {
                beforeSend: function () {
                    var newpass = $("#new_password").val();
                    var conpass = $("#confirm_password").val();
                    if (newpass !== conpass) {
                        $("#confirm_password").focus();
                        $.alert({
                            title: 'Error!', content: 'Password Not Matched', type: 'red',
                            typeAnimated: true
                        });

                        return false;
                    } else {

                    }
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
            $('#password_form').ajaxForm(options);
        });
    });
</script>