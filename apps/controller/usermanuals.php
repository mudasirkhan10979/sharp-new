<?php
class ControllerUserManuals extends Controller
{
    private $error = array();
    
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'user-manuals');
    }
    public function index()
    {
        $data = array();
	    $this->load_model('usermanuals');
		$this->load_model('page');
        $page_id = $this->registry->get('slug_data')['slog_id'];
        $page = $this->model_page->getPage($page_id);
        if (empty($page)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $short_description = strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
        if ($page['banner_image']) {
            $image = BASE_URL . "uploads/image/pages/" . $page['banner_image'];
        } else {
            $image = BASE_URL . "uploads/default_banner.jpg";
        }
        $data['banner'] = array(
            'title' => $page['name'],
            'short_description' => $short_description,
            'image' => $image
        );
        if ($page['meta_description']) {
            $cleaned_descrition = strip_tags(html_entity_decode($page['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        } elseif ($page['short_description']) {
            $cleaned_descrition = strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
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
        $filter_data = array();
        if (isset($this->request->get['category_id'])) {
            $filter_data['filter_category_id'] = $this->request->get['category_id'];
            $data['selected_category'] = $this->request->get['category_id'];
        }
        if (isset($this->request->get['keyword'])) {
            $filter_data['filter_keyword'] = $this->request->get['keyword'];
            $data['keyword'] = $this->request->get['keyword'];
        }
        $limit = 3;
        $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
        $filter_data['start'] = ($page - 1) * $limit;
        $filter_data['limit'] = $limit;
        $data['usermanuals'] = $this->model_usermanuals->GetUserManuals($filter_data);
        $total = $this->model_usermanuals->getTotalUserManuals($filter_data);
        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $url = '';
        if (isset($this->request->get['category_id'])) {
            $url .= '&category_id=' . $this->request->get['category_id'];
        }
        if (isset($this->request->get['keyword'])) {
            $url .= '&keyword=' . urlencode($this->request->get['keyword']);
        }
        $pagination->url = HTTP_HOST . 'user-manuals?page={page}' . $url;
        $data['pagination'] = ($total > $limit) ? $pagination->render() : '';
        $data['categories'] = $this->model_usermanuals->getCategories();
        $data['text_learn_more'] = $this->language->get('text_learn_more');
        $data['text_download_center'] = $this->language->get('text_download_center');
        $data['text_source_code'] = $this->language->get('text_source_code');
        $data['text_product_warranty'] = $this->language->get('text_product_warranty');
        $data['text_user_manual'] = $this->language->get('text_user_manual');
        $data['text_select_category'] = $this->language->get('text_select_category');
        $data['text_search'] = $this->language->get('text_search');
        $data['text_no_record'] = $this->language->get('text_no_record');
        $data['text_keyword']     = $this->language->get('text_keyword');
        $this->template = 'sharp/template/user-manuals.tpl';
        $this->data = $data;
        $this->zones = ['header', 'footer', 'menuinner'];
        $this->response->setOutput($this->render());
    }
    
    public function search()
    {
        $json = array();
    	$this->load_model('usermanuals');
        $filter_data = array();
        if (isset($this->request->post['category_id'])) {
            $filter_data['filter_category_id'] = $this->request->post['category_id'];
        }
        if (isset($this->request->post['keyword'])) {
            $filter_data['filter_keyword'] = $this->request->post['keyword'];
        }
        $page = isset($this->request->post['page']) ? (int)$this->request->post['page'] : 1;
        $limit = 3;
        $filter_data['start'] = ($page - 1) * $limit;
        $filter_data['limit'] = $limit;
        $manuals = $this->model_usermanuals->GetUserManuals($filter_data);
        $total = $this->model_usermanuals->getTotalUserManuals($filter_data);
        $html = '';
        if (!empty($manuals)) {
            foreach ($manuals as $manual) {
                $html .= '<div class="u-menual-item">';
                $html .= '<div class="u-menual-item-inn">';
                $html .= '<div class="u-menual-item-img">';
                $html .= '<img src="' . BASE_URL . 'themes/sharp/assets/imgs/pdf-icon.svg" alt="">';
                $html .= '</div>';
                $html .= '<h3>' . $manual['title'] . '</h3>';
                $html .= '<p>' . date('Y-m-d', strtotime($manual['publish_date'])) . '</p>';
                $html .= '<div class="um-item-link">';
                $html .= '<a target="_blank" href="' . BASE_URL . 'uploads/image/user_manuals/' . $manual['file'] . '">Download <img src="' . BASE_URL . 'themes/sharp/assets/imgs/arrow.svg" alt=""></a>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
        } else {
			$html .= '<div class="col-12"> <div class="alert alert-warning text-center no-record">No record found</div></div>';
        }
           $pagination_html = '';
        if ($total > $limit) {
            $pagination = new Pagination();
            $pagination->total = $total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $url = '';
            if (isset($this->request->post['category_id'])) {
                $url .= '&category_id=' . $this->request->post['category_id'];
            }
            if (isset($this->request->post['keyword'])) {
                $url .= '&keyword=' . urlencode($this->request->post['keyword']);
            }
            $pagination->url = HTTP_HOST . 'user-manuals?page={page}' . $url;
            $pagination_html = $pagination->render();
        }
        $json['html'] = $html;
        $json['pagination'] = $pagination_html;
        $json['total'] = $total;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}