<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Earn and Share Value
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Earn and Share Value</a></li>
                <li class="active">Show</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Earn and Share Value Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="ens_value_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>Student Id</th>
                                            <th>Student Details</th>   
                                            <th>Total Amount</th>
                                            <th>Status</th>
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
            url: "<?php echo site_url('superadmin/getearnandsharevalue');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#ens_value_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].isactive === '0') {
                        var isactive = '<span class="label label-danger">Disable</span>';
                    }
                    if (json[i].isactive === '1') {
                        var isactive = '<span class="label label-primary">Active</span>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].studentName+"<br>"+
                        json[i].email+"<br>Refer Code : "+
                        json[i].my_refer_code+"<br>Student Referer : "+
                        json[i].my_referer+"<br>IpAddress : "+
                        json[i].ipAddress,
                        json[i].ensamount,
                        isactive
                    ]);
                }
            }, error: function(jqXHR, exception){                   
                                $.alert({
                                        title: 'Error!', content: jqXHR["status"]+" - "+ exception, type: 'red',
                                        typeAnimated: true,
                                        buttons: {
                                            Ok: function () {
                                                window.location.reload();
                                            }
                                        }
                                });
                                }
        });
    });
</script>
<script type="text/javascript">
    $(".ensvalLinkShow").addClass("active");
    $(".ensLink").addClass("active");
    document.title  =   "iHuntBest | Earn and Share Value Details";
</script>