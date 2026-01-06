<?php
class ModelCaseStudy extends Model
{
	public function addCaseStudy($data)
	{
		$defaultImageFileName = "";
		$uploadedImageFileName = $defaultImageFileName;

		if (!empty($_FILES["thumbnail"]["name"])) {
			$targetDirectory = DIR_IMAGE . "case_study/";

			$targetFile = $targetDirectory . basename($_FILES["thumbnail"]["name"]);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile);
			$uploadedImageFileName = $this->db->escape($_FILES["thumbnail"]["name"]);
		}


		$defaultBannerFileName = "";
		$uploadedBannerFileName = $defaultBannerFileName;

		if (!empty($_FILES["banner_image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "case_study/";

			$targetFile = $targetDirectory . basename($_FILES["banner_image"]["name"]);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["banner_image"]["tmp_name"], $targetFile);
			$uploadedBannerFileName = $this->db->escape($_FILES["banner_image"]["name"]);
		}

		$status = $this->db->escape($data['status']);
		$sortOrder = $this->db->escape($data['sort_order']);
		$featured = (int)$data['featured'];

		$insertSliderQuery = "INSERT INTO `" . DB_PREFIX . "case_study` SET 
        thumbnail = '" . $uploadedImageFileName . "', 
        banner_image = '" . $uploadedBannerFileName . "', 
        publish = '" . $status . "',
        mark_feature  = '" . $featured . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";

		$this->db->query($insertSliderQuery);
		$caseStudyId = $this->db->getLastId();
		// if ($data['categories']) {
		// 	$categories = implode(',', $data['categories']);
		// 	$this->db->query("UPDATE " . DB_PREFIX . "case_study SET categories = '" . $categories . "' WHERE case_study_id = '" . (int)$caseStudyId . "'");
		// }


		foreach ($data['case_study_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$second_title = $this->db->escape($languageValue['second_title']);
			$second_description = $this->db->escape($languageValue['second_description']);
		    $middle_title = $this->db->escape($languageValue['middle_title']);
			$first_middle_description = $this->db->escape($languageValue['first_middle_description']);
			$second_middle_description	 = $this->db->escape($languageValue['second_middle_description']);
			$third_middle_description = $this->db->escape($languageValue['third_middle_description']);
			$tag = $this->db->escape($languageValue['tag']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);

			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "case_study_description SET 
            case_study_id = '" . (int)$caseStudyId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			second_title = '" . $second_title . "',
			middle_title = '" . $middle_title . "',
			second_description = '" . $second_description . "',
			first_middle_description = '" . $first_middle_description . "',
			second_middle_description = '" . $second_middle_description . "',
			third_middle_description = '" . $third_middle_description . "',
			tag = '" . $tag . "',
            short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == '1') {
				$seoTitle = $title;
			}
		}
		if (isset($data['case_study_image'])) {
			foreach ($data['case_study_image'] as $case_study_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "case_study_image SET case_study_id = '" . (int)$caseStudyId . "', image = '" . $this->db->escape($case_study_image['image']) . "', sort_order = '" . (int)$case_study_image['sort_order'] . "'");
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
		$this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog='casestudies/detail', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $caseStudyId . "'");
		return $caseStudyId;
	}


	public function editCaseStudy($case_study_id, $data)
	{
		$targetDirectory = DIR_IMAGE . "case_study/";
		$imageFileName = '';
	    $bannerFileName = '';

		if (!empty($_FILES["thumbnail"]["name"])) {
			$imageFileName = $_FILES["thumbnail"]["name"];
			$targetFile = $targetDirectory . basename($imageFileName);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile);
			$imageFileName = $this->db->escape($imageFileName);
		}

		if (!empty($imageFileName)) {
			$updateImageQuery = "UPDATE `" . DB_PREFIX . "case_study` SET 
            thumbnail = '" . $imageFileName . "' 
            WHERE case_study_id = '" . (int)$case_study_id . "'";
			$this->db->query($updateImageQuery);
		}

		if (!empty($_FILES["banner_image"]["name"])) {
			$bannerFileName = $_FILES["banner_image"]["name"];
			$targetFile = $targetDirectory . basename($bannerFileName);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["banner_image"]["tmp_name"], $targetFile);
			$bannerFileName = $this->db->escape($bannerFileName);
		}

		if (!empty($bannerFileName)) {
			$updateBannerQuery = "UPDATE `" . DB_PREFIX . "case_study` SET 
            banner_image = '" . $bannerFileName . "' 
            WHERE case_study_id = '" . (int)$case_study_id . "'";
			$this->db->query($updateBannerQuery);
		}
		$status = $this->db->escape($data['status']);
		$sortOrder = $this->db->escape($data['sort_order']);
		$featured = (int)$data['featured'];

		$updateCaseStudyQuery = "UPDATE `" . DB_PREFIX . "case_study` SET
		publish = '" . $status . "',
        mark_feature  = '" . $featured . "',
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'
        WHERE case_study_id = '" . (int)$case_study_id . "'";
		$this->db->query($updateCaseStudyQuery);

		// if ($data['categories']) {
		// 	$categories = implode(',', $data['categories']);
		// 	$this->db->query("UPDATE " . DB_PREFIX . "case_study SET categories = '" . $categories . "' WHERE case_study_id = '" . (int)$case_study_id . "'");
		// } else {
		// 	$categories = "";
		// 	$this->db->query("UPDATE " . DB_PREFIX . "case_study SET categories = '" . $categories . "' WHERE case_study_id = '" . (int)$case_study_id . "'");
		// }

		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "case_study_description WHERE case_study_id = '" . (int)$case_study_id . "'";
		$this->db->query($deleteDescriptionQuery);

		foreach ($data['case_study_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$second_title = $this->db->escape($languageValue['second_title']);
			$second_description = $this->db->escape($languageValue['second_description']);
		    $middle_title = $this->db->escape($languageValue['middle_title']);
			$first_middle_description = $this->db->escape($languageValue['first_middle_description']);
			$second_middle_description	 = $this->db->escape($languageValue['second_middle_description']);
			$third_middle_description = $this->db->escape($languageValue['third_middle_description']);
			$tag = $this->db->escape($languageValue['tag']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "case_study_description SET 
            case_study_id = '" . (int)$case_study_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			second_title = '" . $second_title . "',
			second_description = '" . $second_description . "',
			middle_title = '" . $middle_title . "',
			first_middle_description = '" . $first_middle_description . "',
			second_middle_description = '" . $second_middle_description . "',
			third_middle_description = '" . $third_middle_description . "',
			tag = '" . $tag . "',
            short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == '1') {
				$seoTitle = $title;
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "case_study_image WHERE case_study_id = '" . (int)$case_study_id . "'");
		if (isset($data['case_study_image'])) {
			foreach ($data['case_study_image'] as $case_study_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "case_study_image SET case_study_id = '" . (int)$case_study_id . "', image = '" . $this->db->escape($case_study_image['image']) . "', sort_order = '" . (int)$case_study_image['sort_order'] . "'");
			}
		}

		$this->load_model('seourl');
		$results = $this->db->query("SELECT * FROM aliases WHERE slog='casestudies/detail' AND slog_id='" . $case_study_id . "'");
		if ($data['seo_url']) {
			$keyword =$this->model_seourl->seoUrl($data['seo_url']);
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
		if($results->rows){
			$this->db->query("UPDATE aliases SET url='".$keyword."' WHERE slog='casestudies/detail' AND slog_id='" . $case_study_id . "'");
		}else{
			$this->db->query("INSERT INTO aliases SET url='".$keyword."',slog='casestudies/detail',slog_id='" . $case_study_id . "'");
		}


	}

	public function deleteCaseStudy($case_study_id)
	{

		$this->db->query("DELETE FROM `" . DB_PREFIX . "case_study_description` WHERE case_study_id = '" . (int)$case_study_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "case_study_image WHERE case_study_id = '" . (int)$case_study_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "case_study` WHERE case_study_id = '" . (int)$case_study_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "aliases WHERE slog='casestudies/detail' AND slog_id = '" . (int)$case_study_id . "'");
	}


	public function getCaseStudy($case_study_id)
	{
		$sql = "SELECT cs.*,a.url as seo_url,a.slog_id FROM `" . DB_PREFIX . "case_study` cs LEFT JOIN aliases a ON a.slog_id = cs.case_study_id AND a.slog='casestudies/detail' WHERE cs.case_study_id = " . $case_study_id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getCaseStudyImages($case_study_id)
	{

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "case_study_image WHERE case_study_id = '" . (int)$case_study_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
	public function getCaseStudyDescriptions($case_study_id)
	{
		$case_study_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "case_study_description` csd WHERE csd.case_study_id = " . $case_study_id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$case_study_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
				'second_title'      => $result['second_title'],
				'second_description'      => $result['second_description'],
				'middle_title'      => $result['middle_title'],
				'first_middle_description'      => $result['first_middle_description'],
				'second_middle_description'      => $result['second_middle_description'],
				'third_middle_description'      => $result['third_middle_description'],
				'tag'               => $result['tag'],
				'short_description' => $result['short_description'],
				'meta_keyword'      => $result['meta_keyword'],
				'meta_title'        => $result['meta_title'],
				'meta_description'  => $result['meta_description']
			);
		}
		return $case_study_description_data;
	}

	public function getCaseStudies($data)
	{
		$sql = "SELECT csd.*, cs .* FROM `case_study` cs
				LEFT JOIN case_study_description csd ON cs.case_study_id = csd.case_study_id
				WHERE csd.lang_id = 1 ORDER BY cs.case_study_id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}

		$query = $this->db->query($sql);
		return $query->rows;
	}

	    public function updateCaseStudyStatus($case_study_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "case_study` SET publish = '" . (int)$status . "' WHERE case_study_id = '" . (int)$case_study_id . "'";
        $this->db->query($sql);
        return true;
	}


 public function deleteCaseStudyImage($case_study_id, $type = 'main') {
    // Map the correct column name based on the type
    switch ($type) {
        case 'bannerimage':
            $column = 'banner_image'; // make sure matches DB field name
            break;
        default:
            $column = 'thumbnail'; // or 'image', depending on your DB schema
            break;
    }

    // Fetch the existing image filename
    $query = $this->db->query("SELECT `" . $column . "` AS image FROM " . DB_PREFIX . "case_study WHERE case_study_id = '" . (int)$case_study_id . "'");

    if ($query->num_rows) {
        $image = $query->row['image'];

        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'case_study/' . $image;

            // Delete the file if it exists
            if (file_exists($image_path)) {
                @unlink($image_path);
            }

            // Update DB: clear the column
            $this->db->query("UPDATE " . DB_PREFIX . "case_study SET `" . $column . "` = '' WHERE case_study_id = '" . (int)$case_study_id . "'");
        }

        return ['success' => true];
    } else {
        return ['error' => 'Case Study not found.'];
    }
}

}
