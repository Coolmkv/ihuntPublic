<?php include_once 'university_header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Transactions
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Transactions</li>
            <li class="active">View Transactions</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Transaction List</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
												<th>Payment id</th>
                                                <th>Enrollment id</th>
                                                <th>Student name</th>
                                                <th>Amount</th>
                                                <th>Date</th>
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
        </div>

    </section>
    <!-- /.content -->
	

<!-- Modal -->


</div>
		
					
           

<?php include_once 'university_footer.php'; ?>
<script>

    $(".myEnrollments").addClass("active");
    $(".myEnrollmentsview").addClass("active");
    document.title = "iHuntBest | Enrollments";

    $(document).ready(function () {
        $('#details_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('university/getorgtransactions') ?>",
                "dataType": "json",
                "type": "POST"
            },
            "columns": [
                {"data": "sno"},
				{"data": "PaymentId"},
                {"data": "EnrollmentId"},
                {"data": "StudentName"},
                {"data": "Amount"},
                {"data": "Date"}
            ], error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
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
