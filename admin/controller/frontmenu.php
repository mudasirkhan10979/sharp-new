<?php
class ControllerFrontMenu extends Controller
{
	private $error = array();

	public function index()
	{
		
		$this->document->setTitle("Admin - Front Menu");
		$this->load_model('frontmenu');
		$this->getList();
	}

	public function add()
	{

		$data = $this->language->getAll();
		$this->document->setTitle("Admin - Front Menu");
		$this->load_model('frontmenu');
		$url = "";
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_frontmenu->addMenu($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new Front Menu!');
			$this->response->redirect($this->link('frontmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function edit()
	{

		$this->document->setTitle("Admin - Front Menu");
		$url = "";
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('frontmenu');
			$this->model_frontmenu->editMenu($this->request->get['menu_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Front Menu!');
			$this->response->redirect($this->link('frontmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete()
	{
		$this->load_model('frontmenu');
		if($this->validateDelete() && $this->request->post['menu_id']) {
			$this->model_frontmenu->deleteMenu($this->request->post['menu_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Front Menu!');
			$this->response->redirect($this->link('frontmenu', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}

	private function validateForm()
	{

		if (!$this->user->hasPermission('modify', 'frontmenu')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
		foreach ($data['menus_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['menutitle'][$language_id] = "Name field is missing";
			}
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = 'Please fill all fields';
		}
		if ((utf8_strlen(trim($data['url'])) < 1)) {
			$this->error['menuurl'] = "Menu url is missing";
		}
		if ((utf8_strlen(trim($data['region'])) < 1)) {
			$this->error['region'] = "Region is missing";
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

	private function getList()
	{
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Menu Listing',
			'href' => $this->link('frontmenu', 'token=' . $this->session->data['token'] . $url, 'SSL')
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

		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
			$data['button_edit_icon'] = 'fa fa-eye';
		} else {
			$data['viewer'] = false;
			$data['button_edit_icon'] = 'fa fa-pencil';
		}

		$data['add'] = $this->link('frontmenu/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('frontmenu/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$results = $this->model_frontmenu->getMenus($filter_data);
		foreach ($results as $result) {
			$data['menus'][] = array(
				'menu_id'       => $result['id'],
				'title'		 	=> $result['title'],
				'sort_order'	=> $result['sort_order'],
				'region'    	=> ucfirst($result['region']),
				'status' 		=> $result['status'],
				'edit'       	=> $this->link('frontmenu/edit', 'token=' . $this->session->data['token'] . '&menu_id=' . $result['id'] . $url, 'SSL'),
				'delete'       	=> $this->link('frontmenu/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_block'] = $results;
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
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
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
		$data['ajaxfrontmenustatus'] = $this->link('frontmenu/ajaxfrontmenustatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$menuTotal = $this->model_frontmenu->getTotalMenus();
		$pagination = new Pagination();
		$pagination->total = $menuTotal;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = HTTP_HOST . '?controller=frontmenu/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($menuTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($menuTotal - $this->config->get('config_limit_admin'))) ? $menuTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $menuTotal, ceil($menuTotal / $this->config->get('config_limit_admin')));
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/frontmenu/list.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	private function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['menu_id']) ? 'Add Front Menu' : 'Edit Front Menu';
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['menutitle'])) {
			$data['error_menutitle'] = $this->error['menutitle'];
		} else {
			$data['error_menutitle'] = '';
		}
		if (isset($this->error['menuurl'])) {
			$data['error_menuurl'] = $this->error['menuurl'];
		} else {
			$data['error_menuurl'] = '';
		}
		if (isset($this->error['region'])) {
			$data['error_region'] = $this->error['region'];
		} else {
			$data['error_region'] = '';
		}
		$url = '';

		$data['breadcrumbs'][] = array(
			'text' => "Menu Manger",
			'href' => $this->link('frontmenu', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (!isset($this->request->get['menu_id'])) {
			$data['action'] = $this->link('frontmenu/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('frontmenu/edit', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('frontmenu', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['menu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('frontmenu');
			$banner_info = $this->model_frontmenu->getMenu($this->request->get['menu_id']);
		}
		$data['single_slider'] = $banner_info;

		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['menus_description'])) {
			$data['menus_description'] = $this->request->post['menus_description'];
		} elseif (isset($this->request->get['menu_id'])) {
			$data['menus_description'] = $this->model_frontmenu->getMenusDescriptions($this->request->get['menu_id']);
		} else {
			$data['menus_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($banner_info)) {
			$data['sort_order'] = $banner_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['url'])) {
			$data['url'] = $this->request->post['url'];
		} elseif (!empty($banner_info)) {
			$data['url'] = $banner_info['url'];
		} else {
			$data['url'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($banner_info)) {
			$data['status'] = $banner_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($banner_info)) {
			$data['sort_order'] = $banner_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['region'])) {
			$data['region'] = $this->request->post['region'];
		} elseif (!empty($banner_info)) {
			$data['region'] = $banner_info['region'];
		} else {
			$data['region'] = 'bottom';
		}
		// if (isset($this->request->post['parent_id'])) {
		// 	$data['parent_id'] = $this->request->post['parent_id'];
		// } elseif (!empty($banner_info)) {
		// 	$data['parent_id'] = $banner_info['parent_id'];
		// } else {
		// 	$data['parent_id'] = 0;
		// }

		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
			$data['button_edit_icon'] = 'fa fa-eye';
		} else {
			$data['viewer'] = false;
			$data['button_edit_icon'] = 'fa fa-pencil';
		}

        // $data['all_menus'] = $this->model_frontmenu->getMenus(['order' => 'ASC']);
		$this->data = $data;
		$this->template = 'modules/frontmenu/form.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxfrontmenustatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		$this->load_model('frontmenu');
		$id = $this->request->post['id'];
		$status = $this->request->post['status'];
		$this->model_frontmenu->updateMenuStatus($id, $status);
		$json['success'] = true;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'frontmenu')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}
}
