<?php
class ModelSearch extends Model
{
    public function getSearch($s = "", $start = 0, $limit = 10)
    {
        if (empty($s)) {
            return [];
        }
        $language_id = (int)$this->config->get('config_language_id');
        $search_term = $this->db->escape($s);
        $start = (int)$start;
        $limit = (int)$limit;
        if ($start < 0) $start = 0;
        if ($limit <= 0) $limit = 10;
        $sql_cat = "SELECT c.category_id FROM " . DB_PREFIX . "category c
        LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = c.category_id AND cd.lang_id = '" . $language_id . "')
        WHERE c.status = 1 AND cd.title LIKE '%" . $search_term . "%' ";
        $cat_query = $this->db->query($sql_cat);
        $matched_category_ids = array_column($cat_query->rows, 'category_id');
        $category_condition = "";
        if (!empty($matched_category_ids)) {
            $category_condition = " OR p.category_id IN (" . implode(',', array_map('intval', $matched_category_ids)) . ")";
        }
        $sql = "SELECT DISTINCT p.product_id, pd.name, a.url AS seo_url, p.image, p.price, cd.title AS category_name, ca.url AS category_url
            FROM " . DB_PREFIX . "product p
            LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.lang_id = '" . $language_id . "')
            LEFT JOIN " . DB_PREFIX . "aliases a ON (a.slog_id = p.product_id AND a.slog = 'product/detail')
            LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p.category_id)
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = c.category_id AND cd.lang_id = '" . $language_id . "')
            LEFT JOIN " . DB_PREFIX . "aliases ca ON (ca.slog = CONCAT('category_id=', c.category_id))
            WHERE p.publish = 1 AND c.status = 1
            AND (
                pd.name LIKE '%" . $search_term . "%'
                OR cd.title LIKE '%" . $search_term . "%'
                $category_condition
            )
            ORDER BY p.product_id DESC
            LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getSearchTotal($s = "")
    {
        if (empty($s)) {
            return 0;
        }
        $language_id = (int)$this->config->get('config_language_id');
        $search_term = $this->db->escape($s);
        $sql_cat = "SELECT c.category_id FROM " . DB_PREFIX . "category c
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = c.category_id AND cd.lang_id = '" . $language_id . "')
            WHERE c.status = 1 AND cd.title LIKE '%" . $search_term . "%'";
        $cat_query = $this->db->query($sql_cat);
        $matched_category_ids = array_column($cat_query->rows, 'category_id');
        $category_condition = "";
        if (!empty($matched_category_ids)) {
            $category_condition = " OR p.category_id IN (" . implode(',', array_map('intval', $matched_category_ids)) . ")";
        }
        $sql = "SELECT COUNT(DISTINCT p.product_id) AS total
            FROM " . DB_PREFIX . "product p
            LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.lang_id = '" . $language_id . "')
            LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p.category_id)
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = c.category_id AND cd.lang_id = '" . $language_id . "')
            WHERE p.publish = 1 AND c.status = 1
            AND (
                pd.name LIKE '%" . $search_term . "%'
                OR cd.title LIKE '%" . $search_term . "%'
                $category_condition
            )";
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }
}
