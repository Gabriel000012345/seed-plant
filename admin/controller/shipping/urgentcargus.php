<?php
class ControllerShippingUrgentCargus extends Controller {
	private $error = array();

	public function index() {

        $this->load->language('shipping/urgentcargus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            $this->session->data['success'] = null;
        }

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            // sterg toate variabilele salvate anterior
            if ($this->request->post['urgentcargus_username'] != $this->config->get('urgentcargus_username') || $this->request->post['urgentcargus_password'] != $this->config->get('urgentcargus_password')) {
                //$this->model_setting_setting->editSetting('urgent_preferinte', array(
                //    'urgent_preferinte_price' => '',
                //    'urgent_preferinte_pickup' => '',
                //    'urgent_preferinte_pickup_locality' => '',
                //    'urgent_preferinte_insurance' => '',
                //    'urgent_preferinte_saturday' => '',
                //    'urgent_preferinte_repayment' => '',
                //    'urgent_preferinte_payer' => ''
                //));
            }
			$this->model_setting_setting->editSetting('urgentcargus', $this->request->post);

            // instantiez clasa urgent
            require(DIR_CATALOG.'model/shipping/urgentcargusclass.php');
            $this->model_shipping_urgentcargusclass = new ModelShippingUrgentCargusClass();

            // setez url si key
            $this->model_shipping_urgentcargusclass->SetKeys($this->request->post['urgentcargus_api_url'], $this->request->post['urgentcargus_api_key']);

            // UC login user
            $fields = array(
                'UserName' => $this->request->post['urgentcargus_username'],
                'Password' => $this->request->post['urgentcargus_password']
            );
            $token = $this->model_shipping_urgentcargusclass->CallMethod('LoginUser', $fields, 'POST');

            if (is_array($token)) {
                $this->error['warning'] = $this->language->get('text_error').$token['data'];
            } else {
                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
            }
		}

		$data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
        $data['entry_api_url'] = $this->language->get('entry_api_url');
        $data['entry_api_key'] = $this->language->get('entry_api_key');
        $data['entry_username'] = $this->language->get('entry_username');
        $data['entry_password'] = $this->language->get('entry_password');
        $data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/urgentcargus', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('shipping/urgentcargus', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['urgentcargus_api_url'])) {
			$data['urgentcargus_api_url'] = $this->request->post['urgentcargus_api_url'];
		} else {
			$data['urgentcargus_api_url'] = $this->config->get('urgentcargus_api_url');
		}

        if (isset($this->request->post['urgentcargus_api_key'])) {
			$data['urgentcargus_api_key'] = $this->request->post['urgentcargus_api_key'];
		} else {
			$data['urgentcargus_api_key'] = $this->config->get('urgentcargus_api_key');
		}

        if (isset($this->request->post['urgentcargus_username'])) {
			$data['urgentcargus_username'] = $this->request->post['urgentcargus_username'];
		} else {
			$data['urgentcargus_username'] = $this->config->get('urgentcargus_username');
		}

        if (isset($this->request->post['urgentcargus_password'])) {
			$data['urgentcargus_password'] = $this->request->post['urgentcargus_password'];
		} else {
			$data['urgentcargus_password'] = $this->config->get('urgentcargus_password');
		}

        if (isset($this->request->post['urgentcargus_tax_class_id'])) {
			$data['urgentcargus_tax_class_id'] = $this->request->post['urgentcargus_tax_class_id'];
		} else {
			$data['urgentcargus_tax_class_id'] = $this->config->get('urgentcargus_tax_class_id');
		}

        $this->load->model('localisation/tax_class');
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['urgentcargus_geo_zone_id'])) {
			$data['urgentcargus_geo_zone_id'] = $this->request->post['urgentcargus_geo_zone_id'];
		} else {
			$data['urgentcargus_geo_zone_id'] = $this->config->get('urgentcargus_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['urgentcargus_status'])) {
			$data['urgentcargus_status'] = $this->request->post['urgentcargus_status'];
		} else {
			$data['urgentcargus_status'] = $this->config->get('urgentcargus_status');
		}

		if (isset($this->request->post['urgentcargus_sort_order'])) {
			$data['urgentcargus_sort_order'] = $this->request->post['urgentcargus_sort_order'];
		} else {
			$data['urgentcargus_sort_order'] = $this->config->get('urgentcargus_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('shipping/urgentcargus.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/urgentcargus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

    public function add() {
        if ($this->config->get('urgentcargus_preferinte_pickup') != '') {
            $this->load->model('sale/order');
            $this->load->model('catalog/product');

            // obtin detaliile comenzii
            $order = $this->model_sale_order->getOrder($this->request->get['id']);

            // calculeaza valoarea totala a cosului
            $this->registry->set('tax', new Tax($this->registry));
            $total_data = $this->model_sale_order->getOrderTotals($this->request->get['id']);
            $totals = array();
            foreach ($total_data as $row) {
                $totals[$row['code']] = $row['value'];
            }

            // calculez totalul transportului inclusiv taxele
            $shipping_total = $this->tax->calculate($totals['shipping'], $this->config->get('urgentcargus_tax_class_id'), $this->config->get('config_tax'));

            // transform totalul transportului in lei
            if ($this->config->get('config_currency') != 'RON') {
                $shipping_total = $this->currency->convert($shipping_total, $this->config->get('config_currency'), 'RON');
            }

            // calculez totalul comenzii inclusiv taxele
            $cart_total = $totals['total'];

            // transform totalul comenzii in lei
            if ($this->config->get('config_currency') != 'RON') {
                $cart_total = $this->currency->convert($cart_total, $this->config->get('config_currency'), 'RON');
            }

            // calculez greutatea totala a comenzii in kilograme
            $order_prodcts = $this->model_sale_order->getOrderProducts($this->request->get['id']);
            $products = array();
            $weight = 0;
            $contents_array = array();
            foreach ($order_prodcts as $p) {
                $product = $this->model_catalog_product->getProduct($p['product_id']);
                if ($product['weight_class_id'] == 1) { // kilograms
                    $weight += $product['weight'];
                } elseif ($product['weight_class_id'] == 2) { // grams
                    $weight += ($product['weight'] / 1000);
                } elseif ($product['weight_class_id'] == 3) { // pounds
                    $weight += ($product['weight'] * 0.453592);
                } elseif ($product['weight_class_id'] == 4) { // ounces
                    $weight += ($product['weight'] * 0.0283495);
                } else {
                    $weight += 1;
                }
                $products[] = $product;
                $contents_array[] = $p['quantity'].' x '.$p['name'];
            }
            if ($weight == 0) {
                $weight = 1;
            } else {
                $weight = ceil($weight);
            }

            // determin valoarea declarata
            if ($this->config->get('urgentcargus_preferinte_insurance') == 1) {
                $value = round($cart_total - $shipping_total, 2);
            } else {
                $value = 0;
            }

            // determin livrarea sambata
            if ($this->config->get('urgentcargus_preferinte_saturday') == 1) {
                $saturday = 1;
            } else {
                $saturday = 0;
            }

            // determin livrarea dimineata
            if ($this->config->get('urgentcargus_preferinte_morning') == 1) {
                $morning = 1;
            } else {
                $morning = 0;
            }

            // determin deschidere colet
            if ($this->config->get('urgentcargus_preferinte_openpackage') == 1) {
                $openpackage = 1;
            } else {
                $openpackage = 0;
            }

            // afla daca aceasta comanda a fost platita si daca nu determin rambursul si platitorul expeditiei
            if ($order['payment_code'] == 'cod') {
                if ($this->config->get('urgentcargus_preferinte_payer') == 'recipient') {
                    $payer = 2;
                } else {
                    $payer = 1;
                }
                if ($this->config->get('urgentcargus_preferinte_repayment') == 'bank') {
                    $cash_repayment = 0;
                    if ($payer == 1) {
                        $bank_repayment = round($cart_total, 2);
                    } else {
                        $bank_repayment = round($cart_total - $shipping_total, 2);
                    }
                } else {
                    if ($payer == 1) {
                        $cash_repayment = round($cart_total, 2);
                    } else {
                        $cash_repayment = round($cart_total - $shipping_total, 2);
                    }
                    $bank_repayment = 0;
                }
            } else {
                $bank_repayment = 0;
                $cash_repayment = 0;
                $payer = 1;
            }

            // adaug awb-ul in baza de date
            $sql = "INSERT INTO awb_urgent_cargus SET
                                order_id = '".addslashes($this->request->get['id'])."',
                                pickup_id = '".addslashes($this->config->get('urgentcargus_preferinte_pickup'))."',
                                name = '".addslashes(htmlentities($order['shipping_company'] ? $order['shipping_company'] : implode(' ', array($order['shipping_firstname'], $order['shipping_lastname']))))."',
                                locality_name = '".addslashes(htmlentities($order['shipping_city']))."',
                                county_name = '".addslashes(htmlentities($order['shipping_zone_code']))."',
                                street_name = '',
                                number = '',
                                address = '".addslashes(htmlentities($order['shipping_address_1'].($order['shipping_address_2'] ? "\n".$order['shipping_address_2'] : '')))."',
                                contact = '".addslashes(htmlentities(implode(' ', array($order['shipping_firstname'], $order['shipping_lastname']))))."',
                                phone = '".addslashes($order['telephone'])."',
                                email = '".addslashes($order['email'])."',
                                parcels = '".($this->config->get('urgentcargus_preferinte_type') != 'envelope' ? 1 : 0)."',
                                envelopes = '".($this->config->get('urgentcargus_preferinte_type') == 'envelope' ? 1 : 0)."',
                                weight = '".addslashes($weight)."',
                                value = '".addslashes($value)."',
                                cash_repayment = '".addslashes($cash_repayment)."',
                                bank_repayment = '".addslashes($bank_repayment)."',
                                other_repayment = '',
                                payer = '".addslashes($payer)."',
                                saturday_delivery = '".addslashes($saturday)."',
                                morning_delivery = '".addslashes($morning)."',
                                openpackage = '".addslashes($openpackage)."',
                                observations = '',
                                contents = '".addslashes(htmlentities(implode('; ', $contents_array)))."',
                                barcode = '0',
                                shipping_code = '".addslashes($order['shipping_code'])."'
                            ";

            if ($this->db->query($sql)) {
                echo 'ok';
            } else {
                echo 'err';
            }
        } else {
            echo 'err';
        }
    }
}
?>