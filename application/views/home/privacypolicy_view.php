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
</script>
<div class="bg-color">
    <div class="container">
        <div class="col-md-12">
            <div class="heading">
                <h2>Our Privacy Policy</h2>
                <span class="bott-img"><img src="<?php echo base_url('images/head.png'); ?>"></span>
            </div>
        </div>
    </div>
    <div class="container  mar-top">
        <div class="col-md-12">
            <div class="head-add">
                <h4>Privacy Policy</h4>
                <?php
                if (isset($privacypolicy)) {
                    echo $privacypolicy;
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'shared/footer.php';
