<?php include_once 'shared/header.php'; ?>

<script src="<?php echo base_url('js/jquery.min.js'); ?>" type="text/javascript"></script> <!--
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>-->

<script src="<?php echo base_url('js/amazon_scroller.js'); ?>" type="text/javascript"></script>
<!--
<script src="<?php echo base_url(); ?>plugins/lightgallery/js/lightgallery-all.min.js" type="text/javascript"></script>  -->
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery.form.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/app.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!--<script src="<?php echo base_url(); ?>plugins/imagesLoaded.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/gallery.js" type="text/javascript"></script> -->
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>js/custom.js"></script>
<style>
    .itemwidth{
        width: 49.5%!important;
    }
</style>
<!------------------adds_start--------------------------->
<div class="container add-to">
    <div class="col-md-12">
        <div class="addimage"><img src="<?php echo base_url(); ?>images/add.png"/></div>
    </div>
</div>
<!------------------adds_end--------------------------->
<div class="container add-to-3">
    <div class="col-md-12">
        <div class="heading">
            <h2>EXPLORE ALMOST EVERYTHING</h2>
            <span class="bott-img"><img src="<?php echo base_url(); ?>images/head.png"/></span>
            <p>iHuntBest.com is an extensive search engine for the students, parents,<br>
                and education industry players who are seeking information</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img src="<?php echo base_url(); ?>images/1-icon.png"/></span>
                <div class="text-box">
                    <a href="#">FIND BEST COLLEGE</a>
                    <p>Learn about the best of bests in the country.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img src="<?php echo base_url(); ?>images/2-icon.png"/></span>
                <div class="text-box">
                    <a href="#">EXPLORE EXAMS</a>
                    <p>All information about the exams that will get you into your dream college.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img src="<?php echo base_url(); ?>images/3-icon.png"/></span>
                <div class="text-box text-box-to">
                    <a href="#">GET ADMISSION</a>
                    <p>Find information about the final step to colleges and courses.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img src="<?php echo base_url(); ?>images/4-icon.png"/></span>
                <div class="text-box">
                    <a href="#">TOP COURSES</a>
                    <p>Learn about various mix of courses offered across the country.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-color">
    <div class="container">
        <div class="col-md-12">
            <div class="heading animated fadeInUp" data-appear-top-offset="-200" data-animated="fadeInUp">
                <h2>Our <?php
                    if (isset($type)) {
                        $orgtype = $type;
                    } else {
                        $orgtype = "";
                    } echo $orgtype;
                    ?></h2>
                <span class="bott-img"><img src="<?php echo base_url(); ?>images/head.png"></span>

            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="filter animated" data-animation="fadeInDown" data-revert="fadeOutDown">
                    <div class="filter-to">
                        <h4>Filter Search</h4>
                        <p class="label-to"><?php echo $orgtype; ?> Name</p>
                        <div class="select-to3 autocomplete" id="orgaNames">
                            <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>"/>
                            <input type="text" class="filterinput" name="orgName" id="orgName" orgIds="" placeholder="<?php echo $orgtype; ?> Name" >
                        </div>

                        <p class="label-to">State</p>
                        <div class="select-to3">
                            <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>"/>
                            <select name="state" id="stateIdsel" ></select>
                        </div>
                        <p class="label-to">City</p>
                        <div class="select-to4">
                            <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>"/>
                            <select name="city" id="cityIdsel"  ></select>
                        </div>
                        <p class="label-to">Rating</p>
                        <div class="select-to4">
                            <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>"/>
                            <select name="rating" id="ratings"  >
                                <option value="">Select Ratings</option>
                                <option value="5">Stars 5</option>
                                <option value="4">Stars 4</option>
                                <option value="3">Stars 3</option>
                                <option value="2">Stars 2</option>
                                <option value="1">Stars 1</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group user-form-group">
                            <div class="pull-right">
                                <input type="submit" class="btn btn-primary" name="search" id="search" value="Search">
                            </div>
                        </div>
                        <!--                <a class="sub" href="javascript:">Submit</a><a href="#" class="sub-to">RESET</a>-->
                        <span class="all"><h2>ALL Visitors</h2><a href="#" class="sub-to" style="width:auto;    margin-right: 10px;">50000</a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <?php echo form_open("home/comapreOrganizations"); ?>
                <div id="container" class="hidden">
                    <p class="to-p">There are 0 boxes</p>
                    <input type="hidden" class="hidden" value='<?php echo $type; ?>' name="type">
                </div>
                <?php echo form_close(); ?>
                <div class="col-md-12" id="orgtypes">
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                            <h2>Top Rated <?php echo $type; ?></h2>
                            <a href="<?php echo site_url('allOrganizationDetails?Type=' . $type); ?>">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="box-sadow">
                        <div id="mixedSlider">
                            <div id="table" class="MS-content">
                                <?php
                                if (isset($TopRatedOrgDetails)) {

                                    foreach ($TopRatedOrgDetails as $od) {
                                        if ($od->availableSeats == "") {
                                            $availabesheets = 0;
                                        } else {
                                            $availabesheets = $od->availableSeats;
                                        }
                                        $avg = $od->ratings;

                                        $orgName = preg_replace("/\s+/", "-", $od->orgName);
                                        $btntype = ($od->orgButtonType === "Enroll" ? 'enrollnow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')' : 'enquiryNow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')');
                                        $btnName = ($od->orgButtonType === "Enroll" ? 'Enroll Now' : 'Enquire Now');

                                        $ratings = '';
                                        for ($ratingi = 1; $ratingi < 6; $ratingi++) {
                                            $ratings = $ratings . '<i class="fa fa-star ' . ($ratingi <= $avg ? 'staron' : 'staroff') . '" aria-hidden="true"></i>';
                                        }

                                        echo '<div class="item itemwidth">
                                        <div class="imgTitle">
                                          <span class="logo-co"><img src="' . base_url($od->orgLogo) . '" alt="" /></span>
                                            <h5 class="blogTitle width48 ellipsistext" title="' . $od->orgAddress . '"><i class="fa fa-map-marker" aria-hidden="true"></i>' . $od->orgAddress . '</h5>
                                             <span class="po-check">
                                              <a href="javascript:" class="more" onclick="compare(this);" orgname="' . $od->orgName . '"  loginid="' . $od->loginId . '"> + Add to compare</a>

                                               </span>
                                            <span class="name-to">Available Seats <b>' . $availabesheets . '</b></span>
                                            <img src="' . base_url($od->orgImgHeader) . '" alt="" />
                                        </div>
                                            <p><strong>' . $od->orgName . '</strong></p>
                                            <span class="name"><p><strong>Course Name </strong>: ' . $od->courseName . ' </p></span>
                                            <span class="name"><p>Eligibility/ Cutoff: optional , depends on college to do the validation</p></span>
                                            <span class="name"><p><strong>Fee</strong> : ' . $od->courseFee . ' </p></span>
                                            <span class="name"><p><strong>Ratings</strong> : ' . $ratings . ' </p></span>

                                        <div class=" clearfix"></div>
                                       <div class="col-lg-12">
                                            <div class="col-lg-6 text-center  ">
                                                <a href="' . site_url('OrganizationDetails/' . $od->loginId . '_' . $orgName) . '" class="to">View Details</a>
                                            </div>
                                            <div class="col-lg-6 text-center ">
                                            <a href="javascript:" onClick="' . $btntype . '"  class="to">' . $btnName . '</a>
                                            </div>
                                       </div>
                                    </div>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="MS-controls">
                                <button class="MS-left"><img src="<?php echo base_url(); ?>images/l-aerrow.png"/></button>
                                <button class="MS-right"><img src="<?php echo base_url(); ?>images/r-aerrow.png"/></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                            <h2>Latest <?php echo $type; ?></h2>
                            <a href="<?php echo site_url('allOrganizationDetails?Type=' . $type); ?>">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="box-sadow">
                        <div id="mixedSlider11">
                            <div id="table" class="MS-content">
                                <?php
                                if (isset($LatestOrgDetails)) {

                                    foreach ($LatestOrgDetails as $od) {
                                        if ($od->availableSeats == "") {
                                            $availabesheets = 0;
                                        } else {
                                            $availabesheets = $od->availableSeats;
                                        }
                                        $orgName = preg_replace("/\s+/", "-", $od->orgName);
                                        $loginId = base64_encode($od->loginId);
                                        $avg = $od->ratings;
                                        $btntype = ($od->orgButtonType === "Enroll" ? 'enrollnow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')' : 'enquiryNow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')');
                                        $btnName = ($od->orgButtonType === "Enroll" ? 'Enroll Now' : 'Enquire Now');

                                        $ratings = '';
                                        for ($ratingi = 1; $ratingi < 6; $ratingi++) {
                                            $ratings = $ratings . '<i class="fa fa-star ' . ($ratingi <= $avg ? 'staron' : 'staroff') . '" aria-hidden="true"></i>';
                                        }
                                        echo '<div class="item itemwidth">
                                        <div class="imgTitle">
                                          <span class="logo-co"><img src="' . base_url($od->orgLogo) . '" alt="" /></span>
                                            <h5 class="blogTitle width48 ellipsistext" title="' . $od->orgAddress . '"><i class="fa fa-map-marker" aria-hidden="true"></i>' . $od->orgAddress . '</h5>
                                             <span class="po-check">
                                              <a href="javascript:" class="more" onclick="compare(this);" orgname="' . $od->orgName . '"  loginid="' . $od->loginId . '"> + Add to compare</a>

                                               </span>
                                            <span class="name-to">Available Seats <b>' . $availabesheets . '</b></span>
                                            <img src="' . base_url($od->orgImgHeader) . '" alt="" />
                                        </div>
                                        <p><strong>' . $od->orgName . '</strong></p>
                                        <span class="name"><p><strong>Course Name </strong>: ' . $od->courseName . ' </p></span>
                                        <span class="name"><p>Eligibility/ Cutoff: optional , depends on college to do the validation</p></span>
                                        <span class="name"><p><strong>Fee</strong> : ' . $od->courseFee . ' </p></span>
                                        <span class="name"><p><strong>Ratings</strong> : ' . $ratings . ' </p></span>
                                        <div class=" clearfix"></div>
                                       <div class="col-lg-12">
                                            <div class="col-lg-6 text-center  ">
                                                <a href="' . site_url('OrganizationDetails/' . $od->loginId . '_' . $orgName) . '" class="to">View Details</a>
                                            </div>
                                            <div class="col-lg-6 text-center ">
                                                <a href="javascript:" onClick="' . $btntype . '"  class="to">' . $btnName . '</a>
                                            </div>
                                       </div>
                                    </div>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="MS-controls">
                                <button class="MS-left"><img src="<?php echo base_url(); ?>images/l-aerrow.png"/></button>
                                <button class="MS-right"><img src="<?php echo base_url(); ?>images/r-aerrow.png"/></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                            <h2>Featured <?php echo $type; ?></h2>
                            <a href="<?php echo site_url('allOrganizationDetails?Type=' . $type); ?>">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="box-sadow">
                        <div class="col-md-12 to-slide">
                            <div id="mixedSlider111">
                                <div id="table" class="MS-content">
                                    <?php
                                    if (isset($FeatureOrgDetails)) {

                                        foreach ($FeatureOrgDetails as $od) {
                                            //echo $od->availabesheets;
                                            if ($od->availableSeats == "") {
                                                $availabesheets = 0;
                                            } else {
                                                $availabesheets = $od->availableSeats;
                                            }
                                            $orgName = preg_replace("/\s+/", "-", $od->orgName);
                                            $loginId = base64_encode($od->loginId);
                                            $avg = $od->ratings;
                                            $btntype = ($od->orgButtonType === "Enroll" ? 'enrollnow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')' : 'enquiryNow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')');
                                            $btnName = ($od->orgButtonType === "Enroll" ? 'Enroll Now' : 'Enquire Now');

                                            $ratings = '';
                                            for ($ratingi = 1; $ratingi < 6; $ratingi++) {
                                                $ratings = $ratings . '<i class="fa fa-star ' . ($ratingi <= $avg ? 'staron' : 'staroff') . '" aria-hidden="true"></i>';
                                            }
                                            echo '<div class="item itemwidth" >
                                                    <div class="imgTitle">
                                                      <span class="logo-co"><img src="' . base_url($od->orgLogo) . '" alt="" /></span>
                                                        <h5 class="blogTitle width48 ellipsistext" title="' . $od->orgAddress . '"><i class="fa fa-map-marker" aria-hidden="true"></i>' . $od->orgAddress . '</h5>
                                                         <span class="po-check">
                                                          <a href="javascript:" class="more" onclick="compare(this);" orgname="' . $od->orgName . '"  loginid="' . $od->loginId . '"> + Add to compare</a>

                                                           </span>
                                                        <span class="name-to">Available Seats <b>' . $availabesheets . '</b></span>
                                                        <img src="' . base_url($od->orgImgHeader) . '" alt="" />
                                                    </div>
                                                    <p><strong>' . $od->orgName . '</strong></p>
                                                    <span class="name"><p><strong>Course Name </strong>: ' . $od->courseName . ' </p></span>
                                                    <span class="name"><p>Eligibility/ Cutoff: optional , depends on college to do the validation</p></span>
                                                    <span class="name"><p><strong>Fee</strong> : ' . $od->courseFee . ' </p></span>
                                                    <span class="name"><p><strong>Ratings</strong> : ' . $ratings . ' </p></span>
                                                    <div class=" clearfix"></div>
                                                   <div class="col-lg-12">
                                                        <div class="col-lg-6 text-center  ">
                                                            <a href="' . site_url('OrganizationDetails/' . $od->loginId . '_' . $orgName) . '" class="to">View Details</a>
                                                        </div>
                                                        <div class="col-lg-6 text-center ">
                                                            <a href="javascript:" onClick="' . $btntype . '"  class="to">' . $btnName . '</a>
                                                        </div>
                                                   </div>
                                                </div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="MS-controls">
                                    <button class="MS-left"><img src="<?php echo base_url(); ?>images/l-aerrow.png"/></button>
                                    <button class="MS-right"><img src="<?php echo base_url(); ?>images/r-aerrow.png"/></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).on('click', '.remove', function () {
        var loginid = $(this).attr("loginid");
        $("#container" + loginid).remove();
        var count = 0;
        count = $(".box").length;
        $(".to-p").text("There are " + count + " boxes.");
        if (count === 0) {
            $("#container").addClass("hidden");
        }
    });

    function compare(event) {
        var loginid = $(event).attr("loginid");
        var orgname = $(event).attr("orgname");
        if (loginid === $("#hidden" + loginid).val()) {
            alert("It is already in the list.");
            return false;
        }
        console.log(loginid);
        var count = 0;
        count = $(".box").length;
        if (count < '2') {
            $("#container").append("<div class='box' id='container" + loginid + "' > " + orgname + "<a href='javascript:' class='remove' loginid='" + loginid + "'><i class='fa fa-times'></i></a><input type='hidden' class='hidden' id='hidden" + loginid + "' name='checkedData[]' value='" + loginid + "'></div>");
            var counter = count + 1;
        } else {
            alert("Please select only two Organization");
            return false;
        }
        if (counter === 2) {
            $('#container').append('<input type="submit" class="comparebtn btn" value="Compare">');
        }
        $(".to-p").text("There are " + counter + " boxes.");
        $("#container").removeClass("hidden");
    }
</script>
<script type="text/javascript">
    document.title = 'iHuntBest | Filter By Category';
    function addActive(focussed) {
        $(".OrgName").removeClass("autocomplete-active");
        $("#orgname" + focussed).addClass("autocomplete-active");
    }
    function selElement(focussed) {
        $("#orgName").val($("#orgname" + focussed).text());
        $("#orgName").attr('orgIds', $("#orgname" + focussed).attr('orgId'));
        $("#OrgNamesautocomplete-list").remove();
    }
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        var currentFocus = -1;
        $("#orgName").keyup(function (e) {
            if ($('#OrgNamesautocomplete-list').length) {
                console.log("currentFocus " + currentFocus);
                console.log("OrgNames " + $(".OrgName").length);

                if (e.keyCode === 40) {
                    /*If the arrow DOWN key is pressed,
                     increase the currentFocus variable:*/

                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(currentFocus);
                    return true;
                } else if (e.keyCode === 38) { //up
                    /*If the arrow UP key is pressed,
                     decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(currentFocus);
                    return true;
                } else if (e.keyCode === 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        selElement(currentFocus);
                        return true;
                    }
                } else {
                    currentFocus = -1;
                }
            }
            if (e.keyCode >= 65 && e.keyCode <= 90) {
                var orgName = $(this).val();
                var type = '<?php echo $orgtype; ?>';
                if (type === "") {
                    alert("Organization type not available.");
                    return false;
                } else {
                    $("#OrgNamesautocomplete-list").remove();
                    $.ajax({
                        url: "<?php echo site_url("home/getOrgName"); ?>",
                        type: 'POST',
                        data: {orgName: orgName, type: type},
                        success: function (response) {
                            if (response !== '') {
                                var responsearr = $.parseJSON(response);
                                var dropdowndata = "";
                                for (var i = 0; i < responsearr.length; i++) {
                                    dropdowndata = dropdowndata + '<div id="orgname' + i + '" onclick="selElement(' + i + ');" onmouseover="addActive(' + i + ');" orgId="' + responsearr[i].orgId + '" class="OrgName">' + responsearr[i].orgName + '</div>';
                                }
                            }
                            var divdata = '<div id="OrgNamesautocomplete-list" class="autocomplete-items">' + dropdowndata + '</div>';
                            $("#orgaNames").append(divdata);
                        }, error: function (response) {
                            $.alert({title: 'Error!', content: response, type: 'red',
                                typeAnimated: true, buttons: {
                                    Ok: function () {
                                        window.location.reload();
                                    }
                                }});
                        }
                    });
                }
            } else {
                return false;
            }
        });
        $('#search').click(function () {
            var orgname = $("#orgName").attr('orgids');
            var stateIdsel = $("#stateIdsel").val();
            var cityIdsel = $("#cityIdsel").val();
            var ratings = $("#ratings").val();
            if (orgname === "" && stateIdsel === "" && cityIdsel === "" && ratings === "") {
                alert("Please select some filter.");
            } else {
                var orgid = [];
                if (orgname) {
                    orgid.push(orgname);
                }
                if (stateIdsel) {
                    orgid.push(stateIdsel);
                }
                if (cityIdsel) {
                    orgid.push(cityIdsel);
                }
                $.ajax({
                    type: "POST",
                    data: {orgid: orgid, Type: '<?php echo $orgtype; ?>'},
                    url: "<?php echo site_url('home/filterOrganisations'); ?>",
                    success: function (response) {
                        $("#orgtypes").html(response);
                    }
                });
            }

        });
        $(document).on("click", ".sub", function () {
            var countId = $(this).attr('countId');
            var stId = $(this).attr('stId');
            var orgId = $(this).attr('orgId');
            var search = $(search).attr('search');
            $.ajax({
                type: "POST",
                data: {countId: countId, stId: stId, orgId: orgId, search: search},
                url: "<?php echo site_url('home/SearchByCatOrgDetails'); ?>",
                success: function (response) {
                    if ($.trim(response) !== "") {
                        $("#table").append(response);
                    } else {

                        $("#loadMore").html('All Loaded');
                    }
                }
            });

        });
        getOrgStatesCityNames('stateIdsel', 'states');
        getOrgStatesCityNames('cityIdsel', 'city');
    });
    function getOrgStatesCityNames(id, type) {
        $.ajax({
            type: "POST",
            data: {type: type, roleName: '<?php echo $orgtype; ?>'},
            url: "<?php echo site_url('home/getOrgStatesCityNames'); ?>",
            success: function (response) {
                var datares = $.parseJSON(response);
                var outputsel = '<option value="">Select</option>';
                if (datares !== "" && type === "states") {
                    for (var i = 0; i < datares.length; i++) {
                        outputsel = outputsel + '<option stateid="' + datares[i].stateId + '" value="' + datares[i].orgids + '">' + datares[i].stateName + '</option>';
                    }
                } else {
                    for (var i = 0; i < datares.length; i++) {
                        outputsel = outputsel + '<option cityid="' + datares[i].cityId + '" value="' + datares[i].orgids + '">' + datares[i].cityName + '</option>';
                    }
                }
                $("#" + id).html(outputsel);
            }
        });
    }

</script>
<script>

    $(function () {
        $("#closeenrollModal").click(function () {
            $("#enrollModal").hide();
            $("body").css("overflow", "auto");
        });
        $('#pop-btn').on('click', function () {
            $('.popup').css({
                'transform': 'translateY(0)',
                'z-index': '98'
            });

            $('body').addClass('overlay');

            $('.popup .pop-content').animate({
                left: '0'
            }, 50);

            $(this).css({
                'z-index': '-1'
            });

            $('.popup > .close').on('click', function () {
                $(this).parent().css({
                    'transform': 'translateY(-300%)'
                });

                $('body').removeClass('overlay');
                $(this).parent().siblings('#pop-btn').css({
                    'z-index': '1'
                });
            });
        });
    });

</script>

<!--------------------------footer----------------------->

<script>

    $('#mixedSlider').multislider({
        duration: 750,
        interval: 3000
    });
    $('#mixedSlider11').multislider({
        duration: 850,
        interval: 3100
    });
    $('#mixedSlider111').multislider({
        duration: 950,
        interval: 3200
    });
</script>


<?php
include_once 'shared/footer.php';
