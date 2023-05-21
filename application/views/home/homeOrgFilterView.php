<?php
if (isset($type)) {
    if ($type == "University") {
        ?>
        <div id="mixedSlider1" >
            <div id="table" class="MS-content">
                <?php
                if (isset($orgRes)) {
                    foreach ($orgRes as $od) {
                        if ($od->availableSeats == "") {
                            $availabesheets = 0;
                        } else {
                            $availabesheets = $od->availableSeats;
                        }
                        $avg = $od->ratings;

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
                                            <div class="col-lg-6 text-center ">
                                                <a href="javascript:" onClick="enrollnow(\'' . base64_encode($od->loginId) . '\',\'University\',' . $od->courseid . ',' . $od->OrgcourseId . ')"  class="to">Enroll Now</a>
                                            </div>
                                       </div>
                                    </div>';
                    }
                }
                ?>

            </div>
            <div class="MS-controls">
                <button class="MS-left"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/l-aerrow.png"/></button>
                <button class="MS-right"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/r-aerrow.png"/></button>
            </div>
        </div>
        <script>

            $('#mixedSlider1').multislider({
                duration: 750,
                interval: 3000
            });
        </script>
        <?php
    }
    if ($type == "College") {
        ?><div id="mixedSlider11">
            <div id="table" class="MS-content"  >
                <?php
                if (isset($orgRes)) {
                    foreach ($orgRes as $od) {
                        if ($od->availableSeats == "") {
                            $availabesheets = 0;
                        } else {
                            $availabesheets = $od->availableSeats;
                        }
                        $avg = $od->ratings;

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
                                            <div class="col-lg-6 text-center ">
                                                <a href="javascript:" onClick="enrollnow(\'' . base64_encode($od->loginId) . '\',\'College\',' . $od->courseid . ',' . $od->OrgcourseId . ')"  class="to">Enroll Now</a>
                                            </div>
                                       </div>
                                    </div>';
                    }
                }
                ?>

            </div>
            <div class="MS-controls">
                <button class="MS-left"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/l-aerrow.png"/></button>
                <button class="MS-right"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/r-aerrow.png"/></button>
            </div>
        </div>
        <script>

            $('#mixedSlider11').multislider({
                duration: 750,
                interval: 3000
            });
        </script>
        <?php
    }
    if ($type == "Institute") {
        ?>
        <div id="mixedSlider111">
            <div id="table" class="MS-content"  >
                <?php
                if (isset($orgRes)) {
                    foreach ($orgRes as $od) {
                        if ($od->availableSeats == "") {
                            $availabesheets = 0;
                        } else {
                            $availabesheets = $od->availableSeats;
                        }
                        $avg = $od->ratings;

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
                                            <div class="col-lg-6 text-center ">
                                                <a href="javascript:" onClick="enrollnow(\'' . base64_encode($od->loginId) . '\',\'Institute\',' . $od->courseid . ',' . $od->OrgcourseId . ')"  class="to">Enroll Now</a>
                                            </div>
                                       </div>
                                    </div>';
                    }
                }
                ?>

            </div>
            <div class="MS-controls">
                <button class="MS-left"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/l-aerrow.png"/></button>
                <button class="MS-right"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/r-aerrow.png"/></button>
            </div>
        </div>
        <script>

            $('#mixedSlider111').multislider({
                duration: 750,
                interval: 3000
            });
        </script>
        <?php
    }
    if ($type == "School") {
        ?><div id="mixedSlider1111">
            <div id="table" class="MS-content" >
                <?php
                if (isset($orgRes)) {
                    foreach ($orgRes as $od) {
                        if ($od->availableSeats == "") {
                            $availabesheets = 0;
                        } else {
                            $availabesheets = $od->availableSeats;
                        }
                        $avg = $od->ratings;

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
                                            <div class="col-lg-6 text-center ">
                                                <a href="javascript:" onClick="enrollnow(\'' . base64_encode($od->loginId) . '\',\'School\',' . $od->courseid . ',' . $od->OrgcourseId . ')"  class="to">Enroll Now</a>
                                            </div>
                                       </div>
                                    </div>';
                    }
                }
                ?>

            </div>
            <div class="MS-controls">
                <button class="MS-left"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/l-aerrow.png"/></button>
                <button class="MS-right"><img onerror="imgError(this);" src="<?php echo base_url(); ?>images/r-aerrow.png"/></button>
            </div>
        </div>
        <script>

            $('#mixedSlider1111').multislider({
                duration: 750,
                interval: 3000
            });
        </script><?php
    }
}
?>
