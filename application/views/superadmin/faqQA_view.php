<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add|Show FAQ Question Answers
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">FAQ</a></li>
            <li class="active">Add|Show FAQ Question Answers</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add FAQ Question Answers</h3>
                    </div>
                    <?php echo form_open("superadmin/addFaqQA", ["id" => "submit_form"]); ?>
                    <div class="box-body">
                        <input type="hidden" name="faqId" id="faqId" value="no_one" >
                        <div class="form-group col-md-4 col-sm-12">
                            <label>Category Name</label>
                            <select id="faqCategoryId" name="faqCategoryId" class="form-control" data-validation ="required"></select>
                        </div>
                        <div class="form-group col-md-8 col-sm-12">
                            <label>Question</label>
                            <input type="text" name="faqQuestion" id="faqQuestion" class="form-control" data-validation="required">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Answer</label>
                            <textarea name="faqAnswer" id="faqAnswer" class="form-control summernote" data-validation="required"></textarea>
                        </div>
                        <div class="  col-md-12 text-center">

                            <input style="margin-top:3px" type="submit" value="Save" class=" btn btn-primary" name="save_details" id="save_details">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">FAQ Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="showdata_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Category Name</th>
                                                <th>Question</th>
                                                <th>Answer</th>
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
        $('.summernote').summernote();
        $(document).on("click", ".editfunction", function () {
            var faqId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: {faqId: faqId},
                url: "<?php echo site_url('superadmin/getFaqQA'); ?>",
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result) {
                        $("#faqCategoryId").val(result[0].faqCategoryId);
                        $("#faqId").val(result[0].faqId);
                        $("#faqQuestion").val(result[0].faqQuestion);
                        $('#faqAnswer').summernote('code', result[0].faqAnswer);
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
            var faqId = $(this).attr("del");
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
                            data: {faqId: faqId},
                            url: "<?php echo site_url('superadmin/delFAQ'); ?>",
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
        getCategories('', 'faqCategoryId');
        function getCategories(selectedId, positionId) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('superadmin/getCategories'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].faqCategoryId + '">' + json[i].categoryName + '</option>';
                    }
                    $("#" + positionId).html(data);
                    $("#" + positionId).val(selectedId);
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
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getFaqQA'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].categoryName,
                        json[i].faqQuestion,
                        json[i].faqAnswer,
                        '<a href="javascript:" ed="' + json[i].faqId + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>\n\
&nbsp;&nbsp;&nbsp;&nbsp;<a class="delfunction" href="javascript:" del="' + json[i].faqId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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
    $(".faqlink").addClass("active");
    $(".faqQAlink").addClass("active");
    document.title = "iHuntBest | FAQ Question and Answers";
</script>