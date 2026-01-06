<?php
class ModelSliders extends Model
{
	public function addSlider($data)
{
    $sortOrder = $this->db->escape($data['sort_order']);
    $status = $this->db->escape($data['status']);
	$url = $this->db->escape($data['url']);
    $image = $this->handleUploadedImage($_FILES["image"]);
    $video_url = $this->db->escape($data['video_url']);
    $content_type = $this->db->escape($data['content_type']);
    $insertSliderQuery = "INSERT INTO `" . DB_PREFIX . "sliders` SET 
        image = '" . $image . "', 
		video_url = '" . $video_url . "',
		content_type = '" . $content_type . "',
        status = '" . $status . "', 
		url = '" . $url . "',
        added_date = NOW(),
        modify_date = NOW(),
        sort_order = '" . $sortOrder . "'"; 
    $this->db->query($insertSliderQuery);
    $faqsId = $this->db->getLastId();
    foreach ($data['slider_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $second_title = $this->db->escape($languageValue['second_title']);
        $short_description = $this->db->escape($languageValue['short_description']);
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "slider_description SET 
            slider_id = '" . (int)$faqsId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            second_title = '" . $second_title . "',
            short_description = '" . $short_description . "'";
        $this->db->query($insertDescriptionQuery);
    }
}

	private function handleUploadedImage($file)
	{
		if (empty($file['name'])) {
			return "";
		}
		$targetDirectory = DIR_IMAGE . "sliders/";
		$fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
		$uniqueFileName = pathinfo($file["name"], PATHINFO_FILENAME) . '_' . time() . '.' . $fileExtension;
		$targetFile = $targetDirectory . $uniqueFileName;
		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}
		move_uploaded_file($file["tmp_name"], $targetFile);
	
		return $this->db->escape($uniqueFileName);
	}

	public function editBanner($slider_id, $data)
{
    $sortOrder = $this->db->escape($data['sort_order']);
    $status = $this->db->escape($data['status']);  
    $image = $this->db->escape($data['image']); 
    $url = $this->db->escape($data['url']);  
	$video_url = $this->db->escape($data['video_url']);  
    $content_type = $this->db->escape($data['content_type']);  
    if (!empty($_FILES["image"]["name"])) {
        $image = $this->handleUploadedImage($_FILES["image"]);
    }
    $updateFaqQuery = "UPDATE `" . DB_PREFIX . "sliders` SET
        image = '" . $image . "', 
		video_url = '" . $video_url . "',
		content_type = '" . $content_type . "',
        status = '" . $status . "', 
		url = '" . $url . "',
        sort_order = '" . $sortOrder . "',
        modify_date = NOW()
        WHERE id = '" . (int)$slider_id . "'";
    $this->db->query($updateFaqQuery);
    $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "slider_description WHERE slider_id = '" . (int)$slider_id . "'";
    $this->db->query($deleteDescriptionQuery);
    foreach ($data['slider_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $second_title = $this->db->escape($languageValue['second_title']);
        $short_description = $this->db->escape($languageValue['short_description']); 
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "slider_description SET 
            slider_id = '" . (int)$slider_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            second_title = '" . $second_title . "',
            short_description = '" . $short_description . "'";
        $this->db->query($insertDescriptionQuery);
    }
}

	public function deleteSlider($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "slider_description` WHERE slider_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "sliders` WHERE id = '" . (int)$id . "'");
	}
	public function getSlider($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "sliders` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getSliderDescription($id)
	{
		$slider_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "slider_description` WHERE slider_description.slider_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$slider_description_data[$result['lang_id']] = array( 
				'title'       => $result['title'],
                'second_title'       => $result['second_title'],
				'short_description'       => $result['short_description']
			);
		}
		return $slider_description_data;
	} 
	public function getSliders($data)
	{
		$sql = "SELECT slider_description.*, sliders.* FROM `sliders` 
		LEFT JOIN slider_description on sliders.id = slider_description.slider_id
		WHERE slider_description.lang_id = 1 ORDER BY sliders.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalSliders()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "sliders`");
		return $query->row['total'];
	}
    public function updateSliderStatus($slider_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "sliders` SET status = '" . (int)$status . "' WHERE id = '" . (int)$slider_id . "'";
        $this->db->query($sql);
        return true;
	}


public function deleteSliderImage($slider_id) {
    // Fetch image name from DB
    $query = $this->db->query("SELECT image FROM `" . DB_PREFIX . "sliders` WHERE id = '" . (int)$slider_id . "'");
    if ($query->num_rows) {
        $image = $query->row['image'];
        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'sliders/' . $image;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "sliders` SET image = '' WHERE id = '" . (int)$slider_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Slider not found'];
    }
}
}