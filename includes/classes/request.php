<?php
class Request {
	public $get = array();
	public $post = array();
	public $cookie = array();
	public $files = array();
	public $server = array();
	
  	public function __construct() { 
		$this->get = $this->clean($_GET);
		$this->post = $this->clean($_POST);
		$this->request = $this->clean($_REQUEST);
		$this->cookie = $this->clean($_COOKIE);
		$this->files = $this->clean($_FILES);
		$this->server = $this->clean($_SERVER);  
	}
	
  	public function clean($data) { 
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
				unset($data[$key]); 
	    		$data[$this->clean($key)] = $this->clean($value);
	  		}
		} else { 
	  		$data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
		} 
		return $data;
	}
	function getRealIpAddr() {
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet 
				$ip=$_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy 
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
					$ip=$_SERVER['REMOTE_ADDR'];
				}
				return $ip;
	}  
}