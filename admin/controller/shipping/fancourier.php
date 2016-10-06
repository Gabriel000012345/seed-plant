<?php
class ControllerShippingFANCourier extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->load->language('shipping/fancourier');
			
		$this->document->setTitle($this->language->get('heading_title'));


		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('fancourier', $this->request->post);
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

                $data['entry_status'] = $this->language->get('entry_status');
                $data['entry_clientid'] = $this->language->get('entry_clientid');
                $data['entry_username'] = $this->language->get('entry_username');
                $data['entry_password'] = $this->language->get('entry_password');
                $data['entry_onlyadm'] = $this->language->get('entry_onlyadm');
                $data['entry_parcel'] = $this->language->get('entry_parcel');
                $data['text_labels'] = $this->language->get('text_labels');
                $data['entry_paymentdest'] = $this->language->get('entry_paymentdest');
                $data['entry_fara_tva'] = $this->language->get('entry_fara_tva');
				
				//afisare pret fara km suplimentari
				$data['entry_fara_km'] = $this->language->get('entry_fara_km');
				//sfarsit afisare pret fara km suplimentari
				
				//afisare pret doar km suplimentari
				$data['entry_doar_km'] = $this->language->get('entry_doar_km');
				//sfarsit afisare pret doar km suplimentari
				
                $data['entry_payment0'] = $this->language->get('entry_payment0');
                $data['text_min_gratuit'] = $this->language->get('text_min_gratuit');
                //alex g valoare fixa
                $data['text_valoare_fixa'] = $this->language->get('text_valoare_fixa');
                //sfarsit valoare fixa
                
                //alex g valoare fixa Bucuresti
                $data['text_valoare_fixa_bucuresti'] = $this->language->get('text_valoare_fixa_bucuresti');
                //sfarsit valoare fixa Bucuresti
                
                $data['entry_ramburs'] = $this->language->get('entry_ramburs');
                $data['entry_totalrb'] = $this->language->get('entry_totalrb');
                $data['entry_contcolector'] = $this->language->get('entry_contcolector');
                $data['entry_paymentrbdest'] = $this->language->get('entry_paymentrbdest');
                $data['entry_asigurare'] = $this->language->get('entry_asigurare');
                $data['entry_content'] = $this->language->get('entry_content');
                $data['entry_comment'] = $this->language->get('entry_comment');
				//boby 02.05.2014 adaugare persoana de contact
				$data['entry_pers_cont_exp'] = $this->language->get('entry_pers_cont_exp');
				//end boby
				//boby 05.05.2014 deschidere la livrare
				$data['entry_deschidere_livrare'] = $this->language->get('entry_deschidere_livrare');
				//end boby
                $data['entry_redcode'] = $this->language->get('entry_redcode');
                $data['entry_express'] = $this->language->get('entry_express');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['clientid'])) {
			$data['error_clientid'] = $this->error['clientid'];
		} else {
			$data['error_clientid'] = '';
		}

		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['labels'])) {
			$data['error_labels'] = $this->error['labels'];
		} else {
			$data['error_labels'] = '';
		}

		if (isset($this->error['min_gratuit'])) {
			$data['error_min_gratuit'] = $this->error['min_gratuit'];
		} else {
			$data['error_min_gratuit'] = '';
		}
		
		//alex g valoare fixa
		if (isset($this->error['valoare_fixa'])) {
			$data['error_valoare_fixa'] = $this->error['valoare_fixa'];
		} else {
			$data['error_valoare_fixa'] = '';
		}
		//sfarsit alex g
		
		//alex g valoare fixa bucuresti
		if (isset($this->error['valoare_fixa_bucuresti'])) {
			$data['error_valoare_fixa_bucuresti'] = $this->error['valoare_fixa_bucuresti'];
		} else {
			$data['error_valoare_fixa_bucuresti'] = '';
		}
		//sfarsit alex g
		

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/fancourier', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('shipping/fancourier', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['fancourier_status'])) {
			$data['fancourier_status'] = $this->request->post['fancourier_status'];
		} else {
			$data['fancourier_status'] = $this->config->get('fancourier_status');
		}

		if (isset($this->request->post['fancourier_clientid'])) {
			$data['fancourier_clientid'] = $this->request->post['fancourier_clientid'];
		} else {
			$data['fancourier_clientid'] = $this->config->get('fancourier_clientid');
		}

		if (isset($this->request->post['fancourier_username'])) {
			$data['fancourier_username'] = $this->request->post['fancourier_username'];
		} else {
			$data['fancourier_username'] = $this->config->get('fancourier_username');
		}
		
		if (isset($this->request->post['fancourier_password'])) {
			$data['fancourier_password'] = $this->request->post['fancourier_password'];
		} else {
			$data['fancourier_password'] = $this->config->get('fancourier_password');
		}

		if (isset($this->request->post['fancourier_onlyadm'])) {
			$data['fancourier_onlyadm'] = $this->request->post['fancourier_onlyadm'];
		} else {
			$data['fancourier_onlyadm'] = $this->config->get('fancourier_onlyadm');
		}

		if (isset($this->request->post['fancourier_parcel'])) {
			$data['fancourier_parcel'] = $this->request->post['fancourier_parcel'];
		} else {
			$data['fancourier_parcel'] = $this->config->get('fancourier_parcel');
		}

		if (isset($this->request->post['fancourier_labels'])) {
			$data['fancourier_labels'] = $this->request->post['fancourier_labels'];
		} else {
			$data['fancourier_labels'] = $this->config->get('fancourier_labels');
		}

		if (isset($this->request->post['fancourier_paymentdest'])) {
			$data['fancourier_paymentdest'] = $this->request->post['fancourier_paymentdest'];
		} else {
			$data['fancourier_paymentdest'] = $this->config->get('fancourier_paymentdest');
		}

		if (isset($this->request->post['fancourier_fara_tva'])) {
			$data['fancourier_fara_tva'] = $this->request->post['fancourier_fara_tva'];
		} else {
			$data['fancourier_fara_tva'] = $this->config->get('fancourier_fara_tva');
		}
		
		//afisare valoare fara km suplimentari
		if (isset($this->request->post['fancourier_fara_km'])) {
			$data['fancourier_fara_km'] = $this->request->post['fancourier_fara_km'];
		} else {
			$data['fancourier_fara_km'] = $this->config->get('fancourier_fara_km');
		}
		//sfarsit afisare valoare fara km suplimentari
		
		//afisare valoare doar km suplimentari
		if (isset($this->request->post['fancourier_doar_km'])) {
			$data['fancourier_doar_km'] = $this->request->post['fancourier_doar_km'];
		} else {
			$data['fancourier_doar_km'] = $this->config->get('fancourier_doar_km');
		}
		//sfarsit afisare valoare doar km suplimentari
			

		if (isset($this->request->post['fancourier_payment0'])) {
			$data['fancourier_payment0'] = $this->request->post['fancourier_payment0'];
		} else {
			$data['fancourier_payment0'] = $this->config->get('fancourier_payment0');
		}

		if (isset($this->request->post['fancourier_min_gratuit'])) {
			$data['fancourier_min_gratuit'] = $this->request->post['fancourier_min_gratuit'];
		} else {
			$data['fancourier_min_gratuit'] = $this->config->get('fancourier_min_gratuit');
		}
		
		//alex g valoare fixa
		if (isset($this->request->post['fancourier_valoare_fixa'])) {
			$data['fancourier_valoare_fixa'] = $this->request->post['fancourier_valoare_fixa'];
		} else {
			$data['fancourier_valoare_fixa'] = $this->config->get('fancourier_valoare_fixa');
		}
		//sfarsit valoare fixa
		
		//alex g valoare fixa bucuresti
		if (isset($this->request->post['fancourier_valoare_fixa_bucuresti'])) {
			$data['fancourier_valoare_fixa_bucuresti'] = $this->request->post['fancourier_valoare_fixa_bucuresti'];
		} else {
			$data['fancourier_valoare_fixa_bucuresti'] = $this->config->get('fancourier_valoare_fixa_bucuresti');
		}
		//sfarsit valoare fixa bucuresti

		if (isset($this->request->post['fancourier_ramburs'])) {
			$data['fancourier_ramburs'] = $this->request->post['fancourier_ramburs'];
		} else {
			$data['fancourier_ramburs'] = $this->config->get('fancourier_ramburs');
		}

		if (isset($this->request->post['fancourier_totalrb'])) {
			$data['fancourier_totalrb'] = $this->request->post['fancourier_totalrb'];
		} else {
			$data['fancourier_totalrb'] = $this->config->get('fancourier_totalrb');
		}

		if (isset($this->request->post['fancourier_contcolector'])) {
			$data['fancourier_contcolector'] = $this->request->post['fancourier_contcolector'];
		} else {
			$data['fancourier_contcolector'] = $this->config->get('fancourier_contcolector');
		}

		if (isset($this->request->post['fancourier_paymentrbdest'])) {
			$data['fancourier_paymentrbdest'] = $this->request->post['fancourier_paymentrbdest'];
		} else {
			$data['fancourier_paymentrbdest'] = $this->config->get('fancourier_paymentrbdest');
		}

		if (isset($this->request->post['fancourier_asigurare'])) {
			$data['fancourier_asigurare'] = $this->request->post['fancourier_asigurare'];
		} else {
			$data['fancourier_asigurare'] = $this->config->get('fancourier_asigurare');
		}

		if (isset($this->request->post['fancourier_content'])) {
			$data['fancourier_content'] = $this->request->post['fancourier_content'];
		} else {
			$data['fancourier_content'] = $this->config->get('fancourier_content');
		}

		if (isset($this->request->post['fancourier_comment'])) {
			$data['fancourier_comment'] = $this->request->post['fancourier_comment'];
		} else {
			$data['fancourier_comment'] = $this->config->get('fancourier_comment');
		}
		
		//boby 02.05.2014 adaugare persoana de contact
		if (isset($this->request->post['pers_contact_expeditor'])) {
			$data['pers_contact_expeditor'] = $this->request->post['pers_contact_expeditor'];
		} else {
			$data['pers_contact_expeditor'] = $this->config->get('pers_contact_expeditor');
		}
		//end boby
		
		//boby 05.05.2014 deschidere la livrare
		if (isset($this->request->post['deschidere_livrare'])) {
			$data['deschidere_livrare'] = $this->request->post['deschidere_livrare'];
		} else {
			$data['deschidere_livrare'] = $this->config->get('deschidere_livrare');
		}
		//end boby

		if (isset($this->request->post['fancourier_redcode'])) {
			$data['fancourier_redcode'] = $this->request->post['fancourier_redcode'];
		} else {
			$data['fancourier_redcode'] = $this->config->get('fancourier_redcode');
		}

		if (isset($this->request->post['fancourier_express'])) {
			$data['fancourier_express'] = $this->request->post['fancourier_express'];
		} else {
			$data['fancourier_express'] = $this->config->get('fancourier_express');
		}
		$deschdiereLivrare = $this->config->get('deschidere_livrare');
		$data['deschidere_livrare'] = isset($deschdiereLivrare) ? $deschdiereLivrare : false;

//		$this->template = 'shipping/fancourier.tpl';
//		$this->children = array(
//			'common/header',
//			'common/footer'
//		);
//
// 		$this->response->setOutput($this->render());

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/fancourier', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/fancourier')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['fancourier_clientid']) {
			$this->error['clientid'] = $this->language->get('error_clientid');
		}
		
		if (!$this->request->post['fancourier_username']) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['fancourier_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}
                
		if (!$this->request->post['fancourier_labels']) {
			$this->error['labels'] = $this->language->get('error_labels');
		}

		if ($this->request->post['fancourier_labels']) {
                        if (!is_numeric($this->request->post['fancourier_labels'])){
                            $this->error['labels'] = $this->language->get('error_labels');
                        }
		}

		if ($this->request->post['fancourier_min_gratuit']) {
                        if (!is_numeric($this->request->post['fancourier_min_gratuit'])){
                            $this->error['min_gratuit'] = $this->language->get('error_min_gratuit');
                        }
		}
		
		//alex g valoare fixa
		if ($this->request->post['fancourier_valoare_fixa']) {
                        if (!is_numeric($this->request->post['fancourier_valoare_fixa'])){
                            $this->error['valoare_fixa'] = $this->language->get('error_valoare_fixa');
                        }
		}
		//sfarsit valoare fixa
		
		//alex g valoare fixa bucuresti
		if ($this->request->post['fancourier_valoare_fixa_bucuresti']) {
                        if (!is_numeric($this->request->post['fancourier_valoare_fixa_bucuresti'])){
                            $this->error['valoare_fixa_bucuresti'] = $this->language->get('error_valoare_fixa_bucuresti');
                        }
		}
		//sfarsit valoare fixa bucuresti
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>