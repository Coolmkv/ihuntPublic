<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add|Show Help Menu
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Help Menu</a></li>
            <li class="active">Add|Show Help Menu</li>
        </ol>
    </section>
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-user m-r-5"></i> Add Category</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <?php echo form_open('superadmin/addhelpcategory', ["name" => "addCategory_form", "id" => "addCategory_form"]); ?>
                            <input type="hidden" name="id" id="helptextId" value="no_one">
                            <fieldset>
                                <!-- Text input-->
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Category:</label>
                                    <input type="text" placeholder="Category" id="categoryName" name="categoryName" data-validation="required" class="form-control">
                                </div>
                                <div class="col-md-12 form-group user-form-group">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary" id="addCategory">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Main content sub category -->
    <div class="modal fade" id="addSubCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-user m-r-5"></i> Add Sub Category</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <?php echo form_open('superadmin/addhelpsubcategory', ["name" => "addSubCategory_form", "id" => "addSubCategory_form"]); ?>
                            <input type="hidden" name="id" id="id" value="no_one">
                            <fieldset>
                                <!-- Text input-->
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Category:</label>
                                    <select id="mcategoryId" name="categoryId" class="form-control" data-validation ="required"></select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Sub Category:</label>
                                    <input type="text" placeholder="Sub Category" id="subcategoryName" name="subcategoryName" data-validation="required" class="form-control">
                                </div>
                                <div class="col-md-12 form-group user-form-group">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary" id="addsubCategory">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Help Menu</h3>
                    </div>
                    <?php echo form_open("superadmin/addHelpMenu", ["id" => "submit_form"]); ?>
                    <div class="box-body">
                        <input type="hidden" name="helptextId" id="helptextsId" value="no_one" >
                        <div class="form-group col-md-6 col-sm-12">
                            <label>Category Name</label>
                            <select id="categoryId" name="categoryId" class="form-control" data-validation ="required"></select>
                            <span class="help-block">
                                <a href="#" data-toggle="modal" data-target="#addCategoryModal">
                                    Add Category Name? Click Here <i class="fa fa-plus"></i>
                                </a>
                            </span>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label>Sub Category Name</label>
                            <select id="subcategoryId" name="subcategoryId" class="form-control" data-validation ="required"></select>
                            <span class="help-block">
                                <a href="#" data-toggle="modal" data-target="#addSubCategoryModal">
                                    Add Sub Category Name? Click Here <i class="fa fa-plus"></i>
                                </a>
                            </span>
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                            <label>Question</label>
                            <input type="text" name="heading" id="heading" class="form-control" data-validation="required">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Answer</label>
                            <textarea name="helpContent" id="helpContent" class="form-control summernote" data-validation="required"></textarea>
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
                            <h3 class="box-title">Student Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="showdata_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Category-Sub Category Name</th>
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
        $('#showdata_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('superadmin/getHelpMenu') ?>",
                "dataType": "json",
                "type": "POST"
            },
            "columns": [
                {"data": "serialNumber"},
                {"data": "CategoryName"},
                {"data": "heading"},
                {"data": "helpContent"},
                {"data": "actionbtns"}
            ]

        });
        $('.summernote').summernote();
        $(document).on("change", "#categoryId", function () {
            var categoryId = $(this).val();
            if (categoryId !== "") {
                getCategories('subcategoryId', categoryId);
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
    $('#addCategory').click(function () {
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
                        typeAnimated: true});
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
        $('#addCategory_form').ajaxForm(options);
    });
    $('#addsubCategory').click(function () {
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
                        typeAnimated: true});
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
        $('#addSubCategory_form').ajaxForm(options);
    });
    getCategories('categoryId, #mcategoryId', '0', '');
    function getCategories(positionId, parentId, helpId, selId) {
        $.ajax({
            type: "POST",
            data: {parentId: parentId, helpId: helpId},
            url: "<?php echo site_url('superadmin/getHelpCategories'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Select</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].helpId + '">' + json[i].categoryName + '</option>';
                }
                $("#" + positionId).html(data);
                $("#" + positionId).val(selId);

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
    function editfunction(helptextId) {

        $.ajax({
            type: "POST",
            data: {helptextId: helptextId},
            url: "<?php echo site_url('superadmin/getHelpMenu'); ?>",
            success: function (response) {
                var result = $.parseJSON(response);
                if (result) {
                    $("#helptextsId").val(result.helptextId);
                    $("#categoryId").val(result.categoryId);
                    $("#subcategoryId").val(result.subcategoryId);
                    getCategories('subcategoryId', result.categoryId, result.subcategoryId, result.subcategoryId);
                    $("#heading").val(result.heading);
                    $('#helpContent').summernote('code', result.helpContent);
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
    }
    function deletefunction(helptextId) {
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
                        data: {helptextId: helptextId, delete: "delete"},
                        url: "<?php echo site_url('superadmin/getHelpMenu'); ?>",
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

    }
</script>

<script type="text/javascript">
    $(".helpMenu").addClass("active");
    $(".helpmenulink").addClass("active");
    document.title = "iHuntBest | FAQ Question and Answers";
</script>