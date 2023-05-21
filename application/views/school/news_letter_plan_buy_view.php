<?php include_once 'school_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            News Letter Plan Buy
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("school/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">News Letter Plan Buy</a></li>
            <li class="active">Buy/Show</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Buy News Letter Plan</h3>
                    </div>
                    <?php echo form_open('school/addnewsletterplanbuy', ["id" => "nlpb_form", "name" => "nlpb_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one" >

                            <div class="col-md-12">
                                <div class="form-group col-md-3">
                                    <label>Plan Name</label>
                                    <select name="plan_name" id="plan_name" class="form-control" data-validation="required"></select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>No. of News Letter</label>
                                    <input type="text" name="no_of_news_ltr" id="no_of_news_ltr" class="form-control" disabled="">
                                    <input type="hidden" name="no_of_news_ltr1" id="no_of_news_ltr1" value="" >

                                </div>
                                <div class="form-group col-md-3">
                                    <label>Price</label>
                                    <input type="text" name="price" id="price" class="form-control" disabled="">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Currency</label>
                                    <input type="text" name="currencies" id="currencies" class="form-control" disabled="">
                                </div>
                            </div>
                            <div class="col-md-12 col-md-offset-5">
                                <div class="form-group" style="margin-top: 23px">
                                    <input type="submit" class="btn btn-primary" name="save_nlpb" id="save_nlpb" value="Buy">
                                    <input type="reset" class="btn btn-danger" name="cancel_nlpb" id="cancel_nlpb" value="Cancel">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php form_close(); ?>
                    <!--/.col -->
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">News Letter Plan Buy</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="nlpb_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Plan Name</th>
                                            <th>No.of News Letter</th>
                                            <th>Price</th>
                                            <th>Currency</th>
                                            <th>Buy Date</th>
                                            <th>Status</th>
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
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<!-- ./wrapper -->
<?php include 'school_footer.php' ?>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        getPlanName();
        function getPlanName() {
            $.ajax({
                url: "<?php echo site_url('school/getNewsLetterPlandetailsJson'); ?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose Plan Name</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].nlp_Id + '">' + json[i].plan_name + '</option>';
                    }
                    $('#plan_name').html(data);
                }
            });
        }
        $('#plan_name').change(function () {
            var nlp_Id = $(this).val();
            changePlanName(nlp_Id);
        });
        function changePlanName(nlp_Id) {
            $.ajax({
                url: "<?php echo site_url('school/getNewsLetterPlandetailsJson'); ?>",
                type: 'POST',
                data: 'nlp_Id=' + nlp_Id,
                success: function (response) {
                    if (response !== "") {
                        var json = $.parseJSON(response);
                        $("#no_of_news_ltr1").val(json[0].no_of_news_ltr);
                        $("#no_of_news_ltr").val(json[0].no_of_news_ltr);
                        $("#price").val(json[0].price);
                        $('#currencies').val(json[0].currencies);
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
        $('#save_nlpb').click(function () {
            var options = {
                beforeSend: function () {
                },
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
                            typeAnimated: true, buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
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
            $('#nlpb_form').ajaxForm(options);
        });
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('school/getnewsletterplanbuy'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#nlpb_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].iscurrent === '0') {
                        var iscurrent = '<span class="label label-danger">Disable</span>';
                    }
                    if (json[i].iscurrent === '1') {
                        var iscurrent = '<span class="label label-primary">Active</span>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].plan_name,
                        json[i].no_of_news_letter,
                        json[i].price,
                        json[i].currencies,
                        json[i].buyDate,
                        iscurrent,
                        '<select nlpb_Id="' + json[i].nlpb_Id + '" class="Status" style="background-color:#acd6e9;"><option value="">Choose One...</option><option value="0">Disable</option><option value="1">Active</option></select>'
                    ]);
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
        $(document).on("change", ".Status", function () {
            var nlpb_Id = $(this).attr("nlpb_Id");
            var iscurrent = $(this).val();
            if (iscurrent === "") {
                return false;
            }
            $.ajax({
                type: "POST",
                data: {nlpb_Id: nlpb_Id, iscurrent: iscurrent},
                url: "<?php echo site_url('school/changeStatusNlpb'); ?>",
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
                            }
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
            });
        });
    });
</script>
<script type="text/javascript">
    $(".nlpbAddShow").addClass("active");
    $(".nlpb_link").addClass("active");
    document.title = "iHuntBest | News Letter Plan Buy";
</script>