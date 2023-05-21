<?php include_once 'school_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Upload Approval Documents View
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('school/dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Upload Approval Documents</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Upload Approval Documents</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <?php echo form_open_multipart('school/uploadApprovalDocs', ["id" => "form_Submit", "name" => "form_Submit"]); ?>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <input type="hidden" class="hidden" name="approvalDocId" id="approvalDocId" value="no_id">
                                    <input type="hidden" class="hidden" name="docName" id="docName" value="">
                                    <input type="hidden" class="hidden" name="OrgFileName" id="OrgFileName" value="">
                                    <label class="control-label">Document Upload:</label>
                                    <input type="file" accept="application/pdf,application/msword,
                                           application/vnd.openxmlformats-officedocument.wordprocessingml.document" name="documentUpload" id="documentUpload" class="form-control" data-validation="required">
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">About Document :</label>
                                    <textarea  class="form-control" name="AboutDoc" id="AboutDoc" data-validation="required"  style="resize: none;"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">

                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div class="box-header with-border">
                            <h3 class="box-title">Uploaded Documents</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-condensed table-bordered table-hover">
                                        <thead>
                                            <tr><th>Sr.No.</th><th>File Name</th><th>About Document</th><th>Action</th></tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($adocs)) {
                                                $i = 1;
                                                foreach ($adocs as $docs) {
                                                    $filename = explode("/", $docs->docName);
                                                    echo '<tr><td>' . $i++ . '.' . '</td>';
                                                    echo '<td><a target="_blank" href="' . base_url($docs->docName) . '">' . ($docs->OrgFileName ? $docs->OrgFileName : $filename[count($filename) - 1]) . '</a></td>';
                                                    echo '<td>' . $docs->aboutDocument . '</td>';
                                                    echo '<td><a download href="' . base_url($docs->docName) . '"><i class="fa fa-download"></i></a>&nbsp;&nbsp;&nbsp; <a  href="javascript:"><i class="fa text-danger fa-trash" onclick="deleteme(' . $docs->approvalDocId . ')"></i></a>
                                                        &nbsp;&nbsp;&nbsp;<a  href="javascript:"><i class="fa fa-pencil" onclick="editme(' . $docs->approvalDocId . ')"></i></a></td> </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </section>
                <!-- /.content -->
            </div>
            <?php include_once 'school_footer.php'; ?>
            <script>
                $(".profile_link").addClass("active");
                $(".edit_upload_link").addClass("active");
                document.title = "iHuntBest | Upload Related Documents";
                $(document).ready(function () {
                    $.validate({
                        lang: 'en'
                    });
                    $('#save_details').click(function () {
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
                        $('#form_Submit').ajaxForm(options);
                    });
                });
                function editme(id) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('school/uploadedDocument'); ?>",
                        data: {id: id},
                        success: function (response) {
                            var json = $.parseJSON(response);
                            if (json) {
                                $("#AboutDoc").val(json.aboutDocument);
                                $("#approvalDocId").val(json.approvalDocId);
                                $("#docName").val(json.docName);
                                $("#OrgFileName").val(json.OrgFileName);
                                $("#documentUpload").attr("data-validation", "");
                            } else {
                                $.alert({
                                    title: 'Error!', content: "No data found", type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    }
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

                    });
                }
                function deleteme(id) {
                    $.confirm({
                        title: 'Warning!',
                        content: "Are you sure to delete ?",
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Cancel: function () {
                                window.location.reload();
                            },
                            Confirm: function () {
                                $.ajax({
                                    type: "POST",
                                    data: "del=" + id,
                                    url: "<?php echo site_url("school/deletedocument"); ?>",
                                    success: function (response) {
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
                            }
                        }
                    });
                }
            </script>