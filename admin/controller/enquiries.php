<?php
class ControllerEnquiries extends Controller
{
    private $error = array();

    public function index()
    {
        $this->document->setTitle("Admin - Enquiries");
        $this->load_model('enquiries');
        $this->getList();
    }

    public function edit()
    {
        $this->document->setTitle("Admin - Enquiries");
        $url = "";
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $this->getDetail();
    }
    public function delete()
    {
        $data = $this->language->getAll();
        $this->document->setTitle("Admin - Enquiries");
		$this->load_model('enquiries');
		if ($this->request->post['enquiry_id'] && $this->validateDelete()) {
            $this->model_enquiries->deleteEnquiry($this->request->post['enquiry_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Enquiry!');
			$this->response->redirect($this->link('enquiries', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
    }
    private function getList()
    {
        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => 'Enquiries Listing',
            'href' => $this->link('enquiries', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        $data['add'] = $this->link('enquiries/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->link('enquiries/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['enquiries'] = array();
        $filter_data = array(
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $results = $this->model_enquiries->getEnquiries();

        foreach ($results as $result) {
            // Extract last part after the final "/"
            $enquiry_from = '';
            if (!empty($result['enquiry_from'])) {
                $path = parse_url($result['enquiry_from'], PHP_URL_PATH);
                $enquiry_from = basename(rtrim($path, '/')); // Handles trailing slashes too
            }
            $data['enquiries'][] = array(
                'enquiry_id'     => $result['enquiry_id'],
                'name'     => $result['name'],
                'subject'      => $result['subject'],
                'phone'          => $result['phone'],
                'email'          => $result['email'],
                'message'        => $result['message'], 
                'date'           => $result['enquiry_date'],
                'enquiry_from'   => $enquiry_from, // Only "contact-us"
                'edit'           => $this->link('enquiries/edit', 'token=' . $this->session->data['token'] . '&enquiry_id=' . $result['enquiry_id'] . $url, 'SSL'),
                'delete'         => $this->link('enquiries/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $url = '';
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        if ($this->user->getGroupId() != '1') {
            $data['viewer'] = true;
            $data['button_edit_icon'] = 'fa fa-eye';
        } else {
            $data['viewer'] = false;
            $data['button_edit_icon'] = 'fa fa-pencil';
        }


        $enquiryTotal = $this->model_enquiries->getTotalEnquiries();
        $pagination = new Pagination();
        $pagination->total = $enquiryTotal;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');

        $pagination->url = HTTP_HOST . '?controller=enquiries/&token=' . $this->session->data['token'] . $url . '&page={page}';

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($enquiryTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($enquiryTotal - $this->config->get('config_limit_admin'))) ? $enquiryTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $enquiryTotal, ceil($enquiryTotal / $this->config->get('config_limit_admin')));

        $data['token'] = $this->session->data['token'];
        $this->data = $data;

        $this->template = 'modules/enquiries/list.tpl';

        $this->zones = array(
            'header',
            'columnleft',
            'footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'mediacenter')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}

    private function getDetail()
    {
        $data = $this->language->getAll();
        $data['text_form'] = !isset($this->request->get['enquiry_id']) ? 'Enquiry Details' : '';

        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => "Enquiries",
            'href' => $this->link('enquiries', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $data['cancel'] = $this->link('enquiries', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->load_model('enquiries');
        if (isset($this->request->get['enquiry_id'])) {
            $enquiries = $this->model_enquiries->getEnquiry($this->request->get['enquiry_id']);
        } else {
            $enquiries = array();
        }
        $data['enquiry'] =  $enquiries;
        $this->data = $data;
        $this->template = 'modules/enquiries/detail.tpl';
        $this->zones = array(
            'header',
            'columnleft',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
}
