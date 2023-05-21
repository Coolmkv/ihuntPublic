 
              <?php if(isset($orgDetails)){
                  foreach($orgDetails as $od){
                      $orgName  =   preg_replace("/\s+/","-", $od->orgName);
                      echo '<div class="col-md-4 col-sm-12 contentdiv">
                          <div class="all-img">
                              <div class="imgTitle-to">
                                  <span class="logo-co"><img class="img-responsive" onerror="this.src=\''.base_url('homepage_images/default.png').'\'" src="'. base_url($od->orgLogo).'" alt=""  /> </span>
                                      <h5 class="blogTitle ellipsistext" title="'.$od->orgAddress.'"><i class="fa fa-map-marker" aria-hidden="true"></i> '.$od->orgAddress.'</h5>
                                          <span class="po-check"> 
                                              <a href="javascript:" onclick="compare(this);" class="more" orgname="'.$od->orgName.'"  loginid="'.$od->loginId.'"> + Add to compare</a>
                                                  <span class="ProdId">123</span>
                                          </span>
                                              <img class="fixedimgheight" onError="imgError(this);" src="'. base_url($od->orgImgHeader).'" callby="header'.$od->loginId.'" alt="" /> </div>
                                              <p class="orgnamediv">'.$od->orgName.'</p>
                                      <span class="review-to"></span> 
                                  
                                  <a target="_blank" href="'.site_url('OrganizationDetails/'.$od->loginId.'_'.$orgName).'" class="to-3">View Details</a> 
                              </div>
                        </div>';
                  }

              }else{
                  echo '';
              }
//              <a href="#" class="to">About '.$od->roleName.'</a> 
                 