<?php
class ModelBlock extends Model
{
	public function addBanner($data)
	{

		$publish = $this->db->escape($data['publish']);
		$insertBlockQuery = "INSERT INTO `" . DB_PREFIX . "block` SET 
		date_added = NOW(),
		date_modified = NOW(),
        publish = '" . $publish . "'";
		$this->db->query($insertBlockQuery);
		$blockId = $this->db->getLastId();
		foreach ($data['block_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$content = $this->db->escape($languageValue['content']);
			$on_page = $this->db->escape($languageValue['on_page']);
			$unique_text = $this->db->escape($languageValue['unique_text']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "block_description SET 
            block_id = '" . (int)$blockId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			on_page = '" . $on_page . "', 
			unique_text = '" . $unique_text . "', 
            content = '" . $content . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
	public function editBanner($blockId, $data)
	{

		$publish = $this->db->escape($data['publish']);
		$updateBlockQuery = "UPDATE `" . DB_PREFIX . "block` SET
        publish = '" . $publish . "',
        date_modified = NOW()
        WHERE id = '" . (int)$blockId . "'";
        $this->db->query($updateBlockQuery);
		$this->db->query($updateBlockQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "block_description WHERE block_id = '" . (int)$blockId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['block_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$on_page = $this->db->escape($languageValue['on_page']);
			$unique_text = $this->db->escape($languageValue['unique_text']);
			$content = $this->db->escape($languageValue['content']);

			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "block_description SET 
            block_id = '" . (int)$blockId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			on_page = '" . $on_page . "',
			unique_text = '" . $unique_text . "',
            content = '" . $content . "'";
			$this->db->query($insertDescriptionQuery);	
		}
	}
	public function deleteBanner($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "block_description` WHERE block_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "block` WHERE id = '" . (int)$id . "'");
	}

	public function getAffiliate($affiliate_id)
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "block WHERE id = '" . (int)$affiliate_id . "'");

		return $query->row;
	}
	public function getBanner($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "block` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getSliderDescriptions($id)
	{
		$block_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "block_description` WHERE block_description.block_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$block_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
				'on_page'             => $result['on_page'],
				'unique_text'         => $result['unique_text'],
				'content'      		  => $result['content']
			);
		}
		return $block_description_data;
	}
	public function getSliders($data)
	{
		$sql = "SELECT block_description.*, block.* FROM `block` 
				LEFT JOIN block_description on block.id = block_description.block_id
				WHERE block_description.lang_id = 1 ORDER BY block.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalBanners()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "block`");
		return $query->row['total'];
	}

	public function updateBlockStatusUpdate($blockId, $status)
	{
		$this->db->query("UPDATE `" . DB_PREFIX . "block` SET publish = '" . $status . "' WHERE id = '" . (int)$blockId . "'");
	}
}
