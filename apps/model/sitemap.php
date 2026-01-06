<?php
class ModelSiteMap extends Model
{
public function getCategoriesRecursive($parent_id = 0) 
{
    $sql = "SELECT c.*, cd.title, cd.short_description, a.url as seo_url
            FROM `" . DB_PREFIX . "category` c
            JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
            LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog = CONCAT('category_id=', c.category_id)
            WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = 1
            AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            ORDER BY c.category_id DESC";
    $query = $this->db->query($sql);
    $categories = [];
    foreach ($query->rows as $row) {
        $children = $this->getCategoriesRecursive($row['category_id']);
        $categories[] = [
            'category_id'       => $row['category_id'],
            'title'             => $row['title'],
            'short_description' => $row['short_description'],
            'image'             => $row['image'],
            'seo_url'           => $row['seo_url'],
            'children'          => $children
        ];
    }
    return $categories;
}

public function GetCmsPages()
{
    $sql = "SELECT  p.id AS page_id, pd.name AS title, a.url AS seo_url, a.slog
            FROM " . DB_PREFIX . "pages p
            LEFT JOIN " . DB_PREFIX . "pages_description pd  ON (p.id = pd.page_id) AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            LEFT JOIN " . DB_PREFIX . "aliases a ON (a.slog_id = p.id)
            WHERE p.publish = 1 AND (a.slog IS NULL OR (a.slog NOT LIKE '%/detail%' AND a.slog NOT LIKE '%product%' 
            AND a.slog NOT LIKE '%detail%' AND a.slog NOT LIKE '%category_id=%'))
            ORDER BY p.sort_order ASC";
    $query = $this->db->query($sql);
    return $query->rows;
 }

}
