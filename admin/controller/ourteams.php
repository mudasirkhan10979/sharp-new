<?php
class ControllerOurTeams extends Controller
{
	private $error = array();

	public function index()
	{

		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Our Teams');
		$this->load_model('ourteams');
		$this->getList();
	}
	protected function getList()
	{
		
		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('ourteams', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('ourteams/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('ourteams/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_ourteams->getTeams($filter_data);
		foreach ($results as $result) {
			$data['ourteams'][] = array(
				'team_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'image'       => $result['image'],
				'status'     => $result['status'],
				'edit'        => $this->link('ourteams/edit', 'token=' . $this->session->data['token'] . '&team_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('ourteams/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}

		$data['main_ourteams'] = $results;
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
		$data['sort_status'] = $this->link('ourteams', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('ourteams', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxteamstatus'] = $this->link('ourteams/ajaxteamstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$ourteamsTotal        = $this->model_ourteams->getTotalTeams();
		$pagination         = new Pagination();
		$pagination->total  = $ourteamsTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=ourteams/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($ourteamsTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($ourteamsTotal - $this->config->get('config_limit_admin'))) ? $ourteamsTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $ourteamsTotal, ceil($ourteamsTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=ourteams';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/ourteams/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Our Teams');

		$this->load_model('ourteams');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_ourteams->addTeam($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Our Team!');

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
			$this->response->redirect($this->link('ourteams', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'ourteams')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}

		$data = $this->request->post;

		foreach ($data['ourteams_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['designation'])) < 1)) {
				$this->error['designation'][$language_id] = "Designation field is missing";
			}
		}

		if (!$this->request->get['team_id']) {
			if ($_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload Team Image';
			}
		} else {
			if ($data["image"] == "" && $_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload Team Image';
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

	public function edit()
	{
		$this->document->setTitle('Admin - Our Teams');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('ourteams');
			$this->model_ourteams->editTeam($this->request->get['team_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Our Team!');
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
			$this->response->redirect($this->link('ourteams', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('ourteams');
		if ($this->request->post['team_id'] && $this->validateDelete()) {
			$this->model_ourteams->deleteTeam($this->request->post['team_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Our Team!');
			$this->response->redirect($this->link('ourteams', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['team_id']) ? 'Add New Our Team' : 'Edit Our Team';
		$data['img_feild_required'] = !isset($this->request->get['team_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['team_id']) ? "no" : "yes";
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
		if (isset($this->error['designation'])) {
			$data['error_designation'] = $this->error['designation'];
		} else {
			$data['error_designation'] = '';
		}
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = '';
		}

		$url = '';
		if (!isset($this->request->get['team_id'])) {
			$data['action'] = $this->link('ourteams/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('ourteams/edit', 'token=' . $this->session->data['token'] . '&team_id=' . $this->request->get['team_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('ourteams', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['team_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('ourteams');
			$team_info = $this->model_ourteams->getTeam($this->request->get['team_id']);
		}
		$data['single_ourteams'] = $team_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($team_info)) {
			$data['sort_order'] = $team_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($team_info)) {
			$data['status'] = $team_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($team_info)) {
			$data['image'] = $team_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['ourteams_description'])) {
			$data['ourteams_description'] = $this->request->post['ourteams_description'];
		} elseif (isset($this->request->get['team_id'])) {
			$data['ourteams_description'] = $this->model_ourteams->getTeamDescription($this->request->get['team_id']);
		} else {
			$data['ourteams_description'] = array();
		}
		$this->data = $data;
		$this->template = 'modules/ourteams/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxteamstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('ourteams');
			$team_id = $this->request->post['team_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_ourteams->updateTeamStatus($team_id, $status);
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
		if (!$this->user->hasPermission('modify', 'ourteams')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}
	private function isFileSizeValid($file)
	{
		$uploadMaxSize = ini_get('upload_max_filesize');
		$postMaxSize = ini_get('post_max_size');
		$uploadMaxSizeBytes = $this->convertToBytes($uploadMaxSize);
		$postMaxSizeBytes = $this->convertToBytes($postMaxSize);
		if ($file['error'] === UPLOAD_ERR_OK) {
			$fileSize = $file['size'];
			if ($fileSize <= $uploadMaxSizeBytes && $fileSize <= $postMaxSizeBytes) {
				return true;
			}
		}
		return false;
	}
	private function convertToBytes($size)
	{
		$size = trim($size);
		$lastChar = strtolower($size[strlen($size) - 1]);
		$size = (int) $size;

		switch ($lastChar) {
			case 'g':
				$size *= 1024 * 1024 * 1024;
				break;
			case 'm':
				$size *= 1024 * 1024;
				break;
			case 'k':
				$size *= 1024;
				break;
		}
		return $size;
	}
}
