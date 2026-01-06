<?php
class ControllerAttributeValue extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle('Admin - Attributes Values');
        $this->load_model('attributevalue');
        $this->getList();
    }

    protected function getList()
    {
        $data = $this->language->getAll();
        $url = '';
        
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => 'Home',
            'href' => $this->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => 'Attributes Values',
            'href' => $this->link('attributevalue', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (isset($this->request->get['page'])) {
            $page = (int) $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['add'] = $this->link('attributevalue/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->link('attributevalue/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['attribute_values'] = array();
        $filter_data = array(
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $results = $this->model_attributevalue->getAttributeValues($filter_data);
        
        foreach ($results as $result) {
            $data['attribute_values'][] = array(
                'attribute_value_id' => $result['id'],
                'attribute_key'      => $result['attribute_key'],
                'attribute_name'     => $result['attribute_name'],
                'title'              => $result['title'],
                'status'             => $result['status'],
                'sort_order'         => $result['sort_order'],
                'added_date'         => $result['added_date'],
                'edit'               => $this->link('attributevalue/edit', 'token=' . $this->session->data['token'] . '&attribute_value_id=' . $result['id'] . $url, 'SSL'),
                'delete'             => $this->link('attributevalue/delete', 'token=' . $this->session->data['token'] . '&attribute_value_id=' . $result['id'] . $url, 'SSL')
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

        $attributeValuesTotal = $this->model_attributevalue->getTotalAttributeValues();
        $pagination = new Pagination();
        $pagination->total = $attributeValuesTotal;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->link('attributevalue', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
        $data['pagination'] = $pagination->render();
        $data['results'] = sprintf($this->language->get('text_pagination'), ($attributeValuesTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($attributeValuesTotal - $this->config->get('config_limit_admin'))) ? $attributeValuesTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $attributeValuesTotal, ceil($attributeValuesTotal / $this->config->get('config_limit_admin')));
        
        $data['ajaxattributevaluestatus'] = $this->link('attributevalue/ajaxattributevaluestatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['token'] = $this->session->data['token'];
        
        $this->data = $data;
        $this->template = 'modules/attributevalue/list.tpl';
        $this->zones = array('header', 'columnleft', 'footer');
        $this->response->setOutput($this->render());
    }

    public function add()
    {
        $this->document->setTitle('Admin - Add Attribute Value');
        $this->load_model('attributevalue');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_attributevalue->addAttributeValue($this->request->post);
            $this->session->data['success'] = 'Success: You have added a new Attribute Value!';
            $this->response->redirect($this->link('attributevalue', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle('Admin - Edit Attribute Value');
        $this->load_model('attributevalue');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_attributevalue->editAttributeValue($this->request->get['attribute_value_id'], $this->request->post);
            $this->session->data['success'] = 'Success: You have modified Attribute Value!';
            $this->response->redirect($this->link('attributevalue', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $this->load_model('attributevalue');
        
        if (isset($this->request->post['attribute_value_id']) && $this->validateDelete()) {
            $this->model_attributevalue->deleteAttributeValue($this->request->post['attribute_value_id']);
            $this->session->data['success'] = 'Success: You have deleted Attribute Value!';
        }
        $this->response->redirect($this->link('attributevalue', 'token=' . $this->session->data['token'], 'SSL'));
    }

    protected function getForm()
    {
        $data = $this->language->getAll();
        $data['text_form'] = !isset($this->request->get['attribute_value_id']) ? 'Add New Attribute Value' : 'Edit Attribute Value';

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

        if (isset($this->error['attribute_id'])) {
            $data['error_attribute_id'] = $this->error['attribute_id'];
        } else {
            $data['error_attribute_id'] = '';
        }

        if (isset($this->error['attribute_key'])) {
            $data['error_attribute_key'] = $this->error['attribute_key'];
        } else {
            $data['error_attribute_key'] = '';
        }

        $url = '';
        if (!isset($this->request->get['attribute_value_id'])) {
            $data['action'] = $this->link('attributevalue/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->link('attributevalue/edit', 'token=' . $this->session->data['token'] . '&attribute_value_id=' . $this->request->get['attribute_value_id'] . $url, 'SSL');
        }
        $data['cancel'] = $this->link('attributevalue', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['attribute_value_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $attribute_value_info = $this->model_attributevalue->getAttributeValue($this->request->get['attribute_value_id']);
        }

        $this->load_model('language');
        $data['languages'] = $this->model_language->getLanguages(['order' => 'DESC']);

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($attribute_value_info)) {
            $data['sort_order'] = $attribute_value_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($attribute_value_info)) {
            $data['status'] = $attribute_value_info['status'];
        } else {
            $data['status'] = 1;
        }

        if (isset($this->request->post['attribute_id'])) {
            $data['attribute_id'] = $this->request->post['attribute_id'];
        } elseif (!empty($attribute_value_info)) {
            $data['attribute_id'] = $attribute_value_info['attribute_id'];
        } else {
            $data['attribute_id'] = '';
        }

        if (isset($this->request->post['attribute_key'])) {
            $data['attribute_key'] = $this->request->post['attribute_key'];
        } elseif (!empty($attribute_value_info)) {
            $data['attribute_key'] = $attribute_value_info['attribute_key'];
        } else {
            $data['attribute_key'] = '';
        }

        if (isset($this->request->post['attribute_value_description'])) {
            $data['attribute_value_description'] = $this->request->post['attribute_value_description'];
        } elseif (isset($this->request->get['attribute_value_id'])) {
            $data['attribute_value_description'] = $this->model_attributevalue->getAttributeValueDescription($this->request->get['attribute_value_id']);
        } else {
            $data['attribute_value_description'] = array();
        }

        // Load attributes for dropdown
        $this->load_model('attribute');
        $data['attributes'] = $this->model_attribute->getAttributes();

        $this->data = $data;
        $this->template = 'modules/attributevalue/form.tpl';
        $this->zones = array('header', 'columnleft', 'footer');
        $this->response->setOutput($this->render());
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'attributevalue')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }

        $data = $this->request->post;
        
        foreach ($data['attribute_value_description'] as $language_id => $value) {
         if (utf8_strlen(trim($value['title'])) < 1) {
            $this->error['title'][$language_id] = "Title field is required";
        }
        }

        if (utf8_strlen(trim($data['attribute_id'])) < 1) {
          $this->error['attribute_id'] = "Attribute field is required";
        }

        if (utf8_strlen(trim($data['attribute_key'])) < 1) {
          $this->error['attribute_key'] = "Attribute Key field is required";
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = 'Warning: Please check the form carefully for errors!';
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'attributevalue')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }
        return !$this->error;
    }

    public function ajaxattributevaluestatus()
    {
        $json = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load_model('attributevalue');
            $attribute_value_id = $this->request->post['attribute_value_id'];
            $status = $this->request->post['status'];
            $stat = $this->model_attributevalue->updateAttributeValueStatus($attribute_value_id, $status);
            
            if ($stat) {
                $json['success'] = true;
            } else {
                $json['success'] = false;
            }
        } else {
            $json['success'] = false;
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
?>