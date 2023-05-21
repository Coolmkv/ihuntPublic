<?php include_once 'superadmin_header.php'; ?>
    <div class="content-wrapper">
        <div class="hidden"></div>
        <section class="content-header">
            <h1>
                Add | Remove Career Details    
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Super-Admin Dashboard</a></li>
                <li><a href="#">Career Details</a></li>
                <li class="active">Add | Remove Career Details</li>
            </ol>
        </section>
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add | Remove Career Details</h3>
                        </div>
                        <?php echo form_open("superadmin/addRemoveCarrerDetails" ,["id"=>"submit_form"]);?>
                            <div class="box-body">
                                <input type="hidden" name="openingId" id="openingId" value="no_one" > 
                                <div class="form-group col-md-12 col-sm-12">
                                    <label>Opening Title</label>
                                    <input type="text" name="openingTitle" id="openingTitle" class="form-control" data-validation ="required">
                                </div>                                
                                <div class="form-group col-md-12 col-sm-12">
                                    <label>Opening Details</label>
                                    <textarea name="openingDetails" id="openingDetails" class="form-control summernote"  data-validation ="required"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input style="margin-top:3px" type="submit" value="Save" class="btn btn-primary" name="save_details" 
                                           id="save_details">
                                </div>
                            </div>
                        <?php  echo form_close();?>
                    </div>
                </div>
                <div class="row box-body">
                    <div class="col-md-12">
                        <!-- general form elements --> 
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Career Details</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table id="data_table" class="table table-bordered table-striped table-responsive">
                                            <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Opening Title</th>
                                                <th>Opening Details</th>
                                                <th>Created Date</th>
                                                <th>Closing Status</th>
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
    $(".CareersLink").addClass("active");
    $(".CareersLinkdetails").addClass("active");
    document.title  =   "iHuntBest | Add-Show Career Details";
      $(document).ready(function () {
           $.validate({
            lang: 'en'
        }); 
        $('.summernote').summernote();
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
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('Superadmin/getOpeningDetails');?>",
            success: function (response) {
                var closestatus = "";
                var cobtn       =  "";
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {                     
                    if(json[i].isClosed==='0'){
                        closestatus   =   '<span class="label label-primary">Open</span>';
                        cobtn         =   '<a class="closeOpenfunction" actn="close" href="javascript:" tid="'+json[i].openingId+'" title="Close"><i class="fa fa-envelope"></i></i></a>';
                    }else{
                        closestatus   =   '<span class="label label-danger">Closed</span>';
                        cobtn         =   '<a class="closeOpenfunction" actn="open" href="javascript:" tid="'+json[i].openingId+'" title="Open"><i class="fa fa-envelope-open"></i></i></a>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].openingTitle,
                        json[i].openingDetails,
                        json[i].createdDate,
                        closestatus,
                        '<a href="javascript:" ed="'+json[i].openingId+'" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                        <a class="delfunction" href="javascript:" del="'+json[i].openingId+'" title="Delete"><i class="fa fa-trash-o"></i></i></a>&nbsp;&nbsp;&nbsp;\n\
                        '+cobtn
                    ]);
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
            $(document).on("click", ".editfunction", function () {
            var planid   =   $(this).attr('ed');
            $.ajax({
            type: "POST",
            data: {planid:planid},
            url: "<?php echo site_url('Superadmin/getOpeningDetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                $('#openingId').val(json[0].openingId);
                $('#openingTitle').val(json[0].openingTitle);
                $('#openingDetails').summernote("code",json[0].openingDetails); 
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
        var openingId   =   $(this).attr('del');
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
                        data: {openingId:openingId,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                        url: "<?php echo site_url('superadmin/delOpeningDetails');?>",
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
        });
        $(document).on("click",".closeOpenfunction",function(){
        var openingId   =   $(this).attr('tid');
        var actn        =   $(this).attr('actn');
        if(actn==='close'){
            var content =   "Are you sure to Close this opening?";
        }else{
            var content =   "Are you sure to Open this opening?";
        }
         $.confirm({
            title: 'Warning!',
            content: content,
            type: 'red',
            typeAnimated: true,
            buttons: {
                Cancel: function () {
                    window.location.reload();
                },
                Confirm: function () {
                    $.ajax({
                        type: "POST",
                        data: {openingId:openingId,actn:actn,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                        url: "<?php echo site_url('superadmin/closeOpenOpeningDetails');?>",
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
        });
    });
 </script>