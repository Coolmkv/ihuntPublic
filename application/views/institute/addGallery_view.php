<?php include_once 'institute_header.php'; ?>

<link href="<?php echo base_url() ?>plugins/bootstrap-fileupload/css/bootstrap-fileupload.css"
      rel="stylesheet"/>
<link href="<?php echo base_url() ?>plugins/lightgallery/css/lightgallery.min.css" rel="stylesheet">
<style>
    .my-panel-body{
        box-shadow: 0px 2px 10px #212121;
        background:white;
        padding: 20px;
    }
    .delicon{
        position: absolute;
        z-index: 100;
        padding: 5px;
        background: #730707;
        right: 25px;
        top:10px;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        display: none;
    }
    .imagediv:hover .delicon{
        display: block;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gallery
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('institute/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Gallery</a></li>
            <li class="active"> Add/Show Gallery</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Gallery</h3>
                    </div>
                    <div class="panel">
                        <div class="my-panel-body">
                            <div class="list-unstyled row clearfix masonry-container lightgallery"
                                 style="position: relative;" id="gym_gallery">
                                     <?php
                                     if (isset($gimages)) {
                                         foreach ($gimages as $gi) {
                                             $imgname = explode("/", $gi->imgPath);
                                             $img = $imgname[count($imgname) - 1];
                                             echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 item video imagediv">
                                            <div class="thumbnail">
                                            <span class="fa fa-trash-o deleteAction delicon"
                                                  id="' . $gi->galleryId . '_' . base_url('projectimages\images\gallery\image\/') . $img . '" ></span>
                                                <a href="' . base_url('projectimages\images\gallery\image\/') . $img . '" data-sub-html="Demo Description">
                                                    <figure class="img-effect-shine">
                                                        <img class="img-responsive" src="' . base_url('projectimages\images\gallery\image\/') . $img . '"
                                                             alt="Demo Description"
                                                             style="display: block; width: 246px;height:180px">
                                                    </figure>
                                                </a>
                                            </div>
                                        </div>';
                                         }
                                     }
                                     ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 item video">

<?php echo form_open_multipart('institute/addNewGalleryImage', ["id" => "galary_form", "role" => "form", "name" => "galary_form", "data-toggle" => "validator"]); ?>
                                    <fieldset>
                                        <div>
                                            <!--<label class="label col-sm-2">Galary</label>-->
                                            <div class="controls col-sm-10">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="fileupload-new thumbnail"
                                                         style="width: 200px; height: 150px;">
                                                        <img src="<?php echo base_url(); ?>plugins/no-image.png" alt="image"/>

                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                         style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                    <div>
                                                        <span class="btn btn-white btn-file">
                                                            <span class="fileupload-new"> <i
                                                                    class="fa fa-plus"></i> Add More</span>
                                                            <span class="fileupload-exists"><i
                                                                    class="fa fa-undo"></i> Change</span>

                                                            <input type="file" id="galaryUrl" accept="image/x-png,image/gif,image/jpeg"
                                                                   name="galaryUrl" class="default"
                                                                   onchange="readURL(this);"/>
                                                        </span>
                                                        <b>(1024 * 500)</b>
                                                        <button class="btn btn-primary fileupload-exists"
                                                                id="add_galary"><i class="fa fa-upload"></i>
                                                            Upload
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
<?php echo form_open(); ?>
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







<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <!--<b>Version</b> 1.0.0 (Test)-->
        <strong>Designed &AMP; Developed by<a href="http://starlingsoftwares.com" target="_blank"> Starling Softwares</a></strong>
    </div>
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="#" target="_blank">Starling Softwares</a>.</strong> All rights
    reserved.
</footer>
<div class="control-sidebar-bg"></div>
</div>

<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery.form.js"></script>

<!-- AdminLTE App -->

<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/app.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/bootstrap-fileupload/js/bootstrap-fileupload.js"></script>
<script src="<?php echo base_url(); ?>plugins/lightgallery/js/lightgallery-all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/imagesLoaded.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/gallery.js" type="text/javascript"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script type="text/javascript">
                                                                               date_time('date_time');
</script>
</body>
</html>
<script>
    $(".gallery_link").addClass("active");
    $(".add_gallery_link").addClass("active");
    document.title = "iHuntBest | Add Gallery";

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#gym_gallery').lightGallery({
            thumbnail: true,
            animateThumb: true,
            showThumbByDefault: false
        });
        $(document).on('click', '.deleteAction', function () {
            var data = $(this).attr("id");
            var data1 = data.split('_');
            var galaryId = data1[0];
            var imgPath = data1[1];

            $.confirm({
                title: 'Warning!',
                content: "Are you sure to delete?",
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Cancel: function () {
                        window.location.href = 'addGallery';
                    },
                    Confirm: function () {
                        $.ajax({
                            type: "POST",
                            data: 'id=' + galaryId + '&imgPath=' + imgPath,
                            url: '<?php echo site_url('institute/deleteGalleryImage'); ?>',
                            success: function (response) {
                                var json = $.parseJSON(response);
                                if (json.status === 'success') {
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

                                } else {
                                    alert(json.msg);
                                }
                            }
                        });
                    }
                }
            });
        });
        $('#add_galary').click(function () {

            var options = {
                beforeSend: function () {
                    $("#add_galary").prop('disabled', true);
                    $("#add_galary").html('Please Wait');
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({title: 'Success!', content: json.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.href = 'addGallery';
                                }
                            }
                        });
                        location.reload();
                    } else {
                        $.alert({
                            title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true
                        });
//                        $('#error').html('<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> "' + json.msg + '"</div>');
                    }
                    $("#add_galary").prop('disabled', false);
                    $("#add_galary").html('Upload');
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#galary_form').ajaxForm(options);
        });
    });
</script>