<?php

class ModelIntelligentPrint extends Model
{
  
  public function addIntelligentEnquiry($data)
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

}
