<?php
class ControllerSustainablePartner extends Controller
{
	private $error = array();

	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Sustainable Partners');
		$this->load_model('sustainablepartner');
		$this->getList();
	}

	protected function getList()
	{
		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Sustainable Partners',
			'href' => $this->link('sustainablepartner', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('sustainablepartner/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('sustainablepartner/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_sustainablepartner->getSustainablePartners($filter_data);
		foreach ($results as $result) {
			$data['sustainablepartners'][] = array(
				'sustainablepartner_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'status'     => $result['status'],
				'edit'        => $this->link('sustainablepartner/edit', 'token=' . $this->session->data['token'] . '&sustainablepartner_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('sustainablepartner/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}

		$data['main_sustainablepartners'] = $results;
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
		$data['sort_status'] = $this->link('sustainablepartner', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('sustainablepartner', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxsustainablepartnerstatus'] = $this->link('sustainablepartner/ajaxsustainablepartnerstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$sustainablepartnersTotal        = $this->model_sustainablepartner->getTotalSustainablePartners();
		$pagination         = new Pagination();
		$pagination->total  = $sustainablepartnersTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=sustainablepartner/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($sustainablepartnersTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sustainablepartnersTotal - $this->config->get('config_limit_admin'))) ? $sustainablepartnersTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sustainablepartnersTotal, ceil($sustainablepartnersTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=sustainablepartner';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/sustainablepartner/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	
	public function add()
	{
		$this->document->setTitle('Admin - Sustainable Partner');

		$this->load_model('sustainablepartner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_sustainablepartner->addSustainablePartner($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Sustainable Partner!');

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
			$this->response->redirect($this->link('sustainablepartner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'sustainablepartner')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$error_date = 'Year field is missing';
		$data = $this->request->post;
		foreach ($data['sustainablepartner_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Description field is missing";
			}
		}

			if (!$this->request->get['sustainablepartner_id']) {
				if ($_FILES["logo"]["name"] == "") {
					$this->error['logo'] = 'Please upload Logo';
				}
			} else {
				if ($data["logo"] == "" && $_FILES["logo"]["name"] == "") {
					$this->error['logo'] = 'Please upload Logo';
				}
			}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
		//print post and error array both //
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function edit()
	{
		$this->document->setTitle('Admin - Sustainable Partner');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('sustainablepartner');
			$this->model_sustainablepartner->editSustainablePartner($this->request->get['sustainablepartner_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Sustainable Partner!');
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
			$this->response->redirect($this->link('sustainablepartner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	
	public function delete()
	{
		$this->load_model('sustainablepartner');
		if ($this->request->post['sustainablepartner_id'] && $this->validateDelete()) {
			$this->model_sustainablepartner->deleteSustainablePartner($this->request->post['sustainablepartner_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Sustainable Partner!');
			$this->response->redirect($this->link('sustainablepartner', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}
	
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['sustainablepartner_id']) ? 'Add New Sustainable Partner' : 'Edit Sustainable Partner';
		$data['img_feild_required'] = !isset($this->request->get['sustainablepartner_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['sustainablepartner_id']) ? "no" : "yes";
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
		if (isset($this->error['logo'])) {
			$data['error_logo'] = $this->error['logo'];
		} else {
			$data['error_logo'] = '';
		}

		$url = '';
		if (!isset($this->request->get['sustainablepartner_id'])) {
			$data['action'] = $this->link('sustainablepartner/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('sustainablepartner/edit', 'token=' . $this->session->data['token'] . '&sustainablepartner_id=' . $this->request->get['sustainablepartner_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('sustainablepartner', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['sustainablepartner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('sustainablepartner');
			$sustainablepartner_info = $this->model_sustainablepartner->getSustainablePartner($this->request->get['sustainablepartner_id']);
		}
		$data['single_sustainablepartner'] = $sustainablepartner_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);

		if (isset($this->request->post['sustainablepartner_id'])) {
			$data['sustainablepartner_id'] = $this->request->post['sustainablepartner_id'];
		} elseif (!empty($sustainablepartner_info)) {
			$data['sustainablepartner_id'] = $sustainablepartner_info['id'];
		} else {
			$data['sustainablepartner_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($sustainablepartner_info)) {
			$data['sort_order'] = $sustainablepartner_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($sustainablepartner_info)) {
			$data['status'] = $sustainablepartner_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['logo'])) {
			$data['logo'] = $this->request->post['logo'];
		} elseif (!empty($sustainablepartner_info)) {
			$data['logo'] = $sustainablepartner_info['logo'];
		} else {
			$data['logo'] = '';
		}
		if (isset($this->request->post['sustainablepartner_description'])) {
			$data['sustainablepartner_description'] = $this->request->post['sustainablepartner_description'];
		} elseif (isset($this->request->get['sustainablepartner_id'])) {
			$data['sustainablepartner_description'] = $this->model_sustainablepartner->getSustainablePartnerDescription($this->request->get['sustainablepartner_id']);
		} else {
			$data['sustainablepartner_description'] = array();
		}
		$data['deleteImage'] = $this->link('sustainablepartner/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data = $data;
		$this->template = 'modules/sustainablepartner/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxsustainablepartnerstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('sustainablepartner');
			$sustainablepartner_id = $this->request->post['sustainablepartner_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_sustainablepartner->updateSustainablePartnerStatus($sustainablepartner_id, $status);
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
		if (!$this->user->hasPermission('modify', 'sustainablepartner')) {
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
        $this->load_model('sustainablepartner');
        $sustainablepartner_id = (int)$this->request->get['sustainablepartner_id'];

        if ($sustainablepartner_id) {
            $result = $this->model_sustainablepartner->deleteSustainableImage($sustainablepartner_id);
            if (isset($result['success'])) {
                $json = ['success' => true];
            } else {
                $json = ['error' => $result['error']];
            }
        } else {
            $json = ['error' => 'Invalid Sustainable Partner ID.'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }
}