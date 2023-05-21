<?php
include_once 'institute_header.php';
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
            <li><a href="<?php echo site_url('institute/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Course</a></li>
            <li class="active"> Add Course</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body" id="courseViewdiv">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Courses</h3>
                    </div>

                    <?php echo form_open('institute/addSaveCourse', ["name" => "course_form", "id" => "course_form"]); ?>
                    <div class="box-body">
                        <div class="row" id="mainDiv">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Course Type</label>
                                    <select name="courseTypeId" id="courseTypeId" class="form-control" data-validation="required"></select>
                                    <span class="help-block">
                                        <a href="#" data-toggle="modal" data-target="#CourseType">Add Course Type? Click Here <i class="fa fa-plus"></i></a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Time Duration</label>
                                    <select name="timeDurationId" id="timeDurationId" class="form-control timeDurationClass" data-validation="required"></select>
                                    <span class="help-block">
                                        <a href="#" data-toggle="modal" data-target="#addDuration">Add Duration? Click Here <i class="fa fa-plus"></i></a>
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Mode</label>
                                    <select name="courseDurationType" id="courseDurationType" class="form-control" data-validation="required">                                    </select>
                                    <span class="help-block">
                                        <a href="#" data-toggle="modal" data-target="#addType">Add Mode? Click Here <i class="fa fa-plus"></i></a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 nopadding">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Course Fee</label>
                                        <div class="input-group">
                                            <input type="number" name="courseFee" id="courseFee" placeholder="Course Fee" class="form-control" data-validation="required">
                                            <span class="input-group-addon"><?php echo $currency; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Fee Cycle</label>
                                        <select class="form-control" name="feeCycle" id="feeCycle_id" data-validation="required"></select>
                                        <span class="help-block">
                                            <a href="javascript:" id="feeCycleModalId">Add Fee Cycle? Click Here <i class="fa fa-plus"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Total Seats</label>
                                        <input type="number" name="totalseats" placeholder="Total Seats" onchange="checkMinMaxValue('avlseats', 'totalseats', 'totalseats');" id="totalseats" class="form-control" data-validation="required">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Available Seats</label>
                                    <input type="number" name="avlseats" placeholder="Available Seats" onchange="checkMinMaxValue('avlseats', 'totalseats', 'avlseats');" id="avlseats" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Registration Fee</label>
                                    <div class="input-group">
                                        <input type="number" name="registrationFee" placeholder="Registration Fee" id="registrationFee" class="form-control" >
                                        <span class="input-group-addon"><?php echo $currency; ?></span>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Fee Submit Start Date</label>
                                    <input type="date" name="fromDate" id="fromDate"  onchange="dateValidation('fromDate', 'toDate', 'fromDate');" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Fee Submit End Date</label>
                                    <input type="date" name="toDate" id="toDate" onchange="dateValidation('fromDate', 'toDate', 'toDate');" class="form-control" >
                                </div>
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
                                        <input type="text" class="form-control numOnly preReqagediv" max="100" name="minage" id="minage" placeholder="Min Age in Years" onchange="checkMinMaxValue('minage', 'maxage', 'minage');">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="Title">Max Age in Years</label>
                                        <input type="text" class="form-control numOnly preReqagediv" max="100" name="maxage" id="maxage" placeholder="Max Age in Years" onchange="checkMinMaxValue('minage', 'maxage', 'maxage');">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="Title">Age Valid as on</label>
                                        <input type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control preReqagediv" name="validupto" id="validupto" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="col-md-6 col-sm-12 nopadding">
                                        <legend style="color: #00a65a">Experience Details / Business Details</legend>
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
                                        <select class="form-control timeDurationClass experience_duration expdetailsdiv" name="experience_duration[]" id="experience_duration" ></select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="Title">Description <small>(Industry Type/ Business Name)</small></label>
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
                                    <input type="date" name="openingDate" id="openingDate" class="form-control" onchange="dateValidation('openingDate', 'closingDate', 'openingDate');" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Application Closing Date</label>
                                    <input type="date" name="closingDate" id="closingDate" class="form-control" onchange="dateValidation('openingDate', 'closingDate', 'closingDate');" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Application Fee</label>
                                    <input type="text" name="applicationFee" id="applicationFeeId" class="form-control numOnly" value="0" placeholder="Application Fee" data-validation="required">
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
                                            <input type="date" name="examDate" min="<?php echo date('Y-m-d'); ?>" onchange="dateValidation('examDate', 'resultDateId', 'examDate');"  id="examDate" class="form-control examdiv" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Result Date</label>
                                        <input type="date" name="resultDate"  onchange="dateValidation('examDate', 'resultDateId', 'resultDateId');"  min="<?php echo date('Y-m-d'); ?>" id="resultDateId" class="form-control examdiv">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 text-center">
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
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Courses Details</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="courses_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course Type</th>
                                            <th>Time Duration</th>
                                            <th>Duration Type</th>
                                            <th>Course Fee</th>
                                            <th>Seats</th>
                                            <th>Min Qual.</th>
                                            <th>Experience Requirement</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                </table>
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
<div class="modal fade" id="CourseType" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-navicon m-r-5"></i> Add Course Type</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo form_open('institute/addCourseType', ["name" => "addCourseType_form", "id" => "addCourseType_form"]); ?>
                        <input type="hidden" name="id" id="id" value="no_one">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Course Type:</label>
                                <input type="text" placeholder="Course Type" id="newCourseType" name="newCourseType"
                                       data-validation="required" class="form-control">
                            </div>
                            <div class="col-md-12 form-group user-form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="add_newCourseType">
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

                        <?php echo form_open('institute/addNewDuration', ["name" => "Duration_form", "id" => "Duration_form"]); ?>
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
<div class="modal fade" id="addType" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-navicon m-r-5"></i> Add Type</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo form_open('institute/addType', ["name" => "addType_form", "id" => "addType_form"]); ?>
                        <input type="hidden" name="id" id="id" value="no_one">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Mode:</label>
                                <input type="text" placeholder="Mode" id="newType" name="newType"
                                       data-validation="required" class="form-control">
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

<?php include_once 'institute_footer.php'; ?>
<script>
    $(".add_course_link").addClass("active");
    $(".add_course").addClass("active");
    document.title = "iHuntBest | Add Course";</script>
<script type="text/javascript">
    var minqlaificationsarr = [];
    var minqlaificationsarr1 = [];
    var stremNamearr = [];
    var markingType = [];
    var examModearr = [];
    var durationTypearr = [];
    var courseTypearray = [];
    var feeCycleArray = [];
    function addNewFeeCycle() {
        var options = {
            beforeSend: function () {
            },
            success: function (response) {

                var json = $.parseJSON(response);
                if (json.status === 'success') {
                    $.alert({title: 'Success!', content: json.msg, type: 'blue', typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                getFeeCycle('feeCycle_id', '');
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
        $('#addFeeCyclesForm').ajaxForm(options);
    }
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on("click", "#feeCycleModalId", function () {
            $("#headingtext").html('<i class="fa fa-navicon m-r-5"></i> Add Fee Cycle');
            $("#bodyMaterial").html('<form method="post" action="<?php echo site_url("home/addFeeCycles"); ?>" id="addFeeCyclesForm">\n\
                                    <div class="col-md-6 col-md-offset-3 col-sm-12 form-group">\n\
                                        <label class="control-label">Fee Cycle Title</label>\n\
                                        <input type="text" placeholder="Fee Cycle Title" id="feeCycleTitle" name="feeCycleTitle" data-validation="required" class="form-control">\n\
                                    </div>\n\
                                    <div class="col-md-12 col-sm-12 text-center">\n\
                                        <input type="submit" class="btn btn-success" onclick="addNewFeeCycle();" value="Add Fee Cycle">\n\
                                    </div>\n\
                                </form>');
            $("#commonModal").modal('show');
        });
        $(document).on("click", "#addMarkingType", function () {
            $("#addMarkingTypeModal").modal("show");
        });
        $(document).on("click", "#addcompetitveExam", function () {
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
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    $("#addnewQualifications").modal('hide');
                                }
                            }
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
            $('#competitiveExamForm').ajaxForm(options);
        });
        examMode('examModeId', '', '<?php echo site_url('home/getExamMode'); ?>');
        getMarkingType("markingType");
        timeDurationNew('timeDurationId', '');
        getCourses("");
        getFeeCycle('feeCycle_id', '');
        $(document).on("click", "#add_MarkingType", function () {
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
        $(document).on("click", "#addExamMode", function () {
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
        $(document).on("click", ".editcourse", function () {
            $("#mainDiv").html(windowForm);
            var orgCourseId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "ed=" + orgCourseId,
                url: "<?php echo site_url("institute/editCourses"); ?>",
                success: function (response) {
                    if (response !== "") {
                        var json = $.parseJSON(response);
                        $('#id').val(json.insCourseDetailsId);
                        courseTypearr(json.insCourseId);
                        timeDuration("timeDurationId", json.timeDurationId);
                        courseDurationTypeFromArr('courseDurationType', json.courseDurationType)
                        $('#courseFee').val(json.courseFee);
                        feeCyclearray('feeCycle_id', json.feecycleId);
                        $('#totalseats').val(json.totalSheet);
                        $('#avlseats').val(json.availableSheet);
                        $('#registrationFee').val(json.registrationFee);
                        $('#fromDate').val(json.feepaySdate);
                        $('#toDate').val(json.feepayEdate);
                        $('#openingDate').val(json.applyFrom);
                        $('#closingDate').val(json.applyTo);
                        $('#applicationFeeId').val(json.applicationFee);
                        var relations = [];
                        if (json.minQuals !== null) {
                            $("#course_prerequistesdiv").removeClass("hidden");
                            $("#buttoncourse_prerequistesdiv").prop("checked", true);
                            var minQuals = json.minQuals.split('^');
                            for (var i = 0; i < minQuals.length; i++) {
                                var minQualsarr = minQuals[i];
                                var minQualsarrays = minQualsarr.split(',');
                                relations.push(minQualsarrays[7]);
                                if (i > 0) {
                                    addPreRequisite(minQualsarrays[1] + ',' + minQualsarrays[2], minQualsarrays[6], minQualsarrays[5]);
                                    getStream('min_qualification' + i, minQualsarrays[3] + ',' + minQualsarrays[4]);
                                    //$("#min_qualification" + i).val();

                                } else {
                                    minQualFromArr(minQualsarrays[1] + ',' + minQualsarrays[2], 'min_qualification');
                                    markingTypearr('markingType', minQualsarrays[5]);
                                    $("#min_percentage").val(minQualsarrays[6]);
                                    getStream('min_qualification', minQualsarrays[3] + ',' + minQualsarrays[4]);
                                }

                            }
                            for (var i = 0; i < relations.length; i++) {
                                var j = i + 1;
                                $("#relation" + j).val(relations[i]);
                            }
                        }
                        if (json.maxAge) {
                            $("#preReqagediv").removeClass("hidden");
                            $("#buttonpreReqagediv").prop("checked", true);
                            $("#minage").val(json.minAge);
                            $("#maxage").val(json.maxAge);
                            $("#validupto").val(json.ageValidDate);
                        }
                        if (json.examMode) {
                            examModeArr('examModeId', json.examMode);
                            $("#examdiv").removeClass("hidden");
                            $("#buttonexamdiv").prop("checked", true);
                            $("#examDetailsId").val(json.examDetails);
                            $("#examDate").val(json.examDate);
                            $("#resultDateId").val(json.resultDate);
                        }
                        if (json.expDetails) {
                            $("#expdetailsdiv").removeClass("hidden");
                            $("#buttonexpdetailsdiv").prop("checked", true);
                            var expDetails = json.expDetails.split('^');
                            for (var i = 0; i < expDetails.length; i++) {
                                var expPreReq = expDetails[i].split(',');
                                if (i > 0) {
                                    addExperienceType(expPreReq[0], expPreReq[1], expPreReq[2]);
                                } else {
                                    $("#duration_type").val(expPreReq[0]);
                                    $("#experience_duration").val(expPreReq[1]);
                                    timeDuration('experience_duration', expPreReq[1]);
                                    $("#description").val(expPreReq[2]);
                                }
                            }
                        }
                    }
                },
                error: function (jqXHR, exception) {
                    $.alert({
                        title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });
        $(document).on("click", ".delcourse", function () {
            var orgCourseId = $(this).attr("del");
            $.confirm({
                title: 'Warning!',
                content: "Are you sure to delete?",
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Cancel: function () {
                        window.location.reload();
                    },
                    Confirm: function () {
                        $.ajax({
                            type: "POST",
                            data: "del=" + orgCourseId,
                            url: "<?php echo site_url("institute/deleteCourse"); ?>",
                            success: function (response) {
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
                                        typeAnimated: true, });
                                }
                            }
                        });
                    }
                },
                error: function (jqXHR, exception) {
                    $.alert({
                        title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url("institute/getCourses"); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var reqMinQ = "";

                var oTable = $('table#courses_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    reqMinQ = reqMinQ + (json[i].minQualComptetiveExam !== 'null' ? minqualSet(json[i].minQualComptetiveExam) : "");
                    reqMinQ = reqMinQ + (json[i].minQualsubject !== 'null' ? minqualSet(json[i].minQualsubject) : "");
                    reqMinQ = reqMinQ + (json[i].minqualInst !== 'null' ? minqualSet(json[i].minqualInst) : "");
                    reqMinQ = reqMinQ + (json[i].minqualSchool !== 'null' ? minqualSet(json[i].minqualSchool) : "");
                    reqMinQ = reqMinQ + (json[i].minqualhedu !== 'null' ? minqualSet(json[i].minqualhedu) : "");
                    oTable.fnAddData([
                        (i + 1),
                        json[i].courseName,
                        json[i].timeduration,
                        json[i].courseDurationType,
                        json[i].courseFee,
                        "Total Seats : " + json[i].totalSheet + "<br>Available Seats : " + json[i].availableSheet,
                        reqMinQ,
                        json[i].reqExp,
                        '<a href="javascript:" class="editcourse" ed="' + json[i].insCourseDetailsId + '" title="Edit"><i class="fa fa-edit"></i></i></a>\n\
                            &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" class="delcourse" del="' + json[i].insCourseDetailsId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            },
            error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            window.location.reload();
                        }
                    }
                });
            }
        });
        function minqualSet(minqual) {
            var returnval = "";
            if (minqual) {
                var minqualArr = minqual.split('^');
                var minQuals = '';
                for (var i = 0; i < minqualArr.length; i++) {
                    if (minqualArr[i]) {
                        minQuals = minqualArr[i].split(',');
                        returnval += minQuals[0] + '(' + minQuals[1] + ') <br>' + minQuals[3] + ' ' + minQuals[2] + '<br>';
                    }
                }
            }
            return returnval;
        }
        $(document).on("click", "#addMinqual", function () {
            $("#addnewQualifications").modal('show');
            getCountries();
            getOrgCourseType();
        });
        $(document).on("click", "#addSubject", function () {
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
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    $("#addnewQualifications").modal('hide');
                                    document.getElementById("subjectForm").reset();
                                }
                            }
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
            $('#subjectForm').ajaxForm(options);
        });
        $(document).on("click", "#save_course", function () {
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
                                    window.location.reload();
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
                        title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {

                            }
                        }
                    });
                }
            };
            $('#course_form').ajaxForm(options);
        });
        minQualification("min_qualification");
        $(document).on("click", "#add_newCourseType", function () {
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
                                    getCourses('');
                                    $("#CourseType").modal("hide");
                                }, Reload: function () {
                                    window.location.reload();
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

                            },
                            Reload: function () {
                                window.location.reload();
                            }
                        }
                    });
                }
            };
            $('#addCourseType_form').ajaxForm(options);
        });
        $(document).on("click", "#add_new_duration", function () {
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
                                    timeDurationNew('timeDurationId', '');
                                    $("#addDuration").modal("hide");
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

                            },
                            Reload: function () {
                                window.location.reload();
                            }
                        }
                    });
                }
            };
            $('#Duration_form').ajaxForm(options);
        });
        $(document).on("click", "#add_newType", function () {
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
                                    $("#addType").modal("hide");
                                    courseDurationType('courseDurationType', '');
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {

                                }
                            }});
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
            $('#addType_form').ajaxForm(options);
        });
        $(document).on("click", "#addInstCourseName", function () {
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
        $(document).on("click", "#addCourseName", function () {
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
        windowForm = $("#mainDiv").html();
    });
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
    function getCourses(selval) {
        courseTypearray = [];
        $.ajax({
            url: "<?php echo site_url('institute/getCourseType'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Course Type</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].insCourseId + '">' + json[i].title + '</option>';
                    courseTypearray[json[i].insCourseId] = json[i].title;
                }
                $('#courseTypeId').html(data);
                $('#courseTypeId').val(selval);
            }
        });
    }
    function courseTypearr(selval) {
        if (courseTypearray.length > 0) {
            var data = '<option value="">Select</option>';
            for (var key in courseTypearray) {

                data = data + '<option value="' + key + '"  >' + courseTypearray[key] + '</option>';
            }
            $('#courseTypeId').html(data);
            $('#courseTypeId').val(selval);
        }
    }
    function minQualification(min_qualification) {
        minqlaificationsarr = [];
        minqlaificationsarr1 = [];
        $.ajax({
            url: "<?php echo site_url('Institute/getMinQualification'); ?>",
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
                $(".min_qualification").each(function () {
                    var valueis = $(this).val();
                    $(this).html(data);
                    $(this).val(valueis);
                });
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
            //options = options + '<option value="' + key + '" ' + (minQualificationset === key ? 'selected' : '') + '>' + minqlaificationsarr[key] + '</option>';
        }
        var mType = '<option value="">Select</option>';
        for (var key in markingType) {
            mType = mType + '<option value="' + markingType[key] + '"  ' + (markingType[key] === markingTypes ? "selected" : "not") + '>' + markingType[key] + '</option>';
        }
        $("#course_prerequistesdiv").append('<div class="divadded" id="divremove' + count + '">\n\
                                     <div class="col-md-12 col-sm-12">\n\
                                        <div class="col-md-6 col-sm-12"><h4>Select condition between pre-requisites</h4></div> \n\
\n\                                     <div class="col-md-2 col- col-sm-12  col-md-offset-2"><select name="condition[]" class="form-control" id="relation' + count + '" data-validation="required">\n\
<option value="AND">AND</option><option value="OR">OR</option></select></div>\n\
                                    </div>\n\
                                    <div class="col-md-5 col-sm-12 nopadding">\n\
                                        <div class="col-md-6 col-sm-12">\n\
                                            <div class="form-group">\n\
                                                <label for="Title">Min. Qual. Req.</label>\n\
                                                    <select class="form-control min_qualification" name="min_qualification[]" onchange="getStream(\'min_qualification' + count + '\',\'\');" id="min_qualification' + count + '" >' + options + '</select>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-md-6 col-sm-12">\n\
                                            <div class="form-group">\n\
                                                <label for="Title">Min. Qual.(Stream)</label>\n\
                                                    <select   class="form-control min_qualificationStream" name="min_qualificationStream[]" id="Streammin_qualification' + count + '" ></select>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-md-6 col-sm-12">\n\
                                        <div class="col-md-6 col-sm-12">\n\
                                            <div class="form-group">\n\
                                                <label for="Title">Marking Type</label>\n\
                                                <select name="markingType[]" id="markingType' + count + '" class="form-control markingType" >' + mType + '</select>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-md-6 col-sm-12">\n\
                                            <div class="form-group">\n\
                                                <label for="Title">Marking Value</label>\n\
                                                <input type="text" class="form-control" name="min_percentage[]" value="' + percentage + '" id="min_percentage' + count + '">\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-md-1 col-sm-12">\n\
                                        <br><a href="javascript:" onclick="removediv(\'divremove' + count + '\');" class="remove_field fa fa-remove btn btn-danger"></a>\n\
                                    </div>\n\
                                </div>'); //add input box

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
                    <label for="Title">Description  <small>(Industry Type/ Business Name)</small></label>\n\
                    <input type="text" class="form-control" name="description[]" id="description" data-validation="required" value="' + description + '" placeholder="Description">\n\
                </div>\n\
            </div>\n\
            <div class="col-md-1"><br><a href="javascript:" onclick="removediv(\'divExperience' + count + '\');" class="btn btn-danger fa fa-remove"></a></div></div>');
    }
    function removediv(id) {
        $('#' + id).remove();
    }
    var timedurationar = [];
    function timeDurationNew(timeDurationId, selId) {
        timedurationar = [];
        $.ajax({
            url: "<?php echo site_url('Institute/getTimeDuration'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Duration</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].tdId + '">' + json[i].title + '</option>';
                    timedurationar[json[i].tdId] = json[i].title;
                }
                $('#' + timeDurationId).html(data);
                $('#' + timeDurationId).val(selId);
                $(".timeDurationClass").each(function () {
                    var valueset = $(this).val();
                    $(this).html(data);
                    $(this).val(valueset);
                });
            },
            error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
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
    function timeDuration(timeDurationId, selId) {
        if (timedurationar.length > 0) {
            var options = '<option value="">Select Duration</option>';
            for (var key in timedurationar) {
                options = options + '<option value="' + key + '"  >' + timedurationar[key] + '</option>';
            }
            $('#' + timeDurationId).html(options);
            $('#' + timeDurationId).val(selId);
        } else {
            timeDurationNew(timeDurationId, selId);
        }

    }
    courseDurationType("courseDurationType", "");
    function courseDurationType(location, val) {
        durationTypearr = [];
        $.ajax({
            url: "<?php echo site_url('institute/getCourseDurationType'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Select</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].typeTile + '">' + json[i].typeTile + '</option>';
                    //durationTypearr[json[i].typeTile] = json[i].typeTile;
                    durationTypearr.push(json[i].typeTile);
                }
                $('#' + location).html(data);
                $('#' + location).val(val);
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
    function courseDurationTypeFromArr(location, val) {
        if (durationTypearr.length > 0) {
            var mType = '<option value="">Select</option>';
            for (var key in durationTypearr) {
                mType = mType + '<option value="' + durationTypearr[key] + '"   >' + durationTypearr[key] + '</option>';
            }
            $("#" + location).html(mType);
            $("#" + location).val(val);
        } else {

        }
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
                        markingType.push(rjson[i].markingTitle);
                    }
                }
                $(".markingTypeClass").each(function () {
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
                                    $("#addnewQualifications").modal('hide');
                                    document.getElementById("addnewClassName").reset();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    $("#addnewQualifications").modal('hide');
                                    document.getElementById("addnewClassName").reset();
                                }
                            }
                        });
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
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }

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
    function getCName(id) {
        var courseTypeId = $('#' + id).val();
        var selected_cId = "";
        getcourseTypeBycourse(courseTypeId, selected_cId, 'addcourseNameId');
    }
    function getcourseTypeBycourse(ctId, selected_cId, selId) {
        $.ajax({
            url: "<?php echo site_url('Home/getcourseTypeBycourse'); ?>",
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

                        }
                    }
                });
            }
        });
    }
    function getOrgCourseType() {
        $.ajax({
            url: "<?php echo site_url('Home/getOrgCourseType'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Course Type</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].ctId + '">' + json[i].courseType + '</option>';
                }
                $('#addcourseNameTypeId').html(data);
                $('#addcourseTypeId').html(data);
            }
        });
    }
    $(document).on("click", "#addMinQualStream", function () {
        $("#headingtext").html('<i class="fa fa-navicon m-r-5"></i> Add Minimum Qualification Streams');
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
        getOrgCourseType();
    });
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
    function getFeeCycle(location, selval) {
        feeCycleArray = [];
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('home/getFeeCycle'); ?>",
            success: function (response) {
                if (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].feecycleId + '">' + json[i].title + '</option>';
                        feeCycleArray[json[i].feecycleId] = json[i].title;
                    }
                    $("#" + location).html(data);
                    $("#" + location).val(selval);
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
        });
    }
    function feeCyclearray(location, selval) {
        if (feeCycleArray.length > 0) {
            var data = '<option value="">Select</option>';
            for (var key in feeCycleArray) {
                data = data + '<option value="' + key + '"   >' + feeCycleArray[key] + '</option>';
            }
            $("#" + location).html(data);
            $("#" + location).val(selval);
        }
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
                                <form method="post" action="javascript:" id="addnewClassName">
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
                                        <select name="marking_system" id="marking_system_id" class="form-control markingTypeClass" >
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