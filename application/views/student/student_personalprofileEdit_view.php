<?php
include_once 'student_header.php';

if (isset($profileinfo)) {
    $studentName = $profileinfo->studentName;
    $studentMobile = $profileinfo->studentMobile;
    $gender = $profileinfo->gender;
    $date_of_birth = $profileinfo->date_of_birth;
    $country = $profileinfo->countryId;
    $state = $profileinfo->stateId;
    $ctyname = $profileinfo->cityId;
    $location = $profileinfo->location;
    $dob = $profileinfo->dob;
    $studentImage = $profileinfo->studentImage;
    $fatherName = $profileinfo->fatherName;
    $placeofBirth = $profileinfo->placeofBirth;
    $religion = $profileinfo->religion;
    $studentdetaild = base64_encode($profileinfo->studentdetaild);
} else {
    $studentName = '';
    $studentMobile = '';
    $gender = '';
    $date_of_birth = '';
    $country = '';
    $state = '';
    $ctyname = '';
    $location = '';
    $dob = '';
    $studentdetaild = 'no_id';
    $studentImage = '';
    $fatherName = '';
    $placeofBirth = '';
    $religion = '';
}
echo $map['js'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Student Personal Details Edit
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student'); ?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Edit | Insert Personal Details</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Personal Details Edit</h3>
                        </div>
                        <?php echo form_open_multipart('student/profilePersonalDetails', ["name" => "personal_details", "id" => "personal_details"]); ?>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" class="hidden" value="<?php echo $studentdetaild ?>" name="studentdetaild">
                                <input type="hidden" class="hidden" value="<?php echo $studentImage ?>" name="previmage">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Name:</label>
                                    <input type="text" placeholder="Student Name" id="studentName" name="studentName" value="<?php echo $studentName; ?>"  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Father Name:</label>
                                    <input type="text" placeholder="Father Name" id="studentName" name="fatherName" value="<?php echo $fatherName; ?>"  class="form-control">
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Mobile:</label>
                                    <input type="text" placeholder="Student Mobile" id="studentMobile" name="studentMobile" value="<?php echo $studentMobile; ?>"  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Gender:</label>
                                    <select name="gender" id="gender" class="form-control" data-validation="required">
                                        <option <?php
                                        if ($gender == "") {
                                            echo 'selected';
                                        }
                                        ?> value="">Select Gender</option>
                                        <option <?php
                                        if ($gender == "Female") {
                                            echo 'selected';
                                        }
                                        ?> value="Female">Female</option>
                                        <option <?php
                                        if ($gender == "Male") {
                                            echo 'selected';
                                        }
                                        ?> value="Male">Male</option>
                                        <option <?php
                                        if ($gender == "Other") {
                                            echo 'selected';
                                        }
                                        ?> value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Birth date:</label>
                                    <input type="date"   id="dob" name="dob" value="<?php echo $dob; ?>"  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Birth Place:</label>
                                    <input type="text" placeholder="Place Of Birth" id="placeofBirth" name="placeofBirth" value="<?php echo $placeofBirth; ?>"   class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Religion:</label>
                                    <select name="religion" id="religion_id" class="form-control" >
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Country:</label>
                                    <select name="country" id="country" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">State:</label>
                                    <select name="state" id="state" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">City:</label>
                                    <select name="ctyname" id="ctyname" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Location:</label>
                                    <input type="text"   id="location" name="location" value="<?php echo $location; ?>"  data-validation="required" class="form-control">
                                    <div class="hidden"><?php echo $map['html']; ?></div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label>Profile Image</label>
                                    <img class="img-responsive" style="max-height: 200px" id="pofilepic" src="<?php echo site_url($studentImage); ?>">
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="studentImage"  id="studentImage" class="form-control">
                                </div>


                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">

                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php include_once 'student_footer.php'; ?>
<script>

    $("#studentImage").change(function (e) {
        for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
            var file = e.originalEvent.srcElement.files[i];
            var reader = new FileReader();
            reader.onloadend = function () {
                $("#pofilepic").prop('src', reader.result);
            };
            reader.readAsDataURL(file);
            // $("input").after(img);
        }
    });
    $(".profile_link").addClass("active");
    $(".edit_personal_link").addClass("active");
    document.title = "iHuntBest | Student Personal Details Edit";
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        getCountries('#country', '<?php echo $country; ?>');
        function getCountries(countryId, db_countryId) {
            $.ajax({
                url: "<?php echo site_url('Home/getCountriesJson'); ?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var cid = '';
                    var json = $.parseJSON(response);
                    var data = '<option value="">Country</option>';
                    for (var i = 0; i < json.length; i++) {
                        if (db_countryId === json[i].countryId) {
                            cid = 'selected';
                            getStatesByCountry(json[i].countryId, '<?php echo $state; ?>', '#state');
                        } else {
                            cid = '';
                        }
                        data = data + '<option ' + cid + '  value="' + json[i].countryId + '">' + json[i].name + '</option>';
                    }
                    $(countryId).html(data);
                }
            });
        }
        $(document).on('change', '#country', function () {
            var countryId = $(this).val();
            if (countryId !== "") {
                getStatesByCountry(countryId, '', '#state');
                $('#state').focus();
            } else {
                return false;
            }
        });
        $(document).on('change', '#state', function () {
            var state = $(this).val();
            if (state !== "") {
                getCityByState(state, '', '#ctyname');
                $('#ctyname').focus();
            } else {
                return false;
            }
        });
        function getStatesByCountry(countryId, selected_stateId, stateId) {
            $.ajax({
                url: "<?php echo site_url('Home/getStatesByCountry'); ?>",
                type: 'POST',
                data: 'countryId=' + countryId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">State</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].stateId + '">' + json[i].name + '</option>';
                    }
                    $(stateId).html(data);
                    $(stateId).val(selected_stateId);
                }
            });
        }
        getCityByState('<?php echo $state; ?>', '<?php echo $ctyname; ?>', '#ctyname');
        function getCityByState(stateId, selected_cityId, cityId) {
            $.ajax({
                url: "<?php echo site_url('Home/getCityByStates') ?>",
                type: 'POST',
                data: 'stateId=' + stateId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">City</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].cityId + '">' + json[i].name + '</option>';
                    }
                    $(cityId).html(data);
                    $(cityId).val(selected_cityId);
                }
            });
        }
        $('#save_details').click(function () {
            var options = {
                beforeSend: function () {
                    $('.loader').show();
                    $('.loader').fadeOut(1500);
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
                }, error: function (jqXHR, exception) {
                    $.alert({
                        title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {

                            }
                        }
                    });
                }
            };
            $('#personal_details').ajaxForm(options);
        });
    });
    getRelion('<?php echo ($religion === '0' ? '' : $religion); ?>', 'religion_id');
    function getRelion(selval, id) {
        var result = '<option value="">Select</option>';
        $.ajax({
            url: '<?php echo site_url('home/religion'); ?>',
            success: function (response) {
                if (response !== "") {
                    var respjson = $.parseJSON(response);
                    for (var i = 0; i < respjson.length; i++) {
                        result = result + '<option value="' + respjson[i].religionId + '">' + respjson[i].religionName + '</option>';
                    }
                    $('#' + id).html(result);
                    $('#' + id).val(selval);
                } else {
                    return false;
                }
            }, error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {

                        }
                    }
                });
            }
        });
    }
</script>
