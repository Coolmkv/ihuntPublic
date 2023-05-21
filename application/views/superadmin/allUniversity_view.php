<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            University Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Organization Details</a></li>
            <li class="active">University Details</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">University Details</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="showdata_table" class="table table-bordered table-striped table-condensed table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>University Name</th>
                                            <th>University Mobile</th>
                                            <th>University Email</th>
                                            <th>University Address</th>
                                            <th>Update Status</th>
                                            <th>Approve Profile</th>
                                            <th>Top Rated University</th>
                                            <th>Latest University</th>
                                            <th>Feature University</th>
                                            <th>Status</th>
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
        $.validate({
            lang: 'en'
        });
        $(document).on("change", ".login_status", function () {
            var id = $(this).attr("id");
            var login_status = $(this).val();
            $.ajax({
                type: "POST",
                data: {id: id, login_status: login_status, roletype: "University"},

                url: "<?php echo site_url('superadmin/upDateOrgDetailsLoginStatus'); ?>",
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result.status === 'success') {
                        $.alert({title: 'Success!', content: result.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: result.msg, type: 'red',
                            typeAnimated: true,
                            buttons: {
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
            });
        });
        $(document).on('change', '.changeStatus', function () {
            var orgId = $(this).attr("orgId");
            var orgStatus = $(this).val();
            var Statustype = $(this).attr("Statustype");
            var statusName = $(this).attr("statusName");
            $.ajax({
                type: "POST",
                data: {orgId: orgId, orgStatus: orgStatus, Statustype: Statustype, orgType: 'University', statusName: statusName},
                url: "<?php echo site_url('superadmin/orgStatusChange'); ?>",
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result.status === 'success') {
                        $.alert({title: 'Success!', content: result.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: result.msg, type: 'red',
                            typeAnimated: true,
                            buttons: {
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
            });
        });

        $(document).on('change', '.admin_approved', function () {
            var loginId = $(this).attr("loginId");
            var admin_approved = $(this).val();

            $.ajax({
                type: "POST",
                data: "loginId=" + loginId + '&admin_approved=' + admin_approved + '&roleType=University',
                url: "<?php echo site_url('superadmin/upOrgApprovalStatus'); ?>",
                success: function (response) {
                    var result = $.parseJSON(response);
                    if (result.status === 'success') {
                        $.alert({title: 'Success!', content: result.msg, type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: result.msg, type: 'red',
                            typeAnimated: true,
                            buttons: {
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
            });
        });

        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getUniversityDetails'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var loginStatus = "";
                var verifyStatus = "";
                var orgApproved = "";
                var orgsTopRated = "";
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].loginStatus === '0' && json[i].org_status === "") {
                        loginStatus = '<span class="label label-primary">Active</span>';
                    } else if (json[i].loginStatus === '1' && json[i].org_status === "") {
                        var loginStatus = '<span class="label label-danger">Disable</span>';
                    } else {
                        loginStatus = '<span class="label label-danger">' + json[i].org_status + '</span>';
                    }
                    if (json[i].verifyStatus === '1') {
                        verifyStatus = '<span class="label label-primary">Verified</span>';
                    } else {
                        verifyStatus = '<span class="label label-danger">Not-verified</span>';
                    }

                    if (json[i].admin_approved === '1') {
                        orgApproved = '<input type="checkbox" loginId="' + json[i].id + '" value="' + json[i].admin_approved + '"  class="admin_approved option-input" checked >';
                    } else {
                        orgApproved = '<input type="checkbox" loginId="' + json[i].id + '" value="' + json[i].admin_approved + '"  class="admin_approved option-input" >';
                    }
                    if (json[i].orgLatestStatus === '1') {
                        var orgLatestStatus = '<input type="checkbox" Statustype="orgLatestStatus" statusName="Latest Status" orgId="' + json[i].orgId + '" value="' + json[i].orgLatestStatus + '"  class="changeStatus option-input" checked >';
                    } else {
                        var orgLatestStatus = '<input type="checkbox" Statustype="orgLatestStatus" statusName="Latest Status" orgId="' + json[i].orgId + '" value="' + json[i].orgLatestStatus + '"  class="changeStatus option-input" >';
                    }
                    if (json[i].orgTopRated === '1') {
                        orgsTopRated = '<input type="checkbox" Statustype="orgTopRated" statusName="Top Rated Status" orgId="' + json[i].orgId + '" value="' + json[i].orgTopRated + '"  class="changeStatus option-input" checked >';
                    } else {
                        orgsTopRated = '<input type="checkbox" Statustype="orgTopRated" statusName="Top Rated Status" orgId="' + json[i].orgId + '" value="' + json[i].orgTopRated + '"  class="changeStatus option-input" >';
                    }
                    if (json[i].orgFeatureStatus === '1') {
                        var orgFeatureStatus = '<input type="checkbox" Statustype="orgFeatureStatus" statusName="Featured Status" orgId="' + json[i].orgId + '" value="' + json[i].orgFeatureStatus + '"  class="changeStatus option-input" checked >';
                    } else {
                        var orgFeatureStatus = '<input type="checkbox" Statustype="orgFeatureStatus" statusName="Featured Status" orgId="' + json[i].orgId + '" value="' + json[i].orgFeatureStatus + '"  class="changeStatus option-input" >';
                    }

                    oTable.fnAddData([
                        (i + 1),
                        '<a target="_blank" href="<?php echo site_url('superadmin/orgDetails/?id='); ?>' + json[i].orgIdc + '">' + json[i].orgName + '</a>',
                        json[i].orgMobile,
                        json[i].email + '<br>' + json[i].password,
                        json[i].orgAddress,
                        '<select class="login_status" id="' + json[i].id + '"style="background-color:#acd6e9;">\n\
                        <option value="" ' + (json[i].loginStatus === "" ? 'selected' : '') + '>Choose One...</option>\n\
                        <option value="0" ' + (json[i].loginStatus === "Active" ? 'selected' : '') + '>Active</option>\n\
                        <option value="1" ' + (json[i].loginStatus === "Disable" ? 'selected' : '') + '>Disable</option>\n\
                        <option value="Suspended" ' + (json[i].loginStatus === "Suspended" ? 'selected' : '') + '>Suspended</option>\n\
                        <option value="Blacklisted" ' + (json[i].loginStatus === "Blacklisted" ? 'selected' : '') + '>Blacklisted</option>\n\
                        <option value="Payment Due" ' + (json[i].loginStatus === "Payment Due" ? 'selected' : '') + '>Payment Due</option></select>',
                        orgApproved,
                        orgsTopRated,
                        orgLatestStatus,
                        orgFeatureStatus,

                        loginStatus + "<br>" + verifyStatus
                    ]);
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
    });
</script>

<script type="text/javascript">
    $(".treeviewUd_link").addClass("active");
    $(".organicationDetails_link").addClass("active");
    document.title = "iHuntBest | University Details";
</script>