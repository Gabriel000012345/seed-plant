<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
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
        <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="form_pending" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_pending; ?></h3>
                </div>
                <div class="panel-body">
                    <?php if ($listaAsteptare->num_rows == 0) { echo $text_pending_none; } else { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                                    <th class="text-left"><?php echo $text_idcomanda; ?></th>
                                    <th class="text-left"><?php echo $text_punctridicare; ?></th>
                                    <th class="text-left"><?php echo $text_numedestinatar; ?></th>
                                    <th class="text-left"><?php echo $text_localitatedestinatar; ?></th>
                                    <th class="text-left"><?php echo $text_plicuri; ?></th>
                                    <th class="text-left"><?php echo $text_colete; ?></th>
                                    <th class="text-left"><?php echo $text_greutate; ?></th>
                                    <th class="text-left"><?php echo $text_ramburscash; ?></th>
                                    <th class="text-left"><?php echo $text_ramburscont; ?></th>
                                    <th class="text-left"><?php echo $text_platitor; ?></th>
                                    <td class="text-left" width="50"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaAsteptare->rows as $item) { ?>
                                <tr>
                                    <td><input type="checkbox" name="selected[]" value="<?php echo $item['id']; ?>" /></td>
                                    <td><?php echo $item['order_id']; ?></td>
                                    <td><?php echo $pickups[$item['pickup_id']]['Name'] . ' | '. $pickups[$item['pickup_id']]['LocalityName']; ?></td>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['locality_name'].($item['county_name'] ? ', ' : '').$item['county_name']; ?></td>
                                    <td><?php echo $item['envelopes']; ?></td>
                                    <td><?php echo $item['parcels']; ?></td>
                                    <td><?php echo $item['weight']; ?> kg</td>
                                    <td><?php echo $item['cash_repayment']; ?> lei</td>
                                    <td><?php echo $item['bank_repayment']; ?> lei</td>
                                    <td><?php echo ($item['payer'] == 2 ? $text_destinatar : $text_expeditor); ?></td>
                                    <td class="last">
                                        <a href="<?php echo $item['edit_link']; ?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo $text_edit; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button id="pending_validate" type="button" class="btn btn-primary pull-left"><i class="fa fa-add"></i> <?php echo $text_pending_validate; ?></button>
                        <button id="pending_delete" style="margin-left:5px" type="button" class="btn btn-danger pull-left"><i class="fa fa-add"></i> <?php echo $text_pending_delete; ?></button>
                        <input id="pending_action" type="hidden" name="action" value="" />
                        <script>
                            $(function(){
                                $('#pending_validate, #pending_delete').click(function(){
                                    $('#pending_action').val($(this).attr('id'));
                                    $('#form_pending').submit();
                                    return false;
                                });
                            });
                        </script>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </form>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_validated; ?></h3>
            </div>
            <div class="panel-body">
                <div class="well">
                    <div class="row">
                        <div class="col-sm-4">
                            <form id="form_filter" method="post" action="<?php echo $form_filter_action; ?>">
                                <div class="form-group" style="margin-right: 140px; margin-left:0;">
                                    <label class="control-label" for="input-name" style="margin: 0 0 5px 0; padding:0;"><?php echo $text_pickup; ?></label>
                                    <select name="LocationId" id="urgentcargus_preferinte_pickup" class="form-control">
                                        <?php foreach ($pickups as $pick) { ?>
                                        <?php if ($pick['LocationId'] == $urgentcargus_preferinte_pickup) { ?>
                                        <option value="<?php echo $pick['LocationId']; ?>" selected="selected"><?php echo $pick['Name'].' | '.$pick['LocalityName']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $pick['LocationId']; ?>"><?php echo $pick['Name'].' | '.$pick['LocalityName']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="button" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $text_changepickup; ?></button>
                            </form>
                            <script>
                                $(function () {
                                    $('#button-filter').click(function () {
                                        $('#form_filter').submit();
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <form action="" <?php echo $form_action; ?> " method="post" enctype="multipart/form-data" id="form_validated" class="form-horizontal">
                    <?php if (count($listaValidate) == 0) { echo $text_validated_none; } else { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'awbs\']').prop('checked', this.checked);" /></td>
                                    <th class="text-left"><?php echo $text_idcomanda; ?></th>
                                    <th class="text-left"><?php echo $text_codbara; ?></th>
                                    <th class="text-left"><?php echo $text_costexpeditie; ?></th>
                                    <th class="text-left"><?php echo $text_numedestinatar; ?></th>
                                    <th class="text-left"><?php echo $text_localitatedestinatar; ?></th>
                                    <th class="text-left"><?php echo $text_plicuri; ?></th>
                                    <th class="text-left"><?php echo $text_colete; ?></th>
                                    <th class="text-left"><?php echo $text_greutate; ?></th>
                                    <th class="text-left"><?php echo $text_ramburscash; ?></th>
                                    <th class="text-left"><?php echo $text_ramburscont; ?></th>
                                    <th class="text-left"><?php echo $text_platitor; ?></th>
                                    <th class="text-left"><?php echo $text_status; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaValidate as $item) { ?>
                                <tr>
                                    <td><input type="checkbox" name="awbs[]" value="<?php echo $item['BarCode']; ?>" /></td>
                                    <td><?php echo $item['CustomString']; ?></td>
                                    <td><?php echo $item['BarCode']; ?></td>
                                    <td><?php echo $item['ShippingCost']['GrandTotal']; ?> lei</td>
                                    <td><?php echo $item['Recipient']['Name']; ?></td>
                                    <td><?php echo $item['Recipient']['LocalityName'].($item['Recipient']['CountyName'] ? ', ' : '').$item['Recipient']['CountyName']; ?></td>
                                    <td><?php echo $item['Envelopes']; ?></td>
                                    <td><?php echo $item['Parcels']; ?></td>
                                    <td><?php echo $item['TotalWeight']; ?> kg</td>
                                    <td><?php echo $item['CashRepayment']; ?> lei</td>
                                    <td><?php echo $item['BankRepayment']; ?> lei</td>
                                    <td><?php echo ($item['ShipmentPayer'] == 2 ? $text_destinatar : $text_expeditor); ?></td>
                                    <td class="last"><?php echo $item['Status']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button url="<?php echo $url_print; ?>" id="validated_print" type="button" class="btn btn-primary pull-left"><i class="fa fa-add"></i> <?php echo $text_validated_print; ?></button>
                        <button url="<?php echo $url_order; ?>" id="validated_send" style="margin-left:5px" type="button" class="btn btn-primary pull-left"><i class="fa fa-add"></i> <?php echo $text_validated_send; ?></button>
                        <button id="validated_invalidate" style="margin-left:5px" type="button" class="btn btn-danger pull-left"><i class="fa fa-add"></i> <?php echo $text_validated_invalidate; ?></button>
                        <input id="validated_action" type="hidden" name="action" value="" />
                        <script>
                        $(function(){

                            $('#validated_invalidate').click(function(){
                                $('#validated_action').val($(this).attr('id'));
                                $('#form_validated').submit();
                                return false;
                            });

                            $('#validated_print').click(function(){
                                $('div.alert').remove();
                                var coduri = new Array();
                                $('input[name*=\'awbs\']:checked').each(function(){
                                    coduri.push($(this).val());
                                });
                                if (coduri.length > 0) {
                                    $('.no_awbs_selected').remove();
                                    var coduri_string = '[' + coduri.join(',') + ']';
                                    window.open($(this).attr('url') + "&bar_codes=" + coduri_string, "", "width=900, height=600, left=50, top=50");
                                } else {
                                    $('.container-fluid.pp').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_no_selection; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                }
                                return false;
                            });

                            $('#validated_send').click(function(){
                                window.open($(this).attr('url'), "", "width=900, height=405, left=50, top=50");
                                return false;
                            });

                        });
                        </script>
                    </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>