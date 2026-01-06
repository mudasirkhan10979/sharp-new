<?php


class ControllerAboutbrand extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'about-brand');
    }
    public function index()
    {

        $data = array();
        $this->load_model('home');
        $this->load_model('page');
        $this->load_model('aboutbrand');
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

        $blockbrandaboutus = $this->model_home->getHtmlBlock('block-brand-about-us');
        if (!empty($blockbrandaboutus['content'])) {
            $blockbrandaboutus['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockbrandaboutus['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockbrandaboutus'] = $blockbrandaboutus;

        $blocksustainabilityaboutbrandpage = $this->model_home->getHtmlBlock('block-sustainability-about-brand-page');
        if (!empty($blocksustainabilityaboutbrandpage['content'])) {
            $blocksustainabilityaboutbrandpage['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocksustainabilityaboutbrandpage['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocksustainabilityaboutbrandpage'] = $blocksustainabilityaboutbrandpage;

        $blockcareersbrandpage = $this->model_home->getHtmlBlock('block-careers-brand-page');
        if (!empty($blockcareersbrandpage['content'])) {
            $blockcareersbrandpage['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcareersbrandpage['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockcareersbrandpage'] = $blockcareersbrandpage;

        $blockenvironmentalpolicy = $this->model_home->getHtmlBlock('block-environmental-policy');
        if (!empty($blockenvironmentalpolicy['content'])) {
            $blockenvironmentalpolicy['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockenvironmentalpolicy['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockenvironmentalpolicy'] = $blockenvironmentalpolicy;

        $blockcsrenvironmentalinitiatives = $this->model_home->getHtmlBlock('block-csr-environmental-initiatives');
        if (!empty($blockcsrenvironmentalinitiatives['content'])) {
            $blockcsrenvironmentalinitiatives['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcsrenvironmentalinitiatives['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockcsrenvironmentalinitiatives'] = $blockcsrenvironmentalinitiatives;

        $blockcertificationbrandpage = $this->model_home->getHtmlBlock('block-certification-brand-page');
        if (!empty($blockcertificationbrandpage['content'])) {
            $blockcertificationbrandpage['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcertificationbrandpage['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockcertificationbrandpage'] = $blockcertificationbrandpage;

        $blockeventscalendar = $this->model_home->getHtmlBlock('block-events-calendar');
        if (!empty($blockeventscalendar['content'])) {
            $blockeventscalendar['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockeventscalendar['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockeventscalendar'] = $blockeventscalendar;

        $blockimageaboutus = $this->model_home->getHtmlBlockImages('block-image-about-us');
        $data['blockimageaboutus'] = $blockimageaboutus;

        $blockimagesustainability = $this->model_home->getHtmlBlockImages('block-image-sustainability');
        $data['blockimagesustainability'] = $blockimagesustainability;

        $blockimagecareersaboutbrand = $this->model_home->getHtmlBlockImages('block-image-careers-about-brand');
        $data['blockimagecareersaboutbrand'] = $blockimagecareersaboutbrand;

        $blockimageenviromentalaboutbrand = $this->model_home->getHtmlBlockImages('block-image-enviromental-about-brand');
        $data['blockimageenviromentalaboutbrand'] = $blockimageenviromentalaboutbrand;

        $data['categories'] = $this->model_aboutbrand->getCategories();

        $category_items = array();
        foreach ($data['categories'] as $category) {
            $category_items[$category['ne_category_id']] = $this->model_aboutbrand->getNewsEventsByCategory($category['ne_category_id'], 3);
        }

        $data['category_items'] = $category_items;
        $data['text_no_items'] = $this->language->get('text_no_items');
        $data['text_learn_more'] = $this->language->get('text_learn_more');
        $data['text_apply_now'] = $this->language->get('text_apply_now');
        $data['text_our_news'] = $this->language->get('text_our_news');
        $data['text_play'] = $this->language->get('text_play');
        $data['text_csr_compliance'] = $this->language->get('text_csr_compliance');
        $data['text_no_record'] = $this->language->get('text_no_record');
        $data['text_discover_sustainability'] = $this->language->get('text_discover_sustainability');
        $data['text_read_sustainability_reports'] = $this->language->get('text_read_sustainability_reports');
        $data['text_read_more'] = $this->language->get('text_read_more');
		$NewsDesc = $this->model_home->getHtmlBlock('news-and-events-description');
		if (!empty($NewsDesc['content'])) {
			$NewsDesc['content'] = str_replace('&nbsp;', ' ', html_entity_decode($NewsDesc['content'], ENT_QUOTES, 'UTF-8'));
		}

		$data['news_desc'] = $NewsDesc['content'];
        $this->template = 'sharp/template/about-brand.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'menuinner',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
}
