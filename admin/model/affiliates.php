<?php
class ModelAffiliates extends Model {
	public function addUser($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "affiliates` SET mobno = '" . $this->db->escape($data['mobno']) . "',username = '" . $this->db->escape($data['username']) . "',   salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
	} 
	public function editUser($aff_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "affiliates` SET mobno = '" . $this->db->escape($data['mobno']) . "', username = '" . $this->db->escape($data['username']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', status = '" . (int)$data['status'] . "' WHERE aff_id = '" . (int)$aff_id . "'");
		if ($data['password']) {
			$this->db->query("UPDATE `" . DB_PREFIX . "affiliates` SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE aff_id = '" . (int)$aff_id . "'");
		}
	} 
	public function editPassword($aff_id, $password) {
		$this->db->query("UPDATE `" . DB_PREFIX . "affiliates` SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE aff_id = '" . (int)$aff_id . "'");
	} 
	public function editCode($email, $code) {
		$this->db->query("UPDATE `" . DB_PREFIX . "affiliates` SET code = '" . $this->db->escape($code) . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	} 
	public function deleteUser($aff_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "affiliates` WHERE aff_id = '" . (int)$aff_id . "'");
	} 
	public function getAffiliate($affiliate_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "affiliates WHERE aff_id = '" . (int)$affiliate_id . "'");

		return $query->row;
	}
	public function getUser($aff_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "affiliates`  WHERE aff_id = '" . (int)$aff_id . "'");
		return $query->row;
	}  
	
	public function getAffiliates($data = array()) {
		$sql = "SELECT af.* , SUM(CASE WHEN af_keys.status = '1' THEN 1 ELSE 0 END) AS 'keys_available' , SUM(CASE WHEN af_keys.status = '2' THEN 1 ELSE 0 END) AS 'keys_assigned' FROM `" . DB_PREFIX . "affiliates` as af LEFT JOIN aff_license_keys as af_keys ON af.id = af_keys.affliate_id"; 
		
		$sql .= ' WHERE 1 ';
		$sort_data = array(
			'username',
			'status',
			'date_added'
		); 
		
		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%' || username LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode); //$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sql .= "	GROUP BY af.id ";
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY username";
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
		
		
		if ($imploded) {
			$sql .= " HAVING " . implode(" AND  ", $imploded);
		}
		$query = $this->db->query($sql); 
		return $query->rows;
	} 
	public function getAffiliateKeys($data = array()) {
		
		$sql = "SELECT af_keys.* , st_keys.status_text,  c.name , c.email FROM `" . DB_PREFIX . "aff_license_keys` as af_keys LEFT JOIN customer as c ON c.customer_id = af_keys.assigned_to LEFT JOIN aff_keys_statuses as st_keys ON af_keys.status = st_keys.id "; 
		
		$sql .= ' WHERE 1 ';
		$sort_data = array(
			'id',
		); 
		
		if (!empty($data['filter_key'])) {
			$implode[] = "license_key LIKE '%" . $this->db->escape($data['filter_key']) . "%'";
		}
		if (!empty($data['aff_id'])) {
			$implode[] = "affliate_id = '" . $this->db->escape($data['aff_id']) . "'";
		}
		if (!empty($data['filter_date'])) {
			$implode[] = "date_added = '" . date('Y-m-d',strtotime($this->db->escape($data['filter_date']))) . "'";
		}
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode); //$sql .= " AND " . implode(" AND ", $implode);
		}
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY id";
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
		
		
		if ($imploded) {
			$sql .= " HAVING " . implode(" AND  ", $imploded);
		}
		
		$query = $this->db->query($sql); 
		return $query->rows;
	} 
	public function getTotalUsers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "affiliates`"); 
		return $query->row['total'];
	}
	public function getTotalKeys($aff_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "aff_license_keys` WHERE = affliate_id '".$aff_id."'"); 
		return $query->row['total'];
	} 
	public function getUserByUsername($username) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "affiliates` WHERE username = '" . $this->db->escape($username) . "'"); 
		return $query->row;
	} 
	public function getTotalUsersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "affiliates` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		return $query->row['total'];
	}
}