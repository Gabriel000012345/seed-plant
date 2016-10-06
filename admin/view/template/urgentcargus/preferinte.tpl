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
    <div class="container-fluid">
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <?php if ($valid) { ?>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-flat" class="form-horizontal">
                    <?php /*
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_price"><?php echo $entry_price; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_price" id="urgentcargus_preferinte_price" class="form-control">
                                <option value="0"><?php echo $text_choose_price; ?></option>
                                <?php foreach ($prices as $price) { ?>
                                    <?php if ($price['PriceTableId'] == $urgentcargus_preferinte_price) { ?>
                                        <option value="<?php echo $price['PriceTableId']; ?>" selected="selected"><?php echo $price['Name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $price['PriceTableId']; ?>"><?php echo $price['Name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    */ ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_pickup"><?php echo $entry_pickup; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_pickup" id="urgentcargus_preferinte_pickup" class="form-control">
                                <option localityId="" value=""><?php echo $text_choose_pickup; ?></option>
                                <?php foreach ($pickups as $pick) { ?>
                                    <?php if ($pick['LocationId'] == $urgentcargus_preferinte_pickup) { ?>
                                        <option localityId="<?php echo $pick['LocalityId']; ?>" value="<?php echo $pick['LocationId']; ?>" selected="selected"><?php echo $pick['Name'].' | '.$pick['LocalityName']; ?></option>
                                    <?php } else { ?>
                                        <option localityId="<?php echo $pick['LocalityId']; ?>" value="<?php echo $pick['LocationId']; ?>"><?php echo $pick['Name'].' | '.$pick['LocalityName']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_insurance"><?php echo $entry_insurance; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_insurance" id="urgentcargus_preferinte_insurance" class="form-control">
                                <option<?php if ($urgentcargus_preferinte_insurance != 1) { ?> selected="selected" <?php } ?> value="0">
                                    <?php echo $text_no; ?></option>
                                    <option<?php if ($urgentcargus_preferinte_insurance == 1) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_yes; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_saturday"><?php echo $entry_saturday; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_saturday" id="urgentcargus_preferinte_saturday" class="form-control">
                                <option<?php if ($urgentcargus_preferinte_saturday != 1) { ?> selected="selected" <?php } ?> value="0">
                                    <?php echo $text_no; ?></option>
                                    <option<?php if ($urgentcargus_preferinte_saturday == 1) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_yes; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_morning"><?php echo $entry_morning; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_morning" id="urgentcargus_preferinte_morning" class="form-control">
                                <option<?php if ($urgentcargus_preferinte_morning != 1) { ?> selected="selected" <?php } ?> value="0">
                                    <?php echo $text_no; ?></option>
                                    <option<?php if ($urgentcargus_preferinte_morning == 1) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_yes; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_openpackage"><?php echo $entry_openpackage; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_openpackage" id="urgentcargus_preferinte_openpackage" class="form-control">
                                <option<?php if ($urgentcargus_preferinte_openpackage != 1) { ?> selected="selected" <?php } ?> value="0">
                                    <?php echo $text_no; ?></option>
                                    <option<?php if ($urgentcargus_preferinte_openpackage == 1) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_yes; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_repayment"><?php echo $entry_repayment; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_repayment" id="urgentcargus_preferinte_repayment" class="form-control">
                                <option<?php if ($urgentcargus_preferinte_repayment != 'bank') { ?> selected="selected" <?php } ?> value="cash">
                                    <?php echo $text_cash; ?></option>
                                    <option<?php if ($urgentcargus_preferinte_repayment == 'bank') { ?> selected="selected" <?php } ?> value="bank"><?php echo $text_bank; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_payer"><?php echo $entry_payer; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_payer" id="urgentcargus_preferinte_payer" class="form-control">
                                <option<?php if ($urgentcargus_preferinte_payer != 'recipient') { ?> selected="selected" <?php } ?> value="sender">
                                    <?php echo $text_sender; ?></option>
                                    <option<?php if ($urgentcargus_preferinte_payer == 'recipient') { ?> selected="selected" <?php } ?> value="recipient"><?php echo $text_recipient; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_type"><?php echo $entry_type; ?></label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_type" id="urgentcargus_preferinte_type" class="form-control">
                                <option<?php if ($urgentcargus_preferinte_type != 'envelope') { ?> selected="selected" <?php } ?> value="parcel">
                                    <?php echo $text_parcel; ?></option>
                                    <option<?php if ($urgentcargus_preferinte_type == 'envelope') { ?> selected="selected" <?php } ?> value="envelope"><?php echo $text_envelope; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_free">
                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_free_details; ?>"><?php echo $entry_free; ?></span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" name="urgentcargus_preferinte_free" id="urgentcargus_preferinte_free" value="<?php echo $urgentcargus_preferinte_free; ?>" placeholder="<?php echo $entry_free; ?>" id="input-cost" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_noextrakm">
                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_noextrakm_details; ?>"><?php echo $entry_noextrakm; ?></span>
                        </label>
                        <div class="col-sm-10">
                            <select name="urgentcargus_preferinte_noextrakm" id="urgentcargus_preferinte_noextrakm" class="form-control">
                                <option<?php if ($urgentcargus_preferinte_noextrakm != 1) { ?> selected="selected" <?php } ?> value="0">
                                    <?php echo $text_no; ?></option>
                                    <option<?php if ($urgentcargus_preferinte_noextrakm == 1) { ?> selected="selected" <?php } ?> value="1"><?php echo $text_yes; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="urgentcargus_preferinte_fixed">
                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_fixed_details; ?>"><?php echo $entry_fixed; ?></span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" name="urgentcargus_preferinte_fixed" id="urgentcargus_preferinte_fixed" value="<?php echo $urgentcargus_preferinte_fixed; ?>" placeholder="<?php echo $entry_fixed; ?>" id="input-cost" class="form-control" />
                        </div>
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>