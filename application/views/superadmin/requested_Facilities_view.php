<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Requested Facility Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Facility</a></li>
                <li class="active">Requested Facility Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Requested Facility Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="requestFac_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Organization Name</th>
                                            <th>Organization Mobile</th>
                                            <th>Facility Name</th>
                                            <th>Facility Icon</th>
                                            <th>Approved Facility</th>
                                            <th>Facility Status</th>

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
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on("change", ".facility_status", function () {
            var id = $(this).attr("id");
            var facility_status = $(this).val();
            $.ajax({
                type: "POST",
                data: {id:id,facility_status:facility_status,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                url: "<?php echo site_url('superadmin/changeRequestedFacilitesStatus');?>",
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
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                            }
                                    }
                                });
                            }
                    }
                });
        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getRequestedFacilites');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#requestFac_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].facility_status === '1') {
                        var facility_status = '<span class="label label-danger">Pending</span>';
                    }
                    if (json[i].facility_status === '2') {
                        var facility_status = '<span class="label label-primary">Approved</span>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].orgName,
                        json[i].orgMobile,
                        json[i].facility,
                        '<i class="fa ' +  json[i].facility_icon + '"></i>',
                        '<select class="facility_status" id="' + json[i].facilityId + '"style="background-color:#acd6e9;"><option value="">Choose One...</option><option value="2">Approve</option><option value="1">Unapprove</option>' + json[i].facility_status + '</select>',
                        facility_status,
                    ]);
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(".treeviewReqfacilities_link").addClass("active");
    $(".treeviewfacilities_link").addClass("active");
    document.title  =   "iHuntBest | Requested Facility Details";
</script>