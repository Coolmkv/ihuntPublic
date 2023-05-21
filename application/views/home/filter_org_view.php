<div class="col-md-12 latest-to">
                        <div class="latest">
                        <h2>Top Rated <?php echo $type; ?></h2>
                        <a href="<?php echo site_url('allOrganizationDetails?Type='.$type);?>">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="box-sadow">
                        <div id="mixedSlider">
                            <div id="table" class="MS-content">
                                    <?php if(isset($TopRatedOrgDetails)){

                                    foreach($TopRatedOrgDetails as $od){ 
                                         if($od->availabesheets=="")
                                                {
                                                    $availabesheets =   0;
                                                }else
                                                {
                                                    $availabesheets =   $od->availabesheets;
                                                }
                                    $orgName  =   preg_replace("/\s+/","-", $od->orgName);
                                     $loginId = base64_encode($od->loginId);
                                        echo '<div class="item itemwidth">
                                        <div class="imgTitle">
                                          <span class="logo-co"><img src="'.base_url($od->orgLogo).'" alt="" /></span>
                                            <h5 class="blogTitle width48 ellipsistext" title="'.$od->orgAddress.'"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$od->orgAddress.'</h5>
                                             <span class="po-check">
                                              <a href="javascript:" class="more" onclick="compare(this);" orgname="'.$od->orgName.'"  loginid="'.$od->loginId.'"> + Add to compare</a>
                                                                 
                                               </span>
                                            <span class="name-to">Available Seats <b>'.$availabesheets.'</b></span>
                                            <img src="'.base_url($od->orgImgHeader).'" alt="" />
                                        </div>
                                        <p><strong>'.$od->orgName.'</strong></p>
                                        <span class="name"><p>Eligibility/ Cutoff: optional , depends on college to do the validation</p></span>
                                                <span class="name"><p><strong>Email </strong>: '.$od->email.' </p></span>
                                                <span class="name"><p><strong>Phone</strong> : '.$od->orgMobile.'</p></span>
                                                <span class="name"><p><strong>Website</strong> : '.$od->orgWebsite.' </p></span>

                                        <div class=" clearfix"></div>
                                       <div class="col-lg-12 nopadding">
                                                    <div class="col-lg-12 text-right nopadding">
                                                        <a href="'.site_url('OrganizationDetails/'.$od->loginId.'_'.$orgName).'" class="to">View Details</a>
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
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                        <h2>Latest <?php echo $type; ?></h2>
                        <a href="<?php echo site_url('allOrganizationDetails?Type='.$type);?>">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="box-sadow">
                        <div id="mixedSlider11">
                            <div id="table" class="MS-content">
                                    <?php if(isset($LatestOrgDetails)){

                                    foreach($LatestOrgDetails as $od){ 
                                         if($od->availabesheets=="")
                                                {
                                                    $availabesheets =   0;
                                                }else
                                                {
                                                    $availabesheets =   $od->availabesheets;
                                                }
                                    $orgName  =   preg_replace("/\s+/","-", $od->orgName);
                                     $loginId = base64_encode($od->loginId);
                                        echo '<div class="item itemwidth">
                                        <div class="imgTitle">
                                          <span class="logo-co"><img src="'.base_url($od->orgLogo).'" alt="" /></span>
                                            <h5 class="blogTitle width48 ellipsistext" title="'.$od->orgAddress.'"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$od->orgAddress.'</h5>
                                             <span class="po-check">
                                              <a href="javascript:" class="more" onclick="compare(this);" orgname="'.$od->orgName.'"  loginid="'.$od->loginId.'"> + Add to compare</a>
                                                                 
                                               </span>
                                            <span class="name-to">Available Seats <b>'.$availabesheets.'</b></span>
                                            <img src="'.base_url($od->orgImgHeader).'" alt="" />
                                        </div>
                                        <p><strong>'.$od->orgName.'</strong></p>
                                        <span class="name"><p>Eligibility/ Cutoff: optional , depends on college to do the validation</p></span>
                                                <span class="name"><p><strong>Email </strong>: '.$od->email.' </p></span>
                                                <span class="name"><p><strong>Phone</strong> : '.$od->orgMobile.'</p></span>
                                                <span class="name"><p><strong>Website</strong> : '.$od->orgWebsite.' </p></span>

                                        <div class=" clearfix"></div>
                                       <div class="col-lg-12 nopadding">
                                                    <div class="col-lg-12 text-right nopadding">
                                                        <a href="'.site_url('OrganizationDetails/'.$od->loginId.'_'.$orgName).'" class="to">View Details</a>
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
                    <div class="col-md-12 latest-to">
                        <div class="latest">
                        <h2>Featured Organizations</h2>
                        <a href="<?php echo site_url('allOrganizationDetails?Type='.$type);?>">VIEW ALL</a>
                        </div>
                    </div>
                    <div class="box-sadow">                        
                        <div class="col-md-12 to-slide">
                            <div id="mixedSlider111">
                                            <div id="table" class="MS-content">
                                                 <?php if(isset($FeatureOrgDetails)){

                                                foreach($FeatureOrgDetails as $od){
                                                    //echo $od->availabesheets;
                                                     if($od->availabesheets=="")
                                                            {
                                                                $availabesheets =   0;
                                                            }else
                                                            {
                                                                $availabesheets =   $od->availabesheets;
                                                            }
                                                $orgName  =   preg_replace("/\s+/","-", $od->orgName);
                                                  echo '<div class="item itemwidth" >
                                                    <div class="imgTitle">
                                                      <span class="logo-co"><img src="'.base_url($od->orgLogo).'" alt="" /></span>
                                                        <h5 class="blogTitle width48 ellipsistext" title="'.$od->orgAddress.'"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$od->orgAddress.'</h5>
                                                         <span class="po-check">
                                                          <a href="javascript:" class="more" onclick="compare(this);" orgname="'.$od->orgName.'"  loginid="'.$od->loginId.'"> + Add to compare</a>
                                                            	                     
                                                           </span>
                                                        <span class="name-to">Available Seats <b>'.$availabesheets.'</b></span>
                                                        <img src="'.base_url($od->orgImgHeader).'" alt="" />
                                                    </div>
                                                    <p><strong>'.$od->orgName.'</strong></p>
                                                    <span class="name"><p>Eligibility/ Cutoff: optional , depends on college to do the validation</p></span>
                                                            <span class="name"><p><strong>Email </strong>: '.$od->email.' </p></span>
                                                            <span class="name"><p><strong>Phone</strong> : '.$od->orgMobile.'</p></span>
                                                            <span class="name"><p><strong>Website</strong> : '.$od->orgWebsite.' </p></span>

                                                    <div class=" clearfix"></div>
                                                   <div class="col-lg-12 nopadding">
                                                                <div class="col-lg-12 text-right nopadding">
                                                                    <a href="'.site_url('OrganizationDetails/'.$od->loginId.'_'.$orgName).'" class="to">View Details</a>
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
                    </div>
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