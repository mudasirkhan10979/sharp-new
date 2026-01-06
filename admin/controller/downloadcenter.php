<?php
class ControllerDownloadcenter extends Controller
{
	private $error = array();

	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Download Center');
		$this->load_model('downloadcenter');
		$this->getList();
	}

	protected function getList()
	{
		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Download Center',
			'href' => $this->link('downloadcenter', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('downloadcenter/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('downloadcenter/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_downloadcenter->getDownloads($filter_data);
		foreach ($results as $result) {
			$data['downloads'][] = array(
				'download_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'status'     => $result['status'],
				'edit'        => $this->link('downloadcenter/edit', 'token=' . $this->session->data['token'] . '&download_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('downloadcenter/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}

		$data['main_downloads'] = $results;
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
		$data['sort_status'] = $this->link('downloadcenter', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('downloadcenter', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxdownloadstatus'] = $this->link('downloadcenter/ajaxdownloadstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$downloadsTotal        = $this->model_downloadcenter->getTotalDownloads();
		$pagination         = new Pagination();
		$pagination->total  = $downloadsTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=downloadcenter/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($downloadsTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($downloadsTotal - $this->config->get('config_limit_admin'))) ? $downloadsTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $downloadsTotal, ceil($downloadsTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=downloadcenter';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/downloadcenter/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Download Center');

		$this->load_model('downloadcenter');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_downloadcenter->addDownload($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Download Center!');

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
			$this->response->redirect($this->link('downloadcenter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'downloadcenter')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
		foreach ($data['download_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['description'])) < 1)) {
				$this->error['description'][$language_id] = "Description field is missing";
			}
		}

		// PDF file validation
		if (!$this->request->get['download_id']) {
			if (empty($_FILES["file"]["name"])) {
				$this->error['file'] = 'Please upload PDF file';
			} elseif ($_FILES["file"]["type"] != 'application/pdf') {
				$this->error['file'] = 'Only PDF files are allowed';
			}
		} else {
			if (!empty($_FILES["file"]["name"])) {
				if ($_FILES["file"]["type"] != 'application/pdf') {
					$this->error['file'] = 'Only PDF files are allowed';
				}
			}
		}

		 if ((utf8_strlen(trim($data['product_id'])) < 1)) {
            $this->error['product_id'][$language_id] = "Product field is missing";
        }

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
        // echo "<pre>"; print_r($this->error); exit;
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function edit()
	{
		$this->document->setTitle('Admin - Download Center');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('downloadcenter');
			$this->model_downloadcenter->editDownload($this->request->get['download_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Download Center!');
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
			$this->response->redirect($this->link('downloadcenter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('downloadcenter');
		if ($this->request->post['download_id'] && $this->validateDelete()) {
			$this->model_downloadcenter->deleteDownload($this->request->post['download_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Download Center!');
			$this->response->redirect($this->link('downloadcenter', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['download_id']) ? 'Add New Download Center' : 'Edit Download Center';
		$data['img_feild_required'] = !isset($this->request->get['download_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['download_id']) ? "no" : "yes";
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
		if (isset($this->error['file'])) {
			$data['error_file'] = $this->error['file'];
		} else {
			$data['error_file'] = '';
		}
		if (isset($this->error['product_id'])) {
			$data['error_product_id'] = $this->error['product_id'];
		} else {
			$data['error_product_id'] = '';
		}

		$url = '';
		if (!isset($this->request->get['download_id'])) {
			$data['action'] = $this->link('downloadcenter/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('downloadcenter/edit', 'token=' . $this->session->data['token'] . '&download_id=' . $this->request->get['download_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('downloadcenter', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['download_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('downloadcenter');
			$download_info = $this->model_downloadcenter->getDownload($this->request->get['download_id']);
		}
		$data['single_download'] = $download_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($download_info)) {
			$data['sort_order'] = $download_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($download_info)) {
			$data['status'] = $download_info['status'];
		} else {
			$data['status'] = true;
		}
		// if (isset($this->request->post['image'])) {
		// 	$data['image'] = $this->request->post['image'];
		// } elseif (!empty($download_info)) {
		// 	$data['image'] = $download_info['image'];
		// } else {
		// 	$data['image'] = '';
		// }
		 if (isset($this->request->post['file'])) {
            $data['file'] = $this->request->post['file'];
        } elseif (!empty($download_info)) {
            $data['file'] = $download_info['file'];
        } else {
            $data['file'] = '';
        }
		
		if (isset($this->request->post['product_id'])) {
            $data['product_id'] = $this->request->post['product_id'];
        } elseif (!empty($download_info)) {
            $data['product_id'] = $download_info['product_id'];
        } else {
            $data['product_id'] = '';
        }
		if (isset($this->request->post['download_description'])) {
			$data['download_description'] = $this->request->post['download_description'];
		} elseif (isset($this->request->get['download_id'])) {
			$data['download_description'] = $this->model_downloadcenter->getDownloadDescription($this->request->get['download_id']);
		} else {
			$data['download_description'] = array();
		}
		 $this->load_model('downloadcenter');
        $data['products'] = $this->model_downloadcenter->getProducts();
		$this->data = $data;
		$this->template = 'modules/downloadcenter/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxdownloadstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('downloadcenter');
			$download_id = $this->request->post['download_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_downloadcenter->updateDownloadStatus($download_id, $status);
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
		if (!$this->user->hasPermission('modify', 'downloadcenter')) {
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