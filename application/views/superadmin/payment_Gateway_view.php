<?php include_once 'superadmin_header.php'; ?>
<div class="content-wrapper">
    <div class="hidden"></div>
    <section class="content-header">
        <h1>
            Payment Gateway Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Super-Admin Dashboard</a></li>
            <li><a href="#">Payment Gateway</a></li>
            <li class="active">Payment Gateway Details</li>
        </ol>
    </section>
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Payment Gateway Details</h3>
                    </div>
                    <?php echo form_open("superadmin/insertPaymentGatewayDetails", ["id" => "submit_form"]); ?>
                    <div class="box-body">
                        <div class="col-md-12">
                            <input type="hidden" name="payment_gatewayID" id="payment_gatewayID" value="no_one" >

                            <div class="form-group col-md-4">
                                <label>Payment Gateway Name</label>
                                <input type="text"  name="gateway_name" placeholder="Payment Gateway Name" id="gateway_nameID" class="form-control" data-validation ="required">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Salt</label>
                                <input type="text" name="salt" id="saltId" placeholder="Salt" class="form-control" data-validation ="required">
                            </div>
                            <div class="form-group col-md-4">
                                <label>API Key</label>
                                <input type="text" name="apikey" id="apikeyId" placeholder="API Key" class="form-control" data-validation ="required">
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <input   type="submit" value="Save" class="btn btn-primary" name="save_details" id="save_details">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Payment Gateway Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="data_table" class="table table-bordered table-condensed table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Payment Gateway Name</th>
                                                <th>Salt</th>
                                                <th>API Key</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="control-sidebar-bg"></div>
<?php include 'superadmin_footer.php' ?>


<script type="text/javascript">
    //$(".advertisement_plan").addClass("active");
    //$(".advertisement_plan_link").addClass("active");
    document.title = "iHuntBest | Add-Show Payment Gateway Details";
    function setDefault(payment_gatewayID) {
        $.confirm({
            title: 'Warning!',
            content: "Are you sure to set it default?",
            type: 'red',
            typeAnimated: true,
            buttons: {
                Cancel: function () {
                    window.location.reload();
                },
                Confirm: function () {
                    $.ajax({
                        type: "POST",
                        data: {payment_gatewayID: payment_gatewayID, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                        url: "<?php echo site_url('superadmin/setDefault'); ?>",
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
                                    }});
                            }
                        }
                    });
                }
            }
        });
    }
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });


        $('#save_details').click(function () {
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

                                }
                            }});
                    }
                },
                error: function (response) {
                    $.alert({title: 'Error!', content: response, type: 'red',
                        typeAnimated: true, buttons: {
                            Ok: function () {

                            }
                        }});
                }
            };
            $('#submit_form').ajaxForm(options);
        });
        $.ajax({
            type: "POST",
            data: {ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
            url: "<?php echo site_url('Superadmin/getPaymentGatewaydetails'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    var isdefault = (json[i].isdefault === "1" ? '<span class="btn btn-success btn-xs">Default</span>' :
                            '<button type="button" onclick="setDefault(' + json[i].payment_gatewayID + ');" class="btn btn-xs btn-info" >Set Default</button>'
                            );
                    oTable.fnAddData([
                        (i + 1),
                        json[i].gateway_name,
                        json[i].salt,
                        json[i].apikey,
                        '<a href="javascript:" ed="' + json[i].payment_gatewayID + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                        <a class="delfunction" href="javascript:" del="' + json[i].payment_gatewayID + '" title="Delete"><i class="fa fa-trash-o"></i></i></a> &nbsp;&nbsp;' + isdefault
                    ]);
                }
            }
        });
        $(document).on("click", ".editfunction", function () {
            var payment_gatewayID = $(this).attr('ed');
            $.ajax({
                type: "POST",
                data: {payment_gatewayID: payment_gatewayID, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                url: "<?php echo site_url('Superadmin/getPaymentGatewaydetails'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#payment_gatewayID').val(json.payment_gatewayID);
                    $('#gateway_nameID').val(json.gateway_name);
                    $('#saltId').val(json.salt);
                    $('#apikeyId').val(json.apikey);
                }
            });

        });
        $(document).on("click", ".delfunction", function () {
            var payment_gatewayID = $(this).attr('del');
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
                            data: {payment_gatewayID: payment_gatewayID, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                            url: "<?php echo site_url('superadmin/delPaymentGatewayDetails'); ?>",
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
                                        }});
                                }
                            }
                        });
                    }
                }
            });
        });
    });
</script>