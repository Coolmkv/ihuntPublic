<?php
include_once 'shared/header.php';
if (isset($details)) {
    $id = $details->financial_detail_id;
    $credit_card_no = $details->credit_card_no;
    $creditcard_cvv = $details->creditcard_cvv;
    $account_holder_name = $details->account_holder_name;
    $creditcard_validity = $details->creditcard_validity;
    $debit_card_no = $details->debit_card_no;
    $debitcard_cvv = $details->debitcard_cvv;
    $debitcard_validity = $details->debitcard_validity;
    $bank_name = $details->bank_name;
    $bankaddress = $details->bankaddress;
    $bank_account_no = $details->bank_account_no;
    $ifscCode = $details->ifscCode;
    $micr_code = $details->micr_code;
    $accountType = $details->accountType;
    $defaultCurrency = $details->defaultCurrency;
    (empty($_SESSION['dCurrency']) ? $_SESSION['dCurrency'] = $defaultCurrency : '');
} else {
    $id = 'no_data';
    $credit_card_no = "";
    $creditcard_cvv = "";
    $account_holder_name = "";
    $creditcard_validity = "";
    $debit_card_no = "";
    $debitcard_cvv = "";
    $debitcard_validity = "";
    $bank_name = "";
    $bankaddress = "";
    $bank_account_no = "";
    $ifscCode = "";
    $micr_code = "";
    $defaultCurrency = "";
    $accountType = "";
}
echo $map['js'];
?>
<script src="<?php echo base_url('js/jquery.min.js'); ?>" type="text/javascript"></script> <!--
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>-->
<script src="<?php echo base_url('js/amazon_scroller.js'); ?>" type="text/javascript"></script>
<!--
<script src="<?php echo base_url(); ?>plugins/lightgallery/js/lightgallery-all.min.js" type="text/javascript"></script>  -->
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery.form.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/app.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!--<script src="<?php echo base_url(); ?>plugins/imagesLoaded.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/gallery.js" type="text/javascript"></script> -->
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>js/custom.js"></script>

<script src="<?php echo base_url('plugins\summernote\summernote.min.js'); ?>"></script>
<script>
    function imgError(ele) {
        ele.onerror = "";
        console.log(ele);
        ele.src = '<?php echo base_url('homepage_images/default.png'); ?>';

        return true;
    }
</script>
<div class="bg-color regis12">
    <div class="container">

        <ul class="nav nav-tabs tabtop  tabsetting reg001">
            <li class="active" id="fac"> <a href="#tab_default_1" data-toggle="tab" aria-expanded="false">1.Personal Details</a> </li>
            <li class=""> <a href="#tab_default_2" data-toggle="tab" aria-expanded="false">2. Organization Details</a> </li>
            <li class=""> <a href="#tab_default_3" data-toggle="tab" aria-expanded="false">3. General Details</a> </li>
            <li class=""> <a href="#tab_default_4" data-toggle="tab" aria-expanded="false">4. Financial Details</a> </li>
        </ul>
        <?php
        if (isset($profileData)) {
            $orgName = $profileData->orgName;
            $orgMobile = $profileData->orgMobile;
            $email = $profileData->email;
            $country = $profileData->country;
            $state = $profileData->state;
            $city = $profileData->city;
            $orgAddress = $profileData->orgAddress;
            $orgType = $profileData->orgType;
            $directorName = $profileData->directorName;
            $directorEmail = $profileData->directorEmail;
            $directorMobile = $profileData->directorMobile;
            $orgWebsite = $profileData->orgWebsite;
            $approvedBy = $profileData->approvedBy;
            $orgDesp = $profileData->orgDesp;
            $orgMission = $profileData->orgMission;
            $orgVission = $profileData->orgVission;
            $countryId = $profileData->countryId;
            $stateId = $profileData->stateId;
            $cityId = $profileData->cityId;
            $orgGoogle = $profileData->orgGoogle;
            $orgEstablished = $profileData->orgEstablished;
            $org_landline = $profileData->org_landline;
        }
        echo $map['js'];
        ?>
        <div class="bg-de-college">
            <div class="details-text details-text-to">
                <div class="view-to-com view-to-com-to">
                    <div class="col-md-12 details-text-to-3">
                        <div class="tabbable-panel margin-tops4 ">
                            <div class="tabbable-line">
                                <?php echo form_open('university/saveProfile', ["id" => "profile_form", "name" => "profile_form"]); ?>

                                <div class="tab-content margin-tops">
                                    <div class="tab-pane fade active in" id="tab_default_1">
                                        <div class="about-college">
                                            <h3>Personal Details</h3>
                                        </div>

                                        <div class="to-college">
                                            <div class="row">
                                                <div class="hidden"><?php echo $map['html']; ?></div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label class="custom-label-form">Director Name<span style="color: Red; font-size: 15px; font-weight: bold;"> *</span></label>
                                                        <input name="directorName" maxlength="150" value="<?php echo $directorName; ?>" id="directorName" tabindex="1" class="form-control" data-validation="required" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label class="custom-label-form">Director Mobile<span style="color: Red; font-size: 15px; font-weight: bold;"> *</span></label>
                                                        <input name="directorMobile" maxlength="150" value="<?php echo $directorMobile; ?>" id="directorMobile" tabindex="2" class="form-control" data-validation="required" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label class="custom-label-form">Director Email<span style="color: Red; font-size: 15px; font-weight: bold;"> *</span></label>
                                                        <input name="directorEmail" maxlength="150" value="<?php echo $directorEmail; ?>" id="directorEmail" tabindex="3" class="form-control" data-validation="required" type="email">
                                                    </div>
                                                </div></div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-5"></div>
                                                <div class="col-md-3">
                                                    <a class="btn apply btnNext" >NEXT</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_default_2">
                                        <div class="about-college">
                                            <h3>Organization Details</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div id="orgdet">
                                                    <div class="row">
                                                        <div class="col-md-2 col-md-offset-1">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization Name<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <input name="orgName"  id="orgName" value="<?php echo $orgName; ?>"  tabindex="4" class="form-control" data-validation="required" type="text">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization Mobile<span style="color: Red; font-size: 15px; font-weight: bold;">*</span></label>
                                                                <input name="orgMobile" maxlength="200" value="<?php echo $orgMobile; ?>" id="orgMobile" tabindex="5" class="form-control" data-validation="required" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization Landline<span style="color: Red; font-size: 15px; font-weight: bold;">*</span></label>
                                                                <input name="org_landline" value="<?php echo $org_landline; ?>" id="org_landline" tabindex="6" class="form-control" data-validation="required" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization Email<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <input name="orgEmail"  id="orgEmail" tabindex="7" value="<?php echo $email; ?>" class="form-control" data-validation="required" type="email">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization Type<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <select name="orgType" id="orgType" class="form-control" data-validation="required">
                                                                    <option value="">Select</option>
                                                                    <option <?php
                                                                    if ($orgType == 'Goverment') {
                                                                        echo 'selected';
                                                                    }
                                                                    ?> value="Goverment">Government</option>
                                                                    <option <?php
                                                                    if ($orgType == 'Private') {
                                                                        echo 'selected';
                                                                    }
                                                                    ?> value="Private">Private</option>
                                                                    <option <?php
                                                                    if ($orgType == 'Deemed') {
                                                                        echo 'selected';
                                                                    }
                                                                    ?> value="Deemed">Deemed</option>
                                                                </select>
                                                            </div>
                                                        </div></div>
                                                    <div class="row">
                                                        <div class="col-md-2 col-md-offset-1">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Google Map Iframe<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <input type="text" name="orgGoogle" tabindex="9" id="orgGoogle" class="form-control" value='<?php echo $orgGoogle; ?>'>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization Country<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <select name="orgcountryId" id="orgcountryId" class="form-control" data-validation="required"> </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization State<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <select name="orgstateId" id="orgstateId" class="form-control" data-validation="required"> </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization City<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <select name="orgcityId" id="orgcityId" class="form-control" data-validation="required"> </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Website Url<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <input type="text" name="orgWebsite" tabindex="10" id="orgWebsite" class="form-control" data-validation="required" value="<?php echo $orgWebsite; ?>" >
                                                            </div>
                                                        </div></div>
                                                    <div class="row">
                                                        <div class="col-md-2 col-md-offset-1">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Approved By<span style="color: Red; font-size: 15px; font-weight: bold;">
                                                                        *</span></label>
                                                                <input type="text" name="approvedBy" tabindex="11" id="approvedBy" class="form-control" data-validation="required" value="<?php echo $approvedBy; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Organization Address<span style="color: Red; font-size: 15px; font-weight: bold;">*</span></label>
                                                                <input type="text" name="address1" tabindex="12" id="orgaddress" class="form-control" data-validation="required" value="<?php echo $orgAddress; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-md-offset-1.5">
                                                            <div class="form-group">
                                                                <label class="custom-label-form">Establish Date<span style="color: Red; font-size: 12px; font-weight: bold;">*</span></label>
                                                                <input type="date" max="<?php echo date('Y-m-d'); ?>" name="orgEstablished" tabindex="13" id="orgEstablished"  placeholder="YY/MM/DD" class="form-control" data-validation="required" value="<?php echo $orgEstablished; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <a class="btn apply btnPrevious" >PREV</a>
                                                        </div>
                                                        <div class="col-md-5"></div>
                                                        <div class="col-md-3">
                                                            <a class="btn apply btnNext" >NEXT</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_default_3">
                                        <div class="about-college">
                                            <h3>General Details</h3>
                                        </div>
                                        <div class="to-college">
                                            <div class="row">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label class="custom-label-form">Description<span style="color: Red; font-size: 15px; font-weight: bold;"> *</span></label>
                                                    <textarea name="orgDesp" id="orgDesp" class="form-control summernote" data-validation="required"></textarea>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label class="custom-label-form">Our Mission<span style="color: Red; font-size: 15px; font-weight: bold;"> *</span></label>
                                                    <textarea name="orgMission"  id="orgMission" tabindex="15" class="form-control summernote" data-validation="required"></textarea>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label class="custom-label-form">Our Vision<span style="color: Red; font-size: 15px; font-weight: bold;"> *</span></label>
                                                    <textarea name="orgVission"  id="orgVission" tabindex="16" class="form-control summernote" data-validation="required" type="text"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <a class="btn apply btnPrevious" >PREV</a>
                                                </div>
                                                <div class="col-md-5"></div>
                                                <div class="col-md-3">
                                                    <a class="btn apply btnNext" >NEXT</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_default_4">
                                        <div class="about-college">
                                            <h3>Financial Details</h3>
                                        </div>
                                        <div class="to-college">
                                            <div class="row">
                                                <input type="hidden" value="<?php echo $id; ?>" name="id" id="user_id">
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label class="custom-label-form">Bank Name (Branch)<span class="imp-text">*</span></label>
                                                        <input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" placeholder="Bank Name" class="form-control" data-validation="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label>Bank Address <span class="imp-text">*</span></label>
                                                        <input type="text" name="bankaddress" id="bank_address" value="<?php echo $bankaddress; ?>" placeholder="Bank Address" class="form-control" data-validation="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label>Account Number <span class="imp-text">*</span></label>
                                                        <input type="text" maxlength="20" name="bank_account_no" id="bank_account_no" value="<?php echo $bank_account_no; ?>" placeholder="Account Number" class="form-control" data-validation="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label>Account Name <span class="imp-text">*</span></label>
                                                        <input type="text" name="account_holder_name" id="account_holder_name" value="<?php echo $account_holder_name; ?>" placeholder="Account Name" class="form-control" data-validation="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label>Account Type <span class="imp-text">*</span></label>
                                                        <input type="text" name="accountType" id="accountType" value="<?php echo $accountType; ?>" placeholder="Account Type" class="form-control" data-validation="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label>IFSC Code <span class="imp-text">*</span></label>
                                                        <input type="text" maxlength="20" name="ifscCode" id="ifscCode" value="<?php echo $ifscCode; ?>" placeholder="IFSC Code" class="form-control" data-validation="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label>MICR Code <span class="imp-text">*</span></label>
                                                        <input type="text" maxlength="20" name="micr_code" id="micr_code" value="<?php echo $micr_code; ?>" placeholder="MICR Code" class="form-control" data-validation="required">
                                                    </div>
                                                </div>

                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label>Credit Card Number</label>
                                                        <input type="text" maxlength="20" name="credit_card_no" id="credit_card_no" value="<?php echo $credit_card_no; ?>" placeholder="Credit Card Number" class="form-control numOnly">
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-2 col-md-offset-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Credit Card CVV Number</label>
                                                                                                        <input type="text" maxlength="20" name="creditcard_cvv" id="creditcard_cvv" value="<?php // echo $creditcard_cvv;                ?>" placeholder="123" class="form-control numOnly">
                                                                                                    </div>
                                                                                                </div>-->
                                                <!--                                                <div class="col-md-2 col-md-offset-1">
                                                                                                    <div class="form-group">
                                                                                                        <label for="creditcard_cvv">Credit Card Expiry</label>
                                                                                                        <input type="text" pattern="[0-9 /]{5}" maxlength="5" title="mm/yy" name="creditcard_validity" value="<?php // echo $creditcard_validity;                ?>" id="creditcard_validity"   placeholder="MM/YY" class="form-control expirey card_exp">
                                                                                                    </div>
                                                                                                </div>-->
                                                <div class="col-md-2 col-md-offset-1">
                                                    <div class="form-group">
                                                        <label>Debit Card Number</label>
                                                        <input type="text" maxlength="20" name="debit_card_no" id="debit_card_no" value="<?php echo $debit_card_no; ?>" placeholder="Debit Card Number" class="form-control numOnly">
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-2 col-md-offset-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Debit Card CVV Number</label>
                                                                                                        <input type="text" maxlength="20" name="debitcard_cvv" id="debitcard_cvv" value="<?php // echo $debitcard_cvv;                ?>" placeholder="123" class="form-control numOnly">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-2 col-md-offset-1">
                                                                                                    <div class="form-group">
                                                                                                        <label for="creditcard_cvv">Debit Card Expiry</label>
                                                                                                        <input type="text" pattern="[0-9 /]{5}" maxlength="5" title="MM/YY" name="debitcard_valid" id="debitcard_valid" value="<?php // echo $debitcard_validity;                ?>"  placeholder="MM/YY" class="form-control card_exp expirey">
                                                                                                    </div>
                                                                                                </div>-->
                                                <div class="col-md-2 col-md-offset-1">
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
                                            </div>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <a class="btn apply btnPrevious" >PREV</a>
                                                </div>
                                                <div class="col-md-5"></div>
                                                <div class="col-md-3"><input style="margin-top:3px" type="submit" class="btn apply btnNext" name="save_profile" id="save_profile">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'shared/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $('.summernote').summernote();
        $.ajax({
            url: "<?php echo site_url("university/getProfileData"); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                if (response) {
                    var json = $.parseJSON(response);
                    $('#orgDesp').summernote('code', json.orgDesp);
                    $('#orgMission').summernote('code', json.orgMission);
                    $('#orgVission').summernote('code', json.orgVission);
                }

            }
        });
        $('#save_profile').click(function () {
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
                                    window.location = "<?php echo site_url("University/dashboard"); ?>";
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true, buttons: {
                                Ok: function () {

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
            $('#profile_form').ajaxForm(options);
        });

        getCountriesorg();
        function getCountriesorg() {
            $.ajax({
                url: "<?php echo site_url('Home/getCountriesJson'); ?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose Country</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].countryId + '">' + json[i].name + '</option>';
                    }
                    $('#orgcountryId').html(data);
                    $("#orgcountryId").val(<?php echo $countryId; ?>);
                }
            });
        }
        $('#orgcountryId').change(function () {
            var countryId = $('#orgcountryId').val();
            var selected_orgstateId = "";
            getcountryByStates(countryId, selected_orgstateId);
        });
        getcountryByStates(<?php echo $countryId; ?>,<?php echo $stateId; ?>);
        getStateByCity(<?php echo $stateId; ?>,<?php echo $cityId; ?>);
        function getcountryByStates(countryId, selected_orgstateId) {
            $.ajax({
                url: "<?php echo site_url('Home/getStatesByCountry'); ?>",
                type: 'POST',
                data: 'countryId=' + countryId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose State</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].stateId + '">' + json[i].name + '</option>';
                    }
                    //alert(data);
                    $('#orgstateId').html(data);
                    $('#orgstateId').val(selected_orgstateId);
                }
            });
        }
        $('#orgstateId').change(function () {
            var stateId = $('#orgstateId').val();
            var selected_orgcityId = "";
            getStateByCity(stateId, selected_orgcityId);
        });
        function getStateByCity(stateId, selected_orgcityId) {
            $.ajax({
                url: "<?php echo site_url('Home/getCityByStates') ?>",
                type: 'POST',
                data: 'stateId=' + stateId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose City</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].cityId + '">' + json[i].name + '</option>';
                    }
                    $('#orgcityId').html(data);
                    $('#orgcityId').val(selected_orgcityId);
                }
            });
        }
    });
</script>

<script>

    $('.btnNext').click(function () {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });


</script>