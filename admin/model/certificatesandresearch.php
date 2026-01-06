<?php
class ModelCertificatesAndResearch extends Model
{
	public function addCertificatesAndResearch($data)
	{
			$sortOrder = $this->db->escape($data['sort_order']);
			$status = $this->db->escape($data['status']);  
			$date = $this->db->escape($data['date']);
			$image = $this->handleUploadedImage($_FILES["image"]);
			$insertcertificatesandresearchQuery = "INSERT INTO `" . DB_PREFIX . "certificatesandresearch` SET 
			image = '" . $image . "',   
			status = '" . $status . "', 
			date = '" . $date . "',
			added_date = NOW(),
			modify_date = NOW(),
			sort_order = '" . $sortOrder . "'";
			$this->db->query($insertcertificatesandresearchQuery);
			$faqsId = $this->db->getLastId();
			foreach ($data['certificatesandresearch_description'] as $languageId => $languageValue) {
				$languageId = (int)$languageId;
				$title = $this->db->escape($languageValue['title']);  
				$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "certificatesandresearch_description SET 
				certificatesandresearch_id = '" . (int)$faqsId . "',
				lang_id = '" . $languageId . "',
				title = '" . $title . "'";
				$this->db->query($insertDescriptionQuery);
			}
	}
	private function handleUploadedImage($file)
	{
		if (empty($file['name'])) {
			return "";
		}
		$targetDirectory = DIR_IMAGE . "certificatesandresearch/";
		$filename = time().' - '.rand().' - '.$file["name"];
		$targetFile = $targetDirectory . $filename;
		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}
		move_uploaded_file($file["tmp_name"], $targetFile);
		return $this->db->escape($filename);
	}
	public function editCertificatesAndResearch($certificatesandresearch_id, $data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$status = $this->db->escape($data['status']); 
		$date = $this->db->escape($data['date']);
		$image = $this->db->escape($data['image']); 
		if (!empty($_FILES["image"]["name"])) {
			$this->deleteImage($certificatesandresearch_id);
			$image = $this->handleUploadedImage($_FILES["image"]);
		}
		$updateFaqQuery = "UPDATE `" . DB_PREFIX . "certificatesandresearch` SET
		image = '" . $image . "', 
		status = '" . $status . "', 
		date = '" . $date . "',
		sort_order = '" . $sortOrder . "',
		modify_date = NOW()
	    WHERE id = '" . (int)$certificatesandresearch_id . "'";
		$this->db->query($updateFaqQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "certificatesandresearch_description WHERE certificatesandresearch_id = '" . (int)$certificatesandresearch_id . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['certificatesandresearch_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']); 
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "certificatesandresearch_description SET 
            certificatesandresearch_id = '" . (int)$certificatesandresearch_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
	public function deleteCertificatesAndResearch($id)
	{
		$this->deleteImage($id);
		$this->db->query("DELETE FROM `" . DB_PREFIX . "certificatesandresearch_description` WHERE certificatesandresearch_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "certificatesandresearch` WHERE id = '" . (int)$id . "'");
	}
	public function deleteImage($id)
	{
		$targetDirectory = DIR_IMAGE . "certificatesandresearch/";
		$hotelImageData = array();
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "certificatesandresearch WHERE id = '" . (int)$id . "'");
		$image = $query->row;  
		$filePath = $targetDirectory . $image['image'];
		if (file_exists($filePath)) {
			unlink($filePath);
		} 
	}
	public function getCertificatesAndResearch($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "certificatesandresearch` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getCertificatesAndResearchDescription($id)
	{
		$certificatesandresearch_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "certificatesandresearch_description` WHERE certificatesandresearch_description.certificatesandresearch_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$certificatesandresearch_description_data[$result['lang_id']] = array( 
				'title'       => $result['title']
			);
		}
		return $certificatesandresearch_description_data;
	} 
	public function getCertificatesAndResearchs($data)
	{
		$sql = "SELECT certificatesandresearch_description.*, certificatesandresearch.* FROM `certificatesandresearch` 
		LEFT JOIN certificatesandresearch_description on certificatesandresearch.id = certificatesandresearch_description.certificatesandresearch_id
		WHERE certificatesandresearch_description.lang_id = 1 ORDER BY certificatesandresearch.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalCertificatesAndResearchs()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "certificatesandresearch`");
		return $query->row['total'];
	}

	public function updateCertificatesAndResearchStatus($certificatesandresearch_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "certificatesandresearch` SET status = '" . (int)$status . "' WHERE id = '" . (int)$certificatesandresearch_id . "'";
        $this->db->query($sql);
        return true;
	}

	public function deleteCertificatesAndResearchImage($certificatesandresearch_id) {
    // Fetch image name from DB
    $query = $this->db->query("SELECT image FROM `" . DB_PREFIX . "certificatesandresearch` WHERE id = '" . (int)$certificatesandresearch_id . "'");
    if ($query->num_rows) {
        $image = $query->row['image'];
        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'certificatesandresearch/' . $image;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "certificatesandresearch` SET image = '' WHERE id = '" . (int)$certificatesandresearch_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Certificatesandresearch not found'];
    }
}
}
