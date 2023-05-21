<?php include_once 'superadmin_header.php'; ?>
    <div class="content-wrapper">
        <div class="hidden"></div>
        <section class="content-header">
            <h1>
                Add | Remove Blog Categories    
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Super-Admin Dashboard</a></li>
                <li><a href="#">Blogs</a></li>
                <li class="active">Add | Remove Blog Categories</li>
            </ol>
        </section>
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add | Remove Blog Categories</h3>
                        </div>
                        <?php echo form_open("superadmin/insertBlogCategory" ,["id"=>"submit_form"]);?>
                            <div class="box-body">
                                <input type="hidden" name="catId" id="catId" value="no_one" >
                                <div class="form-group col-md-6 col-lg-offset-3 col-sm-12">
                                    <label>Category Name</label>
                                    <input type="text" name="catName" id="catName" class="form-control" data-validation ="required">
                                </div>
                                
                                <div class="col-md-12 text-center">
                                    <input style="margin-top:3px" type="submit" value="Save" class="btn btn-primary" name="save_details" id="save_details">
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
                                <h3 class="box-title">Team Members Details</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table id="data_table" class="table table-bordered table-striped table-responsive">
                                            <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Category Name</th>                                                 
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
    $(".addBlogsCategories").addClass("active");
    $(".blogs").addClass("active");
    document.title  =   "iHuntBest | Add-Show Blog Categories";
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
            url: "<?php echo site_url('Superadmin/getBlogCategories');?>",
            success: function (response) {
                 
                var json = $.parseJSON(response);
                var oTable = $('table#data_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    
                    oTable.fnAddData([
                        (i + 1),
                        json[i].catName, 
                        '<a href="javascript:" ed="'+json[i].catId+'" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                        <a class="delfunction" href="javascript:" del="'+json[i].catId+'" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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
            var catId   =   $(this).attr('ed');
            $.ajax({
            type: "POST",
            data: {catId:catId},
            url: "<?php echo site_url('Superadmin/getBlogCategories');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                $('#catId').val(json[0].catId);
                $('#catName').val(json[0].catName);    
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
        var catId   =   $(this).attr('del');
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
                        data: {catId:catId,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                        url: "<?php echo site_url('superadmin/delBlogCategory');?>",
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