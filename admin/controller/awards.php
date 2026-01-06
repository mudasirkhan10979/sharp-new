<?php
class ControllerAwards extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Awards');
		$this->load_model('awards');
		$this->getList();
	}
	protected function getList()
	{
		$data = $this->language->getAll();
		$url  = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('awards', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (isset($this->request->get['page'])) {
			$page = (int) $this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		$data['add']    = $this->link('awards/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('awards/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['users'] = array();
		$filter_data   = array(
			'order' => $order,
		);
		$results       = $this->model_awards->getAwards($filter_data);
		foreach ($results as $result) {
			$data['awards'][] = array(
				'award_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'image'       => $result['image'],
				'status'     => $result['status'],
				'edit'        => $this->link('awards/edit', 'token=' . $this->session->data['token'] . '&award_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('awards/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_award'] = $results;
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
			$data['selected'] = (array) $this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$data['groupby'] = 1;
		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status']     = $this->link('awards', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('awards', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$url                     = '';
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
		$awardTotal        = $this->model_awards->getTotalAwards();
		$pagination         = new Pagination();
		$pagination->total  = $awardTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=awards/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($awardTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($awardTotal - $this->config->get('config_limit_admin'))) ? $awardTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $awardTotal, ceil($awardTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=awards';
		$data['token']      = $this->session->data['token'];
		$data['ajaxawardstatus'] = $this->link('awards/ajaxawardstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data         = $data;
		$this->template     = 'modules/awards/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Award');

		$this->load_model('awards');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_awards->addAward($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Award!');

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
			$this->response->redirect($this->link('awards', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	}
	protected function validateForm()
	{
		$data = $this->request->post;
		foreach ($data['award_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			} 
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Description field is missing";
			} 
		}
		if (!$this->request->get['award_id']) {
			if ($_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload Award Image';
			}
		}
		else
		{
			if ($data["image"] == "" && $_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload Award Image';
			}
		}

		if (trim($this->request->post['publish_date']) < 1) {
			$this->error['publish_date'] = "Date is missing";
		}

		if ($this->error && ! isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function edit()
	{
		if ($this->user->hasPermission('modify', 'awards')) {
			$this->document->setTitle('Admin - Award');
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->load_model('awards');
				$this->model_awards->editAward($this->request->get['award_id'], $this->request->post);
				$this->session->data['success'] = $this->language->get('Success: You have modified award!');
				$url                            = '';
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				$this->response->redirect($this->link('awards', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			} 
			$this->getForm();
		}
		else
		{
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
			$this->index();
		}
	}

	public function delete()
	{
		$this->load_model('awards');
		if (isset($this->request->post['award_id']) && $this->validateDelete()) {
			$this->model_awards->deleteAward($this->request->post['award_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Award!');
			$this->response->redirect($this->link('awards', 'token=' . $this->session->data['token'], 'SSL'));
		} 
		$this->getList();
	}

	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = ! isset($this->request->get['award_id']) ? 'Add New Award' : 'Edit Award';
		$data['img_feild_required'] = ! isset($this->request->get['award_id']) ? "required" : "";
		$data['is_edit']            = ! isset($this->request->get['award_id']) ? "no" : "yes";
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
		if (isset($this->error['publish_date'])) {
			$data['error_publish_date'] = $this->error['publish_date'];
		} else {
			$data['error_publish_date'] = '';
		}
		if (isset($this->error['short_description'])) {
			$data['error_short_description'] = $this->error['short_description'];
		} else {
			$data['error_short_description'] = '';
		} 
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = '';
		}
		$url = '';
		if (! isset($this->request->get['award_id'])) {
			$data['action'] = $this->link('awards/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('awards/edit', 'token=' . $this->session->data['token'] . '&award_id=' . $this->request->get['award_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('awards', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['award_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('awards');
			$award_info = $this->model_awards->getAward($this->request->get['award_id']);
		}
		$data['single_award'] = $award_info;
		$db_filter             = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (! empty($award_info)) {
			$data['sort_order'] = $award_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (! empty($award_info)) {
			$data['status'] = $award_info['status'];
		} else {
			$data['status'] = true;
		} 
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($award_info)) {
			$data['image'] = $award_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['publish_date'])) {
			$data['publish_date'] = $this->request->post['publish_date'];
		} elseif (!empty($award_info)) {
			$data['publish_date'] = date('Y-m-d', strtotime($award_info['publish_date']));
		} else {
			$data['publish_date'] = true;
		}
		if (isset($this->request->post['award_description'])) {
			$data['award_description'] = $this->request->post['award_description'];
		} elseif (isset($this->request->get['award_id'])) {
			$data['award_description'] = $this->model_awards->getAwardDescription($this->request->get['award_id']);
		} else {
			$data['award_description'] = array();
		} 
		$this->data     = $data;
		$this->template = 'modules/awards/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	
	public function ajaxawardstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('awards');
			$award_id = $this->request->post['award_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_awards->updateAwardStatus($award_id, $status);
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
		if (!$this->user->hasPermission('modify', 'awards')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}
}
