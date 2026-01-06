<?php
class ModelAttribute extends Model
{
    public function addAttribute($data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        $categoryId = $this->db->escape(implode(',', array_map('intval', $data['category_id'])));
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "attribute` SET 
            attribute_id = '0',
            category_id = '" . $categoryId . "', 
            sort_order = '" . $sortOrder . "',
            status = '" . $status . "',
            added_date = NOW(),
            modify_date = NOW()";
            
        $this->db->query($insertQuery);
        $attributeId = $this->db->getLastId();
        
        foreach ($data['attribute_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "attribute_description SET 
                attribute_id = '" . (int)$attributeId . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "'";
                
            $this->db->query($insertDescriptionQuery);
        }
        
        return $attributeId;
    }

    public function editAttribute($attribute_id, $data)
    {
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        $categoryId = $this->db->escape(implode(',', array_map('intval', $data['category_id'])));
        $updateQuery = "UPDATE `" . DB_PREFIX . "attribute` SET 
            category_id = '" . $categoryId . "',
            sort_order = '" . $sortOrder . "',
            status = '" . $status . "',
            modify_date = NOW()
            WHERE id = '" . (int)$attribute_id . "'";
            
        $this->db->query($updateQuery);
        
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['attribute_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "attribute_description SET 
                attribute_id = '" . (int)$attribute_id . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "'";

            $this->db->query($insertDescriptionQuery);
        }
    }

    public function deleteAttribute($attribute_id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "attribute_description` WHERE attribute_id = '" . (int)$attribute_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "attribute` WHERE id = '" . (int)$attribute_id . "'");
    }

    public function getAttribute($attribute_id)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "attribute` WHERE id = '" . (int)$attribute_id . "'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getAttributeDescription($attribute_id)
    {
        $attribute_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "attribute_description` WHERE attribute_id = '" . (int)$attribute_id . "'";
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $attribute_description_data[$result['lang_id']] = array(
                'title' => $result['title']
            );
        }
        return $attribute_description_data;
    }

    public function getAttributes($data = array())
    {
        $sql = "SELECT a.*, ad.title FROM `" . DB_PREFIX . "attribute` a 
                LEFT JOIN `" . DB_PREFIX . "attribute_description` ad ON (a.id = ad.attribute_id) 
                WHERE ad.lang_id = '" . (int)$this->config->get('config_language_id') . "'";

        $sql .= " ORDER BY a.sort_order ASC, a.added_date DESC";

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

    public function getTotalAttributes()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "attribute`");
        return $query->row['total'];
    }

    public function updateAttributeStatus($attribute_id, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "attribute` SET status = '" . (int)$status . "' WHERE id = '" . (int)$attribute_id . "'";
        $this->db->query($sql);
        return true;
    }

    public function getAttributesByCategory($category_id)
    {
        $sql = "SELECT a.*, ad.title 
                FROM `" . DB_PREFIX . "attribute` a 
                LEFT JOIN `" . DB_PREFIX . "attribute_description` ad ON (a.id = ad.attribute_id) 
                WHERE a.category_id = '" . (int)$category_id . "' AND ad.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                AND a.status = '1' ORDER BY a.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }


 public function getCategories()

{

    $sql = "SELECT c.category_id, cd.title, cd.short_description, c.image, a.url AS seo_url
            FROM `" . DB_PREFIX . "category` c
            LEFT JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
            LEFT JOIN `" . DB_PREFIX . "aliases` a  ON a.slog = CONCAT('category_id=', c.category_id)
            WHERE c.parent_id IN (SELECT category_id FROM `" . DB_PREFIX . "category` 
            WHERE parent_id = 0)
            AND c.status = 1
            AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            ORDER BY c.sort_order ASC";
    return $this->db->query($sql)->rows;
 }

}
