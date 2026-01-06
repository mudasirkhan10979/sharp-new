<?php
class ModelFooter extends Model
{
    public function getFooterMenu($region)
    {
        $sql = "SELECT m.*, md.* FROM menus AS m
                JOIN menus_description AS md ON m.id = md.menu_id
                WHERE md.lang_id ='" . $this->config->get('config_language_id') . "' AND  m.status = '1' AND m.region ='" . $region . "' 
                ORDER BY m.sort_order ASC;";
                $query = $this->db->query($sql);
                return $query->rows;
      }

// public function getCategoriesRecursive($parent_id = 0) 
// {
//     $sql = "SELECT c.*, cd.title, cd.short_description, a.url AS seo_url, cp.level
//             FROM `" . DB_PREFIX . "category` c
//             JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
//             LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog = CONCAT('category_id=', c.category_id)
//             LEFT JOIN `" . DB_PREFIX . "category_path` cp ON cp.category_id = c.category_id
//             AND cp.level = (SELECT MAX(level) 
//             FROM `" . DB_PREFIX . "category_path` WHERE category_id = c.category_id)
//             WHERE c.parent_id = '" . (int)$parent_id . "' 
//             AND c.status = 1
//             AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
//             $query = $this->db->query($sql);
//             $categories = [];
//             foreach ($query->rows as $row) {
//             if ($row['level'] == 2 && isset($row['show_on_header']) && $row['show_on_header'] != 1) {
//                 continue;
//             }
//            $children = $this->getCategoriesRecursive($row['category_id']);
//             // Sort children by sort_order ASC in PHP
//             if (!empty($children)) {
//                 usort($children, function($a, $b) {
//                     return $a['sort_order'] <=> $b['sort_order'];
//                 });
//             }
//         $categories[] = [
//             'category_id'       => $row['category_id'],
//             'title'             => $row['title'],
//             'short_description' => $row['short_description'],
//             'image'             => $row['image'],
//             'seo_url'           => $row['seo_url'],
//             'sort_order'        => $row['sort_order'],
//             'children'          => $children
//         ];
//     }
//     // Sort parent level categories by sort_order ASC as well
//     usort($categories, function($a, $b) {
//         return $a['sort_order'] <=> $b['sort_order'];
//     });

//     return $categories;
// }

public function getCategoriesRecursive($parent_id = 0, $parent_url = '', &$seen_titles = []) 
{
    $sql = "SELECT c.*, cd.title, cd.short_description, a.url AS seo_url, cp.level
            FROM `" . DB_PREFIX . "category` c
            JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
            LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog = CONCAT('category_id=', c.category_id)
            LEFT JOIN `" . DB_PREFIX . "category_path` cp ON cp.category_id = c.category_id
            AND cp.level = (SELECT MAX(level) 
                            FROM `" . DB_PREFIX . "category_path` 
                            WHERE category_id = c.category_id)
            WHERE c.parent_id = '" . (int)$parent_id . "' 
            AND c.status = 1
            AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
            
    $query = $this->db->query($sql);
    $categories = [];

    foreach ($query->rows as $row) {

        // Skip if level 2 and show_on_header != 1
        if ($row['level'] == 2 && isset($row['show_on_header']) && $row['show_on_header'] != 1) {
            continue;
        }

        // Determine the category URL
        $category_url = $row['seo_url'];

        // If title already exists in parent hierarchy, inherit parent's URL
        if (isset($seen_titles[$row['title']])) {
            $category_url = $seen_titles[$row['title']];
        } else {
            // Store this title and URL for children
            $seen_titles[$row['title']] = $category_url;
        }

        // Recursively get children
        $children = $this->getCategoriesRecursive($row['category_id'], $category_url, $seen_titles);

        // Sort children by sort_order
        if (!empty($children)) {
            usort($children, function($a, $b) {
                return $a['sort_order'] <=> $b['sort_order'];
            });
        }

        $categories[] = [
            'category_id'       => $row['category_id'],
            'title'             => $row['title'],
            'short_description' => $row['short_description'],
            'image'             => $row['image'],
            'seo_url'           => $category_url,
            'sort_order'        => $row['sort_order'],
            'children'          => $children
        ];
    }

    // Sort parent level categories
    usort($categories, function($a, $b) {
        return $a['sort_order'] <=> $b['sort_order'];
    });

    return $categories;
}



public function getCategoriesFooterMenu($parent_id = 0) 
{
        $sql = "SELECT c.*, cd.title, cd.short_description, a.url as seo_url
            FROM `" . DB_PREFIX . "category` c
            JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
            LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog = CONCAT('category_id=', c.category_id)
            WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = 1 AND c.show_on_footer = 1 AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            ORDER BY c.sort_order DESC";
        $query = $this->db->query($sql);
        $categories = [];
        foreach ($query->rows as $row) {
        $children = $this->getCategoriesFooterMenu($row['category_id']);
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

 }
