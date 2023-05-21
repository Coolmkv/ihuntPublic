<?php include_once 'superadmin_header.php'; 
echo $map['js'];?>
    <div class="content-wrapper">
        <div class="hidden"><?php echo $map["html"];?></div>
        <section class="content-header">
            <h1>
                Student Registration    
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Super-Admin Dashboard</a></li>
                <li><a href="#">Registration</a></li>
                <li class="active">Student Registration</li>
            </ol>
        </section>
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Student Registration</h3>
                        </div>
                        <?php echo form_open("superadmin/registerStudent" ,["id"=>"submit_form"]);?>
                            <div class="box-body">
                                <input type="hidden" name="studentId" id="id" value="no_one" >
                                <div class="form-group col-md-4">
                                    <label>Name</label>
                                    <input type="text" name="student_name" id="student_name" class="form-control" data-validation ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Contact</label>
                                    <input type="number" maxlength="10" name="studentMobile" id="studentMobile" class="form-control" data-validation ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Email</label>
                                    <input type="email" name="student_email" id="student_email" class="form-control" data-validation ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Password</label>
                                    <input type="text" name="student_password" id="student_password" class="form-control" data-validation ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>DOB</label>
                                    <input type="date" name="student_dob" id="student_dob" max="<?php echo date("Y-m-d",strtotime("-5 year", time()));?>" class="form-control" data-validation ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Gender</label>
                                    <select class="form-control" id="gender" data-validation="required" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="female">Female</option>
                                        <option value="male">Male</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Country</label>
                                    <select  class="form-control" id="countryId1"   name="countryId" data-validation="required"></select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>State</label>
                                    <select class="form-control" id="stateId1" data-validation="required" name="stateId1"></select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>City</label>
                                    <select class="form-control" id="cityId1" data-validation="required" name="cityId1"></select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Address</label>
                                    <input type="text" name="address" id="address" class="form-control" data-validation ="required">
                                </div>
                                <div class="form-group col-md-2">
                                    <label></label>
                                    <input style="margin-top:3px" type="submit" value="Save" class="form-control btn btn-primary" name="save_details" id="save_details">
                                </div>
                            </div>
                        <?php  echo form_close();?>
                    </div>
                </div>
                <div class="row box-body">
                    <div class="col-md-12">
                        <!-- general form elements --> 
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Student Details</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table id="data_table" class="table table-bordered table-striped table-responsive">
                                            <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>DOB</th>
                                                <th>Gender</th>
                                                <th>Address</th>
                                                <th>Country Details</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    $(".admin_registration").addClass("active");
    $(".studentRegister_link").addClass("active");
    document.title  =   "iHuntBest | Student Registration";
    $(document).ready(function () {
        getCountries('#countryId1','<?php if(isset($_SESSION['countryId'])){echo $_SESSION['countryId'];} ?>','#stateId1');
        $('#stateId1').change(function () {
            var stateId = $('#stateId1').val();
            var selected_cityId = "";
            getStateByCity(stateId, selected_cityId,'#cityId1');
        });
        $('#countryId1').change(function () {
            var countryId = $('#countryId1').val();

            var selected_stateId = "";
            getcountryByStates(countryId, selected_stateId,'#stateId1');
        });
        $('#save_details').click(function () {
            $.validate({
                lang: 'en'
            });
            var options = {
                beforeSend: function () {
                },
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
                            typeAnimated: true,buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            } });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#submit_form').ajaxForm(options);
        });
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('superadmin/getStudentDetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) { 
                    oTable.fnAddData([
                        (i + 1),
                        json[i].studentName,
                        json[i].studentMobile,
                        json[i].email,
                        json[i].password,
                        json[i].dob,
                        json[i].gender,
                        json[i].location,
                        json[i].countrydetails,
                        '<a href="javascript:" ed="'+json[i].studentId+'" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="delfunction" href="javascript:" del="'+json[i].studentId+'" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                         
                    ]);
                }
            }
        });
        $(document).on("click", ".editfunction", function () {
            var studentId   =   $(this).attr('ed');
            $.ajax({
            type: "POST",
            data: {studentId:studentId},
            url: "<?php echo site_url('superadmin/getStudentDetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                $('#id').val(json[0].studentId);
                $('#student_name').val(json[0].studentName);
                $('#studentMobile').val(json[0].studentMobile);
                $('#student_email').val(json[0].email);
                $('#student_password').val(json[0].password);
                $('#student_dob').val(json[0].dobo);
                $('#gender').val(json[0].gender);
                $('#countryId1').val(json[0].countryId);
                getcountryByStates(json[0].countryId, json[0].stateId,'#stateId1');
                getStateByCity(json[0].stateId, json[0].cityId,'#cityId1');
                $('#address').val(json[0].location);
                    }
                    });
                    
        });
        $(document).on("click",".delfunction",function(){
        var studentId   =   $(this).attr('del');
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
                        data: {studentId:studentId,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                        url: "<?php echo site_url('superadmin/delStudentDetails');?>",
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
                                    typeAnimated: true,buttons: {
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    } });
                            }
                        }
                    });
                }
            }
            });
        });
    });
    function getCountries(countryId,db_countryId,stateId) {
            $.ajax({
                url: "<?php echo site_url('Home/getCountriesJson');?>",
                type: 'POST',
                data: '',
                success: function (response) {
                  var cid='';
                    var json = $.parseJSON(response);
                    var data = '<option value="">Country</option>';
                    for (var i = 0; i < json.length; i++) {
                        if(db_countryId==json[i].countryId){
                            cid='selected';
                            var selected_stateId = "";
                            getcountryByStates(json[i].countryId, selected_stateId,stateId);
                        }
                        else{
                            cid='';
                        }
                        data = data + '<option '+cid+'  value="' + json[i].countryId + '">' + json[i].name + ' (' + json[i].sortname + ')' + '</option>';
                    }
                    $(countryId).html(data);
                     
                }
            });
        }
        function getcountryByStates(countryId, selected_stateId,stateId) {
            $.ajax({
                url: "<?php echo site_url('Home/getStatesByCountry');?>",
                type: 'POST',
                data: 'countryId=' + countryId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">State</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].stateId + '">' + json[i].name + '</option>';
                    }
                    $(stateId).html(data);
                    $(stateId).val(selected_stateId);
                }
            });
        }
        function getStateByCity(stateId, selected_cityId,cityId) {
            $.ajax({
                url: "<?php echo site_url('Home/getCityByStates')?>",
                type: 'POST',
                data: 'stateId=' + stateId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">City</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].cityId + '">' + json[i].name +'</option>';
                    }
                    $(cityId).html(data);
                    $(cityId).val(selected_cityId);
                }
            });
        }
    
</script>