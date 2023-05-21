<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            University Controls
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Organization Controls</a></li>
            <li class="active">University Controls</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">University Controls</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="showdata_table" class="table table-bordered table-striped table-condensed table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>University Name</th>
                                            <th>Profile Status</th>
                                            <th>Contact Details</th>
                                            <th>University Address</th>
                                            <th>Web site Link</th>
                                            <th>Enquiry/Enroll</th>
                                            <th>Send Message</th>
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

<div class="control-sidebar-bg"></div>

<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>

<script type="text/javascript">

    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
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
        $(document).on("change", ".weblink", function () {
            var id = $(this).attr("id");
            var weblink = $(this).val();
            $.ajax({
                type: "POST",
                data: {id: id, weblink: weblink, roletype: "University", '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},

                url: "<?php echo site_url('superadmin/webLinkStatusUpdate'); ?>",
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result.status === 'success') {
                        $.alert({title: 'Success!', content: result.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: result.msg, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }});
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
            });
        });
        $(document).on('change', '.btnenquiryenroll', function () {
            var loginId = $(this).attr("loginId");
            var btntype = $(this).val();
            if (btntype !== "") {
                $.ajax({
                    type: "POST",
                    data: "loginId=" + loginId + '&btntype=' + btntype + '&roleType=University',
                    url: "<?php echo site_url('superadmin/upOrgApprovalStatus'); ?>",
                    success: function (response) {
                        var result = $.parseJSON(response);
                        if (result.status === 'success') {
                            $.alert({title: 'Success!', content: result.msg, type: 'blue',
                                typeAnimated: true,
                                buttons: {
                                    Ok: function () {
                                        window.location.reload();
                                    }
                                }
                            });
                        } else {
                            $.alert({title: 'Error!', content: result.msg, type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    Ok: function () {
                                        window.location.reload();
                                    }
                                }});
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
                });
            } else {
                return false;
            }

        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getUniversityDetails'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var weblink = "";
                var enqenroll = "";
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    enqenroll = '<select name="btntype" class="btnenquiryenroll" loginId="' + json[i].id + '">\n\
                    <option value="" ' + (json[i].orgButtonType === "" ? 'selected' : '') + '>Choose One...</option>\n\
                    <option value="Enquiry" ' + (json[i].orgButtonType === "Enquiry" ? 'selected' : '') + '>Enquiry</option>\n\
                    <option value="Enroll" ' + (json[i].orgButtonType === "Enroll" ? 'selected' : '') + '>Enroll</option></select>';
                    weblink = '<select class="weblink" id="' + json[i].id + '"style="background-color:#acd6e9;">\n\
                        <option value="" ' + (json[i].webLinkStartus === "" ? 'selected' : '') + '>Choose One...</option>\n\
                        <option value="1" ' + (json[i].webLinkStartus === "1" ? 'selected' : '') + '>Active</option>\n\
                        <option value="0" ' + (json[i].webLinkStartus === "0" ? 'selected' : '') + '>Disable</option>';
                    oTable.fnAddData([
                        (i + 1),
                        '<a target="_blank" href="<?php echo site_url('superadmin/orgDetails/?id='); ?>' + json[i].orgIdc + '">' + json[i].orgName + '</a>',
                        json[i].profileStatus + " %",
                        'Ph. No: ' + json[i].orgMobile + '<br>Email: ' + json[i].email,
                        json[i].orgAddress,
                        weblink,
                        enqenroll,
                        '<button type="button" onClick="sendNotificationMessage(\'' + json[i].orgIdc + '\'); " class="btn btn-xs btn-primary">Send Message</button>'
                    ]);
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
        });
    });

    document.title = "iHuntBest | University Controls";
    function sendNotificationMessage(orgId) {
        $("#sendMessage").modal("show");
        $("#org_Id").val(orgId);
    }
</script>

<script type="text/javascript">
    $(".organicationControls_link").addClass("active");
    $(".univControls_link").addClass("active");
    document.title = "iHuntBest | University Controls";
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

                        <?php echo form_open('superadmin/sendNotifications', ["name" => "messagesubmit_form", "id" => "messagesubmit_form"]); ?>
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