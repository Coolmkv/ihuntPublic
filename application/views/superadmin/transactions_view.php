<?php include_once 'superadmin_header.php'; ?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            Transactions

            <!--<small>Optional description </small>-->

        </h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>

            <li class="active">Transactions</li>

            <li class="active">View Transactions</li>

        </ol>

    </section>                <!-- Main content -->

    <section class="content">

        <div class="row">

            <div class="row box-body">

                <div class="col-md-12">

                    <!-- general form elements -->

                    <div class="box box-primary">

                        <div class="box-header with-border">

                            <h3 class="box-title">Transactions List</h3>

                        </div>

                        <div class="box-body">

                            <div class="row">

                                <div class="col-md-12">

                                    <table id="details_table" class="table table-bordered table-striped table-responsive">

                                        <thead>

                                            <tr>

                                                <th>S. No.</th>
												
												<th>Enrollment Id</th>
												
												<th>Payment Id</th>
												
												<th>Student Name</th>
												
												<th>Organization Amount</th>
												
												<th>ihunt Amount</th>

												<th>Organization Name</th>
												
												<th>Fees Category</th>
												
												<th>Created At</th>
                                               

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
			
 
 <div class="bg-color bg-color-3">
            <div class="container-fluid">
                <div class="row" style="border: solid 1px #faa71a;   border-radius: 6px;">
             <div class="modal" id="studentModal" role="dialog" style="z-index: 99999">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content enrollModalshadow">
                                <div class="modal-body">
                                    <div class="container-fluid nopadding">
                                        <div class="row" style="border: solid 1px #faa71a;   border-radius: 6px;">
                                            <div class="col-md-12" style="padding: 10px 0px; background: #ececec;">
                                                <div class="col-md-3 nopadding text-center">
                                                    <img  id="en_collegelogo" src=""/ height="100px" width="100px">
                                                </div>
                                                <div class="col-md-6 r-login nopadding">
                                                    <form>
                                                        <div class="col-md-12 text-center">
                                                            <div class="col-md-12" style="padding: 10px;" >
                                                                <h4 id="en_collegename"></h4>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 3px;">
                                                                <h6 id="en_collegeaddress"></h6>
                                                            </div>
                                                            <h6  id="approvedById"></h6>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-2 nopadding text-center">
                                                    <img   id="enqLogo" src="<?php echo base_url('images/logo.png'); ?>"/>
                                                </div>
                                                <div class="col-md-1 closediv"><span id="closestudentModal"><i class="fa fa-times fa-1x" id="closesign" ></i></span></div>
                                            </div>
											
											
	  
    </div>
                                            <div class="col-lg-12 nopadding">
                                                <fieldset>
												
                                                    <div class="col-lg-12 text-center nopadding">
                                                        <h4 class="enrollnowlabels" style=" margin-bottom:10px;">Application Form</h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-2 text-center col-sm-12 nopadding">
                                                            <img src="" class="img-thumbnail" onerror="this.src='<?php echo base_url('homepage_images/default.png'); ?>'" id='studentImageenroll'>
                                                        </div>
                                                        <div class="col-lg-10 nopadding">
                                                            <div class="col-md-12 nopadding">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="col-md-4 control-label" for="textinput">Name</label>
                                                                        <div class="col-md-8">
                                                                            <input  name="textinput" id="en_name_id" type="text" placeholder="Name" class="form-control input-md" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="col-md-4 control-label" for="textinput">Birthday</label>
                                                                        <div class="col-md-8">
                                                                            <input id="en_birthday_id" name="textinput" type="Date" placeholder="Birthday" class="form-control input-md" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-md-4 control-label" for="textinput">Father</label>
                                                                    <div class="col-md-8">
                                                                        <input id="en_father_id" name="textinput" type="text" placeholder="Father" class="form-control input-md" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="textinput">Place Of Birth</label>
                                                            <div class="col-md-8">
                                                                <input id="en_placeofb_id" name="textinput" type="text" placeholder="Place Of Birth" class="form-control input-md" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="filebutton">Nationality</label>
                                                            <div class="col-md-8">
                                                                <input id="en_nationality_id" name="filebutton" class="form-control input-md" placeholder="Nationality" type="text" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                             <label class="col-md-4 control-label" for="textinput">Religion</label>
                                                            <div class="col-md-8 ">
                                                                <select name="religion" id="religion_id" class="form-control" disabled><option value="">Select</option></select>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                                    <div class="col-md-12 nopadding  text-center" id="courseDetails">
                                                    </div>
                                                    <div class="col-lg-12 text-center nopadding" id="valEligibilityId">
                                                        <h4 class="enrollnowlabels"  style=" margin-bottom:10px;">Validating Eligibility</h4>
                                                        <div class="col-md-12 col-sm-12 nopadding" id="requiredqual"></div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-green-gradient hidden" id="iseligible" style="padding:5px;">You are eligible</h5>
                                                        </div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-red-gradient hidden" id="isnoteligible" style=" padding:5px;">You are not eligible</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center nopadding" id="experienceDiv">
                                                        <h4 class="enrollnowlabels" id="ExperienceId" style=" margin-bottom:10px;">Experience</h4>
                                                        <div class=" col-lg-12 col-md-12 col-sm-12 nopadding" id="expprereqDiv"></div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-green-gradient hidden" id="iseligibleexp" style="padding:5px;">You are eligible</h5>
                                                        </div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-red-gradient hidden" id="isnoteligibleexp" style=" padding:5px;">You are not eligible</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center nopadding" id="agePreReqDiv">
                                                        <h4 class="enrollnowlabels" id="ExperienceId" style=" margin-bottom:10px;">Age Pre Requisites</h4>
                                                        <div class=" col-lg-12 col-md-12 col-sm-12 nopadding" id="agetablediv"></div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-green-gradient hidden" id="iseligibleage" style="padding:5px;">You are eligible</h5>
                                                        </div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-red-gradient hidden" id="isnoteligibleage" style=" padding:5px;">You are not eligible</h5>
                                                        </div>
                                                    </div>
													      <div class="box-header with-border">
                            <h3 class="box-title">Uploaded Documents</h3>
                        </div>
        
                    </div>               
					
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-condensed table-bordered table-hover">
                                        <thead>
                                            <tr><th>File Name</th><th>About Document</th></tr>
                                        </thead>
                                        <tbody id="stuDoc">
                                           
                                          
                                              
                                   
                                        </tbody> 
                                    </table>
                                </div>  

                            </div>

                                                 
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>	

			
			<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body">
	          <div class="col-lg-12 text-center " style="padding:10px 10px;">
											
									<div class="col-md-10 input_msg_write">
										  <textarea name="message" id="stu_msgId" class="write_msg" rows="3"  placeholder="Type the message for the student/Organization"></textarea>
										  </div>
										  	</div>
					
						<div class="col-lg-12 text-center buttn">
						<button name="sndbtn" type="submit" id="snd_stu" class="msgbtn btn btn-info ">Message to student</button>
						<button name="sndbtn" type="submit" id="snd_org" class="msgbtn btn btn-info ">Message to organization </button>
							<hr>
							<input type="hidden" id="sId" value="" name="studentId">
							<input type="hidden" id="eId" name="eId" value="">
							<input type="hidden" id="oId" name="eId" value="">
							<input type="hidden" id="msgTo_stu" name="msgTo_stu" value="">
							<input type="hidden" id="msgTo_org" name="msgTo_org" value="">
				
							
							
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

<?php include_once 'superadmin_footer.php'; ?>

<script>


    $(".deleteappenddata").click(function(){
		$("#my_msg").empty();
	});
    $(".myEnrollments").addClass("active");

    $(".myEnrollmentsview").addClass("active");

    document.title = "iHuntBest | Enrollments";



    $(document).ready(function () {

        $(document).on('change', '.statuschange', function () {

            var enrollmentId = $(this).attr('erId');

            var status = $(this).val();

            if (status === "") {

                return false;

            }

            var message = window.prompt("Message For Student");

            if (message === "") {

                $.alert({

                    title: 'Error!', content: "Message is required", type: 'red',

                    typeAnimated: true,

                    buttons: {

                        Ok: function () {

                            window.location.reload();

                        }

                    }

                });

            } else {

                $.ajax({

                    url: '<?php echo site_url('university/changeStatus'); ?>',

                    type: "POST",

                    data: {enrollmentId: enrollmentId, status: status, message: message},

                    success: function (response) {

                        var json = $.parseJSON(response);

                        if (json.status === 'success') {

                            $.alert({title: 'Success!', content: json.msg, type: 'blue',

                                typeAnimated: true,

                                buttons: {

                                    Ok: function () {

                                        window.location.reload();

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

        });

        $('#details_table').DataTable({

            "processing": true,

            "serverSide": false,

            "ajax": {

                "url": "<?php echo site_url('superadmin/getTransactions') ?>",

                "dataType": "json",

                "type": "POST"

            },

            "columns": [
			
				{"data": "id"},

                {"data": "enrollmentId"},
                
				{"data": "paymentid"},
				
				{"data": "studentname"},
				
				{"data": "orgamount"},
				
				{"data": "ihuntamount"},
				
			    {"data": "orgname"},
				
				{"data": "feescategory"},
				
				{"data": "createdat"}
				

            ], error: function (jqXHR, exception) {

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

    });
	
		function studentInfo(roleName, courseId, orgCourseId,studentId,enrollmentId,orgId)
    {
		
		$('#enrollmentId').val(enrollmentId);
  
            $.ajax({
                type: "POST",
                data: {type: roleName, courseId: courseId, orgCourseId: orgCourseId,studentId:studentId,orgId:orgId},
                url: "<?php echo site_url('Superadmin/getEnrollData'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
					console.log(json);
                    if (json.studentDetails !== "")
                    {
                        var baseurl = "<?php echo site_url(); ?>";
                        $("#studentImageenroll").prop('src', baseurl + json.studentDetails.studentImage);
                        $("#en_name_id").val(json.studentDetails.studentName);
                        $("#en_birthday_id").val(json.studentDetails.dob);
                        $("#en_mobile_id").val(json.studentDetails.studentMobile);
                        $("#en_father_id").val(json.studentDetails.fatherName);
                        $("#en_placeofb_id").val(json.studentDetails.placeofBirth);
                        $("#religion_id").val(json.studentDetails.religion);
                        $("#en_nationality_id").val(json.studentDetails.name);                  
                        $("#studentId").val(json.studentDetails.studentId);
                        
                    }
                    if (json.CourseDetails !== "") {
                        $("#courseDetails").html('<h4 class="enrollnowlabels"  style=" margin-bottom:10px;">Course Details Applying For</h4>');
                        $("#courseDetails").append(json.CourseDetails);
                    }
                    if (json.agePreReqTable) {
                        $("#agetablediv").html(json.agePreReqTable);
                    }
                    if (json.isAgeEligible === "Yes") {
                        $("#iseligibleage").removeClass("hidden");
                        $("#isnoteligibleage").addClass("hidden");
                        $("#agePreReqDiv").addClass("greenborder");
                        $("#agePreReqDiv").removeClass("redborder");
                    } else {
                        $("#isnoteligibleage").removeClass("hidden");
                        $("#iseligibleage").addClass("hidden");
                        $("#agePreReqDiv").addClass("redborder");
                        $("#agePreReqDiv").removeClass("greenborder");
                    }
                    $("#requiredqual").html("");
                    $("#requiredexp").html("");
                    var qualification = '';
                    var requiredexp = "";
                    if (json.orgDetails !== '') {
                        $("#en_collegelogo").prop('src', '<?php echo base_url(); ?>' + json.orgDetails[0].orgLogo);
                        $("#en_collegename").text(json.orgDetails[0].orgName);
                        $("#orgId").val(json.orgDetails[0].loginId);
                        $("#en_collegeaddress").text(json.orgDetails[0].orgAddress);
                        $("#approvedById").text((json.orgDetails[0].approvedBy !== "" ? "Approved By " + json.orgDetails[0].approvedBy : ''));
                    }
					if(json.docDetails !== '')
					{
						var i;
						for(i=0;i<json.docDetails.length;i++)
						{
						$('#stuDoc').append('<tr><td><a href="<?php echo base_url();?>'+json.docDetails[i].fileName+'">'+json.docDetails[i].OrgFileName+'</a></td><td>'+json.docDetails[i].AboutDoc+'</td></tr>');
						}
					}
                    if (json.reqEligibility) {
                        if (json.reqEligibility.experiencetable) {
                            $("#expprereqDiv").html(json.reqEligibility.experiencetable);
                        }
                        if (json.reqEligibility.Minqualification !== "") {
                            qualification = json.reqEligibility.Minqualification;
                        }
                        if (json.reqEligibility.isElligible === "Yes") {
                            $("#iseligibleexp").removeClass("hidden");
                            $("#isnoteligibleexp").addClass("hidden");
                            $("#experienceDiv").addClass("greenborder");
                            $("#experienceDiv").removeClass("redborder");

                        } else {
                            $("#iseligibleexp").addClass("hidden");
                            $("#isnoteligibleexp").removeClass("hidden");
                            $("#experienceDiv").addClass("redborder");
                            $("#experienceDiv").removeClass("greenborder");
                        }
                        if (json.reqEligibility.Qualified === 'Yes') {
                            $("#iseligible").removeClass("hidden");
                            $("#isnoteligible").addClass("hidden");
                            $("#valEligibilityId").addClass("greenborder");
                            $("#valEligibilityId").removeClass("redborder");
                        } else if (json.reqEligibility.Qualified === 'No') {
                            $("#iseligible").addClass("hidden");
                            $("#isnoteligible").removeClass("hidden");
                            $("#valEligibilityId").addClass("redborder");
                            $("#valEligibilityId").removeClass("greenborder");
                        }
                        if (json.reqEligibility.Qualified === 'Yes' && json.reqEligibility.isElligible === "Yes" && json.isAgeEligible === "Yes") {
                            $("#submitbtn").html('<input type="submit" style="width: fit-content;    padding: 10px;  letter-spacing: 1px;" id="singlebutton" name="singlebutton" class="btn btn-success" value="Enroll Now">');
                        } else {
                            $("#submitbtn").html('<h5 class="bg-red-gradient" id="noteligibletext" style="padding:5px;">Sorry you are not eligible for this course.</h5>');
                        }
                    } else {
                        $("#singlebutton").removeClass('hidden');
                        $("#noteligibletext").remove();
                    }
                    $("#requiredqual").append(qualification);
                    $("#requiredexp").append(requiredexp);
                    $("#studentModal").show();
                    $("body").css("overflow", "hidden");
                },
                error: function (response) {
                    $('#error').html(response);
                }
            });
       
    // }
	}
    $("#closestudentModal").click(function () {
        $("#studentModal").hide();
        $("body").css("overflow", "auto");
    });

		function showMsg(eId,orgId,studentId,studentName,orgName){

 $('#oId').val(orgId);
		 $('#sId').val(studentId);
		  $('#eId').val(eId);
		  $('#msgTo_stu').val(studentName);
		  $('#msgTo_org').val(orgName);

            $.ajax({
                type: "POST",
                data: {eId: eId,orgId:orgId},
                url: "<?php echo site_url('Superadmin/showMsg'); ?>",
                success: function (response) {
					console.log(response);
                    var json = $.parseJSON(response);
					$(".msg_history").html("");
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
    
							if(json[i].msgFrom == 'Admin')
					{
					 $(".msg_history").append('<div class="outgoing_msg"><div class="sent_msg"> <p>'+json[i].msg+'&nbsp;&nbsp;<span class="time_date"> '+json[i].createdDate+'</span></p> </div></div>');
					}
					else{
						
						if(json[i].status=='Approved'){
						var status='<b style="color:greenyellow;"> '+json[i].status+'</b>'; }
						else if(json[i].status=='Rejected') {
						var status='<b style="color:#860101;"> '+json[i].status+'</b>';}
						else if(json[i].status=='pending'){
						var status='<b style="color:#0a175a;"> '+json[i].status+'</b>';}
						$(".msg_history").append('<div class="incoming_msg"> Message From <b style="color:darkBlue;">'+json[i].msgFrom +'</b> <div class="received_msg"> <div class="received_withd_msg"> <p>'+json[i].msg+'&nbsp;&nbsp;<br><a href="<?php echo base_url(); ?>'+json[i].docAttachment+'">'+attach+'</a><span class="time_date"> '+json[i].createdDate+'&nbsp;&nbsp;('+status+')</span></p></div> </div></div>');
					}
					
					}
					}
}
});
}
	
		$('.msgbtn').click(function(){
			
		  var orgId= $('#oId').val();
		  var studentId=$('#sId').val();
		  var enrollmentId=$('#eId').val();
		  var msg=$('#stu_msgId').val();
		  var id=$(this).attr('id');
		  var msgFrom =  'Admin';
		  alert(id)
		if(id=='snd_stu'){
		  var msgTo =	$('#msgTo_stu').val();
		}
		else if(id=='snd_org')
		{
		 var msgTo =	$('#msgTo_org').val();	
		}
		
		 if (orgId === "" && studentId === "" && enrollmentId === "" && msg === "" && msgFrom === "" && msgTo === "") {
                $.alert({
                    title: 'Error!', content: "Message is required", type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {
                            window.location.reload();
                        }
                    }
                });
            } else {
		    $.ajax({
                    url: "<?php echo site_url('Superadmin/notifyMsg'); ?>",
                    type: "POST",
                    data: {orgId: orgId, studentId: studentId, enrollmentId: enrollmentId,msg:msg,msgFrom:msgFrom,msgTo:msgTo},
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
	  });
	  
		    getReligion("", "religion_id");
    function getReligion(selval, id) {
        var result = '<option value="">Select</option>';
        $.ajax({
            url: '<?php echo site_url('home/religion'); ?>',
            success: function (response) {
                if (response !== "") {
                    var respjson = $.parseJSON(response);
                    for (var i = 0; i < respjson.length; i++) {
                        result = result + '<option value="' + respjson[i].religionId + '">' + respjson[i].religionName + '</option>';
                    }
                    $('#' + id).html(result);
                    $('#' + id).val(selval);
                } else {
                    $.alert({
                        title: 'Error!', content: response, type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function () {

                            }
                        }
                    });
                }
            }, error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function () {

                        }
                    }
                });
            }
        });
    }


</script>

