<?php include_once 'school_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Enrollments
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("school/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Enrollments</li>
            <li class="active">View Enrollments</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Enrollment Applications</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Course Details</th>
                                                <th>Course Duration</th>
                                                <th>Fee Details</th>
                                                <th>Important Dates</th>
                                                <th>Application Date</th>
                                                <th>Application Status</th>
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

<?php include_once 'school_footer.php'; ?>
<script>

    $(".myEnrollments").addClass("active");
    $(".myEnrollmentsview").addClass("active");
    document.title = "iHuntBest | Enrollments";

    $(document).ready(function () {
        $(document).on('change', '.statuschange', function () {
            var enrollmentId = $(this).attr('erId');
            var status = $(this).val();
            if (status === "") {
                return false;
            }
            var message = window.prompt("Message For Student");
            if (message === "") {
                $.alert({
                    title: 'Error!', content: "Message is required", type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            window.location.reload();
                        }
                    }
                });
            } else {
                $.ajax({
                    url: '<?php echo site_url('school/changeStatus'); ?>',
                    type: "POST",
                    data: {enrollmentId: enrollmentId, status: status, message: message},
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json.status === 'success') {
                            $.alert({title: 'Success!', content: json.msg, type: 'blue',
                                typeAnimated: true,
                                buttons: {
                                    Ok: function () {
                                        window.location.reload();
                                    }
                                }
                            });
                        } else {
                            $.alert({title: 'Error!', content: json.msg, type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    Ok: function () {
                                        window.location.reload();
                                    }
                                }
                            });
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
            }
        });
        $('#details_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('school/getEnrollApplications') ?>",
                "dataType": "json",
                "type": "POST"
            },
            "columns": [
                {"data": "enrollmentId"},
                {"data": "CourseDetails"},
                {"data": "CourseDuration"},
                {"data": "FeeDetails"},
                {"data": "ImportantDates"},
                {"data": "ApplicationDate"},
                {"data": "ApplicationStatus"}, {"data": "Action"}
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
