<?php
include_once 'student_header.php';
?>
<style>
    .activex{
        background-color: #e9e9e9;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Institute Education Details
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student'); ?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Edit | Insert Institute Exams</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Institute Exams Details</h3>
                        </div>
                        <?php echo form_open('student/insertInstituteEducationDetails', ["name" => "institute_details_form", "id" => "institute_details_form_id"]); ?>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" class="hidden" value="no_id" name="studentInsId" id="studentInsId_id">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Course Name:</label>
                                    <select name="insCourseId" id="insCourseId_id" class="form-control" data-validation="required">
                                        <option>Select Course</option>
                                        <?php
                                        if (isset($inscourseNames)) {
                                            foreach ($inscourseNames as $ic) {
                                                echo '<option value="' . $ic->insCourseId . '">' . $ic->title . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Marking Type:</label>
                                    <select name="markingType" id="markingType_Id" class="form-control" data-validation="required">
                                        <option>Select</option>
                                        <?php
                                        if (isset($markingType)) {
                                            foreach ($markingType as $mt) {
                                                echo '<option value="' . $mt->markingTitle . '" >' . $mt->markingTitle . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Marking Value:</label>
                                    <input type="text" placeholder="Marking Value" id="markingValue_id" name="markingValue" value=""  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Course Start Date:</label>
                                    <input type="date" onchange="dateValidation('coursestartDate_id', 'courseendDate_id', 'coursestartDate_id');" placeholder="Course Start Date" id="coursestartDate_id" name="coursestartDate" value=""  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Course End Date:</label>
                                    <input type="date" onchange="dateValidation('coursestartDate_id', 'courseendDate_id', 'courseendDate_id');" placeholder="Course End Date" id="courseendDate_id" name="courseEndDate" value=""  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Institute Name:</label>
                                    <input type="text" placeholder="Institute Name" id="instituteName_id" name="instituteName" value=""  data-validation="required" class="form-control">
                                    <input type="hidden" class="hidden" id="loginid" name="loginid">
                                    <div id="autocompletediv" class="nopadding">
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Higher Education Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Course Name</th>
                                                <th>Marking Details</th>
                                                <th>Course Start Date</th>
                                                <th>Course End Date</th>
                                                <th>Institute Name</th>
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
        </div>

    </section>
    <!-- /.content -->
</div>
<?php include_once 'student_footer.php'; ?>
<script>
    $(".profile_link").addClass("active");
    $(".edit_ins_link").addClass("active");
    document.title = "iHuntBest | Higher Education Details";
    function CourseName(CourseType, selectedCourse) {
        if (CourseType === "") {
            $.alert({
                title: 'Error!', content: "Course Type can not be empty!", type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: function () {
                        window.location.herf = "studentSenSecondarySchoolDetails";
                    }
                }
            });
        } else {
            $.ajax({
                url: '<?php echo site_url('Student/getCourseNames'); ?>',
                type: 'POST',
                data: {CourseType: CourseType},
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].cId + '">' + json[i].title + '</option>';
                    }
                    $("#course_name_id").html(data);
                    $("#course_name_id").val(selectedCourse);
                    $("#stream_Id").val('');
                }

            });
        }
    }
    function StreamName(course_name, selStream) {
        if (course_name === "") {
            $.alert({
                title: 'Error!', content: "Course Name can not be empty!", type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: function () {
                        window.location.herf = "studentSenSecondarySchoolDetails";
                    }
                }
            });
        } else {
            $.ajax({
                url: '<?php echo site_url('Student/getStreamNames'); ?>',
                type: 'POST',
                data: {course_name: course_name},
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].streamId + '">' + json[i].title + '</option>';
                    }
                    $("#stream_Id").html(data);
                    $("#stream_Id").val(selStream);
                }

            });
        }
    }
    function selElement(i) {
        console.log($("#searchterm" + i).attr("loginId"));
        $("#instituteName_id").val($("#searchterm" + i).html());
        $("#loginid").val($("#searchterm" + i).attr("loginId"));
        $("#autocompletediv").html('');

    }
    function selectValof(id, direction) {
        console.log("id" + id, "direction" + direction);
        if ("downdirection" === direction) {
            if ("instituteName_id" === id) {
                $("#searchterm0").addClass('activex');
            } else {
                var ival = parseInt($("#" + id).attr("ival"));
                (ival + 1 === $(".orgnamediv").length() ? $("#searchterm0").addClass('active') : $("#searchterm" + (ival + 1)).focus());
            }
        }
        if ("updirection" === direction) {
            if ("instituteName_id" === id) {
                return false;
            } else {
                var ival = parseInt($("#" + id).attr("ival"));
                (ival === 0 ? $("#instituteName_id").focus() : $("#searchterm" + (ival - 1)).focus());
            }
        }
    }
    dataTable();
    function dataTable() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("Student/getInstituteEducationDetail"); ?>",
            data: {},
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#details_table').dataTable();
                var marksDetails = "";
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    marksDetails = json[i].markingValue + ' ' + json[i].markingType;
                    oTable.fnAddData([
                        (i + 1),
                        json[i].title,
                        marksDetails,
                        json[i].csdate,
                        json[i].cedate,
                        json[i].instituteName,
                        '<a href="javascript:" class="editRecord"  studentInsId="' + json[i].studentInsId + '" title="Edit"><i class="fa fa-edit"></i></i></a>\n\
        &nbsp;&nbsp;&nbsp;&nbsp;<a  href="javascript:" class="deleteRecord" studentInsId="' + json[i].studentInsId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });
    }
    $(document).on('keyup', ".orgnamediv", function (e) {
        if (e.keyCode === 40) {

            selectValof($(this).attr("id"), "downdirection");
            return false;
        }
        if (e.keyCode === 38) {
            selectValof($(this).attr("id"), "updirection");
            return false;
        }
    });
    $(document).on('keyup', '#instituteName_id', function (e) {
        var insName = $(this).val();
        if (e.keyCode === 40) {
            selectValof("instituteName_id", "downdirection");
            return false;
        }
        if (insName === "") {
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("student/getinstitutenames"); ?>",
            data: {insName: insName},
            success: function (response) {
                if (response !== '') {
                    var responsearr = $.parseJSON(response);
                    var dropdowndata = '';
                    for (var i = 0; i < responsearr.length; i++) {
                        dropdowndata = dropdowndata + '<div id="searchterm' + i + '" ival="' + i + '" onclick="selElement(' + i + ');" loginId="' + responsearr[i].loginId + '"  class="orgnamediv nopadding">' + responsearr[i].orgName + '</div>';
                    }
                } else {
                    var dropdowndata = '<div id="searchterm0" onclick="selElementL(0);" loginids="" class="searchterms nopadding">No Results Found</div>';
                }
                var divdata = '<div id="searchboxautocomplete-list"  class="autocomplete-items nopadding">' + dropdowndata + '</div>';
                $("#autocompletediv").html(divdata);
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
        });
    });
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $("#courseType_id").change(function () {
            var CourseType = $(this).val();
            CourseName(CourseType, "");
        });
        $("#course_name_id").change(function () {
            var course_name = $(this).val();
            StreamName(course_name, "");
        });
        $('#save_details').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {

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
            $('#institute_details_form_id').ajaxForm(options);
        });
        $(document).on('click', '.editRecord', function () {
            var studentInsId = $(this).attr('studentInsId');
            if (studentInsId !== "") {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Student/getInstituteEducationDetail"); ?>",
                    data: {studentInsId: studentInsId},
                    success: function (response) {
                        if (response !== "") {
                            var json = $.parseJSON(response);
                            $("#studentInsId_id").val(json.studentInsId);
                            $("#insCourseId_id").val(json.insCourseId);
                            $("#markingType_Id").val(json.markingType);
                            $("#markingValue_id").val(json.markingValue);
                            $("#coursestartDate_id").val(json.coursestartDate);
                            $("#courseendDate_id").val(json.courseEndDate);
                            $("#instituteName_id").val(json.instituteName);
                            $("#loginid").val(json.loginid);
                        }
                    },
                    error: function (response) {
                        $.alert({
                            title: 'Error!', content: response, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                }
                            }
                        });
                    }
                });
            }
        });
        $(document).on('click', '.deleteRecord', function () {
            var studentInsId = $(this).attr('studentInsId');
            if (studentInsId !== "") {
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
                                url: "<?php echo site_url("Student/delInstEduDetail"); ?>",
                                data: {studentInsId: studentInsId, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                success: function (response) {
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
                                    $.alert({
                                        title: 'Error!', content: response, type: 'red',
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
                    }
                });
            }
        });
    });
    function selectCollege(orgname, orgId) {
        $("#collegeName").val(orgname);
        $("#collegeOrg_id").val(orgId);
        $("#collegesuggesstion-box").hide();
    }
    function selectUniversity(orgname, orgId) {
        $("#universityName").val(orgname);
        $("#universityOrg_id").val(orgId);
        $("#suggesstion-box").hide();
    }

</script>
