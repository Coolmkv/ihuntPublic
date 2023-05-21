<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Stream Details
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Masters</a></li>
        <li class="active">Stream Details</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row box-body">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php if(isset($cname)){echo $cname;}else{echo "Course Name";}?></h3>
                </div>&nbsp;&nbsp;<a href="javascript:" ocname="<?php if(isset($ocname)){echo $ocname;}?>" id="goBackCDetails">Go back to Course Details</a>
                <?php echo form_open('Superadmin/addStream' ,["id"=>"stream_form","name"=>"stream_form"]);?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Stream Name</label>
                                    <input type="text" name="title" id="title" class="form-control" data-validation="required">
                                    <input type="hidden" name="cId" id="cId" class="form-control" value="<?php if(isset($cId)){echo $cId;} ?>" data-validation="required">

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="save_stream" id="save_stream" value="Save">
                                </div>
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
                    <h3 class="box-title">Stream Details</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="stream_table" class="table table-bordered table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Stream</th>
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
<script type="text/javascript">
    function deleteStream(streamId){
        $.confirm({
            title: 'Warning!',
            content: "Are you sure to delete?",
            type: 'red',
            typeAnimated: true,
            buttons: {
                Cancel: function () {
                    //window.location.href = 'stream?cId=<?php //echo $cId; ?>';
                },
                Confirm: function () {
                    $.ajax({
                        type: "POST",
                        data: "streamId=" + streamId,
                        url: "<?php echo site_url('superadmin/deleteStream');?>",
                        success: function (response) {
                            var json = $.parseJSON(response);
                            if (json.status === 'success') {
                                $.alert({title: 'Success!', content: json.msg, type: 'blue',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                             streamTable();
                                        }
                                    }
                                });
                            } else {
                                $.alert({title: 'Error!', content: json.msg, type: 'red',
                                    typeAnimated: true });
                            }
                        }
                    });
                }
            }
            });
        }
        streamTable();
        function streamTable(){
                var ihuntcsrfToken  =   $('input[name="ihuntcsrfToken"]').val();
                var cId = '<?php if(isset($cId)){echo $cId;}else{echo '0';} ?>';

            $.ajax({
                type: "POST",
                url: "<?php echo site_url("superadmin/getStreamDetails");?>",
                data:{ihuntcsrfToken:ihuntcsrfToken,cId:cId},
                success: function (response) {
                    var json = $.parseJSON(response);
                    var oTable = $('table#stream_table').dataTable();
                    oTable.fnClearTable();
                    for (var i = 0; i < json.length; i++) {
                        oTable.fnAddData([
                            (i + 1),
                            json[i].title,
                            '<a href="javascript:" class="editStream" cId="'+json[i].cId+'" streamId="'+json[i].streamId+'" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" onclick="deleteStream(\'' + json[i].streamId + '\');"   title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                        ]);
                    }
                }
            });
        }
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on("click",".editStream",function(){
            var streamId    = $(this).attr('streamId');
        $.ajax({
            type: "POST",
            data: "streamId=" + streamId,
            url: "<?php echo site_url("superadmin/getStreamDetails");?>",
            success: function (response) {
                var json = $.parseJSON(response);
                $('#id').val(json[0].streamId);
                $('#title').val(json[0].title);
            }
            });
        });
        
         
        $(document).on("click","#goBackCDetails",function(){
                var ctId    =   '<?php if(isset($ctId)){echo $ctId;}?>';
                var cname   =   $(this).attr("ocname");
                $.ajax({
                    type: "POST",
                    data: {ctId:ctId,cname:cname},
                    url: "<?php echo site_url('superadmin/getcourse_details');?>",
                    success: function (response) { 
                        $("#maindivContent").html("");
                        $("#maindivContent").html(response);
                    }
                });
        });
        
        

        $('#save_stream').click(function () {
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
                                   streamTable();
                                   $("#id").val("no_one");
                                   $("#title").val("");
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {                                    
                                   streamTable();
                                   $("#id").val("no_one");
                                   $("#title").val("");
                                }
                            } });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#stream_form').ajaxForm(options);
        });
    });
</script>