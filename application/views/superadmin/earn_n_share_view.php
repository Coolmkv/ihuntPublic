<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Earn and Share
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Earn and Share</a></li>
                <li class="active">Add/Show</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Earn and Share</h3>
                        </div>
                        <?php echo form_open('superadmin/addearnandshare',["id"=>"ens_form","name"=>"ens_form"]);?>
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="ensid" ensid="ensid" value="no_one">
                                    <div class="col-md-6 col-md-offset-2">
                                        <div class="form-group">
                                            <label>Referral Amount Per Share </label>
                                            <input type="text" name="amt" id="amt" class="form-control" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="margin-top: 23px">
                                            <label></label>
                                            <input type="submit" class="btn btn-primary" name="save_ens" id="save_ens" value="Save">
                                        </div>
                                    </div>
                                </div>
                            </div>
                       <?php form_close();?>
                        <!--/.col -->
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Earn and Share Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="ens_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Amount</th>                                            
                                            <th>Status</th>
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
        </section>

        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
   
    <!-- Control Sidebar -->

<!-- ./wrapper -->

<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $('#save_ens').click(function () {
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
                            typeAnimated: true,buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                            });
                    }
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
            };           
            $('#ens_form').ajaxForm(options);
        });
        
        $.ajax({            
            type: "POST",
            data: {},
            url: "<?php echo site_url('superadmin/getearnandshare');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#ens_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].iscurrent === '0') {
                        var iscurrent = '<span class="label label-danger">Disable</span>';
                    }
                    if (json[i].iscurrent === '1') {
                        var iscurrent = '<span class="label label-primary">Active</span>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].amount,
                        iscurrent,
                        '<select ensid="' + json[i].ens_value_id + '" class="Status" style="background-color:#acd6e9;"><option value="">Choose One...</option><option value="0">Disable</option><option value="1">Active</option></select>'
                     ]);
                }
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
         $(document).on("change",".Status", function () {
            var ensid = $(this).attr("ensid");
            var iscurrent = $(this).val();
            if(iscurrent===""){
                return false;
            }
            $.ajax({
                type: "POST",
                data: {ensid:ensid,iscurrent:iscurrent},
                url: "<?php echo site_url('superadmin/changeStatus');?>",
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
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                            }
                                    }
                                });
                            }
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
    });
</script>

<script type="text/javascript">
    $(".ensLinkAddShow").addClass("active");
    $(".ensLink").addClass("active");
    document.title  =   "iHuntBest | Earn and Share Details";
</script>