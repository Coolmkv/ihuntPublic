<?php include_once 'college_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Testimonials
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("college/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Testimonials</a></li>
            <li class="active">Add Testimonials</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Testimonials</h3>
                    </div>
                    <?php echo form_open_multipart("college/editTestimonials", ["id" => "submit_form"]); ?>
                    <div class="box-body">
                        <input type="hidden" name="testimonialId" id="testimonialId" value="no_one" >
                        <input type="hidden" name="prevImage" id="prevImage" value="" >
                        <div class="form-group col-md-3">
                            <label>User Name</label>
                            <input type="text" name="userName" id="userName" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-3">
                            <label>User Image</label>
                            <input type="file" name="userImage" accept="image/x-png,image/gif,image/jpeg"  id="userImage" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-6">
                            <label>User Headlines</label>
                            <input type="text" name="userHeadline" id="userHeadline" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-12">
                            <label>User Text</label>
                            <textarea name="userText" id="userText" class="form-control summernote" data-validation ="required"></textarea>
                        </div>
                        <div class="  col-md-12 text-center">

                            <input style="margin-top:3px" type="submit" value="Save" class=" btn btn-primary" name="save_details" id="save_details">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Testimonials</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="showdata_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>UserImage</th>
                                            <th>UserName</th>
                                            <th>UserHeadline</th>
                                            <th>UserText</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->

<div class="control-sidebar-bg"></div>

<!-- ./wrapper -->
<?php include 'college_footer.php' ?>
<script type="text/javascript">

    $(document).ready(function () {
        $('.summernote').summernote({
            height: 200
        });

        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editfunction", function () {
            var testimonialId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: {testimonialId: testimonialId},
                url: "<?php echo site_url('college/getTestimonials'); ?>",
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result) {
                        $("#userName").val(result[0].userName);
                        $("#prevImage").val(result[0].userImage);
                        $("#userHeadline").val(result[0].userHeadline);
                        $('#userText').summernote('code', result[0].userText);
                        $("#userImage").attr("data-validation", "");
                        $("#testimonialId").val(result[0].testimonialId);
                    } else {
                        $.alert({
                            title: 'Error!', content: 'Details not found', type: 'red',
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
        });
        $(document).on('click', '.delfunction', function () {
            var testimonialId = $(this).attr("del");
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
                            data: {testimonialId: testimonialId, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                            url: "<?php echo site_url('college/delTestimonial'); ?>",
                            success: function (response) {
                                var result = $.parseJSON(response);
                                if (result.status === 'success') {
                                    $.alert({title: 'Success!', content: result.msg, type: 'blue',
                                        typeAnimated: true,
                                        buttons: {
                                            Ok: function () {
                                                window.location.reload();
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({title: 'Error!', content: result.msg, type: 'red',
                                        typeAnimated: true,
                                        buttons: {
                                            Ok: function () {
                                                window.location.reload();
                                            }
                                        }});
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
                }
            });

        });

        $.ajax({
            type: "POST",
            data: "testimonialId=all",
            url: "<?php echo site_url('college/getTestimonials'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        '<img src="../' + json[i].userImage + '" style="width:80px;">',
                        json[i].userName,
                        json[i].userHeadline,
                        json[i].userText,
                        '<a href="javascript:" ed="' + json[i].testimonialId + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>\n\
&nbsp;&nbsp;&nbsp;&nbsp;<a class="delfunction" href="javascript:" del="' + json[i].testimonialId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
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



    });
    $('#save_details').click(function () {
        $.validate({
            lang: 'en'
        });
        var options = {
            beforeSend: function () {
            },
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
        };
        $('#submit_form').ajaxForm(options);
    });
</script>

<script type="text/javascript">
    $(".testmo").addClass("active");
    $(".addTestimonials").addClass("active");
    document.title = "iHuntBest | Testimonials";
</script>