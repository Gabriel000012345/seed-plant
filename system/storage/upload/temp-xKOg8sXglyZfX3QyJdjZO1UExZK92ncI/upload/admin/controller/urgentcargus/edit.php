<?php
class ControllerUrgentCargusEdit extends Controller {
    private $error = array();

    public function index(){
        $this->load->language('urgentcargus/edit');

		$this->document->setTitle($this->language->get('heading_title'));

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

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_pending'] = $this->language->get('text_pending');
        $data['text_shipping'] = $this->language->get('text_shipping');
        $data['text_choose_pickup'] = $this->language->get('text_choose_pickup');
        $data['text_no_data'] = $this->language->get('text_no_data');
        $data['text_sender'] = $this->language->get('text_sender');
        $data['text_recipient'] = $this->language->get('text_recipient');
        $data['text_details'] = $this->language->get('text_details');
        $data['text_sender'] = $this->language->get('text_sender');
        $data['text_recipient'] = $this->language->get('text_recipient');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_urgent_destinatie'] = $this->language->get('text_urgent_destinatie');
        $data['text_urgent_franciza'] = $this->language->get('text_urgent_franciza');
        $data['entry_pickup'] = $this->language->get('entry_pickup');
        $data['entry_county'] = $this->language->get('entry_county');
        $data['entry_locality'] = $this->language->get('entry_locality');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_address'] = $this->language->get('entry_address');
        $data['entry_contact'] = $this->language->get('entry_contact');
        $data['entry_phone'] = $this->language->get('entry_phone');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_parcels'] = $this->language->get('entry_parcels');
        $data['entry_envelopes'] = $this->language->get('entry_envelopes');
        $data['entry_weight'] = $this->language->get('entry_weight');
        $data['entry_value'] = $this->language->get('entry_value');
        $data['entry_cash_repayment'] = $this->language->get('entry_cash_repayment');
        $data['entry_bank_repayment'] = $this->language->get('entry_bank_repayment');
        $data['entry_other_repayment'] = $this->language->get('entry_other_repayment');
        $data['entry_payer'] = $this->language->get('entry_payer');
        $data['entry_saturday_delivery'] = $this->language->get('entry_saturday_delivery');
        $data['entry_morning_delivery'] = $this->language->get('entry_morning_delivery');
        $data['entry_openpackage'] = $this->language->get('entry_openpackage');
        $data['entry_observations'] = $this->language->get('entry_observations');
        $data['entry_contents'] = $this->language->get('entry_contents');
        $data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['cancel'] = $this->url->link('urgentcargus/comanda', 'token=' . $this->session->data['token'], 'SSL');

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

        // selectez awb-ul pentru editare
        $awb = $this->db->query("SELECT * FROM awb_urgent_cargus WHERE id = '".$this->request->get['awb']."' ORDER BY id ASC LIMIT 0, 1");
        $data['awb'] = $awb;

        // obtine lista punctelor de ridicare
        $data['pickups'] = $this->model_shipping_urgentcargusclass->CallMethod('PickupLocations', array(), 'GET', $token);
        if (is_null($data['pickups'])) {
            $data['valid'] = false;
            $data['error'] = $this->language->get('text_error').'Nu exista niciun punct de ridicare asociat acestui cont!';
        }

        // preiau judetele din opencart
        $this->load->model('localisation/zone');
        $data['judete'] = $this->model_localisation_zone->getZonesByCountryId(175);

        // obtin lista de judete din api
        $judete = array();
        $dataJudete = $this->model_shipping_urgentcargusclass->CallMethod('Counties?countryId=1', array(), 'GET', $token);
        foreach ($dataJudete as $val) {
            $judete[strtolower($val['Abbreviation'])] = $val['CountyId'];
        }

        // obtin lista de localitati pe baza abrevierii judetului
        $data['localitati'] = $this->model_shipping_urgentcargusclass->CallMethod('Localities?countryId=1&countyId='.$judete[strtolower($data['awb']->row['county_name'])], array(), 'GET', $token);

        $data['action'] = $this->url->link('urgentcargus/edit/save', 'token=' . $this->session->data['token'].'&awb='.$this->request->get['awb'], 'SSL');

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
            'text'      => $this->language->get('text_currentorder'),
            'href'      => $this->url->link('urgentcargus/comanda', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('urgentcargus/edit', 'token=' . $this->session->data['token'].'&awb='.$this->request->get['awb'], 'SSL')
        );

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('urgentcargus/edit.tpl', $data));
    }

    protected function validate() {
		if (!$this->user->hasPermission('modify', 'urgentcargus/edit')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

    public function save(){
        $this->db->query("UPDATE
                                awb_urgent_cargus
                            SET
                                pickup_id = '".$this->request->post['pickup_id']."',
                                name = '".$this->request->post['name']."',
                                locality_name = '".$this->request->post['city']."',
                                county_name = '".$this->request->post['zone_id']."',
                                address = '".$this->request->post['address']."',
                                contact = '".$this->request->post['contact']."',
                                phone = '".$this->request->post['phone']."',
                                email = '".$this->request->post['email']."',
                                parcels = '".$this->request->post['parcels']."',
                                envelopes = '".$this->request->post['envelopes']."',
                                weight = '".$this->request->post['weight']."',
                                value = '".$this->request->post['value']."',
                                cash_repayment = '".$this->request->post['cash_repayment']."',
                                bank_repayment = '".$this->request->post['bank_repayment']."',
                                other_repayment = '".$this->request->post['other_repayment']."',
                                payer = '".$this->request->post['payer']."',
                                saturday_delivery = '".$this->request->post['saturday_delivery']."',
                                morning_delivery = '".$this->request->post['morning_delivery']."',
                                openpackage = '".$this->request->post['openpackage']."',
                                observations = '".$this->request->post['observations']."',
                                contents = '".$this->request->post['contents']."',
                                shipping_code = '".$this->request->post['shipping_code']."'
                            WHERE
                                id ='".$this->request->get['awb']."'");

        $this->load->language('urgentcargus/edit');
		$this->session->data['success'] = $this->language->get('text_success');
        $this->response->redirect($this->url->link('urgentcargus/comanda', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>