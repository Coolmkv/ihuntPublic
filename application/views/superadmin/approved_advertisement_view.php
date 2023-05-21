<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Approved Advertisement Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Advertisement</a></li>
                <li class="active">Approved Advertisement Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Approved Advertisement Details</h3>
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

    <div class="control-sidebar-bg"></div>
 
<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    $(document).ready(function () {
     var base_url = '<?php echo base_url('projectimages/images/adsBanner/image/'); ?>';
        $.validate({
            lang: 'en'
        });   
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getApprovAdvertisement');?>",
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
                        status
                    ]);
                }
            }
        });
    });

</script>

<script type="text/javascript">
    $(".advertisement_plan").addClass("active");
    $(".Approv_adv_plan_link").addClass("active");
    document.title  =   "iHuntBest | Requested Advertisement Details";
</script>
