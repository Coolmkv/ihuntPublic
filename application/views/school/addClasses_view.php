<?php
include_once 'school_header.php';
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
            Classes
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('school/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Course</a></li>
            <li class="active"> Add Classes</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Courses</h3>
                    </div>

                    <?php echo form_open('school/addSaveClasses', ["name" => "class_form", "id" => "class_form"]); ?>
                    <div class="box-body">
                        <div class="row" >
                            <div class="col-md-12 nopadding" id="mainDiv">
                                <input type="hidden" name="id" id="id" value="no_one">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select name="class" id="className" class="form-control" data-validation="required">
                                        </select>
                                        <span class="help-block">
                                            <a href="javascript:" id="addNewClass">Add Class? Click Here <i class="fa fa-plus"></i></a>
                                        </span>
                                    </div>

                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Class Type</label>
                                        <select name="classType" id="classType" class="form-control" data-validation="required">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="help-block">
                                            <a href="javascript:" id="addClassType">Add Class Type? Click Here <i class="fa fa-plus"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Duration Type</label>
                                        <select name="courseDurationType" id="courseDurationType" class="form-control" data-validation="required">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="help-block">
                                            <a href="#" data-toggle="modal" data-target="#addType">Add Type? Click Here <i class="fa fa-plus"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 nopadding">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Tuition Fee</label>
                                            <div class="input-group">
                                                <input type="number" name="courseFee" id="courseFee" class="form-control" data-validation="required">
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
                                            <input type="number" name="totalSheet" onchange="checkMinMaxValue('availableSheet', 'totalSeat', 'totalSeat');" id="totalSeat" class="form-control" data-validation="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Available Seats</label>
                                        <input type="number" name="availableSheet" onchange="checkMinMaxValue('availableSheet', 'totalSeat', 'availableSheet');" id="availableSheet" class="form-control" data-validation="required">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Registration Fee</label>
                                        <div class="input-group">
                                            <input type="number" name="registrationFee" id="registrationFee" class="form-control" >
                                            <span class="input-group-addon"><?php echo $currency; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Fee Submit Start Date</label>
                                        <input type="date" onchange="dateValidation('fromDate', 'toDate', 'fromDate');" name="fromDate" id="fromDate" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Fee Submit End Date</label>
                                        <input type="date" onchange="dateValidation('fromDate', 'toDate', 'toDate');" name="toDate" id="toDate" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Application Start Date</label>
                                        <input type="date" onchange="dateValidation('openingDate', 'closingDate', 'openingDate');" name="openingDate" id="openingDate" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Application End Date</label>
                                        <input type="date" onchange="dateValidation('openingDate', 'closingDate', 'closingDate');" name="closingDate" id="closingDate" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Application Fee</label>
                                        <div class="input-group">
                                            <input type="text" name="applicationFee" id="applicationFeeId" class="form-control numOnly" value="0" placeholder="Application Fee" data-validation="required">
                                            <span class="input-group-addon"><?php echo $currency; ?></span>
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
                                            <input type="text" class="form-control numOnly preReqagediv" onchange="checkMinMaxValue('minage', 'maxage', 'minage');" max="100" name="minage" id="minage"  placeholder="Min-Age">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Max Age in Years</label>
                                            <input type="text" class="form-control numOnly preReqagediv" onchange="checkMinMaxValue('minage', 'maxage', 'maxage');" max="100" name="maxage" id="maxage"  placeholder="Max-Age">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Age as on</label>
                                            <input type="date"   class="form-control preReqagediv" name="validupto" id="validupto" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <div class="col-md-6 col-sm-12 nopadding">
                                            <legend style="color: #00a65a">Course Pre-requisites</legend>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="col-md-8 col-sm-12">
                                                <h4 width="fit-contents">Set Course Pre-requisites  (if required)</h4>
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

                                <div class="col-lg-12 col-md-12 hidden" id="course_prerequistesdiv">
                                    <div class="col-md-5 col-sm-12 nopadding">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="Title">Min. Qual. Req.</label>
                                                <select class="form-control min_qualification" onchange="getStream('min_qualification', '');"  name="min_qualification[]" id="min_qualification"></select>
                                                <span class="help-block">
                                                    <a href="javascript:" id="addMinqual">Add Min. Qual.? Click Here <i class="fa fa-plus"></i></a>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="Title">Min. Qual.(Stream)</label>
                                                <select   class="form-control min_qualificationStream" name="min_qualificationStream[]" id="Streammin_qualification" ></select>
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
                                                <select name="markingType[]" id="markingType" class="form-control markingType" ></select>
                                                <span class="help-block">
                                                    <a href="javascript:" id="addMarkingType">Add Marking Type? Click Here <i class="fa fa-plus"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="Title">Marking Value</label>
                                                <input type="text" class="form-control" name="min_percentage[]" placeholder="90%,A or Any" id="min_percentage">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-12">
                                        <br>
                                        <div class="form-group">
                                            <button type="button" onclick="addPreRequisite('', '', '');" class="btn btn-success">+</button>
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
                                                <select name="examMode" id="examModeId" class="form-control examdiv">

                                                </select>
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
                                                <input type="date" name="examDate" onchange="dateValidation('examDate', 'resultDateId', 'examDate');"    id="examDate" class="form-control examdiv" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Result Date</label>
                                            <input type="date" name="resultDate" onchange="dateValidation('examDate', 'resultDateId', 'resultDateId');" id="resultDateId" class="form-control examdiv">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 text-center">
                                <div class="form-group" style="margin-top: 23px;">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_class" id="save_class" value="Save">
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
                                <table id="classes_table" class="table table-bordered table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Class Details</th>
                                            <th>Class Type</th>
                                            <th>Course Fee Details</th>
                                            <th>Total/Available Seats</th>
                                            <th>Minimum Qualification</th>
                                            <th>Important Dates</th>
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

<?php include_once 'school_footer.php'; ?>
<script>
    $(".add_Classes").addClass("active");
    $(".add_Classes_link").addClass("active");
    document.title = "iHuntBest | Add Class";
</script>
<script type="text/javascript">
    var windowForm = "";
    function courseDurationType() {
        durationarr = [];
        $.ajax({
            url: "<?php echo site_url('School/getCourseDurationType'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Select</option>';
                for (var i = 0; i < json.length; i++) {
                    durationarr[json[i].typeTile] = json[i].typeTile;
                    data = data + '<option value="' + json[i].typeTile + '">' + json[i].typeTile + '</option>';
                }
                $('#courseDurationType').html(data);
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
    var minqlaificationsarr = [];
    var minqlaificationsarr1 = [];
    var markingType = [];
    var examModearr = [];
    var durationarr = [];
    var feeCyclearr = [];
    function classNames(selval, position) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('school/getClassNames'); ?>",
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
    function removediv(id) {
        $('#' + id).remove();
    }
    function getClassType(classTypeId, selclassTypeId) {
        $.ajax({
            type: "POST",
            data: {classTypeId: classTypeId},
            url: "<?php echo site_url('school/getSchoolClassType'); ?>",
            success: function (response) {
                if (response === "noData") {
                    $("#classType").attr("data-validation", "");
                    $("#classType").html('<option value="">Not available</option>');
                } else {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].classTypeId + '">' + json[i].title + '</option>';
                    }
                    $("#classType").html(data);
                    if (selclassTypeId === "0") {
                        selclassTypeId = "";
                    }
                    $("#classType").val(selclassTypeId);
                }
            }
        });
    }
    function minQualification(min_qualification) {
        minqlaificationsarr = [];
        minqlaificationsarr1 = [];
        $.ajax({
            url: "<?php echo site_url('school/getMinQualification'); ?>",
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
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });

        examMode('examModeId', '', '<?php echo site_url('home/getExamMode'); ?>');
        $("#addMinqual").click(function () {
            $("#addnewQualifications").modal('show');
        });
        getFeeCycle('feeCycle_id', '');
        courseDurationType();
        classNames('', 'className');
        minQualification('min_qualification');
        datatable();
        $(document).on('change', '#className', function () {
            var classTypeId = $(this).val();
            if (classTypeId === '') {
                $.alert({title: 'Error!', content: "Please select any value", type: 'red',
                    typeAnimated: true});
                $(this).focus();
                return false;
            } else {
                getClassType(classTypeId, '');
            }

        });
        $(document).on("click", ".editClasses", function () {
            $("#mainDiv").html(windowForm);
            console.log(windowForm);
            var sClassId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "ed=" + sClassId,
                url: "<?php echo site_url("school/getClasses"); ?>",
                success: function (response) {

                    var json = $.parseJSON(response);
                    $('#id').val(json[0].sClassId);
                    classNames(json[0].class, 'className');
                    durationArr('courseDurationType', json[0].courseDurationType);
                    getClassType(json[0].class, json[0].classTypeId);
                    $('#courseFee').val(json[0].courseFee);
                    $('#totalSeat').val(json[0].totalSheet);
                    $('#registrationFee').val(json[0].registrationFee);
                    $('#fromDate').val(json[0].feepaySdate);
                    $('#toDate').val(json[0].feepayEdate);
                    $('#openingDate').val(json[0].applyFrom);
                    $('#closingDate').val(json[0].applyTo);
                    $('#examDate').val(json[0].examDate);
                    feeCycleArr('feeCycle_id', json[0].feecycleId)
                    $('#applicationFeeId').val(json[0].applicationFee);
                    $('#availableSheet').val(json[0].availableSheet);
                    if (json[0].maxAge) {
                        $("#preReqagediv").removeClass("hidden");
                        $("#buttonpreReqagediv").prop("checked", true);
                        $("#minage").val(json[0].minAge);
                        $("#maxage").val(json[0].maxAge);
                        $("#validupto").val(json[0].ageValidDate);
                    }
                    if (json[0].examMode) {
                        $("#examdiv").removeClass("hidden");
                        $("#buttonexamdiv").prop("checked", true);
                        examModeArr('examModeId', json[0].examMode);
                        $("#examDetailsId").val(json[0].examDetails);
                        $("#examDate").val(json[0].examDate);
                        $("#resultDateId").val(json[0].resultDate);
                    } else {
                        examModeArr('examModeId', '');
                    }
                    if (json[0].minQualification) {
                        $("#course_prerequistesdiv").removeClass("hidden");
                        $("#buttoncourse_prerequistesdiv").prop("checked", true);
                        var minQal = json[0].minQualification.split('^');
                        var stable = json[0].streamTable.split('^');
                        var allpercentages = json[0].percentages;
                        var percnt = allpercentages.split(',');
                        var mTypes = json[0].markingTypes.split(',');
                        var relationType = json[0].relationType.split(',');
                        for (var x = 0; x < minQal.length; x++) {
                            if (x > 0) {
                                addPreRequisite(minQal[x], percnt[x], mTypes[x]);
                                getStream('min_qualification' + x, stable[x]);
                                $("#min_qualification" + x).val();
                            } else {
                                minQualFromArr(minQal[x], 'min_qualification');
                                markingTypearr('markingType', mTypes[x]);
                                $("#min_qualification").val(minQal[x]);
                                $("#min_percentage").val(percnt[x]);
                                getStream('min_qualification', stable[x]);
                            }
                        }
                        for (var x = 0; x < relationType.length; x++) {
                            var j = x + 1;
                            $("#relation" + j).val(relationType[x]);
                        }
                    } else {
                        minQualFromArr('', 'min_qualification');
                        markingTypearr('markingType', '');
                        $("#min_qualification").val('');
                        $("#min_percentage").val('');
                        $('.divadded').remove();
                    }
                    $('html, body').animate({
                        'scrollTop': $(".main-header").position().top
                    });
                }
            });
        });
        $(document).on("click", ".delclasses", function () {
            var sClassId = $(this).attr("del");
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
                            data: "del=" + sClassId,
                            url: "<?php echo site_url("school/deleteClasses"); ?>",
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
                                        typeAnimated: true});
                                }
                            }
                        });
                    }
                }
            });
        });
        $(document).on('click', '#save_class', function () {
            var options = {
                beforeSend: function () {
                    if ($("#totalSeat").val() < $("#availableSheet").val()) {
                        $.alert({title: 'Error!', content: 'Total Seats Cannot be less than available seats', type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    $("#availableSheet").focus();
                                    return false;
                                }
                            }
                        });
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
                            typeAnimated: true,
                            buttons: {
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
            $('#class_form').ajaxForm(options);
        });
        $(document).on('click', '#add_newType', function () {

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
                                window.location.reload();
                            }
                        }
                    });
                }
            };
            $('#addType_form').ajaxForm(options);
        });
        $(document).on('click', '#add_MarkingType', function () {
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
            $('#addMarkingType_form').ajaxForm(options);
        });
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
            if (markingType.lenght > 0) {
                var mType = '<option value="">Select</option>';
                for (var key in markingType) {
                    mType = mType + '<option value="' + markingType[key] + '"  ' + (markingType[key] === markingTypes ? "selected" : "not") + '>' + markingType[key] + '</option>';
                }
                $("#" + location).html(mType);
            } else {
                getMarkingType(location);
            }

        }
        getMarkingType("markingType");
        getMarkingTypeExisting("marking_system_id");
        $(document).on('click', '#addcompetitveExam', function () {
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
        $(document).on('click', '#addSubject', function () {
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
        $(document).on('click', '#addMarkingType', function () {
            $("#addMarkingTypeModal").modal("show");
        });

        function datatable() {
            $.ajax({
                type: "POST",
                data: "",
                url: "<?php echo site_url("school/getClasses"); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    var oTable = $('table#classes_table').dataTable();
                    oTable.fnClearTable();
                    for (var i = 0; i < json.length; i++) {
                        var minQualifications = '';
                        var allminQual = json[i].minQualification;
                        if (allminQual) {
                            var markingTypes = json[i].markingTypes.split(',');
                            //var streamIds = json[i].minqualstreamIds.split(',');
                            var minQal = allminQual.split('^');
                            var allpercentages = json[i].percentages;
                            var percnt = allpercentages.split(',');
                            var streamName = json[i].streamNames.split(',');
                            for (var x = 0; x < minQal.length; x++) {
                                minQualifications = minQualifications + 'MinQalification: ' + minqlaificationsarr1[minQal[x]]
                                        + '<br>Stream :' + streamName[x] + '<br>' + markingTypes[x] + ':' + percnt[x] + '<br>';
                            }

                        }
                        oTable.fnAddData([
                            (i + 1),
                            json[i].class + ' ' + (json[i].courseDurationType ? '(' + json[i].courseDurationType + ')' : ''),
                            json[i].title,
                            'Course Fee : ' + json[i].courseFee + '<br>Reg Fee : ' + json[i].registrationFee,
                            json[i].totalSheet + '/' + json[i].availableSheet,
                            minQualifications,
                            'Apply From : ' + json[i].applysdate + '<br>Apply To : ' + json[i].applyedate + '<br>Exam On : ' + json[i].exmdate + '<br>Fee Submit From : ' + json[i].feesdate +
                                    '<br> Fee Submit To: ' + json[i].feeEdate,
                            '<a href="javascript:" class="editClasses" ed="' + json[i].sClassId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" class="delclasses" del="' + json[i].sClassId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                        ]);
                    }
                }
            });
        }
        windowForm = $("#mainDiv").html();
    });
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
    $(document).on('click', '#feeCycleModalId', function () {
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
    $(document).on('click', '#addNewClass', function () {
        $("#headingtext").html('<i class="fa fa-navicon m-r-5"></i> Add Class');
        $("#bodyMaterial").html('<form method="post" action="javascript:">\n\
                                    <div class="col-md-6 col-md-offset-3 col-sm-12 form-group">\n\
                                        <label class="control-label">Class Name</label>\n\
                                        <input type="text" placeholder="Class Name" id="ClassNameId" name="ClassName" data-validation="required" class="form-control">\n\
                                    </div>\n\
                                    <div class="col-md-12 col-sm-12 text-center">\n\
                                        <input type="submit" class="btn btn-success" onclick="addnewClass();" value="Add Class">\n\
                                    </div>\n\
                                </form>');
        $("#commonModal").modal('show');
    });
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
                            typeAnimated: true});
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
    function requiredfied(id) {
        $.alert({
            title: 'Error!', content: "Required Field is empty.", type: 'red',
            typeAnimated: true,
            buttons: {
                Ok: function () {
                    $("#" + id).focus();
                }
            }
        });
    }
    $(document).on('click', '#addClassType,#addMinQualStream', function () {
        $("#headingtext").html('<i class="fa fa-navicon m-r-5"></i> Add Class Type');
        $("#bodyMaterial").html('<form method="post" action="<?php echo site_url("home/addClassType"); ?>" id="addClassTypeform">\n\
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
                                </form>');
        $("#commonModal").modal('show');
        classNames("", "classNamemodal");
    });
    $(document).on('click', '#addExamMode', function () {
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
                                getClassType($("#className").val(), '');
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
        feeCyclearr = [];
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('home/getFeeCycle'); ?>",
            success: function (response) {
                if (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        feeCyclearr[json[i].feecycleId] = json[i].title;
                        data = data + '<option value="' + json[i].feecycleId + '">' + json[i].title + '</option>';
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

</script>
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

                        <?php echo form_open('school/addType', ["name" => "addType_form", "id" => "addType_form"]); ?>
                        <input type="hidden" name="id" id="id" value="no_one">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Type:</label>
                                <input type="text" placeholder="Type" id="newType" name="newType"
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