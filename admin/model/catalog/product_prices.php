<?php
class ModelCatalogProductPrices extends Model {

	public function getProducts($data = array()) {
		$sql = "SELECT p.product_id, pov.product_option_value_id, p.model, pd.name, concat(od.name, ' - ', ovd.name) as option_name, pov.price as option_price FROM " . DB_PREFIX . "product p
					LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
					LEFT JOIN " . DB_PREFIX . "product_option po on (po.product_id = p.product_id)
					LEFT JOIN " . DB_PREFIX . "option o ON (po.option_id = o.option_id)
					LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id)
					LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (po.product_option_id = pov.product_option_id and pov.product_id = p.product_id)
					LEFT JOIN " . DB_PREFIX . "option_value ov ON (o.option_id = ov.option_id and pov.option_value_id = ov.option_value_id )
					LEFT JOIN " . DB_PREFIX . "option_value_description ovd on (ov.option_value_id = ovd.option_value_id)
				WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
				 	  AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'
				 	  AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'
				 	  ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.option_price',
			'p.option_name',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
//var_export($sql); die;
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalProducts($data = array()) {

		$sql = "SELECT COUNT(DISTINCT pov.product_option_id) AS total
				 FROM " . DB_PREFIX . "product p
					LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
					LEFT JOIN " . DB_PREFIX . "product_option po on (po.product_id = p.product_id)
					LEFT JOIN " . DB_PREFIX . "option o ON (po.option_id = o.option_id)
					LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id)
					LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (po.product_option_id = pov.product_option_id and pov.product_id = p.product_id)
					LEFT JOIN " . DB_PREFIX . "option_value ov ON (o.option_id = ov.option_id and pov.option_value_id = ov.option_value_id )
					LEFT JOIN " . DB_PREFIX . "option_value_description ovd on (ov.option_value_id = ovd.option_value_id)
				WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
				 	  AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'
				 	  AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'
		";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function savePOVPrice($povId, $price) {
		$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET price = '" . (float)$price . "' WHERE product_option_value_id = '" . (int)$povId . "'");
		$this->cache->delete('product');
	}
}
