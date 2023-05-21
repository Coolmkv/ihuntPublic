<?php include_once 'university_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Achievement
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Achievement</a></li>
            <li class="active">Add Achievement</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Achievement</h3>
                    </div>
                    <?php echo form_open('university/addAchievement', ["id" => "achieve_form", "name" => "achieve_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <input type="hidden" name="previmage" id="previmage" value="no_image">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="image" id="image" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Award Name</label>
                                    <input type="text" name="awards" id="awards" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-2">
                                <label>Description</label>
                                <textarea class="form-control"  id="description" name="description"></textarea>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_achieve"
                                           id="save_achieve" value="Save">
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
                        <h3 class="box-title">Achievement Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="achieve_table"
                                       class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Image</th>
                                            <th>Award</th>
                                            <th>Description</th>
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
<?php include_once 'university_footer.php'; ?>
<script>
    $(".achievement_link").addClass("active");
    $(".addShowAchievement").addClass("active");
    document.title = "iHuntBest | Add-Show Achievement";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url('projectimages/images/achievement/image/'); ?>';
        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editAchievement", function () {
            var achiveId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "ed=" + achiveId,
                url: "<?php echo site_url('university/getAchievement'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].achiveId);
                    $('#awards').val(json[0].awards);
                    $('#description').val(json[0].description);
                    $('#previmage').val(json[0].image);
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
        $(document).on("click", ".delAchievement", function () {
            var achiveId = $(this).attr("del");
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
                            data: "del=" + achiveId,
                            url: "<?php echo site_url("university/delAchievement"); ?>",
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
                            },
                            error: function (jqXHR, exception) {
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
        });

        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('university/getAchievement'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#achieve_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].image === '') {
                        var image_url = '';
                    } else {
                        var image_url = base_url + json[i].image;
                    }
                    oTable.fnAddData([
                        (i + 1),
                        '<img src="' + image_url + '" class="img-responsive" style="height:60px;width:120px;">',
                        json[i].awards,
                        json[i].description,
                        '<a class="editAchievement" href="javascript:" ed="' + json[i].achiveId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="delAchievement" href="javascript:" del="' + json[i].achiveId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                    ]);
                }
            },
            error: function (jqXHR, exception) {
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

        $('#save_achieve').click(function () {
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
                error: function (jqXHR, exception) {
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
            $('#achieve_form').ajaxForm(options);
        });
    });
</script>