<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <!--<b>Version</b> 1.0.0 (Test)-->
        <strong>Designed &AMP; Developed by<a href="http://starlingsoftwares.com" target="_blank"> Starling Softwares</a></strong>
    </div>
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="#" target="_blank">Starling Softwares</a>.</strong> All rights
    reserved.
</footer>
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script id="jqueryscript" src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.1.4.min.js"></script>
<!--<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>-->
<!--<script src="<?php echo base_url(); ?>plugins/jQuery/jquery-3.2.1.min.js"></script>-->
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jquery.form.js"></script>
<script src="<?php echo base_url(); ?>plugins/jQuery/2.3.64_jquery.form-validator.min.js"></script>

<!-- AdminLTE App -->

<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/app.min.js"></script>
<script src="<?php echo base_url(); ?>js/fontawesome-iconpicker.js"></script>

<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="<?php echo base_url('plugins\summernote\summernote.min.js'); ?>"></script>
<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script type="text/javascript">
    function getCategoryItem(helpId, ctName) {
        $.ajax({
            url: "<?php echo site_url("home/getHelpContent"); ?>",
            type: "POST",
            data: {categories: "category", helpId: helpId},
            success: function (response) {
                if (response !== "") {
                    $("#" + ctName + "" + helpId).html(response);
                } else {
                    $("#" + ctName + "" + helpId).html("No data found.");
                }
                $("#helpmenu").addClass('open');
            },
            error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
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
    $(".helpSearch").keyup(function () {
        var sval = $(this).val();
        if (sval !== "") {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("home/getHelpContent"); ?>",
                data: {searchTerm: sval},
                success: function (response) {
                    if (response !== "") {
                        $("#searchContent").html(response);
                    } else {
                        $("#searchContent").html("No data found.");
                    }
                },
                error: function (jqXHR, exception) {
                    $.alert({
                        title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
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
    });
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("home/siteVisitor"); ?>"
        });
        $.ajax({
            url: "<?php echo site_url("home/getHelpContent"); ?>",
            type: "POST",
            data: {categories: "categories"},
            success: function (response) {
                if (response !== "") {
                    $("#searchCategories").html(response);
                } else {
                    $("#searchCategories").html("No data found.");
                }
            },
            error: function (jqXHR, exception) {
                $.alert({
                    title: 'Error!', content: jqXHR["status"] + " " + exception, type: 'red',
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

    date_time('date_time');
    $(function () {
        $('.numOnly').keydown(function (e) {
            if (e.shiftKey || e.ctrlKey || e.altKey) {
                e.preventDefault();
            } else {
                var key = e.keyCode;
                if (!((key == 8) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                    //if (key > 31 && (key < 48 || key > 57))

                    e.preventDefault();
                }
            }
        });
    });
    $(function () {
        $('.expirey').keydown(function (e) {
            if (e.shiftKey || e.ctrlKey || e.altKey) {
                e.preventDefault();
            } else {
                var key = e.keyCode;
                if (!((key == 8) || (key == 9) || (key == 46) || (key == 191) || (key == 111) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                    //if (key > 31 && (key < 48 || key > 57))
                    //alert(key);
                    e.preventDefault();
                }
            }
        });
    });
</script>
</body>
</html>