<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Exam Mode Master
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Masters</a></li>
            <li class="active">Exam Mode Master</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Exam Mode Master</h3>
                    </div>
                    <?php echo form_open('Superadmin/addExamModeMaster', ["id" => "form_details", "name" => "form_details"]); ?>
                    <div class="box-body">
                        <input type="hidden" name="id" id="id" value="no_one">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 col-sm-12">
                                <div class="form-group">
                                    <label>Mode Name</label>
                                    <input type="text" name="title" id="titleId" placeholder="Mode Name" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 text-center">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_time" id="save_time" value="Save">
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
                        <h3 class="box-title">Exam Mode Master Details</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="data_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Mode Name</th>
                                            <th>Approval Status</th>
                                            <th>Added By</th>
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
    $(document).on('change', '.changeStatus', function () {
        var emid = $(this).attr('emid');
        var status = $(this).val();
        if (status === "") {
            alert("Status is empty.");
            return false;
        }
        $.ajax({
            type: "POST",
            data: {status: status, emid: emid, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            url: "<?php echo site_url('superadmin/changeExamModeStatus'); ?>",
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
        })
    });
    function deleteEnrty(id)
    {
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
                        data: {exam_mode_id: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                        url: "<?php echo site_url('superadmin/delExamModeMaster'); ?>",
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
            var exam_mode_id = $(this).attr('editid');
            $.ajax({
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', exam_mode_id: exam_mode_id},
                url: "<?php echo site_url('superadmin/getExamModeMaster'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].exam_mode_id);
                    $('#titleId').val(json[0].title);
                }
            });
        });
        $.ajax({
            type: "POST",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            url: "<?php echo site_url('superadmin/getExamModeMaster'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                var statuschange = '';
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    statuschange = '<select class="changeStatus" emid="' + json[i].exam_mode_id + '" ><option value="">Select</option>\n\
        <option value="Approve" >Approve</option><option value="unapprove">Un Approve</option></select>';
                    oTable.fnAddData([
                        (i + 1),
                        json[i].title,
                        (json[i].approved === "0" ? '<span class="label label-warning">Request</span>' : (json[i].approved === "1" ? '<span class="label label-primary">Approved</span>' : '<span class="label label-danger">Not Approved</span>')),
                        (json[i].orgName === null ? 'Admin' : json[i].orgName),
                        '<a href="javascript:"   editid="' + json[i].exam_mode_id + '" class="editAction"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
            <a href="#" onclick="deleteEnrty(\'' + json[i].exam_mode_id + '\');" title="Delete"><i class="fa fa-trash-o"></i></i></a> ' + statuschange
                    ]);
                }
            }
        });
        $('#save_time').click(function () {
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
                            buttons: {
                                Ok: function () {

                                }
                            }
                        });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#form_details').ajaxForm(options);
        });
    });</script>

<script type="text/javascript">
    $(".examModeMaster_link").addClass("active");
    $(".admin_item").addClass("active");
    document.title = "iHuntBest | Exam Mode Master";
</script>