<?php
class ControllerModuleRofactura extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/rofactura');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('rofactura', $this->request->post);		

			$this->session->data['success'] = 'Setari salvate cu success';

			$this->response->redirect($this->url->link('module/rofactura', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
        
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/rofactura', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/rofactura', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['stergeFacturi'] = $this->url->link('module/rofactura/stergeFacturi', '', 'SSL');

		$data['token'] = $this->session->data['token'];


		if (isset($this->request->post['rofactura_afis_livrare'])) {
			$data['rofactura_afis_livrare'] = $this->request->post['rofactura_afis_livrare'];
		} else { 
			$data['rofactura_afis_livrare'] = $this->config->get('rofactura_afis_livrare');
		}	

		if (isset($this->request->post['rofactura_livrare_areTVA'])) {
			$data['rofactura_livrare_areTVA'] = $this->request->post['rofactura_livrare_areTVA'];
		} else { 
			$data['rofactura_livrare_areTVA'] = $this->config->get('rofactura_livrare_areTVA');
		}	

		if (isset($this->request->post['rofactura_afis_logo'])) {
			$data['rofactura_afis_logo'] = $this->request->post['rofactura_afis_logo'];
		} else { 
			$data['rofactura_afis_logo'] = $this->config->get('rofactura_afis_logo');
		}	

		if (isset($this->request->post['rofactura_afis_plata'])) {
			$data['rofactura_afis_plata'] = $this->request->post['rofactura_afis_plata'];
		} else { 
			$data['rofactura_afis_plata'] = $this->config->get('rofactura_afis_plata');
		}
		
		if (isset($this->request->post['rofactura_auto_numar'])) {
			$data['rofactura_auto_numar'] = $this->request->post['rofactura_auto_numar'];
		} else { 
			$data['rofactura_auto_numar'] = $this->config->get('rofactura_auto_numar');
		}

		if (isset($this->request->post['rofactura_serie_factura'])) {
			$data['rofactura_serie_factura'] = $this->request->post['rofactura_serie_factura'];
		} else { 
			$data['rofactura_serie_factura'] = $this->config->get('rofactura_serie_factura');
		}

		$this->load->model('sale/order_invoice_ro');
		$ai = $this->model_sale_order_invoice_ro->getAutoIncrement();
		$data['rofactura_nr_factura'] = $ai;

		if (isset($this->request->post['rofactura_date_furnizor'])) {
			$data['rofactura_date_furnizor'] = $this->request->post['rofactura_date_furnizor'];
		} else { 
			$data['rofactura_date_furnizor'] = $this->config->get('rofactura_date_furnizor');
		}

		if (isset($this->request->post['rofactura_afis_furniz'])) {
			$data['rofactura_afis_furniz'] = $this->request->post['rofactura_afis_furniz'];
		} else { 
			$data['rofactura_afis_furniz'] = $this->config->get('rofactura_afis_furniz');
		}

		if (isset($this->request->post['rofactura_afis_dateexp'])) {
			$data['rofactura_afis_dateexp'] = $this->request->post['rofactura_afis_dateexp'];
		} else { 
			$data['rofactura_afis_dateexp'] = $this->config->get('rofactura_afis_dateexp');
		}

		if (isset($this->request->post['rofactura_afis_pdateexp'])) {
			$data['rofactura_afis_pdateexp'] = $this->request->post['rofactura_afis_pdateexp'];
		} else { 
			$data['rofactura_afis_pdateexp'] = $this->config->get('rofactura_afis_pdateexp');
		}

		if (isset($this->request->post['rofactura_afis_delegat'])) {
			$data['rofactura_afis_delegat'] = $this->request->post['rofactura_afis_delegat'];
		} else { 
			$data['rofactura_afis_delegat'] = $this->config->get('rofactura_afis_delegat');
		}

		if (isset($this->request->post['rofactura_afis_ndelegat'])) {
			$data['rofactura_afis_ndelegat'] = $this->request->post['rofactura_afis_ndelegat'];
		} else { 
			$data['rofactura_afis_ndelegat'] = $this->config->get('rofactura_afis_ndelegat');
		}

		if (isset($this->request->post['rofactura_afis_datetransp'])) {
			$data['rofactura_afis_datetransp'] = $this->request->post['rofactura_afis_datetransp'];
		} else { 
			$data['rofactura_afis_datetransp'] = $this->config->get('rofactura_afis_datetransp');
		}

		if (isset($this->request->post['rofactura_date_legal'])) {
			$data['rofactura_date_legal'] = $this->request->post['rofactura_date_legal'];
		} else { 
			$data['rofactura_date_legal'] = $this->config->get('rofactura_date_legal');
		}

		if (isset($this->request->post['rofactura_calctotal'])) {
			$data['rofactura_calctotal'] = $this->request->post['rofactura_calctotal'];
		} else { 
			$data['rofactura_calctotal'] = $this->config->get('rofactura_calctotal');
		}

		if (isset($this->request->post['rofactura_zec_pu'])) {
			$data['rofactura_zec_pu'] = $this->request->post['rofactura_zec_pu'];
		} else { 
			$data['rofactura_zec_pu'] = $this->config->get('rofactura_zec_pu');
		}

		if (isset($this->request->post['rofactura_zec_v'])) {
			$data['rofactura_zec_v'] = $this->request->post['rofactura_zec_v'];
		} else { 
			$data['rofactura_zec_v'] = $this->config->get('rofactura_zec_v');
		}

		if (isset($this->request->post['rofactura_zec_vt'])) {
			$data['rofactura_zec_vt'] = $this->request->post['rofactura_zec_vt'];
		} else { 
			$data['rofactura_zec_vt'] = $this->config->get('rofactura_zec_vt');
		}

		if (isset($this->request->post['rofactura_zec_st'])) {
			$data['rofactura_zec_st'] = $this->request->post['rofactura_zec_st'];
		} else { 
			$data['rofactura_zec_st'] = $this->config->get('rofactura_zec_st');
		}

		if (isset($this->request->post['rofactura_zec_t'])) {
			$data['rofactura_zec_t'] = $this->request->post['rofactura_zec_t'];
		} else { 
			$data['rofactura_zec_t'] = $this->config->get('rofactura_zec_t');
		}

		if (isset($this->request->post['rofactura_setari_total'])) {
			$data['rofactura_setari_total'] = $this->request->post['rofactura_setari_total'];
		} else { 
			$data['rofactura_setari_total'] = $this->config->get('rofactura_setari_total');
		}

		if (isset($this->request->post['rofactura_afis_tara'])) {
			$data['rofactura_afis_tara'] = $this->request->post['rofactura_afis_tara'];
		} else { 
			$data['rofactura_afis_tara'] = $this->config->get('rofactura_afis_tara');
		}
		if (isset($this->request->post['rofactura_afis_telefon'])) {
			$data['rofactura_afis_telefon'] = $this->request->post['rofactura_afis_telefon'];
		} else { 
			$data['rofactura_afis_telefon'] = $this->config->get('rofactura_afis_telefon');
		}
		if (isset($this->request->post['rofactura_afis_email'])) {
			$data['rofactura_afis_email'] = $this->request->post['rofactura_afis_email'];
		} else { 
			$data['rofactura_afis_email'] = $this->config->get('rofactura_afis_email');
		}
		if (isset($this->request->post['rofactura_afis_tva'])) {
			$data['rofactura_afis_tva'] = $this->request->post['rofactura_afis_tva'];
		} else { 
			$data['rofactura_afis_tva'] = $this->config->get('rofactura_afis_tva');
		}

		//Customer Groups and Custom Fields
		
		$this->load->model('customer/customer_group');
		$this->load->model('customer/custom_field');
		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		foreach ($data['customer_groups'] as &$customer_group) {
			$filter_data = array(
				'filter_customer_group_id' => $customer_group['customer_group_id']
				);
			$customer_group['custom_fields'] = $this->model_customer_custom_field->getCustomFields($filter_data);
		}

		if (isset($this->request->post['rofactura_custom_fields_settings'])) {
			$data['rofactura_custom_fields_settings'] = $this->request->post['rofactura_custom_fields_settings'];
		} else { 
			$data['rofactura_custom_fields_settings'] = $this->config->get('rofactura_custom_fields_settings');
		}


		$data['extensii_total'] = array();
		$ordine_extensii_total = array();

		$files = glob(DIR_APPLICATION . 'controller/total/*.php');

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				$this->language->load('total/' . $extension);

			  if ($this->config->get($extension . '_status')) {
				$data['extensii_total'][] = array(
					'name'       => $this->language->get('heading_title'),
					'codename'   => $extension,
					'sort_order' => $this->config->get($extension . '_sort_order'),
				);
				$ordine_extensii_total[] = $this->config->get($extension . '_sort_order');
			  }

			}
		}

		if ($data['extensii_total']) {
			array_multisort($ordine_extensii_total,SORT_NUMERIC,$data['extensii_total']);
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/rofactura.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/rofactura')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['rofactura_auto_numar']) && $this->request->post['rofactura_auto_numar'] && $this->request->post['rofactura_nr_factura']) {
				$this->load->model('sale/order_invoice_ro');
				$max = $this->model_sale_order_invoice_ro->getMaxId();
				if ((int)$this->request->post['rofactura_nr_factura'] < ($max+1)) {
					$this->error['warning'] = 'Numarul de start al facturilor este prea mic. Exista deja facturi cu numar mai mare decat acesta. Numarul minim ce poate fi setat este '. ($max+1) . '. Alternativ puteti sterge toate facturile existente peste numarul '.(int)$this->request->post['rofactura_nr_factura'].' (inclusiv). Dupa stergere o sa reventiti pe aceasta pagina ca sa puteti seta din nou numarul. <a class="btn btn-danger" id="fact-del" data-number="'.((int)$this->request->post['rofactura_nr_factura'] - 1).'">Sterge Facturile</a>';
				} elseif ((int)$this->request->post['rofactura_nr_factura'] > ($max)) {
					$this->model_sale_order_invoice_ro->setAutoIncrement($this->request->post['rofactura_nr_factura']);
				}
			}
		}

		return !$this->error;	
	}

	protected function validatePerm() {
		if (!$this->user->hasPermission('modify', 'module/rofactura')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;	
	}

	public function stergeFacturi() {
		if (isset($this->request->get['deleteOver']) && $this->validatePerm()) {
			$this->load->model('sale/order_invoice_ro');
			$this->model_sale_order_invoice_ro->DeleteInvoices($this->request->get['deleteOver']);
			$this->session->data['success'] = 'Facturile au fost sterse cu success!';
			$this->response->redirect($this->url->link('module/rofactura', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->session->data['success'] = 'Nu poti sterge facturile pentru ca nu ai permisiuni sau nu ai specificat un numar';
			$this->response->redirect($this->url->link('module/rofactura', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."rofacturi (
				`auto_invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  				`order_id` int(11) NOT NULL UNIQUE,
  				`invoice_id` varchar(255) NOT NULL,
  				`data` datetime NOT NULL,
  				`void` int(1) NOT NULL,
  				`pb1` int(2) NOT NULL,
  				`pb2` int(2) NOT NULL,
  				`pb3` int(2) NOT NULL,
  				`pb4` int(2) NOT NULL,
  				`pb5` int(2) NOT NULL,
  				`pb6` int(2) NOT NULL,
  				`pb7` int(2) NOT NULL,
  				`pb8` int(2) NOT NULL,
  				`pb9` int(2) NOT NULL,
  				`cumparator` text,
  				PRIMARY KEY (`auto_invoice_id`)
			) ENGINE=MyISAM COLLATE=utf8_general_ci;");

	}

	public function uninstall() {
		if (isset($this->request->get['delete_table']) && $this->validatePerm()) {
			$this->db->query("DROP TABLE ". DB_PREFIX ."rofacturi");
		}
	}
}
?>