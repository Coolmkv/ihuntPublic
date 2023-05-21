<?php

include_once 'university_header.php';

$currency = (isset($_SESSION['dCurrency']) ? (!empty($_SESSION['dCurrency']) ? $_SESSION['dCurrency'] : "NA") : 'NA');

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
<style>
	/* The switch - the box around the slider */
	.switch {
		position: relative;
		display: inline-block;
		width: 60px;
		height: 34px;
	}
	/* Hide default HTML checkbox */
	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}
	/* The slider */
	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}
	.slider:before {
		position: absolute;
		content: "";
		height: 26px;
		width: 26px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}
	input:checked + .slider {
		background-color: #2196F3;
	}
	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}
	input:checked + .slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}
	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}
	.slider.round:before {
		border-radius: 50%;
	}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Add New Course
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url("university/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="#">Course</a></li>
			<li class="active"> Add New Course</li>
		</ol>
	</section>
	<section class="content">
		<div class="row box-body">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Add Courses</h3>
					</div>

					<div class="box-body">
						<?php echo form_open('university/addUpdateNewCourse', ["name" => "course_form", "id" => "new_course_form"]); ?>
						<div class="row">
							<input type="hidden" name="id" id="id" value="">
							<div class="col-md-6 col-md-offset-3">
								<div class="form-group">
									<label>Select Course</label>
									<select data-live-search="true" name="course_masters_id[]" required id="course_masters_id" class="form-control selectpicker" multiple data-validation="required">
									<?php
									if(isset($organisation_courses)){
										foreach ($organisation_courses as $oc){
											echo '<option value="'.$oc->id.'">'.$oc->course_name.' </option>';
										}
									}
									?>
									</select>
								</div>
								<div class="col-md-6 col-md-offset-3 text-center">
									<button type="submit" class="btn btn-primary" id="save_course">
										Save
									</button>
								</div>
							</div>

						</div>
						<?php echo form_close();?>

					</div>

					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table id="page_table"
									   class="table table-bordered table-striped table-responsive">
									<thead>
									<tr>
										<th>S. No.</th>
										<th>Course Name</th>
										<th>Qualifications</th>
										<th>Qualifications</th>
										<th>Course Details</th>
										<th>Course Details</th>
										<th>Registration Fee</th>
										<th>Course Fee</th>
										<th>Total Seats</th>
										<th>Available Seats</th>
										<th>Action</th>
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
		<!-- /.row -->
	</section>



	<!-- /.content --> 
</div>
<div class="modal fade" id="editCourse" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Edit Course</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
					 
                        <?php echo form_open('university/editCourseMaster', ["name" => "editCourse", "id" => "editCourse_form"]); ?>
                        <fieldset>
						<input type="hidden" name="organisation_courses_id" id="organisation_courses_id" value="">
                            <!-- Text input-->
                            <div class="col-md-6 form-group">
								<label>Course Details</label>
								<textarea class="form-control" name="course_details" id="course_details_id" placeholder="Course Details" required></textarea>
							</div>
							<div class="col-md-6 form-group">
								<label>Course Qualifications</label>
								<textarea class="form-control" name="course_qualifications" id="course_qualifications_id" placeholder="Course Qualifications" required></textarea>
                            </div>
							<div class="col-md-3 form-group">
								<label>Registration Fee</label>
								
								<input type="number" class="form-control" name="registration_fee" id="registration_fee_id" placeholder="Registration Fee" required>
                            </div>
							<div class="col-md-3 form-group">
								<label>Course Fee</label>
								<input type="number" class="form-control" name="course_fee" id="course_fee_id" placeholder="Course Fee" required>
                            </div>
							<div class="col-md-3 form-group">
								<label>Total Seats</label>
								<input type="number" class="form-control" name="total_seats" id="total_seats_id" placeholder="Total Seats" required>
                            </div>
							<div class="col-md-3 form-group">
								<label>Available Seats</label>
								<input type="number" class="form-control" name="available_seats" id="available_seats_id" placeholder="Available Seats" required>
                            </div>
                            <div class="col-md-12 form-group user-form-group">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" id="edit_course">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php include_once 'university_footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>

<script>

	$(".add_course_link").addClass("active");
	$(".add_course").addClass("active");

	document.title = "iHuntBest | Add New Course";
</script>

<script type="text/javascript">
	$(document).on("click",".editOrgCourse",function(){
			let row = $(this).data("row");
			let rowJson = $.parseJSON(atob(row));
			$("#course_details_id").text(rowJson.course_details);
			$("#course_qualifications_id").text(rowJson.course_qualifications);
			$("#organisation_courses_id").val(rowJson.id);
			$("#registration_fee_id").val(rowJson.registration_fee);
			$("#course_fee_id").val(rowJson.course_fee);
			$("#total_seats_id").val(rowJson.total_seats);
			$("#available_seats_id").val(rowJson.available_seats);
			$("#editCourse").modal("show");
		});
	$(document).ready(function () {
		$("#edit_course").on("click",function(){
			var options = {
				beforeSend: function () {
					if(!$("#organisation_courses_id").val()){
						$.alert({title: 'Error!', content: "Course id not set.", type: 'red',
							typeAnimated: true});
							return false;
					}
					
					if(!$("#course_details_id").val()){
						$.alert({title: 'Error!', content: "Course details not set.", type: 'red',
							typeAnimated: true});
							return false;
					}
					
					if(!$("#course_qualifications_id").val()){
						$.alert({title: 'Error!', content: "Course qualifications not set.", type: 'red',
							typeAnimated: true});
							return false;
					}
					let registration_fee_id = $("#registration_fee_id").val();
					let course_fee_id = $("#course_fee_id").val();
					let total_seats_id = $("#total_seats_id").val();
					let available_seats_id = $("#available_seats_id").val();
					if(registration_fee_id<0){
						$.alert({title: 'Error!', content: "Registration Fee should be greater than 0.", type: 'red',
							typeAnimated: true});
							return false;
					}
					if(course_fee_id<0){
						$.alert({title: 'Error!', content: "Course Fee should be greater than 0.", type: 'red',
							typeAnimated: true});
							return false;
					}
					if(total_seats_id<0){
						$.alert({title: 'Error!', content: "Total seats should be greater than 0.", type: 'red',
							typeAnimated: true});
							return false;
					}
					if(available_seats_id<0){
						$.alert({title: 'Error!', content: "Available seats should be greater than 0.", type: 'red',
							typeAnimated: true});
							return false;
					}
				},
				success: function (response) {
					$("#editCourse").modal("hide");
					var json = $.parseJSON(response);
					if (json.status) {
						$.alert({title: 'Success!', content: json.message, type: 'blue',
							typeAnimated: true,
							buttons: {
								Ok: function () {
									window.location.reload();
								}
							}
						});
					} else {
						$.alert({title: 'Error!', content: json.message, type: 'red',
							typeAnimated: true});
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
			};
			$('#editCourse_form').ajaxForm(options);
		});
		$('#save_course').on("click",function () {
			var options = {
				beforeSend: function () {

				},
				success: function (response) {
					console.log(response);
					var json = $.parseJSON(response);
					if (json.status) {
						$.alert({title: 'Success!', content: json.message, type: 'blue',
							typeAnimated: true,
							buttons: {
								Ok: function () {
									window.location.reload();
							}
							}
						});
					} else {
						$.alert({title: 'Error!', content: json.message, type: 'red',
							typeAnimated: true});
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
			};
			$('#new_course_form').ajaxForm(options);
		});
	
	let datatable =	$('#page_table').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
			'url':'<?php echo site_url('university/getAllCourseDetails'); ?>',
			'method':'post'
			
		},
		'columns': [
             { data: 'dataRowNum',"name":"organisation_courses.id" },
             { data: 'course_name',"name":"course_masters.course_name" },
             { data: 'course_qualifications',"name":"organisation_courses.course_qualifications" },
             { data: 'course_qualifications',"name":"course_masters.course_qualifications","visible":false },
             { data: 'course_details',"name":"organisation_courses.course_details" },
             { data: 'course_details',"name":"course_masters.course_details","visible":false },
             { data: 'registration_fee',"name":"organisation_courses.registration_fee" },
             { data: 'course_fee',"name":"organisation_courses.course_fee" },
             { data: 'total_seats',"name":"organisation_courses.total_seats" },
             { data: 'available_seats',"name":"organisation_courses.available_seats" },
             { data: 'action',render:function(r,e,row){
				return '<button type="button" data-row="'+btoa(JSON.stringify(row))+'" title="Edit Course" class="editOrgCourse btn btn-sm btn-primary"><i class="fa fa-edit"></i></button> '+
						'<button type="button" data-course_id="' + row.id + '" title="Delete Course" class="deleteOrgCourse btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>';
			 } },
          ]
    });
});

$(document).on("click", ".deleteOrgCourse", function () {
            var orgCourseId = $(this).data("course_id");
            $.confirm({
                title: 'Warning!',
                content: "Are you sure to delete?",
                type: 'red',
                typeAnimated: true,
                buttons: {
                    Cancel: function () {
                        window.location.reload();
                    },
                    Confirm: function () {
                        $.ajax({
                            type: "POST",
                            data: "organisation_courses_id=" + orgCourseId,
                            url: "<?php echo site_url("university/deleteCourseMasterEntry"); ?>",
                            success: function (response) {
                                var json = $.parseJSON(response);
                                if (json.status === 'success') {
                                    $.alert({title: 'Success!', content: json.message, type: 'blue',
                                        typeAnimated: true,
                                        buttons: {
                                            Ok: function () {
                                                window.location.reload();
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({title: 'Error!', content: json.message, type: 'red',
                                        typeAnimated: true, });
                                }
                            }
                        });
                    }
                }
            });
        });
</script>
