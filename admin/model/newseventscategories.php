<?php
class ModelNewsEventsCategories extends Model
{
    public function addNewsEventsCategories($data)
    {
        $status = (int)$data['status'];
        $sortOrder = (int)$data['sort_order'];
        $parent_id = (int)$data['parent_id'];
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "news_events_categories` SET 
        publish = '" . $status . "',
        parent_id = '" . $parent_id . "',
        date_added = NOW(),
        date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";

        $this->db->query($insertQuery);
        $neCategoryId = $this->db->getLastId();

        foreach ($data['ne_categories_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $meta_title = $this->db->escape($languageValue['meta_title']);
            $meta_keyword = $this->db->escape($languageValue['meta_keyword']);
            $meta_description = $this->db->escape($languageValue['meta_description']);

            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "ne_categories_description SET 
            ne_category_id = '" . (int)$neCategoryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            meta_title = '" . $meta_title . "',
            meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "'";

            $this->db->query($insertDescriptionQuery);
        }

        $this->cache->delete('home.newseventscategories');
    }

    public function editNewsEventsCategories($neCategoryId, $data)
    {
        $status = (int)$data['status'];
        $sortOrder = (int)$data['sort_order'];
        $parent_id = (int)$data['parent_id'];

        $updateQuery = "UPDATE `" . DB_PREFIX . "news_events_categories` SET
        publish = '" . $status . "',
        parent_id = '" . $parent_id . "',
        date_modified = NOW(),
        sort_order = '" . $sortOrder . "'
        WHERE ne_category_id = '" . (int)$neCategoryId . "'";
        $this->db->query($updateQuery);
        
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "ne_categories_description WHERE ne_category_id = '" . (int)$neCategoryId . "'";
        $this->db->query($deleteDescriptionQuery);

        foreach ($data['ne_categories_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $meta_title = $this->db->escape($languageValue['meta_title']);
            $meta_keyword = $this->db->escape($languageValue['meta_keyword']);
            $meta_description = $this->db->escape($languageValue['meta_description']);

            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "ne_categories_description SET 
            ne_category_id = '" . (int)$neCategoryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            meta_title = '" . $meta_title . "',
            meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "'";
            $this->db->query($insertDescriptionQuery);
        }

        $this->cache->delete('home.newseventscategories');
    }

    public function deleteNewsEventsCategories($neCategoryId)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "ne_categories_description` WHERE ne_category_id = '" . (int)$neCategoryId . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "news_events_categories` WHERE ne_category_id = '" . (int)$neCategoryId . "'");
        $this->cache->delete('home.newseventscategories');
    }

    public function getNewsEventsCategory(int $neCategoryId): array
    {
         $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_events_categories` `c` 
        LEFT JOIN `" . DB_PREFIX . "ne_categories_description` `cd` 
        ON (`c`.`ne_category_id` = `cd`.`ne_category_id`) 
        WHERE `c`.`ne_category_id` = '" . (int)$neCategoryId . "' 
        AND `cd`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->row;
    }

    public function getNewsEventsCategoryDescriptions($neCategoryId)
    {
        $ne_categories_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "ne_categories_description` ncd WHERE ncd.ne_category_id = " . $neCategoryId;
        $query = $this->db->query($sql);
        foreach ($query->rows as $result) {
            $ne_categories_description_data[$result['lang_id']] = array(
                'title'             => $result['title'],
                'description'       => $result['description'],
                'meta_keyword'      => $result['meta_keyword'],
                'meta_title'        => $result['meta_title'],
                'meta_description'  => $result['meta_description']
            );
        }
        return $ne_categories_description_data;
    }

   public function getNewsEventsCategories($data = array()) {
    $sql = "SELECT 
        `c`.`ne_category_id`,
        `cd`.`title`,
        `c`.`sort_order`,
        `c`.`publish`
    FROM `" . DB_PREFIX . "news_events_categories` `c`
    LEFT JOIN `" . DB_PREFIX . "ne_categories_description` `cd`
        ON (`c`.`ne_category_id` = `cd`.`ne_category_id` AND `cd`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "')
    WHERE 1";

    if (!empty($data['filter_title'])) {
        $sql .= " AND `cd`.`title` LIKE '" . $this->db->escape('%' . $data['filter_title'] . '%') . "'";
    }

    $sql .= " ORDER BY `c`.`ne_category_id` DESC";

    if (isset($data['start']) || isset($data['limit'])) {
        $data['start'] = max(0, $data['start'] ?? 0);
        $data['limit'] = max(1, $data['limit'] ?? 20);
        $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }

    $query = $this->db->query($sql);
    return $query->rows;
}

    // public function getPath(int $ne_category_id): array
    // {
    //     $query = $this->db->query("SELECT `ne_category_id`, `path_id`, `level` FROM `" . DB_PREFIX . "ne_category_path` WHERE `ne_category_id` = '" . (int)$ne_category_id . "'");
    //     return $query->rows;
    // }

    public function updateNewsEventsCategoryStatus($ne_category_id, $publish)
    {
        $sql = "UPDATE `" . DB_PREFIX . "news_events_categories` SET publish = '" . (int)$publish . "' WHERE ne_category_id = '" . (int)$ne_category_id . "'";
    //   echo $sql; exit;
        $this->db->query($sql);
        return true;
    }
}