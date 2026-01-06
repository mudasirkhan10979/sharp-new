<?php
class ControllerNewsletters extends Controller
{
    private $error = array();

    public function index()
    {


        $this->document->setTitle("Admin - Subscriptions");

        $this->load_model('newsletters');

        $this->getList();
    }

    public function edit()
    {

        $this->document->setTitle("Admin - Subscriptions");
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
        $this->document->setTitle("Admin - Subscriptions");
        $this->load_model('newsletters');
	    if($this->validateDelete() && $this->request->post['newsletter_id']){
        $this->model_newsletters->deleteNewsletter($this->request->post['newsletter_id']);
        $this->session->data['success'] = $this->language->get('Success: You have deleted a Newsletter!');
        $this->response->redirect($this->link('newsletters', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->getList();
      }

    private function getList()
    {
        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => 'newsletters Listing',
            'href' => $this->link('newsletters', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
        $data['add'] = $this->link('newsletters/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->link('newsletters/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['newsletters'] = array();
        $filter_data = array(
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $results = $this->model_newsletters->getNewsletters();

        foreach ($results as $result) {
            $data['newsletters'][] = array(
                'newsletter_id'  => $result['id'], 
                'name'        => $result['name'],
                'email'       => $result['email'], 
                'edit'        => $this->link('newsletters/edit', 'token=' . $this->session->data['token'] . '&newsletter_id=' . $result['id'] . $url, 'SSL'),
                'delete'      => $this->link('newsletters/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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


        $enquiryTotal = $this->model_newsletters->getTotalNewsletters();
        $pagination = new Pagination();
        $pagination->total = $enquiryTotal;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');

        $pagination->url = HTTP_HOST . '?controller=newsletters/&token=' . $this->session->data['token'] . $url . '&page={page}';

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($enquiryTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($enquiryTotal - $this->config->get('config_limit_admin'))) ? $enquiryTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $enquiryTotal, ceil($enquiryTotal / $this->config->get('config_limit_admin')));

        $data['token'] = $this->session->data['token'];
        $this->data = $data;

        $this->template = 'modules/newsletters/list.tpl';

        $this->zones = array(
            'header',
            'columnleft',
            'footer'
        );

        $this->response->setOutput($this->render());
    }

    private function getDetail()
    {
        $data = $this->language->getAll();
        $data['text_form'] = !isset($this->request->get['newsletter_id']) ? 'Enquiry Details' : '';

        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => "newsletters",
            'href' => $this->link('newsletters', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $data['cancel'] = $this->link('newsletters', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->load_model('newsletters');
        if (isset($this->request->get['newsletter_id'])) {
            $newsletters = $this->model_newsletters->getEnquiry($this->request->get['newsletter_id']);
        } else {
            $newsletters = array();
        }
        $data['enquiry'] =  $newsletters;
        $this->data = $data;
        $this->template = 'modules/newsletters/detail.tpl';
        $this->zones = array(
            'header',
            'columnleft',
            'footer'
        );
        $this->response->setOutput($this->render());
    }


    protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'newsletters')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		

		return !$this->error;
	}
}
