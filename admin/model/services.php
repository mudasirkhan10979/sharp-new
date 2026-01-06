<?php
class ModelServices extends Model
{
	public function addService($data)
	{

		$defaultbIconFileName = "";
		$uploadedbIconFileName = $defaultbIconFileName;
		if (!empty($_FILES["icon"]["name"])) {
			$targetDirectory = DIR_IMAGE . "services/";
			$targetFile = $targetDirectory . basename($_FILES["icon"]["name"]);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
			$uploadedbIconFileName = $this->db->escape($_FILES["icon"]["name"]);
		}

		$defaultThumbnaileFileName = "";
		$uploadedThumbnaileFileName = $defaultThumbnaileFileName;
		if (!empty($_FILES["thumbnail"]["name"])) {
			$targetDirectory = DIR_IMAGE . "services/";
			$targetFile = $targetDirectory . basename($_FILES["thumbnail"]["name"]);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile);
			$uploadedThumbnaileFileName = $this->db->escape($_FILES["thumbnail"]["name"]);
		}

		$status = (int)$data['status'];
		$s_category_id = (int)$data['s_category_id'];
		$website_url = $this->db->escape($data['website_url']);
		$facebook_url = $this->db->escape($data['facebook_url']);
		$x_url = $this->db->escape($data['x_url']);
		$longitude = $this->db->escape($data['longitude']);
		$latitude = $this->db->escape($data['latitude']);
		$linkedin_url = $this->db->escape($data['linkedin_url']);
		$phone = $this->db->escape($data['phone']);
		$address = $this->db->escape($data['address']);
		$iframe_map = $this->db->escape($data['iframe_map']);
		$sortOrder = (int)$data['sort_order'];
		$insertServicesQuery = "INSERT INTO `" . DB_PREFIX . "services` SET 
        website_url = '" . $website_url . "', 
        facebook_url = '" . $facebook_url . "', 
        x_url = '" . $x_url . "', 
        longitude = '" . $longitude . "', 
        latitude = '" . $latitude . "', 
        linkedin_url = '" . $linkedin_url . "', 
        phone = '" . $phone . "', 
        address = '" . $address . "', 
        s_category_id = '" . $s_category_id . "', 
		thumbnail = '" . $uploadedThumbnaileFileName . "',
        icon = '" . $uploadedbIconFileName . "', 
        status = '" . $status . "',
        iframe_map = '" . $iframe_map . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
		$this->db->query($insertServicesQuery);
		$serviceId = $this->db->getLastId();
		foreach ($data['services_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$name = $this->db->escape($languageValue['name']);
			$sub_title = $this->db->escape($languageValue['sub_title']);
			$full_description = $this->db->escape($languageValue['full_description']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "services_description SET 
            service_id = '" . (int)$serviceId . "',
            lang_id = '" . $languageId . "',
            name = '" . $name . "',
            sub_title = '" . $sub_title . "',
            full_description = '" . $full_description . "',
            short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
		}
		if (isset($data['service_images'])) {
			foreach ($data['service_images'] as $service_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_images SET service_id = '" . (int)$serviceId . "', image = '" . $this->db->escape($service_image['image']) . "', sort_order = '" . (int)$service_image['sort_order'] . "'");
				$img_description_id = $this->db->getLastId();
				foreach ($service_image['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "service_image_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `service_id` = '" . (int)$serviceId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		$this->cache->delete('home.services.' . (int)$this->config->get('config_language_id'));
	}
	public function editService($serviceId, $data)
	{
		$targetDirectory = DIR_IMAGE . "services/";
		$iconFileName = '';
		if (!empty($_FILES["icon"]["name"])) {
			$iconFileName = $_FILES["icon"]["name"];
			$targetFile = $targetDirectory . basename($iconFileName);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
			$iconFileName = $this->db->escape($iconFileName);
		}
		if (!empty($iconFileName)) {
			    $updateIconQuery = "UPDATE `" . DB_PREFIX . "services` SET 
				icon = '" . $iconFileName . "' 
				WHERE service_id = '" . (int)$serviceId . "'";
			   $this->db->query($updateIconQuery);
		}

		$ThumbnaileFileName = '';
		if (!empty($_FILES["thumbnail"]["name"])) {
			$ThumbnaileFileName = $_FILES["thumbnail"]["name"];
			$targetFile = $targetDirectory . basename($ThumbnaileFileName);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile);
			$ThumbnaileFileName = $this->db->escape($ThumbnaileFileName);
		}
		if (!empty($ThumbnaileFileName)) {
			    $updateThumbnaileQuery = "UPDATE `" . DB_PREFIX . "services` SET 
				thumbnail = '" . $ThumbnaileFileName . "' 
				WHERE service_id = '" . (int)$serviceId . "'";
			   $this->db->query($updateThumbnaileQuery);
		}
		$s_category_id = (int)$data['s_category_id'];
		$status = (int)$data['status'];
		$sortOrder = (int)$data['sort_order'];
		$website_url = $this->db->escape($data['website_url']);
		$facebook_url = $this->db->escape($data['facebook_url']);
		$x_url = $this->db->escape($data['x_url']);
		$longitude = $this->db->escape($data['longitude']);
		$latitude = $this->db->escape($data['latitude']);
		$linkedin_url = $this->db->escape($data['linkedin_url']);
		$phone = $this->db->escape($data['phone']);
		$address = $this->db->escape($data['address']);
		$iframe_map = $this->db->escape($data['iframe_map']);
		$updateServiceQuery = "UPDATE `" . DB_PREFIX . "services` SET
		status = '" . $status . "',
		s_category_id = '" . $s_category_id . "',
		website_url = '" . $website_url . "', 
		facebook_url = '" . $facebook_url . "', 
		x_url = '" . $x_url . "', 
		longitude = '" . $longitude . "', 
		latitude = '" . $latitude . "', 
		linkedin_url = '" . $linkedin_url . "', 
		phone = '" . $phone . "', 
        address = '" . $address . "', 
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "',
        iframe_map = '" . $iframe_map . "'
        WHERE service_id = '" . (int)$serviceId . "'";
		$this->db->query($updateServiceQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "services_description WHERE service_id = '" . (int)$serviceId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['services_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$name = $this->db->escape($languageValue['name']);
			$sub_title = $this->db->escape($languageValue['sub_title']);
			$full_description = $this->db->escape($languageValue['full_description']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "services_description SET 
            service_id = '" . (int)$serviceId . "',
            lang_id = '" . $languageId . "',
            name = '" . $name . "',
            sub_title = '" . $sub_title . "',
            full_description = '" . $full_description . "',
            short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == '1') {
				$seoTitle = $name;
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_images WHERE service_id = '" . (int)$serviceId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_image_description WHERE service_id = '" . (int)$serviceId . "'");
		if (isset($data['service_images'])) {
			foreach ($data['service_images'] as $service_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_images SET service_id = '" . (int)$serviceId . "', image = '" . $this->db->escape($service_image['image']) . "', sort_order = '" . (int)$service_image['sort_order'] . "'");
				$img_description_id = $this->db->getLastId();
				foreach ($service_image['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "service_image_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `service_id` = '" . (int)$serviceId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		$this->cache->delete('home.services.' . (int)$this->config->get('config_language_id'));
	}
	public function deleteService($serviceId)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "services` WHERE service_id = '" . (int)$serviceId . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "services_description` WHERE service_id = '" . (int)$serviceId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_images WHERE service_id = '" . (int)$serviceId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_image_description WHERE service_id = '" . (int)$serviceId . "'");
		$this->cache->delete('home.services.' . (int)$this->config->get('config_language_id'));
	}
	public function getListService($serviceId)
	{

		$sql = "SELECT b.* FROM `" . DB_PREFIX . "services` b  WHERE b.service_id = " . $serviceId;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getServiceImages($serviceId)
	{
		$serviceImageData = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_images WHERE service_id = '" . (int)$serviceId . "' ORDER BY sort_order ASC");
		foreach ($query->rows as $imageDescription) {
			$description_data = [];

			$description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "service_image_description` WHERE `img_description_id` = '" . (int)$imageDescription['id'] . "'");

			foreach ($description_query->rows as $description) {
				$description_data[$description['lang_id']] = ['title' => $description['title'], 'content' => $description['content']];
			}

			$serviceImageData[] = [
				'description' 				=> $description_data,
				'image'                     => $imageDescription['image'],
				'sort_order'                => $imageDescription['sort_order']
			];
		}
		return $serviceImageData;
	}

	public function getServiceDescription($serviceId)
	{
		$services_description = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "services_description` WHERE services_description.service_id = " . $serviceId;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$services_description[$result['lang_id']] = array(
				'name'             => $result['name'],
				'short_description'      => $result['short_description'],
				'full_description'      => $result['full_description'],
				'sub_title'              => $result['sub_title'],
				'meta_keyword'      => $result['meta_keyword'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description']
			);
		}
		return $services_description;
	}
	public function getListServices($data)
	{
		$sql = "SELECT bd.*, b.*, bcd.title as category_name 
        FROM `services` b
        LEFT JOIN services_description bd ON b.service_id = bd.service_id
        LEFT JOIN service_categories_description bcd ON bcd.s_category_id = b.s_category_id
        WHERE bd.lang_id = 1 AND bcd.lang_id = 1";

		if (isset($data['filter_title']) && ($data['filter_title'] != '')) {
			$sql .= " AND  bd.name LIKE '%" . $data['filter_title'] . "%'";
		}
		$sql .= " ORDER BY b.service_id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		if (isset($data['limit'])) {
			$sql .= " Limit " . $data['limit'];
		}
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getServicesCategory()
	{
				$sql = "SELECT bc.id AS category_id, bcd.title AS category_title
				FROM `service_categories` AS bc
				LEFT JOIN `service_categories_description` AS bcd ON bc.id = bcd.s_category_id
				WHERE bcd.lang_id = 1 AND bc.status = 1
				ORDER BY bc.sort_order ASC";
				$query = $this->db->query($sql);
				return $query->rows;
	}
	public function updateServicesStatus($service_id, $status)
	{

		$sql = "UPDATE `" . DB_PREFIX . "services` SET status = '" . (int)$status . "' WHERE service_id = '" . (int)$service_id . "'";
		$this->db->query($sql);
		return true;
	}
}
