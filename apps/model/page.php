<?php

class ModelPage extends Model {

	public function getPage($page_id) { 
	$query = "SELECT pd.*,p.* FROM " . DB_PREFIX . " pages p 
	    LEFT JOIN pages_description pd ON pd.page_id=p.id WHERE p.id = '" . (int)$page_id . "' AND pd.lang_id='".$this->config->get('config_language_id')."' AND p.publish='1'";
		$query = $this->db->query($query);
		return $query->row;
	} 	
}