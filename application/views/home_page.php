<?php
include_once 'shared/header.php';
?>

<!---=======================================header-3==================================---->
<!------------------adds--------------------------->
<div class="container add-to">
    <div class="col-md-12">
        <div class="addimage"><img src="<?php echo base_url();?>images/add.png"/></div>
    </div>
</div>

<!----------------------------------------------content------------------------------->

<!----------------------------------Enroll now start----------------------------------------->
<div class="modal" id="enrollModal" role="dialog" style="z-index: 99999">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 100%;">
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 nopadding">
                        <img id="en_collegelogo" src=""/>
                    </div>
                    <div class="col-md-9 r-login nopadding">
                        <form>
                            <div class="col-md-12">
                                <div class="col-md-3 nopadding">
                                    <h5>Collage Name</h5>
                                </div>
                                <div class="col-md-9 nopadding" >
                                    <h5 id="en_collegename"></h5>
                                </div>
                                <div class="col-md-3 nopadding">
                                    <h5>Address</h5>
                                </div>
                                <div class="col-md-9 nopadding">
                                    <h5 id="en_collegeaddress"></h5>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-1"><span id="closeenrollModal"><i class="fa fa-times fa-2x"></i></span></div>
                    <div class="col-lg-12 nopadding">
                        <form class="form-horizontal">
                                    <fieldset>
                                        <div class="col-lg-12 text-center nopadding">
                                            <h4 class="enrollnowlabels" style=" margin-bottom:10px;">Application Form</h4>
                                        </div>
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
                                                <label class="col-md-4 control-label" for="textinput">Relition</label>  
                                                <div class="col-md-8">
                                                <input id="en_relition_id" name="textinput" type="text" placeholder="Relition" class="form-control input-md">
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
                                        <div class="col-lg-12 text-center nopadding">
                                            <h4 class="enrollnowlabels" style=" margin-bottom:10px;">Validating Eligibility</h4>
                                        </div>
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Qualification</th>
                                                    <th>Board/University </th>
                                                    <th>Name Of School/College/institute</th>
                                                    <th>Your Marks percentages/Grade</th>
                                                    <th>Match</th>
                                                    <th>Marks Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span id="en_qualification_id"></span>10th</td>
                                                    <td>bihar examination board patna </td>
                                                    <td>R.J.S College</td>
                                                    <td>70%</td>
                                                    <td class="red-color">
                                                        <span class="green"> <i class="fa fa-check" aria-hidden="true"></i></span>
                                                        <span class="red-color-c"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                    </td>
                                                    <td>
                                                        <button class="click-e"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10th</td>
                                                    <td>bihar examination board patna </td>
                                                    <td>R.J.S College</td>
                                                    <td>A Grade</td>
                                                    <td class="red-color2">
                                                        <span class="green"> <i class="fa fa-check" aria-hidden="true"></i></span>
                                                        <span class="red-color-c"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                    </td>
                                                    <td>
                                                        <button class="click-e"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                          </table>
                                        <div class="col-lg-12 text-center nopadding">
                                            <h4 class="enrollnowlabels" style=" margin-bottom:10px;">Experience</h4>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Total Experience</th>
                                                    <th>Company Name </th>
                                                    <th>Your Experience</th>
                                                    <th>Required Experience</th>
                                                    <th>Match</th>
                                                    <th>Experience Edit</th>		
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>4 Years</td>
                                                    <td>Selenium</td>
                                                    <td>8 Month</td>
                                                    <td>3 years</td>
                                                    <td class="red-color">
                                                        <span class="green"> <i class="fa fa-check" aria-hidden="true"></i></span>
                                                        <span class="red-color-c"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                    </td>	
                                                    <td>
                                                        <button class="click-e"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4 Years</td>
                                                    <td>Selenium</td>
                                                    <td>8 Month</td>
                                                    <td>12 years</td>
                                                    <td class="red-color2">
                                                        <span class="green"> <i class="fa fa-check" aria-hidden="true"></i></span>
                                                        <span class="red-color-c"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                    </td>
                                                    <td>
                                                        <button class="click-e"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="col-md-12 text-center">
                                            <button id="singlebutton" name="singlebutton" class="btn btn-primary">Send</button>
                                        </div>
                                    </fieldset>
            </form>
                    </div>
                </div>
            </div>
            
                
        </div>
        </div>
        
      </div>
    </div>
  </div>

<!----------------------------------Enroll now end------------------------------------------->
<div class="container add-to-3">
    <div class="col-md-12">
        <div class="heading">
            <h2>EXPLORE ALMOST EVERYTHING</h2>
            <span class="bott-img"><img src="<?php echo base_url();?>images/head.png"/></span>
            <p>iHuntBest.com is an extensive search engine for the students, parents,<br>
                and education industry players who are seeking information</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img src="<?php echo base_url();?>images/1-icon.png"/></span>
                <div class="text-box">
                    <a href="#">FIND BEST COLLEGE</a>
                    <p>Learn about the best of bests in the country.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img src="<?php echo base_url();?>images/2-icon.png"/></span>
                <div class="text-box">
                    <a href="#">EXPLORE EXAMS</a>
                    <p>All information about the exams that will get you into your dream college.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img src="<?php echo base_url();?>images/3-icon.png"/></span>
                <div class="text-box text-box-to">
                    <a href="#">GET ADMISSION</a>
                    <p>Find information about the final step to colleges and courses.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 hover-img-box">
            <div class="image-box">
                <span class="image-box-to"><img src="<?php echo base_url();?>images/4-icon.png"/></span>
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
                <span class="bott-img"><img src="<?php echo base_url();?>images/head.png"></span>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <!--------------slide--------------->
                <div class="col-md-12 latest-to">
                    <div class="latest">
                        <h2>Colleges</h2>

                        <a href="single-organisation?iHuntBest=College">VIEW ALL</a>
                    </div>
                </div>
                <div class="box-sadow">

                    <div id="mixedSlider">
                        <div id="table" class="MS-content">
                            <?php
                            if(isset($collegesRes))
                            {
                                foreach ($collegesRes as $cr)
                                {
                                    if($cr->availabesheets=="")
                                    {
                                        $availabesheets =   0;
                                    }else
                                    {
                                        $availabesheets =   $cr->availabesheets;
                                    }
                                    $loginId = base64_encode($cr->loginId);
                                    echo '<div class="item">
                                    <div class="imgTitle">
                                        <span class="logo-co"><img src="'.base_url($cr->orgLogo).'" alt=""/></span>
                                        <h5 class="blogTitle"><i class="fa fa-map-marker"
                                                                 aria-hidden="true"></i>'.$cr->orgAddress.'</h5>
                                        <span class="po-check">
                                 </span>
                                        <span class="name-to">Available Seats <b>'.$availabesheets.'</b></span>
                                        <img src="'.base_url($cr->orgImgHeader).'" alt=""/>
                                    </div>
                                    <p><strong>'.$cr->orgName.'</strong></p>
                                    <span class="name"><p><strong>Email </strong>: '.$cr->email.' </p></span>
                                    <span class="name"><p><strong>Phone</strong> : '.$cr->orgMobile.'</p></span>
                                    <span class="name"><p><strong>Website</strong> : '.$cr->orgWebsite.' </p></span>

                                    <div class=" clearfix"></div>
                                    <div class="col-lg-12 nopadding">
                                        <div class="col-lg-5 text-right nopadding">
                                            <a href="details.php?orgId='.$loginId.'" class="to">View Details</a>
                                        </div>
                                        <div class="col-lg-2 text-right nopadding"></div>
                                        <div class="col-lg-5 text-right nopadding">
                                            <a href="#" class="to" onClick="enrollnow(\''.$loginId.'\',\'College\')">Enroll Now</a>
                                        </div>
                                    </div>
                                </div>';
                                }
                            }
                            ?>


                        </div>
                        <div class="MS-controls">
                            <button class="MS-left"><img src="<?php echo base_url();?>images/l-aerrow.png"/></button>
                            <button class="MS-right"><img src="<?php echo base_url();?>images/r-aerrow.png"/></button>
                        </div>
                    </div>
                </div>

                <div class="box-sadow">
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                            <h2>University</h2>
                            <a href="single-organisation?iHuntBest=University">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="col-md-12 to-slide">

                        <div id="mixedSlider1">
                            <div id="table" class="MS-content">
                                <?php
                                if(isset($universityRes))
                                {
                                    foreach ($universityRes as $ur)
                                    {
                                        if($ur->availabesheets=="")
                                    {
                                        $availabesheats =   0;
                                    }else
                                    {
                                        $availabesheats =   $ur->availabesheets;
                                    }
                                        echo '<div class="item">
                                        <div class="imgTitle">
                                            <span class="logo-co"><img src="'.base_url($ur->orgLogo).'" alt=""/></span>
                                            <h5 class="blogTitle"><i class="fa fa-map-marker"
                                                                     aria-hidden="true"></i>'.$ur->orgAddress.'</h5>
                                            <span class="po-check">
                                 </span>
                                            <span class="name-to">Available Seats <b>'.$availabesheats.'</b></span>
                                            <img src="'.base_url($ur->orgImgHeader).'" alt=""/>
                                        </div>
                                        <p><strong>'.$ur->orgName.'</strong></p>
                                        <span class="name"><p><strong>Email </strong>: '.$ur->email.' </p></span>
                                        <span class="name"><p><strong>Phone</strong> : '.$ur->orgMobile.'</p></span>
                                        <span class="name"><p><strong>Website</strong> : '.$ur->orgWebsite.' </p></span>

                                        <div class=" clearfix"></div>
                                        <div class="col-lg-12 nopadding">
                                            <div class="col-lg-5 text-right nopadding">
                                                <a href="details.php?orgId='.base64_encode($ur->loginId).'" class="to">View Details</a>
                                            </div>
                                            <div class="col-lg-2 text-right nopadding"></div>
                                            <div class="col-lg-5 text-right nopadding">
                                                <a href="#" class="to" onClick="enrollnow(\''.base64_encode($ur->loginId).'\',\'University\');">Enroll Now</a>
                                            </div>
                                        </div>
                                    </div>';
                                    }
                                }?>
                            </div>
                            <div class="MS-controls">
                                <button class="MS-left"><img src="<?php echo base_url();?>images/l-aerrow.png"/></button>
                                <button class="MS-right"><img src="<?php echo base_url();?>images/r-aerrow.png"/></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-sadow">
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                            <h2>School</h2>

                            <a href="single-organisation?iHuntBest=School">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="col-md-12 to-slide">
                        <div id="mixedSlider11">
                            <div id="table" class="MS-content">
                                 <?php
                                if(isset($schoolRes))
                                {
                                    foreach ($schoolRes as $sr)
                                    {
                                        if($sr->availabesheets=="")
                                    {
                                        $availabesheats =   0;
                                    }else
                                    {
                                        $availabesheats =   $sr->availabesheets;
                                    }
                                        echo '<div class="item">
                                        <div class="imgTitle">
                                            <span class="logo-co"><img src="'.base_url($sr->orgLogo).'" alt=""/></span>
                                            <h5 class="blogTitle"><i class="fa fa-map-marker"
                                                                     aria-hidden="true"></i>'.$sr->orgAddress.'</h5>
                                            <span class="po-check">
                                 </span>
                                            <span class="name-to">Available Seats <b>'.$availabesheats.'</b></span>
                                            <img src="'.base_url($sr->orgImgHeader).'" alt=""/>
                                        </div>
                                        <p><strong>'.$sr->orgName.'</strong></p>
                                        <span class="name"><p><strong>Email </strong>: '.$sr->email.' </p></span>
                                        <span class="name"><p><strong>Phone</strong> : '.$sr->orgMobile.'</p></span>
                                        <span class="name"><p><strong>Website</strong> : '.$sr->orgWebsite.' </p></span>

                                        <div class=" clearfix"></div>
                                        <div class="col-lg-12 nopadding">
                                            <div class="col-lg-5 text-right nopadding">
                                                <a href="details.php?orgId='.base64_encode($sr->loginId).'" class="to">View Details</a>
                                            </div>
                                            <div class="col-lg-2 text-right nopadding"></div>
                                            <div class="col-lg-5 text-right nopadding">
                                                <a href="#" class="to" onClick="enrollnow(\''.base64_encode($sr->loginId).'\',\'School\')">Enroll Now</a>
                                            </div>
                                        </div>
                                    </div>';
                                        
                                    }
                                }?>
                            </div>
                            <div class="MS-controls">
                                <button class="MS-left"><img src="<?php echo base_url();?>images/l-aerrow.png"/></button>
                                <button class="MS-right"><img src="<?php echo base_url();?>images/r-aerrow.png"/></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-sadow">
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                            <h2>Institute</h2>

                            <a href="single-organisation?iHuntBest=Institute">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="col-md-12 to-slide">
                        <div id="mixedSlider111">
                            <div id="table" class="MS-content">
                                <?php
                                if(isset($instituteRes))
                                {
                                    foreach ($instituteRes as $ir)
                                    {
                                        if($ir->availabesheets=="")
                                    {
                                        $availabesheats =   0;
                                    }else
                                    {
                                        $availabesheats =   $ir->availabesheets;
                                    }
                                        echo '<div class="item">
                                        <div class="imgTitle">
                                            <span class="logo-co"><img src="'.base_url($ir->orgLogo).'" alt=""/></span>
                                            <h5 class="blogTitle"><i class="fa fa-map-marker"
                                                                     aria-hidden="true"></i>'.$ir->orgAddress.'</h5>
                                            <span class="po-check">
                                 </span>
                                            <span class="name-to">Available Seats <b>'.$availabesheats.'</b></span>
                                            <img src="'.base_url($ir->orgImgHeader).'" alt=""/>
                                        </div>
                                        <p><strong>'.$ir->orgName.'</strong></p>
                                        <span class="name"><p><strong>Email </strong>: '.$ir->email.' </p></span>
                                        <span class="name"><p><strong>Phone</strong> : '.$ir->orgMobile.'</p></span>
                                        <span class="name"><p><strong>Website</strong> : '.$ir->orgWebsite.' </p></span>

                                        <div class=" clearfix"></div>
                                        <div class="col-lg-12 nopadding">
                                            <div class="col-lg-5 text-right nopadding">
                                                <a href="details.php?orgId='.base64_encode($ir->loginId).'" class="to">View Details</a>
                                            </div>
                                            <div class="col-lg-2 text-right nopadding"></div>
                                            <div class="col-lg-5 text-right nopadding">
                                                <a href="#" class="to" onClick="enrollnow(\''.base64_encode($ir->loginId).'\',\'Institute\')">Enroll Now</a>
                                            </div>
                                        </div>
                                        
                                    </div>';
                                        
                                    }
                                }?>
                            </div>
                            <div class="MS-controls">
                                <button class="MS-left"><img src="<?php echo base_url();?>images/l-aerrow.png"/></button>
                                <button class="MS-right"><img src="<?php echo base_url();?>images/r-aerrow.png"/></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--------------slide--------------->
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
    function enrollnow(id,type)
    {
        if(id!=="" && type!=="")
        {
            $.ajax({
                type: "POST",
                data:{id:id,type:type},
                url: "<?php echo site_url('Home/getEnrollData');?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                     
                    if(json.studentDetails!=="")
                    {
                        $("#en_name_id").val(json.studentDetails[0].studentName);
                        $("#en_birthday_id").val(json.studentDetails[0].dob);
                        $("#en_mobile_id").val(json.studentDetails[0].studentMobile);
                        $("#en_nationality_id").val(json.studentDetails[0].name);
                        $("#en_email_id").val(json.studentDetails[0].email);
                    }
                    if(json.orgDetails!=='')
                    {
                        $("#en_collegelogo").prop('src','<?php echo base_url();?>homepage_images/'+json.orgDetails[0].orgLogo);
                        $("#en_collegename").text(json.orgDetails[0].orgName);
                        $("#en_collegeaddress").text(json.orgDetails[0].orgAddress);
                    }
                    $("#enrollModal").show();
                    $("body").css("overflow","hidden");
                },
                error: function (response) {
                    $('#error').html(response);
                }
            });
        }
    }
    $(function () {
        $("#closeenrollModal").click(function(){
            $("#enrollModal").hide();
            $("body").css("overflow","auto");
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
<script>
    $(".more").click(function () {
        var id = $(this).next('.ProdId').html();
        $("#container").append("<div class='box'> " + id + "<a href='#'>x</a></div>");
        var count = $(".box").length;
        $(".to-p").text("There are " + count + " boxes.");
        $("#container").removeClass("hidden");
    });

    $(".box a").live("click", function () {
        $(this).parent().remove();
        var count = $(".box").length;
        $(".to-p").text("There are " + count + " boxes.");
    });
</script>
<!--------------------------footer----------------------->
<script>
    var $rows = $('#table .item');
    $('#search').keyup(function () {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function () {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
</script>
<script>

    $('#mixedSlider').multislider({
        duration: 750,
        interval: 3000
    });
</script>
<script>

    $('#mixedSlider1').multislider({
        duration: 750,
        interval: 3000
    });
</script>
<script>

    $('#mixedSlider11').multislider({
        duration: 750,
        interval: 3000
    });
</script>
<script>

    $('#mixedSlider111').multislider({
        duration: 750,
        interval: 3000
    });
</script>
<script>
    /*global $ */
    $(document).ready(function () {

        "use strict";

        $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');
        //Checks if li has sub (ul) and adds class for toggle icon - just an UI


        $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');
        //Checks if drodown menu's li elements have anothere level (ul), if not the dropdown is shown as regular dropdown, not a mega menu (thanks Luka Kladaric)

        $(".menu > ul").before("<a href=\"#\" class=\"menu-mobile\">Navigation</a>");

        //Adds menu-mobile class (for mobile toggle menu) before the normal menu
        //Mobile menu is hidden if width is more then 959px, but normal menu is displayed
        //Normal menu is hidden if width is below 959px, and jquery adds mobile menu
        //Done this way so it can be used with wordpress without any trouble

        $(".menu > ul > li").hover(function (e) {
            if ($(window).width() > 943) {
                $(this).children("ul").stop(true, false).fadeToggle(150);
                e.preventDefault();
            }
        });
        //If width is more than 943px dropdowns are displayed on hover

        $(".menu > ul > li").click(function (e) {
            if ($(window).width() <= 943) {
                $(this).children("ul").fadeToggle(150);
                e.preventDefault();
            }
        });
        //If width is less or equal to 943px dropdowns are displayed on click (thanks Aman Jain from stackoverflow)

        $(".menu-mobile").click(function (e) {
            $(".menu > ul").toggleClass('show-on-mobile');
            e.preventDefault();
        });
        //when clicked on mobile-menu, normal menu is shown as a list, classic rwd menu story (thanks mwl from stackoverflow)

    });

</script>

    <?php

include_once 'shared/footer.php';

