<?php include_once 'university_header.php'; ?>
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
            <li class="active"> Request Course</li>
        </ol>
    </section>

    <div class="modal fade" id="addcustom" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-user m-r-5"></i> Add Course Type</h3>
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
    <!-- /.modal -->
    <!--/ for courses Modal start-->
    <div class="modal fade" id="addcourse" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-user m-r-5"></i> Add Courses</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('university/addreqCourse', ["name" => "course_form", "id" => "course_form"]); ?>
                            <input type="hidden" name="id" id="id" value="no_one">
                            <fieldset>
                                <!-- Text input-->
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Course Type:</label>
                                    <select id="course_type_id" name="course_type_id"
                                            data-validation="required" class="form-control"></select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Courses:</label>
                                    <input type="text" placeholder="Courses" id="course" name="course"
                                           data-validation="required" class="form-control">
                                </div>
                                <div class="col-md-12 form-group user-form-group">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary" id="add_course">
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
    <!--/ for courses Modal End-->

    <!--/ for Stream Modal Start-->
    <div class="modal fade" id="addstream" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-user m-r-5"></i> Add Stream</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('university/addreqStream', ["name" => "stream_form", "id" => "stream_form"]); ?>
                            <input type="hidden" name="id" id="id" value="no_one">
                            <fieldset>
                                <!-- Text input-->
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Course:</label>
                                    <select id="course_id" name="course_id"
                                            data-validation="required" class="form-control"></select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Stream:</label>
                                    <input type="text" placeholder="Stream" id="stream" name="stream"
                                           data-validation="required" class="form-control">
                                </div>
                                <div class="col-md-12 form-group user-form-group">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary" id="add_stream">
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
    <!--/ for Stream Modal End-->

    <!--/ for minimum Qualification Modal Start-->
    <div class="modal fade" id="addqual" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-user m-r-5"></i> Add Course Minimum Qualification</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('university/addreqQuali', ["name" => "qual_form", "id" => "qual_form"]); ?>
                            <input type="hidden" name="id" id="id" value="no_one">
                            <fieldset>
                                <!-- Text input-->
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Minimum Qualification:</label>
                                    <input type="text" id="title" name="title" data-validation="required" class="form-control" placeholder="Course Minmum Qualification">
                                </div>
                                <div class="col-md-12 form-group user-form-group">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary" id="add_qual">
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
    <!--/ for minimum Qualification Modal End-->
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Request For Courses</h3>
                        <!--                            <h3 style="float: right" class="box-title"><a href="checkRequestedStatus"><button class="btn btn-primary">View Requested Status</button></a></h3>-->
                    </div>
                    <form>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" name="id" id="id" value="no_one">

                                <div class="col-md-12">
                                    <fieldset>
                                        <legend style="color: #00a65a">Course Information</legend>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Course Type</label>
                                        <select name="courseTypeId" id="courseTypeId" class="form-control" data-validation="required"></select><span class="help-block"><a
                                                href="#" data-toggle="modal" data-target="#addcustom">Request For Course Type? Click Here <i
                                                    class="fa fa-plus"></i> </a></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Course</label>
                                        <select name="courseId" id="courseId" class="form-control" data-validation="required"></select><span class="help-block"><a
                                                href="#" data-toggle="modal" data-target="#addcourse" id="addCoursepopup">Request For Courses? Click Here <i
                                                    class="fa fa-plus"></i> </a></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="a2">
                                        <label>Select Streams</label>
                                        <select name="streamId" id="streamId" class="form-control"
                                                data-validation="required"></select><span class="help-block"><a
                                                href="#" data-toggle="modal" data-target="#addstream" id="addStreampopup">Request For Stream? Click Here <i
                                                    class="fa fa-plus"></i> </a></span>
                                    </div>
                                </div>
                                <!--                                    <div class="col-md-12 hidden">
                                                                        <fieldset>
                                                                            <legend style="color: #00a65a">Course Pre-requisites</legend>
                                                                        </fieldset>
                                                                    </div>
                                                                    <div class="row col-lg-12 col-md-12 hidden" id="course_variant">
                                                                        <div class="col-md-5">
                                                                            <div class="form-group">
                                                                                <label for="Title">Minimum Qualification required</label>
                                                                                <select class="form-control min_qualification"
                                                                                        name="min_qualification[]" id="min_qualification"
                                                                                        data-validation="required"></select><span class="help-block"><a
                                                                                            href="#" data-toggle="modal" data-target="#addqual">Request For Minimum Qualification? Click Here <i
                                                                                                class="fa fa-plus"></i> </a></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>-->
                                <div class="col-md-12">
                                    <fieldset>
                                        <legend style="color: #00a65a">Add New Class Information</legend>
                                    </fieldset>
                                </div>
                                <?php echo form_open('university/addNewClassType', ["id" => "newClassType"]); ?>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Select Class Name</label>
                                        <select name="classTitle" id="classTitle" class="form-control" data-validation="required"></select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Available Class Types</label>
                                        <select name="classType" id="classType" class="form-control" ></select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>New Class Types</label>
                                        <input type="text" class="form-control" name="newClassType" data-validation="required" placeholder="New Class Type *">
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" value="Save Class" name="addNewClass" />
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </form>
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
    $(".req_course").addClass("active");
    document.title = "iHuntBest | Request Course";
</script>
<script type="text/javascript">
    function getclassTitle() {
        $.ajax({
            url: "<?php echo site_url('Home/getClassNames'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Select</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].classTitle + '">' + json[i].classTitle + '</option>';
                }
                $('#classTitle').html(data);
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
    $(document).ready(function () {
        getclassTitle();
        $("#addCoursepopup").click(function () {
            $("#course_type_id").val($("#courseTypeId").val());
        });
        $("#addStreampopup").click(function () {
            $("#course_id").val($("#courseId").val());
        });
        getCourses();
        $.validate({
            lang: 'en'
        });
        getCourses();
        $.ajax({
            url: "<?php echo site_url('University/getMinQualification'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Min Qualification</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].courseId + ',' + json[i].tablename + '">' + json[i].courseName + '</option>';
                }
                $('.min_qualification').html(data);
            }
        });
        $('#add_qual').click(function () {
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
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#qual_form').ajaxForm(options);
        });
        $('#add_course').click(function () {
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
                            typeAnimated: true});
                    }

                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#course_form').ajaxForm(options);
        });

        $('#add_course_type').click(function () {
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
                            typeAnimated: true});
                    }

                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#coursetype_form').ajaxForm(options);
        });

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
                    $('#course_type_id').html(data);
                }
            });
        }
        $('#courseTypeId').change(function () {
            var courseTypeId = $('#courseTypeId').val();
            var selected_cId = "";
            getcourseTypeBycourse(courseTypeId, selected_cId);
        });
        function getcourseTypeBycourse(ctId, selected_cId) {
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
                    $('#courseId').html(data);
                    $('#course_id').html(data);
                    $('#courseId').val(selected_cId);
                }
            });
        }
        $('#courseId').change(function () {
            var courseId = $('#courseId').val();
            var selected_streamId = "";
            getstreamBycourse(courseId, selected_streamId);
        });
        function getstreamBycourse(courseId, selected_streamId) {
            $.ajax({
                url: "<?php echo site_url('university/getstreamBycourse') ?>",
                type: 'POST',
                data: 'courseId=' + courseId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose Stream</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].streamId + '">' + json[i].title + '</option>';
                    }
                    $('#streamId').html(data);
                    $('#streamId').val(selected_streamId);
                }
            });
        }
        $('#add_stream').click(function () {
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
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#stream_form').ajaxForm(options);
        });
    });
</script>