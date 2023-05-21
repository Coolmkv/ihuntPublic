<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Website Visitor Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Website Visitor Details</a></li>
            <li class="active">Show Website Visitor Details</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Website Visitor Details</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="webvisitor" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Visitor Id</th>
                                            <th>Country Name</th>
                                            <th>Total Visits</th>
                                            <th>IpAddress</th>
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
        $('#webvisitor').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('superadmin/getWebvistor') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            "columns": [
                {"data": "visitorId"},
                {"data": "countryName"},
                {"data": "totalVisits"},
                {"data": "ipaddress"}
            ]

        });
    });
</script>

<script type="text/javascript">
    $(".webvisShow").addClass("active");
    $(".totalvisLink").addClass("active");
    document.title = "iHuntBest | Website Visitor Details";
</script>