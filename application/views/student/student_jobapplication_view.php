<?php include_once 'student_header.php'; 
echo $map['js'];
echo $map1['js'];
if(isset($jobprofile)){
    $job_profile_Id     =   $jobprofile->job_profile_Id;
    $post_to_apply      =   $jobprofile->post_to_apply;
    $preferlocation     =   $jobprofile->preffered_location;
    $about_you          =   $jobprofile->about_you;
    $presentLocation    =   $jobprofile->present_location;
    $expected_salary    =   $jobprofile->expected_salary;
    $present_salary     =   $jobprofile->present_salary;
    $notice_period      =   $jobprofile->notice_period;
    $skills             =   $jobprofile->skills;
}else{
    $job_profile_Id     =   "no_id";
    $post_to_apply      =   "";
    $preferlocation     =   "";
    $about_you          =   "";
    $presentLocation    =   "";
    $expected_salary    =   "";
    $present_salary     =   "";
    $notice_period      =   "";
    $skills             =   "";
}?>
<link rel="stylesheet" href="<?php echo base_url('css\css_tagit\jquery.tagit.css'); ?>" charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url('css\css_tagit\tagit.ui-zendesk.css'); ?>" charset="utf-8">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Job Preference Details
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student');?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Edit | Insert Job Preference Details</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border"> 
                            <h3 class="box-title">Job Preference Details <?php if(isset($profileinfo)){ echo '<i class="fa fa-check-circle-o text-green"></i>';}else{ echo '<i class="fa fa-times-circle-o text-red"></i>';}?></h3>
                        </div>
                        <?php echo form_open('student/insertJobProfileDetails',["name"=>"form_details","id"=>"form_details"]);?>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" class="hidden" value="<?php echo $job_profile_Id;?>" name="job_profile_Id" id="job_profile_Id"> 
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Post To Apply:</label>
                                    <input type="text" placeholder="Post To Apply" id="post_to_apply" name="post_to_apply" value="<?php echo $post_to_apply;?>"  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Preferred Location:</label>
                                    <input type="text" placeholder="Preferred Location" id="preffered_location" name="preffered_location" value="<?php echo $preferlocation;?>"  data-validation="required" class="form-control">
                                    <div class="hidden"><?php echo $map['html'];?></div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Present Location:</label>
                                    <input type="text" placeholder="Present Location" id="present_location" name="present_location" value="<?php echo $presentLocation;?>"  data-validation="required" class="form-control">
                                    <div class="hidden"><?php echo $map1['html'];?></div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Expected Salary:</label>
                                    <input type="text" placeholder="Expected Salary (Numbers)" id="expected_salary" name="expected_salary" value="<?php echo $expected_salary;?>"  data-validation="required" class="form-control numOnly">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Present Salary:</label>
                                    <input type="text" placeholder="Present Salary (Numbers)" id="present_salary" name="present_salary" value="<?php echo $present_salary;?>"  data-validation="required" class="form-control numOnly">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Notice Period:</label>
                                    <select name="notice_period" id="notice_period" class="form-control">
                                        <option <?php echo ($notice_period==""?'selected':'');?> value="">Select</option>
                                        <option <?php echo ($notice_period=="0"?'selected':'');?> value="0">No Notice</option>
                                        <option <?php echo ($notice_period=="1"?'selected':'');?> value="1">1 Month</option>
                                        <option <?php echo ($notice_period=="2"?'selected':'');?> value="2">2 Months</option>
                                        <option <?php echo ($notice_period=="3"?'selected':'');?> value="3">3 Months</option>
                                        <option <?php echo ($notice_period=="4"?'selected':'');?> value="4">4 Months</option>                                         
                                    </select>
                                </div>                                
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Key Skills:</label>
                                    <input type="text" class="form-control" id="keySkillsTags" value="<?php echo $skills;?>" name="keySkills" placeholder="Enter You Skills" data-validation="required">    
                                </div>
                                 <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">About You:</label>
                                    <textarea class="form-control" id="about_you" name="about_you" placeholder="Few Lines about you"><?php echo $about_you;?></textarea>    
                                </div> 
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">

                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
<!--                <div class="col-md-12 ">
                     general form elements 
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
                                            <th>Course Details</th>
                                            <th>College Details</th>
                                            <th>University Details</th> 
                                            <th>Marks Details</th>
                                            <th>Year of Passing</th>
                                            <th>Country Details</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        /.col 
                    </div>
                </div>-->
            </div>
            </div>    
        
    </section>
    <!-- /.content -->
</div>


<?php include_once 'student_footer.php';?>
<script src="<?php echo base_url('js\js_tagit\jquery-ui.min.js'); ?>" charset="utf-8"></script>
<script src="<?php echo base_url('js\js_tagit\tag-it.min.js'); ?>" charset="utf-8"></script>
<script>
$(function(){
        $('#keySkillsTags').tagit();
     });
</script>
<script>
$(".add_jobcategory_link").addClass("active"); 
document.title  =   "iHuntBest | Job Profile Details";
     
//    dataTable();
//    function dataTable(){ 
//        $.ajax({
//            type: "POST",
//            url: "<?php ?>",
//            data:{},
//            success: function (response) {
//                var json = $.parseJSON(response);
//                var oTable = $('table#details_table').dataTable();
//                var marksDetails = "";
//                oTable.fnClearTable();
//                for (var i = 0; i < json.length; i++) {
//                    if(json[i].grade===""){
//                           marksDetails =   json[i].obtMarks+'/'+json[i].maxMarks+'( '+json[i].percentage+' % )';
//                        }else{
//                           marksDetails =   json[i].grade;
//                        }
//                    oTable.fnAddData([
//                        (i + 1),
//                        json[i].ctitle+'('+json[i].streamtitle+')',
//                        json[i].collegeName+'('+json[i].college_address+')',
//                        json[i].universityName+'('+json[i].university_address+')',
//                        marksDetails,
//                        json[i].passingyear,
//                        json[i].ctyname+', '+json[i].stsname+', '+json[i].ctryname,
//                        '<a href="javascript:" class="editRecord"  shid="'+json[i].student_hed_id+'" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="javascript:" class="deleteRecord" shid="'+json[i].student_hed_id+'"   title="Delete"><i class="fa fa-trash-o"></i></i></a>',
//                    ]);
//                }
//            }
//        });
//    }
$(document).ready(function(){


    $.validate({
            lang: 'en'
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
//    $(document).on('click','.editRecord',function(){
//        var shid    =   $(this).attr('shid');  
//        if(shid!==""){
//            $.ajax({
//            type: "POST",
//            url: "<?php echo site_url("Student");?>",
//            data:{student_hed_id:shid},
//            success: function (response) {
//                if(response!==""){
//                    var json = $.parseJSON(response); 
//                    StreamName(json[0].course_name,json[0].streamId);
//                    CourseName(json[0].courseType,json[0].course_name);
//                    $("#student_hed_id").val(json[0].student_hed_id);
//                    $("#collegeOrg_id").val(json[0].college_orgId);
//                    $("#universityOrg_id").val(json[0].univ_orgId);                     
//                    $("#courseType_id").val(json[0].courseType);
//                    $("#collegeName").val(json[0].collegeName);
//                    $("#location").val(json[0].college_address);
//                    $("#universityName").val(json[0].universityName);
//                    $("#university_address").val(json[0].university_address);
//                    if(json[0].grade!==""){
//                        $("#marks").prop("checked",false);
//                        $("#grade").prop("checked",true);
//                        $(".marks").addClass('hidden');
//                        $(".grade").removeClass('hidden');
//                        $("#grade_id").val(json[0].grade);                        
//                    }else{
//                        $("#marks").prop("checked",true);
//                        $("#grade").prop("checked",false);
//                        $(".marks").removeClass('hidden');
//                        $(".grade").addClass('hidden');
//                        $("#obtmarks").val(json[0].obtMarks);
//                        $("#maxmarks").val(json[0].maxMarks); 
//                        $("#percentage").val(json[0].percentage);   
//                    }
//                    $("#passingyear").val(json[0].yearPassout);
//                    $("#country").val(json[0].countryId);
//                    getcountryByStates(json[0].countryId, json[0].stateId,'#state');
//                    getStateByCity('state', json[0].cityId,'#cityid');
//                } 
//            },
//                error: function (response) {
//                    $.alert({
//                            title: 'Error!', content: response, type: 'red',
//                            typeAnimated: true,
//                            buttons: {
//                                Ok: function () {
//                                    window.location.reload();
//                                }
//                            }
//                        });
//                }
//        });
//        }
//    });
//    $(document).on('click','.deleteRecord',function(){
//        var student_hed_id  =   $(this).attr('shid');
//        
//        if(student_hed_id!==""){
//            $.confirm({
//            title: 'Warning!',
//            content: "Are you sure to delete?",
//            type: 'red',
//            typeAnimated: true,
//            buttons: {
//                Cancel: function () {
//                    window.location.reload();
//                },
//                Confirm: function () {
//                    $.ajax({
//            type: "POST",
//            url: "<?php echo site_url("Student");?>",
//            data:{student_hed_id:student_hed_id},
//            success: function (response) {
//                var json = $.parseJSON(response);
//                 if (json.status === 'success') {
//                        $.alert({
//                            title: 'Success!', content: json.msg, type: 'blue',
//                            typeAnimated: true,
//                            buttons: {
//                                Ok: function () {
//                                    window.location.reload();
//                                }
//                            }
//                        });
//                    } else {
//                        $.alert({
//                            title: 'Error!', content: json.msg, type: 'red',
//                            typeAnimated: true,
//                            buttons: {
//                                Ok: function () {
//                                    window.location.reload();
//                                }
//                            }
//                        });
//                    }
//            },
//                error: function (response) {
//                    $.alert({
//                            title: 'Error!', content: response, type: 'red',
//                            typeAnimated: true,
//                            buttons: {
//                                Ok: function () {
//                                    window.location.reload();
//                                    }
//                                }
//                            });
//                        }
//                    });
//                }
//            }
//            });
//            
//        }
//    });
    <?php if(!isset($profileinfo)){    echo 'requiredfunction();';}?>
    
});
   function requiredfunction(){
       $("#save_details").addClass("hidden");
        alert("Please Complete your education Details");
        window.location =   '<?php echo site_url('studentSecondarySchoolDetails');?>';
    }

</script>
