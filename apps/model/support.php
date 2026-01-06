<?php
class ModelSupport extends Model
{
   public function GetFaqs()
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "faqs` f
        JOIN `" . DB_PREFIX . "faqs_description` fd ON f.id = fd.faq_id
        WHERE fd.lang_id = '" . $this->config->get('config_language_id') . "' AND f.publish = 1
        ORDER BY f.id DESC LIMIT 3";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}
