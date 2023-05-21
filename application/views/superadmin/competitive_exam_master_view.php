<?php include_once 'superadmin_header.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="hidden"><?php echo $map["html"];?></div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Competitive Exam Master
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('superadmin/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#">Masters</a></li>
                <li class="active">Competitive Exam Master</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row box-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Competitive Exam Details</h3>
                        </div>
                        <?php echo form_open('Superadmin/addCompetitveExamDetails' ,["id"=>"deatils_form","name"=>"deatils_form"]);?>
                         
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id" value="no_one">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select id="countryId" name="countryId" class="form-control">                                                 
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Exam Name</label>
                                            <input type="text" name="exam_name" id="exam_name_id" class="form-control" placeholder="Exam Name *" data-validation="required">                                    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Marking System</label>
                                            <input type="text" name="marking_system" id="marking_system_id" class="form-control" title="eg: Grade,Marks" placeholder="Grade,Marks etc. *" data-validation="required">                                    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Validity Time</label>
                                            <input type="text" name="validity_time" title="Exam Score Validity in Months" id="validity_time_id" placeholder="Exam Score Validity in Months" class="form-control" data-validation="required">                                    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                           <label>Type of Exam</label>
                                           <select id="typeOfexam_id" name="typeOfexam" class="form-control" data-validation="required">
                                                <option value="">Select</option>
                                                <option value="Entrance">Entrance</option>
                                                <option value="Scholarship">Scholarship</option>
                                                <option value="Both">Both</option> 
                                            </select>                             
                                       </div>
                                   </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" style="margin-top: 23px">
                                            <label></label>
                                            <input type="submit" class="btn btn-primary" name="save_details" id="save_details" value="Register">
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
                <div class="col-md-12 table-responsive">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Competitive Exam Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="showdata_table" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Country</th>
                                            <th>Exam Name</th>
                                            <th>Marking System</th>
                                            <th>Validity Time</th>
                                            <th>Type of Exam</th> 
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
    function deleteEnrty(id)
    { 
         
        var Id = id;
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
                        data: {Id:Id},
                        url: "<?php echo site_url('superadmin/delCompetitiveExam');?>",
                        success: function (response) {
                            var json = $.parseJSON(response);
                            if (json.status === 'success') {
                                $.alert({
                                    title: 'Success!', content: json.msg, type: 'blue',
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
                                    typeAnimated: true,
                                });
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
         
        $(document).on('click', '.editAction', function () {
            var Id = $(this).attr('ctId');
            $.ajax({
                type: "POST",
                data: "id=" + Id,
                url: "<?php echo site_url('superadmin/getCompetitiveExamDetails');?>",
                success: function (response) {
                    var json = $.parseJSON(response); 
                        $('#id').val(json[0].c_exam_id);
                        $('#countryId').val(json[0].country_id);
                        $('#exam_name_id').val(json[0].exam_name);
                        $('#marking_system_id').val(json[0].marking_system);
                        $('#validity_time_id').val(json[0].exam_valid_for);  
                        $('#typeOfexam_id').val(json[0].exam_type);                          
                }
            });
        });
        $.ajax({
            type: "POST",
            data: "",
            url: "<?php echo site_url('superadmin/getCompetitiveExamDetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                var oTable = $('table#showdata_table').dataTable();
                oTable.fnClearTable();
                for (var i = 0; i < json.length; i++) {
                    oTable.fnAddData([
                        (i + 1),
                        json[i].name,
                        json[i].exam_name,
                        json[i].marking_system,
                        json[i].exam_valid_for+' Months',
                        json[i].exam_type, 
                        '<a href="javascript:"   ctId="' + json[i].c_exam_id + '" class="editAction"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteEnrty(\''+ json[i].c_exam_id +'\');" title="Delete"><i class="fa fa-trash-o"></i></i></a>'
                    ]);
                }
            }
        });

        $('#save_details').click(function () {
            var options = {
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    var json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $.alert({
                            title: 'Success!', content: json.msg, type: 'blue',
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
                            typeAnimated: true,
                            buttons: {
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#deatils_form').ajaxForm(options);
        });
        getCountries();
        
        function getCountries() {
            $.ajax({
                url: "<?php echo site_url("home/getCountriesJson");?>",
                type: 'POST',
                data: '',
                success: function (response) {
                    var json = $.parseJSON(response);
                    var data = '<option value="">Choose Country</option>';
                    for (var i = 0; i < json.length; i++) {
                        data = data + '<option value="' + json[i].countryId + '">' + json[i].name + '</option>';
                    }
                    $('#countryId').html(data); 
                }
            });
        }
    });
</script>

<script type="text/javascript">
    $(".admin_item").addClass("active");
    $(".competitiveexam_link").addClass("active");
    document.title  =   "iHuntBest | Competitve Exam Master";
</script>