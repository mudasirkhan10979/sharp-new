<?php
class ModelProduct extends Model
{
    public function getProducts($data = array())
    {
        $sql = "SELECT p.*, pd.*, a.url as seo_url 
                FROM " . DB_PREFIX . "product p 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = p.product_id AND a.slog = 'product/detail'
                LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = p.product_id 
                LEFT JOIN " . DB_PREFIX . "category c ON c.category_id = p.category_id
                WHERE p.publish = '1' AND c.status = '1' AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        $sql .= " ORDER BY p.product_id DESC";
        if (isset($data['start']) || isset($data['limit'])) {
            $sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) as total 
                FROM " . DB_PREFIX . "product p  
                LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = p.product_id 
                WHERE p.publish = '1' AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getProductsDetails($productId)
    {
        $language_id = (int)$this->config->get('config_language_id');

        $sql = "SELECT p.*, pd.*, a.url AS seo_url, cd.title AS category_name, ca.url AS category_url
                FROM `" . DB_PREFIX . "product` p
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = p.product_id AND a.slog = 'product/detail'
                LEFT JOIN `" . DB_PREFIX . "product_description` pd ON pd.product_id = p.product_id AND pd.lang_id = '{$language_id}'
                LEFT JOIN `" . DB_PREFIX . "category` c ON c.category_id = p.category_id
                LEFT JOIN `" . DB_PREFIX . "category_description` cd ON cd.category_id = c.category_id AND cd.lang_id = '{$language_id}'
                LEFT JOIN `" . DB_PREFIX . "aliases` ca ON ca.slog = CONCAT('category_id=', c.category_id)
                WHERE p.product_id = '" . (int)$productId . "' AND p.publish = '1' AND c.status = '1'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getProductImages($productId)
    {
        $sql = "SELECT si.* FROM slider_images si WHERE si.product_id = '" . (int)$productId . "'";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getProductProductBenefits($productId)
    {
        $sql = "SELECT pi.*, pid.* FROM product_icons pi  
        LEFT JOIN " . DB_PREFIX . "product_icons_description pid ON pid.icon_description_id = pi.id AND pid.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
        WHERE pi.product_id = '" . (int)$productId . "'";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getProductProductFeatures($productId)
    {
        $sql = "SELECT pim.*, pimd.* FROM product_images pim  
        LEFT JOIN " . DB_PREFIX . "product_image_description pimd ON pimd.img_description_id = pim.id AND pimd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
        WHERE pim.product_id = '" . (int)$productId . "'";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getSourceCodes($productId)
    {
        $sql = "SELECT sc.*, scd.title 
                FROM " . DB_PREFIX . "source_code sc 
                LEFT JOIN " . DB_PREFIX . "source_code_description scd 
                ON sc.id = scd.source_id 
                WHERE sc.status = 1 AND sc.product_id = " . (int)$productId . "
                AND scd.lang_id = " . (int)$this->config->get('config_language_id') . "
                ORDER BY sc.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getRelatedProducts($productId)
    {
        $categoryQuery = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$productId . "'");
        $category_id = isset($categoryQuery->row['category_id']) ? (int)$categoryQuery->row['category_id'] : 0;
        if (!$category_id) {
            return [];
        }
        $sql = "SELECT p.*, pd.*, a.url as seo_url 
            FROM " . DB_PREFIX . "product p 
            LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = p.product_id AND a.slog = 'product/detail'
            LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = p.product_id 
            WHERE p.publish = '1' AND c.status = '1' 
            AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            AND p.product_id != '" . (int)$productId . "'
            AND p.category_id = '" . (int)$category_id . "'
            ORDER BY p.publish_date DESC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function addEnquiry($data)
    {
        $sql = "INSERT INTO " . DB_PREFIX . "productenquiry SET 
            name ='" . $this->db->escape($data["name"]) . "', 
            email ='" . $this->db->escape($data["email"]) . "',
            phone ='" . $this->db->escape($data["phone"]) . "',
            country ='" . $this->db->escape($data["country"]) . "',
            city ='" . $this->db->escape($data["city"]) . "',
            subject ='" . $this->db->escape($data["subject"]) . "',
            message ='" . $this->db->escape($data["message"]) . "',
            enquiry_from='" . $this->db->escape($data["enquiry_from"]) . "',
            enquiry_date=NOW()";
        return $this->db->query($sql);
    }

    public function getCountries()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE status = '1' ORDER BY name ASC");
        return $query->rows;
    }
}
