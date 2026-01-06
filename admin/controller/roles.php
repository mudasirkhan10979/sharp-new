<?php
class ControllerRoles extends Controller {
	private $error = array(); 
	public function index() { 
		
		$this->document->setTitle('Roles'); 
		$this->load_model('roles'); 
		$this->getList();
	}

	public function add() { 
		$this->document->setTitle('Roles'); 
		$this->load_model('roles'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_roles->addUserGroup($this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
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
			$this->response->redirect($this->link('roles', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	} 
	public function edit() { 
		$this->document->setTitle('Roles'); 
		$this->load_model('roles'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_roles->editUserGroup($this->request->get['user_group_id'], $this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
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
			$this->response->redirect($this->link('roles', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	}

	public function delete() { 
		$this->document->setTitle('Roles'); 
		$this->load_model('roles'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $user_group_id) {
				$this->model_roles->deleteUserGroup($user_group_id);
			} 
			$this->session->data['success'] = $this->language->get('text_success'); 
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
			$this->response->redirect($this->link('roles', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getList();
	}

	protected function getList() {
		$data=$this->language->getAll(); 
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		} 
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('aur_text_list'),
			'href' => $this->link('dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('aur_heading_title'),
			'href' => $this->link('roles', 'token=' . $this->session->data['token'] . $url, 'SSL')
		); 
		$data['add'] = $this->link('roles/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('roles/delete', 'token=' . $this->session->data['token'] . $url, 'SSL'); 
		$data['user_groups'] = array(); 
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		); 
		$user_group_total = $this->model_roles->getTotalUserGroups(); 
		$results = $this->model_roles->getUserGroups($filter_data); 
		foreach ($results as $result) {
			$data['user_groups'][] = array(
				'user_group_id' => $result['user_group_id'],
				'name'          => $result['name'],
				'edit'          => $this->link('roles/edit', 'token=' . $this->session->data['token'] . '&user_group_id=' . $result['user_group_id'] . $url, 'SSL')
			);
		}  
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
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		} 
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		$data['sort_name'] = $this->link('roles', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL'); 
		$url = ''; 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $user_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->link('roles', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($user_group_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($user_group_total - $this->config->get('config_limit_admin'))) ? $user_group_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $user_group_total, ceil($user_group_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->data = $data;
		$this->template = 'adminuser/roles_list.tpl';
		$this->zones = array(
			'header',
			'footer'
		);
		$this->response->setOutput($this->render()); 
	}

	protected function getForm() {
		$data=$this->language->getAll();   
		$data['text_form'] = !isset($this->request->get['user_group_id']) ? $this->language->get('aur_text_add') : $this->language->get('aur_text_edit');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		} 
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		} 
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
		$data['breadcrumbs'] = array(); 
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->link('dashboard', 'token=' . $this->session->data['token'], 'SSL')
		); 
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('aur_heading_title'),
			'href' => $this->link('roles', 'token=' . $this->session->data['token'] . $url, 'SSL')
		); 
		if (!isset($this->request->get['user_group_id'])) {
			$data['action'] = $this->link('roles/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('roles/edit', 'token=' . $this->session->data['token'] . '&user_group_id=' . $this->request->get['user_group_id'] . $url, 'SSL');
		} 
		$data['cancel'] = $this->link('roles', 'token=' . $this->session->data['token'] . $url, 'SSL'); 
		if (isset($this->request->get['user_group_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$user_group_info = $this->model_roles->getUserGroup($this->request->get['user_group_id']);
		} 
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($user_group_info)) {
			$data['name'] = $user_group_info['name'];
		} else {
			$data['name'] = '';
		} 
		$ignore = array(
			'dashboard',
			'startup',
			'login',
			'logout',
			'forgotten',
			'reset',
			'not_found',
			'permission',
			'footer',
			'header',
			'dashboard/order',
			'dashboard/sale',
			'dashboard/customer',
			'dashboard/online',
			'dashboard/map',
			'dashboard/activity',
			'dashboard/chart',
			'dashboard/recent'
		); 
		$data['permissions'] = array(); 
		$files = glob(DIR_APP . 'controller/*.php');
		foreach ($files as $file) {
			$part = explode('/', dirname($file)); 
			$permission =  basename($file, '.php'); ///end($part) . '/' . basename($file, '.php'); 
			if (!in_array($permission, $ignore)) {
				$data['permissions'][] = $permission;
			}
		} 
		if (isset($this->request->post['permission']['access'])) {
			$data['access'] = $this->request->post['permission']['access'];
		} elseif (isset($user_group_info['permission']['access'])) {
			$data['access'] = $user_group_info['permission']['access'];
		} else {
			$data['access'] = array();
		} 
		if (isset($this->request->post['permission']['modify'])) {
			$data['modify'] = $this->request->post['permission']['modify'];
		} elseif (isset($user_group_info['permission']['modify'])) {
			$data['modify'] = $user_group_info['permission']['modify'];
		} else {
			$data['modify'] = array();
		}
		$this->data = $data;
		$this->template = 'adminuser/roles_form.tpl';
		$this->zones = array(
			'header',
			'footer'
		);
		$this->response->setOutput($this->render());  
	}

	protected function validateForm() {
		 
		return true;
		if (!$this->user->hasPermission('modify', 'roles')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		} 
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		} 
		return !$this->error;
	} 
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'roles')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		} 
		$this->load_model('adminuser'); 
		foreach ($this->request->post['selected'] as $user_group_id) {
			$user_total = $this->model_adminuser->getTotalUsersByGroupId($user_group_id); 
			if ($user_total) {
				$this->error['warning'] = sprintf($this->language->get('error_user'), $user_total);
			}
		} 
		return !$this->error;
	}
}