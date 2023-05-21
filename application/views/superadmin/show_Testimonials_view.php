<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Show Testimonials
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Testimonials</a></li>
            <li class="active">Show Testimonials</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">

            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Show Testimonials</h3>
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
        </div>
    </section>

    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->

<div class="control-sidebar-bg"></div>

<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">

    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editfunction", function () {
            var testimonialId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: {testimonialId: testimonialId},
                url: "<?php echo site_url('superadmin/getTestimonials'); ?>",
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result) {
                        $("#faqCategoryId").val(result[0].faqCategoryId);
                        $("#categoryName").val(result[0].categoryName);

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
            var faqCategoryId = $(this).attr("del");
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
                            data: {faqCategoryId: faqCategoryId},
                            url: "<?php echo site_url('superadmin/delCategories'); ?>",
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
            url: "<?php echo site_url('superadmin/getTestimonials'); ?>",
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
    $(".showTestimonials").addClass("active");
    document.title = "iHuntBest | Testimonials";
</script>