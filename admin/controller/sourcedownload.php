<?php
class ControllerSourcedownload extends Controller
{
	private $error = array();

	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Source Code Download');
		$this->load_model('sourcedownload');
		$this->getList();
	}

	protected function getList()
	{
		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Source Code Download',
			'href' => $this->link('sourcedownload', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('sourcedownload/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('sourcedownload/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_sourcedownload->getSourceCodes();
		foreach ($results as $result) {
			$data['sources'][] = array(
				'source_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'status'     => $result['status'],
				'edit'        => $this->link('sourcedownload/edit', 'token=' . $this->session->data['token'] . '&source_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('sourcedownload/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}

		$data['main_sources'] = $results;
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
		$data['sort_status'] = $this->link('sourcedownload', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('sourcedownload', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxsourcestatus'] = $this->link('sourcedownload/ajaxsourcestatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$sourcesTotal        = $this->model_sourcedownload->getTotalSourceCodes();
		$pagination         = new Pagination();
		$pagination->total  = $sourcesTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=sourcedownload/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($sourcesTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sourcesTotal - $this->config->get('config_limit_admin'))) ? $sourcesTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sourcesTotal, ceil($sourcesTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=sourcedownload';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/sourcedownload/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	
	public function add()
	{
		$this->document->setTitle('Admin - Source Code Download');

		$this->load_model('sourcedownload');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_sourcedownload->addSourceCode($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Source Code!');

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
			$this->response->redirect($this->link('sourcedownload', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'sourcedownload')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
		foreach ($data['source_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
		}


         // PDF file validation
        // if (!$this->request->get['source_id']) {
        //     if (empty($_FILES["file"]["name"])) {
        //         $this->error['file'] = 'Please upload PDF file';
        //     } elseif ($_FILES["file"]["type"] != 'application/pdf') {
        //         $this->error['file'] = 'Only PDF files are allowed';
        //     }
        // } else {
        //     if (empty($this->request->post['existing_file']) && empty($_FILES["existing_file"]["name"])) {
        //         $this->error['file'] = 'Please upload PDF file';
        //     } elseif (!empty($_FILES["file"]["name"]) && $_FILES["file"]["type"] != 'application/pdf') {
        //         $this->error['file'] = 'Only PDF files are allowed';
        //     }
        // }

			// PDF file validation with 13MB limit
			if (!empty($_FILES["file"]["name"])) {

				// Check for upload errors first
				if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
					switch ($_FILES["file"]["error"]) {
						case UPLOAD_ERR_INI_SIZE:
						case UPLOAD_ERR_FORM_SIZE:
							$this->error['file'] = 'File size must be less than 13MB';
							break;
						case UPLOAD_ERR_PARTIAL:
							$this->error['file'] = 'The file was only partially uploaded.';
							break;
						case UPLOAD_ERR_NO_FILE:
							$this->error['file'] = 'Please upload PDF file.';
							break;
						default:
							$this->error['file'] = 'Unexpected upload error. Please try again.';
					}
				} else {
					// Then validate type & size
					$allowed_types = ['application/pdf', 'application/x-pdf', 'binary/octet-stream'];
					$file_extension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

					if ($_FILES["file"]["size"] > 13631488) {
						$this->error['file'] = 'File size must be less than 13MB';
					} elseif (!in_array($_FILES["file"]["type"], $allowed_types) || $file_extension != 'pdf') {
						$this->error['file'] = 'Only PDF files are allowed';
					}
				}
			}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
		
		 if ((utf8_strlen(trim($data['product_id'])) < 1)) {
            $this->error['product_id'][$language_id] = "Product field is missing";
        }
        // echo '<pre>'; print_r($this->error); exit;
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function edit()
	{
		$this->document->setTitle('Admin - Source Code Download');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('sourcedownload');
			$this->model_sourcedownload->editSourceCode($this->request->get['source_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Source Code!');
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
			$this->response->redirect($this->link('sourcedownload', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	
	public function delete()
	{
		$this->load_model('sourcedownload');
		if ($this->request->post['source_id'] && $this->validateDelete()) {
			$this->model_sourcedownload->deleteSourceCode($this->request->post['source_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Source Code!');
			$this->response->redirect($this->link('sourcedownload', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}
	
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['source_id']) ? 'Add New Source Code' : 'Edit Source Code';
		$data['file_feild_required'] = !isset($this->request->get['source_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['source_id']) ? "no" : "yes";
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
		if (!isset($this->request->get['source_id'])) {
			$data['action'] = $this->link('sourcedownload/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('sourcedownload/edit', 'token=' . $this->session->data['token'] . '&source_id=' . $this->request->get['source_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('sourcedownload', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['source_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('sourcedownload');
			$source_info = $this->model_sourcedownload->getSourceCode($this->request->get['source_id']);
		}
		$data['single_source'] = $source_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($source_info)) {
			$data['sort_order'] = $source_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($source_info)) {
			$data['status'] = $source_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['file'])) {
            $data['file'] = $this->request->post['file'];
        } elseif (!empty($source_info)) {
            $data['file'] = $source_info['file'];
        } else {
            $data['file'] = '';
        }		
		if (isset($this->request->post['product_id'])) {
            $data['product_id'] = $this->request->post['product_id'];
        } elseif (!empty($source_info)) {
            $data['product_id'] = $source_info['product_id'];
        } else {
            $data['product_id'] = '';
        }
		if (isset($this->request->post['source_description'])) {
			$data['source_description'] = $this->request->post['source_description'];
		} elseif (isset($this->request->get['source_id'])) {
			$this->load_model('sourcedownload');
			$data['source_description'] = $this->model_sourcedownload->getSourceDescription($this->request->get['source_id']);
		} else {
			$data['source_description'] = array();
		}
		$this->load_model('sourcedownload');
        $data['products'] = $this->model_sourcedownload->getProducts();
		$this->data = $data;
		$this->template = 'modules/sourcedownload/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxsourcestatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('sourcedownload');
			$source_id = $this->request->post['source_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_sourcedownload->updateSourceStatus($source_id, $status);
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
		if (!$this->user->hasPermission('modify', 'sourcedownload')) {
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