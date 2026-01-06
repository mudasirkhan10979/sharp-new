<?php
class ModelLcareport extends Model
{
    public function addLcareport($data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        $image = $this->handleUploadedImage($_FILES["image"]);
         $pdf = $this->handleUploadedPdf($_FILES["pdf"]);
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "lcareport` SET 
            status = '" . $status . "', 
            image = '" . $image . "',
            pdf = '" . $pdf . "',
            added_date = NOW(),
            modify_date = NOW(),
            sort_order = '" . $sortOrder . "'"; 
            
        $this->db->query($insertQuery);
        $lcareportId = $this->db->getLastId();
        
        foreach ($data['lcareport_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $short_description = $this->db->escape($languageValue['short_description']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "lcareport_description SET 
                lcareport_id = '" . (int)$lcareportId . "',
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
        $targetDirectory = DIR_IMAGE . "lcareport/";
        $targetFile = $targetDirectory . basename($file["name"]);
        
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($file["name"]);
    }

     private function handleUploadedPdf($file) {
        if (empty($file['name'])) {
            return "";
        }
        
        $targetDirectory = DIR_IMAGE . "lcareport_pdfs/";
        $targetFile = $targetDirectory . basename($file["name"]);
        
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($file["name"]);
    }

    private function deletePdfFile($filename) {
        $filepath = DIR_IMAGE . "lcareport_pdfs/" . $filename;
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }

    public function editLcareport($lcareport_id, $data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);  
        $image = $this->db->escape($data['image']);  
        
        if (!empty($_FILES["image"]["name"])) {
            $image = $this->handleUploadedImage($_FILES["image"]);
        }
        $pdf = $this->db->escape($data['existing_pdf']);  
        if (!empty($_FILES["pdf"]["name"])) {
            $pdf = $this->handleUploadedPdf($_FILES["pdf"]);
            // Delete old PDF file if exists
            if (!empty($data['existing_pdf'])) {
                $this->deletePdfFile($data['existing_pdf']);
            }
        }
        
        $updateQuery = "UPDATE `" . DB_PREFIX . "lcareport` SET 
            status = '" . $status . "', 
            image = '" . $image . "',
            pdf = '" . $pdf . "',
            sort_order = '" . $sortOrder . "',
            modify_date = NOW()
            WHERE id = '" . (int)$lcareport_id . "'";
            
        $this->db->query($updateQuery);
        
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "lcareport_description WHERE lcareport_id = '" . (int)$lcareport_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['lcareport_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $short_description = $this->db->escape($languageValue['short_description']); 
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "lcareport_description SET 
                lcareport_id = '" . (int)$lcareport_id . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "',
                short_description = '" . $short_description . "'";
                
            $this->db->query($insertDescriptionQuery);
        }
    }

    public function deleteLcareport($id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "lcareport_description` WHERE lcareport_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "lcareport` WHERE id = '" . (int)$id . "'");
    }

    public function getLcareport($id)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "lcareport` WHERE id = " . $id;
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getLcareportDescription($id)
    {
        $lcareport_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "lcareport_description` WHERE lcareport_description.lcareport_id = " . $id;
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $lcareport_description_data[$result['lang_id']] = array( 
                'title' => $result['title'],
                'short_description' => $result['short_description']
            );
        }
        return $lcareport_description_data;
    } 

    public function getLcareports($data)
    {
        $sql = "SELECT lcareport_description.*, lcareport.* FROM `lcareport` 
        LEFT JOIN lcareport_description on lcareport.id = lcareport_description.lcareport_id
        WHERE lcareport_description.lang_id = 1 ORDER BY lcareport.id";
        
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalLcareports()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "lcareport`");
        return $query->row['total'];
    }

    public function updateLcareportStatus($lcareport_id, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "lcareport` SET status = '" . (int)$status . "' WHERE id = '" . (int)$lcareport_id . "'";
        $this->db->query($sql);
        return true;
    }

    public function deletelcareportImage($lcareport_id) {
    // Fetch image name from DB
    $query = $this->db->query("SELECT image FROM `" . DB_PREFIX . "lcareport` WHERE id = '" . (int)$lcareport_id . "'");
    if ($query->num_rows) {
        $image = $query->row['image'];
        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'lcareport/' . $image;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "lcareport` SET image = '' WHERE id = '" . (int)$lcareport_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Lcareport not found'];
    }
  }
}