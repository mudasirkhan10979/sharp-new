<?php
class ControllerNewsEventsCategories extends Controller
{
	private $error = array();

	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - News & Events Categories');
		$this->load_model('newseventscategories');
		$this->getList();
	}

	public function add()
	{
		$this->document->setTitle('Admin - News & Events Categories');
		$this->load_model('newseventscategories');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_newseventscategories->addNewsEventsCategories($this->request->post);
			$this->session->data['success'] = 'Success: You have added a new News & Events category!';
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
			$this->response->redirect($this->link('newseventscategories', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function edit()
	{
		$this->document->setTitle('Admin - News & Events Categories');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('newseventscategories');
			$this->model_newseventscategories->editNewsEventsCategories($this->request->get['ne_category_id'], $this->request->post);
			$this->session->data['success'] = 'Success: You have modified News & Events category!';
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
			$this->response->redirect($this->link('newseventscategories', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function delete()
	{
		$this->load_model('newseventscategories');
		if ($this->request->post['ne_category_id'] && $this->validateDelete()) {
			$this->model_newseventscategories->deleteNewsEventsCategories($this->request->post['ne_category_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted News & Events category!');
			$this->response->redirect($this->link('newseventscategories', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}

	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['ne_category_id']) ? 'Add New News & Events Category' : 'Edit News & Events Category';

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}
		if (isset($this->error['parent'])) {
			$data['error_parent'] = $this->error['parent'];
		} else {
			$data['error_parent'] = '';
		}

		$url = '';

		if (!isset($this->request->get['ne_category_id'])) {
			$data['action'] = $this->link('newseventscategories/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('newseventscategories/edit', 'token=' . $this->session->data['token'] . '&ne_category_id=' . $this->request->get['ne_category_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('newseventscategories', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['ne_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('newseventscategories');
			$ne_categories_info = $this->model_newseventscategories->getNewsEventsCategory($this->request->get['ne_category_id']);
		}

		$db_filter = [
			'order' => 'DESC'
		];

		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);

		if (isset($this->request->post['ne_categories_description'])) {
			$data['ne_categories_description'] = $this->request->post['ne_categories_description'];
		} elseif (isset($this->request->get['ne_category_id'])) {
			$data['ne_categories_description'] = $this->model_newseventscategories->getNewsEventsCategoryDescriptions($this->request->get['ne_category_id']);
		} else {
			$data['ne_categories_description'] = array();
		}
		if (isset($this->request->post['path'])) {
			$data['path'] = $this->request->post['path'];
		} elseif (!empty($ne_categories_info)) {
			$data['path'] = $ne_categories_info['path'];
		} else {
			$data['path'] = '';
		}
		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = (int)$this->request->post['parent_id'];
		} elseif (!empty($ne_categories_info)) {
			$data['parent_id'] = $ne_categories_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($ne_categories_info)) {
			$data['sort_order'] = $ne_categories_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($ne_categories_info)) {
			$data['status'] = $ne_categories_info['publish'];
		} else {
			$data['status'] = true;
		}
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/newseventscategories/form.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	protected function validateForm()
{
    $data = $this->request->post;
    $this->load_model('newseventscategories');
    foreach ($data['ne_categories_description'] as $language_id => $value) {
        if (utf8_strlen(trim($value['title'])) < 1) {
            $this->error['title'][$language_id] = "Title field is missing";
        }
        if (utf8_strlen(trim($value['description'])) < 1) {
            $this->error['description'][$language_id] = "Description field is missing";
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
		$this->load_model('newseventscategories');
		$url = '';

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
		$data['add'] = $this->link('newseventscategories/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['ne_categories'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_newseventscategories->getNewsEventsCategories($filter_data);
		// echo '<pre>'; print_r($results); echo '</pre>'; exit;
		foreach ($results as $result) {
			$data['ne_categories'][] = array(
				'ne_category_id'=> $result['ne_category_id'],
				'title'		 	=> $result['title'],
				'sort_order'	=> $result['sort_order'],
				'status' 		=> $result['publish'],
				'edit'       	=> $this->link('newseventscategories/edit', 'token=' . $this->session->data['token'] . '&ne_category_id=' . $result['ne_category_id'] . $url, 'SSL'),
				'delete'       	=> $this->link('newseventscategories/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['ajaxnecategorystatus'] = $this->link('newseventscategories/ajaxnecategorystatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/newseventscategories/list.tpl';

		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxnecategorystatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('newseventscategories');
			$ne_category_id = $this->request->post['ne_category_id'];
			$status = $this->request->post['status'];

			$stat = $this->model_newseventscategories->updateNewsEventsCategoryStatus($ne_category_id, $status);
			if ($stat) {
				$json['success'] = true;
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			} else {
				$json['success'] = false;
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			}
		} else {
			$json['success'] = false;
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}

	protected function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'newseventscategories')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}

	public function autocomplete() {
		$json = [];
		if (isset($this->request->get['filter_title'])) {
			$this->load_model('newseventscategories');
			$filter_data = [
				'filter_title' => $this->request->get['filter_title'],
				'sort'        => 'title',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			];
			$results = $this->model_newseventscategories->getNewsEventsCategories($filter_data);
			foreach ($results as $result) {
				$json[] = [
					'ne_category_id' => $result['ne_category_id'],
					'title'        => $result['title']
				];
			}
		}
		$sort_order = [];
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['title'];
		}
		array_multisort($sort_order, SORT_ASC, $json);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}