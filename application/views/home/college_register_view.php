<?php include_once 'shared/header.php'; ?>
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
<script>
    function imgError(ele) {
        ele.onerror = "";
        console.log(ele);
        ele.src = '<?php echo base_url('homepage_images/default.png'); ?>';

        return true;
    }
    $(function () {
        $('html, body').animate({
            'scrollTop': $(".before-you-begin").position().top
        });
    });
</script>
<div class="bg-color">
    <div class="container before-you-begin">
        <div class="card content-header">
            <h2>Register as College</h2>
        </div>
        <div class="breadcrumbs">
            <a href="#">Home</a>
            <a href="#">Before You Begin</a>
        </div>
        <div class="bg-white">
            <div class="col-md-12">
                <div class="job-t">
                    <h3>Before you Begin</h3>
                    <?php
                    if (isset($beforeYouBegin)) {
                        echo $beforeYouBegin->bybText;
                    } else {
                        ?>
                        <ul>
                            <li style="color:Red"> Please note that the Accreditation &amp; Affiliation awarded to a Training Centre does not make it auto eligible for PMKVY targets.</li>
                            <li> The information you feed in the TP Registration Form should be complete and correct in all respect. Post the submission of the Form, it will be reviewed by SMART Team. You will be given time to complete the deficiencies in the Form, if any. Please note that the payment made by you will NOT be Refunded. </li>
                            <li> Please ensure that you have uninterrupted Internet connection while you are filling this online application.</li>
                            <li> You will need to upload certain documents as proof of the data provided, the documents you are uploading should be self attested. Please ensure that the soft copies of the following documents are readily available with you:
                                <ul>
                                    <li>Certificate of Incorporation/ Registration of your organization </li>
                                    <li>Proof of annual turnover of your organization in the form of a Chartered Accountant certificate, for the last 3 years if incorporated in the year 2014 or before, for the last 2 years if incorporated in 2015, for the last 1 year if incorporated in 2016. This is not mandatory for organizations incorporated in the year 2017</li>

                                    <li>Permanent Account Number (PAN) of your organization</li>

                                    <li>Address proof of your Head/ Registered office (Incorporation Certificate/ Telephone Bill/ Electricity Bill/ Service Tax Registration)</li>
                                </ul>
                            </li>
                            <li>
                                You will need to make the online payment of INR 10,000 for the successful submission of the Training Provider Registration Form. Please ensure you have details of the Credit Card/ Debit Card/ Net Banking ready with you.</li>
                        </ul><?php } ?>
                    <div class="form-group">
                        <span class="type-3">
                            <a href="<?php echo site_url('college/registerform'); ?>" class="apply">Proceed to Registration Form <i class="fa fa-arrow-right"></i></a>                                                                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'shared/footer.php';
