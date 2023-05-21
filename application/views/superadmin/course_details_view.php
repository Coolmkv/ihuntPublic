<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        University Course Name
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url("superadmin/dashboard");?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Masters</a></li>
        <li class="active">University Course Name</li>
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
                </div>&nbsp;&nbsp;<a href="<?php echo site_url("superadmin/univCoursesMaster");?>">Go back to Course Type</a>
                <?php echo form_open('Superadmin/addCourse' ,["id"=>"course_form","name"=>"course_form"]);?>
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="no_one">
                            <input type="hidden" name="ctId" id="ctId" class="form-control" value="<?php if(isset($ctId)){ echo $ctId;}?>" data-validation="required">

                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group">
                                    <label>Course Name</label>
                                    <input type="text" name="title" id="title" class="form-control" data-validation="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 22px">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="add_course" id="add_course" value="Save">
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
                    <h3 class="box-title">University Course Name</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="course_table"
                                   class="table table-bordered table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Course Name</th>
                                    <th>Add Stream</th>
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

<script type="text/javascript">
    $(document).ready(function () {
        $.validate({
            lang: 'en'
        });
        $(document).on("click",".editcourse",function(){
        var cId     =   $(this).attr('cId');
        var ctId    =   $(this).attr('ctId');
        $.ajax({
            type: "POST",
            data: "ctId=" + ctId+"&cId="+cId,
            url: "<?php echo site_url('superadmin/getCoursedetails');?>",
            success: function (response) {
                var json = $.parseJSON(response);
                $('#id').val(json[0].cId);
                $('#title').val(json[0].title);
            }
            });    
        });
        $(document).on("click",".delcourse",function(){
        var cId     =   $(this).attr('cId');
        $.confirm({
            title: 'Warning!',
            content: "Are you sure to delete?",
            type: 'red',
            typeAnimated: true,
            buttons: {
                Cancel: function () {
                     dataTable();
                },
                Confirm: function () {
                    $.ajax({
                        type: "POST",
                        data: "cId=" + cId,
                        url: "<?php echo site_url('superadmin/delCoursedetails');?>",
                        success: function (response) {
                            var json = $.parseJSON(response);
                            if (json.status === 'success') {
                                $.alert({title: 'Success!', content: json.msg, type: 'blue',
                                    typeAnimated: true,
                                    buttons: {
                                        Ok: function () {
                                            dataTable();
                                        }
                                    }
                                });
                            } else {
                                $.alert({title: 'Error!', content: json.msg, type: 'red',
                                    typeAnimated: true, });
                            }
                        }
                    });
                }
            }
            });
        });
         dataTable();
        function dataTable(){
        var ctId = '<?php if(isset($ctId)){echo $ctId;}else{echo '0';} ?>';
        var ihuntcsrfToken  =   $('input[name="ihuntcsrfToken"]').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('superadmin/getCoursedetails');?>",
                    data: {ctId:ctId,ihuntcsrfToken:ihuntcsrfToken},
                    success: function (response) {
                        var json = $.parseJSON(response);
                        var oTable = $('table#course_table').dataTable();
                        oTable.fnClearTable();
                        for (var i = 0; i < json.length; i++) {
                            oTable.fnAddData([
                                (i + 1),
                                json[i].title,
                                '<a href="javascript:" cId="'+json[i].cId+'" class="streamDetails" courseName="'+json[i].title+'" courseType="<?php if(isset($cname)){echo $cname;}else{echo "Course Name";}?>" title="Edit"><i class="fa fa-plus"></i></a>',
                                '<a href="javascript:" class="editcourse" ctId="'+json[i].ctId+'"  cId="'+json[i].cId+'" title="Edit"><i class="fa fa-edit"></i></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" ctId="'+json[i].ctId+'"  cId="'+json[i].cId+'" class="delcourse" title="Delete"><i class="fa fa-trash-o"></i></i></a>',
                            ]);
                        }
                    }
                });

        }
        $(document).on("click",".streamDetails",function(){
            var courseType  =   $(this).attr("courseType");
            var courseName  =   $(this).attr("courseName");
            var cId         =   $(this).attr("cId");
            var ihuntcsrfToken  =   $('input[name="ihuntcsrfToken"]').val();
            var ctId = '<?php if(isset($ctId)){echo $ctId;}else{echo '0';} ?>';
            $.ajax({
                type: "POST",
                data: {courseType:courseType,courseName:courseName,cId:cId,ctId:ctId,ihuntcsrfToken:ihuntcsrfToken},
                url: "<?php echo site_url('superadmin/loadStream_details');?>",
                success: function (response) { 
                    $("#maindivContent").html(response);
                }
            });
        });
        $('#add_course').click(function () {
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
                                    dataTable();
                                    $('#title').val("");
                                }
                            }
                        });
                    } else {
                        $.alert({title: 'Error!', content: json.msg, type: 'red',
                            typeAnimated: true });
                    }
                },
                error: function (response) {
                    $('#error').html(response);
                }
            };
            $('#course_form').ajaxForm(options);
        });
    });
</script>
