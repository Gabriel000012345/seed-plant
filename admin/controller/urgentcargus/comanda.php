<?php
class ControllerUrgentCargusComanda extends Controller {
    private $error = array();

    public function index(){

        $this->load->language('urgentcargus/comanda');

		$this->document->setTitle($this->language->get('heading_title'));

        if (isset($_GET['LocationId'])) {
            $pickup = $this->request->get['LocationId'];
        } else {
            $pickup = $this->config->get('urgentcargus_preferinte_pickup');
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            $this->session->data['success'] = '';
        } else {
            $data['success'] = '';
        }
        if (isset($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            $this->session->data['error'] = '';
        } else {
            $data['error'] = '';
        }
        if (isset($this->session->data['error_warning'])) {
            $data['error_warning'] = $this->session->data['error_warning'];
            $this->session->data['error_warning'] = '';
        } else {
            $data['error_warning'] = '';
        }

        // instantiez clasa urgent
        require(DIR_CATALOG.'model/shipping/urgentcargusclass.php');
        $this->model_shipping_urgentcargusclass = new ModelShippingUrgentCargusClass();

        // setez url si key
        $this->model_shipping_urgentcargusclass->SetKeys($this->config->get('urgentcargus_api_url'), $this->config->get('urgentcargus_api_key'));

        // UC login user
        $fields = array(
            'UserName' => $this->config->get('urgentcargus_username'),
            'Password' => $this->config->get('urgentcargus_password')
        );
        $token = $this->model_shipping_urgentcargusclass->CallMethod('LoginUser', $fields, 'POST');

        if (is_array($token)) {
            $data['valid'] = false;
            $data['error'] = $this->language->get('text_error').$token['data'];
        } else {
            $data['valid'] = true;

            // obtine lista punctelor de ridicare
            $data['pickups'] = array();
            $pickups = $this->model_shipping_urgentcargusclass->CallMethod('PickupLocations', array(), 'GET', $token);
            if (is_null($pickups)) {
                $data['valid'] = false;
                $data['error'] = $this->language->get('text_error').'Nu exista niciun punct de ridicare asociat acestui cont!';
            } else {
                foreach ($pickups as $pick) {
                    $data['pickups'][$pick['LocationId']] = $pick;
                }
            }

            // UC get comanda curenta
            $orders = $this->model_shipping_urgentcargusclass->CallMethod('Orders?locationId='.$pickup.'&status=0&pageNumber=1&itemsPerPage=1000', array(), 'GET', $token);

            // UC get awb-uri curente
            $data['listaValidate'] = array();
            if (!is_null($orders)) {
                $result = $this->model_shipping_urgentcargusclass->CallMethod('Awbs?&orderId='.(isset($orders['OrderId']) == 1 ? $orders['OrderId'] : $orders[0]['OrderId']), array(), 'GET', $token);
                if (!is_null($result)) {
                    foreach ($result as $t) {
                        if ($t['Status'] != 'Deleted') {
                            $data['listaValidate'][] = $t;
                        }
                    }
                }
            }

            // get comenzi in asteptare
            $ord = $this->db->query("SELECT * FROM awb_urgent_cargus WHERE barcode = '0' ORDER BY id ASC");

            $data['listaAsteptare'] = $ord;
            foreach ($data['listaAsteptare']->rows as $key => $row) {
                $data['listaAsteptare']->rows[$key]['edit_link'] = $this->url->link('urgentcargus/edit', 'token=' . $this->session->data['token'].'&awb='.$row['id'], 'SSL');
            }

            $data['urgentcargus_preferinte_pickup']  = $this->config->get('urgentcargus_preferinte_pickup');

            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

                // sterg awb-urile selectate din lista in asteptare
                if (isset($this->request->post['action']) && $this->request->post['action'] == 'pending_delete') {
                    if (isset($this->request->post['selected'])) {
                        $this->db->query("DELETE FROM awb_urgent_cargus WHERE id IN(".implode(',', $this->request->post['selected']).")");
                        $this->session->data['success'] = $this->language->get('text_success_delpending');
                    } else {
                        $this->session->data['error'] = $this->language->get('text_no_selection');
                    }
                }

                // sterg awb-urile selectate din lista cu validate
                if (isset($this->request->post['action']) && $this->request->post['action'] == 'validated_invalidate') {
                    if (isset($this->request->post['awbs'])) {
                        foreach ($this->request->post['awbs'] as $barcode) {
                            $result = $this->model_shipping_urgentcargusclass->CallMethod('Awbs?barCode=' . $barcode, array(), 'DELETE', $token);
                            $this->db->query("UPDATE awb_urgent_cargus SET barcode = '0' WHERE barcode = '" . $barcode . "'");
                        }
                        $this->session->data['success'] = $this->language->get('text_success_delvalidated');
                    } else {
                        $this->session->data['error'] = $this->language->get('text_no_selection');
                    }
                }

                // validez awb-urile din lista de asteptare
                if (isset($this->request->post['action']) && $this->request->post['action'] == 'pending_validate') {
                    if (isset($this->request->post['selected'])) {
                        $errors = array();
                        $successes = array();
                        foreach ($this->request->post['selected'] as $id) {
                            $row = $this->db->query("SELECT * FROM awb_urgent_cargus WHERE barcode = '0' AND id = '".addslashes($id)."'");

                            if ($row->row['shipping_code'] == 'urgentcargus.franciza') {
                                // se trimite catre franciza UrgentCargus si nu catre adresa destinatarului
                                $CountyName = $row->row['county_name'];
                                $LocalityName = $row->row['locality_name'];
                                $Address = 'Se va ridica de la sediul Urgent Cargus!';
                                $Observations = 'SE VA RIDICA DE LA SEDIUL URGENT CARGUS | '.$row->row['observations'];
                            } else {
                                // se trimite catre adresa destinatarului
                                $CountyName = $row->row['county_name'];
                                $LocalityName = $row->row['locality_name'];
                                $Address = $row->row['address'];
                                $Observations = $row->row['observations'];
                            }

                            if ($row->num_rows > 0) {
                                $fields = array(
                                    'Sender' => array(
                                        'LocationId' => $row->row['pickup_id']
                                    ),
                                    'Recipient' => array(
                                        'LocationId' => null,
                                        'Name' => $row->row['name'],
                                        'CountyId' => null,
                                        'CountyName' => $CountyName,
                                        'LocalityId' => null,
                                        'LocalityName' => $LocalityName,
                                        'StreetId' => null,
                                        'StreetName' => '-',
                                        'AddressText' => $Address,
                                        'ContactPerson' => $row->row['contact'],
                                        'PhoneNumber' => $row->row['phone'],
                                        'Email' => $row->row['email']
                                    ),
                                    'Parcels' => $row->row['parcels'],
                                    'Envelopes' => $row->row['envelopes'],
                                    'TotalWeight' => $row->row['weight'],
                                    'DeclaredValue' => $row->row['value'],
                                    'CashRepayment' => $row->row['cash_repayment'],
                                    'BankRepayment' => $row->row['bank_repayment'],
                                    'OtherRepayment' => $row->row['other_repayment'],
                                    'OpenPackage' => $row->row['openpackage'] == 1 ? true : false,
                                    //'PriceTableId' => $this->config->get('urgentcargus_preferinte_price'),
                                    'PriceTableId' => null,
                                    'ShipmentPayer' => $row->row['payer'],
                                    'ServiceId' => $row->row['payer'] == 1 ? 1 : 4,
                                    'MorningDelivery' => $row->row['morning_delivery'] == 1 ? true : false,
                                    'SaturdayDelivery' => $row->row['saturday_delivery'] == 1 ? true : false,
                                    'Observations' => $Observations,
                                    'PackageContent' => $row->row['contents'],
                                    'CustomString' => $row->row['order_id']
                                );
                                $cod_bara = $this->model_shipping_urgentcargusclass->CallMethod('Awbs', $fields, 'POST', $token);

                                if (is_array($cod_bara)) {
                                    if (isset($cod_bara['error'])) {
                                        $errors[] = $this->language->get('text_order').' '.$row->row['parcels'].': '.$cod_bara['error'];
                                    }
                                } else if ($cod_bara != '') {
                                    $this->db->query("UPDATE awb_urgent_cargus SET barcode = '".$cod_bara."' WHERE id = '".addslashes($id)."'");
                                    $successes[] = $cod_bara;
                                } else {
                                    $errors[] = 'Unknown error!';
                                }
                            }
                        }
                        if (count($errors) > 0) {
                            $this->session->data['error'] = implode('; ', $errors);
                        }
                        if (count($successes) > 0) {
                            $c = count($successes);
                            $this->session->data['success'] = ($c == 1
                                                                    ? $this->language->get('text_one').' '.$this->language->get('text_success_validated_1')
                                                                    : $c.' '.$this->language->get('text_success_validated'));
                        }
                    } else {
                        $this->session->data['error'] = $this->language->get('text_no_selection');
                    }
                }
                $this->response->redirect($this->url->link('urgentcargus/comanda', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }

        $data['url_print'] = $this->url->link('urgentcargus/comanda/print_awbs', 'token=' . $this->session->data['token'], 'SSL');
        $data['url_order'] = $this->url->link('urgentcargus/comanda/validate_order', 'token=' . $this->session->data['token'], 'SSL');
        $data['text_no_selection'] = $this->language->get('text_no_selection');

        $data['form_action'] = $this->url->link('urgentcargus/comanda', 'token=' . $this->session->data['token'], 'SSL');
        $data['form_filter_action'] = $this->url->link('urgentcargus/comanda/change_pickup', 'token=' . $this->session->data['token'], 'SSL');
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_shipping'] = $this->language->get('text_shipping');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_pending'] = $this->language->get('text_pending');
        $data['text_validated'] = $this->language->get('text_validated');
        $data['text_idcomanda'] = $this->language->get('text_idcomanda');
        $data['text_punctridicare'] = $this->language->get('text_punctridicare');
        $data['text_numedestinatar'] = $this->language->get('text_numedestinatar');
        $data['text_localitatedestinatar'] = $this->language->get('text_localitatedestinatar');
        $data['text_plicuri'] = $this->language->get('text_plicuri');
        $data['text_colete'] = $this->language->get('text_colete');
        $data['text_greutate'] = $this->language->get('text_greutate');
        $data['text_ramburscash'] = $this->language->get('text_ramburscash');
        $data['text_ramburscont'] = $this->language->get('text_ramburscont');
        $data['text_platitor'] = $this->language->get('text_platitor');
        $data['text_codbara'] = $this->language->get('text_codbara');
        $data['text_costexpeditie'] = $this->language->get('text_costexpeditie');
        $data['text_status'] = $this->language->get('text_status');
        $data['text_pending_validate'] = $this->language->get('text_pending_validate');
        $data['text_pending_delete'] = $this->language->get('text_pending_delete');
        $data['text_pending_none'] = $this->language->get('text_pending_none');
        $data['text_validated_print'] = $this->language->get('text_validated_print');
        $data['text_validated_invalidate'] = $this->language->get('text_validated_invalidate');
        $data['text_validated_send'] = $this->language->get('text_validated_send');
        $data['text_validated_none'] = $this->language->get('text_validated_none');
        $data['text_expeditor'] = $this->language->get('text_expeditor');
        $data['text_destinatar'] = $this->language->get('text_destinatar');
        $data['text_changepickup'] = $this->language->get('text_changepickup');
        $data['text_pickup'] = $this->language->get('text_pickup');

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
            'href'      => $this->url->link('urgentcargus/comanda', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('urgentcargus/comanda.tpl', $data));
    }

    public function change_pickup() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSettingValue('urgentcargus_preferinte', 'urgentcargus_preferinte_pickup', $this->request->post['LocationId']);
        $this->response->redirect($this->url->link('urgentcargus/comanda', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function print_awbs() {
        // instantiez clasa urgent
        require(DIR_CATALOG.'model/shipping/urgentcargusclass.php');
        $this->model_shipping_urgentcargusclass = new ModelShippingUrgentCargusClass();

        // setez url si key
        $this->model_shipping_urgentcargusclass->SetKeys($this->config->get('urgentcargus_api_url'), $this->config->get('urgentcargus_api_key'));

        // UC login user
        $fields = array(
            'UserName' => $this->config->get('urgentcargus_username'),
            'Password' => $this->config->get('urgentcargus_password')
        );
        $token = $this->model_shipping_urgentcargusclass->CallMethod('LoginUser', $fields, 'POST');

        // UC print
        $print = $this->model_shipping_urgentcargusclass->CallMethod('AwbDocuments?type=PDF&format=0&barCodes='.$this->request->get['bar_codes'], array(), 'GET', $token);

        header('Content-type:application/pdf');
        echo base64_decode($print);
        die();
    }

    public function validate_order() {
        $this->load->language('urgentcargus/comanda');
        $data['button_sendorder'] = $this->language->get('button_sendorder');
        $data['choose_pickup_date'] = $this->language->get('choose_pickup_date');
        $data['heading_title'] = $this->language->get('heading_title');

        $data['url_send'] = $this->url->link('urgentcargus/comanda/send_order', 'token=' . $this->session->data['token'], 'SSL');
        $data['url_validate'] = $this->url->link('urgentcargus/comanda/validate_order', 'token=' . $this->session->data['token'], 'SSL');

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Europe/Bucharest'));
        $today = $date->format('Y-m-d H:i:s');
        if (isset($this->request->get['date'])) {
            $d = explode('.', $this->request->get['date']);
            $date->setDate($d[2], $d[1], $d[0]);
        }
        $cd = $date->format('Y-m-d H:i:s');

        if (date('w', strtotime($cd)) == 0) { // duminica
            $date = date('d.m.Y', strtotime($cd.' +1 day'));
            $h_start = 13;
            $h_end = 18;
            $h2_start = 14;
            $h2_end = 19;
        } else if (date('w', strtotime($cd)) == 1 || date('w', strtotime($cd)) == 2 || date('w', strtotime($cd)) == 3 || date('w', strtotime($cd)) == 4) { // luni, marti, miercuri si joi
            if ($cd == $today) {
                if (date('H', strtotime($cd)) > 18) {
                    $date = date('d.m.Y', strtotime($cd.' +1 day'));
                    $h_start = 13;
                    $h_end = 18;
                    $h2_start = 14;
                    $h2_end = 19;
                } else if (date('H', strtotime($cd)) == 18) {
                    $date = date('d.m.Y', strtotime($cd));
                    $h_start = 18;
                    $h_end = 18;
                    $h2_start = 19;
                    $h2_end = 19;
                } else {
                    $date = date('d.m.Y', strtotime($cd));
                    $h_start = date('H', strtotime($cd)) + 1;
                    $h_end = 18;
                    $h2_start = date('H', strtotime($cd)) + 2;
                    $h2_end = 19;
                }
            } else {
                $date = date('d.m.Y', strtotime($cd));
                $h_start = 13;
                $h_end = 18;
                $h2_start = 14;
                $h2_end = 19;
            }
        } else if (date('w', strtotime($cd)) == 5) { // vineri
            if ($cd == $today) {
                if (date('H', strtotime($cd)) > 18) {
                    $date = date('d.m.Y', strtotime($cd.' +1 day'));
                    $h_start = 13;
                    $h_end = 14;
                    $h2_start = 14;
                    $h2_end = 15;
                } else if (date('H', strtotime($cd)) == 18) {
                    $date = date('d.m.Y', strtotime($cd));
                    $h_start = 18;
                    $h_end = 18;
                    $h2_start = 19;
                    $h2_end = 19;
                } else {
                    $date = date('d.m.Y', strtotime($cd));
                    $h_start = date('H', strtotime($cd)) + 1;
                    $h_end = 18;
                    $h2_start = date('H', strtotime($cd)) + 2;
                    $h2_end = 19;
                }
            } else {
                $date = date('d.m.Y', strtotime($cd));
                $h_start = 13;
                $h_end = 18;
                $h2_start = 14;
                $h2_end = 19;
            }
        } else if (date('w', strtotime($cd)) == 6) { // sambata
            if ($cd == $today) {
                if (date('H', strtotime($cd)) > 14) {
                    $date = date('d.m.Y', strtotime($cd.' +2 day'));
                    $h_start = 13;
                    $h_end = 18;
                    $h2_start = 14;
                    $h2_end = 19;
                } else if (date('H', strtotime($cd)) == 14) {
                    $date = date('d.m.Y', strtotime($cd));
                    $h_start = 14;
                    $h_end = 14;
                    $h2_start = 15;
                    $h2_end = 15;
                } else {
                    $date = date('d.m.Y', strtotime($cd));
                    $h_start = date('H', strtotime($cd)) + 1;
                    $h_end = 14;
                    $h2_start = date('H', strtotime($cd)) + 2;
                    $h2_end = 15;
                }
            } else {
                $date = date('d.m.Y', strtotime($cd));
                $h_start = 13;
                $h_end = 14;
                $h2_start = 14;
                $h2_end = 15;
            }
        }

        $data['date'] = $date;

        if (isset($this->request->get['hour'])) {
            $h = explode(':', $this->request->get['hour']);
            $h2_start = $h[0] + 1;
            $hour = $this->request->get['hour'];
        } else {
            $hour = false;
        }

        $html = '';
        for ($i = $h_start; $i <= $h_end; $i++) {
            $html .= '<option'.($hour == $i.':00' ? ' selected="selected"' : '').'>'.$i.':00</option>';
        }
        $data['h_dela'] = $html;

        $html = '';
        for ($i = $h2_start; $i <= $h2_end; $i++) {
            $html .= '<option>'.$i.':00</option>';
        }
        $data['h_panala'] = $html;

        $data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('urgentcargus/finalizare.tpl', $data));
    }

    public function send_order() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            // instantiez clasa urgent
            require(DIR_CATALOG.'model/shipping/urgentcargusclass.php');
            $this->model_shipping_urgentcargusclass = new ModelShippingUrgentCargusClass();

            // setez url si key
            $this->model_shipping_urgentcargusclass->SetKeys($this->config->get('urgentcargus_api_url'), $this->config->get('urgentcargus_api_key'));

            // UC login user
            $fields = array(
                'UserName' => $this->config->get('urgentcargus_username'),
                'Password' => $this->config->get('urgentcargus_password')
            );
            $token = $this->model_shipping_urgentcargusclass->CallMethod('LoginUser', $fields, 'POST');

            $d = explode('.', $this->request->post['date']);
            $from = $d[2].'-'.$d[1].'-'.$d[0].' '.$this->request->post['hour_from'].':00';
            $to = $d[2].'-'.$d[1].'-'.$d[0].' '.$this->request->post['hour_to'].':00';

            // UC send order
            $order_id = $this->model_shipping_urgentcargusclass->CallMethod('Orders?locationId='.$this->config->get('urgentcargus_preferinte_pickup').'&PickupStartDate='.date('Y-m-d%20H:i:s', strtotime($from)).'&PickupEndDate='.date('Y-m-d%20H:i:s', strtotime($to)).'&action=1', array(), 'PUT', $token);

            $url_borderou = $this->url->link('urgentcargus/comanda/print_summary', 'token=' . $this->session->data['token'], 'SSL');
            echo '<script>window.opener.location.reload(); window.resizeTo(916, 669); window.location = "'.html_entity_decode($url_borderou).'&order_id='.$order_id.'";</script>';
        }
    }

    public function print_summary() {
        if ($this->request->get['order_id']) {
            // instantiez clasa urgent
            require(DIR_CATALOG.'model/shipping/urgentcargusclass.php');
            $this->model_shipping_urgentcargusclass = new ModelShippingUrgentCargusClass();

            // setez url si key
            $this->model_shipping_urgentcargusclass->SetKeys($this->config->get('urgentcargus_api_url'), $this->config->get('urgentcargus_api_key'));

            // UC login user
            $fields = array(
                'UserName' => $this->config->get('urgentcargus_username'),
                'Password' => $this->config->get('urgentcargus_password')
            );
            $token = $this->model_shipping_urgentcargusclass->CallMethod('LoginUser', $fields, 'POST');

            // UC print borderou
            $borderou = $this->model_shipping_urgentcargusclass->CallMethod('OrderDocuments?orderId='.$this->request->get['order_id'].'&docType=0', array(), 'GET', $token);

            header('Content-type:application/pdf');
            echo base64_decode($borderou);
            die();
        }
    }

    protected function validate() {
		if (!$this->user->hasPermission('modify', 'urgentcargus/comanda')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
?>