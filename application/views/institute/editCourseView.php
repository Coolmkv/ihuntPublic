<?php if(isset($OrgCourse)){
    $insDetailId  =   $OrgCourse->insCourseDetailsId;
    $insCourseId  =   $OrgCourse->insCourseId;
    $timeDurtnId  =   $OrgCourse->timeDurationId;
    $courseFee    =   $OrgCourse->courseFee;
    $totalSheet   =   $OrgCourse->totalSheet;
    $avlblSheet   =   $OrgCourse->availableSheet;
    $cDType       =   $OrgCourse->courseDurationType; 
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
    $feepaySdate  =   $OrgCourse->feepaySdate;
    $feepayEdate  =   $OrgCourse->feepayEdate;
    $applyFrom    =   $OrgCourse->applyFrom;
    $applyTo      =   $OrgCourse->applyTo;
    $examDate     =   $OrgCourse->examDate;
    
} ?>                
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Courses</h3>
                        </div>
                         
                        <?php echo form_open('institute/addSaveCourse',["name"=>"course_form","id"=>"course_form"]);?>        
                             <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="<?php echo $insDetailId;?>">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Course Type</label>
                                            <select name="courseTypeId" id="courseTypeId" class="form-control" data-validation="required">
                                                
                                            </select>
                                        </div>
                                    </div>                                     
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Time Duration</label>
                                            <select name="timeDurationId" id="timeDurationId" class="form-control" data-validation="required">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Duration Type</label>
                                            <select name="courseDurationType" id="courseDurationType" class="form-control" data-validation="required">
                                                <option <?php echo ($cDType==""?"selected":""); ?> value="">Select</option>
                                                <option <?php echo ($cDType=="Full Time"?"selected":""); ?> value="Full Time">Full Time</option>
                                                <option <?php echo ($cDType=="Part Time"?"selected":""); ?> value="Part Time">Part Time</option>
                                            </select>
                                        </div>
                                    </div>
                                     
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Course Fee</label>
                                            <input type="number" value="<?php echo $courseFee; ?>" name="courseFee" id="courseFee" class="form-control" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Total Seats</label>
                                            <input type="number" name="totalseats" id="totalseats" class="form-control" value="<?php echo $totalSheet; ?>" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Available Seats</label>
                                            <input type="number" name="avlseats" id="avlseats" class="form-control" value="<?php echo $avlblSheet; ?>" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Registration Fee</label>
                                            <input type="number" name="registrationFee" id="registrationFee" value="<?php echo $regFee; ?>" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Fee Submit Start Date</label>
                                            <input type="date" name="fromDate" value="<?php echo $feepaySdate; ?>"  id="fromDate" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Fee Submit End Date</label>
                                            <input type="date" name="toDate" value="<?php echo $feepayEdate; ?>" id="toDate" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Application Start Date</label>
                                            <input type="date" name="openingDate" value="<?php echo $applyFrom; ?>" id="openingDate" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Application End Date</label>
                                            <input type="date" name="closingDate" value="<?php echo $applyTo; ?>" id="closingDate" class="form-control" >
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
                                                            '.($i==0?'<button type="button" onclick="addPreRequisite();" class="btn btn-success">+</button>':
                                                        '<a href="javascript:" onclick="removediv(\'divedit'.$i.'\');" class=" btn btn-danger fa fa-remove"></a>').'
                                                            
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
                                                                <button type="button" onclick="addPreRequisite();" class="btn btn-success">+</button>
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
                                                    '.($i==0?'<button onclick="addExperienceDiv();" type="button" class="btn btn-success">+</button>':
                                                        '<a href="javascript:" onclick="removediv(\'divedit'.$i.'\');" class="fa fa-remove btn btn-danger"></a>').'
                                                         
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
                                                        <button onclick="addExperienceDiv();" type="button" class="btn btn-success">+</button>
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

    $(document).ready(function(){
        $.validate({
            lang: 'en'
        });
        getCourses(<?php echo $insCourseId;?>);
        timeDuration('timeDurationId',<?php echo $timeDurtnId;?>);
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
     
    timeDuration("experience_duration","");
    function minQualifications(min_qualification,selval){
        $.ajax({
                url: "<?php echo site_url('Institute/getMinQualification');?>",
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