<?php
class ControllerUrgentCargusPreferinte extends Controller {
    private $error = array();

    public function index(){

        $this->load->language('urgentcargus/preferinte');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		$data['success'] = '';
        $data['error'] = '';
        $data['error_warning'] = '';
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('urgentcargus_preferinte', $this->request->post);
			$data['success'] = $this->language->get('text_success');
		}

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_choose_price'] = $this->language->get('text_choose_price');
        $data['text_choose_pickup'] = $this->language->get('text_choose_pickup');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_cash'] = $this->language->get('text_cash');
        $data['text_bank'] = $this->language->get('text_bank');
        $data['text_sender'] = $this->language->get('text_sender');
        $data['text_recipient'] = $this->language->get('text_recipient');
        $data['text_parcel'] = $this->language->get('text_parcel');
        $data['text_envelope'] = $this->language->get('text_envelope');

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

            // obtine lista planurilor tarifare
            $data['prices'] = $this->model_shipping_urgentcargusclass->CallMethod('PriceTables', array(), 'GET', $token);
            if (is_null($data['prices'])) {
                $data['valid'] = false;
                $data['error'] = $this->language->get('text_error').'Nu exista niciun plan tarifar asociat acestui cont!';
            }

            // obtine lista punctelor de ridicare
            $data['pickups'] = $this->model_shipping_urgentcargusclass->CallMethod('PickupLocations', array(), 'GET', $token);
            if (is_null($data['pickups'])) {
                $data['valid'] = false;
                $data['error'] = $this->language->get('text_error').'Nu exista niciun punct de ridicare asociat acestui cont!';
            }

            $data['entry_price'] = $this->language->get('entry_price');
            $data['entry_pickup'] = $this->language->get('entry_pickup');
            $data['entry_insurance'] = $this->language->get('entry_insurance');
            $data['entry_saturday'] = $this->language->get('entry_saturday');
            $data['entry_morning'] = $this->language->get('entry_morning');
            $data['entry_openpackage'] = $this->language->get('entry_openpackage');
            $data['entry_repayment'] = $this->language->get('entry_repayment');
            $data['entry_payer'] = $this->language->get('entry_payer');
            $data['entry_type'] = $this->language->get('entry_type');
            $data['entry_noextrakm'] = $this->language->get('entry_noextrakm');
            $data['entry_noextrakm_details'] = $this->language->get('entry_noextrakm_details');
            $data['entry_free'] = $this->language->get('entry_free');
            $data['entry_free_details'] = $this->language->get('entry_free_details');
            $data['entry_fixed'] = $this->language->get('entry_fixed');
            $data['entry_fixed_details'] = $this->language->get('entry_fixed_details');

            $data['button_save'] = $this->language->get('button_save');
            $data['button_cancel'] = $this->language->get('button_cancel');
            $data['cancel'] = $this->url->link('urgentcargus/preferinte', 'token=' . $this->session->data['token'], 'SSL');

            if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
            } else {
                $data['error_warning'] = '';
            }

            $data['action'] = $this->url->link('urgentcargus/preferinte', 'token=' . $this->session->data['token'], 'SSL');

            //if (isset($this->request->post['urgentcargus_preferinte_price'])) {
            //    $data['urgentcargus_preferinte_price'] = $this->request->post['urgentcargus_preferinte_price'];
            //} else {
            //    $data['urgentcargus_preferinte_price'] = $this->config->get('urgentcargus_preferinte_price');
            //}

            if (isset($this->request->post['urgentcargus_preferinte_pickup'])) {
                $data['urgentcargus_preferinte_pickup'] = $this->request->post['urgentcargus_preferinte_pickup'];
            } else {
                $data['urgentcargus_preferinte_pickup'] = $this->config->get('urgentcargus_preferinte_pickup');
            }

            if (isset($this->request->post['urgentcargus_preferinte_pickup_locality'])) {
                $data['urgentcargus_preferinte_pickup_locality'] = $this->request->post['urgentcargus_preferinte_pickup_locality'];
            } else {
                $data['urgentcargus_preferinte_pickup_locality'] = $this->config->get('urgentcargus_preferinte_pickup_locality');
            }

            if (isset($this->request->post['urgentcargus_preferinte_insurance'])) {
                $data['urgentcargus_preferinte_insurance'] = $this->request->post['urgentcargus_preferinte_insurance'];
            } else {
                $data['urgentcargus_preferinte_insurance'] = $this->config->get('urgentcargus_preferinte_insurance');
            }

            if (isset($this->request->post['urgentcargus_preferinte_saturday'])) {
                $data['urgentcargus_preferinte_saturday'] = $this->request->post['urgentcargus_preferinte_saturday'];
            } else {
                $data['urgentcargus_preferinte_saturday'] = $this->config->get('urgentcargus_preferinte_saturday');
            }

            if (isset($this->request->post['urgentcargus_preferinte_morning'])) {
                $data['urgentcargus_preferinte_morning'] = $this->request->post['urgentcargus_preferinte_morning'];
            } else {
                $data['urgentcargus_preferinte_morning'] = $this->config->get('urgentcargus_preferinte_morning');
            }

            if (isset($this->request->post['urgentcargus_preferinte_openpackage'])) {
                $data['urgentcargus_preferinte_openpackage'] = $this->request->post['urgentcargus_preferinte_openpackage'];
            } else {
                $data['urgentcargus_preferinte_openpackage'] = $this->config->get('urgentcargus_preferinte_openpackage');
            }

            if (isset($this->request->post['urgentcargus_preferinte_repayment'])) {
                $data['urgentcargus_preferinte_repayment'] = $this->request->post['urgentcargus_preferinte_repayment'];
            } else {
                $data['urgentcargus_preferinte_repayment'] = $this->config->get('urgentcargus_preferinte_repayment');
            }

            if (isset($this->request->post['urgentcargus_preferinte_payer'])) {
                $data['urgentcargus_preferinte_payer'] = $this->request->post['urgentcargus_preferinte_payer'];
            } else {
                $data['urgentcargus_preferinte_payer'] = $this->config->get('urgentcargus_preferinte_payer');
            }

            if (isset($this->request->post['urgentcargus_preferinte_type'])) {
                $data['urgentcargus_preferinte_type'] = $this->request->post['urgentcargus_preferinte_type'];
            } else {
                $data['urgentcargus_preferinte_type'] = $this->config->get('urgentcargus_preferinte_type');
            }

            if (isset($this->request->post['urgentcargus_preferinte_free'])) {
                $data['urgentcargus_preferinte_free'] = $this->request->post['urgentcargus_preferinte_free'];
            } else {
                $data['urgentcargus_preferinte_free'] = $this->config->get('urgentcargus_preferinte_free');
            }

            if (isset($this->request->post['urgentcargus_preferinte_fixed'])) {
                $data['urgentcargus_preferinte_fixed'] = $this->request->post['urgentcargus_preferinte_fixed'];
            } else {
                $data['urgentcargus_preferinte_fixed'] = $this->config->get('urgentcargus_preferinte_fixed');
            }

            if (isset($this->request->post['urgentcargus_preferinte_noextrakm'])) {
                $data['urgentcargus_preferinte_noextrakm'] = $this->request->post['urgentcargus_preferinte_noextrakm'];
            } else {
                $data['urgentcargus_preferinte_noextrakm'] = $this->config->get('urgentcargus_preferinte_noextrakm');
            }
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
            'href'      => $this->url->link('urgentcargus/preferinte', 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('urgentcargus/preferinte.tpl', $data));
    }

    protected function validate() {
		if (!$this->user->hasPermission('modify', 'urgentcargus/preferinte')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
?>