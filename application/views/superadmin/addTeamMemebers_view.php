<?php include_once 'superadmin_header.php'; ?>
<div class="content-wrapper">
    <div class="hidden"></div>
    <section class="content-header">
        <h1>
            Add | Remove Team Members
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Super-Admin Dashboard</a></li>
            <li><a href="#">Our Members</a></li>
            <li class="active">Add | Remove Team Members</li>
        </ol>
    </section>
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add | Remove Team Members</h3>
                    </div>
                    <?php echo form_open_multipart("superadmin/addRemoveMember", ["id" => "submit_form"]); ?>
                    <div class="box-body">
                        <input type="hidden" name="memberId" id="memberId" value="no_one" >
                        <input type="hidden" name="memberImageName" id="memberImageName" value="" >
                        <div class="form-group col-md-3 col-sm-12">
                            <label>Name</label>
                            <input type="text" name="memberName" id="memberName" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label>Position</label>
                            <input type="text" name="position" id="positionId" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label>Email</label>
                            <input type="email" name="memberEmail" id="memberEmailId" class="form-control" data-validation ="required">
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label>Phone No</label>
                            <input type="text" name="phoneNo" id="phoneNo" class="form-control"  >
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label>Image</label>
                            <input type="file" name="memberImage" accept="image/x-png,image/gif,image/jpeg" id="memberImageId" class="form-control">
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label>Facebook Link</label>
                            <input type="url" name="memberFbLink" id="memberFbLink" class="form-control"  >
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label>Twitter Link</label>
                            <input type="url" name="memberTtLink" id="memberTtLink" class="form-control"  >
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label>Google+ Link</label>
                            <input type="url" name="memberGpLink" id="memberGpLink" class="form-control"  >
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label>About Member</label>
                            <textarea name="aboutMember" id="aboutMember" class="form-control" style="resize: none;"></textarea>
                        </div>
                        <div class="col-md-12 text-center">
                            <input style="margin-top:3px" type="submit" value="Save" class="btn btn-primary" name="save_details" id="save_details">
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
                            <h3 class="box-title">Team Members Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="data_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <th>Image</th>
                                                <th>About Member</th>
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
<script type="text/javascript">
    $(".ourteamLink").addClass("active");
    document.title = "iHuntBest | Add-Show Team Members";
    $(document).ready(function () {
        $.validate({
            lang: 'en'
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
                }, error: function (jqXHR, exception) {
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
            };
            $('#submit_form').ajaxForm(options);
        });
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('Superadmin/getTeamMembers'); ?>",
            success: function (response) {
                var image = "";
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    image = '<img src="<?php echo base_url(); ?>' + json[i].memberImage + '" class="img-responsive" \n\
                    onerror="this.src=\'<?php echo base_url('plugins/no-image.png'); ?>\'">';
                    ;
                    oTable.fnAddData([
                        (i + 1),
                        json[i].memberName,
                        json[i].position,
                        json[i].memberEmail,
                        json[i].phoneNo,
                        image,
                        json[i].aboutMember,
                        '<a href="javascript:" ed="' + json[i].memberId + '" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                        <a class="delfunction" href="javascript:" del="' + json[i].memberId + '" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }, error: function (jqXHR, exception) {
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
        $(document).on("click", ".editfunction", function () {
            var memberId = $(this).attr('ed');
            $.ajax({
                type: "POST",
                data: {memberId: memberId},
                url: "<?php echo site_url('Superadmin/getTeamMembers'); ?>",
                success: function (response) {
                    var json = $.parseJSON(response);
                    $('#memberId').val(json[0].memberId);
                    $('#memberName').val(json[0].memberName);
                    $('#positionId').val(json[0].position);
                    $('#memberEmailId').val(json[0].memberEmail);
                    $('#phoneNo').val(json[0].phoneNo);
                    $('#memberImageName').val(json[0].memberImage);
                    $('#memberFbLink').val(json[0].memberFbLink);
                    $('#memberTtLink').val(json[0].memberTtLink);
                    $('#memberGpLink').val(json[0].memberGpLink);
                    $('#aboutMember').val(json[0].aboutMember);
                }, error: function (jqXHR, exception) {
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
        $(document).on("click", ".delfunction", function () {
            var memberId = $(this).attr('del');
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
                            data: {memberId: memberId, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                            url: "<?php echo site_url('superadmin/delTeamMember'); ?>",
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