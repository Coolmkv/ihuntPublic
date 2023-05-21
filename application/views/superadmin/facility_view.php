<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Facilities
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Facilities</a></li>
                <li class="active">Add/Show</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Facilities</h3>
                        </div>
                        <?php echo form_open('superadmin/addNewfacility',["id"=>"facility_form","name"=>"facility_form"]);?>
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="no_one">
                                    <div class="col-md-6 col-md-offset-2">
                                        <div class="form-group">
                                            <label>Facility Title</label>
                                            <input type="text" name="title" id="title" class="form-control" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-2">
                                        <div class="form-group">
                                            <label>Facility Icon</label>
                                            <input class="form-control icp icp-auto" name="fac_icon" id="fac_icon" value="fa-support" type="text" />
<!--                                            <input type="file" name="facility_icon" id="facility_icon" class="form-control" data-validation="required">-->
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="margin-top: 23px">
                                            <label></label>
                                            <input type="submit" class="btn btn-primary" name="save_facility" id="save_facility" value="Save">
                                        </div>
                                    </div>
                                </div>
                            </div>
                       <?php form_close();?>
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
                            <h3 class="box-title">Facilities Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="facility_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Facilities</th>
                                            <th>Facilities Icon</th>
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
      $('.icp-auto').iconpicker();
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $('#save_facility').click(function () {
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
                            typeAnimated: true,buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                            });
                    }
                },error: function (response) {
                    $('#error').html(response);
                }
            };           
            $('#facility_form').ajaxForm(options);
        });
            
        
        $.ajax({
            
            type: "POST",
            data: {},
            url: "<?php echo site_url('superadmin/getFacilities');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#facility_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {

                    oTable.fnAddData([
                        (i + 1),
                        json[i].title,
                        '<i class="fa ' +  json[i].facility_icon + '"></i>',
                        '<a href="javascript:" facid="' + json[i].facilityId1 + '" class="editAction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" facid="' + json[i].facilityId1 + '" class="delAction"  title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });
        $(document).on('click', '.editAction', function () {
            var facId = $(this).attr('facid');
            $.ajax({
                type: "POST",
                data: "ed=" + facId,
                url: "<?php echo site_url('superadmin/getFacilities');?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].facilityId1);
                    $('#title').val(json[0].title);
                }
            });
        });
        $(document).on('click', '.delAction', function () {
            var facId = $(this).attr('facid');
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
                            data:{del:facId,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                            url: "<?php echo site_url('superadmin/deleteFacilities');?>",
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
                    error: function (data, errorThrown) {
                        alert(errorThrown);
                    }
                        });
                    }
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(".treeviewAddShow_link").addClass("active");
    $(".treeviewfacilities_link").addClass("active");
    document.title  =   "iHuntBest | Facilities";
</script>