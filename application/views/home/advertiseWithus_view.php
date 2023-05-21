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
    <div class="container">
        <div class="col-md-12">
            <div class="heading">
                <h2>Advertise With Us</h2>
                <span class="bott-img"><img src="<?php echo base_url('images/head.png');?>"></span>
            </div>
        </div>
    </div>
    <div class="container  mar-top">
        <div class="col-md-12">
            <div class="addver">
                <p>We are the India’s most innovative and interactive education portal with an ergonomically designed 
                    interface which ensures the maximum conversion. iHuntBest.in caters the need of students, parents and 
                    educators seeking information on higher education. The website provides options of side bar banners, footer
                    banners, text links and mailers services on our opt-in mailer database.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="head-add">
                <h4>Educational Institutes</h4>
                <ol>
                <li>Creation of a separate for the institute</li>
                <li>Responsive presentation of image and other creative</li>
                <li>Guaranteed rise in user interaction and click through rate</li>
                <li>Option to migrate traffic through referral link</li>
                <li>Add your own API to get instant notification of candidate seeking information</li>
                </ol>
            </div>
        </div>
        <div class="col-md-6">
            <div class="head-add">
                <h4>Advertisers</h4>
            <ol>
                <li>Ample space for third party banners</li>
                <li>Algorithm to adjust the placement of banners only on relevant pages</li>
                <li>Ad Rotation Policy to ensure the sustainable advert reach and frequency of visitors seeing the ad</li>
            </ol>
            </div>
        </div>
        <?php echo form_open('home/advertisementForm',["id"=>"form_details"]);?>
        <div class="form-add">
            <div class="col-md-6">
                <div class="addver-form">
                    <input type="hidden" name="orgId" value="" id="orgId">
                    <div class="form-group col-md-12 nopadding" id="advorgNamediv">                        
                        <label>College/University Name</label>
                        <input type="text" name="orgName" id="advorgName" value="" >
                         
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstname" value="" data-validation ="required">
                    </div>
                    <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" name="lastName" value="" data-validation ="required">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="addver-form">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="Email" name="email" value="" data-validation ="required">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phoneNo" maxlength="12" value="" >
                    </div>  
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" name="mobile" maxlength="10" value="" data-validation ="required">
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0px 5px;">
                <div class="addver-form">
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea style="border-radius: 5px;resize: none;" name="comment" data-validation ="required"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" id="comment-submit" class="submit-input grad-btn ln-tr" value="Send">
                    </div>  
                </div>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
</div>
<script>
    function addActiveAdv(focussed) {       
            var searchTh     =   $(".searchterms").height();
            var divheight    =   $("#searchboxautocomplete-list").height();
            var scrollh      =   $("#searchboxautocomplete-list").prop('scrollHeight');

            if(divheight<(focussed+2)*(searchTh+21)<scrollh){
                $("#searchboxautocomplete-list").scrollTop((focussed+1)*(searchTh+21)-divheight);           
            }else{
                $("#searchboxautocomplete-list").scrollTop(0);   
            }
            $(".searchterms").removeClass("autocomplete-active");
            $("#searchterm"+focussed).addClass("autocomplete-active"); 
          }
    function addActiveAdvM(focussed){
        currentFocusAdv=focussed;
        $(".searchterms").removeClass("autocomplete-active");
        $("#searchterm"+focussed).addClass("autocomplete-active"); 
    }
          var currentFocusAdv=-1;
    function selElementHAdv(focussed){
    $("#advorgName").val($("#searchterm"+focussed).text()); 
    $("#orgId").val($("#searchterm"+focussed).attr('loginids'));  
    $("#searchboxautocomplete-list").remove();
    }
$(document).ready(function(){
    $.validate({
                lang: 'en'
            });
    
        $("#advorgName").keyup(function(e){           
           if($('#searchboxautocomplete-list').length){ 
            if (e.keyCode === 40) {                         
                currentFocusAdv++;               
                addActiveAdv(currentFocusAdv);
                return true;
            } else if (e.keyCode === 38) {
              currentFocusAdv--;
              addActiveAdv(currentFocusAdv);
              return true;
            } else if (e.keyCode === 13) {
              e.preventDefault();
              if (currentFocusAdv > -1) {
                selElementHAdv(currentFocusAdv);
                return true;
                }
            }else{
                currentFocusAdv=-1;
            }           
          }
            if(e.keyCode >= 65 && e.keyCode <= 90){
                var keySearch = $(this).val(); 
            
                $("#searchboxautocomplete-list").remove();
                $.ajax({
                    url: "<?php echo site_url("home/orgNames");?>",
                    type: 'POST',
                    data: {keySearch:keySearch},
                    success: function(response){
                        if(response!==''){
                            var responsearr     =   $.parseJSON(response);
                             var dropdowndata   =   '';
                            for(var i=0;i<responsearr.length;i++){
                                dropdowndata    =   dropdowndata+'<div id="searchterm'+i+'" onclick="selElementHAdv('+i+');" onmouseover="addActiveAdvM('+i+');" loginids="'+responsearr[i].loginId+'" class="searchterms">'+responsearr[i].orgName+'</div>';
                            }
                        }else{
                         var dropdowndata   =   '<div id="searchterm0" onclick="selElementHAdv(0);" onmouseover="addActiveAdvM(0);" loginids="" class="searchterms">No Results Found</div>';
                        }
                        var divdata =   '<div id="searchboxautocomplete-list" class="autocomplete-items">'+dropdowndata+'</div>';
                        $("#advorgNamediv").append(divdata);
                    },error: function (jqXHR,response) {
                     $.alert({title: 'Error!', content: jqXHR["status"]+" "+response, type: 'red',
                            typeAnimated: true,buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            } });
                }
                });
            }else{
            return false;
            }
       });
});
        $('#comment-submit').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function(response){
                var result = $.parseJSON(response);
                    if (result.status === 'success') {
                                $.alert({title: 'Success!', content: result.msg, type: 'blue',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                          window.location.reload();
                                        }
                                    }
                                });
                            } else {
                                $.alert({title: 'Error!', content: result.msg, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                          window.location.reload();
                                        }
                                    } });
                            }
            }, 
            error: function(jqXHR, exception){             
                    $.alert({
                            title: 'Error!', content: jqXHR["status"]+" "+ exception, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
            };
            $('#form_details').ajaxForm(options);
        }); 
</script>
<?php  include_once 'shared/footer.php';
