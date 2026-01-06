<?php
class ControllerMainCategory extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $registry->set('pcUrls', 'maincategory');
    }
     public function index()
{    
    $this->load_model('maincategory');
    $slugData = $this->registry->get('slug_data');
    $limit = 3; 
    $offset = 0; 
    $current_parent_id = 0;
    $category_id = 0;
    if (!empty($slugData['slog']) && strpos($slugData['slog'], 'category_id=') === 0) {
        $category_id = (int)$slugData['slog_id'];
        $current_parent_id = $category_id;
        $category_data = $this->model_maincategory->getCategoryPage($category_id);
        if (empty($category_data)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $short_description = strip_tags(html_entity_decode($category_data['short_description'], ENT_QUOTES, 'UTF-8'));
        $image = !empty($category_data['image']) ? BASE_URL . "uploads/image/categories/" . $category_data['image'] : BASE_URL . "uploads/default_banner.jpg";
        $data['banner'] = [
            'title'             => $category_data['title'],
            'short_description' => $short_description,
            'image'             => $image
        ];
        $categories = $this->model_maincategory->getCategoriesByParent($category_id);
        foreach ($categories as &$category) {
            if (!empty($category['parent_seo_url'])) {
                $category['full_url'] = HTTPS_HOST . $category['parent_seo_url'] . '/' . $category['seo_url'];
            } else {
                $category['full_url'] = HTTPS_HOST . $category['seo_url'];
            }
        }
        $data['categories'] = $categories;
        $data['featured_products'] = $this->model_maincategory->getProductsByCategory($category_id, $offset, $limit);
        $total_featured = $this->model_maincategory->getTotalFeaturedProductsByCategory($category_id);
        } else {
        $data['banner'] = [
            'title'             => "Categories",
            'short_description' => "",
            'image'             => BASE_URL . "uploads/default_banner.jpg"
        ];
        $categories = $this->model_maincategory->getCategoriesByParent(0);
        foreach ($categories as &$category) {
            $category['full_url'] = HTTPS_HOST . $category['seo_url'];
        }
        $data['categories'] = $categories;
        $data['featured_products'] = $this->model_maincategory->getAllFeaturedProducts($offset, $limit);
        $total_featured = $this->model_maincategory->getTotalAllFeaturedProducts();
    }
    // echo '<pre>';print_r($data['categories']);echo '</pre>';exit;
    $data['current_category_id'] = $category_id;
    $data['current_parent_id'] = $current_parent_id;
    $data['load_more_limit'] = $limit;
    $data['load_more_offset'] = $limit;
    $data['load_more_total'] = $total_featured;
    $data['load_more_has_more'] = (count($data['featured_products']) >= $limit && $data['load_more_offset'] < $total_featured);
    $data['load_more_category_id'] = $category_id;
    $data['text_categories']        = $this->language->get('text_categories');
    $data['text_featured_products'] = $this->language->get('text_featured_products');
    $data['text_learn_more']        = $this->language->get('text_learn_more');
    $data['text_load_more']         = $this->language->get('text_load_more') ?: 'Load More';
    $data['text_loading']           = $this->language->get('text_loading') ?: 'Loading...';
    $data['text_back']           = $this->language->get('text_back');
    $data['heading_filter']           = $this->language->get('heading_filter');
    $data['text_results']              = $this->language->get('text_results');
    $data['text_sort_by']              = $this->language->get('text_sort_by');
    $data['text_new']              = $this->language->get('text_new');
    $data['text_old']              = $this->language->get('text_old');
    $data['text_categories']              = $this->language->get('text_categories');
    $data['text_no_record']              = $this->language->get('text_no_record');
    $data['text_no_featured_products']   = $this->language->get('text_no_featured_products');
    $data['text_no_more_products']  = $this->language->get('text_no_more_products') ?: 'No more products to load';
    $this->template = 'sharp/template/main-category.tpl';
    $this->data     = $data;
    $this->zones    = ['header','footer','menuinner'];
    $this->response->setOutput($this->render());
}
    public function Detail()
    {
        $slugData = $this->registry->get('slug_data');
        $data['slugData'] = $slugData;
        if (empty($slugData['slog']) || strpos($slugData['slog'], 'category_id=') !== 0) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $this->load_model('maincategory');
        $category_id = (int)$slugData['slog_id'];
        $categories_top = $this->model_maincategory->getCategoriesByChild($category_id);
        $data['categories_top'] = $categories_top;
        $parentCategory = $this->model_maincategory->getParentCategory($category_id);
        $data['parentCategory'] = $parentCategory;
        $category = $this->model_maincategory->getCategoryPagee($category_id);
        if (empty($category)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $short_description = strip_tags(html_entity_decode($category['short_description'], ENT_QUOTES, 'UTF-8'));
        $image = !empty($category['image']) ? BASE_URL . "uploads/image/categories/" . $category['image'] : BASE_URL . "uploads/default_banner.jpg";
        $data['banner'] = [
            'title'             => $category['title'],
            'short_description' => $short_description,
            'image'             => $image
        ];
        $data['filters'] = $this->model_maincategory->getFilters($category_id);
        $filter_data = array();
        if (isset($this->request->get['attribute']) && is_array($this->request->get['attribute'])) {
            foreach ($this->request->get['attribute'] as $attribute_id => $value_id) {
                if (!empty($value_id)) {
                    $filter_data['attribute'][(int)$attribute_id] = (int)$value_id;
                }
            }
        }
        if (isset($this->request->get['screen_size']) && $this->request->get['screen_size'] != '') {
            $filter_data['screen_size'] = $this->request->get['screen_size'];
        }
        if (isset($this->request->get['feature']) && $this->request->get['feature'] != '') {
            $filter_data['feature'] = $this->request->get['feature'];
        }
        if (isset($this->request->get['resolution']) && $this->request->get['resolution'] != '') {
            $filter_data['resolution'] = $this->request->get['resolution'];
        }
        if (isset($this->request->get['price_range']) && $this->request->get['price_range'] != '') {
            $filter_data['price_range'] = $this->request->get['price_range'];
        }
        if (isset($this->request->get['sort']) && $this->request->get['sort'] != '') {
            $filter_data['sort'] = $this->request->get['sort'];
        } else {
            $filter_data['sort'] = 'newest';
        }
        $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
        $limit = 12; 
        $filter_data['start'] = ($page - 1) * $limit;
        $filter_data['limit'] = $limit;
        $products = $this->model_maincategory->getProductsByCategoryy($category_id, $filter_data);
        $data['products'] = $products;
        $total = $this->model_maincategory->getTotalProductsByCategory($category_id, $filter_data);
        $data['product_total'] = $total;
        $data['filter_data'] = $filter_data;
        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $url_params = [];
        if (isset($this->request->get['screen_size']) && $this->request->get['screen_size'] != '') {
            $url_params['screen_size'] = $this->request->get['screen_size'];
        }
        if (isset($this->request->get['feature']) && $this->request->get['feature'] != '') {
            $url_params['feature'] = $this->request->get['feature'];
        }
        if (isset($this->request->get['resolution']) && $this->request->get['resolution'] != '') {
            $url_params['resolution'] = $this->request->get['resolution'];
        }
        if (isset($this->request->get['price_range']) && $this->request->get['price_range'] != '') {
            $url_params['price_range'] = $this->request->get['price_range'];
        }
        if (isset($this->request->get['sort']) && $this->request->get['sort'] != '') {
            $url_params['sort'] = $this->request->get['sort'];
        }
        foreach ($_GET as $key => $value) {
            if (strpos($key, 'attribute[') === 0) {
                $url_params[$key] = $value;
            }
        }
        $pagination_url = HTTP_HOST . $slugData['url'];
        if (!empty($url_params)) {
            $pagination_url .= '?' . http_build_query($url_params) . '&page={page}';
        } else {
            $pagination_url .= '?page={page}';
        }
        $pagination->url = $pagination_url;
        $data['pagination'] = $pagination->render();
        $data['text_back']        = $this->language->get('text_back');
        $data['heading_filter']   = $this->language->get('heading_filter');
        $data['text_results']     = $this->language->get('text_results');
        $data['text_sort_by']     = $this->language->get('text_sort_by');
        $data['text_new']         = $this->language->get('text_new');
        $data['text_old']         = $this->language->get('text_old');
         $data['text_learn_more']        = $this->language->get('text_learn_more');
        $data['text_no_more_products']  = $this->language->get('text_no_more_products') ?: 'No more products to load';
        $data['text_text_new'] = $this->language->get('text_text_new');
        $this->template = 'sharp/template/product-listing.tpl';
        $this->data  = $data;
        $this->zones = ['header','footer','menuinner'];
        $this->response->setOutput($this->render());
    }
   public function getCategoryProducts()
{
    $json = [];
    if (isset($this->request->get['category_id'])) {
        $category_id = (int)$this->request->get['category_id'];
        $offset = isset($this->request->get['offset']) ? (int)$this->request->get['offset'] : 0;
        $limit = 3;
        $this->load_model('maincategory');
        
        if ($category_id > 0) {
            $products = $this->model_maincategory->getProductsByCategory($category_id, $offset, $limit);
            $json['total'] = $this->model_maincategory->getTotalFeaturedProductsByCategory($category_id);
        } else {
            $products = $this->model_maincategory->getAllFeaturedProducts($offset, $limit);
            $json['total'] = $this->model_maincategory->getTotalAllFeaturedProducts();
        }
        $unique_products = [];
        $seen_product_ids = [];
        foreach ($products as $product) {
            if (!in_array($product['product_id'], $seen_product_ids)) {
                $seen_product_ids[] = $product['product_id'];
                $unique_products[] = $product;
            }
        }
        $json['products'] = [];
        foreach ($unique_products as $product) {
            $encodedImage = '';
            if (!empty($product['image'])) {
                $encodedImage = rawurlencode($product['image']);
                $imageUrl = BASE_URL . 'uploads/image/product/' . $encodedImage;
            } else {
                $imageUrl = BASE_URL . 'uploads/default_banner.jpg';
            }
            $json['products'][] = [
                'product_id' => $product['product_id'],
                'name'       => $product['name'],
                'is_new'       => $product['is_new'],
                'model'      => $product['model'],
                'image'      => $imageUrl,
                'url'        => $product['url']
            ];
        }
        $json['offset'] = $offset + count($json['products']);
        $json['has_more'] = ($json['offset'] < $json['total']);
        $json['success'] = true;
        $json['loaded_count'] = count($json['products']);
    } else {
        $json['success'] = false;
        $json['error'] = 'Category ID is required';
    }
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }
}