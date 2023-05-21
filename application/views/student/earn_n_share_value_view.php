<?php include_once 'student_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Earn and Share Value
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("student");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Earn and Share Value</a></li>
                <li class="active">Show</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Earn and Share Value Details</h3>
                        </div>
                           <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Name:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label id="studentName"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Email:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label id="email"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Refer Code:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label id="my_refer_code"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Referer:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label id="my_referer"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <u>Amount:</u>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                        <label id="ensamount"></label>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
   
    <!-- Control Sidebar -->

<!-- ./wrapper -->

<?php include 'student_footer.php' ?>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        var studentId  =   '<?php echo $_SESSION['studentId'];?>';
        $.ajax({            
            type: "POST",
            data: {studentId:studentId},
            url: "<?php echo site_url('Student/getearnandsharevalue');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                $('#studentId').val(json[0].studentId);
                $('#studentName').html(json[0].studentName);
                $('#email').html(json[0].email);
                $('#my_refer_code').html(json[0].my_refer_code);
                $('#my_referer').html(json[0].my_referer);
                $('#ensamount').html(json[0].ensamount);
            }, error: function(jqXHR, exception){                   
                                $.alert({
                                        title: 'Error!', content: jqXHR["status"]+" - "+ exception, type: 'red',
                                        typeAnimated: true,
                                        buttons: {
                                            Ok: function () {
                                                window.location.reload();
                                            }
                                        }
                                });
                                }
        });
    });
</script>
<script type="text/javascript">
    $(".ensvalLinkShow").addClass("active");
    $(".ensLink").addClass("active");
    document.title  =   "iHuntBest | Earn and Share Value Details";
</script>