<?php
class ModelServiceCenters extends Model
{
    public function GetServiceCenters($data = array())
    {
        $sql = "SELECT sc.*, scd.*, c.name AS country_name, c.country_id
                FROM `" . DB_PREFIX . "service_centers` sc
                JOIN `" . DB_PREFIX . "service_centers_description` scd 
                  ON sc.service_center_id = scd.service_center_id 
                  AND scd.language_id = '" . (int)$this->config->get('config_language_id') . "'
                LEFT JOIN `" . DB_PREFIX . "country` c 
                  ON sc.country_id = c.country_id 
                  AND c.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                WHERE sc.publish = 1";

        if (!empty($data['keyword'])) {
            $sql .= " AND (scd.service_center_name LIKE '%" . $this->db->escape($data['keyword']) . "%' 
                          OR scd.address LIKE '%" . $this->db->escape($data['keyword']) . "%'
                          OR c.name LIKE '%" . $this->db->escape($data['keyword']) . "%'
                          OR sc.department LIKE '%" . $this->db->escape($data['keyword']) . "%'
                          OR sc.sr LIKE '%" . $this->db->escape($data['keyword']) . "%'
                          OR sc.landline LIKE '%" . $this->db->escape($data['keyword']) . "%')";
        }

        if (!empty($data['country_id'])) {
            $sql .= " AND sc.country_id = '" . (int)$data['country_id'] . "'";
        }

        $sql .= " ORDER BY sc.sort_order ASC";

        $start = isset($data['start']) ? (int)$data['start'] : 0;
        $limit = isset($data['limit']) ? (int)$data['limit'] : 10;

        $sql .= " LIMIT " . $start . "," . $limit;

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalServiceCenters($data = array())
    {
        $sql = "SELECT COUNT(DISTINCT sc.service_center_id) AS total 
                FROM `" . DB_PREFIX . "service_centers` sc
                JOIN `" . DB_PREFIX . "service_centers_description` scd 
                  ON sc.service_center_id = scd.service_center_id 
                  AND scd.language_id = '" . (int)$this->config->get('config_language_id') . "'
                LEFT JOIN `" . DB_PREFIX . "country` c 
                  ON sc.country_id = c.country_id 
                  AND c.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                WHERE sc.publish = 1";

        if (!empty($data['keyword'])) {
            $sql .= " AND (scd.service_center_name LIKE '%" . $this->db->escape($data['keyword']) . "%' 
                          OR scd.address LIKE '%" . $this->db->escape($data['keyword']) . "%'
                          OR c.name LIKE '%" . $this->db->escape($data['keyword']) . "%'
                          OR sc.department LIKE '%" . $this->db->escape($data['keyword']) . "%'
                          OR sc.sr LIKE '%" . $this->db->escape($data['keyword']) . "%'
                          OR sc.landline LIKE '%" . $this->db->escape($data['keyword']) . "%')";
        }

        if (!empty($data['country_id'])) {
            $sql .= " AND sc.country_id = '" . (int)$data['country_id'] . "'";
        }

        $query = $this->db->query($sql);
        return $query->row['total'];
    }
}
