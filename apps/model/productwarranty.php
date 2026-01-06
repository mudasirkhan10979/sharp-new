<?php
class ModelUserManuals extends Model
{

   public function getProducts() {
        $sql = "SELECT pd.name, p.product_id FROM `" . DB_PREFIX . "product` p 
        LEFT JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id
        WHERE pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}