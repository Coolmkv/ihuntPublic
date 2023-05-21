<?php
include_once 'institute_header.php';

echo $map['js'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><div class="hidden"><?php echo $map['html']; ?></div>
        <h1>
            Concerned Person Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("institute/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Concerned Person Details</a></li>
            <li class="active"> Add | View Concerned Person Details</li>
        </ol>
    </section>                <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Concerned Person Details</h3>
                    </div>
                    <?php echo form_open('institute/addConcernedPersonDetails', ["name" => "concernedPersonDetails_form", "id" => "concernedPersonDetails_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="cp_Id" id="cp_Id" value="no_one">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="cp_name" id="cp_name" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="cp_email" id="cp_email" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="number" name="cp_contact" id="cp_contact" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Alt. Contact</label>
                                    <input type="number" name="cp_alt_contact" id="cp_alt_contact" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="cp_position" id="cp_position" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="cp_address" id="cp_address" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="form-group"  >
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_details"
                                           id="save_details" value="Save">
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
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Concerned Person Details</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tbl_data" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Alt. Contact</th>
                                            <th>Designation</th>
                                            <th>Address</th>
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
    <!-- /.content -->
</div>
<?php include_once 'institute_footer.php'; ?>
<script>
    $(".profile_link").addClass("active");
    $(".view_concerned_link").addClass("active");
    document.title = "iHuntBest | Concerned Person Details";
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editfunction", function () {
            var cp_Id = $(this).attr('cpId');
            $.ajax({
                type: "POST",
                data: {cp_Id: cp_Id},
                url: "<?php echo site_url('institute/getConcernedPersonDetails'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#cp_Id').val(json[0].cp_Id);
                    $("#cp_name").val(json[0].cp_name);
                    $('#gender').val(json[0].gender);
                    $("#cp_email").val(json[0].cp_email);
                    $("#cp_contact").val(json[0].cp_contact);
                    $("#cp_alt_contact").val(json[0].cp_alt_contact);
                    $("#cp_position").val(json[0].cp_position);
                    $("#cp_address").val(json[0].cp_address);
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

        });
        $(document).on("click", ".delfunction", function () {
            var cp_Id = $(this).attr('cpId');
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
                            data: {cp_Id: cp_Id, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                            url: "<?php echo site_url('institute/delConcernedPerson'); ?>",
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
                                        typeAnimated: true, buttons: {
                                            Ok: function () {
                                                window.location.reload();
                                            }
                                        }});
                                }
                            }
                        });
                    }
                }
            });
        });
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('institute/getConcernedPersonDetails'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#tbl_data').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].cp_name,
                        json[i].gender,
                        json[i].cp_email,
                        json[i].cp_contact,
                        json[i].cp_alt_contact,
                        json[i].cp_position,
                        json[i].cp_address,
                        '<a href="javascript:" cpId="' + json[i].cp_Id + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>\n\
                        &nbsp;&nbsp;&nbsp;&nbsp;<a class="delfunction" href="javascript:" cpId="' + json[i].cp_Id + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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
        $('#save_details').click(function () {
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
                            typeAnimated: true,
                        });
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
            };
            $('#concernedPersonDetails_form').ajaxForm(options);
        });
    });
</script>
