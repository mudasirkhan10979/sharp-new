<?php
class Customer
{
	private $member_id;
	private $member_name;
	private $email;
	private $company_name;
	private $telephone;
	private $lab_id;
	private $customer_verified;
	private $address;
	private $member_pic;

	public function __construct($registry)
	{
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		if (isset($this->session->data['member_id'])) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "members WHERE id = '" . (int)$this->session->data['member_id'] . "' AND status = '1'");
			if ($customer_query->num_rows) {
				$this->member_id = $customer_query->row['id'];
				$this->member_name = $customer_query->row['member_name'];
				$this->email = $customer_query->row['company_email'];
				$this->company_name = $customer_query->row['company_name'];
				$this->telephone = $customer_query->row['phone'];
				$this->lab_id = $customer_query->row['lab_id'];
				$this->address = $customer_query->row['company_address'];
				$this->customer_verified = $customer_query->row['status'];
				$this->member_pic = $customer_query->row['profile_image'];
			} else {
				$this->logout();
			}
		}
	}

	public function login($email, $password, $override = false)
	{
		if ($override) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "members WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
		} else {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "members WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
		}

		if ($customer_query->num_rows) {
			$this->session->data['member_id'] = $customer_query->row['id'];


			$this->member_id = $customer_query->row['id'];
			$this->member_name = $customer_query->row['member_name'];
			$this->email = $customer_query->row['company_email'];
			$this->company_name = $customer_query->row['company_name'];
			$this->telephone = $customer_query->row['phone'];
			$this->lab_id = $customer_query->row['lab_id'];
			$this->address = $customer_query->row['company_address'];
			$this->customer_verified = $customer_query->row['status'];
			$this->member_pic = $customer_query->row['profile_image'];
			return true;
		} else {
			return false;
		}
	}

	public function logout()
	{
		
		unset($this->session->data['member_id']);
		$this->member_id = '';
		$this->member_name = '';
		$this->email = '';
		$this->telephone = '';
		$this->company_name = '';
		$this->address = '';
		$this->customer_verified = '';
		$this->lab_id = '';
		$this->member_pic = '';
	}

	public function isLogged()
	{
		
		return $this->member_id;
	}

	public function getId()
	{
		return $this->member_id;
	}
	public function getLabId()
	{
		return $this->lab_id;
	}
	public function getProfileImage()
	{
		return $this->member_pic;
	}
	public function getFullName()
	{
		return $this->member_name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getTelephone()
	{
		return $this->telephone;
	}
	public function getCompanyName()
	{
		return $this->company_name;
	}
	public function getAddress()
	{
		return $this->address;
	}
	public function isVerified()
	{
		return $this->customer_verified;
	}

}
