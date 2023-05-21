<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Subject Master
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Masters</a></li>
            <li class="active">Subject Master</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Subject Master</h3>
                    </div>
                    <?php echo form_open('Superadmin/addSubjectMaster', ["id" => "form_details", "name" => "form_details"]); ?>
                    <div class="box-body">
                        <input type="hidden" name="id" id="id" value="no_one">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 col-sm-12">
                                <div class="form-group">
                                    <label>Subject Name</label>
                                    <input type="text" name="subjectTitle" id="subjectTitleId" placeholder="Subject Name" class="form-control" data-validation="required">
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
                        <h3 class="box-title">Subject Master Details</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="data_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Subject Name</th>
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
                        data: {subjectId: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                        url: "<?php echo site_url('superadmin/delSubjectMaster'); ?>",
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
            var subjectId = $(this).attr('editid');
            $.ajax({
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', subjectId: subjectId},
                url: "<?php echo site_url('superadmin/getSubjectMaster'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].subjectId);
                    $('#subjectTitleId').val(json[0].subjectTitle);
                }
            });
        });
        $.ajax({
            type: "POST",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            url: "<?php echo site_url('superadmin/getSubjectMaster'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].subjectTitle,
                        '<a href="javascript:"   editid="' + json[i].subjectId + '" class="editAction"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteEnrty(\'' + json[i].subjectId + '\');" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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
    });
</script>

<script type="text/javascript">
    $(".subject_link").addClass("active");
    $(".admin_item").addClass("active");
    document.title = "iHuntBest | Subject Master";
</script>