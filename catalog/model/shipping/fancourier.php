<?php
class ModelShippingFANCourier extends Model {
	function getQuote($address) {
		$this->load->language('shipping/fancourier');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country where country_id = '" . (int)$address['country_id'] . "' and name='Romania'");
	
		if ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		if ($status) {

                        $username = $this->config->get('fancourier_username');
                        $parola = $this->config->get('fancourier_password');
                        $clientid = $this->config->get('fancourier_clientid');
                        $parcel = $this->config->get('fancourier_parcel');
                        $labels = $this->config->get('fancourier_labels');
                        $ramburs = $this->config->get('fancourier_ramburs');
                        $content = $this->config->get('fancourier_content');
                        $contcolector = $this->config->get('fancourier_contcolector');
                        $redcode = $this->config->get('fancourier_redcode');
                        $express = $this->config->get('fancourier_express');
                        $paymentdest = $this->config->get('fancourier_paymentdest');
                        $paymentrbdest = $this->config->get('fancourier_paymentrbdest');
                        $payment0 = $this->config->get('fancourier_payment0');
                        $min_gratuit = $this->config->get('fancourier_min_gratuit');
                        //alex g valoare fixa
                        $valoare_fixa = $this->config->get('fancourier_valoare_fixa');
                        //sfarsit valoare fixa
                        
                        //alex g valoare fixa bucuresti
                        $valoare_fixa_bucuresti = $this->config->get('fancourier_valoare_fixa_bucuresti');
                        //sfarsit valoare fixa bucuresti
                        
                        $observatii = $this->config->get('fancourier_comment');
						//boby 02.05.2014 adaugare persoana de contact
						$pers_contact_expeditor = $this->config->get('pers_contact_expeditor');
						//end boby
						//boby 05.05.2014 deschidere la livrare
						$optiuni = $this->config->get('deschidere_livrare');
						//end boby
						$asigurare = $this->config->get('fancourier_asigurare');
                        $totalrb = $this->config->get('fancourier_totalrb');
                        $onlyadm = $this->config->get('fancourier_onlyadm');
                        $fara_tva = $this->config->get('fancourier_fara_tva');
						
						//valoare fara km suplimentari
						$fara_km = $this->config->get('fancourier_fara_km');
						//sfarsit valoare fara km suplimentari
						
						//valoare km suplimentari
						$doar_km = $this->config->get('fancourier_doar_km');
						//sfarsit valoare km suplimentari
						
                        $msg = "Comanda nu a fost procesata de catre FAN Courier.<br>Va rugam sa corectati datele de livrare conform mesajului de mai jos: <br><br>";

                        $method_data = array();
                        $error = '';

                        if (is_numeric($min_gratuit)) $min_gratuit = $min_gratuit + 0; else $min_gratuit = 0 + 0;
                        
						//alex g valoare fixa
						if (is_numeric($valoare_fixa)) $valoare_fixa = $valoare_fixa + 0; else $valoare_fixa = 0 + 0;
                        //sfarsit valoare fixa
                        
						//alex g valoare fixa
						if (is_numeric($valoare_fixa_bucuresti)) $valoare_fixa_bucuresti = $valoare_fixa_bucuresti + 0; else $valoare_fixa_bucuresti = 0 + 0;
                        //sfarsit valoare fixa
                        
                        if ($parcel){
                            $plic="0";
                            if (is_numeric($labels)){
                                $colet=$labels;
                            } else {
                                $colet=1;
                            }
                        } else {
                            $colet="0";
                            if (is_numeric($labels)){
                                $plic=$labels;
                            } else {
                                $plic=1;
                            }
                        }

                        if ($totalrb){
                            $totalrb = "1";
                        } else {
                            $totalrb = "0";
                        }

                        if ($this->cart->hasProducts()){

                                    if ($asigurare){
                                            $valoaredeclarata = number_format(round((float)$this->cart->getTotal(),2), 2, '.', '');
                                    } else {
                                            $valoaredeclarata = 0;
                                    }

                                    $greutate = number_format(round((float)$this->cart->getWeight(),0), 0, '.', '');
									//
									if ($greutate>1)
									{
										$plic=0;
										if (is_numeric($labels))
										{
											$colet=$labels;
										} 
										else 
										{
											$colet=1;
										}
									}
									//
                                    if (round((float)$this->cart->getWeight(),0)>5) $redcode = false;

                                    $lungime=0;
                                    $latime=0;
                                    $inaltime=0;

                                    if ($paymentdest){
                                        $plata_expeditiei="destinatar";
                                    }else{
                                        $plata_expeditiei="expeditor";
                                    }

                                    $rambursare = '';
                                    $rambursare_number = 0 + 0;

                                    $plata_expeditiei_ramburs = "";
                                    
                                    //alex g comutare intre valoarea fixa bucuresti si valoarea fixa pe tara
                                    if ((strtolower($address['city'])=="bucuresti") and is_numeric($valoare_fixa_bucuresti))
                                    {
                                    	$valoare_fixa=$valoare_fixa_bucuresti;
                                    }
                                    //alex g sfarsit comutare
                                    
                                    
                                    if ($ramburs){
                                        if ($contcolector){
                                            $rambursare = number_format(round((float)$this->cart->getTotal(),2), 2, '.', '');
                                            $rambursare_number = round((float)$this->cart->getTotal(),2)+0;
                                            //valoare fixa adaugare la ramburs cont colector
                                            //if($valoare_fixa!=0 and $totalrb=="1" and ($min_gratuit>$rambursare_number or $min_gratuit==0))
                                            //{
                                            	//$plata_expeditiei="expeditor";
                                            //	$totalrb="0";
                                            //	$rambursare=$rambursare+$valoare_fixa;
                                            	
                                            //}
                                            
                                            if ($min_gratuit<$rambursare_number and $min_gratuit!=0)
                                            {							
                                            	$totalrb="0";
                                            }
                                            //sfarsit
                                            
                                            if ($paymentrbdest){
                                                $plata_expeditiei_ramburs="destinatar";
                                            }else{
                                                $plata_expeditiei_ramburs="expeditor";
                                            }
                                        } else {
                                        	
                                            $rambursare = (string)number_format(round((float)$this->cart->getTotal(),2), 2, '.', '')." LEI";
                                            $rambursare_number = round((float)$this->cart->getTotal(),2)+0;
                                            
                                            //valoare fixa adaugare la ramburs 
                                        	//if($valoare_fixa!=0 and $totalrb=="1" and ($min_gratuit>$rambursare_number or $min_gratuit==0))
                                            //{
                                            	//$plata_expeditiei="expeditor";
                                            //	$totalrb="0";
                                            //	$rambursare=$rambursare+$valoare_fixa;
                                            //}
                                            //sfarsit
											//$observatii=$min_gratuit."bla bla bla bla".$rambursare_number;
											
											if ($min_gratuit<$rambursare_number and $min_gratuit!=0)
                                            {
                                            	$totalrb="0";
                                            }
                                            
                                            if ($paymentrbdest){
                                                $plata_expeditiei_ramburs="destinatar";
                                            }else{
                                                $plata_expeditiei_ramburs="expeditor";
                                            }
                                        }
                                    } else {
                                        $rambursare_number = round((float)$this->cart->getTotal(),2)+0;
                                    }
									
									//cand min gratuit mai mic ca ramburs plata la expeditor
                                        if ($min_gratuit<$rambursare_number and $min_gratuit!=0)
										{
											$plata_expeditiei="expeditor";
										}
									//

                                    $localitate_dest = $address['city'];

                                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone where zone_id = " . (int)$address['zone_id'] . " limit 0, 1");

                                    if ($query->num_rows) {
                                        $judet_dest = $query->row['name'];
                                    }
                                    
                                    if ($judet_dest=="Satu-Mare")
                                    {
                                        $judet_dest="Satu Mare";
                                    }

                                    if ($judet_dest=="Dimbovita")
                                    {
                                        $judet_dest="Dambovita";
                                    }
                                    
                                    //$pers_contact_expeditor = '';
																											
                                    $continut='';
                                    if ($content){
                                        foreach ($this->cart->getProducts() as $product) {
                                            if ($product['shipping']) {
                                                $continut = $continut.", ".$product["model"];
                                            }
                                        }

                                    }
                                    if ($continut!=""){$continut=substr($continut, 2);}						

                                    if(trim($address["company"])!=''){
                                        $nume_destinatar =$address["company"];
                                        $persoana_contact =  $address["firstname"]." ".$address["lastname"];
                                        if (trim($persoana_contact) == '')$this->customer->getFirstName()." ".$this->customer->getLastName();
                                    } else {
                                        $nume_destinatar = $address["firstname"]." ".$address["lastname"];
                                        if ($nume_destinatar == ' ')$this->customer->getFirstName()." ".$this->customer->getLastName();
                                        $persoana_contact = $this->customer->getFirstName()." ".$this->customer->getLastName();
                                        if (trim($persoana_contact) == trim($persoana_contact)) $persoana_contact = '';
                                    }

                                    $telefon = $this->customer->getTelephone();
                                    if (!is_null($this->customer->getFax()) and $this->customer->getFax()!='') $telefon=$telefon." / ".$this->customer->getFax();

                                    if (isset($this->session->data['guest']['telephone'])) {
                                        $telefon = $this->session->data['guest']['telephone'] ;
                                    }
                                    
                                     //alex g 12.02.2014 transmitere adresa de mail catre selfawb
									$email = $this->customer->getEmail();
                        			if (isset($this->session->data['guest']['email'])) {
                                        $email = $this->session->data['guest']['email'] ;
                                    }									
                                    //sfarsit alex g


                                    $strada = $address['address_1'];
									$strada = rawurlencode($strada);
                                    if ($address['address_1']!=''){
										$temp_adress = $address['address_2'];
										$temp_adress = rawurlencode($temp_adress);
                                        $strada = $strada.", ".$temp_adress;
                                    }
                                    
                                    $postalcode = str_pad($address['postcode'], 6 ,"0");

                                    $url = 'http://www.selfawb.ro/order.php';
                                    $c = curl_init ($url);
                                    curl_setopt ($c, CURLOPT_POST, true);
                                    curl_setopt ($c, CURLOPT_POSTFIELDS, "username=$username&user_pass=$parola&client_id=$clientid&return=services");
                                    curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
                                    $page = curl_exec ($c);
                                    curl_close ($c);

                                    //$servicii_data = str_getcsv($page,"\n"); // COMPATIBIL PENTRU VERSIUNE PHP > 5.3.X
                                    $servicii_data = explode("\n",ltrim(rtrim($page))); // COMPATIBIL PENTRU VERSIUNE PHP < 5.2.X

                                    foreach($servicii_data as $tip_serviciu_info){
                                        $tip_serviciu_info = str_replace('"','',$tip_serviciu_info);
                                        if ((!$contcolector or round($ramburs, 0)==0)){
                                            $tip_serviciu = explode(",",$tip_serviciu_info);
                                            if ($tip_serviciu[1]==0 and (($tip_serviciu[2]==0 and $tip_serviciu[3]==0) or ($tip_serviciu[2]==1 and $redcode) or ($tip_serviciu[3]==1 and $express))){
                                                    $url = 'http://www.selfawb.ro/order.php';
                                                    $c = curl_init ($url);
                                                    curl_setopt ($c, CURLOPT_POST, true);
                                                    curl_setopt ($c, CURLOPT_POSTFIELDS, "username=$username&user_pass=$parola&client_id=$clientid&plata_expeditiei=$plata_expeditiei&tip_serviciu=$tip_serviciu[0]&localitate_dest=$localitate_dest&judet_dest=$judet_dest&plic=$plic&colet=$colet&greutate=$greutate&lungime=$lungime&latime=$latime&inaltime=$inaltime&valoare_declarata=$valoaredeclarata&plata_ramburs=$plata_expeditiei_ramburs&ramburs=$rambursare&pers_contact_expeditor=$pers_contact_expeditor&observatii=$observatii&continut=$continut&nume_destinatar=$nume_destinatar&persoana_contact=$persoana_contact&telefon=$telefon&email=$email&strada=$strada&postalcode=$postalcode&totalrb=$totalrb&admin=$onlyadm&fara_tva=$fara_tva&suma_fixa=$valoare_fixa&fara_km=$fara_km&doar_km=$doar_km&optiuni=$optiuni");
                                                    curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
                                                    $page = curl_exec ($c);
                                                    curl_close ($c);
                                                    $price = explode("|||",$page);
                                                    if (isset($price[1])) {
                                                        
                                                    	if (!($payment0) and ($min_gratuit>$rambursare_number or $min_gratuit==0)) 
                                                    	{
                                                        $price_standard = $price[0]; 
															//alex g valoare fixa
															//if ($valoare_fixa!=0)
															//{
																//adaugare km suplimentari la valoare fixa
																//if ($doar_km==1)
																//{
																//	$price_standard=$price_standard;
																//}
																//else
																//{
																//	$price_standard = $valoare_fixa;
																//}
																//sfarsit km suplimentari la valoare fixa
															//}
															//sfarsit valoare fixa
                                                    	}
                                                        else 
                                                        $price_standard = 0;
                                                        
                                                        $link_standard = $price[1];
                                                       
                                                    } else {
                                                        $price_standard = "";
                                                    }

                                                    if (is_numeric($price_standard) and $link_standard!=""){
                                                            $currency = 'RON';
                                                            $quote_data[str_replace(" ","_",$tip_serviciu[0])] = array(
                                                                'code'         => 'fancourier.'.str_replace(" ","_",$tip_serviciu[0]),
                                                                'title'        => "<a href=\"http://www.selfawb.ro/order.php?order_id=$link_standard\" target=\"_blank\">$tip_serviciu[0]</a>",
                                                                'cost'         => $this->currency->convert($price_standard, $currency, $this->config->get('config_currency')),
                                                                'tax_class_id' => 'fancourier.tax',
                                                                'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($price_standard, $currency, $this->currency->getCode()), $this->config->get('fan_class_id'), $this->config->get('config_tax')), $this->currency->getCode(), 1.0000000)
                                                            );
                                                    }else{
                                                            if ($tip_serviciu[2]==0 and $tip_serviciu[3]==0){
                                                                $quote_data[str_replace(" ","_",$tip_serviciu[0])] = array(
                                                                    'code'         => 'fancourier.'.str_replace(" ","_",$tip_serviciu[0]),
                                                                    'title'        => "<a href=\"http://www.selfawb.ro/order.php?order_id=$link_standard\" target=\"_blank\">$tip_serviciu[0]</a>",
                                                                    'cost'         => 0,
                                                                    'tax_class_id' => 'fancourier.tax.'.str_replace(" ","_",$tip_serviciu[0]),
                                                                    'text'         => $msg.$page
                                                                );
                                                                $error = $msg.$page;
                                                            }
                                                    }
                                            }
                                            unset($tip_serviciu);
                                        } else {
                                            $tip_serviciu = explode(",",$tip_serviciu_info);
                                            if ($tip_serviciu[1]==1 and (($tip_serviciu[2]==0 and $tip_serviciu[3]==0) or ($tip_serviciu[2]==1 and $redcode) or ($tip_serviciu[3]==1 and $express))){
                                                    $url = 'http://www.selfawb.ro/order.php';
                                                    $c = curl_init ($url);
                                                    curl_setopt ($c, CURLOPT_POST, true);
                                                    curl_setopt ($c, CURLOPT_POSTFIELDS, "username=$username&user_pass=$parola&client_id=$clientid&plata_expeditiei=$plata_expeditiei&tip_serviciu=$tip_serviciu[0]&localitate_dest=$localitate_dest&judet_dest=$judet_dest&plic=$plic&colet=$colet&greutate=$greutate&lungime=$lungime&latime=$latime&inaltime=$inaltime&valoare_declarata=$valoaredeclarata&plata_ramburs=$plata_expeditiei_ramburs&ramburs=$rambursare&pers_contact_expeditor=$pers_contact_expeditor&observatii=$observatii&continut=$continut&nume_destinatar=$nume_destinatar&persoana_contact=$persoana_contact&telefon=$telefon&email=$email&strada=$strada&postalcode=$postalcode&totalrb=$totalrb&admin=$onlyadm&fara_tva=$fara_tva&suma_fixa=$valoare_fixa&fara_km=$fara_km&doar_km=$doar_km&optiuni=$optiuni");
                                                    curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
                                                    $page = curl_exec ($c);
                                                    curl_close ($c);
                                                    $price = explode("|||",$page);
                                                    if (!($payment0) and ($min_gratuit>$rambursare_number or $min_gratuit==0)) $price_standard = $price[0]; else $price_standard = 0;
                                                    if (isset($price[1])) {
                                                        if (!($payment0) and ($min_gratuit>$rambursare_number or $min_gratuit==0)) 
                                                        {
                                                        $price_standard = $price[0]; 
															//alex g valoare fixa
															//if ($valoare_fixa!=0) 
															//{
																//adaugare km suplimentari la valoare fixa
															//	if ($doar_km==1)
															//	{
															//		$price_standard=$valoare_fixa+$price_standard;
															//	}
															//	else
															//	{
															//		$price_standard = $valoare_fixa;
															//	}
																//sfarsit km suplimentari la valoare fixa
															//}
															//sfarsit valoare fixa
                                                        }
                                                        else 
                                                        $price_standard = 0;
                                                        
                                                        $link_standard = $price[1];
                                                        
                                                        
                                                    } else {
                                                        $price_standard = "";
                                                    }

                                                    if (is_numeric($price_standard) and $link_standard!=""){
                                                            $currency = 'RON';
                                                            $quote_data[str_replace(" ","_",$tip_serviciu[0])] = array(
                                                                'code'         => 'fancourier.'.str_replace(" ","_",$tip_serviciu[0]),
                                                                'title'        => "<a href=\"http://www.selfawb.ro/order.php?order_id=$link_standard\" target=\"_blank\">$tip_serviciu[0]</a>",
                                                                'cost'         => $this->currency->convert($price_standard, $currency, $this->config->get('config_currency')),
                                                                'tax_class_id' => 'fancourier.tax',
                                                                'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($price_standard, $currency, $this->currency->getCode()), $this->config->get('fan_class_id'), $this->config->get('config_tax')), $this->currency->getCode(), 1.0000000)
                                                            );
                                                    }else{
                                                            if ($tip_serviciu[2]==0 and $tip_serviciu[3]==0){
                                                                $quote_data[str_replace(" ","_",$tip_serviciu[0])] = array(
                                                                    'code'         => 'fancourier.'.str_replace(" ","_",$tip_serviciu[0]),
                                                                    'title'        => "<a href=\"http://www.selfawb.ro/order.php?order_id=$link_standard\" target=\"_blank\">$tip_serviciu[0]</a>",
                                                                    'cost'         => 0,
                                                                    'tax_class_id' => 'fancourier.tax.'.str_replace(" ","_",$tip_serviciu[0]),
                                                                    'text'         => $msg.$page
                                                                );
                                                                $error = $msg.$page;
                                                            }
                                                    }
                                            }
                                            unset($tip_serviciu);
                                        }
                                    }

                                    $method_data = array(
                                            'code'       => 'fancourier',
                                            'title'      => 'FAN Courier - Romania',
                                            'quote'      => $quote_data,
                                            'sort_order' => '1',
                                            'error'      => $error
                                    );

                                    return $method_data;
                        }

                }
	}
}
?>