<?php
class ModelNewsletters extends Model {

    public function deleteNewsletter($newsletter_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "newsletters WHERE id = '" . (int)$newsletter_id . "'");
    }

    public function getNewsletter($newsletter_id) {
        $query = $this->db->query("SELECT e.*  FROM " . DB_PREFIX . "newsletters e 
        WHERE e.id = '" . (int)$newsletter_id . "'");
        return $query->row;
    }

    public function getNewsletters() {
         $sql = "SELECT e.*  FROM " . DB_PREFIX . "newsletters e 
        ORDER BY e.id DESC";

        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function getTotalNewsletters() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newsletters");
        return $query->row['total'];
    }
}
