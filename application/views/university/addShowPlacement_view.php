<?php include_once 'university_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Placement
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Placement</a></li>
            <li class="active">Add Placement</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Placement</h3>
                    </div>
                    <?php echo form_open('university/addPlacement', ["id" => "placement_form", "name" => "placement_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <input type="hidden" name="previmage" id="previmage" value="no_image">
                            <div class="col-md-6 col-md-12">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" name="companyName" id="companyName" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-12">
                                <div class="form-group">
                                    <label>Company Image</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="companyImage" id="companyImage" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3 col-md-12">
                                <div class="form-group">
                                    <label>Highest Amount</label>
                                    <input type="text" name="highestAmount" id="highestAmount" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-3 col-md-12">
                                <div class="form-group">
                                    <label>Average Amount</label>
                                    <input type="text" name="averageAmount" id="averageAmount" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-3 col-md-12">
                                <div class="form-group">
                                    <label>Lowest Amount</label>
                                    <input type="text" name="lowestAmount" id="lowestAmount" class="form-control"
                                           data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-3 col-md-12">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select name="Currency" id="currency" class="form-control">
                                        <option value="">Select</option>
                                        <?php
                                        if (isset($currency)) {
                                            foreach ($currency as $cr) {
                                                echo '<option value="' . $cr->code . '" >' . $cr->name . '(' . $cr->code . ')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_placement"
                                           id="save_placement" value="Save">
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
                        <h3 class="box-title">Placement Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="placement_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Company Name</th>
                                            <th>Company Image</th>
                                            <th>Highest Amount</th>
                                            <th>Average Amount</th>
                                            <th>Lowest Amount</th>
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
    $(".placement_link").addClass("active");
    $(".add_showPlacement_link").addClass("active");
    document.title = "iHuntBest | Add-Show Placement";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url('projectimages/images/placementCompany/image/'); ?>';
        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editPlacement", function () {
            var placementId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "ed=" + placementId,
                url: "<?php echo site_url('university/getPlacement'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].placementId);
                    $('#highestAmount').val(json[0].highestAmount);
                    $('#lowestAmount').val(json[0].lowestAmount);
                    $('#averageAmount').val(json[0].averageAmount);
                    $('#companyName').val(json[0].companyName);
                    $('#previmage').val(json[0].companyImage);
                    $('#currency').val(json[0].currency);
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
        $(document).on("click", ".delPlacement", function () {
            var placementId = $(this).attr("del");
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
                            data: "del=" + placementId,
                            url: "<?php echo site_url("university/delPlacement"); ?>",
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
        });

        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('university/getPlacement'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#placement_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].companyImage === '') {
                        var companyImage = '';
                    } else {
                        var companyImage = base_url + json[i].companyImage;
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].companyName,
                        '<img src="' + companyImage + '" onError="this.src=\'<?php echo base_url('projectimages/default.png'); ?>\'" class="img-responsive" style="height:60px;width:120px;">',
                        json[i].highestAmount + '(' + json[i].currency + ')',
                        json[i].averageAmount + '(' + json[i].currency + ')',
                        json[i].lowestAmount + '(' + json[i].currency + ')',
                        '<a class="editPlacement" href="javascript:" ed="' + json[i].placementId + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="delPlacement" href="javascript:" del="' + json[i].placementId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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

        $('#save_placement').click(function () {
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
            $('#placement_form').ajaxForm(options);
        });
    });
</script>