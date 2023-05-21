<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>iHuntBest | Forgot Password</title>
        <link rel="icon" href="<?php echo base_url();?>images/fav.png" type="image/jpg" sizes="30x30">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    </head>

    <body class="hold-transition login-page" style="background-image: url('<?php echo base_url('images/001.jpg');?>');height: 100%; overflow-y: hidden">
        <div class="login-box">
            <div class="login-logo">
                <a href=""><b>Forgot Password</b></a>
                </div>
            <!-- /.login-logo -->
            <div class="login-box-body" style="">
                <p class="login-box-msg">Forgot Password Form</p>
                <?php echo form_open('home/forgotPasswordCode' ,["id"=>"form_details"]);?>
                
                    <div class="form-group has-feedback" id="emailIDdiv">
                        <input type="text" name="email" class="form-control" id="email_id"   placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback hidden codediv"  >
                        <input type="text" name="secretCode" autocomplete="new-password"  class="form-control" placeholder="Code" data-validation="required">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback hidden codediv">
                        <input type="password" name="newPassword" autocomplete="new-password"  class="form-control" placeholder="New Password" data-validation="required">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    
                    <p id="message"></p>
                    <div class="row">
                        <div class="col-xs-12">                             
                            <input type="submit" value="Change Password" class="hidden btn btn-primary btn-block btn-flat" id="login">
                            <button type="button" onclick="generateCodes();" class="btn btn-primary btn-block btn-flat" id="generateCode">Generate Code</button>
                        </div>
                        <!-- /.col -->
                    </div>
                <?php echo form_close();?>
            </div>
            <!-- /.login-box-body -->
        </div>
        <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url(); ?>plugins/jQuery/jquery.form.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
        <script>
            function generateCodes(){
                    var emailid =   $("#email_id").val();
                    
                    if(emailid===""){
                        $.alert({title: 'Error!', content: "Email Should not be blank", type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {                                           
                                        }
                                    } });
                    }else{
                        $.ajax({
                            type:"POST",
                            url:'<?php echo site_url('home/codegenrations?type=').$this->input->get('type'); ?>',
                            data:{emailid:emailid},                             
                            success:function (response){
                               var result = $.parseJSON(response);
                            if (result.status === 'success') {
                                $.alert({title: 'Success!', content: result.msg, type: 'blue',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () { 
                                        $("#emailIDdiv,#generateCode").addClass("hidden");
                                        $(".codediv,#login").removeClass("hidden");
                                        }
                                    }
                                });
                            } else {
                                $.alert({title: 'Error!', content: result.msg, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {}
                                    } });
                                }
                            },
                            error: function(jqXHR, exception){             
                            $.alert({
                                    title: 'Error!', content: jqXHR["status"]+" "+ exception, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {

                                        }
                                    }
                            });
                            }
                        });
                    }
                }
                
            $(document).ready(function () {
                $.validate({
                    lang: 'en'
                });
                
                $('#login').click(function () {
                    var options = {
                        beforeSend: function () {
                        },
                        success: function (response) {
                             var result = $.parseJSON(response);
                            if (result.status === 'success') {
                                $.alert({title: 'Success!', content: result.msg, type: 'blue',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () { 
                                         window.location.href   =   '<?php echo site_url();?>';
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
                        }, error: function(jqXHR, exception){             
                            $.alert({
                                    title: 'Error!', content: jqXHR["status"]+" "+ exception, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {

                                        }
                                    }
                            });
                            }
                    };
                    $('#form_details').ajaxForm(options);
                });

            });
        </script>
    </body>
</html>
