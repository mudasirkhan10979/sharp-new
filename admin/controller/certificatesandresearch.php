<?php
class ControllerCertificatesAndResearch extends Controller
{

	private $error = array();
	public function index()
	{
		// exit('here');
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Certificates & Research');
		$this->load_model('certificatesandresearch');
		$this->getList();
	}
	protected function getList()
	{
		$data = $this->language->getAll();
		$url  = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('certificatesandresearch', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('certificatesandresearch/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('certificatesandresearch/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['users'] = array();
		$filter_data   = array(
			'order' => $order,
		);
		$results       = $this->model_certificatesandresearch->getCertificatesAndResearchs($filter_data);
		foreach ($results as $result) {
			$data['certificatesandresearch'][] = array(
				'certificatesandresearch_id'   => $result['id'],
				'sort_order'  => $result['sort_order'],
				'title'   	  => $result['title'],
				'image'       => $result['image'],
				'status'     => $result['status'],
				'edit'        => $this->link('certificatesandresearch/edit', 'token=' . $this->session->data['token'] . '&certificatesandresearch_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('certificatesandresearch/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_certificatesandresearch'] = $results;
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
		$data['sort_status']     = $this->link('certificatesandresearch', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('certificatesandresearch', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$certificatesandresearchTotal        = $this->model_certificatesandresearch->getTotalCertificatesAndResearchs();
		$pagination         = new Pagination();
		$pagination->total  = $certificatesandresearchTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=certificatesandresearch/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($certificatesandresearchTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($certificatesandresearchTotal - $this->config->get('config_limit_admin'))) ? $certificatesandresearchTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $certificatesandresearchTotal, ceil($certificatesandresearchTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=certificatesandresearch';
		$data['token']      = $this->session->data['token'];
		$data['ajaxcertificatesandresearchstatus'] = $this->link('certificatesandresearch/ajaxcertificatesandresearchstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data         = $data;
		$this->template     = 'modules/certificatesandresearch/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Certificates & Research');

		$this->load_model('certificatesandresearch');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_certificatesandresearch->addCertificatesAndResearch($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Certificates & Research!');

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
			$this->response->redirect($this->link('certificatesandresearch', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	}
	protected function validateForm()
	{
		$data = $this->request->post;
		foreach ($data['certificatesandresearch_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			} 
		}
		if (!$this->request->get['certificatesandresearch_id']) {
			if ($_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload Image';
			}
		}
		else
		{
			if ($data["image"] == "" && $_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload Image';
			}
		}

		if ($this->request->post['date'] == '') {
			$this->error['date'] =  "Date field is missing";
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
		if ($this->user->hasPermission('modify', 'certificatesandresearch')) {
			$this->document->setTitle('Admin - Certificates & Research');
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->load_model('certificatesandresearch');
				$this->model_certificatesandresearch->editCertificatesAndResearch($this->request->get['certificatesandresearch_id'], $this->request->post);
				$this->session->data['success'] = $this->language->get('Success: You have modified Certificates & Research!');
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
				$this->response->redirect($this->link('certificatesandresearch', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
		$this->load_model('certificatesandresearch');
		if (isset($this->request->post['certificatesandresearch_id']) && $this->validateDelete()) {
			$this->model_certificatesandresearch->deleteCertificatesAndResearch($this->request->post['certificatesandresearch_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Certificates & Research!');
			$this->response->redirect($this->link('certificatesandresearch', 'token=' . $this->session->data['token'], 'SSL'));
		} 
		$this->getList();
	}

	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = ! isset($this->request->get['certificatesandresearch_id']) ? 'Add New Certificates & Research' : 'Edit Certificates & Research';
		$data['img_feild_required'] = ! isset($this->request->get['certificatesandresearch_id']) ? "required" : "";
		$data['is_edit']            = ! isset($this->request->get['certificatesandresearch_id']) ? "no" : "yes";
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
		if (! isset($this->request->get['certificatesandresearch_id'])) {
			$data['action'] = $this->link('certificatesandresearch/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('certificatesandresearch/edit', 'token=' . $this->session->data['token'] . '&certificatesandresearch_id=' . $this->request->get['certificatesandresearch_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('certificatesandresearch', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['certificatesandresearch_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('certificatesandresearch');
			$certificatesandresearch_info = $this->model_certificatesandresearch->getCertificatesAndResearch($this->request->get['certificatesandresearch_id']);
		}
		$data['single_certificatesandresearch'] = $certificatesandresearch_info;
		$db_filter             = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);

		if (isset($this->request->post['certificatesandresearch_id'])) {
			$data['certificatesandresearch_id'] = $this->request->post['certificatesandresearch_id'];
		} elseif (!empty($certificatesandresearch_info)) {
			$data['certificatesandresearch_id'] = $certificatesandresearch_info['id'];
		} else {
			$data['certificatesandresearch_id'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (! empty($certificatesandresearch_info)) {
			$data['sort_order'] = $certificatesandresearch_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (! empty($certificatesandresearch_info)) {
			$data['status'] = $certificatesandresearch_info['status'];
		} else {
			$data['status'] = true;
		} 
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($certificatesandresearch_info)) {
			$data['image'] = $certificatesandresearch_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['date'])) {
			$data['date'] = $this->request->post['date'];
		} elseif (!empty($certificatesandresearch_info)) {
			$data['date'] = date('Y-m-d', strtotime($certificatesandresearch_info['date']));
		} else {
			$data['date'] = '';
		}
		if (isset($this->request->post['certificatesandresearch_description'])) {
			$data['certificatesandresearch_description'] = $this->request->post['certificatesandresearch_description'];
		} elseif (isset($this->request->get['certificatesandresearch_id'])) {
			$data['certificatesandresearch_description'] = $this->model_certificatesandresearch->getCertificatesAndResearchDescription($this->request->get['certificatesandresearch_id']);
		} else {
			$data['certificatesandresearch_description'] = array();
		} 
		 $data['deleteImage'] = $this->link('certificatesandresearch/deleteImage', 'token=' . $this->session->data['token'], 'SSL');
		$this->data     = $data;
		$this->template = 'modules/certificatesandresearch/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	
	public function ajaxcertificatesandresearchstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('certificatesandresearch');
			$certificatesandresearch_id = $this->request->post['certificatesandresearch_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_certificatesandresearch->updateCertificatesAndResearchStatus($certificatesandresearch_id, $status);
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
		if (!$this->user->hasPermission('modify', 'certificatesandresearch')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}

	public function deleteImage()
    {
        $this->load_model('certificatesandresearch');
        $certificatesandresearch_id = (int)$this->request->get['certificatesandresearch_id'];

        if ($certificatesandresearch_id) {
            $result = $this->model_certificatesandresearch->deleteCertificatesAndResearchImage($certificatesandresearch_id);
            if (isset($result['success'])) {
                $json = ['success' => true];
            } else {
                $json = ['error' => $result['error']];
            }
        } else {
            $json = ['error' => 'Invalid Certificatesandresearch ID.'];
        }

        header('Content-Type: application/json');
        echo json_encode($json);
        exit;
    }

}
