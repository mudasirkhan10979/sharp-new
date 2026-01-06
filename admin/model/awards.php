<?php
class ModelAwards extends Model
{
	public function addAward($data)
	{
			$sortOrder = $this->db->escape($data['sort_order']);
			$status = $this->db->escape($data['status']);  
			$publish_date = $this->db->escape($data['publish_date']);
			$image = $this->handleUploadedImage($_FILES["image"]);
			$insertawardQuery = "INSERT INTO `" . DB_PREFIX . "awards` SET 
			image = '" . $image . "',
			publish_date = '" . $publish_date . "',   
			status = '" . $status . "', 
			added_date = NOW(),
			modify_date = NOW(),
			sort_order = '" . $sortOrder . "'";
			$this->db->query($insertawardQuery);
			$faqsId = $this->db->getLastId();
			foreach ($data['award_description'] as $languageId => $languageValue) {
				$languageId = (int)$languageId;
				$title = $this->db->escape($languageValue['title']); 
				$short_description = $this->db->escape($languageValue['short_description']); 
				$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "award_description SET 
				award_id = '" . (int)$faqsId . "',
				lang_id = '" . $languageId . "',
				short_description = '" . $short_description . "',
				title = '" . $title . "'";
				$this->db->query($insertDescriptionQuery);
			}
	}
	private function handleUploadedImage($file)
	{
		if (empty($file['name'])) {
			return "";
		}

		$targetDirectory = DIR_IMAGE . "awards/";
		$filename = time().' - '.rand().' - '.$file["name"];
		$targetFile = $targetDirectory . $filename;

		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}

		move_uploaded_file($file["tmp_name"], $targetFile);
		return $this->db->escape($filename);
	}
	public function editAward($award_id, $data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$status = $this->db->escape($data['status']); 
		$publish_date = $this->db->escape($data['publish_date']);
		$image = $this->db->escape($data['image']); 
		if (!empty($_FILES["image"]["name"])) {
			$this->deleteImage($award_id);
			$image = $this->handleUploadedImage($_FILES["image"]);
		}
		$updateFaqQuery = "UPDATE `" . DB_PREFIX . "awards` SET
		image = '" . $image . "', 
	    publish_date = '" . $publish_date . "',  
		status = '" . $status . "', 
		sort_order = '" . $sortOrder . "',
		modify_date = NOW()
	    WHERE id = '" . (int)$award_id . "'";
		$this->db->query($updateFaqQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "award_description WHERE award_id = '" . (int)$award_id . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['award_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']); 
			$short_description = $this->db->escape($languageValue['short_description']); 
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "award_description SET 
            award_id = '" . (int)$award_id . "',
            lang_id = '" . $languageId . "',
            short_description = '" . $short_description . "',
            title = '" . $title . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
	public function deleteAward($id)
	{
		$this->deleteImage($id);
		$this->db->query("DELETE FROM `" . DB_PREFIX . "award_description` WHERE award_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "awards` WHERE id = '" . (int)$id . "'");
	}
	public function deleteImage($id)
	{
		$targetDirectory = DIR_IMAGE . "awards/";
		$hotelImageData = array();
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "awards WHERE id = '" . (int)$id . "'");
		$image = $query->row;  
		$filePath = $targetDirectory . $image['image'];
		if (file_exists($filePath)) {
			unlink($filePath);
		} 
	}
	public function getAward($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "awards` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getAwardDescription($id)
	{
		$award_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "award_description` WHERE award_description.award_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$award_description_data[$result['lang_id']] = array( 
				'title'       => $result['title'],
				'short_description' => $result['short_description']
			);
		}
		return $award_description_data;
	} 
	public function getAwards($data)
	{
		$sql = "SELECT award_description.*, awards.* FROM `awards` 
		LEFT JOIN award_description on awards.id = award_description.award_id
		WHERE award_description.lang_id = 1 ORDER BY awards.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalAwards()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "awards`");
		return $query->row['total'];
	}

	public function updateAwardStatus($award_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "awards` SET status = '" . (int)$status . "' WHERE id = '" . (int)$award_id . "'";
        $this->db->query($sql);
        return true;
	}
}
