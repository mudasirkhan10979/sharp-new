<?php
class ModelHome extends Model
{
    
    public function addSubscription($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "newsletters SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', date_added = NOW()");
        return $this->db->getLastId();
    }

    public function checkEmailExists($email) {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "newsletters WHERE email = '" . $this->db->escape($email) . "'");
        return $query->row['total'] > 0;
    }

  public function getNewsCategories()
    {
        $sql = "SELECT nc.ne_category_id AS category_id, ncd.title
        FROM `" . DB_PREFIX . "news_events_categories` nc
        LEFT JOIN `" . DB_PREFIX . "ne_categories_description` ncd ON nc.ne_category_id = ncd.ne_category_id
        WHERE ncd.lang_id = '" . (int)$this->config->get('config_language_id') . "' AND nc.publish = 1
        ORDER BY nc.sort_order ASC;";
        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function getNews()
    {
        $sql = "SELECT n.news_event_id, n.publish_date, n.date_added AS date, ncd.title, n.thumbnail AS image, n.ne_category_id AS category_id, a.url AS seo_url
        FROM `news_events` n
        LEFT JOIN `news_events_description` ncd ON n.news_event_id = ncd.news_event_id
        LEFT JOIN `aliases` a ON a.slog_id = n.news_event_id AND a.slog = 'newsevent/detail'
        LEFT JOIN `" . DB_PREFIX . "news_events_categories` nc ON n.ne_category_id = nc.ne_category_id
        WHERE ncd.lang_id  = '" . (int)$this->config->get('config_language_id') . "' AND n.publish = 1 AND n.show_on_home = 1
        ORDER BY n.sort_order ASC;";
        $query = $this->db->query($sql);
        return $query->rows;
    }

public function getCategories()
{
    $sql = " SELECT c.*, cd.title, cd.short_description, a.url AS seo_url, pa.url AS parent_seo_url FROM `" . DB_PREFIX . "category` c
        JOIN `" . DB_PREFIX . "category_description` cd ON c.category_id = cd.category_id
        LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog = CONCAT('category_id=', c.category_id)
        LEFT JOIN `" . DB_PREFIX . "aliases` pa ON pa.slog = CONCAT('category_id=', c.parent_id)
        WHERE c.show_on_home = 1 AND c.status = 1 AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
        ORDER BY c.sort_order ASC";
    $query = $this->db->query($sql);
    return $query->rows;
}

public function getProducts()
{
    $sql = "SELECT DISTINCT p.product_id, p.category_id, p.is_new, c.category_id AS category_category_id, p.thumbnail, p.image, p.featured_image, pd.name, p.sku AS model, a.url AS seo_url
            FROM `" . DB_PREFIX . "product` p
            INNER JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id 
            AND pd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            LEFT JOIN `" . DB_PREFIX . "category` c ON p.category_id = c.category_id
            LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = p.product_id AND a.slog = 'product/detail'
            WHERE p.publish = 1 AND c.status = 1 AND p.featured = 1
            ORDER BY p.sort_order ASC LIMIT 6";  
    $query = $this->db->query($sql);
    return $query->rows;
}

    public function getHomeSlider()
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "sliders` s
        JOIN `" . DB_PREFIX . "slider_description` sd ON s.id = sd.slider_id
        WHERE sd.lang_id = '" . $this->config->get('config_language_id') . "' AND s.status = 1
        ORDER BY s.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getHtmlBlock($name)
    {
        $sql = "SELECT bd.content,bd.title FROM `" . DB_PREFIX . "block` b
        JOIN `" . DB_PREFIX . "block_description` bd ON b.id = bd.block_id
        WHERE bd.unique_text = '" . $name . "' AND bd.lang_id = '" . $this->config->get('config_language_id') . "' AND b.publish = 1";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getHtmlBlockImages($name)
    {
        $sql = "SELECT bd.title,b.image FROM `" . DB_PREFIX . "blockimages` b
        JOIN `" . DB_PREFIX . "block_images_description` bd ON b.id = bd.block_id
        WHERE bd.unique_text = '" . $name . "' AND bd.lang_id = '" . $this->config->get('config_language_id') . "' AND b.publish = 1";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getOverHistory()
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "ourhistory` oh
        JOIN `" . DB_PREFIX . "ourhistories_description` ohd ON oh.id = ohd.history_id
        WHERE ohd.lang_id = '" . $this->config->get('config_language_id') . "' AND oh.status = 1
        ORDER BY oh.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getHomeMediaCenter()
    {
        $sql = "SELECT m.*,md.*, a.url as seo_url FROM `" . DB_PREFIX . "media_center` m
        JOIN `" . DB_PREFIX . "media_center_description` md ON m.media_center_id = md.media_center_id
        LEFT JOIN aliases a ON m.media_center_id = a.slog_id AND a.slog = 'mediacenter/detail'                         
        WHERE md.lang_id = '" . $this->config->get('config_language_id') . "' AND m.publish = 1
        ORDER BY m.media_center_id DESC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getAwards()
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "awards` a
        JOIN `" . DB_PREFIX . "award_description` ad ON a.id = ad.award_id
        WHERE ad.lang_id = '" . $this->config->get('config_language_id') . "' AND a.status = 1
        ORDER BY a.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getOverTeam()
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "ourteams` ot
        JOIN `" . DB_PREFIX . "ourteams_description` otd ON ot.id = otd.team_id
        WHERE otd.lang_id = '" . $this->config->get('config_language_id') . "' AND ot.status = 1
        ORDER BY ot.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getlocations()
    {
        $sql = "SELECT l.*, ld.*
                FROM `" . DB_PREFIX . "locations` l
                LEFT JOIN `" . DB_PREFIX . "location_description` ld ON ld.location_id = l.id
                WHERE ld.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND l.publish = 1
                ORDER BY l.id DESC";
                $query = $this->db->query($sql);
                return $query->rows;
    }
    
    public function getLocationById($id) 
    {
        $sql = "SELECT l.*, ld.*
                FROM `" . DB_PREFIX . "locations` l
                LEFT JOIN `" . DB_PREFIX . "location_description` ld ON ld.location_id = l.id
                WHERE ld.lang_id = '" . (int)$this->config->get('config_language_id') . "' AND l.id = '" . (int)$id . "'
                AND l.publish = 1
                ORDER BY l.id DESC";
        $query = $this->db->query($sql);
        return $query->row;
    }
}
