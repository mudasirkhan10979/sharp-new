<?php
class ModelCareerEnquiries extends Model {

    public function deleteCareerEnquiry($enquiry_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "career_inquiries WHERE enquiry_id = '" . (int)$enquiry_id . "'");
    }

    public function getCareerEnquiry($enquiry_id) {
       
        $query = $this->db->query("SELECT ci.*,cd.title as title FROM " . DB_PREFIX . "career_inquiries ci LEFT JOIN career_description cd ON cd.career_id = ci.career_id AND cd.lang_id = '1' WHERE ci.enquiry_id = '" . (int)$enquiry_id . "'");
        return $query->row;
    }

    public function getCareerEnquiries() {
     
        $sql = "SELECT ci.*,cd.title as title FROM " . DB_PREFIX . "career_inquiries ci LEFT JOIN career_description cd ON cd.career_id = ci.career_id AND cd.lang_id = '1' ORDER BY ci.enquiry_id DESC";

        $query = $this->db->query($sql);
        return $query->rows;
        
    }
    
}
