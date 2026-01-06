<?php
class ControllerAffiliates extends Controller {
	private $error = array(); 
	public function index() { 
		$this->document->setTitle($this->language->get('afu_heading_title')); 
		$this->load_model('affiliates'); 
		$this->getList();
	} 
	public function add() { 
		$this->document->setTitle($this->language->get('afu_heading_title')); 
		$this->load_model('affiliates'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_affiliates->addUser($this->request->post); 
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
			$this->response->redirect($this->link('affiliates', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	} 
	public function edit() {  
		$this->document->setTitle($this->language->get('afu_heading_title')); 
		$this->load_model('affiliates'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_affiliates->editUser($this->request->get['aff_id'], $this->request->post); 
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
			$this->response->redirect($this->link('affiliates', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	} 
	public function keys() {  
		$this->document->setTitle($this->language->get('afu_heading_title')); 
		$this->load_model('affiliates'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_affiliates->editUser($this->request->get['aff_id'], $this->request->post); 
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
			$this->response->redirect($this->link('affiliates', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getListKeys();
	} 
	public function delete() { 
		$this->document->setTitle($this->language->get('afu_heading_title')); 
		$this->load_model('affiliates'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $aff_id) {
				$this->model_affiliates->deleteUser($aff_id);
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
			$this->response->redirect($this->link('affiliates', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getList();
	} 
	protected function getList() {
		
		$data=$this->language->getAll();
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'username';
		} 
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
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
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('afu_heading_title'),
			'href' => $this->link('affiliates', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->link('affiliates/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('affiliates/delete', 'token=' . $this->session->data['token'] . $url, 'SSL'); 
		$data['users'] = array(); 
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'filter_name'              => $filter_name,
			'filter_email'             => $filter_email,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		); 
		$aff_total = $this->model_affiliates->getTotalUsers(); 
		$results = $this->model_affiliates->getAffiliates($filter_data);  
		foreach ($results as $result) {
			$data['affiliates'][] = array(
				'aff_id'     => $result['aff_id'],
				'name'   	 => $result['firstname'].' '.$result['lastname'],
				'mobno'		 => $result['mobno'],
				'username'   => $result['username'],
				'email'   	 => $result['email'],
				'keys_available'  => $result['keys_available'],
				'keys_assigned'   => $result['keys_assigned'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'       => $this->link('affiliates/edit', 'token=' . $this->session->data['token'] . '&aff_id=' . $result['id'] . $url, 'SSL'),
				'keys'       => $this->link('affiliates/keys', 'token=' . $this->session->data['token'] . '&aff_id=' . $result['id'] . $url, 'SSL')
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
		$data['groupby'] = 1;
		$url = ''; 
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		} 
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		$data['sort_status'] = $this->link('affiliates', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('affiliates', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$pagination = new Pagination();
		$pagination->total = $aff_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->link('affiliates', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'); 
		$data['pagination'] = $pagination->render(); 
		$data['results'] = sprintf($this->language->get('text_pagination'), ($aff_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($aff_total - $this->config->get('config_limit_admin'))) ? $aff_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $aff_total, ceil($aff_total / $this->config->get('config_limit_admin')));
		$data['sort'] = $sort;
		$data['order'] = $order; 
		$data['ajaxUrl'] = HTTP_HOST.'?controller=affiliates';
		$data['token'] = $this->session->data['token'];
		$data['filter_name'] = $filter_name;
		$data['filter_email'] = $filter_email;
		
		$this->data = $data;
		$this->template = 'affiliates/aff_list.tpl';
		
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	protected function getListKeys() {
		
		$data=$this->language->getAll();
		$aff_id = $this->request->get['aff_id'];
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'username';
		} 
		
		if (isset($this->request->get['filter_key'])) {
			$filter_key = $this->request->get['filter_key'];
		} else {
			$filter_key = null;
		}

		if (isset($this->request->get['filter_date'])) {
			$filter_date = $this->request->get['filter_date'];
		} else {
			$filter_date = null;
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
		if (isset($this->request->get['filter_key'])) {
			$url .= '&filter_key=' . urlencode(html_entity_decode($this->request->get['filter_key'], ENT_QUOTES, 'UTF-8'));
		}

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('afu_heading_title'),
			'href' => $this->link('affiliates', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->link('affiliates/addkey', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('affiliates/deletekey', 'token=' . $this->session->data['token'] . $url, 'SSL'); 
		$data['users'] = array(); 
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'aff_id' => $aff_id,
			'filter_key' => $filter_key,
			'filter_date' => $filter_date,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		); 
		$aff_total = $this->model_affiliates->getTotalKeys($aff_id); 
		$results = $this->model_affiliates->getAffiliateKeys($filter_data);  
		foreach ($results as $result) {
			$data['affiliates'][] = array(
				'aff_id'     => $result['aff_id'],
				'license_key'   	 => $result['license_key'],
				'status_text'   	 => $result['status_text'],
				'name'   	 => $result['name'],
				'email'   	 => $result['email'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'       => $this->link('affiliates/edit', 'token=' . $this->session->data['token'] . '&aff_id=' . $result['id'] . $url, 'SSL'),
				'keys'       => $this->link('affiliates/keys', 'token=' . $this->session->data['token'] . '&aff_id=' . $result['id'] . $url, 'SSL')
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
		$data['groupby'] = 1;
		$url = ''; 
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		} 
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		$data['sort_status'] = $this->link('affiliates', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('affiliates', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$pagination = new Pagination();
		$pagination->total = $aff_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->link('affiliates', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'); 
		$data['pagination'] = $pagination->render(); 
		$data['results'] = sprintf($this->language->get('text_pagination'), ($aff_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($aff_total - $this->config->get('config_limit_admin'))) ? $aff_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $aff_total, ceil($aff_total / $this->config->get('config_limit_admin')));
		$data['sort'] = $sort;
		$data['order'] = $order; 
		$data['ajaxUrl'] = HTTP_HOST.'?controller=affiliates/keys';
		$data['token'] = $this->session->data['token'];
		$data['filter_name'] = $filter_name;
		$data['filter_email'] = $filter_email;
		$data['filter_key'] = $filter_key;
		$data['aff_id'] = $aff_id;
		$data['filter_date'] = $filter_date;
		
		$this->data = $data;
		$this->template = 'affiliates/aff_keys_list.tpl';
		
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$data=$this->language->getAll(); 
		$data['text_form'] = !isset($this->request->get['af_id']) ? $this->language->get('afu_text_add') : $this->language->get('afu_text_edit');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		} 
		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		} 
		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		} 
		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		} 
		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		} 
		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
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
		 
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('afu_heading_title'),
			'href' => $this->link('affiliates', 'token=' . $this->session->data['token'] . $url, 'SSL')
		); 
		if (!isset($this->request->get['aff_id'])) {
			$data['action'] = $this->link('affiliates/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('affiliates/edit', 'token=' . $this->session->data['token'] . '&aff_id=' . $this->request->get['aff_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('affiliates', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['aff_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$aff_info = $this->model_affiliates->getUser($this->request->get['aff_id']);
		} 
		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} elseif (!empty($aff_info)) {
			$data['username'] = $aff_info['username'];
		} else {
			$data['username'] = '';
		}  
		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		} 
		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($aff_info)) {
			$data['firstname'] = $aff_info['firstname'];
		} else {
			$data['firstname'] = '';
		} 
		if (isset($this->request->post['mobno'])) {
			$data['mobno'] = $this->request->post['mobno'];
		} elseif (!empty($aff_info)) {
			$data['mobno'] = $aff_info['mobno'];
		} else {
			$data['mobno'] = '';
		} 
		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($aff_info)) {
			$data['lastname'] = $aff_info['lastname'];
		} else {
			$data['lastname'] = '';
		}  
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($aff_info)) {
			$data['email'] = $aff_info['email'];
		} else {
			$data['email'] = '';
		}  
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($aff_info)) {
			$data['status'] = $aff_info['status'];
		} else {
			$data['status'] = 0;
		}
		$this->data = $data;
		$this->template = 'affiliates/aff_form.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render()); 
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'affiliates')) {
			//$this->error['warning'] = $this->language->get('error_permission'); 
		}
		if ((utf8_strlen($this->request->post['username']) < 3) || (utf8_strlen($this->request->post['username']) > 20)) {
			$this->error['username'] = $this->language->get('error_username');
		} 
		$aff_info = $this->model_affiliates->getUserByUsername($this->request->post['username']); 
		if (!isset($this->request->get['aff_id'])) {
			if ($aff_info) {
				$this->error['warning'] = $this->language->get('afu_error_exists');
			}
		} else {
			if ($aff_info && ($this->request->get['aff_id'] != $aff_info['aff_id'])) {
				$this->error['warning'] = $this->language->get('afu_error_exists');
			}
		} 
		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('afu_error_firstname');
		} 
		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('afu_error_lastname');
		} 
		if ($this->request->post['password'] || (!isset($this->request->get['aff_id']))) {
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['password'] = $this->language->get('afu_error_password');
			} 
			if ($this->request->post['password'] != $this->request->post['confirm']) {
				$this->error['confirm'] = $this->language->get('afu_error_confirm');
			}
		} 
		return !$this->error;
	} 
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'affiliates')) {
			//$this->error['warning'] = $this->language->get('error_permission');
		} 
		foreach ($this->request->post['selected'] as $aff_id) {
			if ($this->user->getId() == $aff_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}
		} 
		return !$this->error;
	}
}