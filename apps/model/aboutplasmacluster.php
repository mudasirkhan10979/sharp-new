<?php

class ModelAboutPlasmacluster extends Model
{
    public function getPlasmacluster()
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "certificatesandresearch` c
        LEFT JOIN `" . DB_PREFIX . "certificatesandresearch_description` cd ON c.id = cd.certificatesandresearch_id
        WHERE cd.lang_id = '" . $this->config->get('config_language_id') . "' AND c.status = 1
        ORDER BY c.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

public function getAirPurifiersProducts()
{
    $sql = "SELECT DISTINCT p.product_id, p.is_new, p.category_id, c.category_id AS category_category_id, 
            p.thumbnail, p.image, p.featured_image, pd.name, p.sku AS model, a.url AS seo_url
            FROM `" . DB_PREFIX . "product` p
            INNER JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id 
            AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            LEFT JOIN `" . DB_PREFIX . "category` c ON p.category_id = c.category_id
            LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = p.product_id AND a.slog = 'product/detail'
            WHERE p.publish = 1 AND c.status = 1
            AND p.category_id = 95
            ORDER BY p.sort_order ASC 
            LIMIT 6";  
    $query = $this->db->query($sql);
    return $query->rows;
}

}
