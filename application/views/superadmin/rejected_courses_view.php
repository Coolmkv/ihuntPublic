<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Rejected Advertisement Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Advertisement</a></li>
                <li class="active">Rejected Advertisement Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Rejected Advertisement Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="rejCourses_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course Type</th>
                                            <th>Course</th>
                                            <th>Stream</th>
                                            <th>Approved Course</th>
                                            <th>Course Status</th>
                                            <th>Rejection Date</th>
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

</div>
<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        }); 
            $(document).on("change",".requestStatus", function () {
            var streamId = $(this).attr("streamId");
            var cId = $(this).attr("cId");
            var ctId = $(this).attr("ctId");
            var requestStatus = $(this).val();
            $.ajax({
                type: "POST",
                data: {streamId:streamId,cId:cId,ctId:ctId,requestStatus:requestStatus},
                url: "<?php echo site_url('superadmin/changeRequestedCourseStatus');?>",
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
                    }
                });
        }); 
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getRejectedCoursedetails');?>",
                success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#rejCourses_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].requestStatus === '1') {
                        var requestStatus = '<span class="label label-danger">Pending</span>';
                    }
                    if (json[i].requestStatus === '2') {
                        var requestStatus = '<span class="label label-primary">Approved</span>';
                    }
                    if (json[i].requestStatus === '3') {
                        var requestStatus = '<span class="label label-danger">UnApproved</span>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].courseType,
                        json[i].course,
                        json[i].stream,
                        '<select class="requestStatus" streamId="' + json[i].streamId + '" cId="' + json[i].cId + '" ctId="' + json[i].ctId + '" style="background-color:#acd6e9;"><option value="">Choose One...</option><option value="1">Pending</option><option value="2">Approve</option><option value="3">Unapprove</option>' + json[i].requestStatus + '</select>',
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
    $(".rejected_courses_plan_link").addClass("active");
    document.title  =   "iHuntBest | Requested Courses Details";
</script>