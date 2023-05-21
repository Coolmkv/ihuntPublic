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
<div class="bg-color">
     <div class="container-fluid">
    <div class="col-md-12 hidden">
      <ul class="nav nav-tabs tabtop  tabsetting">
        <li class="active"  id="fac"> <a href="#tab_default_1" data-toggle="tab">More</a> </li>
        <li> <a href="#tab_default_7" data-toggle="tab">About</a> </li>
        <li> <a href="#tab_default_2" data-toggle="tab"> mission , vision,</a> </li>
        <li> <a href="#tab_default_3" data-toggle="tab"> gallery </a> </li>
        <li> <a href="#tab_default_4" data-toggle="tab"> Placement</a> </li>
        <li> <a href="#tab_default_5" data-toggle="tab"> Faculty </a> </li>
        <li> <a href="#tab_default_6" data-toggle="tab" class="thbada"> Achievements </a> </li>
        <li> <a href="#tab_default_8" data-toggle="tab" class="thbada"> REVIEWS </a> </li>
        <li> <a href="#tab_default_9" data-toggle="tab" class="thbada"> News </a> </li>
        <li> <a href="#tab_default_10" data-toggle="tab" class="thbada"> Events </a> </li>
      </ul>
    </div>
        
    <div class="col-md-9">
      <div class="compair001">
        <?php if(isset($orgDetails)){ ?>
        <div id="specs-list" class="compare-specs-list">
          <table cellspacing="0">
            <tbody>
            <?php echo '<tr><th scope="row"></th>';
            foreach ($orgDetails as $od){                
                echo '<td>  <div class="to-college">
                                <h3>Approved By '.(empty($od->approvedBy)?"Not Available":$od->approvedBy).'</h3>
                            </div>
                                <div class="col-image" style="height:260px;">
                                    <img onError="imgErrorNormal(this);" src="'. base_url($od->orgImgHeader).'" style="height:260px;">              
                                    <span class="logo-co"><img src="'. base_url($od->orgLogo).'" alt=""></span>
                                    <div class="web-college"> 
                                        <span class="type-3-to">
                                            <p>
                                            <i class="fa fa-building-o"></i> &nbsp; country  : 
                                        </span><span>'.$od->countryName.'</span></p>
                                    </div>
                                </div>
                        </td>';
            }
            echo '</tr>';
            echo '<tr><th scope="row">Org Name</th>';
            foreach ($orgDetails as $od){                
                echo '<td>'.$od->orgName.'</td>';
            }
            echo '</tr>';
            echo '<tr><th scope="row">Org Location</th>';
            foreach ($orgDetails as $od){                
                echo '<td>'.$od->orgAddress.'</td>';
            }
            echo '</tr>';
            echo '<tr><th scope="row">Courses Details</th>';
             foreach ($orgDetails as $od){   
                echo '<td>';
                $courseName =   "";
                if(isset($orgCourses)){
                    foreach ($orgCourses as $oc){
                     if($od->loginId==$oc->loginId){
                         if($oc->course!==""){
                             $courseName = $courseName.$oc->course."(".($oc->departmentName?$oc->departmentName:$oc->courseType).")".($oc->courseDurationType?"-".$oc->courseDurationType:"")." - Fee <i class='fa fa-rupee'></i>".$oc->courseFee." - Duration ".$oc->courseduration."<br>";
                         }
                       }                        
                   }
                }
                
                   echo ($courseName==""?"No Course Data":rtrim($courseName,","));
                echo '</td>';   
             }            
            echo '</tr>';
            ?>
            </tbody>
          </table>
        </div>
        <?php }?>  
      </div>
    </div>
    <div class="col-md-3">
      <div class="add-5">
<a href="#">
    <img <?php echo 'onError="this.src=\''.base_url('homepage_images/default.png').'\'"';?>  src="images/ad-2.jpg">
</a>
</div>
       
      
        </div>
  </div>
</div>
<script>
    document.title  =   'iHuntBest | Organizations Compare';     
</script>    
<?php  include_once 'shared/footer.php';?>