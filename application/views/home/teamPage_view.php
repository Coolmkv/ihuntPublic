<?php include_once 'shared/header.php'; ?>
<script src="<?php echo base_url('js/jquery.min.js');?>" type="text/javascript"></script> <!--
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>-->

    <script src="<?php echo base_url('js/amazon_scroller.js');?>" type="text/javascript"></script>
<!--    
<script src="<?php echo base_url(); ?>plugins/lightgallery/js/lightgallery-all.min.js" type="text/javascript"></script>  -->
    <!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>plugins/jQuery/jquery.form.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/app.min.js"></script> 
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!--<script src="<?php echo base_url(); ?>plugins/imagesLoaded.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/gallery.js" type="text/javascript"></script> -->
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script>
function imgError(ele){
         ele.onerror = "";
         console.log(ele);
         ele.src =   '<?php echo base_url('homepage_images/default.png');?>';
          
         return true;
          
        
    }
    document.title  =   'iHuntBest | Our Team';
</script>
<div class="bg-color">
    <div class="container">
        <div class="col-md-12">
            <div class="heading">
                <h2>Our Management Team</h2>
                <span class="bott-img"><img src="<?php echo base_url('images/head.png');?>"></span>
            </div>
        </div>
    </div>
    <div class="container  mar-top">
        <?php if(isset($teamdata)){
                    foreach ($teamdata as $td){
                        echo '<div class="col-md-6">
            <div class="team">
                <span class="team-pic">
                    <img src="'.base_url($td->memberImage).'"/>
                    <div class="social-team">
                        <ul>
                        <li><a href="'.$td->memberFbLink.'"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                        <li><a href="'.$td->memberTtLink.'"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                        <li><a href="'.$td->memberGpLink.'"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </span>
                <span class="des-img">
                    <div class="r-f-text">
                        <ul>
                            <li><i style="font-size:18px;" class="fa fa-user" aria-hidden="true">&nbsp;'.$td->memberName.'</i></li>
                            <li><i class="fa fa-briefcase" aria-hidden="true">&nbsp;'.$td->position.'</i></li>
                            <li><i class="fa fa-envelope" aria-hidden="true">&nbsp;'.$td->memberEmail.'</i></li>
                            <p class="de-team">'.$td->aboutMember.'</p>
                        </ul>
                    </div>
                </span>
            </div> 
        </div>';
                    }
        }else{            echo 'No data available';}?>
        
    </div>
</div>

<?php  include_once 'shared/footer.php'; 