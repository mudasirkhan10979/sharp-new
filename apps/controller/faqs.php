<?php

class ControllerFaqs extends Controller
{
	private $error = array();
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->registry->set('pcUrls', 'contact-us');
	}
	public function index()
	{
		$data = array();
		$this->load_model('faqs');
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
		// $limit = 1;
		// $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
		// $filterData = array(
		// 	'start' => ($page - 1) * $limit,
		// 	'limit' => $limit
		// );
		$filterData = array(
			'start' => 0,
			'limit' => 0
		);
		$faqs = $this->model_faqs->GetFaqs($filterData);
		$data['faqs'] = $faqs;
		foreach ($faqs as &$faq) {
			$faq['answer'] = str_replace('&nbsp;', ' ', html_entity_decode($faq['answer'], ENT_QUOTES, 'UTF-8'));
		}
		$data['faqs'] = $faqs;
		// $total = $this->model_faqs->getTotalFaqs();
		// $pagination = new Pagination();
		// $pagination->total = $total;
		// $pagination->page = $page;
		// $pagination->limit = $limit;
		// $pagination->url = HTTP_HOST . 'faqs?page={page}';
		// $data['pagination'] = ($total > $limit) ? $pagination->render() : '';
		$data['text_no_record'] = $this->language->get('text_no_record');
		$this->template = 'sharp/template/faqs.tpl';
		$this->data = $data;
		$this->zones = ['header', 'footer', 'menuinner'];
		$this->response->setOutput($this->render());
	}
}
