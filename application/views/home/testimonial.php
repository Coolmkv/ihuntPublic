<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/4/2018
 * Time: 4:01 PM
 */

include_once 'shared/header.php'; ?>
    <script src="<?php echo base_url( 'js/jquery.min.js' ); ?>" type="text/javascript"></script> <!--
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>-->

    <script src="<?php echo base_url( 'js/amazon_scroller.js' ); ?>" type="text/javascript"></script>
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
            ele.src = '<?php echo base_url( 'homepage_images/default.png' );?>';

            return true;


        }
    </script>
    <div class="bg-color">
        <div class="container">
            <div class="col-md-12">
                <div class="heading animated fadeInUp" data-appear-top-offset="-200" data-animated="fadeInUp">
                    <h2>Testimonials</h2>
                    <span class="bott-img"><img src="<?php echo base_url('images/head.png');?>"></span>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="bg-de-college co-to-se">
                <div class="row">
                    <div class="col-md-12">
						<?php if ( isset( $testimonial ) ) {
							foreach ( $testimonial as $tst ) {
								?>
                                <div class="testiminial-block">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2"><img src="<?php echo $tst->userImage;?>"
                                                                            class="img-responsive img-circle"/></div>
                                        <div class="col-md-10 col-sm-10 testimonial-content">
                                            <h3><?php echo $tst->userHeadline;?></h3>
	                                        <?php echo $tst->userText;?>
                                            <div class="testimonial-author">
	                                            <?php echo $tst->userName;?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
							<?php }
						} ?>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.title = 'iHuntBest | Testimonials';

    </script>
<?php include_once 'shared/footer.php';