<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Rejected Page Request Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("superadmin/dashboard"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Page Request</a></li>
            <li class="active">Rejected Page Request Details</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row box-body">
            <div class="col-md-12 table-responsive">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Rejected Page Request Details</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="dataTable" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Organization Name</th>
                                            <th>Page Title</th>
                                            <th>Requested On</th>
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
<div class="modal fade" id="pageViewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" style="width: auto;overflow: auto;">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="pageTitle"></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="pageContent">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
        $(document).on("change", ".approvalStatus", function () {
            var pageId = $(this).attr("pageId");
            var approvalStatus = $(this).val();
            var paymentAmount = "";
            var paymentLink = "";
            if (approvalStatus === "askPayment") {
                paymentAmount = window.prompt("Please mention amount", "");
                paymentLink = window.prompt("Please payment Link", "");
                if (paymentAmount === "" || paymentAmount === null) {
                    alert("Please enter payment Amount.");
                    return false;
                }
                if (paymentLink === "" || paymentLink === null) {
                    alert("Please enter payment link.");
                    return false;
                }
            }

            $.ajax({
                type: "POST",
                data: {pageId: pageId, paymentAmount: paymentAmount, paymentLink: paymentLink, approvalStatus: approvalStatus, ihuntcsrfToken: '<?php echo get_cookie('ihuntcsrfCookie'); ?>'},
                url: "<?php echo site_url('superadmin/changeApprovalStatus'); ?>",
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
            data: {pageStatusType: "approval_rejected"},
            url: "<?php echo site_url('superadmin/getPageRequests'); ?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#dataTable').dataTable();
                oTable.fnClearTable();
                var approvalReq = "";
                for (var i = 0; i < json.length; i++) {
                    if (json[i].approvalStatus === 'approval_request') {
                        approvalReq = '<span class="btn btn-sm btn-primary">Requested For Approval</span>';
                    }
                    if (json[i].approvalStatus === 'approval_rejected') {
                        approvalReq = '<span class="btn btn-sm btn-danger">Request Rejected</span>';
                    }
                    if (json[i].approvalStatus === 'approval_accepted') {
                        approvalReq = '<span class="btn btn-sm btn-success">Accepted</span>';
                    }
                    var approvalStatus = '<select class="approvalStatus" pageId="' + json[i].pageId + '"style="background-color:#acd6e9;">\n\
                                                <option ' + (json[i].approvalStatus === '' ? 'selected' : '') + ' value="">Choose One...</option>\n\
                                                <option ' + (json[i].approvalStatus === 'approval_accepted' ? 'selected' : '') + ' value="approval_accepted">Approved</option>\n\
                                                <option ' + (json[i].approvalStatus === 'askPayment' ? 'selected' : '') + ' value="askPayment">Ask Payment</option> \n\
                                                <option ' + (json[i].approvalStatus === 'approval_rejected' ? 'selected' : '') + ' value="approval_rejected">Rejected</option> </select>';

                    oTable.fnAddData([
                        (i + 1),
                        json[i].orgName,
                        '<a href="javascript:" onclick="viewPage(' + json[i].pageId + ');" title="view page">' + json[i].pageName + '</a>',
                        json[i].createdOn,
                        approvalReq,
                        approvalStatus
                    ]);
                }
            }
        });
    });
    function viewPage(pageId) {
        if (pageId !== "") {
            $.ajax({
                type: "POST",
                data: {pageId: pageId, pageStatusType: "approval_rejected"},
                url: "<?php echo site_url('superadmin/getPageRequests'); ?>",
                success: function (response) {
                    if (response !== "") {
                        var json = $.parseJSON(response);
                        $("#pageTitle").html(json.pageName);
                        $("#pageContent").html(json.description);
                        $("#pageViewModal").modal('show');
                    } else {
                        alert("Invalid Request");
                    }
                }
            });
        }

    }
</script>

<script type="text/javascript">
    $(".pageLink").addClass("active");
    $(".rpageReqLink").addClass("active");
    document.title = "iHuntBest | Page Request Rejected Details";
</script>