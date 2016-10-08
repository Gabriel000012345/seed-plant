<?php
class ControllerModuleUrgentCargus extends Controller {
	public function localitati() {
		// instantiez clasa urgent
        require(DIR_APPLICATION.'model/shipping/urgentcargusclass.php');
        $this->model_shipping_urgentcargusclass = new ModelShippingUrgentCargusClass();

        // setez url si key
        $this->model_shipping_urgentcargusclass->SetKeys($this->config->get('urgentcargus_api_url'), $this->config->get('urgentcargus_api_key'));

        // UC login user
        $fields = array(
            'UserName' => $this->config->get('urgentcargus_username'),
            'Password' => $this->config->get('urgentcargus_password')
        );
        $token = $this->model_shipping_urgentcargusclass->CallMethod('LoginUser', $fields, 'POST');

        // extrag datele judetului intern pe baza id-ului
        $this->load->model('localisation/zone');
        $judet = $this->model_localisation_zone->getZone($this->request->get['judet']);

        // obtin lista de judete din api
        $judete = array();
        $dataJudete = $this->model_shipping_urgentcargusclass->CallMethod('Counties?countryId=1', array(), 'GET', $token);
        foreach ($dataJudete as $val) {
            $judete[strtolower($val['Abbreviation'])] = $val['CountyId'];
        }

        // obtin lista de localitati pe baza abrevierii judetului
        $localitati = $this->model_shipping_urgentcargusclass->CallMethod('Localities?countryId=1&countyId='.$judete[strtolower($judet['code'])], array(), 'GET', $token);

        // generez options pentru dropdown
        if (count($localitati) > 1) {
            echo '<option value="" km="0">-</option>'."\n";
        }
        foreach ($localitati as $row) {
            echo '<option'.(trim(strtolower($this->request->get['val'])) == trim(strtolower($row['Name'])) ? ' selected="selected"' : '').' km="'.($row['InNetwork'] ? 0 : (!$row['ExtraKm'] ? 0 : $row['ExtraKm'])).'">'.$row['Name'].'</option>'."\n";
        }
	}
}
?>