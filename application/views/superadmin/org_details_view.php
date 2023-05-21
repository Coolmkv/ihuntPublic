<?php include_once 'superadmin_header.php';
if(isset($profileData)){
    $loginId            =   $profileData->loginId;
    $orgName            =   $profileData->orgName;
    $directorName       =   $profileData->directorName;
    $directorEmail      =   $profileData->directorEmail;
    $directorMobile     =   $profileData->directorMobile;
    $orgMobile          =   $profileData->orgMobile;
    $org_landline       =   $profileData->org_landline;
    $orgLogo            =   $profileData->orgLogo;
    $orgImgHeader       =   $profileData->orgImgHeader; 
    $orgAddress         =   $profileData->orgAddress;
    $orgType            =   $profileData->orgType;
    $approvedBy         =   $profileData->approvedBy;
    $orgGoogle          =   $profileData->orgGoogle;
    $orgDesp            =   $profileData->orgDesp;
    $orgMission         =   $profileData->orgMission;
    $orgVission         =   $profileData->orgVission;
    $orgWebsite         =   $profileData->orgWebsite;
    $orgVideo           =   $profileData->orgVideo;
    $orgEstablished     =   $profileData->orgEstablished;
    $orgLatestStatus    =   $profileData->orgLatestStatus;
    $orgFeatureStatus   =   $profileData->orgFeatureStatus;
    $email              =   $profileData->email;
    $country            =   $profileData->country;
    $state              =   $profileData->statename;
    $city               =   $profileData->ctyname;
    $roleName           =   $profileData->roleName;
    $verifyStatus       =   $profileData->verifyStatus;
    $admin_approved     =   $profileData->admin_approved;
    $org_status         =   $profileData->org_status;
    $loginStatus        =   $profileData->loginStatus;
    
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Profile
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Profile</a></li>
                <li class="active"> View Profile</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content"> 
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Profile Images</h3>
                        </div> 
                        <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="no_one">
                                    <div class="col-md-6 text-center">
                                        <div class="form-group">
                                            <label>Logo</label>
                                            <img  style="height:210px;width: 300px" alt="No selected Logo" src="<?php  echo base_url($orgLogo);?>" onerror="this.src='<?php echo base_url('projectimages/default.png');?>'" class="img-responsive img-thumbnail">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Header Image</label>
                                            <img  style="height:210px;width: 300px" alt="No selected Header Image" onerror="this.src='<?php echo base_url('projectimages/default.png');?>'" src="<?php echo base_url($orgImgHeader);?>" class="img-responsive img-thumbnail">                                            
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <!--/.col -->
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Organization Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Name:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo $orgName; ?></label>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Org. Type:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $roleName; ?></label>
                                </div>
                            </div>
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                            <u>Mobile:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo $orgMobile; ?></label>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Landline No:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $org_landline; ?></label>
                                </div>
                            </div>    
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Email:</u>
                                </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo $email; ?></label>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Country:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $country; ?></label>
                                </div>
                            </div>
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>State:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo $state; ?></label>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>City:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo $city; ?></label>
                                </div>
                            </div>        
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Address:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo $orgAddress; ?></label>
                            </div>
                        </div>   
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Org. Type:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo ($orgType==""?'N/A':$orgType); ?></label>
                                </div>
                            </div>  
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Established On:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo ($orgEstablished==""?'N/A':$orgEstablished); ?></label>
                            </div>
                        </div>  
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Approved By:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php  echo ($approvedBy==""?'N/A':$approvedBy); ?></label>
                                </div>
                            </div>   
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Latest Status:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo ($orgLatestStatus == 1 ? 'Latest' : 'Not Latest');  ?></label>
                            </div>
                        </div>    
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Featured Status:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo ($orgFeatureStatus == 1 ? 'Featured' : 'Not Featured');  ?></label>
                                </div>
                            </div> 
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Verify Status:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo ($verifyStatus == 1 ? 'Verified' : 'Not Verified');  ?></label>
                            </div>
                        </div>   
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Admin Approved:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo ($admin_approved == 1 ? 'Approved' : 'Not Approved');  ?></label>
                                </div>
                            </div>
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Org Status:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo ($loginStatus == 1 && $org_status=="" ? 'Disable' : $loginStatus == 0 && $org_status=="" ? 'Active' :$org_status);  ?></label>
                            </div>
                        </div>   
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Director Name:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo ($directorName==""?"N/A":$directorName);   ?></label>
                            </div>
                        </div>           
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Director Mobile:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo ($directorMobile==""?"N/A":$directorMobile);  ?></label>
                                </div>
                            </div>       
                        <div class="col-md-4">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Director Email:</u>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo ($directorEmail==""?"N/A":$directorEmail);  ?></label>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Website Url:</u>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo ($orgWebsite==""?"N/A":'<a href="'.$orgWebsite.'" target="_blank">'.$orgWebsite.'</a>');  ?></label>
                                </div>
                            </div>   
                        <div class="col-md-6">
                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Description:</u>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <label><?php echo ($orgDesp==""?"N/A":$orgDesp);  ?></label>
                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Our Mission:</u>
                                </div>
                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <label><?php echo ($orgMission==""?"N/A":$orgMission);  ?></label>
                                </div>
                            </div>    
                        <div class="col-md-6">
                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Our Vision:</u>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <label><?php echo ($orgVission==""?"N/A":$orgVission);  ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Default Facilities:</u>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <label><?php if(isset($orgFacilities)){ foreach($orgFacilities as $of){echo '<div class="cllege-facili"><i class="fa '.$of->facility_icon.'">&nbsp;'.$of->title.'</i></div>';}}  ?></label>
                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <u>Req. Appr. Facilities:</u>
                                </div>
                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <label><?php if(isset($orgFacilitiesa)){ foreach($orgFacilitiesa as $of){echo '<div class="cllege-facili"><i class="fa '.$of->facility_icon.'">&nbsp;'.$of->title.'</i></div>';}}  ?></label>
                                </div>
                            </div>    
                        <div class="col-md-6">
                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <u>Req. Pending Facilities:</u>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <label><?php if(isset($orgFacilitiesp)){ foreach($orgFacilitiesp as $of){echo '<div class="cllege-facili"><i class="fa '.$of->facility_icon.'">&nbsp;'.$of->title.'</i></div>';}}  ?></label>
                            </div>
                        </div>  
                        <div class="col-md-12 hidden">
                            <br><br><br><br>
                            <a href="<?php echo site_url('superadmin/editprofile');?>"><button style="margin-top:3px;width: 135px" class="form-control btn btn-primary" type="submit" name="header_submit" id="header_submit">Edit Profile</button></a>&nbsp;&nbsp;&nbsp;
                            
                        </div>


                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                </div>
            </div>

        </section>

        <!-- /.content -->

    </div>
<?php include_once 'superadmin_footer.php';?>
<script>
document.title  =   "iHuntBest | Profile View";
</script>