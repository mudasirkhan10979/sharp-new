<?php


class ControllerAboutPlasmacluster extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'about-plasmacluster');
    }
    public function index()
    {
        $data = array();
        $this->load_model('home');
        $this->load_model('page');
        $this->load_model('aboutplasmacluster');
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

        $blockaboutulamcorperplasmacluster = $this->model_home->getHtmlBlock('block-about-ulamcorper-plasmacluster');
        if (!empty($blockaboutulamcorperplasmacluster['content'])) {
            $blockaboutulamcorperplasmacluster['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockaboutulamcorperplasmacluster['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockaboutulamcorperplasmacluster'] = $blockaboutulamcorperplasmacluster;

        $blockbenefitsaboutplasmacluster = $this->model_home->getHtmlBlock('block-benefits-about-plasmacluster');
        if (!empty($blockbenefitsaboutplasmacluster['content'])) {
            $blockbenefitsaboutplasmacluster['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockbenefitsaboutplasmacluster['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockbenefitsaboutplasmacluster'] = $blockbenefitsaboutplasmacluster;


        $blocklorem1plasmacluster = $this->model_home->getHtmlBlock('block-lorem1-plasmacluster');
        if (!empty($blocklorem1plasmacluster['content'])) {
            $blocklorem1plasmacluster['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocklorem1plasmacluster['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocklorem1plasmacluster'] = $blocklorem1plasmacluster;

        $blocklorem2plasmacluster = $this->model_home->getHtmlBlock('block-lorem2-plasmacluster');
        if (!empty($blocklorem2plasmacluster['content'])) {
            $blocklorem2plasmacluster['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocklorem2plasmacluster['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocklorem2plasmacluster'] = $blocklorem2plasmacluster;

        $blocklorem3plasmacluster = $this->model_home->getHtmlBlock('block-lorem3-plasmacluster');
        if (!empty($blocklorem3plasmacluster['content'])) {
            $blocklorem3plasmacluster['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocklorem3plasmacluster['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocklorem3plasmacluster'] = $blocklorem3plasmacluster;

        $blocklorem4plasmacluster = $this->model_home->getHtmlBlock('block-lorem4-plasmacluster');
        if (!empty($blocklorem4plasmacluster['content'])) {
            $blocklorem4plasmacluster['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocklorem4plasmacluster['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocklorem4plasmacluster'] = $blocklorem4plasmacluster;
        
        $plasmaclusterairblock = $this->model_home->getHtmlBlock('plasmacluster-air-block');
        if (!empty($plasmaclusterairblock['content'])) {
            $plasmaclusterairblock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($plasmaclusterairblock['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['plasmaclusterairblock'] = $plasmaclusterairblock;

        $blockplasmaclusterpage = $this->model_home->getHtmlBlockImages('block-plasmacluster-page');
        $data['blockplasmaclusterpage'] = $blockplasmaclusterpage;

        $blockimagebenefits = $this->model_home->getHtmlBlockImages('block-image-benefits');
        $data['blockimagebenefits'] = $blockimagebenefits;

        $aboutsharpimage1 = $this->model_home->getHtmlBlockImages('about-sharp-image1');
        $data['aboutsharpimage1'] = $aboutsharpimage1;

        $aboutsharpblack1 = $this->model_home->getHtmlBlock('block-plasmacluster');
        if (!empty($aboutsharpblack1['content'])) {
            $aboutsharpblack1['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharpblack1['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharpblack1'] = $aboutsharpblack1;

        $plasmacluster = $this->model_aboutplasmacluster->getPlasmacluster();
        $data['plasmacluster'] = $plasmacluster;
        $data['air_purifiers_products'] = $this->model_aboutplasmacluster->getAirPurifiersProducts();
        $data['text_our_products'] = $this->language->get('text_our_products');
        $data['text_play'] = $this->language->get('text_play');
        $data['text_lpsracid'] = $this->language->get('text_lpsracid');
        $data['text_overview'] = $this->language->get('text_overview');
        $data['text_certificates'] = $this->language->get('text_certificates');
        $data['description_certificates'] = $this->language->get('description_certificates');
        $data['text_text_new'] = $this->language->get('text_text_new');
        $this->template = 'sharp/template/about-plasmacluster.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'menuinner',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
}
