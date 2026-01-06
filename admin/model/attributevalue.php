<?php
class ModelAttributeValue extends Model
{
    public function addAttributeValue($data)
    {
        $attributeId = $this->db->escape($data['attribute_id']);
        $attributeKey = $this->db->escape($data['attribute_key']);
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "attribute_value` SET 
            attribute_id = '" . $attributeId . "',
            attribute_key = '" . $attributeKey . "',
            sort_order = '" . $sortOrder . "',
            status = '" . $status . "',
            added_date = NOW(),
            modify_date = NOW()";
            
        $this->db->query($insertQuery);
        $attributeValueId = $this->db->getLastId();
        
        foreach ($data['attribute_value_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "attribute_value_description SET 
                attribute_value_id = '" . (int)$attributeValueId . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "'";
                
            $this->db->query($insertDescriptionQuery);
        }
        
        return $attributeValueId;
    }

    public function editAttributeValue($attribute_value_id, $data)
    {
        $attributeId = $this->db->escape($data['attribute_id']);
        $attributeKey = $this->db->escape($data['attribute_key']);
        $sortOrder = $this->db->escape($data['sort_order']);
        $status = $this->db->escape($data['status']);
        
        $updateQuery = "UPDATE `" . DB_PREFIX . "attribute_value` SET 
            attribute_id = '" . $attributeId . "',
            attribute_key = '" . $attributeKey . "',
            sort_order = '" . $sortOrder . "',
            status = '" . $status . "',
            modify_date = NOW()
            WHERE id = '" . (int)$attribute_value_id . "'";
            
        $this->db->query($updateQuery);
        
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "attribute_value_description WHERE attribute_value_id = '" . (int)$attribute_value_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['attribute_value_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "attribute_value_description SET 
                attribute_value_id = '" . (int)$attribute_value_id . "',
                lang_id = '" . $languageId . "',
                title = '" . $title . "'";

            $this->db->query($insertDescriptionQuery);
        }
    }

    public function deleteAttributeValue($attribute_value_id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "attribute_value_description` WHERE attribute_value_id = '" . (int)$attribute_value_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "attribute_value` WHERE id = '" . (int)$attribute_value_id . "'");
    }

    public function getAttributeValue($attribute_value_id)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "attribute_value` WHERE id = '" . (int)$attribute_value_id . "'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getAttributeValueDescription($attribute_value_id)
    {
        $attribute_value_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "attribute_value_description` WHERE attribute_value_id = '" . (int)$attribute_value_id . "'";
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $attribute_value_description_data[$result['lang_id']] = array(
                'title' => $result['title']
            );
        }
        return $attribute_value_description_data;
    }

    public function getAttributeValues($data = array())
    {
        $sql = "SELECT av.*, avd.title, a.title as attribute_name 
                FROM `" . DB_PREFIX . "attribute_value` av 
                LEFT JOIN `" . DB_PREFIX . "attribute_value_description` avd ON (av.id = avd.attribute_value_id) 
                LEFT JOIN `" . DB_PREFIX . "attribute_description` a ON (av.attribute_id = a.attribute_id AND a.lang_id = '" . (int)$this->config->get('config_language_id') . "')
                WHERE avd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";

        $sql .= " ORDER BY av.sort_order ASC, av.added_date DESC";

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

    public function getTotalAttributeValues()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "attribute_value`");
        return $query->row['total'];
    }

    public function updateAttributeValueStatus($attribute_value_id, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "attribute_value` SET status = '" . (int)$status . "' WHERE id = '" . (int)$attribute_value_id . "'";
        $this->db->query($sql);
        return true;
    }

    public function getAttributeValuesByAttribute($attribute_id)
    {
        $sql = "SELECT av.*, avd.title 
                FROM `" . DB_PREFIX . "attribute_value` av 
                LEFT JOIN `" . DB_PREFIX . "attribute_value_description` avd ON (av.id = avd.attribute_value_id) 
                WHERE av.attribute_id = '" . (int)$attribute_id . "' 
                AND avd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                AND av.status = '1'
                ORDER BY av.sort_order ASC";

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getAttributeValueByKey($attribute_key, $attribute_id)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "attribute_value` 
                WHERE attribute_key = '" . $this->db->escape($attribute_key) . "' 
                AND attribute_id = '" . (int)$attribute_id . "'";
        
        $query = $this->db->query($sql);
        return $query->row;
    }
}
