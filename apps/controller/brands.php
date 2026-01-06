<?php

class ControllerBrands extends Controller
{
	private $error = array();
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'brands');
    }
    public function index()
    {
        $data = array();
        $this->load_model('home');
        $this->load_model('brands');
        $this->load_model('page');
        $page_id =  $this->registry->get('slug_data')['slog_id'];
        $page = $this->model_page->getPage($page_id);
        if (empty($page)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $short_description =  strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
        if ($page['banner_image']) {
            $image = BASE_URL . "uploads/image/pages/" . $page['banner_image'];
        } else {
            $image = BASE_URL . "uploads/default_banner.jpg";
        }
        $data['banner'] = array(
            'title'              => $page['name'],
            'short_description' => $short_description,
            'image'             => $image
        );
        $limit = 5;
        $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
        $filterData = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );
        $data['brands'] = array();
        $this->load_model('brands');
        $brands = $this->model_brands->getbrandslist($filterData);
        $imgURL = BASE_URL . "uploads/image/brands/";
        foreach ($brands as $brand) {
            $icon = isset($brand['icon']) && !empty($brand['icon']) ? $imgURL . $brand['icon'] : BASE_URL . 'uploads/no_image.png';
            $thumbnail = isset($brand['thumbnail']) && !empty($brand['thumbnail']) ? $imgURL . $brand['thumbnail'] : BASE_URL . 'uploads/no_image.png';
            $data['brands'][] = [
                'id' => $brand['id'],
                'name' => $brand['name'],
                'location_name' => $brand['location_name'],
                'icon' => $icon,
                'thumbnail' => $thumbnail,
                'href' => HTTP_HOST . 'brands/' . $brand['seo_url']
            ];
        }
        
        $total = $this->model_brands->getTotalBrands($filterData);
        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = HTTP_HOST . 'brands/listing?page={page}';
        $data['pagination'] = ($total > $limit) ? $pagination->render() : '';
        $data['text_no_record'] =  $this->language->get('text_no_record');
        $data['heading_title'] =  $this->language->get('heading_title');
        $this->template = 'food/template/brands.tpl';
        $this->data = $data;
        $this->zones = array('header', 'footer');
        $this->response->setOutput($this->render());
    }
    public function detail()
   {
    $this->load_model('brands');
    $this->load_model('home');
    $brandsId =  $this->registry->get('slug_data')['slog_id'];
    $BrandsDetails = $this->model_brands->getBrandsDetails($brandsId);
    if (!$BrandsDetails || !$BrandsDetails['status']) {
        $this->redirect(HTTPS_HOST.'error404');
        exit;
    }
    $data['BrandsDetails'] = array();
    if ($BrandsDetails) {
        $imgURL = BASE_URL . "uploads/image/brands/";
        $banner = isset($BrandsDetails['image']) && !empty($BrandsDetails['image']) ? $imgURL . $BrandsDetails['image'] : BASE_URL . 'uploads/no_image.png';
        $thumbnail = isset($BrandsDetails['thumbnail']) && !empty($BrandsDetails['thumbnail']) ? $imgURL . $BrandsDetails['thumbnail'] : BASE_URL . 'uploads/no_image.png';
        $icon = isset($BrandsDetails['icon']) && !empty($BrandsDetails['icon']) ? $imgURL . $BrandsDetails['icon'] : BASE_URL . 'uploads/no_image.png';
        $full_description = str_replace('&nbsp;', ' ', html_entity_decode($BrandsDetails['full_description'], ENT_QUOTES, 'UTF-8'));
        $data['BrandsDetails'] = array(
            'brand_id' => $BrandsDetails['brand_id'],
            'brand_name'   => $BrandsDetails['name'],
            'full_description' => $full_description,
            'opening_time' => $BrandsDetails['opening_time'],
            'closing_time' => $BrandsDetails['closing_time'],
            'facebook_url' => $BrandsDetails['facebook_url'],
            'youtube_url' => $BrandsDetails['youtube_url'],
            'x_url'        => $BrandsDetails['x_url'],
            'instagram_url'=> $BrandsDetails['instagram_url'],
            'phone'        => $BrandsDetails['phone'],
            'email'        => $BrandsDetails['email'],
            'address'      => $BrandsDetails['address'],
            'thumbnail'    => $thumbnail,
            'brand_image'  => $banner,
            'icon'         => $icon,
            'longitude'    => $BrandsDetails['longitude'],
            'latitude'     => $BrandsDetails['latitude'],
            'location_name' => $BrandsDetails['location_name'],

        );
    }
    if ($BrandsDetails['meta_description']) {
        $cleaned_descrition =  strip_tags(html_entity_decode($BrandsDetails['meta_description'], ENT_QUOTES, 'UTF-8'));
        $metaDescription = substr($cleaned_descrition, 0, 160);
        $this->document->setDescription($metaDescription);
    } elseif ($BrandsDetails['description']) {
        $cleaned_descrition =  strip_tags(html_entity_decode($BrandsDetails['description'], ENT_QUOTES, 'UTF-8'));
        $metaDescription = substr($cleaned_descrition, 0, 160);
        $this->document->setDescription($metaDescription);
    }
    if ($BrandsDetails['meta_keyword']) {
        $this->document->setKeywords($BrandsDetails['meta_keyword']);
    } elseif ($BrandsDetails['title']) {
        $this->document->setKeywords($BrandsDetails['title']);
    }
    if ($BrandsDetails['meta_title']) {
        $this->document->setTitle($BrandsDetails['meta_title']);
    } elseif ($BrandsDetails['title']) {
        $this->document->setTitle($BrandsDetails['title']);
    }

    $slider_images = $this->model_brands->getAdditionalbrandimages($BrandsDetails['brand_id']);
    $data['slider_images'] = $slider_images;

    $MenuRepeator = $this->model_brands->getMenuRepeator($BrandsDetails['brand_id']);
    $data['MenuRepeator'] = $MenuRepeator;

    $morebrands = $this->model_brands->getRelatedbrands();
    $data['morebrands'] = $morebrands;

    $brandmenublock = $this->model_home->getHtmlBlock('brand-menu-block');
    if (!empty($brandmenublock['content'])) {
        $brandmenublock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($brandmenublock['content'], ENT_QUOTES, 'UTF-8'));
    }
    $data['brandmenublock'] = $brandmenublock;

    $relatedbrandblock = $this->model_home->getHtmlBlock('related-brand-block');
    if (!empty($relatedbrandblock['content'])) {
        $relatedbrandblock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($relatedbrandblock['content'], ENT_QUOTES, 'UTF-8'));
    }
    $data['relatedbrandblock'] = $relatedbrandblock;
    $data['text_follow_on'] = $this->language->get('text_follow_on');
    $data['text_our_brands'] = $this->language->get('text_our_brands');
    $data['heading_title'] = $this->language->get('heading_title');
    $data['text_opening_hours'] = $this->language->get('text_opening_hours');
    $data['text_contact_details'] = $this->language->get('text_contact_details');
    $data['text_coasterra'] = $this->language->get('text_coasterra');
    $data['text_only_view'] = $this->language->get('text_only_view');
    $this->template = 'food/template/brand_details.tpl';
    $this->data = $data;
    $this->zones = array(
        'header',
        'footer'
    );
    $this->response->setOutput($this->render());
}

}
