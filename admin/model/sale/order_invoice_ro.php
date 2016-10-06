<?php
class ModelSaleOrderInvoiceRo extends Model {
	public function getInvoice ($order_id) {
		$invoice_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "rofacturi` WHERE order_id = '" . (int)$order_id . "'");
		return $invoice_query->row;
	}
	public function addInvoice($order_id, $data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "rofacturi` SET order_id = '" . (int)$order_id . "', invoice_id = '".$this->db->escape($data['invoice_id'])."', data = '".$this->db->escape(date('Y-m-d', strtotime($data['data'])))."', void = '".(int)$data['void']."', pb1 = '".(int)$data['pb1']."', pb2 = '".(int)$data['pb2']."', pb3 = '".(int)$data['pb3']."', pb4 = '".(int)$data['pb4']."', pb5 = '".(int)$data['pb5']."', pb6 = '".(int)$data['pb6']."', pb7 = '".(int)$data['pb7']."', pb8 = '".(int)$data['pb8']."', pb9 = '".(int)$data['pb9']."', cumparator = '".$this->db->escape($data['cumparator'])."'");
	}
	public function editInvoice($order_id, $data = array()) {
		$this->db->query("UPDATE `" . DB_PREFIX . "rofacturi` SET invoice_id = '".$this->db->escape($data['invoice_id'])."', data = '".$this->db->escape(date('Y-m-d', strtotime($data['data'])))."', void = '".(int)$data['void']."', pb1 = '".(int)$data['pb1']."', pb2 = '".(int)$data['pb2']."', pb3 = '".(int)$data['pb3']."', pb4 = '".(int)$data['pb4']."', pb5 = '".(int)$data['pb5']."', pb6 = '".(int)$data['pb6']."', pb7 = '".(int)$data['pb7']."', pb8 = '".(int)$data['pb8']."', pb9 = '".(int)$data['pb9']."', cumparator = '".$this->db->escape($data['cumparator'])."' WHERE order_id = '" . (int)$order_id . "'");
	}
	public function DeleteInvoices($min) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "rofacturi` WHERE auto_invoice_id > '".(int)$min."'");
	}
	public function getMaxId() {
		$max = $this->db->query("SELECT MAX(auto_invoice_id) as max FROM `" . DB_PREFIX . "rofacturi`");
		return $max->row['max'];
	}
	public function setAutoIncrement($number) {
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "rofacturi` AUTO_INCREMENT = " .(int)$number);
	}
	public function getAutoIncrement() {
		$ai = $this->db->query("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND  TABLE_NAME = '".DB_PREFIX."rofacturi';");
		if (!$ai->row) return 0;
		return $ai->row['AUTO_INCREMENT'];
	}
}
?>