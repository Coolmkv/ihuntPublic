<?php include_once 'student_header.php';?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Experience Details
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student');?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Edit | Insert Experience Details</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Experience Details</h3>
                        </div>
                        <?php echo form_open('student/insertExperienceDetails',["name"=>"form_details","id"=>"form_details"]);?>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" class="hidden" value="no_id" name="student_exp_id" id="student_exp_id">
                                 
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Experience Type:</label>
                                    <select name="experienceType" id="experienceType" class="form-control" data-validation="required">
                                        <option value="">Select</option>
                                        <option value="Full Time">Full Time</option>
                                        <option value="Part Time">Part Time</option>
                                    </select>                                
                                </div>                                 
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group autocomplete">
                                    <label class="control-label">Organization Name:</label>
                                    <input type="text" placeholder="Worked Where" id="orgName" name="orgName" value=""  data-validation="required" class="form-control">
                                    
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Designation:</label>
                                    <input type="text"   id="designation" name="designation" value="" placeholder="Designation"  data-validation="required" class="form-control"> 
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group autocomplete">
                                    <label class="control-label">From Date:</label>
                                    <input type="date"  id="startDate" name="startDate"   max="<?php echo date('Y-m-d');?>" data-validation="required" class="form-control">                                     
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group autocomplete">
                                    <label class="control-label">To Date:</label>
                                    <input type="date"  id="endDate" name="endDate"   max="<?php echo date('Y-m-d');?>" data-validation="required" class="form-control">                                     
                                </div>  
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group autocomplete">
                                    <label class="control-label">Working Now:</label>
                                    <input type="checkbox"  id="workingStatus" name="workingStatus" value="Working" class="form-control">                                     
                                </div>  
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">

                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Higher Education Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Experience Type</th>
                                            <th>Organization Name</th>
                                            <th>Designation</th> 
                                            <th>From Date</th>
                                            <th>To Date</th> 
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
            </div>    
        
    </section>
    <!-- /.content -->
</div>
<?php include_once 'student_footer.php';?>
<script>
$(".experience_link").addClass("active"); 
document.title  =   "iHuntBest | Experience Details";
$(document).ready(function(){
    $.validate({
        lang: 'en'
    });
    $("#workingStatus").click(function(){
       if($(this).prop('checked')===true){
            $("#endDate").val("");
            $("#endDate").prop("readonly",true);
            $("#endDate").attr("data-validation","");
       }else{
           $("#endDate").val("");
            $("#endDate").prop("readonly",false);
            $("#endDate").attr("data-validation","required");
       }
    });
    $("#startDate").change(function(){
        $("#endDate").prop("min",$("#startDate").val());
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
                            typeAnimated: true
                        });
                    }
                },
                error: function (response) {
                    $.alert({
                            title: 'Error!', content: response, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                }
            };
            $('#form_details').ajaxForm(options);
        });
        dataTable();
    function dataTable(){ 
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("Student/getExperienceDetails");?>",
            data:{},
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#details_table').dataTable();
                var workingStatus = "";
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if(json[i].workingStatus===""){
                           workingStatus =   json[i].toDate;
                        }else{
                           workingStatus =   'Till Date';
                        }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].experienceType,
                        json[i].orgName,
                        json[i].designation,                        
                        json[i].fromDate,
                        workingStatus,
                        '<a href="javascript:" class="editRecord"  expid="'+json[i].student_exp_id+'" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="javascript:" class="deleteRecord" expid="'+json[i].student_exp_id+'"   title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                    ]);
                }
            }
        });
    }
    $(document).on('click','.editRecord',function(){
        var expid    =   $(this).attr('expid');  
        if(expid!==""){
            $.ajax({
            type: "POST",
            url: "<?php echo site_url("Student/getExperienceDetails");?>",
            data:{student_exp_id:expid},
            success: function (response) {
                if(response!==""){
                    var json = $.parseJSON(response);  
                    $("#student_exp_id").val(json[0].student_exp_id);
                    $("#experienceType").val(json[0].experienceType);
                    $("#orgName").val(json[0].orgName);                     
                    $("#designation").val(json[0].designation);
                    $("#startDate").val(json[0].startDate);
                    if(json[0].workingStatus==="Working"){
                        $("#workingStatus").prop("checked",true);
                        $("#endDate").prop("readonly",true);
                        $("#endDate").attr("data-validation","");
                        $("#endDate").prop("min",json[0].startDate);
                    }else{
                        $("#endDate").val(json[0].endDate);
                        $("#endDate").prop("readonly",false);
                        $("#endDate").attr("data-validation","required");
                        $("#endDate").prop("min",json[0].startDate);
                    }
                     
                } 
            }
        });
        }
    });
     $(document).on('click','.deleteRecord',function(){
        var student_exp_id  =   $(this).attr('expid');
        
        if(student_exp_id!==""){
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
            url: "<?php echo site_url("Student/delExperienceDetail");?>",
            data:{student_exp_id:student_exp_id},
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
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
            },
                error: function (response) {
                    $.alert({
                            title: 'Error!', content: response, type: 'red',
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
            }
            });
            
        }
    });
});
</script>
 

