<?php

class ModelAboutbrand extends Model
{
    public function getNewsEventsByCategory($category_id, $limit = 0) {
        $sql = "
            SELECT ne.*, ned.title, ned.short_description, a.url as seo_url
            FROM " . DB_PREFIX . "news_events ne
            LEFT JOIN " . DB_PREFIX . "news_events_description ned ON (ne.news_event_id = ned.news_event_id)
            LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevent/detail'
            WHERE ne.ne_category_id = '" . (int)$category_id . "' 
            AND ne.publish = '1' 
            AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            ORDER BY ne.sort_order ASC, ne.publish_date DESC";
        if ($limit > 0) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function getCategories() {
        $query = $this->db->query("
            SELECT nec.*, necd.title 
            FROM " . DB_PREFIX . "news_events_categories nec
            LEFT JOIN " . DB_PREFIX . "ne_categories_description necd ON (nec.ne_category_id = necd.ne_category_id)
            WHERE nec.publish = '1' 
            AND necd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            ORDER BY nec.sort_order ASC");
  
        return $query->rows;
    }

    public function getCategory($category_id) {
        $query = $this->db->query("
            SELECT nec.*, necd.title 
            FROM " . DB_PREFIX . "news_events_categories nec
            LEFT JOIN " . DB_PREFIX . "ne_categories_description necd ON (nec.ne_category_id = necd.ne_category_id)
            WHERE nec.ne_category_id = '" . (int)$category_id . "' 
            AND nec.publish = '1' 
            AND necd.lang_id = '" . (int)$this->config->get('config_language_id') . "'");
                      echo $query; exit;
        return $query->row;
    }
}
