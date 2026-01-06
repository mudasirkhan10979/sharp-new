<?php
class ModelCasestudies extends Model
{
    public function getCasestudies()
    {
        $sql = "SELECT cs.*, csd.*, a.url as seo_url 
                FROM " . DB_PREFIX . "case_study cs
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = cs.case_study_id AND a.slog = 'casestudies/detail'
                LEFT JOIN " . DB_PREFIX . "case_study_description csd ON csd.case_study_id = cs.case_study_id 
                WHERE cs.publish = '1' AND csd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
                $sql .= " ORDER BY cs.sort_order ASC, cs.date_added DESC";
                $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalCasestudies()
    {
        $sql = "SELECT COUNT(*) as total 
                FROM " . DB_PREFIX . "case_study cs
                LEFT JOIN " . DB_PREFIX . "case_study_description ned ON csd.case_study_id = cs.case_study_id 
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = cs.case_study_id AND a.slog = 'casestudies/detail'
                WHERE cs.publish = '1' AND csd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    
        public function getCasestudiesDetails($case_study_id)
    {
        $sql = "SELECT cs.*, csd.*, a.url as seo_url 
                FROM " . DB_PREFIX . "case_study cs
                LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = cs.case_study_id AND a.slog = 'casestudies/detail'
                LEFT JOIN " . DB_PREFIX . "case_study_description csd ON csd.case_study_id = cs.case_study_id 
                 WHERE cs.case_study_id = '" . (int)$case_study_id . "' AND cs.publish = '1' AND csd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
                $query = $this->db->query($sql);
                $result = $query->row;
                return $result;
    }

            public function getCasestudiesSlider($case_study_id)
    {
                $sql = "SELECT * FROM `" . DB_PREFIX . "case_study_image` csi
                WHERE csi.case_study_id = '" . (int)$case_study_id . "'
                ORDER BY csi.sort_order ASC";
                $query = $this->db->query($sql);
                $result = $query->rows;
                return $result;
    }


    public function getRelatedCasestudies($news_event_id)
    {

        $sql = "SELECT cs.*, csd.*, a.url as seo_url 
        FROM " . DB_PREFIX . "case_study cs
        LEFT JOIN " . DB_PREFIX . "aliases a ON a.slog_id = cs.case_study_id AND a.slog = 'casestudies/detail'
        LEFT JOIN " . DB_PREFIX . "case_study_description csd ON csd.case_study_id = cs.case_study_id
        WHERE cs.case_study_id != '" . (int)$news_event_id . "' AND cs.publish = '1' AND csd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        return $query->rows;
    }

      public function GetFaqs()
        {
            $sql = "SELECT * FROM `" . DB_PREFIX . "faqs` f
            JOIN `" . DB_PREFIX . "faqs_description` fd ON f.id = fd.faq_id
            WHERE fd.lang_id = '" . $this->config->get('config_language_id') . "' AND f.publish = 1
            ORDER BY f.id DESC LIMIT 3";
            $query = $this->db->query($sql);
            return $query->rows;
        }

            public function GetLcaReports()
        {
            $sql = "SELECT * FROM `" . DB_PREFIX . "lcareport` l
            JOIN `" . DB_PREFIX . "lcareport_description` ld ON l.id = ld.lcareport_id
            WHERE ld.lang_id = '" . $this->config->get('config_language_id') . "' AND l.status = 1
            ORDER BY l.id DESC";
            $query = $this->db->query($sql);
            return $query->rows;
        }

     public function GetSustainablePartners()
        {
            $sql = "SELECT * FROM `" . DB_PREFIX . "sustainablepartner` s
            JOIN `" . DB_PREFIX . "sustainablepartner_description` sd ON s.id = sd.sustainablepartner_id
            WHERE sd.lang_id = '" . $this->config->get('config_language_id') . "' AND s.status = 1
            ORDER BY s.id DESC";
            $query = $this->db->query($sql);
            return $query->rows;
        }

    public function GetProductLifeCycleAnalysis()
        {
            $sql = "SELECT * FROM `" . DB_PREFIX . "productlifecycleanalysis` p
            JOIN `" . DB_PREFIX . "productlifecycleanalysis_description` pd ON p.id = pd.productlife__id
            WHERE pd.lang_id = '" . $this->config->get('config_language_id') . "' AND p.status = 1
            ORDER BY p.id DESC";
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