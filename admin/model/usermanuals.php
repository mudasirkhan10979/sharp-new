<?php
class ModelUsermanuals extends Model
{
    public function addManual($data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        $product_id = $this->db->escape($data['product_id']);
        $file = $this->handleUploadedFile($_FILES["file"]);
        $publish_date = $this->db->escape($data['publish_date']);
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "user_manual` SET 
            status = '" . $status . "', 
            file = '" . $file . "',
            product_id = '" . $product_id . "',
            publish_date = '" . $publish_date . "',
            added_date = NOW(),
            modify_date = NOW(),
            sort_order = '" . $sortOrder . "'"; 
            
        $this->db->query($insertQuery);
        $manualId = $this->db->getLastId();
        
        foreach ($data['manual_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "user_manual_description SET 
                manual_id = '" . (int)$manualId . "',
                lang_id = '" . $languageId . "',
                title = '" . $title. "'";
                
            $this->db->query($insertDescriptionQuery);
        }
    }

     private function handleUploadedFile($file) {
        if (empty($file['name'])) {
            return "";
        }
        
        $targetDirectory = DIR_IMAGE . "user_manuals/";
        $targetFile = $targetDirectory . basename($file["name"]);
        
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($file["name"]);
    }

    // private function deleteFile($filename) {
    //     $filepath = DIR_IMAGE . "user_manuals/" . $filename;
    //     if (file_exists($filepath)) {
    //         unlink($filepath);
    //     }
    // }

    public function editManual($manual_id, $data)
    {
      $sortOrder = $this->db->escape($data['sort_order']);
      $product_id = $this->db->escape($data['product_id']);
      $status = $this->db->escape($data['status']);  
      $publish_date = $this->db->escape($data['publish_date']);
      $existingFile = $this->getManual($manual_id)['file'];
      $file = $existingFile; // Default to existing file

      // Only update file if a new one is uploaded
      if (!empty($_FILES["file"]["name"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $file = $this->handleUploadedFile($_FILES["file"]);
        // Optional: Delete old file if you want to clean up storage
        // if (!empty($existingFile)) {
        //     $this->deleteFile($existingFile);
        // }
      }
        
        $updateQuery = "UPDATE `" . DB_PREFIX . "user_manual` SET 
            status = '" . $status . "', 
            file = '" . $file . "',
            sort_order = '" . $sortOrder . "',
            product_id = '" . $product_id . "',
            publish_date = '" . $publish_date . "',
            modify_date = NOW()
            WHERE id = '" . (int)$manual_id . "'";
            
        $this->db->query($updateQuery);
        
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "user_manual_description WHERE manual_id = '" . (int)$manual_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['manual_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "user_manual_description SET 
                manual_id = '" . (int)$manual_id . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "'";

            $this->db->query($insertDescriptionQuery);
        }
    }

    public function deleteManual($id)
    {
        // Get file name before deletion
        // $manualInfo = $this->getManual($id);
        // if ($manualInfo && !empty($manualInfo['file'])) {
        //     $this->deleteFile($manualInfo['file']);
        // }
        
        $this->db->query("DELETE FROM `" . DB_PREFIX . "user_manual_description` WHERE manual_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "user_manual` WHERE id = '" . (int)$id . "'");
    }

    public function getManual($id)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "user_manual` WHERE id = " . (int)$id;
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getManualDescription($id)
    {
        $manual_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "user_manual_description` WHERE manual_id = " . (int)$id;
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $manual_description_data[$result['lang_id']] = array( 
                'title' => $result['title']
            );
        }
        return $manual_description_data;
    } 

  public function getManuals()
    {
            $sql = "SELECT umd.*, um.* 
            FROM `" . DB_PREFIX . "user_manual` um 
            LEFT JOIN `" . DB_PREFIX . "user_manual_description` umd 
            ON um.id = umd.manual_id 
            WHERE umd.lang_id = " . (int)$this->config->get('config_language_id') . " 
            ORDER BY um.id DESC";
         // echo $sql; exit;
        // $sql = "SELECT umd.*, um.* FROM `" . DB_PREFIX . "user_manual` um 
        // LEFT JOIN " . DB_PREFIX . "user_manual_description umd ON um.id = umd.manual_id
        // WHERE umd.lang_id = " . (int)$this->config->get('config_language_id');
        // if (isset($data['order']) && ($data['order'] == 'ASC')) {
        //     $sql .= " ORDER BY um.sort_order ASC";
        // } else {
        //     $sql .= " ORDER BY um.sort_order DESC";
        // }
        // if (isset($data['start']) || isset($data['limit'])) {
        //     if ($data['start'] < 0) {
        //         $data['start'] = 0;
        //     }            
        //     if ($data['limit'] < 1) {
        //         $data['limit'] = 20;
        //     }   
        //     $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        // }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalManuals()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user_manual`");
        return $query->row['total'];
    }

    public function updateManualStatus($manual_id, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "user_manual` SET status = '" . (int)$status . "' WHERE id = '" . (int)$manual_id . "'";
        $this->db->query($sql);
        return true;
    }

     public function getProducts()
 {
       $sql = "SELECT p.product_id, pd.name FROM product p
              LEFT JOIN product_description pd ON p.product_id = pd.product_id
              WHERE pd.lang_id = 1 AND p.publish = 1 ORDER BY p.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
   }
}