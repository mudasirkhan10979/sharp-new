<?php
class ModelPage extends Model
{

	public function addBanner($data)
	{

		$defaultImageFileName = "no_image-100x100.png";
		$uploadedImageFileName = $defaultImageFileName;

		if (!empty($_FILES["banner_image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "pages/";
			$targetFile = $targetDirectory . basename($_FILES["banner_image"]["name"]);
			move_uploaded_file($_FILES["banner_image"]["tmp_name"], $targetFile);
			$uploadedImageFileName = $this->db->escape($_FILES["banner_image"]["name"]);
		}
		$publish = $this->db->escape($data['publish']);
		$sortOrder = $this->db->escape($data['sort_order']);
		$insertPagesQuery = "INSERT INTO `" . DB_PREFIX . "pages` SET 
        banner_image = '" . $uploadedImageFileName . "', 
        publish = '" . $publish . "',
		added_date = NOW(),
		modify_date = NOW(),
        sort_order = '" . $sortOrder . "'";
		$this->db->query($insertPagesQuery);
		$pageId = $this->db->getLastId();

		foreach ($data['pages_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$name = $this->db->escape($languageValue['name']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$description = $this->db->escape($languageValue['description']);

			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "pages_description SET 
            page_id = '" . (int)$pageId . "',
            lang_id = '" . $languageId . "',
            name = '" . $name . "',
            short_description = '" . $short_description . "',
            description = '" . $description . "',
            meta_title = '" . $meta_title . "',
            meta_description = '" . $meta_description . "',
            meta_keyword = '" . $meta_keyword . "'";
			$this->db->query($insertDescriptionQuery);

			if ($languageId == '1') {
				$seoTitle = $name;
			}
		}

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
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = '" . $this->db->escape($data['theme']) . "', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $pageId . "'");
	}

	public function editBanner($pageId, $data)
	{
		$targetDirectory = DIR_IMAGE . "pages/";
		$imageFileName = '';
		if (!empty($_FILES["banner_image"]["name"])) {
			$imageFileName = $_FILES["banner_image"]["name"];
			$targetFile = $targetDirectory . basename($imageFileName);
			move_uploaded_file($_FILES["banner_image"]["tmp_name"], $targetFile);
			$imageFileName = $this->db->escape($imageFileName);
		}
		if (!empty($imageFileName)) {
			$updateImageQuery = "UPDATE `" . DB_PREFIX . "pages` SET 
            banner_image = '" . $imageFileName . "' 
            WHERE id = '" . (int)$pageId . "'";
			$this->db->query($updateImageQuery);
		}
		$publish = $this->db->escape($data['publish']);
		$sortOrder = $this->db->escape($data['sort_order']);
		$updatePagesQuery = "UPDATE `" . DB_PREFIX . "pages` SET
        publish = '" . $publish . "',
        sort_order = '" . $sortOrder . "'
        WHERE id = '" . (int)$pageId . "'";
		$this->db->query($updatePagesQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "pages_description WHERE page_id = '" . (int)$pageId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['pages_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$name = $this->db->escape($languageValue['name']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$description = $this->db->escape($languageValue['description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "pages_description SET 
            page_id = '" . (int)$pageId . "',
            lang_id = '" . $languageId . "',
            name = '" . $name . "',
			short_description = '" . $short_description . "',
            description = '" . $description . "',
            meta_title = '" . $meta_title . "',
            meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == '1') {
				$seoTitle = $name;
			}
		}


		$this->load_model('seourl');
		
		$results = $this->db->query("SELECT * FROM aliases WHERE slog IN ('pages', 'generalpages', 'about', 'aboutbrand', 'aboutsharp', 'aboutplasmacluster', 'intelligentprint', 'contact', 'mediacenter', 'careers', 'servicecenters', 'brands', 'casestudies', 'downloadcenter', 'faqs', 'maincategory', 'newsevent', 'ourlocation', 'privacypolicy', 'product', 'productwarranty', 'servicecenterlist', 'sourcecodedownload', 'sitemap', 'support', 'usermanuals') AND slog_id='" . $pageId . "'");
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
			$this->db->query("UPDATE aliases SET url='" . $keyword . "',slog='".$this->db->escape($data['theme'])."' WHERE slog IN ('pages', 'generalpages', 'about', 'aboutbrand', 'aboutsharp', 'aboutplasmacluster', 'intelligentprint', 'contact', 'mediacenter', 'careers', 'servicecenters', 'brands', 'casestudies', 'downloadcenter', 'faqs', 'maincategory', 'newsevent', 'ourlocation', 'privacypolicy', 'product', 'productwarranty', 'servicecenterlist', 'sourcecodedownload', 'sitemap', 'support', 'usermanuals') AND slog_id='" . $pageId . "'");
		} else {
			$this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='" . $this->db->escape($data['theme']) . "',slog_id='" . $pageId . "'");
		}
	}
	public function deleteBanner($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "pages_description` WHERE page_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "pages` WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "aliases` WHERE slog_id = '" . (int)$id . "' AND slog IN ('pages', 'generalpages', 'about', 'aboutbrand', 'aboutsharp', 'aboutplasmacluster', 'intelligentprint', 'contact', 'mediacenter', 'careers', 'servicecenters', 'brands', 'casestudies', 'downloadcenter', 'faqs', 'maincategory', 'newsevent', 'ourlocation', 'privacypolicy', 'product', 'productwarranty', 'servicecenterlist', 'sourcecodedownload', 'sitemap', 'support', 'usermanuals')");
	}
	
	public function getBanner($id)
	{
		$sql = "SELECT p.*, a.url AS seo_url,a.slog FROM `" . DB_PREFIX . "pages` p 
        LEFT JOIN aliases a ON a.slog_id = p.id AND a.slog IN ('pages', 'generalpages', 'about', 'aboutbrand', 'aboutsharp', 'aboutplasmacluster', 'intelligentprint', 'contact', 'mediacenter', 'careers', 'servicecenters', 'brands', 'casestudies', 'downloadcenter', 'faqs', 'maincategory', 'newsevent', 'ourlocation', 'privacypolicy', 'product', 'productwarranty', 'servicecenterlist', 'sourcecodedownload', 'sitemap', 'support', 'usermanuals') 
        WHERE p.id = " . (int)$id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getPageDescriptions($id)
	{
		$pages_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "pages_description` WHERE pages_description.page_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$pages_description_data[$result['lang_id']] = array(
				'name'             => $result['name'],
				'short_description'      => $result['short_description'],
				'description'      => $result['description'],
				'meta_keyword'      => $result['meta_keyword'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description']
			);
		}
		return $pages_description_data;
	}
	public function getSliders($data)
	{
		$sql = "SELECT pages_description.*, pages.* FROM `pages` 
				LEFT JOIN pages_description on pages.id = pages_description.page_id
				WHERE pages_description.lang_id = 1 ORDER BY pages.id";
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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "pages`");
		return $query->row['total'];
	}

	public function updateCmsStatus ($id, $status)
	{
	   $sql = "UPDATE `" . DB_PREFIX . "pages` SET publish = '" . $status . "' WHERE id = '" . $id . "'";
	   $this->db->query($sql);
	}

	public function deletePageImage($page_id) {
    // Fetch banner_image name from DB
    $query = $this->db->query("SELECT banner_image FROM `" . DB_PREFIX . "pages` WHERE id = '" . (int)$page_id . "'");
    if ($query->num_rows) {
        $banner_image = $query->row['banner_image'];
        if (!empty($banner_image)) {
            $image_path = DIR_IMAGE . 'pages/' . $banner_image;
            if (file_exists($image_path) && is_file($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE `" . DB_PREFIX . "pages` SET banner_image = '' WHERE id = '" . (int)$page_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Page not found'];
    }
}
 
}
