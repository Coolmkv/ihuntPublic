<?php
include_once 'student_header.php';
if (isset($profileinfo)) {

    $sssd_id = $profileinfo->sssd_id;
    $class_name = $profileinfo->class_name;
    $school_name = $profileinfo->school_name;
    $orgId = $profileinfo->orgId;
    $classTypeId = $profileinfo->classTypeId;
    $markingValue = $profileinfo->markingValue;
    $markingTypes = $profileinfo->markingType;
    $passing_year = $profileinfo->passing_year;
    $board = $profileinfo->board;
    $countryId = $profileinfo->countryId;
    $state = $profileinfo->stateId;
    $cityId = $profileinfo->cityId;
    $school_address = $profileinfo->school_address;
} else {
    $sssd_id = 'no_id';
    $class_name = '';
    $school_name = '';
    $orgId = '';
    $classTypeId = "";
    $markingValue = '';
    $markingTypes = '';
    $passing_year = '';
    $board = '';
    $percentages = '';
    $countryId = '';
    $state = '';
    $cityId = '';
    $school_address = '';
}
echo $map['js'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Student Secondary School Details Edit
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student'); ?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Edit | Insert Secondary School Details</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Secondary School Details Edit</h3>
                        </div>
                        <?php echo form_open('student/secodarySchoolDetails', ["name" => "secondary_school_details", "id" => "secondary_school_details"]); ?>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" class="hidden" value="<?php echo $sssd_id ?>" name="sssd_id">
                                <input type="hidden" class="hidden" value="<?php echo $orgId; ?>" name="schoolOrg_id" id="schoolOrg_id">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Class:</label>
                                    <select name="studentClass" id="class_id" class="form-control" data-validation="required"></select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">Stream:</label>
                                    <select name="classTypeId" id="stream_id" class="form-control" data-validation="required">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">School Name:</label>
                                    <input type="text" autocomplete="off" placeholder="School Name" id="SchoolName" name="SchoolName" value="<?php echo $school_name; ?>"  data-validation="required" class="form-control">
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
                                    <input type="date"   id="passingyear" name="passingyear" value="<?php echo $passing_year; ?>"  data-validation="required" class="form-control">
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
                                    <select name="ctyname" id="ctyname" class="form-control" data-validation="required">
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label class="control-label">School Address:</label>
                                    <input type="text"   id="location" name="location" value="<?php echo $school_address; ?>"  data-validation="required" class="form-control">
                                    <div class="hidden"><?php echo $map['html']; ?></div>
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
            <?php include_once 'student_footer.php'; ?>
            <script>
                $(".profile_link").addClass("active");
                $(".edit_secondary_link").addClass("active");
                document.title = "iHuntBest | Student Secondary School Details Edit";
                function getClassName(classname, selVal = '') {
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
                                    data = data + '<option value="' + rjson[i].classTypeId + '">' + rjson[i].title + '</option>';
                                }
                                $("#stream_id").html(data);
                                $("#stream_id").val(selVal);
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
                function classNames(selval, position) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('home/getClassNames'); ?>",
                        success: function (response) {
                            if (response) {
                                var json = $.parseJSON(response);
                                var data = '<option value="">Select</option>';
                                for (var i = 0; i < json.length; i++) {
                                    data = data + '<option value="' + json[i].classTitle + '">' + json[i].classTitle + '</option>';
                                }
                                $("#" + position).html(data);
                                $("#" + position).val(selval);
                            }
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
                $(document).ready(function () {
                    $.validate({
                        lang: 'en'
                    });
                    classNames('<?php echo $class_name; ?>', 'class_id');
                    var class_name = '<?php echo $class_name; ?>';
                    if (class_name) {
                        getClassName(class_name, '<?php echo $classTypeId; ?>');
                    }

                    $(document).on('change', '#class_id', function () {
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
                        url: "<?php echo site_url('student/getSchoolNames'); ?>",
                        data: 'keyword=' + $(this).val(),
                        beforeSend: function () {
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
                                autocomplete(document.getElementById('SchoolName'), arrs, ids, document.getElementById('schoolOrg_id'));
                            } else {
                                $("#suggesstion-box").html('');
                                $("#SchoolName").css("background", "#FFF");
                                $("#schoolOrg_id").val("0");
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
                        inpid.value = "";
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
