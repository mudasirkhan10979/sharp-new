<?php
class ControllerAttribute extends Controller
{
    private $error = array();

    public function index()
    {
        $data = $this->language->getAll();
        $this->document->setTitle('Admin - Attributes');
        $this->load_model('attribute');
        $this->getList();
    }

    protected function getList()
    {
        $data = $this->language->getAll();
        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => 'Attributes',
            'href' => $this->link('attribute', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (isset($this->request->get['page'])) {
            $page = (int) $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['add'] = $this->link('attribute/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->link('attribute/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['attributes'] = array();
        $filter_data = array(
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $results = $this->model_attribute->getAttributes($filter_data);
        
        foreach ($results as $result) {
            $data['attributes'][] = array(
                'attribute_id' => $result['id'],
                'category_id'  => $result['category_id'],
                'sort_order'   => $result['sort_order'],
                'status'       => $result['status'],
                'added_date'   => $result['added_date'],
                'title'        => $result['title'],
                'edit'         => $this->link('attribute/edit', 'token=' . $this->session->data['token'] . '&attribute_id=' . $result['id'] . $url, 'SSL'),
                'delete'       => $this->link('attribute/delete', 'token=' . $this->session->data['token'] . '&attribute_id=' . $result['id'] . $url, 'SSL')
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

        $attributesTotal = $this->model_attribute->getTotalAttributes();
        $pagination = new Pagination();
        $pagination->total = $attributesTotal;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = HTTP_HOST . '?controller=attribute&token=' . $this->session->data['token'] . $url . '&page={page}';
        
        $data['pagination'] = $pagination->render();
        $data['results'] = sprintf($this->language->get('text_pagination'), ($attributesTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($attributesTotal - $this->config->get('config_limit_admin'))) ? $attributesTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $attributesTotal, ceil($attributesTotal / $this->config->get('config_limit_admin')));
        
        $data['ajaxattributestatus'] = $this->link('attribute/ajaxattributestatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['token'] = $this->session->data['token'];
        
        $this->data = $data;
        $this->template = 'modules/attribute/list.tpl';
        $this->zones = array('header', 'columnleft', 'footer');
        $this->response->setOutput($this->render());
    }

    public function add()
    {
        $this->document->setTitle('Admin - Add Attribute');
        $this->load_model('attribute');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_attribute->addAttribute($this->request->post);
            $this->session->data['success'] = 'Success: You have added a new Attribute!';
            $this->response->redirect($this->link('attribute', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle('Admin - Edit Attribute');
        $this->load_model('attribute');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_attribute->editAttribute($this->request->get['attribute_id'], $this->request->post);
            $this->session->data['success'] = 'Success: You have modified Attribute!';
            $this->response->redirect($this->link('attribute', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $this->load_model('attribute');
        
        if (isset($this->request->post['attribute_id']) && $this->validateDelete()) {
            $this->model_attribute->deleteAttribute($this->request->post['attribute_id']);
            $this->session->data['success'] = 'Success: You have deleted Attribute!';
            $this->response->redirect($this->link('attribute', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->getList();
    }

    protected function getForm()
    {
        $data = $this->language->getAll();
        $data['text_form'] = !isset($this->request->get['attribute_id']) ? 'Add New Attribute' : 'Edit Attribute';

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

        if (isset($this->error['category_id'])) {
            $data['error_category_id'] = $this->error['category_id'];
        } else {
            $data['error_category_id'] = '';
        }

        $url = '';
        if (!isset($this->request->get['attribute_id'])) {
            $data['action'] = $this->link('attribute/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->link('attribute/edit', 'token=' . $this->session->data['token'] . '&attribute_id=' . $this->request->get['attribute_id'] . $url, 'SSL');
        }
        $data['cancel'] = $this->link('attribute', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['attribute_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $attribute_info = $this->model_attribute->getAttribute($this->request->get['attribute_id']);
        }

        $this->load_model('language');
        $data['languages'] = $this->model_language->getLanguages(['order' => 'DESC']);

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($attribute_info)) {
            $data['sort_order'] = $attribute_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($attribute_info)) {
            $data['status'] = $attribute_info['status'];
        } else {
            $data['status'] = 1;
        }

        if (isset($this->request->post['category_id'])) {
            if (is_array($this->request->post['category_id'])) {
                $data['category_id'] = $this->request->post['category_id'];
            } else {
                $data['category_id'] = explode(',', $this->request->post['category_id']);
            }
			} elseif (!empty($attribute_info)) {
				$data['category_id'] = is_array($attribute_info['category_id']) ?
				$attribute_info['category_id'] : explode(',', $attribute_info['category_id']);
			} else {
				$data['category_id'] = [];
		}

        if (isset($this->request->post['attribute_description'])) {
            $data['attribute_description'] = $this->request->post['attribute_description'];
        } elseif (isset($this->request->get['attribute_id'])) {
            $data['attribute_description'] = $this->model_attribute->getAttributeDescription($this->request->get['attribute_id']);
        } else {
            $data['attribute_description'] = array();
        }

        $data['categories'] = $this->model_attribute->getCategories();
        // echo '<pre>'; print_r($data['categories']); echo '</pre>'; exit;
        $this->data = $data;
        $this->template = 'modules/attribute/form.tpl';
        $this->zones = array('header', 'columnleft', 'footer');
        $this->response->setOutput($this->render());
    }

   protected function validateForm()
{
    if (!$this->user->hasPermission('modify', 'attribute')) {
        $this->error['warning'] = 'Warning: You do not have permission for modification!';
    }

    $data = $this->request->post;

    foreach ($data['attribute_description'] as $language_id => $value) {
        if (utf8_strlen(trim($value['title'])) < 1) {
            $this->error['title'][$language_id] = "Title field is required";
        }
		}

        if ((empty($data['category_id']))) {
			$this->error['category_id'] = "Category field is required";
		}

    if ($this->error && !isset($this->error['warning'])) {
        $this->error['warning'] = 'Warning: Please check the form carefully for errors!';
    }

    return !$this->error;
}


    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'attribute')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }
        return !$this->error;
    }

    public function ajaxattributestatus()
    {
        $json = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load_model('attribute');
            $attribute_id = $this->request->post['attribute_id'];
            $status = $this->request->post['status'];
            $stat = $this->model_attribute->updateAttributeStatus($attribute_id, $status);
            
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
