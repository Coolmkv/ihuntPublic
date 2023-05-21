<?php include_once 'student_header.php'; ?>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Competitive Exam Details
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student');?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Edit | Insert Competitive Exam Details</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Competitive Exam Details</h3>
                        </div>
                        <?php echo form_open('student/insertCompetitveExamDetails',["name"=>"formDetails","id"=>"formDetails"]);?>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" class="hidden" value="no_id" name="studentCompExamId" id="studentCompExamId">                                 
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Exam Name:</label>
                                    <select name="c_exam_id" id="c_exam_id" class="form-control" data-validation="required">
                                        <option value="">Select</option>
                                         <?php 
                                         if(isset($examNames)){
                                             foreach ($examNames as $en){
                                                 echo '<option value="'.$en->c_exam_id.'">'.$en->exam_name.'</option>';
                                             }
                                             
                                         }
										 echo '<option value="other">Other</option>'; ?>
                                    </select>                                
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Exam Clearing Date:</label>
                                    <input type="date" max="<?php echo date('Y-m-d');?>" placeholder="Exam Clearing Date *" id="examClearingDate" name="examClearingDate" value=""  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Exam Valid Date:</label>
                                    <input type="date" placeholder="Exam Valid Date *" id="examValidDate" name="examValidDate" value=""  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Exam Result:</label>
                                    <input type="text"   id="examResult" name="examResult" placeholder="Exam Result *" value=""  data-validation="required" class="form-control">
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
                            <h3 class="box-title">Competitive Exam Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Exam Name</th>
                                            <th>Cleared On</th>
                                            <th>Valid Upto</th> 
                                            <th>Result</th>
                                            <th>Marking System</th>
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
 <!--/ for courses Modal start-->
<div class="modal fade" id="addExam" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-user m-r-5"></i> Add Exam</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                     <?php echo form_open('student/addreqExam',["name"=>"exam_form","id"=>"exam_form"]);?>        
                            <input type="hidden" name="id" id="id" value="no_one">
                            <fieldset>
                                <!-- Text input-->
                                <div class="col-md-6 col-sm-12 form-group">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select id="country" name="countryId" class="form-control">                                                 
                                        </select>                                            
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 form-group">
                                    <div class="form-group">
                                        <label>Exam Name</label>
                                        <input type="text" name="exam_name" id="exam_name_id" class="form-control" placeholder="Exam Name *" data-validation="required">                                    
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 form-group">
                                    <div class="form-group">
                                        <label>Marking System</label>
                                        <input type="text" name="marking_system" id="marking_system_id" class="form-control" title="eg: Grade,Marks" placeholder="Grade,Marks etc. *" data-validation="required">                                    
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 form-group">
                                    <div class="form-group">
                                        <label>Validity Time</label>
                                        <input type="text" name="validity_time" title="Exam Score Validity in Months" id="validity_time_id" placeholder="Exam Score Validity in Months" class="form-control" data-validation="required">                                    
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 form-group">
                                    <div class="form-group">
                                        <label>Type of Exam</label>
                                        <select id="typeOfexam_id" name="typeOfexam" class="form-control" data-validation="required">
                                             <option value="">Select</option>
                                             <option value="Entrance">Entrance</option>
                                             <option value="Scholarship">Scholarship</option>
                                             <option value="Both">Both</option> 
                                         </select>                             
                                    </div>
                                </div>
                                <div class="col-md-12 form-group user-form-group">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary" id="addExamRequest">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            <?php echo form_close(); ?>
                       </div>
                </div>
            </div>            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php include_once 'student_footer.php';?>
<script>
$(".profile_link").addClass("active");
$(".edit_ce_link").addClass("active");
document.title  =   "iHuntBest | Competitve Exam Details";

    dataTable();
    function dataTable(){ 
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("Student/getCompetitiveExamDetails");?>",
            data:{},
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#details_table').dataTable();                 
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    
                    oTable.fnAddData([
                        (i + 1),                       
                        json[i].exam_name,
                        json[i].cldate,
                        json[i].cvdate,                        
                        json[i].examResult,                       
                        json[i].marking_system,
                        '<a href="javascript:" class="editRecord"  rowId="'+json[i].studentCompExamId+'" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="javascript:" class="deleteRecord" rowId="'+json[i].studentCompExamId+'"   title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });
    }
$(document).ready(function(){
    $(".close").click(function(){
        $("#c_exam_id").val('');
    }); 
$("#examClearingDate").change(function(){
    $("#examValidDate").prop('min',$(this).val());
});
    $.validate({
            lang: 'en'
        }); 
    
    getCountries('#country','');
    function getCountries(countryId,db_countryId) {
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
                            getcountryByStates(json[i].countryId, '','#state');
                        }
                        else{
                            cid='';
                        }
                        data = data + '<option '+cid+'  value="' + json[i].countryId + '">' + json[i].name +'</option>';
                    }
                    $(countryId).html(data);
                }
            });
        }
    $('#save_details').click(function () {
            var options = {
                beforeSend: function () {
                    if($("#c_exam_id").val()==="other"){
                        $("#c_exam_id").val("");
                         $.alert({
                            title: 'Error!', content: "Please Select Valid Exam", type: 'red',
                            typeAnimated: true 
                            });
                        return false;
                        
                    }
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
            $('#formDetails').ajaxForm(options);
        });
    $(document).on('click','.editRecord',function(){
        var studentCompExamId    =   $(this).attr('rowId');  
        if(studentCompExamId!==""){
            $.ajax({
            type: "POST",
            url: "<?php echo site_url("Student/getCompetitiveExamDetails");?>",
            data:{studentCompExamId:studentCompExamId},
            success: function (response) {
                if(response!==""){
                    var json = $.parseJSON(response); 
                    $("#studentCompExamId").val(json[0].studentCompExamId);
                    $("#c_exam_id").val(json[0].c_exam_id);          
                    $("#examClearingDate").val(json[0].examClearingDate);
                    $("#examValidDate").val(json[0].examValidDate); 
                    $("#examResult").val(json[0].examResult);                     
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
    });
    $(document).on('click','.deleteRecord',function(){
       var studentCompExamId    =   $(this).attr('rowId'); 
        
        if(studentCompExamId!==""){
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
            url: "<?php echo site_url("Student/delCompetitiveExam");?>",
            data:{studentCompExamId:studentCompExamId},
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
    $("#c_exam_id").change(function(){
        if($(this).val()==="other"){
            $("#addExam").modal("show");
        }else{
            $("#addExam").modal("hide");
        }
    });
    $('#addExamRequest').click(function () {
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
            $('#exam_form').ajaxForm(options);
        });
});
</script>
