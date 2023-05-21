<?php
include_once 'university_header.php';

if (isset($defaultImage)) {
    $currentImage = $defaultImage->orgImgHeader;
    $orgVideo = $defaultImage->orgVideo;
} else {
    $currentImage = "";
    $orgVideo = "";
}
?>
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
    .deficon{
        position: absolute;
        z-index: 100;
        padding: 6px;
        background: #3c8dbc;
        right: 25px;
        bottom:105px;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        display: none;
    }
    .deficonv{    position: absolute;
                  z-index: 100;
                  padding: 6px;
                  background: #3c8dbc;
                  right: 130px;
                  bottom: 211px;
                  color: #fff;
                  border-radius: 5px;
                  cursor: pointer;
                  display: none;

    }
    .videodiv:hover .deficonv{
        display: block;
    }
    .imagediv:hover .editicon {
        display: block;
    }
    .imagediv:hover .delicon{
        display: block;
    }
    .imagediv:hover .deficon{
        display: block;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile Header Management
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('university/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active"> Profile Header Management</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- /.modal -->
        <div class="modal fade" id="UploadImage" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-user m-r-5"></i>Upload New Header Image</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open_multipart("university/uploadheaderImageVideo", ["name" => "imageVideo", "class" => "form-horizontal", "id" => "imageVideo"]) ?>
<!--                                        <input type="hidden" name="id" id="id" value="no_one">-->
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Upload Header Image</label>
                                        <input type="file"  accept="image/x-png,image/gif,image/jpeg" name="headerImage" id="headerImage" class="form-control" required="true" >
                                        <div class='imgprogress' id="progressDivId">
                                            <div class='imgprogress-bar' id='progressBar'></div>
                                            <div class='imgpercent' id='percent'>0%</div>
                                        </div>
                                        <input type="hidden" name="prevImage" id="prevImage" class="hidden" value="">
                                        <input type="hidden" name="prevImageId"  id="prevImageId" class="hidden" value="">
                                        <input type="hidden" name="type" class="hidden" value="image">
                                    </div>
                                    <div class="col-md-12 form-group user-form-group">
                                        <div class="pull-right">
                                            <button type="submit"  name="headerImage_upload" id="headerImage_upload" class="btn btn-primary">Upload</button>

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

        <div class="modal fade" id="HeaderVideo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-vimeo-square m-r-5"></i>Upload Header Video</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open_multipart('university/uploadheaderImageVideo', ["name" => "header_video", "id" => "header_video"]); ?>
<!--                                        <input type="hidden" name="id" id="id" value="no_one">-->
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-6 form-group">
                                        <label >Upload Header Video:</label>
                                        <input type="file" accept="video/mp4,video/x-m4v,video/*" name="orgvideoHeader" id="orgvideoHeader"  class="form-control"onchange="uploadFile('orgvideoHeader')">
                                        <div class='imgprogress' id="videoprogressDivId">
                                            <div class='imgprogress-bar' id='videoprogressBar'></div>
                                            <div class='imgpercent' id='videopercent'>0%</div>
                                        </div>
                                        <input type="hidden" name="headerVideoUrl" class="hidden" value="">
                                        <input type="hidden" name="type" class="hidden" value="video">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label >OR Header Video URL:</label>
                                        <input type="text" name="orgVideoUrl" id="orgVideoUrl"  class="form-control">
                                        <input type="hidden" name="Headerimgname" class="hidden" value="">
                                    </div>
                                    <div class="col-md-12 form-group user-form-group">
                                        <div class="pull-right">
                                            <button type="submit" name="headerVideo_upload" id="headerVideo_upload" class="btn btn-primary">Upload</button>
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

        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profile Header Management</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 text-center">
                                <div class="form-group">
                                    <label>Current Image</label><br>
                                    <img  style="height:210px;width: 300px" alt="No selected Logo"src="<?php echo base_url($currentImage); ?>" onerror="this.src='<?php echo base_url('projectimages/default.png'); ?>'" class="img-responsive img-thumbnail">
                                    <div class="text-center">
                                        <button style="margin-left:5px; margin-top: 5px;width: 100px" class="form-control btn btn-primary" type="submit" id="orgLogo" onclick="clearForm('imageVideo');" name="orgLogo" data-toggle="modal" data-target="#UploadImage">Upload Image</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="form-group videodiv">
                                    <label>Available Video</label><br>
                                    <video width="300" height="210" controls>
                                        <source src="<?php echo base_url($orgVideo); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <span title="Set Default Image" class="fa fa-check deficonv" onclick="setDefaultImage('', '<?php echo base_url($orgVideo); ?>', 'video');" ></span>
                                    <div class="text-center">
                                        <button style="margin-left:5px; margin-top: 5px;width: 100px" class="form-control btn btn-primary" onclick="clearForm('header_video');" type="submit" id="orgVideo" name="orgVideo" data-toggle="modal" data-target="#HeaderVideo">Edit Video</button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

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
                        <h3 class="box-title">Profile Header Images</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <?php
                            if (isset($headerImage)) {
                                foreach ($headerImage as $hi) {

                                    echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 item video imagediv">
                                            <div class="thumbnail">
                                            <span class="fa fa-trash-o deleteAction delicon"
                                                  id="' . $hi->headerId . '_' . $hi->url . '" ></span>
                                                    <span title="Edit Image" class="fa fa-pencil editicon" onclick="editImage(' . $hi->headerId . ',\'' . $hi->url . '\');" ></span>
                                                    <span title="Set Default Image" class="fa fa-check deficon" onclick="setDefaultImage(' . $hi->headerId . ',\'' . $hi->url . '\',\'image\');" ></span>
                                                <a href="' . base_url($hi->url) . '" data-sub-html="Demo Description">
                                                    <figure class="img-effect-shine">
                                                        <img class="img-responsive" src="' . base_url($hi->url) . '"
                                                             alt="Demo Description"
                                                             style="display: block; width: auto;height:180px">
                                                    </figure>
                                                </a>
                                            </div>
                                        </div>';
                                }
                            }
                            ?>


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
    $(".profile_link").addClass("active");
    $(".profile_header_link").addClass("active");
    document.title = "iHuntBest | Profile View";
    $('#headerImage_upload').click(function () {

        var options = {
            beforeSend: function () {
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
        $('#imageVideo').ajaxForm(options);
    });
    $('#headerVideo_upload').click(function () {
        var options = {
            beforeSend: function () {
                var vid = document.getElementById("orgvideoHeader");
                var mbs = (vid.files[0].size) / (1024 * 1024);
                if (mbs > 100) {
                    $.alert({
                        title: 'Error!', content: "Video size should be less than 100 Mb. It is now " + mbs + " mb", type: 'red',
                        typeAnimated: true
                    });
                    return false;
                } else {
                    $("#videoprogressDivId").css("display", "block");
                    var percentValue = '0%';
                    $('#videoprogressBar').width(percentValue);
                    $('#videopercent').html(percentValue);
                }

            }, uploadProgress: function (event, position, total, percentComplete) {
                var percentValue = percentComplete + '%';
                $("#videoprogressBar").animate({
                    width: '' + percentValue + ''
                }, {
                    duration: 100,
                    easing: "linear",
                    step: function (x) {
                        //console.log('percentComplete' + percentComplete);
                        //percentText = Math.round(x * 100 / percentComplete);
                        $("#videopercent").text(percentComplete + "%");
                    }
                });
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
        $('#header_video').ajaxForm(options);
    });
    function editImage(id, prevImage) {
        if (id !== "" && prevImage !== "") {
            $("#prevImage").val(prevImage);
            $("#prevImageId").val(id);
            $("#progressDivId").css("display", "none");
            document.getElementById('imageVideo').reset();
            $("#UploadImage").modal('show');
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
    $(document).on('click', '.deleteAction', function () {
        var data = $(this).attr("id");
        var data1 = data.split('_');
        var headerId = data1[0];
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
                        data: {headerId: headerId, imgPath: imgPath, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                        url: '<?php echo site_url('university/deleteHeaderImage'); ?>',
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
    function setDefaultImage(headerId, imgPath, type) {
        $.confirm({
            title: 'Warning!',
            content: "Are you sure to set this default?",
            type: 'red',
            typeAnimated: true,
            buttons: {
                Cancel: function () {
                    window.location.reload();
                },
                Confirm: function () {
                    $.ajax({
                        type: "POST",
                        data: {headerId: headerId, imgPath: imgPath, type: type, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                        url: '<?php echo site_url('university/setDefaultImage'); ?>',
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
    }

</script>