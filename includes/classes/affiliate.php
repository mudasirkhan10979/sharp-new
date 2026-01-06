<?php
class Affiliate {
	private $aff_id;
	private $username;
	private $permission = array();
	
	public function __construct($registry) {
		
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		
		if (isset($this->session->data['aff_id'])) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliates WHERE aff_id = '" . (int)$this->session->data['aff_id'] . "' AND status = '1'");
			if ($user_query->num_rows) {
				$this->aff_id = $user_query->row['aff_id'];
				$this->username = $user_query->row['username'];
				
			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password) {
		
		$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliates WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
		
		if ($user_query->num_rows) {
			$this->session->data['aff_id'] = $user_query->row['aff_id']; 
			$this->aff_id = $user_query->row['aff_id'];
			$this->username = $user_query->row['username'];
			
			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['aff_id']); 
		$this->aff_id = '';
		$this->username = '';
	}

	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	} 
	public function isLogged() {
		return $this->aff_id;
	} 
	public function getId() {
		return $this->aff_id;
	}

	public function getUserName() {
		return $this->username;
	}

}