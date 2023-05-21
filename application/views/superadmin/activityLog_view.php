<?php include_once 'superadmin_header.php'; ?>
<style>
    .active a
    {color:#FFF !important;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Password
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Password</a></li>
            <li class="active">Change Password</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>Select One</label>
                                    <select class="form-control" name="user_type" id="user_type">
                                        <option value="AllUsers">AllUsers</option>
                                        <option value="Superadmin">Superadmin</option>
                                        <option value="University">University</option>
                                        <option value="College">College</option>
                                        <option value="Institute">Institute</option>
                                        <option value="School">School</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Select Start Date</label>
                                    <input type="date" class="form-control" name="datestart" id="datestart" data-validation="required" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label>Select End Date</label>
                                    <input type="date" class="form-control" name="dateend" id="dateend" data-validation="required" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label style="margin-top: 38px"></label>
                                    <input type="submit" class="btn btn-info" name="search_user" id="search_user" value="Search">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" id="">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Activities</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style='overflow:scroll;overflow-x:hidden;max-height:500px;'>
                            <div class="col-md-12" id="activity_log">
                                <table id="showdata_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">Sr.No.</th><th>Activity Details</th>
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
<?php include_once 'superadmin_footer.php'; ?>
<script>
    $(".activitylog").addClass("active");
    document.title = "iHuntBest | Activity Log";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("change", "#dateend", function () {
            $("#datestart").prop("max", $("#dateend").val());
        });
        $(document).on("change", "#datestart", function () {
            $("#dateend").prop("min", $("#datestart").val());
        });
        $.validate({
            lang: 'en'
        });
        dataTableShow("AllUsers", "", "");
        $('#search_user').click(function () {
            var usertype = $('#user_type').val();
            var dateStart = $('#datestart').val();
            var dateEnd = $('#dateend').val();
            dataTableShow(usertype, dateStart, dateEnd);
        });

    });
    function dataTableShow(usertype, dateStart, dateEnd) {

        $('#showdata_table').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": "<?php echo site_url('superadmin/getActivitylog') ?>",
                "dataType": "json",
                "type": "POST",
                "data": function (data) {
                    data.user_type = usertype;
                    data.datestart = dateStart;
                    data.dateend = dateEnd;
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                {"data": "serialNumber"},
                {"data": "avtivityDetails"}
            ]

        });
    }
</script>