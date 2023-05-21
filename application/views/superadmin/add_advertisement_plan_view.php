<?php include_once 'superadmin_header.php'; ?>
<div class="content-wrapper">
    <div class="hidden"></div>
    <section class="content-header">
        <h1>
            Advertisement Plan
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Super-Admin Dashboard</a></li>
            <li><a href="#">Advertisement</a></li>
            <li class="active">Advertisement Plan</li>
        </ol>
    </section>
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Advertisement Plan</h3>
                    </div>
                    <?php echo form_open("superadmin/AdvplanDetails", ["id" => "submit_form"]); ?>
                    <div class="box-body">
                        <div class="col-md-12">
                            <input type="hidden" name="planid" id="planid" value="no_one" >
                            <div class="form-group col-md-3">
                                <label>Image Location</label>
                                <select id="img_loc" name="img_loc" class="form-control" data-validation ="required">
                                    <option value="">Image Location</option>
                                    <option value="Top">Top</option>
                                    <option value="Middle">Middle</option>
                                    <option value="Right Side">Right Side</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Days</label>
                                <input type="number" maxlength="10" name="days" id="days" class="form-control" data-validation ="required">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Price</label>
                                <input type="text" name="price" id="price" class="form-control" data-validation ="required">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Currency</label>
                                <select name="currency" id="currency" class="form-control"
                                        data-validation="required"><?php
                                            if (isset($currency)) {
                                                echo '<option value="">Select</option>';
                                                foreach ($currency as $cr) {
                                                    echo '<option value="' . $cr->code . '">' . $cr->code . ' (' . $cr->name . ')</option>';
                                                }
                                            }
                                            ?></select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Plan Name</label>
                                <input type="text" name="plan_name" id="plan_name" class="form-control" data-validation ="required">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Start Time</label>
                                <div class='input-group date'id="start_time">
                                    <input type='text' class="form-control" name="start_time" id="start_time_input" placeholder="Start Time"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>End Time</label>
                                <div class="input-group date" id="end_time">
                                    <input type='text' class="form-control" name="end_time" id="end_time_input" placeholder="End Time"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Country</label>
                                <select name="countryId" id="countryId" class="form-control"
                                        data-validation="required"></select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>State</label>
                                <select name="stateId" id="stateId" class="form-control" data-validation="required"></select>
                            </div>

                        </div>



                        <div class="col-md-12 text-center">
                            <input   type="submit" value="Save" class="btn btn-primary" name="save_details" id="save_details">
                        </div>
                    </div>
<?php echo form_close(); ?>
                </div>
            </div>
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Advertisement Plan Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="data_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Image Location</th>
                                                <th>Days</th>
                                                <th>Price</th>
                                                <th>Plane Name</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Country</th>
                                                <th>State</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="control-sidebar-bg"></div>
<?php include 'superadmin_footer.php' ?>
<link src="<?php echo base_url(); ?>timepicker/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>timepicker/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>timepicker/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $('#end_time_input').prop('disabled', true);
    $('#start_time').datetimepicker({
        format: 'HH:mm:ss:A',
        useCurrent: false
    });

    $('#end_time').datetimepicker({
        format: 'HH:mm:ss:A',
        useCurrent: false
    });

    $("#start_time").on("dp.change", function (e) {
        $('#end_time_input').prop('disabled', false);
        if (e.date) {
            $('#end_time').data("DateTimePicker").date(e.date.add(1, 'h'));
        }

        $('#end_time').data("DateTimePicker").minDate(e.date);
    });
</script>
<script type="text/javascript">
    $(".advertisement_plan").addClass("active");
    $(".advertisement_plan_link").addClass("active");
    document.title = "iHuntBest | Add-Show Advertisement Plan";
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $('#countryId').change(function () {
            var countryId = $('#countryId').val();
            var selected_stateId = "";
            getcountryByStates(countryId, selected_stateId);
        });
        getCountries();
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
        function getcountryByStates(countryId, selected_stateId) {
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
        function getStateByCity(stateId, selected_cityId) {
            $.ajax({
                url: "<?php echo site_url("home/getCityByStates"); ?>",
                type: 'POST',
                data: 'stateId=' + stateId,
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose City</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].cityId + '">' + json[i].name + '</option>';
                    }
                    $('#cityId').html(data);
                    $('#cityId').val(selected_cityId);
                }
            });
        }
        $('#stateId').change(function () {
            var stateId = $('#stateId').val();
            var selected_cityId = "";
            getStateByCity(stateId, selected_cityId);
        });
        $('#save_details').click(function () {
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
                error: function (response) {
                    $.alert({title: 'Error!', content: response, type: 'red',
                        typeAnimated: true, buttons: {
                            Ok: function () {
                                window.location.reload();
                            }
                        }});
                }
            };
            $('#submit_form').ajaxForm(options);
        });
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('Superadmin/getAdvplanDetails'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].img_loc,
                        json[i].days,
                        json[i].price + ' (' + json[i].currencyCode + ')',
                        json[i].plan_name,
                        json[i].start_time,
                        json[i].end_time,
                        json[i].countryname,
                        json[i].statename,
                        '<a href="javascript:" ed="' + json[i].planId + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                        <a class="delfunction" href="javascript:" del="' + json[i].planId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });
        $(document).on("click", ".editfunction", function () {
            var planid = $(this).attr('ed');
            $.ajax({
                type: "POST",
                data: {planid: planid},
                url: "<?php echo site_url('Superadmin/getAdvplanDetails'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#planid').val(json[0].planId);
                    $('#img_loc').val(json[0].img_loc);
                    $('#days').val(json[0].days);
                    $('#price').val(json[0].price);
                    $('#plan_name').val(json[0].plan_name);
                    $('#start_time_input').val(json[0].start_time);
                    $('#end_time_input').val(json[0].end_time);
                    $('#countryId').val(json[0].countryId);
                    getcountryByStates(json[0].countryId, json[0].stateId);
                }
            });

        });
        $(document).on("click", ".delfunction", function () {
            var planId = $(this).attr('del');
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
                            data: {planId: planId, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                            url: "<?php echo site_url('superadmin/delAdvplanDetails'); ?>",
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
    });
</script>