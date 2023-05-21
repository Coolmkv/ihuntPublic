<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Rejected Advertisement Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Advertisement</a></li>
                <li class="active">Rejected Advertisement Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Rejected Advertisement Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="apprvadv_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                             <th>Sr. No.</th>
                                            <th>Adv Banner</th>
                                            <th>Adv Title</th>
                                            <th>Adv URL</th>
                                            <th>Adv Location</th>
                                            <th>Plan Details</th>
                                            <th>Start Date</th>
                                            <th>Rejection Date</th>
                                            <th>Approved Adv</th>
                                            <th>Adv Status</th>
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
     var base_url = '<?php echo base_url('projectimages/images/adsBanner/image/'); ?>';
        $.validate({
            lang: 'en'
        }); 
          $(document).on("change", ".apprv_by_admin", function () {
            var adsId = $(this).attr("adsId");
            var apprv_by_admin = $(this).val();
            $.ajax({
                type: "POST",
                data: {adsId:adsId,apprv_by_admin:apprv_by_admin},
                url: "<?php echo site_url('superadmin/changeRequestedAdvStatus');?>",
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
                    }
                });
        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getRejectedAdvertisement');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#apprvadv_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].adsBanner === '') {
                        var image_url = '';
                    } else {
                        var image_url = base_url + json[i].adsBanner;
                    }
                    var status="";
                    if (json[i].apprv_by_admin === '1') {
                         status = '<span class="label label-danger">Pending</span>';
                    }
                    if (json[i].apprv_by_admin === '2') {
                        status='<span class="label label-primary">Active</span>';
                    }
                    if (json[i].apprv_by_admin === '3') {
                         status = '<span class="label label-danger">UnApproved</span>';
                    }
                    if (json[i].statusadd === '0')
                        {
                            status='<span class="label label-danger">Expired</span>';
                        }
                    oTable.fnAddData([
                        (i + 1),
                        '<img src="' + image_url + '" onError="this.src=\'<?php echo base_url('projectimages/default.png');?>\'" class="img-responsive" style="height:60px;width:120px;">',
                        json[i].adsTitle,
                        json[i].url,
                        json[i].img_loc,
                        json[i].plan_name+" <br> Price : "+
                        json[i].price+" <br> Days : "+
                        json[i].days+" <br>Valid Upto : "+json[i].expiryDate+" <br> Country : "+
                        json[i].countryname+" <br> State : "+
                        json[i].statename,
                        json[i].startdate,
                        json[i].updatedAt,
                        '<select class="apprv_by_admin" adsId="' + json[i].adsId + '" style="background-color:#acd6e9;"><option value="">Choose One...</option><option value="1">Pending</option><option value="2">Approve</option><option value="3">Unapprove</option>' + json[i].apprv_by_admin + '</select>',
                         status
                    ]);
                }
            }
        });
    });

</script>
<script type="text/javascript">
    $(".advertisement_plan").addClass("active");
    $(".rejected_adv_plan_link").addClass("active");
    document.title  =   "iHuntBest | Requested Advertisement Details";
</script>
