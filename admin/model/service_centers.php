<?php
class ModelServiceCenters extends Model
{
    public function addServiceCenter($data)
    {
        $sr = (int)$this->db->escape($data['sr']);
        $email = $this->db->escape($data['email']);
        $phone = $this->db->escape($data['phone']);
        $country_id = (int)$this->db->escape($data['country_id']);
        $landline = $this->db->escape($data['landline']);
        $department = $this->db->escape($data['department']);
        $sort_order = (int)$this->db->escape($data['sort_order']);
        $publish = (int)$this->db->escape($data['publish']);
        
        $query = "INSERT INTO `" . DB_PREFIX . "service_centers` SET 
            sr = '" . $sr . "',
            country_id = '" . $country_id . "',
            landline = '" . $landline . "',
            email = '" . $email . "',
            phone = '" . $phone . "',
            department = '" . $department . "',
            sort_order = '" . $sort_order . "',
            publish = '" . $publish . "',
            added_date = NOW(),
            modify_date = NOW()";
            
        $this->db->query($query);
        
        $service_center_id = $this->db->getLastId();
        
        foreach ($data['service_center_description'] as $language_id => $value) {
            $this->addServiceCenterDescription($service_center_id, $language_id, $value);
        }
        
        return $service_center_id;
    }

    public function editServiceCenter($service_center_id, $data)
    {
        $sr = (int)$this->db->escape($data['sr']);
        $email = $this->db->escape($data['email']);
        $phone = $this->db->escape($data['phone']);
        $country_id = (int)$this->db->escape($data['country_id']);
        $landline = $this->db->escape($data['landline']);
        $department = $this->db->escape($data['department']);
        $sort_order = (int)$this->db->escape($data['sort_order']);
        $publish = (int)$this->db->escape($data['publish']);
        
        $query = "UPDATE `" . DB_PREFIX . "service_centers` SET 
            sr = '" . $sr . "',
            email = '" . $email . "',
            phone = '" . $phone . "',
            country_id = '" . $country_id . "',
            landline = '" . $landline . "',
            department = '" . $department . "',
            sort_order = '" . $sort_order . "',
            publish = '" . $publish . "',
            modify_date = NOW()
            WHERE service_center_id = '" . (int)$service_center_id . "'";
            
        $this->db->query($query);
        
        $this->db->query("DELETE FROM `" . DB_PREFIX . "service_centers_description` WHERE service_center_id = '" . (int)$service_center_id . "'");
        
        foreach ($data['service_center_description'] as $language_id => $value) {
            $this->addServiceCenterDescription($service_center_id, $language_id, $value);
        }
    }
    
    private function addServiceCenterDescription($service_center_id, $language_id, $data)
    {
        $service_center_name = $this->db->escape($data['service_center_name']);
        $address = $this->db->escape($data['address']);
        
        $query = "INSERT INTO `" . DB_PREFIX . "service_centers_description` SET 
            service_center_id = '" . (int)$service_center_id . "',
            language_id = '" . (int)$language_id . "',
            service_center_name = '" . $service_center_name . "',
            address = '" . $address . "'";
            
        $this->db->query($query);
    }
    
    public function deleteServiceCenter($service_center_id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "service_centers_description` WHERE service_center_id = '" . (int)$service_center_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "service_centers` WHERE service_center_id = '" . (int)$service_center_id . "'");
    }


	public function getServiceCenter($service_center_id)
	{
		// echo "SELECT * FROM `" . DB_PREFIX . "service_centers` WHERE service_center_id = " . $service_center_id; exit;
		$sql = "SELECT * FROM `" . DB_PREFIX . "service_centers` WHERE service_center_id = " . $service_center_id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getServiceCenterDescriptions($service_center_id)
	{
		$slider_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "service_centers_description` WHERE service_centers_description.service_center_id = " . $service_center_id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$slider_description_data[$result['language_id']] = array( 
				'service_center_name' => $result['service_center_name'], 
				'address' => $result['address']
			);
		}
		return $slider_description_data;
	} 
	public function getServiceCenters($data)
	{
		$sql = "SELECT service_centers_description.*, service_centers.*, country.name as country_name, country.country_id FROM `service_centers`
		LEFT JOIN service_centers_description on service_centers.service_center_id = service_centers_description.service_center_id
		LEFT JOIN country ON service_centers.country_id = country.country_id
		WHERE service_centers_description.language_id = 1 ORDER BY service_centers.service_center_id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalServiceCenters()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "service_centers`");
		return $query->row['total'];
	}

	public function updateServiceCenterStatus($service_center_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "service_centers` SET publish = '" . (int)$status . "' WHERE service_center_id = '" . (int)$service_center_id . "'";
		$this->db->query($sql);
	}

		 public function getCountries()
            {
                $sql = "SELECT c.country_id, c.name 
                        FROM `country` c
                        WHERE c.status = 1 AND c.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                        ORDER BY c.country_id ASC";     
                $query = $this->db->query($sql);
                return $query->rows;
        }
}
