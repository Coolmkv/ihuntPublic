<?php include_once 'college_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Enquiries
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("college/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Enquiries</li>
            <li class="active">View Enquiries</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Enquiry Applications</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Course Details</th>
                                                <th>Sender Details</th>
                                                <th>Message</th>
                                                <th>Enquiry Date</th>
                                                <th>Enquiry Status</th>
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
        </div>

    </section>
    <!-- /.content -->
</div>

<?php include_once 'college_footer.php'; ?>
<script>

    $(".myEnrollments").addClass("active");
    $(".myEnquiriesview").addClass("active");
    document.title = "iHuntBest | Enquiries";

    $(document).ready(function () {

        $('#details_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('college/getenquiriesApplications') ?>",
                "dataType": "json",
                "type": "POST"
            },
            "columns": [
                {"data": "tcEnquiyId"},
                {"data": "CourseDetails"},
                {"data": "senderDetails"},
                {"data": "message"},
                {"data": "enquiryDate"},
                {"data": "enquiryStatus"},
                {"data": "action"}
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
