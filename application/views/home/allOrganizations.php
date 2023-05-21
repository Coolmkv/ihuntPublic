<?php include_once 'shared/header.php'; ?>
<script src="<?php echo base_url('js/jquery.min.js');?>" type="text/javascript"></script> <!--
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>-->

    <script src="<?php echo base_url('js/amazon_scroller.js');?>" type="text/javascript"></script>
<!--    
<script src="<?php echo base_url(); ?>plugins/lightgallery/js/lightgallery-all.min.js" type="text/javascript"></script>  -->
    <!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>plugins/jQuery/jquery.form.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/app.min.js"></script> 
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!--<script src="<?php echo base_url(); ?>plugins/imagesLoaded.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/gallery.js" type="text/javascript"></script> -->
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script>
function imgError(ele){
         ele.onerror = "";
         console.log(ele);
         ele.src =   '<?php echo base_url('homepage_images/default.png');?>';
          
         return true;
          
        
    }
</script>
<div class="bg-color">
    <div class="container-fluid">
        <div class="all-college02">
          <div class="col-sm-2 view-co-left">
            <div class="view-college">
              <div class="all-text">
                  <p><?php 
                  
                if(isset($totalOrgs)){ $totalRecords=$totalOrgs->totalorgs; echo 'FOUND '.$totalRecords.' '.strtoupper($type);}else{'NOT RECORD FOUND';}?></p>
                <div class="filter-college">
                    <div class="state">
                <p>State</p>
                <span><?php if(isset($StateWiseData)){ echo count($StateWiseData);}else{ echo "0";}?></span>
                </div>
                    <div class="fillter-all" id="searchable-container">
                    <ul class="listing_filter scrollbar" id="style-3">
                      <?php if(isset($StateWiseData)){
                            foreach ($StateWiseData as $sd){
                                echo    '<li class="checkbox  ">                          
                                            <label>  <input type="checkbox" loginids="'.$sd->lids.'" class="filterChkBox" onclick="filterOrgs();" typesel="stateId" value="'.$sd->stateId.'">  <span></span> '.$sd->statename.' - ['.$sd->totalorgs.']</label>
                                        </li>';
                            }
                      }else{
                          echo '<li class="checkbox  ">
                                    <label>  <input type="checkbox" disabled="true">  <span></span>  No Data</label>
                                </li>';
                      }?>  
                    </ul>
                  </div>
                </div> 
                <div class="filter-college">
                    <div class="state">
                    <p>CITY</p>
                    <span><?php if(isset($CityWiseData)){ echo count($CityWiseData);}else{ echo "0";}?></span>
                    </div>
                    <div class="fillter-all" id="searchable-container">
                    <ul class="listing_filter scrollbar" id="style-3">
                       <?php if(isset($CityWiseData)){
                            foreach ($CityWiseData as $cd){
                                echo    '<li class="checkbox  ">                          
                                            <label>  <input  type="checkbox" loginids="'.$cd->lids.'" class="filterChkBox" onclick="filterOrgs();"  typesel="cityId" value="'.$cd->cityId.'">  <span></span> '.$cd->cityname.' - ['.$cd->totalorgs.']</label>
                                        </li>';
                            }
                      }else{
                          echo '<li class="checkbox  ">
                                    <label>  <input type="checkbox" disabled="true">  <span></span>  No Data</label>
                                </li>';
                      }?>
                    </ul>
                  </div>
                </div>
                <div class="filter-college">
                    <div class="state">
                    <p>COURSE TYPE</p>
                    <span><?php if(isset($courseWise)){ echo count($courseWise);}else{ echo "0";}?></span>
                    </div>
                    <div class="fillter-all" id="searchable-container">
                      <ul class="listing_filter scrollbar" id="style-3">
                          <?php if(isset($courseWise)){
                              foreach ($courseWise as $cd){
                                  if($type==="School"){
                                      $classes =   'classes="'.$cd->classes.'"';
                                  }else{$classes="";}
                                  echo    '<li class="checkbox  ">                          
                                              <label>  <input type="checkbox" class="filterChkBox courses" '.$classes.' onclick="filterOrgs();" loginids="'.$cd->lids.'" id="'. str_replace(" ", "_", $cd->courseType).'"  typesel="ctId" value="'.$cd->ctId.'">  <span></span> '.$cd->courseType.' - ['.$cd->totalorgs.']</label>
                                          </li>';
                                  }
                            }else{
                                echo '<li class="checkbox  ">
                                          <label>  <input type="checkbox" disabled="true">  <span></span>  No Data</label>
                                      </li>';
                            }?>
                      </ul>
                    </div>
                </div>
                <div class="filter-college">
                    <div class="state">
                    <p>TYPE OF <?php echo strtoupper($type);?></p>
                    <span><?php if(isset($orgTypeWise)){ echo count($orgTypeWise);}else{ echo "0";}?></span>
                    </div>
                    <div class="fillter-all" id="searchable-container">
                      <ul class="listing_filter scrollbar" id="style-3" style="height: auto;">
                           <?php if(isset($orgTypeWise)){
                              foreach ($orgTypeWise as $cd){

                                  echo    '<li class="checkbox  ">                          
                                              <label>  <input type="checkbox" class="filterChkBox" onclick="filterOrgs();" loginids="'.$cd->lids.'"  typesel="orgType" value="'.$cd->orgType.'">  <span></span> '.(empty($cd->orgType)?"Not Set":$cd->orgType).' - ['.$cd->totalorgs.']</label>
                                          </li>';
                                  }
                            }else{
                                echo '<li class="checkbox  ">
                                          <label>  <input type="checkbox" disabled="true">  <span></span>  No Data</label>
                                      </li>';
                            }?>
                      </ul>
                    </div>
                </div>
                <div class="filter-college">
                    <div class="state">
                    <p>STATUS OF <?php echo strtoupper($type);?></p>
                    <span><?php if(isset($orgStatusWise)){     echo "3";}else{ echo "0";}?></span>
                    </div>
                    <div class="fillter-all" id="searchable-container">
                      <ul class="listing_filter scrollbar" id="style-3" style="height: auto;">
                           <?php if(isset($orgStatusWise)){ 
                               $topasarr    = explode(",", $orgStatusWise->topratedorgs);
                            echo    '<li class="checkbox  ">                          
                                              <label>  <input type="checkbox" class="filterChkBox" onclick="filterOrgs();" id="toprated" loginids="'.$orgStatusWise->topratedorgs.'"  typesel="toprated" value="toprated">  <span></span> Top Rated '.ucfirst($type).' - ['.count($topasarr).']</label>
                                          </li>';
                            $latestasarr    = explode(",", $orgStatusWise->latestorgs);
                            echo    '<li class="checkbox  ">                          
                                              <label>  <input type="checkbox" class="filterChkBox" onclick="filterOrgs();" id="latest" loginids="'.$orgStatusWise->latestorgs.'"  typesel="latest" value="latest">  <span></span> Latest '.ucfirst($type).' - ['.count($latestasarr).']</label>
                                          </li>';
                            $featuredasarr    = explode(",", $orgStatusWise->featuredorgs);
                            echo    '<li class="checkbox  ">                          
                                              <label>  <input type="checkbox" class="filterChkBox" onclick="filterOrgs();" id="featured" loginids="'.$orgStatusWise->featuredorgs.'"  typesel="featured" value="featured">  <span></span> Featured '. ucfirst($type).' - ['.count($featuredasarr).']</label>
                                          </li>';
                            }else{
                                echo '<li class="checkbox  ">
                                          <label>  <input type="checkbox" disabled="true">  <span></span>  No Data</label>
                                      </li>';
                            }?>
                      </ul>
                    </div>
                </div>
              </div>
            </div>
          </div>
            <div class="col-sm-8 all-college-to">
                <?php echo form_open("home/comapreOrganizations");?>
                <div id="container" class="hidden">
                    
                    <p class="to-p">There are 0 boxes</p>  
                    <input type="hidden" class="hidden" value="<?php echo $type; ?>" name="type"> 
                </div>
                <?php echo form_close();?>
                <div id="orgContentDiv" class="col-md-12 nopadding">
              <?php if(isset($orgDetails)){//onError="this.src=\''.base_url('homepage_images/default.png').'\'"
                  foreach($orgDetails as $od){
                      $orgName  =   preg_replace("/\s+/","-", $od->orgName);
                      echo '<div class="col-md-4 col-sm-12 contentdiv">
                          <div class="all-img">
                              <div class="imgTitle-to">
                                  <span class="logo-co"><img class="img-responsive" onerror="imgError(this);" src="'. base_url($od->orgLogo).'" alt="Logo"  > </span>
                                      <h5 class="blogTitle ellipsistext" title="'.$od->orgAddress.'"><i class="fa fa-map-marker" aria-hidden="true"></i> '.$od->orgAddress.'</h5>
                                          <span class="po-check"> 
                                              <a href="javascript:" class="more" onclick="compare(this);" orgname="'.$od->orgName.'"  loginid="'.$od->loginId.'"> + Add to compare</a>
                                                  <span class="ProdId">123</span>
                                          </span>
                                              <img class="fixedimgheight" onerror="imgError(this);" src="'. base_url($od->orgImgHeader).'" callby="header'.$od->loginId.'" alt="Image" /> </div>
                                              <p class="orgnamediv">'.$od->orgName.'</p>
                                      <span class="review-to"></span> 
                                  
                                  <a target="_blank" href="'.site_url('OrganizationDetails/'.$od->loginId.'_'.$orgName).'" class="to-3">View Details</a> 
                              </div>
                        </div>';
//                      <a href="#" class="to">About '.$od->roleName.'</a> 
                  }

              }else{
                  echo '<h3>Sorry no data ! :(</h3>';
              }?> 
                </div>
                <div class="col-md-12"><div class="load"><a href="javascript:" id="loadMore" >Load More</a></div></div>
          </div>

          <div class="col-sm-2 view-co-left">
          <div class="add-5">
      <a href="#">
      <img src="images/ad-2.jpg">
      </a>
      </div>
      <div class="add-5">
      <a href="#">

      <img src="images/232Career_banner.jpg">
      </a>
      </div>
          </div>
          <div class="clearfix"></div>
          </div>
    </div>
</div>
<script>
    document.title  =   'iHuntBest | All Organization Details';
   function filterStatus(type){    
       type =   type.replace(/\s+/g, '_');
                if(type!==""){
                    $("#"+type).prop('checked',true);
                    filterOrgs();
                    return true;
                }                 
            }
    function filterClass(type){    
       type =   type.replace(/\s+/g, '_');
       
       if(type==="11th" || type==="12th"){
          $(".courses").each(function(){
              var allClasses    =   $(this).attr("classes");
                if(allClasses!==""){
                    var classes =   allClasses.split(",");
                    for(var i=0;i<classes.length;i++){
                        if(classes[i]===type){
                            $(this).prop("checked",true);
                            break;
                        }
                    }
                }                
            }); 
            filterOrgs();
            return true;
       }
                if(type!==""){
                    $("#"+type).prop('checked',true);
                    filterOrgs();
                    return true;
                }                 
            }        
    function filterhearderSearch(loginid){
    var checkedData  =   [];
    var sloginid    =    loginid.split(",");
    for(var i=0;i<sloginid.length;i++){
                        checkedData.push(sloginid[i]);
                    }
            $("#loadMore").html("Load More");
            $("#orgContentDiv").html("");
           loadmoreFilter(checkedData);
    } 
    function filterOrgs(){            
            var checkedData  =   [];
            $(".filterChkBox").each(function(){
                if($(this).prop("checked")===true){
                    var loginids    =    $(this).attr("loginids");
                    var sloginid    =    loginids.split(",");
                    for(var i=0;i<sloginid.length;i++){
                        checkedData.push(sloginid[i]);
                    }  
                }                
            });
            $("#loadMore").html("Load More");
            $("#orgContentDiv").html("");
           loadmoreFilter(checkedData);
            console.log(checkedData);
        }    
    $(document).ready(function(){
         <?php if($this->input->get("CourseType")){
                echo 'filterStatus(\''.$this->input->get("CourseType").'\');';
            }
            if($this->input->get("Status")){
                echo 'filterStatus(\''.$this->input->get("Status").'\');';
            } 
            if($this->input->get("ClassType")){
                echo 'filterClass(\''.$this->input->get("ClassType").'\');';
            }
            if($this->input->get("id")){
                echo 'filterhearderSearch(\''.$this->input->get("id").'\');';
            }?>
            
        
        
        
    });
    function loadmoreFilter(checkedData){
        var total   =   0;
        $(".contentdiv").each(function(){
            total++;
        });
        $.ajax({
                type: "POST",
                data: {checkedData:checkedData,totalRecods:"<?php echo $totalRecords;?>",type:'<?php echo $type; ?>',start:total},
                url: "<?php echo site_url("home/loadMoreOrg");?>",
                success: function (response) { 
                    if($.trim(response)!==""){
                        $("#orgContentDiv").append(response);
                    }else{
                        
                        $("#loadMore").html('All Loaded');
                    }
                }
           });  
    }
    $("#loadMore").click(function(){
        if($(this).html()==='All Loaded'){
            alert("All Records Loaded");
            return false;
        }else{
            var checkedData  =   [];
        $(".filterChkBox").each(function(){
                if($(this).prop("checked")===true){
                    checkedData.push($(this).attr("loginids"));
                    console.log(checkedData);
                }                
            });
            
           loadmoreFilter(checkedData);
        }        
    });
    
$(document).on('click','.remove',function(){
    var loginid     =   $(this).attr("loginid");
    $("#container"+loginid).remove();
     var count = 0;
    count   =   $(".box").length; 
    $(".to-p").text("There are " + count + " boxes.");
    if(count===0){
        $("#container").addClass("hidden");
    }
});
function compare(event) {        
        var loginid     =   $(event).attr("loginid");
        var orgname     =   $(event).attr("orgname");
        if(loginid===$("#hidden"+loginid).val()){
            alert("It is already in the list.");
            return false;
        }console.log(loginid);
        var count = 0;
        count   =   $(".box").length;
	 if(count<'2'){
                $("#container").append("<div class='box' id='container"+loginid+"' > "+orgname + "<a href='javascript:' class='remove' loginid='"+loginid+"'><i class='fa fa-times'></i></a><input type='hidden' class='hidden' id='hidden"+loginid+"' name='checkedData[]' value='"+loginid+"'></div>");
           var counter = count+1; }
	else{
            alert("Please select only two college");
            return false;
	}
        if(counter===2){ 
             $('#container').append('<input type="submit" class="comparebtn btn" value="Compare">');
        }            
    $(".to-p").text("There are " + counter + " boxes.");
    $("#container").removeClass("hidden");
}
</script>    
<?php  include_once 'shared/footer.php'; 