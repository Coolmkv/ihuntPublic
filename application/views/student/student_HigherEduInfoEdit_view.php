<?php
include_once 'student_header.php';
if (isset($countryId)) {
    $countryId = $countryId;
    $state = $state;
    $cityId = $cityId;
} else {
    $countryId = "";
    $state = "";
    $cityId = "";
}
echo $map['js'];
echo $map2['js'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Higher Education Details
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student'); ?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Edit | Insert Higher Education Details</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Higher Education Details</h3>
                        </div>
                        <?php echo form_open('student/insertHigherEducationDetails', ["name" => "secondary_school_details", "id" => "secondary_school_details"]); ?>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" class="hidden" value="no_id" name="student_hed_id" id="student_hed_id">
                                <input type="hidden" class="hidden" value="" name="collegeOrg_id" id="collegeOrg_id">
                                <input type="hidden" class="hidden" value="" name="universityOrg_id" id="universityOrg_id">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Course Type:</label>
                                    <select name="courseType" id="courseType_id" class="form-control" data-validation="required">
                                        <option>Select Course</option>
                                        <?php
                                        if (isset($coursetypes)) {
                                            foreach ($coursetypes as $ct) {
                                                echo '<option value="' . $ct->ctId . '">' . $ct->courseType . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Course Name:</label>
                                    <select name="course_name" id="course_name_id" class="form-control" data-validation="required">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Stream Name:</label>
                                    <select name="streamId" id="stream_Id" class="form-control" data-validation="required">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group autocomplete">
                                    <label class="control-label">College Name:</label>
                                    <input type="text" placeholder="College Name" id="collegeName" name="collegeName" value=""  data-validation="required" class="form-control">

                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">College Address:</label>
                                    <input type="text"   id="location" name="college_address" value=""  data-validation="required" class="form-control">
                                    <div class="hidden"><?php echo $map['html']; ?></div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group autocomplete">
                                    <label class="control-label">University Name:</label>
                                    <input type="text" placeholder="University Name" id="universityName" name="universityName" value=""  data-validation="required" class="form-control">
                                    <div class="col-lg-4" style="z-index: 9999; margin-left: -17px;width: 29%;position: fixed;" id="suggesstion-box"></div>
                                </div>
                                <div class="col-lg-12 nopadding">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                        <label class="control-label">University Address:</label>
                                        <input type="text"   id="university_address" name="university_address" value=""  data-validation="required" class="form-control">
                                        <div class="hidden"><?php echo $map2['html']; ?></div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group" style="margin-bottom: 0px;">
                                        <label class="control-label">Marks Type:</label>
                                        <select name="markingType" id="markingType_id" class="form-control" data-validation="required" >
                                            <option value="">Select</option>
                                            <?php
                                            if (isset($markingType)) {
                                                foreach ($markingType as $mt) {
                                                    echo '<option value="' . $mt->markingTitle . '" >' . $mt->markingTitle . '</option>';
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
                                        <input type="text" placeholder="90, 400,A+ etc." id="markingValue_id" name="markingValue" value=""  required="true" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Year of Passing:</label>
                                    <input type="date"   id="passingyear" name="passingyear" value=""  data-validation="required" class="form-control">
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Country:</label>
                                    <select name="country" id="country" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">State:</label>
                                    <select name="state" id="state" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">City:</label>
                                    <select name="cityid" id="cityid" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">

                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
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
                        <!--/.col -->
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<?php include_once 'student_footer.php'; ?>
<script>
    $(".profile_link").addClass("active");
    $(".edit_pg_link").addClass("active");
    document.title = "iHuntBest | Higher Education Details";
    function CourseName(CourseType, selectedCourse) {
        if (CourseType === "") {
            $.alert({
                title: 'Error!', content: "Course Type can not be empty!", type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: function () {
                        window.location.herf = "studentSenSecondarySchoolDetails";
                    }
                }
            });
        } else {
            $.ajax({
                url: '<?php echo site_url('Student/getCourseNames'); ?>',
                type: 'POST',
                data: {CourseType: CourseType},
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].cId + '">' + json[i].title + '</option>';
                    }
                    $("#course_name_id").html(data);
                    $("#course_name_id").val(selectedCourse);
                    $("#stream_Id").val('');
                }

            });

        }
    }
    function StreamName(course_name, selStream) {
        if (course_name === "") {
            $.alert({
                title: 'Error!', content: "Course Name can not be empty!", type: 'red',
                typeAnimated: true,
                buttons: {
                    Ok: function () {
                        window.location.herf = "studentSenSecondarySchoolDetails";
                    }
                }
            });
        } else {
            $.ajax({
                url: '<?php echo site_url('Student/getStreamNames'); ?>',
                type: 'POST',
                data: {course_name: course_name},
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].streamId + '">' + json[i].title + '</option>';
                    }
                    $("#stream_Id").html(data);
                    $("#stream_Id").val(selStream);
                }

            });

        }
    }

    dataTable();
    function dataTable() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("Student/getHigherEduDetail"); ?>",
            data: {},
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#details_table').dataTable();
                var marksDetails = "";
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    marksDetails = json[i].markingValue + ' ' + json[i].markingType;
                    oTable.fnAddData([
                        (i + 1),
                        json[i].ctitle + '(' + json[i].streamtitle + ')',
                        json[i].collegeName + '(' + json[i].college_address + ')',
                        json[i].universityName + '(' + json[i].university_address + ')',
                        marksDetails,
                        json[i].passingyear,
                        json[i].ctyname + ', ' + json[i].stsname + ', ' + json[i].ctryname,
                        '<a href="javascript:" class="editRecord"  shid="' + json[i].student_hed_id + '" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="javascript:" class="deleteRecord" shid="' + json[i].student_hed_id + '"   title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                    ]);
                }
            }
        });
    }
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $("#courseType_id").change(function () {
            var CourseType = $(this).val();
            CourseName(CourseType, "");
        });
        $("#course_name_id").change(function () {
            var course_name = $(this).val();
            StreamName(course_name, "");
        });
        $("#country").change(function () {
            getcountryByStates($(this).val(), '', '#state');
        });
        $("#state").change(function () {
            getStateByCity($(this).val(), '', '#cityid');
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
                }
            });
        }
        //getStateByCity('<?php echo $state; ?>', '<?php echo $cityId; ?>','#ctyname');
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
            $('#secondary_school_details').ajaxForm(options);
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('student/getCollegeNames'); ?>",
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
//			$("#collegeName").css("background","#FFF url(<?php echo base_url('images/LoaderIcon.gif'); ?>) no-repeat 90%");
            },
            success: function (data) {
                if (data !== "NotFound") {
                    var jsona = $.parseJSON(data);
                    var arrs = [];
                    var ids = [];
                    for (x in jsona) {
                        arrs[x] = jsona[x].orgName;
                        ids[x] = jsona[x].orgId;
                    }
                    autocomplete(document.getElementById('collegeName'), arrs, ids, document.getElementById('collegeOrg_id'));
//                            var arr     =   data.split(",");
//                            autocomplete(document.getElementById("collegeName"), arr);
                } else {
                    alert(data);

                }
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('student/getUniversityNames'); ?>",
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
//			$("#universityName").css("background","#FFF url(<?php echo base_url('images/LoaderIcon.gif'); ?>) no-repeat 90%");
            },
            success: function (data) {
                if (data !== "NotFound") {
                    var jsona = $.parseJSON(data);
                    var arrs = [];
                    var ids = [];
                    for (x in jsona) {
                        arrs[x] = jsona[x].orgName;
                        ids[x] = jsona[x].orgId;
                    }
                    autocomplete(document.getElementById('universityName'), arrs, ids, document.getElementById('universityOrg_id'));

                } else {
                    $("#suggesstion-box").html('');
                    $("#universityName").css("background", "#FFF");
                    $("#universityOrg_id").val("0");
                }
            }
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
        $(document).on('click', '.editRecord', function () {
            var shid = $(this).attr('shid');
            if (shid !== "") {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("Student/getHigherEduDetail"); ?>",
                    data: {student_hed_id: shid},
                    success: function (response) {
                        if (response !== "") {
                            var json = $.parseJSON(response);
                            StreamName(json[0].course_name, json[0].streamId);
                            CourseName(json[0].courseType, json[0].course_name);
                            $("#student_hed_id").val(json[0].student_hed_id);
                            $("#collegeOrg_id").val(json[0].college_orgId);
                            $("#universityOrg_id").val(json[0].univ_orgId);
                            $("#courseType_id").val(json[0].courseType);
                            $("#collegeName").val(json[0].collegeName);
                            $("#location").val(json[0].college_address);
                            $("#universityName").val(json[0].universityName);
                            $("#university_address").val(json[0].university_address);
                            $("#markingType_id").val(json[0].markingType);
                            $("#markingValue_id").val(json[0].markingValue);
                            $("#passingyear").val(json[0].yearPassout);
                            $("#country").val(json[0].countryId);
                            getcountryByStates(json[0].countryId, json[0].stateId, '#state');
                            getStateByCity('state', json[0].cityId, '#cityid');
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
        $(document).on('click', '.deleteRecord', function () {
            var student_hed_id = $(this).attr('shid');

            if (student_hed_id !== "") {
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
                                url: "<?php echo site_url("Student/delHigherEduDetail"); ?>",
                                data: {student_hed_id: student_hed_id},
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
    function selectCollege(orgname, orgId) {
        $("#collegeName").val(orgname);
        $("#collegeOrg_id").val(orgId);
        $("#collegesuggesstion-box").hide();
    }
    function selectUniversity(orgname, orgId) {
        $("#universityName").val(orgname);
        $("#universityOrg_id").val(orgId);
        $("#suggesstion-box").hide();
    }

</script>
