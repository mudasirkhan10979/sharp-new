<?php
class ControllerAdminuser extends Controller {
	private $error = array(); 
	public function index() { 
		$this->document->setTitle($this->language->get('au_heading_title'));
		$this->load_model('adminuser');
		$this->getList();
	} 
	public function add() { 
		$this->document->setTitle($this->language->get('au_heading_title')); 
		$this->load_model('adminuser'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_adminuser->addUser($this->request->post); 
			$this->session->data['success'] = $this->language->get('Success: You have added a new admin user!'); 
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
			$this->response->redirect($this->link('adminuser', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	} 
	public function edit() {  
		$this->document->setTitle($this->language->get('au_heading_title')); 
		$this->load_model('adminuser'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_adminuser->editUser($this->request->get['user_id'], $this->request->post); 
			$this->session->data['success'] = $this->language->get('Success: You have modified admin user!'); 
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
			
            $this->response->redirect($this->link('adminuser', 'token=' . $this->session->data['token'] . $url, 'SSL'));

		}

		$this->getForm();
	} 
	public function delete() { 
		$this->document->setTitle($this->language->get('au_heading_title')); 
		$this->load_model('adminuser'); 
		if (isset($this->request->post['user_id']) && $this->validateDelete()) {
			$this->model_adminuser->deleteUser($this->request->post['user_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted admin user!');
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
			$this->response->redirect($this->link('adminuser', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'text' => $this->language->get('mtext_adminuser'),
			'href' => $this->link('dashboard', 'token=' . $this->session->data['token'], 'SSL')
		); 
		
		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
			$data['button_edit_icon'] = 'fa fa-eye';
		} else {
			$data['viewer'] = false;
			$data['button_edit_icon'] = 'fa fa-pencil';
		}
		$data['add'] = $this->link('adminuser/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('adminuser/delete', 'token=' . $this->session->data['token'] . $url, 'SSL'); 
		$data['users'] = array(); 
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		); 
		$user_total = $this->model_adminuser->getTotalUsers(); 
		$results = $this->model_adminuser->getUsers($filter_data);   
		$userRoles = $this->model_adminuser->getAllUserGroups();  
		foreach ($results as $result) {
			$data['users'][] = array(
				'user_id'    => $result['user_id'],
				'username'   => $result['username'],
				'date'   	 => $result['date_added'],
				'email'   	 => $result['email'],
				'full_name'  => $result['full_name'],
				'role'   	 => $userRoles[$result['user_group_id']],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'delete'       => $this->link('adminuser/delete', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'edit'       => $this->link('adminuser/edit', 'token=' . $this->session->data['token'] . '&user_id=' . $result['user_id'] . $url, 'SSL')
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
		$data['sort_username'] = $this->link('adminuser', 'token=' . $this->session->data['token'] . '&sort=username' . $url, 'SSL');
		$data['sort_status'] = $this->link('adminuser', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('adminuser', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		
		$data['ajaxadminuserstatus'] = $this->link('adminuser/ajaxadminuserstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $user_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->link('adminuser', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'); 
		$data['pagination'] = $pagination->render(); 
		$data['results'] = sprintf($this->language->get('text_pagination'), ($user_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($user_total - $this->config->get('config_limit_admin'))) ? $user_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $user_total, ceil($user_total / $this->config->get('config_limit_admin')));
		$data['sort'] = $sort;
		$data['order'] = $order; 
		$this->data = $data;
		$this->template = 'adminuser/adminuser_list.tpl';
		$this->zones = array(
			'header',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
        
		$data=$this->language->getAll(); 
		$data['text_form'] = !isset($this->request->get['user_id']) ? $this->language->get('au_text_add') : $this->language->get('au_text_edit');
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
		
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		if (isset($this->error['fullname'])) {
			$data['error_fullname'] = $this->error['fullname'];
		} else {
			$data['error_fullname'] = '';
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
			'text' => $this->language->get('au_heading_title'),
			'href' => $this->link('adminuser', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['user_id'])) {
			$data['action'] = $this->link('adminuser/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('adminuser/edit', 'token=' . $this->session->data['token'] . '&user_id=' . $this->request->get['user_id'] . $url, 'SSL');
		} 
		$data['cancel'] = $this->link('adminuser', 'token=' . $this->session->data['token'] . $url, 'SSL'); 
		if (isset($this->request->get['user_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$user_info = $this->model_adminuser->getUser($this->request->get['user_id']);
		} 
		

		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
			$data['button_edit_icon'] = 'fa fa-eye';
		} else {
			$data['viewer'] = false;
			$data['button_edit_icon'] = 'fa fa-pencil';
		}

		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} elseif (!empty($user_info)) {
			$data['username'] = $user_info['username'];
		} else {
			$data['username'] = '';
		} 
		if (isset($this->request->post['user_group_id'])) {
			$data['user_group_id'] = $this->request->post['user_group_id'];
		} elseif (!empty($user_info)) {
			$data['user_group_id'] = $user_info['user_group_id'];
		} else {
			$data['user_group_id'] = '';
		} 
		$this->load_model('roles'); 
		$data['user_groups'] = $this->model_roles->getUserGroups(); 
		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		} 
		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		} 
		if (isset($this->request->post['fullname'])) {
			$data['fullname'] = $this->request->post['fullname'];
		} elseif (!empty($user_info)) {
			$data['fullname'] = $user_info['full_name'];
		} else {
			$data['fullname'] = '';
		} 
		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($user_info)) {
			$data['lastname'] = $user_info['lastname'];
		} else {
			$data['lastname'] = '';
		}  
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($user_info)) {
			$data['email'] = $user_info['email'];
		} else {
			$data['email'] = '';
		} 
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($user_info)) {
			$data['image'] = $user_info['image'];
		} else {
			$data['image'] = '';
		} 
		
		$this->load_model('tool/image'); 
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($user_info) && $user_info['image'] && is_file(DIR_IMAGE . $user_info['image'])) {
			
			$data['thumb'] = $this->model_tool_image->resize($user_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		} 
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100); 

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($user_info)) {
			$data['status'] = $user_info['status'];

		} else {
			$data['status'] = true;
		}
		$this->data = $data;
		$this->template = 'adminuser/adminuser_form.tpl';
		$this->zones = array(
			'header',
			'footer'
		);
		$this->response->setOutput($this->render()); 
	} 
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'adminuser')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		if ((utf8_strlen($this->request->post['username']) < 1) || (utf8_strlen($this->request->post['username']) > 30)) {
			$this->error['username'] = $this->language->get('error_adminusername');
		}

		$user_info = $this->model_adminuser->getUserByUsername($this->request->post['username']);
        
		if (!isset($this->request->get['user_id'])) {
			if ($user_info) {
				$this->error['warning'] = $this->language->get('error_exists_username');
			}
		} else {
			if ($user_info && ($this->request->get['user_id'] != $user_info['user_id'])) {
				$this->error['warning'] = $this->language->get('error_exists_username');
			}
		}
		if ((utf8_strlen(trim($this->request->post['fullname'])) < 1) || (utf8_strlen(trim($this->request->post['fullname'])) > 32)) {
			$this->error['fullname'] = $this->language->get('error_fullname');
		}
		if ((utf8_strlen(trim($this->request->post['username'])) < 1) || (utf8_strlen(trim($this->request->post['username'])) > 32)) {
			$this->error['username'] = $this->language->get('error_username');
		}
		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}
		$user_info = $this->model_adminuser->getUserByEmail($this->request->post['email']);

		if (!isset($this->request->get['user_id'])) {
			if ($user_info) {
				$this->error['warning'] = $this->language->get('error_exists_email');
			}
		} else {
			if ($user_info && ($this->request->get['user_id'] != $user_info['user_id'])) {
				$this->error['warning'] = $this->language->get('error_exists_email');
			}
		}
		if ($this->request->post['password'] || (!isset($this->request->get['user_id']))) {
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['password'] = $this->language->get('error_password');
			}

			if ($this->request->post['password'] != $this->request->post['confirm']) {
				$this->error['confirm'] = $this->language->get('error_confirm');
			}
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
		return !$this->error;
	}

	public function ajaxadminuserstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		$this->load_model('adminuser');
		$id = $this->request->post['id'];
		// echo '<pre>'; print_r($user_id); exit;
		$status = $this->request->post['status'];
		$this->model_adminuser->updateAdminUserStatus($id, $status);
		$json['success'] = true;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}

	protected function validateDelete() {
		
		if (!$this->user->hasPermission('modify', 'adminuser')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		foreach ($this->request->post['selected'] as $user_id) {
			if ($this->user->getId() == $user_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}
		}

		return !$this->error;
	}
}