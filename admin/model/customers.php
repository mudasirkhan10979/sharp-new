<?php
class ModelCustomers extends Model {
	
	public function editToken($customer_id, $token) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = '" . $this->db->escape($token) . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function deleteCustomer($customer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
        // echo "<pre>";
        // print_r($query);exit();
		return $query->row;
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getCustomers($data = array()) {
		
		$sql = "SELECT c.* , CONCAT(af.firstname, ' ', af.lastname) as aff_name FROM " . DB_PREFIX . "customer c LEFT JOIN affiliates af ON c.aff_id = af.id";
		// print_r($sql);exit(); 
		$sql .= ' WHERE 1 ';
		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "c.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_key'])) {
			$implode[] = "c.license_key LIKE '" . $this->db->escape($data['filter_key']) . "%'";
		}
		if (!empty($data['filter_aff_name'])) {
			$implode[] = "CONCAT(af.firstname, ' ', af.lastname) LIKE '" . $this->db->escape($data['filter_aff_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['user_id']) && !is_null($data['user_id'])) {
			$implode[] = "user_id = '" . (int)$data['user_id'] . "'";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode); //$sql .= " AND " . implode(" AND ", $implode);
		}

		$sql .= " GROUP BY customer_id";

		if ($imploded) {
			$sql .= " HAVING " . implode(" AND  ", $imploded);
		}

		// echo $sql;exit();

		$sort_data = array(
			'name',
			'email',
			'status',
			'date_added',
			'type',
		);
		// print_r($sort_data);exit();

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY customer_id";
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
		//echo $sql;exit();
		$query = $this->db->query($sql);

  //        echo "<pre>";
		// print_r($query);exit();

		return $query->rows;
	}

	public function getTotalCustomers($data = array()) {
		
		$sql = "SELECT COUNT(*) as 'total' FROM " . DB_PREFIX . "customer c LEFT JOIN affiliates af ON c.aff_id = af.id";
		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "c.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_key'])) {
			$implode[] = "c.license_key LIKE '" . $this->db->escape($data['filter_key']) . "'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (!empty($data['filter_aff_name'])) {
			$implode[] = "CONCAT(af.firstname, ' ', af.lastname) LIKE '" . $this->db->escape($data['filter_aff_name']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		if ($imploded) {
			$sql .= " HAVING " . implode(" AND  ", $imploded);
		}
		//echo $sql;exit;

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getCustomerstoexport($data = array() , $user_id = '') 
	{ 
	
		$sql = "SELECT customer_id,type,firstname,lastname,email,company_name,designation,mobile_no,gender,address,country_id,state,dob,date_added FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "country occ ON (c.country=occ.country_id)"; 
		$implode = array(); 
		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		} 
		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		} 	 	
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}  	
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		} 	
		if (!empty($user_id)) {
			$implode[] = "DATE(c.user_id) = '" . $this->db->escape($user_id) . "'";
		} 
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		} 
		$sort_data = array(
			'type',
			'firstname',
			'lastname',
			'c.email',
			'c.company_name',
			'c.designation',
			'c.mobile_no',
			'customer_group',
			'c.status',
			'c.approved',
			'c.ip',
			'c.date_added'
		);	 
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY firstname";	
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
		
		$query = $this->db->query($sql); 
		return $query->rows;	
	}
	

}