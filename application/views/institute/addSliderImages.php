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
    .editicon{
        position: absolute;
        z-index: 100;
        padding: 6px;
        background: #3c8dbc;
        right: 25px;
        bottom:30px;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        display: none;
    }
    .imagediv:hover .editicon{
        display: block;
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
            Slider Images
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("institute/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Slider Images</a></li>
            <li class="active"> Add/Show Slider Images</li>
        </ol>
    </section>
    <!-- /.modal -->
    <div class="modal fade" id="SlideImage" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-user m-r-5"></i>Upload New Slide</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open_multipart("institute/updateSliderImage", ["name" => "updateimage_form", "class" => "form-horizontal", "id" => "updateimage_form"]) ?>

                            <fieldset>
                                <!-- Text input-->
                                <div class="col-md-6 col-md-offset-3 form-group">
                                    <label class="control-label">Upload New Image:</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="sliderImage" id="sliderImage" class="form-control" required="true">
                                    <div class='imgprogress' id="progressDivId">
                                        <div class='imgprogress-bar' id='progressBar'></div>
                                        <div class='imgpercent' id='percent'>0%</div>
                                    </div>
                                    <input type="hidden" name="prevImage" class="hidden" id="prevImage">
                                    <input type="hidden" name="prevImageId" class="hidden" id="prevImageId">
                                </div>
                                <div class="col-md-12 form-group user-form-group">
                                    <div class="pull-right">
                                        <button type="submit" name="updateSlide" id="updateSlide" class="btn btn-primary">Upload</button>

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

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Slider Images</h3>
                    </div>
                    <div class="panel">
                        <div class="my-panel-body">
                            <div class="list-unstyled row clearfix masonry-container lightgallery"
                                 style="position: relative;" id="gym_gallery">
                                     <?php
                                     if (isset($gimages)) {
                                         foreach ($gimages as $gi) {

                                             echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 item video imagediv">
                                            <div class="thumbnail">
                                            <span class="fa fa-trash-o deleteAction delicon"
                                                  id="' . $gi->slideId . '_' . $gi->imageUrl . '" ></span>
                                                      <span title="Edit Image" class="fa fa-pencil editicon" onclick="editSliderImage(' . $gi->slideId . ',\'' . $gi->imageUrl . '\');" ></span>
                                                <a href="' . base_url($gi->imageUrl) . '" data-sub-html="Demo Description">
                                                    <figure class="img-effect-shine">
                                                        <img class="img-responsive" src="' . base_url($gi->imageUrl) . '"
                                                             alt="Demo Description"
                                                             style="display: block; width: 246px;height:180px">
                                                    </figure>
                                                </a>
                                            </div>
                                        </div>';
                                         }
                                     }
                                     ?>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 item video">

                                    <?php echo form_open_multipart('institute/addSliderImage', ["id" => "image_form", "role" => "form", "name" => "image_form", "data-toggle" => "validator"]); ?>
                                    <fieldset>
                                        <div>
                                            <!--<label class="label col-sm-2">Galary</label>-->
                                            <div class="controls col-sm-10">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="fileupload-new thumbnail">
                                                        <img src="<?php echo base_url(); ?>plugins/no-image.png" alt="image"/>
                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-white btn-file">
                                                            <span class="fileupload-new"> <i
                                                                    class="fa fa-plus"></i> Add More</span>
                                                            <span class="fileupload-exists"><i
                                                                    class="fa fa-undo"></i> Change</span>

                                                            <input type="file" accept="image/x-png,image/gif,image/jpeg" id="sliderImage"
                                                                   name="sliderImage" class="default"
                                                                   onchange="readURL(this);"/>
                                                        </span>
                                                        <b>(1350 * 400)</b>
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
    $(".profile_link").addClass("active");
    $(".sliderimage_link").addClass("active");
    document.title = "iHuntBest | Add Gallery";

</script>
<script type="text/javascript">
    function editSliderImage(id, prevImage) {
        if (id !== "" && prevImage !== "") {
            $("#prevImage").val(prevImage);
            $("#prevImageId").val(id);
            $("#SlideImage").modal('show');
            clearForm('updateimage_form');
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
    }
    $(document).ready(function () {
        $('#gym_gallery').lightGallery({
            thumbnail: true,
            animateThumb: true,
            showThumbByDefault: false
        });

        $(document).on('click', '.deleteAction', function () {
            var data = $(this).attr("id");
            var data1 = data.split('_');
            var slideId = data1[0];
            var imgPath = data1[1];

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
                            data: {slideId: slideId, imgPath: imgPath, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                            url: '<?php echo site_url('institute/deleteSliderImage'); ?>',
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
                                            typeAnimated: true,
                                            buttons: {
                                                Ok: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        });
                                    }

                                } else {
                                    alert(json.msg);
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
                    $("#add_galary").prop('disabled', false);
                    $("#add_galary").html('Upload');
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
            $('#image_form').ajaxForm(options);
        });
        $('#updateSlide').click(function () {

            var options = {
                beforeSend: function () {
                    $("#updateSlide").prop('disabled', true);
                    $("#updateSlide").html('Please Wait');
                    $("#progressDivId").css("display", "block");
                    var percentValue = '0%';
                    $('#progressBar').width(percentValue);
                    $('#percent').html(percentValue);
                }, uploadProgress: function (event, position, total, percentComplete) {

                    var percentValue = percentComplete + '%';
                    $("#progressBar").animate({
                        width: '' + percentValue + ''
                    }, {
                        duration: 100,
                        easing: "linear",
                        step: function (x) {
                            //console.log('percentComplete' + percentComplete);
                            //percentText = Math.round(x * 100 / percentComplete);
                            $("#percent").text(percentComplete + "%");
                        }
                    });
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
                }
                , error: function (jqXHR, exception) {
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
            $('#updateimage_form').ajaxForm(options);
        });
    });
</script>