<?php
class ControllerModuleRssfeed extends Controller {
	public function index($setting) {
//		var_export($setting);
		static $module = 0;
		
		$this->language->load('module/rssfeed');

      	$data['heading_title'] = $this->language->get('heading_title');
      	$data['text_more'] = $this->language->get('text_more');

		$this->load->model('tool/image');
		
		$data['news'] = array();
		
		$feed_url = $setting['url'];

		// INITIATE CURL. 
		$curl = curl_init(); 

		// CURL SETTINGS. 
		curl_setopt($curl, CURLOPT_URL,"$feed_url"); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0); 

		// GRAB THE XML FILE. 
		$xmlTwitter = curl_exec($curl); 

		curl_close($curl); 

		// SET UP XML OBJECT.
		// Use either one of these, depending on revision of PHP.
		// Comment-out the line you are not using.
		//$xml = new SimpleXMLElement($xmlTwitter);
		$xml = simplexml_load_string($xmlTwitter); 

		// How many items to display 
		$count = $setting['limit'];

		// How many characters from each item 
		// 0 (zero) will show them all. 
		$char = 0; 
		
		foreach ($xml->channel->item as $item) {
			if($char == 0){ 
				$newstring = $item->description; 
			} 
			else{ 
				$newstring = substr($item->description, 0, $char); 
			}
			if($count > 0){ 
				$data['news'][] = array(
					'title' 	=> $item->title,
					'content'	=> $newstring,
					'link'		=> $item->guid
				);
			} 
			$count--;
		}
		
		$data['direction'] = $setting['direction'];

		$this->id = 'rssfeed';

//		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/rssfeed.tpl')) {
//			$this->template = $this->config->get('config_template') . '/template/module/rssfeed.tpl';
//		} else {
//			$this->template = 'default/template/module/rssfeed.tpl';
//		}

		return $this->load->view('module/rssfeed', $data);
	}
}
?>