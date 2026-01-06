<?php
class ModelProductLifecyCleanalysis extends Model
{
	public function addProductlifecycleanalysis($data)
{
    $sortOrder = $this->db->escape($data['sort_order']);
    $status = $this->db->escape($data['status']);
	// $date = $this->db->escape($data['date']);
    $image = $this->handleUploadedImage($_FILES["image"]);
    $insertproductlifecycleanalysisQuery = "INSERT INTO `" . DB_PREFIX . "productlifecycleanalysis` SET 
        status = '" . $status . "', 
		image = '" . $image . "',
        added_date = NOW(),
        modify_date = NOW(),
        sort_order = '" . $sortOrder . "'"; 
    $this->db->query($insertproductlifecycleanalysisQuery);
    $productlifecycleanalysisId = $this->db->getLastId();
    foreach ($data['productlifecycleanalysis_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $short_description = $this->db->escape($languageValue['short_description']);
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "productlifecycleanalysis_description SET 
            productlife__id = '" . (int)$productlifecycleanalysisId . "',
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
		$targetDirectory = DIR_IMAGE . "productlifecycleanalysis/";
		$targetFile = $targetDirectory . basename($file["name"]);
		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}
		move_uploaded_file($file["tmp_name"], $targetFile);
		return $this->db->escape($file["name"]);
	}
	public function editProductlifecycleanalysis($productlife__id, $data)
   {
    $sortOrder = $this->db->escape($data['sort_order']);
    $status = $this->db->escape($data['status']);  
	// $date = $this->db->escape($data['date']);
    $image = $this->db->escape($data['image']);  
    if (!empty($_FILES["image"]["name"])) {
        $image = $this->handleUploadedImage($_FILES["image"]);
    }
    $updateFaqQuery = "UPDATE `" . DB_PREFIX . "productlifecycleanalysis` SET 
        status = '" . $status . "', 
		image = '" . $image . "',
        sort_order = '" . $sortOrder . "',
        modify_date = NOW()
        WHERE id = '" . (int)$productlife__id . "'";
    $this->db->query($updateFaqQuery);
    $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "productlifecycleanalysis_description WHERE productlife__id = '" . (int)$productlife__id . "'";
    $this->db->query($deleteDescriptionQuery);
    foreach ($data['productlifecycleanalysis_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $short_description = $this->db->escape($languageValue['short_description']); 
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "productlifecycleanalysis_description SET 
            productlife__id = '" . (int)$productlife__id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            short_description = '" . $short_description . "'";
        $this->db->query($insertDescriptionQuery);
      }
    }

	public function deleteProductlifecycleanalysis($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "productlifecycleanalysis_description` WHERE productlife__id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "productlifecycleanalysis` WHERE id = '" . (int)$id . "'");
	}
	public function getProductlifecycleanalysiss($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "productlifecycleanalysis` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getgetProductlifecycleanalysisDescription($id)
	{
		$productlifecycleanalysis_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "productlifecycleanalysis_description` WHERE productlifecycleanalysis_description.productlife__id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$productlifecycleanalysis_description_data[$result['lang_id']] = array( 
				'title'       => $result['title'],
				'short_description'       => $result['short_description']
			);
		}
		return $productlifecycleanalysis_description_data;
	} 
	public function getProductlifecycleanalysis($data)
	{
		$sql = "SELECT productlifecycleanalysis_description.*, productlifecycleanalysis.* FROM `productlifecycleanalysis` 
		LEFT JOIN productlifecycleanalysis_description on productlifecycleanalysis.id = productlifecycleanalysis_description.productlife__id
		WHERE productlifecycleanalysis_description.lang_id = 1 ORDER BY productlifecycleanalysis.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalproductlifecycleanalysis()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "productlifecycleanalysis`");
		return $query->row['total'];
	}
    public function updateProductLifecyCleanalysisStatus($productlife__id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "productlifecycleanalysis` SET status = '" . (int)$status . "' WHERE id = '" . (int)$productlife__id . "'";
        $this->db->query($sql);
        return true;
	}

	public function deleteProductLifecyCleanalysisImage($productlife__id) {
    // Fetch image name from DB
    $query = $this->db->query("SELECT image FROM `" . DB_PREFIX . "productlifecycleanalysis` WHERE id = '" . (int)$productlife__id . "'");
    if ($query->num_rows) {
        $image = $query->row['image'];
        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'productlifecycleanalysis/' . $image;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "productlifecycleanalysis` SET image = '' WHERE id = '" . (int)$productlife__id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Product Lifecy Cleanalysis not found'];
    }
}
}