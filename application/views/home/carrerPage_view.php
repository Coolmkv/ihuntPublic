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
    document.title  =   'iHuntBest | Career With Us';
</script>
<div class="bg-color">
    <div class="container">
        <div class="col-md-12">
            <div class="heading">
                <h2>Career With Us</h2>
                <span class="bott-img"><img src="<?php echo base_url('images/head.png');?>"></span>
            </div>
        </div>
    </div>
    <div class="container  mar-top">
        <div class="col-md-6">
            <div class="faq-text">
                <h2>Current Openings</h2>
            </div> 
            <?php if(isset($openingDetails)){
                    foreach ($openingDetails as $od){
                        echo '<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand">
                                        <div class="right-arrow pull-right">+</div>
                                            <a href="#">'.$od->openingTitle.'</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body">'.$od->openingDetails.'</div>
                                </div>
                            </div>';
                    }
        }else{            echo 'No data available';}?>
        </div>
        <div class="col-md-6">
            <div class="faq-text">
                <h2>Application Form</h2>
                <?php echo form_open_multipart("home/applyForJob",["id"=>"form_details"]);?>
                <div class="form-group col-md-6" style="margin: 0px;">
                    <label for="firstName">First Name <span class="asterisk">*</span></label>
                    <input type="text" id="firstName" class="form-control" name="firstName" data-validation="required">
                </div>
                <div class="form-group col-md-6" style="margin: 0px;">
                  <label for="lastName">Last Name <span class="asterisk">*</span></label>
                  <input type="text" id="lastName" class="form-control" name="lastName" data-validation="required">
                </div>
                <div class="form-group col-md-6" style="margin: 0px;">
                  <label for="email">Email <span class="asterisk">*</span></label>
                  <input type="email" id="email" class="form-control" name="email" data-validation="required">
                </div>
                <div class="form-group col-md-6" style="margin: 0px;">
                  <label for="phone">Phone <span class="asterisk">*</span></label>
                  <input type="text" minlength="10" maxlength="10" id="phone" class="form-control numOnly" name="phone" data-validation="required">
                </div>
                <div class="form-group col-md-12 nopadding" style="margin: 0px;">
                  <label for="openingId">Job Opening <span class="asterisk">*</span></label>
                  <select class="form-control" data-validation="required" name="openingId" id="openingId">
                      <option value="">Select</option>
                      <?php if(isset($openingDetails)){
                                foreach ($openingDetails as $od){
                                    echo '<option value="'.$od->openingId.'">'.$od->openingTitle.'</option>';
                                }
                            } ?>
                  </select>
                </div>
                <div class="form-group col-md-12 nopadding" style="margin: 0px;">
                  <label for="resumeFile">Resume/CV <span class="asterisk">*</span></label>
                  <input type="file" id="resumeFile" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" 
                                        class="form-control"   name="resumeFile" data-validation="required">
                </div>
                <div class="form-group col-md-12 nopadding" style="margin: 0px;">
                  
                    <input type="submit" class="apply" id="save_details" value="Apply Now">
                 
                </div>
                <?php echo form_close(); ?>
            </div> 
        </div>
        
    </div>
</div>
<script>
 
$(document).ready(function(){
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
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#form_details').ajaxForm(options);
        });
});
</script>
<?php  include_once 'shared/footer.php'; 