<?php
 $registry = $GLOBALS['registry']; 
 $config = $registry->get('config');
 $currency = $registry->get('currency'); 
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice_ro.css" />
</head>
<body>
<?php $nrord = count($orders); $nract=0; ?>
<?php foreach ($orders as $order) { $nract++; //print_r($order); ?>
<?php
  $pagini = 1;
  $produse_n_comanda = count($order['product']);
  if($produse_n_comanda > $order['pb1']) $pagini = 2;
  if($produse_n_comanda > ($order['pb1'] + $order['pb2'])) $pagini = 3;
  if($produse_n_comanda > ($order['pb1'] + $order['pb2'] + $order['pb3'])) $pagini = 4;
  if($produse_n_comanda > ($order['pb1'] + $order['pb2'] + $order['pb3'] + $order['pb4'])) $pagini = 5;
  if($produse_n_comanda > ($order['pb1'] + $order['pb2'] + $order['pb3'] + $order['pb4'] + $order['pb5'])) $pagini = 6;
  for ($i=1; $i<=$pagini; $i++) {
    $ciclu_pagini[$i] = $i;
  }
?>
<div class="container-fact" <?php if ($nrord != $nract) { ?>style="page-break-after: always;"<?php } ?>>
<?php foreach ($ciclu_pagini as $pagina_curenta) { ?>
  <table class="store" style="font-weight: bold;">
    <tr>
      <td valign="top" width="35%">
        <h3 style="margin: 0px; margin-bottom: 10px;"><?php echo $language_vars['text_vanzator']; ?></h3>
      <?php if (!$config->get('rofactura_afis_furniz')) { ?>
        <?php echo $order['store_name']; ?><br />
        <?php echo $order['store_address']; ?><br />
        <?php echo $text_telephone; ?> <?php echo $order['store_telephone']; ?><br />
        <?php if ($order['store_fax']) { ?>
        <?php echo $text_fax; ?> <?php echo $order['store_fax']; ?><br />
        <?php } ?>
        <?php echo $order['store_email']; ?><br />
        <?php echo $order['store_url']; ?><br />
        <?php echo $config->get('rofactura_date_furnizor') ? html_entity_decode($config->get('rofactura_date_furnizor')) : ''; ?>
      <?php } else { ?>
        <?php echo $config->get('rofactura_date_furnizor') ? html_entity_decode($config->get('rofactura_date_furnizor')) : ''; ?>
      <?php } ?>
      </td>
      <td align="center" valign="top" width="30%">
       <?php if (!$config->get('rofactura_afis_logo')) { ?>
        <?php if ($logo) { ?>
          <a href="<?php echo HTTP_CATALOG; ?>"><img width="200" src="<?php echo $logo; ?>" alt="<?php echo $order['store_name']; ?>" /></a>
        <?php } else { ?>
          <a href="<?php echo HTTP_CATALOG; ?>"><h1><?php echo $order['store_name']; ?></h1></a>
        <?php } ?>
       <?php } ?>
        <h2 style="margin: 0px; margin-bottom: 10px;"><?php echo $language_vars['text_factura']; ?></h2>
        <table class="store_middle" style="text-align: center; width: 100%">
          <?php if ($config->get('rofactura_auto_numar')) { ?>
          <tr>
            <td class="to-right"><b><?php echo $language_vars['text_nrfact']; ?>:</b></td>
            <td class="to-left"><?php echo $config->get('rofactura_serie_factura'); ?> <?php echo $order['auto_number']; ?></td>
          </tr>
          <?php } ?>
          <?php if ($order['invoice_no'] && !$config->get('rofactura_auto_numar')) { ?>
          <tr>
            <td class="to-right"><b><?php echo $language_vars['text_nrfact']; ?>:</b></td>
            <td class="to-left"><?php echo $order['invoice_no']; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td class="to-right"><b><?php echo $language_vars['text_data']; ?>:</b></td>
            <td class="to-left"><?php echo $order['date_added']; ?></td>
          </tr>
          <?php if (!$config->get('rofactura_afis_plata')) { ?>
          <tr>
            <td class="to-right"><b><?php echo $text_payment_method; ?></b></td>
            <td class="to-left"><?php echo $order['payment_method']; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td class="to-right"><b>Pagina:</b></td>
            <td class="to-left"><?php echo $pagina_curenta . ' / ' . $pagini; ?></td>
          </tr>
        </table>
      </td>
      <td align="right" valign="top" width="35%">
        <h3 style="margin: 0px; margin-bottom: 10px;"><?php echo $language_vars['text_cumparator']; ?></h3>
        <?php if (!$order['cumparator']) { ?>
          <?php echo $order['payment_address']; ?><br/>
          <?php if(!$afis_email) echo $order['email'] . '<br/>'; ?>
          <?php if(!$afis_telefon) echo $order['telephone']; ?>
          <?php if ($order['payment_company']) { ?>
            <br/><?php echo $order['payment_company']; ?>
          <?php } ?>
        <?php } else { ?>
          <?php echo nl2br($order['cumparator']); ?>
        <?php } ?>
      </td>
    </tr>
  </table>
 <div class="product-table-wrapper <?php if ($order['factura_anulata']) { ?>anulata<?php } ?>">
  <?php if ($order['factura_anulata']) { ?><div class="anulat">Anulata</div><?php } ?>
  <table class="product<?php if($pagina_curenta != $pagini) { ?> page_break<?php } ?>" style="max-width: 100%;">
    <tr class="heading-prodtab">
      <td class="td-imp-width_m"><b><?php echo $language_vars['text_numar']; ?></b></td>
      <td><b><?php echo $language_vars['text_denumire_produse']; ?></b></td>
      <td class="td-imp-width_m"><b><?php echo $language_vars['text_um']; ?></b></td>
      <td class="td-imp-width_m"><b><?php echo $language_vars['text_cantit']; ?></b></td>
      <td class="td-imp-width"><b><?php if ($show_tva) { ?><?php echo $language_vars['pret_unitar']; ?><?php } else { ?>Pret Unitar<?php } ?><br />-<?php echo $order['moneda']; ?>-</b></td>
      <?php if ($show_tva) { ?><td class="td-imp-width_m"><b><?php echo $language_vars['cota_tva']; ?></b></td><?php } ?>
      <td class="td-imp-width"><b><?php echo $language_vars['text_valoare']; ?><br />-<?php echo $order['moneda']; ?>-</b></td>
      <?php if ($show_tva) { ?><td class="td-imp-width"><b><?php echo $language_vars['text_valoare_tva']; ?><br />-<?php echo $order['moneda']; ?>-</b></td><?php } ?>
    </tr>
    <tr class="heading-prodtab2">
      <td><b>0</b></td>
      <td><b>1</b></td>
      <td><b>2</b></td>
      <td><b>3</b></td>
      <td><b>4</b></td>
      <?php if ($show_tva) { ?><td><b>5</b></td><?php } ?>
      <td><b><?php echo $show_tva ? 6 : 5; ?></b></td>
      <?php if ($show_tva) { ?><td><b>7</b></td><?php } ?>
    </tr>
    <?php if ($pagina_curenta == 1) { 
              $nrcrt = 0;
              $tc_taxe = 0; 
              $s_total = 0; 
              $t9=$t20=$ct20=$ct9=0; 
          }
    if ($pagina_curenta == 1) {
      $product_start = 0;
    } else {
      $product_start = 0;
      for ($j=1; $j<$pagina_curenta; $j++) $product_start += $order['pb'.$j];
    }
    foreach (array_slice($order['product'], $product_start, ($order['pb'.($pagina_curenta)])) as $product) { 
      $nrcrt++; 
    ?>
    <tr class="prow">
      <td class="td-imp-width_m"><?php echo $nrcrt; ?></td>
      <td><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
        <br />
        &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?></td>
      <td class="td-imp-width_m"><?php echo $language_vars['text_bucata']; ?></td>
      <td class="td-imp-width_m"><?php echo $product['quantity']; ?></td>
      <td align="center"><?php echo number_format($product['pret_u'], $zpu, $language_vars['decimal_point'], $language_vars['thousand_point']); ?></td>
      <?php if ($show_tva) { ?><td class="td-imp-width_m"><?php echo $product['cota_tva']; ?></td><?php } ?>
      <td align="center"><?php echo number_format($product['pret_t'], $zv, $language_vars['decimal_point'], $language_vars['thousand_point']); $s_total += $product['pret_t']; ?></td>
      <?php if ($show_tva) { ?><td align="center"><?php echo number_format($product['val_tva'], $zvt, $language_vars['decimal_point'], $language_vars['thousand_point']); $tc_taxe += $product['val_tva']; ?></td><?php } ?>
      <?php 
        if ($product['cota_tva'] == 20) {
          $t20 += $product['pret_t'];
        } else {
          $t9 += $product['pret_t'];
        }
        if (isset($produse_cupon)) {
          if (in_array($product['product_id'] ,$produse_cupon)) {
            if ($product['cota_tva'] == 20) {
              $ct20 += $product['pret_t'];
            } else {
              $ct9 += $product['pret_t'];
            }
          }
        }
      ?>
    </tr>
    <?php } ?>
  <?php if ($pagina_curenta == $pagini) { ?>
    <?php foreach ($order['voucher'] as $voucher) { $nrcrt++; ?>
    <tr>
      <td class="td-imp-width_m"><?php echo $nrcrt; ?></td>
      <td><?php echo $voucher['description']; ?></td>
      <td class="td-imp-width_m"><?php echo $language_vars['text_bucata']; ?></td>
      <td class="td-imp-width_m">1</td>
      <td align="center"><?php echo number_format($voucher['amountnf'], $zpu, $language_vars['decimal_point'], $language_vars['thousand_point']); ?></td>
      <?php if ($show_tva) { ?><td class="td-imp-width_m">0</td><?php } ?>
      <td align="center"><?php echo number_format($voucher['amountnf'], $zv, $language_vars['decimal_point'], $language_vars['thousand_point']); $s_total += $voucher['amountnf']; ?></td>
      <?php if ($show_tva) { ?><td align="center"><?php echo number_format(0, $zvt, $language_vars['decimal_point'], $language_vars['thousand_point']); ?></td><?php } ?>
    </tr>
    <?php } ?>
    <?php $t_taxe = 0; $liv = 0; $subtotal_aditional = 0; $tva_aditional = 0; ?>
    <?php foreach ($order['total'] as $total) { ?>
    <?php if (!in_array($total['code'], array('total', 'tax', 'sub_total'))) { $nrcrt++; ?>
      <?php 
        $totalul_are_tva = isset($setari_total[$total['code']]['tva']) ? $setari_total[$total['code']]['tva'] : 0;
        $totalul_se_aduna = isset($setari_total[$total['code']]['calc']) ? $setari_total[$total['code']]['calc'] : 0;
        $ajusteaza_tva = isset($setari_total[$total['code']]['calc_t']) ? $setari_total[$total['code']]['calc_t'] : 0;
        $metoda_tva = isset($setari_total[$total['code']]['calc_tva']) ? $setari_total[$total['code']]['calc_tva'] : 0;
        
        if ($totalul_are_tva) {
         if (!$metoda_tva) {
          $pret_unitar_total = $currency->format($total['value'], $order['moneda'], $order['moneda_v'], false, $zpu);
          $cota_tva_total = isset($setari_total[$total['code']]['ctva']) ? $setari_total[$total['code']]['ctva'] : 20;
          if ($cota_tva_total != '-') {
            $ctva = $cota_tva_total == 20 ? 0.20 : 0.09;
            $tva_total = $currency->format($total['value']*$ctva , $order['moneda'], $order['moneda_v'], false, $zvt);
          } else {
            $cota_t9 = (isset($produse_cupon) && $total['code'] == 'coupon') ? $ct9/($ct20 + $ct9) : $t9/($t20 + $t9);
            $cota_t20 = 1 - $cota_t9;
            $tva_total = $currency->format(($total['value']*$cota_t9*0.09) + ($total['value']*$cota_t20*0.20), $order['moneda'], $order['moneda_v'], false, $zvt);
          }
         } else {
          $cota_tva_total = isset($setari_total[$total['code']]['ctva']) ? $setari_total[$total['code']]['ctva'] : 20;

          if ($cota_tva_total != '-') {
            $ctva = $cota_tva_total == 20 ? 0.20 : 0.09;
            $pret_unitar_total = $currency->format($total['value']/(1+$ctva), $order['moneda'], $order['moneda_v'], false, $zpu);
            $tva_total = $currency->format($total['value']*($ctva/(1+$ctva)) , $order['moneda'], $order['moneda_v'], false, $zvt);
          } else {
            $cota_t9 = (isset($produse_cupon) && $total['code'] == 'coupon') ? $ct9/($ct20 + $ct9) : $t9/($t20 + $t9);
            $cota_t20 = 1 - $cota_t9;
            $ptu = $total['value'] / (1 + (0.20*$cota_t20 + 0.09*$cota_t9));
            $pret_unitar_total = $currency->format($ptu, $order['moneda'], $order['moneda_v'], false, $zpu);
            $tt = $total['value'] * (0.20*$cota_t20 + 0.09*$cota_t9) / (1 + (0.20*$cota_t20 + 0.09*$cota_t9));
            $tva_total = $currency->format($tt, $order['moneda'], $order['moneda_v'], false, $zvt);
          }
         }
        } else {
          $pret_unitar_total = $currency->format($total['value'], $order['moneda'], $order['moneda_v'], false, $zpu);
          $cota_tva_total = 0;
          $tva_total = 0;
        }

        if ($totalul_se_aduna) $subtotal_aditional += $pret_unitar_total;
        if ($ajusteaza_tva) $tva_aditional += $tva_total;
        //print_r($tva_aditional);
        //subtotal si taxe calculate
        $s_total += $pret_unitar_total;
        $tc_taxe += $tva_total;
      ?>

      <tr class="prow">
        <td class="td-imp-width_m"><?php echo $nrcrt; ?></td>
        <td><?php echo $total['title']; ?></td>
        <td class="td-imp-width_m"><?php echo $language_vars['text_bucata']; ?></td>
        <td class="td-imp-width_m">1</td>
        <td align="center"><?php echo number_format($pret_unitar_total, $zpu, $language_vars['decimal_point'], $language_vars['thousand_point']); ?></td>
        <?php if ($show_tva) { ?><td class="td-imp-width_m"><?php echo $cota_tva_total; ?></td><?php } ?>
        <td align="center"><?php echo number_format($pret_unitar_total, $zv, $language_vars['decimal_point'], $language_vars['thousand_point']); ?></td>
        <?php if ($show_tva) { ?><td align="center"><?php echo number_format($tva_total, $zvt, $language_vars['decimal_point'], $language_vars['thousand_point']); ?></td><?php } ?>
      </tr>
    <?php } ?>
      <?php if ($total['code'] == 'tax') { ?>
        <?php $t_taxe += $total['value']; ?>
      <?php } ?>
    <?php } ?>
    <?php 
      $t_taxe = $currency->format($t_taxe , $order['moneda'], $order['moneda_v'], false)+$tva_aditional; 
      $dif_taxe = $t_taxe - $tc_taxe;
    ?>
    <?php if ($dif_taxe >= 1 || $dif_taxe <= -1) { $nrcrt++; ?>
     <tr class="prow">
      <td class="td-imp-width_m"><?php echo $nrcrt; ?></td>
      <td><?php echo $language_vars['text_dif_taxe']; ?></td>
      <td class="td-imp-width_m"><?php echo $language_vars['text_bucata']; ?></td>
      <td class="td-imp-width_m">1</td>
      <td align="center"><?php echo number_format(0, $zpu, $language_vars['decimal_point'], $language_vars['thousand_point']); ?></td>
      <?php if ($show_tva) { ?><td class="td-imp-width_m">0</td><?php } ?>
      <td align="center"><?php echo number_format(0, $zv, $language_vars['decimal_point'], $language_vars['thousand_point']); ?></td>
      <?php if ($show_tva) { ?><td align="center"><?php echo number_format($dif_taxe,$zvt, $language_vars['decimal_point'], $language_vars['thousand_point']); $tc_taxe += $dif_taxe; ?></td><?php } ?>
     </tr>
    <?php } ?>
    <tr class="spacer">
      <td colspan="<?php echo $show_tva ? 8 : 6; ?>">&nbsp;<br />
        <?php echo $config->get('rofactura_date_legal') ? "<b>".html_entity_decode($config->get('rofactura_date_legal'))."</b>" : ''; ?>
      </td>
    </tr>
    <tr class="wtotals">
      <td colspan="<?php echo $show_tva ? 4 : 3; ?>" rowspan="2" style="padding: 0px; vertical-align: top;">
        
        <div class="date-exp">
          <div class="left">
            <b><?php echo $language_vars['text_semnatura']; ?></b>
          </div>
          <div class="right">
            <?php if (!$config->get('rofactura_afis_dateexp')) { ?>
              <?php echo $language_vars['text_expeditie']; ?> 
              <?php if (!$config->get('rofactura_afis_pdateexp')) { ?>
                <?php echo $order['shipping_method']; ?>
              <?php } else { ?>
                ............
              <?php } ?>
              <br />
            <?php } ?>
            <?php if (!$config->get('rofactura_afis_delegat')) { ?>
              <?php echo $language_vars['text_delegat']; ?> 
              <?php if (!$config->get('rofactura_afis_ndelegat')) { ?>
                <?php echo $order['client']; ?>
              <?php } else { ?>
                ............
              <?php } ?>
              <br />
              <?php echo $language_vars['text_delegat_extra']; ?>
              <br />
            <?php } ?>
            <?php if (!$config->get('rofactura_afis_datetransp')) { ?>
              <?php echo $language_vars['text_transport_extra']; ?>
            <?php } ?>
              <br />
              <br />
              <br />
              <br />
          </div>
        </div>
      </td>
      <td colspan="2" class="bbold" align="right"><?php echo $language_vars['text_stotal']; ?></td>
          <td class="td-imp-width bbold" align="center">
           <?php if (!$config->get('rofactura_calctotal')) { ?>
            <?php foreach ($order['total'] as $total) { ?>
              <?php if ($total['code'] == 'sub_total') { ?>
                <?php echo number_format($currency->format($total['value'] , $order['moneda'], $order['moneda_v'], false, $zst) + $subtotal_aditional,$zst, $language_vars['decimal_point'], $language_vars['thousand_point']); ?>
              <?php } ?>
            <?php } ?>
           <?php } else { ?>
                <?php echo number_format($s_total,$zst, $language_vars['decimal_point'], $language_vars['thousand_point']); ?>
           <?php } ?>
          </td>
          <?php if ($show_tva) { ?><td class="td-imp-width bbold" align="center">
           <?php if (!$config->get('rofactura_calctotal')) { ?>
            <?php $taxe = 0; ?>
            <?php foreach ($order['total'] as $total) { ?>
              <?php if ($total['code'] == 'tax') { ?>
                <?php $taxe += $total['value']; ?>
              <?php } ?>
            <?php } ?>
            <?php echo number_format($currency->format($taxe , $order['moneda'], $order['moneda_v'], false, $zst)+$tva_aditional, $zst, $language_vars['decimal_point'], $language_vars['thousand_point']); ?>
           <?php } else { ?>
            <?php echo number_format($tc_taxe, $zst, $language_vars['decimal_point'], $language_vars['thousand_point']); ?>
           <?php } ?>
          </td><?php } ?>
    </tr>
    <tr  class="wtotals">
       <td colspan="<?php echo $show_tva ? 1 : 2; ?>" class="bbold" valign="top" align="center"><?php echo $language_vars['text_sprim']; ?></td>
       <?php if ($show_tva) { ?><td colspan="1" class="bbold"><?php echo $language_vars['text_ptotal']; ?></td><?php } ?>
          <td colspan="<?php echo $show_tva ? 2 : 1; ?>" align="center" class="bbold">
           <?php if (!$show_tva) { ?><span style="font-weight: normal; font-size: 11px;"><?php echo $language_vars['text_ptotal']; ?></span><br /><?php } ?>
           <?php if (!$config->get('rofactura_calctotal')) { ?>
            <?php foreach ($order['total'] as $total) { ?>
              <?php if ($total['code'] == 'total') { ?>
                <?php echo number_format($currency->format($total['value'] , $order['moneda'], $order['moneda_v'], false, $zt), $zt, $language_vars['decimal_point'], $language_vars['thousand_point']); ?>
              <?php } ?>
            <?php } ?>
           <?php } else { ?>
                <?php echo number_format($s_total+$tc_taxe, $zt, $language_vars['decimal_point'], $language_vars['thousand_point']); ?>
           <?php } ?>
          </td>
    </tr>
  <?php } ?>
  </table>
 </div>
<?php } ?>
</div>
<?php } ?>
</body>
</html>