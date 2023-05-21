<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Rejected Facility Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Facility</a></li>
                <li class="active">Rejected Facility Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Rejected Facility Details</h3>
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
                                            <th>Facility Status</th>
                                            <th>Rejection Date</th>
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
         
        $.ajax({
            type: "POST",
            data: {ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
            url: "<?php echo site_url('superadmin/getRejectedFacilities');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#requestFac_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].facility_status === '1') {
                        var facility_status = '<span class="label label-danger">Rejected</span>';
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
                        facility_status,
                        json[i].approvalDate
                    ]);
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(".treeviewrejectfacilities_link").addClass("active");
    $(".treeviewfacilities_link").addClass("active");
    document.title  =   "iHuntBest | Rejected Facility Details";
</script>