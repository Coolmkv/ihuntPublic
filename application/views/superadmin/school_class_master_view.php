<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            School Class
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Masters</a></li>
            <li class="active">School Class</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add School Class Name</h3>
                    </div>
                    <?php echo form_open('Superadmin/addSchoolClassName', ["id" => "class_name_form", "name" => "class_name_form"]); ?>

                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Class Name</label>
                                    <input type="text" placeholder="Class Name" name="cname" id="cname" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_class"
                                           id="save_class" value="Save">
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
                        <h3 class="box-title">School Class Type Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="showdata_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Class Title</th>
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
        var ihuntcsrfToken = $('input[name="ihuntcsrfToken"]').val();
        var classnamesId = id;
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
                        data: {del: classnamesId, ihuntcsrfToken: ihuntcsrfToken},
                        url: "<?php echo site_url('superadmin/delSchoolClass'); ?>",
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
            var classnamesId = $(this).attr('classnamesId');
            $.ajax({
                type: "POST",
                data: "id=" + classnamesId,
                url: "<?php echo site_url('home/getClassNames'); ?>",
                success: function (response) {
                    if (response !== "") {
                        var json = $.parseJSON(response);
                        $('#id').val(json.classnamesId);
                        $('#cname').val(json.classTitle);
                    } else {
                        alert("No details found.");
                    }
                }
            });
        });




        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('home/getClassNames'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].classTitle,
                        '<a href="javascript:"   classnamesId="' + json[i].classnamesId + '" class="editAction"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteEnrty(' + json[i].classnamesId + ');" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });

        $(document).on('click', '#save_class', function () {
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
            $('#class_name_form').ajaxForm(options);
        });
    });
</script>

<script type="text/javascript">
    $(".schoolClassType_link").addClass("active");
    $(".admin_item").addClass("active");
    document.title = "iHuntBest | School Class Type";
</script>