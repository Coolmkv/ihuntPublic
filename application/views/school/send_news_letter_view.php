<?php include_once 'school_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Send News Letter
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("school/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Send News Letter</a></li>
            <li class="active">Send</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Upload Email For News Letter</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open_multipart('school/uploadnewsltremailexcel', ["id" => "form_upload", "name" => "form_upload"]); ?>
                        <div class="row">

                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Upload File</label>
                                    <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="news_ltr_email_excel" id="news_ltr_email_excel" class="form-control" data-validation="required">

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_data" id="save_data" value="Save">
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-2">
                            <div class="form-group">
                                <label>Download Sample</label>
                                <a download="News Letter Email" href="<?php echo base_url('excelfiles\exceldownloads\News Letter Email.xlsx'); ?>">Sample Excel</a>
                                <p>All details should be in a perfect order as in the sample.</p>
                            </div>
                        </div>

                    </div>

                    <!--/.col -->
                </div>
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Send News Letter</h3>
                    </div>
                    <?php echo form_open('school/emailnewsletter', ["id" => "sendnl_form", "name" => "sendnl_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Email</label>
                                    <select name="email" id="email" class="form-control" data-validation="required"></select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Message</label>
                                <textarea class="form-control summernote"  id="msg" name="msg"></textarea>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_sendnl"
                                           id="save_sendnl" value="Send">
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
    </section>
    <!-- /.content -->
</div>
<?php include_once 'school_footer.php'; ?>
<script>
    $(".nlpbSend").addClass("active");
    $(".nlpb_link").addClass("active");
    document.title = "iHuntBest | Send News Letter";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote();
        $.validate({
            lang: 'en'
        });
        getEmail();
        function getEmail() {
            $.ajax({
                url: "<?php echo site_url('school/getnewsletteremailJson'); ?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select Email</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].email + '">' + json[i].email + '</option>';
                    }
                    $('#email').html(data);
                }
            });
        }
        $('#save_data').click(function () {

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
            $('#form_upload').ajaxForm(options);
        });
        $('#save_sendnl').click(function () {
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
            $('#sendnl_form').ajaxForm(options);
        });
    });
</script>