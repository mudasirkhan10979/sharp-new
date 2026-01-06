<?php
class ModelNewsEvent extends Model
{
    public function getNewsEvents($data = array())
    {
        $sql = "SELECT ne.*, ned.*, a.url as seo_url 
                FROM " . DB_PREFIX . "news_events ne 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevent/detail'
                LEFT JOIN " . DB_PREFIX . "news_events_description ned ON ned.news_event_id = ne.news_event_id 
                LEFT JOIN " . DB_PREFIX . "news_events_categories nec ON nec.ne_category_id = ne.ne_category_id
                WHERE ne.publish = '1' AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
  
        $sql .= " ORDER BY ne.sort_order ASC, ne.date_added DESC";
        if (isset($data['start']) || isset($data['limit'])) {
            $sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalNewsEvents()
    {
        $sql = "SELECT COUNT(*) as total 
                FROM " . DB_PREFIX . "news_events ne  
                LEFT JOIN " . DB_PREFIX . "news_events_description ned ON ned.news_event_id = ne.news_event_id 
                WHERE ne.publish = '1' AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
    public function getNewsEventsByType($type, $data = array())
    {
        $sql = "SELECT ne.*, ned.*, a.url as seo_url 
                FROM " . DB_PREFIX . "news_events ne 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevent/detail'
                LEFT JOIN " . DB_PREFIX . "news_events_description ned ON ned.news_event_id = ne.news_event_id 
                WHERE ne.publish = '1' AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        switch($type) {
            case 'news':
                $sql .= " AND ne.ne_category_id = 1";
                break;
            case 'events':
                $sql .= " AND ne.ne_category_id = 3";
                break;
            case 'blogs':
                $sql .= " AND ne.ne_category_id = 4";
                break;
        }
        $sql .= " ORDER BY ne.sort_order ASC, ne.date_added DESC";
        
        if (isset($data['start']) || isset($data['limit'])) {
            $sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function getTotalNewsEventsByType($type)
    {
        $sql = "SELECT COUNT(*) as total 
                FROM " . DB_PREFIX . "news_events ne  
                LEFT JOIN " . DB_PREFIX . "news_events_description ned ON ned.news_event_id = ne.news_event_id 
                WHERE ne.publish = '1' AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        switch($type) {
            case 'news':
                $sql .= " AND ne.ne_category_id = 1";
                break;
            case 'events':
                $sql .= " AND ne.ne_category_id = 3";
                break;
            case 'blogs':
                $sql .= " AND ne.ne_category_id = 4";
                break;
        }
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
    public function getNewsEvent($news_event_id)
    {
        $sql = "SELECT DISTINCT ne.*, ned.*, a.url as seo_url, nec.name as category_name
                FROM " . DB_PREFIX . "news_events ne 
                INNER JOIN " . DB_PREFIX . "news_events_description ned ON ned.news_event_id = ne.news_event_id
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevent/detail'
                LEFT JOIN " . DB_PREFIX . "news_events_categories nec ON nec.ne_category_id = ne.ne_category_id
                WHERE ne.news_event_id = '" . (int)$news_event_id . "' 
                AND ne.publish = '1' AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        return $query->row;
    }
        public function getNewsEventDetails($news_event_id)
    {
        $sql = "SELECT ne.*, ned.*, a.url as seo_url 
                FROM " . DB_PREFIX . "news_events ne 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevent/detail'
                LEFT JOIN " . DB_PREFIX . "news_events_description ned ON ned.news_event_id = ne.news_event_id 
                LEFT JOIN " . DB_PREFIX . "news_events_categories nec ON nec.ne_category_id = ne.ne_category_id
                WHERE ne.news_event_id = '" . (int)$news_event_id . "' AND ne.publish = '1' AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        $result = $query->row;
        return $result;
    }

    public function getRelatedNewsEvents($news_event_id, $limit = 3)
    {
        $sql = "SELECT ne.*, ned.*, a.url as seo_url 
                FROM " . DB_PREFIX . "news_events ne 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevent/detail'
                LEFT JOIN " . DB_PREFIX . "news_events_description ned ON ned.news_event_id = ne.news_event_id 
                WHERE ne.publish = '1' AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                AND ne.news_event_id != '" . (int)$news_event_id . "'";
        $sql .= " GROUP BY ne.news_event_id ORDER BY ne.date_added DESC LIMIT " . (int)$limit;
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCategories($parent_id = 0)
    {
        $sql = "SELECT nec.*, necd.name 
                FROM " . DB_PREFIX . "news_events_categories nec 
                LEFT JOIN " . DB_PREFIX . "news_events_categories_description necd 
                ON nec.ne_category_id = necd.ne_category_id 
                WHERE nec.parent_id = '" . (int)$parent_id . "' 
                AND nec.publish = '1' 
                AND necd.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                ORDER BY nec.sort_order, necd.name";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCategory($ne_category_id)
    {
        $sql = "SELECT nec.*, necd.name, necd.description 
                FROM " . DB_PREFIX . "news_events_categories nec 
                LEFT JOIN " . DB_PREFIX . "news_events_categories_description necd 
                ON nec.ne_category_id = necd.ne_category_id 
                WHERE nec.ne_category_id = '" . (int)$ne_category_id . "' 
                AND nec.publish = '1' 
                AND necd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getHomepageNewsEvents($limit = 6)
    {
        $sql = "SELECT ne.*, ned.*, a.url as seo_url 
                FROM " . DB_PREFIX . "news_events ne 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevent/detail'
                LEFT JOIN " . DB_PREFIX . "news_events_description ned ON ned.news_event_id = ne.news_event_id 
                WHERE ne.publish = '1' AND ne.show_on_home = '1' 
                AND ned.lang_id = '" . (int)$this->config->get('config_language_id') . "'
                ORDER BY ne.sort_order ASC, ne.date_added DESC 
                LIMIT " . (int)$limit;
        $query = $this->db->query($sql);
        return $query->rows;
    }
}