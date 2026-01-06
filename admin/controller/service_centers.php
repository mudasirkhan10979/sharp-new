<?php
class ControllerServiceCenters extends Controller
{
    private $error = array();
    
    public function index()
    {

        $data = $this->language->getAll();
        $this->document->setTitle('Admin - Service Centers');
        $this->load_model('service_centers');
        $this->getList();
    }
    
    protected function getList()
    {
        $data = $this->language->getAll();
        $url = '';
        
        if (isset($this->request->get['page'])) {
            $page = (int) $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['add'] = $this->link('service_centers/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->link('service_centers/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $filter_data = array(
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );
        
        $results = $this->model_service_centers->getServiceCenters($filter_data);
        foreach ($results as $result) {
            $data['service_centers'][] = array(
                'service_center_id' => $result['service_center_id'],
                'service_center_name' => $result['service_center_name'],
                'country_name' => $result['country_name'],
                'department' => isset($result['department']) ? $result['department'] : '',
                'landline' => $result['landline'],
                'publish' => $result['publish'],
                'edit' => $this->link('service_centers/edit', 'token=' . $this->session->data['token'] . '&service_center_id=' . $result['service_center_id'] . $url, 'SSL'),
                'delete' => $this->link('service_centers/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
            );
        }

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

        $service_center_total = $this->model_service_centers->getTotalServiceCenters();
        
        $pagination = new Pagination();
        $pagination->total = $service_center_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->link('service_centers', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
        $data['pagination'] = $pagination->render();
        $data['results'] = sprintf($this->language->get('text_pagination'), ($service_center_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($service_center_total - $this->config->get('config_limit_admin'))) ? $service_center_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $service_center_total, ceil($service_center_total / $this->config->get('config_limit_admin')));
        
        $data['ajaxdservicecenterstatus'] = $this->link('service_centers/ajaxdservicecenterstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['token'] = $this->session->data['token'];
        
        $this->data = $data;
        $this->template = 'modules/servicecenters/list.tpl';
        $this->zones = array('header', 'columnleft', 'footer');
        $this->response->setOutput($this->render());
    }
    
    public function add()
    {
        $this->document->setTitle('Admin - Service Center');
        $this->load_model('service_centers');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_service_centers->addServiceCenter($this->request->post);
            $this->session->data['success'] = 'Success: You have added a new Service Center!';
            
            $url = '';
            $this->response->redirect($this->link('service_centers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        } 
        
        $this->getForm();
    }
    
    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'service_centers')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }
        
        $data = $this->request->post;
        
        if (empty($data['sr'])) {
            $this->error['sr'] = 'SR Number is required!';
        }

        if (empty($data['email'])) {
            $this->error['email'] = 'Email is required!';
        }

        if (empty($data['phone'])) {
            $this->error['phone'] = 'Phone is required!';
        }
        
        if (empty($data['country_id'])) {
            $this->error['country_id'] = 'Country is required!';
        }

       if (empty($data['department'])) {
            $this->error['department'] = 'Department is required!';
        }
        
        if (empty($data['landline'])) {
            $this->error['landline'] = 'Contact Number is required!';
        }
        
        foreach ($data['service_center_description'] as $language_id => $value) {
            if (empty(trim($value['service_center_name']))) {
                $this->error['service_center_name'][$language_id] = "Service Center Name is required";
            } 
            
            if (empty(trim($value['address']))) {
                $this->error['address'][$language_id] = "Address is required";
            }  
        }  
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = 'Warning: Please check the form carefully for errors!';
        }
        
        return !$this->error;
    }
    
    public function edit()
    {
        $this->document->setTitle('Admin - Service Center');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->load_model('service_centers');
            $this->model_service_centers->editServiceCenter($this->request->get['service_center_id'], $this->request->post);
            $this->session->data['success'] = 'Success: You have modified Service Center!';
            
            $url = '';
            $this->response->redirect($this->link('service_centers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        } 
        
        $this->getForm();
    }
    
    public function delete()
    {
        $this->load_model('service_centers');
        
        if (isset($this->request->post['service_center_id']) && $this->validateDelete()) {
            $this->model_service_centers->deleteServiceCenter($this->request->post['service_center_id']);
            $this->session->data['success'] = 'Success: You have deleted Service Center!';
            $this->response->redirect($this->link('service_centers', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->getList();
    }
    
    protected function getForm()
    {
        $data = $this->language->getAll();
        $data['text_form'] = !isset($this->request->get['service_center_id']) ? 'Add New Service Center' : 'Edit Service Center';
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['sr'])) {
            $data['error_sr'] = $this->error['sr'];
        } else {
            $data['error_sr'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        if (isset($this->error['phone'])) {
            $data['error_phone'] = $this->error['phone'];
        } else {
            $data['error_phone'] = '';
        }
        
        if (isset($this->error['country_id'])) {
            $data['error_country_id'] = $this->error['country_id'];
        } else {
            $data['error_country_id'] = '';
        }

        if (isset($this->error['department'])) {
            $data['error_department'] = $this->error['department'];
        } else {
            $data['error_department'] = '';
        }
        
        if (isset($this->error['landline'])) {
            $data['error_landline'] = $this->error['landline'];
        } else {
            $data['error_landline'] = '';
        }
        
        if (isset($this->error['service_center_name'])) {
            $data['error_service_center_name'] = $this->error['service_center_name'];
        } else {
            $data['error_service_center_name'] = array();
        }
        
        if (isset($this->error['address'])) {
            $data['error_address'] = $this->error['address'];
        } else {
            $data['error_address'] = array();
        }
        
        $url = '';

        if (! isset($this->request->get['service_center_id'])) {
            $data['action'] = $this->link('service_centers/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->link('service_centers/edit', 'token=' . $this->session->data['token'] . '&service_center_id=' . $this->request->get['service_center_id'] . $url, 'SSL');
		}
        
        $data['cancel'] = $this->link('service_centers', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['service_center_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
             $this->load_model('service_centers');
            $service_center_info = $this->model_service_centers->getServiceCenter($this->request->get['service_center_id']);
        }
        $this->load_model('service_centers');
        $data['countries'] = $this->model_service_centers->getCountries();
        $db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);

        if (isset($this->request->post['sr'])) {
            $data['sr'] = $this->request->post['sr'];
        } elseif (!empty($service_center_info)) {
            $data['sr'] = $service_center_info['sr'];
        } else {
            $data['sr'] = '';
        }

        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } elseif (!empty($service_center_info)) {
            $data['email'] = $service_center_info['email'];
        } else {
            $data['email'] = '';
        }

        if (isset($this->request->post['phone'])) {
            $data['phone'] = $this->request->post['phone'];
        } elseif (!empty($service_center_info)) {
            $data['phone'] = $service_center_info['phone'];
        } else {
            $data['phone'] = '';
        }
        
        if (isset($this->request->post['country_id'])) {
            $data['country_id'] = $this->request->post['country_id'];
        } elseif (!empty($service_center_info)) {
            $data['country_id'] = $service_center_info['country_id'];
        } else {
            $data['country_id'] = '';
        }

        if (isset($this->request->post['department'])) {
            $data['department'] = $this->request->post['department'];
        } elseif (!empty($service_center_info)) {
            $data['department'] = isset($service_center_info['department']) ? $service_center_info['department'] : '';
        } else {
            $data['department'] = '';
        }
        
        if (isset($this->request->post['landline'])) {
            $data['landline'] = $this->request->post['landline'];
        } elseif (!empty($service_center_info)) {
            $data['landline'] = $service_center_info['landline'];
        } else {
            $data['landline'] = '';
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($service_center_info)) {
            $data['sort_order'] = $service_center_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }
        
        if (isset($this->request->post['publish'])) {
            $data['publish'] = $this->request->post['publish'];
        } elseif (!empty($service_center_info)) {
            $data['publish'] = $service_center_info['publish'];
        } else {
            $data['publish'] = 1;
        }
        
        if (isset($this->request->post['service_center_description'])) {
            $data['service_center_description'] = $this->request->post['service_center_description'];
        } elseif (isset($this->request->get['service_center_id'])) {
            $data['service_center_description'] = $this->model_service_centers->getServiceCenterDescriptions($this->request->get['service_center_id']);
        } else {
            $data['service_center_description'] = array();
        }
        
        $this->data = $data;
        $this->template = 'modules/servicecenters/form.tpl';
        $this->zones = array('header', 'columnleft', 'footer');
        $this->response->setOutput($this->render());
    }
    
    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'service_centers')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }
        
        return !$this->error;
    }
    
    public function ajaxdservicecenterstatus()
    {
        $json = array();
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load_model('service_centers');
            $service_center_id = $this->request->post['service_center_id'];
            $status = $this->request->post['status'];
            
            $this->model_service_centers->updateServiceCenterStatus($service_center_id, $status);
            $json['success'] = true;
            
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }
}