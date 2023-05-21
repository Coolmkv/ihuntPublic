<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                News Letter Plan Buy Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">News Letter Plan Buy Details</a></li>
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
                            <h3 class="box-title">News Letter Plan Buy  Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="data_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>User Details</th>
                                            <th>Buy Plan Details</th>
                                            <th>Buy Date</th>
                                            <th>Pay Status</th>
                                            <th>Status </th>
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
            url: "<?php echo site_url('superadmin/getnewsletterplanbuy');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) { 
                    if (json[i].isactive === '0') {
                        var isactive = '<span class="label label-danger">Disable</span>';
                    }
                    if (json[i].isactive === '1') {
                        var isactive = '<span class="label label-primary">Active</span>';
                    }
                    if(json[i].pay_status === '1'){
                        var pay_status = '<span class="label label-primary">Payment Successful</span>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].email+"<br>Role Name :"+json[i].roleName,
                        json[i].plan_name+"<br>No of Newsletter :"+
                        json[i].no_of_news_ltr+"<br>Price :"+
                        json[i].price+"<br>Currency :"+
                        json[i].currencies,
                        json[i].buyDate,
                        pay_status,
                        isactive
                    ]);
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(".nlpb_Show").addClass("active");
    $(".newsltr_plan_Link").addClass("active");
    document.title  =   "iHuntBest | News Letter Plan Buy Details";
</script>