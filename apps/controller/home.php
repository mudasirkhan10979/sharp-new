<?php

class ControllerHome extends Controller
{
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->registry->set('pcUrls', 'home');
	}
	public function index()
	{
		$slugData =  $this->registry->get('slug_data');
		$this->load_model('home');
		$homeSlider = $this->model_home->getHomeSlider();
        $data['homeSlider'] = $homeSlider;
		$data['categories'] = $this->model_home->getCategories();
		$data['products'] = $this->model_home->getProducts();
		$consumer_electronics_block = $this->model_home->getHtmlBlock('consumer-electronics');
		if (!empty($consumer_electronics_block['content'])) {
			$consumer_electronics_block['content'] = str_replace('&nbsp;', ' ', html_entity_decode($consumer_electronics_block['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['consumer_electronics_block'] = $consumer_electronics_block;
		$block_businesssolutions = $this->model_home->getHtmlBlock('block-business-solutions');
		if (!empty($block_businesssolutions['content'])) {
			$block_businesssolutions['content'] = str_replace('&nbsp;', ' ', html_entity_decode($block_businesssolutions['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['block_businesssolutions'] = $block_businesssolutions;
    	$data['consumer_electronics_image'] = $this->model_home->getHtmlBlockImages('consumer-electronics-image');
		$data['block_image_business_solutions'] = $this->model_home->getHtmlBlockImages('block-image-business-solutions');
		$data['news_categories'] = $this->model_home->getNewsCategories();
		$data['news'] = $this->model_home->getNews();
		$groupedNews = [];
		foreach ($data['news'] as $item) {
			$categoryId = $item['category_id'];
			$groupedNews[$categoryId]['category_id'] = $categoryId;
			$groupedNews[$categoryId]['news'][] = $item;
		}
		
		$data['news'] = array_values($groupedNews);
		$support_service_block = $this->model_home->getHtmlBlock('support-service');
		if (!empty($support_service_block['content'])) {
			$support_service_block['content'] = str_replace('&nbsp;', ' ', html_entity_decode($support_service_block['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['support_service_block'] = $support_service_block;

		$product_support_block = $this->model_home->getHtmlBlock('product-support');
		if (!empty($product_support_block['content'])) {
			$product_support_block['content'] = str_replace('&nbsp;', ' ', html_entity_decode($product_support_block['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['product_support_block'] = $product_support_block;

		$need_help_chat_block = $this->model_home->getHtmlBlock('need-help-chat');
		if (!empty($need_help_chat_block['content'])) {
			$need_help_chat_block['content'] = str_replace('&nbsp;', ' ', html_entity_decode($need_help_chat_block['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['need_help_chat_block'] = $need_help_chat_block;

		$customer_service_center_block = $this->model_home->getHtmlBlock('customer-service-center');
		if (!empty($customer_service_center_block['content'])) {
			$customer_service_center_block['content'] = str_replace('&nbsp;', ' ', html_entity_decode($customer_service_center_block['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['customer_service_center_block'] = $customer_service_center_block;

		$blocks_careers_block = $this->model_home->getHtmlBlock('blocks-careers');
		if (!empty($blocks_careers_block['content'])) {
			$blocks_careers_block['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocks_careers_block['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['blocks_careers_block'] = $blocks_careers_block;
		
		$join_our_team_block = $this->model_home->getHtmlBlock('join-our-team');
		if (!empty($join_our_team_block['content'])) {
			$join_our_team_block['content'] = str_replace('&nbsp;', ' ', html_entity_decode($join_our_team_block['content'], ENT_QUOTES, 'UTF-8'));
		}
		$data['join_our_team_block'] = $join_our_team_block;
        $data['careers_image'] = $this->model_home->getHtmlBlockImages('careers-image');
		$data['joinus_career_images'] = $this->model_home->getHtmlBlockImages('joinus-career-images');
		$data['text_learn_more'] = $this->language->get('text_learn_more');
		$data['text_popular'] = $this->language->get('text_popular');
		$data['text_categories'] = $this->language->get('text_categories');
		$data['text_our_news'] = $this->language->get('text_our_news');
		$data['text_no_record'] = $this->language->get('text_no_record');
		$data['text_featured_products'] = $this->language->get('text_featured_products');
		$data['text_no_featured_products_found'] = $this->language->get('text_no_featured_products_found');
        $data['text_text_new'] = $this->language->get('text_text_new');
		$NewsDesc = $this->model_home->getHtmlBlock('news-and-events-description');
		if (!empty($NewsDesc['content'])) {
			$NewsDesc['content'] = str_replace('&nbsp;', ' ', html_entity_decode($NewsDesc['content'], ENT_QUOTES, 'UTF-8'));
		}

		$data['news_desc'] = $NewsDesc['content'];
		
		$this->template = 'sharp/template/common/home.tpl';
		$this->data = $data;
		$this->zones = array(
			'header',
			'footer',
            'menu'
		);
		$this->response->setOutput($this->render());
	}
 }
