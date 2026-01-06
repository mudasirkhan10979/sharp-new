<?php
class ModelOurhistories extends Model
{
	public function addHistory($data)
{
    $sortOrder = $this->db->escape($data['sort_order']);
    $status = $this->db->escape($data['status']);
	$date = $this->db->escape($data['date']);
    $image = $this->handleUploadedImage($_FILES["image"]);
    $inserthistoryQuery = "INSERT INTO `" . DB_PREFIX . "ourhistory` SET 
        status = '" . $status . "', 
		image = '" . $image . "',
		date = '" . $date . "',
        added_date = NOW(),
        modify_date = NOW(),
        sort_order = '" . $sortOrder . "'"; 
    $this->db->query($inserthistoryQuery);
    $historiesId = $this->db->getLastId();
    foreach ($data['ourhistories_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $short_description = $this->db->escape($languageValue['short_description']);
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "ourhistories_description SET 
            history_id = '" . (int)$historiesId . "',
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
		$targetDirectory = DIR_IMAGE . "ourhistories/";
		$targetFile = $targetDirectory . basename($file["name"]);
		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}
		move_uploaded_file($file["tmp_name"], $targetFile);
		return $this->db->escape($file["name"]);
	}
	public function editHistory($history_id, $data)
   {
    $sortOrder = $this->db->escape($data['sort_order']);
    $status = $this->db->escape($data['status']);  
	$date = $this->db->escape($data['date']);
    $image = $this->db->escape($data['image']);  
    if (!empty($_FILES["image"]["name"])) {
        $image = $this->handleUploadedImage($_FILES["image"]);
    }
    $updateFaqQuery = "UPDATE `" . DB_PREFIX . "ourhistory` SET 
        status = '" . $status . "', 
		image = '" . $image . "',
		date = '" . $date . "',
        sort_order = '" . $sortOrder . "',
        modify_date = NOW()
        WHERE id = '" . (int)$history_id . "'";
    $this->db->query($updateFaqQuery);
    $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "ourhistories_description WHERE history_id = '" . (int)$history_id . "'";
    $this->db->query($deleteDescriptionQuery);
    foreach ($data['ourhistories_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $short_description = $this->db->escape($languageValue['short_description']); 
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "ourhistories_description SET 
            history_id = '" . (int)$history_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            short_description = '" . $short_description . "'";
        $this->db->query($insertDescriptionQuery);
      }
    }
	public function deleteHistory($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "ourhistories_description` WHERE history_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "ourhistory` WHERE id = '" . (int)$id . "'");
	}
	public function getHistory($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "ourhistory` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getHistoryDescription($id)
	{
		$ourhistories_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "ourhistories_description` WHERE ourhistories_description.history_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$ourhistories_description_data[$result['lang_id']] = array( 
				'title'       => $result['title'],
				'short_description'       => $result['short_description']
			);
		}
		return $ourhistories_description_data;
	} 
	public function getHistories($data)
	{
		$sql = "SELECT ourhistories_description.*, ourhistory.* FROM `ourhistory` 
		LEFT JOIN ourhistories_description on ourhistory.id = ourhistories_description.history_id
		WHERE ourhistories_description.lang_id = 1 ORDER BY ourhistory.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalhistories()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "ourhistory`");
		return $query->row['total'];
	}
    public function updateHistoriesStatus($history_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "ourhistory` SET status = '" . (int)$status . "' WHERE id = '" . (int)$history_id . "'";
        $this->db->query($sql);
        return true;
	}

	public function deleteOurHistoryImage($history_id) {
    // Fetch image name from DB
    $query = $this->db->query("SELECT image FROM `" . DB_PREFIX . "ourhistory` WHERE id = '" . (int)$history_id . "'");
    if ($query->num_rows) {
        $image = $query->row['image'];
        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'ourhistories/' . $image;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "ourhistory` SET image = '' WHERE id = '" . (int)$history_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Our History not found'];
    }
}
}