<?php include_once 'college_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Promocode
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("college/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Promocode</a></li>
            <li class="active">Add|Remove Promocode</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Promocode</h3>
                    </div>
                    <?php echo form_open('college/addPromocode', ["id" => "form_details"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="promocodeDetailsId" id="promocodeDetailsId" value="no_one">
                            <div class="form-group col-md-4 col-md-12">
                                <label>Promocode</label>
                                <input type="text" name="PromoCode" id="PromoCode" class="form-control" data-validation="required">
                            </div>
                            <div class="form-group col-md-4 col-md-12">
                                <label>Offer Amount</label>
                                <input type="text" name="offer_amount" id="offer_amount" class="form-control" data-validation="required">
                            </div>
                            <div class="form-group col-md-4 col-md-12">
                                <label>Course</label>
                                <select name="orgCourseId" id="orgCourseId" class="form-control" data-validation="required"></select>
                            </div>
                            <div class="form-group col-md-4 col-md-12">
                                <label>Valid From</label>
                                <input type="date" min="<?php echo date('Y-m-d'); ?>" name="validFrom" id="validFrom" class="form-control" data-validation="required">
                            </div>
                            <div class="form-group col-md-4 col-md-12">
                                <label>Valid To</label>
                                <input type="date" min="<?php echo date('Y-m-d'); ?>" name="validTo" id="validTo" class="form-control" data-validation="required">
                            </div>
                            <div class="form-group col-md-4 col-md-12">
                                <label>Price Per Promocode</label>
                                <input type="hidden" name="priceid" id="priceid" value="<?php if (isset($price)) {
                        echo $price->price;
                    } ?>">
                                <input type="hidden" name="promocodeId" id="promocodeId" value="<?php if (isset($price)) {
                        echo $price->promocodeId;
                    } ?>">
                                <input type="number" name="price" id="price" readonly="true" value="<?php if (isset($price)) {
                        echo $price->price;
                    } ?>" class="form-control" data-validation="required">
                            </div>
                            <div class="form-group col-md-4 col-md-12">
                                <label>Number of Promocodes</label>
                                <input type="number" name="numberOfCodes" min="1" id="numberOfCodes" class="form-control" data-validation="required">
                            </div>
                            <div class="form-group col-md-4 col-md-12">
                                <label>Payable Amount</label>
                                <input type="number" readonly="true" min="1" name="payableAmount" id="payableAmount" class="form-control" data-validation="required">
                            </div>
                            <div class="form-group col-md-4 col-md-12">
                                <label>Applicable</label>
                                <input type="checkbox" name="isApplicable" value="1" id="isApplicable" class="form-control">
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_achieve" id="save_achieve" value="Save">
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
                        <h3 class="box-title">Promocode Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="achieve_table"
                                       class="table table-bordered table-striped table-responsive table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Promocode</th>
                                            <th>Offer Amount</th>
                                            <th>Course</th>
                                            <th>Valid Dates</th>
                                            <th>Price Per Promocode</th>
                                            <th>Number of Promocodes</th>
                                            <th>Payable Amount (Status)</th>
                                            <th>Applicable</th>
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
<?php include_once 'college_footer.php'; ?>
<script>
    $(".promoCode_link").addClass("active");
    $(".addShowPromocode").addClass("active");
    document.title = "iHuntBest | Add-Show Promocode";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $("#validFrom").change(function () {
            $("#validTo").prop("min", $(this).val());
        });
        $("#validTo").change(function () {
            $("#validFrom").prop("max", $(this).val());
        });
        $("#numberOfCodes").keyup(function () {
            var price = parseInt($("#priceid").val());
            var noc = parseInt($(this).val());
            if (price > 0 && noc > 0) {
                var totalamount = price * noc;
                $("#payableAmount").val(totalamount);
            } else {
                $("#payableAmount").val('');
                return false;
            }
        });
        getCourseName('', 'orgCourseId');
        function getCourseName(selval, Position) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('college/getCourseNames'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    var seldata = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        seldata = seldata + '<option value="' + json[i].orgCourseId + '">' + json[i].courseName + '</option>';
                    }
                    $("#" + Position).html(seldata);
                    $("#" + Position).val(selval);
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

        $(document).on("click", ".editDetails", function () {
            var promocodeDetailsId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "promocodeDetailsId=" + promocodeDetailsId,
                url: "<?php echo site_url('college/getPromocode'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#promocodeDetailsId').val(json[0].promocodeDetailsId);
                    $('#PromoCode').val(json[0].PromoCode);
                    $('#offer_amount').val(json[0].offer_amount);
                    $('#orgCourseId').val(json[0].orgCourseId);
                    $('#validFrom').val(json[0].validFrom);
                    $('#validTo').val(json[0].validTo);
                    $("#validTo").prop("min", json[0].validFrom);
                    $("#validFrom").prop("min", json[0].validFrom);
                    $('#price').val(json[0].price);
                    $('#priceid').val(json[0].price);
                    $('#numberOfCodes').val(json[0].numberOfCodes);
                    $('#payableAmount').val(json[0].payableAmount);
                    (json[0].isapplicable === "1" ? $('#isApplicable').prop("checked", true) : '');
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
        $(document).on("click", ".delDetails", function () {
            var promocodeDetailsId = $(this).attr("del");
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
                            data: "promocodeDetailsId=" + promocodeDetailsId,
                            url: "<?php echo site_url("college/delPromocode"); ?>",
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
            url: "<?php echo site_url('college/getPromocode'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#achieve_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].PromoCode,
                        json[i].offer_amount,
                        json[i].courseName,
                        json[i].validdates,
                        json[i].price,
                        json[i].numberOfCodes,
                        json[i].payableAmount + '&nbsp;' + (json[i].paymentStatus === "1" ? '<span class="label label-primary">Paid</span>' : '<span class="label label-danger">Not Paid</span>'),
                        (json[i].isapplicable === "1" ? '<span class="label label-primary">Applicable</span>' : '<span class="label label-danger">Not Applicable</span>'),
                        '<a class="editDetails" href="javascript:" ed="' + json[i].promocodeDetailsId + '" title="Edit"><i class="fa fa-edit"></i></i></a>\n\
            &nbsp;&nbsp;&nbsp;&nbsp;<a class="delDetails" href="javascript:" del="' + json[i].promocodeDetailsId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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

        $('#save_achieve').click(function () {
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
            $('#form_details').ajaxForm(options);
        });
    });
</script>