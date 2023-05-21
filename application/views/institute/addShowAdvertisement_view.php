<?php include_once 'institute_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Advertisement
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('institute/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Advertisement</a></li>
            <li class="active">Add Advertisement</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Advertisement</h3>
                    </div>
                    <?php echo form_open_multipart('institute/addAdvertisement', ["id" => "advertisement_form", "name" => "advertisement_form"]); ?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <input type="hidden" name="previmage" id="previmage" value="no_image">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Advertisement Banner</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="adsBanner" id="adsBanner" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Advertisement Title</label>
                                    <input type="text" name="adsTitle" id="adsTitle" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Advertisement URL</label>
                                    <input type="url" name="url" id="url" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Location of Advertisement</label>
                                <select id="location" name="location" class="form-control" data-validation ="required">
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Plan Name</label>
                                <select id="plan_name" name="plan_name" class="form-control" data-validation ="required">
                                </select>
                                </input>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Price</label>
                                <input type="text" id="price"  name="price" class="form-control" disabled="">
                                </input>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Days</label>
                                <input type="text" id="days" name="days"   class="form-control" disabled="">
                                </input>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select name="countryId" id="countryId" class="form-control" readonly=""></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>State</label>
                                    <select name="stateId" id="stateId" class="form-control" disabled=""></select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Start Date</label>
                                <input id="startDate" name="startDate" type="date" min="<?php echo date('Y-m-d'); ?>"   class="form-control">
                                </input>
                            </div>
                            <div class="col-md-12 text-center">
                                <input type="submit" class="btn btn-primary" name="save_advertisement"  id="save_advertisement" value="Save">
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <!--/.col -->
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row box-body">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Advertisement Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="ads_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Adv Banner</th>
                                            <th>Adv Title</th>
                                            <th>Adv URL</th>
                                            <th>Adv Location</th>
                                            <th>Plan Details</th>
                                            <th>Imp. Dates</th>
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
<div class="modal" id="startDateInsert" role="dialog" style="z-index: 99999">
    <div class="modal-dialog">
        <div class="modal-content"  >
            <div class="modal-body">
                <div class="container-fluid nopadding">
                    <div class="row"  >
                        <div class="col-lg-12 nopadding">
                            <?php echo form_open('institute/updateTime', ["id" => "startDate_form", "name" => "startDate_form"]); ?>
                            <fieldset>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Start Date</label>
                                        <div class="col-md-8">
                                            <input id="startDateC" name="startDateC" type="date" min="<?php echo date('Y-m-d'); ?>"  data-validation ="required"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center" style="margin: 20px 0px 0px 0px;">
                                    <input type="hidden" class="hidden" name="adsId" id="adsId">
                                    <button id="singlebutton" name="singlebutton"  class="btn btn-primary">Save</button>
                                </div>

                            </fieldset>
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'institute_footer.php'; ?>
<script>
    $(".advertisetment_link").addClass("active");
    $(".advertisement").addClass("active");
    document.title = "iHuntBest | Add-Show Advertisement";
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url('projectimages/images/adsBanner/image/'); ?>';
        $.validate({
            lang: 'en'
        });
        $(document).on("click", ".editAdvertisement", function () {
            var adsId = $(this).attr("ed");
            $.ajax({
                type: "POST",
                data: "ed=" + adsId,
                url: "<?php echo site_url('institute/getAdvertisement'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#id').val(json[0].adsId);
                    $('#previmage').val(json[0].adsBanner);
                    $('#adsTitle').val(json[0].adsTitle);
                    $('#url').val(json[0].url);
                    getPlansForimageLoc(json[0].img_loc, json[0].planId);
                    changePlanName(json[0].planId);
                    $('#price').val(json[0].price);
                    $('#days').val(json[0].days);
                    $('#statusId').val(json[0].statusId);
                    $('#countryId').val(json[0].countryId);
                    getcountryByStates(json[0].countryId, json[0].stateId);

                }
            });
        });
        $(document).on("click", ".startAdd", function () {
            var adsId = $(this).attr('addId');
            if (adsId !== "") {
                $("#adsId").val(adsId);
                $("#startDateInsert").modal('show');
            }
        });
        $('#countryId').change(function () {
            var countryId = $('#countryId').val();
            var selected_stateId = "";
            getStateByCountry(countryId, selected_stateId);
        });
        getCountries();
        $('#stateId').change(function () {
            var stateId = $('#stateId').val();
            var selected_cityId = "";
            getStateByCity(stateId, selected_cityId);
        });
        $(document).on("click", ".delAdvertisement", function () {
            var facultyId = $(this).attr("del");
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
                            data: "del=" + facultyId,
                            url: "<?php echo site_url("institute/delAdvertisement"); ?>",
                            success: function (response) {
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
                            }
                        });
                    }
                }
            });
        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('institute/getAdvertisement'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#ads_table').dataTable();
                var status = "";
                var expiry = "";
                var sdate = '';
                var btnsdate = '';
                var delbtn = '';
                var editbtn = '';
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].adsBanner === '') {
                        var image_url = '';
                    } else {
                        var image_url = base_url + json[i].adsBanner;
                    }
                    if (json[i].apprv_by_admin === '1')
                    {
                        status = '<span class="label label-danger">Not Approved</span>';
                        editbtn = '<a class="editAdvertisement" href="javascript:" ed="' + json[i].adsId + '" title="Edit"><i class="fa fa-edit"></i></i></a>';
                        delbtn = '<a class="delAdvertisement" href="javascript:" del="' + json[i].adsId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>';
                    }
                    if (json[i].apprv_by_admin === '2')
                    {
                        status = '<span class="label label-primary">Active</span>';
                        editbtn = '';
                        delbtn = '';
                    }
                    if (json[i].apprv_by_admin === '3') {
                        status = '<span class="label label-danger">UnApproved</span>';
                        editbtn = '<a class="editAdvertisement" href="javascript:" ed="' + json[i].adsId + '" title="Edit"><i class="fa fa-edit"></i></i></a>';
                        delbtn = '<a class="delAdvertisement" href="javascript:" del="' + json[i].adsId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>';
                    }
                    if (json[i].statusadd === '0')
                    {
                        status = '<span class="label label-danger">Expired</span>';
                        editbtn = '';
                        delbtn = '';
                    }
                    if (json[i].startDate === null) {
                        sdate = 'Not Started';
                        btnsdate = '<a href="javascript:" class="startAdd btn btn-primary btn-xs" addId="' + json[i].adsId + '" >Start Plan</a>';
                    } else {
                        sdate = json[i].startDate;
                        btnsdate = '';
                        editbtn = '';
                        delbtn = '';
                    }
                    if (json[i].expiryDate === null) {
                        expiry = 'Not Started yet';
                    } else {
                        expiry = 'Valid Upto : ' + json[i].expiryDate;
                    }
                    oTable.fnAddData([
                        (i + 1),
                        '<img src="' + image_url + '" onError="this.src=\'<?php echo base_url('projectimages/default.png'); ?>\'" class="img-responsive" style="height:60px;width:120px;">',
                        json[i].adsTitle,
                        json[i].url,
                        json[i].img_loc,
                        json[i].plan_name + " <br> Price : " +
                                json[i].price + " <br> Days : " +
                                json[i].days + " <br>" + expiry + " <br> Country : " +
                                json[i].countryname + " <br> State : " +
                                json[i].statename,
                        'Added On : ' + json[i].addeddate + '<br>' + sdate,
                        status,
                        editbtn + '&nbsp;&nbsp;&nbsp;&nbsp;' + delbtn + ' ' + btnsdate
                    ]);
                }
            }
        });
        $("#singlebutton").click(function () {
            var options = {
                beforeSend: function () {
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
                    $('#error').html(response);
                }
            };
            $('#startDate_form').ajaxForm(options);
        });
        $('#save_advertisement').click(function () {
            var options = {
                beforeSend: function () {
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
                            typeAnimated: true
                        });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#advertisement_form').ajaxForm(options);
        });
    });
    getLocations();
    function getLocations() {
        $.ajax({
            url: "<?php echo site_url('institute/getPlandetailsJson'); ?>",
            type: 'POST',
            data: {location: "find"},
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Advertisement Location</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].img_loc + '">' + json[i].img_loc + '</option>';
                }
                $('#location').html(data);
            }
        });
    }
    $('#location').change(function () {
        var img_loc = $(this).val();
        getPlansForimageLoc(img_loc, "");
    });
    function getPlansForimageLoc(img_loc, selplanId) {
        $.ajax({
            url: "<?php echo site_url('institute/getPlandetailsJson'); ?>",
            type: 'POST',
            data: 'img_loc=' + img_loc,
            success: function (response) {
                if (response !== "") {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Select(Price)</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].planId + '"> ' + json[i].plan_name + ' ( ' + json[i].price + ' )</option>';
                    }
                    $('#location').val(img_loc);
                    $("#plan_name").html(data);
                    $("#plan_name").val(selplanId);
                }

            }
        });
    }
    $('#plan_name').change(function () {
        var planId = $(this).val();
        changePlanName(planId);
    });
    function changePlanName(planId) {

        $.ajax({
            url: "<?php echo site_url('institute/getPlandetailsJson'); ?>",
            type: 'POST',
            data: 'planId=' + planId,
            success: function (response) {
                if (response !== "") {
                    var json = $.parseJSON(response);
                    $("#price").val(json[0].price + ' (' + json[0].currencyCode + ')');
                    $("#days").val(json[0].days);
                    $('#countryId').val(json[0].countryId);
                    getStateByCountry(json[0].countryId, json[0].stateId);
                }
            }
        });
    }
    function getCountries() {
        $.ajax({
            url: "<?php echo site_url("home/getCountriesJson"); ?>",
            type: 'POST',
            data: '',
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Country</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].countryId + '">' + json[i].name + '</option>';
                }
                $('#countryId').html(data);
            }
        });
    }
    function getStateByCountry(countryId, selected_stateId) {
        $.ajax({
            url: "<?php echo site_url("home/getStatesByCountry"); ?>",
            type: 'POST',
            data: 'countryId=' + countryId,
            success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose State</option>';
                for (var i = 0; i < json.length; i++) {
                    data = data + '<option value="' + json[i].stateId + '">' + json[i].name + '</option>';
                }
                $('#stateId').html(data);
                $('#stateId').val(selected_stateId);

            }
        });
    }

</script>