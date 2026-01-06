<?php

class ModelCareers extends Model
{
    public function getCareers($data = array())
    {
        $sql = "SELECT c.*, cd.*, jd.title as jobtype_name, a.url as seo_url, ld.title as location_title 
                FROM " . DB_PREFIX . "careers c 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = c.id AND a.slog = 'careers/detail'
                LEFT JOIN " . DB_PREFIX . "career_description cd ON cd.career_id = c.id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN " . DB_PREFIX . "locations l ON FIND_IN_SET(l.id, c.location_id) AND l.publish = 1
                LEFT JOIN " . DB_PREFIX . "location_description ld ON ld.location_id = l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN " . DB_PREFIX . "jobtype j ON FIND_IN_SET(j.id, c.jobtype_id) 
                LEFT JOIN " . DB_PREFIX . "jobtype_description jd ON jd.jobtype_id = j.id AND jd.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE c.status = '1' AND cd.lang_id = '" . $this->config->get('config_language_id') . "'";

        if (!empty($data['filter_jobtype'])) {
            $sql .= " AND FIND_IN_SET('" . (int)$data['filter_jobtype'] . "', c.jobtype_id)";
        }

        if (!empty($data['filter_location'])) {
            $sql .= " AND ld.title LIKE '%" . $this->db->escape($data['filter_location']) . "%'";
        }

        if (!empty($data['filter_title'])) {
            $sql .= " AND cd.title LIKE '%" . $this->db->escape($data['filter_title']) . "%'";
        }

        $sql .= " GROUP BY c.id";
        $sql .= " ORDER BY c.sort_order ASC, c.id DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            $sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getjobtypes()
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "jobtype j
                LEFT JOIN " . DB_PREFIX . "jobtype_description jd ON jd.jobtype_id = j.id AND jd.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE j.publish = '1' AND jd.lang_id = '" . $this->config->get('config_language_id') . "'
                ORDER BY j.sort_order ASC";

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getLocations()
    {
        $sql = "SELECT DISTINCT ld.title, l.id 
                FROM " . DB_PREFIX . "locations l
                LEFT JOIN " . DB_PREFIX . "location_description ld ON ld.location_id = l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE l.publish = '1'
                ORDER BY ld.title ASC";

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalCareers($data)
    {
        $sql = "SELECT COUNT(DISTINCT c.id) AS total 
                FROM " . DB_PREFIX . "careers c 
                LEFT JOIN " . DB_PREFIX . "career_description cd ON cd.career_id = c.id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN " . DB_PREFIX . "locations l ON FIND_IN_SET(l.id, c.location_id) AND l.publish = 1
                LEFT JOIN " . DB_PREFIX . "location_description ld ON ld.location_id = l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE c.status = '1' AND cd.lang_id = '" . $this->config->get('config_language_id') . "'";
        if (!empty($data['filter_jobtype'])) {
            $sql .= " AND FIND_IN_SET('" . (int)$data['filter_jobtype'] . "', c.jobtype_id)";;
        }

        if (!empty($data['filter_location'])) {
            $sql .= " AND ld.title LIKE '%" . $this->db->escape($data['filter_location']) . "%'";
        }

        if (!empty($data['filter_title'])) {
            $sql .= " AND cd.title LIKE '%" . $this->db->escape($data['filter_title']) . "%'";
        }

        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getCareerDetails($careerId)
    {
        $sql = "SELECT c.*, cd.*, jd.title as jobtype_name, a.url as seo_url, ld.title as location_title 
                FROM " . DB_PREFIX . "careers c 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = c.id AND a.slog = 'careers/detail'
                LEFT JOIN " . DB_PREFIX . "career_description cd ON cd.career_id = c.id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN " . DB_PREFIX . "locations l ON FIND_IN_SET(l.id, c.location_id) AND l.publish = 1
                LEFT JOIN " . DB_PREFIX . "location_description ld ON ld.location_id = l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN " . DB_PREFIX . "jobtype j ON FIND_IN_SET(j.id, c.jobtype_id) 
                LEFT JOIN " . DB_PREFIX . "jobtype_description jd ON jd.jobtype_id = j.id AND jd.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE c.status = '1' AND cd.lang_id = '" . $this->config->get('config_language_id') . "' AND c.id = '" . (int)$careerId . "'";
        $query = $this->db->query($sql);
        $result = $query->row;
        return $result;
    }
    public function getRelatedCareer($careerId)
    {
        $sql = "SELECT c.*, cd.*, jd.title as jobtype_name, a.url as seo_url, ld.title as location_title 
                FROM " . DB_PREFIX . "careers c 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = c.id AND a.slog = 'careers/detail'
                LEFT JOIN " . DB_PREFIX . "career_description cd ON cd.career_id = c.id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN " . DB_PREFIX . "locations l ON FIND_IN_SET(l.id, c.location_id) AND l.publish = 1
                LEFT JOIN " . DB_PREFIX . "location_description ld ON ld.location_id = l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN " . DB_PREFIX . "jobtype j ON FIND_IN_SET(j.id, c.jobtype_id) 
                LEFT JOIN " . DB_PREFIX . "jobtype_description jd ON jd.jobtype_id = j.id AND jd.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE c.status = '1' AND cd.lang_id = '" . $this->config->get('config_language_id') . "'";
        if ($careerId) {
            $sql .= " AND  c.id != '" . (int)$careerId . "'";
        }
        $sql .= " GROUP BY c.id";
        $sql .= " ORDER BY c.sort_order, c.id DESC";
        $query = $this->db->query($sql);
        $careers = $query->rows;
        return $careers;
    }

    public function addCareerEnquiry($data)
    {
        $subject = $this->db->escape($data['subject']);
        $name = $this->db->escape($data['name']);
        $email = $this->db->escape($data['email']);
        $phone = $this->db->escape($data['phone']);
        $message = $this->db->escape($data['message']);
        $career_id = $this->db->escape($data['career_id']);
        $enquiry_from = $this->db->escape($data['enquiry_from']);
        $cv_file = $this->handleUploadedImage($_FILES["cv_file"]);
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "career_inquiries` SET 
                career_id = '" . $career_id . "', 
                name = '" . $name . "', 
                email = '" . $email . "', 
                phone = '" . $phone . "', 
                enquiry_from = '" . $enquiry_from . "',
                subject = '" . $subject . "', 
                message = '" . $message . "', 
                cv_file = '" . $cv_file . "', 
                date_added = NOW()";

        $this->db->query($insertQuery);
        return $cv_file;
    }

    private function handleUploadedImage($file)
    {
        if (empty($file['name'])) {
            return "";
        }
        $targetDirectory = DIR_IMAGE . "careers/cvs/";
        $filename = time() . rand() . $file["name"];
        $targetFile = $targetDirectory . $filename;
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($filename);
    }
}
