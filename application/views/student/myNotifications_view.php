<?php include_once 'student_header.php'; ?>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            My Notifications
            <!--<small>Optional description </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student');?>"><i class="fa fa-dashboard"></i>Student Dashboard</a></li>
            <li class="active">View Notifications</li>
        </ol>
    </section>                <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row box-body">                 
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">My Notifications</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="details_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Message</th>
                                            <th>Sent From</th>
                                            <th>In Reference</th>
                                            <th>Notification Status</th>
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
            </div>    
        
    </section>
    <!-- /.content -->
</div>
  
<?php include_once 'student_footer.php';?>
<script>
 
$(".myApplLink").addClass("active");
document.title  =   "iHuntBest | My Applications";

    $('#details_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
		     "url": "<?php echo site_url('student/getNotifications') ?>",
		     "dataType": "json",
		     "type": "POST",
                     "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                },
	    "columns": [
		          { "data": "MessageId" },
		          { "data": "Message" },
                          { "data": "SentBy" },
        		  { "data": "InRefence" },
                          { "data": "NotificationStatus" } 
                       ],
            "columnDefs": [
                    {
                        "targets": [-1, 4],
                        "orderable": false
                    }
                ],
                               
              error: function(jqXHR, exception){                   
                            $.alert({
                                    title: 'Error!', content: jqXHR["status"]+" - "+ exception, type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    }
                            });
                            }
	    });
   
 
</script>
