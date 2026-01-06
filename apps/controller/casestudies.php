<?php
class ControllerCasestudies extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'sustainability');
    }

    public function index()
    {

        $data = array();
	    $this->load_model('casestudies');
		$this->load_model('page');
        $this->load_model('home');
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
        
        $limit = 5;
        $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;

        $filter_data = array(
            'start' => ($page_num - 1) * $limit,
            'limit' => $limit
        );
        $data['casestudies'] = array();
        $casestudies = $this->model_casestudies->getCasestudies($filter_data);
        $imgURL = BASE_URL . "uploads/image/case_study/";
        foreach ($casestudies as $casestudy) {
            $thumbnail = isset($casestudy['thumbnail']) && !empty($casestudy['thumbnail']) ? $imgURL . $casestudy['thumbnail'] : BASE_URL . 'uploads/no_image.png';
            $data['casestudies'][] = [
                'id' => $casestudy['case_study_id'],
                'title' => $casestudy['title'],
                'tag' => $casestudy['tag'],
                'short_description' => $casestudy['short_description'],
                'image' => $thumbnail,
                'url' => HTTP_HOST . 'sustainability/' . $casestudy['seo_url']
            ];
        }
        $total = $this->model_casestudies->getTotalCasestudies();
        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = HTTP_HOST . 'casestudies?page={page}';
        $data['pagination'] = $total > $limit ? $pagination->render() : '';
        $blockcsrofcasestudies = $this->model_home->getHtmlBlock('block-csr-of-casestudies');
        if (!empty($blockcsrofcasestudies['content'])) {
            $blockcsrofcasestudies['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcsrofcasestudies['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockcsrofcasestudies'] = $blockcsrofcasestudies;

        $blockcasestudiesreports = $this->model_home->getHtmlBlock('block-casestudies-reports');
        if (!empty($blockcasestudiesreports['content'])) {
            $blockcasestudiesreports['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcasestudiesreports['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockcasestudiesreports'] = $blockcasestudiesreports;

        $blockcasestudiespartners = $this->model_home->getHtmlBlock('block-casestudies-partners');
        if (!empty($blockcasestudiespartners['content'])) {
            $blockcasestudiespartners['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcasestudiespartners['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockcasestudiespartners'] = $blockcasestudiespartners;

        $blockcasestudiesproductlifecycle = $this->model_home->getHtmlBlock('block-casestudies-product-lifecycle');
        if (!empty($blockcasestudiesproductlifecycle['content'])) {
            $blockcasestudiesproductlifecycle['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockcasestudiesproductlifecycle['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockcasestudiesproductlifecycle'] = $blockcasestudiesproductlifecycle;

        $blockfaqsonsupport = $this->model_home->getHtmlBlock('block-faqs-on-support');
        if (!empty($blockfaqsonsupport['content'])) {
            $blockfaqsonsupport['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockfaqsonsupport['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockfaqsonsupport'] = $blockfaqsonsupport;

        $blockimagecsrreports = $this->model_home->getHtmlBlockImages('block-image-csr-reports');
        $data['blockimagecsrreports'] = $blockimagecsrreports;
        
        $blockrightimagecsrreports = $this->model_home->getHtmlBlockImages('block-right-image-csr-reports');
        $data['blockrightimagecsrreports'] = $blockrightimagecsrreports;
                
        $blockimagecasestudiesreports = $this->model_home->getHtmlBlockImages('block-image-casestudies-reports');
        $data['blockimagecasestudiesreports'] = $blockimagecasestudiesreports;

        $faqs = $this->model_casestudies->GetFaqs();
        $data['faqs'] = $faqs;
        foreach ($faqs as &$faq){
            $faq['answer'] = str_replace('&nbsp;', ' ', html_entity_decode($faq['answer'], ENT_QUOTES, 'UTF-8'));
        }
        $data['faqs'] = $faqs;

        $lcareports = $this->model_casestudies->GetLcaReports();
        $data['lcareports'] = $lcareports;
        
        $sustainablePartners = $this->model_casestudies->GetSustainablePartners();
        $data['sustainablePartners'] = $sustainablePartners;

        $productlifecycleanalysis = $this->model_casestudies->GetProductLifeCycleAnalysis();
        $data['productlifecycleanalysis'] = $productlifecycleanalysis;

        $data['text_learn_more'] = $this->language->get('text_learn_more');
        $data['text_esg_csr'] = $this->language->get('text_esg_csr');
        $data['text_lca_reports'] = $this->language->get('text_lca_reports');
        $data['text_about_us'] = $this->language->get('text_about_us');
        $data['text_download'] = $this->language->get('text_download');
        $data['text_explore'] = $this->language->get('text_explore');
        $this->template = 'sharp/template/casestudies.tpl';
        $this->data = $data;
        $this->zones = array('header', 'footer','menuinner');
        $this->response->setOutput($this->render());
    }


        public function Detail()
    {
        $this->load_model('casestudies');
        $this->load_model('home');
        $case_study_id =  $this->registry->get('slug_data')['slog_id'];
        $casestudiesDetails = $this->model_casestudies->getCasestudiesDetails($case_study_id);
        if (!$case_study_id || !$casestudiesDetails['publish']) {
            $this->redirect(HTTPS_HOST.'error404');
            exit;
        }
        $data['casestudiesDetails'] = array();
        if ($casestudiesDetails) {
            $imgURL = BASE_URL . "uploads/image/case_study/";
            $banner = isset($casestudiesDetails['banner_image']) && !empty($casestudiesDetails['banner_image']) ? $imgURL . $casestudiesDetails['banner_image'] : BASE_URL . 'uploads/no_image.png';
            $short_description =  html_entity_decode($casestudiesDetails['short_description'], ENT_QUOTES, 'UTF-8');
            $second_description = str_replace('&nbsp;', ' ', html_entity_decode($casestudiesDetails['second_description'], ENT_QUOTES, 'UTF-8'));
            $first_middle_description = str_replace('&nbsp;', ' ', html_entity_decode($casestudiesDetails['first_middle_description'], ENT_QUOTES, 'UTF-8'));
            $second_middle_description = str_replace('&nbsp;', ' ', html_entity_decode($casestudiesDetails['second_middle_description'], ENT_QUOTES, 'UTF-8'));
            $third_middle_description = str_replace('&nbsp;', ' ', html_entity_decode($casestudiesDetails['third_middle_description'], ENT_QUOTES, 'UTF-8'));
            $data['casestudiesDetails'] = array(
                'middle_image' => $banner,
                'case_study_id' => $casestudiesDetails['case_study_id'],
                'title' => $casestudiesDetails['title'],
                'second_title' => $casestudiesDetails['second_title'],
                'middle_title' => $casestudiesDetails['middle_title'],
                'tag'          => $casestudiesDetails['tag'],
                'publish_date' => date('d M Y', strtotime($casestudiesDetails['publish_date'])),
                'short_description' => $short_description,
                'second_description' => $second_description,
                'first_middle_description' => $first_middle_description,
                'second_middle_description' => $second_middle_description,
                'third_middle_description' => $third_middle_description

            );
        }

         $data['casesliders'] = $this->model_casestudies->getCasestudiesSlider($casestudiesDetails['case_study_id']);

        if ($casestudiesDetails['meta_description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($casestudiesDetails['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        } elseif ($casestudiesDetails['second_description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($casestudiesDetails['second_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        }
        if ($casestudiesDetails['meta_keyword']) {
            $this->document->setKeywords($casestudiesDetails['meta_keyword']);
        } elseif ($casestudiesDetails['title']) {
            $this->document->setKeywords($casestudiesDetails['title']);
        }
        if ($casestudiesDetails['meta_title']) {
            $this->document->setTitle($casestudiesDetails['meta_title']);
        } elseif ($casestudiesDetails['title']) {
            $this->document->setTitle($casestudiesDetails['title']);
        }
        $data['breadcrumbs'] = [
            'text' => $this->language->get('text_back'),
            'href' => HTTP_HOST . "sustainability"
        ];
        $data['relatedcasestudy'] = array();
        $relatedcasestudy = $this->model_casestudies->getRelatedCasestudies($case_study_id);
        foreach ($relatedcasestudy as $casestudy) {
            $image = BASE_URL . "uploads/image/case_study/" . $casestudy['thumbnail'];
            $short_description = strip_tags(html_entity_decode($casestudy['short_description'], ENT_QUOTES, 'UTF-8'));
            $data['relatedcasestudy'][] = array(
                'case_study_id'   => $casestudy['case_study_id'],
                'title'             => $casestudy['title'],
                'tag'           => $casestudy['tag'],
                'short_description' => $short_description,
                'image'             => $image,
                'url' => HTTP_HOST . 'sustainability/' . $casestudy['seo_url']
            );
        }
        $data['text_related_case_studies'] = $this->language->get('text_related_case_studies');
        $data['text_learn_more'] = $this->language->get('text_learn_more');
        $this->template = 'sharp/template/casestudies-detail.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'menuinner',
            'footer'
        );
        $this->response->setOutput($this->render());

    }
}