<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(0);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="google-signin-client_id" content="1098112280898-pa8h04sn3eehti6cb21l9qonn9gq0ea1.apps.googleusercontent.com">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="icon" href="<?php echo base_url(); ?>images/fav.png" type="image/jpg" sizes="30x30">
        <link href='https://fonts.googleapis.com/css?family=Karla' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="<?php echo base_url('css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('css/style.css?v=1.8'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('css/responcive.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('css/animate.css'); ?>" rel="stylesheet" type="text/css" media="all"/>
        <link href="<?php echo base_url('css/registerform.css?v=1.1'); ?>" rel="stylesheet" type="text/css" >
        <link href="<?php echo base_url(); ?>plugins/lightgallery/css/lightgallery.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('plugins\summernote\summernote.css'); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <script src="https://apis.google.com/js/platform.js" async defer></script>

    </head>
    <body>
        <div id="navbar">
            <div class="container">
                <nav class="navbar navbar-default navbar-static-top" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"></a>
                    </div>

                    <div class="collapse navbar-collapse" id="navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <select  class="menu-select" id="countryId" name="countryId"></select>
                            </li>
                            <li>
                                <select  class="menu-select" id="stateId" name="stateId"></select>
                            </li><li>
                                <select  class="menu-select" id="cityId" name="cityId"></select>
                            </li>
                            <li><a href="#">Test Plans</a></li>
                            <li><a href="#">Advertise Plans</a></li>
                            <li><a href="#">Alert</a></li>
                            <?php
                            if (isset($_SESSION['studentName'])) {
                                ?>
                                <li><a href="#" class="textEllipsis">Welcome <?php echo $_SESSION['studentName']; ?> </a></li>
                                <li><a href="<?php echo site_url('studentDashboard'); ?>">My DashBoard</a></li>
                                <li><a href="<?php echo site_url('Register/logout'); ?>" onclick="signOut();"  id="myBtn2">Logout</a></li>
                                <?php
                            } else {
                                ?>
                                <li><a href="#"  id="myBtn">Student Login/Sign Up</a></li>
                                <?php
                            }
                            if (isset($_SESSION["userType"])) {

                                echo '<li><a href="' . site_url($_SESSION['userType'] . '/dashboard') . '" title="' . $_SESSION['orgName'] . '">My DashBoard</a></li>
                                <li><a href="' . site_url('Register/logout') . '"  id="myBtn2">Logout</a></li>';
                            } else {
                                echo '<li><a href="' . site_url("LoginOrRegister") . '"  id="myBtn2">Organization Login/Sign Up</a></li>';
                            }
                            ?>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </div>
        </div>
        <div class="loading">
            <div class="loder-box">
                <img src="<?php echo base_url('images/load1.png'); ?>" class="load1">
                <img src="<?php echo base_url('images/load3.png'); ?>" class="load3">
                <img src="<?php echo base_url('images/load2.png'); ?>" class="load2">
            </div>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content1">
                <div class="agile-its">
                    <button class="tablink tablink-0" onclick="openCity('London', this, '#ff9900')" id="defaultOpen">Register</button>
                    <button class="tablink tablink-01" onclick="openCity('Paris', this, '#643d91')">Login</button>
                    <span class="close" onclick="closeModal('myModal');">&times;</span>
                    <div id="London" class="tabcontent">
                        <div class="w3layouts">
                            <div class="photos-upload-view">
                                <?php echo form_open('Register/studentRegistration', ["id" => "studentRegistrationForm"]); ?>
                                <div class="">
                                    <div class="row">
                                        <div id="message"></div>
                                        <div class="col-md-6">
                                            <label>Student Name</label>
                                            <input class="form-control" name="studentName" id="studentName" placeholder="Student Name" data-validation="required">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Student Mobile</label>
                                            <input class="form-control numOnly" maxlength="10" minlength="10" name="studentMobile" id="studentMobile" placeholder="Student Mobile" data-validation="number length required" data-validation-length="10">
                                        </div>

                                        <div class="col-md-6">
                                            <div class="ferry ferry-from">
                                                <label>Student Email</label>
                                                <input class="form-control" name="email" id="studentemail" placeholder="Email" data-validation="required email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ferry ferry-from">
                                                <label>Password</label>
                                                <input class="form-control" type="password" name="password" id="studentpassword" placeholder="Password" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ferry ferry-from">
                                                <label>Country</label>
                                                <select  class="form-control" id="countryId1"   name="countryId" data-validation="required"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ferry ferry-from">
                                                <label>State</label>
                                                <select class="form-control" id="stateId1" data-validation="required" name="stateId1"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ferry ferry-from">
                                                <label>City</label>
                                                <select class="form-control" id="cityId1" data-validation="required" name="cityId1"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group has-feedback">
                                                <label>Location</label>
                                                <input type="text" name="address" id="address" class="form-control" data-validation="required" placeholder="Enter a location" autocomplete="off">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Date Of Birth</label>
                                            <input class="form-control" name="dob" id="dob" type="date">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Gender</label>

                                            <div class="">
                                                <div class="agileinfo_radio_button">
                                                    <label class="radio"><input name="gender" class="gender" value="male" id="male" checked="" type="radio"><i></i>Male</label>
                                                </div>
                                                <div class="agileinfo_radio_button">
                                                    <label class="radio"><input name="gender" class="gender" value="female" id="female" type="radio"><i></i>Female</label>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>

                                        <div class="clear"></div>
                                    </div>

                                    <div class="wthree-text">
                                        <br>
                                        <div class="wthreesubmitaits">
                                            <input name="save_user" id="registerStudent" value="Register" type="submit">
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <?php echo form_close(); ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>


                    <div id="Paris" class="tabcontent">
                        <div class="w3layouts">
                            <?php echo form_open("Register/studentLogin", ['id' => 'studentLoginForm']); ?>
                            <form action="services/student-login.php" id="login_form" method="post">
                                <div class="photos-upload-view">
                                    <input type="hidden" value="<?php echo $this->input->get('referCode'); ?>" id="rcode" name="refercode">
                                    <div class="agileinfo-row">
                                        <div class="ferry ferry-from">
                                            <label>User Email</label>
                                            <input type="email" name="email" id="email" placeholder="Email" required>
                                        </div>

                                        <div class="ferry ferry-from">
                                            <label>Password</label>
                                            <input type="password" name="password" id="password" placeholder="Password" required>
                                        </div>
                                        <div class="alert alert-danger hidden" id="messagesdiv">
                                        </div>
                                        <div id="studentLoginCaptcha" ></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="wthree-text">
                                        <!--                                <label class="anim">
                                                                                                            <input type="checkbox" class="checkbox" required>
                                                                                                            <span>Forgot Password?</span>
                                                                        </label>-->
                                        <div class="wthreesubmitaits">
                                            <input type="submit" id="studentlogin" name="login" value="Sign In">
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="wthree-text">
                                        <a href="<?php echo site_url("forgotpassword"); ?>" class="">
                                            <div class="wthreesubmitaits forgotbutton text-center">
                                                Forgot Password
                                            </div>
                                        </a>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 text-center" style="text-align: -webkit-center;">
                                        <div class="col-md-12 col-sm-12" style="text-align: -webkit-center;text-align: -moz-center;padding: 20px;">
                                            <div id="my-signin2"></div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <fb:login-button scope="public_profile,email,user_gender,user_location" onlogin="checkLoginState();">
                                            </fb:login-button>
                                            <div id="status">
                                            </div>
                                        </div>
                                        <div id="fb-root"></div>
                                        <script async defer src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.2&appId=294729754539736&autoLogAppEvents=1"></script>





                                    </div>



                                </div>
                            </form>
                            <?php echo form_close(); ?>
                            <div class="clear"></div>
                            <div class="gif">
                                <img src="<?php echo base_url(); ?>images/Open_educational_resources_animated.gif"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php if (!isset($_SESSION['countryId'])) { ?>
            <div class="hunt-modal" id="hunt-modal">
                <span class="__title">Pick A Region</span>
                <div class="location-search-container nav-tip" data-id="dTopRgnDD" data-role="dHeaderDD">
                    <div class="__dd-trianglel"></div>
                    <div class="__dd-sec-top struktur"> <span class="__icon search-icon"> <i class=" fa fa-search"></i> </span> <span class="twitter-typeahead" style="position: relative; display: inline-block;">
                            <input class="form-input __input _default tt-hint" type="text" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);">
                            <input class="form-input __input _default tt-input" id="inp_RegionSearch_top" type="text" placeholder="Search for your city"    style="position: relative; vertical-align: top; background-color: transparent;">
                            <pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Roboto, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizeLegibility; text-transform: none;"></pre>
                            <div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                                <div class="tt-dataset tt-dataset-result"></div>
                            </div>
                        </span>
                        <div data-id="inp_RegionSearch_top" style="position: absolute; display: none; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 1px solid rgb(73, 186, 142); padding: 10px; width: 85%; max-height: 190px; overflow-y: auto;">
                            <ul id="uRgnLst_top">
                            </ul>
                        </div>
                    </div>
                    <div class="__dd-sec-bottom">
                        <div class="__dropdown-head"> Popular Countries </div>
                        <div class="__top-cities">
                            <ul>
                                <li class="region-list" id="101"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/india.png"> </span> India </a>
                                    <div class="sub-region" style="display: none;"> </div>
                                </li>
                                <li class="region-list" id="44"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/china.png"> </span>China </a>
                                    <div class="sub-region" style="display: none;"> </div>
                                </li>
                                <li class="region-list" id="38"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/canada.png"> </span> Canada </a> </li>
                                <li class="region-list" id="231"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/usa.png"> </span> USA</a> </li>
                                <li class="region-list" id="75"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/france.png"> </span> France </a> </li>
                                <li class="region-list" id="181"> <a href="javascript:"><span class="__icon"> <img src="<?php echo base_url(); ?>images/russia.png"> </span>Russia </a> </li>
                                <li class="region-list" id="13"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/australia.png"> </span> Australia </a> </li>
                                <li class="region-list" id="82"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/germany.png"> </span> Germany </a> </li>
                                <li class="region-list" id="202"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/south-africa.png"> </span> South Africa </a> </li>
                                <li class="region-list" id="109"> <a href="javascript:"> <span class="__icon"> <img src="<?php echo base_url(); ?>images/japan.png"> </span> Japan </a> </li>
                            </ul>
                        </div>
                        <div class="others-cities-list" style="display:none;">
                            <div class="__dropdown-head"> Other Cities </div>

                            <ul class="city-list">
                                <?php
                                if (isset($countries_list)) {
                                    foreach ($countries_list as $cl) {
                                        echo '<li class="city-name " id="' . $cl->countryId . '"> <a href="javascript:" onclick="BMS.Region.fnSTopReg(\'KOLK\',\'Kolkata\');"> ' . $cl->name . ' </a> </li>';
                                    }
                                }
                                ?>

                            </ul>

                        </div>
                        <a class="__view-all-cities" href="javascript:" onclick="$('.__dd-sec-bottom .others-cities-list').toggle();(!$('.others-cities-list').is(':visible') ? $(this).text('View All Cities') : $(this).text('Hide All Cities'));">View All Cities</a> </div>
                </div>
            </div>
        <?php } ?>
        <div class="container">
            <div class="search-box">
                <div class="col-md-3">
                    <div class="logo"><a href="<?php echo site_url("home/index"); ?>"><img src="<?php echo base_url(); ?>images/logo.png"/></a></div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6 nopadding" style="padding: 5px;">
                    <div class="search-fill autocomplete nopadding" id="mainSearchboxdiv">
                        <input loginIds="" orgType="" type="search" placeholder="Search By Course, Location or College Name" id="mainSearchbox" /><a
                            href="javascript:" onclick="findRelatedOrg();"><img src="<?php echo base_url(); ?>images/se.png"/></a></div>
                </div>
                <div class="col-md-2">
                    <div class="cart"><a href="#"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>Cart</a></div>
                </div>
            </div>
        </div>
        <!---=======================================header-3==================================---->
        <?php include 'menu.php'; ?>
        <!---=======================================header-3==================================---->
        <!------------------adds--------------------------->
        <div class="bg-color bg-color-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="modal" id="enrollModal" role="dialog" style="z-index: 99999">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content enrollModalshadow">
                                <div class="modal-body">
                                    <div class="container-fluid nopadding">
                                        <div class="row" style="border: solid 1px #faa71a;   border-radius: 6px;">
                                            <div class="col-md-12" style="padding: 10px 0px; background: #ececec;">
                                                <div class="col-md-2 nopadding text-center">
                                                    <img  id="en_collegelogo" src=""/>
                                                </div>
                                                <div class="col-md-7 r-login nopadding">
                                                    <form>
                                                        <div class="col-md-12 text-center">
                                                            <div class="col-md-12" style="padding: 10px;" >
                                                                <h4 id="en_collegename"></h4>
                                                            </div>
                                                            <div class="col-md-12" style="padding: 3px;">
                                                                <h6 id="en_collegeaddress"></h6>
                                                            </div>
                                                            <h6  id="approvedById"></h6>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-2 nopadding text-center">
                                                    <img   id="enqLogo" src="<?php echo base_url('images/logo.png'); ?>"/>
                                                </div>
                                                <div class="col-md-1 closediv"><span id="closeenrollModal"><i class="fa fa-times fa-1x" id="closesign" ></i></span></div>
                                            </div>
                                            <div class="col-lg-12 nopadding">
                                                <?php echo form_open('home/enrollNow', ['id' => 'enrollNowForm', 'class' => 'form-horizontal']); ?>
                                                <fieldset>
                                                    <input type="hidden" name="orgCourseId" id="orgCourseId" class="hidden">
                                                    <input type="hidden" name="courseId" id="enrcourseId" class="hidden">
                                                    <input type="hidden" name="orgType" id="orgTypeId" class="hidden">
                                                    <div class="col-lg-12 text-center nopadding">
                                                        <h4 class="enrollnowlabels" style=" margin-bottom:10px;">Application Form</h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-2 text-center col-sm-12 nopadding">
                                                            <img src="" class="img-thumbnail" onerror="this.src='<?php echo base_url('homepage_images/default.png'); ?>'" id='studentImageenroll'>
                                                        </div>
                                                        <div class="col-lg-10 nopadding">
                                                            <div class="col-md-12 nopadding">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="col-md-4 control-label" for="textinput">Name</label>
                                                                        <div class="col-md-8">
                                                                            <input  name="textinput" id="en_name_id" type="text" placeholder="Name" class="form-control input-md">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="col-md-4 control-label" for="textinput">Birthday</label>
                                                                        <div class="col-md-8">
                                                                            <input id="en_birthday_id" name="textinput" type="Date" placeholder="Birthday" class="form-control input-md">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-md-4 control-label" for="textinput">Mobile</label>
                                                                    <div class="col-md-8">
                                                                        <input id="en_mobile_id" name="textinput" type="text" placeholder="Mobile" class="form-control input-md">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-md-4 control-label" for="textinput">Father</label>
                                                                    <div class="col-md-8">
                                                                        <input id="en_father_id" name="textinput" type="text" placeholder="Father" class="form-control input-md">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="textinput">Place Of Birth</label>
                                                            <div class="col-md-8">
                                                                <input id="en_placeofb_id" name="textinput" type="text" placeholder="Place Of Birth" class="form-control input-md">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="filebutton">Nationality</label>
                                                            <div class="col-md-8">
                                                                <input id="en_nationality_id" name="filebutton" class="form-control input-md" placeholder="Nationality" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="textinput">Religion</label>
                                                            <div class="col-md-8">
                                                                <select name="religion" id="religion_id"><option value="">Select</option></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="textinput">Email</label>
                                                            <div class="col-md-8">
                                                                <input id="en_email_id" name="textinput" type="email" placeholder="Email" class="form-control input-md">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 nopadding  text-center" id="courseDetails">
                                                    </div>
                                                    <div class="col-lg-12 text-center nopadding" id="valEligibilityId">
                                                        <h4 class="enrollnowlabels"  style=" margin-bottom:10px;">Validating Eligibility</h4>
                                                        <div class="col-md-12 col-sm-12 nopadding" id="requiredqual"></div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-green-gradient hidden" id="iseligible" style="padding:5px;">You are eligible</h5>
                                                        </div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-red-gradient hidden" id="isnoteligible" style=" padding:5px;">You are not eligible</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center nopadding" id="experienceDiv">
                                                        <h4 class="enrollnowlabels" id="ExperienceId" style=" margin-bottom:10px;">Experience</h4>
                                                        <div class=" col-lg-12 col-md-12 col-sm-12 nopadding" id="expprereqDiv"></div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-green-gradient hidden" id="iseligibleexp" style="padding:5px;">You are eligible</h5>
                                                        </div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-red-gradient hidden" id="isnoteligibleexp" style=" padding:5px;">You are not eligible</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center nopadding" id="agePreReqDiv">
                                                        <h4 class="enrollnowlabels" id="ExperienceId" style=" margin-bottom:10px;">Age Pre Requisites</h4>
                                                        <div class=" col-lg-12 col-md-12 col-sm-12 nopadding" id="agetablediv"></div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-green-gradient hidden" id="iseligibleage" style="padding:5px;">You are eligible</h5>
                                                        </div>
                                                        <div class="col-md-12 nopadding">
                                                            <h5 class="bg-red-gradient hidden" id="isnoteligibleage" style=" padding:5px;">You are not eligible</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-center nopadding" style="margin: 10px 0px;" id="submitbtn">
                                                        <input type="submit" style="width: fit-content;    padding: 10px;  letter-spacing: 1px;" id="singlebutton" name="singlebutton" class="btn btn-success" value="Enroll Now">
                                                    </div>
                                                </fieldset>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal" id="enquiryModal" role="dialog" style="z-index: 99999">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="width: 100%;">
                                <div class="modal-body">
                                    <div class="container-fluid nopadding">
                                        <div class="row" style="border: solid 1px #faa71a;   border-radius: 6px;">
                                            <div class="col-md-12" style="padding: 10px 0px; background: #ececec;">
                                                <div class="col-md-2 nopadding text-center">
                                                    <img style="max-height: 80px;" id="en_collegelogoenq" src=""/>
                                                </div>
                                                <div class="col-md-9 r-login nopadding">
                                                    <form>
                                                        <div class="col-md-12">
                                                            <div class="col-md-3" style="padding: 10px;">
                                                                <h5>Name</h5>
                                                            </div>
                                                            <div class="col-md-9  " style="padding: 10px;" >
                                                                <h5 id="enq_orgname"></h5>
                                                            </div>
                                                            <div class="col-md-3" style="padding: 10px;">
                                                                <h5>Address</h5>
                                                            </div>
                                                            <div class="col-md-9" style="padding: 10px;">
                                                                <h5 id="enq_orgaddress"></h5>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-1"><a href="javascript:"><span id="closeenqiryModal"><i class="fa fa-times fa-2x"></i></span></a></div>
                                            </div>
                                            <div class="col-md-12 nopadding  text-center" id="courseDetailsenq">
                                            </div>
                                            <div class="col-lg-12 nopadding">
                                                <?php echo form_open('home/enquiryNow', ['id' => 'enquiryForm', 'class' => 'form-horizontal']); ?>
                                                <fieldset>
                                                    <input type="hidden" name="orgCourseId" id="enqorgCourseId" class="hidden">
                                                    <input type="hidden" name="courseId" id="enqcourseId" class="hidden">
                                                    <input type="hidden" name="orgType" id="enqorgTypeId" class="hidden">

                                                    <div class="col-lg-12 text-center nopadding">
                                                        <h4 class="enrollnowlabels" style=" margin-bottom:10px;">Enquiry Form</h4>
                                                    </div>
                                                    <div class="col-md-12 nopadding">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label" for="textinput">Name</label>
                                                                <div class="col-md-8">
                                                                    <input  name="senderName" id="senderName_id" value="<?php echo (isset($_SESSION['studentName']) ? $_SESSION['studentName'] : ""); ?>" type="text" placeholder="Name" data-validation="required" class="form-control input-md">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label" for="textinput">Email</label>
                                                                <div class="col-md-8">
                                                                    <input id="emailSender" name="emailSender" value="<?php echo (isset($_SESSION['studentemail']) ? $_SESSION['studentemail'] : ""); ?>" type="email" placeholder="Email" data-validation="required email" class="form-control input-md">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" for="textinput">Mobile</label>
                                                            <div class="col-md-8">
                                                                <input id="contact_id" name="contactSender" type="text" placeholder="Mobile" class="form-control input-md" data-validation="required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <div class="form-group">
                                                            <label class="col-md-12 text-left" for="textinput">Message</label>
                                                            <div class="col-md-12">
                                                                <textarea placeholder="Message" class="form-control" style="resize:none;" name="enqmessage" data-validation="required"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-center">
                                                        <button id="enquiryBtn" name="enquiryBtn" class="btn btn-primary">Send Enquiry</button><br><br>
                                                    </div>
                                                </fieldset>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>