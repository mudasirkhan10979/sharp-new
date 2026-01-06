<?php
class Api {
	
	public function __construct($registry) {
		
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
	}

	public function getId() {
		return $this->user_id;
	}

}