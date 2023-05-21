<?php include_once 'school_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Notifications
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('school/dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">View Notifications</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Notifications</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Message</th>
                                                <th>Sent From</th>
                                                <th>In Reference</th>
                                                <th>Notification Status</th>
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
        </div>

    </section>
    <!-- /.content -->
</div>

<?php include_once 'school_footer.php'; ?>
<script>

    $(".notfication_link").addClass("active");
    document.title = "iHuntBest | Notifications";

    $('#details_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('school/getNotifications') ?>",
            "dataType": "json",
            "type": "POST",
            "data": {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
        },
        "columns": [
            {"data": "MessageId"},
            {"data": "Message"},
            {"data": "SentBy"},
            {"data": "InRefence"},
            {"data": "NotificationStatus"}, {"data": "Action"}
        ],
        "columnDefs": [
            {
                "targets": [-1, 4],
                "orderable": false
            }
        ],

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
    $(document).ready(function () {
        $('#senNotificationMessage').click(function () {
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
                            typeAnimated: true, });
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
            $('#messagesubmit_form').ajaxForm(options);
        });
    });
    function sendNotificationMessage(orgId) {
        $("#sendMessage").modal("show");
        $("#org_Id").val(orgId);
    }
</script>
<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-envelope-o"></i> Send Message/Notification</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo form_open('school/sendNotifications', ["name" => "messagesubmit_form", "id" => "messagesubmit_form"]); ?>
                        <fieldset>
                            <!-- Text input-->
                            <div class="col-md-12 form-group">
                                <label class="control-label">Reference </label>
                                <input type="text" placeholder="Reference" id="reference" name="reference" data-validation="required" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label">Message </label>
                                <textarea placeholder="message" id="message" name="message" data-validation="required" class="form-control" style="resize: none;"></textarea>

                            </div>
                            <div class="col-md-3 col-lg-offset-1 form-group">
                                <label class="control-label">Send Email </label>
                                <input type="checkbox" id="emailSend" name="emailSend"  value="1"  >
                            </div>
                            <input type="hidden" class="hidden" name="orgId" id="org_Id" value="">
                            <div class="col-md-6 form-group user-form-group">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" id="senNotificationMessage">
                                        Send
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
