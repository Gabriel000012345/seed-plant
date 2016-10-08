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
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <?php if ($valid) { ?>

                <?php if ($zone == 'orders') { ?>

                <div class="well">
                    <div class="row">
                        <div class="col-sm-4">
                            <form id="form_filter" method="get" action="">
                                <div class="form-group" style="margin-right: 140px;">
                                    <label class="control-label" for="input-name"><?php echo $text_pickup; ?></label>

                                    <input type="hidden" name="route" value="urgentcargus/istoric"></input>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>"></input>
                                    <select name="LocationId" id="urgent_preferinte_pickup" class="form-control">
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

                <?php if (count($orders) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text-left"><?php echo $text_idcomanda; ?></td>
                                <td class="text-left"><?php echo $text_datavalidare; ?></td>
                                <td class="text-left"><?php echo $text_intervalridicare; ?></td>
                                <td class="text-left"><?php echo $text_dataprocesare; ?></td>
                                <td class="text-left"><?php echo $text_awburi; ?></td>
                                <td class="text-left"><?php echo $text_plicuri; ?></td>
                                <td class="text-left"><?php echo $text_colete; ?></td>
                                <td class="text-left"><?php echo $text_greutate; ?></td>
                                <td class="text-left"><?php echo $text_status; ?></td>
                                <td class="text-left" width="50"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $item) { ?>
                            <tr>
                                <td class="text-left"><?php echo $item['OrderId']; ?></td>
                                <td class="text-left"><?php echo $item['ValidationDate'] ? date('d.m.Y', strtotime($item['ValidationDate'])) : '-'; ?></td>
                                <td class="text-left"><?php echo $item['PickupStartDate'] ? date('d.m.Y H:i', strtotime($item['PickupStartDate']))  . ' - ' . date('H:i', strtotime($item['PickupEndDate'])) : '-'; ?></td>
                                <td class="text-left"><?php echo $item['ProcessedDate'] ? date('d.m.Y', strtotime($item['ProcessedDate'])) : '-'; ?></td>
                                <td class="text-left"><?php echo $item['NoAwb']; ?></td>
                                <td class="text-left"><?php echo $item['NoEnvelop']; ?></td>
                                <td class="text-left"><?php echo $item['NoParcel']; ?></td>
                                <td class="text-left"><?php echo $item['TotalWeight']; ?> kg</td>
                                <td class="text-left"><?php echo $item['OrdStatus']; ?></td>
                                <td class="text-right">
                                    <a href="<?php echo $view_url; ?>&LocationId=<?php echo $urgentcargus_preferinte_pickup; ?>&OrderId=<?php echo $item['OrderId']; ?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="<?php echo $text_view; ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div style="color:#999; font-size:11px; padding:10px 0;">Sunt afisate ultimele 100 de comenzi efectuate pentru punctul curent de ridicare. Pentru comenzile anterioare, va rugam sa consultati pagina Urgent Cargus</div>
                </div>
                <?php } else { ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> <?php echo $text_noresults; ?>
                </div>
                <?php } ?>

                <?php } elseif ($zone == 'awb_details') { ?>

                <?php if (is_array($detaliuAwb)) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="headings"><th colspan="2" class="no-link last"><?php echo $text_awb_expeditor; ?></th></tr>
                            <tr><td width="150"><?php echo $text_awb_nume; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['Name'] ? $detaliuAwb['Sender']['Name'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_judet; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['CountyName'] ? $detaliuAwb['Sender']['CountyName'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_localitate; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['LocalityName'] ? $detaliuAwb['Sender']['LocalityName'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_strada; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['StreetName'] ? $detaliuAwb['Sender']['StreetName'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_numar; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['BuildingNumber'] ? $detaliuAwb['Sender']['BuildingNumber'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_adresa; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['AddressText'] ? $detaliuAwb['Sender']['AddressText'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_perscontact; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['ContactPerson'] ? $detaliuAwb['Sender']['ContactPerson'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_telefon; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['PhoneNumber'] ? $detaliuAwb['Sender']['PhoneNumber'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_email; ?></td><td class="last"><?php echo $detaliuAwb['Sender']['Email'] ? $detaliuAwb['Sender']['Email'] : '-'; ?></td></tr>

                            <tr class="headings"><th colspan="2" class="no-link last"><?php echo $text_awb_destinatar; ?></th></tr>
                            <tr><td><?php echo $text_awb_nume; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['Name'] ? $detaliuAwb['Recipient']['Name'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_judet; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['CountyName'] ? $detaliuAwb['Recipient']['CountyName'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_localitate; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['LocalityName'] ? $detaliuAwb['Recipient']['LocalityName'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_strada; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['StreetName'] ? $detaliuAwb['Recipient']['StreetName'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_numar; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['BuildingNumber'] ? $detaliuAwb['Recipient']['BuildingNumber'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_adresa; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['AddressText'] ? $detaliuAwb['Recipient']['AddressText'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_perscontact; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['ContactPerson'] ? $detaliuAwb['Recipient']['ContactPerson'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_telefon; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['PhoneNumber'] ? $detaliuAwb['Recipient']['PhoneNumber'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_email; ?></td><td class="last"><?php echo $detaliuAwb['Recipient']['Email'] ? $detaliuAwb['Recipient']['Email'] : '-'; ?></td></tr>

                            <tr class="headings"><th colspan="2" class="no-link last"><?php echo $text_awb_detaliiawb; ?></th></tr>
                            <tr><td><?php echo $text_awb_codbara; ?></td><td class="last"><?php echo $detaliuAwb['BarCode'] ? $detaliuAwb['BarCode'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_plicuri; ?></td><td class="last"><?php echo $detaliuAwb['Envelopes'] ? $detaliuAwb['Envelopes'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_colete; ?></td><td class="last"><?php echo $detaliuAwb['Parcels'] ? $detaliuAwb['Parcels'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_greutate; ?></td><td class="last"><?php echo $detaliuAwb['TotalWeight'] ? $detaliuAwb['TotalWeight'] : '-'; ?> kg</td></tr>
                            <tr><td><?php echo $text_awb_valoaredeclarata; ?></td><td class="last"><?php echo $detaliuAwb['DeclaredValue'] ? $detaliuAwb['DeclaredValue'] : '0'; ?> lei</td></tr>
                            <tr><td><?php echo $text_awb_rambursnumerar; ?></td><td class="last"><?php echo $detaliuAwb['CashRepayment'] ? $detaliuAwb['CashRepayment'] : '0'; ?> lei</td></tr>
                            <tr><td><?php echo $text_awb_ramburscont; ?></td><td class="last"><?php echo $detaliuAwb['BankRepayment'] ? $detaliuAwb['BankRepayment'] : '0'; ?> lei</td></tr>
                            <tr><td><?php echo $text_awb_rambursalt; ?></td><td class="last"><?php echo $detaliuAwb['OtherRepayment'] ? $detaliuAwb['OtherRepayment'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_deschidere; ?></td><td class="last"><?php echo $detaliuAwb['OpenPackage'] ? $text_da : $text_nu; ?></td></tr>
                            <tr><td><?php echo $text_awb_livraresambata; ?></td><td class="last"><?php echo $detaliuAwb['SaturdayDelivery'] ? $text_da : $text_nu; ?></td></tr>
                            <tr><td><?php echo $text_awb_livraredimineata; ?></td><td class="last"><?php echo $detaliuAwb['MorningDelivery'] ? $text_da : $text_nu; ?></td></tr>
                            <tr><td><?php echo $text_awb_plataexpeditie; ?></td><td class="last"><?php echo $detaliuAwb['ShipmentPayer'] == 1 ? $text_awb_expeditor : $detaliuAwb['ShipmentPayer'] == 2 ? $text_awb_destinatar : $text_awb_tert; ?></td></tr>
                            <tr><td><?php echo $text_awb_observatii; ?></td><td class="last"><?php echo $detaliuAwb['Observations'] ? $detaliuAwb['Observations'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_continut; ?></td><td class="last"><?php echo $detaliuAwb['PackageContent'] ? $detaliuAwb['PackageContent'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_awb_serieclient; ?></td><td class="last"><?php echo $detaliuAwb['CustomString'] ? $detaliuAwb['CustomString'] : '-'; ?></td></tr>
                            <tr><td><?php echo $text_status; ?></td><td class="last"><?php echo $detaliuAwb['Status'] ? $detaliuAwb['Status'] : '-'; ?></td></tr>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> <?php echo $text_nodata; ?>
                </div>
                <?php } ?>

                <?php } else { ?>

                <?php if (count($awbs) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text-left"><?php echo $text_serieclient; ?></td>
                                <td class="text-left"><?php echo $text_numarawb; ?></td>
                                <td class="text-left"><?php echo $text_numedestinatar; ?></td>
                                <td class="text-left"><?php echo $text_localitatedestinatar; ?></td>
                                <td class="text-left"><?php echo $text_plicuri; ?></td>
                                <td class="text-left"><?php echo $text_colete; ?></td>
                                <td class="text-left"><?php echo $text_greutate; ?></td>
                                <td class="text-left"><?php echo $text_cost; ?></td>
                                <td class="text-left"><?php echo $text_datavalidare; ?></td>
                                <td class="text-left"><?php echo $text_status; ?></td>
                                <td class="text-left" width="50"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($awbs as $item) { ?>
                            <tr>
                                <td class="text-left"><?php echo $item['CustomString']; ?></td>
                                <td class="text-left"><?php echo '<a target="_blank" style="text-decoration:none; color:#000;" href="https://www.urgentcargus.ro/Private/Tracking.aspx?CodBara='.$item['BarCode'].'">'.$item['BarCode'].'</a>'; ?></td>
                                <td class="text-left"><?php echo $item['Recipient']['Name']; ?></td>
                                <td class="text-left"><?php echo $item['Recipient']['LocalityName']; ?></td>
                                <td class="text-left"><?php echo $item['Envelopes']; ?></td>
                                <td class="text-left"><?php echo $item['Parcels']; ?></td>
                                <td class="text-left"><?php echo $item['TotalWeight']; ?></td>
                                <td class="text-left"><?php echo $item['ShippingCost']['GrandTotal']; ?></td>
                                <td class="text-left"><?php echo $item['ValidationDate'] ? date('d.m.Y', strtotime($item['ValidationDate'])) : '-'; ?></td>
                                <td class="text-left"><?php echo $item['Status']; ?></td>
                                <td class="text-right">
                                    <a href="<?php echo $view_url; ?>&LocationId=<?php echo $urgentcargus_preferinte_pickup; ?>&OrderId=<?php echo $OrderId; ?>&BarCode=<?php echo $item['BarCode']; ?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="<?php echo $text_viewawb; ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php echo $text_noresultsawb; ?>
                </div>
                <?php } ?>

                <?php } ?>

                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>