<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Approved Facility Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Facility</a></li>
                <li class="active">Approved Facility Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Approved Facility Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="requestFac_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course Type</th>
                                            <th>Course</th>
                                            <th>Stream</th>
                                            <th>Course Status</th>
                                            <th>Approval Date</th>
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
    <div class="control-sidebar-bg"></div>
 
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
            url: "<?php echo site_url('superadmin/GetApprovedCourse');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#requestFac_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].requestStatus === '1') {
                        var requestStatus = '<span class="label label-danger">Pending</span>';
                    }
                    if (json[i].requestStatus === '2') {
                        var requestStatus = '<span class="label label-primary">Approved</span>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].courseType,
                        json[i].course,
                        json[i].stream,
                        requestStatus,
                        json[i].updatedAt
                    ]);
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(".treeviewReqCourses_link").addClass("active");
    $(".treeviewApprovuniversityCourse_link").addClass("active");
    document.title  =   "iHuntBest | Approved Facility Details";
</script>