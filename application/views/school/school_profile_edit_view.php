<?php
include_once 'school_header.php';
if (isset($profileData)) {
    $orgName = $profileData->orgName;
    $orgMobile = $profileData->orgMobile;
    $email = $profileData->email;
    $country = $profileData->country;
    $state = $profileData->state;
    $city = $profileData->city;
    $orgAddress = $profileData->orgAddress;
    $orgType = $profileData->orgType;
    $directorName = $profileData->directorName;
    $directorEmail = $profileData->directorEmail;
    $directorMobile = $profileData->directorMobile;
    $orgWebsite = $profileData->orgWebsite;
    $approvedBy = $profileData->approvedBy;
    $orgDesp = $profileData->orgDesp;
    $orgMission = $profileData->orgMission;
    $orgVission = $profileData->orgVission;
    $countryId = $profileData->countryId;
    $stateId = $profileData->stateId;
    $cityId = $profileData->cityId;
    $orgGoogle = $profileData->orgGoogle;
    $org_landline = $profileData->org_landline;
    $orgEstablished = $profileData->orgEstablished;
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
            <li><a href="<?php echo site_url('school/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active"> Edit Profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Profile</h3>
                    </div>

                    <?php echo form_open('school/updateProfile', ["id" => "profile_form", "name" => "profile_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Director Name</label>
                                    <input type="text" name="directorName" id="directorName" value="<?php echo $directorName; ?>" class="form-control" placeholder="Director Name" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Director Mobile</label>
                                    <input type="text" name="directorMobile" id="directorMobile" value="<?php echo $directorMobile; ?>" class="form-control" placeholder="Director Mobile" data-validation="number length required"
                                           data-validation-length="10">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Director Email</label>
                                    <input type="email" name="directorEmail" id="directorEmail" value="<?php echo $directorEmail; ?>"   class="form-control" placeholder="Director Email" data-validation="required">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Organization Name</label>
                                    <input type="text" name="orgName" id="orgName" class="form-control" value="<?php echo $orgName; ?>" placeholder="Organization Name" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Organization Mobile</label>
                                    <input type="text" name="orgMobile" id="orgMobile" class="form-control" value="<?php echo $orgMobile; ?>" placeholder="Organization Mobile" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Organization Landline</label>
                                    <input type="text" name="org_landline" id="org_landline" class="form-control" placeholder="Landline No."    value="<?php echo $org_landline; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Organization Email</label>
                                    <input type="text" name="orgEmail" id="orgEmail" class="form-control" placeholder="Organization Email" value="<?php echo $email; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Organization Type</label>
                                    <select name="orgType" id="orgType" class="form-control"
                                            data-validation="required">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Google Map Iframe</label>
                                    <input type="text" name="orgGoogle" id="orgGoogle" placeholder="Google Map Iframe" class="form-control" value='<?php echo $orgGoogle; ?>'>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Organization Country <u
                                            style="background-color: sandybrown">(<?php echo $country; ?>
                                            )</u></label>
                                    <select name="countryId" id="countryId" class="form-control" data-validation="required"></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Organization State <u
                                            style="background-color: sandybrown">(<?php echo $state; ?>)</u></label>
                                    <select name="stateId" id="stateId" class="form-control" data-validation="required"></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Organization City <u
                                            style="background-color: sandybrown">(<?php echo $city; ?>)</u></label>
                                    <select name="cityId" id="cityId" class="form-control" data-validation="required"></select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Website Url</label>
                                    <input type="text" name="orgWebsite" id="orgWebsite" class="form-control" value="<?php echo $orgWebsite; ?>" placeholder="Website Url"  data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Approved By</label>
                                    <input type="text" name="approvedBy" id="approvedBy" class="form-control" value="<?php echo $approvedBy; ?>" placeholder="Approved By" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Organization Address</label>
                                    <input type="text" placeholder="Organization Address" name="address" id="address" class="form-control"   data-validation="required" value="<?php echo $approvedBy; ?>">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Organization Establish Date</label>
                                    <input type="date" placeholder="Organization Establish Date" name="orgEstablished" id="orgEstablished" class="form-control" value="<?php echo $orgEstablished; ?>">

                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea name="orgDesp" id="orgDesp" class="form-control summernote"    data-validation="required"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Our Mission</label>
                                <textarea name="orgMission" id="orgMission" class="form-control summernote" placeholder="Our Mission" data-validation="required"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Our Vision</label>
                                <textarea name="orgVission" id="orgVission" class="form-control summernote" placeholder="Our Vision"  data-validation="required"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="font-size: medium"><u>Facilities</u></label><br>
                                    <div class="pull-right" style="margin-right: 20px">
                                        <a class="btn btn-primary" id="request_facility" name="request_facility" href="#" data-toggle="modal" data-target="#addfacilities"> <i class="fa fa-plus"></i> Request Facility</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 nopadding" id="facilities_div"></div>

                            </div>
                            <div class="col-md-2" style="float: right">
                                <div class="form-group">
                                    <label></label>
                                    <input style="margin-top:3px" type="submit" class="form-control btn btn-primary" name="save_profile" id="save_profile">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <!--/.col -->
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- /.modal -->
        <div class="modal fade" id="requestFacilities" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-user m-r-5"></i>Request Facilities</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">

                                <?php echo form_open("school/requestFacility", ["id" => "facility_form"]); ?>
                                <input type="hidden" name="id" id="id" value="no_one">
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-6 col-md-offset-2">
                                        <div class="form-group">
                                            <label>Facility Title</label>
                                            <input type="text" name="title" id="title" class="form-control" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-2">

                                        <div class="form-group">
                                            <label>Facility Icon</label>
                                            <input class="form-control icp icp-auto" name="fac_icon" id="fac_icon" value="fa-support" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group user-form-group">
                                        <div class="pull-right">
                                            <button type="submit" name="save_facility" id="save_facility" class="btn btn-primary">Save Facilities</button>
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

    </section>

    <!-- /.content -->

</div>
<div class="modal fade" id="addOrgType" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-book m-r-5"></i> Add Organization Type</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_open('school/addNewOrganisationType', ["id" => "organizationTypeForm"]); ?>
                        <fieldset>
                            <!-- Text input-->

                            <div class="col-md-12 form-group">
                                <label class="control-label">Organization Type:</label>
                                <input type="text" placeholder="Organization Type" id="newOrgType" name="newOrgType" data-validation="required" class="form-control">
                            </div>

                            <div class="col-md-12 form-group user-form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="add_OrganisationType">
                                        Save
                                    </button>
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
<?php include_once 'school_footer.php'; ?>
<script>
    $(".profile_link").addClass("active");
    $(".edit_profile_link").addClass("active");
    document.title = "iHuntBest | Profile Edit";
</script>
<script src="<?php echo base_url('js/location.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACimPVNI1GUVZIfy5HA342kjuq7grLzS0&libraries=places&callback=initAutocomplete"  async defer></script>
<script>
    $('.icp-auto').iconpicker();
    getorgType('<?php echo $orgType; ?>', 'orgType');
    function getorgType(selval, position) {
        $.ajax({
            url: "<?php echo site_url("home/orgTypes"); ?>",
            type: 'POST',
            success: function (response) {
                var data = '<option>Select</option>';
                if (response) {
                    var json = $.parseJSON(response);

                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].typeName + '">' + json[i].typeName + '</option>';
                    }

                }
                data = data + '<option value="Other">Other</option>';
                $("#" + position).html(data);
                $("#" + position).val(selval);
            },
            error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }
    $('#add_OrganisationType').click(function () {
        var options = {
            beforeSend: function () {
            },
            success: function (response) {
                console.log(response);
                var json = $.parseJSON(response);
                if (json.status === 'success') {
                    var newOrgType = $("#newOrgType").val();
                    $.alert({title: 'Success!', content: json.msg, type: 'blue',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                $("#addOrgType").modal('hide');
                                getorgType(newOrgType, 'orgType');
                            }
                        }
                    });
                } else {
                    $.alert({title: 'Error!', content: json.msg, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                $("#addOrgType").modal('hide');
                                getorgType('<?php echo $orgType; ?>', 'orgType');
                            }
                        }});
                }

            },
            error: function (response) {
                $('#error').html(response);
            }
        };
        $('#organizationTypeForm').ajaxForm(options);
    });
</script>
<script type="text/javascript">
    date_time('date_time');

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on('change', '#orgType', function () {
            if ($(this).val() === "Other") {
                $("#addOrgType").modal('show');
            }
        });
        $('.summernote').summernote();
        $.ajax({
            url: "<?php echo site_url("school/getProfileData"); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                if (response) {
                    var json = $.parseJSON(response);
                    $('#orgDesp').summernote('code', json.orgDesp);
                    $('#orgMission').summernote('code', json.orgMission);
                    $('#orgVission').summernote('code', json.orgVission);
                }

            }
        });
        getCountries();

        $('#countryId').change(function () {
            var countryId = $('#countryId').val();
            var selected_stateId = "";
            getcountryByStates(countryId, selected_stateId);
        });
        $('#request_facility').click(function () {
            $('#requestFacilities').modal('show');
        });

        $('#stateId').change(function () {
            var stateId = $('#stateId').val();
            var selected_cityId = "";
            getStateByCity(stateId, selected_cityId);
        });
        $('#save_profile').click(function () {
            var options = {
                beforeSend: function () {
                    if ($("#orgDesp").val() === "") {
                        alert("Please add description.");
                        $('#orgDesp').summernote({focus: true});
                        return false;
                    }
                    if ($("#orgMission").val() === "") {
                        alert("Please add mission.");
                        $('#orgMission').summernote({focus: true});
                        return false;
                    }
                    if ($("#orgVission").val() === "") {
                        alert("Please add vision.");
                        $('#orgVission').summernote({focus: true});
                        return false;
                    }
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true, buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#profile_form').ajaxForm(options);
        });
        $('#save_facility').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    $('#requestFacilities').modal('hide');
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    facilities_div();
                                }
                            }
                        });
                    } else if (json.status === 'error') {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true, buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        window.location.reload();
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#facility_form').ajaxForm(options);
        });
        function getCountries() {
            $.ajax({
                url: "<?php echo site_url("home/getCountriesJson"); ?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose Country</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].countryId + '">' + json[i].name + '</option>';
                    }
                    $('#countryId').html(data);
                    $('#countryId option[value="<?php echo $countryId; ?>"]').prop("selected", true);
                    getcountryByStates(<?php echo $countryId; ?>, <?php echo $stateId; ?>);
                }
            });
        }

        function getcountryByStates(countryId, selected_stateId) {
            $.ajax({
                url: "<?php echo site_url("home/getStatesByCountry"); ?>",
                type: 'POST',
                data: 'countryId=' + countryId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose State</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].stateId + '">' + json[i].name + '</option>';
                    }
                    $('#stateId').html(data);
                    $('#stateId').val(selected_stateId);
                    getStateByCity(<?php echo $stateId; ?>, <?php echo $cityId; ?>)
                }
            });
        }

        function getStateByCity(stateId, selected_cityId) {
            $.ajax({
                url: "<?php echo site_url("home/getCityByStates"); ?>",
                type: 'POST',
                data: 'stateId=' + stateId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose City</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].cityId + '">' + json[i].name + '</option>';
                    }
                    $('#cityId').html(data);
                    $('#cityId').val(selected_cityId);
                }
            });
        }
        facilities_div();

    });
    function facilities_div() {
        $.ajax({
            url: '<?php echo site_url('school/orgFacilities'); ?>',
            success: function (data) {
                $("#facilities_div").html(data);
            }
        });
    }
</script>