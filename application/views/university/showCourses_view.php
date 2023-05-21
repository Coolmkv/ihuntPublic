<?php
include_once 'university_header.php';
$currency = (isset($_SESSION['dCurrency']) ? (!empty($_SESSION['dCurrency']) ? $_SESSION['dCurrency'] : "NA") : 'NA');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maindiv">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Course
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Course</a></li>
            <li class="active"> Show Course</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
            </div>
        </div>
        <!-- /.row -->
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Courses Details</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="courses_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course Type(Dep)Course</th>
                                            <th>Time Duration</th>
                                            <th>Application Details</th>
                                            <th>Stream Details</th>
                                            <th>Exam Details</th>
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
    $(".add_course_link").addClass("active");
    $(".show_course").addClass("active");
    document.title = "iHuntBest | Show Course";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        function isJson(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
        $.validate({
            lang: 'en'
        });
        $(document).on('click', '.editCourses', function () {
            var orgCourseId = $(this).attr('ed');
            $.ajax({
                type: "POST",
                data: "ed=" + orgCourseId,
                url: "<?php echo site_url('university/editCourse'); ?>",
                success: function (response) {

                    if (isJson(response)) {
                        var json = $.parseJSON(response);
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true});
                    } else {
                        $("#maindiv").html(response);
                    }
                }
            });
        });
        $(document).on('click', '.delCourse', function () {
            var orgCourseId = $(this).attr('del');
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
                            data: "del=" + orgCourseId,
                            url: "<?php echo site_url('university/deleteCourse'); ?>",
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
            url: "<?php echo site_url('university/getCourses') ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#courses_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    var sdetails = "";
                    if (json[i].streamDetails) {
                        var sdetailsar = json[i].streamDetails.split('^');
                        for (var ii = 0; ii < sdetailsar.length; ii++) {
                            var sitemsarr = sdetailsar[ii].split(',');
                            sdetails = (sitemsarr[0] !== "" ? "Stream :" + sitemsarr[0] : "");
                            sdetails = sdetails + (sitemsarr[1] !== "" ? "<br>Course Fee :" + sitemsarr[1] + ' <?php echo $currency; ?>' : "");
                            sdetails = sdetails + (sitemsarr[2] !== "" ? "<br>Seats(T/A) :" + sitemsarr[2] + '/' + sitemsarr[3] : "");
                            sdetails = sdetails + (sitemsarr[4] !== "" ? "<br>Fee Type :" + sitemsarr[4] : "");
                        }
                    } else {
                        sdetails = '<a href="<?php echo site_url("university/addStreams?cid="); ?>' + json[i].orgCourseId + '" target="_blank" class="btn btn-sm btn-primary">Add Stream</a>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].courseType + '(' + json[i].department + ')' + json[i].course,
                        json[i].timeduration,
                        'Application Starts :' + json[i].appOpening + '<br>Application Ends :' + json[i].appClosing + '<br>Application Fee :' + (json[i].applicationFee !== "0" ? json[i].applicationFee + ' <?php echo $currency; ?>' : ''),
                        sdetails,
                        'Exam Date :' + json[i].exmDate + '<br>Result Date :' + json[i].rdate + '<br>Exam Mode : ' + json[i].examMode + '<br>Exam Details : ' + json[i].examDetails,
                        '<a href="javascript:" class="editCourses" ed="' + json[i].orgCourseId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" class="delCourse" del="' + json[i].orgCourseId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });
    });
</script>