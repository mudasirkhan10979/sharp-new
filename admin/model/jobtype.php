<?php
class ModelJobType extends Model
{
	public function addJobType($data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish = $this->db->escape($data['publish']);
		$insertQuery = "INSERT INTO `" . DB_PREFIX . "jobtype` SET 
		publish = '" . $publish . "', 
        added_date = NOW(),
		modify_date = NOW(),
		sort_order = '" . $sortOrder . "'";
		$this->db->query($insertQuery);
		$jobTypeId = $this->db->getLastId();

		foreach ($data['jobtype_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$description = $this->db->escape($languageValue['description']);
			$insertDescQuery = "INSERT INTO " . DB_PREFIX . "jobtype_description SET 
            jobtype_id = '" . (int)$jobTypeId . "',
            lang_id = '" . $languageId . "',
            description = '" . $description . "',
            title = '" . $title . "'";
			$this->db->query($insertDescQuery);
		}
	}

	public function editJobType($jobTypeId, $data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish = $this->db->escape($data['publish']);
		$updateQuery = "UPDATE `" . DB_PREFIX . "jobtype` SET
		publish = '" . $publish . "', 
		sort_order = '" . $sortOrder . "',
		modify_date = NOW()
	    WHERE id = '" . (int)$jobTypeId . "'";
		$this->db->query($updateQuery);

		$this->db->query("DELETE FROM `" . DB_PREFIX . "jobtype_description` WHERE jobtype_id = '" . (int)$jobTypeId . "'");

		foreach ($data['jobtype_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$description = $this->db->escape($languageValue['description']);
			$insertDescQuery = "INSERT INTO " . DB_PREFIX . "jobtype_description SET 
            jobtype_id = '" . (int)$jobTypeId . "',
            lang_id = '" . $languageId . "',
            description = '" . $description . "',
            title = '" . $title . "'";
			$this->db->query($insertDescQuery);
		}
	}

	public function deleteJobType($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "jobtype_description` WHERE jobtype_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "jobtype` WHERE id = '" . (int)$id . "'");
	}

	public function getJobType($id)
	{
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "jobtype` WHERE id = " . (int)$id);
		return $query->row;
	}

	public function getJobTypeDescriptions($id)
	{
		$data = array();
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "jobtype_description` WHERE jobtype_id = " . (int)$id);
		foreach ($query->rows as $result) {
			$data[$result['lang_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description'],
			);
		}
		return $data;
	}
	

	public function getJobTypes($data)
	{
		$sql = "SELECT jt.*, jtd.* FROM `" . DB_PREFIX . "jobtype` jt 
		        LEFT JOIN `" . DB_PREFIX . "jobtype_description` jtd 
		        ON jt.id = jtd.jobtype_id 
		        WHERE jtd.lang_id = 1 
		        ORDER BY jt.id";

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		// echo $sql; exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTotalJobTypes()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "jobtype`");
		return $query->row['total'];
	}

	public function updateJobTypeStatus($jobTypeId, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "jobtype` SET publish = '" . (int)$status . "' WHERE id = '" . (int)$jobTypeId . "'";
		$this->db->query($sql);
	}
}
