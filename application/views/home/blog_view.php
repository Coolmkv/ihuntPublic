<?php include_once 'shared/header.php'; ?>
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
                    <h2>Latest Blogs</h2>
                    <span class="bott-img"><img src="<?php echo base_url('images/head.png');?>"></span>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="bg-de-college co-to-se">
                <div class="row">
                    <div class="col-md-12 testiminial-block">
                        <div class="col-md-5">
                            <select class="form-control">
                                <option value="choose">Choose Category</option>
								<?php if ( isset( $blogCat ) ) {
									foreach ( $blogCat as $cat ) {
										?>
                                        <option value="<?php echo $cat->catId?>"><?php echo $cat->catName; ?></option>
									<?php }
								} ?>
                            </select>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" placeholder="Enter Search Keywords..">
                        </div>
                        <div class="col-md-1">
                            <input class="btn btn-success" type="button" value="Search"></div>
                    </div>
                    <div class="col-md-12">
	                    <?php if ( isset( $blogs ) ) {
	                    foreach ( $blogs as $bgs ) {
	                    ?>
                        <div class="col-md-12 testiminial-block">
                            <div class="col-md-3">
                                <div class="b-img"><img src="<?php echo base_url('images/login-bg.jpg');?>"/></div>
                            </div>
                            <div class="col-md-9">
                                <div class="b-text">
                                    <h1><?php echo $bgs->blogTitle ?></h1>
	                                <?php echo $bgs->blogDesp ?>
                                </div>
                                <div class="pull-right"><span class="badge">Date & Time: <?php echo $bgs->updatedAt ?></span>
                                    <div class="pull-right"></div>
                                </div>
                                <div class="pull-left"><span class="badge">Posted By: Admin</span>
                                    <div class="pull-left"></div>
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
        document.title = 'iHuntBest | Blogs';

    </script>
<?php include_once 'shared/footer.php';