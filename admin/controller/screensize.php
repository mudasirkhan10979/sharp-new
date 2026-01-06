<?php
class ControllerScreenSize extends Controller
{
    private $error = array();
    public function index()
    {
        $data = $this->language->getAll();
        $this->document->setTitle('Admin - Screen Sizes');
        $this->load_model('screensize');
        $this->getList();
    }

    protected function getList()
    {
        $data = $this->language->getAll();
        $data['heading_title'] = 'Screen Sizes';
        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => 'ScreenSize',
            'href' => $this->link('screensize', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
        $data['add']    = $this->link('screensize/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->link('screensize/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['screensizes'] = array();
        $filter_data   = array(
            'order' => $order,
        );
        $results       = $this->model_screensize->getScreenSizes($this->config->get('config_language_id'), $filter_data);
        foreach ($results as $result) {
            $data['screensizes'][] = array(
                'screensize_id' => $result['id'],
                'title'    => $result['title'],
                'status'    => $result['status'],
                'edit'       => $this->link('screensize/edit', 'token=' . $this->session->data['token'] . '&screensize_id=' . $result['id'] . $url, 'SSL'),
                'delete'     => $this->link('screensize/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array) $this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }
        // $data['main_slider'] = $results;
        $data['groupby'] = 1;
        $url             = '';
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $data['sort_status']     = $this->link('screensize', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
        $data['sort_date_added'] = $this->link('screensize', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
        $data['sort_title']   = $this->link('screensize', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
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
        $data['ajaxupdatescreensizestatus'] = $this->link('screensize/ajaxupdatescreensizestatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $bannerTotal        = $this->model_screensize->getTotalScreenSizes();
        $pagination         = new Pagination();
        $pagination->total  = $bannerTotal;
        $pagination->page   = $page;
        $pagination->limit  = $this->config->get('config_limit_admin');
        $pagination->url    = HTTP_HOST . '?controller=screensize&token=' . $this->session->data['token'] . $url . '&page={page}';
        $data['pagination'] = $pagination->render();
        $data['results']    = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
        $data['ajaxUrl']    = HTTP_HOST . '?controller=screensize&token=' . $this->session->data['token'] . '&action=ajaxupdatescreensizestatus';
        $data['token']      = $this->session->data['token'];
        $this->data         = $data;
        $this->template     = 'modules/screensize/list.tpl';
        $this->zones        = array(
            'header',
            'columnleft',
            'footer'
        );
        $this->response->setOutput($this->render());
        // echo "<script>var ajaxUrl = '" . $data['ajaxupdatescreensizestatus'] . "';</script>";
        // echo "<script>alert(ajaxUrl);</script>";
        // exit;
    }

    public function add()
    {
        $this->document->setTitle('Admin - Add ScreenSize');

        $this->load_model('screensize');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_screensize->addScreenSize($this->request->post);

            $this->session->data['success'] = $this->language->get('Success: You have added a new screensize!');

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
            $this->response->redirect($this->link('screensize', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getForm();
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'screensize')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }
        $data = $this->request->post;
        foreach ($data['screensize_description'] as $language_id => $value) {
            if ((utf8_strlen(trim($value['title'])) < 1)) {
                $this->error['title'][$language_id] = "Title field is missing";
            }
            if ((utf8_strlen(trim($value['description'])) < 1)) {
                $this->error['description'][$language_id] = "Description field is missing";
            }
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
        $this->document->setTitle('Admin - Edit ScreenSize');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            // echo '<pre>'; print_r($this->request->post); '</pre>'; exit;
            $this->load_model('screensize');
            $this->model_screensize->editScreenSize($this->request->get['screensize_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('Success: You have modified screensize!');
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
            $this->response->redirect($this->link('screensize', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $this->load_model('screensize');
        if ($this->validateDelete() && isset($this->request->post['screensize_id'])) {
            $this->model_screensize->deleteScreenSize($this->request->post['screensize_id']);
            $this->session->data['success'] = $this->language->get('Success: You have deleted a screensize!');

            $this->response->redirect($this->link('screensize', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->getList();
    }

    protected function getForm()
    {
        $data                       = $this->language->getAll();
        $data['text_form']          = ! isset($this->request->get['screensize_id']) ? 'Add New ScreenSize' : 'Edit ScreenSize';
        $data['img_feild_required'] = ! isset($this->request->get['screensize_id']) ? "required" : "";
        $data['is_edit']            = ! isset($this->request->get['screensize_id']) ? "no" : "yes";
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
        $url = '';

        if (! isset($this->request->get['screensize_id'])) {
            $data['action'] = $this->link('screensize/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->link('screensize/edit', 'token=' . $this->session->data['token'] . '&screensize_id=' . $this->request->get['screensize_id'] . $url, 'SSL');
        }
        $data['cancel'] = $this->link('screensize', 'token=' . $this->session->data['token'] . $url, 'SSL');
        if (isset($this->request->get['screensize_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->load_model('screensize');
            $screensize_info = $this->model_screensize->getScreenSize($this->request->get['screensize_id']);
        }
        $data['screensize_info'] = $screensize_info;
        $db_filter  = [
            'order' => 'DESC'
        ];
        $this->load_model('language');
        $data['languages'] = $this->model_language->getLanguages($db_filter);
        if (isset($this->request->post['screensize_description'])) {
            $data['screensize_description'] = $this->request->post['screensize_description'];
        } elseif (isset($this->request->get['screensize_id'])) {
            $data['screensize_description'] = $this->model_screensize->getScreenSizeDescriptions($this->request->get['screensize_id']);
        } else {
            $data['screensize_description'] = array();
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (! empty($screensize_info)) {
            $data['sort_order'] = $screensize_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (! empty($screensize_info)) {
            $data['status'] = $screensize_info['status'];
        } else {
            $data['status'] = true;
        }
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;
        $this->data     = $data;
        $this->template = 'modules/screensize/form.tpl';
        $this->zones    = array(
            'header',
            'columnleft',
            'footer'
        );
        $this->response->setOutput($this->render());
    }

    public function ajaxupdatescreensizestatus()
    {
        $json = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load_model('screensize');
            $screensizeId = $this->request->post['screensize_id'];
            $status = $this->request->post['status'];
            $this->model_screensize->updateScreenSizeStatus($screensizeId, $status);
            $json['success'] = true;
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    protected function validateDelete()
    {

        if (!$this->user->hasPermission('modify', 'screensize')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }


        return !$this->error;
    }
}
