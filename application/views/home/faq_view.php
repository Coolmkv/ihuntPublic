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
</script>
<div class="bg-color">
    <div class="container">
        <div class="bg-de-college">
            <div class="faq-text">
                <h2>Frequently Asked Questions</h2>
                    <ul class="nav nav-tabs">
                        <?php if(isset($faqCat)){
                                $i=1;
                                foreach ($faqCat as $fc){
                                    echo '<li '.($i==1?'class="active"':'').'><a href="#tab'.$i.'" data-toggle="tab">'.$fc->categoryName.'</a></li>';
                                    $i++;
                                }
                        }?>
                    </ul>
            </div>
            <div class="tab-content">
                <?php  if(isset($faqCat)){
                                $i=1;
                        foreach ($faqCat as $fc){
                            echo '<div class="tab-pane fade in '.($i==1?'active':'').'" id="tab'.$i.'">
                                                    <div class="panel-group" id="accordion'.$i.'">';
                            if(isset($faq)){
                                $j=1;
                                foreach($faq as $fq){
                                    if($fc->faqCategoryId==$fq->faqCategoryId){      
                                                echo '<div class="panel panel-default">
                                                            <div class="panel-heading">
                                                              <h4 data-toggle="collapse" data-parent="#accordion'.$i.'" href="#collapse'.$i.$j.'" accname="'.$i.$j.'" aria-expanded="false" class="panel-title expand">
                                                                 <div class="right-arrow pull-right circleicon" id="expandIcon'.$i.$j.'"><i class="fa fa-plus-circle"></i></div>
                                                                <a href="#">'.$fq->faqQuestion.'</a>
                                                              </h4>
                                                            </div>
                                                            <div id="collapse'.$i.$j.'" class="panel-collapse collapse">
                                                                  <div class="panel-body">'.$fq->faqAnswer.'</div>
                                                            </div>
                                                        </div>
                                                    ';
                                                
                                    }
                                    $j++;
                                }
                            }
                            echo '</div>
                                </div>';
                            $i++;
                        }
                        }else{
                            echo 'No data.';
                        }?>
            </div>
        </div>
        
    </div>
</div>

<script>
    document.title  =   'iHuntBest | FAQ\'s'; 
     
    $(function() {
    $(".expand").on( "click", function() {
        var idc =   $(this).attr('accname');
        $(".circleicon").html('<i class="fa fa-plus-circle"></i>');
        if($(this).attr('aria-expanded')==='true'){
             $("#expandIcon"+idc).html('<i class="fa fa-plus-circle"></i>');
        }else{
            $("#expandIcon"+idc).html('<i class="fa fa-minus-circle"></i>'); 
        }
        
        
    });
});
</script>    
<?php  include_once 'shared/footer.php'; 