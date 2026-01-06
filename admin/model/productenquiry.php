<?php
class ModelProductEnquiry extends Model {

    public function deleteProductEnquiry($enquiry_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "productenquiry WHERE enquiry_id = '" . (int)$enquiry_id . "'");
    }

    public function getProductEnquiry($enquiry_id) {
        $query = $this->db->query("SELECT e.*  FROM " . DB_PREFIX . "productenquiry e 
        WHERE e.enquiry_id = '" . (int)$enquiry_id . "'");
        return $query->row;
    }

    public function getProductEnquiries() {
         $sql = "SELECT e.*  FROM " . DB_PREFIX . "productenquiry e 
        ORDER BY e.enquiry_id DESC";

        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function getTotalProductEnquiries() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "productenquiry");
        return $query->row['total'];
    }
}
