<?php include_once 'student_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<style>
    .divcontainer {
        width: auto;
        margin: 10px auto;
    }
    .progressbarenroll {
        counter-reset: step;
    }
    .progressbarenroll li {
        list-style-type: none;
        padding: 5px;
        float: left;
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }
    .progressbarenroll li.active:before {
        content:'\2714';
    }
    .progressbarenroll li:before {
        width: 20px;
        height: 20px;
        content: '\2716';
        line-height: 17px;
        border: 2px solid #7d7d7d;
        display: block;
        text-align: center;
        margin: 0 auto 10px auto;
        border-radius: 50%;
        background-color: #f9f9f9;
    }
    .progressbarenroll li:after {
        width: 71%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -37%;
        z-index: 0;
    }
    .progressbarenroll li:first-child:after {
        content: none;
    }
    .progressbarenroll li.active {
        color: green;
    }
    .progressbarenroll li.active:before {
        border-color: #55b776;
    }
    .progressbarenroll li.active + li:after {
        background-color: #55b776;
    }</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            My Applications
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student'); ?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">View Application</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">My Applications</h3>
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

<?php include_once 'student_footer.php'; ?>
<script>

    $(".myApplLink").addClass("active");
    document.title = "iHuntBest | My Applications";

    dataTable();
    function dataTable() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("Student/mgetMyApplication"); ?>",
            data: {},
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#details_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {

                    oTable.fnAddData([
                        (i + 1),
                        json[i].courseName + '(' + json[i].courseType + ') ' + json[i].departmentName,
                        json[i].timeDuration + ' ' + json[i].courseDurationType,
                        '<br> Reg Fee : ' + json[i].registrationFee + '<br> Course Fee : ' + json[i].courseFee,
                        'Application Opening : ' + (json[i].openingDate ? json[i].openingDate : "NA") +
                                '<br>Application Closing : ' + (json[i].closingDate ? json[i].closingDate : "NA")
                                + '<br>Exam Date: ' + (json[i].examDate ? json[i].examDate : "NA"),
                        json[i].applicationDate,
                        (json[i].status === "Enrolled" ? '<div class="divcontainer"><ul class="progressbarenroll"><li class="active">Enrolled</li><li >Accepted</li></ul></div>'
                                : '<div class="divcontainer"><ul class="progressbarenroll"><li class="active">Enrolled</li><li class="active">Accepted</li></ul></div>')
                    ]);
                }
            }, error: function (jqXHR, exception) {
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
    }


</script>
