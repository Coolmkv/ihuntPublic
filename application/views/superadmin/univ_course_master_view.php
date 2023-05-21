<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maindivContent">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            University Course Type
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Masters</a></li>
            <li class="active">University Course Type</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add University Course Type</h3>
                    </div>
                    <?php echo form_open('Superadmin/addCourseType', ["id" => "course_type_form", "name" => "course_type_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>University Course Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_course"
                                           id="save_course" value="Save">
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
                        <h3 class="box-title">University Course Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="course_type_table"
                                       class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course Type</th>
                                            <th>Add Course</th>
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
<!-- /.content-wrapper -->

<!-- Control Sidebar -->

<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    function deleteEnrty(id)
    {
        var ctId = id;
        var ihuntcsrfToken = $('input[name="ihuntcsrfToken"]').val();
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
                        data: {del: ctId, ihuntcsrfToken: ihuntcsrfToken},
                        url: "<?php echo site_url('superadmin/delCourseType'); ?>",
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
                                });
                            }
                        }
                    });
                }
            }
        });
    }
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on('click', '.editAction', function () {
            var ctId = $(this).attr('ctId');
            $.ajax({
                type: "POST",
                data: "ed=" + ctId,
                url: "<?php echo site_url('superadmin/getCourseType'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].ctId);
                    $('#title').val(json[0].courseType);
                }
            });
        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getCourseType'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#course_type_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].courseType,
                        '<a href="javascript:" class="addcourse" ctId="' + json[i].ctId + '" cname="' + json[i].courseType + '" title="Add Course"><i class="fa fa-plus"></i></a>',
                        '<a href="javascript:"   ctId="' + json[i].ctId + '" class="editAction"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteEnrty(\'' + json[i].ctId + '\');" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });
        $(document).on("click", ".addcourse", function () {
            var ctId = $(this).attr("ctId");
            var cname = $(this).attr("cname");
            var ihuntcsrfToken = $('input[name="ihuntcsrfToken"]').val();
            $.ajax({
                type: "POST",
                data: {ctId: ctId, cname: cname, ihuntcsrfToken: ihuntcsrfToken},
                url: "<?php echo site_url('superadmin/getcourse_details'); ?>",
                success: function (response) {
                    $("#maindivContent").html(response);
                }
            });
        });
        $('#save_course').click(function () {
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
                            typeAnimated: true,
                        });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#course_type_form').ajaxForm(options);
        });
    });
</script>

<script type="text/javascript">
    $(".universityCourse_link").addClass("active");
    $(".admin_item").addClass("active");
    document.title = "iHuntBest | University Course Type";
</script>