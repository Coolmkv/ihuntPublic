<?php include_once 'superadmin_header.php'; ?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

           First Subscription Text
            <small></small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>

            <li><a href="#">Footer Pages</a></li>

            <li class="active">First Subscription Text</li>

        </ol>

    </section>



    <!-- Main content -->

    <section class="content">

        <div class="row box-body">

            <div class="col-md-12 table-responsive">

                <!-- general form elements -->

                <div class="box box-primary">

                    <div class="box-header with-border">

                        <h3 class="box-title"> First Subscription Text</h3>

                    </div>



                    <div class="box-body">

                        <div class="row">

                            <div class="col-md-12 hidden" id="insertBYB">

                                <?php echo form_open("superadmin/editFirstSubscription", ["id" => "submit_form"]); ?>

                                <div class="form-group col-md-12">

                                    <input type="hidden" class="hidden" name="bybId" id="bybId" value="">

                                    

                                    <textarea name="beforeYouBegin" id="beforeYouBegin" class="form-control summernote" data-validation ="required"></textarea>

                                </div>

                                <div class="  col-md-12 text-center">



                                    <input style="margin-top:3px" type="submit" value="Save" class=" btn btn-primary" name="save_details" id="save_details">

                                </div>

                                <?php echo form_close(); ?>

                            </div>

                            <div class="col-md-12 hidden" id="showBYB">

                                <div class="col-md-12" id="BYBText"></div>

                                <div class="col-md-12 text-center">

                                    <button type="button" class="btn btn-info" onclick="editGiftSmile();">Edit</button>

                                </div>

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

<!-- /.content-wrapper -->



<!-- Control Sidebar -->



<div class="control-sidebar-bg"></div>



<!-- ./wrapper -->

<?php include 'superadmin_footer.php' ?>

<script type="text/javascript">

    function editGiftSmile() {

        $("#showBYB").addClass("hidden");

        $("#insertBYB").removeClass("hidden");

    }

    $(document).ready(function () {

        $.validate({

            lang: 'en'

        });

        $('.summernote').summernote({

            height: 400

        });

        $.ajax({

            type: "POST",

            data: {},

            url: "<?php echo site_url('superadmin/getFirstSubscription'); ?>",

            success: function (response) {

                if (response !== "") {

                    var json = $.parseJSON(response);

                    $("#BYBText").html(json.fsText);

                    $("#bybId").val(json.fsId);

                    $('#beforeYouBegin').summernote('code', json.fsText);

                    $("#showBYB").removeClass("hidden");

                } else {

                    $("#insertBYB").removeClass("hidden");

                }





            }

        });

    });

    $('#save_details').click(function () {

        $.validate({

            lang: 'en'

        });

        var options = {

            beforeSend: function () {

            },

            success: function (response) {

                var json = $.parseJSON(response);

                if (json.status === 'success') {

                    $.alert({title: 'Success!', content: json.msg, type: 'blue',

                        typeAnimated: true,

                        buttons: {

                            Ok: function () {

                                window.location.reload();

                            }

                        }

                    });

                } else {

                    $.alert({title: 'Error!', content: json.msg, type: 'red',

                        typeAnimated: true, buttons: {

                            Ok: function () {

                                window.location.reload();

                            }

                        }});

                }

            },

            error: function (jqXHR, exception) {

                $.alert({

                    title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',

                    typeAnimated: true,

                    buttons: {

                        Ok: function () {

                            window.location.reload();

                        }

                    }

                });

            }

        };

        $('#submit_form').ajaxForm(options);

    });

</script>



<script type="text/javascript">

    $(".orgByB").addClass("active");

    $(".bubtext").addClass("active");

    document.title = "iHuntBest | First Subscription";

</script>