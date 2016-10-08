<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-flat" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid pp">
        <?php if ($success) { ?>
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($error) { ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-flat" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_pending; ?></h3>
                </div>
                <div class="panel-body">
                    <?php if ($awb->num_rows == 0) { echo $text_no_data; } else { ?>
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2">
                                    <h4 style="font-weight:bold; margin:0;"><?php echo $text_sender; ?></h4>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_pickup; ?></td>
                                <td>
                                    <select class="form-control" name="pickup_id">
                                        <?php foreach ($pickups as $pick) { ?>
                                            <?php if ($pick['LocationId'] == $awb->row['pickup_id']) { ?>
                                                <option value="<?php echo $pick['LocationId']; ?>" selected="selected"><?php echo $pick['Name'].' | '.$pick['LocalityName']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $pick['LocationId']; ?>"><?php echo $pick['Name'].' | '.$pick['LocalityName']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h4 style="font-weight:bold; margin:0;"><?php echo $text_recipient; ?></h4>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_name; ?></td>
                                <td><input class="form-control" type="text" name="name" value="<?php echo $awb->row['name']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_county; ?></td>
                                <td>
                                    <select class="form-control" name="zone_id">
                                        <?php foreach ($judete as $judet) { ?>
                                            <?php if ($judet['code'] == $awb->row['county_name']) { ?>
                                                <option zone_id="<?php echo $judet['zone_id']; ?>" value="<?php echo $judet['code']; ?>" selected="selected"><?php echo $judet['name']; ?></option>
                                            <?php } else { ?>
                                                <option zone_id="<?php echo $judet['zone_id']; ?>" value="<?php echo $judet['code']; ?>"><?php echo $judet['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_locality; ?></td>
                                <td>
                                <select class="form-control" name="city">
                                    <?php foreach ($localitati as $localitate) { ?>
                                        <?php if (trim(strtolower($localitate['Name'])) == trim(strtolower($awb->row['locality_name']))) { ?>
                                            <option value="<?php echo $localitate['Name']; ?>" selected="selected"><?php echo $localitate['Name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $localitate['Name']; ?>"><?php echo $localitate['Name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_address; ?></td>
                                <td><textarea class="form-control" name="address"><?php echo $awb->row['address']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_contact; ?></td>
                                <td><input class="form-control" type="text" name="contact" value="<?php echo $awb->row['contact']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_phone; ?></td>
                                <td><input class="form-control" type="text" name="phone" value="<?php echo $awb->row['phone']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_email; ?></td>
                                <td><input class="form-control" type="text" name="email" value="<?php echo $awb->row['email']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h4 style="font-weight:bold; margin:0;"><?php echo $text_details; ?></h4>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_parcels; ?></td>
                                <td><input class="form-control" type="text" name="parcels" value="<?php echo $awb->row['parcels']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_envelopes; ?></td>
                                <td><input class="form-control" type="text" name="envelopes" value="<?php echo $awb->row['envelopes']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_weight; ?></td>
                                <td><input class="form-control" type="text" name="weight" value="<?php echo $awb->row['weight']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_value; ?></td>
                                <td><input class="form-control" type="text" name="value" value="<?php echo $awb->row['value']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_cash_repayment; ?></td>
                                <td><input class="form-control" type="text" name="cash_repayment" value="<?php echo $awb->row['cash_repayment']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_bank_repayment; ?></td>
                                <td><input class="form-control" type="text" name="bank_repayment" value="<?php echo $awb->row['bank_repayment']; ?>"></input></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_other_repayment; ?></td>
                                <td><textarea class="form-control" name="other_repayment"><?php echo $awb->row['other_repayment']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_payer; ?></td>
                                <td>
                                    <select class="form-control" name="payer">
                                        <option<?php if ($awb->row['payer'] != 2) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_sender; ?></option>
                                        <option<?php if ($awb->row['payer'] == 2) { ?> selected="selected" <?php } ?> value="2"><?php echo $text_recipient; ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_morning_delivery; ?></td>
                                <td>
                                    <select class="form-control" name="morning_delivery">
                                        <option<?php if ($awb->row['morning_delivery'] != 1) { ?> selected="selected" <?php } ?> value="0"><?php echo $text_no; ?></option>
                                        <option<?php if ($awb->row['morning_delivery'] == 1) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_yes; ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_saturday_delivery; ?></td>
                                <td>
                                    <select class="form-control" name="saturday_delivery">
                                        <option<?php if ($awb->row['saturday_delivery'] != 1) { ?> selected="selected" <?php } ?> value="0"><?php echo $text_no; ?></option>
                                        <option<?php if ($awb->row['saturday_delivery'] == 1) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_yes; ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_openpackage; ?></td>
                                <td>
                                    <select class="form-control" name="openpackage">
                                        <option<?php if ($awb->row['openpackage'] != 1) { ?> selected="selected" <?php } ?> value="0"><?php echo $text_no; ?></option>
                                        <option<?php if ($awb->row['openpackage'] == 1) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_yes; ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_observations; ?></td>
                                <td><textarea class="form-control" name="observations"><?php echo $awb->row['observations']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_contents; ?></td>
                                <td><textarea class="form-control" name="contents"><?php echo $awb->row['contents']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_shipping_method; ?></td>
                                <td>
                                    <select class="form-control" name="shipping_code">
                                        <option<?php if ($awb->row['shipping_code'] != 'urgent.franciza') { ?> selected="selected" <?php } ?> value="urgent.destinatie"><?php echo $text_urgent_destinatie; ?></option>
                                        <option<?php if ($awb->row['shipping_code'] == 'urgent.franciza') { ?> selected="selected" <?php } ?> value="urgent.franciza"><?php echo $text_urgent_franciza; ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function(){
        function do_replace() {
            var element = null;
            if ($("input[name='city']").length) {
                element = $("input[name='city']");
            }
            if ($("select[name='city']").length) {
                element = $("select[name='city']");
            }
            var attr_name = element.attr('name');
            var attr_class = element.attr('class');
            var attr_id = element.attr('id');
            var value = element.val();

            if ($('select[name="zone_id"]').val().length > 0) {
                $.post('../index.php?route=module/urgentcargus/localitati&judet=' + $('select[name="zone_id"]').find('option:selected').attr('zone_id') + '&val=' + value, function (data) {
                    element.replaceWith('<select name="' + attr_name + '" class="' + attr_class + '" id="' + attr_id + '">' + data + '</select>');
                });
            } else {
                element.replaceWith('<input type="text" name="' + attr_name + '" class="' + attr_class + '" id="' + attr_id + '" value="' + value + '" />');
            }
        }

        $('select[name="zone_id"]').change(function(){
            do_replace();
        });
    });
</script>
<?php echo $footer; ?>