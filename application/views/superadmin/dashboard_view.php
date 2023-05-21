<?php include_once 'superadmin_header.php';
if(isset($totals))
{
    $total_colleges     =   $totals->totalcolleges;
    $total_university   =   $totals->totaluniversities;
    $total_institutes   =   $totals->totalInstitutes;
    $total_school       =   $totals->totalSchools;
    $total_students     =   $totals->totalstudents;
    $pending_facility   =   $totals->pendingfacilities;
    $approve_facility   =   $totals->approvedfacilities;
    $totalcourseTypes   =   $totals->totalcourseTypes;
    $totalinstitute     =   $totals->totalinstitute;
    $totaltimedrtn      =   $totals->totaltimedrtn;
    $totalsctype        =   $totals->totalsctype;
    $totalminqual       =   $totals->totalminqual;
    $totalfacilies      =   $totals->totalfacilies;
    $totalreqfacilies   =   $totals->totalreqfacilies;
    $totalaprfacilies   =   $totals->totalaprfacilies;
    $totalrejfacilies   =   $totals->totalrejfacilies;
    $totalshowdetails   =   $totals->totalshowdetails;
    $totalCountries     =   $totals->totalCountries;
    $totalstates        =   $totals->totalstates;
    $totalcities        =   $totals->totalcities;
    $totalregistration  =   $totals->totalregistration; 
    $advertisement_plan =   $totals->advertisement_plan;
    $competitiveExam    =   $totals->competitiveExam;
    $teamMembers        =   $totals->teamMembers;
    $Careers            =   $totals->Careers;
    $jobApplications    =   $totals->jobApplications;
    $ensvalue           =   $totals->ensvalue;
    $ensUservalue       =   $totals->ensUservalue;
    $totalVisitor       =   $totals->totalVisitor;
    $webVisitor         =   $totals->webVisitor;
    $nlPlan             =   $totals->nlPlan;
    $nlPlanBuy          =   $totals->nlPlanBuy;
    $FaqTotal           =   $totals->FaqTotal;
    $FAQCategory        =   $totals->FAQCategory;
}else
{
    $total_colleges     =   "";
    $total_university   =   "";
    $total_institutes   =   "";
    $total_school       =   "";
    $total_students     =   "";
    $pending_facility   =   "";
    $approve_facility   =   "";
    $totalcourseTypes   =   "";
    $totalinstitute     =   "";
    $totaltimedrtn      =   "";
    $totalsctype        =   "";
    $totalminqual       =   "";
    $totalfacilies      =   "";
    $totalreqfacilies   =   "";
    $totalaprfacilies   =   "";
    $totalshowdetails   =   "";
    $totalCountries     =   "";
    $advertisement_plan =   "";
    $competitiveExam    =   "";
    $ensvalue           =   '';
    $ensUservalue       =   "";
    $totalVisitor       =   "";
}
?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <!--<small>Optional description </small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                        <li class="active">Here</li>
                    </ol>
                </section>                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-blue-gradient">
                                <div class="inner">
                                    <h3>&nbsp;</h3>
                                    <p>Profile</p>
                                </div>
                                <div class="icon"><i class="fa fa-user-secret"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/profile');?>">View Profile
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green-gradient">
                                <div class="inner">
                                    <h3>&nbsp;</h3>
                                    <p>Profile</p>
                                </div>
                                <div class="icon"><i class="fa fa-pencil"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/editprofile');?>">Edit Profile
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green-active">
                                <div class="inner">
                                    <h3>&nbsp;</h3>
                                    <p>Profile</p>
                                </div>
                                <div class="icon"><i class="fa fa-rupee"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/financialDetails');?>">Financial Details
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-teal-gradient">
                                <div class="inner">
                                    <h3><?php echo $totalcourseTypes;?></h3>
                                    <p>Masters</p>
                                </div>
                                <div class="icon"><i class="fa fa-university"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/univCoursesMaster');?>">University Courses
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><?php echo $totalinstitute;?></h3>
                                    <p>Masters</p>
                                </div>
                                <div class="icon"><i class="fa fa-code-fork"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/InstCoursesMaster');?>">Institute Courses
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green-active">
                                <div class="inner">
                                    <h3><?php echo $totaltimedrtn;?></h3>
                                    <p>Masters</p>
                                </div>
                                <div class="icon"><i class="fa fa-clock-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/TimedurationMaster');?>">Time Duration
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-orange-active">
                                <div class="inner">
                                    <h3><?php echo $totalsctype;?></h3>
                                    <p>Masters</p>
                                </div>
                                <div class="icon"><i class="fa fa-shield"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/schoolClassTypeMaster');?>">School Class Type
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-light-blue-active">
                                <div class="inner">
                                    <h3><?php echo $totalminqual;?></h3>
                                    <p>Masters</p>
                                </div>
                                <div class="icon"><i class="fa fa-compress"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/minQualificationMaster');?>">Minimum Qualification
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-yellow-gradient">
                                <div class="inner">
                                    <h3><?php echo $competitiveExam;?></h3>
                                    <p>Masters</p>
                                </div>
                                <div class="icon"><i class="fa fa-book"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/competitiveMaster');?>">Competitive Exams
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-blue-gradient">
                                <div class="inner">
                                    <h3><?php echo $total_university; ?></h3>
                                    <p>Organization Details</p>
                                </div>
                                <div class="icon"><i class="fa  fa-university "></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/showUniversity');?>">University Details
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-maroon-active">
                                <div class="inner">
                                    <h3><?php echo $total_colleges; ?></h3>
                                    <p>Organization Details</p>
                                </div>
                                <div class="icon"><i class="fa  fa-graduation-cap"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/showCollege');?>">Colleges Details
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>                        
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-aqua-gradient">
                                <div class="inner">
                                    <h3><?php echo $total_institutes; ?></h3>
                                    <p>Organization Details</p>
                                </div>
                                <div class="icon"><i class="fa  fa-code-fork"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/showInstitute');?>">Institute Details
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3><?php echo $total_school; ?></h3>
                                    <p>Organization Details</p>
                                </div>
                                <div class="icon"><i class="fa  fa-shield"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/showSchool');?>">School Details
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green-gradient">
                                <div class="inner">
                                    <h3><?php echo $totalfacilies; ?></h3>
                                    <p>Facilities</p>
                                </div>
                                <div class="icon"><i class="fa fa-plus"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/addFacility');?>">Add | Show Facilities
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-lime">
                                <div class="inner">
                                    <h3><?php echo $totalreqfacilies; ?></h3>
                                    <p>Facilities</p>
                                </div>
                                <div class="icon"><i class="fa fa-pencil-square-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/showRequestFacility');?>">Requested Facilities
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green-active">
                                <div class="inner">
                                    <h3><?php echo $totalaprfacilies; ?></h3>
                                    <p>Facilities</p>
                                </div>
                                <div class="icon"><i class="fa fa-check-square-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/showApprovedFacility');?>">Approved Facilities
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><?php echo $totalrejfacilies; ?></h3>
                                    <p>Facilities</p>
                                </div>
                                <div class="icon"><i class="fa fa-times-circle-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/showRejectedFacility');?>">Rejected Facilities
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-light-blue-active">
                                <div class="inner">
                                    <h3><?php echo $totalshowdetails; ?></h3>
                                    <p>Student Details</p>
                                </div>
                                <div class="icon"><i class="fa fa-deviantart"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/showStudentDetails');?>">Show Student Details
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3><small class="text-gray"><?php echo $totalCountries.','.$totalstates,','.$totalcities; ?></small> </h3>
                                    <p>Country, State & City</p>
                                </div>
                                <div class="icon"><i class="fa fa-cc"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/addShowCountry');?>">Add | Show Country
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>      
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-teal-gradient">
                                <div class="inner">
                                    <h3><?php echo $totalregistration; ?></h3>
                                    <p>Register</p>
                                </div>
                                <div class="icon"><i class="fa fa-plus-square"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/orgRegister');?>">Organization Registration
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>      
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-light-blue-active">
                                <div class="inner">
                                    <h3><?php echo $totalshowdetails; ?></h3>
                                    <p>Register</p>
                                </div>
                                <div class="icon"><i class="fa fa-user"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/studentRegister');?>">Student Registration
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>     
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-light-blue-active">
                                <div class="inner">
                                    <h3>&nbsp;</h3>
                                    <p>Register</p>
                                </div>
                                <div class="icon"><i class="fa fa-file-excel-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/orgFileupload');?>">Upload Files of Organization
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>     
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-olive-active">
                                <div class="inner">
                                    <h3>&nbsp;</h3>
                                    <p>Registration of Organization</p>
                                </div>
                                <div class="icon"><i class="fa fa-openid"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/registeredOrganisation');?>">Organization Register Page Content 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>     
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-yellow-gradient">
                                <div class="inner">
                                    <h3><?php echo $advertisement_plan;?></h3>
                                    <p>Advertisement Plan</p>
                                </div>
                                <div class="icon"><i class="fa fa-paper-plane-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/advertisementplan');?>">Add | Edit Advertisement Plan 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green-gradient">
                                <div class="inner">
                                    <h3><?php echo $teamMembers;?></h3>
                                    <p>Our Team</p>
                                </div>
                                <div class="icon"><i class="fa fa-id-card-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/addTeam');?>">Add | Remove Team Members 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-blue-gradient">
                                <div class="inner">
                                    <h3><?php echo $Careers;?></h3>
                                    <p>Careers</p>
                                </div>
                                <div class="icon"><i class="fa fa-briefcase"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/careers');?>">Add | Remove Careers Details 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-teal-gradient">
                                <div class="inner">
                                    <h3><?php echo $jobApplications;?></h3>
                                    <p>Careers</p>
                                </div>
                                <div class="icon"><i class="fa fa-file-pdf-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/jobApplications');?>">Job Applications 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green-gradient">
                                <div class="inner">
                                    <h3><?php echo $ensvalue;?></h3>
                                    <p>Earn and Share</p>
                                </div>
                                <div class="icon"><i class="fa fa-dollar"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/earnandshare');?>">Add Earn and Share 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-green-gradient">
                                <div class="inner">
                                    <h3><?php echo $ensUservalue;?></h3>
                                    <p>Earn and Share</p>
                                </div>
                                <div class="icon"><i class="fa fa-dollar"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/earnandsharevalue');?>">Earn and Share Value 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-light-blue-gradient">
                                <div class="inner">
                                    <h3><?php echo $totalVisitor; ?></h3>
                                    <p>Visitor</p>
                                </div>
                                <div class="icon"><i class="fa fa-users"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/totalvisitor');?>">Total Visitor Details 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-light-blue-gradient">
                                <div class="inner">
                                    <h3><?php echo $webVisitor; ?></h3>
                                    <p>Visitor</p>
                                </div>
                                <div class="icon"><i class="fa fa-globe"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/webvisitor');?>">Website Visitor Details 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-blue-gradient">
                                <div class="inner">
                                    <h3><?php echo $nlPlan;?></h3>
                                    <p>News Letter Plan</p>
                                </div>
                                <div class="icon"><i class="fa fa-envelope-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/newsletterplan');?>">Add|Show News Letter Plan 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-blue-gradient">
                                <div class="inner">
                                    <h3><?php echo $nlPlanBuy;?></h3>
                                    <p>News Letter Plan Buy</p>
                                </div>
                                <div class="icon"><i class="fa fa-dollar"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/newsletterplanbuy');?>">Add|Show News Letter Plan Buy 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-aqua-gradient">
                                <div class="inner">
                                    <h3><?php echo $FAQCategory;?></h3>
                                    <p>FAQ</p>
                                </div>
                                <div class="icon"><i class="fa fa-question-circle-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/faqCategories');?>">Add|Show FAQ Categories 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="small-box bg-aqua-gradient">
                                <div class="inner">
                                    <h3><?php echo $FaqTotal;?></h3>
                                    <p>FAQ</p>
                                </div>
                                <div class="icon"><i class="fa fa-question-circle-o"></i></div>
                                <a class="small-box-footer" href="<?php echo site_url('superadmin/faqQuestionAnswers');?>">Add|Show FAQ Question Answers
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        
                    </div>

 

                </section>
                <!-- /.content -->
            </div>
            <?php include 'superadmin_footer.php' ?>
            <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
            
            <script type="text/javascript">
                $(".dashboard_item").addClass("active");
            </script>
        
        
