<?php include_once 'superadmin_header.php'; ?>
<link href="<?php echo base_url() ?>plugins/bootstrap-fileupload/css/bootstrap-fileupload.css"  rel="stylesheet"/>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            City
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">State</a></li>
            <li class="active">Add/Show City</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php if (isset($sname)) {
    echo $sname;
} if (isset($countryid)) {
    $sid = $countryid;
} else {
    $sid = "";
} ?></h3>
                        <br><a href="<?php echo site_url("superadmin/addState?ed=" . $sid); ?>"> Go back to state</a>
                    </div>

<?php echo form_open_multipart("superadmin/insertCity", ["id" => "submit_form"]); ?>
                    <div class="box-body">

                        <input type="hidden" name="id" id="id" value="no_one" >
                        <input type="hidden" name="state" id="state_Id" value="<?php if (isset($stateid)) {
    echo $stateid;
} ?>" >
                        <input type="hidden" name="flagname" id="flagname" value="" >
                        <input type="hidden" name="statename" value="<?php if (isset($sname)) {
    echo $sname;
} ?>">
                        <div class="form-group col-md-5">
                            <label>City Name</label>
                            <input type="text" name="name" id="name" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-5">
                            <label>City Flag</label>
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
                                               name="cityFlag" class="default"
                                               onchange="readURL(this);"/>
                                    </span>
                                    <b>(110 * 80)</b>

                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label></label>
                            <input style="margin-top:3px" type="submit" value="Save" class="form-control btn btn-primary" name="save_details" id="save_details">
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
                            <h3 class="box-title">City Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="country_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>City Name</th>
                                                <th>City Flag</th>
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
                                                                   var cityId = $(this).attr('ed');
                                                                   $.ajax({
                                                                       type: "POST",
                                                                       data: {cityId: cityId, stateId: '<?php if (isset($stateid)) {
    echo $stateid;
} ?>'},
                                                                       url: "<?php echo site_url('Home/getCityByStates'); ?>",
                                                                       success: function (response) {
                                                                           var json = $.parseJSON(response);
                                                                           $('#id').val(json[0].cityId);
                                                                           $('#name').val(json[0].name);
                                                                           $('#flagname').val(json[0].city_flag);
                                                                       }
                                                                   });
                                                               });
                                                               $(document).on("click", ".delfunction", function () {
                                                                   var cityId = $(this).attr('del');
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
                                                                                   data: {cityId: cityId, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                                                                                   url: "<?php echo site_url('superadmin/delCity'); ?>",
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
                                                               $(document).on("change", ".city_status", function () {
                                                                   var id = $(this).attr("id");
                                                                   var city_status = $(this).val();
                                                                   $.ajax({
                                                                       type: "POST",
                                                                       data: {id: id, city_status: city_status, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                                                                       url: '<?php echo site_url('superadmin/updateStatusCity'); ?>',
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

                                                               var Base64 = {_keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", encode: function (e) {
                                                                       var t = "";
                                                                       var n, r, i, s, o, u, a;
                                                                       var f = 0;
                                                                       e = Base64._utf8_encode(e);
                                                                       while (f < e.length) {
                                                                           n = e.charCodeAt(f++);
                                                                           r = e.charCodeAt(f++);
                                                                           i = e.charCodeAt(f++);
                                                                           s = n >> 2;
                                                                           o = (n & 3) << 4 | r >> 4;
                                                                           u = (r & 15) << 2 | i >> 6;
                                                                           a = i & 63;
                                                                           if (isNaN(r)) {
                                                                               u = a = 64
                                                                           } else if (isNaN(i)) {
                                                                               a = 64
                                                                           }
                                                                           t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a)
                                                                       }
                                                                       return t
                                                                   }, decode: function (e) {
                                                                       var t = "";
                                                                       var n, r, i;
                                                                       var s, o, u, a;
                                                                       var f = 0;
                                                                       e = e.replace(/[^A-Za-z0-9+/=]/g, "");
                                                                       while (f < e.length) {
                                                                           s = this._keyStr.indexOf(e.charAt(f++));
                                                                           o = this._keyStr.indexOf(e.charAt(f++));
                                                                           u = this._keyStr.indexOf(e.charAt(f++));
                                                                           a = this._keyStr.indexOf(e.charAt(f++));
                                                                           n = s << 2 | o >> 4;
                                                                           r = (o & 15) << 4 | u >> 2;
                                                                           i = (u & 3) << 6 | a;
                                                                           t = t + String.fromCharCode(n);
                                                                           if (u != 64) {
                                                                               t = t + String.fromCharCode(r)
                                                                           }
                                                                           if (a != 64) {
                                                                               t = t + String.fromCharCode(i)
                                                                           }
                                                                       }
                                                                       t = Base64._utf8_decode(t);
                                                                       return t
                                                                   }, _utf8_encode: function (e) {
                                                                       e = e.replace(/rn/g, "n");
                                                                       var t = "";
                                                                       for (var n = 0; n < e.length; n++) {
                                                                           var r = e.charCodeAt(n);
                                                                           if (r < 128) {
                                                                               t += String.fromCharCode(r)
                                                                           } else if (r > 127 && r < 2048) {
                                                                               t += String.fromCharCode(r >> 6 | 192);
                                                                               t += String.fromCharCode(r & 63 | 128)
                                                                           } else {
                                                                               t += String.fromCharCode(r >> 12 | 224);
                                                                               t += String.fromCharCode(r >> 6 & 63 | 128);
                                                                               t += String.fromCharCode(r & 63 | 128)
                                                                           }
                                                                       }
                                                                       return t
                                                                   }, _utf8_decode: function (e) {
                                                                       var t = "";
                                                                       var n = 0;
                                                                       var r = c1 = c2 = 0;
                                                                       while (n < e.length) {
                                                                           r = e.charCodeAt(n);
                                                                           if (r < 128) {
                                                                               t += String.fromCharCode(r);
                                                                               n++
                                                                           } else if (r > 191 && r < 224) {
                                                                               c2 = e.charCodeAt(n + 1);
                                                                               t += String.fromCharCode((r & 31) << 6 | c2 & 63);
                                                                               n += 2
                                                                           } else {
                                                                               c2 = e.charCodeAt(n + 1);
                                                                               c3 = e.charCodeAt(n + 2);
                                                                               t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);
                                                                               n += 3
                                                                           }
                                                                       }
                                                                       return t
                                                                   }}

                                                               $.ajax({
                                                                   type: "POST",
                                                                   data: {stateId: '<?php if (isset($stateid)) {
    echo $stateid;
} ?>'},
                                                                   url: "<?php echo site_url('Home/getCityByStates'); ?>",
                                                                   success: function (response) {
                                                                       $('.loading').hide();
                                                                       var json = $.parseJSON(response);
                                                                       var oTable = $('table#country_table').dataTable();
                                                                       var flagimg = "";
                                                                       oTable.fnClearTable();
                                                                       for (var i = 0; i < json.length; i++) {
                                                                           if (json[i].cityFlag === "0") {
                                                                               var status = '<span class="label label-primary">Active</span>';
                                                                           } else if (json[i].cityFlag === "1") {
                                                                               var status = '<span class="label label-danger">Disable</span>';
                                                                           }
                                                                           flagimg = '<img src="<?php echo base_url('projectimages/images/cityflags/'); ?>' + json[i].city_flag + '" class="img-responsive" \n\
                    onerror="this.src=\'<?php echo base_url('plugins/no-image.png'); ?>\'">';
                                                                           oTable.fnAddData([
                                                                               (i + 1),
                                                                               json[i].name,
                                                                               flagimg,
                                                                               '<select class="city_status" id="' + json[i].cityId + '"style="background-color:#acd6e9;"><option value="">Choose One...</option><option value="0">Active</option><option value="1">Disable</option></select>',
                                                                               status,
                                                                               '<a href="javascript:" ed="' + json[i].cityId + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="delfunction" href="javascript:" del="' + json[i].cityId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                                                                           ]);
                                                                       }
                                                                   }
                                                               });

                                                               $('#save_details').click(function () {
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
                                                                   $('#submit_form').ajaxForm(options);
                                                               });
                                                           });
</script>

<script type="text/javascript">
    $(".treeviewASC_link").addClass("active");
    $(".treeviewCSC_link").addClass("active");
    document.title = "iHuntBest | City";
</script>