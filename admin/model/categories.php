<?php
class ModelCategories extends Model
{
	public function addCategory($data)
	{
		$defaultImageFileName = "";
		$uploadedImageFileName = $defaultImageFileName;
		$uploadedFeatureImageFileName = $defaultImageFileName;
		if (!empty($_FILES["image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "categories/";
			$targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
			move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
			$uploadedImageFileName = $this->db->escape($_FILES["image"]["name"]);
		}
		    // Handle feature image
		if (!empty($_FILES["feature_image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "categories/";
			$targetFile = $targetDirectory . basename($_FILES["feature_image"]["name"]);
			move_uploaded_file($_FILES["feature_image"]["tmp_name"], $targetFile);
			$uploadedFeatureImageFileName = $this->db->escape($_FILES["feature_image"]["name"]);
		}
		$status = (int)$data['status'];
		$featured = (int)$data['featured'];
		$show_on_home = $this->db->escape($data['show_on_home']);
		$show_on_footer = (int)$data['show_on_footer'];
		$show_on_header = (int)$data['show_on_header'];
		$sortOrder = (int)$data['sort_order'];
		$parent_id = (int)$data['parent_id'];
		$insertQuery = "INSERT INTO `" . DB_PREFIX . "category` SET 
        status = '" . $status . "',
		featured = '" . $featured . "',
		show_on_home = '" . $show_on_home . "',
		show_on_footer = '" . $show_on_footer . "',
		show_on_header = '" . $show_on_header . "',
        image = '" . $uploadedImageFileName . "', 
        feature_image = '" . $uploadedFeatureImageFileName . "',
        parent_id = '" . $parent_id . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
		
		$this->db->query($insertQuery);
		$categoryId = $this->db->getLastId();

		foreach ($data['sc_categories_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "category_description SET 
            category_id = '" . (int)$categoryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if($languageId == 1)
			{
				$seoTitle = $title;
			}
		}
		$level = 0;
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");
		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$categoryId . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}
		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$categoryId . "', `path_id` = '" . (int)$categoryId . "', `level` = '" . (int)$level . "'");
	     $this->load_model('seourl');
		if ($data['seo_url']) {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		} else {
			$keyword = $this->model_seourl->seoUrl($seoTitle);
			if (isset($keyword)) {
				$checkUrl = $this->model_seourl->chkUUrl($keyword);
				if (!$checkUrl) {
					$keyword = $keyword;
				} else {
					$originalTitle = $keyword;
					$counter = 2;
					while ($checkUrl) {
						$keyword = $originalTitle . '-' . $counter;
						$checkUrl = $this->model_seourl->chkUUrl($keyword);
						$counter++;
					}
				}
			}
			
		$this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = 'category_id=" . (int)$categoryId . "', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $categoryId . "'");
		
	  }
	
	}
	public function editCategory($categoryId, $data)
	{
		$targetDirectory = DIR_IMAGE . "categories/";
		$imageFileName = '';
		 $featureImageFileName = '';
		if (!empty($_FILES["image"]["name"])) {
			$imageFileName = $_FILES["image"]["name"];
			$targetFile = $targetDirectory . basename($imageFileName);
			move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
			$imageFileName = $this->db->escape($imageFileName);
		}
		if (!empty($imageFileName)) {
			$updateImageQuery = "UPDATE `" . DB_PREFIX . "category` SET 
            image = '" . $imageFileName . "' 
            WHERE category_id = '" . (int)$categoryId . "'";
			$this->db->query($updateImageQuery);
		}
		if (!empty($_FILES["feature_image"]["name"])) {
			$featureImageFileName = $_FILES["feature_image"]["name"];
			$targetFile = $targetDirectory . basename($featureImageFileName);
			move_uploaded_file($_FILES["feature_image"]["tmp_name"], $targetFile);
			$featureImageFileName = $this->db->escape($featureImageFileName);
		}
		if (!empty($featureImageFileName)) {
			$updateFeatureImageQuery = "UPDATE `" . DB_PREFIX . "category` SET 
            feature_image = '" . $featureImageFileName . "' 
            WHERE category_id = '" . (int)$categoryId . "'";
			$this->db->query($updateFeatureImageQuery);
		}
		$status = (int)$data['status'];
		$featured = (int)$data['featured'];
		$show_on_home = $this->db->escape($data['show_on_home']);
		$show_on_footer = (int)$data['show_on_footer'];
		$show_on_header = (int)$data['show_on_header'];
		$sortOrder = (int)$data['sort_order'];
		$parent_id = (int)$data['parent_id'];
		$updateCaseStudyQuery = "UPDATE `" . DB_PREFIX . "category` SET
		status = '" . $status . "',
		featured = '" . $featured . "',
		show_on_home = '" . $show_on_home . "',
		show_on_footer = '" . $show_on_footer . "',
		show_on_header = '" . $show_on_header . "',
		parent_id = '" . $parent_id . "',
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'
        WHERE category_id = '" . (int)$categoryId . "'";
		$this->db->query($updateCaseStudyQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$categoryId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['sc_categories_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "category_description SET 
            category_id = '" . (int)$categoryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if($languageId == 1)
			{
				$seoTitle = $title;
			}
		}
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE `path_id` = '" . (int)$categoryId . "' ORDER BY `level` ASC");
		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$category_path['category_id'] . "' AND `level` < '" . (int)$category_path['level'] . "'");

				$path = array();
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . $parent_id . "' ORDER BY `level` ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$category_path['category_id'] . "' ORDER BY `level` ASC");
				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}
				$level = 0;
				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', `level` = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$categoryId . "'");
			$level = 0;
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");
			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$categoryId . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

				$level++;
			}
			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$categoryId . "', `path_id` = '" . (int)$categoryId . "', `level` = '" . (int)$level . "'");
		}

		$this->load_model('seourl');
		$results = $this->db->query("SELECT * FROM aliases WHERE slog= 'category_id=" . (int)$categoryId . "' AND slog_id='" . $categoryId . "'");
		if ($data['seo_url']) {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		} else {
			$keyword = $this->model_seourl->seoUrl($seoTitle);
			if (isset($keyword)) {
				$checkUrl = $this->model_seourl->chkUUrl($keyword);
				if (!$checkUrl) {
					$keyword = $keyword;
				} else {
					$originalTitle = $keyword;
					$counter = 2;
					while ($checkUrl) {
						$keyword = $originalTitle . '-' . $counter;
						$checkUrl = $this->model_seourl->chkUUrl($keyword);
						$counter++;
					}
				}
			}
		}

		if ($results->rows) {
			//  Always delete old alias before inserting new
            $this->db->query("DELETE FROM aliases WHERE slog='category_id=" . (int)$categoryId . "' AND slog_id='" . (int)$categoryId . "'");
			//  Insert new alias (fresh and clean)
            $this->db->query("INSERT INTO aliases SET url='" . $this->db->escape($keyword) . "', slog='category_id=" . (int)$categoryId . "', slog_id='" . (int)$categoryId . "'");
			// $this->db->query("UPDATE aliases SET url='" . $keyword . "' WHERE slog='category_id=" . (int)$categoryId . "' AND slog_id='" . $categoryId . "'");
		} else {
			$this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='category_id=" . (int)$categoryId . "',slog_id='" . $categoryId . "'");
		}
	}
	public function deleteCategory($categoryId)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$categoryId . "'");
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE `path_id` = '" . (int)$categoryId . "'");
		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}
		$this->db->query("DELETE FROM `" . DB_PREFIX . "category` WHERE category_id = '" . (int)$categoryId . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "category_description` WHERE category_id = '" . (int)$categoryId . "'");
		// $this->db->query("DELETE FROM `" . DB_PREFIX . "aliases` WHERE slog = 'categories/detail' AND slog_id = '" . (int)$categoryId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "aliases WHERE slog = 'category_id=" . (int)$categoryId . "'"); 
	}
public function getSCCategory(int $categoryId): array
{
    $query = $this->db->query("SELECT DISTINCT c.*, cd2.*, 
        (SELECT GROUP_CONCAT(`cd1`.`title` ORDER BY `level` SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') 
         FROM `" . DB_PREFIX . "category_path` `cp` 
         LEFT JOIN `" . DB_PREFIX . "category_description` `cd1` ON (`cp`.`path_id` = `cd1`.`category_id` AND `cp`.`category_id` != `cp`.`path_id`)
         WHERE `cp`.`category_id` = `c`.`category_id` AND `cd1`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "' 
         GROUP BY `cp`.`category_id`) AS `path`,
         a.url as seo_url FROM `" . DB_PREFIX . "category` `c` 
         LEFT JOIN `" . DB_PREFIX . "category_description` `cd2` ON (`c`.`category_id` = `cd2`.`category_id`) 
         LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = c.category_id AND a.slog = 'category_id=" . (int)$categoryId . "' 
         WHERE `c`.`category_id` = '" . (int)$categoryId . "' AND `cd2`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "'");
    return $query->row;
}
	public function getCategoryDescriptions($categoryId)
	{
		$sc_categories_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "category_description` ccd WHERE ccd.category_id = " . $categoryId;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$sc_categories_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
				'short_description'             => $result['short_description'],
				'meta_keyword'      => $result['meta_keyword'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description']
			);
		}
		return $sc_categories_description_data;
	}
	public function getCategories($data = array())
	{
		$sql = "SELECT `cp`.`category_id` AS `category_id`, GROUP_CONCAT(`cd1`.`title` ORDER BY `cp`.`level` SEPARATOR ' > ') AS `title`, `c1`.`parent_id`, `c1`.`sort_order`, `c1`.`status` FROM `" . DB_PREFIX . "category_path` `cp` LEFT JOIN `" . DB_PREFIX . "category` `c1` ON (`cp`.`category_id` = `c1`.`category_id`) LEFT JOIN `" . DB_PREFIX . "category` `c2` ON (`cp`.`path_id` = `c2`.`category_id`) LEFT JOIN `" . DB_PREFIX . "category_description` `cd1` ON (`cp`.`path_id` = `cd1`.`category_id`) LEFT JOIN `" . DB_PREFIX . "category_description` `cd2` ON (`cp`.`category_id` = `cd2`.`category_id`) WHERE `cd1`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "' AND `cd2`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "'";
		if (!empty($data['filter_title'])) {
			$sql .= " AND `cd2`.`title` LIKE '" . $this->db->escape('%' . $data['filter_title'] . '%') . "'";
		}

		$sql .= " GROUP BY `c1`.`category_id`";


		$sql .= " ORDER BY `c1`.`category_id`";

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getPath(int $categoryId): array
	{
		$query = $this->db->query("SELECT `category_id`, `path_id`, `level` FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$categoryId . "'");
		return $query->rows;
	}

	   public function updateCategoryStatus($categoryId, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "category` SET status = '" . (int)$status . "' WHERE category_id = '" . (int)$categoryId . "'";
        $this->db->query($sql);
        return true;
    }


public function deleteCategoryImage($category_id, $type = 'main') {

	// echo '<pre>'; print_r($type); exit;
    switch ($type) {
        case 'feature_image':  
            $column = 'feature_image';
            break;
        default:
            $column = 'image';
    }
    // Get the current image filename
    $query = $this->db->query("SELECT `" . $column . "` AS image FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
    if ($query->num_rows) {
        $image = $query->row['image'];
        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'categories/' . $image;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE " . DB_PREFIX . "category SET `" . $column . "` = '' WHERE category_id = '" . (int)$category_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Category not found'];
    }
 }

}
