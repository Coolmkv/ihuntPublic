<?php

include_once 'shared/header.php';

if (isset($orgDetails)) {
    $email = $orgDetails->email;
    $orgName = $orgDetails->orgName;
    $orgAddress = $orgDetails->orgAddress;
    $orgLogo = $orgDetails->orgLogo;
    $orgImgHeader = $orgDetails->orgImgHeader;
    $country = $orgDetails->country;
    $state = $orgDetails->state;
    $approvedBy = $orgDetails->approvedBy;
    $defaultHeader = $orgDetails->defaultHeader;
    $orgVideo = $orgDetails->orgVideo;
    $yOfEst = ($orgDetails->yearsofest ? $orgDetails->yearsofest : 1);
    if ($approvedBy == "") {
        $approvedBy = "N/A";
    }
    $orgGoogle = $orgDetails->orgGoogle;
    $city = $orgDetails->city;
    $orgWebsite = ($orgDetails->webLinkStartus === "0" ? "" : $orgDetails->orgWebsite);
    $directorName = $orgDetails->directorName;
    $directorEmail = $orgDetails->directorEmail;
    $directorMobile = $orgDetails->directorMobile;
    $orgDesp = $orgDetails->orgDesp;
    $orgMission = $orgDetails->orgMission;
    $orgVission = $orgDetails->orgVission;
    $loginId = base64_encode($orgDetails->loginId);
    $orgType = $orgDetails->roleName;
    $orgButtonType = $orgDetails->orgButtonType;
} else {
    echo '';
    $defaultHeader = "";
    $orgVideo = "";
}
if (isset($orgSeats)) {
    if (!empty($orgSeats->availableSheet)) {
        $availableSheet = $orgSeats->availableSheet;
    } else {
        $availableSheet = 0;
    }
    if (!empty($orgSeats->totalSheet)) {
        $totalSheet = $orgSeats->totalSheet;
    } else {
        $totalSheet = 0;
    }
}
if (isset($orgCount)) {
    $tu = $orgCount->totalUniversities;
    $tc = $orgCount->totalColleges;
    $ti = $orgCount->totalInstitutes;
    $ts = $orgCount->totalSchools;
} else {
    $tu = 0;
    $tc = 0;
    $ti = 0;
    $ts = 0;
}
echo ($orgGoogle == "" ? (isset($location) ? $location['js'] : '') : '');
?>

<!--    <script src="<?php // echo base_url('js/jquery.min.js');                                                                                            
                        ?>" type="text/javascript"></script>
-->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>

<script src="<?php echo base_url('js/amazon_scroller.js'); ?>" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>plugins/lightgallery/js/lightgallery-all.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery.form.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/app.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/imagesLoaded.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/gallery.js" type="text/javascript"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script>
    <?php include 'js/location.js'; ?>
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/counter.js"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACimPVNI1GUVZIfy5HA342kjuq7grLzS0&libraries=places&callback=initAutocomplete"
async defer></script>-->

<script>
    function imgError(ele) {
        ele.onerror = "";
        //console.log(ele);
        ele.src = '<?php echo base_url('homepage_images/default.png'); ?>';

        return true;


    }
</script>
<div class="col-md-12">
    <ul class="nav nav-tabs tabtop  tabsetting">
        <li class="active" id="fac"><a href="#tab_default_1" data-toggle="tab" onclick="OpenPage('0');">More</a></li>
        <li><a href="#tab_default_7" data-toggle="tab" onclick="OpenPage('0');">About</a></li>
        <li><a href="#tab_default_2" data-toggle="tab" onclick="OpenPage('0');"> mission , vision,</a></li>
        <li><a href="#tab_default_3" data-toggle="tab" onclick="OpenPage('0');"> Gallery </a></li>
        <li><a href="#tab_default_4" data-toggle="tab" onclick="OpenPage('0');"> Placement</a></li>
        <li><a href="#tab_default_5" data-toggle="tab" onclick="OpenPage('0');"> Faculty </a></li>
        <li><a href="#tab_default_6" data-toggle="tab" class="thbada" onclick="OpenPage('0');"> Achievements </a></li>
        <li><a href="#tab_default_8" data-toggle="tab" class="thbada" onclick="OpenPage('0');"> REVIEWS </a></li>
        <li><a href="#tab_default_9" data-toggle="tab" class="thbada" onclick="OpenPage('0');"> News </a></li>
        <li><a href="#tab_default_10" data-toggle="tab" class="thbada" onclick="OpenPage('0');"> Events </a></li>
        <?php
        if (isset($pageNames)) {
            echo '<li>
            <div class="dropdown" style="top: 9px;">
                <a class="dropdown-toggle thbada" style="padding: 11px !important;" type="button" data-toggle="dropdown">
                    Pages <i class="fa fa-angle-double-down"></i>&nbsp;
                </a><ul class="dropdown-menu" style="top: 33px;">';
            foreach ($pageNames as $pN) {
                echo '<li class="pageLink" id="pageLink' . $pN->pageId . '"><a  href = "#tab_default_Page_' . $pN->pageId . '" data-toggle="tab" class="thbada" onclick="OpenPage(' . $pN->pageId . ');">' . $pN->pageName . '</a></li>';
            }
            echo '

            </ul>
            </div>
            </li>';
        }
        ?>

    </ul>




</div>

<div class="col-md-9">
    <div class="bg-de-college">
        <div class="details-text details-text-to">
            <div class="view-to-com view-to-com-to">
                <div class="col-md-12 details-text-to-3">
                    <div class="tabbable-panel margin-tops4 ">
                        <div class="tabbable-line">
                            <div class="tab-content margin-tops">
                                <div class="tab-pane active fade in" id="tab_default_1">
                                    <div class="to-college">
                                        <span class="co-name">
                                            <h3><?php echo $orgName; ?></h3>
                                        </span>
                                        <div class="price-car-to3">
                                            <ul>
                                                <li><i class="fa fa-clock-o"></i> <?php echo $yOfEst; ?> Years</li>
                                                <li>|</li>
                                                <li>|</li>
                                                <li><i class="fa fa-user"></i> Total
                                                    Seats <?php echo $totalSheet; ?></li>
                                                <li>|</li>
                                                <li><i class="fa fa-user-plus"></i> Available
                                                    Seats <?php echo $availableSheet; ?></li>
                                                <li>|</li>
                                                <li><i class="fa fa-user-times"></i>Booked Seats <?php echo $totalSheet - $availableSheet; ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-img">
                                        <div class="col-image" <?php echo ($defaultHeader === "video" ? 'style="height:334px;"' : ''); ?>>
                                            <?php
                                            if ($defaultHeader === "video") {
                                                echo '<div class="videodiv"><video width="100%" height="100%" controls>
                                        <source src="' . base_url($orgVideo) . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video></div>';
                                            } else {
                                                echo '<img src="' . base_url($orgImgHeader) . '"/>';
                                            }
                                            ?>

                                            <marquee style="position: sticky;" class="marque" onMouseOver="this.stop()" onMouseOut="this.start()">Application Opening
                                                Date <?php
                                                        if (isset($orgSelectedCourseDetails[0]->appOpening)) {
                                                            echo $orgSelectedCourseDetails[0]->appOpening;
                                                        } else {
                                                            echo 'No Dates';
                                                        }
                                                        ?> |
                                                Application Closing Date <?php
                                                                            if (isset($orgSelectedCourseDetails[0]->appClosing)) {
                                                                                echo $orgSelectedCourseDetails[0]->appClosing;
                                                                            } else {
                                                                                echo 'No Dates';
                                                                            }
                                                                            ?> | Application Exam Date <?php
                                                                            if (isset($orgSelectedCourseDetails[0]->examDate)) {
                                                                                echo $orgSelectedCourseDetails[0]->examDate;
                                                                            } else {
                                                                                echo 'No Dates';
                                                                            }
                                                                            ?> | Result Date <?php
                                                                    if (isset($orgSelectedCourseDetails[0]->resultDate)) {
                                                                        echo $orgSelectedCourseDetails[0]->resultDate;
                                                                    } else {
                                                                        echo 'No Dates';
                                                                    }
                                                                    ?>| Exam Mode <?php
                                                                if (isset($orgSelectedCourseDetails[0]->examMode)) {
                                                                    echo $orgSelectedCourseDetails[0]->examMode;
                                                                } else {
                                                                    echo 'No Available';
                                                                }
                                                                ?>
                                            </marquee>
                                            <span class="logo-co"><img src="<?php echo base_url($orgLogo); ?>" alt="Org logo"></span>
                                            <div class="col-aproval">
                                                <h3>Approved by <?php echo $approvedBy; ?></h3>
                                            </div>
                                            <div class="web-college">
                                                <span class="type-3-to">
                                                    <p><i class="fa fa-building-o"></i> &nbsp; country : <span><?php echo $country; ?></span></p>
                                                </span>
                                                <span class="type-3-to">
                                                    <p><i class="fa fa-building-o"></i> &nbsp; State : <span><?php echo $state; ?></span></p>
                                                </span>
                                                <span class="type-3-to">
                                                    <p><i class="fa fa-building-o"></i> &nbsp; City : <span><?php echo $city; ?></span></p>
                                                </span>
                                                <span class="type-3-to">
                                                    <p><i class="fa fa-globe"></i> &nbsp; Web site : <span><a href="javascript:" id="websiteLink" linkw="<?php echo $orgWebsite; ?>"><?php echo ($orgWebsite == "" ? 'N/A' : $orgWebsite); ?></a></span></p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="border-to"></div>
                                        <div class="view-to-com">
                                            <div class="col-md-12">
                                                <div class="col-md-5 share-to-3">
                                                    <div class="share-to">
                                                        <ul>
                                                            <li><i class="fa fa-share-alt"></i></li>
                                                            <li><a href="#"><i class="fa fa-facebook"></i> Share</a>
                                                            </li>
                                                            <li><a href="#"><i class="fa fa-google-plus"></i>
                                                                    Share</a></li>
                                                            <li><a href="#"><i class="fa fa-twitter"></i> Share</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="review-3">
                                                        <ul>
                                                            <?php
                                                            if (isset($_SESSION['studentId'])) {
                                                                echo '<li class = "review1"><a href = "javascript:void(0);" id = "my-review">Write a Review</a></li>';
                                                            } else {
                                                                echo '<li class = "review1"><a href = "javascript:" id = "notloggedin">Write a Review</a></li>';
                                                            }
                                                            ?>
                                                            <li class="down"><a href="#"><i class="fa fa-download" aria-hidden="true"></i>Downloads</a>
                                                            </li>
                                                            <li> <span class="apply-too pull-right">
                                                                    <button>Add to Compare</button>

                                                                </span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        echo form_open("student/addRating", ["id" => "form_submit"]);
                                        if (isset($myRatings)) {
                                            $courseMode = $myRatings->courseMode;
                                            $Comment = $myRatings->Comment;
                                            $ratings = $myRatings->ratings;
                                        } else {
                                            $courseMode = "";
                                            $Comment = "";
                                            $ratings = 2;
                                        }
                                        ?>
                                        <div class="view-to-com" style="padding:0">
                                            <div class="col-md-12 my-review">
                                                <div class="review-block-rate">
                                                    <input type="hidden" class="hidden" name="ratings" value="<?php echo $ratings; ?>" id="ratings_id">
                                                    <input type="hidden" class="hidden" name="loginid" value="<?php echo $loginId; ?>">
                                                    <button type="button" class="btn btn-grey btn-xs buttonStar" onclick="startclick(1);" aria-label="Left Align" value="1" id="buttonStar1">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-grey btn-xs buttonStar" onclick="startclick(2);" aria-label="Left Align" value="2" id="buttonStar2">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-grey btn-xs buttonStar" onclick="startclick(3);" aria-label="Left Align" value="3" id="buttonStar3">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-grey btn-xs buttonStar" onclick="startclick(4);" aria-label="Left Align" value="4" id="buttonStar4">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-grey btn-xs buttonStar" onclick="startclick(5);" aria-label="Left Align" value="5" id="buttonStar5">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                                <div class="review-block-title">Select Course Mode</div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <select name="courseMode" required="true">
                                                            <option <?php echo ($courseMode == "Regular" ? "selected" : ""); ?> value="Regular">Regular</option>
                                                            <option <?php echo ($courseMode == "Part Time" ? "selected" : ""); ?> value="Part Time">Part Time</option>
                                                            <option <?php echo ($courseMode == "Full Time" ? "selected" : ""); ?> value="Full Time">Full Time</option>

                                                        </select>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-9">
                                                        <textarea style="height:50px;" placeholder="Write Your comment here" name="Comment" required="true"><?php echo $Comment; ?></textarea>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="submit" value="<?php echo (isset($myRatings) ? "Update" : "Submit") ?>" id="submitReview">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_open(); ?>
                                        <div class="view-to-com">
                                            <div class="col-md-12 details-text-to-3">
                                                <h3>FACILITIES</h3>
                                                <?php
                                                if (isset($reqFacility)) {
                                                    foreach ($reqFacility as $rf) {
                                                        echo '<div class = "cllege-facili">
            <ul>
            <li><a href = "#"><i class = "fa ' . $rf->facility_icon . '"></i>' . $rf->facilities . '
            </a>
            </li>
            </ul>
            </div>';
                                                    }
                                                } else {
                                                    echo '<h4>No Data Available.</h4>';
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="view-to-com">
                                            <div class="col-md-12 details-text-to-3">
                                                <div class="wrapper">
                                                    <div class="counter col_fourth">
                                                        <h2 class="timer count-title count-number" data-to="<?php echo $tu; ?>" data-speed="1500"></h2>
                                                        <p class="count-text ">University</p>
                                                    </div>
                                                    <div class="counter col_fourth">
                                                        <h2 class="timer count-title count-number" data-to="<?php echo $tc; ?>" data-speed="1500"></h2>
                                                        <p class="count-text ">College </p>
                                                    </div>
                                                    <div class="counter col_fourth">
                                                        <h2 class="timer count-title count-number" data-to="<?php echo $ti; ?>" data-speed="1500"></h2>
                                                        <p class="count-text ">Institute</p>
                                                    </div>
                                                    <div class="counter col_fourth end">
                                                        <h2 class="timer count-title count-number" data-to="<?php echo $ts; ?>" data-speed="1500"></h2>
                                                        <p class="count-text ">School</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="view-to-com">
                                            <div class="col-md-12 details-text-to-3">
                                                <div class="pro">
                                                    <p><i class="fa fa-file-code-o" aria-hidden="true"></i>
                                                        Course Type :
                                                        <select id="courseType" name="courseType">
                                                            <?php
                                                            if (isset($orgCourseType)) {
                                                                foreach ($orgCourseType as $oct) {
                                                                    echo '<option value = "' . $oct->ctId . '">' . $oct->courseType . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value = "">No Data</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </p>
                                                    <p class="hidden"><i class="fa fa-clock-o" aria-hidden="true"></i> Batch
                                                        Timing :- N/A</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="view-to-com">
                                            <div class="col-md-12 details-text-to-3">
                                                <h3>Course detail</h3>
                                                <?php
                                                $btnName = ($orgButtonType === "Enquiry" ? 'Enquiry' : 'Apply Now');

                                                if (isset($orgCourses)) {
                                                    foreach ($orgCourses as $oc) {
                                                        $btntype = ($orgButtonType === "Enquiry" ? 'enquiryNow(\'' . $loginId . '\',\'' . $orgType . '\',' . $oc->orgCourseId . ')' : 'enrollnow(\'' . $loginId . '\',\'' . $orgType . '\',' . $oc->orgCourseId . ')');

                                                        echo '<div class = "to-course">
            <div class = "all-corse">
            <div class = "col-sm-8">
            <h2 class = "Master">' . $oc->course_name. '</h2>
            </div>
            <div class = "col-sm-4">
            <a href = "#" onClick = "' . $btntype . '" class = "l-d-text"><i
            class = "fa fa-paper-plane"
            aria-hidden = "true"></i>' . $btnName . '</a>
            <a href = "#" class = "r-d-text">More Details</a>
            </div>
            </div>
            <div class = "all-corse">
            <div class = "col-sm-4 all-corse-to">
            <p><i class = "fa fa-clock-o" aria-hidden = "true"></i>Duration : ' . $oc->course_duration . ' Months</p>
            </div>
            <div class = "col-sm-4 all-corse-to">
            <p><i class = "fa fa-file-text-o" aria-hidden = "true"></i>Course Details : ' . $oc->course_details . '</p>
            </div>
            <div class = "col-sm-4 all-corse-to">
            <p><i class = "fa hidden fa-inr" aria-hidden = "true"></i> ' . $oc->courseFee . ' ' . $oc->defaultCurrency . ' (Total Fees)</p>
            </div>
            </div>
            </div>';
                                                    }
                                                } else {
                                                    echo 'No Data Found';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_7">
                                    <div class="about-college">
                                        <h3><i class="fa fa-building"></i> About: <?php echo strtoupper($orgName); ?></h3>


                                        <div class="col-sm-4">
                                            <div class="faculty-img">
                                                <img src="<?php echo base_url('images/faculty.jpg'); ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="pro-fac">
                                                <ul>
                                                    <li><i class="fa fa-sitemap" aria-hidden="true"></i>(Director)
                                                    </li>
                                                    <li><i class="fa fa-user" aria-hidden="true"></i><?php echo $directorName; ?>
                                                    </li>
                                                    <li><span><i class="fa fa-phone" aria-hidden="true"></i>Contact Number <b> :-</b></span>
                                                        <?php echo $directorMobile; ?>
                                                    </li>
                                                    <li><span><i class="fa fa-envelope" aria-hidden="true"></i>Email ID <b> :-</b></span>
                                                        <?php echo $directorEmail; ?>
                                                    </li>
                                                    <li></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <p><?php echo $orgDesp; ?></p>
                                        <br>
                                        <div class="col-sm-12 nopadding">
                                            <?php
                                            if (isset($approvalDocs)) {
                                                echo '<h3><i class="fa fa-file-o"></i>Organisation Approval Documents</h3>';
                                                foreach ($approvalDocs as $ad) {
                                                    if (file_exists($ad->docName)) {
                                                        echo '<div class="col-md-3 col-sm-12"><label>About Document</label><p>' . $ad->aboutDocument . '</p>';
                                                        //echo '<embed src="' . base_url($ad->docName) . '" width="800px" height="2100px" />';
                                                        echo '<iframe src="https://docs.google.com/gview?url=' . base_url($ad->docName) . '&embedded=true" style="width:100%; height:100%;" frameborder="0"></iframe></div>';
                                                        //echo "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=" . base_url($ad->docName) . "' width='600px' height='800px' frameborder='0'></iframe>";
                                                    } else {
                                                        echo base_url($ad->docName);
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_2">
                                    <div class="about-college">
                                        <div class="col-sm-6">
                                            <div class="img-mission">
                                                <img src="<?php echo base_url('images/m.png'); ?>" />
                                            </div>
                                            <p class="m-text"><?php echo $orgMission; ?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="img-mission">
                                                <img src="<?php echo base_url('images/v.png'); ?>" />
                                            </div>
                                            <p class="m-text"><?php echo $orgVission; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_3">
                                    <div class="about-college">
                                        <div id="gallerydiv" class="xpager-gallery lightgallery">
                                            <?php
                                            if (isset($orgGallery)) {
                                                foreach ($orgGallery as $og) {
                                                    echo '<div class = "col-sm-3">
                                                    <a href = "' . base_url($og->galaryUrl) . '" data-sub-html = "Demo Description">
                                                    <figure class = "img-effect-shine">
                                                    <img class = "img-responsive" src = "' . base_url($og->galaryUrl) . '"
                                                    alt = "Demo Description" style = "display: block; width: 246px;height:180px">
                                                    </figure>
                                                    </a>
                                                    </div>';
                                                }
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_4">
                                    <div class="about-college">
                                        <h3><i class="fa fa-user"></i> PLACEMENT</h3>
                                        <?php
                                        if (isset($orgPlacement)) {
                                            foreach ($orgPlacement as $op) {
                                                echo '<div class = "place-to">
                                                    <div class = "top-t">
                                                    <div class = "top-co">
                                                    <h3><label>Company Name : ' . $op->companyName . '</label></h3>
                                                    </div>
                                                    </div>
                                                    <div class = "col-sm-3">
                                                    <div class = "plac">
                                                    <div class = "place-ment">
                                                    <img title = "' . $op->companyName . '" alt = "' . $op->companyName . '" src = "' . base_url('projectimages/images/placementCompany/image/' . $op->companyImage) . '"/>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div> <div class = "col-sm-4">
                                                    <div class = "direct-faculty">
                                                    <h5><img src = "' . base_url('images/high.png') . '" class = "lazy" alt = "Carrer"></h5>
                                                    <h4>HIGHEST PACKAGE<br>' . $op->highestAmount . '</h4>
                                                    </div>
                                                    </div>
                                                    <div class = "col-sm-4">
                                                    <div class = "direct-faculty">
                                                    <h5><img src = "' . base_url('images/med.png') . '" class = "lazy" alt = "Carrer"></h5>
                                                    <h4>AVERAGE PACKAGE<br>' . $op->averageAmount . '</h4>
                                                    </div>
                                                    </div>
                                                    <div class = "col-sm-4">
                                                    <div class = "direct-faculty">
                                                    <h5><img src = "' . base_url('images/low.png') . '" class = "lazy" alt = "Carrer"></h5>
                                                    <h4>LOWEST PACKAGE <br>' . $op->lowestAmount . '</h4>
                                                    </div>
                                                    </div>
                                                    <div class = "review-to"></div>
                                                    ';
                                            }
                                        } else {
                                            echo '<h4>No placement data available</h4>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_5">
                                    <div class="about-college">
                                        <h3><i class="fa fa-user"></i> Faculty</h3>
                                        <div class="col-sm-6">
                                            <div class="direct-faculty">
                                                <h5><img src="<?php echo base_url('images/Faculty.png'); ?>" class="lazy" alt="Carrer">
                                                </h5>
                                                <h4>Total Faculty Members <br><?php
                                                                                if (isset($orgfaculty)) {
                                                                                    $totalfaculty = count($orgfaculty);
                                                                                } else {
                                                                                    $totalfaculty = 1;
                                                                                }
                                                                                echo $totalfaculty;
                                                                                ?></h4>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="direct-faculty">
                                                <h5><img src="<?php echo base_url('images/Student_Ratio.png'); ?>" class="lazy" alt="Carrer"></h5>
                                                <h4> Faculty Student Ratio <br>
                                                    1 : <?php echo round($totalSheet / $totalfaculty); ?> </h4>
                                            </div>
                                        </div>
                                        <div class="review-to"></div>
                                        <?php
                                        if (isset($orgfaculty)) {
                                            foreach ($orgfaculty as $fac) {
                                                echo '<div class = "col-sm-6 col-sm-6-fac">
                                                    <div class = "fac-pro">
                                                    <div class = "f-img">
                                                    <img style = "max-height:69px;" src = "' . base_url('projectimages/images/facultyImage/image/' . $fac->facultyImage) . '"/>
                                                    </div>
                                                    <div class = "r-f-text">
                                                    <span> <i class = "fa fa-user" aria-hidden = "true"></i> &nbsp;
                                                    ' . ucwords(strtolower($fac->name)) . ' </span><br>
                                                    <span><i class = "fa fa-briefcase" aria-hidden = "true"></i> ' . ucwords(strtolower($fac->post)) . '</span><br>
                                                    <span><i class = "fa fa-envelope" aria-hidden = "true"></i> ' . $fac->email . '</span>
                                                    </div>
                                                    </div>
                                                    </div>';
                                            }
                                        }
                                        ?>

                                    </div>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tab_default_6">
                                    <div class="about-college">
                                        <div class="review-block review-block-to">
                                            <div class="row">
                                                <?php
                                                if (isset($achievements)) {
                                                    foreach ($achievements as $ac) {
                                                        echo '<div class = "col-my-6">
                                                    <div class = "box-description">
                                                    <div class = "col-sm-3">
                                                    <img src = "' . base_url('projectimages/images/achievement/image/' . $ac->image) . '" class = "img-rounded">
                                                    </div>
                                                    <div class = "col-sm-9">
                                                    <h4 class = "text-center">' . ucwords(strtolower($ac->awards)) . '</h4>
                                                    <div class = "review-block-description"><p>' . $ac->description . '</p>
                                                    </div>
                                                    </div>
                                                    <div class = "clearfix"></div>
                                                    </div>
                                                    </div>';
                                                    }
                                                }
                                                ?> </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_8">
                                    <!-------======================rating==============================--->
                                    <?php
                                    if (isset($allRatings)) {
                                        $star1 = 0;
                                        $star2 = 0;
                                        $star3 = 0;
                                        $star4 = 0;
                                        $star5 = 0;
                                        $total = 0;
                                        $numOfR = 0;
                                        foreach ($allRatings as $ar) {
                                            ($ar->ratings == "1" ? $star1++ : "");
                                            ($ar->ratings == "2" ? $star2++ : "");
                                            ($ar->ratings == "3" ? $star3++ : "");
                                            ($ar->ratings == "4" ? $star4++ : "");
                                            ($ar->ratings == "5" ? $star5++ : "");
                                            $total = $total + $ar->ratings;
                                            $numOfR++;
                                        }
                                        $avg = $total / $numOfR;
                                        echo '<div class = "col-sm-5">
                                                    <div class = "rating-block">
                                                    <h4>Average user rating</h4>
                                                    <h2 class = "bold padding-bottom-7">' . $avg . '
                                                    <small>/ 5</small>
                                                    </h2>
                                                    <button type = "button" class = "btn ' . ($avg >= 1 ? 'btn-warning' : 'btn-grey') . ' btn-sm"
                                                    aria-label = "Left Align">
                                                    <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </button>
                                                    <button type = "button" class = "btn ' . ($avg >= 2 ? 'btn-warning' : 'btn-grey') . ' btn-sm"
                                                    aria-label = "Left Align">
                                                    <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </button>
                                                    <button type = "button" class = "btn ' . ($avg >= 3 ? 'btn-warning' : 'btn-grey') . ' btn-sm"
                                                    aria-label = "Left Align">
                                                    <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </button>
                                                    <button type = "button" class = "btn ' . ($avg >= 4 ? 'btn-warning' : 'btn-grey') . '  btn-sm"
                                                    aria-label = "Left Align">
                                                    <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </button>
                                                    <button type = "button" class = "btn ' . ($avg >= 5 ? 'btn-warning' : 'btn-grey') . ' btn-sm"
                                                    aria-label = "Left Align">
                                                    <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </button>
                                                    </div>
                                                    </div>';

                                        echo '<div class = "col-sm-7">
                                                    <h4>Rating breakdown</h4>
                                                    <div class = "pull-left" style = "margin-right: 15px;">
                                                    <div class = "pull-left" style = "width:35px; line-height:1;">
                                                    <div style = "height:9px; margin:5px 0;">5 <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-left" style = "width:180px;">
                                                    <div class = "progress" style = "height:9px; margin:8px 0;">
                                                    <div class = "progress-bar progress-bar-success"
                                                    role = "progressbar" aria-valuenow = "5" aria-valuemin = "0"
                                                    aria-valuemax = "5" style = "width: ' . (($star5 / $numOfR) * 100) . '%">
                                                    <span class = "sr-only">' . (($star5 / $numOfR) * 100) . '% Complete (danger)</span>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-right" style = "margin-left:10px;">' . $star5 . '</div>
                                                    </div>
                                                    <div class = "pull-left" style = "margin-right: 15px;">
                                                    <div class = "pull-left" style = "width:35px; line-height:1;">
                                                    <div style = "height:9px; margin:5px 0;">4 <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-left" style = "width:180px;">
                                                    <div class = "progress" style = "height:9px; margin:8px 0;">
                                                    <div class = "progress-bar progress-bar-primary"
                                                    role = "progressbar" aria-valuenow = "4" aria-valuemin = "0"
                                                    aria-valuemax = "5" style = "width: ' . (($star4 / $numOfR) * 100) . '%">
                                                    <span class = "sr-only">' . (($star4 / $numOfR) * 100) . '% Complete (danger)</span>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-right" style = "margin-left:10px;">' . $star4 . '</div>
                                                    </div>
                                                    <div class = "pull-left" style = "margin-right: 15px;">
                                                    <div class = "pull-left" style = "width:35px; line-height:1;">
                                                    <div style = "height:9px; margin:5px 0;">3 <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-left" style = "width:180px;">
                                                    <div class = "progress" style = "height:9px; margin:8px 0;">
                                                    <div class = "progress-bar progress-bar-info"
                                                    role = "progressbar" aria-valuenow = "3" aria-valuemin = "0"
                                                    aria-valuemax = "5" style = "width: ' . (($star3 / $numOfR) * 100) . '%">
                                                    <span class = "sr-only">' . (($star3 / $numOfR) * 100) . '% Complete (danger)</span>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-right" style = "margin-left:10px;">' . $star3 . '</div>
                                                    </div>
                                                    <div class = "pull-left" style = "margin-right: 15px;">
                                                    <div class = "pull-left" style = "width:35px; line-height:1;">
                                                    <div style = "height:9px; margin:5px 0;">2 <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-left" style = "width:180px;">
                                                    <div class = "progress" style = "height:9px; margin:8px 0;">
                                                    <div class = "progress-bar progress-bar-warning"
                                                    role = "progressbar" aria-valuenow = "2" aria-valuemin = "0"
                                                    aria-valuemax = "5" style = "width: ' . (($star2 / $numOfR) * 100) . '%">
                                                    <span class = "sr-only">' . (($star2 / $numOfR) * 100) . '% Complete (danger)</span>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-right" style = "margin-left:10px;">' . $star2 . '</div>
                                                    </div>
                                                    <div class = "pull-left" style = "margin-right: 15px;">
                                                    <div class = "pull-left" style = "width:35px; line-height:1;">
                                                    <div style = "height:9px; margin:5px 0;">1 <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-left" style = "width:180px;">
                                                    <div class = "progress" style = "height:9px; margin:8px 0;">
                                                    <div class = "progress-bar progress-bar-danger"
                                                    role = "progressbar" aria-valuenow = "1" aria-valuemin = "0"
                                                    aria-valuemax = "5" style = "width: ' . (($star2 / $numOfR) * 100) . '%">
                                                    <span class = "sr-only">' . (($star2 / $numOfR) * 100) . '% Complete (danger)</span>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class = "pull-right" style = "margin-left:10px;">' . $star1 . '</div>
                                                    </div>
                                                    </div>';
                                        echo '<div class = "col-sm-12"><hr/>';
                                        foreach ($allRatings as $ar) {
                                            echo '<div class = "row">
                                                    <div class = "col-sm-3">
                                                    <img style = "height:60px;" onerror = "imgError(this);" src = "' . site_url('projectimages/images/studentProfileImages/' . $ar->studentImage) . '"
                                                    class = "img-rounded">
                                                    <div class = "review-block-name"><a href = "#">' . ucfirst(strtolower($ar->studentName)) . '</a>
                                                    </div>
                                                    <div class = "review-block-date">' . $ar->commentDate . '<br/>' . ($ar->daysago == 0 ? 'Today' : $ar->daysago . " days ago") . '
                                                    </div>
                                                    </div>
                                                    <div class = "col-sm-9">
                                                    <div class = "review-block-rate">';
                                            for ($rp = 1; $rp <= 5; $rp++) {
                                                echo ($rp > $ar->ratings ? '<button type = "button" class = "btn btn-grey btn-xs" aria-label = "Left Align">
                                                    <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </button>' : '<button type = "button" class = "btn btn-warning btn-xs" aria-label = "Left Align">
                                                    <i class = "fa fa-star" aria-hidden = "true"></i>
                                                    </button>&nbsp;
                                                    ');
                                            }
                                            echo '</div>
                                                    <div class = "review-block-title">Comment</div>
                                                    <div class = "review-block-description">' . $ar->Comment . '
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <hr/>';
                                        }
                                        echo '</div>';
                                    } else {
                                        echo '<p> No Ratings Available</p>';
                                    }
                                    ?>
                                    <!-------======================rating==============================--->


                                </div>
                                <div class="tab-pane fade in" id="tab_default_9">

                                    <?php
                                    if (isset($news)) {
                                        foreach ($news as $ns) {
                                            echo '<div class = "review-block review-block-to">
                                                    <div class = "row">
                                                    <div class = "col-sm-3">
                                                    <img src = "' . base_url('projectimages/images/news/image/' . $ns->newsImage) . '" class = "img-rounded">
                                                    </div>
                                                    <div class = "col-sm-9">
                                                    <div class = "review-block-title">
                                                    <h3><i class = "fa fa-newspaper-o"></i>' . $ns->title . '</h3>
                                                    </div>
                                                    <div class = "review-block-description">
                                                    <p>' . $ns->description . '</p><br>
                                                    <span class = "clan"><i class = "fa fa-calendar"
                                                    aria-hidden = "true"></i><a href = "#">' . $ns->pDate . '</a></span>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>';
                                        }
                                    } else {
                                    ?><div class="review-block review-block-to">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <img src="<?php echo base_url('images/bill.jpg'); ?>" class="img-rounded">
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="review-block-title">
                                                        <h3><i class="fa fa-building"></i>GEETHANJALI INSTITUTE
                                                            OF SCIENCE AND TECHNOLOGY</h3>
                                                    </div>
                                                    <div class="review-block-description">
                                                        <p>Lorem Ipsum Is Simply
                                                            Dummy Text Of The Printing And Typesetting Industry.
                                                            Lorem Ipsum Has Been The Industry's Standard Dummy Text
                                                            Ever Since The 1500s, When An Unknown Printer Took A
                                                            Galley Of Type And Scrambled It To Make A Type Specimen
                                                            Book. It Has Survived Not Only Five Centuries, But Also
                                                            The Leap Into Electronic Typesetting, Remaining
                                                            Essentially Unchanged. It Was Popularised In The 1960s
                                                            With</p>
                                                        <br>
                                                        <span class="clan"><i class="fa fa-calendar" aria-hidden="true"></i><a href="#">29 / 07 / 2017</a></span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div><?php
                                            }
                                                ?>



                                </div>
                                <div class="tab-pane fade in" id="tab_default_10">
                                    <?php
                                    if (isset($events)) {
                                        foreach ($events as $evt) {
                                            echo '<div class="review-block review-block-to">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <img src="' . base_url('projectimages/images/eventImage/image/' . $evt->eventImage) . '" class="img-rounded">
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <div class="review-block-title">
                                                                        <h3><i class="fa fa-building"></i>' . $evt->eventTitle . '</h3>
                                                                    </div>
                                                                    <div class="review-block-description"><p>' . $evt->description . '</p>
                                                                    <br>
                                                                <span class="clan clan-to">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                <a href="#">' . $evt->publishdate . '</a></span>
                                                            <span class="clan clan-to">
                                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                                <a href="#">' . $evt->location . '</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   ';
                                        }
                                    } else {
                                    ?>
                                        <div class="review-block review-block-to">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <img src="<?php echo base_url('images/bill.jpg'); ?>" class="img-rounded">
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="review-block-title">
                                                        <h3><i class="fa fa-building"></i>GEETHANJALI INSTITUTE
                                                            OF SCIENCE AND TECHNOLOGY</h3>
                                                    </div>
                                                    <div class="review-block-description">
                                                        <p>Lorem Ipsum Is Simply
                                                            Dummy Text Of The Printing And Typesetting Industry.
                                                            Lorem Ipsum Has Been The Industry's Standard Dummy Text
                                                            Ever Since The 1500s, When An Unknown Printer Took A
                                                            Galley Of Type And Scrambled It To Make A Type Specimen
                                                            Book. It Has Survived Not Only Five Centuries, But Also
                                                            The Leap Into Electronic Typesetting, Remaining
                                                            Essentially Unchanged. It Was Popularised In The 1960s
                                                            With</p>
                                                        <br>
                                                        <span class="clan clan-to"><i class="fa fa-calendar" aria-hidden="true"></i><a href="#">29 / 07 / 2017</a></span>
                                                        <span class="clan clan-to"><i class="fa fa-map-marker" aria-hidden="true"></i><a href="#">Delhi</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><?php } ?>
                                </div>

                                <?php
                                if (isset($pageNames)) {
                                    foreach ($pageNames as $pn) {
                                        echo '<div class="tab-pane fade in" id="tab_default_Page_' . $pn->pageId . '">
                                                    <div class="pagesDiv col-lg-12" id="pageId' . $pn->pageId . '" >
                                                        <div class="text-center"><h2>' . $pn->pageName . '</h2></div>
                                                            <div class="col-lg-12">' . $pn->description . '</div>
                                                    </div>
                                                </div>';
                                    }
                                }
                                ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="col-md-3">

    <div class="span8">
        <?php
        if (isset($highlightedData)) {
            $courseName = $highlightedData->course_name . ' (' . $highlightedData->course_details . ')';
            $courseDuration = $highlightedData->course_duration . " Months";
            $courseFee = $highlightedData->courseFee;
            $btnName = ($orgButtonType === "Enquiry" ? 'Enquiry' : 'Apply Now');
            $btntypehc = ($orgButtonType === "Enquiry" ?
                'enquiryNow(\'' . $loginId . '\',\'' . $orgType . '\',' . $highlightedData->orgCourseId . ',' . $highlightedData->orgCourseId . ')' :
                'enrollnow(\'' . $loginId . '\',\'' . $orgType . '\',' . $highlightedData->orgCourseId . ',' . $highlightedData->orgCourseId . ')');
        } else {
            $courseName = "";
            $courseDuration = "";
            $courseFee = "";
            $btntypehc = "";
        }
        ?> <span class="img-to">
            <img src="<?php echo base_url($orgImgHeader); ?>" />
        </span>
        <ul>
            <li><?php echo $courseName; ?></li>
            <li><?php echo $courseDuration; ?></li>
            <li><?php echo $courseFee; ?></li>
            <li><a href="#" onclick="<?php echo $btntypehc; ?>" class="to-3-4">Enroll Now</a></li>
        </ul>
    </div>

    </span>
    <div class="span8">
        <h3><i class="fa fa-map-marker"></i>Location on Map</h3>
        <?php echo ($orgGoogle == "" ? (isset($location) ? $location['html'] : '') : ''); ?>
        <!--    <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=15+Springfield+Way,+Hythe,+CT21+5SH&amp;aq=t&amp;sll=52.8382,-2.327815&amp;sspn=8.047465,13.666992&amp;ie=UTF8&amp;hq=&amp;hnear=15+Springfield+Way,+Hythe+CT21+5SH,+United+Kingdom&amp;t=m&amp;z=14&amp;ll=51.077429,1.121722&amp;output=embed"></iframe>-->
    </div>
    <span class="span8 span8-to-3">
        <span class="img-to">
            <img src="<?php echo base_url('images/download.jpg'); ?>" />
        </span>
        <p>An alumni association is an association of graduates or, more broadly, of former students (alumni). In the United Kingdom and the United States, alumni of universities, colleges, schools (especially independent schools), fraternities, and sororities often form groups with alumni from the same organization</p>
    </span>
    <span class="span8 span8-to-3">
        <h3><i class="fa fa-briefcase"></i>Latest Jobs</h3>
        <ul>
            <li><a href="#"><span><img src="<?php echo base_url('images/l.jpg'); ?>" /></span> Lorem Ipsum is simply dummy text ...</a></li>
            <li><a href="#"><span><img src="<?php echo base_url('images/l.jpg'); ?>" /></span> Lorem Ipsum is simply dummy text ...</a></li>
            <li><a href="#"><span><img src="<?php echo base_url('images/l.jpg'); ?>" /></span> Lorem Ipsum is simply dummy text ...</a></li>
            <li><a href="#"><span><img src="<?php echo base_url('images/l.jpg'); ?>" /></span> Lorem Ipsum is simply dummy text ...</a></li>
            <li><a href="#"><span><img src="<?php echo base_url('images/l.jpg'); ?>" /></span> Lorem Ipsum is simply dummy text ...</a></li>
            <li><a href="#"><span><img src="<?php echo base_url('images/l.jpg'); ?>" /></span> Lorem Ipsum is simply dummy text ...</a></li>
            <li><a href="#"><span><img src="<?php echo base_url('images/l.jpg'); ?>" /></span> Lorem Ipsum is simply dummy text ...</a></li>
            <li><a href="#"><span><img src="<?php echo base_url('images/l.jpg'); ?>" /></span> Lorem Ipsum is simply dummy text ...</a></li>
        </ul>
    </span>

</div>
<div class="modal fade" id="orgWebsiteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header modal-header-primary" style="height: 30px;
                 background: #eee;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #faa71a;padding: 2px;
                        height: 10px;right: 0px;">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="modalbody" style="padding: 0px; border: solid 2px #ea9d19;border-radius: 6px;">

                    </div>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<?php include_once 'shared/footer.php'; ?>
<!--------------------------footer----------------------->
<script type="text/javascript">
    function startclick(id) {
        var ratings_id = parseInt($("#ratings_id").val());
        if (id === "") {
            id = ratings_id;
        }
        $(".buttonStar").removeClass("btn-warning");
        $(".buttonStar").addClass("btn-grey");
        for (var i = 1; i <= id; i++) {
            $("#buttonStar" + i).addClass("btn-warning");
            $("#buttonStar" + i).removeClass("btn-grey");
        }
        $("#ratings_id").val(id);
        return true;
    }
    $(document).ready(function() {
        //                                                        $("#gallery").xGallery();
        startclick("");
        $('#gallerydiv').lightGallery({
            thumbnail: true,
            animateThumb: true,
            showThumbByDefault: true
        });
        $("#courseType").change(function() {
            var ctId = $(this).val();
        });

        $("#submitReview").click(function() {
            var options = {
                beforeSend: function() {
                    var ratings = $("#ratings_id").val();
                    if (ratings === "") {
                        $.alert({
                            title: 'Error!',
                            content: "Please Select Ratings.",
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function() {
                                    window.location.reload();
                                }
                            }
                        });
                        return false;
                    }
                },
                success: function(response) {
                    //console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({
                            title: 'Success!',
                            content: json.msg,
                            type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function() {
                                    window.location.reload();
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
                                    window.location.reload();
                                }
                            }
                        });
                    }
                },
                error: function(response) {
                    $('#error').html(response);
                }
            };
            $('#form_submit').ajaxForm(options);
        });

    });
</script>
<script>
    /*global $ */
    document.title = 'iHuntBest | <?php echo $orgName . ' Details'; ?>';
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            data: {
                id: '<?php echo $loginId; ?>'
            },
            url: "<?php echo site_url("home/orgViewCounter"); ?>"
        });
        $("#websiteLink").click(function() {

            var weblink = $(this).attr('linkw');
            if (weblink !== "") {
                var iframe = '<iframe src="' + weblink + '" height="600" width="100%"></iframe>';
                $("#modalbody").html(iframe);
                $("#orgWebsiteModal").modal('show');
            } else {
                return false;
            }
        });
    });
</script>
<script>
    $("#notloggedin").click(function(e) {
        $.alert({
            title: 'Error!',
            content: "Login as Student to write a review.",
            type: 'red',
            typeAnimated: true
        });
    });
    $('#my-review-btn,#my-review').click(function(e) {
        $('.my-review').slideToggle('slow');

    });
    getReligion("", "religion_id");

    function getReligion(selval, id) {
        var result = '<option value="">Select</option>';
        $.ajax({
            url: '<?php echo site_url('home/religion'); ?>',
            success: function(response) {
                if (response !== "") {
                    var respjson = $.parseJSON(response);
                    for (var i = 0; i < respjson.length; i++) {
                        result = result + '<option value="' + respjson[i].religionId + '">' + respjson[i].religionName + '</option>';
                    }
                    $('#' + id).html(result);
                    $('#' + id).val(selval);
                } else {
                    $.alert({
                        title: 'Error!',
                        content: response,
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
                    content: jqXHR["status"] + " - " + exception,
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

    function OpenPage(id) {
        $(".pageLink").each(function() {
            if ($(this).attr("id") !== 'pageLink' + id) {
                $(this).removeClass("active");
            }
        });
        //        $(".pageLink").removeClass('active');
        //        $("#pageLink" + id).addClass('active');
    }
</script>