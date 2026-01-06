<?php
class ModelBlockImages extends Model
{
	public function addBlockImage($data)
	{

		$publish = $this->db->escape($data['publish']);
		$image = $this->handleUploadedImage($_FILES["image"]);
		$insertBlockQuery = "INSERT INTO `" . DB_PREFIX . "blockimages` SET 
		date_added = NOW(),
		publish = '" . $publish . "',
		date_modified = NOW(),
        image = '" . $image . "'";
		$this->db->query($insertBlockQuery);
		$blockId = $this->db->getLastId();
		foreach ($data['block_images_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$on_page = $this->db->escape($languageValue['on_page']);
			$unique_text = $this->db->escape($languageValue['unique_text']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "block_images_description SET 
            block_id = '" . (int)$blockId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			on_page = '" . $on_page . "', 
			unique_text = '" . $unique_text . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}


	public function editBlockImage($blockId, $data)
{
    $publish = $this->db->escape($data['publish']);
    $existingImage = '';
    $blockInfo = $this->getBlocks($blockId);
    if ($blockInfo && !empty($blockInfo['image'])) {
        $existingImage = $blockInfo['image'];
    }
    if (!empty($_FILES["image"]["name"])) {
        $image = $this->handleUploadedImage($_FILES["image"]);
    } else {
        $image = isset($data['hidden_image']) ? $this->db->escape($data['hidden_image']) : $existingImage;
    }
    $updateBlockQuery = "UPDATE `" . DB_PREFIX . "blockimages` SET
    image = '" . $image . "', 
    publish = '" . $publish . "',
    date_modified = NOW()
    WHERE id = '" . (int)$blockId . "'";
    $this->db->query($updateBlockQuery);
    $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "block_images_description WHERE block_id = '" . (int)$blockId . "'";
    $this->db->query($deleteDescriptionQuery);
    foreach ($data['block_images_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $on_page = $this->db->escape($languageValue['on_page']);
        $unique_text = $this->db->escape($languageValue['unique_text']);
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "block_images_description SET 
        block_id = '" . (int)$blockId . "',
        lang_id = '" . $languageId . "',
        title = '" . $title . "',
        on_page = '" . $on_page . "',
        unique_text = '" . $unique_text . "'";
        $this->db->query($insertDescriptionQuery);	
    }
}
	private function handleUploadedImage($file)
	{
		if (empty($file['name'])) {
			return "";
		}
		$targetDirectory = DIR_IMAGE . "blockimages/";
		$originalFileName = pathinfo($file["name"], PATHINFO_FILENAME);
		$fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
		$uniqueName = $originalFileName . '_' . date('YmdHis') . '.' . $fileExtension;
		$targetFile = $targetDirectory . $uniqueName;
		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}
		move_uploaded_file($file["tmp_name"], $targetFile);
		return $this->db->escape($uniqueName);
	}
	public function deleteBlockImage($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "block_images_description` WHERE block_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blockimages` WHERE id = '" . (int)$id . "'");
	}

	public function getAffiliate($affiliate_id)
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blockimages WHERE id = '" . (int)$affiliate_id . "'");

		return $query->row;
	}
	public function getBlocks($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "blockimages` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getBlockImageDescriptions($id)
	{
		$block_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "block_images_description` WHERE block_images_description.block_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$block_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
				'on_page'             => $result['on_page'],
				'unique_text'         => $result['unique_text']
			);
		}
		return $block_description_data;
	}
	public function getBlockImages($data)
	{
		$sql = "SELECT block_images_description.*, blockimages.* FROM `blockimages` 
				LEFT JOIN block_images_description on blockimages.id = block_images_description.block_id
				WHERE block_images_description.lang_id = 1 ORDER BY blockimages.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalBlockImages()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blockimages`");
		return $query->row['total'];
	}

	public function updateBlockImagesStatusUpdate($blockId, $status)
	{
		// echo "UPDATE `" . DB_PREFIX . "blockimages` SET publish = '" . $status . "' WHERE id = '" . (int)$blockId . "'"; exit;
		$this->db->query("UPDATE `" . DB_PREFIX . "blockimages` SET publish = '" . $status . "' WHERE id = '" . (int)$blockId . "'");
	}

	public function deleteBlocksImage($block_id) {
    // Fetch image name from DB
    $query = $this->db->query("SELECT image FROM `" . DB_PREFIX . "blockimages` WHERE id = '" . (int)$block_id . "'");
    if ($query->num_rows) {
        $image = $query->row['image'];
        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'sliders/' . $image;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "blockimages` SET image = '' WHERE id = '" . (int)$block_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Block Image not found'];
    }
}
}
