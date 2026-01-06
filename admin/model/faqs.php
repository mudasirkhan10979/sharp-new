<?php
class ModelFaqs extends Model
{
	public function addBanner($data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish = $this->db->escape($data['publish']); 
		$show_in_footer = $this->db->escape($data['show_in_footer']);
		$insertFaqsQuery = "INSERT INTO `" . DB_PREFIX . "faqs` SET 
		publish = '" . $publish . "',
		show_in_footer = '" . $show_in_footer . "', 
        added_date = NOW(),
		modify_date = NOW(),
		sort_order = '" . $sortOrder . "'";
		$this->db->query($insertFaqsQuery);
		$faqsId = $this->db->getLastId();
		foreach ($data['faqs_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$question = $this->db->escape($languageValue['question']);
			$answer = $this->db->escape($languageValue['answer']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "faqs_description SET 
            faq_id = '" . (int)$faqsId . "',
            lang_id = '" . $languageId . "',
            question = '" . $question . "',
            answer = '" . $answer . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
	public function editBanner($faqsId, $data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish = $this->db->escape($data['publish']); 
		$show_in_footer = $this->db->escape($data['show_in_footer']);
		$updateFaqQuery = "UPDATE `" . DB_PREFIX . "faqs` SET
		publish = '" . $publish . "', 
		show_in_footer = '" . $show_in_footer . "',
		sort_order = '" . $sortOrder . "',
		modify_date = NOW()
	    WHERE id = '" . (int)$faqsId . "'";
		$this->db->query($updateFaqQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "faqs_description WHERE faq_id = '" . (int)$faqsId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['faqs_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$question = $this->db->escape($languageValue['question']);
			$answer = $this->db->escape($languageValue['answer']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "faqs_description SET 
            faq_id = '" . (int)$faqsId . "',
            lang_id = '" . $languageId . "',
            question = '" . $question . "',
            answer = '" . $answer . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
	public function deleteBanner($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "faqs_description` WHERE faq_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "faqs` WHERE id = '" . (int)$id . "'");
	}
	public function getBanner($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "faqs` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getSliderDescriptions($id)
	{
		$faq_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "faqs_description` WHERE faqs_description.faq_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$faq_description_data[$result['lang_id']] = array(
				'question'             => $result['question'],
				'answer'       => $result['answer']
			);
		}
		return $faq_description_data;
	} 
	public function getFaqs($data)
	{
		$sql = "SELECT faqs_description.*, faqs.* FROM `faqs` 
		LEFT JOIN faqs_description on faqs.id = faqs_description.faq_id
		WHERE faqs_description.lang_id = 1 ORDER BY faqs.id";
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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "faqs`");
		return $query->row['total'];
	}

	public function updateFaqsStatus($faq_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "faqs` SET publish = '" . (int)$status . "' WHERE id = '" . (int)$faq_id . "'";
		$this->db->query($sql);
	}
}
