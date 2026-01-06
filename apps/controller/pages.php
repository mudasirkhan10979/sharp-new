<?php

class ControllerPages extends Controller
{
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->registry->set('pcUrls', 'pages');
	}
	public function index()
	{
	
		$this->load_model('page');
		$data = array();
		$data['getPages'] = array();
		$page_id =  $this->registry->get('slug_data')['slog_id'];
		$getPages = $this->model_page->getPage($page_id);
		if (empty($getPages)) {
			$this->redirect(HTTPS_HOST.'error404');
			exit;
		}
		$data['getPages'] = array();
		$description = str_replace('&nbsp;', ' ', html_entity_decode($getPages['description'], ENT_QUOTES, 'UTF-8'));
		$banner_image = BASE_URL . "uploads/image/pages/" . $getPages['banner_image'];
		$data['getPages'] = array(
			'banner_image' => $banner_image,
			'name' => $getPages['name'],
			'description' => trim($description),
			'short_description' => $getPages['short_description']
		);
		if ($getPages['meta_description']) {
			$cleaned_descrition =  strip_tags(html_entity_decode($getPages['meta_description'], ENT_QUOTES, 'UTF-8'));
			$metaDescription = substr($cleaned_descrition, 0, 160);
			$this->document->setDescription($metaDescription);
		} elseif ($getPages['description']) {
			$cleaned_descrition =  strip_tags(html_entity_decode($getPages['description'], ENT_QUOTES, 'UTF-8'));
			$metaDescription = substr($cleaned_descrition, 0, 160);
			$this->document->setDescription($metaDescription);
		}
		if ($getPages['meta_keyword']) {
			$this->document->setKeywords($getPages['meta_keyword']);
		} elseif ($getPages['title']) {
			$this->document->setKeywords($getPages['title']);
		}
		if ($getPages['meta_title']) {
			$this->document->setTitle($getPages['meta_title']);
		} elseif ($getPages['title']) {
			$this->document->setTitle($getPages['title']);
		}
        $data['heading_title'] = $this->language->get('heading_title');
		$this->template = 'sharp/template/pages.tpl';
		$this->data = $data;
		$this->zones = array(
			'header',
			'footer',
			'menuinner'
		);
		$this->response->setOutput($this->render());
	}
}
