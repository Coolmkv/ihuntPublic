<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Minimum Qualification
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Masters</a></li>
                <li class="active">Minimum Qualification</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Minimum Qualification</h3>
                        </div>
                        <?php echo form_open('Superadmin/addMinQalification' ,["id"=>"minQualifiation_form","name"=>"minQualifiation_form"]);?>
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="no_one">
                                    <div class="col-md-6 col-md-offset-2">
                                        <div class="form-group">
                                            <label>Minimum Qualification</label>
                                            <input type="text" name="title" id="title" class="form-control" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="margin-top: 23px">
                                            <label></label>
                                            <input type="submit" class="btn btn-primary" name="save_qualification" id="save_qualification" value="Save">
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
                            <h3 class="box-title">Minimum Qualification Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="showdata_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Minimum Qualification</th>
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
        var ihuntcsrfToken  =   $('input[name="ihuntcsrfToken"]').val();  
        var ctId = id;
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
                        data: {del:ctId,ihuntcsrfToken:ihuntcsrfToken},
                        url: "<?php echo site_url('superadmin/delMinQalification');?>",
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
                data: "id=" + ctId,
                url: "<?php echo site_url('superadmin/getMinQalification');?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].courseMinQualId);
                    $('#title').val(json[0].title);
                }
            });
        });


       

        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getMinQalification');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].title,
                        '<a href="javascript:"   ctId="' + json[i].courseMinQualId + '" class="editAction"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteEnrty('+ json[i].courseMinQualId +');" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });

        $('#save_qualification').click(function () {
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
            $('#minQualifiation_form').ajaxForm(options);
        });
    });
</script>

<script type="text/javascript">
    $(".minQualification_link").addClass("active");
    $(".admin_item").addClass("active");
    document.title  =   "iHuntBest | Minimum Qualification";
</script>