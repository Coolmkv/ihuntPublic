<?php
include_once 'institute_header.php';
if (isset($profileData)) {
    $orgLogo = $profileData->orgLogo;
    $orgImgHeader = $profileData->orgImgHeader;
    $orgName = $profileData->orgName;
    $orgMobile = $profileData->orgMobile;
    $email = $profileData->email;
    $country = $profileData->country;
    $state = $profileData->state;
    $city = $profileData->city;
    $orgAddress = $profileData->orgAddress;
    $orgType = $profileData->orgType;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('institute/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active"> View Profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- /.modal -->
        <div class="modal fade" id="LogoImage" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-user m-r-5"></i>Upload Logo</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open_multipart("institute/uploadProfileImage", ["name" => "logo_form", "class" => "form-horizontal", "id" => "logo_form"]) ?>
<!--                                        <input type="hidden" name="id" id="id" value="no_one">-->
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Upload Logo:</label>
                                        <input type="file" accept="image/x-png,image/gif,image/jpeg" name="orgLogo" id="orgLogo" class="form-control" required="true">
                                        <input type="hidden" name="logoimgname" class="hidden" value="<?php echo $orgLogo ?>">
                                    </div>
                                    <div class="col-md-12 form-group user-form-group">
                                        <div class="pull-right">
                                            <button type="submit" name="logo_upload" id="logo_upload" class="btn btn-primary">Upload</button>

                                        </div>
                                    </div>
                                </fieldset>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="HeaderImage" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-user m-r-5"></i>Upload Header Image</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open_multipart('institute/uploadHeaderImage', ["name" => "header_form"]); ?>
<!--                                        <input type="hidden" name="id" id="id" value="no_one">-->
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Upload Header Image:</label>
                                        <input type="file" accept="image/x-png,image/gif,image/jpeg" name="orgImgHeader" id="orgImgHeader"  class="form-control">
                                        <input type="hidden" name="Headerimgname" class="hidden" value="<?php echo $orgImgHeader ?>">
                                    </div>
                                    <div class="col-md-12 form-group user-form-group">
                                        <div class="pull-right">
                                            <button type="submit" name="header_upload" id="header_upload" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </fieldset>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profile Images</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 text-center">
                                <div class="form-group">
                                    <label>Logo</label>
                                    <img  style="height:210px;width: 300px" alt="No selected Logo"src="<?php if ($orgLogo == '') {
                                    echo $orgLogo; ?><?php } else {
                                    echo base_url($orgLogo);
                                } ?>" onerror="this.src='<?php echo base_url('projectimages/default.png'); ?>'" class="img-responsive img-thumbnail">
                                    <div class="text-center">
                                        <button style="margin-left:5px; margin-top: 5px;width: 100px" class="form-control btn btn-primary" type="submit" id="orgLogo" name="orgLogo" data-toggle="modal" data-target="#LogoImage">Edit Logo</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Header Image</label>
                                    <img  style="height:210px;width: 300px" alt="No selected Header Image" src="<?php if ($orgImgHeader == '') {
                                    echo $orgImgHeader; ?><?php } else {
                                    echo base_url($orgImgHeader);
                                } ?>" onerror="this.src='<?php echo base_url('projectimages/default.png'); ?>'" class="img-responsive img-thumbnail">
                                    <div class="text-center"><button style="margin-left:5px;margin-top:5px;width: 135px" class="form-control btn btn-primary" type="submit" name="header_submit" id="header_submit" data-toggle="modal" data-target="#HeaderImage">Edit Header Image</button></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!--/.col -->
                </div>
            </div>
        </div>
        <!-- /.row -->

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
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <u>Name:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $orgName; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <u>Mobile:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $orgMobile; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <u>Email:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $email; ?></label>
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
                                    <label><?php echo $city; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <u>Address:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $orgAddress; ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <u>Organization Type:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $orgType; ?></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <br><br><br><br>
                                <a href="<?php echo site_url('institute/editprofile'); ?>"><button style="margin-top:3px;width: 135px" class="form-control btn btn-primary" type="submit" name="header_submit" id="header_submit">Edit Profile</button></a>&nbsp;&nbsp;&nbsp;
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
<?php include_once 'institute_footer.php'; ?>
<script>
    $(".profile_link").addClass("active");
    $(".view_profile_link").addClass("active");
    document.title = "iHuntBest | Profile View";
</script>