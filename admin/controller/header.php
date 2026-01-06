<?php
class ControllerHeader extends Controller
{
	public function index()
	{

		if (!$this->user->isLogged() || !isset($this->session->data['token']) || ((string)$this->request->get['token'] != $this->session->data['token'])) {
			if ($this->request->get['controller'] != 'home') {
				$this->response->redirect($this->link('home', '', true));
			}
		}

		$data = array();
		
		
		
		$data['title'] = $this->document->getTitle();
		$data['base'] = '';
		// if ($this->request->server['HTTPS']) {
		// 	$data['base'] = HTTPS_SERVER;
		// } else {
		// 	$data['base'] = HTTP_SERVER;
		// }
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		//$this->load->language('common/header'); 
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_order_status'] = $this->language->get('text_order_status');
		$data['text_complete_status'] = $this->language->get('text_complete_status');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_online'] = $this->language->get('text_online');
		$data['text_approval'] = $this->language->get('text_approval');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_stock'] = $this->language->get('text_stock');
		$data['text_review'] = $this->language->get('text_review');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_front'] = $this->language->get('text_front');
		$data['text_help'] = $this->language->get('text_help');
		$data['text_homepage'] = $this->language->get('text_homepage');
		$data['text_documentation'] = $this->language->get('text_documentation');
		$data['text_support'] = $this->language->get('text_support');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
		$data['text_logout'] = 'Logout';
		// fix this without token to redirect to the logout <scneario class=""></scneario>

		if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$data['logged'] = '';
			$data['logged'] = false;
			//$data['home'] = $this->url->link('common/dashboard', '', 'SSL');
			$data['home'] = 'common/dashboard';
		} else {
			$data['logged'] = true;

			//$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
			//$data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');

			$data['home'] = HTTP_HOST . '?controller=dashboard/&token=' . $this->session->data['token'];
			$data['logout'] = HTTP_HOST . '?controller=logout/&token=' . $this->session->data['token'];

			$data['enquiries'] =  HTTP_HOST . '?controller=dashboard/&token=' . $this->session->data['token'];
			$data['programEnquiries'] =  HTTP_HOST . '?controller=dashboard/&token=' . $this->session->data['token'];


			// Online Stores
			$data['stores'] = array();
			$data['stores'][] = array(
				'name' => $this->config->get('config_name'),
				'href' => HTTP_CATALOG
			);
		}
		//echo '<pre>'; print_r($data); exit;
		$this->id = 'header';
		$this->template = 'common/header.tpl';
		$this->data = $data;
		$this->zones = array(
			'columnleft'
		);

		$this->response->setOutput($this->render());
		//return $this->load->view('common/header.tpl', $data);
	}
}
