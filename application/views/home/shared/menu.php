<div class="fixed-header-">
    <div class="menu-container">
        <div class="container">
            <div class="menu">
                <ul>
                    <li><a href="#">UNIVERSITY</a>
                        <ul id="universityDropDown">
                            <li><a href="#">University Views</a>
                                <ul>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=University&Status=toprated"); ?>">Top Rated University</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=University&Status=latest"); ?>">Latest University</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=University&Status=featured"); ?>">Featured University</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#">COLLEGE</a>
                        <ul id="collegeDropDown">
                            <li><a href="#">College Views</a>
                                <ul>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=College&Status=toprated"); ?>">Top Rated College</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=College&Status=latest"); ?>">Latest College</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=College&Status=featured"); ?>">Featured College</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#">INSTITUTE</a>
                        <ul id="instituteDropDown">
                            <li><a href="#">INSTITUTE Views</a>
                                <ul>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=Institute&Status=toprated"); ?>">Top Rated Institute</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=Institute&Status=latest"); ?>">Latest Institute</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=Institute&Status=featured"); ?>">Feature Institute</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#">SCHOOL</a>
                        <ul>
                            <li><a href="#">SCHOOL Views</a>
                                <ul>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&Status=toprated"); ?>">Top Rated School</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&Status=latest"); ?>">Latest School</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&Status=featured"); ?>">Feature School</a></li>
                                </ul>
                            </li>
                            <li><a href="#">CLASS</a>
                                <ul>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">First 1st)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Second(2nd)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Third(3rd)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Fourth(4th)</a></li>

                                </ul>
                            </li>
                            <li><a href="#">&nbsp;</a>
                                <ul>

                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Fifth(5th)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Six(6th)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Seventh(7th)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Eighth(8th)</a></li>

                                </ul>
                            </li>
                            <li><a href="#">&nbsp;</a>
                                <ul>

                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Nineth(9th)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=Up to Metric"); ?>">Tenth(10th)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=11th"); ?>">Eleventh(11th)</a></li>
                                    <li><a href="<?php echo site_url("allOrganizationDetails?Type=School&ClassType=12th"); ?>">Twelveth(12th)</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--    <div class="to-header">-->
    <!--        <div class="container">-->
    <!--            <ul class="quickly_ul">-->
    <!--                <li>best hunter   -   </li>-->
    <!--                <li><a href="all_college.html">Best Colleges</a></li>-->
    <!--                <li><a href="all_college.html">Most Popular Colleges</a></li>-->
    <!--                <li><a href="all_college.html">Top Rated Colleges</a></li>-->
    <!--                <li><a href="all_college.html">Latest Colleges</a></li>-->
    <!--            </ul>-->
    <!--        </div>-->
    <!--    </div>-->
    <!-----------------------slider--------------------------->

    <div id="first-slider">
        <div id="carousel-example-generic" class="carousel slide carousel-fade">
            <!-- Indicators -->
            <!--            <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                        </ol>-->
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <!-- Item 1 -->
                <?php
                if (isset($orgSlides)) {
                    $x = 1;
                    foreach ($orgSlides as $os) {
                        echo '<div class="item ' . ($x == 1 ? 'active' : '') . ' slide' . $x++ . '" style="height:450px;">
                                    <img style="width:100%;overflow:hidden;" src="' . base_url($os->imageUrl) . '" alt="University Slides"/>
                                <div class="row">
                                    <div class="container">
                                        <div class="col-md-7 text-left">
                                            <h5 data-animation="animated bounceInDown">Receive a World-Class</h5>
                                            <h5 data-animation="animated bounceInUp">Education In the heart of The West.</h5>
                                            <p>Top Rated For combining academic quality and outdoor recreation.</p>
                                            <div class="click-search"><a href="#">Register TOday</a><a href="#">Check Courses</a></div>
                                        </div>
                                        <div class="col-md-5 text-right"></div>
                                    </div>
                                </div>
                            </div>';
                    }
                } else {
                    ?>
                    <div class="item active slide1">
                        <img src="<?php echo base_url(); ?>images/slider.jpg"/>
                        <div class="row"><div class="container">
                                <div class="col-md-7 text-left">
                                    <h5 data-animation="animated bounceInDown">Receive a World-Class</h5>
                                    <h5 data-animation="animated bounceInUp">Education In the heart of The West.</h5>
                                    <p>Top Rated For combining academic quality and outdoor recreation.</p>
                                    <div class="click-search"><a href="#">Register TOday</a><a href="#">Check Courses</a></div>
                                </div>
                                <div class="col-md-5 text-right"></div>
                            </div></div>
                    </div>
                    <!-- Item 2 -->
                    <div class="item slide2">
                        <img src="<?php echo base_url(); ?>images/slider.jpg"/>
                        <div class="row"><div class="container">
                                <div class="col-md-7 text-left">
                                    <h5 data-animation="animated bounceInDown">Receive a World-Class</h5>
                                    <h5 data-animation="animated bounceInUp">Education In the heart of The West.</h5>
                                    <p>Top Rated For combining academic quality and outdoor recreation.</p>
                                    <div class="click-search"><a href="#">Register TOday</a><a href="#">Check Courses</a></div>
                                </div>
                                <div class="col-md-5 text-right"></div>
                            </div></div>
                    </div>
                    <!-- Item 3 -->
                    <div class="item slide3">
                        <img src="<?php echo base_url(); ?>images/slider.jpg"/>
                        <div class="row"><div class="container">
                                <div class="col-md-7 text-left">
                                    <h5 data-animation="animated bounceInDown">Receive a World-Class</h5>
                                    <h5 data-animation="animated bounceInUp">Education In the heart of The West.</h5>
                                    <p>Top Rated For combining academic quality and outdoor recreation.</p>
                                    <div class="click-search"><a href="#">Register TOday</a><a href="#">Check Courses</a></div>
                                </div>
                                <div class="col-md-5 text-right"></div>
                            </div></div>
                    </div>
                    <!-- Item 4 -->
                    <div class="item slide4">
                        <img src="<?php echo base_url(); ?>images/slider.jpg"/>
                        <div class="row"><div class="container">
                                <div class="col-md-7 text-left">
                                    <h5 data-animation="animated bounceInDown">Receive a World-Class</h5>
                                    <h5 data-animation="animated bounceInUp">Education In the heart of The West.</h5>
                                    <p>Top Rated For combining academic quality and outdoor recreation.</p>
                                    <div class="click-search"><a href="#">Register TOday</a><a href="#">Check Courses</a></div>
                                </div>
                                <div class="col-md-5 text-right"></div>
                            </div></div>
                    </div>
                    <?php
                }
                ?>

                <?php
                if (isset($reqFacility)) {
                    echo '<div class="top-coll">
                            <div class="container-fluid">
                                <div class="facilities-bar">';
                    $fi = 0;
                    foreach ($reqFacility as $rf) {
                        if ($fi < 4) {
                            echo '<span class="btn custom-btn text-center" data-toggle="tooltip" title="' . $rf->facilities . '">
                                        <i class="fa ' . $rf->facility_icon . '"></i>
                                        <small>' . $rf->facilities . '</small>
                                    </span>';
                            $fi++;
                        }
                    }
                    echo '<a href="#fac" class="scroll"><span class="btn custom-btn text-center" data-toggle="tooltip" title="More facilities">
                            <i class="fa fa-arrow-right"></i>
                            <small>More</small>
                            </span></a>
                        </div>
                    </div>
                </div>';
                }
                ?>




                <!-- End Item 4 -->

            </div>
            <!-- End Wrapper for slides-->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <i class="fa fa-angle-left"></i><span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <i class="fa fa-angle-right"></i><span class="sr-only">Next</span>
            </a>

        </div>

    </div>

</div>