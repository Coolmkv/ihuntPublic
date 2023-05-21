<?php
include_once 'college_header.php';
if (isset($details)) {
    $id = $details->financial_detail_id;
    $credit_card_no = $details->credit_card_no;
//    $creditcard_cvv = $details->creditcard_cvv;
//    $creditcard_validity = $details->creditcard_validity;
    $debit_card_no = $details->debit_card_no;
//    $debitcard_cvv = $details->debitcard_cvv;
//    $debitcard_validity = $details->debitcard_validity;
    $bank_name = $details->bank_name;
    $bankaddress = $details->bankaddress;
    $bank_account_no = $details->bank_account_no;
    $ifscCode = $details->ifscCode;
    $micr_code = $details->micr_code;
    $defaultCurrency = $details->defaultCurrency;
    $account_holder_name = $details->account_holder_name;
    (empty($_SESSION['dCurrency']) ? $_SESSION['dCurrency'] = $defaultCurrency : '');
    $accountType = $details->accountType;
} else {
    $id = 'no_data';
//    $credit_card_no = "";
//    $creditcard_cvv = "";
//    $creditcard_validity = "";
//    $debit_card_no = "";
//    $debitcard_cvv = "";
//    $debitcard_validity = "";
    $bank_name = "";
    $bankaddress = "";
    $bank_account_no = "";
    $ifscCode = "";
    $micr_code = "";
    $defaultCurrency = "";
    $account_holder_name = "";
    $accountType = "";
}
echo $map['js'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Financial Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('college/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active">Financial Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Financial Details</h3>
                    </div>
                    <div class="hidden"><?php echo $map["html"]; ?></div>
                    <div class="box-body">
                        <?php echo form_open('college/saveFinancialDetails', ['id' => 'form_details', 'name' => 'form_details']); ?>
                        <div class="row">
                            <input type="hidden" value="<?php echo $id; ?>" name="id" id="user_id">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bank Name (Branch Name)</label>
                                    <input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" placeholder="Bank Name" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bank Address</label>
                                    <input type="text" name="bankaddress" id="bank_address" value="<?php echo $bankaddress; ?>" placeholder="Bank Address" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" maxlength="20" name="bank_account_no" id="bank_account_no" value="<?php echo $bank_account_no; ?>" placeholder="Account Number" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <input type="text" name="account_holder_name" id="account_holder_name" value="<?php echo $account_holder_name; ?>" placeholder="Account Name" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Account Type</label>
                                    <input type="text" name="accountType" id="accountType" value="<?php echo $accountType; ?>" placeholder="Account Type" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>IFSC Code</label>
                                    <input type="text" maxlength="20" name="ifscCode" id="ifscCode" value="<?php echo $ifscCode; ?>" placeholder="IFSC Code" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>MICR Code</label>
                                    <input type="text" maxlength="20" name="micr_code" id="micr_code" value="<?php echo $micr_code; ?>" placeholder="MICR Code" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Credit Card Number (Not Mandatory)</label>
                                    <input type="text" maxlength="20" name="credit_card_no" id="credit_card_no" value="<?php echo $credit_card_no; ?>" placeholder="Credit Card Number" class="form-control numOnly">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Debit Card Number (Not Mandatory)</label>
                                    <input type="text" maxlength="20" name="debit_card_no" id="debit_card_no" value="<?php echo $debit_card_no; ?>" placeholder="Debit Card Number" class="form-control numOnly">
                                </div>
                            </div>
                            <!--
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Credit Card CVV Number</label>
                                                                <input type="text" maxlength="20" name="creditcard_cvv" id="creditcard_cvv" value="<?php // echo $creditcard_cvv;              ?>" placeholder="123" class="form-control numOnly">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="creditcard_cvv">Credit Card Expiry</label>
                                                                <input type="text" pattern="[0-9 /]{5}" maxlength="5" title="mm/yy" name="creditcard_validity" value="<?php // echo $creditcard_validity;              ?>" id="creditcard_validity"   placeholder="MM/YY" class="form-control expirey card_exp">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Debit Card CVV Number</label>
                                                                <input type="text" maxlength="20" name="debitcard_cvv" id="debitcard_cvv" value="<?php // echo $debitcard_cvv;              ?>" placeholder="123" class="form-control numOnly">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="creditcard_cvv">Debit Card Expiry</label>
                                                                <input type="text" pattern="[0-9 /]{5}" maxlength="5" title="MM/YY" name="debitcard_valid" id="debitcard_valid" value="<?php // echo $debitcard_validity;              ?>"  placeholder="MM/YY" class="form-control card_exp expirey">
                                                            </div>
                                                        </div>-->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditcard_cvv">Default Currency</label>
                                    <select name="defaultCurrency" class="form-control">
                                        <option value="">Select</option>
                                        <?php
                                        if (isset($currency)) {
                                            foreach ($currency as $cr) {
                                                echo '<option value="' . $cr->code . '" ' . ($defaultCurrency == $cr->code ? 'selected' : '') . '>' . $cr->name . '(' . $cr->code . ')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">
                            </div>

                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!--/.col -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<div class="control-sidebar-bg"></div>
<!-- ./wrapper -->
<?php include 'college_footer.php' ?>
<script type="text/javascript">
    $(".profile_link").addClass("active");
    $(".view_Finacial_link").addClass("active");
    document.title = "iHuntBest | Financial Details";
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(".card_exp").change(function () {
            var ccev = $(this).val();
            var splitccev = ccev.split("/");
            if (splitccev.length === 2) {
                var month = splitccev[0];
                var year = splitccev[1];
                if (month > 12 || month < 0) {
                    alert("Invalid Month");
                    $(this).val('');
                    $(this).focus();
                    return false;
                } else if (year > 99 || year < 0) {
                    alert("Invalid Year");
                    $(this).val('');
                    $(this).focus();
                    return false;
                }
            } else {
                alert("Invalid Format");
                $(this).val('');
                $(this).focus();
                return false;
            }
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
            $('#form_details').ajaxForm(options);
        });
    });
</script>