<?php include_once 'institute_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pages
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('institute/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Pages</a></li>
            <li class="active">Add Pages</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Pages</h3>
                    </div>
                    <?php echo form_open('institute/addNewPages', ["id" => "pages_form", "name" => "pages_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Page Title</label>
                                    <input type="text" name="pageName" id="pageName" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea class="form-control summernote"  id="description" name="description"></textarea>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_page"
                                           id="save_page" value="Save">
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
                        <h3 class="box-title">Page Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="page_table"
                                       class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Page Title</th>
                                            <th>Date</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
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
    $(".pages_link").addClass("active");
    $(".add_pages_link").addClass("active");
    document.title = "iHuntBest | Add Pages";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $('.summernote').summernote();
        $(document).on('click', '.editPages', function () {
            var pageId = $(this).attr('ed');
            $.ajax({
                type: "POST",
                data: "ed=" + pageId,
                url: "<?php echo site_url('institute/showPages'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].pageId);
                    $('#pageName').val(json[0].pageName);
                    $('#description').val(json[0].description);
                    $('#description').summernote('code', json[0].description);
                }
            });
        });
        $(document).on('click', '.deletePages', function () {
            var pageId = $(this).attr('del');

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
                            data: "del=" + pageId,
                            url: "<?php echo site_url("institute/delPages"); ?>",
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
            url: "<?php echo site_url('institute/showPages'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#page_table').dataTable();
                var approvallink = '';
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].approvalStatus === '') {
                        approvallink = '&nbsp; <a href="javascript:" onclick="submitForApproval(\'' + json[i].pageId + '\',\'sendforapproval\');" class="btn btn-primary btn-sm">Submit For Approval</a>';
                    } else if (json[i].approvalStatus === 'approval_request') {
                        approvallink = '&nbsp; <a href="javascript:" onclick="submitForApproval(\'' + json[i].pageId + '\',\'cancelapproval\');" class="btn btn-danger btn-sm">Cancel Request</a>';
                    } else if (json[i].approvalStatus === 'askPayment') {
                        approvallink = '&nbsp; <button class="btn btn-success  btn-sm">Pay Amount : ' + json[i].paymentAmount + '</button>';
                    } else if (json[i].approvalStatus === 'approval_rejected') {
                        approvallink = '&nbsp; <button class="btn btn-danger btn-sm">Rejected</button>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].pageName,
                        json[i].date,
                        '<a href="javascript:" class="editPages editbtn" ed="' + json[i].pageId + '" title="Edit"><button class="btn btn-primary">view/edit page</button></i></a>',
                        '<a href="javascript:" del="' + json[i].pageId + '" class="deletePages" title="Delete"><i class="fa fa-trash-o"></i></i></a>\n\
                        ' + approvallink + ''
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

        $('#save_page').click(function () {
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
            $('#pages_form').ajaxForm(options);
        });
    });
    function submitForApproval(pageId, reqType) {
        if (reqType === "sendforapproval") {
            var textcontent = 'This may be chargable by admin ?';
        } else if (reqType === "cancelapproval") {
            var textcontent = 'Are you sure to cancel.';
        }
        $.confirm({
            title: 'Warning!',
            content: textcontent,
            type: 'red',
            typeAnimated: true,
            buttons: {
                Cancel: function () {
                    window.location.reload();
                },
                Confirm: function () {
                    $.ajax({
                        type: "POST",
                        data: {reqType: reqType, pageId: pageId},
                        url: "<?php echo site_url("institute/submitForApproval"); ?>",
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
            }
        });
    }
</script>