<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-rofactura" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-rofactura">
        <table class="table table-stripped table-hover">
          <tr>
            <td style="width: 25%">
              Afiseaza logo-ul magazinului in factura
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_logo">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_logo) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Afiseaza metoda de plata pe factura
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_plata">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_plata) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Platitor de TVA
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_tva">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_tva) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Afiseaza telefon cumparator
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_telefon">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_telefon) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Afiseaza email cumparator
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_email">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_email) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Afiseaza tara cumparator
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_tara">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_tara) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Genereaza numarul facturii automat (in functie de urmatoarele 2 setari setare)<br /><span style="font-size: 11px; color: #999">Daca selectati NU, numarul facturii va fi cel al comenzii</span>
            </td>
            <td>  
              <select class="form-control" name="rofactura_auto_numar">
                <option value="0">NU</option>
                <option value="1" <?php if ($rofactura_auto_numar) { ?>selected="selected"<?php } ?>>DA</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Serie Factura
            </td>
            <td>  
              <input name="rofactura_serie_factura" class="form-control" value="<?php echo $rofactura_serie_factura ? $rofactura_serie_factura : 'Factura'; ?>" />
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Numar de start Facturi
            </td>
            <td>  
              <input name="rofactura_nr_factura" class="form-control" value="<?php echo $rofactura_nr_factura; ?>" />
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Date Furnizor / Extra Date Furnizor (suporta HTML)
            </td>
            <td>  
              <textarea name="rofactura_date_furnizor" style="width: 100%; height: 100px; box-sizing: border-box; border-radius: 3px"><?php echo html_entity_decode($rofactura_date_furnizor); ?></textarea>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Afisare date furnizor
              <br /><span style="font-size: 11px; color: #999">In aceasta instanta "Implicit" = Numele magazinului din setari, adresa, telefonul.<br/>Ca alternativa puteti scrie mai sus toate detaliile ce le doriti a fi afisate.</span>
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_furniz">
                <option value="0">Implicit + Datele de mai sus</option>
                <option value="1" <?php if ($rofactura_afis_furniz) { ?>selected="selected"<?php } ?>>Doar datele de mai sus</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Afiseaza livrarea pe factura <br />
              <span style="font-size: 11px; color: #999">Daca pretul livrarii este diferit de 0 atunci trebuie afisata pentru ca totalurile sa fie corecte</span>
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_livrare">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_livrare) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              Pretul livrari are TVA asociat
            </td>
            <td>  
              <select class="form-control" name="rofactura_livrare_areTVA">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_livrare_areTVA) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              Afiseaza date privind expeditia
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_dateexp">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_dateexp) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              La date privind expeditia afiseaza
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_pdateexp">
                <option value="0">Metoda de livrare</option>
                <option value="1" <?php if ($rofactura_afis_pdateexp) { ?>selected="selected"<?php } ?>>.....(puncte, puncte)</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              Afiseaza Delegat
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_delegat">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_delegat) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              La Delegat afiseaza
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_ndelegat">
                <option value="0">Numele Clietului</option>
                <option value="1" <?php if ($rofactura_afis_ndelegat) { ?>selected="selected"<?php } ?>>.....(puncte, puncte)</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              Afiseaza Date despre transport (cu .....)
            </td>
            <td>  
              <select class="form-control" name="rofactura_afis_datetransp">
                <option value="0">DA</option>
                <option value="1" <?php if ($rofactura_afis_datetransp) { ?>selected="selected"<?php } ?>>NU</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Text afisat deasupra totalurilor
              <br /><span style="font-size: 11px; color: #999">Exemplu: "Conform art. 155 alin. (28) din Legea nr. 571/2003 privind Codul fiscal, factura este valabila fara semnatura si stampila"</span>
            </td>
            <td>  
              <textarea name="rofactura_date_legal" style="width: 100%; height: 100px; box-sizing: border-box; border-radius: 3px"><?php echo html_entity_decode($rofactura_date_legal); ?></textarea>
            </td>
          </tr>
          <tr>
            <td>
              Valoare Total, subtotal si taxe:
              <br /><span style="font-size: 11px; color: #999">In opencart calculele sunt realizate cu 4 zecimale insa de obicei monezile sunt configurate sa afiseze pana la 2 zecimale. Din acest motiv categodata pot exista micro diferente de 1-2 bani intre suma reala a preturilor afisate cu 2 zecimale si total/subtotal. Aici aveti oportunitatea de a corecta acest lucru in factura prin calcularea totalului si subtotalului prin insumarea preturile afisate. Insa in aceasta situatie veti avea o micro diferenta intre totalul facturii si totalul comenzii afisat la detaliile comenzii. Orice varianta alegeti e ok, diferenta este oricum foarte mica si nesemnificativa.</span>
            </td>
            <td>  
              <select class="form-control" name="rofactura_calctotal">
                <option value="0">Asa cum apare in detaliile comenzii cu ajustare de subtotal daca e nevoie</option>
                <option value="1" <?php if ($rofactura_calctotal) { ?>selected="selected"<?php } ?>>Calculate in factura</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Numere de zecimale (introduceti numere intre 0 si 4)
            </td>
            <td>  
              Pret unitar:
              <input type="text" class="form-control" name="rofactura_zec_pu" value="<?php echo $rofactura_zec_pu ? $rofactura_zec_pu : 2; ?>" />
              Valoare:
              <input type="text" class="form-control" name="rofactura_zec_v" value="<?php echo $rofactura_zec_v ? $rofactura_zec_v : 2; ?>" />
              Valoare TVA:
              <input type="text" class="form-control" name="rofactura_zec_vt" value="<?php echo $rofactura_zec_vt ? $rofactura_zec_vt : 2; ?>" />
              Subtotaluri:
              <input type="text" class="form-control" name="rofactura_zec_st" value="<?php echo $rofactura_zec_st ? $rofactura_zec_st : 2; ?>" />
              Total:
              <input type="text" class="form-control" name="rofactura_zec_t" value="<?php echo $rofactura_zec_t ? $rofactura_zec_t : 2; ?>" />
            </td>
          </tr>
          <tr>
            <td style="width: 25%">
              Setari totaluri
            </td>
            <td>  
              <table class="table table-stripped table-hover"> 
                  <tr>
                    <td style="width: 14%; background: #eee">Nume</td>
                    <td style="width: 14%; background: #eee">Ordine</td>
                    <td style="width: 14%; background: #eee">Se calculeaza TVA</td>
                    <td style="width: 14%; background: #eee">Ce cota de TVA are?</td>
                    <td style="width: 14%; background: #eee">Calculare TVA</td>
                    <td style="width: 14%; background: #eee">Ajusteaza tva-ul (conteaza doar atunci cand afisati totalurile originale si nu cele calculate)</td>
                    <td style="width: 14%; background: #eee">Ajusteaza subtotalul (conteaza doar atunci cand afisati totalurile originale si nu cele calculate)</td>
                  </tr>
                <?php foreach ($extensii_total as $total) { ?>
                 <?php if(in_array($total['codename'], array('total', 'tax', 'sub_total'))) { ?>
                  <tr>
                    <td style="color: #aaa"> 
                      <?php echo $total['name']; ?>
                    </td>
                    <td style="color: #aaa"> 
                      <?php echo $total['sort_order']; ?>
                    </td>
                    <td style="color: #aaa"> 
                      --
                    </td>
                    <td style="color: #aaa"> 
                      --
                    </td>
                    <td style="color: #aaa"> 
                      --
                    </td>
                    <td style="color: #aaa"> 
                      --
                    </td>
                    <td style="color: #aaa"> 
                      --
                    </td>
                  </tr>
                 <?php } else { ?>
                  <tr>
                    <td> 
                      <?php echo $total['name']; ?>
                    </td>
                    <td> 
                      <?php echo $total['sort_order']; ?>
                    </td>
                    <td> 
                      <select class="form-control" name="rofactura_setari_total[<?php echo $total['codename']; ?>][tva]">
                        <option value="0" <?php if (isset($rofactura_setari_total[$total['codename']]['tva']) && !$rofactura_setari_total[$total['codename']]['tva']) { ?>selected="selected"<?php } ?>>Nu</option>
                        <option value="1" <?php if (isset($rofactura_setari_total[$total['codename']]['tva']) && $rofactura_setari_total[$total['codename']]['tva']) { ?>selected="selected"<?php } ?>>Da</option>
                      </select>
                    </td>
                    <td> 
                      <select class="form-control" name="rofactura_setari_total[<?php echo $total['codename']; ?>][ctva]">
                        <option value="20" <?php if (isset($rofactura_setari_total[$total['codename']]['ctva']) && !$rofactura_setari_total[$total['codename']]['ctva']) { ?>selected="selected"<?php } ?>>20%</option>
                        <option value="9" <?php if (isset($rofactura_setari_total[$total['codename']]['ctva']) && $rofactura_setari_total[$total['codename']]['ctva'] == 9) { ?>selected="selected"<?php } ?>>9%</option>
                        <option value="-" <?php if (isset($rofactura_setari_total[$total['codename']]['ctva']) && $rofactura_setari_total[$total['codename']]['ctva'] == '-') { ?>selected="selected"<?php } ?>>-</option>
                      </select>
                    </td>
                    <td> 
                      <select class="form-control" name="rofactura_setari_total[<?php echo $total['codename']; ?>][calc_tva]">
                        <option value="0" <?php if (isset($rofactura_setari_total[$total['codename']]['calc_tva']) && !$rofactura_setari_total[$total['codename']]['calc_tva']) { ?>selected="selected"<?php } ?>>Adaugat</option>
                        <option value="1" <?php if (isset($rofactura_setari_total[$total['codename']]['calc_tva']) && $rofactura_setari_total[$total['codename']]['calc_tva']) { ?>selected="selected"<?php } ?>>Substras</option>
                      </select>
                    </td>
                    <td> 
                      <select class="form-control" name="rofactura_setari_total[<?php echo $total['codename']; ?>][calc_t]">
                        <option value="0" <?php if (isset($rofactura_setari_total[$total['codename']]['calc_t']) && !$rofactura_setari_total[$total['codename']]['calc_t']) { ?>selected="selected"<?php } ?>>Nu</option>
                        <option value="1" <?php if (isset($rofactura_setari_total[$total['codename']]['calc_t']) && $rofactura_setari_total[$total['codename']]['calc_t']) { ?>selected="selected"<?php } ?>>Da</option>
                      </select>
                    </td>
                    <td> 
                      <select class="form-control" name="rofactura_setari_total[<?php echo $total['codename']; ?>][calc]">
                        <option value="0" <?php if (isset($rofactura_setari_total[$total['codename']]['calc']) && !$rofactura_setari_total[$total['codename']]['calc']) { ?>selected="selected"<?php } ?>>Nu</option>
                        <option value="1" <?php if (isset($rofactura_setari_total[$total['codename']]['calc']) && $rofactura_setari_total[$total['codename']]['calc']) { ?>selected="selected"<?php } ?>>Da</option>
                      </select>
                    </td>
                  </tr>
                 <?php } ?>
                <?php } ?>
              </table>
            </td>
          </tr>
          

          <tr>
            <td colspan="2">
              <h2> Setari campuri custom in functie de grupul de clienti</h2>
            </td>
          </tr>

          <?php foreach ($customer_groups as $group) { ?>
            <tr>
            <td>
              <?php echo $group['name']; ?>
            </td>
            <td>  
              Client:
              <select class="form-control" name="rofactura_custom_fields_settings[<?php echo $group['customer_group_id']; ?>][client]">
                <option value="0">Implicit (Nume Client)</option>
                <?php foreach ($group['custom_fields'] as $field) { ?>
                  <option value="<?php echo $field['custom_field_id']; ?>" <?php if (isset($rofactura_custom_fields_settings[$group['customer_group_id']]['client']) && $rofactura_custom_fields_settings[$group['customer_group_id']]['client'] == $field['custom_field_id']) { ?>selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
                <?php } ?>
              </select>
              CNP:
              <select class="form-control" name="rofactura_custom_fields_settings[<?php echo $group['customer_group_id']; ?>][cnp]">
                <option value="0">Nu e cazul</option>
                <?php foreach ($group['custom_fields'] as $field) { ?>
                  <option value="<?php echo $field['custom_field_id']; ?>" <?php if (isset($rofactura_custom_fields_settings[$group['customer_group_id']]['cnp']) && $rofactura_custom_fields_settings[$group['customer_group_id']]['cnp'] == $field['custom_field_id']) { ?>selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
                <?php } ?>
              </select>
              CIF:
              <select class="form-control" name="rofactura_custom_fields_settings[<?php echo $group['customer_group_id']; ?>][cif]">
                <option value="0">Nu e cazul</option>
                <?php foreach ($group['custom_fields'] as $field) { ?>
                  <option value="<?php echo $field['custom_field_id']; ?>" <?php if (isset($rofactura_custom_fields_settings[$group['customer_group_id']]['cif']) && $rofactura_custom_fields_settings[$group['customer_group_id']]['cif'] == $field['custom_field_id']) { ?>selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
                <?php } ?>
              </select>
              Reg. Com.:
              <select class="form-control" name="rofactura_custom_fields_settings[<?php echo $group['customer_group_id']; ?>][regcom]">
                <option value="0">Nu e cazul</option>
                <?php foreach ($group['custom_fields'] as $field) { ?>
                  <option value="<?php echo $field['custom_field_id']; ?>" <?php if (isset($rofactura_custom_fields_settings[$group['customer_group_id']]['regcom']) && $rofactura_custom_fields_settings[$group['customer_group_id']]['regcom'] == $field['custom_field_id']) { ?>selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
                <?php } ?>
              </select>
              IBAN:
              <select class="form-control" name="rofactura_custom_fields_settings[<?php echo $group['customer_group_id']; ?>][iban]">
                <option value="0">Nu e cazul</option>
                <?php foreach ($group['custom_fields'] as $field) { ?>
                  <option value="<?php echo $field['custom_field_id']; ?>" <?php if (isset($rofactura_custom_fields_settings[$group['customer_group_id']]['iban']) && $rofactura_custom_fields_settings[$group['customer_group_id']]['iban'] == $field['custom_field_id']) { ?>selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
                <?php } ?>
              </select>
              Banca:
              <select class="form-control" name="rofactura_custom_fields_settings[<?php echo $group['customer_group_id']; ?>][banca]">
                <option value="0">Nu e cazul</option>
                <?php foreach ($group['custom_fields'] as $field) { ?>
                  <option value="<?php echo $field['custom_field_id']; ?>" <?php if (isset($rofactura_custom_fields_settings[$group['customer_group_id']]['banca']) && $rofactura_custom_fields_settings[$group['customer_group_id']]['banca'] == $field['custom_field_id']) { ?>selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
                <?php } ?>
              </select>
            </td>
            </tr>
          <?php } ?>


        </table>
      </form>
      </div>
    </div>
  </div>
</div>
<script>
$('#fact-del').on('click', function() {
  if (confirm('Esti sigur ca doresti sa stergi acele facturi? Nu le vei mai putea recupera in starea lor de inainte.(insa le vei putea regenera)')) {
    var numb = $(this).data('number');
    location = '<?php echo $stergeFacturi; ?>&deleteOver=' + numb + '&token=<?php echo $token; ?>';
  }
});
</script>
<?php echo $footer; ?>