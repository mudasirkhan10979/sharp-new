<?php
class ModelResolution extends Model
{
    public function addResolution($data)
    {
        $status = $this->db->escape($data['status']);
        $sort_order = $this->db->escape($data['sort_order']);
        $insertResolutionQuery = "INSERT INTO `" . DB_PREFIX . "resolution` SET 
        status = '" . $status . "',
        sort_order = '" . $sort_order . "',
        date_added = NOW()";
        $this->db->query($insertResolutionQuery);
        $resolutionId = $this->db->getLastId();
        foreach ($data['resolution_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "resolution_description SET 
            resolution_id = '" . (int)$resolutionId . "',
            lang_id = '" . $languageId . "',
            description = '" . $description . "',
            title = '" . $title . "'";
            $this->db->query($insertDescriptionQuery);
        }
    }

       public function editResolution($resolutionId, $data)
    {
        $status = $this->db->escape($data['status']);
        $sort_order = $this->db->escape($data['sort_order']);
        $updateResolutionQuery = "UPDATE `" . DB_PREFIX . "resolution` SET
        status = '" . $status . "',
        sort_order = '" . $sort_order . "',
        date_modified = NOW()
        WHERE id = '" . (int)$resolutionId . "'";
        $this->db->query($updateResolutionQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "resolution_description WHERE resolution_id = '" . (int)$resolutionId . "'";
        $this->db->query($deleteDescriptionQuery);
        foreach ($data['resolution_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $updateDescriptionQuery = "INSERT INTO " . DB_PREFIX . "resolution_description SET 
            resolution_id = '" . (int)$resolutionId . "',
            lang_id = '" . $languageId . "',
            description = '" . $description . "',
            title = '" . $title . "'";
            $this->db->query($updateDescriptionQuery);
        }
        // die($updateResolutionQuery);
    }

    public function getResolution($resolutionId)
    {
        $query = $this->db->query($sql = "SELECT * FROM `" . DB_PREFIX . "resolution` WHERE id = " . (int)$resolutionId);
        return $query->row;
    }

    public function getResolutionDescriptions($resolutionId)
    {
        $resolution_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "resolution_description` WHERE resolution_id = " . (int)$resolutionId;
        $query = $this->db->query($sql);
        foreach ($query->rows as $result) {
            $resolution_description_data[$result['lang_id']] = array(
                'title'             => $result['title'],
                'description'       => $result['description']
            );
        }
        return $resolution_description_data;
    }

    public function getResolutions($languageId, $data = array())
    {
        $languageId = (int)$languageId;
        $sql = "SELECT rd.*, r.* 
				FROM `" . DB_PREFIX . "resolution` r
				LEFT JOIN `" . DB_PREFIX . "resolution_description` rd ON r.id = rd.resolution_id
				WHERE rd.lang_id = '" . $languageId . "' or  rd.lang_id = 1
				ORDER BY r.id";
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalresolutions()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "resolution`");
        return $query->row['total'];
    }

    public function updateResolutionStatus($resolutionId, $status)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "resolution` SET status = '" . (int)$status . "' WHERE id = '" . (int)$resolutionId . "'");
    }

    public function deleteResolution($resolutionId)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "resolution WHERE id = '" . (int)$resolutionId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "resolution_description WHERE resolution_id = '" . (int)$resolutionId . "'");
    }
}
