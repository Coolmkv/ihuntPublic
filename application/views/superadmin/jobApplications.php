<?php include_once 'superadmin_header.php'; ?>
    <div class="content-wrapper">
        <div class="hidden"></div>
        <section class="content-header">
            <h1>
                Job Applications    
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Super-Admin Dashboard</a></li>
                <li><a href="#">Careers</a></li>
                <li class="active">Job Applications</li>
            </ol>
        </section>
        <section class="content">
            <div class="row box-body">
                <div class="row box-body">
                    <div class="col-md-12">
                        <!-- general form elements --> 
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Job Applications</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table id="data_table" class="table table-bordered table-striped table-responsive">
                                            <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>For Opening</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <th>Resume</th>
                                                <th>Status</th> 
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
    $(".CareersLinkdetails").addClass("active");
    $(".JobapplicationLink").addClass("active");
    document.title  =   "iHuntBest | Add-Show Team Members";
      $(document).ready(function () {
           $.validate({
            lang: 'en'
        }); 
        
        $.ajax({
            type: "POST",
            data: {},
            url: "<?php echo site_url('Superadmin/getJobApplication');?>",
            success: function (response) {
                var resume  =   "";
                var status  =   ""; 
                var impbtn  =   "";
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    
                    impbtn      =   (json[i].isImportant==="0"?'<a href="javascript:" class="important" imp="important" ids="'+json[i].jobapplicationId+'">\n\
                            <i class="fa fa-check-square-o"></i></a>':'<a href="javascript:" class="important" imp="nimportant" ids="'+json[i].jobapplicationId+'"><i class="fa fa-window-close-o"></i></a>');
                    resume      =   '<a target="_blank" href="<?php echo base_url();?>'+json[i].resumeFile+'"  >Resume</a>';
                    status      =   (json[i].isImportant==="0"?'<span class="label label-danger">Not Important</span>':'<span class="label label-primary">Important</span>');
                    oTable.fnAddData([
                        (i + 1),
                        json[i].firstName+" "+json[i].lastName,
                        json[i].openingTitle,
                        json[i].email,
                        json[i].phone,
                        resume, 
                        status,
                        '<a class="delfunction" href="javascript:" del="'+json[i].jobapplicationId+'" title="Delete"><i class="fa fa-trash-o"></i></i></a>&nbsp;&nbsp;'+impbtn
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
        $(document).on("click", ".important", function () {
            var jobapplicationId   =   $(this).attr('ids');
            var important          =   $(this).attr('imp');
             
            $.ajax({
            type: "POST",
            data: {jobapplicationId:jobapplicationId,important:important,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
            url: "<?php echo site_url('Superadmin/markasImportant');?>",
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
                    
        });
        $(document).on("click",".delfunction",function(){
        var jobapplicationId   =   $(this).attr('del');
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
                        data: {jobapplicationId:jobapplicationId,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                        url: "<?php echo site_url('superadmin/delJobApplication');?>",
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