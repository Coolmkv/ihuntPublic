<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Advertise With Us Messages
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Advertise With Us</a></li>
            <li class="active">Advertise With Us Messages</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Advertise With Us Messages</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="showdata_table" class="table table-bordered table-striped table-condensed table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Organization Name</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact No.</th>
                                            <th>Mobile No</th>
                                            <th>Comment</th>
                                            <th>Message Date</th>
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
            data: "",
            url: "<?php echo site_url('superadmin/getadvertiseWithUsDetails'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].organisation_name,
                        json[i].firstName + ' ' + json[i].lastName,
                        json[i].email,
                        json[i].phoneNo,
                        json[i].mobile,
                        json[i].comment,
                        json[i].messagedate

                    ]);
                }
            },
            error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
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

    $(".advertisewithus").addClass("active");
    document.title = "iHuntBest | Advertise With Us Messages";
</script>