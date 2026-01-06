<?php
class ModelFrontMenu extends Model {

    public function addMenu($data)
	{

		$status = $this->db->escape($data['status']);
		$url = $this->db->escape($data['url']);
		$region = $this->db->escape($data['region']);
		$sortOrder = $this->db->escape($data['sort_order']);
		//$parentId = $data['parent_id'];
		$insertMenuQuery = "INSERT INTO `" . DB_PREFIX . "menus` SET 
        status = '" . $status . "',
        region = '" . $region . "',
		url = '" . $url . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
		$this->db->query($insertMenuQuery);
		$menuId = $this->db->getLastId();
		foreach ($data['menus_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "menus_description SET 
            menu_id = '" . (int)$menuId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}


    public function editMenu($menuId, $data)
	{
		$status = $this->db->escape($data['status']);
		$region = $this->db->escape($data['region']);
		$url = $this->db->escape($data['url']);
		$sortOrder = $this->db->escape($data['sort_order']);
		$updateMenuQuery = "UPDATE `" . DB_PREFIX . "menus` SET
        status = '" . $status . "',
		region = '" . $region . "', 
        url = '" . $url . "', 
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'
        WHERE id = '" . (int)$menuId . "'";
		$this->db->query($updateMenuQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "menus_description WHERE menu_id = '" . (int)$menuId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['menus_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "menus_description SET 
            menu_id = '" . (int)$menuId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
    public function deleteMenu($id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "menus WHERE id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "menus_description` WHERE menu_id = '" . (int)$id . "'");
    }
    public function getMenusDescriptions($id)
	{
		$menus_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "menus_description` WHERE menus_description.menu_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$menus_description_data[$result['lang_id']] = array(
				'title'             => $result['title']
			);
		}
		return $menus_description_data;
	}

    public function getMenu($id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menus WHERE id = '" . (int)$id . "'");
        return $query->row;
    }

	public function getMenus($data)
	{
		$sql = "SELECT menus_description.*, menus.* FROM `menus` 
				LEFT JOIN menus_description on menus.id = menus_description.menu_id
				WHERE menus_description.lang_id = 1 ORDER BY menus.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
    public function getTotalMenus() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menus");
        return $query->row['total'];
    }

	public function updateMenuStatus($id, $status) {

		$this->db->query("UPDATE " . DB_PREFIX . "menus SET status = '" . (int)$status . "' WHERE id = '" . (int)$id . "'");
	}
}
