<?php include_once 'superadmin_header.php'; ?>
<div class="content-wrapper">
    <div class="hidden"></div>
    <section class="content-header">
        <h1>
            Add | Show Blogs
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Super-Admin Dashboard</a></li>
            <li><a href="#">Blogs</a></li>
            <li class="active">Add | Show Blogs</li>
        </ol>
    </section>
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add | Show Blogs</h3>
                    </div>
                    <?php echo form_open_multipart("superadmin/insertBlogs", ["id" => "submit_form"]); ?>
                    <div class="box-body">
                        <input type="hidden" name="blogId" id="blogId" value="no_one" >
                        <input type="hidden" name="prevImage" id="prevImage" value="" >
                        <div class="form-group col-md-4 col-sm-12">
                            <label>Category Name</label>
                            <select name="blogcatId" id="blogcatId" class="form-control" data-validation ="required"></select>
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label>Blog Title</label>
                            <input type="text" name="blogTitle" id="blogTitle" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label>Blog Image</label>
                            <input type="file" name="blogImage" accept="image/x-png,image/gif,image/jpeg" id="blogImage" class="form-control" data-validation="required">
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                            <label>Blog Description</label>
                            <textarea name="blogDesp" id="blogDesp" class="form-control summernote"  data-validation ="required"></textarea>
                        </div>
                        <div class="col-md-12 text-center">
                            <input style="margin-top:3px" type="submit" value="Submit For Approval" class="btn btn-primary" name="save_details" id="save_details">
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
                            <h3 class="box-title">Team Members Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="data_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Blog Category</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Description</th>
                                                <th>Added By (Date)</th>
                                                <th>Status</th>
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
</div>
<div class="control-sidebar-bg"></div>
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    $(".addBlogs").addClass("active");
    $(".blogs").addClass("active");
    document.title = "iHuntBest | Add-Show Blogs";
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });

        $(document).on("change", ".blogstatus", function () {
            var status = $(this).val();
            var blogId = $(this).attr("blogId");
            $.confirm({
                title: 'Status Change!',
                content: "Are you sure to Change Status to " + (status === '0' ? "UnApprove" : (status === '1' ? "Approve" : (status === '2' ? "Reject" : ""))) + "?",
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    Cancel: function () {
                        window.location.reload();
                    },
                    Confirm: function () {
                        $.ajax({
                            type: "POST",
                            data: {status: status, blogId: blogId, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                            url: "<?php echo site_url('superadmin/changeBlogStatus'); ?>",
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
        $('.summernote').summernote();
        $('#save_details').click(function () {
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
            $('#submit_form').ajaxForm(options);
        });
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('Superadmin/getBlogCategories'); ?>",
            success: function (response) {

                var json = $.parseJSON(response);
                var data = '<option value="">Select</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].catId + '">' + json[i].catName + '</option>';
                }
                $("#blogcatId").html(data);
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
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('Superadmin/getBlogsDetails'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();

                for (var i = 0; i < json.length; i++) {
                    var blogstatus = '<select name="changeOption" class="form-control blogstatus" blogId="' + json[i].blogId + '"><option ' + (json[i].blogStatus === '0' ? 'selected' : '') + ' value="0">Unapproved</option>\n\
                        <option ' + (json[i].blogStatus === '1' ? 'selected' : '') + ' value="1">Approved</option>\n\
                        <option ' + (json[i].blogStatus === '2' ? 'selected' : '') + ' value="2">Rejected</option></select>';
                    oTable.fnAddData([
                        (i + 1),
                        json[i].catName,
                        json[i].blogTitle,
                        '<img src="<?php echo base_url(); ?>' + json[i].blogImage + '" style="width:80px;">',
                        json[i].blogDesp,
                        json[i].addedBy,
                        blogstatus,
                        '<a href="javascript:" ed="' + json[i].blogId + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>\n\
&nbsp;&nbsp;&nbsp;&nbsp;<a class="delfunction" href="javascript:" del="' + json[i].blogId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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
        $(document).on("click", ".editfunction", function () {
            var blogId = $(this).attr('ed');
            $.ajax({
                type: "POST",
                data: {blogId: blogId},
                url: "<?php echo site_url('Superadmin/getBlogsDetails'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#blogId').val(json[0].blogId);
                    $('#prevImage').val(json[0].blogImage);
                    $('#blogImage').attr("data-validation", "");
                    $("#blogcatId").val(json[0].blogcatId);
                    $("#blogTitle").val(json[0].blogTitle);
                    $('#blogDesp').summernote('code', json[0].blogDesp);
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
            var blogId = $(this).attr('del');
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
                            data: {blogId: blogId, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                            url: "<?php echo site_url('superadmin/delBlog'); ?>",
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
    });
</script>