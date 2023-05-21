<?php include_once 'home/shared/header.php'; 

if($this->session->userdata('amount')){
	 $amount = $this->session->userdata('amount');
	$order_id = $this->session->userdata('order_id');
	$razorpay_payment_id = $this->session->userdata('razorpay_payment_id');
	$currency_code = $this->session->userdata('currency_code');
	$student_id=$_SESSION['studentId'];
	$status = 1;
	$org_id=$this->session->userdata('org_id');
	$course_id=$this->session->userdata('course_id');
	$course_s_id=$this->session->userdata('course_s_id');
	$orgType=$this->session->userdata('orgType');
	
	 $this->Home_model->mEnrollNow();

	// $this->Home_model->payment_info($amount,$order_id,$razorpay_payment_id,$currency_code,$student_id,$status,$org_id,$course_id,$course_s_id,$orgType);
	
	
	
	$array_items = array('amount','order_id','razorpay_payment_id', 'currency_code','org_id', 'course_id','orgType','course_s_id');

$this->session->unset_userdata($array_items);  
	
} 

?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<!--<script src="<?php // echo base_url('js/jquery.min.js');                                                                                                                                                                                                                                                                                                                                   ?>" type="text/javascript"></script>

<script src="<?php // echo base_url();                                                                                                                                                                                                                                                                                                                                   ?>plugins/jQuery/jquery-3.2.1.min.js"></script>-->



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

<?php include 'js/location.js'; ?>

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACimPVNI1GUVZIfy5HA342kjuq7grLzS0&libraries=places&callback=initAutocomplete"

async defer></script>

<script>

    document.title = 'iHuntBest | Home Page';

    function imgError(ele) {

        ele.onerror = "";

        console.log(ele);

        ele.src = '<?php echo base_url('homepage_images/default.png'); ?>';



        return true;





    }

    $(document).ready(function () {

        $("#slider").slider({

            min: 1000,

            max: 100000,

            step: 1,

            values: [10, 900],

            slide: function (event, ui) {

                for (var i = 0; i < ui.values.length; ++i) {

                    $("input.sliderValue[data-index=" + i + "]").val(ui.values[i]);

                }

            }

        });



        $("input.sliderValue").change(function () {

            var $this = $(this);

            $("#slider").slider("values", $this.data("index"), $this.val());

        });

        $("#sliderCollege").slider({

            min: 1000,

            max: 100000,

            step: 1,

            values: [10, 900],

            slide: function (event, ui) {

                for (var i = 0; i < ui.values.length; ++i) {

                    $("input.sliderValueCollege[data-index=" + i + "]").val(ui.values[i]);

                }

            }

        });



        $("input.sliderValueCollege").change(function () {

            var $this = $(this);

            $("#sliderCollege").slider("values", $this.data("index"), $this.val());

        });

        $("#sliderInstitute").slider({

            min: 1000,

            max: 100000,

            step: 1,

            values: [10, 900],

            slide: function (event, ui) {

                for (var i = 0; i < ui.values.length; ++i) {

                    $("input.sliderValueInstitute[data-index=" + i + "]").val(ui.values[i]);

                }

            }

        });



        $("input.sliderValueInstitute").change(function () {

            var $this = $(this);

            $("#sliderInstitute").slider("values", $this.data("index"), $this.val());

        });

        $("#sliderSchool").slider({

            min: 1000,

            max: 100000,

            step: 1,

            values: [10, 900],

            slide: function (event, ui) {

                for (var i = 0; i < ui.values.length; ++i) {

                    $("input.sliderValueSchool[data-index=" + i + "]").val(ui.values[i]);

                }

            }

        });



        $("input.sliderValueSchool").change(function () {

            var $this = $(this);

            $("#sliderSchool").slider("values", $this.data("index"), $this.val());

        });

    });

</script>

<section class="showcase">
   <div class="container">
    <div class="text-center">
      <h1 class="display-3">Thank You!</h1>
      <p class="lead">Your payment has been received successfully.</p>
      <hr>
      <p>
        Having trouble? <a href="mailto:contact@webhaunt.com">Contact us</a>
      </p>
      <p class="lead">
        <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>" role="button">Continue to homepage</a>
      </p>
    </div>
    </div>
</section>
<br><br><br><br><br><br>
<?php

include_once 'home/shared/footer.php';?>