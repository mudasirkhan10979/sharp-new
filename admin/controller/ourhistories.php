<?php
class ControllerOurhistories extends Controller
{
	private $error = array();

	public function index()
	{

		$data = $this->language->getAll();
		$this->document->setTitle('Admin - History');
		$this->load_model('ourhistories');
		$this->getList();
	}

	protected function getList()
	{
		
		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('ourhistories', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('ourhistories/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('ourhistories/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_ourhistories->getHistories($filter_data);
		foreach ($results as $result) {
			$data['ourhistories'][] = array(
				'history_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'status'     => $result['status'],
				'edit'        => $this->link('ourhistories/edit', 'token=' . $this->session->data['token'] . '&history_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('ourhistories/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}

		$data['main_ourhistories'] = $results;
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
		$data['sort_status'] = $this->link('ourhistories', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('ourhistories', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxhistorystatus'] = $this->link('ourhistories/ajaxhistorystatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$ourhistoriesTotal        = $this->model_ourhistories->getTotalhistories();
		$pagination         = new Pagination();
		$pagination->total  = $ourhistoriesTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=ourhistories/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($ourhistoriesTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($ourhistoriesTotal - $this->config->get('config_limit_admin'))) ? $ourhistoriesTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $ourhistoriesTotal, ceil($ourhistoriesTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=ourhistories';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/ourhistories/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - History');

		$this->load_model('ourhistories');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_ourhistories->addHistory($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new History!');

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
			$this->response->redirect($this->link('ourhistories', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'ourhistories')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$error_date = 'Year field is missing';
		$data = $this->request->post;
		foreach ($data['ourhistories_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Description field is missing";
			}
		}

		if ($this->request->post['date'] == '') {
			$this->error['date'] =  $error_date;
		}

			if (!$this->request->get['history_id']) {
				if ($_FILES["image"]["name"] == "") {
					$this->error['image'] = 'Please upload Image';
				}
			} else {
				if ($data["image"] == "" && $_FILES["image"]["name"] == "") {
					$this->error['image'] = 'Please upload Image';
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
		$this->document->setTitle('Admin - History');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('ourhistories');
			$this->model_ourhistories->editHistory($this->request->get['history_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified History!');
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
			$this->response->redirect($this->link('ourhistories', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('ourhistories');
		if ($this->request->post['history_id'] && $this->validateDelete()) {
			$this->model_ourhistories->deleteHistory($this->request->post['history_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted History!');
			$this->response->redirect($this->link('ourhistories', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['history_id']) ? 'Add New History' : 'Edit History';
		$data['img_feild_required'] = !isset($this->request->get['history_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['history_id']) ? "no" : "yes";
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
		if (isset($this->error['date'])) {
			$data['error_date'] = $this->error['date'];
		} else {
			$data['error_date'] = '';
		}
		$url = '';
		if (!isset($this->request->get['history_id'])) {
			$data['action'] = $this->link('ourhistories/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('ourhistories/edit', 'token=' . $this->session->data['token'] . '&history_id=' . $this->request->get['history_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('ourhistories', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['history_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('ourhistories');
			$history_info = $this->model_ourhistories->getHistory($this->request->get['history_id']);
		}
		$data['single_ourhistories'] = $history_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);

		if (isset($this->request->post['history_id'])) {
			$data['history_id'] = $this->request->post['history_id'];
		} elseif (!empty($history_info)) {
			$data['history_id'] = $history_info['id'];
		} else {
			$data['history_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($history_info)) {
			$data['sort_order'] = $history_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($history_info)) {
			$data['status'] = $history_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['date'])) {
			$data['date'] = $this->request->post['date'];
		} elseif (!empty($history_info)) {
			$data['date'] = date('Y-m-d', strtotime($history_info['date']));
		} else {
			$data['date'] = '';
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($history_info)) {
			$data['image'] = $history_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['ourhistories_description'])) {
			$data['ourhistories_description'] = $this->request->post['ourhistories_description'];
		} elseif (isset($this->request->get['history_id'])) {
			$data['ourhistories_description'] = $this->model_ourhistories->getHistoryDescription($this->request->get['history_id']);
		} else {
			$data['ourhistories_description'] = array();
		}
		$data['deleteImage'] = $this->link('ourhistories/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data = $data;
		$this->template = 'modules/ourhistories/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxhistorystatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('ourhistories');
			$history_id = $this->request->post['history_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_ourhistories->updateHistoriesStatus($history_id, $status);
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
		if (!$this->user->hasPermission('modify', 'ourhistories')) {
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

	public function deleteImage()
    {
        $this->load_model('ourhistories');
        $history_id = (int)$this->request->get['history_id'];

        if ($history_id) {
            $result = $this->model_ourhistories->deleteOurHistoryImage($history_id);
            if (isset($result['success'])) {
                $json = ['success' => true];
            } else {
                $json = ['error' => $result['error']];
            }
        } else {
            $json = ['error' => 'Invalid Our History ID.'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }
}
