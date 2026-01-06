<?php
class ModelDownloadCenter extends Model
{
    public function getDownloads($data = array())
    {
        $sql = "SELECT dd.title, dd.description, d.file, d.product_id, 
                       pd.name as product_name, cd.title as category_name, cd.category_id
                FROM `" . DB_PREFIX . "download` d
                JOIN `" . DB_PREFIX . "download_description` dd ON d.id = dd.download_id
                LEFT JOIN `" . DB_PREFIX . "product` p ON p.product_id = d.product_id
                LEFT JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                LEFT JOIN `" . DB_PREFIX . "category` c ON p.category_id = c.category_id
                LEFT JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                WHERE dd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND d.status = 1";
        if (!empty($data['filter_category_id'])) {
            $sql .= " AND c.category_id = '" . (int)$data['filter_category_id'] . "'";
        }

        if (!empty($data['filter_keyword'])) {
            $sql .= " AND (dd.title LIKE '%" . $this->db->escape($data['filter_keyword']) . "%' OR dd.description LIKE '%" . $this->db->escape($data['filter_keyword']) . "%')";
        }

        $sql .= " ORDER BY d.sort_order ASC";
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

    public function getTotalDownloads($data = array())
    {
        $sql = "SELECT COUNT(DISTINCT d.id) AS total 
                FROM `" . DB_PREFIX . "download` d
                JOIN `" . DB_PREFIX . "download_description` dd ON d.id = dd.download_id
                LEFT JOIN `" . DB_PREFIX . "product` p ON p.product_id = d.product_id
                LEFT JOIN `" . DB_PREFIX . "category` c ON p.category_id = c.category_id
                WHERE dd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND d.status = 1";
        if (!empty($data['filter_category_id'])) {
            $sql .= " AND c.category_id = '" . (int)$data['filter_category_id'] . "'";
        }
        if (!empty($data['filter_keyword'])) {
            $sql .= " AND (dd.title LIKE '%" . $this->db->escape($data['filter_keyword']) . "%' OR dd.description LIKE '%" . $this->db->escape($data['filter_keyword']) . "%')";
        }
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getCategories() {
        $sql = "SELECT DISTINCT cd.category_id, cd.title
                FROM `" . DB_PREFIX . "category_description` cd
                JOIN `" . DB_PREFIX . "category` c ON cd.category_id = c.category_id
                JOIN `" . DB_PREFIX . "product` p ON p.category_id = c.category_id
                JOIN `" . DB_PREFIX . "download` d ON d.product_id = p.product_id
                WHERE cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                AND d.status = 1
                AND c.status = 1
                ORDER BY cd.title ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}