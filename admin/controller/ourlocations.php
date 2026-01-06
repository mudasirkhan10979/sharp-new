<?php
class ControllerOurlocations extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Our Locations');
		$this->load_model('ourlocations');
		$this->getList();
	}
	protected function getList()
	{
		$data                  = $this->language->getAll();
		$url                   = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Our Locations',
			'href' => $this->link('ourlocations', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('ourlocations/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('ourlocations/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['users'] = array();
		$filter_data   = array(
			'order' => $order,
		);
		$results       = $this->model_ourlocations->getLocations($filter_data);
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'   => $result['id'], 
				'title'   	  => $result['title'], 
				'publish'     => $result['publish'],
				'edit'        => $this->link('ourlocations/edit', 'token=' . $this->session->data['token'] . '&location_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('ourlocations/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['sort_status']     = $this->link('ourlocations', 'token=' . $this->session->data['token'] . '&sort=publish' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('ourlocations', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
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
		$data['ajaxdourlocationstatus'] = $this->link('ourlocations/ajaxdourlocationstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$sliderTotal        = $this->model_ourlocations->getTotalLocations();
		$pagination         = new Pagination();
		$pagination->total  = $sliderTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=ourlocations/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($sliderTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sliderTotal - $this->config->get('config_limit_admin'))) ? $sliderTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sliderTotal, ceil($sliderTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=ourlocations';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/ourlocations/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Our Location');

		$this->load_model('ourlocations');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_ourlocations->addLocation($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Our Location!');

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
			$this->response->redirect($this->link('ourlocations', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'ourlocations')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post; 

		if (trim($this->request->post['phone']) == '') {
			$this->error['phone'] = 'Phone field is missing';
		} elseif (!preg_match('/^\+?\d+$/', $this->request->post['phone'])) {
			$this->error['phone'] = 'Phone number should contain only digits';
		}

	
		if (trim($this->request->post['email']) == '') {
			$this->error['email'] = 'Email field is missing';
		} elseif (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = 'Please enter a valid email address';
		}
		if (trim($this->request->post['address']) == '') {
			$this->error['address'] =  'Address field is missing';
		}
		if (trim($this->request->post['longitude']) == '') {
			$this->error['longitude'] =  'Longitude field is missing';
		}
		if (trim($this->request->post['latitude']) == '') {
			$this->error['latitude'] =  'Latitude field is missing';
		}
		foreach ($data['location_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title is missing";
			} 
			// if ((utf8_strlen(trim($value['description'])) < 1)) {
			// 	$this->error['description'][$language_id] = "Description is missing";
			// }   
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
		$this->document->setTitle('Admin - Our Location');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('ourlocations');
			$this->model_ourlocations->editLocation($this->request->get['location_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Our Location!');
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
			$this->response->redirect($this->link('ourlocations', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} 
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('ourlocations');
		if($this->request->post['location_id'] && $this->validateDelete()) {
			$this->model_ourlocations->deleteLocation($this->request->post['location_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Our Location!');
			$this->response->redirect($this->link('ourlocations', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}
	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = ! isset($this->request->get['location_id']) ? 'Add New Our Location' : 'Edit Our Location';
		$data['img_feild_required'] = ! isset($this->request->get['location_id']) ? "required" : "";
		$data['is_edit']            = ! isset($this->request->get['location_id']) ? "no" : "yes";
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
		if (isset($this->error['phone'])) {
			$data['error_phone'] = $this->error['phone'];
		} else {
			$data['error_phone'] = '';
		}
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		if (isset($this->error['longitude'])) {
			$data['error_longitude'] = $this->error['longitude'];
		} else {
			$data['error_longitude'] = '';
		}
		if (isset($this->error['latitude'])) {
			$data['error_latitude'] = $this->error['latitude'];
		} else {
			$data['error_latitude'] = '';
		}

		$url = '';

		if (! isset($this->request->get['location_id'])) {
			$data['action'] = $this->link('ourlocations/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('ourlocations/edit', 'token=' . $this->session->data['token'] . '&location_id=' . $this->request->get['location_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('ourlocations', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['location_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('ourlocations');
			$location_info = $this->model_ourlocations->getLocation($this->request->get['location_id']);
		}
		$data['single_location'] = $location_info;
		$db_filter             = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (! empty($location_info)) {
			$data['sort_order'] = $location_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (! empty($location_info)) {
			$data['publish'] = $location_info['publish'];
		} else {
			$data['publish'] = true;
		}  
		if (isset($this->request->post['longitude'])) {
			$data['longitude'] = $this->request->post['longitude'];
		} elseif (!empty($location_info)) {
			$data['longitude'] = $location_info['longitude'];
		} else {
			$data['longitude'] = '';
		}
		if (isset($this->request->post['latitude'])) {
			$data['latitude'] = $this->request->post['latitude'];
		} elseif (!empty($location_info)) {
			$data['latitude'] = $location_info['latitude'];
		} else {
			$data['latitude'] = '';
		}
		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} elseif (!empty($location_info)) {
			$data['phone'] = $location_info['phone'];
		} else {
			$data['phone'] = '';
		}
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($location_info)) {
			$data['email'] = $location_info['email'];
		} else {
			$data['email'] = '';
		}
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($location_info)) {
			$data['address'] = $location_info['address'];
		} else {
			$data['address'] = '';
		}
		if (isset($this->request->post['location_description'])) {
			$data['location_description'] = $this->request->post['location_description'];
		} elseif (isset($this->request->get['location_id'])) {
			$data['location_description'] = $this->model_ourlocations->getLocationDescription($this->request->get['location_id']);
		} else {
			$data['location_description'] = array();
		}  
		$this->data     = $data;
		$this->template = 'modules/ourlocations/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'ourlocations')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}
	public function ajaxdourlocationstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		$this->load_model('ourlocations');
		$location_id = $this->request->post['location_id'];
		$status = $this->request->post['status'];
		$this->model_ourlocations->updatelocationStatus($location_id, $status);
		$json['success'] = true;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}
	
}
