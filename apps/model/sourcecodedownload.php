<?php
class ModelSourceCodeDownload extends Model
{
    public function getSourceCodes($data = array())
    {
        $sql = "SELECT scd.title, sc.file, sc.added_date, sc.product_id, cd.title as category_name, cd.category_id, pd.name as product_name
                FROM `" . DB_PREFIX . "source_code` sc
                JOIN `" . DB_PREFIX . "source_code_description` scd ON sc.id = scd.source_id
                LEFT JOIN `" . DB_PREFIX . "product` p ON p.product_id = sc.product_id
                LEFT JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                LEFT JOIN `" . DB_PREFIX . "category` c ON p.category_id = c.category_id
                LEFT JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                WHERE scd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND sc.status = 1";
                if (!empty($data['filter_category_id'])) {
                    $sql .= " AND c.category_id = '" . (int)$data['filter_category_id'] . "'";
                }

            if (!empty($data['filter_keyword'])) {
                // Split the keyword by spaces
                $keywords = preg_split('/\s+/', $this->db->escape($data['filter_keyword']));
                
                $conditions = [];
                foreach ($keywords as $word) {
                    $word = trim($word);
                    if ($word) {
                        // Check if each word exists in product name + manual title
                        $conditions[] = "CONCAT(pd.name, ' ', scd.title) LIKE '%" . $word . "%'";
                    }
                }

                if ($conditions) {
                    // Combine all conditions with AND, so all words must match
                    $sql .= " AND (" . implode(' AND ', $conditions) . ")";
                }
         }
        $sql .= " ORDER BY sc.sort_order ASC, sc.added_date DESC";
        if (isset($data['start']) || isset($data['limit'])) {
            $data['start'] = max(0, $data['start'] ?? 0);
            $data['limit'] = max(1, $data['limit'] ?? 20);
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        // echo $sql; exit;
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalSourceCodes($data = array())
    {
        $sql = "SELECT COUNT(DISTINCT sc.id) AS total 
                FROM `" . DB_PREFIX . "source_code` sc
                JOIN `" . DB_PREFIX . "source_code_description` scd ON sc.id = scd.source_id
                LEFT JOIN `" . DB_PREFIX . "product` p ON p.product_id = sc.product_id
                LEFT JOIN `" . DB_PREFIX . "category` c ON p.category_id = c.category_id
                WHERE scd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND sc.status = 1";
            if (!empty($data['filter_category_id'])) {
                $sql .= " AND c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }
        
            if (!empty($data['filter_keyword'])) {
                // Split the keyword by spaces
                $keywords = preg_split('/\s+/', $this->db->escape($data['filter_keyword']));
                
                $conditions = [];
                foreach ($keywords as $word) {
                    $word = trim($word);
                    if ($word) {
                        // Check if each word exists in product name + manual title
                        $conditions[] = "CONCAT(pd.name, ' ', scd.title) LIKE '%" . $word . "%'";
                    }
                }

                if ($conditions) {
                    // Combine all conditions with AND, so all words must match
                    $sql .= " AND (" . implode(' AND ', $conditions) . ")";
                }
            }

        
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getCategories()
    {
        $sql = "SELECT DISTINCT cd.category_id, cd.title
                FROM `" . DB_PREFIX . "category_description` cd
                JOIN `" . DB_PREFIX . "category` c ON cd.category_id = c.category_id
                JOIN `" . DB_PREFIX . "product` p ON p.category_id = c.category_id
                JOIN `" . DB_PREFIX . "source_code` sc ON sc.product_id = p.product_id
                WHERE cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                AND sc.status = 1
                AND c.status = 1
                ORDER BY cd.title ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}