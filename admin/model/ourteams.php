<?php
class ModelOurTeams extends Model
{
	public function addTeam($data)
{
    $sortOrder = $this->db->escape($data['sort_order']);
    $status = $this->db->escape($data['status']);
    $image = $this->handleUploadedImage($_FILES["image"]);
    $insertTeamQuery = "INSERT INTO `" . DB_PREFIX . "ourteams` SET 
        image = '" . $image . "', 
        status = '" . $status . "', 
        added_date = NOW(),
        modify_date = NOW(),
        sort_order = '" . $sortOrder . "'"; 
    $this->db->query($insertTeamQuery);
    $teamsId = $this->db->getLastId();
    foreach ($data['ourteams_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $designation = $this->db->escape($languageValue['designation']);
        // $short_description = $this->db->escape($languageValue['short_description']);
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "ourteams_description SET 
            team_id = '" . (int)$teamsId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            designation = '" . $designation . "'";
        $this->db->query($insertDescriptionQuery);
    }
}
	private function handleUploadedImage($file)
	{
		if (empty($file['name'])) {
			return "";
		}
		$targetDirectory = DIR_IMAGE . "ourteams/";
		$targetFile = $targetDirectory . basename($file["name"]);
		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}
		move_uploaded_file($file["tmp_name"], $targetFile);
		return $this->db->escape($file["name"]);
	}
	public function editTeam($team_id, $data)
   {
    $sortOrder = $this->db->escape($data['sort_order']);
    $status = $this->db->escape($data['status']);  
    $image = $this->db->escape($data['image']);  
    if (!empty($_FILES["image"]["name"])) {
        $image = $this->handleUploadedImage($_FILES["image"]);
    }
    $updateFaqQuery = "UPDATE `" . DB_PREFIX . "ourteams` SET
        image = '" . $image . "', 
        status = '" . $status . "', 
        sort_order = '" . $sortOrder . "',
        modify_date = NOW()
        WHERE id = '" . (int)$team_id . "'";
    $this->db->query($updateFaqQuery);
    $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "ourteams_description WHERE team_id = '" . (int)$team_id . "'";
    $this->db->query($deleteDescriptionQuery);
    foreach ($data['ourteams_description'] as $languageId => $languageValue) {
        $languageId = (int)$languageId;
        $title = $this->db->escape($languageValue['title']);
        $designation = $this->db->escape($languageValue['designation']);
        // $short_description = $this->db->escape($languageValue['short_description']); 
        $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "ourteams_description SET 
            team_id = '" . (int)$team_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            designation = '" . $designation . "'";
        $this->db->query($insertDescriptionQuery);
      }
    }
	public function deleteTeam($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "ourteams_description` WHERE team_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "ourteams` WHERE id = '" . (int)$id . "'");
	}
	public function getTeam($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "ourteams` WHERE id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getTeamDescription($id)
	{
		$ourteams_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "ourteams_description` WHERE ourteams_description.team_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$ourteams_description_data[$result['lang_id']] = array( 
				'title'       => $result['title'],
				'designation'       => $result['designation']
			);
		}
		return $ourteams_description_data;
	} 
	public function getTeams($data)
	{
		$sql = "SELECT ourteams_description.*, ourteams.* FROM `ourteams` 
		LEFT JOIN ourteams_description on ourteams.id = ourteams_description.team_id
		WHERE ourteams_description.lang_id = 1 ORDER BY ourteams.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalTeams()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "ourteams`");
		return $query->row['total'];
	}
    public function updateTeamStatus($team_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "ourteams` SET status = '" . (int)$status . "' WHERE id = '" . (int)$team_id . "'";
        $this->db->query($sql);
        return true;
	}
}