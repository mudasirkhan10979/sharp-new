<?php
class ControllerJobType extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Job Types');
		$this->load_model('jobtype');
		$this->getList();
	}
	protected function getList()
	{
		$data = $this->language->getAll();
		$url  = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Job Types',
			'href' => $this->link('jobtype', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('jobtype/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('jobtype/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['users'] = array();
		$filter_data   = array(
			'order' => $order,
		);
		$results = $this->model_jobtype->getJobTypes($filter_data);
		foreach ($results as $result) {
			$data['jobtypes'][] = array(
				'jobtype_id'     => $result['jobtype_id'],
				'sort_order' => $result['sort_order'],
				'title'   => $result['title'],
				'publish'    => $result['publish'],
				'edit'       => $this->link('jobtype/edit', 'token=' . $this->session->data['token'] . '&jobtype_id=' . $result['jobtype_id'] . $url, 'SSL'),
				'delete'     => $this->link('jobtype/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_jobtypes'] = $results;
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
		$url             = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status']     = $this->link('jobtype', 'token=' . $this->session->data['token'] . '&sort=publish' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('jobtype', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxjobtypestatus'] = $this->link('jobtype/ajaxjobtypestatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$jobTypeTotal        = $this->model_jobtype->getTotalJobTypes();
		$pagination         = new Pagination();
		$pagination->total  = $jobTypeTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=jobtype/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($jobTypeTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($jobTypeTotal - $this->config->get('config_limit_admin'))) ? $jobTypeTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $jobTypeTotal, ceil($jobTypeTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=jobtype';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/jobtype/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Job Type');

		$this->load_model('jobtype');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_jobtype->addJobType($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Job Type!');

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
			$this->response->redirect($this->link('jobtype', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'jobtype')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
		foreach ($data['jobtype_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title is missing";
			}
			if ((utf8_strlen(trim($value['description'])) < 1)) {
				$this->error['description'][$language_id] = "Description is missing";
			}
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
		$this->document->setTitle('Admin - Job Type');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('jobtype');
			$this->model_jobtype->editJobType($this->request->get['jobtype_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Job Type!');
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
			$this->response->redirect($this->link('jobtype', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('jobtype');
		if($this->validateDelete() && $this->request->post['jobtype_id']){
			$this->model_jobtype->deleteJobType($this->request->post['jobtype_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted a Job Type!');
			$this->response->redirect($this->link('jobtype', 'token=' . $this->session->data['token'], 'SSL'));
		}
	
		$this->getList();
	}
	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = ! isset($this->request->get['jobtype_id']) ? 'Add New Job Type' : 'Edit Job Type';
		$data['is_edit']            = ! isset($this->request->get['jobtype_id']) ? "no" : "yes";
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

		$url = '';

		if (! isset($this->request->get['jobtype_id'])) {
			$data['action'] = $this->link('jobtype/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('jobtype/edit', 'token=' . $this->session->data['token'] . '&jobtype_id=' . $this->request->get['jobtype_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('jobtype', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['jobtype_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('jobtype');
			$jobType_info = $this->model_jobtype->getJobType($this->request->get['jobtype_id']);
		}
		$data['single_jobtype'] = $jobType_info;
		$db_filter             = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['jobtype_description'])) {
			$data['jobtype_description'] = $this->request->post['jobtype_description'];
		} elseif (isset($this->request->get['jobtype_id'])) {
			$data['jobtype_description'] = $this->model_jobtype->getJobTypeDescriptions($this->request->get['jobtype_id']);
		} else {
			$data['jobtype_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (! empty($jobType_info)) {
			$data['sort_order'] = $jobType_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (! empty($jobType_info)) {
			$data['publish'] = $jobType_info['publish'];
		} else {
			$data['publish'] = true;
		}

		$this->data     = $data;
		$this->template = 'modules/jobtype/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxJobTypeStatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		$this->load_model('jobtype');
		$jobtype_id = $this->request->post['jobtype_id'];
		$status = $this->request->post['status'];
		$this->model_jobtype->updateJobTypeStatus($jobtype_id, $status);
		$json['success'] = true;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}
	
	protected function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'jobtype')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}
}