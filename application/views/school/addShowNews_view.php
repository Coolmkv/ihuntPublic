<?php include_once 'school_header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            News
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('school/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">News</a></li>
            <li class="active">Add News</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add News</h3>
                    </div>
                    <?php echo form_open('school/addNews', ["id" => "news_form", "name" => "news_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <input type="hidden" name="previmage" id="previmage" value="no_image">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>News Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>News Image</label>
                                    <input type="file" name="newsImage" id="newsImage" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Publish Date</label>
                                    <input type="date" name="publishDate" id="publishDate" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-12 ">
                                <label>Description</label>
                                <textarea class="form-control summernote"  id="description" name="description"><?php if (isset($_GET['orgStreamId'])) {
                        echo $description;
                    } ?></textarea>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_news"
                                           id="save_news" value="Save">
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
                        <h3 class="box-title">News Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="news_table"
                                       class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>News Title</th>
                                            <th>News Image</th>
                                            <th>Publish Date</th>
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
<?php include_once 'school_footer.php'; ?>
<script>
    $(".news_link").addClass("active");
    $(".add_show_news").addClass("active");
    document.title = "iHuntBest | Add-Show News";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url('projectimages/images/news/image/'); ?>';
        $('.summernote').summernote();
        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editNews", function () {
            var newsId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "ed=" + newsId,
                url: "<?php echo site_url('school/getNews'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].newsId);
                    $('#title').val(json[0].title);
                    $('#previmage').val(json[0].newsImage);
                    $('#description').val(json[0].description);
                    $('#publishDate').val(json[0].publishDateo);
                    $('#description').summernote('code', json[0].description);

                }
            });
        });
        $(document).on("click", ".delNews", function () {
            var newsId = $(this).attr("del");
            $.confirm({
                title: 'Warning!',
                content: "Are you sure to delete?",
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Cancel: function () {
                        window.location.href = 'news';
                    },
                    Confirm: function () {
                        $.ajax({
                            type: "POST",
                            data: "del=" + newsId,
                            url: "<?php echo site_url("school/delNews"); ?>",
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
            url: "<?php echo site_url('school/getNews'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#news_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].newsImage === '') {
                        var image_url = '';
                    } else {
                        var image_url = base_url + json[i].newsImage;
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].title,
                        '<img src="' + image_url + '" onError="this.src=\'<?php echo base_url('projectimages/default.png'); ?>\'" class="img-responsive" style="height:60px;width:120px;">',
                        json[i].publishDate,
                        '<a class="editNews editbtn" href="javascript:" ed="' + json[i].newsId + '" title="Edit"><button class="btn btn-primary">View/Edit</button></a>',
                        '<a class="delNews"  del="' + json[i].newsId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                    ]);
                }
            }
        });

        $('#save_news').click(function () {
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
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                },
                error: function (response) {
                    $.alert({
                        title: 'Error!', content: response, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {
                                window.location.reload();
                            }
                        }
                    });
                }
            };
            $('#news_form').ajaxForm(options);
        });
    });
</script>