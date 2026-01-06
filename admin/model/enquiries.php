<?php
class ModelEnquiries extends Model {

    public function deleteEnquiry($enquiry_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "enquiries WHERE enquiry_id = '" . (int)$enquiry_id . "'");
    }

    public function getEnquiry($enquiry_id) {
        $query = $this->db->query("SELECT e.*  FROM " . DB_PREFIX . "enquiries e 
        WHERE e.enquiry_id = '" . (int)$enquiry_id . "'");
        return $query->row;
    }

    public function getEnquiries() {
         $sql = "SELECT e.*  FROM " . DB_PREFIX . "enquiries e 
        ORDER BY e.enquiry_id DESC";

        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function getTotalEnquiries() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "enquiries");
        return $query->row['total'];
    }
}
