<?php
if (isset($_SESSION['userType'])) {
    redirect($_SESSION['userType'] . '/dashboard');
} else {

}
?>
<!doctype html>
<html>
    <head>
        <?php echo $map['js']; ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>iHuntBest | Register</title>
        <link rel="icon" href="<?php echo base_url(); ?>images/fav.png" type="image/jpg" sizes="30x30">
        <link href='https://fonts.googleapis.com/css?family=Karla' rel='stylesheet'>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/skins/skin-blue.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>css/responcive.css" rel="stylesheet" type="text/css"/>

        <link href="<?php echo base_url(); ?>css/animate.css" rel="stylesheet" type="text/css" media="all"/>
        <link href="<?php echo base_url(); ?>css/registerform.css" rel="stylesheet" type="text/css"/>

        <script src="<?php echo base_url(); ?>js/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/amazon_scroller.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

    </head>

    <body style="background-color: #bdb4b4 !Important;">
        <!-- The Modal -->
        <div id="modelTerms" class="modalcstm">
            <!-- Modal content -->
            <div class="modal-contentcstm">
                <div class="modal-headercstm">
                    <span class="closecstm" onclick="closemodal('modelTerms');">&times;</span>
                    <h2 class="text-center headerstyles">Terms & Conditions</h2>
                </div>
                <div class="modal-bodycstm">
                    <div>
                        <ol>
                            <li>This portal caters Universities, colleges ,Institutes and schools only.</li>
                            <li>This is promotional portal only.</li>
                            <li>Your organization stands liable for information mentioned or published on the portal.</li>
                            <li>Focus of information should be transparency in the education system.</li>
                        </ol>
                    </div>

                </div>
                <div class="modal-footercstm">
                    <div class="hidden"><?php echo $map['html']; ?></div>
                </div>
            </div>

        </div>

        <div class="modal-content1">
            <div class="agile-its">
                <div class="m-img-t">
                    <a href="<?php echo site_url("home/index"); ?>"><img src="<?php echo base_url(); ?>images/logo.png" style="max-width:200px;margin-top: 15px;margin: auto;
                                                                         float: none;
                                                                         display: block;
                                                                         padding-top: 15px;"></a>

                    <h1 style="color:red; font-weight:bold;margin-bottom:10px; text-align:center; margin-top:0px;">NOTIFICATION</h1>
                    <p style="text-align:center;">Empowered by NEDC</p>
                    <p style="font-weight:bold; margin-bottom:20px;text-align:center;">Welcome to National Educational Portal, Institute/College/University Registration is open, you can register your college &amp; Courses/Programs.</p>
                </div>
                <button type="button" class="tablink tablink-0"  onclick="openCity('London', 'defaultOpen', '#ff9900')" id="defaultOpen">Register</button>
                <button type="button" class="tablink tablink-01" onclick="openCity('Paris', 'loginbtn', '#643d91')" id="loginbtn">Login</button>
                <div id="London" class="tabcontent">
                    <div class="w3layouts">
                        <div class="photos-upload-view">
                            <?php echo form_open('Login/newRegistration', ["id" => "register_form", "name" => "register_form"]); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Role Type</label>
                                        <select id="roleName" name="roleName" class="form-control">
                                            <option value="University">University</option>
                                            <option value="College">College</option>
                                            <option value="Institute">Institute</option>
                                            <option value="School">School</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Organization Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Organization Name" data-validation="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Mobile</label>
                                        <input type="text" name="orgMobile" id="orgMobile" class="form-control numOnly" placeholder="Mobile" data-validation="required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email_id" autocomplete="off" class="form-control" placeholder="Email" data-validation="required">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group has-feedback">
                                <label>Password</label>
                                <input type="password" name="password" id="password" autocomplete="new-password" class="form-control" placeholder="Password" data-validation="required">
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label>Country</label>

                                        <select name="countryId" id="countryId" class="form-control" data-validation="required"></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label>State</label>

                                        <select name="stateId" id="stateId" class="form-control" data-validation="required"></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label>City</label>
                                        <select name="cityId" id="cityId" class="form-control" data-validation="required"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Address</label>

                                <input type="text" name="address" id="address" class="form-control" data-validation="required">

                            </div>
                            <div id="error"></div>
                            <!--<div id="signupformCaptcha" class="g-recaptcha" data-sitekey="6LfYFV0UAAAAAPmeRqPDdUCFNWvDbR3IXgyKMNp3"></div>-->
                            <div id="signupformCaptcha" ></div>
                            <br>

                            <div class="col-sm-8 no-padding-left reg-btn">
                                <p style="float:left;"><input type="checkbox" class="checkbox2 checkbox" required>
                                <div id="opener" style="float: left;margin-top: 2px;margin-left: 13px;">
                                    <a href="#1" name="1" onclick="showterms();" style="color:#000;">I accept terms and conditions</a></div>

                                </p>

                            </div>
                            <div style="float: right" class="col-md-6">

                                <button type="submit" class="btn btn-primary btn-block btn-flat" id="save_user">Register</button>
                            </div>
                            <?php echo form_close(); ?>
                            <div id="benefits" style="display:none;">
                                <div id="myModal" class="niraj">
                                    <div class="modal-content11">
                                        <div class="agile-its3" style="    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.23);">
                                            <h4 style="text-align:left; padding-left:15px;"></h4>
                                            <li style="padding:15px;text-align: justify;color: #443f3f;font-weight: normal;line-height: 24px;    font-size: 14px; list-style:none;">1. This portal caters Universities, colleges ,Institutes and schools only.</li>
                                            <li style="padding:15px;text-align: justify;color: #443f3f;font-weight: normal;line-height: 24px;    font-size: 14px; list-style:none;">2. This is promotional portal only.</li>
                                            <li style="padding:15px;text-align: justify;color: #443f3f;font-weight: normal;line-height: 24px;    font-size: 14px; list-style:none;">3. Your organisation stands liable for information mentioned or published on the portal</li>
                                            <li style="padding:15px;text-align: justify;color: #443f3f;font-weight: normal;line-height: 24px;    font-size: 14px; list-style:none;">3. Focus of information should be transparency in the education system</li>
                                            <div id="upbutton" style="position: absolute;right: 0;top: 0;background: red;color: #fff;"> <a onclick="conceal();" style="color:#fff;">&times;</a></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="clear"></div>

                    </div>
                </div>

                <div id="Paris" class="tabcontent">
                    <div class="w3layouts">
                        <div class="photos-upload-view">
                            <?php echo form_open("Login/orglogin", ["id" => "login_form", "name" => "login_form"]); ?>
                            <div class="agileinfo-row">
                                <div class="ferry ferry-from">
                                    <input type="text" name="email" class="form-control" placeholder="Email" required>
                                </div>

                                <div class="ferry ferry-from">
                                    <input type="password" autocomplete="off" name="password" class="form-control" placeholder="Password" data-validation="required">
                                </div>

                                <div class="form-group has-feedback">
                                    <select class="select2 form-control" id="role" name="role">
                                        <option value="University">University</option>
                                        <option value="College">College</option>
                                        <option value="Institute">Institute</option>
                                        <option value="School">School</option>
                                    </select>
                                </div>
                                <p id="message"></p>

                                <div class="clear"></div>

                            </div>
                            <!--<div id="loginrecaptha" class="g-recaptcha" data-sitekey="6LfYFV0UAAAAAPmeRqPDdUCFNWvDbR3IXgyKMNp3"></div>-->
                            <div id="loginrecaptha"></div>
                            <br>

                            <div class="row">
                                <div class="col-xs-6" >
                                    <button type="button" class="btn btn-primary btn-block btn-flat" >
										<a href="<?php echo site_url('forgotpassword?type=org'); ?>">
											Forget Password
										</a>
									</button>
                                </div>
                                <div class="col-xs-6">
                                    <button type="submit"  style="background-color: #faa71a" class="btn  btn-block btn-flat" name="loginadmin" id="login" >Sign in</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="gif">
                                <img src="<?php echo base_url(); ?>images/Open_educational_resources_animated.gif"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------------------pop up------------------------------>

        <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url(); ?>plugins/jQuery/jquery.form.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

        <script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>


        <script>

                                                $("#ct").change(function () {
                                                    //alert('ok');
                                                    var x = document.getElementById("ct").value;
                                                    if (x === "User") {
                                                        $("#ctp").show();
                                                    } else {
                                                        $("#ctp").hide();
                                                    }
                                                });
                                                $("#email_id").change(function () {
                                                    var email = $(this).val();
                                                    email = email.toLowerCase();
                                                    if (email !== "" && (email.search('gmail') > "0" || email.search('hotmail') > "0" || email.search('rediffmail') > "0" || email.search('outlook') > "0" || email.search('zoho') > "0")) {


                                                        $.alert({
                                                            title: 'Error!', content: "Public Domain are not allowed. Please use Domain/Professional email Id.", type: 'red',
                                                            typeAnimated: true
                                                        });
                                                        $("#email_id").val("");
                                                        return false;
                                                    } else {
                                                        return true;
                                                    }
                                                });
                                                function showterms()
                                                {
                                                    $("#modelTerms").css('display', 'block');
                                                }

                                                function closemodal(id)
                                                {
                                                    $("#" + id).css('display', 'none');
                                                }
        </script>


        <script>
            function openCity(cityName, elmnt, color) {
                $(".tabcontent").css("display", "none");
                $(".tablink").css("background", "");
                $("#" + elmnt).css("background", color);
                $("#" + cityName).css("display", "block");
            }
            // Get the element with id="defaultOpen" and click on it

        </script>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("home/siteVisitor"); ?>"
                });
                $("#email_id").val("");
                document.getElementById("defaultOpen").click();
                $.validate({
                    lang: 'en'
                });
                getCountries();

                $('#countryId').change(function () {
                    var countryId = $('#countryId').val();
                    var selected_stateId = "";
                    getcountryByStates(countryId, selected_stateId);
                });

                $('#stateId').change(function () {
                    var stateId = $('#stateId').val();
                    var selected_cityId = "";
                    getStateByCity(stateId, selected_cityId);
                });
                $('#save_user').click(function () {
                    if ($("#g-recaptcha-response").val() === "") {
                        alert("Please Enter Recapcha");
                        $("#g-recaptcha-response").focus();
                    }
                    var options = {
                        beforeSend: function () {

                        },
                        success: function (response) {
                            //                            alert(response);
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
                            } else {
                                $.alert({
                                    title: 'Error!', content: json.msg, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                            grecaptcha.reset(widgetId1);
                                            window.location.reload();
                                        }
                                    }
                                });
                            }
                        },
                        error: function (jqXHR, exception) {
                            $.alert({
                                title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    Ok: function () {
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    };
                    $('#register_form').ajaxForm(options);
                });
                $('#login').click(function () {
                    var options = {
                        beforeSend: function () {
                        },
                        success: function (response) {
                            var json = $.parseJSON(response);
                            if (json.status === 'error') {
                                grecaptcha.reset(widgetId2);
                                $.alert({title: 'Error!', content: json.msg, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    }});
                            } else if (json.status === 'captcha') {
                                grecaptcha.reset(widgetId2);
                                $.alert({title: 'Error!', content: json.msg, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    }});
                            } else {
                                $.alert({title: 'Success!', content: json.msg, type: 'blue',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    }
                                });
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
                    };
                    $('#login_form').ajaxForm(options);
                });
                $('#forget').click(function () {
                    var options = {
                        beforeSend: function () {
                        },
                        success: function (response) {
                            var json = $.parseJSON(response);
                            if (json.status === 'success') {
                                alert(json.msg);
                                $('#myModalask').modal('hide');
                            } else {
                                $('#message').text(json.msg);
                            }
                        },
                        error: function (response) {
                            $('#error').html(response);
                        }
                    };
                    $('#forget_form').ajaxForm(options);
                });
                $('.numOnly').keydown(function (e) {
                    if (e.shiftKey || e.ctrlKey || e.altKey) {
                        e.preventDefault();
                    } else {
                        var key = e.keyCode;
                        if (!((key == 8) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                            //if (key > 31 && (key < 48 || key > 57))

                            e.preventDefault();


                        }

                    }
                });
                function getCountries() {
                    $.ajax({
                        url: "<?php echo site_url('Home/getCountriesJson'); ?>",
                        type: 'POST',
                        data: '',
                        success: function (response) {
                            var json = $.parseJSON(response);
                            var data = '<option value="">Choose Country</option>';
                            for (var i = 0; i < json.length; i++) {
                                data = data + '<option value="' + json[i].countryId + '">' + json[i].name + '</option>';
                            }
                            $('#countryId').html(data);
                        }
                    });
                }
                function getcountryByStates(countryId, selected_stateId) {
                    $.ajax({
                        url: "<?php echo site_url('Home/getStatesByCountry'); ?>",
                        type: 'POST',
                        data: 'countryId=' + countryId,
                        success: function (response) {
                            var json = $.parseJSON(response);
                            var data = '<option value="">Choose State</option>';
                            for (var i = 0; i < json.length; i++) {
                                data = data + '<option value="' + json[i].stateId + '">' + json[i].name + '</option>';
                            }
                            $('#stateId').html(data);
                            $('#stateId').val(selected_stateId);
                        }
                    });
                }

                function getStateByCity(stateId, selected_cityId) {
                    $.ajax({
                        url: "<?php echo site_url('Home/getCityByStates') ?>",
                        type: 'POST',
                        data: 'stateId=' + stateId,
                        success: function (response) {
                            var json = $.parseJSON(response);
                            var data = '<option value="">Choose City</option>';
                            for (var i = 0; i < json.length; i++) {
                                data = data + '<option value="' + json[i].cityId + '">' + json[i].name + '</option>';
                            }
                            $('#cityId').html(data);
                            $('#cityId').val(selected_cityId);
                        }
                    });
                }
            });

            var verifyCallback = function (response) {
                alert(response);
            };
            var widgetId1;
            var widgetId2;
            var onloadCallback = function () {
                // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
                // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
                widgetId1 = grecaptcha.render('signupformCaptcha', {
                    'sitekey': '6LfYFV0UAAAAAPmeRqPDdUCFNWvDbR3IXgyKMNp3',
                    'theme': 'dark'
                });
                widgetId2 = grecaptcha.render('loginrecaptha', {
                    'sitekey': '6LfYFV0UAAAAAPmeRqPDdUCFNWvDbR3IXgyKMNp3', 'theme': 'dark'
                });

            };
        </script>
    </body>
</html>
