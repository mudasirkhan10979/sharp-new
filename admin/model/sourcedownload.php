<?php
class ModelSourcedownload extends Model
{
    public function addSourceCode($data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        $file = $this->handleUploadedFile($_FILES["file"]);
        $product_id = $this->db->escape($data['product_id']);
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "source_code` SET 
            status = '" . $status . "', 
            file = '" . $file . "',
             product_id = '" . $product_id . "',
            added_date = NOW(),
            modify_date = NOW(),
            sort_order = '" . $sortOrder . "'"; 
            
        $this->db->query($insertQuery);
        $sourceId = $this->db->getLastId();
        
        foreach ($data['source_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "source_code_description SET 
                source_id = '" . (int)$sourceId . "',
                lang_id = '" . $languageId . "',
                title = '" . $title. "'";
                
            $this->db->query($insertDescriptionQuery);
        }
    }


  private function handleUploadedFile($file) {
        if (empty($file['name'])) {
            return "";
        }
        
        $targetDirectory = DIR_IMAGE . "source_code_files/";
        $targetFile = $targetDirectory . basename($file["name"]);
        
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($file["name"]);
    }

    // private function deleteFile($filename) {
    //     $filepath = DIR_IMAGE . "source_code_files/" . $filename;
    //     if (file_exists($filepath)) {
    //         unlink($filepath);
    //     }
    // }


    public function editSourceCode($source_id, $data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);  
        $product_id = $this->db->escape($data['product_id']);
        $file = $this->db->escape($data['existing_file']);  
        
        if (!empty($_FILES["file"]["name"])) {
            $file = $this->handleUploadedFile($_FILES["file"]);
            // Delete old file if exists
            // if (!empty($data['existing_file'])) {
            //     $this->deleteFile($data['existing_file']);
            // }
        }

        $updateQuery = "UPDATE `" . DB_PREFIX . "source_code` SET 
            status = '" . $status . "', 
            file = '" . $file . "',
            product_id = '" . $product_id . "',
            sort_order = '" . $sortOrder . "',
            modify_date = NOW()
            WHERE id = '" . (int)$source_id . "'";
            
        $this->db->query($updateQuery);
        
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "source_code_description WHERE source_id = '" . (int)$source_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['source_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "source_code_description SET 
                source_id = '" . (int)$source_id . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "'";

            $this->db->query($insertDescriptionQuery);
        }
    }

    public function deleteSourceCode($id)
    {
        // Get file name before deletion
        // $sourceInfo = $this->getSourceCode($id);
        // if ($sourceInfo && !empty($sourceInfo['file'])) {
        //     $this->deleteFile($sourceInfo['file']);
        // }
        
        $this->db->query("DELETE FROM `" . DB_PREFIX . "source_code_description` WHERE source_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "source_code` WHERE id = '" . (int)$id . "'");
    }

    public function getSourceCode($id)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "source_code` WHERE id = " . (int)$id;
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getSourceDescription($id)
    {
        $source_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "source_code_description` WHERE source_id = " . (int)$id;
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $source_description_data[$result['lang_id']] = array( 
                'title' => $result['title']
            );
        }
        return $source_description_data;
    } 

    public function getSourceCodes()
    {
            $sql = "SELECT scd.*, sc.* 
            FROM `" . DB_PREFIX . "source_code` sc 
            LEFT JOIN `" . DB_PREFIX . "source_code_description` scd 
            ON sc.id = scd.source_id 
            WHERE scd.lang_id = " . (int)$this->config->get('config_language_id') . " 
            ORDER BY sc.id DESC";
        
        // if (isset($data['order']) && ($data['order'] == 'ASC')) {
        //     $sql .= " ORDER BY sc.sort_order ASC";
        // } else {
        //     $sql .= " ORDER BY sc.sort_order DESC";
        // }
        
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalSourceCodes()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "source_code`");
        return $query->row['total'];
    }

     public function getProducts()
 {
       $sql = "SELECT p.product_id, pd.name FROM product p
              LEFT JOIN product_description pd ON p.product_id = pd.product_id
              WHERE pd.lang_id = 1 AND p.publish = 1 ORDER BY p.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
   }

    public function updateSourceStatus($source_id, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "source_code` SET status = '" . (int)$status . "' WHERE id = '" . (int)$source_id . "'";
        $this->db->query($sql);
        return true;
    }
}