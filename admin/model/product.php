<?php
class ModelProduct extends Model
{
    public function addProduct($data)
    {
        $uploadedThumbnaileFileName = $this->handleUploadedImage($_FILES["thumbnail"]);
        $uploadedbenefitsimageFileName = $this->handleUploadedImage($_FILES["benefits_image"]);
        $uploadedImageFileName = $this->handleUploadedImage($_FILES["image"]);
        $uploadedFeaturedImageFileName = $this->handleUploadedImage($_FILES["featured_image"]);
        $publish = (int)$data['publish'];
        $is_new = (int)$data['is_new'];
        $featured = (int)$data['featured'];
        $category_id = (int)$data['category_id'];
        // $country_id = (int)$data['country_id'];
        $screensize_id = (int)$data['screensize_id'];
        $resolution_id = (int)$data['resolution_id'];
        $publish_date = $this->db->escape($data['publish_date']);
        $sku = $this->db->escape($data['sku']);
        $product_serial_number = $this->db->escape($data['product_serial_number']);
        $video_url = $this->db->escape($data['video_url']);
        $sortOrder = (int)$data['sort_order'];
        $tags = '';
        if (isset($data['product_tags'])) {
            $tags = is_array($data['product_tags'])
                ? implode(',', $data['product_tags'])
                : $data['product_tags'];
        }
        $insertProductQuery = "INSERT INTO `" . DB_PREFIX . "product` SET 
            sku = '" . $sku . "', 
            product_serial_number = '" . $product_serial_number . "',
            category_id = '" . $category_id . "', 
            screensize_id = '" . $screensize_id . "', 
            resolution_id = '" . $resolution_id . "', 
            thumbnail = '" . $uploadedThumbnaileFileName . "',
            benefits_image = '" . $uploadedbenefitsimageFileName . "',
            image = '" . $uploadedImageFileName . "',
            featured_image = '" . $uploadedFeaturedImageFileName . "',
            publish = '" . $publish . "',
            is_new = '" . $is_new . "',
            featured = '" . $featured . "',
            product_tags = '" . $this->db->escape($tags) . "',
            publish_date = '" . $publish_date . "',
            video_url = '" . $video_url . "',
            date_added = NOW(),
            date_modified = NOW(),
            sort_order = '" . $sortOrder . "'";
        $this->db->query($insertProductQuery);
        $productId = $this->db->getLastId();
        foreach ($data['product_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $name = $this->db->escape($languageValue['name']);
            $full_description = $this->db->escape($languageValue['full_description']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $meta_title = $this->db->escape($languageValue['meta_title']);
            $meta_keyword = $this->db->escape($languageValue['meta_keyword']);
            $meta_description = $this->db->escape($languageValue['meta_description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_description SET 
                product_id = '" . (int)$productId . "',
                lang_id = '" . $languageId . "',
                name = '" . $name . "',
                full_description = '" . $full_description . "',
                short_description = '" . $short_description . "',
                meta_title = '" . $meta_title . "',
                meta_keyword = '" . $meta_keyword . "',
                meta_description = '" . $meta_description . "'";
            $this->db->query($insertDescriptionQuery);
            if ($languageId == 1) {
                $seoTitle = $name;
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
        $this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = 'product/detail', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $productId . "'");


    // Add product attributes
    if (isset($data['product_attribute'])) {
        foreach ($data['product_attribute'] as $product_attribute) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET 
                product_id = '" . (int)$productId . "',
                attribute_id = '" . (int)$product_attribute['attribute_id'] . "',
                attribute_value_id = '" . (int)$product_attribute['attribute_value_id'] . "',
                sort_order = '" . (int)$product_attribute['sort_order'] . "',
                added_date = NOW()");
        }
    }


        // In the insert/update methods, modify the slider images handling:
        if (isset($data['slider_images'])) {
            foreach ($data['slider_images'] as $slider_images) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "slider_images SET product_id = '" . (int)$productId . "', color = '" . $this->db->escape($slider_images['color']) . "', image = '" . $this->db->escape($slider_images['image']) . "', sort_order = '" . (int)$slider_images['sort_order'] . "'");
                // $sli_description_id = $this->db->getLastId();

                // Only insert descriptions if they exist
                // if (isset($slider_images['description'])) {
                //     foreach ($slider_images['description'] as $language_id => $description) {
                //         $this->db->query("INSERT INTO `" . DB_PREFIX . "slider_images_description` SET `sli_description_id` = '" . (int)$sli_description_id . "', `lang_id` = '" . (int)$language_id . "', `product_id` = '" . (int)$productId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
                //     }
                // }
            }
        }


        if (isset($data['product_images'])) {
            foreach ($data['product_images'] as $product_images) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_images SET product_id = '" . (int)$productId . "', image = '" . $this->db->escape($product_images['image']) . "', sort_order = '" . (int)$product_images['sort_order'] . "'");
                $img_description_id = $this->db->getLastId();
                foreach ($product_images['description'] as $language_id => $description) {
                    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_image_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `product_id` = '" . (int)$productId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
                }
            }
        }

        if (isset($data['product_icons'])) {
            foreach ($data['product_icons'] as $product_icons) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_icons SET product_id = '" . (int)$productId . "', image = '" . $this->db->escape($product_icons['image']) . "', sort_order = '" . (int)$product_icons['sort_order'] . "'");
                $icon_description_id = $this->db->getLastId();
                foreach ($product_icons['description'] as $language_id => $description) {
                    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_icons_description` SET `icon_description_id` = '" . (int)$icon_description_id . "', `lang_id` = '" . (int)$language_id . "', `product_id` = '" . (int)$productId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
                }
            }
        }

        $this->cache->delete('home.product.' . (int)$this->config->get('config_language_id'));
    }
    private function handleUploadedImage($file)
    {
        if (empty($file['name'])) {
            return "";
        }
        $targetDirectory = DIR_IMAGE . "product/";
        $originalFileName = pathinfo($file["name"], PATHINFO_FILENAME);
        $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $uniqueName = $originalFileName . '_' . date('YmdHis') . '.' . $fileExtension;
        $targetFile = $targetDirectory . $uniqueName;
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($uniqueName);
    }
    public function editProduct($productId, $data)
    {
        $category_id = (int)$data['category_id'];
        // $country_id = (int)$data['country_id'];
        $screensize_id = (int)$data['screensize_id'];
        $resolution_id = (int)$data['resolution_id'];
        $publish = (int)$data['publish'];
        $is_new = (int)$data['is_new'];
        $featured = (int)$data['featured'];
        $sortOrder = (int)$data['sort_order'];
        $tags = '';
        if (isset($data['product_tags'])) {
            $tags = is_array($data['product_tags'])
                ? implode(',', $data['product_tags'])
                : $data['product_tags'];
        }
        $publish_date = $this->db->escape($data['publish_date']);
        $sku = $this->db->escape($data['sku']);
        $product_serial_number = $this->db->escape($data['product_serial_number']);
        $video_url = $this->db->escape($data['video_url']);
        $thumbnail = $this->db->escape($data['thumbnail']);
        if (!empty($_FILES["thumbnail"]["name"])) {
            $thumbnail = $this->handleUploadedImage($_FILES["thumbnail"]);
        }
        $benefits_image = $this->db->escape($data['benefits_image']);
        if (!empty($_FILES["benefits_image"]["name"])) {
            $benefits_image = $this->handleUploadedImage($_FILES["benefits_image"]);
        }
        $image = $this->db->escape($data['image']);
        if (!empty($_FILES["image"]["name"])) {
            $image = $this->handleUploadedImage($_FILES["image"]);
        }
        
        $featured_image = $this->db->escape($data['featured_image']);
        if (!empty($_FILES["featured_image"]["name"])) {
            $featured_image = $this->handleUploadedImage($_FILES["featured_image"]);
        }


        $updateProductQuery = "UPDATE `" . DB_PREFIX . "product` SET
            publish = '" . $publish . "',
            is_new = '" . $is_new . "',
            featured = '" . $featured . "',
            thumbnail = '" . $thumbnail . "', 
            benefits_image = '" . $benefits_image . "', 
            image = '" . $image . "', 
            featured_image = '" . $featured_image . "',
            category_id = '" . $category_id . "',
            screensize_id = '" . $screensize_id . "', 
            resolution_id = '" . $resolution_id . "', 
            sku = '" . $sku . "', 
            product_serial_number = '" . $product_serial_number . "',
            product_tags = '" . $this->db->escape($tags) . "',
            publish_date = '" . $publish_date . "',
            date_modified = NOW(),
            sort_order = '" . $sortOrder . "',
            video_url = '" . $video_url . "'
            WHERE product_id = '" . (int)$productId . "'";
        $this->db->query($updateProductQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$productId . "'";
        $this->db->query($deleteDescriptionQuery);
        foreach ($data['product_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $name = $this->db->escape($languageValue['name']);
            $full_description = $this->db->escape($languageValue['full_description']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $meta_title = $this->db->escape($languageValue['meta_title']);
            $meta_keyword = $this->db->escape($languageValue['meta_keyword']);
            $meta_description = $this->db->escape($languageValue['meta_description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_description SET 
                product_id = '" . (int)$productId . "',
                lang_id = '" . $languageId . "',
                name = '" . $name . "',
                full_description = '" . $full_description . "',
                short_description = '" . $short_description . "',
                meta_title = '" . $meta_title . "',
                meta_keyword = '" . $meta_keyword . "',
                meta_description = '" . $meta_description . "'";
            $this->db->query($insertDescriptionQuery);
            if ($languageId == 1) {
                $seoTitle = $name;
            }
        }

        $this->load_model('seourl');
        $results = $this->db->query("SELECT * FROM aliases WHERE slog='product/detail' AND slog_id='" . $productId . "'");
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
            $this->db->query("UPDATE aliases SET url='" . $keyword . "' WHERE slog='product/detail' AND slog_id='" . $productId . "'");
        } else {
            $this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='product/detail',slog_id='" . $productId . "'");
        }


          // Update product attributes
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$productId . "'");
            
            if (isset($data['product_attribute'])) {
                foreach ($data['product_attribute'] as $product_attribute) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET 
                        product_id = '" . (int)$productId . "',
                        attribute_id = '" . (int)$product_attribute['attribute_id'] . "',
                        attribute_value_id = '" . (int)$product_attribute['attribute_value_id'] . "',
                        sort_order = '" . (int)$product_attribute['sort_order'] . "',
                        added_date = NOW()");
                }
            }

        // echo "DELETE FROM " . DB_PREFIX . "slider_images WHERE product_id = '" . (int)$productId . "'"; exit;
        $this->db->query("DELETE FROM " . DB_PREFIX . "slider_images WHERE product_id = '" . (int)$productId . "'");
        // $this->db->query("DELETE FROM " . DB_PREFIX . "slider_images_description WHERE product_id = '" . (int)$productId . "'");
        if (isset($data['slider_images'])) {
            foreach ($data['slider_images'] as $slider_images) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "slider_images SET product_id = '" . (int)$productId . "', color = '" . $this->db->escape($slider_images['color']) . "', image = '" . $this->db->escape($slider_images['image']) . "', sort_order = '" . (int)$slider_images['sort_order'] . "'");
                // $sli_description_id = $this->db->getLastId();

                // Only insert descriptions if they exist
                // if (isset($slider_images['description'])) {
                //     foreach ($slider_images['description'] as $language_id => $description) {
                //         $this->db->query("INSERT INTO `" . DB_PREFIX . "slider_images_description` SET `sli_description_id` = '" . (int)$sli_description_id . "', `lang_id` = '" . (int)$language_id . "', `product_id` = '" . (int)$productId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
                //     }
                // }
            }
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "product_images WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_image_description WHERE product_id = '" . (int)$productId . "'");

        if (isset($data['product_images'])) {
            foreach ($data['product_images'] as $product_images) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_images SET product_id = '" . (int)$productId . "', image = '" . $this->db->escape($product_images['image']) . "', sort_order = '" . (int)$product_images['sort_order'] . "'");
                $img_description_id = $this->db->getLastId();
                foreach ($product_images['description'] as $language_id => $description) {
                    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_image_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `product_id` = '" . (int)$productId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
                }
            }
        }


        $this->db->query("DELETE FROM " . DB_PREFIX . "product_icons WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_icons_description WHERE product_id = '" . (int)$productId . "'");

        if (isset($data['product_icons'])) {
            foreach ($data['product_icons'] as $product_icons) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_icons SET product_id = '" . (int)$productId . "', image = '" . $this->db->escape($product_icons['image']) . "', sort_order = '" . (int)$product_icons['sort_order'] . "'");
                $icon_description_id = $this->db->getLastId();
                foreach ($product_icons['description'] as $language_id => $description) {
                    $this->db->query("INSERT INTO `" . DB_PREFIX . "product_icons_description` SET `icon_description_id` = '" . (int)$icon_description_id . "', `lang_id` = '" . (int)$language_id . "', `product_id` = '" . (int)$productId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
                }
            }
        }

        $this->cache->delete('home.product.' . (int)$this->config->get('config_language_id'));
    }

    public function deleteProduct($productId)
    {
        // Delete product attributes
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "product_description` WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_images WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "slider_images WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_icons WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "product` WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_image_description WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "slider_images_description WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_icons_description WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "aliases` WHERE slog = 'product/detail' AND slog_id = '" . (int)$productId . "'");
        $this->cache->delete('home.product.' . (int)$this->config->get('config_language_id'));
    }

    // public function getProduct($productId)
    // {
    //     $sql = "SELECT p.* FROM `" . DB_PREFIX . "product` p WHERE p.product_id = " . $productId;
    //     $query = $this->db->query($sql);
    //     return $query->row;
    // }

    public function getProduct($productId)
    {
        $sql = "SELECT p.* ,a.url as seo_url FROM `" . DB_PREFIX . "product` p
		LEFT JOIN aliases a ON a.slog_id = p.product_id AND a.slog='product/detail' 
		WHERE p.product_id = " . $productId;
        $query = $this->db->query($sql);
        return $query->row;
    }



    public function getProductImages($productId)
    {
        $productImageData = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_images WHERE product_id = '" . (int)$productId . "' ORDER BY sort_order ASC");

        foreach ($query->rows as $imageDescription) {
            $description_data = [];
            $description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_image_description` WHERE `img_description_id` = '" . (int)$imageDescription['id'] . "'");

            foreach ($description_query->rows as $description) {
                $description_data[$description['lang_id']] = ['title' => $description['title'], 'content' => $description['content']];
            }

            $productImageData[] = [
                'description' => $description_data,
                'image' => $imageDescription['image'],
                'sort_order' => $imageDescription['sort_order']
            ];
        }
        return $productImageData;
    }


    public function getProductSliders($productId)
    {
        $productImageData3 = [];

        $query = $this->db->query("SELECT * 
            FROM " . DB_PREFIX . "slider_images 
            WHERE product_id = '" . (int)$productId . "' 
            ORDER BY sort_order ASC");

        foreach ($query->rows as $imageRow) {
            $productImageData3[] = [
                'color'      => $imageRow['color'],
                'image'      => $imageRow['image'],
                'sort_order' => $imageRow['sort_order'],
                'title'      => $imageRow['title'],      // assuming title exists in slider_images
                'content'    => $imageRow['content']     // assuming content exists in slider_images
            ];
        }

        return $productImageData3;
    }

    public function getProductIcons($productId)
    {
        $productImageData2 = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_icons WHERE product_id = '" . (int)$productId . "' ORDER BY sort_order ASC");

        foreach ($query->rows as $imageDescription2) {
            $description_data2 = [];
            $description_query2 = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_icons_description` WHERE `icon_description_id` = '" . (int)$imageDescription2['id'] . "'");

            foreach ($description_query2->rows as $description2) {
                $description_data2[$description2['lang_id']] = ['title' => $description2['title'], 'content' => $description2['content']];
            }

            $productImageData2[] = [
                'description' => $description_data2,
                'image' => $imageDescription2['image'],
                'sort_order' => $imageDescription2['sort_order']
            ];
        }
        return $productImageData2;
    }

    public function getProductDescription($productId)
    {
        $product_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "product_description` WHERE product_description.product_id = " . $productId;
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_description_data[$result['lang_id']] = array(
                'name' => $result['name'],
                'short_description' => $result['short_description'],
                'full_description' => $result['full_description'],
                'meta_keyword' => $result['meta_keyword'],
                'meta_title' => $result['meta_title'],
                'meta_description' => $result['meta_description']
            );
        }
        return $product_description_data;
    }

    public function getProducts($data)
    {
        $sql = "SELECT bd.*, b.*, sd.title as category_name 
            FROM `product` b
            LEFT JOIN product_description bd ON b.product_id = bd.product_id
            LEFT JOIN category_description sd ON sd.category_id = b.category_id
            WHERE bd.lang_id = 1 AND sd.lang_id = 1";

        if (isset($data['filter_title']) && ($data['filter_title'] != '')) {
            $sql .= " AND bd.name LIKE '%" . $data['filter_title'] . "%'";
        }

        $sql .= " ORDER BY b.product_id";
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }

        if (isset($data['limit'])) {
            $sql .= " LIMIT " . $data['limit'];
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCategories()
    {
        $sql = "SELECT category.category_id, category_description.title 
                FROM `category` 
                LEFT JOIN category_description ON category.category_id = category_description.category_id
                WHERE category_description.lang_id = 1 AND status = 1
                ORDER BY category.sort_order ASC";

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getScreenSize()
    {
        $sql = "SELECT screensize.id, screensize_description.title 
                FROM `screensize` 
                LEFT JOIN screensize_description ON screensize.id = screensize_description.screensize_id
                WHERE screensize_description.lang_id = 1 AND status = 1
                ORDER BY screensize.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getResolution()
    {
        $sql = "SELECT resolution.id, resolution_description.title 
                FROM `resolution` 
                LEFT JOIN resolution_description ON resolution.id = resolution_description.resolution_id
                WHERE resolution_description.lang_id = 1 AND status = 1
                ORDER BY resolution.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    // public function getCountries()
    // {
    //     $sql = "SELECT c.country_id, c.name 
    //             FROM `country` c
    //             WHERE c.status = 1
    //             ORDER BY c.country_id ASC";     
    //     $query = $this->db->query($sql);
    //     return $query->rows;
    // }

    public function updateProductStatus($product_id, $status)
    {
        $sql = "UPDATE `" . DB_PREFIX . "product` SET publish = '" . (int)$status . "' WHERE product_id = '" . (int)$product_id . "'";
        $this->db->query($sql);
        return true;
    }

        public function updateProductFeatured($product_id, $featured)
    {
        $sql = "UPDATE `" . DB_PREFIX . "product` SET featured = '" . (int)$featured . "' WHERE product_id = '" . (int)$product_id . "'";
        $this->db->query($sql);
        return true;
    }


public function deleteProductImage($product_id, $type = 'main') {
    // Map the correct column name based on the type
    switch ($type) {
        case 'thumbnail':
            $column = 'thumbnail';
            break;
        case 'benefits':
            $column = 'benefits_image';
            break;
        case 'featured_image':  
            $column = 'featured_image';
            break;  
        default:
            $column = 'image';
    }
    // Get the current image filename
    $query = $this->db->query("SELECT `" . $column . "` AS image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
    if ($query->num_rows) {
        $image = $query->row['image'];
        if (!empty($image)) {
            $image_path = DIR_IMAGE . 'product/' . $image;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            $this->db->query("UPDATE " . DB_PREFIX . "product SET `" . $column . "` = '' WHERE product_id = '" . (int)$product_id . "'");
        }
        return ['success' => true];
    } else {
        return ['error' => 'Product not found'];
    }
}


public function getProductAttributes($product_id) {
    $product_attribute_data = array();
    
    $query = $this->db->query("SELECT pa.*, ad.title as attribute_name, avd.title as attribute_value_name, av.attribute_key 
                               FROM " . DB_PREFIX . "product_attribute pa 
                               LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (pa.attribute_id = ad.attribute_id AND ad.lang_id = '" . (int)$this->config->get('config_language_id') . "')
                               LEFT JOIN " . DB_PREFIX . "attribute_value av ON (pa.attribute_value_id = av.id)
                               LEFT JOIN " . DB_PREFIX . "attribute_value_description avd ON (av.id = avd.attribute_value_id AND avd.lang_id = '" . (int)$this->config->get('config_language_id') . "')
                               WHERE pa.product_id = '" . (int)$product_id . "'
                               ORDER BY pa.sort_order ASC");
    
                            foreach ($query->rows as $result) {
                                $product_attribute_data[] = array(
                                    'attribute_id' => $result['attribute_id'],
                                    'attribute_value_id' => $result['attribute_value_id'],
                                    'attribute_name' => $result['attribute_name'],
                                    'attribute_value_name' => $result['attribute_value_name'],
                                    'attribute_key' => $result['attribute_key'],
                                    'sort_order' => $result['sort_order']
                                );
                            }
    
    return $product_attribute_data;
}

public function getProductAttributesFront($product_id) {
    $attribute_data = array();
    
    $query = $this->db->query("SELECT a.id as attribute_id, ad.title as attribute_name, 
                               GROUP_CONCAT(CONCAT(avd.title, '||', av.attribute_key) SEPARATOR ';;') as values_data
                               FROM " . DB_PREFIX . "product_attribute pa
                               LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.id)
                               LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.id = ad.attribute_id AND ad.lang_id = '" . (int)$this->config->get('config_language_id') . "')
                               LEFT JOIN " . DB_PREFIX . "attribute_value av ON (pa.attribute_value_id = av.id)
                               LEFT JOIN " . DB_PREFIX . "attribute_value_description avd ON (av.id = avd.attribute_value_id AND avd.lang_id = '" . (int)$this->config->get('config_language_id') . "')
                               WHERE pa.product_id = '" . (int)$product_id . "' AND a.status = '1' AND av.status = '1'
                               GROUP BY a.id
                               ORDER BY pa.sort_order ASC");
    
                                foreach ($query->rows as $result) {
                                    $values = array();
                                    $values_data = explode(';;', $result['values_data']);
                                    
                                    foreach ($values_data as $value_data) {
                                        $value_parts = explode('||', $value_data);
                                        if (count($value_parts) == 2) {
                                            $values[] = array(
                                                'title' => $value_parts[0],
                                                'key' => $value_parts[1]
                                            );
                                        }
                                    }
                                    
                                    $attribute_data[] = array(
                                        'attribute_id' => $result['attribute_id'],
                                        'attribute_name' => $result['attribute_name'],
                                        'values' => $values
                                    );
                                }
                                
                                return $attribute_data;
                            }


               }
