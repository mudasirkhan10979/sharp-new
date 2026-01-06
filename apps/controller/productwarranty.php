<?php
class ControllerProductWarranty extends Controller
{
    private $error = array();
    
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'product-warranty-registration');
    }
    public function index()
    {
        $data = array();
		$this->load_model('page');
        $this->load_model('home');
        $page_id = $this->registry->get('slug_data')['slog_id'];
        $page = $this->model_page->getPage($page_id);
        if (empty($page)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $short_description = strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
        if ($page['banner_image']) {
            $image = BASE_URL . "uploads/image/pages/" . $page['banner_image'];
        } else {
            $image = BASE_URL . "uploads/default_banner.jpg";
        }
        $data['banner'] = array(
            'title' => $page['name'],
            'short_description' => $short_description,
            'image' => $image
        );
        if ($page['meta_description']) {
            $cleaned_descrition = strip_tags(html_entity_decode($page['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        } elseif ($page['short_description']) {
            $cleaned_descrition = strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        }
        if ($page['meta_keyword']) {
            $this->document->setKeywords($page['meta_keyword']);
        } elseif ($page['title']) {
            $this->document->setKeywords($page['title']);
        }
        if ($page['meta_title']) {
            $this->document->setTitle($page['meta_title']);
        } elseif ($page['title']) {
            $this->document->setTitle($page['title']);
        }
        $blockproductwarranty = $this->model_home->getHtmlBlock('block-product-warranty');
        if (!empty($blockproductwarranty['content'])) {
            $blockproductwarranty['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockproductwarranty['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockproductwarranty'] = $blockproductwarranty;
        $blockproductwarrantysecond = $this->model_home->getHtmlBlock('block-product-warranty-second');
        if (!empty($blockproductwarrantysecond['content'])) {
            $blockproductwarrantysecond['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockproductwarrantysecond['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockproductwarrantysecond'] = $blockproductwarrantysecond;
        $blockwarrantyregistrationright = $this->model_home->getHtmlBlockImages('block-warranty-registration-right');
        $data['blockwarrantyregistrationright'] = $blockwarrantyregistrationright;
        $blockwarrantyregistrationleft = $this->model_home->getHtmlBlockImages('block-warranty-registration-left');
        $data['blockwarrantyregistrationleft'] = $blockwarrantyregistrationleft;
        $data['text_learn_more'] = $this->language->get('text_learn_more');
        $data['text_download_center'] = $this->language->get('text_download_center');
        $data['text_source_code'] = $this->language->get('text_source_code');
        $data['text_product_warranty'] = $this->language->get('text_product_warranty');
        $data['text_user_manual'] = $this->language->get('text_user_manual');
        $this->template = 'sharp/template/product-warranty-registration.tpl';
        $this->data = $data;
        $this->zones = ['header', 'footer', 'menuinner'];
        $this->response->setOutput($this->render());
    }
}