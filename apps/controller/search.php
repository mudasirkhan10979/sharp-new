<?php
class ControllerSearch extends Controller
{
    public function index() 
    {
        $this->load_model('search');
        $data = [];
        $this->document->setTitle($this->language->get('heading_title'));
        $keyword = isset($this->request->get['keywords']) ? trim($this->request->get['keywords']) : '';
        $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
        if ($page < 1) $page = 1;
        $limit = 12;
        $start = ($page - 1) * $limit;
        $data['keyword'] = $keyword;
        $data['page'] = $page;
        $results = [];
        $total = 0;
        if (!empty($keyword)) {
            $results = $this->model_search->getSearch($keyword, $start, $limit);
            $total = $this->model_search->getSearchTotal($keyword);
        }
        $products = [];
        foreach ($results as $result) {
            $image = !empty($result['image']) ? BASE_URL . 'uploads/image/product/' . $result['image'] : BASE_URL . 'themes/sharp/assets/imgs/placeholder-product.jpg';
            $seo = !empty($result['seo_url']) ? ltrim($result['seo_url'], '/') : '';
            $url = !empty($seo) ? HTTPS_HOST . $seo : (HTTPS_HOST . 'product/detail&product_id=' . $result['product_id']);
            $products[] = [
                'product_id' => $result['product_id'],
                'name'      => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
                'url'        => $url,
                'image'      => $image
            ];
        }
        $data['products'] = $products;
        $data['pagination'] = [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'pages' => $total > 0 ? ceil($total / $limit) : 0,
        ];
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => BASE_URL
        ];
        $data['breadcrumbs'][] = [
            'text' =>  ($keyword ? ' ' . $keyword : ''),
            'href' => ''
        ];
        $data['text_prev'] = $this->language->get('text_prev');
        $data['text_next'] = $this->language->get('text_next');
        $data['text_no_products_found'] = $this->language->get('text_no_products_found');
        $data['text_try_different_keywords'] = $this->language->get('text_try_different_keywords');
        $data['text_enter_search_term'] = $this->language->get('text_enter_search_term');
		$this->template = 'sharp/template/common/search.tpl';
		$this->data = $data;
		$this->zones = array(
			'header',
			'footer',
            'menuinner'
		);
		$this->response->setOutput($this->render());
	}
    
    public function ajax() 
    {
        $this->load_model('search');
        $json = [];
        if (isset($this->request->get['term']) && !empty(trim($this->request->get['term']))) {
            $term = trim($this->request->get['term']);
            $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
            if ($page < 1) $page = 1;
            $limit = 1000; 
            $start = ($page - 1) * $limit;
            $results = $this->model_search->getSearch($term, $start, $limit);
            $total = $this->model_search->getSearchTotal($term);
            $products = [];
            foreach ($results as $result) {
                $image = !empty($result['image']) ? BASE_URL . 'uploads/image/product/' . $result['image'] : BASE_URL . 'themes/sharp/assets/imgs/placeholder-product.jpg';
                $seo = !empty($result['seo_url']) ? ltrim($result['seo_url'], '/') : '';
                $url = !empty($seo) ? HTTPS_HOST . $seo : (HTTPS_HOST . 'product/detail&product_id=' . $result['product_id']);
                $products[] = [
                    'product_id' => $result['product_id'],
                    'name'      => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
                    'url'        => $url,
                    'image'      => $image
                ];
            }
            $json = [
                'success' => true,
                'products' => $products,
                'total' => $total,
                'pagination' => [
                    'total' => $total,
                    'page' => $page,
                    'limit' => $limit,
                    'pages' => $total > 0 ? ceil($total / $limit) : 0,
                ],
            ];
        } else {
            $json = [
                'success' => false,
                'error' => 'No search term provided'
            ];
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
