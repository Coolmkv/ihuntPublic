<?php include_once 'university_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Placed Students
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Placement</a></li>
            <li class="active">Add Placed Students</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Placed Student</h3>
                    </div>
                    <?php echo form_open_multipart('university/addPlacedStudent', ["id" => "placement_form", "name" => "placement_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <input type="hidden" name="previmage" id="previmage" value="">
                            <div class="col-md-4 col-md-12">
                                <div class="form-group">
                                    <label>Student Name</label>
                                    <input type="text" name="studentName" id="studentName" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4 col-md-12">
                                <div class="form-group">
                                    <label>Student Image</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="image" id="image" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 col-md-12">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" name="companyName" id="companyName" class="form-control"  data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4 col-md-12">
                                <div class="form-group">
                                    <label>Placement Date</label>
                                    <input type="date" name="placementDate" id="placementDate" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 col-md-12">
                                <div class="form-group">
                                    <label>Package Amount</label>
                                    <input type="text" name="package" id="package" class="form-control numOnly"  data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4 col-md-12">
                                <div class="form-group">
                                    <label>Course of Student</label>
                                    <select name="courseId" class="form-control" id="courseId" data-validation="required"></select>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-12">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select name="currency" id="currency" class="form-control" data-validation="required">
                                        <option value="">Select</option>
                                        <?php
                                        if (isset($currency)) {
                                            foreach ($currency as $cr) {
                                                echo '<option value="' . $cr->code . '" ' . ($defaultCurrency == $cr->code ? 'selected' : '') . '>' . $cr->name . '(' . $cr->code . ')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_placement"  id="save_placement" value="Save">
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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Placement Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="placement_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Student Name</th>
                                            <th>Student Image</th>
                                            <th>Company Name</th>
                                            <th>Course Details</th>
                                            <th>Placement Details</th>
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
<?php include_once 'university_footer.php'; ?>
<script>
    $(".placement_link").addClass("active");
    $(".add_showStudentPlacement_link").addClass("active");
    document.title = "iHuntBest | Add-Show Placed Students";
</script>
<script type="text/javascript">
    var coursedetails = [];
    function getCourses(position, value) {
        $.ajax({
            url: "<?php echo site_url('university/getCourses'); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Course</option>';
                for (var i = 0; i < json.length; i++) {
                    coursedetails[json[i].orgCourseId] = json[i].department + '(' + json[i].course + ', ' + json[i].timeduration + ')';
                    if (value === json[i].orgCourseId) {
                        data = data + '<option selected value="' + json[i].orgCourseId + '-' + json[i].courseId + '">' + json[i].department + '(' + json[i].course + ', ' + json[i].timeduration + ')</option>';
                    } else {
                        data = data + '<option value="' + json[i].orgCourseId + '">' + json[i].department + '(' + json[i].course + ', ' + json[i].timeduration + ')</option>';
                    }
                }
                $('#' + position).html(data);

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
        getCourses('courseId', '');
        var base_url = '<?php echo base_url(); ?>';
        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editPlacement", function () {
            var placedstudentId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "placedstudentId=" + placedstudentId,
                url: "<?php echo site_url('university/placedStudentRecords'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].placedstudentId);
                    $('#studentName').val(json[0].studentName);
                    $('#previmage').val(json[0].image);
                    $('#companyName').val(json[0].companyName);
                    $('#package').val(json[0].package);
                    $('#placementDate').val(json[0].placementDate);
                    $('#courseId').val(json[0].courseId);
                    $('#currency').val(json[0].currency);
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
        });
        $(document).on("click", ".delPlacement", function () {

            var placedstudentId = $(this).attr("del");
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
                            data: "placedstudentId=" + placedstudentId,
                            url: "<?php echo site_url("university/delPlacedStudent"); ?>",
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
                }
            });
        });

        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('university/placedStudentRecords'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#placement_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].image === '') {
                        var studentImage = '';
                    } else {
                        var studentImage = base_url + '/' + json[i].image;

                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].studentName,
                        '<img src="' + studentImage + '" onError="this.src=\'<?php echo base_url('projectimages/default.png'); ?>\'" class="img-responsive" style="height:60px;width:120px;">',
                        json[i].companyName,
                        coursedetails[json[i].courseId],
                        json[i].placementDetails,
                        '<a class="editPlacement" href="javascript:" ed="' + json[i].placedstudentId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                        <a class="delPlacement" href="javascript:" del="' + json[i].placedstudentId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
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

        $('#save_placement').click(function () {
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
            };
            $('#placement_form').ajaxForm(options);
        });
    });
</script>