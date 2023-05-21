<?php
include_once 'student_header.php';

if (isset($profileinfo)) {

    $ssssd_id = $profileinfo->ssssd_id;
    $classTypeId = $profileinfo->classTypeId;
    $class_name = $profileinfo->class_name;
    $school_name = $profileinfo->school_name;
    $orgId = $profileinfo->orgId;
    $passing_year = $profileinfo->passing_year;
    $markingValue = $profileinfo->markingValue;
    $markingTypes = $profileinfo->markingType;
    $board = $profileinfo->board;
    $countryId = $profileinfo->countryId;
    $state = $profileinfo->stateId;
    $cityId = $profileinfo->cityId;
    $school_address = $profileinfo->school_address;
} else {
    $ssssd_id = 'no_id';
    $classTypeId = '';
    $class_name = '';
    $school_name = '';
    $orgId = '';
    $passing_year = '';
    $board = '';
    $markingValue = '';
    $markingTypes = '';
    $countryId = '';
    $state = '';
    $cityId = '';
    $school_address = '';
    $grade = "";
}
echo $map['js'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Student Sr. Secondary School Details Edit
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student'); ?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Edit | Insert Sr. Secondary School Details</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Secondary Sr. School Details Edit</h3>
                        </div>
                        <?php echo form_open('student/secodarySecSchoolDetails', ["name" => "form_details", "id" => "form_details"]); ?>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" class="hidden" value="<?php echo $ssssd_id; ?>" name="ssssd_id">
                                <input type="hidden" class="hidden" value="<?php echo $orgId; ?>" name="schoolOrg_id" id="schoolOrg_id">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Class:</label>
                                    <select name="class_name" id="class_id" class="form-control" data-validation="required">
                                        <option value="">Select</option>
                                        <option <?php echo ($class_name === "11th" ? 'selected' : ''); ?> value="11th">11th</option>
                                        <option <?php echo ($class_name === "12th" ? 'selected' : ''); ?> value="12th">12th</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Stream:</label>
                                    <select name="classTypeId" id="stream_id" class="form-control" data-validation="required">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group autocomplete">
                                    <label class="control-label">School Name:</label>
                                    <input autocomplete="off" type="text" placeholder="School Name" id="SchoolName" name="school_name" value="<?php echo $school_name; ?>"  data-validation="required" class="form-control">
                                    <div class="col-lg-4" style="z-index: 9999; margin-left: -17px;width: 29%;position: fixed;" id="suggesstion-box"></div>
                                </div>

                                <div class="col-lg-12 nopadding">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                        <label class="control-label">Board Name:</label>
                                        <input type="text" placeholder="Board Name" id="boardName" name="boardName" value="<?php echo $board; ?>"  data-validation="required" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group" style="margin-bottom: 0px;">
                                        <label class="control-label">Marks Type:</label>
                                        <select name="markingType" id="markingType_id" class="form-control" data-validation="required" >
                                            <option value="">Select</option>
                                            <?php
                                            if (isset($markingType)) {
                                                foreach ($markingType as $mt) {
                                                    echo '<option value="' . $mt->markingTitle . '"  ' . ($markingTypes == $mt->markingTitle ? "selected" : "") . '>' . $mt->markingTitle . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="help-block hidden">
                                            <a href="javascript:" id="addMarkingType">Add Marking Type? Click Here <i class="fa fa-plus"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group marks">
                                        <label class="control-label">Marking Value:</label>
                                        <input type="text" placeholder="90, 400,A+ etc." id="markingValue_id" name="markingValue" value="<?php echo $markingValue; ?>"  required="true" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Year of Passing:</label>
                                    <input type="date"   id="passingyear" name="passing_year" value="<?php echo $passing_year; ?>"  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Country:</label>
                                    <select name="countryId" id="country" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">State:</label>
                                    <select name="stateId" id="state" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">City:</label>
                                    <select name="ctyname" id="ctyname" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">School Address:</label>
                                    <input type="text"   id="location" name="school_address" value="<?php echo $school_address; ?>"  data-validation="required" class="form-control">
                                    <div class="hidden"><?php echo $map['html']; ?></div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group marks">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Subject Wise Marks</h3>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12" id="subjects">
                                    <?php
                                    if (isset($profileinfo)) {
                                        $subjectIds = $profileinfo->subjectIds;
                                        if ($subjectIds != "") {
                                            $subjectId = explode(',', $subjectIds);
                                            $maxmarks = explode(',', $profileinfo->maxmarks);
                                            $obtMarks = explode(',', $profileinfo->obtMarks);
                                            for ($i = 0; $i < count($subjectId); $i++) {
                                                echo '<div class="col-md-12 col-sm-12 nopadding" id="subjects' . $i . '">
                                                        <div class="col-md-3 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="Title">Subject</label>
                                                                <select class="form-control subject prevs" subjectId="' . base64_encode($subjectId[$i]) . '" name="subjectId[]" id="subjectId' . $i . '"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="Title">Max Marks</label>
                                                                <input type="number" min="0" value="' . $maxmarks[$i] . '" class="form-control maxMarks" numbr="' . $i . '" name="maxMarks[]" id="maxMarks' . $i . '">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="Title">Obt Marks</label>
                                                                <input type="number" min="0" value="' . $obtMarks[$i] . '" class="form-control obtMarks" numbr="' . $i . '" name="obtMarks[]" id="obtMarks' . $i . '">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12">
                                                            <br>
                                                            <div class="form-group">
                                                                ' . ($i == 0 ? '<button type="button" onclick="addSubject();" class="btn btn-primary">+</button>' :
                                                        '<a href="javascript:" onclick="removediv(\'subjects' . $i . '\');" class="remove_field fa fa-remove"></a>') . '
                                                            </div>
                                                        </div>
                                                    </div>    ';
                                            }
                                        } else {
                                            echo '<div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Subject</label>
                                            <select class="form-control subject" name="subjectId[]" id="subjectId"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Max Marks</label>
                                            <input type="number" min="0" class="form-control maxMarks" numbr="0" name="maxMarks[]" id="maxMarks">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="Title">Obt Marks</label>
                                            <input type="number" min="0" class="form-control obtMarks" numbr="0" name="obtMarks[]" id="obtMarks">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <br>
                                        <div class="form-group">
                                            <button type="button" onclick="addSubject();" class="btn btn-primary">+</button>
                                        </div>
                                    </div>';
                                        }
                                    }
                                    ?>

                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>

                </section>
                <!-- /.content -->
            </div>
            <div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3><i class="fa fa-book m-r-5"></i> Add Subject</h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo form_open('student/addNewSubject', ["id" => "subject_form"]); ?>
                                    <fieldset>
                                        <!-- Text input-->
                                        <input type="hidden" id="subjectInputId" class="hidden">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">Subject Name:</label>
                                            <input type="text" placeholder="Subject Name" id="subjectName" name="subjectName" data-validation="required" class="form-control">
                                        </div>

                                        <div class="col-md-12 form-group user-form-group">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-primary" id="add_subject">
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

            <?php
            include_once 'student_footer.php';
            if (isset($subjectNames)) {
                $arr = '';
                foreach ($subjectNames as $sn) {
                    $arr = $arr . '"' . $sn->subjectId . '^' . $sn->subjectTitle . '"' . ',';
                }
                $arrs = rtrim($arr, ',');
            } else {
                $arrs = '';
            }
            ?>
            <script>
                $(".profile_link").addClass("active");
                $(".edit_srsec_link").addClass("active");

                var subjectNames = [<?php echo $arrs; ?>];
                getSubject('', 'subjectId');
                document.title = "iHuntBest | Student Senior Secondary School Details Edit";
<?php echo ($classTypeId !== "" ? 'getClassName(\'' . $class_name . '\');' : ""); ?>
                function removediv(id) {

                    $('#' + id).remove();
                }
                function addSubject() {
                    var count = $('.subject').length;
                    if (count === '')
                    {
                        return false;
                    }
                    $("#subjects").append('<div class="col-lg-12 col-md-12 nopadding" id="subjects' + count + '"> \n\
                                                <div class="col-md-3 col-sm-12">\n\
                                                    <div class="form-group">\n\
                                                        <label for="Title">Subject</label>\n\
                                                        <select class="form-control subject" name="subjectId[]"  id="subjectId' + count + '"></select>\n\
                                                    </div>\n\
                                                </div>\n\
                                                <div class="col-md-3 col-sm-12">\n\
                                                    <div class="form-group">\n\
                                                        <label for="Title">Max Marks</label>\n\
                                                        <input type="number" min="0" class="form-control maxMarks"  numbr="' + count + '" name="maxMarks[]" id="maxMarks' + count + '">\n\
                                                    </div>\n\
                                                </div>\n\
                                                <div class="col-md-3 col-sm-12">\n\
                                                    <div class="form-group">\n\
                                                        <label for="Title">Obt Marks</label>\n\
                                                        <input type="number" min="0" class="form-control obtMarks" numbr="' + count + '" name="obtMarks[]" id="obtMarks' + count + '">\n\
                                                    </div> \n\
                                                </div> \n\
                                                <div class="col-md-3 col-sm-12">\n\
                                                    <br>\n\
                                                    <div class="form-group">\n\
                                                        <a href="javascript:" onclick="removediv(\'subjects' + count + '\');" class="remove_field fa fa-remove"></a>\n\
                                                    </div>\n\
                                                </div>\n\
                                            </div>');
                    getSubject('', 'subjectId' + count);
                }
                function getSubject(selVal, position, added = '') {


                    if (subjectNames.length === 0 || added === 'again') {
                        $.ajax({
                            url: '<?php echo site_url('student/getSubjectNames'); ?>',
                            type: 'POST',
                            success: function (response) {
                                var rjson = $.parseJSON(response);
                                var data = '<option value="">Select</option>';
                                if (rjson !== "") {

                                    for (var i = 0; i < rjson.length; i++) {
                                        subjectNames[rjson[i].subjectId] = rjson[i].subjectTitle;
                                        data = data + '<option value="' + rjson[i].subjectId + '">' + rjson[i].subjectTitle + '</option>';
                                    }
                                }
                                data = data + '<option value="Other">Other</option>';
                                $("#" + position).html(data);
                                $("#" + position).val(selVal);
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
                        });
                    } else {
                        subjectNamesShow(position, selVal);
                }

                }
                function getClassName(classname) {
                    var ctype = '<?php echo $classTypeId; ?>';
                    if (classname === "") {
                        $.alert({
                            title: 'Error!', content: "Class Name Should not be empty", type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.herf = "studentSenSecondarySchoolDetails";
                                }
                            }
                        });
                    } else {
                        $.ajax({
                            url: "<?php echo site_url("Student/getClassTypeName"); ?>",
                            type: 'POST',
                            data: {classname: classname},
                            success: function (response) {
                                var rjson = $.parseJSON(response);
                                var data = '<option value="">Select</option>';
                                for (var i = 0; i < rjson.length; i++) {
                                    if (ctype === rjson[i].classTypeId) {
                                        data = data + '<option selected value="' + rjson[i].classTypeId + '">' + rjson[i].title + '</option>';
                                    } else {
                                        data = data + '<option value="' + rjson[i].classTypeId + '">' + rjson[i].title + '</option>';
                                    }

                                }
                                $("#stream_id").html(data);
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
                        });
                    }
                }
                $(document).ready(function () {
                    setvaluessub();
                    function setvaluessub() {
                        $(".prevs").each(function () {
                            var selValue = $(this).attr('subjectid');
                            var position = $(this).attr('id');
                            getSubject(selValue, position);
                        });
                    }

                    $(document).on('change', '.subject', function () {
                        if ($(this).val() === "Other") {
                            $("#subjectInputId").val($(this).attr('id'));
                            $("#addSubject").modal('show');
                        }
                    });
                    $('#add_subject').click(function () {
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
                                                $("#addSubject").modal('hide');
                                                getSubject('', $("#subjectInputId").val(), 'again');
                                                $('#' + $("#subjectInputId").val()).focus();
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({title: 'Error!', content: json.msg, type: 'red',
                                        typeAnimated: true});
                                }

                            },
                            error: function (response) {
                                $('#error').html(response);
                            }
                        };
                        $('#subject_form').ajaxForm(options);
                    });
                    $.validate({
                        lang: 'en'
                    });
                    getSubject('', 'subjectId');
                    $("#class_id").change(function () {
                        var classname = $(this).val();
                        getClassName(classname);
                    });
                    $("#country").change(function () {
                        getcountryByStates($(this).val(), '', '#state');
                    });
                    $("#state").change(function () {
                        getStateByCity($(this).val(), '', '#ctyname');
                    });
                    getCountries('#country', '<?php echo $countryId; ?>');
                    function getCountries(countryId, db_countryId) {
                        $.ajax({
                            url: "<?php echo site_url('Home/getCountriesJson'); ?>",
                            type: 'POST',
                            data: '',
                            success: function (response) {
                                var cid = '';
                                var json = $.parseJSON(response);
                                var data = '<option value="">Country</option>';
                                for (var i = 0; i < json.length; i++) {
                                    if (db_countryId == json[i].countryId) {
                                        cid = 'selected';
                                        getcountryByStates(json[i].countryId, '<?php echo $state; ?>', '#state');
                                    } else {
                                        cid = '';
                                    }
                                    data = data + '<option ' + cid + '  value="' + json[i].countryId + '">' + json[i].name + '</option>';
                                }
                                $(countryId).html(data);
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
                        });
                    }
                    function getcountryByStates(countryId, selected_stateId, stateId) {
                        $.ajax({
                            url: "<?php echo site_url('Home/getStatesByCountry'); ?>",
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
                        });
                    }
                    getStateByCity('<?php echo $state; ?>', '<?php echo $cityId; ?>', '#ctyname');
                    function getStateByCity(stateId, selected_cityId, cityId) {
                        $.ajax({
                            url: "<?php echo site_url('Home/getCityByStates') ?>",
                            type: 'POST',
                            data: 'stateId=' + stateId,
                            success: function (response) {
                                var json = $.parseJSON(response);
                                var data = '<option value="">City</option>';
                                for (var i = 0; i < json.length; i++) {
                                    data = data + '<option value="' + json[i].cityId + '">' + json[i].name + '</option>';
                                }
                                $(cityId).html(data);
                                $(cityId).val(selected_cityId);
                            }
                        });
                    }
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
                                $('#error').html(response);
                            }
                        };
                        $('#form_details').ajaxForm(options);
                    });
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('student/getSchoolNames'); ?>",
                        data: 'keyword=' + $(this).val(),
                        beforeSend: function () {

                        },
                        success: function (data) {
                            if (data === "NotFound") {
                                $("#suggesstion-box").show();
                                $("#suggesstion-box").html(data);
                                $("#SchoolName").css("background", "#FFF");
                            } else {
                                var jsona = $.parseJSON(data);
                                var arrs = [];
                                var ids = [];
                                for (x in jsona) {
                                    arrs[x] = jsona[x].orgName;
                                    ids[x] = jsona[x].orgId;
                                }
                                autocomplete(document.getElementById('SchoolName'), arrs, ids, document.getElementById('schoolOrg_id'));
                            }
                        }
                    });
                });
                function autocomplete(inp, arr, ids, inpid) {

                    /*the autocomplete function takes two arguments,
                     the text field element and an array of possible autocompleted values:*/
                    var currentFocus;
                    /*execute a function when someone writes in the text field:*/
                    inp.addEventListener("input", function (e) {
                        var a, b, i, val = this.value;
                        /*close any already open lists of autocompleted values*/
                        closeAllLists();
                        if (!val) {
                            return false;
                        }
                        currentFocus = -1;
                        /*create a DIV element that will contain the items (values):*/
                        a = document.createElement("DIV");
                        a.setAttribute("id", this.id + "autocomplete-list");
                        a.setAttribute("class", "autocomplete-items");
                        /*append the DIV element as a child of the autocomplete container:*/
                        this.parentNode.appendChild(a);
                        /*for each item in the array...*/
                        for (i = 0; i < arr.length; i++) {
                            /*check if the item starts with the same letters as the text field value:*/
                            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                                /*create a DIV element for each matching element:*/
                                b = document.createElement("DIV");
                                /*make the matching letters bold:*/
                                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                                b.innerHTML += arr[i].substr(val.length);
                                /*insert a input field that will hold the current array item's value:*/
                                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                                b.innerHTML += "<input type='hidden' value='" + ids[i] + "'>";
                                /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function (e) {
                                    /*insert the value for the autocomplete text field:*/
                                    inp.value = this.getElementsByTagName("input")[0].value;
                                    inpid.value = this.getElementsByTagName("input")[1].value;
                                    /*close the list of autocompleted values,
                                     (or any other open lists of autocompleted values:*/
                                    closeAllLists();
                                });
                                a.appendChild(b);
                            }
                        }
                    });
                    /*execute a function presses a key on the keyboard:*/
                    inp.addEventListener("keydown", function (e) {
                        var x = document.getElementById(this.id + "autocomplete-list");
                        inpid.value = "";
                        if (x)
                            x = x.getElementsByTagName("div");
                        if (e.keyCode == 40) {
                            /*If the arrow DOWN key is pressed,
                             increase the currentFocus variable:*/
                            currentFocus++;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 38) { //up
                            /*If the arrow UP key is pressed,
                             decrease the currentFocus variable:*/
                            currentFocus--;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 13) {
                            /*If the ENTER key is pressed, prevent the form from being submitted,*/
                            e.preventDefault();
                            if (currentFocus > -1) {
                                /*and simulate a click on the "active" item:*/
                                if (x)
                                    x[currentFocus].click();
                            }
                        }
                    });
                    function addActive(x) {
                        /*a function to classify an item as "active":*/
                        if (!x)
                            return false;
                        /*start by removing the "active" class on all items:*/
                        removeActive(x);
                        if (currentFocus >= x.length)
                            currentFocus = 0;
                        if (currentFocus < 0)
                            currentFocus = (x.length - 1);
                        /*add class "autocomplete-active":*/
                        x[currentFocus].classList.add("autocomplete-active");
                    }
                    function removeActive(x) {
                        /*a function to remove the "active" class from all autocomplete items:*/
                        for (var i = 0; i < x.length; i++) {
                            x[i].classList.remove("autocomplete-active");
                        }
                    }
                    function closeAllLists(elmnt) {
                        /*close all autocomplete lists in the document,
                         except the one passed as an argument:*/
                        var x = document.getElementsByClassName("autocomplete-items");
                        for (var i = 0; i < x.length; i++) {
                            if (elmnt != x[i] && elmnt != inp) {
                                x[i].parentNode.removeChild(x[i]);
                            }
                        }
                    }
                    /*execute a function when someone clicks in the document:*/
                    document.addEventListener("click", function (e) {
                        closeAllLists(e.target);
                    });
                }
            </script>
