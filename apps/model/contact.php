<?php
class ModelContact extends Model
{

    public function addContact($data)
    {
        $sql = "INSERT INTO " . DB_PREFIX . " enquiries SET 
        name ='" . $this->db->escape($data["name"]) . "', 
        email ='" . $this->db->escape($data["email"]) . "',
        phone ='" . $this->db->escape($data["phone"]) . "',
        subject ='" . $this->db->escape($data["subject"]) . "',
        message='" . $this->db->escape($data["message"]) . "',	
        enquiry_from ='" . $this->db->escape($data["enquiry_from"]) . "',	
        enquiry_date=NOW()";
        $result =  $this->db->query($sql);
        return $result;
    }

        public function getCustomerFeedback()
    {
        $sql = "SELECT *
        FROM `" . DB_PREFIX . "customer_feedback` c
        JOIN `" . DB_PREFIX . "feedback_description` cd ON c.id = cd.feedback_id
        WHERE cd.lang_id = '" . $this->config->get('config_language_id') . "' AND c.status = 1
        ORDER BY c.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function GetServiceCenters() 
    {
        $sql = "SELECT sc.*, scd.*, c.name AS country_name, c.country_id
                FROM `" . DB_PREFIX . "service_centers` sc
                JOIN `" . DB_PREFIX . "service_centers_description` scd ON sc.service_center_id = scd.service_center_id
                LEFT JOIN `" . DB_PREFIX . "country` c ON sc.country_id = c.country_id 
                WHERE scd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND sc.publish = 1";
        $query = $this->db->query($sql);
        return $query->rows;
    }

}
