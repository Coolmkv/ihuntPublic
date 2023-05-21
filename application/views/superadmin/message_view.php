<?php include_once 'superadmin_header.php'; ?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            Message Status

            <!--<small>Optional description </small>-->

        </h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>

            <li class="active">Message Status</li>

            <li class="active">View Message Status</li>

        </ol>

    </section>                <!-- Main content -->

    <section class="content">

        <div class="row">

            <div class="row box-body">

                <div class="col-md-12">

                    <!-- general form elements -->

                    <div class="box box-primary">

                        <div class="box-header with-border">

                            <h3 class="box-title">Messages Request</h3>

                        </div>

                        <div class="box-body">

                            <div class="row">

                                <div class="col-md-12">

                                    <table id="details_table" class="table table-bordered table-striped table-responsive">

                                        <thead>

                                            <tr>

                                                <th>S. No.</th>
												
												<th>Message</th>

                                                <th>Message From</th>

                                                <th>Message To</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                        <!--/.col -->

                    </div>

                </div>

            </div>

        </div>



    </section>

    <!-- /.content -->

</div>
			           

<?php include_once 'superadmin_footer.php'; ?>

<script>


    $(".deleteappenddata").click(function(){
		$("#my_msg").empty();
	});
    $(".myEnrollments").addClass("active");

    $(".myEnrollmentsview").addClass("active");

    document.title = "iHuntBest | Enrollments";



    $(document).ready(function () {

        $(document).on('change', '.statuschange', function () {

            var msgId = $(this).attr('msgId');

            var status = $(this).val();
			alert(status);

            if (status === "Pending") {

                return false;

            }
     else {

                $.ajax({

                    url: '<?php echo site_url('Superadmin/changeMsgStatus'); ?>',

                    type: "POST",

                    data: {msgId: msgId, status: status},

                    success: function (response) {

                        var json = $.parseJSON(response);

                        if (json.status === 'success') {

                            $.alert({title: ' Status changed Successfully!', content: json.msg, type: 'blue',

                                typeAnimated: true,

                                buttons: {

                                    Ok: function () {

                                        window.location.reload();

                                    }

                                }


                            });

                        } else {

                            $.alert({title: 'Error!', content: json.msg, type: 'red',

                                typeAnimated: true,

                                buttons: {

                                    Ok: function () {

                                        window.location.reload();

                                    }

                                }

                            });

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

                });

            }

        });

        $('#details_table').DataTable({

            "processing": true,

            "serverSide": false,

            "ajax": {

                "url": "<?php echo site_url('superadmin/getMessage') ?>",

                "dataType": "json",

                "type": "POST"

            },

            "columns": [

                {"data": "msgId"},
				
				{"data": "Message"},
				
				{"data": "MessageFrom"},

                {"data": "MessageTo"},

                {"data": "Action"}


            ], error: function (jqXHR, exception) {

                $.alert({

                    title: 'Error!', content: jqXHR["status"] + " - " + exception, type: 'red',

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

