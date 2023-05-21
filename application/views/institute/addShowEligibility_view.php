<?php include_once 'institute_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<style>
    .theadcolor{
        color: #3c8dbc!important;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Eligibility Criteria
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('institute/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Eligibility Criteria</a></li>
            <li class="active"> Add | Show Eligibility Criteria</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Eligibility Criteria</h3>
                    </div>
                    <?php echo form_open('institute/addEligibility', ["id" => "eligibility_form", "name" => "eligibility_form"]); ?>
                    <div class="box-body">
                        <center><u class="theadcolor"><h3>Course Details</h3></u></center>
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Type</label>
                                    <select name="courseTypeId" id="courseTypeId" class="form-control" data-validation="required"></select>
                                </div>
                            </div>
                            <hr style="width: 97%; color: black; height: 1px; background-color:black;">
                            <center><u class="theadcolor"><h3>Eligibility Criteria</h3></u></center>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Class</label>
                                    <select name="class" id="class" class="form-control" data-validation="required">
                                        <option value="">Select</option>
                                        <option value="11th">11th</option>
                                        <option value="12th">12th</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Class Type</label>
                                    <select name="classTypeId" id="classTypeId" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Percentage</label>
                                    <input type="number" name="percentage" max="100" id="percentage" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px;">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_eligibility" id="save_eligibility" value="Save">
                                </div>
                            </div>


                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <!--/.col -->
                </div>
            </div>
        </div>
        <!-- /.row -->
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
                                <table id="eligibility_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Course Type</th>
                                            <th>Class</th>
                                            <th>Class Type</th>
                                            <th>Percentage</th>
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
</div>
<?php include_once 'institute_footer.php'; ?>
<script>
    $(".elgibility_link").addClass("active");
    document.title = "iHuntBest | Add | Show Eligibility";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        getCourses();
        getClassType();
        $('#class').change(function () {
            getClassType('');
        });
        function getClassType(selclass) {

            var clas = $('#class').val();

            $.ajax({
                url: "<?php echo site_url('institute/getClassType'); ?>",
                type: 'POST',
                data: 'class=' + clas,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].classTypeId + '">' + json[i].title + '</option>';
                    }
                    $('#classTypeId').html(data);
                    $('#classTypeId').val(selclass);
                }
            });
        }
        $(document).on('click', '.editEligibility', function () {
            var minQualificationId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "ed=" + minQualificationId,
                url: "<?php echo site_url("institute/showEligibility") ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].minQualificationId);
                    $('#courseTypeId').val(json[0].insCourseDetailsId);
                    $('#class').val(json[0].class);
                    $('#classTypeId').val(json[0].classTypeId);
                    $('#percentage').val(json[0].percentage);
                    getClassType(json[0].classTypeId);
                }
            });
        });
        $(document).on('click', '.delEligibility', function () {
            var minQualificationId = $(this).attr("del");
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
                            data: "del=" + minQualificationId,
                            url: "<?php echo site_url('institute/delEligibility'); ?>",
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
                                        }});
                                }
                            },
                            error: function (error) {
                                $.alert({title: 'Error!', content: error, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    }});
                            }

                        });
                    }
                }
            });

        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url("institute/showEligibility") ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#eligibility_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].title,
                        json[i].classname,
                        json[i].classtitle,
                        json[i].percentage,
                        '<a href="javascript:" class="editEligibility" ed="' + json[i].minQualificationId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" del="' + json[i].minQualificationId + '" class="delEligibility" title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                    ]);
                }
            }
        });
        $('#save_eligibility').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
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
                            typeAnimated: true, });
                    }

                },
                error: function (error) {
                    $.alert({title: 'Error!', content: error, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                window.location.reload();
                            }
                        }});
                }
            };
            $('#eligibility_form').ajaxForm(options);
        });



        function getCourses() {
            $.ajax({
                url: "<?php echo site_url('institute/getCourseType'); ?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose Course Type</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].insCourseDetailsId + '">' + json[i].title + '</option>';
                    }
                    $('#courseTypeId').html(data);
                }
            });
        }
    });

</script>