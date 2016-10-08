<?php echo $header; ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
$(function() {
    $('#datepicker').datepicker({
        minDate: 0,
        firstDay: 1,
        dateFormat: 'dd.mm.yy',
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0), ''];
        }
    });

    $('#datepicker').change(function(){
        window.location = "<?php echo html_entity_decode($url_validate); ?>" + "&date=" + $(this).val();
    });

    $('select[name="hour_from"]').change(function(){
        window.location = "<?php echo html_entity_decode($url_validate); ?>" + "&date=" + $('#datepicker').val() + "&hour=" + $(this).val();
    });
});
</script>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1><?php echo $heading_title; ?></h1>
        </div>
    </div>
    <div class="box">
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $choose_pickup_date; ?></h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo $url_send; ?>" method="post" enctype="multipart/form-data" id="form">
                        <input class="form-control" name="date" type="text" id="datepicker" value="<?php echo $date; ?>" style="width:200px; float:left; margin-right:10px;" />
                        <select class="form-control" name="hour_from" style="width:90px; float:left; margin-right:10px;">
                            <?php echo $h_dela; ?>
                        </select>
                        <select class="form-control" name="hour_to" style="width:90px; float:left; margin-right:10px;">
                            <?php echo $h_panala; ?>
                        </select>
                        <a onclick="$('#form').submit();" class="btn btn-primary"><?php echo $button_sendorder; ?></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<style>
    * {
        font-size: 12px;
        font-family: Arial;
    }

    select {
        padding: 2px;
    }

    #content {
        min-width: initial;
        padding: 30px;
    }

    .box > .content {
        min-height: initial;
    }
</style>
<?php echo $footer; ?>