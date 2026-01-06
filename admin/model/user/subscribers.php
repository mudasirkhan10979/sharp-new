<?php
class ModelUserSubscribers extends Model {
	 
	public function deleteSubscriber($user_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "subscriber` WHERE id = '" . (int)$user_id . "'");
	} 

	public function getSubscribers($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "subscriber` ORDER BY id DESC";  
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		} 
		$query = $this->db->query($sql); 
		return $query->rows;
	}
	public function export() {

		$output = '';

		$fp = fopen('php://temp', 'r+');

		fputs($fp, $bom = '');

		$query = "SELECT s.email as email_address from subscriber as s ORDER BY s.id DESC";
		
		$results = $this->db->query($query);

		$row = $results->row;

		fputcsv($fp, array_keys($row));

		rewind($fp);

		$output .= fgets($fp);

		$default_store = $this->config->get('config_name');

		foreach ($results->rows as $result) {
			rewind($fp);
			fputcsv($fp, $result);
			rewind($fp);
			$output .= fgets($fp);
		}

		return $output;
	} 
	public function getTotalSubscribers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "subscriber`"); 
		return $query->row['total'];
	}
}