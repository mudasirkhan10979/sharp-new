<?php
class ControllerLcareport extends Controller
{
	private $error = array();

	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - LCA Report');
		$this->load_model('lcareport');
		$this->getList();
	}

	protected function getList()
	{
		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'LCA Report',
			'href' => $this->link('lcareport', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('lcareport/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('lcareport/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_lcareport->getLcareports($filter_data);
		foreach ($results as $result) {
			$data['lcareports'][] = array(
				'lcareport_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'status'     => $result['status'],
				'edit'        => $this->link('lcareport/edit', 'token=' . $this->session->data['token'] . '&lcareport_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('lcareport/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}

		$data['main_lcareports'] = $results;
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
		$data['sort_status'] = $this->link('lcareport', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('lcareport', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxlcareportstatus'] = $this->link('lcareport/ajaxlcareportstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$lcareportsTotal        = $this->model_lcareport->getTotalLcareports();
		$pagination         = new Pagination();
		$pagination->total  = $lcareportsTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=lcareport/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($lcareportsTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($lcareportsTotal - $this->config->get('config_limit_admin'))) ? $lcareportsTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $lcareportsTotal, ceil($lcareportsTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=lcareport';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/lcareport/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - LCA Report');

		$this->load_model('lcareport');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_lcareport->addLcareport($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new LCA Report!');

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
			$this->response->redirect($this->link('lcareport', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'lcareport')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$error_date = 'Year field is missing';
		$data = $this->request->post;
		foreach ($data['lcareport_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Description field is missing";
			}
		}


		if (!$this->request->get['lcareport_id']) {
				if ($_FILES["image"]["name"] == "") {
					$this->error['image'] = 'Please upload Image';
				}
			} else {
				if ($data["image"] == "" && $_FILES["image"]["name"] == "") {
					$this->error['image'] = 'Please upload Image';
				}
			}

		// PDF validation
        if (!$this->request->get['lcareport_id']) {
            if (empty($_FILES["pdf"]["name"])) {
                $this->error['pdf'] = 'Please upload PDF file';
            } elseif ($_FILES["pdf"]["type"] != 'application/pdf') {
                $this->error['pdf'] = 'Only PDF files are allowed';
            }
        } else {
            if (empty($this->request->post['existing_pdf']) && empty($_FILES["pdf"]["name"])) {
                $this->error['pdf'] = 'Please upload PDF file';
            } elseif (!empty($_FILES["pdf"]["name"]) && $_FILES["pdf"]["type"] != 'application/pdf') {
                $this->error['pdf'] = 'Only PDF files are allowed';
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
		$this->document->setTitle('Admin - LCA Report');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('lcareport');
			$this->model_lcareport->editLcareport($this->request->get['lcareport_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified LCA Report!');
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
			$this->response->redirect($this->link('lcareport', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('lcareport');
		if ($this->request->post['lcareport_id'] && $this->validateDelete()) {
			$this->model_lcareport->deleteLcareport($this->request->post['lcareport_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted LCA Report!');
			$this->response->redirect($this->link('lcareport', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['lcareport_id']) ? 'Add New LCA Report' : 'Edit LCA Report';
		$data['img_feild_required'] = !isset($this->request->get['lcareport_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['lcareport_id']) ? "no" : "yes";
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
		if (isset($this->error['pdf'])) {
			$data['error_pdf'] = $this->error['pdf'];
		} else {
			$data['error_pdf'] = '';
		}

		$url = '';
		if (!isset($this->request->get['lcareport_id'])) {
			$data['action'] = $this->link('lcareport/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('lcareport/edit', 'token=' . $this->session->data['token'] . '&lcareport_id=' . $this->request->get['lcareport_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('lcareport', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['lcareport_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('lcareport');
			$lcareport_info = $this->model_lcareport->getLcareport($this->request->get['lcareport_id']);
		}
		$data['single_lcareport'] = $lcareport_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);

		if (isset($this->request->post['lcareport_id'])) {
			$data['lcareport_id'] = $this->request->post['lcareport_id'];
		} elseif (!empty($lcareport_info)) {
			$data['lcareport_id'] = $lcareport_info['id'];
		} else {
			$data['lcareport_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($lcareport_info)) {
			$data['sort_order'] = $lcareport_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($lcareport_info)) {
			$data['status'] = $lcareport_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($lcareport_info)) {
			$data['image'] = $lcareport_info['image'];
		} else {
			$data['image'] = '';
		}
		 if (isset($this->request->post['pdf'])) {
            $data['pdf'] = $this->request->post['pdf'];
        } elseif (!empty($lcareport_info)) {
            $data['pdf'] = $lcareport_info['pdf'];
        } else {
            $data['pdf'] = '';
        }
		if (isset($this->request->post['lcareport_description'])) {
			$data['lcareport_description'] = $this->request->post['lcareport_description'];
		} elseif (isset($this->request->get['lcareport_id'])) {
			$data['lcareport_description'] = $this->model_lcareport->getLcareportDescription($this->request->get['lcareport_id']);
		} else {
			$data['lcareport_description'] = array();
		}
		$data['deleteImage'] = $this->link('lcareport/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data = $data;
		$this->template = 'modules/lcareport/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxlcareportstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('lcareport');
			$lcareport_id = $this->request->post['lcareport_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_lcareport->updateLcareportStatus($lcareport_id, $status);
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
		if (!$this->user->hasPermission('modify', 'lcareport')) {
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
        $this->load_model('lcareport');
        $lcareport_id = (int)$this->request->get['lcareport_id'];

        if ($lcareport_id) {
            $result = $this->model_lcareport->deletelcareportImage($lcareport_id);
            if (isset($result['success'])) {
                $json = ['success' => true];
            } else {
                $json = ['error' => $result['error']];
            }
        } else {
            $json = ['error' => 'Invalid Lcareport ID.'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }
}