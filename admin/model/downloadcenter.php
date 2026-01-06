<?php
class ModelDownloadcenter extends Model
{
    public function addDownload($data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        $file = $this->handleUploadedFile($_FILES["file"]);
        $product_id = $this->db->escape($data['product_id']);
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "download` SET 
            status = '" . $status . "', 
            file = '" . $file . "',
            product_id = '" . $product_id . "',
            added_date = NOW(),
            modify_date = NOW(),
            sort_order = '" . $sortOrder . "'"; 
            
        $this->db->query($insertQuery);
        $downloadId = $this->db->getLastId();
        
        foreach ($data['download_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "download_description SET 
                download_id = '" . (int)$downloadId . "',
                lang_id = '" . $languageId . "',
                description = '" . $description. "',
                title = '" . $title. "'";
                
            $this->db->query($insertDescriptionQuery);
        }
    }

    // private function handleUploadedImage($file)
    // {
    //     if (empty($file['name'])) {
    //         return "";
    //     }
    //     $targetDirectory = DIR_IMAGE . "download/";
    //     $targetFile = $targetDirectory . basename($file["name"]);
        
    //     if (!is_dir($targetDirectory)) {
    //         mkdir($targetDirectory, 0755, true);
    //     }
    //     move_uploaded_file($file["tmp_name"], $targetFile);
    //     return $this->db->escape($file["name"]);
    // }

    private function handleUploadedFile($file) {
        if (empty($file['name'])) {
            return "";
        }
        
        $targetDirectory = DIR_IMAGE . "download_files/";
        $targetFile = $targetDirectory . basename($file["name"]);
        
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($file["name"]);
    }

    // private function deleteFile($filename) {
    //     $filepath = DIR_IMAGE . "download_files/" . $filename;
    //     if (file_exists($filepath)) {
    //         unlink($filepath);
    //     }
    // }

    public function editDownload($download_id, $data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);  
        $product_id = $this->db->escape($data['product_id']);
        $existingFile = $this->getDownload($download_id)['file'];
        $file = $existingFile; // Default to existing file
      if (!empty($_FILES["file"]["name"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $file = $this->handleUploadedFile($_FILES["file"]);
        // Optional: Delete old file if you want to clean up storage
        // if (!empty($existingFile)) {
        //     $this->deleteFile($existingFile);
        // }
      }
        
        $updateQuery = "UPDATE `" . DB_PREFIX . "download` SET 
            status = '" . $status . "', 
            file = '" . $file . "',
            product_id = '" . $product_id . "',
            sort_order = '" . $sortOrder . "',
            modify_date = NOW()
            WHERE id = '" . (int)$download_id . "'";
            
        $this->db->query($updateQuery);
        
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['download_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "download_description SET 
                download_id = '" . (int)$download_id . "',
                lang_id = '" . $languageId . "',
                description = '" . $description . "',
                title = '" . $title . "'";

            $this->db->query($insertDescriptionQuery);
        }
    }

    public function deleteDownload($id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "download_description` WHERE download_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "download` WHERE id = '" . (int)$id . "'");
    }

    public function getDownload($id)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "download` WHERE id = " . $id;
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getDownloadDescription($id)
    {
        $download_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "download_description` WHERE download_description.download_id = " . $id;
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $download_description_data[$result['lang_id']] = array( 
                'title' => $result['title'],
                'description' => $result['description']
            );
        }
        return $download_description_data;
    } 

    public function getDownloads($data)
    {
        $sql = "SELECT download_description.*, download.* FROM `download` 
        LEFT JOIN download_description on download.id = download_description.download_id
        WHERE download_description.lang_id = 1 ORDER BY download.id";
        
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalDownloads()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "download`");
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

    public function updateDownloadStatus($download_id, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "download` SET status = '" . (int)$status . "' WHERE id = '" . (int)$download_id . "'";
        $this->db->query($sql);
        return true;
    }
}