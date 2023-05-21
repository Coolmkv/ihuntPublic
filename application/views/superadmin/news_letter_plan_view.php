<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                News Letter Plan
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">News Letter Plan</a></li>
                <li class="active">Add/Show</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add News Letter Plan</h3>
                        </div>
                        <?php echo form_open('superadmin/addNewsletterplan',["id"=>"nlp_form","name"=>"nlp_form"]);?>
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="no_one" >
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                        <label>Plan Name</label>
                                            <input type="text" name="plan_name" id="plan_name" class="form-control" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>No. of News Letter</label>
                                            <input type="text" name="no_of_news_ltr" id="no_of_news_ltr" class="form-control" data-validation="required">
                                        </div>
                                         <div class="form-group col-md-3">
                                            <label>Price</label>
                                            <input type="text" name="price" id="price" class="form-control" data-validation="required">
                                        </div>
                                         <div class="form-group col-md-3">
                                            <label>Currency</label>
                                            <select name="currencies" id="currencies" class="form-control" data-validation="required"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-md-offset-5">   
                                        <div class="form-group" style="margin-top: 23px">
                                            <label></label>
                                            <input type="submit" class="btn btn-primary" name="save_nlp" id="save_nlp" value="Save">
                                        </div>
                                    </div>
                                </div>
                            </div>
                       <?php form_close();?>
                        <!--/.col -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row box-body">
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">News Letter Plan Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="nlp_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Plan Name</th>                                            
                                            <th>No.of News Letter</th>
                                            <th>Price</th>
                                            <th>Currency</th>
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
    <!-- /.content-wrapper -->
    <!-- Control Sidebar -->
<!-- ./wrapper -->
<?php include 'superadmin_footer.php' ?>
<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        getCurrencies();
         function getCurrencies() {
            $.ajax({
                url: "<?php echo site_url('superadmin/getCurrenciesJson');?>",
                type: 'POST',
                data: '',
                success: function (response) {
                var json = $.parseJSON(response);
                var data = '<option value="">Choose Currencies</option>';
                for (var i = 0; i < json.length; i++) {
                data = data + '<option value="' + json[i].code + '">' + json[i].name + '</option>';
                }
                $('#currencies').html(data);
                }
            });
        }
        $('#save_nlp').click(function () {
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
            };           
            $('#nlp_form').ajaxForm(options);
        });
         $(document).on("click", ".editfunction", function () {
            var nlp_Id   =   $(this).attr('ed');
            $.ajax({
            type: "POST",
            data: {nlp_Id:nlp_Id},
            url: "<?php echo site_url('superadmin/getNewsletterplan');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                $('#id').val(json[0].nlp_Id);
                $('#plan_name').val(json[0].plan_name);
                $('#no_of_news_ltr').val(json[0].no_of_news_ltr);
                $('#price').val(json[0].price);
                $('#currencies').val(json[0].currencies);
                }
            });
        });
        $(document).on("click",".delfunction",function(){
        var nlp_Id   =   $(this).attr('del');
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
                        data: {nlp_Id:nlp_Id,ihuntcsrfToken:'<?php echo get_cookie('ihuntcsrfCookie');?>'},
                        url: "<?php echo site_url('superadmin/delNewsletterplan');?>",
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
                                    }
                                });
                            }
                        }
                    });
                }
            }
            });
        });    
        $.ajax({            
            type: "POST",
            data: {},
            url: "<?php echo site_url('superadmin/getNewsletterplan');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#nlp_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    if (json[i].isactive === '0') {
                        var isactive = '<span class="label label-danger">Disable</span>';
                    }
                    if (json[i].isactive === '1') {
                        var isactive = '<span class="label label-primary">Active</span>';
                    }
                    oTable.fnAddData([
                        (i + 1),
                        json[i].plan_name,
                        json[i].no_of_news_ltr,
                        json[i].price,
                        json[i].currencies,
                        isactive,
                        '<a href="javascript:" ed="'+json[i].nlp_Id+'" class="editfunction" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="delfunction" href="javascript:" del="'+json[i].nlp_Id+'" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
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
    });
</script>
<script type="text/javascript">
    $(".newsltr_plan_AddShow").addClass("active");
    $(".newsltr_plan_Link").addClass("active");
    document.title  =   "iHuntBest | News Letter Plan Details";
</script>