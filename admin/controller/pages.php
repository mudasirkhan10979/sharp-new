<?php
class ControllerPages extends Controller
{
	private $error = array();
	public function __construct($registry)
	{
		parent::__construct($registry);

		if (!$this->user->hasPermission('access', 'pages')) {
			$this->response->redirect($this->link('permission', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - CMS Pages');
		$this->load_model('page');
		$this->getList();
	}
	public function add()
	{
		$this->document->setTitle('Admin - CMS Pages');
		$this->load_model('page');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_page->addBanner($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new CMS Page!');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->link('pages', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function edit()
	{
		$this->document->setTitle('Admin - CMS Pages');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('page');
			$this->model_page->editBanner($this->request->get['page_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified CMS Page!');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->link('pages', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('page');
		if ($this->validateDelete() && $this->request->post['page_id']) {
			$this->model_page->deleteBanner($this->request->post['page_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted CMS Page!');
			$this->response->redirect($this->link('pages', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['page_id']) ? 'Add New CMS Page' : 'Edit CMS Page';
		$data['img_feild_text'] = !isset($this->request->get['page_id']) ? "Page Background Image" : "Change Page Background Image";
		$data['img_feild_required'] = !isset($this->request->get['page_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['page_id']) ? "no" : "yes";

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['pagesimg'])) {
			$data['error_pagesimg'] = $this->error['pagesimg'];
		} else {
			$data['error_pagesimg'] = '';
		}
		if (isset($this->error['theme'])) {
			$data['error_theme'] = $this->error['theme'];
		} else {
			$data['error_theme'] = '';
		}
		if (isset($this->error['pagestitle'])) {
			$data['error_pagestitle'] = $this->error['pagestitle'];
		} else {
			$data['error_pagestitle'] = '';
		}
		if (isset($this->error['pagesdesc'])) {
			$data['error_pagesdesc'] = $this->error['pagesdesc'];
		} else {
			$data['error_pagesdesc'] = '';
		}
		if (isset($this->error['seo_url'])) {
			$data['error_seo_url'] = $this->error['seo_url'];
		} else {
			$data['error_seo_url'] = '';
		}
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => "Page",
			'href' => $this->link('pages', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (!isset($this->request->get['page_id'])) {
			$data['action'] = $this->link('pages/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('pages/edit', 'token=' . $this->session->data['token'] . '&page_id=' . $this->request->get['page_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('pages', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['page_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('page');
			$page_info = $this->model_page->getBanner($this->request->get['page_id']);

		}
		$data['single_slider'] = $page_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['pages_description'])) {
			$data['pages_description'] = $this->request->post['pages_description'];
		} elseif (isset($this->request->get['page_id'])) {
			$this->load_model('page');
			$data['pages_description'] = $this->model_page->getPageDescriptions($this->request->get['page_id']);
		} else {
			$data['pages_description'] = array();
		}
		if (isset($this->request->post['page_id'])) {
			$data['page_id'] = $this->request->post['page_id'];
		} elseif (!empty($page_info)) {
			$data['page_id'] = $page_info['id'];
		} else {
			$data['page_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($page_info)) {
			$data['sort_order'] = $page_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (!empty($page_info)) {
			$data['publish'] = $page_info['publish'];
		} else {
			$data['publish'] = true;
		}
		if (isset($this->request->post['banner_image'])) {
			$data['banner_image'] = $this->request->post['banner_image'];
		} elseif (!empty($page_info)) {
			$data['banner_image'] = $page_info['banner_image'];
		} else {
			$data['banner_image'] = '';
		}
		$data['themes'] = array(
			'pages'   => 'CMS Page',
			'generalpages' => 'General Pages',
			'aboutbrand'   => 'About Brand',
			'aboutsharp'   => 'About sharp',
		    'aboutplasmacluster'   => 'About Plasmacluster',
			'intelligentprint'   => 'Intelligent Print',
			'careers' => "Careers",
			'servicecenters' => "Service Centers",
			'casestudies' => "Case Studies",
            'downloadcenter' => "Download Center",
            'faqs' => "FAQs",
			'maincategory' => "Main Category",
			'newsevent' => "News & Events",
			'ourlocation' => "Our Location",
			'privacypolicy' => "Privacy Policy",
			'product' => "Product",
			'productwarranty' => "Product Warranty",
			'servicecenterlist' => "Service Center List",
			'sourcecodedownload' => "Source Code Download",
			'support' => "Support",
			'usermanuals' => "User Manuals",
            'contact' => "Contact Us",
			'sitemap' => "Site Map",
			// 'brands' => "Our Brand",

		);
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($page_info)) {
			$data['seo_url'] = $page_info['seo_url'];
		} else {
			$data['seo_url'] = '';
		}
		if (isset($this->request->post['theme'])) {
			$data['theme'] = $this->request->post['theme'];
		} elseif (!empty($page_info)) {
			$data['theme'] = $page_info['slog'];
		} else {
			$data['theme'] = '';
		}
		$data['deleteImage'] = $this->link('pages/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data = $data;
		$this->template = 'modules/pages/add.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'pages')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
		foreach ($data['pages_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['name'])) < 1)) {
				$this->error['pagestitle'][$language_id] = "Title field is missing";
			}
			if (isset($value['short_description']) && $data['theme'] != 'pages') {
				if ((utf8_strlen(trim($value['short_description'])) < 1)) {
					$this->error['pagesdesc'][$language_id] = "Short description is missing";
				}
			}
		}
		if (!$this->request->get['page_id']) {
			if (isset($_FILES["banner_image"]["name"]) && $data['theme'] != 'pages') {
				if ($_FILES["banner_image"]["name"] == "") {
					$this->error['pagesimg'] = 'Please upload Banner image';
				}
			}
		}

		if (!$this->request->get['page_id']) {
			if ((utf8_strlen(trim($data['theme'])) < 1)) {
				$this->error['theme'] = 'Please select any theme';
			}
		}
		$this->load_model('seourl');
		if ($data['seo_url'] != "") {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		}
		if ($keyword != '') {
			$this->load_model('seourl');
			$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);
			foreach ($seo_urls as $seo_url) {
				if (
					($this->request->get['page_id'] != $seo_url['slog_id']) || !in_array($seo_url['slog'], ['pages', 'generalpages', 'aboutbrand', 'aboutsharp', 'aboutplasmacluster', 'intelligentprint', 'careers', 'casestudies', 'downloadcenter', 'faqs', 'maincategory', 'newsevent', 'ourlocation', 'privacypolicy', 'product', 'productwarranty', 'servicecenterlist', 'sourcecodedownload', 'support', 'usermanuals', 'sitemap', 'contact', 'servicecenters', 'mediacenter', 'brands'])
				) {
					$this->error['seo_url'] = "This URL is already being used";
					break;
				}
			}
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	protected function getList()
	{

		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('pages', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		$data['add'] = $this->link('pages/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('pages/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_page->getSliders($filter_data);
		foreach ($results as $result) {
			$data['pages'][] = array(
				'page_id'     => $result['id'],
				'name'		 	=> $result['name'],
				'short_description'		 	=> $result['short_description'],
				'sort_order'   => $result['sort_order'],
				'publish' 		=> $result['publish'],
				'edit'       	=> $this->link('pages/edit', 'token=' . $this->session->data['token'] . '&page_id=' . $result['id'] . $url, 'SSL'),
				'delete'       	=> $this->link('pages/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_slider'] = $results;
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$data['groupby'] = 1;
		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status'] = $this->link('pages', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('pages', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$data['ajaxcmsstatus'] = $this->link('pages/ajaxcmsstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$bannerTotal = $this->model_page->getTotalBanners();
		$pagination = new Pagination();
		$pagination->total = $bannerTotal;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = HTTP_HOST . '?controller=pages/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl'] = HTTP_HOST . '?controller=pages';
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/pages/list.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxcmsstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('page');
			$id = $this->request->post['id'];
			$status = $this->request->post['status'];
			$this->model_page->updateCmsStatus($id, $status);
			$json['success'] = true;
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'pages')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}


		return !$this->error;
	}

	public function deleteImage()
    {
        $this->load_model('page');
        $page_id = (int)$this->request->get['page_id'];

        if ($page_id) {
            $result = $this->model_page->deletePageImage($page_id);
            if (isset($result['success'])) {
                $json = ['success' => true];
            } else {
                $json = ['error' => $result['error']];
            }
        } else {
            $json = ['error' => 'Invalid page ID.'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }
}
