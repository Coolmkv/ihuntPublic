<?php
include_once 'university_header.php';
$currency = (isset($_SESSION['dCurrency']) ? (!empty($_SESSION['dCurrency']) ? $_SESSION['dCurrency'] : "NA") : 'NA');
?>
<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Course
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Course</a></li>
            <li class="active"> Add Course</li>
        </ol>
    </section>

    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">

                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Courses</h3>
                    </div>
                    <?php echo form_open('university/addSaveCourse', ["name" => "course_form", "id" => "course_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-12">
                                <fieldset>
                                    <legend style="color: #00a65a">Department Information</legend>
                                </fieldset>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Department</label>
                                    <select name="department" id="department" class="form-control" data-validation="required"></select>
                                    <span class="help-block">
                                        <a href="#" data-toggle="modal" data-target="#addcustom1">Add Department? Click Here <i class="fa fa-plus"></i></a>
                                    </span>
                                </div>
                            </div>
                            <div class="pull-right" style="margin-right: 20px">
                                <a class="btn btn-primary" id="request_courses" name="request_courses" href="<?php echo site_url('university/requestCourse'); ?>" > <i class="fa fa-plus"></i>Request For Courses</a>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <legend style="color: #00a65a">Course Information</legend>
                                </fieldset>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Course Type</label>
                                    <select name="courseTypeId" id="courseTypeId" class="form-control" data-validation="required"></select>
                                    <span class="help-block">
                                        <a   href="#" data-toggle="modal" data-target="#addOthersCourseType">Add Others Course Type? Click Here <i class="fa fa-plus"></i> </a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Course</label>
                                    <select name="courseId" id="courseId" class="form-control" data-validation="required"></select>
                                    <span class="help-block">
                                        <a href="#" data-toggle="modal" data-target="#addcustomCourse">Add Others Course? Click Here <i class="fa fa-plus"></i> </a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <legend style="color: #00a65a">Course Duration Information</legend>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Duration</label>
                                    <select name="courseDurationId" id="courseDurationId" class="form-control" data-validation="required"></select>
                                </div>
                                <span class="help-block">
                                    <a href="#" data-toggle="modal" data-target="#addDuration">Add Duration? Click Here <i class="fa fa-plus"></i></a>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mode</label>
                                    <select name="courseDurationType" id="courseDurationType" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <span class="help-block">
                                    <a href="#" data-toggle="modal" data-target="#addType">Add Mode? Click Here <i class="fa fa-plus"></i></a>
                                </span>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="col-md-6 col-sm-12 nopadding">
                                        <legend style="color: #00a65a">Course Pre-requisites</legend>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="col-md-8 col-sm-12">
                                            <h4 width="fit-contents">Set Course Pre-requisites (if required)</h4>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label class="switch">
                                                <input type="checkbox" id="buttoncourse_prerequistesdiv" onclick="showHideDiv('course_prerequistesdiv');">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row col-lg-12 col-md-12 hidden" id="course_prerequistesdiv">
                                <div class="col-md-5 col-sm-12 nopadding">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Min. Qual. Req.</label>
                                            <select   class="selectpicker  form-control min_qualification course_prerequistesdiv" onChange="getStream('min_qualification', '');" name="min_qualification[]" id="min_qualification" ></select>
                                            <span class="help-block">
                                                <a href="javascript:" id="addMinqual">Add Min. Qual.? Click Here <i class="fa fa-plus"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Min. Qual.(Stream)</label>
                                            <select   class="form-control min_qualificationStream course_prerequistesdiv" name="min_qualificationStream[]" id="Streammin_qualification" ></select>
                                            <span class="help-block">
                                                <a href="javascript:" id="addMinQualStream">Add Stream ? Click Here <i class="fa fa-plus"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Marking Type</label>
                                            <select name="markingType[]" id="markingType" class="form-control markingType course_prerequistesdiv" ></select>
                                            <span class="help-block">
                                                <a href="javascript:" id="addMarkingType">Add Marking Type? Click Here <i class="fa fa-plus"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Marking Value</label>
                                            <input type="text" class="form-control course_prerequistesdiv" name="min_percentage[]" placeholder="90%,A or Any" id="min_percentage">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-12">
                                    <br>
                                    <div class="form-group">
                                        <button type="button" onclick="addPreRequisite('', '', '');" class="add_requisites_button btn btn-success">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="col-md-6 col-sm-12 nopadding">
                                        <legend style="color: #00a65a">Age Pre-requisites</legend>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="col-md-8 col-sm-12">
                                            <h4 width="fit-contents">Set Age Pre-requisites (if required)</h4>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label class="switch">
                                                <input type="checkbox" id="buttonpreReqagediv" onclick="showHideDiv('preReqagediv');">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-12 col-sm-12 hidden" id="preReqagediv">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="Title">Min Age in Years</label>
                                        <input type="text" class="form-control numOnly preReqagediv" max="100" name="minage" onchange="checkMinMaxValue('minage', 'maxage', 'minage');" id="minage"  placeholder="Min-Age">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="Title">Max Age in Years</label>
                                        <input type="text" class="form-control numOnly preReqagediv" max="100" name="maxage" onchange="checkMinMaxValue('minage', 'maxage', 'maxage');" id="minage"  placeholder="Max-Age">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="Title">Age Valid as on</label>
                                        <input type="date"  class="form-control preReqagediv" name="validupto" id="validupto" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="col-md-6 col-sm-12 nopadding">
                                        <legend style="color: #00a65a">Experience Details / Business Type</legend>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="col-md-8 col-sm-12">
                                            <h4 width="fit-contents">Set Experience Details (if required)</h4>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label class="switch">
                                                <input type="checkbox" id="buttonexpdetailsdiv"  onclick="showHideDiv('expdetailsdiv');">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row col-lg-12 col-md-12 experienceDiv hidden" id="expdetailsdiv">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Title">Experience Duration Type</label>
                                        <select class="form-control expdetailsdiv" name="duration_type[]" id="duration_type">
                                            <option value="">Select</option>
                                            <option value="Full Time">Full Time</option>
                                            <option value="Part Time">Part Time</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Title">Duration</label>
                                        <select class="form-control experience_duration expdetailsdiv" name="experience_duration[]" id="experience_duration" ></select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="Title">Description <small>(Industry Type/ Business Type)</small></label>
                                        <input type="text" class="form-control expdetailsdiv" name="description[]" id="description"  placeholder="Description">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <br>
                                    <div class="form-group">
                                        <button type="button" class="add_experience_button btn btn-success" onclick="addExperienceType('', '', '');">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <legend style="color: #00a65a">Course Details</legend>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Application Opening Date</label>
                                    <input type="date" name="openingDate" id="openingDate" onchange="dateValidation('openingDate', 'closingDate', 'openingDate');" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Application Closing Date</label>
                                    <input type="date" name="closingDate" id="closingDate" onchange="dateValidation('openingDate', 'closingDate', 'closingDate');"class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Application Fee</label>
                                    <div class="input-group">
                                        <input type="text" name="applicationFee" id="applicationFeeId" value="0" class="form-control numOnly" placeholder="Application Fee" data-validation="required">
                                        <span class="bg-green-gradient input-group-addon"><?php echo $currency; ?></span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="col-md-6 col-sm-12 nopadding">
                                        <legend style="color: #00a65a">Exam Details</legend>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="col-md-8 col-sm-12">
                                            <h4 width="fit-contents">Set Exam Details (if required)</h4>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label class="switch">
                                                <input type="checkbox" id="buttonexamdiv" onclick="showHideDiv('examdiv');">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row col-lg-12 col-md-12  hidden" id="examdiv">
                                <div class="col-md-12 col-sm-12 nopadding">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Exam Mode</label>
                                            <select name="examMode" id="examModeId" class="form-control examdiv"></select>
                                            <span class="help-block">
                                                <a href="javascript:" id="addExamMode">Add Exam Mode? Click Here <i class="fa fa-plus"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Exam Details</label>
                                            <input type="text" name="examDetails" placeholder="Exam Details" id="examDetailsId" class="form-control examdiv" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Exam Date</label>
                                            <input type="date" name="examDate" id="examDate" onchange="dateValidation('examDate', 'resultDateId', 'examDate');" class="form-control examdiv" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Result Date</label>
                                        <input type="date" name="resultDate" min="<?php echo date('Y-m-d'); ?>" onchange="dateValidation('examDate', 'resultDateId', 'resultDateId');" id="resultDateId" class="form-control examdiv">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="form-group" style="margin-top: 23px;">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_course" id="save_course" value="Save">
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


    </section>

    <!-- /.content -->


</div>
<?php include_once 'university_footer.php'; ?>
<script>
    $(".add_course_link").addClass("active");
    $(".add_course").addClass("active");
    document.title = "iHuntBest | Add Course";</script>
<script type="text/javascript">
    var minqlaificationsarr = [];
    var minqlaificationsarr1 = [];
    var markingType = [];
    var timedurationar = [];
    function courseDurationType() {
        $.ajax({
            url: "<?php echo site_url('University/getCourseDurationType'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Select</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].typeTile + '">' + json[i].typeTile + '</option>';
                }
                $('#courseDurationType').html(data);
            }, error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            // window.location.reload();
                        }
                    }
                });
            }
        });
    }
    $(document).ready(function () {
        courseDurationType();
        $.validate({
            lang: 'en'
        });
        $("#addMinqual").click(function () {
            $("#addnewQualifications").modal('show');
        });
        getCourses();
        getDepartments();
        GetTimeDuration();
        minQualification('min_qualification');
        getMarkingType('');
        $('#courseTypeId').change(function () {
            var courseTypeId = $('#courseTypeId').val();
            var selected_cId = "";
            getcourseTypeBycourse(courseTypeId, selected_cId, 'courseId');
        });
        $('#save_course').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    // window.location.reload();
                                },
                                AddStream: function () {
                                    window.location.href = '<?php echo site_url('university/addStreams'); ?>';
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
                    }

                }, error: function (jqXHR, exception) {
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
            };
            $('#course_form').ajaxForm(options);
        });
        $('#add_MarkingType').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    getMarkingType("newMarkingType");
                                    document.getElementById("addMarkingType_form").reset();
                                    $("#addMarkingTypeModal").modal('hide');
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true, });
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
            $('#addMarkingType_form').ajaxForm(options);
        });
        $('#add_course_New').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    var courseTypeId = $('#courseTypeId').val();
                                    var selected_cId = "";
                                    getcourseTypeBycourse(courseTypeId, selected_cId, 'courseId');
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
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
            $('#coursetypeCourse_form').ajaxForm(options);
        });
        $('#add_newType').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    courseDurationType();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
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
            $('#addType_form').ajaxForm(options);
        });
        $('#add_course_type').click(function () {
            var options = {
                beforeSend: function () { },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    getCourses();
                                    $("#addOthersCourseType").modal('hide');
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
                    }
                }, error: function (jqXHR, exception) {
                    $.alert({
                        title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                //window.location.reload();
                            }
                        }
                    });
                }
            };
            $('#coursetype_form').ajaxForm(options);
        });
        $('#save_department').click(function () {
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
                                    getDepartments();
                                    $("#addcustom1").modal('hide');
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
                                getDepartments();
                            }
                        }
                    });
                }
            };
            $('#department_form').ajaxForm(options);
        });
        $('#add_new_duration').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    GetTimeDuration();
                                    $("#addDuration").modal('hide');
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
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
            $('#Duration_form').ajaxForm(options);
        });
        $("#addMarkingType").click(function () {
            $("#addMarkingTypeModal").modal("show");
        });
        $('#addCourseName').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    minQualification('min_qualification');
                                    document.getElementById("addCourseNameForm").reset();
                                    $("#addnewQualifications").modal('hide');
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
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
            $('#addCourseNameForm').ajaxForm(options);
        });
        $("#addcompetitveExam").click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    minQualification('min_qualification');
                                    $("#addnewQualifications").modal('hide');
                                    document.getElementById("competitiveExamForm").reset();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
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
            $('#competitiveExamForm').ajaxForm(options);
        });
        $("#addSubject").click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    minQualification('min_qualification');
                                    $("#addnewQualifications").modal('hide');

                                    document.getElementById("subjectForm").reset();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
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
            $('#subjectForm').ajaxForm(options);
        });
        $('#addInstCourseName').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    minQualification('min_qualification');
                                    document.getElementById("addInstituteCourseNameForm").reset();
                                    $("#addnewQualifications").modal('hide');
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
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
            $('#addInstituteCourseNameForm').ajaxForm(options);
        });
        $("#addExamMode").click(function () {
            $("#headingtext").html('<i class="fa fa-navicon m-r-5"></i> Add Exam Mode');
            $("#bodyMaterial").html('<form method="post" action="<?php echo site_url("home/addExamMode"); ?>" id="addExamModeform">\n\
                                    <div class="col-md-6 col-md-offset-3 col- col-sm-12 form-group">\n\
                                        <label class="control-label"> Exam Mode Name</label>\n\
                                        <input type="text" placeholder="Exam Mode Name" id="examModeId" name="examMode" data-validation="required" class="form-control">\n\
                                    </div>\n\
                                    <div class="col-md-12 col-sm-12 text-center">\n\
                                        <input type="submit" class="btn btn-success" onclick="addExamModeForm();" id="addExamMode" value="Add Exam Mode">\n\
                                    </div>\n\
                                </form>');
            $("#commonModal").modal('show');
        });
    });
    examMode('examModeId', '', '<?php echo site_url('home/getExamMode'); ?>');
    function addExamModeForm() {
        var options = {
            beforeSend: function () {
            },
            success: function (response) {

                var json = $.parseJSON(response);
                if (json.status === 'success') {
                    $.alert({title: 'Success!', content: json.msg, type: 'blue', typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                examMode('examModeId', '', '<?php echo site_url('home/getExamMode'); ?>');
                                $("#commonModal").modal('hide');
                            }
                        }
                    });
                } else {
                    $.alert({title: 'Error!', content: json.msg, type: 'red',
                        typeAnimated: true});
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
        $('#addExamModeform').ajaxForm(options);
    }
    function getCourses() {
        $.ajax({
            url: "<?php echo site_url('University/getCourseType'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Course Type</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].ctId + '">' + json[i].courseType + '</option>';
                }
                $('#courseTypeId').html(data);
                $('#courseTypeIdnew').html(data);
                $('#addcourseTypeId').html(data);
                $('#addcourseNameTypeId').html(data);
            }
        });
    }
    function getcourseTypeBycourse(ctId, selected_cId, selId) {
        $.ajax({
            url: "<?php echo site_url('University/getcourseTypeBycourse'); ?>",
            type: 'POST',
            data: 'ctId=' + ctId,
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Course</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].cId + '">' + json[i].title + '</option>';
                }
                $('#' + selId).html(data);
                $('#' + selId).val(selected_cId);
            }, error: function (jqXHR, exception) {
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
    function getStream(id, selval) {
        var courseDetails = $("#" + id).val();
        if (courseDetails === "") {
            return false;
        } else {
            var courseDetailsArr = courseDetails.split(",");
            if (courseDetailsArr.length > 1) {
                var courseId = courseDetailsArr[0];
                var tableName = courseDetailsArr[1];
            } else {
                return false;
            }
        }
        $.ajax({
            type: "POST",
            data: {courseId: courseId, tableName: tableName},
            url: "<?php echo site_url("home/getminQualSteam"); ?>",
            success: function (response) {
                var data = '<option value="">Select Stream</option>';
                if (response !== '""') {
                    var json = $.parseJSON(response);
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].minqualstreamId + ',' + json[i].tableName + '">' + json[i].streamTitle + '</option>';
                    }
                } else {
                    data = data + '<option value="0,notavailable">Not Available</option>';
                }
                $("#Stream" + id).html(data);
                $("#Stream" + id).val(selval);
            },
            error: function (jqXHR, exception) {
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

    function getDepartments() {
        $.ajax({
            url: "<?php echo site_url('University/showDepartments'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Department</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].departmentId + '">' + json[i].title + ' (' + json[i].departmentCode + ')' + '</option>';
                }
                $('#department').html(data);
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
    function GetTimeDuration() {
        $.ajax({
            url: "<?php echo site_url('University/getTimeDuration'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Duration</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].tdId + '">' + json[i].title + '</option>';
                    timedurationar[json[i].tdId] = json[i].title;
                }

                $('#courseDurationId').html(data);
                $('.experience_duration').html(data);
            }, error: function (jqXHR, exception) {
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
    function minQualification(min_qualification) {
        minqlaificationsarr = [];
        minqlaificationsarr1 = [];
        $.ajax({
            url: "<?php echo site_url('university/getMinQualification'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Min Qualification</option>';
                var tableName = "";
                for (var i = 0; i < json.length; i++) {
                    if (tableName === "") {
                        data = data + '<optgroup label="' + json[i].courseCategory + '" data-max-options="1">';
                        tableName = json[i].tablename;
                    } else {
                        if (tableName === json[i].tablename) {
                            data = data + '<option value="' + json[i].courseId + ',' + json[i].tablename + '">' + json[i].courseName + '</option>';
                        } else {
                            data = data + '</optgroup>';
                            data = data + '<optgroup label="' + json[i].courseCategory + '" data-max-options="1">';
                            tableName = json[i].tablename;
                        }
                    }
                    minqlaificationsarr[json[i].courseId + ',' + json[i].tablename + ',' + json[i].courseCategory] = json[i].courseName;
                    minqlaificationsarr1[json[i].courseId + ',' + json[i].tablename] = json[i].courseName;
                }
                $('#' + min_qualification).html(data);
            }, error: function (jqXHR, exception) {
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
    function getMarkingType(location) {
        markingType = [];
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url("home/getMarkingType"); ?>",
            success: function (response) {
                var data = '<option value="">Select</option>';
                if (response !== "") {
                    var rjson = $.parseJSON(response);
                    for (var i = 0; i < rjson.length; i++) {
                        data = data + '<option value="' + rjson[i].markingTitle + '">' + rjson[i].markingTitle + '</option>';
                        markingType[rjson[i].markingTitle] = rjson[i].markingTitle;
                    }
                }
                $(".markingType").each(function () {
                    var valueset = $(this).val();
                    $(this).html(data);
                    $(this).val(valueset);
                });
                $("#" + location).html(data);
            },
            error: function (jqXHR, exception) {
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
    function getMarkingTypeExisting(location) {
        if (markingType.length > 0) {
            var mType = '<option value="">Select</option>';
            for (var key in markingType) {
                mType = mType + '<option value="' + markingType[key] + '"  ' + (markingType[key] === markingTypes ? "selected" : "not") + '>' + markingType[key] + '</option>';
            }
            $("#" + location).html(mType);
        } else {
            getMarkingType(location);
        }

    }
    function addPreRequisite(minQualificationset, percentage, markingTypes) {
        var count = $('.min_qualification').length;
        if (count === '')
        {
            return false;
        }
        var options = '<option value="">Choose Min Qualification</option>';
        var tableName = "";
        for (var key in minqlaificationsarr) {
            var keyarr = key.split(",");
            if (tableName === "") {
                options = options + '<optgroup label="' + keyarr[2] + '" data-max-options="1">';
                tableName = keyarr[1];
            } else {
                if (tableName === keyarr[1]) {
                    options = options + '<option value="' + keyarr[0] + ',' + keyarr[1] + '" ' + (minQualificationset === keyarr[0] + ',' + keyarr[1] ? 'selected' : '') + '>' + minqlaificationsarr[key] + '</option>';
                } else {
                    options = options + '</optgroup>';
                    options = options + '<optgroup label="' + keyarr[2] + '" data-max-options="1">';
                    tableName = keyarr[1];
                }
            }
        }
        var mType = '<option value="">Select</option>';
        for (var key in markingType) {
            mType = mType + '<option value="' + markingType[key] + '"  ' + (markingType[key] === markingTypes ? "selected" : "not") + '>' + markingType[key] + '</option>';
        }
        $("#course_prerequistesdiv").append('<div class="divadded" id="divremove' + count + '">\n\
                                     <div class="col-md-12 col-sm-12">\n\
                                        <div class="col-md-6 col-sm-12"><h4>Select condition between pre-requisites</h4></div> \n\
                                        \n\<div class="col-md-2 col- col-sm-12  col-md-offset-2"><select name="condition[]" class="form-control" id="relation' + count + '" data-validation="required">\n\
                                        <option value="">Select</option><option value="AND">AND</option><option value="OR">OR</option></select></div>\n\
                                    </div>\n\
                                    <div class="col-md-5 col-sm-12 nopadding">\n\
                                        <div class="col-md-6 col-sm-12">\n\
                                            <div class="form-group">\n\
                                                <label for="Title">Min. Qual. Req.</label>\n\
                                                    <select class="form-control min_qualification" name="min_qualification[]" onchange="getStream(\'min_qualification' + count + '\',\'\');" id="min_qualification' + count + '" data-validation="required">' + options + '</select>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-md-6 col-sm-12">\n\
                                            <div class="form-group">\n\
                                                <label for="Title">Min. Qual.(Stream)</label>\n\
                                                    <select class="form-control min_qualificationStream" name="min_qualificationStream[]" id="Streammin_qualification' + count + '" data-validation="required"></select>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-md-6 col-sm-12">\n\
                                        <div class="col-md-6 col-sm-12">\n\
                                            <div class="form-group">\n\
                                                <label for="Title">Marking Type</label>\n\
                                                <select name="markingType[]" id="markingType' + count + '" class="form-control markingType" data-validation="required">' + mType + '</select>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-md-6 col-sm-12">\n\
                                            <div class="form-group">\n\
                                                <label for="Title">Marking Value</label>\n\
                                                <input type="text" class="form-control" name="min_percentage[]" placeholder="90%,A or Any" value="' + percentage + '" id="min_percentage' + count + '" data-validation="required">\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-md-1 col-sm-12">\n\
                                        <br><a href="javascript:" onclick="removediv(\'divremove' + count + '\');" class="remove_field fa fa-remove btn btn-danger"></a>\n\
                                    </div>\n\
                                </div>'); //add input box

    }
    function removediv(id) {
        $('#' + id).remove();
    }
    function addExperienceType(type, duration, description) {
        var count = $('.experience_duration').length;
        var options = '<option value="">Select Duration</option>';
        for (var key in timedurationar) {

            options = options + '<option value="' + key + '" ' + (duration === key ? 'selected' : '') + '>' + timedurationar[key] + '</option>';
        }
        $("#expdetailsdiv").append('<div class="col-md-12 col-sm-12 nopadding" id="divExperience' + count + '"><div class="col-md-3">\n\
                    <div class="form-group">\n\
                        <label for="Title">Experience Duration Type</label>\n\
                        <select class="form-control" name="duration_type[]" id="duration_type1" data-validation="required">\n\
        <option>Select</option><option value="Full Time" ' + (type === "Full Time" ? "selected" : "") + '>Full Time</option><option value="Part Time" ' + (type === "Part Time" ? "selected" : "") + '>Part Time</option></select>\n\
                    </div>\n\
            </div>\n\
            <div class="col-md-3">\n\
                <div class="form-group">\n\
                <label for="Title">Duration</label>\n\
                    <select class="form-control experience_duration" name="experience_duration[]" id="experience_duration" data-validation="required">' + options + '</select>\n\
                </div>\n\
            </div>\n\
            <div class="col-md-5">\n\
                <div class="form-group">\n\
                    <label for="Title">Description <small>(Industry Type/ Business Type)</small></label>\n\
                    <input type="text" class="form-control" name="description[]" id="description" data-validation="required" value="' + description + '" placeholder="Description">\n\
                </div>\n\
            </div>\n\
            <div class="col-md-1"><br><a href="javascript:" onclick="removediv(\'divExperience' + count + '\');" class="btn btn-danger fa fa-remove"></a></div></div>');
    }
    $("#addMinQualStream").click(function () {
        $("#headingtext").html('<i class="fa fa-navicon m-r-5"></i> Add Class Type');
        $("#bodyMaterial").html('<div class="col-md-12">\n\
                                    <h4>Add Class Type</h4>\n\
                                </div>\n\
                                <form method="post" action="<?php echo site_url("home/addClassType"); ?>" id="addClassTypeform">\n\
                                    <div class="col-md-6 col-sm-12 form-group">\n\
                                        <label class="control-label">Class Name</label>\n\
                                        <select name="class" id="classNamemodal" class="form-control" data-validation="required"></select>\n\
                                    </div>\n\
                                    <div class="col-md-6 col-sm-12 form-group">\n\
                                        <label class="control-label">Class Type</label>\n\
                                        <input type="text" placeholder="Class Type Name" id="ClassTypeNameId" name="ClassTypeName" data-validation="required" class="form-control">\n\
                                    </div>\n\
                                    <div class="col-md-12 col-sm-12 text-center">\n\
                                        <input type="submit" class="btn btn-success" onclick="addClassTypeForm();" id="addClassTypeNew" value="Add Class Type">\n\
                                    </div>\n\
                                </form>\n\
                                <div class="col-md-12">\n\
                                    <h4>Add Course Name</h4>\n\
                                </div>\n\
                                    <form method="post" action="<?php echo site_url("home/addCourseStreamName"); ?>" id="addStreamNameForm">\n\
                                        <div class="col-md-12"> \n\
                                            <div class="col-md-4 col-sm-12 form-group">\n\
                                                <label class="control-label">Course Type</label>\n\
                                                    <select name="courseType" onchange="getCName(\'addcourseTypeId\');" id="addcourseTypeId" class="form-control" data-validation="required"></select>\n\
                                            </div>\n\
                                            <div class="col-md-4 col-sm-12 form-group">\n\
                                                <label class="control-label">Course Name</label>\n\
                                                <select name="courseName" id="addcourseNameId" class="form-control" data-validation="required"></select>\n\
                                            </div> \n\
                                            <div class="col-md-4 col-sm-12 form-group">\n\
                                                <label class="control-label">Stream Name</label>\n\
                                                <input type="text" placeholder="Stream Name" id="StreamNameId" name="StreamName" data-validation="required" class="form-control">\n\
                                            </div>\n\
                                            <div class="col-md-12 text-center col-sm-12">\n\
                                                <input type="submit" class="btn btn-success" id="addStream" onclick="addStreamName();" value="Add Stream">\n\
                                            </div> \n\
                                        </div> \n\
                                    </form>');
        $("#commonModal").modal('show');
        classNames("", "classNamemodal");
        getCourses();
    });
    function classNames(selval, position) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('home/getClassNames'); ?>",
            success: function (response) {
                if (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].classTitle + '">' + json[i].classTitle + '</option>';
                    }
                    $("#" + position).html(data);
                    $("#" + position).val(selval);
                }
            }, error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            //window.location.reload();
                        }
                    }
                });
            }
        });
    }
    getCountries();
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
            }
        });
    }
    getMarkingTypeExisting("marking_system_id");
    function getCName(id) {
        var courseTypeId = $('#' + id).val();
        var selected_cId = "";
        getcourseTypeBycourse(courseTypeId, selected_cId, 'addcourseNameId');
    }
    function addnewClass() {
        var newClassName = $("#ClassNameId").val();
        if (newClassName === "") {
            requiredfied("ClassNameId");
            $("#ClassNameId").focus();
            return false;
        } else {
            $.ajax({
                type: "POST",
                data: {newClassName: newClassName},
                url: "<?php echo site_url("home/addNewClass"); ?>",
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    classNames('', 'className');
                                    minQualification('min_qualification');
                                    $("#commonModal").modal('hide');
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true, });
                    }
                },
                error: function (jqXHR, exception) {
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
    }
    function addStreamName() {
        var options = {
            beforeSend: function () {
            },
            success: function (response) {
                console.log(response);
                var json = $.parseJSON(response);
                if (json.status === 'success') {
                    $.alert({title: 'Success!', content: json.msg, type: 'blue',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                minQualification('min_qualification');

                                $("#commonModal").modal('hide');
                            }
                        }
                    });
                } else {
                    $.alert({title: 'Error!', content: json.msg, type: 'red',
                        typeAnimated: true});
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
        $('#addStreamNameForm').ajaxForm(options);
    }
    function addClassTypeForm() {

        var options = {
            beforeSend: function () {
            },
            success: function (response) {

                var json = $.parseJSON(response);
                if (json.status === 'success') {
                    $.alert({title: 'Success!', content: json.msg, type: 'blue', typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                minQualification('min_qualification');
                                $("#commonModal").modal('hide');
                            }
                        }
                    });
                } else {
                    $.alert({title: 'Error!', content: json.msg, type: 'red',
                        typeAnimated: true});
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
        $('#addClassTypeform').ajaxForm(options);
    }

</script>
<div class="modal fade" id="addMarkingTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-navicon m-r-5"></i> Add Marking Type</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo form_open('home/addMarkingType', ["name" => "addMarkingType_form", "id" => "addMarkingType_form"]); ?>

                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Marking Type:</label>
                                <input type="text" placeholder="Marking Type" id="newMarkingType" name="newMarkingType"
                                       data-validation="required" class="form-control">
                            </div>
                            <div class="col-md-12 form-group user-form-group text-center">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="add_MarkingType">
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
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="headingtext"></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="bodyMaterial">
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
<div class="modal fade" id="addDuration" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-clock-o m-r-5"></i> Add Duration</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo form_open('university/addNewDuration', ["name" => "Duration_form", "id" => "Duration_form"]); ?>
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Duration:</label>
                                <input type="text" placeholder="Duration" id="newDuration" name="newDuration" data-validation="required" class="form-control">
                            </div>
                            <div class="col-md-12 form-group user-form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="add_new_duration">
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
<div class="modal fade" id="addOthersCourseType" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-cog m-r-5"></i> Add Course Type</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo form_open('university/addCourseType', ["name" => "coursetype_form", "id" => "coursetype_form"]); ?>
                        <input type="hidden" name="id" id="id" value="no_one">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Course Type:</label>
                                <input type="text" placeholder="Course Type" id="courseType" name="courseType"
                                       data-validation="required" class="form-control">
                            </div>
                            <div class="col-md-12 form-group user-form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="add_course_type">
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
<div class="modal fade" id="addcustomCourse" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-cog m-r-5"></i> Add Course </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_open('university/addCourseTypeCourse', ["name" => "coursetypeCourse_form", "id" => "coursetypeCourse_form"]); ?>
                        <input type="hidden" name="id" id="id" value="no_one">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Course Type:</label>
                                <select name="courseTypeIdnew" id="courseTypeIdnew" class="form-control" data-validation="required"></select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label">Course:</label>
                                <input type="text" placeholder="Course" id="courseNew" name="courseNew"
                                       data-validation="required" class="form-control">
                            </div>
                            <div class="col-md-12 form-group user-form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="add_course_New">
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
<!-- /.modal -->

<div class="modal fade" id="addcustom1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-file m-r-5"></i> Add Department</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo form_open('university/addNewDepartment', ["name" => "department_form", "id" => "department_form"]); ?>
                        <input type="hidden" name="id" id="id" value="no_one">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Department Title</label>
                                    <input type="text" name="title" id="title" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Department Code</label>
                                    <input type="text" name="departmentCode" id="departmentCode" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 form-group user-form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="save_department">
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
<!-- /.modal -->
<div class="modal fade" id="addType" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-navicon m-r-5"></i> Add Mode</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_open('university/addType', ["name" => "addType_form", "id" => "addType_form"]); ?>
                        <input type="hidden" name="id" id="id" value="no_one">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Mode:</label>
                                <input type="text" placeholder="Mode" id="newType" name="newType" data-validation="required" class="form-control">
                            </div>
                            <div class="col-md-12 form-group user-form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="add_newType">
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
<div class="modal fade" id="addnewQualifications" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-navicon m-r-5"></i> Add Qualifications</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12">
                                <h4>Add Class</h4>
                            </div>
                            <div class="col-md-12">
                                <form method="post" action="javascript:">
                                    <div class="col-md-6 col-md-offset-3 col-sm-12 form-group">
                                        <label class="control-label">Class Name</label>
                                        <input type="text" placeholder="Class Name" id="ClassNameId" name="ClassName" data-validation="required" class="form-control">
                                    </div>
                                    <div class="col-md-12 col-sm-12 text-center">
                                        <input type="submit" class="btn btn-success" onclick="addnewClass();" id="addNewClassId" value="Add Class">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <h4>Competitive Exam</h4>
                            </div>
                            <form method="post" action="<?php echo base_url("home/addCompetitiveExamDetails"); ?>" id="competitiveExamForm">
                                <div class="col-md-12">
                                    <div class="col-md-4 col-sm-12 form-group">
                                        <label>Country</label>
                                        <select id="countryId" name="countryId" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12 form-group">
                                        <label>Exam Name</label>
                                        <input type="text" name="exam_name" id="exam_name_id" class="form-control" placeholder="Exam Name *" data-validation="required">
                                    </div>
                                    <div class="col-md-4 col-sm-12 form-group">
                                        <label>Marking System</label>
                                        <select name="marking_system" id="marking_system_id" class="form-control" >
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12 form-group">
                                        <label>Validity Time</label>
                                        <input type="text" name="validity_time" title="Exam Score Validity in Months" id="validity_time_id" placeholder="Exam Score Validity in Months" class="form-control numOnly" data-validation="required">
                                    </div>
                                    <div class="col-md-4 col-sm-12 form-group">
                                        <label>Type of Exam</label>
                                        <select id="typeOfexam_id" name="typeOfexam" class="form-control" data-validation="required">
                                            <option value="">Select</option>
                                            <option value="Entrance">Entrance</option>
                                            <option value="Scholarship">Scholarship</option>
                                            <option value="Both">Both</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-sm-12 text-center">
                                        <input type="submit" class="btn btn-success" id="addcompetitveExam" value="Add Competitive Exam">
                                    </div>
                                </div>
                            </form>

                            <div class="col-md-12">
                                <h4>Add Subject</h4>
                            </div>
                            <form method="post" action="<?php echo base_url("home/addSubjectDetails"); ?>" id="subjectForm">
                                <div class="col-md-12">
                                    <div class="col-md-6 col-md-offset-3 col-sm-12 form-group">
                                        <label class="control-label">Subject Name</label>
                                        <input type="text" placeholder="Subject Name" id="SubjectNameId" name="SubjectName" data-validation="required" class="form-control">
                                    </div>
                                    <div class="col-md-12 text-center col-sm-12">
                                        <input type="submit" class="btn btn-success" id="addSubject" value="Add Subject">
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12">
                                <h4>Add Course Name</h4>
                            </div>
                            <form method="post" action="<?php echo base_url("home/addCourseName"); ?>" id="addCourseNameForm">
                                <div class="col-md-12">
                                    <div class="col-md-4 col-sm-12 form-group">
                                        <label class="control-label">Course Type</label>
                                        <select name="courseType" id="addcourseNameTypeId" class="form-control" data-validation="required"></select>
                                    </div>
                                    <div class="col-md-4 col-sm-12 form-group">
                                        <label class="control-label">Course Name</label>
                                        <input type="text" placeholder="Course Name" id="CourseName" name="CourseName" data-validation="required" class="form-control">

                                    </div>
                                    <div class="col-md-4 col-sm-12 form-group">
                                        <label class="control-label">Stream Name</label>
                                        <input type="text" placeholder="Stream Name" id="StreamNameId" name="StreamName" data-validation="required" class="form-control">
                                    </div>
                                    <div class="col-md-12 text-center col-sm-12">
                                        <input type="submit" class="btn btn-success" id="addCourseName" value="Add Course">
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12">
                                <h4>Add Institute Course Name</h4>
                            </div>
                            <?php echo form_open('home/addInstituteCourseName', ["id" => "addInstituteCourseNameForm"]); ?>
                            <div class="col-md-12">
                                <div class="col-md-4 col-md-offset-4 col-sm-12 form-group">
                                    <label class="control-label">Course Name</label>
                                    <input type="text" placeholder="Course Name" id="CourseName" name="CourseName" data-validation="required" class="form-control">
                                </div>
                                <div class="col-md-12 text-center col-sm-12">
                                    <input type="submit" class="btn btn-success" id="addInstCourseName" value="Add Course Name">
                                </div>
                            </div>
                            <?php echo form_close(); ?>

                        </fieldset>
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