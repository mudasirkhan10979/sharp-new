<?php
class ModelFaqs extends Model
{
   public function GetFaqs($data = array())
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "faqs` f
        JOIN `" . DB_PREFIX . "faqs_description` fd ON f.id = fd.faq_id
        WHERE fd.lang_id = '" . $this->config->get('config_language_id') . "' AND f.publish = 1
        ORDER BY f.sort_order ASC";
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

   public function getTotalFaqs()
    {
        $sql = "SELECT COUNT(DISTINCT f.id) AS total FROM `" . DB_PREFIX . "faqs` f
        JOIN `" . DB_PREFIX . "faqs_description` fd ON f.id = fd.faq_id
        WHERE fd.lang_id = '" . $this->config->get('config_language_id') . "' AND f.publish = 1
        ORDER BY f.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
}
