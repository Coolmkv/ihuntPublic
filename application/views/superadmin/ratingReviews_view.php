<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Rating & Reviews Details
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Rating & Reviews Approvals</a></li>
                <li class="active">Rating & Reviews Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Rating & Reviews Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="showdata_table" class="table table-bordered table-condensed table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Org Name (Type)</th>
                                            <th>Student Name</th>
                                            <th>Ratings</th>
                                            <th>Comment</th>
                                            <th>Rating Date</th>
                                            <th>Approval Status</th>
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

    <div class="control-sidebar-bg"></div>
 
<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
     function appDis(id){
         $.ajax({
            type:"POST",
            data:{ratings_Id:id},
            url:"<?php echo site_url('superadmin/approveDisapprove');?>",
            success: function(response){
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
                                    } });
                            }
            }, 
            error: function(jqXHR, exception){             
                    $.alert({
                            title: 'Error!', content: jqXHR["status"]+" "+ exception, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
         });
     }
     function deleteme(id){
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
                           data: {ratings_Id:id,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                           url: "<?php echo site_url('superadmin/delRating');?>",
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
                                       } });
                               }
                           }
                       });
                   }
               }
               });
     }
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
          
         
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getRatingDetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var approvalStatus      =   "";
                var btns                 =   "";    
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if(json[i].isReviewed==='1'){
                        approvalStatus = '<span class="label label-primary">Approved</span>';
                        btns        =       '<a href="javascript:" class="btn btn-xs btn-danger" onclick="appDis('+json[i].ratings_Id+');">Un-Approve</a>';
                    }else{
                        approvalStatus = '<span class="label label-danger">Not-Approved</span>';
                        btns        =       '<a href="javascript:" class="btn btn-xs btn-primary" onclick="appDis('+json[i].ratings_Id+');">Approve</a>';
                    }
                    btns=   btns+'&nbsp;<a href="javascript:" onclick="deleteme('+json[i].ratings_Id+');"><i class="fa fa-trash"></i></a>';
                    oTable.fnAddData([
                        (i + 1),                         
                        json[i].orgdetails,
                        json[i].studentName,
                        json[i].ratings+'/5',
                        json[i].Comment,
                        json[i].commentDate,
                        approvalStatus,
                        btns
                    ]);
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(".ratingNreview").addClass("active");
    
    document.title  =   "iHuntBest | Rating And Reviews Details";
</script>