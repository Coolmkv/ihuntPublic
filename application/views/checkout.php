<script src="<?php echo base_url('js/jquery.min.js'); ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('js/amazon_scroller.js'); ?>" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>plugins/jQuery/jquery.form.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>js/app.min.js"></script>

<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>

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

<div class="container">
<br>
<h2 class="text-center">Join The Course</h2><br>
<?php //echo($enrollNow->CourseDetails); ?>
<pre>
<?php $course = $CourseInfo['CourseDetails']; 
// $OrgInfo
?>
</pre>
<form name="razorpay_frm_payment" class="razorpay-frm-payment" id="razorpay-frm-payment" method="post">
<input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo uniqid();
?>"> 
<input type="hidden" name="language" value="EN"> 
<input type="hidden" name="amount" id="amt" value="<?php echo $course->ApplicationFee; ?>"> 
<input type="hidden" name="currency" id="currency" value="<?php echo $course->defaultCurrency; ?>">
 <input type="hidden" name="url" id="url" value="<?php echo base_url('callback'); ?>"> 
 <input type="hidden" name="org_id" id="org_id" value="<?php echo $ordId; ?>"> 
 <input type="hidden" name="course_id" id="course_id" value="<?php echo $orgCourseId; ?>"> 
 <input type="hidden" name="course_s_id" id="course__s_id" value="<?php echo $courseId; ?>"> 
 <input type="hidden" name="orgType" id="orgType" value="<?php echo $orgType; ?>"> 

<input type="hidden" name="cname" id="cname" value="<?php echo $course->courseTitle; ?>"> 
<input type="hidden" name="oname" id="oname" value="<?php echo $OrgInfo->orgName; ?>"> 
<input type="hidden" name="surl" id="surl" value="<?php echo base_url('payment_success'); ?>"> 
<input type="hidden" name="furl" id="furl" value="<?php echo base_url('payment_failure'); ?>"> 

<?php 
/* echo "<pre>";
print_r($course);
echo "</pre>"; */
?>

	<table id="cart" class="table table-hover table-condensed" >
    				<thead >
						<tr>
							<th style="width:17%"><b>Course Name</b></th>
							<th style="width:18%"><b>Organization Name</b></th>
							<th style="width:15%" class="text-center"><b>Course Duration<b></th>
							<th style="width:20%"><b>Application Fees</b></th>
							<th style="width:10%"><b>Total Amount</b></th>
							<th style="width:20%"></th>
						</tr>
					</thead>
					<tbody>
				<?php 	
		
		
				// foreach($data as $key=>$element)
				?>
						<tr>
							<td data-th="course">
								<div class="row">
									<div class="col-sm-10">
										<h4 class="nomargin">
										<?php echo $course->courseTitle; ?></h4>			
									</div>
								</div>
							</td>
							<td data-th="organization"><h4 class="nomargin"><?php echo $OrgInfo->orgName; ?></h4></td>
							<td data-th="duration" class="text-center"><h4 class="nomargin"><?php echo $course->CourseDuration; ?></h4></td>
							<td data-th="fees">
								<h4 class="nomargin"><?php echo $course->ApplicationFee; ?></h4>
							</td>
							<td data-th="total">
								<h4 class="nomargin"><?php echo $course->ApplicationFee.'('.$course->defaultCurrency.')'; ?></h4>
							</td>
							<td class="actions" data-th="">
								<a href="<?php echo base_url(); ?>" class="btn btn-warning"><i class="fa fa-angle-left"></i> Go Back</a>								
							</td>
						</tr>
					</tbody>
					<tfoot>
						
						<tr>
							
							<td colspan="2" class="hidden-xs"></td>
							<td><button  id="razor-pay-now" class="btn btn-success">Checkout<i class="fa fa-angle-right"></i></</button></td>
						</tr>
					</tfoot>
				</table>
				</form>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">

  jQuery(document).on('click', '#razor-pay-now', function (e) {
    var total = (jQuery('form#razorpay-frm-payment').find('input#amt').val()*100);
    var orgamt = jQuery('form#razorpay-frm-payment').find('input#amt').val();
    var org_id = jQuery('form#razorpay-frm-payment').find('input#org_id').val();
    var course_id = jQuery('form#razorpay-frm-payment').find('input#course_id').val();
    var course_s_id = jQuery('form#razorpay-frm-payment').find('input#course__s_id').val();
	console.log(orgamt);
    var merchant_order_id = jQuery('form#razorpay-frm-payment').find('input#merchant_order_id').val();
	console.log(merchant_order_id);
    var merchant_surl_id = jQuery('form#razorpay-frm-payment').find('input#surl').val();
    var merchant_furl_id = jQuery('form#razorpay-frm-payment').find('input#furl').val();
    //var card_holder_name_id = jQuery('form#razorpay-frm-payment').find('input#billing-name').val();
    var merchant_total = total;
	console.log(merchant_total);
    //var merchant_amount = jQuery('form#razorpay-frm-payment').find('input#amount').val();
    var currency_code_id = jQuery('form#razorpay-frm-payment').find('input#currency').val();
    var key_id = "<?php echo RAZOR_KEY_ID; ?>";
    var course_name = jQuery('form#razorpay-frm-payment').find('input#cname').val();
    var org_name = jQuery('form#razorpay-frm-payment').find('input#oname').val();
	var orgType = jQuery('form#razorpay-frm-payment').find('input#orgType').val();
    //var store_description = 'Payment';
   
    //var email = jQuery('form#razorpay-frm-payment').find('input#billing-email').val();
    //var phone = jQuery('form#razorpay-frm-payment').find('input#billing-phone').val();
    
    jQuery('.text-danger').remove();

    /* if(card_holder_name_id=="") {
      jQuery('input#billing-name').after('<small class="text-danger">Please enter full mame.</small>');
      return false;
    } */
    /* if(email=="") {
      jQuery('input#billing-email').after('<small class="text-danger">Please enter valid email.</small>');
      return false;
    }
    if(phone=="") {
      jQuery('input#billing-phone').after('<small class="text-danger">Please enter valid phone.</small>');
      return false;
    } */
    var pagecall = jQuery('form#razorpay-frm-payment').find('input#url').val();;
	console.log(pagecall);
    var razorpay_options = {
        key: key_id,
        amount: merchant_total,
        name: org_name,
        description: course_name,
        netbanking: true,
        currency: currency_code_id,
        handler: function (transaction) {
            jQuery.ajax({
                url: pagecall,
                type: 'post',
                data: {razorpay_payment_id: transaction.razorpay_payment_id, merchant_order_id: merchant_order_id, merchant_surl_id: merchant_surl_id, merchant_furl_id: merchant_furl_id,merchant_total: merchant_total,currency_code_id: currency_code_id,course_id:course_id,org_id:org_id,orgType:orgType,course_s_id:course_s_id}, 
                dataType: 'json',
                success: function (res) {
					console.log(res);
                    if(res.msg){
                        alert(res.msg);
                        return false;
                    } 
                    window.location = res.redirectURL;
                }
            });
        },
        "modal": {
            "ondismiss": function () {
                // code here
            }
        }
    };
    // obj        
    var objrzpv1 = new Razorpay(razorpay_options);
    objrzpv1.open();
        e.preventDefault();
            
});
</script>