<?php
class ModelCareers extends Model {

	public function addCareer($data)
	{ 
		$status = $this->db->escape($data['status']);
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish_date = $this->db->escape($data['publish_date']);
		$location_id = $this->db->escape($data['location_id']);
		$jobtype_id = $this->db->escape($data['jobtype_id']);
		$insertTestimonialQuery = "INSERT INTO `" . DB_PREFIX . "careers` SET 
        publish_date = '" . $publish_date . "', 
        location_id = '" . $location_id . "',  
        jobtype_id = '" . $jobtype_id . "',  
        status = '" . $status . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
		$this->db->query($insertTestimonialQuery);
		$career_id = $this->db->getLastId();
		foreach ($data['careers_description'] as $languageId => $languageValue) { 
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$job_description = $this->db->escape($languageValue['job_description']);
			$key_description = $this->db->escape($languageValue['key_description']);
			$requirements_description = $this->db->escape($languageValue['requirements_description']);
			$skills_description = $this->db->escape($languageValue['skills_description']);
			$benefits_description = $this->db->escape($languageValue['benefits_description']);

			$meta_keywords = $this->db->escape($languageValue['meta_keywords']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "career_description SET 
            career_id = '" . (int)$career_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			short_description = '" . $short_description . "',
			meta_keywords = '" . $meta_keywords . "',
			meta_title = '" . $meta_title . "',
			meta_description = '" . $meta_description . "',
			key_description = '" . $key_description . "',
			requirements_description = '" . $requirements_description . "',
			skills_description = '" . $skills_description . "',
			benefits_description = '" . $benefits_description . "',
            job_description = '" . $job_description . "'"; 
			$this->db->query($insertDescriptionQuery);
			if($languageId == 1)
			{
				$seoTitle = $title;
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
		$this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = 'careers/detail', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $career_id . "'");
	}
	public function editCareer($career_id, $data)
	{ 
		$status = $this->db->escape($data['status']);
		$sortOrder = $this->db->escape($data['sort_order']);
        $publish_date = $this->db->escape($data['publish_date']);
		$location_id = $this->db->escape($data['location_id']);
		$jobtype_id = $this->db->escape($data['jobtype_id']);
		$updatetesTimonialQuery = "UPDATE `" . DB_PREFIX . "careers` SET
        publish_date = '" . $publish_date . "', 
        location_id = '" . $location_id . "', 
        jobtype_id = '" . $jobtype_id . "', 
        status = '" . $status . "',
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'
        WHERE id = '" . (int)$career_id . "'";
		$this->db->query($updatetesTimonialQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "career_description WHERE career_id = '" . (int)$career_id . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['careers_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$job_description = $this->db->escape($languageValue['job_description']);
			$key_description = $this->db->escape($languageValue['key_description']);
			$requirements_description = $this->db->escape($languageValue['requirements_description']);
			$skills_description = $this->db->escape($languageValue['skills_description']);
			$benefits_description = $this->db->escape($languageValue['benefits_description']);
			$meta_keywords = $this->db->escape($languageValue['meta_keywords']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "career_description SET 
            career_id = '" . (int)$career_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			short_description = '" . $short_description . "',
			meta_keywords = '" . $meta_keywords . "',
			meta_title = '" . $meta_title . "',
			meta_description = '" . $meta_description . "',
			key_description = '" . $key_description . "',
			requirements_description = '" . $requirements_description . "',
			skills_description = '" . $skills_description . "',
			benefits_description = '" . $benefits_description . "',
            job_description = '" . $job_description . "'"; 
			$this->db->query($insertDescriptionQuery);
			if($languageId == 1)
			{
				$seoTitle = $title;
			}
		} 
		$this->load_model('seourl');
		$results = $this->db->query("SELECT * FROM aliases WHERE slog='careers/detail' AND slog_id='" . $career_id . "'");
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
			$this->db->query("UPDATE aliases SET url='" . $keyword . "' WHERE slog='careers/detail' AND slog_id='" . $career_id . "'");
		} else {
			$this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='careers/detail',slog_id='" . $career_id . "'");
		} 


	}
	public function deleteCareer($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "career_description` WHERE career_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "careers` WHERE id = '" . (int)$id . "'"); 
		$this->db->query("DELETE FROM `" . DB_PREFIX . "aliases` WHERE slog = 'careers/detail' AND slog_id = '" . (int)$id . "'"); 

	} 


	public function getCareer($id)
	{
		$sql = "SELECT c.* ,a.url as seo_url FROM `" . DB_PREFIX . "careers` c
		LEFT JOIN aliases a ON a.slog_id = c.id AND a.slog='careers/detail' 
		WHERE c.id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getCareerDescriptions($id)
	{
		$career_description = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "career_description` WHERE career_description.career_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$career_description[$result['lang_id']] = array(
				'title'               => $result['title'],
				'short_description'   => $result['short_description'],
				'key_description'     => $result['key_description'],
				'requirements_description' => $result['requirements_description'],
				'skills_description'  => $result['skills_description'],
				'benefits_description' => $result['benefits_description'],
				'job_description'     => $result['job_description'],
				'meta_keywords'       => $result['meta_keywords'],
				'meta_title'          => $result['meta_title'],
				'meta_description'    => $result['meta_description']
			);
		}
		return $career_description;
	}
	public function getCareers($data)
	{
		$sql = "SELECT career_description.*, careers.* FROM `careers` 
				LEFT JOIN career_description on careers.id = career_description.career_id
				WHERE career_description.lang_id = 1 ORDER BY careers.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalCareers()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "careers`");
		return $query->row['total'];
	}
	public function getLocations()
	{
		$sql = "SELECT location_description.location_id AS id,location_description.title,locations.*
		FROM location_description
		LEFT JOIN locations ON locations.id = location_description.location_id
		WHERE location_description.lang_id = 1 AND publish = 1 ORDER BY locations.id"; 
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getJobTypes()
	{
		        $sql = "SELECT jobtype.id, jobtype_description.title 
				FROM `jobtype` 
				LEFT JOIN jobtype_description ON jobtype.id = jobtype_description.jobtype_id
				WHERE jobtype_description.lang_id = 1 AND publish = 1
				ORDER BY jobtype.id"; 
		        $query = $this->db->query($sql);
		       return $query->rows;
	}
	public function updateCareersStatus($career_id, $status) {

		$sql = "UPDATE `" . DB_PREFIX . "careers` SET status = '" . (int)$status . "' WHERE id = '" . (int)$career_id . "'";
		$this->db->query($sql);
	} 
}