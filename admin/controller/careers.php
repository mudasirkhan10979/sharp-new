<?php
class ControllerCareers extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Careers');
		$this->load_model('careers');
		$this->getList();
	}
	public function add()
	{
		$this->document->setTitle('Admin - Career');
		$this->load_model('careers');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_careers->addCareer($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new Career!');
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
			$this->response->redirect($this->link('careers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function edit()
	{
		$this->document->setTitle('Admin - Career');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('careers');
			$this->model_careers->editCareer($this->request->get['career_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Career!');
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
			$this->response->redirect($this->link('careers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{

		$this->load_model('careers');
		if ($this->request->post['career_id'] && $this->validateDelete()) {
			$this->model_careers->deleteCareer($this->request->post['career_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Career!');
			$this->response->redirect($this->link('careers', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}
	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = !isset($this->request->get['career_id']) ? 'Add New Career' : 'Edit Career';
		$data['img_feild_text']     = !isset($this->request->get['career_id']) ? "Career Background Image" : "Change Career Background Image";
		$data['img_feild_required'] = !isset($this->request->get['career_id']) ? "required" : "";
		$data['is_edit']            = !isset($this->request->get['career_id']) ? "no" : "yes";

		$this->load_model('careers');
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
		// if (isset($this->error['description'])) {
		// 	$data['error_description'] = $this->error['description'];
		// } else {
		// 	$data['error_description'] = '';
		// }
		if (isset($this->error['short_description'])) {
			$data['error_short_description'] = $this->error['short_description'];
		} else {
			$data['error_short_description'] = '';
		}
		if (isset($this->error['publish_date'])) {
			$data['error_publish_date'] = $this->error['publish_date'];
		} else {
			$data['error_publish_date'] = '';
		}
		if (isset($this->error['location_id'])) {
			$data['error_location_id'] = $this->error['location_id'];
		} else {
			$data['error_location_id'] = '';
		}
		if (isset($this->error['jobtype_id'])) {
			$data['error_jobtype_id'] = $this->error['jobtype_id'];
		} else {
			$data['error_jobtype_id'] = '';
		}
		if (isset($this->error['seo_url'])) {
			$data['error_seo_url'] = $this->error['seo_url'];
		} else {
			$data['error_seo_url'] = '';
		}
		$url                   = '';
		$data['breadcrumbs'][] = array(
			'text' => "Career",
			'href' => $this->link('careers', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (!isset($this->request->get['career_id'])) {
			$data['action'] = $this->link('careers/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('careers/edit', 'token=' . $this->session->data['token'] . '&career_id=' . $this->request->get['career_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('careers', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['career_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$career_info = $this->model_careers->getCareer($this->request->get['career_id']);
		}
		$data['single_slider'] = $career_info;
		$db_filter             = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['careers_description'])) {
			$data['careers_description'] = $this->request->post['careers_description'];
		} elseif (isset($this->request->get['career_id'])) {
			$data['careers_description'] = $this->model_careers->getCareerDescriptions($this->request->get['career_id']);
		} else {
			$data['careers_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($career_info)) {
			$data['sort_order'] = $career_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($career_info)) {
			$data['status'] = $career_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['publish_date'])) {
			$data['publish_date'] = $this->request->post['publish_date'];
		} elseif (!empty($career_info)) {
			$data['publish_date'] = date('Y-m-d', strtotime($career_info['publish_date']));
		} else {
			$data['publish_date'] = true;
		}
		if (isset($this->request->post['location_id'])) {
			$data['location_id'] = $this->request->post['location_id'];
		} elseif (!empty($career_info)) {
			$data['location_id'] = $career_info['location_id'];
		} else {
			$data['location_id'] = '';
		}
		if (isset($this->request->post['jobtype_id'])) {
			$data['jobtype_id'] = $this->request->post['jobtype_id'];
		} elseif (!empty($career_info)) {
			$data['jobtype_id'] = $career_info['jobtype_id'];
		} else {
			$data['jobtype_id'] = '';
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($career_info)) {
			$data['image'] = $career_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($career_info)) {
			$data['seo_url'] = $career_info['seo_url'];
		} else {
			$data['seo_url'] = false;
		}
		$data['locations'] = $this->model_careers->getLocations();
		$data['jobtypes'] = $this->model_careers->getJobTypes();
		$this->data        = $data;
		$this->template    = 'modules/careers/form.tpl';
		$this->zones       = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	protected function validateForm()
	{
		$data = $this->request->post;
		foreach ($data['careers_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title is missing";
			}
			// if ((utf8_strlen(trim($value['description'])) < 1)) {
			// 	$this->error['description'][$language_id] = "Description is missing";
			// }
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Short Description is missing";
			}
		}

		if ((utf8_strlen(trim($data['location_id'])) < 1)) {
			$this->error['location_id'][$language_id] = "Location is missing";
		}

		if (trim($this->request->post['publish_date']) < 1) {
			$this->error['publish_date'] = "Publish Date is missing";
		}
		
		if ((utf8_strlen(trim($data['jobtype_id'])) < 1)) {
			$this->error['jobtype_id'][$language_id] = "Job Type is missing";
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}

		$this->load_model('seourl');
		if ($data['seo_url'] != "") {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		}
		if ($keyword != '') {
			$this->load_model('seourl');
			$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);
			foreach ($seo_urls as $seo_url) {
				if (($this->request->get['career_id'] != $seo_url['slog_id'] || ($seo_url['slog'] != 'careers/detail'))) {
					$this->error['seo_url'] = "This url is already been used";
					break;
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	protected function getList()
	{
		$data                  = $this->language->getAll();
		$url                   = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Careers',
			'href' => $this->link('careers', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('careers/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('careers/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->session->data['delete_success'] = $this->language->get('Success: You have deleted the selected careers!');
		$data['users']  = array();
		$filter_data    = array(
			'order' => $order,
		);
		$results        = $this->model_careers->getCareers($filter_data);
		foreach ($results as $result) {
			$data['careers'][] = array(
				'career_id' => $result['id'],
				'title'     => $result['title'],
				'status'   => $result['status'],
				'edit'      => $this->link('careers/edit', 'token=' . $this->session->data['token'] . '&career_id=' . $result['id'] . $url, 'SSL'),
				'delete'    => $this->link('careers/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_slider'] = $results;
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
		// if (isset($this->session->data['delete_success'])) {
		// 	$data['delete_success'] = $this->session->data['delete_success'];
		// 	unset($this->session->data['delete_success']);
		// } else {
		// 	$data['delete_success'] = '';
		// }
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
		$data['sort_status']     = $this->link('careers', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('careers', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxcareersstatus'] = $this->link('careers/ajaxcareersstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$bannerTotal        = $this->model_careers->getTotalCareers();
		$pagination         = new Pagination();
		$pagination->total  = $bannerTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=careers/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=careers';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/careers/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	protected function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'careers')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}

	public function ajaxcareersstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		$this->load_model('careers');
		$career_id = $this->request->post['career_id'];
		$status = $this->request->post['status'];
		$this->model_careers->updateCareersStatus($career_id, $status);
		$json['success'] = true;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}
}