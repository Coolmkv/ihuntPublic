<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Course Fee Type
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Masters</a></li>
            <li class="active">Course Fee Type</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Course Fee Type</h3>
                    </div>
                    <?php echo form_open('Superadmin/addCourseFeeType', ["id" => "form_details", "name" => "form_details"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Course Fee Type Title</label>
                                    <input type="text" name="FeeType_Name" id="FeeType_NameId" placeholder="Course Fee Type Title" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-2">
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
                        <h3 class="box-title">Course Fee Type</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="data_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course Fee Type Title</th>
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
                        data: {courseFeeType_Id: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                        url: "<?php echo site_url('superadmin/delcourseFeeType'); ?>",
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
            var courseFeeType_Id = $(this).attr('editid');
            $.ajax({
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', courseFeeType_Id: courseFeeType_Id},
                url: "<?php echo site_url('superadmin/getCourseFeeTypes'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].courseFeeType_Id);
                    $('#FeeType_NameId').val(json[0].FeeType_Name);
                }
            });
        });
        $.ajax({
            type: "POST",
            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            url: "<?php echo site_url('superadmin/getCourseFeeTypes'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].FeeType_Name,
                        '<a href="javascript:"   editid="' + json[i].courseFeeType_Id + '" class="editAction"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteEnrty(' + json[i].courseFeeType_Id + ');" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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
    $(".courseFeeType_link").addClass("active");
    $(".admin_item").addClass("active");
    document.title = "iHuntBest | Course Fee Type Master";
</script>