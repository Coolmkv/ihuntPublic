<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Student Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Student Details</a></li>
                <li class="active">Show Student Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Student Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="data_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Student Name</th>
                                            <th>Student Mobile</th>
                                            <th>Student Email</th>
                                            <th>Gender</th>
                                            <th>D.O.B.</th>
                                            <th>Student Address</th>
<!--                                            <th>Login Status</th>-->
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
            data: {},
            url: "<?php echo site_url('superadmin/getStudentDetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) { 
                    oTable.fnAddData([
                        (i + 1),
                        json[i].studentName,
                        json[i].studentMobile,
                        json[i].email,
                        json[i].gender,
                        json[i].dob,
                        json[i].location 
                    ]);
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(".treeviewSSD_link").addClass("active");
    $(".treeviewStudentDetails_link").addClass("active");
    document.title  =   "iHuntBest | Student Details";
</script>