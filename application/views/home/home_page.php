<?php include_once 'shared/header.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!--<script src="<?php // echo base_url('js/jquery.min.js');                                                                                                                                                                                                                                                                                                                                   
                    ?>" type="text/javascript"></script>
<script src="<?php // echo base_url();                                                                                                                                                                                                                                                                                                                                   
                ?>plugins/jQuery/jquery-3.2.1.min.js"></script>-->

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

<script>
    <?php include 'js/location.js'; ?>
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACimPVNI1GUVZIfy5HA342kjuq7grLzS0&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    document.title = 'iHuntBest | Home Page';

    function imgError(ele) {
        ele.onerror = "";
        console.log(ele);
        ele.src = '<?php echo base_url('homepage_images/default.png'); ?>';

        return true;


    }
    $(document).ready(function() {
        $("#slider").slider({
            min: 1000,
            max: 100000,
            step: 1,
            values: [10, 900],
            slide: function(event, ui) {
                for (var i = 0; i < ui.values.length; ++i) {
                    $("input.sliderValue[data-index=" + i + "]").val(ui.values[i]);
                }
            }
        });

        $("input.sliderValue").change(function() {
            var $this = $(this);
            $("#slider").slider("values", $this.data("index"), $this.val());
        });
        $("#sliderCollege").slider({
            min: 1000,
            max: 100000,
            step: 1,
            values: [10, 900],
            slide: function(event, ui) {
                for (var i = 0; i < ui.values.length; ++i) {
                    $("input.sliderValueCollege[data-index=" + i + "]").val(ui.values[i]);
                }
            }
        });

        $("input.sliderValueCollege").change(function() {
            var $this = $(this);
            $("#sliderCollege").slider("values", $this.data("index"), $this.val());
        });
        $("#sliderInstitute").slider({
            min: 1000,
            max: 100000,
            step: 1,
            values: [10, 900],
            slide: function(event, ui) {
                for (var i = 0; i < ui.values.length; ++i) {
                    $("input.sliderValueInstitute[data-index=" + i + "]").val(ui.values[i]);
                }
            }
        });

        $("input.sliderValueInstitute").change(function() {
            var $this = $(this);
            $("#sliderInstitute").slider("values", $this.data("index"), $this.val());
        });
        $("#sliderSchool").slider({
            min: 1000,
            max: 100000,
            step: 1,
            values: [10, 900],
            slide: function(event, ui) {
                for (var i = 0; i < ui.values.length; ++i) {
                    $("input.sliderValueSchool[data-index=" + i + "]").val(ui.values[i]);
                }
            }
        });

        $("input.sliderValueSchool").change(function() {
            var $this = $(this);
            $("#sliderSchool").slider("values", $this.data("index"), $this.val());
        });
    });
</script>
<!---=======================================header-3==================================---->
<!------------------adds--------------------------->
<div class="container add-to">
    <div class="col-md-12">
        <div class="addimage"><img src="<?php echo base_url(); ?>images/add.png" /></div>
    </div>
</div>

<!----------------------------------------------content------------------------------->

<!----------------------------------Enroll now start----------------------------------------->

</div>

<!----------------------------------Enroll now end------------------------------------------->
<div class="container add-to-3">
    <div class="col-md-12">
        <div class="heading">
            <h2>EXPLORE ALMOST EVERYTHING</h2>
            <span class="bott-img"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/head.png" /></span>
            <p>iHuntBest.com is an extensive search engine for the students, parents,<br>
                and education industry players who are seeking information</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/1-icon.png" /></span>
                <div class="text-box">
                    <a href="#">FIND BEST COLLEGE</a>
                    <p>Learn about the best of bests in the country.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/2-icon.png" /></span>
                <div class="text-box">
                    <a href="#">EXPLORE EXAMS</a>
                    <p>All information about the exams that will get you into your dream college.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/3-icon.png" /></span>
                <div class="text-box text-box-to">
                    <a href="#">GET ADMISSION</a>
                    <p>Find information about the final step to colleges and courses.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/4-icon.png" /></span>
                <div class="text-box">
                    <a href="#">TOP COURSES</a>
                    <p>Learn about various mix of courses offered across the country.</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-----------===================================top-college-==========================--->
<div class="bg-color">
    <div class="container">
        <div class="col-md-12">
            <div class="heading animated fadeInUp" data-appear-top-offset="-200" data-animated="fadeInUp">
                <h2>Our Organization</h2>
                <span class="bott-img"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/head.png"></span>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 nopadding">
                <div class="col-md-3 col-sm-12">
                    <div class="filter animated" data-animation="fadeInDown" data-revert="fadeOutDown">
                        <div class="filter-to">
                            <form>
                                <h4>Filter Universities</h4>
                                <p class="label-to">Course Name</p>
                                <div class="select-to3 autocomplete" id="orgaNames">
                                    <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>" />
                                    <select name="state" name="univCourseName" id="univCourseName">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <p class="label-to">Fee</p>
                                <div class="select-to3">
                                    <div class="col-lg-6">
                                        <input type="text" id="ufeemin" class="sliderValue" data-index="0" value="" />
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" id="ufeemax" class="sliderValue" data-index="1" value="" />
                                    </div>
                                    <div class="col-lg-12" style="padding: 10px;">
                                        <div id="slider"></div>
                                    </div>
                                </div>
                                <p class="label-to">Location</p>
                                <div class="input-group" id="UnivLocationDiv">
                                    <input type="text" class="form-control locationfind" id="iUnivLocationDiv" divid="UnivLocationDiv" orgType="University">
                                    <div class="input-group-btn">
                                        <button class="btn bg-yellow-gradient"><i class="fa fa-refresh"></i></button>
                                    </div>

                                </div>
                                <p class="label-to">Rating</p>
                                <div class="select-to4">
                                    <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>" />
                                    <select name="rating" id="ratingsUniv">
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
                                        <input type="reset" value="Reset" class="btn btn-danger">
                                        <input type="button" class="btn btn-warning" onclick="filterOrganisations('University', 'universitySlides');" name="searchuniv" id="searchuniv" value="Filter">
                                    </div>
                                </div>
                                <!--                <a class="sub" href="javascript:">Submit</a><a href="#" class="sub-to">RESET</a>-->
                                <span class="all">
                                    <h2>ALL Visitors</h2><a href="#" class="sub-to allVisitors" style="width:auto;    margin-right: 10px;">50000</a>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="box-sadow">
                        <div class="col-md-12 latest-to">
                            <div class="latest">
                                <h2>University</h2>
                                <a href="<?php echo site_url('organizationsCategories?Type=University'); ?>">VIEW ALL</a>
                            </div>
                        </div>
                        <div class="col-md-12 to-slide" id="universitySlides">
                            <div id="mixedSlider1">
                                <div id="table" class="MS-content">
                                    <?php
                                    if (isset($universityRes)) {
                                        foreach ($universityRes as $od) {

                                            if ($od->availableSeats == "") {
                                                $availabesheets = 0;
                                            } else {
                                                $availabesheets = $od->availableSeats;
                                            }
                                            $avg = $od->ratings;
                                            $btntype = ($od->orgButtonType === "Enquiry" ? 'enquiryNow(\'' . base64_encode($od->loginId) . '\',\'University\',' . $od->courseid . ',' . $od->OrgcourseId . ')' : 'enrollnow(\'' . base64_encode($od->loginId) . '\',\'University\',' . $od->courseid . ',' . $od->OrgcourseId . ')');
                                            $btnName = ($od->orgButtonType === "Enquiry" ? 'Enquire Now' : 'Enroll Now');
                                            $orgName = preg_replace("/\s+/", "-", $od->orgName);
                                            $loginId = base64_encode($od->loginId);
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
                                            <span class="name"><p>Eligibility/ Cutoff: ' . (empty($od->course_qualifications) ? "optional , depends on college to do the validation" : $od->course_qualifications) . '</p></span>
                                            <span class="name"><p><strong>Fee</strong> : ' . $od->courseFee . ' </p></span>
                                            <span class="name"><p><strong>Ratings</strong> : ' . $ratings . ' </p></span>

                                        <div class=" clearfix"></div>
                                       <div class="col-lg-12">
                                            <div class="col-lg-6 text-center  ">
                                                <a href="' . site_url('OrganizationDetails/' . $od->loginId . '_' . $orgName . "_" . $od->OrgcourseId) . '" class="to">View Details</a>
                                            </div>
                                            <div class="col-lg-6 text-center " style="padding:0px 10px;">
                                                <a href="javascript:" onClick="' . $btntype . '"  class="to">' . $btnName . '</a>
                                            </div>
                                       </div>
                                    </div>';
                                        }
                                    }
                                    ?>
                                    <!--                                <div class="col-lg-2 text-right nopadding"></div>
                                                                                <div class="col-lg-5 text-right nopadding">
                                                                                    <a href="#" class="to" onClick="enrollnow(\''.base64_encode($ur->loginId).'\',\'University\');">Enroll Now</a>
                                                                                </div>-->
                                </div>
                                <div class="MS-controls">
                                    <button class="MS-left"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/l-aerrow.png" /></button>
                                    <button class="MS-right"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/r-aerrow.png" /></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 nopadding">
                <div class="col-md-3 col-sm-12">
                    <div class="filter animated" data-animation="fadeInDown" data-revert="fadeOutDown">
                        <div class="filter-to">
                            <form>
                                <h4>Filter College</h4>
                                <p class="label-to">Course Name</p>
                                <div class="select-to3 autocomplete" id="orgaNames">
                                    <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>" />
                                    <select name="state" name="collegeCourseName" id="collegeCourseName">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <p class="label-to">Fee</p>
                                <div class="select-to3">
                                    <div class="col-lg-6">
                                        <input type="text" class="sliderValueCollege" id="cfeemin" data-index="0" value="" />
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" class="sliderValueCollege" id="cfeemax" data-index="1" value="" />
                                    </div>
                                    <div class="col-lg-12" style="padding: 10px;">
                                        <div id="sliderCollege"></div>
                                    </div>
                                </div>
                                <p class="label-to">Location</p>
                                <div class="input-group" id="CollLocationDiv">
                                    <input type="text" class="form-control locationfind" divid="CollLocationDiv" id="iCollLocationDiv" orgType="College">
                                    <div class="input-group-btn">
                                        <button class="btn bg-yellow-gradient"><i class="fa fa-refresh"></i></button>
                                    </div>

                                </div>
                                <p class="label-to">Rating</p>
                                <div class="select-to4">
                                    <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>" />
                                    <select name="ratingColl" id="ratingsColl">
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
                                        <input type="reset" value="Reset" class="btn btn-danger">
                                        <input type="button" class="btn btn-warning" onclick="filterOrganisations('College', 'collegeSlides');" name="csearch" id="csearch" value="Filter">
                                    </div>
                                </div>
                                <!--                <a class="sub" href="javascript:">Submit</a><a href="#" class="sub-to">RESET</a>-->
                                <span class="all">
                                    <h2>ALL Visitors</h2><a href="#" class="sub-to allVisitors" style="width:auto;    margin-right: 10px;">50000</a>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                            <h2>Colleges</h2>

                            <a href="<?php echo site_url('organizationsCategories?Type=College'); ?>">VIEW ALL</a>
                        </div>
                        <div class="col-md-12 to-slide" id="collegeSlides">
                            <div id="mixedSlider11">
                                <div id="table" class="MS-content">
                                    <?php
                                    if (isset($collegesRes)) {
                                        foreach ($collegesRes as $od) {
                                            if ($od->availableSeats == "") {
                                                $availabesheets = 0;
                                            } else {
                                                $availabesheets = $od->availableSeats;
                                            }
                                            $avg = $od->ratings;
                                            $btntype = ($od->orgButtonType === "Enquiry" ? 'enquiryNow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')' : 'enrollnow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')');
                                            $btnName = ($od->orgButtonType === "Enquiry" ? 'Enquire Now' : 'Enroll Now');

                                            $orgName = preg_replace("/\s+/", "-", $od->orgName);
                                            $loginId = base64_encode($od->loginId);
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
                                            <div class="col-lg-6 text-center " style="padding:0px 10px;">
                                                <a href="javascript:" onClick="' . $btntype . '"  class="to">' . $btnName . '</a>
                                            </div>
                                       </div>
                                    </div>';
                                        }
                                    }
                                    ?>
                                    <!--                            <div class="col-lg-2 text-right nopadding"></div>
                                                                            <div class="col-lg-5 text-right nopadding">
                                                                                <a href="#" class="to" onClick="enrollnow(\''.$loginId.'\',\'College\')">Enroll Now</a>
                                                                            </div>-->
                                </div>
                                <div class="MS-controls">
                                    <button class="MS-left"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/l-aerrow.png" /></button>
                                    <button class="MS-right"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/r-aerrow.png" /></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 nopadding">
                <div class="col-md-3 col-sm-12">
                    <form>
                        <div class="filter animated" data-animation="fadeInDown" data-revert="fadeOutDown">
                            <div class="filter-to">
                                <h4>Filter Institute</h4>
                                <p class="label-to">Course Name</p>
                                <div class="select-to3 autocomplete" id="orgaNames">
                                    <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>" />
                                    <select name="state" name="instituteCourseName" id="instituteCourseName">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <p class="label-to">Fee</p>
                                <div class="select-to3">
                                    <div class="col-lg-6">
                                        <input type="text" class="sliderValueInstitute" id="ifeemin" data-index="0" value="" />
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" class="sliderValueInstitute" id="ifeemax" data-index="1" value="" />
                                    </div>
                                    <div class="col-lg-12" style="padding: 10px;">
                                        <div id="sliderInstitute"></div>
                                    </div>
                                </div>
                                <p class="label-to">Location</p>
                                <div class="input-group" id="InsLocationDiv">
                                    <input type="text" class="form-control locationfind" id="iInsLocationDiv" divid="InsLocationDiv" orgType="Institute">
                                    <div class="input-group-btn">
                                        <button class="btn bg-yellow-gradient"><i class="fa fa-refresh"></i></button>
                                    </div>

                                </div>
                                <p class="label-to">Rating</p>
                                <div class="select-to4">
                                    <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>" />
                                    <select name="ratingInst" id="ratingsInst">
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
                                        <input type="reset" value="Reset" class="btn btn-danger">
                                        <input type="button" class="btn btn-warning" name="inssearch" id="inssearch" onclick="filterOrganisations('Institute', 'instituteSlides');" value="Filter">

                                    </div>
                                </div>
                                <!--                <a class="sub" href="javascript:">Submit</a><a href="#" class="sub-to">RESET</a>-->
                                <span class="all">
                                    <h2>ALL Visitors</h2><a href="#" class="sub-to allVisitors" style="width:auto;    margin-right: 10px;">50000</a>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="box-sadow">
                        <div class="col-md-12 latest-to">
                            <div class="latest">
                                <h2>Institute</h2>

                                <a href="<?php echo site_url('organizationsCategories?Type=Institute'); ?>">VIEW ALL</a>
                            </div>
                        </div>
                        <div class="col-md-12 to-slide" id="instituteSlides">
                            <div id="mixedSlider111">
                                <div id="table" class="MS-content">
                                    <?php
                                    if (isset($instituteRes)) {
                                        foreach ($instituteRes as $od) {
                                            if ($od->availableSeats == "") {
                                                $availabesheets = 0;
                                            } else {
                                                $availabesheets = $od->availableSeats;
                                            }
                                            $avg = $od->ratings;
                                            $btntype = ($od->orgButtonType === "Enquiry" ? 'enquiryNow(\'' . base64_encode($od->loginId) . '\',\'Institute\',' . $od->courseid . ',' . $od->OrgcourseId . ')' : 'enrollnow(\'' . base64_encode($od->loginId) . '\',\'Institute\',' . $od->courseid . ',' . $od->OrgcourseId . ')');
                                            $btnName = ($od->orgButtonType === "Enquiry" ? 'Enquire Now' : 'Enroll Now');

                                            $orgName = preg_replace("/\s+/", "-", $od->orgName);
                                            $loginId = base64_encode($od->loginId);
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
                                            <div class="col-lg-6 text-center " style="padding:0px 10px;">
                                                <a href="javascript:" onClick="' . $btntype . '"  class="to">' . $btnName . '</a>
                                            </div>
                                       </div>
                                    </div>';
                                        }
                                    }
                                    ?>
                                    <!--                                <div class="col-lg-2 text-right nopadding"></div>
                                                                                <div class="col-lg-5 text-right nopadding">
                                                                                    <a href="#" class="to" onClick="enrollnow(\''.base64_encode($ir->loginId).'\',\'Institute\')">Enroll Now</a>
                                                                                </div>-->
                                </div>
                                <div class="MS-controls">
                                    <button class="MS-left"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/l-aerrow.png" /></button>
                                    <button class="MS-right"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/r-aerrow.png" /></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 nopadding">
                <div class="col-md-3 col-sm-12">
                    <div class="filter animated" data-animation="fadeInDown" data-revert="fadeOutDown">
                        <div class="filter-to">
                            <form>
                                <h4>Filter School</h4>
                                <p class="label-to">Course Name</p>
                                <div class="select-to3 autocomplete" id="orgaNames">
                                    <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>" />
                                    <select name="state" name="schoolCourseName" id="schoolCourseName">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <p class="label-to">Fee</p>
                                <div class="select-to3">
                                    <div class="col-lg-6">
                                        <input type="text" class="sliderValueSchool" id="sfeemin" data-index="0" value="" />
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" class="sliderValueSchool" id="sfeemax" data-index="1" value="" />
                                    </div>
                                    <div class="col-lg-12" style="padding: 10px;">
                                        <div id="sliderSchool"></div>
                                    </div>
                                </div>
                                <p class="label-to">Location</p>
                                <div class="input-group" id="SchLocationDiv">
                                    <input type="text" class="form-control locationfind" id="iSchLocationDiv" divid="SchLocationDiv" orgType="School">
                                    <div class="input-group-btn">
                                        <button class="btn bg-yellow-gradient"><i class="fa fa-refresh"></i></button>
                                    </div>

                                </div>
                                <p class="label-to">Rating</p>
                                <div class="select-to4">
                                    <img class="to-1" src="<?php echo base_url('images/Arrow-Up1.png'); ?>" />
                                    <select name="ratingScho" id="ratingsScho">
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
                                        <input type="reset" value="Reset" class="btn btn-danger">
                                        <input type="button" class="btn btn-warning" name="schsearch" id="schsearch" onclick="filterOrganisations('School', 'schoolSlides');" value="Filter">
                                    </div>
                                </div>
                                <!--                <a class="sub" href="javascript:">Submit</a><a href="#" class="sub-to">RESET</a>-->
                                <span class="all">
                                    <h2>ALL Visitors</h2><a href="#" class="sub-to allVisitors" style="width:auto;    margin-right: 10px;">50000</a>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="box-sadow">
                        <div class="col-md-12 latest-to">
                            <div class="latest">
                                <h2>School</h2>
                                <a href="<?php echo site_url('organizationsCategories?Type=School'); ?>">VIEW ALL</a>
                            </div>
                        </div>
                        <div class="col-md-12 to-slide" id="schoolSlides">
                            <div id="mixedSlider1111">
                                <div id="table" class="MS-content">
                                    <?php
                                    if (isset($schoolRes)) {
                                        foreach ($schoolRes as $od) {
                                            if ($od->availableSeats == "") {
                                                $availabesheets = 0;
                                            } else {
                                                $availabesheets = $od->availableSeats;
                                            }
                                            $avg = $od->ratings;
                                            $btntype = ($od->orgButtonType === "Enquiry" ? 'enquiryNow(\'' . base64_encode($od->loginId) . '\',\'School\',' . $od->courseid . ',' . $od->OrgcourseId . ')' : 'enrollnow(\'' . base64_encode($od->loginId) . '\',\'School\',' . $od->courseid . ',' . $od->OrgcourseId . ')');
                                            $btnName = ($od->orgButtonType === "Enquiry" ? 'Enquire Now' : 'Enroll Now');

                                            $orgName = preg_replace("/\s+/", "-", $od->orgName);
                                            $loginId = base64_encode($od->loginId);
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
                                            <div class="col-lg-6 text-center " style="padding:0px 10px;">
                                                <a href="javascript:" onClick="' . $btntype . '"  class="to">' . $btnName . '</a>
                                            </div>
                                       </div>
                                    </div>';
                                        }
                                    }
                                    ?>
                                    <!--                                <div class="col-lg-2 text-right nopadding"></div>
                                                                                <div class="col-lg-5 text-right nopadding">
                                                                                    <a href="#" class="to" onClick="enrollnow(\''.base64_encode($sr->loginId).'\',\'School\')">Enroll Now</a>
                                                                                </div>-->
                                </div>
                                <div class="MS-controls">
                                    <button class="MS-left"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/l-aerrow.png" /></button>
                                    <button class="MS-right"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/r-aerrow.png" /></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup">
    <div class="pop-content">
        <h1>
            hey everyone !
        </h1>
    </div>
    <span class="close">
        <i class="fa fa-close"></i>
    </span>

</div>
<script>
    $(function() {

        $('#pop-btn').on('click', function() {
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

            $('.popup > .close').on('click', function() {
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
<script>
    $(".more").click(function() {
        var id = $(this).next('.ProdId').html();
        $("#container").append("<div class='box'> " + id + "<a href='#'>x</a></div>");
        var count = $(".box").length;
        $(".to-p").text("There are " + count + " boxes.");
        $("#container").removeClass("hidden");
    });

    $(".box a").live("click", function() {
        $(this).parent().remove();
        var count = $(".box").length;
        $(".to-p").text("There are " + count + " boxes.");
    });
</script>
<!--------------------------footer----------------------->
<script>
    var $rows = $('#table .item');
    $('#search').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
</script>
<script>
    function filterOrganisations(orgType, divId) {
        var feeminValue = "";
        var feemaxValue = "";
        var loginIds = [];
        var courseIds = "";
        if (orgType === "University") {
            var courseName = "univCourseName";
            var feemax = "ufeemax";
            var feemin = "ufeemin";
            var locations = "iUnivLocationDiv";
            var ratingId = "ratingsUniv";
        }
        if (orgType === "College") {
            var courseName = "collegeCourseName";
            var feemax = "cfeemax";
            var feemin = "cfeemin";
            var locations = "iCollLocationDiv";
            var ratingId = "ratingsColl";
        }
        if (orgType === "Institute") {
            var courseName = "instituteCourseName";
            var feemax = "ifeemax";
            var feemin = "ifeemin";
            var locations = "iInsLocationDiv";
            var ratingId = "ratingsInst";
        }
        if (orgType === "School") {
            var courseName = "schoolCourseName";
            var feemax = "sfeemax";
            var feemin = "sfeemin";
            var locations = "iSchLocationDiv";
            var ratingId = "ratingsScho";
        }
        if ($("#" + courseName).val() !== "") {
            courseIds = $("#" + courseName).val();
        }
        if ($("#" + feemax).val() !== "") {
            feeminValue = $("#" + feemin).val();
            feemaxValue = $("#" + feemax).val();
        }
        if ($("#" + locations).val() !== "") {
            var locationIds = $("#" + locations).attr("loginids");

            var locationIda = locationIds.split(',');
            loginIds = $.merge(loginIds, locationIda);
        }
        var ratings = $("#" + ratingId).val();
        $.ajax({
            url: '<?php echo site_url('Home/filterOrganisationsHome'); ?>',
            data: {
                ratings: ratings,
                courseIds: courseIds,
                orgType: orgType,
                feeminValue: feeminValue,
                feemaxValue: feemaxValue,
                loginIds: loginIds
            },
            type: "POST",
            success: function(response) {
                if (response) {
                    $("#" + divId).html(response);
                }
            },
            error: function(jqXHR, exception) {
                $.alert({
                    title: 'Error!',
                    content: jqXHR["status"] + " " + exception,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function() {
                            window.location.href = '<?php echo site_url(); ?>';
                        }
                    }
                });
            }
        });
    }

    function selElementL(focussed, divId) {
        $("#i" + divId).val($("#searchterm" + focussed).text());
        $("#i" + divId).attr('loginIds', $("#searchterm" + focussed).attr('loginids'));
        $("#searchboxautocomplete-list").remove();
    }
    $('#mixedSlider1').multislider({
        duration: 750,
        interval: 2000
    });
    $('#mixedSlider1').multislider('pause');

    $('#mixedSlider11').multislider({
        duration: 750,
        interval: 2200
    });
    $('#mixedSlider11').multislider('pause');


    $('#mixedSlider111').multislider({
        duration: 750,
        interval: 2500
    });
    $('#mixedSlider111').multislider('pause');


    $('#mixedSlider1111').multislider({
        duration: 750,
        interval: 3000
    });
    $('#mixedSlider1111').multislider('pause');
    var currentFocusL = -1;
    $(document).ready(function() {
        var verificationCode = '<?php echo $this->input->get('verificationCode'); ?>';
        var id = '<?php echo $this->input->get('id'); ?>';
        if (verificationCode !== "" && id !== "") {
            $.ajax({
                url: '<?php echo site_url('Home/verifyEmail'); ?>',
                data: {
                    verificationCode: verificationCode,
                    id: id
                },
                type: "POST",
                success: function(response) {
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({
                            title: 'Success!',
                            content: json.msg,
                            type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function() {
                                    window.location.href = '<?php echo site_url('home/index'); ?>';
                                }
                            }
                        });
                    } else {
                        $.alert({
                            title: 'Error!',
                            content: json.msg,
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function() {
                                    window.location.href = '<?php echo site_url('home/index'); ?>';
                                }
                            }
                        });
                    }
                },
                error: function(jqXHR, exception) {
                    $.alert({
                        title: 'Error!',
                        content: jqXHR["status"] + " " + exception,
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function() {
                                window.location.href = '<?php echo site_url('home/index'); ?>';
                            }
                        }
                    });
                }
            });
        }
        var studentVerification = '<?php echo $this->input->get('studentVerification'); ?>';
        var studentid = '<?php echo $this->input->get('id'); ?>';
        if (studentVerification !== "" && studentid !== "") {
            $.ajax({
                url: '<?php echo site_url('Home/verifyStudentEmail'); ?>',
                data: {
                    studentVerification: studentVerification,
                    studentid: studentid
                },
                type: "POST",
                success: function(response) {
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({
                            title: 'Success!',
                            content: json.msg,
                            type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function() {
                                    window.location.href = '<?php echo site_url('home/index'); ?>';
                                }
                            }
                        });
                    } else {
                        $.alert({
                            title: 'Error!',
                            content: json.msg,
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function() {
                                    window.location.reload('home/index');
                                }
                            }
                        });
                    }
                },
                error: function(jqXHR, exception) {
                    $.alert({
                        title: 'Error!',
                        content: jqXHR["status"] + " " + exception,
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function() {
                                window.location.href = '<?php echo site_url('home/index'); ?>';
                            }
                        }
                    });
                }
            });
        }

        getCourseName("University", "univCourseName");
        getCourseName("College", "collegeCourseName");
        getCourseName("Institute", "instituteCourseName");
        getCourseName("School", "schoolCourseName");
        allVisitorsCount();
        $(".locationfind").keyup(function(e) {
            var divid = $(this).attr("divid");
            if ($('#searchboxautocomplete-list').length) {
                if (e.keyCode === 40) {
                    currentFocusL++;
                    addActiveH(currentFocusL);
                    return true;
                } else if (e.keyCode === 38) {
                    currentFocusL--;
                    addActiveH(currentFocusL);
                    return true;
                } else if (e.keyCode === 13) {
                    e.preventDefault();
                    if (currentFocusL > -1) {
                        selElementL(currentFocusL, divid);
                        return true;
                    }
                } else {
                    currentFocusL = -1;
                }
            }
            if (e.keyCode >= 65 && e.keyCode <= 90) {
                var keySearch = $(this).val();
                var orgType = $(this).attr("orgType");
                var divid = $(this).attr("divid");
                $("#searchboxautocomplete-list").remove();
                $.ajax({
                    url: "<?php echo site_url("home/locationSearch"); ?>",
                    type: 'POST',
                    data: {
                        keySearch: keySearch,
                        orgType: orgType
                    },
                    success: function(response) {
                        if (response !== '') {
                            var responsearr = $.parseJSON(response);
                            var dropdowndata = '';
                            for (var i = 0; i < responsearr.length; i++) {
                                dropdowndata = dropdowndata + '<div id="searchterm' + i + '" onclick="selElementL(' + i + ',\'' + divid + '\');" onmouseover="addActiveHm(' + i + ');" loginids="' + responsearr[i].loginIds + '"  class="locations">' + responsearr[i].orgAddress + '</div>';
                            }
                        } else {
                            var dropdowndata = '<div id="searchterm0" onclick="selElementL(0,\'' + divid + '\');" onmouseover="addActiveHm(0);" loginids="" class="searchterms">No Results Found</div>';
                        }
                        var divdata = '<div id="searchboxautocomplete-list" class="autocomplete-items">' + dropdowndata + '</div>';
                        $("#searchboxautocomplete-list").html("");
                        $("#" + divid).append(divdata);
                    },
                    error: function(jqXHR, exception) {
                        $.alert({
                            title: 'Error!',
                            content: jqXHR["status"] + " " + exception,
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function() {
                                    //window.location.reload();
                                }
                            }
                        });
                    }
                });
            } else {
                return false;
            }
        });
    });

    function getCourseName(orgType, locationset) {
        $.ajax({
            url: '<?php echo site_url('Home/getCourseName'); ?>',
            data: {
                orgType: orgType
            },
            type: "POST",
            success: function(response) {
                var json = $.parseJSON(response);
                var option = '<option value="">Select</option>';
                if (json) {
                    for (var i = 0; i < json.length; i++) {
                        option = option + '<option value="' + json[i].id + '">' + json[i].course_name + '</option>';
                    }
                    $("#" + locationset).html(option);
                } else {
                    $.alert({
                        title: 'Error!',
                        content: json.msg,
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            Ok: function() {
                                 
                            }
                        }
                    });
                }
            },
            error: function(jqXHR, exception) {
                $.alert({
                    title: 'Error!',
                    content: jqXHR["status"] + " " + exception,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function() {
                            
                        }
                    }
                });
            }
        });
    }

    function allVisitorsCount() {
        $.ajax({
            url: '<?php echo site_url('Home/getVisitors'); ?>',
            data: {
                totalview: "total"
            },
            type: "POST",
            success: function(response) {
                if (response) {
                    var json = $.parseJSON(response);
                    $(".allVisitors").html(json.visitors);
                }
            },
            error: function(jqXHR, exception) {
                $.alert({
                    title: 'Error!',
                    content: jqXHR["status"] + " " + exception,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        Ok: function() {
                            window.location.href = '<?php echo site_url(); ?>';
                        }
                    }
                });
            }
        });
        //
    }
</script>


<?php
include_once 'shared/footer.php';
