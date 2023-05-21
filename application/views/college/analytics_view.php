<?php include_once 'college_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Analytics
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("college/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Analytics</a></li>
            <li class="active"> View Analytics</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">View Analytics</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-blue-gradient"><i class="fa fa-eye"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Page Views</span>
                                        <span class="info-box-number"><?php if (isset($visits)) {
    echo $visits->visitorCount;
} ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green-gradient"><i class="fa fa-bar-chart"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Admission took</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua-gradient"><i class="fa fa-bar-chart"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Admission in process</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.col -->
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row box-body hidden">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Department Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="department_table"
                                       class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Department Title</th>
                                            <th>Department Code</th>
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
<?php include_once 'college_footer.php'; ?>
<script>
    $(".analytics_link").addClass("active");
    $(".analytics").addClass("active");
    document.title = "iHuntBest | View Analytics";
</script>
<script type="text/javascript">
    $(document).ready(function () {

//
//        $.ajax({
//            type: "POST",
//            data: "",
//            url: "<?php echo site_url('University/showDepartments'); ?>",
//            success: function (response) {
//                var json = $.parseJSON(response);
//                var oTable = $('table#department_table').dataTable();
//                oTable.fnClearTable();
//                for (var i = 0; i < json.length; i++) {
//                    oTable.fnAddData([
//                        (i + 1),
//                        json[i].title,
//                        json[i].departmentCode,
//                        '<a href="javascript:" class="editDepartment" ed="' + json[i].departmentId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" del="' + json[i].departmentId + '" class="deleteDepartment" title="Delete"><i class="fa fa-trash-o"></i></i></a>',
//                    ]);
//                }
//            }
//        });
    });
</script>