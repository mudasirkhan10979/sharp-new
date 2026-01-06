<?php
class ModelLocations extends Model
{
	public function addLocation($data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish = $this->db->escape($data['publish']);   
		$insertblogQuery = "INSERT INTO `" . DB_PREFIX . "locations` SET 
        publish_date = NOW(), 
		publish = '" . $publish . "',  
        added_date = NOW(),
		modify_date = NOW(),
		sort_order = '" . $sortOrder . "'";
		$this->db->query($insertblogQuery);
		$locationId = $this->db->getLastId();
		foreach ($data['location_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']); 
			$description = $this->db->escape($languageValue['description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "location_description SET 
            location_id = '" . (int)$locationId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "', 
            description = '" . $description . "'";
			$this->db->query($insertDescriptionQuery);
		}
	} 
	public function editLocation($locationId, $data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish = $this->db->escape($data['publish']);  

		$updateFaqQuery = "UPDATE `" . DB_PREFIX . "locations` SET 
		publish = '" . $publish . "', 
		sort_order = '" . $sortOrder . "',
		modify_date = NOW()
	    WHERE id = '" . (int)$locationId . "'";
		$this->db->query($updateFaqQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "location_description WHERE location_id = '" . (int)$locationId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['location_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']); 
			$description = $this->db->escape($languageValue['description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "location_description SET 
            location_id = '" . (int)$locationId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "', 
            description = '" . $description  . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
	public function deleteLocation($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "location_description` WHERE location_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "locations` WHERE id = '" . (int)$id . "'");
	}
	public function getLocation($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "locations` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getLocationDescription($id)
	{
		$slider_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "location_description` WHERE location_description.location_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$slider_description_data[$result['lang_id']] = array( 
				'title'       => $result['title'], 
				'description'       => $result['description']
			);
		}
		return $slider_description_data;
	} 
	public function getLocations($data)
	{
		$sql = "SELECT location_description.*, locations.* FROM `locations` 
		LEFT JOIN location_description on locations.id = location_description.location_id
		WHERE location_description.lang_id = 1 ORDER BY locations.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalLocations()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "locations`");
		return $query->row['total'];
	}

	public function updatelocationStatus($location_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "locations` SET publish = '" . (int)$status . "' WHERE id = '" . (int)$location_id . "'";
		$this->db->query($sql);
	}
}
