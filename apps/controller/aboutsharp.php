<?php


class ControllerAboutSharp extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'about-sharp');
    }
    public function index()
    {
        $data = array();
        $this->load_model('home');
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

        $aboutsharpblack1 = $this->model_home->getHtmlBlock('about-sharp-black1');
        if (!empty($aboutsharpblack1['content'])) {
            $aboutsharpblack1['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharpblack1['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharpblack1'] = $aboutsharpblack1;

        $aboutsharploremipsameter = $this->model_home->getHtmlBlock('about-sharp-lorem-ips-ameter');
        if (!empty($aboutsharploremipsameter['content'])) {
            $aboutsharploremipsameter['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharploremipsameter['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharploremipsameter'] = $aboutsharploremipsameter;

        $aboutsharpsmefcorporateprofile = $this->model_home->getHtmlBlock('about-sharp-smef-corporate-profile');
        if (!empty($aboutsharpsmefcorporateprofile['content'])) {
            $aboutsharpsmefcorporateprofile['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharpsmefcorporateprofile['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharpsmefcorporateprofile'] = $aboutsharpsmefcorporateprofile;

 
        $aboutsharpphilosophy = $this->model_home->getHtmlBlock('about-sharp-philosophy');
        if (!empty($aboutsharpphilosophy['content'])) {
            $aboutsharpphilosophy['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharpphilosophy['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharpphilosophy'] = $aboutsharpphilosophy;

        $aboutsharpmessagefrom = $this->model_home->getHtmlBlock('about-sharp-message-from');
        if (!empty($aboutsharpmessagefrom['content'])) {
            $aboutsharpmessagefrom['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharpmessagefrom['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharpmessagefrom'] = $aboutsharpmessagefrom;

        $aboutsharpmanagingdirector2 = $this->model_home->getHtmlBlock('about-sharp-managing-director');
        if (!empty($aboutsharpmanagingdirector2['content'])) {
            $aboutsharpmanagingdirector2['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharpmanagingdirector2['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharpmanagingdirector2'] = $aboutsharpmanagingdirector2;

        $aboutsharpsotasaito = $this->model_home->getHtmlBlock('about-sharp-sota-saito');
        if (!empty($aboutsharpsotasaito['content'])) {
            $aboutsharpsotasaito['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharpsotasaito['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharpsotasaito'] = $aboutsharpsotasaito;

        
        $aboutsharphistory = $this->model_home->getHtmlBlock('about-sharp-history');
        if (!empty($aboutsharphistory['content'])) {
            $aboutsharphistory['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutsharphistory['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutsharphistory'] = $aboutsharphistory;

        $aboutsharpimage1 = $this->model_home->getHtmlBlockImages('about-sharp-image1');
        $data['aboutsharpimage1'] = $aboutsharpimage1;

        $aboutsharpmiddleleftimage = $this->model_home->getHtmlBlockImages('about-sharp-middle-left-image');
        $data['aboutsharpmiddleleftimage'] = $aboutsharpmiddleleftimage;

        $aboutsharpmiddlerightimage = $this->model_home->getHtmlBlockImages('about-sharp-middle-right-image');
        $data['aboutsharpmiddlerightimage'] = $aboutsharpmiddlerightimage;

        $aboutsharpmiddle2ndleftimage = $this->model_home->getHtmlBlockImages('about-sharp-middle-2nd-left-image');
        $data['aboutsharpmiddle2ndleftimage'] = $aboutsharpmiddle2ndleftimage;

        $aboutsharpmiddle2ndrightimage = $this->model_home->getHtmlBlockImages('about-sharp-middle-2nd-right-image');
        $data['aboutsharpmiddle2ndrightimage'] = $aboutsharpmiddle2ndrightimage;

        $aboutsharpmanagingdirector = $this->model_home->getHtmlBlockImages('about-sharp-managing-director');
        $data['aboutsharpmanagingdirector'] = $aboutsharpmanagingdirector;

        $ourhistory = $this->model_home->getOverHistory();
        $data['ourhistory'] = $ourhistory;

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_our_history'] = $this->language->get('text_our_history');
        $this->template = 'sharp/template/about-sharp.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'menuinner',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
}
