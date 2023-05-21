<?php if(isset($OrgCourse)){
    $orgCourseId  =   $OrgCourse->orgCourseId;
    $courseId     =   $OrgCourse->courseId;
    $courseFee    =   $OrgCourse->courseFee;
    $courseTypeId =   $OrgCourse->courseTypeId;
    $tdId         =   $OrgCourse->courseDurationId;
    $cDType       =   $OrgCourse->courseDurationType;
    $cFeeType     =   $OrgCourse->courseFeeType_Id; 
    $percentages  =   $OrgCourse->reqPercentages; 
    $reqCourses   =   "";
    $reqCourses   =   $reqCourses.($OrgCourse->reqCourseTitle?$OrgCourse->reqCourseTitle:"");
    $reqCourses   =   $reqCourses.($OrgCourse->reqClass?$OrgCourse->reqClass:"");
    $reqCourses   =   $reqCourses.($OrgCourse->reqInsTitle?$OrgCourse->reqInsTitle:"");
    $reqCourses   =   $reqCourses.($OrgCourse->reqCompExam?$OrgCourse->reqCompExam:"");
    $reqTables    =   $OrgCourse->reqTableNames; 
    $expDTypes    =   $OrgCourse->expDurationTypes;
    $expDurtnIds  =   $OrgCourse->expDurationIds;
    $descriptions =   $OrgCourse->descriptions;
    $reqMinQualId =   $OrgCourse->reqcourseMinQualId;
    $timeDurtns   =   $OrgCourse->timeDurationtitles;
    $regFee       =   $OrgCourse->registrationFee;
    $fromDate     =   $OrgCourse->fromDate;
    $toDate       =   $OrgCourse->toDate;
    $openingDate  =   $OrgCourse->openingDate;
    $closingDate  =   $OrgCourse->closingDate;
    $examDate     =   $OrgCourse->examDate;  
    
} ?>                
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Courses</h3>
                        </div>
                         
                        <?php echo form_open('college/addSaveCourse',["name"=>"course_form","id"=>"course_form"]);?>        
                             <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="<?php echo $orgCourseId;?>">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Course Type</label>
                                            <select name="courseTypeId" id="courseTypeId" class="form-control" data-validation="required">
                                                <?php if(isset($coursetype)){
                                                    echo '<option value="">Select</option>';
                                                    foreach ($coursetype as $ct){
                                                        echo '<option '.($courseTypeId==$ct->ctId?"selected":"").' value="'.$ct->ctId.'">'.$ct->courseType.'</option>';
                                                    }
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Course</label>
                                            <select name="courseId" id="courseId" class="form-control" data-validation="required"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Time Duration</label>
                                            <select name="timeDurationId" id="timeDurationId" class="form-control" data-validation="required">
                                                <?php if(isset($durationType)){
                                                    echo '<option value="">Select</option>';
                                                    foreach($durationType as $dt){
                                                        echo '<option '.($tdId==$dt->tdId?"selected":"").' value="'.$dt->tdId.'">'.$dt->title.'</option>';
                                                    }
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Duration Type</label>
                                            <select name="courseDurationType" id="courseDurationType" class="form-control" data-validation="required">
                                            </select>
                                        </div>
                                    </div>
<!--                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Course Fee Type</label>
                                            <select name="courseFeeType" id="courseFeeType" class="form-control" data-validation="required">
                                                <option <?php // echo ($cFeeType==""?"selected":""); ?> value="">Select</option>
                                                <option <?php // echo ($cFeeType=="1"?"selected":""); ?> value="1">Annual Fee</option>
                                                <option <?php // echo ($cFeeType=="2"?"selected":""); ?> value="2">Half Yearly Fee</option>
                                                <option <?php // echo ($cFeeType=="3"?"selected":""); ?> value="3">Quarterly Fee</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Course Fee</label>
                                            <input type="number" value="<?php // echo $courseFee; ?>" name="courseFee" id="courseFee" class="form-control" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Registration Fee</label>
                                            <input type="number" name="registrationFee" id="registrationFee" value="<?php // echo $regFee; ?>" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Fee Submit Start Date</label>
                                            <input type="date" name="fromDate" value="<?php // echo $fromDate; ?>"  id="fromDate" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Fee Submit End Date</label>
                                            <input type="date" name="toDate" value="<?php // echo $toDate; ?>" id="toDate" class="form-control" >
                                        </div>
                                    </div>-->
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Application Start Date</label>
                                            <input type="date" name="openingDate" value="<?php echo $openingDate; ?>" id="openingDate" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Application End Date</label>
                                            <input type="date" name="closingDate" value="<?php echo $closingDate; ?>" id="closingDate" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Exam Date</label>
                                            <input type="date" name="examDate" value="<?php echo $examDate; ?>" id="examDate" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Add Courses Eligibility</h3>
                                </div> 
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Course Pre-requisites</h4>
                                        </div>
                                        <?php echo '<div class="col-lg-12 col-md-12" id="course_variant">';
                                        if($reqMinQualId!=""){
                                            $reqMinQualIds   =   explode(",",$reqMinQualId);
                                            $reqCourse       =   explode(",", $reqCourses);  
                                            $percentage      =   explode(",", $percentages);                                             
                                            $reqTable        =   explode(",", $reqTables);
                                            for($i=0;$i< count($reqMinQualIds);$i++){
                                                echo '<div id="divedit'.$i.'">
                                                    <div class="col-md-5 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="Title">Minimum Qualification required</label>
                                                            <select mintable="'.$reqMinQualIds[$i].','.$reqTable[$i].'" class="form-control min_qualification editfunction" name="min_qualification[]" id="min_qualification'.$i.'"></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="Title">Minimum Grade/Band/percentage/percentile</label>
                                                            <input type="text" class="form-control" name="min_percentage[]" value="'.$percentage[$i].'" id="min_percentage">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-sm-12">
                                                        <br>
                                                        <div class="form-group">
                                                            '.($i==0?'<button type="button" onclick="addPreRequisite();" class="btn btn-primary">+</button>':
                                                        '<a href="javascript:" onclick="removediv(\'divedit'.$i.'\');" class="fa fa-remove"></a>').'
                                                            
                                                        </div>
                                                    </div>
                                                </div>';
                                            }
                                            
                                        }else{
                                            echo '<div id="divedit">
                                                        <div class="col-md-5 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="Title">Minimum Qualification required</label>
                                                                <select class="form-control min_qualification" name="min_qualification[]" id="min_qualification"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="Title">Minimum Grade/Band/percentage/percentile</label>
                                                                <input type="text" class="form-control" name="min_percentage[]" id="min_percentage">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-12">
                                                            <br>
                                                            <div class="form-group">
                                                                <button type="button" onclick="addPreRequisite();" class="btn btn-primary">+</button>
                                                            </div>
                                                        </div>
                                                    </div>';
                                        }
                                        echo '</div>';
                                        ?>
                                        
                                         <div class="col-md-12">
                                            <h4>Experience Details</h4>
                                        </div>
                                        <div class="col-lg-12 col-md-12" id="experience_variant">
                                            <?php 
                                            if($expDTypes!=""){
                                                $expDType       =   explode(",", $expDTypes);
                                                $description    =   explode(",", $descriptions);
                                                $expDurtnId     =   explode(",", $expDurtnIds);
                                                for($i=0;$i<count($expDType);$i++){
                                                    echo '<div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Title">Experience Duration Type</label>
                                                        <select class="form-control" name="duration_type[]" id="duration_type'.$i.'" >
                                                            <option '.($expDType[$i]==''?'selected':'').' value="">Select</option>
                                                            <option '.($expDType[$i]=='Full Time'?'selected':'').' value="Full Time">Full Time</option>                                                        
                                                            <option '.($expDType[$i]=='Part Time'?'selected':'').' value="Part Time">Part Time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Title">Duration</label>
                                                        <select class="form-control experience_duration edittd" tdur="'.$expDurtnId[$i].'" name="experience_duration[]" id="experience_duration'.$i.'"  ></select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Title">Description</label>
                                                        <input type="text" class="form-control" name="description[]" value="'.$description[$i].'" id="description'.$i.'"   placeholder="Description">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <br>
                                                    <div class="form-group">
                                                    '.($i==0?'<button onclick="addExperienceDiv();" type="button" class="btn btn-primary">+</button>':
                                                        '<a href="javascript:" onclick="removediv(\'divedit'.$i.'\');" class="fa fa-remove"></a>').'
                                                         
                                                    </div>
                                                </div>';
                                                }
                                            }else{
                                                echo '<div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Title">Experience Duration Type</label>
                                                        <select class="form-control" name="duration_type[]" id="duration_type" >
                                                            <option value="">Select</option>
                                                            <option value="Full Time">Full Time</option>                                                        
                                                            <option value="Part Time">Part Time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Title">Duration</label>
                                                        <select class="form-control experience_duration" name="experience_duration[]" id="experience_duration"  ></select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Title">Description</label>
                                                        <input type="text" class="form-control" name="description[]" id="description"   placeholder="Description">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <br>
                                                    <div class="form-group">
                                                        <button onclick="addExperienceDiv();" type="button" class="btn btn-primary">+</button>
                                                    </div>
                                                </div>';
                                            }
                                                
                                                 
                                                
                                        
                                            
                                            ?>
                                        </div>
                                        <div class="col-md-12 col-sm-12 text-center">
                                            <div class="form-group" style="margin-top: 23px;">
                                                <label></label>
                                                <input type="submit" class="btn btn-primary" name="save_course" id="save_course" value="Save">
                                            </div>
                                        </div>
                                    </div>                                
                                </div>
                                
                            </div>
                        
                            
                        
                        <?php echo form_close(); ?>
                        <!--/.col -->
                    </div>
                </div>
<script type="text/javascript">
    function courseDurationType(){
        $.ajax({
            url: "<?php echo site_url('College/getCourseDurationType');?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Select</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].typeTile + '">' + json[i].typeTile  + '</option>';
                }
                $('#courseDurationType').html(data);
                $('#courseDurationType').val('<?php echo $cDType;?>');
            }, error: function(jqXHR, exception){                   
                            $.alert({
                                    title: 'Error!', content: jqXHR["status"]+" - "+ exception, type: 'red',
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
$('#courseTypeId').change(function () {
    var courseTypeId = $('#courseTypeId').val();
    var selected_cId = "";
    getcourseTypeBycourse(courseTypeId, selected_cId);
});
    $(document).ready(function(){
        courseDurationType();
        $.validate({
            lang: 'en'
        });
        minQualification("min_qualification");
        $(".editfunction").each(function(){
            var mintable    =   $(this).attr("mintable");
            var minid       =   $(this).attr("id");
            minQualifications(minid,mintable);
        });
        $(".edittd").each(function(){
            var minid      =   $(this).attr("id");
            var tdur       =   $(this).attr("tdur");
                timeDuration(minid,tdur);
             
        });
        getcourseTypeBycourse(<?php echo $courseTypeId;?>,<?php echo $courseId;?>);
        $('#save_course').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
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
                    }
                    else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true, });
                    }

                }, 
            error: function(jqXHR, exception){             
                    $.alert({
                            title: 'Error!', content: jqXHR["status"]+" "+ exception, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
            };
            $('#course_form').ajaxForm(options);
        });   
    });
    function getcourseTypeBycourse(ctId, selected_cId) {
        $.ajax({
            url: "<?php echo site_url('college/getcourseTypeBycourse');?>",
            type: 'POST',
            data: 'ctId=' + ctId,
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Course</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].cId + '">' + json[i].title + '</option>';
                }
                $('#courseId').html(data);
                $('#courseId').val(selected_cId);
            }
        });
    }
    timeDuration("experience_duration","");
    function minQualifications(min_qualification,selval){
        $.ajax({
                url: "<?php echo site_url('College/getMinQualification');?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose Min Qualification</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].courseId +','+json[i].tablename+'">' + json[i].courseName + '</option>';
                    }
                    $('#'+min_qualification).html(data);
                    $('#'+min_qualification).val(selval);
                }, error: function(jqXHR, exception){                   
                                $.alert({
                                        title: 'Error!', content: jqXHR["status"]+" - "+ exception, type: 'red',
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
</script>