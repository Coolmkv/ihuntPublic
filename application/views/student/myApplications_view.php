<?php include_once 'student_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<style>
    .divcontainer {
        width: auto;
        margin: 10px -20px;
    }
    .progressbarenroll {
        counter-reset: step;
    }
    .progressbarenroll li {
        list-style-type: none;
        padding: 5px 4px;
        float: left;
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }
    .progressbarenroll li.active:before {
        content:'\2714';
    }
    .progressbarenroll li:before {
        width: 20px;
        height: 20px;		    color: red;
        content: '\2716';
        line-height: 17px;
        border: 2px solid red;
        display: block;
        text-align: center;
        margin: 0 auto 10px auto;
        border-radius: 50%;
        background-color: #f9f9f9;
    }
    .progressbarenroll li:after {
        width: 71%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -37%;
        z-index: 0;
    }
    .progressbarenroll li:first-child:after {
        content: none;
    }
    .progressbarenroll li.active {
        color: green;
    }
    .progressbarenroll li.active:before {
        border-color: #55b776;		color: #55b776;
    }
    .progressbarenroll li.active + li:after {
        background-color: #55b776;
    }</style>
<div class="content-wrapper">
<input type="hidden" name="url" id="url" value="<?php echo base_url('payment'); ?>"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            My Applications
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student'); ?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">View Application</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">My Applications</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Course Details</th>
                                                <th>Course Duration</th>
                                                <th>Fee Details</th>
                                                <th>Important Dates</th>
                                                <th>Application Date</th>
                                                <th>Application Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
 
               <div class="box-body " id="doc_upload" >
                            <div class="row">
                                <?php echo form_open_multipart('Student/uploadOrgDocs',["id"=>"form_doc_Submit","name"=>"form_doc_Submit"]);?>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <input type="hidden" class="hidden" name="fileUploadId" id="fileUploadId" value="no_id">
                                    <input type="hidden" class="hidden" name="OrgFileName" id="OrgFileName" value="">
                                    <label class="control-label">Document Upload:</label>
                                    <input type="file" accept="application/pdf,application/msword,
                                        application/vnd.openxmlformats-officedocument.wordprocessingml.document" name="documentUpload" id="documentUpload" class="form-control" data-validation="required">
                                </div>
                          <div class="form-group">
                    <!--<button class="btn btn-success" id="btn_upload" type="submit">Upload</button>-->
                </div>
                           
                                
                            </div>
                        </div>
						</div>

      <div class="modal-body">
	          <div class="col-lg-12 " style="padding:10px 10px;">
											
<div class="col-md-10 input_msg_write">
										  <textarea name="message" id="stu_msgId" class="write_msg" rows="3"  placeholder="Type the message for the student"></textarea>
										  </div>
					
						<div class="col-md-2 text-center buttn">
						<button name="sndbtn" type="submit" id="sndbtn" class="msg_send_btn btn-info "> <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
						</div>
						
						<input type="hidden" id="orgId" name="orgId" value="">
							<input type="hidden" id="studentId" value="<?php echo $_SESSION['studentId']; ?>" name="studentId">
							<input type="hidden" id="enrollmentId" name="enrollmentId" value="">
							<input type="hidden" id="msgFrom" name="msgFrom" value="<?php echo $_SESSION['studentName']; ?>">
							<input type="hidden" id="msgTo" name="msgTo" value="">
							</div>
								   
		<div class="mesgs">
         <div class="msg_history">
		 

      
         </div>
         
       </div>
	
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  
</div>
  </div>
  </div>
 <?php echo form_close();?>  

<?php include_once 'student_footer.php'; ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

    $(".myApplLink").addClass("active");
    document.title = "iHuntBest | My Applications";

    dataTable();
    function dataTable() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("Student/mgetMyApplication"); ?>",
            data: {},
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#details_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {	
var orgName="'"+json[i].orgName+"'";				
var courseName="'"+json[i].courseName+"'";	
var org_account_id="'"+json[i].org_account_id+"'";	
var org_email="'"+json[i].email+"'";	
var org_splitpayment_status="'"+json[i].org_splitpayment_status +"'";	
var org_percentage= "'"+json[i].org_percentage+"'";	
	
var amt=	json[i].registrationFee+'+'+json[i].courseFee;	
                    oTable.fnAddData([
                        (i + 1),
						
                        json[i].courseName + '(' + json[i].courseType + ') ' + json[i].departmentName+'<br><div class=""><button class="btn btn-info" onclick="showMsg('+json[i].enrollmentId+','+json[i].id+','+orgName+')" data-toggle="modal" data-target="#myModal">Check Message</button></div>',
                        json[i].timeDuration + ' ' + json[i].courseDurationType,
                        '<br> Reg Fee : ' + json[i].registrationFee + '<br> Course Fee : ' + json[i].courseFee,
                        'Application Opening : ' + (json[i].openingDate ? json[i].openingDate : "NA") +
                                '<br>Application Closing : ' + (json[i].closingDate ? json[i].closingDate : "NA")
                                + '<br>Exam Date: ' + (json[i].examDate ? json[i].examDate : "NA"),
                        json[i].applicationDate,
                        (json[i].status === "Enrolled" ? '<div class="divcontainer"><ul class="progressbarenroll"><li class="active">Enrolled</li><li class="active">InProcess</li></ul></div>'
                                :  (json[i].status === "Accepted" ? '<div class="divcontainer text-center"><ul class="progressbarenroll"><li class="active">Enrolled</li><li class="active">Accepted</li></ul><br><button class="btn btn-info" id="'+json[i].enrollmentId+'" onclick="payfee('+json[i].enrollmentId+','+amt+','+orgName+','+courseName+','+org_account_id+','+json[i].id+','+org_percentage+','+org_splitpayment_status+','+org_email+')">Pay Fee Now</button></div>' :'<div class="divcontainer"><ul class="progressbarenroll"><li class="active">Enrolled</li><li>Rejected</li></ul></div>'))
								
                    ]);
                }
            }, error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }
	
	function payfee(eid,amt,orgname,cname,org_account_id,orgId,org_percentage,org_splitpayment_status,org_email)
	{
		//alert("hello");
		//alert(eid);
		//alert(amt);
		var enrollmentId = eid;
		var orgaccount_id = org_account_id;
		var orgpercentage = org_percentage;
		var org_splitpay_status = org_splitpayment_status;
		var orgemail = org_email;
	
		var total = amt*100;
		var orgamt = amt;
		var key_id = "<?php echo RAZOR_KEY_ID; ?>";
		var org_name = orgname;
		var course_name  = cname;
		//alert(cname);
		var pagecall = jQuery("#url").val();
		
		var currency_code_id = "INR";
		var razorpay_options = {
        key: key_id,
        amount: total,
        name: org_name,
        description: course_name,
        netbanking: true,
        currency: currency_code_id,
        handler: function (transaction) {
            jQuery.ajax({
                url: pagecall,
                type: 'post',
                data: {razorpay_payment_id: transaction.razorpay_payment_id,merchant_total: total,currency_code_id: currency_code_id,enrollmentId : enrollmentId,orgaccount_id : orgaccount_id,orgId:orgId,orgpercentage : orgpercentage,org_splitpay_status:org_splitpay_status,orgemail:orgemail,org_name:org_name}, 
                dataType: 'json',
                success: function (res) {
					console.log(res);
					$('#'+eid).hide();
                    if(res.msg){
                        alert(res.msg);
						
                        return false;
                    } 
                    //window.location = res.redirectURL;
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
	}
	

	
	
function showMsg(eId,orgId,orgName){
	
	 $('#orgId').val(orgId); 
		$('#enrollmentId').val(eId);
		$('#msgTo').val(orgName);
		
		
            $.ajax({
                type: "POST",
                data: {eId: eId},
                url: "<?php echo site_url('Student/showMsg'); ?>",
                success: function (response) {
					console.log(response);
                    var json = $.parseJSON(response);
						$(".msg_history").html("");
					var from_name=$('#msgFrom').val(); 
					if(jQuery.isEmptyObject( json )){
					$(".msg_history").append('<li style="text-align:center;list-style-type:none;font-size: 22px;">No messages to show</li>');
						
					}
					else{
						for (var i = 0; i < json.length ; i++) {
							
									if(json[i].docAttachment == '' ){
								var attach = '';
							}
							else{
								var attach='Find Attachment';
							}
						
							if(json[i].msgFrom == from_name)
							{
							
					    if(json[i].status=='Approved'){
						var status='<b style="color:greenyellow;"> '+json[i].status+'</b>'; }
						else if(json[i].status=='Rejected') {
						var status='<b style="color:#860101;"> '+json[i].status+'</b>';}
						else if(json[i].status=='pending'){
						var status='<b style="color:#0a175a;"> '+json[i].status+'</b>';}
						 $(".msg_history").append('<div class="outgoing_msg"><div class="sent_msg"> <p>'+json[i].msg+'&nbsp;&nbsp;<br><a href="<?php echo base_url(); ?>'+json[i].docAttachment+'">'+attach+'</a><span class="time_date"> '+json[i].createdDate+'&nbsp;&nbsp;('+status+')</span></p></div></div>');
						}
							else if(json[i].msgFrom == "Admin"){
									
							$(".msg_history").append('<div class="incoming_msg"> Message From <b style="color:darkRed;">'+json[i].msgFrom +'</b> <div class="received_msg"> <div class="received_withd_msg"> <p>'+json[i].msg+'&nbsp;&nbsp;<br><a href="<?php echo base_url(); ?>'+json[i].docAttachment+'">'+attach+'</a><span class="time_date"> '+json[i].createdDate+'</span></p></div> </div></div>');
							}
							else
							{
							$(".msg_history").append('<div class="incoming_msg"> Message From <b style="color:darkbBlue;">'+json[i].msgFrom +'</b> <div class="received_msg"> <div class="received_withd_msg"> <p>'+json[i].msg+'&nbsp;&nbsp;<br><a href="<?php echo base_url(); ?>'+json[i].docAttachment+'">'+attach+'</a><span class="time_date"> '+json[i].createdDate+'</span></p></div> </div></div>');
						}
						}
						}
}
});
}

			
			$('#form_doc_Submit').submit(function()
			{
		  var orgId=$('#orgId').val();
		  var studentId=$('#studentId').val();
		  var enrollmentId=$('#enrollmentId').val();
		  var msg=$('#stu_msgId').val();
		  var msgFrom = $('#msgFrom').val();
		  var msgTo =	$('#msgTo').val();
		 if (orgId === "" || studentId === "" || enrollmentId === "" || msg === "" || msgFrom === "" || msgTo === "") {
	
                $.alert({
                    title: 'Error!', content: "Message is required", type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            //window.location.reload();
                        }
                    }
                });
            } else {
		    $.ajax({
                    url: "<?php echo site_url('Student/uploadOrgDocs'); ?>",
                    type: "POST",
					data:new FormData(this),
					contentType:false,
					cache:false,
					processData:false,
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json.status === 'success') 
						{
                            $.alert({title: 'Success!', content: json.msg, type: 'blue',
                                typeAnimated: true,
                                buttons: {
                                    Ok: function () {
                                        $('#stu_msgId').val('');
                                    }
                                }
                            });
                        } else {
                            $.alert({title: 'Error!', content: json.msg, type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    Ok: function () {
                                        window.location.reload();
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
			
                });
				
			
			}	
			return false;
	  });

</script>
