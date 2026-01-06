<?php
class ModelUserManuals extends Model
{
    public function GetUserManuals($data = array())
    {
        $sql = "SELECT umd.title, u.publish_date, u.file, u.product_id, 
                cd.title as category_name, cd.category_id 
                FROM `" . DB_PREFIX . "user_manual` u
                JOIN `" . DB_PREFIX . "user_manual_description` umd ON u.id = umd.manual_id
                LEFT JOIN `" . DB_PREFIX . "product` pu ON pu.product_id = u.product_id
                LEFT JOIN `" . DB_PREFIX . "category` c ON pu.category_id = c.category_id
                LEFT JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE umd.lang_id = '" . $this->config->get('config_language_id') . "' AND u.status = 1";
        if (!empty($data['filter_category_id'])) {
            $sql .= " AND c.category_id = '" . (int)$data['filter_category_id'] . "'";
        }
        if (!empty($data['filter_keyword'])) {
            $sql .= " AND umd.title LIKE '%" . $this->db->escape($data['filter_keyword']) . "%'";
        }
        $sql .= " ORDER BY u.sort_order ASC";
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

    public function getTotalUserManuals($data = array())
    {
        $sql = "SELECT COUNT(DISTINCT u.id) AS total FROM `" . DB_PREFIX . "user_manual` u
        JOIN `" . DB_PREFIX . "user_manual_description` umd ON u.id = umd.manual_id
        LEFT JOIN `" . DB_PREFIX . "product` pu ON pu.product_id = u.product_id
        LEFT JOIN `" . DB_PREFIX . "category` c ON pu.category_id = c.category_id
        WHERE umd.lang_id = '" . $this->config->get('config_language_id') . "' AND u.status = 1";
        if (!empty($data['filter_category_id'])) {
            $sql .= " AND c.category_id = '" . (int)$data['filter_category_id'] . "'";
        }
        if (!empty($data['filter_keyword'])) {
            $sql .= " AND umd.title LIKE '%" . $this->db->escape($data['filter_keyword']) . "%'";
        }
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

   public function getCategories() {
        $sql = "SELECT DISTINCT cd.category_id, cd.title 
                FROM `" . DB_PREFIX . "category_description` cd
                JOIN `" . DB_PREFIX . "category` c ON cd.category_id = c.category_id
                JOIN `" . DB_PREFIX . "product` p ON p.category_id = c.category_id
                JOIN `" . DB_PREFIX . "user_manual` u ON u.product_id = p.product_id
                WHERE cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                AND u.status = 1
                AND c.status = 1
                ORDER BY cd.title ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}