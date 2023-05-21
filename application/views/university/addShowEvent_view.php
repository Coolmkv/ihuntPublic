<?php include_once 'university_header.php'; ?>
<?php echo $map['js']; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Event
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Event</a></li>
            <li class="active">Add/Show Event</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Event</h3>
                    </div>
                    <?php echo form_open_multipart("university/addEvent", ["id" => "event_form", "name" => "event_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <input type="hidden" name="prevImage" id="previmage" value="no_image">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Event Image</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="eventImage" id="eventImage" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Event Title</label>
                                    <input type="text" name="eventTitle" id="eventTitle" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Event Description</label>
                                    <textarea type="text" name="description" id="description" class="form-control" data-validation="required"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Location</label>
                                    <textarea type="text" name="address" id="address" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_event"
                                           id="save_event" value="Save">
                                </div>
                            </div>
                            <div class="hidden">
                                <?php echo $map['html']; ?>
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
                        <h3 class="box-title">Event Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="event_table"
                                       class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Event Image</th>
                                            <th>Event Title</th>
                                            <th>Description</th>
                                            <th>Location</th>
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
    $(".events_link").addClass("active");
    $(".add_show_events_link").addClass("active");
    document.title = "iHuntBest | Add-Show Event";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).ready(function () {
            var base_url = '<?php echo base_url('projectimages/images/eventImage/image/'); ?>';

            $.validate({
                lang: 'en'
            });
            $(document).on('click', '.editevent', function () {
                var eventId = $(this).attr("ed");
                $.ajax({
                    type: "POST",
                    data: "ed=" + eventId,
                    url: "<?php echo site_url('University/getEvents'); ?>",
                    success: function (response) {
                        var json = $.parseJSON(response);
                        $('#id').val(json[0].eventId);
                        $('#eventTitle').val(json[0].eventTitle);
                        $('#previmage').val(json[0].eventImage);
                        $('#description').val(json[0].description);
                        $('#address').val(json[0].location);
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
            });
<?php if (isset($_GET['del'])) { ?>
                var eventId = '<?php echo $_GET['del']; ?>';
                $.confirm({
                    title: 'Warning!',
                    content: "Are you sure to delete?",
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Cancel: function () {
                            window.location.href = 'event';
                        },
                        Confirm: function () {
                            $.ajax({
                                type: "POST",
                                data: "del=" + eventId,
                                url: "<?php echo site_url('University/delEvent'); ?>",
                                success: function (response) {
                                    var json = $.parseJSON(response);
                                    if (json.status === 'success') {
                                        $.alert({
                                            title: 'Success!', content: json.msg, type: 'blue',
                                            typeAnimated: true,
                                            buttons: {
                                                Ok: function () {
                                                    window.location.href = "event";
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

<?php } ?>

            $.ajax({
                type: "POST",
                data: "",
                url: "<?php echo site_url('University/getEvents'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    var oTable = $('table#event_table').dataTable();
                    oTable.fnClearTable();
                    for (var i = 0; i < json.length; i++) {
                        if (json[i].eventImage === '') {
                            var image_url = '';
                        } else {
                            var image_url = base_url + json[i].eventImage;
                        }
                        oTable.fnAddData([
                            (i + 1),
                            '<img src="' + image_url + '" onError="this.src=\'<?php echo base_url('projectimages/default.png') ?>\'" class="img-responsive" style="height:60px;width:120px;">',
                            json[i].eventTitle,
                            json[i].description,
                            json[i].location,

                            '<a class="editevent" href="javascript:" ed="' + json[i].eventId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="event?del=' + json[i].eventId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>',
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

            $('#save_event').click(function () {
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
                $('#event_form').ajaxForm(options);
            });
        });
    });
</script>