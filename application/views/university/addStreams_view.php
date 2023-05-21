<?php
include_once 'university_header.php';
$currency = (isset($_SESSION['dCurrency']) ? (!empty($_SESSION['dCurrency']) ? $_SESSION['dCurrency'] : "NA") : 'NA');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Course Streams
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Course Streams Details</a></li>
            <li class="active"> Add Course Streams</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Course Streams</h3>
                    </div>
                    <?php echo form_open('university/addNewStreams', ["id" => "stream_form", "name" => "stream_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">

                            <div class="col-md-6">
                                <div class="form-group" id="a1">
                                    <label>Select Course </label>
                                    <select name="orgCourseId" id="orgCourseId" class="form-control"
                                            data-validation="required"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="a2">
                                    <label>Select Streams</label>
                                    <select name="streamId" id="streamId" class="form-control"
                                            data-validation="required"></select>

                                    <span class="help-block">
                                        <a href="javascript:" id="addStream">Add Stream ? Click Here <i class="fa fa-plus"></i></a>
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="a3">
                                    <label>SEO Keywords</label>
                                    <input type="text" name="seoKeywords" id="seoKeywords" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="a3">
                                    <label>Total Seats</label>
                                    <input type="number" name="totalSheet" id="totalSheet" onchange="checkMinMaxValue('availableSheet', 'totalSheet', 'totalSheet');"  class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4" id="a4">
                                <div class="form-group">
                                    <label>Available Seats</label>
                                    <input type="number" name="availableSheet" id="availableSheet" onchange="checkMinMaxValue('availableSheet', 'totalSheet', 'availableSheet');" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea class="form-control summernote"  id="description" name="description" data-validation="required"></textarea>

                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <legend style="color: #00a65a">Course Fee Structure</legend>
                                </fieldset>
                            </div>
                            <div class="col-md-12 no-padding">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Course Fee Type</label>
                                        <select name="courseFeeType" id="courseFeeType" class="form-control" data-validation="required">
                                        </select>
                                        <span class="help-block">
                                            <a href="#" data-toggle="modal" data-target="#addcourseFeeType">Add Course Fee Type? Click Here <i class="fa fa-plus"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Course Fee</label>
                                        <div class="input-group">
                                            <input type="number" name="courseFee" id="courseFee" class="form-control" data-validation="required">
                                            <span class="bg-green-gradient input-group-addon"><?php echo $currency; ?></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Registration Fee</label>
                                        <div class="input-group">
                                            <input type="number" name="registrationFee" id="registrationFee" class="form-control" data-validation="required">
                                            <span class="bg-green-gradient input-group-addon"><?php echo $currency; ?></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Date (Fee Submit)</label>
                                        <input type="date" name="fromDate" id="fromDate" class="form-control" data-validation="required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Date (Fee Submit)</label>
                                    <input type="date" name="toDate" id="toDate" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-12 text-center" style="float: right">
                                <div class="form-group">
                                    <label></label>
                                    <input style="margin-top:3px" type="submit"
                                           class="btn btn-primary" name="save_stream"
                                           id="save_stream">
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
</div>
<div class="modal fade" id="addcourseFeeType" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-money m-r-5"></i> Add Course Fee Type</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo form_open('university/addCourseFeeType', ["name" => "addCourseFeeType_form", "id" => "addCourseFeeType_form"]); ?>
                        <input type="hidden" name="id" id="id" value="no_one">
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Type:</label>
                                <input type="text" placeholder="Type" id="newFeeType" name="newFeeType"
                                       data-validation="required" class="form-control">
                            </div>
                            <div class="col-md-12 form-group user-form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="add_newFeeType">
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
<?php include_once 'university_footer.php'; ?>
<script>
    $(".streamDetails_link").addClass("active");
    $(".addstream_link").addClass("active");
    document.title = "iHuntBest | Add Streams";
</script>
<script type="text/javascript">

    var courseid = '';
    $(document).on('click', '#addStream', function () {
        $("#headingtext").html('<i class="fa fa-navicon m-r-5"></i> Add Stream Name');
        $("#bodyMaterial").html('<div class="col-md-12">\n\
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
                                                <input type="submit" class="btn btn-success" id="addStreamForm" onclick="addStreamName();" value="Add Stream">\n\
                                            </div> \n\
                                        </div> \n\
                                    </form>');
        $("#commonModal").modal('show');

        getCoursesTypes();
    });
    function getCoursesTypes() {
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
    function getCName(id) {
        var courseTypeId = $('#' + id).val();
        var selected_cId = "";
        getcourseTypeBycourse(courseTypeId, selected_cId, 'addcourseNameId');
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

    function addStreamName() {
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
                                var orgCourseId1 = $('#orgCourseId').val();
                                if (orgCourseId1) {
                                    var ArrNames = orgCourseId1.split("-");

                                    var courseId = ArrNames[1];
                                    getStreams('', courseId);
                                }

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
    function courseFeeType(position, selval) {
        $.ajax({
            url: "<?php echo site_url('Home/getCourseFeeType'); ?>",
            type: 'POST',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Select</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].courseFeeType_Id + '">' + json[i].FeeType_Name + '</option>';
                }
                $('#' + position).html(data);
                $('#' + position).val(selval);
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
    function getCourses(editorgCourseId) {
        var cid = '<?php echo $this->input->get("cid"); ?>';

        $.ajax({
            url: "<?php echo site_url('university/getCourses'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Course</option>';
                for (var i = 0; i < json.length; i++) {
                    if (editorgCourseId === json[i].orgCourseId || cid === json[i].orgCourseId) {
                        courseid = json[i].courseId;
                        data = data + '<option selected value="' + json[i].orgCourseId + '-' + json[i].courseId + '">' + json[i].department + '(' + json[i].course + ', ' + json[i].timeduration + ')</option>';
                    } else {
                        data = data + '<option value="' + json[i].orgCourseId + '-' + json[i].courseId + '">' + json[i].department + '(' + json[i].course + ', ' + json[i].timeduration + ')</option>';
                    }

                }
                $('#orgCourseId').html(data);
                if (cid !== "" && courseid !== "") {
                    getStreams('', courseid);
                }
            }
        });
    }
    getCourses("");
    function getStreams(editstreamId, courseId) {
        $.ajax({
            url: "<?php echo site_url('university/getstreamBycourse') ?>",
            type: 'POST',
            data: 'courseId=' + courseId,
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option>Choose Stream</option>';
                for (var i = 0; i < json.length; i++) {
                    if (editstreamId === json[i].streamId) {
                        data = data + '<option selected value="' + json[i].streamId + '">' + json[i].title + '</option>';
                    } else {
                        data = data + '<option value="' + json[i].streamId + '">' + json[i].title + '</option>';
                    }
                }
                $('#streamId').html(data);

            }

        });
    }
    $(document).ready(function () {



        courseFeeType('courseFeeType', '');
        $.validate({
            lang: 'en'
        });
        $('.summernote').summernote();
<?php if (isset($_GET['desp'])) { ?>
            $('#save_stream').hide();
            $('#a1').hide();
            $('#a2').hide();
            $('#a3').hide();
            $('#a4').hide();
            $('#description').attr("readonly", "readonly");

<?php } ?>


<?php if (isset($_GET['orgStreamId'])) { ?>
            var orgStreamId = '<?php echo $_GET['orgStreamId'] ?>';
            $.ajax({
                type: "POST",
                data: 'orgStreamId=' + orgStreamId,
                url: '<?php echo site_url('university/viewStreams') ?>',
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].orgStreamId);

                    $('#totalSheet').val(json[0].totalSheet);
                    $('#availableSheet').val(json[0].availableSheet);
                    $('#seoKeywords').val(json[0].seoKeywords);
                    $('#description').val(json[0].description);
                    $('#description').summernote('code', json[0].description);
                    getCourses(json[0].orgCourseId);
                    getStreams(json[0].streamId, json[0].courseId);
                    $("#courseFeeType").val(json[0].courseFeeType);
                    $("#courseFee").val(json[0].courseFee);
                    $("#registrationFee").val(json[0].registrationFee);
                    $("#fromDate").val(json[0].fromDate);
                    $("#toDate").val(json[0].toDate);
                }
            });
<?php } ?>
        $('#orgCourseId').change(function () {
            var orgCourseId1 = $(this).val();
            if (orgCourseId1) {
                var ArrNames = orgCourseId1.split("-");
                // var orgCourseId = ArrNames[0];//alert(Name1);
                var courseId = ArrNames[1];//alert(courseId);
                getStreams('', courseId);
//                console.log("org"+orgCourseId1);
            }

        });


        $('#save_stream').click(function () {
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
        $('#add_newFeeType').click(function () {
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
                                    courseFeeType('courseFeeType', '');
                                    clearForm('addCourseFeeType_form');
                                    closeModal("addcourseFeeType");
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
            $('#addCourseFeeType_form').ajaxForm(options);
        });
    });
</script>