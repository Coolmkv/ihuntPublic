<?php include_once 'superadmin_header.php'; ?> 
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Promocode Price Master
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Promocode</a></li>
                <li class="active">Promocode Price Master</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <?php echo form_open("superadmin/addPromocodeMasterDetails" ,["id"=>"submit_form"]); ?>
                            <div class="box-body">                                
                                <input type="hidden" name="promocodeId" id="promocodeId" value="no_one" >                                
                                <div class="form-group col-md-5">
                                    <label>Promocode Price</label>
                                    <input type="number" name="price" min="0" id="price" class="form-control" data-validation ="required">
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Applicable</label>
                                    <input type="checkbox" name="isApplicable" value="1" id="isApplicable" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label></label>
                                    <input style="margin-top:3px" type="submit" value="Save" class="form-control btn btn-primary" name="save_details" id="save_details">
                                </div>
                            </div>
                        <?php  echo form_close();?>
                    </div>
                    <!--/.col -->
                </div>
                <div class="row box-body">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Promocode Price Details</h3>
                            </div>

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table id="dataTable" class="table table-bordered table-striped table-responsive">
                                            <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Price</th> 
                                                <th>AddedOn</th>
                                                <th>UpdateOn</th>
                                                <th>IsApplicable</th>
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
        $.ajax({
            type: "POST", 
            url: "<?php echo site_url('Superadmin/getPromocodeMasterDetails');?>",
            success: function (response) {
                 
                var json    =   $.parseJSON(response);
                var oTable  =   $('table#dataTable').dataTable();
                var status  =   "";
                var btn     =   "";
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].isApplicable === "1") {
                        status = '<span class="label label-primary">Active</span>';
                        btn    =    '&nbsp;<a class="activeDeactive btn btn-danger btn-xs" ed="'+json[i].promocodeId+'" val="0" href="javascript:" >Deactivate</a>';
                    } else if (json[i].isApplicable === "0") {
                        status = '<span class="label label-danger">Disable</span>';
                        btn    =    '&nbsp;<a class="activeDeactive btn btn-success btn-xs" ed="'+json[i].promocodeId+'" val="1" href="javascript:" >Activate</a>';
                    
                    }
                     
                    oTable.fnAddData([
                        (i + 1),
                        json[i].price,
                        json[i].aDate, 
                        json[i].uDate,
                        status,
                        '<a href="javascript:" ed="'+json[i].promocodeId+'" class="editfunction" title="Edit">\n\
                            <i class="fa fa-edit"></i></i></a>\n\
                            &nbsp;&nbsp;&nbsp;&nbsp;\n\
                            <a class="delfunction" href="javascript:" del="'+json[i].promocodeId+'" title="Delete">\n\
                            <i class="fa fa-trash-o"></i></i></a>'+btn
                    ]);
                }
            }
        });
        $(document).on("click",".editfunction",function () {
            var promocodeId   =   $(this).attr('ed');
            $.ajax({
            type: "POST",
            data: {promocodeId:promocodeId},
            url: "<?php echo site_url('Superadmin/getPromocodeMasterDetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                $('#promocodeId').val(json[0].promocodeId);
                $('#price').val(json[0].price);
                (json[0].isApplicable==="1"?$("#isApplicable").prop('checked',true):$("#isApplicable").prop('checked',false));
                    }, error: function(jqXHR, exception){                   
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
        });
        $(document).on("click",".delfunction",function(){
        var promocodeId   =   $(this).attr('del');
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
                        data: {promocodeId:promocodeId,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                        url: "<?php echo site_url('superadmin/delPromoCode');?>",
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
                        }, error: function(jqXHR, exception){                   
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
                }
            }
            });
        });
        $(document).on("click", ".activeDeactive", function () {
            var promocodeId = $(this).attr("ed");
            var value = $(this).attr("val");
            $.ajax({
                type: "POST",
                data: {promocodeId:promocodeId,value:value,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                url: '<?php echo site_url('superadmin/activeDeactive');?>',
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
                }, error: function(jqXHR, exception){                   
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
        });

        $('#save_details').click(function () {
            $.validate({
                lang: 'en'
            });

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
                            typeAnimated: true,buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            } });
                    }
                }, error: function(jqXHR, exception){                   
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
            };
            $('#submit_form').ajaxForm(options);
        });
    });
</script>

<script type="text/javascript">
    $(".pcmaster").addClass("active");     
    document.title  =   "iHuntBest | Promocode Price Master";
</script>