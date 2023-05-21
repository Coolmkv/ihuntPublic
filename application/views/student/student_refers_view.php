<?php include_once 'student_header.php'; 

if(isset($referDetails)){
    $refercode        =   $referDetails->refercode;
    $myrefrences      =   $referDetails->myrefrences;
    $my_referer       =   $referDetails->my_referer;  
    
}else{
    $refercode        =   '';
    $myrefrences      =   '';
    $my_referer       =   '';
     
}

?>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Refers
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student');?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">Refers</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Refers Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row"> 
                                <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 form-group text-center">
                                    <label class="control-label">My Refer Code</label>
                                    <h3 id="myrefer_code"><?php echo $refercode;?></h3>
                                    <h5 id="linktext"><?php echo site_url('?referCode='.$refercode);?></h5>
                                    <button class="btn btn-dropbox" onclick="myFunction()"><i class="fa fa-copy"></i> Copy Link</button>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 form-group text-center">
                                    <label class="control-label">Total Referrals</label>
                                    <h3 ><?php echo $myrefrences;?></h3>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 form-group text-center">                                    
                                    <?php 
                                    if($my_referer==""){
                                        echo form_open('student/addMyReference',['id'=>'myreferences']);
                                        echo '  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                                    <label class="control-label">Add Your Referer Code:</label>
                                                    <input type="text" placeholder="Add Your Referer Code" id="your_refrence_code" name="your_refrence_code"    data-validation="required" class="form-control">
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Save">
                                                </div>
                                                ';
                                        echo form_close();
                                    }else{
                                        echo '<label class="control-label">Your were Referred By</label>';
                                        echo '<h3>'.$my_referer.'</h3>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        
    </section>
    <!-- /.content -->
</div>
<?php include_once 'student_footer.php';?>
<script>
$(".refers_link").addClass("active"); 
document.title  =   "iHuntBest | Refer";
function myFunction() {
     
    var copyText = document.getElementById("linktext");
    var range = document.createRange();
    range.selectNodeContents(copyText);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
    document.execCommand('copy');
    alert("Contents copied to clipboard.");
    return false;
}
$(document).ready(function(){
    $.validate({
            lang: 'en'
        });
    $('#save_details').click(function () {
            var options = {
                beforeSend: function () {
                    
                    var myreferCode =   $("#myrefer_code").text();
                    var yourrefcode =   $("#your_refrence_code").val();
                    if(yourrefcode==myreferCode){
                        $.alert({
                            title: 'Error!', content: "You Can not enter your code", type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                        return false;
                    } 
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({
                            title: 'Success!', content: json.msg, type: 'blue',
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
                                    window.location.reload();
                                }
                            }
                        });
                    }
                },
                error: function (response) {
                    $.alert({
                            title: 'Error!', content: response, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                }
            };
            $('#myreferences').ajaxForm(options);
        }); 
});
</script>
