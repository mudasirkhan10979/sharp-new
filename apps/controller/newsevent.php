<?php
class ControllerNewsEvent extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'news-events');
       $this->load_model('newsevent');
        $this->load_model('page');
    }
    
    public function index()
    {
        $page_id = $this->registry->get('slug_data')['slog_id'];
        $page = $this->model_page->getPage($page_id);
        
        if (empty($page)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        
        $data['categories'] = $this->model_newsevent->getCategories();
        $data['popular_news'] = $this->model_newsevent->getHomepageNewsEvents(2);
        
        foreach ($data['popular_news'] as &$news) {
            $news['image'] = BASE_URL . "uploads/image/newsevents/" . $news['thumbnail'];
            $news['short_description'] = strip_tags(html_entity_decode($news['short_description'], ENT_QUOTES, 'UTF-8'));
            $news['publish_date'] = date('d M Y', strtotime($news['publish_date']));
            $news['href'] = HTTPS_HOST . "news-event/" . $news['seo_url'];
        }
        
        $limit = 3;
        $page_num = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
        $filter_data = array(
            'start' => ($page_num - 1) * $limit,
            'limit' => $limit
        );
        $data['all_news'] = $this->model_newsevent->getNewsEvents($filter_data);
        foreach ($data['all_news'] as &$news) {
            $news['image'] = BASE_URL . "uploads/image/newsevents/" . $news['thumbnail'];
            $news['publish_date'] = date('d M Y', strtotime($news['publish_date']));
            $news['href'] = HTTPS_HOST . "news-event/" . $news['seo_url'];
        }
        $total = $this->model_newsevent->getTotalNewsEvents();
        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page_num;
        $pagination->limit = $limit;
        $pagination->url = HTTP_HOST . 'news-events?page={page}';
        $data['pagination'] = $total > $limit ? $pagination->render() : '';
        $short_description = strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
        $image = $page['banner_image'] ? BASE_URL . "uploads/image/pages/" . $page['banner_image'] : BASE_URL . "uploads/default_banner.jpg";
        $data['banner'] = array(
            'title' => $page['name'],
            'short_description' => $short_description,
            'image' => $image
        );
        $data['breadcrumbs'] = array(
            array(
                'text' => $this->language->get('text_home'),
                'href' => HTTP_HOST . 'home'
            ),
            array(
                'text' => $data['banner']['title'],
                'href' => ''
            )
        );
        $data['text_read_more'] = $this->language->get('text_read_more');
        $data['text_no_record'] = $this->language->get('text_no_record');
        $data['text_learn_more'] = $this->language->get('text_learn_more');
        $data['text_popular'] = $this->language->get('text_popular');
        $data['text_all'] = $this->language->get('text_all');
        $data['text_news'] = $this->language->get('text_news');
        $data['text_events'] = $this->language->get('text_events');
        $data['text_blogs'] = $this->language->get('text_blogs');
        $data['text_no_news'] = $this->language->get('text_no_news');
        $data['text_loading'] = $this->language->get('text_loading');
        $this->template = 'sharp/template/news_event.tpl';
        $this->data = $data;
        $this->zones = array('header', 'footer','menuinner');
        $this->response->setOutput($this->render());
    }

        public function Detail()
    {
        $this->load_model('newsevent');
        $this->load_model('home');
        $news_event_id =  $this->registry->get('slug_data')['slog_id'];
        $newseventDetails = $this->model_newsevent->getNewsEventDetails($news_event_id);
        if (!$news_event_id || !$newseventDetails['publish']) {
            $this->redirect(HTTPS_HOST.'error404');
            exit;
        }
        $data['newseventDetails'] = array();
        if ($newseventDetails) {
            $imgURL = BASE_URL . "uploads/image/newsevents/";
            $banner = isset($newseventDetails['banner_image']) && !empty($newseventDetails['banner_image']) ? $imgURL . $newseventDetails['banner_image'] : BASE_URL . 'uploads/no_image.png';
            $middle_image = isset($newseventDetails['middle_image']) && !empty($newseventDetails['middle_image']) ? $imgURL . $newseventDetails['middle_image'] : BASE_URL . 'uploads/no_image.png';
            $left_image = isset($newseventDetails['left_image']) && !empty($newseventDetails['left_image']) ? $imgURL . $newseventDetails['left_image'] : '';
            $right_image = isset($newseventDetails['right_image']) && !empty($newseventDetails['right_image']) ? $imgURL . $newseventDetails['right_image'] :'';
            $short_description =  html_entity_decode($newseventDetails['short_description'], ENT_QUOTES, 'UTF-8');
            $description = str_replace('&nbsp;', ' ', html_entity_decode($newseventDetails['description'], ENT_QUOTES, 'UTF-8'));
            $second_description = str_replace('&nbsp;', ' ', html_entity_decode($newseventDetails['second_description'], ENT_QUOTES, 'UTF-8'));
            $middle_description = str_replace('&nbsp;', ' ', html_entity_decode($newseventDetails['middle_description'], ENT_QUOTES, 'UTF-8'));
            $second_middle_description = str_replace('&nbsp;', ' ', html_entity_decode($newseventDetails['second_middle_description'], ENT_QUOTES, 'UTF-8'));
            $last_description = str_replace('&nbsp;', ' ', html_entity_decode($newseventDetails['last_description'], ENT_QUOTES, 'UTF-8'));
            $data['newseventDetails'] = array(
                'banner' => $banner,
                'middle_image' => $middle_image,
                'left_image' => $left_image,
                'right_image' => $right_image,
                'banner_title' => $newseventDetails['title'],
                'middle_title' => $newseventDetails['middle_title'],
                'publish_date' => date('d M Y', strtotime($newseventDetails['publish_date'])),
                'short_description' => $short_description,
                'second_description' => $second_description,
                'middle_description' => $middle_description,
                'second_middle_description' => $second_middle_description,
                'last_description' => $last_description,
                'description' => $description
            );
        }
        $data['action'] = HTTP_HOST . $this->registry->get('slug_data')['url'];
        $cleaned_description = strip_tags(html_entity_decode($newseventDetails['description'], ENT_QUOTES, 'UTF-8'));
        $trimmed_description = substr($cleaned_description, 0, 250);
        $this->document->addFBMeta('og:image', $banner . "?" . time());
        $this->document->addFBMeta('og:image:width', '1120');
        $this->document->addFBMeta('og:image:height', '768');
        $this->document->addFBMeta('og:url', $data['action']);
        $this->document->addFBMeta('og:description', $trimmed_description);
        $this->document->addFBMeta('og:title', $newseventDetails['title']);
        $this->document->addFBMeta('og:type', 'website');
        $this->document->addFBMeta('og:site_name', 'Sharp');
        $this->document->addTWMeta('twitter:image', $banner . "?" . time());
        $this->document->addTWMeta('twitter:title', $newseventDetails['title']);
        $this->document->addTWMeta('twitter:description', $trimmed_description);
        $this->document->addTWMeta('twitter:card', 'summary_large_image');
        $this->document->addTWMeta('twitter:site', 'Sharp');
        $data['share_links'] = array(
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($data['action']),
            'twitter' => 'https://twitter.com/intent/tweet?text=' . urlencode($trimmed_description) . '&url=' . urlencode($data['action']),
            'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($data['action']),
            'whatsapp' => 'https://api.whatsapp.com/send?text=' . urlencode($newseventDetails['title'] . ' - ' . $data['action']),
            'instagram' => 'https://www.instagram.com/', 
            'youtube' => 'https://www.youtube.com/'
        );
        if ($newseventDetails['meta_description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($newseventDetails['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        } elseif ($newseventDetails['description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($newseventDetails['description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        }
        if ($newseventDetails['meta_keyword']) {
            $this->document->setKeywords($newseventDetails['meta_keyword']);
        } elseif ($newseventDetails['title']) {
            $this->document->setKeywords($newseventDetails['title']);
        }
        if ($newseventDetails['meta_title']) {
            $this->document->setTitle($newseventDetails['meta_title']);
        } elseif ($newseventDetails['title']) {
            $this->document->setTitle($newseventDetails['title']);
        }
        $data['breadcrumbs'] = [
            'text' => $this->language->get('text_back'),
            'href' => HTTP_HOST . "news-events"
        ];
        $data['text_btn_read_more']   =  $this->language->get('text_btn_read_more');
        $data['relatednewevents'] = array();
        $relatednewevents = $this->model_newsevent->getRelatedNewsEvents($news_event_id);
        foreach ($relatednewevents as $event) {
            $image = BASE_URL . "uploads/image/newsevents/" . $event['thumbnail'];
            $short_description = strip_tags(html_entity_decode($event['short_description'], ENT_QUOTES, 'UTF-8'));
            $data['relatednewevents'][] = array(
                'news_event_id'   => $event['news_event_id'],
                'title'             => $event['title'],
                'publish_date'      =>  date('d M Y', strtotime($event['publish_date'])),
                'short_description' => $short_description,
                'image'             => $image,
                'href'              =>  HTTPS_HOST . "news-events/" . $event['seo_url']
            );
        }
        $data['text_share'] = $this->language->get('text_share');
        $data['text_related_news_events'] = $this->language->get('text_related_news_events');
        $data['text_view_all'] = $this->language->get('text_view_all');
        $data['text_learn_more'] = $this->language->get('text_learn_more');
        $data['back_label'] = $this->language->get('back_label');
        $this->template = 'sharp/template/news_details.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'menuinner',
            'footer'
        );
        $this->response->setOutput($this->render());

    }
    
    public function filter()
    {
    
        $json = array();
        if (isset($this->request->get['type'])) {
            $type = $this->request->get['type'];
            $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
            $limit = 3;
            $filter_data = array(
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );
            $news_events = $this->model_newsevent->getNewsEventsByType($type, $filter_data);
            foreach ($news_events as &$news) {
                $news['image'] = BASE_URL . "uploads/image/newsevents/" . $news['thumbnail'];
                $news['publish_date'] = date('d M Y', strtotime($news['publish_date']));
                $news['href'] = HTTPS_HOST . "news-event/" . $news['seo_url'];
            }
            $total = $this->model_newsevent->getTotalNewsEventsByType($type);
            $pagination = new Pagination();
            $pagination->total = $total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = HTTP_HOST . 'news-event/filter?type=' . $type . '&page={page}';
            $json['news_events'] = $news_events;
            $json['pagination'] = $total > $limit ? $pagination->render() : '';
            $json['total'] = $total;
            $json['success'] = true;
        } else {
            $json['error'] = 'Invalid request';
            $json['success'] = false;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}