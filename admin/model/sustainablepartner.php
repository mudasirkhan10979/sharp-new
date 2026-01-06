<?php
class ModelSustainablePartner extends Model
{
    public function addSustainablePartner($data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        $logo = $this->handleUploadedImage($_FILES["logo"]);
        
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "sustainablepartner` SET 
            status = '" . $status . "', 
            logo = '" . $logo . "',
            added_date = NOW(),
            modify_date = NOW(),
            sort_order = '" . $sortOrder . "'"; 
            
        $this->db->query($insertQuery);
        $sustainablepartner_id = $this->db->getLastId();
        
        foreach ($data['sustainablepartner_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $short_description = $this->db->escape($languageValue['short_description']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "sustainablepartner_description SET 
                sustainablepartner_id = '" . (int)$sustainablepartner_id . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "',
                short_description = '" . $short_description . "'";
                
            $this->db->query($insertDescriptionQuery);
        }
    }

    private function handleUploadedImage($file)
    {
        if (empty($file['name'])) {
            return "";
        }
        $targetDirectory = DIR_IMAGE . "sustainablepartner/";
        $targetFile = $targetDirectory . basename($file["name"]);
        
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($file["name"]);
    }

    public function editSustainablePartner($sustainablepartner_id, $data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);  
        $logo = $this->db->escape($data['logo']);  
        
        if (!empty($_FILES["logo"]["name"])) {
            $logo = $this->handleUploadedImage($_FILES["logo"]);
        }
        
        $updateQuery = "UPDATE `" . DB_PREFIX . "sustainablepartner` SET 
            status = '" . $status . "', 
            logo = '" . $logo . "',
            sort_order = '" . $sortOrder . "',
            modify_date = NOW()
            WHERE id = '" . (int)$sustainablepartner_id . "'";
            
        $this->db->query($updateQuery);
        
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "sustainablepartner_description WHERE sustainablepartner_id = '" . (int)$sustainablepartner_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['sustainablepartner_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $short_description = $this->db->escape($languageValue['short_description']); 
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "sustainablepartner_description SET 
                sustainablepartner_id = '" . (int)$sustainablepartner_id . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "',
                short_description = '" . $short_description . "'";
                
            $this->db->query($insertDescriptionQuery);
        }
    }

    public function deleteSustainablePartner($id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "sustainablepartner_description` WHERE sustainablepartner_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "sustainablepartner` WHERE id = '" . (int)$id . "'");
    }

    public function getSustainablePartner($id)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "sustainablepartner` WHERE id = " . $id;
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getSustainablePartnerDescription($id)
    {
        $sustainablepartner_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "sustainablepartner_description` WHERE sustainablepartner_description.sustainablepartner_id = " . $id;
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $sustainablepartner_description_data[$result['lang_id']] = array( 
                'title' => $result['title'],
                'short_description' => $result['short_description']
            );
        }
        return $sustainablepartner_description_data;
    } 

    public function getSustainablePartners($data)
    {
        $sql = "SELECT sustainablepartner_description.*, sustainablepartner.* FROM `sustainablepartner` 
        LEFT JOIN sustainablepartner_description on sustainablepartner.id = sustainablepartner_description.sustainablepartner_id
        WHERE sustainablepartner_description.lang_id = 1 ORDER BY sustainablepartner.id";
        
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalSustainablePartners()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "sustainablepartner`");
        return $query->row['total'];
    }

    public function updateSustainablePartnerStatus($sustainablepartner_id, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "sustainablepartner` SET status = '" . (int)$status . "' WHERE id = '" . (int)$sustainablepartner_id . "'";
        $this->db->query($sql);
        return true;
    }

    public function deleteSustainableImage($sustainablepartner_id) {
    // Fetch logo name from DB
    $query = $this->db->query("SELECT logo FROM `" . DB_PREFIX . "sustainablepartner` WHERE id = '" . (int)$sustainablepartner_id . "'");
    if ($query->num_rows) {
        $logo = $query->row['logo'];
        if (!empty($logo)) {
            $image_path = DIR_IMAGE . 'sustainablepartner/' . $logo;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "sustainablepartner` SET logo = '' WHERE id = '" . (int)$sustainablepartner_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Sustainable Partner not found'];
    }
  }
}