<?php include_once 'superadmin_header.php'; ?>
<link href="<?php echo base_url() ?>plugins/bootstrap-fileupload/css/bootstrap-fileupload.css"  rel="stylesheet"/>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Country
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Country</a></li>
            <li class="active">Add/Show Country</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Country</h3>
                    </div>
                    <?php echo form_open_multipart("superadmin/addCountry", ["id" => "country_form"]); ?>
                    <div class="box-body">
                        <input type="hidden" name="id" id="id" value="no_one" >
                        <input type="hidden" name="flagname" id="flagname" value="" >
                        <div class="form-group col-md-5">
                            <label>Country Name</label>
                            <input type="text" name="name" id="name" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-5">
                            <label>Country Short Name</label>
                            <input type="text" name="sortname" id="sortname" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-5">
                            <label>Country Flag</label>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail"
                                     style="width: 200px; height: 150px;">
                                    <img src="<?php echo base_url(); ?>plugins/no-image.png" alt="image"/>

                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail"
                                     style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"> <i
                                                class="fa fa-plus"></i> Add More</span>
                                        <span class="fileupload-exists"><i
                                                class="fa fa-undo"></i> Change</span>

                                        <input type="file" id="galaryUrl"
                                               name="countryImage" class="default"
                                               onchange="readURL(this);"/>
                                    </span>
                                    <b>(110 * 80)</b>

                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label></label>
                            <input style="margin-top:3px" type="submit" value="Save" class="form-control btn btn-primary" name="save_country" id="save_country">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <!--/.col -->
            </div>
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="loading">Loading&#8230;</div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Country Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="country_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Country Name</th>
                                                <th>Country Short Name</th>
                                                <th>Country Flag</th>
                                                <th>Add State</th>
                                                <th>Update Status</th>
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
            <!-- /.row -->
        </div>

    </section>

    <!-- /.content -->

</div>
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<div class="control-sidebar-bg"></div>
<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script src="<?php echo base_url(); ?>plugins/bootstrap-fileupload/js/bootstrap-fileupload.js"></script>
<script type="text/javascript">
                                                           $(document).ready(function () {
                                                               $(document).on("click", ".editfunction", function () {
                                                                   var countryId = $(this).attr('ed');
                                                                   $.ajax({
                                                                       type: "POST",
                                                                       data: "ed=" + countryId,
                                                                       url: "<?php echo site_url('superadmin/getCountry'); ?>",
                                                                       success: function (response) {
                                                                           var json = $.parseJSON(response);
                                                                           $('#id').val(json[0].countryId);
                                                                           $('#name').val(json[0].name);
                                                                           $('#sortname').val(json[0].sortname);
                                                                           $('#flagname').val(json[0].flag_image);
                                                                       }
                                                                   });
                                                               });
                                                               $(document).on("click", ".delfunction", function () {
                                                                   var countryId = $(this).attr('del');
                                                                   $.confirm({
                                                                       title: 'Warning!',
                                                                       content: "Are you sure to delete?",
                                                                       type: 'red',
                                                                       typeAnimated: true,
                                                                       buttons: {
                                                                           Cancel: function () {
                                                                               window.location.reload();
                                                                           },
                                                                           Confirm: function () {
                                                                               $.ajax({
                                                                                   type: "POST",
                                                                                   data: {del: countryId, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                                                                                   url: "<?php echo site_url('superadmin/delCountry'); ?>",
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
                                                                                   }
                                                                               });
                                                                           }
                                                                       }
                                                                   });
                                                               });
                                                               $(document).on("change", ".country_status", function () {
                                                                   var id = $(this).attr("id");
                                                                   var country_status = $(this).val();
                                                                   $.ajax({
                                                                       type: "POST",
                                                                       data: {id: id, country_status: country_status, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                                                                       url: '<?php echo site_url('superadmin/updateStatusCountry'); ?>',
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
                                                                   url: "<?php echo site_url('superadmin/getCountry'); ?>",
                                                                   success: function (response) {
                                                                       $('.loading').hide();
                                                                       var json = $.parseJSON(response);
                                                                       var oTable = $('table#country_table').dataTable();
                                                                       var flagimg = "";
                                                                       oTable.fnClearTable();
                                                                       for (var i = 0; i < json.length; i++) {
                                                                           if (json[i].countryFlag === "0") {
                                                                               var status = '<span class="label label-primary">Active</span>';
                                                                           } else if (json[i].countryFlag === "1") {
                                                                               var status = '<span class="label label-danger">Disable</span>';
                                                                           }
                                                                           flagimg = '<img src="<?php echo base_url('projectimages/images/countryflags/'); ?>' + json[i].flag_image + '" class="img-responsive" \n\
                    onerror="this.src=\'<?php echo base_url('plugins/no-image.png'); ?>\'">';
                                                                           oTable.fnAddData([
                                                                               (i + 1),
                                                                               json[i].name,
                                                                               json[i].sortname,
                                                                               flagimg,
                                                                               '<a href="addState?ed=' + json[i].countryId + '" title="More"><i class="fa fa-plus"></i></i></a>',
                                                                               '<select class="country_status" id="' + json[i].countryId + '"style="background-color:#acd6e9;"><option value="">Choose One...</option><option value="0">Active</option><option value="1">Disable</option>' + json[i].countryFlag + '</select>',
                                                                               status,
                                                                               '<a href="#" ed="' + json[i].countryId + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="delfunction" href="javascript:" del="' + json[i].countryId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                                                                           ]);
                                                                       }
                                                                   }
                                                               });
                                                               $('#save_country').click(function () {
                                                                   $.validate({
                                                                       lang: 'en'
                                                                   });

                                                                   var options = {
                                                                       beforeSend: function () {
                                                                       },
                                                                       success: function (response) {
//                            console.log(response);
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
                                                                       error: function (response) {
                                                                           $('#error').html(response);
                                                                       }
                                                                   };
                                                                   $('#country_form').ajaxForm(options);
                                                               });
                                                           });
</script>

<script type="text/javascript">
    $(".treeviewASC_link").addClass("active");
    $(".treeviewCSC_link").addClass("active");
    document.title = "iHuntBest | Country";
</script>