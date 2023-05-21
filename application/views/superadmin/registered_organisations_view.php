<?php include_once 'superadmin_header.php'; ?>
<script src="<?php echo base_url(); ?>js/tinymce/js/tinymce/tinymce.js"></script>
    <script>
        tinymce.init({
            selector: ".ckeditor",
            plugins: [
                "advlist lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste ",
            ],
            browser_spellcheck: true,
            contextmenu: false,
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  | preview ",
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                tinymce.activeEditor.windowManager.open({
                    title: "File Browser",
                    url: 'ckeditor/myfilebrowser.html',
                    width: 480,
                    height: 240
                }, {
                    oninsert: function (url) {
                        win.document.getElementById(field_name).value = url;
                        tinymce.activeEditor.windowManager.close();
                    }
                });

            }
        });
    </script>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Organization Register
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Registration of Organization</a></li>
                <li class="active">Organization Register</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Registration Contents</h3>
                        </div>
                         
                            <?php echo form_open("superadmin/setOrgRegistrationContent", ["id"=>"reg_form","name"=>"reg_form"]);?>
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="no_one">
                                    <div class="col-md-6 col-md-offset-2">
                                        <div class="form-group">
                                            <label>Main Heading</label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                   data-validation="required">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Before Begin Content</label>
                                        <textarea class="form-control ckeditor"  id="beforeBegin" name="beforeBegin"></textarea>

                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Proceed Content</label>
                                        <textarea class="form-control ckeditor"  id="proceedContent" name="proceedContent"></textarea>

                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="margin-top: 23px">
                                            <label></label>
                                            <input type="submit" class="btn btn-primary" name="save_reg"
                                                   id="save_reg" value="Save">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php form_close(); ?>
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
                            <h3 class="box-title">Registration Contents Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="reg_table"
                                           class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Main Heading</th>
                                            <th>Date & Time</th>
                                            <th>View/Edit</th>
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
    <!-- /.content-wrapper -->
    
    <!-- Control Sidebar -->

<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on("click",".editEntry",function(){
            var orgRegCId =   $(this).attr('ed');
                $.ajax({
                type: "POST",
                data: "ed=" + orgRegCId,
                url: "<?php echo site_url("superadmin/getRegisteredOrg");?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].orgRegCId);
                    $('#title').val(json[0].title);
                    $('#beforeBegin').val(json[0].beforeBegin);
                    $('#proceedContent').val(json[0].proceedContent);
                     var ed = tinyMCE.get('beforeBegin');
                    ed.setProgressState(1); // Show progress
                    window.setTimeout(function() {
                        ed.setProgressState(0); // Hide progress
                        ed.setContent(json[0].beforeBegin);
                    }, 1000);
                    var ed1 = tinyMCE.get('proceedContent');
                    ed1.setProgressState(1); // Show progress
                    window.setTimeout(function() {
                        ed1.setProgressState(0); // Hide progress
                        ed1.setContent(json[0].proceedContent);
                    }, 1000);
                }
            });
        });
        $(document).on("click",".delEntry",function(){
        var orgRegCId =   $(this).attr('del');
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
                        data: "del=" + orgRegCId,
                        url: "<?php echo site_url('superadmin/delOrgRegistraion');?>",
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
                                    typeAnimated: true,buttons: {
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    }
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
            url: "<?php echo site_url("superadmin/getRegisteredOrg");?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#reg_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].title,
                        json[i].createdAt,
                        '<a href="javascript:" class="editEntry" ed="' + json[i].orgRegCId + '" title="Edit"><button class="btn btn-primary">View/Edit page</button></i></a>',
                        '<a href="javascript:" class="delEntry" del="' + json[i].orgRegCId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                    ]);
                }
            }
        });

        $('#save_reg').click(function () {
        var ed = tinyMCE.get('beforeBegin');
        $('#beforeBegin').val(ed.getContent());
        var ed1 = tinyMCE.get('proceedContent');
        $('#proceedContent').val(ed1.getContent());
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
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#reg_form').ajaxForm(options);
        });
    });
</script>

<script type="text/javascript">
    $(".treeviewASRAO_link").addClass("active");
    $(".treeviewRAO_link").addClass("active");
    document.title  =   "iHuntBest | Organization Register";
</script>