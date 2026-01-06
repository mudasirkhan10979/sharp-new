<?php
class Language {
	private $default = 'english';
	private $directory;
	private $data = array();
 
	public function __construct($directory) {
		$this->directory = $directory->pcUrls;
	}
	
  	public function get($key) {
		// echo "<pre>";print_r($this->data);exit;
   		return (isset($this->data[$key]) ? $this->data[$key] : $key);
  	}
	public function getAll(){
		return $this->data;
	}
	
	public function load($filename) {
		// print "<pre>".print_r($filename,true)."</pre>";
		// print "<pre>".print_r(DIR_LANGUAGE,true)."</pre>";
		// print "<pre>".print_r($this->directory,true)."</pre>";
		// die();
		
		$file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';
		// echo $file;echo '<br>';exit;
    	
		if (file_exists($file)) {
			$_ = array();
	  		
			require($file);
			$this->data = array_merge($this->data, $_);
			return $this->data;
		}
		
		$file = DIR_LANGUAGE . $this->default . '/' . $filename . '.php';
		
		if (file_exists($file)) {
			$_ = array();
	  		
			require($file);
		
			$this->data = array_merge($this->data, $_);
			
			return $this->data;
		} else {
			//trigger_error('Error: Could not load language ' . $filename . '!');
		//	exit();
		}
  	}
}
