<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td colspan=2>
                <span class="help">Stimate client, puteti obtine informatii pentru configurare la adresa de email: <a href="mailto:selfawb@fancourier.ro">selfawb@fancourier.ro</a></span>
                <span class="help">Va multumim pentru ca folositi serviciile FAN Courier.</span>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_status; ?></td>
            <td><select name="fancourier_status">
                <?php if ($fancourier_status) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td colspan=2>
                <span class="help"><b>Securitate:</b></span>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_clientid; ?></td>
            <td><input type="text" name="fancourier_clientid" value="<?php echo $fancourier_clientid; ?>" />
              <?php if ($error_clientid) { ?>
              <span class="error"><?php echo $error_clientid; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_username; ?></td>
            <td><input type="text" name="fancourier_username" value="<?php echo $fancourier_username; ?>" />
              <?php if ($error_username) { ?>
              <span class="error"><?php echo $error_username; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_password; ?></td>
            <td><input type="text" name="fancourier_password" value="<?php echo $fancourier_password; ?>" />
              <?php if ($error_password) { ?>
              <span class="error"><?php echo $error_password; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_onlyadm; ?></td>
            <td><select name="fancourier_onlyadm">
                <?php if ($fancourier_onlyadm) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td colspan=2>
                <span class="help"><b>Optiuni AWB:</b></span>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_parcel; ?></td>
            <td><select name="fancourier_parcel">
                <?php if ($fancourier_parcel) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $text_labels; ?><br>&nbsp;</td>
            <td><input type="text" name="fancourier_labels" value="<?php echo $fancourier_labels; ?>" />
              <span class="help">Introduceti un numar intreg. Exemplu: 1 - daca expeditati 1 pachet / AWB.</span>
              <?php if ($error_labels) { ?>
              <span class="error"><?php echo $error_labels; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_paymentdest; ?></td>
            <td><select name="fancourier_paymentdest">
                <?php if ($fancourier_paymentdest) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_fara_tva; ?></td>
            <td><select name="fancourier_fara_tva">
                <?php if ($fancourier_fara_tva) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		  <!--
		  <tr>
            <td><?php echo $entry_fara_km; ?></td>
            <td>
				<select name="fancourier_fara_km">
                <?php if ($fancourier_fara_km) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
				</select>
				<span class="help">In cadrul acestei optiuni este necesar sa se seteze <b>Plata AWB la destinatie - Nu</b> si <b>Adaugare taxa transp. la ramburs - Da</b></span>
			  </td>
          </tr> --->
		  
		  <tr>
            <td><?php echo $entry_doar_km; ?></td>
            <td>
				<select name="fancourier_doar_km">
                <?php if ($fancourier_doar_km) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
				</select>
				<span class="help">In cadrul acestei optiuni este necesar sa se seteze <b>Plata AWB la destinatie - Nu</b> si <b>Adaugare taxa transp. la ramburs - Da</b></span>
			  </td>
          </tr>
		  
		  
          <tr>
            <td><?php echo $entry_payment0; ?></td>
            <td><select name="fancourier_payment0">
                <?php if ($fancourier_payment0) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $text_min_gratuit; ?></td>
            <td><input type="text" name="fancourier_min_gratuit" value="<?php echo $fancourier_min_gratuit; ?>" />
              <?php if ($error_min_gratuit) { ?>
              <span class="error"><?php echo $error_min_gratuit; ?></span>
              <?php } ?></td>
          </tr>
          
          <!-- alex g valoare fixa bucuresti -->
          <tr>
            <td><?php echo $text_valoare_fixa_bucuresti; ?></td>
            <td><input type="text" name="fancourier_valoare_fixa_bucuresti" value="<?php echo $fancourier_valoare_fixa_bucuresti; ?>" />
              <?php if ($error_valoare_fixa_bucuresti) { ?>
              <span class="error"><?php echo $error_valoare_fixa_bucuresti; ?></span>
              <?php } ?></td>
          </tr>
          <!-- sfarsit valoare fixa bucuresti-->
          
          <!-- alex g valoare fixa -->
          <tr>
            <td><?php echo $text_valoare_fixa; ?></td>
            <td><input type="text" name="fancourier_valoare_fixa" value="<?php echo $fancourier_valoare_fixa; ?>" />
              <?php if ($error_valoare_fixa) { ?>
              <span class="error"><?php echo $error_valoare_fixa; ?></span>
              <?php } ?></td>
          </tr>
          <!-- sfarsit valoare fixa -->
          <tr>
          
          
            <td colspan=2>
                <span class="help"><b>Optiuni ramburs:</b></span>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_ramburs; ?></td>
            <td><select name="fancourier_ramburs">
                <?php if ($fancourier_ramburs) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_totalrb; ?></td>
            <td><select name="fancourier_totalrb">
                <?php if ($fancourier_totalrb) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_contcolector; ?></td>
            <td><select name="fancourier_contcolector">
                <?php if ($fancourier_contcolector) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_paymentrbdest; ?><br>&nbsp;</td>
            <td><select name="fancourier_paymentrbdest">
                <?php if ($fancourier_paymentrbdest) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
              <span class="help">Nu se aplica pentru serviciile de tip Cont Colector.</span></td>
          </tr>
          <tr>
            <td colspan=2>
                <span class="help"><b>Asigurare:</b></span>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_asigurare; ?></td>
            <td><select name="fancourier_asigurare">
                <?php if ($fancourier_asigurare) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_content; ?></td>
            <td><select name="fancourier_content">
                <?php if ($fancourier_content) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td colspan=2>
                <span class="help"><b>Observatii si note:</b></span>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_comment; ?></td>
            <td><input type="text" name="fancourier_comment" value="<?php echo $fancourier_comment; ?>" />
            </td>
          </tr>
		  <tr>
            <td><?php echo $entry_pers_cont_exp; ?></td>
            <td><input type="text" name="pers_contact_expeditor" value="<?php echo $pers_contact_expeditor; ?>" />
            </td>
          </tr>
          <tr>
            <td colspan=2>
                <span class="help"><b>Servicii specifice disponibile:</b></span>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_redcode; ?></td>
            <td><select name="fancourier_redcode">
                <?php if ($fancourier_redcode) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_express; ?></td>
            <td><select name="fancourier_express">
                <?php if ($fancourier_express) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td colspan=2>
                <span class="help"><b>Optiuni servicii*:</b></span>
            </td>
          </tr>
		  
		  <tr>
				<td>
				<?php  echo $entry_deschidere_livrare?>
				</td>
				<td>
				<input type="checkbox" name="deschidere_livrare" value="A" <?php if ($deschidere_livrare) echo "checked"; ?>/>
				</td>
		  </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('select[name=\'ups_origin\']').bind('change', function() {
	$('#service > div').hide();	
										 
	$('#' + this.value).show();	
});

$('select[name=\'ups_origin\']').trigger('change');
//--></script> 
<?php echo $footer; ?>