<?php
class ModelMainCategory extends Model
{
    // public function getCategoriesByParent($parent_id = 0)
    // {
    //     $sql = "SELECT c.category_id, cd.title, cd.short_description, c.image, c.feature_image, a.url AS seo_url, parent_a.url AS parent_seo_url
    //             FROM `" . DB_PREFIX . "category` c
    //             LEFT JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
    //             LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog = CONCAT('category_id=', c.category_id)
    //             LEFT JOIN `" . DB_PREFIX . "category` parent ON c.parent_id = parent.category_id
    //             LEFT JOIN `" . DB_PREFIX . "aliases` parent_a ON parent_a.slog = CONCAT('category_id=', parent.category_id)
    //             WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = 1 
    //             AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
    //             ORDER BY c.sort_order ASC";
    //     return $this->db->query($sql)->rows;
    // }

    public function getCategoriesByParent($parent_id = 0)
{
    $sql = "SELECT c.category_id, cd.title, cd.short_description, c.image, c.feature_image,
                   a.url AS seo_url, parent_a.url AS parent_seo_url
            FROM `" . DB_PREFIX . "category` c
            LEFT JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
            LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog = CONCAT('category_id=', c.category_id)
            LEFT JOIN `" . DB_PREFIX . "category` parent ON c.parent_id = parent.category_id
            LEFT JOIN `" . DB_PREFIX . "aliases` parent_a ON parent_a.slog = CONCAT('category_id=', parent.category_id)
            WHERE c.parent_id = '" . (int)$parent_id . "' 
            AND c.status = 1 
            AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            ORDER BY c.sort_order ASC";

    $rows = $this->db->query($sql)->rows;

    // Apply Logic Here
    foreach ($rows as &$row) {
        // Remove -ID from slug (example: dishwasher-22 → dishwasher)
        if (!empty($row['seo_url'])) {
            $row['seo_url'] = preg_replace('/-\d+$/', '', $row['seo_url']);
        }
        if (!empty($row['parent_seo_url'])) {
            $row['parent_seo_url'] = preg_replace('/-\d+$/', '', $row['parent_seo_url']);
        }
        // Build final full URL
        $row['full_url'] = HTTPS_HOST . $row['parent_seo_url'] . '/' . $row['seo_url'];
    }
    return $rows;
}

    public function getCategories()
    {
        return $this->getCategoriesByParent(0);
    }

    public function hasChildCategories($category_id)
    {
        $sql = "SELECT COUNT(*) as total 
                FROM `" . DB_PREFIX . "category` 
                WHERE parent_id = '" . (int)$category_id . "' 
                AND status = 1";
        $result = $this->db->query($sql);
        return $result->row['total'] > 0;
    }

    public function getCategoryType($category_id)
    {
        $sql = "SELECT parent_id FROM `" . DB_PREFIX . "category` 
                WHERE category_id = '" . (int)$category_id . "'";
        $result = $this->db->query($sql);
        
        if ($result->row['parent_id'] == 0) {
            return 'parent';
        } else {
            return 'child';
        }
    }

    public function getChildCategories($parent_id)
    {
        $sql = "SELECT c.category_id, cd.title, c.image, ca.url AS seo_url, pa.url AS parent_url
                FROM `" . DB_PREFIX . "category` c 
                LEFT JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
                LEFT JOIN `" . DB_PREFIX . "aliases` ca ON ca.slog = CONCAT('category_id=', c.category_id)
                LEFT JOIN `" . DB_PREFIX . "category` pc ON c.parent_id = pc.category_id
                LEFT JOIN `" . DB_PREFIX . "aliases` pa ON pa.slog = CONCAT('category_id=', pc.category_id)
                WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = 1 
                AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                ORDER BY c.sort_order ASC";
        $result = $this->db->query($sql)->rows;
        foreach ($result as &$row) {
            $row['children'] = $this->getChildCategories($row['category_id']);
        }

        return $result;
    }

    public function getCategoryPage($category_id)
    {
        $sql = "SELECT c.category_id, cd.title, cd.short_description, c.image
                FROM `" . DB_PREFIX . "category` c
                JOIN `" . DB_PREFIX . "category_description` cd 
                ON c.category_id = cd.category_id
                WHERE c.category_id = '" . (int)$category_id . "' 
                AND c.status = 1 
                AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                LIMIT 1";
        return $this->db->query($sql)->row;
    }

    private function getAllChildCategoryIds($parent_id)
    {
        $child_ids = [];
        $query = $this->db->query("SELECT category_id FROM `" . DB_PREFIX . "category` WHERE parent_id = '" . (int)$parent_id . "'");
        foreach ($query->rows as $row) {
            $child_ids[] = $row['category_id'];
            $child_ids = array_merge($child_ids, $this->getAllChildCategoryIds($row['category_id']));
        }
        return $child_ids;
    }
public function getProductsByCategory($category_id, $start = 0, $limit = 3)
{
    $category_ids = $this->getAllChildCategoryIds($category_id);
    $category_ids[] = (int)$category_id;
    $ids = implode(',', array_map('intval', $category_ids));
    $sql_ids = "SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE p.publish = 1 AND p.featured = 1 
    AND p.category_id IN ($ids) ORDER BY p.product_id DESC LIMIT " . (int)$start . "," . (int)$limit;
    $product_ids_result = $this->db->query($sql_ids);
    if (empty($product_ids_result->rows)) {
        return [];
    }
    $product_ids = [];
    foreach ($product_ids_result->rows as $row) {
        $product_ids[] = $row['product_id'];
    }
    $ids_string = implode(',', $product_ids);
    $sql_details = "SELECT p.product_id, p.is_new, p.image, pd.name, p.sku AS model, a.url AS seo_url
                    FROM `" . DB_PREFIX . "product` p
                    LEFT JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id
                    LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = p.product_id AND a.slog = 'product/detail'
                    WHERE p.product_id IN ($ids_string)
                    AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                    ORDER BY p.product_id DESC";
    $query = $this->db->query($sql_details);
    $products = [];
    foreach ($query->rows as $product) {
        $products[] = [
            'product_id' => $product['product_id'],
            'name'       => $product['name'],
            'is_new'     => $product['is_new'],
            'image'      => $product['image'],
            'url'        => HTTPS_HOST . 'product/' . $product['seo_url']
        ];
    }
    return $products;
}


public function getTotalFeaturedProductsByCategory($category_id)
    {
        $category_ids = $this->getAllChildCategoryIds($category_id);
        $category_ids[] = (int)$category_id;
        $ids = implode(',', array_map('intval', $category_ids));
        $sql = "SELECT COUNT(DISTINCT p.product_id) as total
                FROM `" . DB_PREFIX . "product` p
                LEFT JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id
                WHERE pd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND p.publish = 1 AND p.featured = 1 AND p.category_id IN ($ids)";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

public function getAllFeaturedProducts($start = 0, $limit = 3)
{
    $sql_ids = "SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p
                WHERE p.publish = 1 AND p.featured = 1 ORDER BY p.product_id DESC 
                LIMIT " . (int)$start . "," . (int)$limit;
    $product_ids_result = $this->db->query($sql_ids);
    if (empty($product_ids_result->rows)) {
        return [];
    }
    $product_ids = [];
    foreach ($product_ids_result->rows as $row) {
        $product_ids[] = $row['product_id'];
    }
    $ids_string = implode(',', $product_ids);
    $sql_details = "SELECT p.product_id, p.is_new, p.image, pd.name, p.sku AS model, a.url AS seo_url
                    FROM `" . DB_PREFIX . "product` p LEFT JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id
                    LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = p.product_id AND a.slog = 'product/detail'
                    WHERE p.product_id IN ($ids_string) AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                    ORDER BY p.product_id DESC";
    $query = $this->db->query($sql_details);
    $products = [];
    foreach ($query->rows as $product) {
        $products[] = [
            'product_id' => $product['product_id'],
            'name'       => $product['name'],
            'is_new'     => $product['is_new'],
            'model'      => $product['model'],
            'image'      => $product['image'],
            'url'        => HTTPS_HOST . $product['seo_url']
        ];
    }
    return $products;
}

public function getTotalAllFeaturedProducts()
    {
        $sql = "SELECT COUNT(DISTINCT p.product_id) as total
                FROM `" . DB_PREFIX . "product` p
                LEFT JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id
                WHERE pd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND p.publish = 1 AND p.featured = 1";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getCategoryPagee($category_id)
    {
        $sql = "SELECT * FROM category c 
                LEFT JOIN category_description cd ON cd.category_id = c.category_id 
                WHERE c.category_id = '" . (int)$category_id . "' AND c.status = 1 
                AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                LIMIT 1";
        return $this->db->query($sql)->row;
    }

    public function getCategoriesByChild($parent_id) {
        $language_id = (int)$this->config->get('config_language_id');
        $parent_id = (int)$parent_id;

        $sql = "SELECT DISTINCT c.category_id, cd.title, cd.short_description, c.image, a.url AS seo_url, parent_a.url AS parent_seo_url, c.parent_id, c.sort_order, cp.level
                FROM " . DB_PREFIX . "category_path cp
                INNER JOIN " . DB_PREFIX . "category c ON cp.category_id = c.category_id
                LEFT JOIN " . DB_PREFIX . "category_description cd ON c.category_id = cd.category_id
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog = CONCAT('category_id=', c.category_id)
                LEFT JOIN " . DB_PREFIX . "category parent ON c.parent_id = parent.category_id
                LEFT JOIN " . DB_PREFIX . "aliases parent_a ON parent_a.slog = CONCAT('category_id=', parent.category_id)
                WHERE cp.path_id = '" . (int)$parent_id . "'
                AND cp.category_id != '" . (int)$parent_id . "'  -- Exclude parent
                AND c.status = 1
                AND cd.lang_id = '" . $language_id . "'
                ORDER BY cp.level, c.sort_order ASC";
        return $this->db->query($sql)->rows;
    }

    public function getParentCategory($category_id)
    {
        $sql = "SELECT c.category_id, cd.title, ca.url 
                FROM category c
                LEFT JOIN category_description cd ON cd.category_id = c.category_id 
                LEFT JOIN aliases ca ON ca.slog = CONCAT('category_id=', c.category_id)
                WHERE c.category_id = (SELECT parent_id FROM category WHERE category_id = '" . (int)$category_id . "')
                AND c.status = 1 AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                LIMIT 1";
        return $this->db->query($sql)->row;
    }

    public function getFilters($category_id)
    {
        $parent_ids = $this->getAllParentCategoryIds($category_id);
        $category_ids = array_merge([$category_id], $parent_ids);
        $placeholders = implode(',', array_fill(0, count($category_ids), '?'));
        // $sql = "SELECT DISTINCT a.id AS attribute_id, ad.title AS attribute_title, av.id AS value_id, avd.title AS value_title, a.category_id AS assigned_category
        //         FROM `" . DB_PREFIX . "attribute` a
        //         INNER JOIN `" . DB_PREFIX . "attribute_description` ad ON ad.attribute_id = a.id AND ad.lang_id = '" . (int)$this->config->get('config_language_id') . "'
        //         LEFT JOIN `" . DB_PREFIX . "attribute_value` av ON av.attribute_id = a.id AND av.status = 1
        //         LEFT JOIN `" . DB_PREFIX . "attribute_value_description` avd ON avd.attribute_value_id = av.id AND avd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
        //         WHERE a.status = 1
        //         AND (
        //             a.category_id IN ($placeholders)
        //             OR a.category_id = '0' -- Global attributes
        //             OR FIND_IN_SET('" . (int)$category_id . "', a.category_id)
        //             OR " . $this->buildCategoryMatchConditions($category_ids) . "
        //         )
        //      ORDER BY a.sort_order ASC, av.sort_order ASC";

    $sql = "SELECT DISTINCT a.id AS attribute_id, ad.title AS attribute_title, av.id AS value_id, avd.title AS value_title, a.category_id AS assigned_category
            FROM `" . DB_PREFIX . "attribute` a
            INNER JOIN `" . DB_PREFIX . "attribute_description` ad 
                ON ad.attribute_id = a.id AND ad.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            LEFT JOIN `" . DB_PREFIX . "attribute_value` av 
                ON av.attribute_id = a.id AND av.status = 1
            LEFT JOIN `" . DB_PREFIX . "attribute_value_description` avd 
                ON avd.attribute_value_id = av.id AND avd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            WHERE a.status = 1
            AND (
                a.category_id IN ($placeholders)
                OR a.category_id = '0' -- Global attributes
                OR FIND_IN_SET('" . (int)$category_id . "', a.category_id)
                OR " . $this->buildCategoryMatchConditions($category_ids) . "
            )
         ORDER BY a.sort_order ASC, av.sort_order ASC";



        $params = $category_ids;
        $query = $this->db->query($sql, $params);
        $grouped = [];
        foreach ($query->rows as &$row) {
            $id = $row['attribute_id'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'attribute_id' => $id,
                    'attribute_title' => $row['attribute_title'],
                    'assigned_category' => $row['assigned_category'],
                    'values' => []
                ];
            }
            if (!empty($row['value_id'])) {
                $grouped[$id]['values'][] = [
                    'value_id' => $row['value_id'],
                    'value_title' => $row['value_title']
                ];
            }
        }
        $feature = [
            ['value' => '1', 'name' => 'Featured'],
            ['value' => '0', 'name' => 'Unfeatured']
        ];
        $price_ranges = [
            ['value' => '0-100', 'name' => 'Under $100'],
            ['value' => '100-500', 'name' => '$100 - $500'],
            ['value' => '500-1000', 'name' => '$500 - $1000'],
            ['value' => '1000-2000', 'name' => '$1000 - $2000'],
            ['value' => '2000+', 'name' => 'Over $2000']
        ];
        return [
            'grouped_attributes' => $grouped,
            'feature' => $feature,
            'price_ranges' => $price_ranges
        ];
    }
    private function getAllParentCategoryIds($category_id)
    {
        $parent_ids = [];
        $current_id = $category_id;
        $max_depth = 10;
        $depth = 0;
        while ($current_id > 0 && $depth < $max_depth) {
            $query = $this->db->query("SELECT parent_id FROM `" . DB_PREFIX . "category` WHERE category_id = '" . (int)$current_id . "'");
            
            if ($query->row && $query->row['parent_id'] > 0) {
                $parent_id = $query->row['parent_id'];
                $parent_ids[] = $parent_id;
                $current_id = $parent_id;
            } else {
                break;
            }
            $depth++;
        }
        return $parent_ids;
    }

    private function buildCategoryMatchConditions($category_ids)
    {
        $conditions = [];
        foreach ($category_ids as $cat_id) {
            $conditions[] = "a.category_id LIKE '%," . (int)$cat_id . ",%'";
            $conditions[] = "a.category_id LIKE '" . (int)$cat_id . ",%'";
            $conditions[] = "a.category_id LIKE '%," . (int)$cat_id . "'";
            $conditions[] = "a.category_id = '" . (int)$cat_id . "'";
        }
        return implode(' OR ', $conditions);
    }
   public function getProductsByCategoryy($category_id, $filter_data = [])
{
    $language_id = (int)$this->config->get('config_language_id');
    $category_id = (int)$category_id;

    // Always include this category + all its children
    $allCategoryIds = [$category_id];
    $childCategories = $this->getAllChildCategoryIds($category_id);
    if (!empty($childCategories)) {
        $allCategoryIds = array_unique(array_merge($allCategoryIds, $childCategories));
    }
    $category_condition = "p.category_id IN (" . implode(',', array_map('intval', $allCategoryIds)) . ")";

    $sql = "SELECT DISTINCT p.product_id, p.is_new, p.image, pd.name, pd.short_description, pd.full_description, 
            p.sku, pa.url as seo_url, p.screensize_id, p.resolution_id, p.price 
            FROM " . DB_PREFIX . "product p 
            LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = p.product_id 
            LEFT JOIN " . DB_PREFIX . "aliases pa ON pa.slog_id = p.product_id AND pa.slog = 'product/detail'
            WHERE $category_condition AND p.publish = 1 AND pd.lang_id = '$language_id'";

    // Filter by attributes
    if (!empty($filter_data['attribute'])) {
        foreach ($filter_data['attribute'] as $attribute_id => $value_id) {
            if (!empty($value_id)) {
                $sql .= " AND EXISTS (
                    SELECT 1 FROM " . DB_PREFIX . "product_attribute pa 
                    WHERE pa.product_id = p.product_id 
                    AND pa.attribute_id = '" . (int)$attribute_id . "' 
                    AND pa.attribute_value_id = '" . (int)$value_id . "'
                )";
            }
        }
    }

    // Filter by screen size
    if (!empty($filter_data['screen_size'])) {
        $sql .= " AND p.screensize_id = '" . $this->db->escape($filter_data['screen_size']) . "'";
    }

    // Filter by resolution
    if (!empty($filter_data['resolution'])) {
        $sql .= " AND p.resolution_id = '" . $this->db->escape($filter_data['resolution']) . "'";
    }

    // Filter by featured
    if (isset($filter_data['feature']) && $filter_data['feature'] !== '') {
        $sql .= " AND p.featured = '" . (int)$filter_data['feature'] . "'";
    }

    // Filter by price range
    if (!empty($filter_data['price_range'])) {
        $price_range = explode('-', $filter_data['price_range']);
        if (count($price_range) == 2) {
            if ($price_range[1] == '+') {
                $sql .= " AND p.price >= " . (float)$price_range[0];
            } else {
                $sql .= " AND p.price BETWEEN " . (float)$price_range[0] . " AND " . (float)$price_range[1];
            }
        }
    }

    $sql .= " GROUP BY p.product_id";

    // Sorting
    if (isset($filter_data['sort'])) {
        switch ($filter_data['sort']) {
            case 'oldest':
                $sql .= " ORDER BY p.product_id ASC";
                break;
            case 'price_low':
                $sql .= " ORDER BY p.price ASC";
                break;
            case 'price_high':
                $sql .= " ORDER BY p.price DESC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY p.product_id DESC";
                break;
        }
    } else {
        $sql .= " ORDER BY p.product_id DESC";
    }

    // Pagination (limit)
    if (isset($filter_data['start']) && isset($filter_data['limit'])) {
        if ($filter_data['start'] < 0) $filter_data['start'] = 0;
        $sql .= " LIMIT " . (int)$filter_data['start'] . "," . (int)$filter_data['limit'];
    }

    $query = $this->db->query($sql);

    // Remove duplicates
    $products = [];
    $product_ids = [];
    foreach ($query->rows as $product) {
        if (!in_array($product['product_id'], $product_ids)) {
            $product_ids[] = $product['product_id'];
            $products[] = $product;
        }
    }

    return $products;
}


public function getTotalProductsByCategory($category_id, $filter_data = [])
{
    $category_id = (int)$category_id;

    // Always include this category + all its children
    $allCategoryIds = [$category_id];
    $childCategories = $this->getAllChildCategoryIds($category_id);
    if (!empty($childCategories)) {
        $allCategoryIds = array_unique(array_merge($allCategoryIds, $childCategories));
    }
    $category_condition = "p.category_id IN (" . implode(',', array_map('intval', $allCategoryIds)) . ")";

    $sql = "SELECT COUNT(DISTINCT p.product_id) as total 
            FROM " . DB_PREFIX . "product p 
            LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = p.product_id
            WHERE $category_condition AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "' AND p.publish = 1";
    // Filter by attributes
    if (!empty($filter_data['attribute'])) {
        foreach ($filter_data['attribute'] as $attribute_id => $value_id) {
            if (!empty($value_id)) {
                $sql .= " AND EXISTS (
                    SELECT 1 FROM " . DB_PREFIX . "product_attribute pa 
                    WHERE pa.product_id = p.product_id 
                    AND pa.attribute_id = '" . (int)$attribute_id . "' 
                    AND pa.attribute_value_id = '" . (int)$value_id . "'
                )";
            }
        }
    }

    // Filter by screen size
    if (!empty($filter_data['screen_size'])) {
        $sql .= " AND p.screensize_id = '" . $this->db->escape($filter_data['screen_size']) . "'";
    }

    // Filter by resolution
    if (!empty($filter_data['resolution'])) {
        $sql .= " AND p.resolution_id = '" . $this->db->escape($filter_data['resolution']) . "'";
    }

    // Filter by featured
    if (isset($filter_data['feature']) && $filter_data['feature'] !== '') {
        $sql .= " AND p.featured = '" . (int)$filter_data['feature'] . "'";
    }

    // Filter by price range
    if (!empty($filter_data['price_range'])) {
        $price_range = explode('-', $filter_data['price_range']);
        if (count($price_range) == 2) {
            if ($price_range[1] == '+') {
                $sql .= " AND p.price >= " . (float)$price_range[0];
            } else {
                $sql .= " AND p.price BETWEEN " . (float)$price_range[0] . " AND " . (float)$price_range[1];
            }
        }
    }

    $result = $this->db->query($sql);
    return $result->row['total'];
}

}