<?php

class ModelBrands extends Model {

	public function getbrandslist($data) {
				$sql = "SELECT b.*, bd.*, ld.title as location_name, a.url as seo_url
				FROM `" . DB_PREFIX . "brands` b
				LEFT JOIN `" . DB_PREFIX . "brands_description` bd ON b.brand_id = bd.brand_id
				LEFT JOIN `" . DB_PREFIX . "locations` l ON b.location_id = l.id
				LEFT JOIN `" . DB_PREFIX . "location_description` ld ON l.id = ld.location_id AND ld.lang_id = '" . $this->config->get('config_language_id') . "' 
				LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = b.brand_id AND a.slog = 'brands/detail'
				WHERE bd.lang_id = '" . $this->config->get('config_language_id') . "' 
				AND b.status = 1 AND l.publish = 1 GROUP BY b.brand_id
				ORDER BY b.sort_order ASC";
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}
				if ($data['limit'] < 1) {
					$data['limit'] = 3;
				}
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
			$query = $this->db->query($sql);
			return $query->rows;
	}

	public function getTotalBrands($data) {
		       $sql = "SELECT COUNT(DISTINCT b.brand_id) AS total
				FROM `" . DB_PREFIX . "brands` b
				LEFT JOIN `" . DB_PREFIX . "brands_description` bd ON b.brand_id = bd.brand_id
				LEFT JOIN `" . DB_PREFIX . "locations` l ON b.location_id = l.id
				LEFT JOIN `" . DB_PREFIX . "location_description` ld ON l.id = ld.location_id AND ld.lang_id = '" . $this->config->get('config_language_id') . "' 
				WHERE bd.lang_id = '" . $this->config->get('config_language_id') . "' 
				AND l.publish = 1 AND b.status = 1";
				$query = $this->db->query($sql);
				return $query->row['total'];
	    }

	public function getBrandsDetails($brandId) {
		       $sql = "SELECT b.*, bd.*, ld.title as location_name, l.phone, l.email, l.latitude, l.longitude, l.address, a.url as seo_url
				FROM `" . DB_PREFIX . "brands` b
				LEFT JOIN `" . DB_PREFIX . "brands_description` bd ON b.brand_id = bd.brand_id
				LEFT JOIN `" . DB_PREFIX . "locations` l ON b.location_id = l.id
				LEFT JOIN `" . DB_PREFIX . "location_description` ld ON l.id = ld.location_id AND ld.lang_id = '" . $this->config->get('config_language_id') . "' 
				LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = b.brand_id AND a.slog = 'brands/detail'
				WHERE bd.lang_id = '" . $this->config->get('config_language_id') . "' 
				AND b.brand_id = '" . $brandId . "' 
				AND b.status = 1
				AND l.publish = 1
				AND b.brand_id IS NOT NULL
				ORDER BY b.brand_id DESC, b.sort_order ASC
				LIMIT 1";
				$query = $this->db->query($sql);
				return $query->row;
	}

	public function getAdditionalbrandimages($brandId) {
		        $sql = "SELECT bi.* FROM `" . DB_PREFIX . "brand_images` bi
				WHERE  bi.brand_id = '" . $brandId . "'
				ORDER BY bi.sort_order ASC";
				$query = $this->db->query($sql);
				return $query->rows;
	}

	public function getMenuRepeator($brandId) {
		        $sql = "SELECT oi.*, oid.* FROM `" . DB_PREFIX . "ourmenu_images` oi
				LEFT JOIN `" . DB_PREFIX . "ourmenu_image_description` oid ON oi.id = oid.menu_description_id
				WHERE oid.lang_id = '" . $this->config->get('config_language_id') . "'
				AND oi.brand_id = '" . $brandId . "'
				ORDER BY oi.sort_order ASC";
				$query = $this->db->query($sql);
				return $query->rows;
	}

	public function getRelatedbrands() {
		$sql = "SELECT b.*, bd.*, ld.title as location_name, a.url as seo_url FROM `" . DB_PREFIX . "brands` b
		LEFT JOIN `" . DB_PREFIX . "brands_description` bd ON b.brand_id = bd.brand_id
		LEFT JOIN `" . DB_PREFIX . "location_description` ld ON b.location_id = ld.location_id AND ld.lang_id = '" . $this->config->get('config_language_id') . "' 
		LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = b.brand_id AND a.slog = 'brands/detail'
		WHERE bd.lang_id = '" . $this->config->get('config_language_id') . "' 
		AND b.status = 1
		GROUP BY b.brand_id
		ORDER BY b.sort_order ASC";
		$query = $this->db->query($sql);
		return $query->rows;
  }

}