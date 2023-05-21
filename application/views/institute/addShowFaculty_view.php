<?php include_once 'institute_header.php';
echo $map['js']; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Faculty
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('institute/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Faculty</a></li>
            <li class="active">Add Faculty</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Faculty</h3>
                    </div>
<?php echo form_open_multipart('institute/addFaculty', ["id" => "faculty_form", "name" => "faculty_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <input type="hidden" name="previmage" id="previmage" value="no_image">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Faculty Image</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="facultyImage" id="facultyImage" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Faculty Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Faculty Gender</label>
                                    <select class="form-control" name="gender" id="gender" data-validation="required">
                                        <option value="">Select Gender</option>
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Faculty Mobile</label>
                                    <input type="text" name="mobile" id="mobile" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Faculty Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Qualification</label>
                                    <input type="text" name="qualification" id="qualification" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Post</label>
                                    <input type="text" name="post" id="post" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Faculty Address</label>
                                    <input type="text" name="address" id="address" class="form-control">
                                </div>
                            </div>
                            <div class="hidden">
<?php echo $map['html']; ?>
                            </div>
                            <div class="col-md-4 col-sm-12 text-center">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_faculty"
                                           id="save_faculty" value="Save">
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
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Faculty Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="faculty_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Faculty Image</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Qualification</th>
                                            <th>Post</th>
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
<?php include_once 'institute_footer.php'; ?>
<script>
    $(".faculty_link").addClass("active");
    $(".addShowFaculty").addClass("active");
    document.title = "iHuntBest | Add-Show Faculty";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url('projectimages/images/facultyImage/image/'); ?>';
        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editFaculty", function () {
            var facultyId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "ed=" + facultyId,
                url: "<?php echo site_url('institute/getFaculty'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].facultyId);
                    $('#name').val(json[0].name);
                    $('#gender').val(json[0].gender);
                    $('#mobile').val(json[0].mobile);
                    $('#email').val(json[0].email);
                    $('#address').val(json[0].address);
                    $('#qualification').val(json[0].qualification);
                    $('#post').val(json[0].post);

                    $('#previmage').val(json[0].facultyImage);
                }
            });
        });
        $(document).on("click", ".delFaculty", function () {
            var facultyId = $(this).attr("del");
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
                            data: "del=" + facultyId,
                            url: "<?php echo site_url("institute/delFaculty"); ?>",
                            success: function (response) {
                                var json = $.parseJSON(response);
                                if (json.status === 'success') {
                                    $.alert({
                                        title: 'Success!', content: json.msg, type: 'blue',
                                        typeAnimated: true,
                                        buttons: {
                                            Ok: function () {
                                                window.location.reload();
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        title: 'Error!', content: json.msg, type: 'red',
                                        typeAnimated: true
                                    });
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
            url: "<?php echo site_url('institute/getFaculty'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#faculty_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].facultyImage === '') {
                        var image_url = '';
                    } else {
                        var image_url = base_url + json[i].facultyImage;
                    }
                    oTable.fnAddData([
                        (i + 1),
                        '<img src="' + image_url + '" onError="this.src=\'<?php echo base_url('projectimages/default.png'); ?>\'" class="img-responsive" style="height:60px;width:120px;">',
                        json[i].name,
                        json[i].gender,
                        json[i].mobile,
                        json[i].email,
                        json[i].address,
                        json[i].qualification,
                        json[i].post,
                        '<a class="editFaculty" href="javascript:" ed="' + json[i].facultyId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="delFaculty" href="javascript:" del="' + json[i].facultyId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });

        $('#save_faculty').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({
                            title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        $.alert({
                            title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true
                        });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#faculty_form').ajaxForm(options);
        });
    });
</script>