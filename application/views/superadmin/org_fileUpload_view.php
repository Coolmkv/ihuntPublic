<?php include_once 'superadmin_header.php';?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Upload Files of Organization
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('superadmin/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Register</a></li>
                <li class="active"> Upload Files of Organization</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content"> 
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Upload Files of Organization</h3>
                        </div> 
                        <div class="box-body">
                            <?php echo form_open_multipart('superadmin/uploadexcel',["id"=>"form_upload","name"=>"form_upload"]);?>
                                <div class="row">
                                     
                                    <div class="col-md-6 col-md-offset-2">
                                        <div class="form-group">
                                            <label>Upload File</label>
                                            <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="orgexcel" id="orgexcel" class="form-control" data-validation="required"> 

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="margin-top: 23px">
                                            <label></label>
                                            <input type="submit" class="btn btn-primary" name="save_data" id="save_data" value="Save">
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                            </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Download Sample</label>
                                    <a download="Organisation Registraion From" href="<?php echo base_url('excelfiles\exceldownloads\Organisation Registraion From.xlsx');?>">Sample Excel</a>
                                    <p>All details should be in a perfect order as in the sample.</p>
                                </div>
                            </div>
                            
                        </div>

                        <!--/.col -->
                    </div>
                </div>
            </div>
            <!-- /.row -->

            

        </section>

        <!-- /.content -->

    </div>
<?php include_once 'superadmin_footer.php';?>
<script>
document.title  =   "iHuntBest | Upload excel";
$(document).ready(function(){
    
        $('#save_data').click(function () {

            var options = {
                beforeSend: function () { 
                },
                success: function (response) {
                    console.log(response);
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
            $('#form_upload').ajaxForm(options);
        });
});
</script>