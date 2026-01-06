<?php

class ControllerSitemap extends Controller
{
	private $error = array();
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->registry->set('pcUrls', 'site-map');
	}
	public function index()
	{
		$data = array();
		$this->load_model('home');
		$this->load_model('page');
        $this->load_model('sitemap');
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
			$image =  BASE_URL . "uploads/default_banner.jpg";
		}
		$data['banner'] = array(
			'title'              => $page['name'],
			'short_description' => $short_description,
			'image'             => $image
		);
		if ($page['meta_description']) {
			$cleaned_descrition =  strip_tags(html_entity_decode($page['meta_description'], ENT_QUOTES, 'UTF-8'));
			$metaDescription = substr($cleaned_descrition, 0, 160);
			$this->document->setDescription($metaDescription);
		} elseif ($page['short_description']) {
			$cleaned_descrition =  strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
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
		$cmspages = $this->model_sitemap->GetCmsPages();
		$data['cmspages'] = $cmspages;
		$data['categories'] = array();
		$data['categories'] = $this->model_sitemap->getCategoriesRecursive('Categories');
		$data['text_page'] = $this->language->get('text_page');
		$data['text_product_categories'] = $this->language->get('text_product_categories');
		$this->template = 'sharp/template/sitemap.tpl';
		$this->data = $data;
		$this->zones = ['header', 'footer', 'menuinner'];
		$this->response->setOutput($this->render());
	}
}
