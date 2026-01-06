<?php

class ControllerSupport extends Controller
{
	private $error = array();
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->registry->set('pcUrls', 'support');
	}
	public function index()
	{
		$data = array();
		$this->load_model('home');
		$this->load_model('page');
		$this->load_model('faqs');
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
        $blockdownloadcenter = $this->model_home->getHtmlBlock('block-download-center');
        if (!empty($blockdownloadcenter['content'])) {
            $blockdownloadcenter['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockdownloadcenter['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockdownloadcenter'] = $blockdownloadcenter;

        $blocksseddoeiusmod = $this->model_home->getHtmlBlock('blocks-sed-do-eiusmod');
        if (!empty($blocksseddoeiusmod['content'])) {
            $blocksseddoeiusmod['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocksseddoeiusmod['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocksseddoeiusmod'] = $blocksseddoeiusmod;

        $blockwearehereto = $this->model_home->getHtmlBlock('block-we-are-here-to');
        if (!empty($blockwearehereto['content'])) {
            $blockwearehereto['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockwearehereto['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockwearehereto'] = $blockwearehereto;
		
        $blockfaqsonsupport = $this->model_home->getHtmlBlock('block-faqs-on-support');
        if (!empty($blockfaqsonsupport['content'])) {
            $blockfaqsonsupport['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockfaqsonsupport['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockfaqsonsupport'] = $blockfaqsonsupport;

		$blocksourcecodedownload = $this->model_home->getHtmlBlock('block-source-code-download');
        if (!empty($blocksourcecodedownload['content'])) {
            $blocksourcecodedownload['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocksourcecodedownload['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocksourcecodedownload'] = $blocksourcecodedownload;

		$blockproductwarranty = $this->model_home->getHtmlBlock('block-product-warranty');
        if (!empty($blockproductwarranty['content'])) {
            $blockproductwarranty['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockproductwarranty['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockproductwarranty'] = $blockproductwarranty;

		$blockusermanuals = $this->model_home->getHtmlBlock('block-user-manuals');
        if (!empty($blockusermanuals['content'])) {
            $blockusermanuals['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockusermanuals['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockusermanuals'] = $blockusermanuals;


		$blockimagedownloadcenter = $this->model_home->getHtmlBlockImages('block-image-download-center');
        $data['blockimagedownloadcenter'] = $blockimagedownloadcenter;
		
		$blockimagewearehere = $this->model_home->getHtmlBlockImages('block-image-we-are-here');
        $data['blockimagewearehere'] = $blockimagewearehere;
		$faqs = $this->model_faqs->GetFaqs();
		$data['faqs'] = $faqs;
 		$data['telephone'] = $this->config->get('config_telephone');
		$data['config_email'] = $this->config->get('config_email');
		$data['config_address'] = $this->config->get('config_address' . $this->config->get('config_language_id'));
		$data['text_location'] = $this->language->get('text_location');
		$data['phone_lab'] = $this->language->get('phone_lab');
		$data['email_lab'] = $this->language->get('email_lab');
		$data['text_explore'] = $this->language->get('text_explore');
		$data['heading_title_contact'] = $this->language->get('heading_title_contact');
		$this->template = 'sharp/template/support.tpl';
		$this->data = $data;
		$this->zones = ['header', 'footer', 'menuinner'];
		$this->response->setOutput($this->render());
	}
}