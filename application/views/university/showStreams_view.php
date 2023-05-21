<?php include_once 'university_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maindiv">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Streams
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Streams Details</a></li>
            <li class="active"> Show Streams</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Streams Details</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="stream_table" class="table table-bordered table-striped table-responsive table-condensed">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course Type</th>
                                            <th>Course</th>
                                            <th>Stream</th>
                                            <th>Duration</th>
                                            <th>SEO Keywords</th>
                                            <th>Total/Available Seats</th>
                                            <th>Fee Details</th>
                                            <th>Show Desc.</th>
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
<?php include_once 'university_footer.php'; ?>
<script>
    $(".streamDetails_link").addClass("active");
    $(".showstream_link").addClass("active");
    document.title = "iHuntBest | Show Streams";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on('click', '.delOrgstreams', function () {
            var orgStreamId = $(this).attr('del');
            $.confirm({
                title: 'Warning!',
                content: "Are you sure to delete?",
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Cancel: function () {
                        window.location.reload();
                    },
                    Confirm: function () {
                        $.ajax({
                            type: "POST",
                            data: "del=" + orgStreamId,
                            url: "<?php echo site_url('university/delStreams') ?>",
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
                                        typeAnimated: true});
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
            url: "<?php echo site_url('university/viewStreams') ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#stream_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].courseType,
                        json[i].course,
                        json[i].stream,
                        json[i].timeduration,
                        json[i].seoKeywords,
                        json[i].totalSheet + '/' + json[i].availableSheet,
                        json[i].feeDetails,
                        '<a href="addStreams?orgStreamId=' + json[i].orgStreamId + '&desp=desp"><button  type="button" class="btn btn-sm btn-primary desp">Show Description</button></a>',
                        '<a href="addStreams?orgStreamId=' + json[i].orgStreamId + '"><i class="fa fa-edit editAction"></i></a>\n\
                        <a href="javascript:" class="delOrgstreams" del="' + json[i].orgStreamId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });
    });
</script>