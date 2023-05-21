<?php include_once 'superadmin_header.php'; echo $map['js'];?>
<!-- Content Wrapper. Contains page content -->
<div class="hidden"><?php echo $map["html"];?></div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Organization Registration
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('superadmin/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Register</a></li>
                <li class="active">Organization Registration</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Organization Details</h3>
                        </div>
                        <?php echo form_open('Superadmin/addOrganizationDetails' ,["id"=>"deatils_form","name"=>"deatils_form"]);?>
                         
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="no_one">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Role Type</label>
                                            <select id="roleName" name="roleName" class="form-control">
                                                <option value="">Select Role</option>
                                                <option value="University">University</option>
                                                <option value="College">College</option>
                                                <option value="Institute">Institute</option>
                                                <option value="School">School</option>
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Organization Name</label>
                                            <input type="text" name="orgname" id="orgname" class="form-control" data-validation="required">                                    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Organization Contact</label>
                                            <input type="number" name="orgContact" id="orgContact" class="form-control" >                                    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Organization Landline No.</label>
                                            <input type="number" name="orgAContact" id="orgAContact" class="form-control" data-validation="required">                                    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Organization Email</label>
                                            <input type="text" name="orgemail" id="orgemail" class="form-control" data-validation="required">                                    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Organization Password</label>
                                            <input type="text" name="orgpassword" id="orgpassword" class="form-control" data-validation="required">                                    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select id="countryId" name="country" class="form-control"></select>                                   
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>State</label>
                                            <select id="stateId" name="state" class="form-control"></select>                                   
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>City</label>
                                            <select id="cityId" name="city" class="form-control"></select>                                   
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Organization Address</label>
                                            <input type="text" name="address" id="address" class="form-control" data-validation="required">                                    
                                        </div>
                                    </div>
									<div class="col-md-4">
                                        <div class="form-group">
                                            <label>Organization Account Id</label>
                                            <input type="text" name="orgaccid" id="orgaccid" class="form-control" data-validation="required">                                    
                                        </div>
                                    </div>
									<div class="col-md-4">
                                        <div class="form-group">
                                            <label>Organization Percentage</label>
											<select name="comm" id="comm">
											  <option value="">Select One</option>
											  <option value="percent">Percentage</option>
											  <option value="lumsum">lumsum</option>
											</select>
                                                                               
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group">
											 <input type="text" name="percentage" placeholder="Enter %" id="percentage" style="display:none;" class="form-control" data-validation="required">                                    
                                            <input type="text" name="lumsum" placeholder="Enter lumsum" id="lumsum" style="display:none;" class="form-control" data-validation="required"> 
										</div>
									</div>
									<div class="col-md-4">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="split[]" id="split">Split Payment</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="margin-top: 23px">
                                            <label></label>
                                            <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Register">
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
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Registered Organization Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="showdata_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Role Name</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Landline No.</th> 
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Country</th>
                                            <th>Address</th>
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

     $('#comm').change(function() {
		var selected = $(this).val();
		if(selected == 'percent'){
		  $('#percentage').show();
		  $('#lumsum').hide();
		}else if(selected == 'lumsum'){
			$('#lumsum').show();
			$('#percentage').hide();
		}
     });

    function deleteEnrty(id)
    { 
        var ihuntcsrfToken  =   $('input[name="ihuntcsrfToken"]').val();
        var Id = id;
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
                        data: {Id:Id,ihuntcsrfToken:ihuntcsrfToken},
                        url: "<?php echo site_url('superadmin/delOrganisationDetails');?>",
                        success: function (response) {
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
            var Id = $(this).attr('ctId');
            $.ajax({
                type: "POST",
                data: "id=" + Id,
                url: "<?php echo site_url('superadmin/getOrganisationDetails');?>",
                success: function (response) {
                    var json = $.parseJSON(response); 
                        $('#id').val(json[0].id);
                        $("#orgname").val(json[0].orgName);
                        $("#roleName").val(json[0].roleName);                        
                        $("#orgContact").val(json[0].orgMobile);
                        $("#orgAContact").val(json[0].org_landline);                   
                        $("#orgemail").val(json[0].email);
                        $("#orgpassword").val(json[0].password);
                        if(json[0].countryId!==null){
                            $("#countryId").val(json[0].countryId); 
                        }
                        if(json[0].countryId!==null && json[0].stateId!==null){
                            getcountryByStates(json[0].countryId, json[0].stateId);
                        } 
                        if(json[0].cityId!==null && json[0].stateId!==null){
                            getStateByCity(json[0].stateId, json[0].cityId);     
                        }                                   
                        $("#address").val(json[0].orgAddress);
                        $("#studentId").val(json[0].org_account_id);
                        $("#percentage").val(json[0].org_percentage);
                }
            });
        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getOrganisationDetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].roleName,
                        json[i].orgName,
                        json[i].orgMobile,
                        json[i].org_landline,
                        json[i].email,
                        json[i].password,
                        json[i].ctyname+','+json[i].statename+','+json[i].country,
                        json[i].orgAddress, 
                        '<a href="javascript:"   ctId="' + json[i].id + '" class="editAction"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteEnrty('+ json[i].id +');" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });

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
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#deatils_form').ajaxForm(options);
        });
        getCountries();
        $('#countryId').change(function () {
            var countryId = $('#countryId').val();
            var selected_stateId = "";
            getcountryByStates(countryId, selected_stateId);
        });
        $('#stateId').change(function () {
            var stateId = $('#stateId').val();
            var selected_cityId = "";
            getStateByCity(stateId, selected_cityId);
        });
        function getCountries() {
            $.ajax({
                url: "<?php echo site_url("home/getCountriesJson");?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose Country</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].countryId + '">' + json[i].name + '</option>';
                    }
                    $('#countryId').html(data); 
                }
            });
        }

        function getcountryByStates(countryId, selected_stateId) {
            $.ajax({
                url: "<?php echo site_url("home/getStatesByCountry");?>",
                type: 'POST',
                data: 'countryId=' + countryId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose State</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].stateId + '">' + json[i].name + '</option>';
                    }
                    $('#stateId').html(data);
                    $('#stateId').val(selected_stateId);
                    
                }
            });
        }

        function getStateByCity(stateId, selected_cityId) {
            $.ajax({
                url: "<?php echo site_url("home/getCityByStates");?>",
                type: 'POST',
                data: 'stateId=' + stateId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose City</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].cityId + '">' + json[i].name + '</option>';
                    }
                    $('#cityId').html(data);
                    $('#cityId').val(selected_cityId);
                }
            });
        }
    });
</script>

<script type="text/javascript">
    $(".orgRegister_link").addClass("active");
    $(".admin_registration").addClass("active");
    document.title  =   "iHuntBest | Organization Registration";
</script>