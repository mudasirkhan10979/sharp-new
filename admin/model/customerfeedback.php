<?php
class ModelCustomerFeedback extends Model
{
    public function addCustomerFeedback($data)
	{
        $defaultImageFileName = "no_image-100x100.png";
        $icon = $defaultImageFileName;
 
        if (!empty($_FILES["icon"]["name"])) {
            $targetDirectory = DIR_IMAGE . "customer_feedback/";
            $targetFile = $targetDirectory . basename($_FILES["icon"]["name"]);
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755);
            }
            move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
            $icon = $this->db->escape($_FILES["icon"]["name"]);
        }
        $status = $this->db->escape($data['status']);
		$sortOrder = $this->db->escape($data['sort_order']);
        $numberOfStars = (int)$data['number_of_stars'];
        $insertFeedbackQuery = "INSERT INTO `" . DB_PREFIX . "customer_feedback` SET 
        icon = '" . $icon . "',
        number_of_stars = '" . (int)$numberOfStars . "', 
        sort_order = '" . (int)$sortOrder . "',
        status = '" . $status . "',
        date_added = NOW()";
        $this->db->query($insertFeedbackQuery);
        $feedbackId = $this->db->getLastId();
        foreach ($data['feedback_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $designation = $this->db->escape($languageValue['designation']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "feedback_description SET 
            feedback_id = '" . (int)$feedbackId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            designation = '" . $designation . "'";
            $this->db->query($insertDescriptionQuery);
        }
    }

    public function getCustomerFeedback($feedbackId)
	{
		$query = $this->db->query($sql = "SELECT * FROM `" . DB_PREFIX . "customer_feedback` WHERE id = " . (int)$feedbackId);
		return $query->row;
	}

    public function getCustomerFeedbackDescriptions($feedbackId)
    {
        $feedback_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "feedback_description` WHERE feedback_id = " . (int)$feedbackId;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$feedback_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
				'description'       => $result['description'],
				'designation'       => $result['designation']
			);
		}
		return $feedback_description_data;
    }

	public function getCustomerFeedbacks($languageId, $data = array())
	{
		$languageId = (int)$languageId;
		$sql = "SELECT fd.*, cf.* 
				FROM `" . DB_PREFIX . "customer_feedback` cf
				LEFT JOIN `" . DB_PREFIX . "feedback_description` fd ON cf.id = fd.feedback_id
				WHERE fd.lang_id = '" . $languageId . "' or  fd.lang_id = 1
				ORDER BY cf.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTotalCustomerFeedbacks()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer_feedback`");
		return $query->row['total'];
	}

    public function updateFeedbackStatus($feedbackId, $status) {
		$this->db->query("UPDATE `" . DB_PREFIX . "customer_feedback` SET status = '" . (int)$status . "' WHERE id = '" . (int)$feedbackId . "'");
	}

    public function editCustomerFeedback($feedbackId, $data)
    {
        $targetDirectory = DIR_IMAGE . "customer_feedback/";
        $icon = '';
        if (!empty($_FILES["icon"]["name"])) {
            $icon = $_FILES["icon"]["name"];
            $targetFile = $targetDirectory . basename($icon);
            move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
            $icon = $this->db->escape($icon);
        }
        if (!empty($icon)) {
            $updateImageQuery = "UPDATE `" . DB_PREFIX . "customer_feedback` SET
            icon = '" . $icon . "'
            WHERE id = '" . (int)$feedbackId . "'";
            $this->db->query($updateImageQuery);
        }
        $status = $this->db->escape($data['status']);
		$sortOrder = $this->db->escape($data['sort_order']);
        $numberOfStars = isset($data['number_of_stars']) ? (int)$data['number_of_stars'] : 5;
        $updateFeedbackQuery = "UPDATE `" . DB_PREFIX . "customer_feedback` SET
        status = '" . $status . "',
        number_of_stars = '" . $numberOfStars . "',
        sort_order = '" . $sortOrder . "',
        date_modified = NOW()
        WHERE id = '" . (int)$feedbackId . "'";
        $this->db->query($updateFeedbackQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "feedback_description WHERE feedback_id = '" . (int)$feedbackId . "'";
        $this->db->query($deleteDescriptionQuery);
        foreach ($data['feedback_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $designation = $this->db->escape($languageValue['designation']);
            $updateDescriptionQuery = "INSERT INTO " . DB_PREFIX . "feedback_description SET 
            feedback_id = '" . (int)$feedbackId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            designation = '" . $designation . "'";
            $this->db->query($updateDescriptionQuery);
        }
    // die($updateFeedbackQuery);
    }

    public function deleteCustomerFeedback($feedbackId)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_feedback WHERE id = '" . (int)$feedbackId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "feedback_description WHERE feedback_id = '" . (int)$feedbackId . "'");
    }

  public function deleteCustomerFeedbackImage($feedbackId) {
    // Fetch image name from DB
    $query = $this->db->query("SELECT icon FROM `" . DB_PREFIX . "customer_feedback` WHERE id = '" . (int)$feedbackId . "'");
    if ($query->num_rows) {
        $icon = $query->row['icon'];
        if (!empty($icon)) {
            $image_path = DIR_IMAGE . 'customer_feedback/' . $icon;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "customer_feedback` SET icon = '' WHERE id = '" . (int)$feedbackId . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Customer Feedback not found'];
    }
  }
}