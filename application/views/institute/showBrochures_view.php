<?php include_once 'institute_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Brochures
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('institute/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Brochures</a></li>
            <li class="active"> Add Brochures</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Brochures</h3>
                    </div>
                    <?php echo form_open('institute/addBrochures', ["name" => "brouchers_form", "id" => "brouchers_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Brochures Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Brochures Image</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="image" id="image" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_brouchers"
                                           id="save_brouchers" value="Save">
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
                        <h3 class="box-title">Brochures Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="brouchers_table"
                                       class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Brochures Title</th>
                                            <th>Brochures Image</th>
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
    $(".brochures_link").addClass("active");
    $(".addshowBrouchers").addClass("active");
    document.title = "iHuntBest | Add Brochures";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url(); ?>';

        $.validate({
            lang: 'en'
        });
<?php if (isset($_GET['ed'])) { ?>
            var broucherId = '<?php echo $_GET['ed']; ?>';
            $.ajax({
                type: "POST",
                data: "ed=" + broucherId,
                url: "<?php echo site_url('institute/brochuresTable'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].broucherId);
                    $('#title').val(json[0].title);
                }
            });
<?php } ?>



<?php if (isset($_GET['del'])) { ?>
            var broucherId = '<?php echo $_GET['del']; ?>';
            $.confirm({
                title: 'Warning!',
                content: "Are you sure to delete?",
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Cancel: function () {
                        window.location.href = 'addBrouchers';
                    },
                    Confirm: function () {
                        $.ajax({
                            type: "POST",
                            data: "del=" + broucherId,
                            url: "<?php echo site_url('institute/delBrochures'); ?>",
                            success: function (response) {
                                var json = $.parseJSON(response);
                                if (json.status === 'success') {
                                    $.alert({
                                        title: 'Success!', content: json.msg, type: 'blue',
                                        typeAnimated: true,
                                        buttons: {
                                            Ok: function () {
                                                window.location.href = 'showBrochure';
                                                ;
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        title: 'Error!', content: json.msg, type: 'red',
                                        typeAnimated: true,
                                    });
                                }
                            }
                        });
                    }
                }
            });

<?php } ?>

        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('institute/brochuresTable'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#brouchers_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].image === '') {
                        var image_url = '';
                    } else {
                        var image_url = base_url + json[i].image;
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].title,
                        '<img src="' + image_url + '" onError="this.src=\'' + base_url + 'projectimages/default.png\'" class="img-responsive" style="height:60px;width:120px;">',
                        '<a href="showBrochure?ed=' + json[i].broucherId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="showBrochure?del=' + json[i].broucherId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                    ]);
                }
            }
        });

        $('#save_brouchers').click(function () {
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
                                    window.location.href = 'showBrochure';
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
            $('#brouchers_form').ajaxForm(options);
        });
    });
</script>