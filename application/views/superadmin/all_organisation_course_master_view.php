<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maindivContent">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			All Organisations Course Master
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="#">Masters</a></li>
			<li class="active">All Organisations Course Master</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row box-body">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Add Organisation Courses</h3>
					</div>
					<?php echo form_open('Superadmin/addOrganisationCourses', ["id" => "course_type_form", "name" => "course_type_form"]); ?>
					<div class="box-body">
						<div class="row">
							<input type="hidden" name="id" id="id" value="">
							<div class="col-md-3">
								<div class="form-group">
									<label>Course Name</label>
									<input type="text" name="course_name" id="course_name_id" class="form-control"
										   data-validation="required" placeholder="Course Name">
								</div>
							</div>
							<div class="col-md-3" id="subCourseMainDiv">
								<div class="col-md-10">
									<div class="form-group">
										<label>Sub Course Name</label>
										<input type="text" name="course_category[]" id="course_category_id"
											   class="form-control category"  placeholder="Sub Course Name">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>&nbsp;</label>
										<button type="button" class="btn-info btn" onclick="makeNewItem()" title="Add new Sub Course Box">
											<i class="fa fa-plus"></i>
										</button>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Duration In Months</label>
									<input  placeholder="Duration In months" type="number" min="1"
											data-validation="required" name="duration_in_months" id="duration_in_months_id" class="form-control">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Description</label>
									<textarea name="description" id="description_id" class="form-control"></textarea>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Organisation Type</label>
									<select data-validation="required"  name="for_organization" id="for_organization_id" class="form-control">
										<option value="">Select</option>
										<option value="University/College">University/College</option>
										<option value="Institute">Institute</option>
										<option value="School">School</option>
									</select>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<div class="form-group"  >
									<label>&nbsp;</label>
									<input type="submit" class="btn btn-primary" name="save_course"
										   id="save_course" value="Save" onclick="this.attr('disabled','true')">
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
					<!--/.col -->
				</div>
			</div>
		</div>
		<!-- /.row -->

		<div class="row box-body">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Organisations Course Details</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table id="course_type_table"
									   class="table table-bordered table-striped table-responsive">
									<thead>
									<tr>
										<th>S. No.</th>
										<th>Course Name</th>
										<th>Sub Course Name</th>
										<th>Duration (Months)</th>
										<th>Description</th>
										<th>Organisation Type</th>
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

	</section>

	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->

<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
	function deleteEnrty(id)
	{

		var ihuntcsrfToken = $('input[name="ihuntcsrfToken"]').val();
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
						data: {id: id, ihuntcsrfToken: ihuntcsrfToken},
						url: "<?php echo site_url('superadmin/delOrganisationCourse'); ?>",
						success: function (response) {
							var json = $.parseJSON(response);
							if (json.status == true) {
								$.alert({
									title: 'Success!', content: json.message, type: 'blue',
									typeAnimated: true,
									buttons: {
										Ok: function () {
											window.location.reload();
										}
									}
								});
							} else {
								$.alert({
									title: 'Error!', content: json.message, type: 'red',
									typeAnimated: true,
								});
							}
						}
					});
				}
			}
		});
	}
	$(document).ready(function () {
		$.validate({
			lang: 'en'
		});
		$(document).on('click', '.editAction', function () {
			var ctId = $(this).attr('ctId');
			$.ajax({
				type: "POST",
				data: {id:ctId},
				url: "<?php echo site_url('superadmin/getAllCourseDetails'); ?>",
				success: function (response) {
					var json = $.parseJSON(response);
					$('#id').val(json[0].id);
					$('#course_name_id').val(json[0].course_name);
					$('#course_category_id').val(json[0].course_category);
					$('#duration_in_months_id').val(json[0].duration_in_months);
					$('#description_id').val(json[0].description);
					$('#for_organization_id').val(json[0].for_organization);
				}
			});
		});
		$.ajax({
			type: "GET",
			data: "",
			url: "<?php echo site_url('superadmin/getAllCourseDetails'); ?>",
			success: function (response) {
				var json = $.parseJSON(response);
				var oTable = $('table#course_type_table').dataTable();
				oTable.fnClearTable();
				for (var i = 0; i < json.length; i++) {
					oTable.fnAddData([
						(i + 1),
						json[i].course_name,
						json[i].course_category,
						json[i].duration_in_months,
						json[i].description,
						json[i].for_organization,
						 '<a href="javascript:"   ctId="' + json[i].id + '" class="editAction">' +
						 '<i class="fa fa-edit"></i>' +
						 '</a>&nbsp;&nbsp;&nbsp;&nbsp;' +
						 '<a href="#" onclick="deleteEnrty(\'' + json[i].id + '\');" title="Delete">' +
						 '<i class="fa fa-trash-o"></i></a>'
					]);
				}
			}
		});

		$('#save_course').click(function () {
			var options = {
				beforeSend: function () {
				},
				success: function (response) {
					console.log(response);
					var json = $.parseJSON(response);
					if (json.status === 'success') {
						$.alert({
							title: 'Success!', content: json.message, type: 'blue',
							typeAnimated: true,
							buttons: {
								Ok: function () {
									window.location.reload();
								}
							}
						});
					} else {
						$.alert({
							title: 'Error!', content: json.message, type: 'red',
							typeAnimated: true,
						});
					}
				},
				error: function (response) {
					$('#error').html(response);
				}
			};
			$('#course_type_form').ajaxForm(options);
		});
	});
</script>

<script type="text/javascript">
	$(".organizationCourse_link").addClass("active");
	$(".admin_item").addClass("active");
	document.title = "iHuntBest | All Organisations Course Master";

	function makeNewItem() {
		let categories = $(".category").length;
		categories++;
		let item =
				'<div class="col-md-10 categories'+categories+'" >' +
				'<div class="form-group">' +
				'<label>Sub Course Name</label>' +
				'<input type="text" name="course_category[]" id="course_category_id'+categories+'"' +
				' class="form-control category" placeholder="Sub Course Name">' +
				'</div>' +
				'</div>' +
				'<div class="col-md-2 categories'+categories+'">' +
				'<div class="form-group">' +
				'<label>&nbsp;</label>' +
				'<button type="button"  class="btn btn-danger" onclick="removeDiv(\'categories'+categories+'\')" title="Add new Sub Course Box">\n' +
				'<i class="fa fa-minus"></i>' +
				'</button>\n' +
				'</div>\n' +
				'</div>\n' +
				'</div>';
		$("#subCourseMainDiv").append(item);
	}
	function removeDiv(removeClass) {
		$("."+removeClass).remove();
	}
</script>
