<?php
class ModelNewsEvents extends Model
{
    public function addNewsEvents($data)
    {
        $uploadedbanner_image = $this->handleUploadedImage($_FILES["banner_image"]);
        $uploadedthumbnail_image = $this->handleUploadedImage($_FILES["thumbnail"]);
        $uploadedmiddle_image = $this->handleUploadedImage($_FILES["middle_image"]);
        $uploadedleft_image = $this->handleUploadedImage($_FILES["left_image"]);
        $uploadedright_image = $this->handleUploadedImage($_FILES["right_image"]);
        $publish = (int)$data['publish'];
        $publish_date = $this->db->escape($data['publish_date']);
        $sortOrder = (int)$data['sort_order'];
        $ne_category_id = (int)$data['ne_category_id'];
		$show_on_home = $this->db->escape($data['show_on_home']);
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "news_events` SET 
        banner_image = '" . $uploadedbanner_image . "', 
        thumbnail = '" . $uploadedthumbnail_image . "', 
        middle_image = '" . $uploadedmiddle_image . "',
        left_image = '" . $uploadedleft_image . "',
        right_image = '" . $uploadedright_image . "',
        publish = '" . $publish . "',
        show_on_home = '" . $show_on_home . "', 
        ne_category_id = '" . $ne_category_id . "',
        publish_date = '" . $publish_date . "',
        date_added = NOW(),
        date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
        $this->db->query($insertQuery);
        $newsEventId = $this->db->getLastId();
        foreach ($data['news_events_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $middle_title = $this->db->escape($languageValue['middle_title']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $description = $this->db->escape($languageValue['description']);
            $second_description = $this->db->escape($languageValue['second_description']);
            $middle_description = $this->db->escape($languageValue['middle_description']);
            $second_middle_description = $this->db->escape($languageValue['second_middle_description']);
            $last_description = $this->db->escape($languageValue['last_description']);
            $meta_title = $this->db->escape($languageValue['meta_title']);
            $meta_keyword = $this->db->escape($languageValue['meta_keyword']);
            $meta_description = $this->db->escape($languageValue['meta_description']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "news_events_description SET 
            news_event_id = '" . (int)$newsEventId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            middle_title = '" . $middle_title . "',
            short_description = '" . $short_description . "',
            meta_title = '" . $meta_title . "',
            meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "',
            middle_description = '" . $middle_description . "',
            second_description = '" . $second_description . "',
            second_middle_description = '" . $second_middle_description . "',
            last_description = '" . $last_description . "',
            description = '" . $description . "'";
            
            $this->db->query($insertDescriptionQuery);
            
            if ($languageId == '1') {
                $seoTitle = $title;
            }
        }
        
        $this->load_model('seourl');
        if ($data['seo_url']) {
            $keyword = $this->model_seourl->seoUrl($data['seo_url']);
        } else {
            $keyword = $this->model_seourl->seoUrl($seoTitle);
            if (isset($keyword)) {
                $checkUrl = $this->model_seourl->chkUUrl($keyword);
                if (!$checkUrl) {
                    $keyword = $keyword;
                } else {
                    $originalTitle = $keyword;
                    $counter = 2;
                    while ($checkUrl) {
                        $keyword = $originalTitle . '-' . $counter;
                        $checkUrl = $this->model_seourl->chkUUrl($keyword);
                        $counter++;
                    }
                }
            }
        }
        
        $this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = 'newsevent/detail', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $newsEventId . "'");
        $this->cache->delete('home.news_events_data');
        return $newsEventId;
    }

    private function handleUploadedImage($file)
    {
        if (empty($file['name'])) {
            return "";
        }
        $targetDirectory = DIR_IMAGE . "newsevents/";
        $targetFile = $targetDirectory . basename($file["name"]);
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($file["name"]);
    }

    public function editNewsEvents($news_event_id, $data)
    {
        if (!empty($_FILES["banner_image"]["name"])) {
            $banner_image = $this->handleUploadedImage($_FILES["banner_image"]);
            $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET
            banner_image = '" . $banner_image . "'
            WHERE news_event_id = '" . (int)$news_event_id . "'";
            $this->db->query($updateQuery);
        }
        
        if (!empty($_FILES["thumbnail"]["name"])) {
            $thumbnail = $this->handleUploadedImage($_FILES["thumbnail"]);
            $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET thumbnail = '" . $thumbnail . "' 
            WHERE news_event_id = '" . (int)$news_event_id . "'";
            $this->db->query($updateQuery);
        }

        if (!empty($_FILES["middle_image"]["name"])) {
            $middle_image = $this->handleUploadedImage($_FILES["middle_image"]);
            $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET middle_image = '" . $middle_image . "' 
            WHERE news_event_id = '" . (int)$news_event_id . "'";
            $this->db->query($updateQuery);
        }

       if (!empty($_FILES["left_image"]["name"])) {
            $left_image = $this->handleUploadedImage($_FILES["left_image"]);
            $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET left_image = '" . $left_image . "' 
            WHERE news_event_id = '" . (int)$news_event_id . "'";
            $this->db->query($updateQuery);
        }

         if (!empty($_FILES["right_image"]["name"])) {
            $right_image = $this->handleUploadedImage($_FILES["right_image"]);
            $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET right_image = '" . $right_image . "' 
            WHERE news_event_id = '" . (int)$news_event_id . "'";
            $this->db->query($updateQuery);
        }
        
        $publish = (int)$data['publish'];
        $sortOrder = (int)$data['sort_order'];
        $publish_date = $this->db->escape($data['publish_date']);
        $ne_category_id = (int)$data['ne_category_id'];
        $show_on_home = $this->db->escape($data['show_on_home']);
        $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET
        publish = '" . $publish . "', 
        show_on_home = '" . $show_on_home . "', 
        ne_category_id = '" . $ne_category_id . "',
        date_modified = NOW(),
        publish_date = '" . $publish_date . "',
        sort_order = '" . $sortOrder . "'
        WHERE news_event_id = '" . (int)$news_event_id . "'";
        
        $this->db->query($updateQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "news_events_description WHERE news_event_id = '" . (int)$news_event_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['news_events_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $middle_title = $this->db->escape($languageValue['middle_title']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $description = $this->db->escape($languageValue['description']);
            $second_description = $this->db->escape($languageValue['second_description']);
            $middle_description = $this->db->escape($languageValue['middle_description']);
            $second_middle_description = $this->db->escape($languageValue['second_middle_description']);
            $last_description = $this->db->escape($languageValue['last_description']);
            $meta_title = $this->db->escape($languageValue['meta_title']);
            $meta_keyword = $this->db->escape($languageValue['meta_keyword']);
            $meta_description = $this->db->escape($languageValue['meta_description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "news_events_description SET 
            news_event_id = '" . (int)$news_event_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            middle_title = '" . $middle_title . "',
            short_description = '" . $short_description . "',
            meta_title = '" . $meta_title . "',
            meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "',
            second_description = '" . $second_description . "',
            middle_description = '" . $middle_description . "',
            second_middle_description = '" . $second_middle_description . "',
            last_description = '" . $last_description . "',
            description = '" . $description . "'";
            
            $this->db->query($insertDescriptionQuery);
            
            if ($languageId == '1') {
                $seoTitle = $title;
            }
        }
        
        $this->load_model('seourl');
        $results = $this->db->query("SELECT * FROM aliases WHERE slog='newsevent/detail' AND slog_id='" . $news_event_id . "'");
        
        if ($data['seo_url']) {
            $keyword = $this->model_seourl->seoUrl($data['seo_url']);
        } else {
            $keyword = $this->model_seourl->seoUrl($seoTitle);
            if (isset($keyword)) {
                $checkUrl = $this->model_seourl->chkUUrl($keyword);
                if (!$checkUrl) {
                    $keyword = $keyword;
                } else {
                    $originalTitle = $keyword;
                    $counter = 2;
                    while ($checkUrl) {
                        $keyword = $originalTitle . '-' . $counter;
                        $checkUrl = $this->model_seourl->chkUUrl($keyword);
                        $counter++;
                    }
                }
            }
        }
        
        if ($results->rows) {
            $this->db->query("UPDATE aliases SET url='" . $keyword . "' WHERE slog='newsevent/detail' AND slog_id='" . $news_event_id . "'");
        } else {
            $this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='newsevent/detail',slog_id='" . $news_event_id . "'");
        }
        
        $this->cache->delete('home.news_events_data');
    }

    public function deleteNewsEvents($news_event_id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "news_events_description` WHERE news_event_id = '" . (int)$news_event_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "news_events` WHERE news_event_id = '" . (int)$news_event_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "aliases WHERE slog='newsevent/detail' AND slog_id = '" . (int)$news_event_id . "'");
        $this->cache->delete('home.news_events_data');
    }

    public function getNewsEvents($news_event_id)
    {
        $sql = "SELECT ne.*,a.url as seo_url,a.slog_id FROM `" . DB_PREFIX . "news_events` ne 
        LEFT JOIN aliases a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevent/detail' WHERE ne.news_event_id = " . $news_event_id;
    //    echo $sql; exit;
        $query = $this->db->query($sql);
        return $query->row;
    }

	// public function getNewsEvents($data)
	// {
	// 	$sql = "SELECT ned.*, ne .* FROM `news_events` ne
	// 			LEFT JOIN news_events_description ned ON ne.news_event_id = ned.news_event_id
	// 			WHERE ned.lang_id = 1 ORDER BY ne.news_event_id";
    //         if (isset($data['order']) && ($data['order'] == 'DESC')) {
    //             $sql .= " DESC";
    //         } else {
    //             $sql .= " DESC";
    //         }
    //         $query = $this->db->query($sql);
    //         return $query->rows;
    //     }


    public function getNewsEventsDescriptions($news_event_id)
    {
        $news_events_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "news_events_description` ned WHERE ned.news_event_id = " . $news_event_id;
        $query = $this->db->query($sql);
        foreach ($query->rows as $result) {
            $news_events_description_data[$result['lang_id']] = array(
                'title'                 => $result['title'],
                'middle_title'          => $result['middle_title'],
                'short_description'     => $result['short_description'],
                'description'           => $result['description'],
                'second_description'    => $result['second_description'],
                'middle_description'    => $result['middle_description'],
                'second_middle_description'  => $result['second_middle_description'],
                'last_description'      => $result['last_description'],
                'meta_keyword'          => $result['meta_keyword'],
                'meta_title'            => $result['meta_title'],
                'meta_description'      => $result['meta_description']
            );
        }
        return $news_events_description_data;
    }

    public function getNewsEventsList($data)
    {
        $sql = "SELECT ned.*, ne.* FROM `news_events` ne
                LEFT JOIN news_events_description ned ON ne.news_event_id = ned.news_event_id
                WHERE ned.lang_id = 1 ORDER BY ne.news_event_id";
                
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        
        $query = $this->db->query($sql);
        return $query->rows;
    }

public function getNewsEventsCategories()
{
    $sql = "SELECT nec.ne_category_id, 
            necd.title
            FROM news_events_categories nec
            LEFT JOIN ne_categories_description necd
            ON nec.ne_category_id = necd.ne_category_id
            WHERE necd.lang_id = 1 AND nec.publish = 1
            ORDER BY nec.sort_order ASC";
         $query = $this->db->query($sql);
         return $query->rows;
}

    public function getNewsEventsCategoriesList()
    {
        $sql = "SELECT ne_categories.ne_category_id, 
                ne_categories_description.title, ne_categories.sort_order 
                FROM ne_categories LEFT JOIN ne_categories_description 
                ON ne_categories.ne_category_id = ne_categories_description.ne_category_id
                WHERE ne_categories_description.lang_id = 1 AND ne_categories.publish = 1
                ORDER BY ne_categories.sort_order ASC";
                
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function updateNewsEventsStatus($news_event_id, $publish)
    {
        $sql = "UPDATE `" . DB_PREFIX . "news_events` SET publish = '" . (int)$publish . "' WHERE news_event_id = '" . (int)$news_event_id . "'";
        $this->db->query($sql);
        return true;
    }

   public function deleteNewsEventsImage($news_event_id, $type = 'main') {
    // Map the correct column name based on the type
    switch ($type) {
        case 'bannerimage':
            $column = 'banner_image';
            break;
        case 'middle':
            $column = 'middle_image';
            break;
        case 'left':
            $column = 'left_image';
            break;
        case 'right':
            $column = 'right_image';
            break;
         case 'main':
            $column = 'thumbnail';
            break;
    }

    // Fetch the existing image filename
    $query = $this->db->query("SELECT `" . $column . "` AS image FROM " . DB_PREFIX . "news_events WHERE news_event_id = '" . (int)$news_event_id . "'");

    if ($query->num_rows) {
        $image = $query->row['image'];

        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'newsevents/' . $image;

            // Delete the file if it exists
            if (file_exists($image_path)) {
                @unlink($image_path);
            }

            // Update DB: clear the column
            $this->db->query("UPDATE " . DB_PREFIX . "news_events SET `" . $column . "` = '' WHERE news_event_id = '" . (int)$news_event_id . "'");
        }

        return ['success' => true];
    } else {
        return ['error' => 'News Event not found.'];
    }
}



}